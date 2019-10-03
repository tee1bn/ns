<?php

use Illuminate\Database\Capsule\Manager as DB;
use  v2\Shop\Shop;
 

/**
 * this class is the default controller of our application,
 * 
*/
class PayPalController extends controller
{

	public function __construct(){

	}



	public function make_subscription_order_payment($order_id)
	{
		$order = SubscriptionOrder::where('paid_at', null)->where('id', $order_id)->where('payment_method', 'paytm')->first();
		if ($order == null) {
			Session::putFlash("info","Invalid Request");
			return;
		}


		$shop = new Shop();
		$payment_details =	$shop
							->setOrderType('ebook') //what is being bought
							->setOrder($order)
							->setPaymentMethod('paytm')
							->initializePayment()
							->attemptPayment()
							;

		$payment_details = json_decode($order->payment_details , true);
		$url = $payment_details['url'];
		$paytmParams = $payment_details['paytm_param'];
		$checksum = $payment_details['checksum'];

		$this->view('paytm/paytm', compact('paytmParams', 'url', 'checksum'));
	}	




	public function make_order_payment($order_id)
	{
		$order = Orders::where('paid_at', null)->where('id', $order_id)->first();

		$cart['$items'] = $order->order_detail();
		$safety =  Orders::confirm_order_is_safe_for_processing($cart);
		if ($safety == false) {
			Redirect::back();
			return;
		}

		if ($order == null) {
			Session::putFlash("info","Invalid Request");
			return;
		}

		$shop = new Shop();
		$payment_details =	$shop
							->setOrderType('ebook') //what is being bought
							->setOrder($order)
							->setPaymentMethod('paytm')
							->initializePayment()
							->attemptPayment()
							;



		$customer = $order->user;
		$payment_details = json_decode($order->payment_details , true);
		$url = $payment_details['url'];
		$paytmParams = $payment_details['paytm_param'];
		$checksum = $payment_details['checksum'];

		$this->view('paytm/paytm', compact('paytmParams', 'url', 'checksum'));
	}	


	public function callback()
	{

			$shop = new Shop();
			$item_purchased = $shop->available_type_of_orders[$_REQUEST['item_purchased']];
		 	$full_class_name = $item_purchased['namespace'].'\\'.$item_purchased['class'];
		 	$order_id = $_REQUEST['order_unique_id'];
		 	$order = $full_class_name::where('id' ,$order_id)->where('paid_at', null)->first();

			$shop->setOrder($order)->verifyPayment();
                
             
			Redirect::to('user/packages');
	}

	public function re_confirm_order($order_id)
	{
			$shop = new Shop();
			$item_purchased = $shop->available_type_of_orders['ebook'];
		 	$full_class_name = $item_purchased['namespace'].'\\'.$item_purchased['class'];
		 	$order = $full_class_name::where('id' ,$order_id)->where('paid_at', null)->first();

			$shop->setOrder($order)->reVerifyPayment();

		Redirect::back();
	}


	public function re_confirm_sub_order($order_id)
	{

			$shop = new Shop();
			$item_purchased = $shop->available_type_of_orders['scheme'];
		 	$full_class_name = $item_purchased['namespace'].'\\'.$item_purchased['class'];
		 	$order = $full_class_name::where('id' ,$order_id)->where('paid_at', null)->first();

			$shop->setOrder($order)->reVerifyPayment();

		Redirect::back();
		

	}





}























?>