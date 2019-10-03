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





use v2\Shop\Contracts\OrderInterface;
use Exception, SiteSettings, Config, MIS;
/**
 * 
 */
class PayPal 
{
	private $name = 'coinpay';
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
						    $this->api_keys['secret_key'],
						  )
						);

	}


	public function verifyPayment()
	{
				
		/*
			$confirmation = ['status'=>true];
			return compact('result','confirmation');

		*/
		
				
				echo "<pre>";
				$_SESSION['de']= 'pp';
					print_r($_SESSION);

					die();



					if (   (!isset($_GET['paymentId'] , $_GET['PayerID']) )  || ($booking_id==null)    ) {
						die();
					}




				$booking = bookings::find($booking_id);
						$hotel = $booking->hotel;

				$apiContext = $hotel->paypal_api_context() ;


				$payment_id = $_GET['paymentId'];
				$payer_id =   $_GET['PayerID'];

				$payment = Payment::get($payment_id, $apiContext);

				$execute = new PaymentExecution();
				$execute->setPayerId($payer_id);

					
					try {
						
						$result =  $payment->execute($execute , $apiContext);
						print_r($result);

						$_SESSION['paypal'] = $result;
						$booking->update([
											'payment_status' => 'paid',
											'status' => 1
										]);

					} catch (Exception $e) {
						$data = json_decode($e->getData());
						print_r($data);
						die($e);
					}


				$hotel_payment_configuration =  HotelsPaymentGatewaysConfiguration::where('hotel_id',$booking->hotel_id)
																							->where('payment_gateway_id', 1) //1 is for paypal
																							->first();


				echo $hotel_payment_configuration->success_url;
				ob_end_clean();

				echo "Payment made successfully!";

				// header("Location:{$hotel_payment_configuration->success_url} ");



	}


	public function setOrder( $order)
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
			'item_purchased'=> $this->order->name_in_shop
		]);


		$callback_url = "{$domain}/paypal/callback?$callback_param";

		// Create new payer and method
		$payer = new Payer();
		$payer->setPaymentMethod("paypal");


		$item1 = new Item();
		$item1->setName("Payment for Order#$order_ref")
		    ->setCurrency('INR')
		    ->setQuantity(1)
		    ->setSku("1") // Similar to `item_number` in Classic API
		    ->setPrice($price_breakdown['price_exclusive_of_tax']);


		$itemList = new ItemList();
		$itemList->setItems(array($item1));


		$details = new Details();
		$details->setTax($price_breakdown['total_sum_tax'])
		    ->setSubtotal($price_breakdown['price_exclusive_of_tax']);


		    $amount = new Amount();
		    $amount->setCurrency("INR")
		        ->setTotal($price_breakdown['price_exclusive_of_tax'])
		        ->setDetails($details);


		        $transaction = new Transaction();
		        $transaction->setAmount($amount)
		            ->setItemList($itemList)
		            ->setDescription("Payment for Order#$order_ref")
		            ->setInvoiceNumber($this->order->id);

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

		  print_r($approvalUrl);
		  // Redirect the customer to $approvalUrl
		} catch (PayPal\Exception\PayPalConnectionException $ex) {
		  echo $ex->getCode();
		  echo $ex->getData();
		  die($ex);
		} catch (Exception $ex) {
		  die($ex);
		}




		

		$payment_details = [
						/*'gateway' => $this->name,
						'ref' => $order_ref,
						'order_unique_id' => $this->order->id,*/


						"walletId" 	 =>  $this->api_keys['wallet_id'],
						"referenceId"=>  $order_ref,
						"amount" 	 =>  $amount,
						"currency" 	 =>  "EUR",
						"successRedirectUrl" =>  $sucess_url,
						"failRedirectUrl" =>  $failure_url,
						"cancelRedirectUrl" =>  $cancel_url
						


						];


		$this->order->setPayment($payment_method , $payment_details);

		return $this;

	}

	public function attemptPayment()
	{


		if ($this->order->is_paid()) {
			throw new Exception("This Order has been paid with {$this->order->payment_details}", 1);
		}


		if ($this->order->payment_method != $this->name) {
			throw new Exception("This Order is not set to use paystack payment menthod", 1);
		}


		$payment_details = json_decode($this->order->payment_details, true);
		$formatted_authorization = ("{$this->api_keys['username']}:{$this->api_keys['password']}");
		$formatted_authorization = base64_encode($formatted_authorization);

		$header = [
			"Accept-Encoding: gzip",
			"Content-Type: application/json",
			"Authorization: Basic $formatted_authorization"
		];


		print_r($header);

		print_r($payment_details);

		$url =  $this->urls['create_payment_page'];

		$response = MIS::make_post($url, $payment_details, $header );

		print_r($response);
		// return $payment_details;

	}



}
