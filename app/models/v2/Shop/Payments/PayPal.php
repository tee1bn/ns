<?php


namespace v2\Shop\Payments;

use PayPal\Rest\ApiContext ;
use PayPal\Auth\OAuthTokenCredential;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use \PayPal\Api\PaymentExecution;



use v2\Shop\Contracts\OrderInterface;
use Exception, SiteSettings, Config, MIS, Redirect;
/**
 * 
 */
class PayPal  
{
	private $name = 'paypal';
	private $mode;
	
	function __construct()
	{

		$settings = SiteSettings::find_criteria('paypal_keys')->settingsArray;

		$this->mode = $settings['mode']['mode'];

		$this->api_keys =  $settings[$this->mode];

		$urls =  [
			'test' => [
				'base_url'=> "https://api.sandbox.paypal.com",
			],
			'live' => [
				'base_url'=> "https://api.paypal.com",			
			],
		];


		$this->urls = $urls[$this->mode];
		
		$this->apiContext = new ApiContext(
						  new OAuthTokenCredential(
						    $this->api_keys['public_key'],
						    $this->api_keys['secret_key']
						  )
						);
		



		$this->apiContext->setConfig(
		      array(
		      	'mode' => ['test'=>'sandbox', 'live'=>'live'][$this->mode],
		        'log.LogEnabled' => true,
		        'log.FileName' => 'PayPal.log',
		        'log.LogLevel' => 'DEBUG'
		      )
		);

	}



	public function goToGateway()
	{
		$payment_details = json_decode($this->order->payment_details , true);
		Redirect::to($payment_details['approval_url']);	
	}


	public function paymentStatus()
	{
		return true ;
	}



	public function reVerifyPayment()
	{
		$response = 		$this->paymentStatus();
		if ($response['STATUS'] == "TXN_SUCCESS") {

			if (($this->amountPayable() == $response['TXNAMOUNT'])) {

				if (!$this->order->is_paid()) {
					$this->order->mark_paid();

				}else{

					\Session::putFlash('success', "Payment successful");
				}

				return $response;
			}

		}
		
		\Session::putFlash('danger', "Payment not successful");
	}



	public function verifyPayment()
	{

				if (   (!isset($_GET['paymentId'] , $_GET['PayerID']) ) ) {
					return;
				}



				$payment_id = $_GET['paymentId'];
				$payer_id =   $_GET['PayerID'];

				$payment = Payment::get($payment_id, $this->apiContext);

				$execute = new PaymentExecution();
				$execute->setPayerId($payer_id);

					
					try {
						
						$result =  $payment->execute($execute , $this->apiContext);

						$confirmation = ['status'=>true];
                     	return compact('result','confirmation');

					} catch (Exception $e) {
						$data = json_decode($e->getData());
						print_r($data);
						die($e);
					}

	}


	public function setOrder(OrderInterface $order)
	{
		$this->order = $order;
		return $this;

	}


	public function amountPayable()
	{
		$amount =  $this->order->total_tax_inclusive()['price_inclusive_of_tax'];

		return $amount;
	}


	public function initializePayment()
	{
		$payment_method = $this->name;
		$order_ref = $this->order->generateOrderID();
		$price_breakdown = $this->order->total_tax_inclusive();
		$user = $this->order->user;
		$domain = Config::domain();




		$callback_param = http_build_query([
			'item_purchased'=> $this->order->name_in_shop,
			'order_unique_id'=> $this->order->id,
		]);


		$callback_url = "{$domain}/shop/callback?$callback_param";

		// Create new payer and method
		$payer = new Payer();
		$payer->setPaymentMethod("paypal");


		$item1 = new Item();
		$item1->setName("Payment for Order#$order_ref")
		    ->setCurrency('EUR')
		    ->setQuantity(1)
		    ->setSku("1") // Similar to `item_number` in Classic API
		    ->setPrice($price_breakdown['price_exclusive_of_tax']);


		$itemList = new ItemList();
		$itemList->setItems(array($item1));


		$details = new Details();
		$details->setTax($price_breakdown['total_sum_tax'])
		    ->setSubtotal($price_breakdown['price_exclusive_of_tax']);


		    $amount = new Amount();
		    $amount->setCurrency("EUR")
		        ->setTotal($price_breakdown['price_inclusive_of_tax'])
		        ->setDetails($details);


		        $transaction = new Transaction();
		        $transaction->setAmount($amount)
		            ->setItemList($itemList)
		            ->setDescription("Payment for Order#$order_ref")
		            ->setInvoiceNumber($order_ref);

		            $redirectUrls = new RedirectUrls();
		            $redirectUrls->setReturnUrl($callback_url)
		                ->setCancelUrl($callback_url);


		                $payment = new Payment();
		                $payment->setIntent("sale")
		                    ->setPayer($payer)
		                    ->setRedirectUrls($redirectUrls)
		                    ->setTransactions(array($transaction));



		// Create payment with valid API context
		try {
		  $payment->create($this->apiContext);

		  // Get PayPal redirect URL and redirect the customer
		  $approvalUrl = $payment->getApprovalLink(); 

		  $payment_details = [
		  				'gateway' => $this->name,
		  				'ref' => $order_ref,
		  				'order_unique_id' => $this->order->id,
		  				"approval_url" 	 =>  $approvalUrl,
		  				"amount" 	 =>  $this->amountPayable(),
		  			];

		  // Redirect the customer to $approvalUrl
		} catch (PayPal\Exception\PayPalConnectionException $ex) {
		  echo $ex->getCode();
		  echo $ex->getData();
		  die($ex);
		} catch (Exception $ex) {
		  die($ex);
		}


		$this->order->setPayment($payment_method , $payment_details);

		return $this;

	}

	public function attemptPayment()
	{


		if ($this->order->is_paid()) {
			throw new Exception("This Order has been paid with {$this->order->payment_method}", 1);
		}


		if ($this->order->payment_method != $this->name) {
			throw new Exception("This Order is not set to use {$this->name} payment menthod", 1);
		}

		$payment_details = json_decode($this->order->payment_details, true);
	
		$this->payment_details;

		return $this;
	}



}
