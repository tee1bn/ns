<?php

namespace v2\Shop\Payments;
use v2\Shop\Contracts\OrderInterface;
use Exception, SiteSettings, Config, MIS;
/**
 * 
 */
class CoinPay 
{
	private $name = 'coinpay';
	private $mode;
	
	function __construct()
	{

		$settings = SiteSettings::coinpay_keys();

		$this->mode = $settings['mode']['mode'];

		$this->api_keys =  $settings[$this->mode];

		$urls =  [
			'test' => [],
			'live' => [
				'create_payment_page'=> "https://p.coinwaypay.com/w/register",
			],
		];

		$this->urls = $urls[$this->mode];
	}


	public function verifyPayment()
	{
				
		/*
			$confirmation = ['status'=>true];
			return compact('result','confirmation');

		*/
		
					$payment_details = json_decode($this->order->payment_details, true);
					$reference = $payment_details['ref'];


					  Session::putFlash("danger", "we could not complete your payment.");

			

	}


	public function setOrder( $order)
	{
		$this->order = $order;
		return $this;

	}


	public function amountPayable()
	{
		$amount =  $this->order->total_price();

		return $amount;
	}


	public function initializePayment()
	{

		$payment_method = $this->name;

		$order_ref = $this->order->generateOrderID();

		$amount = $this->amountPayable();

		$user = $this->order->user;

		$domain = Config::domain();


		/*$param  = http_build_query([
			'order_type'=> '' 
		]);*/



		$sucess_url = "$domain/shop/verify_payment";
		$failure_url = "$domain/shop/verify_payment";
		$cancel_url = "$domain/shop/verify_payment";

		

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


/*		"Content-Type" => " application/json",
		   "Authorization" => " Basic " . base64_encode('ae7a4f220ea847ada4d19566b76d26b2' . ':' . '2927618294cb4df78acfed3dac7d7e218ea7191c4e8945158f31d0c85838b922'),
		   "Accept" => " application/json",
*/

		$headers = [

			

					"Content-Type"=>" application/json",
					"Authorization"=>" Basic $formatted_authorization",
					"Accept"=>" application/json",
			];




			$client = new \GuzzleHttp\Client();
			$options = [
			    'json' => $payment_details,
			    'headers' => $headers,
			   ]; 
			$response = $client->post("https://p.coinwaypay.com/w/register", $options);

			print_r($response->getBody());


		print_r($header);

		print_r($payment_details);

		$url =  $this->urls['create_payment_page'];

		$response = MIS::make_post($url, $payment_details, $header );

		print_r($response);
		// return $payment_details;

	}



}
