<?php

namespace v2\Shop;
use Exception, SiteSettings;
/**
 * 
 */
class Shop 
{
	
	public $available_payment_method;
	public $available_orders;
	private $payment_method;
	private $order;


	function __construct($argument = null)
	{
		$this->setup_available_payment_method();
		$this->setup_available_orders();
	}



	public function __get($property_name)
	{
		return $this->$property_name;
	}
	
	public function get_available_payment_methods()
	{
		$available = array_filter($this->available_payment_method,  function($gateway){

			return $gateway['available'] == true;
		});

		return $available;
	}


	private function setup_available_payment_method()
	{

		$payments_settings = SiteSettings::payment_gateway_settings()->keyBy('criteria');

		$this->available_payment_method = [

				'paypal' => [
								'name' => 'PayPal',
								'class' => 'PayPal',
								'namespace' => "v2\Shop\Payments",
								'available' => $payments_settings['paypal_keys']->settingsArray['mode']['available']
							],
				'coinpay' => [
								'name' => 'CoinPay',
								'class' => 'CoinPay',
								'namespace' => "v2\Shop\Payments",
								'available' => $payments_settings['coinpay_keys']->settingsArray['mode']['available']
							],

		];

	}

	private function setup_available_orders()
	{

		$this->available_type_of_orders = [

				'advert_papers' => [
								'name' => 'Advert Papers',
								'class' => 'Orders',
								'namespace' => "",
								'available' => true
							],

				'packages' => [
								'name' => 'Packages',
								'class' => 'SubscriptionOrder',
								'namespace' => "",
								'available' => true
							],
		];

	}



	public static function empty_cart_in_session()
	{
		unset($_SESSION['cart']);
		unset($_SESSION['shop_checkout_id'] );
	}




	public function verifyPayment()
	{	
		$this->setPaymentMethod($this->order->payment_method) ;
		$verification =  ($this->payment_method->verifyPayment($this->order));

		//payment confirmed
		if ($verification['confirmation']['status'] == 1) {
			$this->order->mark_paid();
			self::empty_cart_in_session();
			//clear session 
		}

		return $this;
	}





	public function reVerifyPayment()
	{	

		$this->setPaymentMethod($this->order->payment_method) ;
		$verification =  ($this->payment_method->reVerifyPayment($this->order));

		//payment confirmed
		if ($verification['confirmation']['status'] == 1) {
			$this->order->mark_paid();
			self::empty_cart_in_session();
			//clear session 
		}

		return $this;
	}


	public function setOrder($order)
	{
		$this->order = $order;
		return $this;
	}



	public function initializePayment()
	{

		$this->payment_method->initializePayment($this->order);

		return $this;
	}

	public function setPaymentMethod($payment_method)
	{

		$method = $this->available_payment_method[$payment_method];

		if ($method['available'] != true) {
			throw new Exception("{$method['name']} is not available", 1);
		}


		$full_class_name = $method['namespace'].'\\'.$method['class'];

		$this->payment_method = new  $full_class_name;
		$this->payment_method->setOrder($this->order);


		return $this;
	}

	public function setOrderType($order_type)
	{	

		$method = $this->available_type_of_orders[$order_type];

		 $full_class_name = $method['namespace'].'\\'.$method['class'];

		if ($method['available'] != true) {
			throw new Exception("{$method['name']} is not available", 1);
		}

		$this->order = new  $full_class_name;
		return $this;
	}


	public function receiveOrder(array $cart)
	{

		$this->order = 	$this->order->create_order($cart);

		return $this;
	}


	public function goToGateway()
	{
		$this->payment_method->goToGateway();

	}




	public function attemptPayment()
	{

		$this->payment_attempt_details = $this->payment_method->attemptPayment($this->order);

		return $this->payment_attempt_details;
	}

}