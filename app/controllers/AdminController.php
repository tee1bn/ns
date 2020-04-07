<?php

use Illuminate\Database\Capsule\Manager as DB;
use  Filters\Filters\WalletFilter;
use  Filters\Filters\SupportTicketFilter;
use  Filters\Filters\UserFilter;

use v2\Shop\Payments\Paypal\Subscription;
use v2\Shop\Payments\Paypal\PaypalAgreement;
use v2\Models\Wallet;
/**
 * this class is the default controller of our application,
 * 
*/
class AdminController extends controller
{


	public function __construct(){


		$this->middleware('administrator')->mustbe_loggedin();
	}


	public function packages()
	{

		$this->view('admin/packages');

	}

	

	public function support_messages()
	{

		$this->view('admin/support-messages');
	}

	private function ticket_matters($extra_sieve)
	{


		$sieve = $_REQUEST;
		$sieve = array_merge($sieve, $extra_sieve);

		$query = SupportTicket::latest();
		// ->where('status', 1);  //in review
		$sieve = array_merge($sieve);
		$page = (isset($_GET['page']))?  $_GET['page'] : 1 ;
		$per_page = 50;
		$skip = (($page -1 ) * $per_page) ;

		$filter =  new  SupportTicketFilter($sieve);

		$data =  $query->Filter($filter)->count();

		$tickets =  $query->Filter($filter)
						->offset($skip)
						->take($per_page)
						->get();  //filtered

		return compact('tickets', 'sieve', 'data','per_page');
		
	}






	public function open_tickets()
	{
		$sieve = ['status' => 0];
		$compact =  $this->ticket_matters($sieve);
		extract($compact);
		$page_title = 'Open Tickets';

		$this->view('admin/all_tickets', compact('tickets', 'sieve', 'data','per_page', 'page_title'));
	}


	public function closed_tickets()
	{
		$sieve = ['status' => 1];
		$compact =  $this->ticket_matters($sieve);
		extract($compact);
		$page_title = 'Closed Tickets';

		$this->view('admin/all_tickets', compact('tickets', 'sieve', 'data','per_page', 'page_title'));
	}




	public function package_invoice($order_id=null)
	{

		$order  =  SubscriptionOrder::where('id', $order_id)->first();
		
		if ($order == null) {
			Redirect::back();
		}

		$order->invoice();

		
	}


	public function products_orders()
	{
			$orders =  Orders::all();
			$this->view("admin/products_orders", compact('orders'));
	}


	public function update_subscription_confirmation_message()
	{


		DB::beginTransaction();

		try {
			

				SubscriptionPlan::find($_POST['id'])->update([
					'confirmation_message'=> $_POST['confirmation_message']
				]);
				DB::commit();
				Session::putFlash('success', "Note Updated Successfully");
		} catch (Exception $e) {
				Session::putFlash('danger', "Note Not Updated Successfully");

		}

				Redirect::back();

	}


	public function view_company($company_id= null)
	{
		$company = Company::find($company_id);

		if ($company == null) {
			Redirect::back();
		}

		$owner = $company->user;

		$this->user_profile($owner->id);

		Redirect::to('user/company')	;

	}

	public function decline_company($company_id= null)
	{
		$company = Company::find($company_id);

		if ($company == null) {
			Redirect::back();
		}


		$company->decline();

		Redirect::back();

	}

	public function approve_company($company_id= null)
	{
		$company = Company::find($company_id);

		if ($company == null) {
			Redirect::back();
		}


		$company->approve();

		Redirect::back();

	}

	public function fetch_subscription()
	{

		header("content-type:application/json");
		echo SubscriptionPlan::all();
	}


	public function order($order_id=null)
	{

		$order  =  Orders::where('id', $order_id)->first();


		if ($order== null) {
			Redirect::back();
		}


		$this->view('admin/order_detail', compact('order'));
	}

	

	public function update_account_plans()
	{
	

		print_r($_POST);

		// return;
		$this->validator()->check(Input::all() , array(
			'package_type' =>[
				'required'=> true,
			],

			'id' =>[
				'required'=> true,
			],
			
			'price' =>[
				// 'required'=> true,
			],
			
		));


		if (! $this->validator->passed()) {

			Session::putFlash('danger', Input::inputErrors());
			Redirect::back();
		}



		$plan = Input::all();

		$account_plan =  SubscriptionPlan::find($_POST['id']);



		if ($account_plan == null) {
			Session::putFlash('danger', "Invalid Request");
			Redirect::back();
		}


		$account_plan->update(['availability' => null]);
		print_r($account_plan->toArray());



		$account_plan->update([
				'package_type'=> $_POST['package_type'],
				'price'=> $_POST['price'],
				'hierarchy'=> $_POST['hierarchy'],
				'details'=> json_encode($_POST['details']),
				 'availability'=> $_POST['availability'],
				 'commission_price' => $_POST['commission_price'],
				 'downline_commission_level' => $_POST['downline_commission_level'],
				 'get_pool' => $_POST['get_pool'],
				 'percent_vat' => $_POST['percent_vat'],

				]);

			Session::putFlash('success', "$account_plan->package_type updated successfully ");

		Redirect::back();
	}






	public function update_subscription_plans()
	{


		foreach ($_POST['plan'] as $plan_id => $plan) {

			$subscription_plan = SubscriptionPlan::find($plan_id);
			$subscription_plan->update(['availability' => '']);
			print_r($subscription_plan->toArray());
			$subscription_plan->update($plan);


		}

		Session::putFlash("success","Updated Succesfully.");

		Redirect::back();

	}



	public function edit_book($ebook_id)
	{

		$ebook = Ebooks::find($ebook_id);

		$this->view('admin/edit_book', compact('ebook'));

	}


	public function products()
	{

		$this->view('admin/products');

	}


	public function licensing()
	{

		$this->view('admin/licensing');

	}


	public function packages_settings()
	{	
		$this->packages();

		// $this->view('admin/packages_settings');

	}



	public function add_book()
	{

		$ebook = Ebooks::create([]);

		Redirect::to("admin/edit_book/{$ebook->id}");

	}


	public function download_request($product_id)
	{

		 $product = Products::find($product_id);
		 $product->download();
		 Redirect::back();
	}




	public function download_book($ebook_id)
	{

		 $ebook = Ebooks::find($ebook_id);
		 $ebook->download();

	}



	public function update_ebook($ebook_id=null)
	{
		echo "<pre>";
		print_r($_POST);
		print_r($_FILES);

		DB::beginTransaction();

		try {
		
				$ebook = Ebooks::find($_POST['ebook_id']);
				$ebook->update([
						'title' => $_POST['title'],
						'description' => $_POST['description'],
						'subscription_access' => $_POST['subscription_access'],
					]);

				$ebook->upload_coverpic($_FILES['cover_image']);
				$ebook->upload_ebook($_FILES['ebook']);

			DB::commit();

			Session::putFlash('success', 'Ebook Updated Succesfully.');
		} catch (Exception $e) {
			DB::rollback();
			Session::putFlash('danger', 'Ebook could not update succesfully.');
			
		}
		Redirect::back();

	}


	public function export_payout_to_pdf($month)
	{

					$mpdf = new \Mpdf\Mpdf([
				        'margin_left' => 15,
				        'margin_right' => 15,
				        'margin_top' => 10,
				        'margin_bottom' => 20,
				        'margin_header' => 10,
				        'margin_footer' => 10
				    ]);

					  $project_name = Config::project_name();
					  $domain = Config::domain();

				    $mpdf->SetProtection(array('print'));
				    $mpdf->SetTitle("$domain");
				    $mpdf->SetAuthor("$project_name");
				    $mpdf->SetWatermarkText("$project_name");
				    $mpdf->showWatermarkText = true;
				    $mpdf->watermark_font = 'DejaVuSansCondensed';
				    $mpdf->watermarkTextAlpha = 0.1;
				    $mpdf->SetDisplayMode('fullpage');

				    $date_now = (date('Y-m-d H:i:s'));

				    $mpdf->SetFooter("Date Generated: " . $date_now . " - {PAGENO} of {nbpg}");

						$html  = $this->payouts_html($month , true);

				    $mpdf->WriteHTML($html);

		    $mpdf->Output("$month-Payouts.pdf", \Mpdf\Output\Destination::DOWNLOAD);
	}

	public function payouts_view($month)
	{
		$view = $this->payouts_html($month);

		header("content-type:application/json");

		echo json_encode(compact('view'));
	}


	public function payouts_html($month, $return = false)
	{

		$daterange = MIS::date_range($month, 'month', true);


		$query     =   Wallet::select(DB::raw("sum(amount) as amount"),'user_id')->ClearedWithin($daterange)->Credit()->Completed()->groupBy('user_id');
		$payouts = $query->get()->keyBy('user_id');
		$total = $payouts->sum('amount');

		$users  = User::whereIn('id', array_keys($payouts->toArray()))->with(['company'])->get()->keyBy('id');


		if ($return) {
			return $this->buildView('admin/payouts_pdf', compact('payouts','month','total', 'users'));
		}

		echo $this->buildView('admin/payouts_pdf', compact('payouts','month','total', 'users'));
	}

	public function payouts()
	{


		$this->view('admin/payouts');
	}


	public function fetch_documents_list()
	{


		$documents_settings = SiteSettings::documents_settings();

		header("content-type:application/json");

		 $documents = ($documents_settings);

		
		 echo  json_encode(compact('documents'));
	}


	public function upload_supporting_document()
	{



		$documents_settings =  SiteSettings::where('criteria', 'documents_settings')->first();

		$files =  MIS::refine_multiple_files($_FILES['files']);

		$combined_files = array_combine($_POST['label'], $files);

		$response = $documents_settings->upload_documents($combined_files);


		// Redirect::back();
		

	}


	public function delete_document($key)
	{
		
		$documents_settings =  SiteSettings::where('criteria', 'documents_settings')->first();
		$response = $documents_settings->delete_document($key);
		header("content-type:application/json");

		echo json_encode(compact('response'));


		
		
	}




	public function confirm_payment($order_id)
	{

		$order = SubscriptionOrder::find($order_id);
		$status = $order->mark_paid();
		Redirect::back();
	}


	public function testimony()
	{

		$this->view('admin/testimony');
	}

	public function documents()
	{
		$show = true;
		$this->view('admin/documents', compact('show'));
	}	

	public function edit_testimony($testimony_id =null)
	{
		if (($testimony_id != null)  ) {
		$testimony = Testimonials::find($testimony_id);
			if (($testimony != null) ) {

						$this->view('admin/edit_testimony', ['testimony'=>$testimony ]);
						return;
			}else{
				Redirect::to();
			}

		}

	}



	public function suspending_admin($admin_id=null)
	{

		$admin = Admin::find($admin_id);
			if ($admin == null) {
					Redirect::back();
				}


		if ($admin->is_owner()) {
			Session::putFlash('danger', "Invalid Request");
			Redirect::back();
		}else{

			$admin->delete();
			Session::putFlash('success', "Deleted Succesfully");
		}
					Redirect::back();
	}



	public function create_admin()
	{

			if (Input::exists()) {

			}

			$this->validator()->check(Input::all() , array(

					'firstname' =>[

						'required'=> true,
						'min'=> 2,
						'max'=> 20,
							],
					'lastname' =>[

							'required'=> true,
							'min'=> 2,
							'max'=> 20,
								],

					'email' => [

									'required'=> true,
									'email'=> true,
									'unique'=> 'Admin'
								],

					'username' => [

									'required'=> true,

									'min'=> 3,
									// 'one_word'=> true,
									'no_special_character'=> true,
									'unique'=> 'Admin',
								],

					'phone' => [

									'required'=> true,
									'min'=> 9,
									'max'=> 14,
									'unique'=>'Admin'

								],

			));

			if($this->validator->passed()){
			 	$admin =  Admin::create([
			 				'firstname' => Input::get('firstname') ,
			 				'lastname' => Input::get('lastname') ,
			 				'email' => Input::get('email') ,
			 				'phone' => Input::get('phone') ,
			 				'username' => Input::get('username') ,
			 				
			 				]);
			 	if($admin){


			 		Session::putFlash('success', "Admin Created Succesfully.");
			 	}
		 	}else{


		 		Session::putFlash('info', Input::inputErrors());
			}



	}




	public function mark_withdrawal_paid($withdrawal_id)
	{

		$withdrawal = LevelIncomeReport::find($withdrawal_id);
		$withdrawal->mark_withdrawal_paid();
	
			Redirect::back();
	}



	public function administrators()
	{

		$this->view('admin/administrators');
	}
	


	public function accounts()
	{
		$this->view('admin/accounts');
	}


	public function profile($admin_id=null)
	{

		$admin  =  Admin::where('id', $admin_id)->first();
		if (($admin == null) || (($admin->is_owner() )  && (!$this->admin()->is_owner()))) {

			Session::putFlash('danger','unauthorised access');
			Redirect::back();
		}

		$this->view('admin/profile', compact('admin'));
	}





	public function toggle_news($new_id)
	{

		$news = BroadCast::find($new_id);
		if ($news->status) {

		$update = $news->update(['status' => 0 ]);
		Session::putFlash('success', 'News unpublished succesfully');


		}else{

		$update = $news->update(['status' => 1 ]);

		Session::putFlash('success', 'News published succesfully');

		}

		Redirect::back();
	}




	public function delete_news($new_id)
	{

		$news = BroadCast::find($new_id);
		if ($news != null) {

		$update = $news->delete();
		Session::putFlash('success', 'Deleted succesfully');


		}


	Redirect::back("admin/news");


	}



	public function create_news(){

		print_r(Input::all());
		BroadCast::create([
						'broadcast_message' => Input::get('news'),
						'admin_id' => $this->admin()->id
						]);
		Session::putFlash('success', 'News Created succesfully');

		Redirect::back();


	}



	public function broadcast()
	{
		$this->view('admin/broadcast');
	}


	public function cms()
	{
		$this->view('admin/cms');
	}



	public function viewSupportTicket($ticket_id){

		$support_ticket_messages = SupportTicket::find($ticket_id)->messages; 
		$support_ticket 		 = SupportTicket::find($ticket_id); 

		$this->view('admin/support-ticket-messages', [
					'support_ticket_messages'	=> $support_ticket_messages ,
					'support_ticket'			=> $support_ticket 
									]);  

	}
	


	 public function create_testimonial()
    {

    	if (Input::exists() || true) {

	    	$testimony = Testimonials::create([
	    						'attester' => Input::get('attester'),
								  'content'  =>Input::get('testimony')]);

    	}
    	Redirect::to("admin/edit_testimony/{$testimony->id}");
    }





	public function testimonials()
	{
		$this->view('admin/testimonials');

	}

	public function approve_testimonial($testimonial_id)
	{

		$testimony = Testimonials::find($testimonial_id);
		if ($testimony->approval_status) {

		$update = $testimony->update(['approval_status' => 0 ]);
		Session::putFlash('success', 'Testimonial disapproved succesfully');


		}else{

		$update = $testimony->update(['approval_status' => 1 ]);

		Session::putFlash('success', 'Testimonial approved succesfully');

		}


	Redirect::back();


	}

	public function delete_testimonial($testimonial_id)
	{

		$testimony = Testimonials::find($testimonial_id);
		if ($testimony != null) {

		 $testimony->delete();
			Session::putFlash('success', 'Testimonial deleted succesfully');


		}


		Redirect::back();
	}


 	public function update_testimonial()
    {

    	echo "<pre>";
    	$testimony_id = Input::get('testimony_id');
     	$testimony = Testimonials::find($testimony_id);

    	$testimony->update([
    						 'attester' =>Input::get('attester'),
							  'content'  =>Input::get('testimony'),
							  'approval_status' => 0 
							]);


    	Session::putFlash('success','Testimonial updated successfully. Awaiting approval');

    	Redirect::back();
    }



	public function support()
	{

		$support_tickets = SupportTicket::all();
			$this->view('admin/support', ['support_tickets' => $support_tickets]);  
	}




	private function users_matters($extra_sieve)
	{


		$sieve = $_REQUEST;
		$sieve = array_merge($sieve, $extra_sieve);

		$query = User::latest();
		// ->where('status', 1);  //in review
		$sieve = array_merge($sieve);
		$page = (isset($_GET['page']))?  $_GET['page'] : 1 ;
		$per_page = 50;
		$skip = (($page -1 ) * $per_page) ;

		$filter =  new  UserFilter($sieve);

		$data =  $query->Filter($filter)->count();

		$sql = $query->Filter($filter);

		$users =  $query->Filter($filter)
						->offset($skip)
						->take($per_page)
						->get();  //filtered


		return compact('users', 'sieve', 'data','per_page');
		
	}
	

	
	public function users()
	{


		$compact =  $this->users_matters([]);
		extract($compact);
		$page_title = 'Users';

		$this->view('admin/users', compact('users', 'sieve', 'data','per_page', 'page_title'));
	}




	public function companies(){
		$this->view('admin/companies');
	}



	public function testing()
	{
		$this->view('admin/sales');
	}	


	
	public function update_cms()
	{

		DB::beginTransaction();

		try {
			
				CMS::updateOrCreate([
					'criteria' => $_POST['criteria']
				],[
					'settings' => $_POST['settings'],
				]);



			DB::commit();
			Session::putFlash("success", "Changes Saved");
		} catch (Exception $e) {
			DB::rollback();
			print_r($e->getMessage());
		}

		Redirect::back();
	}






	public function settings(){
		$this->view('admin/settings');
	}


	public function user_profile($user_id = null){

		if ($user_id==null) {
			Redirect::back();
		}


		$_SESSION[$this->auth_user()] = $user_id;

		$domain = Config::domain();
		$e = <<<EOL


				<style type="text/css">
					body {
	  				 margin: 0;
	   				overflow: hidden;
					}
					#iframe1 {
	   				 position:absolute;
	    				left: 0px;
	    				width: 100%;
	    				top: 0px;
	    				height: 100%;
					}
				</style>


	 		<iframe  id="iframe1" src="$domain/user/dashboard"></iframe>
EOL;

		echo "$e";
		// $this->view('admin/accessing_user_profile');
	}



	public function suspending_user($user_id){


		if (User::find($user_id)->blocked_on) {

		$update = User::find($user_id)->update(['blocked_on' => null ]);
		Session::putFlash('success', 'Ban lifted succesfully');


		}else{

		$update = User::find($user_id)->update(['blocked_on' => date("Y-m-d")]);

		Session::putFlash('success', 'User Blocked succesfully');

		}


		if ($update) {	
		}else{
		Session::putFlash('flash', 'Could not Block this User');
		}


		Redirect::back();
	}



	public function dashboard()
	{	
		$this->view('admin/dashboard');

	}



	private function wallet_matters($extra_sieve, $class)
	{

		$sieve = $_REQUEST;
		$sieve = array_merge($sieve, $extra_sieve);

		$query = $class::latest();
		// ->where('status', 1);  //in review
		$sieve = array_merge($sieve);
		$page = (isset($_GET['page']))?  $_GET['page'] : 1 ;
		$per_page = 50;
		$skip = (($page -1 ) * $per_page) ;

		$filter =  new  WalletFilter($sieve);

		$data =  $query->Filter($filter)->count();

		$records =  $query->Filter($filter)
						->offset($skip)
						->take($per_page)
						->get();  //filtered

		return compact('records', 'sieve', 'data','per_page');
		
	}



	public function credits($from=null , $to=null)
	{


		$compact =  $this->wallet_matters([
		], 'v2\Models\Wallet');

		extract($compact);
		$page_title = 'Credit';

		$this->view('admin/credits', compact('records', 'sieve', 'data','per_page', 'page_title'));
	}





	public function library()
	{	
		$this->view('admin/library');

	}

	public function debits($from=null , $to=null)
	{	
		$query =  LevelIncomeReport::Debits();

		if (($from != null) && ($to != null)) {
			$query =  $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
		}

		$debits = $query->get(); 
		$inflows_total = $query->sum('amount_earned');
		$this->view('admin/debits', compact('debits', 'inflows_total'));

	}


	public function orders($from=null , $to=null)
	{	


		$query =  SubscriptionOrder::latest();


		if (($from != null) && ($to != null)) {
			$query =  $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
		}

	 	$subscription_orders = $query->get();
		$inflows_total = $query->where('paid_at','!=', null)->sum('price');
	
		$this->view('admin/subscription_orders', compact('subscription_orders',
														'inflows_total'));
	}




}























?>