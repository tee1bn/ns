<?php


use \PayPal\Api\Payment;
use \PayPal\Api\PaymentExecution;
use Razorpay\Api\Api;


use Illuminate\Database\Eloquent\Model as Eloquent;

class Orders extends Eloquent 
{
	
		protected $fillable = [
								'buyer_name',
								'user_id',
								'percent_off',
								'amount_payable',
								'razorpay_order_id',
								'razorpay_response',
								'email',
								'phone',
								'address',
								'additional_note',
								'buyer_order',
								'billing_details',
								'shipping_details',
								'status',
								'billing_firstname',
								'billing_lastname',
								'billing_company',
								'billing_country',
								'billing_street_address',
								'billing_city',
								'billing_state',
								'billing_phone',
								'billing_email',
								'billing_apartment',
								
								'shipping_firstname',
								'shipping_lastname',
								'shipping_company',
								'shipping_country',
								'shipping_street_address',
								'shipping_city',
								'shipping_state',
								'shipping_phone',
								'shipping_email',
								'shipping_apartment',

								'shipping_fee',
								'paid_at',

								];
	
	protected $table = 'orders';




	public function execute_paypal_payment()
	{

		if ((!isset($_GET['paymentId'] , $_GET['PayerID']) ) ) {
			die();
		}



		$apiContext = $this->paypal_api_context() ;


		$payment_id = $_GET['paymentId'] ;
		$payer_id =   $_GET['PayerID'];



		$payment = Payment::get($payment_id, $apiContext);


		$execute = new PaymentExecution();
		$execute->setPayerId($payer_id);

			
			try {
					
					$result =  $payment->execute($execute , $apiContext);
					// $_SESSION['paypal'] = $result;
					$this->mark_paid();

					Session::putFlash("success", "Payment completed successfully.");

			} catch (Exception $e) {
				echo "string";
				$data = json_decode($e->getData());
				print_r($data);
					Session::putFlash("danger", "Payment could not completed successfully.");
				die($e);
			}

}



	public function razorpay_api()
	{


		

		$settings = 		 SiteSettings::site_settings();
		$api_key  =   $settings['razorpay_public_key'];
		$api_secret  =   $settings['razorpay_secret_key'];
		$api = new Api($api_key, $api_secret);




		return $api;

	}

	

	private function paypal_api_context()
	{


		$site_settings = SiteSettings::site_settings();
		$paypal_public_key = $site_settings['paypal_public_key'];
		$paypal_secret_key = $site_settings['paypal_secret_key'];



		$apiContext = new \PayPal\Rest\ApiContext(
				    		new \PayPal\Auth\OAuthTokenCredential(
        							$paypal_public_key,     // ClientID
        							$paypal_secret_key      // ClientSecret
    					)
					);

		return $apiContext;

	}

	

	public function make_payment()
	{

		$apiContext = $this->paypal_api_context();
		
		echo "<pre>";
		
        print_r($apiContext);
    

		// print_r($apiContext);



		// Step 2.1 : Between Step 2 and Step 3
		$apiContext->setConfig(
		      array(
		        'log.LogEnabled' => true,
		        'log.FileName' => 'PayPal.log',
		        'log.LogLevel' => 'DEBUG'
		      )
		);



		// 3. Lets try to create a Payment
		// https://developer.paypal.com/docs/api/payments/#payment_create


		$payer = new \PayPal\Api\Payer();
		$payer->setPaymentMethod('paypal');
		  
		$shop_name =  Config::project_name();
		$currency_code  = 'USD';



		// print_r(($this->order_detail()[0]));


/*
			foreach ($this->order_detail() as $key => $order_item) {

				$item = new \PayPal\Api\Item();
				$item->setName(ucwords($order_item['name']))
					 ->setCurrency($currency_code)
					 ->setQuantity($order_item['qty'])
					 ->setPrice($order_item['price']);

				$list[] = $item;
			}*/
			
			    
		 $discount =	$this->overalltotal - $this->AmountPayable;
				$item = new \PayPal\Api\Item();
				$item->setName("Product Order")
					 ->setCurrency($currency_code)
					 ->setQuantity(1)
					 ->setPrice($this->AmountPayable);

				$list[] = $item;





		$itemList =  new \PayPal\Api\ItemList();
		$itemList->setItems($list);



		$details =  new \PayPal\Api\Details();
		$details->setSubtotal($this->AmountPayable);


		$amount = new \PayPal\Api\Amount();
		$amount->setTotal($this->AmountPayable)
				->setCurrency($currency_code);




		$transaction = new \PayPal\Api\Transaction();
		$transaction->setAmount($amount)
					->setItemList($itemList)
					->setDescription("Payment for $shop_name Order #{$this->id}")
					->setInvoiceNumber($this->id);





		$success_url = Config::domain()."/shop/paypal_payment_received/$this->id";
		$cancel_url = Config::domain()."/shop/view_cart";

		$redirectUrls = new \PayPal\Api\RedirectUrls();
		$redirectUrls->setReturnUrl($success_url)
		    ->setCancelUrl($cancel_url);



		$payment = new \PayPal\Api\Payment();
		$payment->setIntent('sale')
		    ->setPayer($payer)
		    ->setTransactions(array($transaction))
		    ->setRedirectUrls($redirectUrls);

    

		// 4. Make a Create Call and print the values
		try {
		    $payment->create($apiContext);
		   
		    // echo $payment;
		    // echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";


		   echo $approval_url = $payment->getApprovalLink();
		    
		    header("Location: $approval_url");
		}
		catch (\PayPal\Exception\PayPalConnectionException $ex) {
		    // This will print the detailed information on the exception.
		    //REALLY HELPFUL FOR DEBUGGING
		    echo $ex->getData();

		    Session::putFlash("danger", "We could not initiate your payment using Paypal ");

		}

	}





	public function user()
	{

		return $this->belongsTo('User', 'user_id');
	}

	public function mark_paid()
	{
		$this->update(['paid_at'=> date("Y-m-d H:i:s")]);
		$this->give_upline_sale_commission();
	}




	private function give_upline_sale_commission()
	{

		$settings= SiteSettings::site_settings();

		$user 	 = $this->user;
		$upline  = User::where('mlm_id' , $user->referred_by)->first();
		$amount  = $settings['product_sales_commission'] * 0.01 * $this->amount_payable;
		$comment = "#{$this->id} Product Commission";

		$month_index = date('m');


		$credit  = LevelIncomeReport::credit_user($upline['id'], $amount, $comment , $user->id, $this->id);
		return $credit;
	}





	public function getAmountPayableAttribute()
	{
		 $amount_payable = $this->overalltotal - (0.01 * $this->percent_off * $this->overalltotal);

		return $amount_payable ;
	}
	

	public function getshippingfeeAttribute($value)
	{

		return json_decode($value, true) ;
	}


	public function getpaymentAttribute()
	{
		if ($this->paid_at) {

			return '<span class="label label-success">Paid</span>';
		}

			return '<span class="label label-danger">Unpaid</span>';

	}

	public function getshippingcostAttribute()
	{

		return (int) $this->shipping_fee['price'] ;
	}



	public function getdateAttribute()
	{
		return date("M d, Y", strtotime($this->created_at)) ;
	}




	public function getoveralltotalAttribute()
	{
		return $this->total_price() + $this->shippingcost;
	}




	public function getSchemeOffAttribute()
	{
		return ($this->percent_off *  $this->overalltotal * 0.01) ;
	}

	public function has_item($item_id)
	{

		foreach ($this->order_detail() as $key => $item) {
			if ($item['id'] ==  $item_id) {
				return true;
			}
		}


		return false;
	}

	public function order_detail()
	{
		return (json_decode($this->buyer_order,true));
	}

	public function total_item()
	{


		$orders =  $this->order_detail();
		
		return count($orders);
	}

	public function total_qty()
	{

		$orders =  $this->order_detail();
		foreach ($orders as $order) {

			$total_qty[] = $order['qty'];

		}

		return array_sum($total_qty);
	}



	public function total_price()
	{

		$orders =  $this->order_detail();
		foreach ($orders as $order) {

			$total_price[] = $order['price'] *$order['qty'];

		}

		$total =  array_sum($total_price) ;

		return $total;
	}


	public function paystack_total()
	{
		return (100 * $this->overalltotal);
	}

	public function razorpay_amount_payable()
	{
		return  intval(100 * round($this->amount_payable));
	}

	public function is_paid()
	{

		return (bool) ($this->paid_at != null);
	}


	public function delete_order(array $ids)
	{
		foreach ($ids as $key => $id) {
			$order = self::find($id);
				if ($order != null) {

					try{
					 $order->delete();
					}catch(Exeception $e){

					}
				}
			}
			return true;
	}



}


















?>