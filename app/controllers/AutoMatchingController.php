<?php
// error_reporting(E_ERROR | E_PARSE);

use Illuminate\Database\Capsule\Manager as DB;
use v2\Models\ISPWallet;
use v2\Models\Wallet;
use v2\Models\Isp;
use v2\Models\Withdrawal;
use Apis\CoinWayApi;


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

	}



        public function fetch_news()
        {
            $auth = $this->auth();

            $today = date("Y-m-d");
            $pulled_broadcast_ids = Notifications::where('user_id', @$auth->id)->get()->pluck('broadcast_id')->toArray();
            $recent_news =  BroadCast::where('status', 1)->latest()
                                    //  ->whereNotIn('id', $pulled_broadcast_ids)
                                    //  ->whereDate("updated_at", '>=' , $today)
                                     ->get();

                                     
            foreach ($recent_news as $key => $news) {
                        
                        if(in_array($news->id, $pulled_broadcast_ids)){
                            continue;   
                        }

                $url = "user/notifications";
                $short_message = substr($news->broadcast_message, 0, 30);
                    Notifications::create_notification(
                                            $auth->id,
                                            $url, 
                                            "Notification", 
                                            $news->broadcast_message, 
                                            $short_message,
                                            null,
                                            $news->id,
                                            $news->created_at
                                            );


            }
        }

    public function prepare_production_month($month=null)
    {

    	if ($month==null) {
    		$this->get_period();
    	}else{

    		$payment_month = $month;

    		$payment_date_range = MIS::date_range($payment_month, 'month', true);
    		$this->period =  compact('payment_month', 'payment_date_range');

    	}

    }



    public function personal_auto_withdrawal($user_id)
    {


    }

    public function automatic_withdrawals_for_production_month($month=null)
    {
    	echo "<Pre>";
    	$this->prepare_production_month($month);


    	// all_users with commissions in prod month with sum greater than 0
    	$settings = $this->all_settings['rules_settings']->settingsArray;
    	$min_withdrawal = $settings['min_withdrawal_usd'];
    	// print_r($settings);
    	
    	print_r($this->period);
		$date_range = $this->period['payment_date_range'];
    	$credits = Wallet::
    					// whereDate('paid_at', '>=' , $date_range['start_date'])
    					  whereDate('paid_at', '<=' , $date_range['end_date'])
    					 ->where('type', 'credit')
    					 ->where('wallet_for_commissions.status', 'completed')
    					 ->select(DB::raw('sum(wallet_for_commissions.amount) as credits'),DB::raw('wallet_for_commissions.user_id'))
    					 ->groupBy('wallet_for_commissions.user_id')
    					 ->having('credits', '>=', $min_withdrawal )
    					 ;


    	$identifier = "{$date_range['start_date']}";
    	$already_created_withdrawals = Withdrawal::whereDate('created_at', '>=' , $date_range['start_date'])
    					 ->whereDate('created_at', '<=' , $date_range['end_date'])
    					 ->where('identifier', 'like', "%$identifier%")
    					 ;


		print_r($already_created_withdrawals->get()->toArray());


		$people_to_pay = $credits->leftJoinSub($already_created_withdrawals, 'already_created_withdrawals', function($join){
			$join->on('already_created_withdrawals.user_id', '=', 'wallet_for_commissions.user_id');
		})
		->where('already_created_withdrawals.amount', '=', NULL)

		->take(50);


		print_r($people_to_pay->get()->toArray());


		$all_users_ids  =  $people_to_pay->get()->pluck('user_id')->toArray();
		$users_being_paid = User::whereIn('id', $all_users_ids)->get()->keyBy('id');


		echo $payout =  Wallet::availableBalanceOnUser(1, null, $date_range['end_date']);
       		$balances = Withdrawal::payoutBalanceFor(1, $date_range['end_date']);

       		print_r($balances);

		$withdrawal_fee_percent = $settings['withdrawal_fee'];

		print_r($date_range);

		echo $created_at = "{$date_range['start_date']} 00:00:00";
    	foreach ($people_to_pay->get() as $key => $payment) {
    		//log withdrawals request 	
    		print_r($payment['user_id']);

       		$balances = Withdrawal::payoutBalanceFor($payment['user_id'], $date_range['end_date']);


    		$user = $users_being_paid[$payment['user_id']];
    		$method_details = $user->company->iban_number;
    		$identifier = "{$payment['user_id']}_{$date_range['start_date']}";


    		//ensure user can withdraw;
    		$available_payout_balance = round($balances['available_payout_balance'], 2);
       		$fee = $available_payout_balance * 0.01 * $withdrawal_fee_percent;

    		if ($available_payout_balance < $min_withdrawal) {
    			continue;
    		}
    		print_r($date_range);
    		print_r($balances);

    		DB::beginTransaction();

    		try {

    		 echo   $withdrawal = Withdrawal::create([
    		        'user_id' => $payment['user_id'],
    		        'withdrawal_method_id' => NULL,
    		        'amount' => $available_payout_balance,
    		        'method_details' => json_encode(['iban'=>$method_details]),
    		        'fee' => $fee,
    		        'identifier' => $identifier,
    		        'created_at' => $created_at,
    		    ]);

    		    DB::commit();
    		} catch (Exception $e) {
    			print_r($e->getMessage());
    		    DB::rollback();
    		}


    		


    	}

    	// print_r($credits->get()->toArray());
    }

	public function begin_commission($month=null)
	{

	   	$this->prepare_production_month($month);



		$this->schedule_due_commissions();

		if ($this->settings['distribute_commissions']== 1) {
		}else{
			echo "not yet set b admin";
		}

	}



	public function distribute_setup_fee_commissions($month=null)
	{
    	$this->prepare_production_month($month);


		echo "<pre>";
		print_r($this->period);

		//check
		
		$unpaid = SettlementTracker::where('setup_fee_commission_distributed_at', null)->where('setup_fee','!=', null);
		$users = User::query();

		$unpaid_users = $unpaid->joinSub($users, 'users', function($join){
			$join->on('users.id', '=', 'settlement_tracker.user_id');
		})->take(100)->get();



		foreach ($unpaid_users as $key => $settlement) {
			$settlement->give_setup_fee_commission();
		}

	}


	public function auth_cron()
	{
	    $auth = $this->auth();
	    if (!$auth) {
	        return;
	    }

	    $this->fetch_news();

	    $user_id = $auth->id;
	    $this->cron($user_id);
	}


	public function cron($user_id)
	{
	    $this->coinage_on($user_id);
	}

	//settle isp coins earned for all users -needs cron
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

	//settle isp coins earned for set user_id
	public function coinage_on($user_id, $month=null){
		$user = User::find($user_id);

		$coinage_on = new Isp;
		$coinage_on->setUser($user)->setMonth($month)->doCheck();
		
	}



	public function get_date_to_start_schedule()
	{


		$last_settlement = SettlementTracker::where('paid_at','!=', null)->latest()->first();
		$last_settlement_date = $last_settlement->period ??  '2019-08-01';




		$pools_settlement =  IspPoolsSchedule::where('paid_at','!=', null)->where('period',$last_settlement_date)->first();

		if ($pools_settlement != null) {

			$date = date("Y-m-01", strtotime("+1 month $last_settlement_date"));

		}else{

			$date =  $last_settlement_date;
		}


			$last_settlement_month = date("Y-m", strtotime($last_settlement_date));
			$this_month  = date("Y-m");

			if ($last_settlement_month >= $this_month ) {

				$date = date("Y-m-01", strtotime("-1 month"));
			}

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

		// print_r($period);

		//user_ids of already scheduled commisssions
		$scheduled_commissions = SettlementTracker::where('period', $payment_month);


		// connect with API
		$query_string = http_build_query([
			'from' 	=> $payment_date_range['start_date'],
			'to' 	=> $payment_date_range['end_date'],
			'$top' => 2,
			'$skip' => 0
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
				'$top' 	=> $per_page,
				'$skip' => $skip
			]);

			

				echo $url = "{$this->url}?$query_string";

				$response = collect(json_decode( MIS::make_get($url, $this->header) , true));

				
				$record = collect($response['value'])->keyBy('supervisorNumber')->toArray();
				$supervisor_numbers =  collect($record)->pluck('supervisorNumber')->toArray();


				//ensure there is more commissions to schedule

				$this->treat_supervisors_commissions($record , $supervisor_numbers, $payment_month);
/*
		
				print_r($supervisors_to_be_treated);
				print_r($supervisor_numbers);
				print_r($record);
				print_r($response->toArray());*/
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


	//needs cron
	//this adds the set up fee total in the settlement tracker for each user
	public function include_setup_fee_on_scheduled()
	{
		$period =  $this->period;

		extract($period);
		extract($payment_date_range);


		$scheduled_commissions_without_setup_fee = SettlementTracker::where('period', $payment_month)
		->where('setup_fee', null)
		->where('user_id', '!=', null)
		->take(100)->get();

		$coin_way = new CoinWayApi;


		foreach ($scheduled_commissions_without_setup_fee as $key => $schedule) {

			$url = "https://api.coinwaypay.com/api/supervisor/accounts";
        
   

            $response = $coin_way
                ->setUrl($url)
                ->connect(['supervisor_number'=> $schedule['user_id'], 
                        ], true)
                ->get_response()->toArray();

            
            $records = collect($response['values']); 


            $column = 'createdAt';
            $records_in_daterange = $records->filter(function($item) use ($start_date, $end_date, $column){
                            return  (strtotime($item[$column]) >= strtotime($start_date)) && (strtotime($item[$column]) <= strtotime($end_date));
                         });


			$setup_fee_for_this_supervisor = $records_in_daterange->sum('setupFee');             

			SettlementTracker::where('period', $payment_month)->where('user_id', $schedule['user_id'])
				 ->update([
				 	'setup_fee' => $setup_fee_for_this_supervisor
				 ]);


		}



	}


	public function initiate_pools_commissions()
	{


		$period =  $this->period;

		extract($period);
		extract($payment_date_range);





		//ensure setup fee is available before proceeding
		$scheduled = SettlementTracker::where('period', $payment_month);
		$setup_fee_not_complete = $scheduled->where('setup_fee', null)->where('user_id','!=', null)->count() > 0;
		if ($setup_fee_not_complete) {
			$this->include_setup_fee_on_scheduled();
			return;
		}


		$scheduled_commissions = SettlementTracker::where('period', $payment_month)->where('user_id','!=', null);
		// print_r($scheduled_commissions->get()->toArray());


		$total_disagio = $scheduled_commissions->sum('settled_disagio');
		
		$total_setup_fee = $scheduled_commissions->sum('setup_fee'); //get from api


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
		// $sharable_total = 90;

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

		$date_range = $this->period['payment_date_range'];
		extract($date_range);

		$users_coins = ISPWallet::whereRaw("(earning_category = 'gold' OR earning_category = 'silber' OR earning_category = 'silber2')")
		// ->whereDate('paid_at','>=',  $start_date)->whereDate('paid_at', '<=',$end_date)
		->Completed()->Cleared();


		$total_coin = $users_coins->sum('amount');

		$users_having_share = $users_coins->selectRaw("sum(amount) as amount, user_id")->groupBy('user_id');



		if ($total_coin == 0) {return; } //nothing share in this pool


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

		 		$paid_at = $this->period['payment_date_range']['end_date'];
		 		$identifier = "ispsilber/$user_id/".$period['payment_month'];
		 		$extra = json_encode([
		 			'period' => $period,
		 			'all_coins' => $coin
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

		$date_range = $this->period['payment_date_range'];
		extract($date_range);

		$users_having_gold = ISPWallet::Completed()->Category('gold')->Cleared()
		// ->whereDate('paid_at','>=',  $start_date)->whereDate('paid_at', '<=',$end_date)
		->with('user');




		$total_gold_coin = $users_having_gold->sum('amount');



		if ($total_gold_coin == 0) {return; } //no gold to share in gold pool



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

		 		$paid_at = $this->period['payment_date_range']['end_date'];
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
	 * This evenetually pays commissions already scheduled.
	 */
	public function pay_commissions()
	{

		////ensure we have total orders by user direct(own)merchants so we can check commission eligibility

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