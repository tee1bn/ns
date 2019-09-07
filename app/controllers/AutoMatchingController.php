<?php
// error_reporting(E_ERROR | E_PARSE);

use Illuminate\Database\Capsule\Manager as DB;

/**



*/
class AutoMatchingController extends controller
{




	public function __construct(){

		$this->settings = SiteSettings::site_settings();


		$this->url = "https://api.coinwaypay.com/api/supervisor/turnover";
		$this->api_key ='X-Api-Key : aabee567-eec7-4bbb-a0da-fb514cbc3285';

		$this->header = [
			$this->api_key
		];


		echo "<pre>";

		// print_r($this->settings);
		

	}


	//this function schedules commissions due for
	public function schedule_due_commissions()
	{	

		$payment_start_day = $this->settings['commission_payouts_start_date'];


		$action_start_date = date("Y-m-$payment_start_day");
		$action_start_time =  strtotime($action_start_date) ;
		$today = date("Y-m-d");

		$date_condition = (time() >= $action_start_time);

		if (!$date_condition) {
			return;
		}


		echo $payment_month = date("Y-m-01", strtotime("last month"));

		$payment_date_range = MIS::date_range($payment_month, 'month', true);

		print_r($payment_date_range);

		$scheduled_commissions = SettlementTracker::where('period', $payment_month)->get()->pluck('user_id');






		$query_string = http_build_query([
			'from' 	=> $payment_date_range['start_date'],
			'to' 	=> $payment_date_range['end_date'],
		]);

		$url = "{$this->url}?$query_string";

		$response = json_decode( MIS::make_get($url, $this->header) , true);

		print_r($response);


		return;


		$total_no = 1234;
		$stop = ($scheduled_commissions->count() >= $total_no);
		if ($stop) {return;}




		print_r($scheduled_commissions->toArray());

		$non_scheduled_users = User::whereNotIn('id', $scheduled_commissions->toArray())->get()->take(25);




		foreach ($non_scheduled_users as $key => $user) {
			//call API and schedule them

		}

		// print_r($non_scheduled_users->toArray());

		echo "<br>";

		/*
		 *pagination
		 *get the total number
		 *get the total number of skip for take 100
		 */
		$per_page = 100;
		$pages = ceil($total_no /$per_page);


		for ($i=1; $i <= $pages ; $i++) { 
			$skip = ($per_page * ($i-1));


			$query_string = http_build_query([
				'from' 	=> $payment_date_range['start_date'],
				'to' 	=> $payment_date_range['end_date'],
				'top' 	=> $per_page,
				'skip' => $skip
			]);

			

echo			$url = "{$this->url}?$query_string";

			// $response = MIS::make_get($url, $this->header);







			echo "<br>$skip <br>";
		}

	}




	public function pay_commissions()
	{
		$unpaid = SettlementTracker::where('paid_at', null)->get();

		foreach ($unpaid as $key => $settlement) {

				$disagio = $settlement['settled_disagio'];
				$license_fee = $settlement['settled_license_fee'];

				$settlement->give_commission($disagio, $license_fee);
		}

	}






	public function send_subscription_email()
	{

		$orders = SubscriptionOrder::where('user_id', $this->auth()->id)->where('sent_email', '!=', 1)->get();

		foreach ($orders as $order) {

			$order->send_subscription_confirmation_mail();
		}

	}

	public function index()
	{
		# code...
	}













}
















?>