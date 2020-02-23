<?php
use v2\Shop\Shop;


/**
 * this class is the default controller of our application,
 * 
*/
class UserController extends controller
{


	public function __construct(){


		$company = $this->auth()->company;
		if ($company == null) {
			$company =  Company::create(['user_id'=>$this->auth()->id]);
		}



		if (! $this->admin()) {
			 $this->middleware('current_user')
				->mustbe_loggedin()
				->must_have_verified_email();
				// ->must_have_verified_company()
		}		


	}

	

	public function notifications($notification_id = 'all')
	{
		switch ($notification_id) {
			case 'all':
			$notifications = Notifications::all_notifications($this->auth()->id);

				break;
			
			default:
			

			$notifications = Notifications::where('user_id', $this->auth()->id)->where('id', $notification_id)->first();

			Notifications::mark_as_seen([$notifications->id]);


			if ($notifications == null) {
				Session::putFlash("danger", "Invalid Request");
				Redirect::back();
			}



			if ($notifications->DefaultUrl != $notifications->UsefulUrl) {

				Redirect::to($notifications->UsefulUrl);
			}



				break;
		}



		$this->view('auth/notifications', compact('notifications'));
	}



	public function company()
	{
		$company = $this->auth()->company;
		$this->view('auth/company', compact('company'));
	}


	public function download_request($item_id=null, $order_id=null)
	{

		 $order  =  Orders::where('id', $order_id)
		 					->where('user_id', $this->auth()->id)
		 					->where('paid_at', '!=', null)
		 					->first();
		 $item = Products::find($item_id);

		if (($order_id == null) || ($item_id ==null) ||  ($order == null) || (! $order->has_item($item_id)) ) {
			Redirect::back();
		}


		
		

		$item->download();
		Redirect::back();		
				
		// print_r($order->order_detail());/

	}




	public function order($order_id=null)
	{

		$order  =  SubscriptionOrder::where('id', $order_id)->where('user_id', $this->auth()->id)->first();
		echo	$this->buildView('auth/order_detail', compact('order'));

	}

	public function package_invoice($order_id=null)
	{

		$order  =  SubscriptionOrder::where('id', $order_id)->where('user_id', $this->auth()->id)->first();
		
		if ($order == null) {
			Redirect::back();
		}

		$order->invoice();

	}




	public function products_orders()
	{
		$this->view('auth/products_orders');
	}



	public function view_cart()
	{

		$cart = json_decode($_SESSION['cart'], true)['$items'];

		if (count($cart) == 0) {
			Session::putFlash("info","Your cart is empty.");
			Redirect::to('user/shop');
		}
    	$this->view('auth/view_cart');
	}


    public function shop()
    {

		$products = $this->auth()->accessible_products();

    	$this->view('auth/shop', compact('products'));
    }



    public function scheme()
    {

    	$subscription = $this->auth()->subscription;

    	if ($subscription == null) {

    		Redirect::back();
    	}

    	$this->view('auth/subscription_confirmation', compact('subscription'));
    }




	public function download($ebook_id)
	{

		$ebook = Ebooks::find($ebook_id);
		 $ebook->download();
	}


	public function create_upgrade_request($subscription_id=null)
	{

		$subscription_id = $_REQUEST['subscription_id'];
	/*
		$order = $this->auth()->subscription;
		if ($order->payment_state == 'automatic') {
		 	$order->cancelAgreement();
		}
*/


		$response = SubscriptionPlan::create_subscription_request($subscription_id, $this->auth()->id);


			header("content-type:application/json");
			echo $response;

		// Redirect::back();
	}


	public function create_secret_upgrade_request($subscription_id)
	{
		
		$response = SubscriptionPlan::create_secret_subscription_request($subscription_id, $this->auth()->id);

			
		// Redirect::back();
	}


	public function package_orders()
	{
			$this->view('auth/package_orders');
	}


	public function package()
	{	
			$shop = new Shop;
			$this->view('auth/package', compact('shop'));
	}




	public function reports()
	{
			$this->view('auth/report');
	}






	public function make_withdrawal_request()
	{

		$settings = SiteSettings::site_settings();
		$min_withdrawal = $settings['minimum_withdrawal'];		

		$currency = Config::currency();
		$amount = $_POST['amount'];


		if ($amount < $min_withdrawal) {
			Session::putFlash('info',"Sorry, Minimum Withdrawal is  $currency$min_withdrawal. ");
			Redirect::back();
		}


	



		LevelIncomeReport::create_withdrawal_request($this->auth()->id, $amount);

		Redirect::back();

	}




	public function withdrawals()
	{
		$this->view('auth/withdrawal-history');

	}



 	public function update_testimonial()
    {

    	echo "<pre>";
    	$testimony_id = Input::get('testimony_id');
     	$testimony = Testimonials::find($testimony_id);

    	$attester =  $this->auth()->lastname.' '. $this->auth()->firstname;


    	$testimony->update([
    						 'attester' =>$attester,
							  'user_id'	 => $this->auth()->id, 
							  'content'  =>Input::get('testimony'),
							  'approval_status' => 0 
							]);


    	Session::putFlash('success','Testimonial updated successfully. Awaiting approval');

    	Redirect::back();
    }



	public function create_testimonial()
    {
    	if (Input::exists() || true) {

    		$auth = $this->auth();

	    	$testimony = Testimonials::create([
	    						'attester' => $auth->lastname.' '. $auth->firstname,
								  'user_id'	 => $auth->id, 
								  'content'  =>Input::get('testimony')]);

    	}
    	Redirect::to("user/edit_testimony/{$testimony->id}");
    }



	public function edit_testimony($testimony_id =null)
	{
		if (($testimony_id != null)  ) {
		$testimony = Testimonials::find($testimony_id);
			if (($testimony != null) && ($testimony->user_id == $this->auth()->id)) {

						$this->view('auth/edit_testimony', ['testimony'=>$testimony ]);
						return;
			}else{
				Session::putFlash('danger','Invalid Request');
				Redirect::back();
			}

		}

	}



	public function view_testimony()
	{
		$this->view('auth/view-testimony');
	}



	public function testimony()
	{
		$this->view('auth/testimony');
	}


	public function documents()
	{
		$show = false;
		$this->view('auth/documents', compact('show'));
	}




	public function news()
	{
		$this->view('auth/news');
	}

	public function language()
	{
		$this->view('auth/language');
	}




	public function profile()
	{
		$this->view('auth/profile');
	}


	

	public function earnings($from=null, $to=null)
	{
		$query =  LevelIncomeReport::where('status','Credit')->where('owner_user_id', $this->auth()->id)->latest();
		if (($from != null) && ($to != null)) {
			$query =  $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
		}


		$earnings = $query->get();
		$earnings_total = $query->sum('amount_earned');
		$this->view('auth/earnings', [
											'earnings'=>$earnings,
											'earnings_total'=>$earnings_total,
											]);
	}



    public function upload_payment_proof()
    {
        $order_id = $_POST['order_id'];
        $order    = SubscriptionOrder::find($order_id);
        $order->upload_payment_proof($_FILES['payment_proof']);
        Session::putFlash('success',"#$order_id Proof Uploaded Successfully!");
        Redirect::back();

    }


	public function upload_ph_payment_proof()
	{
		$directory  = 'uploads/images/payment_proofs';

			$handle = new Upload($_FILES['payment_proof']);
			$match = Match::find(Input::get('match_id'));

                //if it is image, generate thumbnail
                if (explode('/', $handle->file_src_mime)[0] == 'image') {

			$handle->Process($directory);
	 		$original_file  = $directory.'/'.$handle->file_dst_name;

		(new Upload($match->payment_proof))->clean();
			$match->update(['payment_proof' => $original_file]);


			Session::putFlash('success','Proof Uploaded Successfully!');
			Redirect::back();

	}

	}





	public function support()
	{
		$this->view('auth/support');

	}





	public function view_ticket($ticket_id){

	 	$support_ticket 		 = SupportTicket::find($ticket_id); 

		$this->view('auth/support-messages', [
					'support_ticket'			=> $support_ticket 
									]);  


	}



	public function index()
	{
		$settings = SiteSettings::site_settings();
		$this->view('auth/dashboard', compact('settings'));
	}


	public function accounts()
	{
		$this->view('auth/accounts');

	}


	public function dashboard()
	{

		$settings = SiteSettings::site_settings();
		$this->view('auth/dashboard', compact('settings'));
	}

	public function broadcast()
	{
		$this->view('auth/broadcast');

	}








}























?>