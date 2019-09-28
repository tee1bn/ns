
<?php

use Illuminate\Database\Capsule\Manager as DB;
use Razorpay\Api\Api;

/**
 * this class is the default controller of our application,
 * 
*/
class shopController extends controller
{


	public function __construct(){

		/*if (! $this->admin()) {

			$this->middleware('current_user')
				 ->mustbe_loggedin()
				 ->must_have_verified_email();
		}		*/
	}





	function verify_payment()
	{
		$order_id = $_REQUEST['order_id'];
		$order_type = $_REQUEST['order_type'];

		$order = Orders::find($order_id);

		if ($order == null) {
			return ;
		}

			$shop = new Shop();
			$payment_details =	$shop
								->setOrder($order) //what is being bought
								->verifyPayment();


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





	public function paypal_payment_received($order_id)
	{

		$order = Orders::where('id', $order_id)->first();
		// ->where('user_id', $this->auth()->id)

		 $order->execute_paypal_payment('paypal');

		 Redirect::to('user/shop');

	}



	public function complete_order($value='')
	{

		$cart = json_decode($_POST['cart'],  true);

		DB::beginTransaction();


		try {
			


			$percent_off = $this->auth()->subscription->percent_off;
			$total = $cart['$total'];

		 	$amount_payable = $total - (0.01 * $percent_off * $total);


		 	if ($amount_payable == 0) {

		 		throw new Exception("Error Processing Request", 1);
		 	}




		 

			$razor_api  = Orders::razorpay_api();
			
			$new_order = Orders::create([
							'user_id'		 => $this->auth()->id,
							'buyer_order'	 => json_encode($cart['$items']),
							'percent_off' 	 => $percent_off,
							'amount_payable' => $amount_payable,
						]);




		 	// $razorpay_amount =  intval(100 * round($amount_payable));

		 	$order = $razor_api->order->create(array(
			  'receipt' => $new_order->id,
			  'amount' => $new_order->razorpay_amount_payable(),
			  'currency' => 'INR',
			  'payment_capture' =>  1
			  )
			);

		 	$razorpay_order_id = $order->id;

			$new_order->update([
					'razorpay_order_id' => $razorpay_order_id,
				]);



			DB::commit();
			Session::putFlash('success', "Order Created Successfully. ");
			$this->empty_cart_in_session();

			header("content-type:application/json");
			echo $new_order;


		} catch (Exception $e) {
			
			DB::rollback();
			Session::putFlash('danger', "We could not create your order.");
			Redirect::back();
		}




	}


	public function make_payment($order_id=null)
	{
		$order = 	Orders::where('id', $order_id)->where('user_id', $this->auth()->id)->first();

		 $order->make_payment('paypal');

		 Redirect::to("user/products-orders");
	}




	public function open_order_confirmation($order_id='')
	{
			echo $this->buildView('emails/order_confirmation', ['order'=> Orders::find($order_id)]);
	}

	/**
	 * this is the default landing point for all request to our application base domain
	 * @return a view from the current active template use: Config::views_template()
	 * to find out current template
	 */
	public function index($category=null)
	{

		$this->view('guest/shop', ['default_category'=>$category]);
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

	public function checkout()
	{
		$this->view('guest/checkout');
	}


	public function place_order()
	{

		// echo "<pre>";
		// print_r($_POST['cart']);

		$cart =  json_decode($_POST['cart'], true);
		foreach ($cart['$items'] as $key => $item) {
			unset($cart['$items'][$key]['$$hashKey']);
		}


		;
		$cart['$buyer_detail']['shipping'];

		// print_r($cart['$buyer_detail']['billing']);
		// print_r($cart['$others']['payment_method']);


		$billing_validator	= new Validator;
		$shipping_validator	= new Validator;
		
		$billing_validator->check($cart['$buyer_detail']['billing'], UserBilling::$billing_detail_rules );
		$error_notes =  $this->inputErrors();
		unset($_SESSION['inputs-errors']); //remove captured errors for first validation

			if ($cart['$buyer_detail']['billing']['ship_to_diff_address'] == 1) {

				$shipping_validator->check($cart['$buyer_detail']['shipping'], UserShipping::$shipping_detail_rules );
				$error_notes .=  $this->inputErrors();
			}else{
				foreach ($cart['$buyer_detail']['billing'] as $key => $value) {
					 $new_key  = str_replace('billing', 'shipping', $key);
					$cart['$buyer_detail']['shipping'][$new_key] = $value;
				}

			}

		// print_r($cart['$buyer_detail']['shipping']);
		//validate cart
		// print_r($cart['$items']);
		


		 if($billing_validator->passed() && $shipping_validator->passed() && (Products::validate_cart($cart['$items']))){

				$new_order = Orders::create([
								'user_id'		=> $this->auth()->id,
								'buyer_order'		=> json_encode($cart['$items']),
								'additional_note'		=> ($cart['$buyer_detail']['billing']['order_notes']),
								'shipping_fee'		=> json_encode($cart['$selected_shipping']),
			]);

			$new_order->update($cart['$buyer_detail']['billing']);
			$new_order->update($cart['$buyer_detail']['shipping']);


			// Session::putFlash('success', "Order Created Successfully");

			header("Content-type:application/json");
			$new_order->total_amount = $new_order->total_price();
			$new_order->paystack_total = $new_order->paystack_total();
			// echo json_encode($new_order->toArray() , 4);


				$paystack_keys = CmsPages::fetch_page_content('paystack_keys');
				$public_key = $paystack_keys['public_key'];


			echo json_encode([
							'order' => $new_order->toArray(),
							'payment_method' => $cart['$others']['payment_method'],
							'public_key' => $public_key
							]);

		

	 }else{

		Session::putFlash('danger', "{$error_notes}");
		echo "error"; //corrupts the json and prevents paystack from loading 
	 }

		// print_r($cart);
	 return; 	
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




	public function add_to_cart($course_id)
	{
		$course = Course::find($course_id);
		$image = $course->image;
		$course->image = $image ;


		foreach ($_SESSION['cart'] as $item) {
				$item = json_decode($item , true);
				if ($item['id'] == $course_id) {
					echo "Item already in cart!";

					return;
				}


		}

		$_SESSION['cart'][] =	$course->toJson();
		echo "Added successfully!";
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

			// $cart['$items'] = $items;
	
		if (! isset($_SESSION['cart'])) {
			
			$cart = [];

		}

				// print_r($items);
				// print_r($cart);


		print_r(json_encode($cart));

	}


	public function update_cart()
	{

		// print_r($_POST);
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
		$courses = Products::on_sale()->orderBy('updated_at', 'DESC')
		->where('scheme',$this->auth()->subscription->id)		;





		// $courses = Products::on_sale()->orderBy('updated_at', 'DESC');

/*
		if (Category::find($category_id) != null) {

			$courses->where('category_id', $category_id);
		}*/

		//pagination
		$courses = $courses->get()->forPage($page, $per_page);
		foreach ($courses as $course) {

			$course->by = $course->instructor->lastname.' '. $course->instructor->firstname;
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