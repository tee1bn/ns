<?php
// error_reporting(E_ERROR | E_PARSE);

use Illuminate\Database\Capsule\Manager as DB;

/**



*/
class AutoMatchingController extends controller
{




	public function __construct()
	{

		$this->settings = SiteSettings::site_settings();


		$this->url = "https://api.coinwaypay.com/api/supervisor/turnover";
		$this->api_key ='X-Api-Key : aabee567-eec7-4bbb-a0da-fb514cbc3285';

		$this->header = [
			$this->api_key
		];



		if ($this->settings['distribute_commissions']== 1) {

					$this->scheduled_commissions();
		}


		echo "<pre>";

	}


	public function get_date_to_start_schedule()
	{

		$last_settlement = SettlementTracker::where('paid_at','!=', null)->latest()->first();
		$last_settlement_date = $last_settlement->period;


		if ($last_settlement_date == "") {
			$last_settlement_date = '2019-08-01';
		}



		$pools_settlement =  PoolsCommissionSchedule::where('paid_at','!=', null)->where('period',$last_settlement_date)->first();

		if ($pools_settlement != null) {

			$date = date("Y-m-01", strtotime("+1 month $last_settlement_date"));

		}else{

			$date =  $last_settlement_date;
		}


		echo "$date";


		return $date;

	}


	public function get_period()
	{


		$payment_start_day = $this->settings['commission_payouts_start_date'];


		$action_start_date = date("Y-m-$payment_start_day");
		$action_start_time =  strtotime($action_start_date) ;
		$today = date("Y-m-d");

		//ensure it is time to begin the scheduling
		$date_condition = (time() >= $action_start_time);

		if (!$date_condition) {
			return;
		}

		//deduce payment month
		// $payment_month = date("Y-m-01", strtotime("last month"));
		$payment_month = $this->get_date_to_start_schedule();




		$payment_date_range = MIS::date_range($payment_month, 'month', true);



		return compact('payment_month', 'payment_date_range');
	}


	/**
	 * { This schedule the commissions due for all participants from disagio ,license and no of merchant }
	 * 
	 */
	public function schedule_due_commissions()
	{	

		$period =  $this->get_period();
		extract($period);


		//user_ids of already scheduled commisssions
		$scheduled_commissions = SettlementTracker::where('period', $payment_month)->get()->pluck('user_id');


		// connect with API
		$query_string = http_build_query([
			'from' 	=> $payment_date_range['start_date'],
			'to' 	=> $payment_date_range['end_date'],
		]);

		$url = "{$this->url}?$query_string";

		$response = json_decode( MIS::make_get($url, $this->header) , true);

		$total_no = $response['totalCount'];


		// print_r($scheduled_commissions->toArray());

		//users having pending schedules 
		$non_scheduled_users = User::whereNotIn('id', $scheduled_commissions->toArray())->get()->take(50);


            $non_scheduled_ids = $non_scheduled_users->pluck('id');

			print_r($non_scheduled_ids->toArray());
		/*
		 *determine how many steps and paginations
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

			

				$url = "{$this->url}?$query_string";

				$response = collect(json_decode( MIS::make_get($url, $this->header) , true));

				
				$record = collect($response['value'])->keyBy('supervisorNumber')->toArray();
				$supervisor_numbers =  collect($record)->pluck('supervisorNumber')->toArray();

				$supervisors_to_be_treated = array_intersect($non_scheduled_ids->toArray(), $supervisor_numbers);


				//ensure there is more commissions to schedule
				$stop = (count($supervisors_to_be_treated) >= 0);
				if ($stop) {

					echo "pools";
					//schedule pools commission if regular commission is complete
					$this->pay_commissions();	
					$this->initiate_pools_commissions();	

					return;
				}




				$supervisors = User::whereIn('id', $supervisors_to_be_treated)->get()->keyBy('id')->toArray();

				$this->treat_supervisors_commissions($record , $supervisors, $payment_month);

		
				print_r($supervisors_to_be_treated);
				print_r($supervisor_numbers);
				print_r($record);
				print_r($response->toArray());
		}
	}





	/**
	 * This treats all users whose schdule detail are supplied
	 *
	 * @param      <array>  $records_from_api      The records from api
	 * @param      <array>  $supervisor_ids  The supervisor usernames ie usernames of users
	 * @param      <string>  $payment_month         The payment month
	 */
	public function treat_supervisors_commissions($records_from_api, $supervisor_ids, $payment_month)
	{

			// DB::beginTransaction();

			foreach ($supervisor_ids as $id => $user) {

				$commissions = $records_from_api[$user[id]];

				$settlement[] =	SettlementTracker::create([

						'user_id'	=> $user['id'],
						'user_no'	=> $user['id'],	
						'period'	=> $payment_month,
						'dump'		=> json_encode($commissions),
						'settled_disagio' => $commissions['sumDisagio'],
						'no_of_merchants' => $commissions['tenantCount'],
						'settled_license_fee' =>  $commissions['licenseSum']
					]);


			}

	}



	/**
	 * this  begins the pools commission scheduling
	 */
	public function initiate_pools_commissions()
	{


		$period =  $this->get_period();
		extract($period);




		print_r($payment_date_range);

		$scheduled_commissions = SettlementTracker::where('period', $payment_month)->get();

		echo $total_disagio = $scheduled_commissions->sum('settled_disagio');

		$pools_settings = SiteSettings::pools_settings();


		$pools_settings = array_map(function($step) use ($total_disagio){

			$sharable_total = 0.01 * $step['percent_disagio'] * $total_disagio;
			$step['sharable_total'] =  $sharable_total;

			return $step;

		}, $pools_settings);


		$company_gain = $total_disagio - collect($pools_settings)->sum('sharable_total');

		$dump = [
			'total_disagio' =>  $total_disagio,
			'company_gain' => $company_gain,
			'settings' => $pools_settings,
		];

		print_r($dump);




		$pools_commissions = PoolsCommissionSchedule::updateOrCreate([
															'period' => $payment_month
														],

														[
															'disagio_dump' => json_encode($dump)
														]);
		$this->pay_pools_commission();


	}




	public function pay_pools_commission()
	{
		$period =  $this->get_period();
		extract($period);

		$pools_commissions =  PoolsCommissionSchedule::where('period', $payment_month)->first();

		if ($pools_commissions == null) {
			return;
		}

		$details = json_decode($pools_commissions->disagio_dump, true);

		$month 	 = date('F Y', strtotime($payment_month));


		foreach ($details['settings'] as $key => $pools) {
			print_r($pools);

			 $users = SettlementTracker::where('period', $payment_month)
												 ->where('no_of_merchants', '>=', $pools['min_merchant_recruitment'])
												 ->get();


				if ($users->isEmpty()) {
					continue;
				}

				$no_of_users = $users->count();
				$total_pool = $pools['sharable_total'];

				$per_head =  ($total_pool / $no_of_users);

				$pool_amount  = MIS::money_format($per_head);

					DB::beginTransaction();

					try {
						
						foreach ($users as $key => $user) {

							$comment = "$month {$pools['level']} Bonus";
							LevelIncomeReport::credit_user($user['id'], $pool_amount, $comment , $user['id']);

						}

						DB::commit();

					} catch (Exception $e) {

						print_r($e->getMessage());
						DB::rollback();
						
					}



			echo "<br>";

		}


	}





	/**
	 * This evenetually pays commissions already scheduled.
	 */
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