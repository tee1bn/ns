<?php
// error_reporting(E_ERROR | E_PARSE);

use Illuminate\Database\Capsule\Manager as DB;
use v2\Models\ISPWallet;
use v2\Models\Wallet;
use v2\Models\Isp;


/**



*/
class AutoMatchingController extends controller
{

	public $settings;
	public $url;
	public $api_key;
	public $header;
	public $period;

	public $all_settings;


	public function __construct()
	{

		$this->all_settings = SiteSettings::all()->keyBy('criteria');
		$this->settings = $this->all_settings['site_settings']->settingsArray;


		$this->url = "https://api.coinwaypay.com/api/supervisor/turnover";
		$this->api_key = $this->settings['coinway_sales_api_key'];

		$this->header = [
			$this->api_key
		];

		$this->get_period();



		if ($this->settings['distribute_commissions']== 1) {
			$this->schedule_due_commissions();
		}else{
			echo "not yet set b admin";
		}


		echo "<pre>";

	}



	public function coinage_on_all(){

		$users = User::query();

		$paid_coins = "";

		$date_range = $this->period['payment_date_range'];

		$paid_coins = 	ISPWallet::whereDate('paid_at', '>=' , $date_range['start_date'])->whereDate('paid_at', '<=' , $date_range['end_date']);

        $not_paid_users_sql = $users
                ->leftJoinSub($paid_coins, 'paid_coins', function ($join) {
                    $join->on('users.id', '=', 'paid_coins.user_id');
                })->where('paid_coins.user_id','=', NULL); 


         $not_paid_users = $not_paid_users_sql->get(['*', 'users.id as id']);

     
		// 
		foreach ($not_paid_users as $key => $user) {
			$coinage_on = new Isp;
			$coinage_on->setUser($user)->doCheck();
		}

	}


	public function coinage_on($user_id){
		$user = User::find($user_id);

		$coinage_on = new Isp;
		$coinage_on->setUser($user)->doCheck();
		
	}



	public function get_date_to_start_schedule()
	{

		$last_settlement = SettlementTracker::where('paid_at','!=', null)->latest()->first();
		$last_settlement_date = $last_settlement->period ??  '2020-04-01';




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

		$this->period =  compact('payment_month', 'payment_date_range');
	}


	/**
	 * { This schedule the commissions due for all participants from disagio ,license and no of merchant }
	 * 
	 */
	public function schedule_due_commissions()
	{	

		$period =  $this->period;
		extract($period);


		//user_ids of already scheduled commisssions
		$scheduled_commissions = SettlementTracker::where('period', $payment_month);


		// connect with API
		$query_string = http_build_query([
			'from' 	=> $payment_date_range['start_date'],
			'to' 	=> $payment_date_range['end_date'],
			'top' => 2,
			'skip' => 0
		]);

		$url = "{$this->url}?$query_string";

		$response = json_decode( MIS::make_get($url, $this->header) , true);

		$total_no = $response['totalCount'];




		if ($scheduled_commissions->count() == $total_no) {

			echo "begin pools";
			$this->pay_commissions();	

			//schedule pools commission if regular commission is complete
			$this->initiate_pools_commissions();	
			return;
			
		}




		// print_r($scheduled_commissions->toArray());




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

			

				echo $url = "{$this->url}?$query_string";

				$response = collect(json_decode( MIS::make_get($url, $this->header) , true));

				
				$record = collect($response['value'])->keyBy('supervisorNumber')->toArray();
				$supervisor_numbers =  collect($record)->pluck('supervisorNumber')->toArray();


				//ensure there is more commissions to schedule

				$this->treat_supervisors_commissions($record , $supervisor_numbers, $payment_month);

		
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


			$already_settled_user_ids = SettlementTracker::where('period', $payment_month)->get(['user_id'])->pluck('user_id')->toArray();

			foreach ($supervisor_ids as $id => $supervisor_id) {

				if (in_array($supervisor_id, $already_settled_user_ids)) {continue;}

				$commissions = $records_from_api[$supervisor_id];

				try {
					

						$settlement[] =	SettlementTracker::create([
								'user_id'	=> $supervisor_id,
								'user_no'	=> $supervisor_id,	
								'period'	=> $payment_month,
								'dump'		=> json_encode($commissions),
								'settled_disagio' => $commissions['sumDisagio'],
								'no_of_merchants' => $commissions['tenantCount'],
								'settled_license_fee' =>  $commissions['licenseSum']
							]);

				} catch (Exception $e) {
					
				}

			}

	}



	public function initiate_pools_commissions()
	{


		$period =  $this->period;

		extract($period);
		extract($payment_date_range);



		$scheduled_commissions = SettlementTracker::where('period', $payment_month);

		$total_disagio = $scheduled_commissions->sum('settled_disagio');
		$total_setup_fee = $scheduled_commissions->sum('settled_license_fee'); //get from api


		$isp_settings = $this->all_settings['isp']->settingsArray;
		$isp_make_up = $isp_settings['isp_make_up'];


		$isp_disagio = $isp_make_up['percent_of_disagio'] * 0.01 * $total_disagio;
		$isp_setupfee = $isp_make_up['percent_of_setup_fee'] * 0.01 * $total_setup_fee;


		$total_package_sales = SubscriptionOrder::whereDate('paid_at','>=',  $start_date)->whereDate('paid_at', '<=',$end_date)->sum('price');

		$isp_package = $isp_make_up['percent_of_all_sales_package'] * 0.01 * $total_package_sales;


		$totals = $total_disagio + $total_setup_fee + $total_package_sales ;

		$sharable_total = $isp_disagio + $isp_setupfee + $isp_package ;

		$company_gain =  $totals - $sharable_total;

		$dump = compact(
			'total_disagio',
			'total_setup_fee',
			'total_package_sales',
			'totals',
			'isp_disagio',
			'isp_setupfee',
			'isp_package',
			'sharable_total',
			'company_gain',
			'isp_settings'
		);

	

		$pools_commissions = IspPoolsSchedule::updateOrCreate([
															'period' => $payment_month
														],

														[
															'dump' => json_encode($dump)
														]);

		$this->pay_pools_commission();

	}






	public function pay_pools_commission()
	{
		$period =  $this->period;
		extract($period);



		$isp =  IspPoolsSchedule::where('period', $payment_month)->first();

		if ($isp == null) {
			return;
		}

		$details = $isp->DumpArray;
		$sharable_total = $details['sharable_total'];
		$sharable_total = 90;

		$isp_coin = collect($details['isp_settings']['isp'])->keyBy('key')->toArray();

		//gold
		$sharable_total_on_gold = $isp_coin['gold']['isp_percent'] * 0.01 * $sharable_total;

		$this->share_gold_pool($sharable_total_on_gold, $period);




		//silber
		$sharable_total_on_silber = $isp_coin['silber']['isp_percent'] * 0.01 * $sharable_total;
		$this->share_silber_pool($sharable_total_on_silber, $period);


		return;

	}

	public function share_silber_pool($sharable_total, $period)
	{
		//find all user on gold or silber

		$users_coins = ISPWallet::whereRaw("earning_category = 'gold' OR earning_category = 'silber'")->Completed()->Cleared();

		$total_coin = $users_coins->sum('amount');

		$users_having_share = $users_coins->selectRaw("sum(amount) as amount, user_id")->groupBy('user_id');



 		$worth_of_coin =  round(($sharable_total / $total_coin), 2);



		foreach ($users_having_share->get() as $key => $coin_holder){
		 		$coin = $coin_holder['amount'];
		 		$payment_month = date("F, Y", strtotime($period['payment_month']));
		 		$comment = "$coin shares From ISP Silber of $payment_month ";

		 		if ($coin_holder['user']['id'] == '') {
		 			continue;
		 		}

		 		$amount = $coin * $worth_of_coin;

		 		$user_id = $coin_holder['user_id'];

		 		$paid_at = date("Y-m-d H:i:s");
		 		$identifier = "ispsilber/$user_id/".$period['payment_month'];
		 		$extra = json_encode([
		 			'period' => $period,
		 			'gold_coins' => $coin
		 		]);

		 		try {
		 			
		 			Wallet::createTransaction(
		 				'credit',
		 				$user_id,
		 				null,
		 				$amount,
		 				'completed',
		 				'silber',
		 				$comment,
		 				$identifier, 
		 				null, 
		 				null,
		 				$extra,
		 				$paid_at 
		 			);

		 		} catch (Exception $e) {
		 			
		 		}



		 }
	}



	public function share_gold_pool($sharable_total, $period)
	{
		//find all user on gold

		$users_having_gold = ISPWallet::Completed()->Category('gold')->Cleared()->with('user');
		$total_gold_coin = $users_having_gold->sum('amount');
 		$worth_of_a_gold =  round(($sharable_total / $total_gold_coin), 2);



		foreach ($users_having_gold->get() as $key => $gold_holder){
		 		$gold = $gold_holder['amount'];
		 		$payment_month = date("F, Y", strtotime($period['payment_month']));
		 		$comment = "$gold shares From ISP Gold of $payment_month ";

		 		if ($gold_holder['user']['id'] == '') {
		 			continue;
		 		}

		 		$amount = $gold * $worth_of_a_gold;

		 		$user_id = $gold_holder['user']['id'];

		 		$paid_at = date("Y-m-d H:i:s");
		 		$identifier = "ispgold/$user_id/".$period['payment_month'];
		 		$extra = json_encode([
		 			'period' => $period,
		 			'gold_coins' => $gold
		 		]);


		 		try {
		 			
		 			Wallet::createTransaction(
		 				'credit',
		 				$user_id,
		 				null,
		 				$amount,
		 				'completed',
		 				'gold',
		 				$comment,
		 				$identifier, 
		 				null, 
		 				null,
		 				$extra,
		 				$paid_at 
		 			);

		 		} catch (Exception $e) {
		 			
		 		}



		 }
	}





	/**
	 * this  begins the pools commission scheduling old
	 */
	public function initiate_pools_commissions_old()
	{


		$period =  $this->period;
		extract($period);




		print_r($payment_date_range);

		$scheduled_commissions = SettlementTracker::where('period', $payment_month)->get();

		echo $total_disagio = $scheduled_commissions->sum('settled_disagio');

		$pools_settings = $this->all_settings['pools_settings']->settingsArray ;


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




	public function pay_pools_commission_old()
	{
		$period =  $this->period;
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

				$pool_amount  = round($per_head, 2);

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
		$unpaid = SettlementTracker::where('paid_at', null);
		$users = User::query();

		$unpaid_users = $unpaid->joinSub($users, 'users', function($join){
			$join->on('users.id', '=', 'settlement_tracker.user_id');
		})->take(100)->get();


		foreach ($unpaid_users as $key => $settlement) {

				$settlement->give_commission();
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