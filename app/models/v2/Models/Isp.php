<?php


namespace v2\Models;
use SiteSettings,SubscriptionOrder;
use v2\Models\ISPWallet;
use MIS, Exception;
use Illuminate\Database\Capsule\Manager as DB;
use Filters\Filters\UserFilter;
use Apis\CoinWayApi;


class Isp
{

	private $user;
	private $isp_setting;

	private $coins = [];
	private $month = "";

	public function __construct()
	{

		$this->isp_setting = SiteSettings::find_criteria('isp')->settingsArray;

	    //call api

		$this->month = date("Y-m");
		$this->api_response  = CoinWayApi::api($this->month);
		// print_r($this->isp_setting);

		// krsort($this->rank_qualifications);
	}


	public function setUser($user)
	{
		$this->user = $user;
		return $this;
	}


	public function __get($property)
	{
		return $this->$property;
	}


	public function interprete($response)
	{
		$isp = collect($this->isp_setting['isp'])->keyBy('key')->toArray();


		print_r($response);

		//gold
		$gold = $response['gold'];

		$amount = $gold['step_2'] * $isp['gold']['coin_received'];
		$each_x_in_whole_network = $isp['gold']['requirement']['step_2']['each_x_in_whole_network'];

		$achieved_network = $gold['step_2'] * $each_x_in_whole_network;
		$comment = "Gold coin received for reaching $achieved_network in network";
		$paid_at = date("Y-m-d H:i:s");

		//delete all pending or entitled coins
		// ISPWallet::for($this->user->id)->Category('gold')->Pending()->delete();

		$gold_identifier = $this->user->id."gold/$this->month";

		$extra_detail = json_encode([
			'reason'=>'gold_term'
		]);



			if ($gold['step_1'] == 1) { //user qualify to receive gold

				//delete all existing gold coins

				try {
					
					// give new coin update
					ISPWallet::createTransaction(	
						'credit',
						$this->user->id,
						null,
						$amount,
						'completed',
						'gold',
						$comment ,
						$gold_identifier, 
						null , 
						null,
						$extra_detail,
						$paid_at
					);

				} catch (Exception $e) {
					
				}

			}else{ //user should get pending gold coin
				// $amount = 
				try {
						
					ISPWallet::createTransaction(	
						'credit',
						$this->user->id,
						null,
						$amount,
						'pending',
						'gold',
						$comment ,
						$gold_identifier, 
						null , 
						null,
						$extra_detail,
						$paid_at
					);
				} catch (Exception $e) {
						
						// print($e->getMessage());
				}
			}

			//delete all pending or entitled coins
			// ISPWallet::for($this->user->id)->Category('silber')->Pending()->delete();

			//silber
			$silber = $response['silber'];

			$amount = $silber['step_3'] * $isp['silber']['coin_received'];
			$paid_at = date("Y-m-d H:i:s");

			$achieved_network = $silber['step_3'] * $isp['silber']['requirement']['step_3']['each_x_month'];

			$comment = "Silber coin received for reaching $achieved_network months subscription";
			$silber_identifier = $this->user->id."silber_step_3$this->month";

			$extra_detail = json_encode([
				'reason'=>'x_month_active_pp'
			]);

			if ($amount > 0) {

				try {
					

				// give new coin update
				ISPWallet::createTransaction(	
					'credit',
					$this->user->id,
					null,
					$amount,
					'completed',
					'silber',
					$comment ,
					$silber_identifier, 
					null , 
					null,
					$extra_detail,
					$paid_at
				);

				} catch (Exception $e) {
					
				}
			}

			//second type of silber coin earning



			$extra_detail = json_encode([
				'reason'=>'second_way_step_4'
			]);

			$amount = $silber['step_4']['multiple_of_coins_earned'] * $isp['silber']['coin_received'];
			$silber_identifier = $this->user->id."silber_step_4$this->month";

			$no_of_direct_paid_line = $silber['step_4']['no_of_direct_paid_line'];
			$no_of_direct_paid_line = $silber['step_4']['no_of_direct_paid_line'];



$comment = <<<ELO
 	"Silber coin received for having $no_of_direct_paid_line direct paid lines and for 
 	 $no_of_direct_paid_line active direct merchant connection";
ELO;

echo "$comment";

			if ($silber['step_4']['no_of_direct_paid_line'] == 1) {

				try {
					
					// give new coin update
					ISPWallet::createTransaction(	
						'credit',
						$this->user->id,
						null,
						$amount,
						'completed',
						'silber',
						$comment ,
						$silber_identifier, 
						null , 
						null,
						$extra_detail,
						$paid_at
					);
				} catch (Exception $e) {
					
				}

			}else{

				try {
									
				// give new coin update
				ISPWallet::createTransaction(	
					'credit',
					$this->user->id,
					null,
					$amount,
					'pending',
					'silber',
					$comment ,
					$silber_identifier, 
					null , 
					null,
					$extra_detail,
					$paid_at
				);
			} catch (Exception $e) {
				
			}				
	

			}


	}

	public function doCheck()
	{

		foreach ($this->isp_setting['isp'] as $key => $coin) {

			foreach ($coin['requirement'] as $requirement => $conditions) {

				if(method_exists($this, $requirement)){
					$response[$coin['key']][$requirement] =  	$this->$requirement($conditions);
				}
			}

		}


		$this->interprete($response);
	}

	//ensure this user direct_line and in_direct_active_member is met
	public function step_1($conditions)
	{

		foreach ($conditions as $requirement => $condition) {

			if(method_exists($this, $requirement)){
				$response[$requirement] =  (int) $this->$requirement($condition);
			}
		}

		if (array_sum($response) == count($response)) {
			return 1;
		}

		 return 0;
	}


	//determine multiple of set coins to receive
	public function step_2($conditions)
	{
		foreach ($conditions as $requirement => $condition) {

			if(method_exists($this, $requirement)){
				$response[$requirement] =  (int) $this->$requirement($condition);
			}
		}

		return $response['each_x_in_whole_network'];
	}


	//determine coins by length of package subscription
	public function step_3($conditions)
	{

		//for silber isp

		$no_of_month = SubscriptionOrder::Paid()
						->where('user_id', $this->user->id)
						->where('plan_id', '>=', $conditions['of_x_package_id'])
						// ->where('no_of_month', '>=', $conditions['each_x_month'])
						->sum('no_of_month');
		
		$multiple_of_coins_earned = floor($no_of_month / $conditions['each_x_month']) ;

		//silber_coin already earned 

		//get daterange for this month
		$daterange = MIS::date_range($this->month, 'month', true);
		$already_paid_coin = ISPWallet::for($this->user->id)->Category('silber')
							->whereDate('paid_at', '<', $daterange['start_date'])
							->Completed()->sum('amount');
		
		$coin_earned_this_month = $multiple_of_coins_earned - $already_paid_coin;							

		// TODO: remove ALREADYEARNED COIN FROM THIS $multiple_of_coins_earned

		return $coin_earned_this_month;

	}



	/**
	if the sales agent has 5 direct paid advanced or professionals and 5 active direct merchants 
		than the user get also a silver coin. if 10 /10 then he gets 2 if 15/15 he gets 3 and so on.
	*/
	public function step_4($content)
	{

		$paid_packages = explode(",", $content['direct_paid_packages']);


		//indirect_lines
		$direct_line = $this->user->all_downlines_by_path('placement', false)->where('referred_by', $this->user->mlm_id);


		//get those with active subscription
		$today = date("Y-m-01");
		$active_subscriptions = SubscriptionOrder::Paid()->whereDate('expires_at','<' , $today);
        $active_members = $direct_line
                ->joinSub($active_subscriptions, 'active_subscriptions', function ($join) {
                    $join->on('users.id', '=', 'active_subscriptions.user_id');
                }); 



        if ($active_members->count() >= $content['no_of_direct_paid_line']) {

        	$no_of_direct_paid_line = 1;
        }else{

        	$no_of_direct_paid_line = 0;
        }


        //no of direct merchants

         //get ids
        $direct_sales_partners_ids = $active_members->get()->pluck('id')->toArray();
		$total_direct_merchants = $this->api_response->whereIn('supervisorNumber', $direct_sales_partners_ids)->sum('tenantCount');



		$multiple_of_coins_earned = floor($total_direct_merchants / $content['each_x_active_direct_merchant']) ;



        $result = compact('no_of_direct_paid_line','multiple_of_coins_earned');

		print_r($result);
		
		return $result;
	}



	public function direct_line($direct_line)
	{
		$response = false;

		$downline = $this->user->referred_members_downlines(1, 'placement');

		if (isset($downline[1])) {

			$no_direct_line = count($downline[1]);
		}else{

			$no_direct_line = 0;
		}


		if ($no_direct_line >= $direct_line) {
			$response = true;
		}


		return $response;
	}


	//this is actually indirect_active_merchants
	public function in_direct_active_merchants($expected_no)
	{
		$response = false;

		$sieve = ['month'=> $this->month];

	    // $filter = new  UserFilter($sieve);



		$own_merchants = $this->api_response[$this->user->id]['tenantCount'] ?? 0;



		//indirect_lines
		$no_indirect_line = $this->user->all_downlines_by_path('placement', false);


		//get those with active subscription
		$today = date("Y-m-01");
		$active_subscriptions = SubscriptionOrder::Paid()->whereDate('expires_at','<' , $today);
        $active_members = $no_indirect_line
                ->joinSub($active_subscriptions, 'active_subscriptions', function ($join) {
                    $join->on('users.id', '=', 'active_subscriptions.user_id');
                }); 

         //get ids
        $in_direct_sales_partners_ids = $active_members->get()->pluck('id')->toArray();

		$total_merchants = $this->api_response->whereIn('supervisorNumber', $in_direct_sales_partners_ids)->sum('tenantCount');


         $no_indirect_active_merchants =   $total_merchants;


		if ($no_indirect_active_merchants >= $expected_no) {
			$response = true;
		}

		return $response;
	}


	public function each_x_in_whole_network($chunk)
	{
		//for gold isp

		$sieve = ['month'=> $this->month];

		$no_in_whole_network = $this->user->all_downlines_by_path('placement', false)->count();
		$multiple_of_coins_earned = floor($no_in_whole_network / $chunk) ;


		//get daterange for this month
		$daterange = MIS::date_range($this->month, 'month', true);
		$already_paid_coin = ISPWallet::for($this->user->id)->Category('gold')
							->whereDate('paid_at', '<', $daterange['start_date'])
							->Completed()->sum('amount');
		
		$coin_earned_this_month = $multiple_of_coins_earned - $already_paid_coin;							

		// TODO: remove ALREADYEARNED COIN FROM THIS $multiple_of_coins_earned

		return $coin_earned_this_month;
	}

}


















?>