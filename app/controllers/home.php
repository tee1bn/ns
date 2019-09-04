<?php


use classes\Auth\Auth as Auth;


/**
 * this class is the default controller of our application,
 * 
*/
class home extends controller
{


	public function __construct(){

	}

	public function test2()
	{
		

		echo "<pre>";
			// print_r(MIS::date_range('2019-08-15', 'week'));


		$url ="https://www.google.com/search?q=php+curl+get+request+with+headers&rlz=1C1CHBF_enNG843NG843&oq=php+curl+get&aqs=chrome.1.69i57j0l5.8073j0j7&sourceid=chrome&ie=UTF-8";
		
		$url = "https://api.coinwaypay.com/api/supervisor/turnover?from=2019-01-01&to=2020-01-01";
		$header = [
			'X-Api-Key'=> "aabee567-eec7-4bbb-a0da-fb514cbc3285"
		];


		$response = MIS::make_get($url);




return;
		$commission_settings= [


				1 => [

					'level' => 'pool 1',
					'min_merchant_recruitment' => 100,
					'percent_disagio' => 0.05,
				],

				2 => [

					'level' => 'pool 2',
					'min_merchant_recruitment' => 300,
					'percent_disagio' => 0.1,
				],

				3 => [

					'level' => 'pool 3',
					'min_merchant_recruitment' => 5-0,
					'percent_disagio' => 0.15,
				],

		];




		print_r(json_encode($commission_settings));
		// print_r(SiteSettings::commission_settings());



		echo "</pre>";


	}


	public function send_message()
	{

		if (Input::exists() || true) {
			$this->validator()->check(Input::all() , array(

		
			'name' =>[

				'required'=> true,
				'min'=> 3,
				'max'=> 42,
					],
			'email' =>[

						'required'=> true,
						'email'=> true,
						'max'=> 52,
							],

			'subject' =>[
						'min'=> 7,
							],


			'message' =>[

						'required'=> true,
						'min'=> 5,
							],
		));
		
		if($this->validator->passed()){

					$settings = SiteSettings::site_settings();

					$to = $settings['contact_email'];

					$phone = $_POST['subject'];
					$from = "$name, $email ";
					$message = "$from - $phone ".$_POST['message'];


					$mailer = new Mailer();
					$response = $mailer->sendMail($to,'New Message',$message);	


					if ($response == true) {
					 	Session::putFlash('success', '<div id="sendmessage" style="display: block;">Your message has been sent. Thank you!</div>');
					}else{
					 	Session::putFlash('danger', '<div id="errormessage" style="display: block;">Could not send message. Please try again </div> ');

					}


					 }else{

					 	
					 	Session::putFlash('danger', '<div id="errormessage" style="display: block;">Could not send message. Please try again </div> ');
						print_r($this->validator->errors());


					 }
	}


		Redirect::back();
	}


	public function test()
	{
		echo "<pre>";

		$site_settings = [];


		print_r(json_encode($site_settings));
	
	}




	public function set_filters()
	{

		echo "<pre>";
		$redirect = $_POST['redirect'];
		$filter_name = MIS::set_filter_name($redirect);

		echo "$filter_name";
		echo "<br>";

		$_SESSION['filters'][$filter_name] = $_POST;
		print_r($_SESSION);

		Redirect::to($redirect);
	}




	/**
	 * [flash_notification for application notifications]
	 * @return [type] [description]
	 */
	public function flash_notification()
	{
		header("Content-type: application/json");

		if (isset($_SESSION['flash'])) {
		echo json_encode($_SESSION['flash']);
		}else{
			echo "[]";
		}


		unset($_SESSION['flash']);

	}



	public function index($page=null)
	{	

		Redirect::to('login');
	}


	public function about_us()
	{
				$this->view('guest/about');
	}


	public function how_it_works()
	{
				$this->view('guest/how-it-works');
	}

	public function contacts()
	{
				$this->view('guest/contact');
	}

	public function faqs()
	{
				$this->view('guest/faq');
	}


}























?>