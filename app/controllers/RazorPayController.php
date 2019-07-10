<?php

use Razorpay\Api\Api;


/**



*/
class RazorPayController extends controller
{



	public function __construct(){
	}




	public function email(){

		$mailer = new Mailer();

		$mailer->sendMail('tee01bn@gmail.com', 'Subject', 'Testing emial');

	}


	public function index(){

		$api_key = 'rzp_test_ZS6LJ68zhbjxSb';
		$api_secret = 'tDyrcCJYyubGBp69eHDcKiyK';

		echo "<pre>";
		// $order_id = "order_CV9JPWSfV7L7Ib";

		$api = new Api($api_key, $api_secret);

		$order = $api->order->create(array(
		  'receipt' => '123',
		  'amount' => 100,
		  'currency' => 'INR',
		  'payment_capture' =>  '0'
		  )
		);


		 	$razorpay_order_id = $order->id;




		// $order = $api->order->fetch('order_CVb65dH5RQuV5u');

		// $payments = $api->order->fetch('order_CVb65dH5RQuV5u')->payments();

		/*
$link  = $api->invoice->create(array('type' => 'link', 'amount' => 500, 'description' => 'For XYZ purpose', 'customer' => array('email' => 'test@test.test')));
*/

print_r($link);

		/*$payment = $api->payment->fetch('pay_29QQoUBi66xm2f');
		$payment->capture(array('amount' => 500));

*/
		print_r($order);

	}









}























?>