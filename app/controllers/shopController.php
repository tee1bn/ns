<?php

use Illuminate\Database\Capsule\Manager as DB;
use Razorpay\Api\Api;
use  v2\Shop\Shop;


/**
 * this class is the default controller of our application,
 * 
*/
class shopController extends controller
{


	public function __construct(){		
		if (! $this->admin()) {
			$this->middleware('current_user')
				 ->mustbe_loggedin();
				 // ->must_have_verified_email();
		}		
	}


	public function re_confirm_order()
	{
			$shop = new Shop();
			$item_purchased = $shop->available_type_of_orders[$_REQUEST['item_purchased']];
		 	$full_class_name = $item_purchased['namespace'].'\\'.$item_purchased['class'];
		 	$order = $full_class_name::where('id' ,$_REQUEST['order_unique_id'])->where('paid_at', null)->first();

			$shop->setOrder($order)->reVerifyPayment();

		Redirect::back();
	}


	//for subscription payment
	public function execute_agreement()
	{
		
		$shop = new Shop();
		$item_purchased = $shop->available_type_of_orders[$_REQUEST['item_purchased']];
	 	$full_class_name = $item_purchased['namespace'].'\\'.$item_purchased['class'];		 	
	 	$order_id = $_REQUEST['order_unique_id'];
	 	$order = $full_class_name::where('id' ,$order_id)->where('paid_at', null)->first();


	 	echo "<pre>";
	 	print_r($_REQUEST);

		// $shop->setOrder($order)->verifyPayment();
		
	}


	public function callback()
	{

		$shop = new Shop();
		$item_purchased = $shop->available_type_of_orders[$_REQUEST['item_purchased']];
	 	$full_class_name = $item_purchased['namespace'].'\\'.$item_purchased['class'];		 	
	 	$order_id = $_REQUEST['order_unique_id'];
	 	$order = $full_class_name::where('id' ,$order_id)->where('paid_at', null)->first();

		$shop->setOrder($order)->verifyPayment();

		switch ($_REQUEST['item_purchased']) {
			case 'packages':
				Redirect::to('user/package');
				break;
			case 'scheme':
				Redirect::to("user/ebook/{$order->id}");
				break;
			
			default:
				# code...
				break;
		}
			
			Redirect::to('user/package');

	}


	public function checkout()
	{
		$shop = new Shop();

		$item_purchased = $shop->available_type_of_orders[$_REQUEST['item_purchased']];

		$full_class_name = $item_purchased['namespace'].'\\'.$item_purchased['class'];
		$order_id = $_REQUEST['order_unique_id'];
		$order = $full_class_name::where('id' ,$order_id)->where('user_id', $this->auth()->id)->where('paid_at', null)->first();


		$payment_type = $full_class_name::$payment_types[$_REQUEST['payment_method']];

		if ($order == null) {
			Session::putFlash("info","Invalid Request");
			return;
		}

		$shop = new Shop();
		$attempt =	$shop
							->setOrder($order)
							->setPaymentMethod($_REQUEST['payment_method'])
							->setPaymentType($payment_type)
							->initializePayment()
							->attemptPayment();
		if ($attempt ==false) {
			Redirect::back();
		}

		$shop->goToGateway();

	}

	


	public function capture_payment($razorpay_payment_id, $order_id)
	{

		$order = Orders::find($order_id);
		
		if ($order->razorpay_response == '') {

			$order->update(['razorpay_response' => $_POST['razorpay_response']]);
		}
		$api = Orders::razorpay_api();

		// $razorpay_response = json_decode($_POST['razorpay_response'], true);

		$razorpay_response = json_decode($order->razorpay_response, true);


		$razorpay_signature = $razorpay_response['razorpay_signature'];


		print_r($razorpay_response);
				
		// $payment = $api->payment->fetch("$razorpay_payment_id");
		// $response =  $payment->capture(array('amount' => $order->razorpay_amount_payable()));



		$settings = 		 SiteSettings::site_settings();
		$api_key  =   $settings['razorpay_public_key'];
		$api_secret  =   $settings['razorpay_secret_key'];



		$generated_signature = 
		hash_hmac('sha256', $razorpay_response['razorpay_order_id']. "|" .$razorpay_response['razorpay_payment_id'] , $api_secret);


		if ($generated_signature == $razorpay_signature) {

				DB::beginTransaction();

				try {
					
					$order->mark_paid();
					DB::commit();
					Session::putFlash("success","Payment received successfully");
				} catch (Exception $e) {
					
					DB::rollback();
				}



		}

	}






	public function capture_sub_payment($razorpay_payment_id, $order_id )
	{

		echo "<pre>";

		$order = SubscriptionOrder::find($order_id);
		
		if ($order->razorpay_response == '') {
			$order->update(['razorpay_response' => $_POST['razorpay_response']]);
		}

		$api = Orders::razorpay_api();

		// $razorpay_response = json_decode($_POST['razorpay_response'], true);

		$razorpay_response = json_decode($order->razorpay_response, true);


		$razorpay_signature = $razorpay_response['razorpay_signature'];


		print_r($razorpay_response);
				


		$settings = 		 SiteSettings::site_settings();
		$api_key  =   $settings['razorpay_public_key'];
		$api_secret  =   $settings['razorpay_secret_key'];



		$generated_signature = 
		hash_hmac('sha256', $razorpay_response['razorpay_order_id']. "|" .$razorpay_response['razorpay_payment_id'] , $api_secret);

	
		if ($generated_signature == $razorpay_signature) {

				DB::beginTransaction();

				try {
					
					$order->mark_as_paid();
					DB::commit();
					Session::putFlash("success","Payment received successfully");
				} catch (Exception $e) {
					
					DB::rollback();
				}



		}

	}





	public function fetch_order($order_id)
	{

		header("Access-Control-Allow-Origin:*");


		$order = Orders::find($order_id)->load('user');

		$settings = 		 SiteSettings::site_settings();
		$api_key  =   $settings['razorpay_public_key'];
		$api_secret  =   $settings['razorpay_secret_key'];




		$order->razorpay_public_key =  $api_key;
		$order->razorpay_amount = $order->razorpay_amount_payable();
		$order->company = Config::project_name();


		
		header("content-type:application/json")	;
		
		echo "$order";	

	}

	public function fetch_suborder($order_id)
	{

		header("Access-Control-Allow-Origin:*");


		$order = SubscriptionOrder::find($order_id);

		$settings = 		 SiteSettings::site_settings();
		$api_key  =   $settings['razorpay_public_key'];
		$api_secret  =   $settings['razorpay_secret_key'];




		$order->razorpay_public_key =  $api_key;
		$order->razorpay_amount = $order->razorpay_amount_payable();
		$order->company = Config::project_name();


		
		header("content-type:application/json")	;
		
		echo "$order";	

	}



	public function complete_order($value='')
	{

		$cart = json_decode($_POST['cart'],  true);
		header("content-type:application/json");

		//ensure there is license keys available before proceeding
		$safety =  Orders::confirm_order_is_safe_for_processing($cart);
		if ($safety == false) {
			echo json_encode(['payment_method' => ['method'=>'none']]);
			return;
		}



		DB::beginTransaction();

		try {
			

			$auth = $this->auth();
			$total = $cart['$total'];

		 	$amount_payable = $total ;

		 	if ($amount_payable == 0) {


				Session::putFlash('danger', "Invalid Cart");
					echo "{}";
					return ;

		 	}
		 	

			$new_order = Orders::updateOrCreate(
						['id' => $_SESSION['shop_checkout_id']],
						[
							'user_id'		 => $auth->id,
							'buyer_order'	 => json_encode($cart['$items']),
							'percent_off' 	 => $percent_off,
							'amount_payable' => $amount_payable,
						]);


			
			if ($new_order->is_secret_order()) {

				if ($_POST['payment_method'] != 'website') {

					Session::putFlash('danger', "You can only use website to pay this order. ");
					echo "{}";
					return ;
				}

			}else{


				if ($_POST['payment_method'] == 'website') {

					Session::putFlash('danger', "You cannot use website to pay this order. ");
					echo "{}";
					return ;
				}

										// print_r($shop);
			}


			if ($new_order->is_mixed_order()) {
				Session::putFlash('danger', "You can order either secret products only or non-secret product only. ");
				echo "{}";
				return;	
			}



				$shop = new Shop();
					$payment_details =	$shop
										->setOrderType('ebook') //what is being bought
										->setOrder($new_order)
										->setPaymentMethod($_POST['payment_method'])
										->initializePayment()
										->attemptPayment();


			DB::commit();
			Session::putFlash('success', "Order Created Successfully. ");
			$_SESSION['shop_checkout_id'] = $new_order->id;

			echo $shop->order;


		} catch (Exception $e) {
			
			DB::rollback();
			Session::putFlash('danger', "We could not create your order.");
			// Redirect::back();
		}




	}



	/**
	 * this is the default landing point for all request to our application base domain
	 * @return a view from the current active template use: Config::views_template()
	 * to find out current template
	 */
	public function index($category=null)
	{
		echo "string";

		// $this->view('guest/shop', ['default_category'=>$category]);
	}


	public function order_detail($order_id)
	{	
		$order = Orders::find($order_id);
		if ($order == null) {

			Redirect::back();
		}
		$this->view('guest/order_detail', ['order'=> $order]);

	}


	public function cart()
	{
		$shipping_rate = '1500.00';
		$this->view('guest/cart', ['shipping_rate'=>$shipping_rate]);
	}




	public function delete_stored_order($order_id)
	{
			Orders::delete_order([$order_id]);
			echo "deletededeed";
	}




	public function product_detail($product_id=null)
	{
		$product = Products::find($product_id);
		$this->view('guest/product-details', ['product'=>$product]);
	}





	public function retrieve_cart_in_session()
	{

		// echo "<pre>";
		header("content-type:application/json");

			$cart = json_decode($_SESSION['cart'], true);

			foreach ($cart['$items'] as $key =>  $item) {

				 // $item_array =  json_decode($item, true);
				unset($cart['$items'][$key]['$$hashKey']);
				$items[] = $item;
			}

		if (! isset($_SESSION['cart'])) {
			$cart = [];
		}

		print_r(json_encode($cart));
	}


	public function update_cart()
	{		
		
		$_SESSION['cart'] = ($_POST['cart']);
	}


	public function all_categories($page=1)
	{
		header("Content-type: application/json");
		// $per_page = 100;
		echo ProductsCategory::all();
		// ->forPage($page , $per_page);
	}

	public function empty_cart_in_session()
	{
		unset($_SESSION['cart']);
		unset($_SESSION['shop_checkout_id'] );
	}




	public function send_order_notification_email($order_id)
	{
		$order =  Orders::find($order_id);

			$notification_email=  	CmsPages::where('page_unique_name', 'notification' )->first()->page_content;
			$notification_email = json_decode($notification_email , true);


		$subject = Config::project_name().' NEW ORDER NOTIFICATION';
		 $email_body = $this->buildView('emails/order_notification', ['order'=>$order]);

		$mailer = 	new Mailer();
		$mailer->sendMail($notification_email['notification_email'], $subject, $email_body );
		ob_end_clean();
	}


	public function send_order_confirmation_email($order_id)
	{
		$order =  Orders::find($order_id);
		$to = $order->billing_email;
		$subject = Config::project_name().' ORDER CONFIRMATION';
		 $email_body = $this->buildView('emails/order_confirmation', ['order'=>$order]);

		$mailer = 	new Mailer();
		$mailer->sendMail($to, $subject, $email_body );
		ob_end_clean();
	}


	public function fetch_products($page=1, $category_id=null)
	{

		$per_page = 20;

		$courses = $this->auth()->accessible_products();

		//pagination
		$courses = $courses->get()->forPage($page, $per_page);
		foreach ($courses as $course) {

			$course->number_of_available_license_key = $course->HasAvailalbleLicenseKey;
			$course->category = $course->category;
			$course->short_title = substr($course->title, 0, 34);
			$course->last_updated = $course->updated_at->diffForHumans();
			$course->thumbnail = $course->image;
			$course->url_link = $course->url_link();
			$course->images = $course->images;
			$course->mainimage = $course->mainimage;
			$course->secondaryimage = $course->secondaryimage;
			$course->percentdiscount = $course->percentdiscount;
			$course->quickdescription = $course->quickdescription();
		}

		header("Content-type: application/json");


		echo $courses;

			
}



	public function retrieve_shipping_settings()
	{
		header("Content-type: application/json");
		// echo CmsPages::where('page_unique_name', 'shipping_details')->first()->page_content;

	}


	public function find($course_id)
		{

		header("Content-type: application/json");
		// $per_page = 100;
		 $course =  Products::find($course_id);

			$course->by = $course->instructor->lastname.' '. $course->instructor->firstname;
			$course->category = $course->category;
			$course->short_title = substr($course->title, 0, 34);
			$course->last_updated = $course->updated_at->diffForHumans();
			$course->thumbnail = $course->image;
			$course->url_link = $course->url_link();
			$course->images = $course->images;
			$course->mainimage = $course->mainimage;
			$course->quickdescription = $course->quickdescription();

		echo $course;

			}	


	



}






?>