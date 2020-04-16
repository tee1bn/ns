<?php


namespace v2\Models;
use SiteSettings,SubscriptionOrder;
use v2\Models\ISPWallet;
use MIS;
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


		$this->month = date("Y-m");
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



			if ($gold['step_1'] == 1) { //user qualify to receive gold

				//delete all existing gold coins


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
					null,
					$paid_at
				);


			}else{ //user should get pending gold coin

				// $amount = 
				
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
					null,
					$paid_at
				);
			}

			//delete all pending or entitled coins
			// ISPWallet::for($this->user->id)->Category('silber')->Pending()->delete();

			//silber
			$silber = $response['silber'];

			$amount = $silber['step_3'] * $isp['silber']['coin_received'];
			$paid_at = date("Y-m-d H:i:s");

			$achieved_network = $silber['step_3'] * $isp['silber']['requirement']['step_3']['each_x_month'];

			$comment = "Silber coin received for reaching $achieved_network months subscription";
			$silber_identifier = $this->user->id."silber$this->month";

			$extra_detail = json_encode([
				'reason'=>'x_month_active_pp'
			]);

			if ($amount > 0) {

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

			}

			//second type of silber coin earning



			$extra_detail = json_encode([
				'reason'=>'second_way'
			]);

			// give new coin update
/*			ISPWallet::createTransaction(	
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
*/


	}

	public function doCheck()
	{

		foreach ($this->isp_setting['isp'] as $key => $coin) {

			foreach ($coin['requirement'] as $requirement => $conditions) {

				if(method_exists($this, $requirement)){
					$response[$coin['key']][$requirement] =  (int)	$this->$requirement($conditions);
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
			return true;
		}

			return false;
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
		$daterange = MIS::daterange($this->month, 'month', true);
		$aleady_paid_coin = ISPWallet::for($this->user->id)->Category('silber')
							->whereDate('paid_at', '<', $daterange['start_date'])
							->Completed()->sum('amount');
		
		$coin_earned_this_month = $multiple_of_coins_earned - $already_paid_coin;							

		// TODO: remove ALREADYEARNED COIN FROM THIS $multiple_of_coins_earned

		return $coin_earned_this_month;

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



	    //call api
		$api_response  = CoinWayApi::api($this->month);
		$own_merchants = $api_response[$this->user->id]['tenantCount'] ?? 0;



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

		$total_merchants = $api_response->whereIn('supervisorNumber', $in_direct_sales_partners_ids)->sum('tenantCount');


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
		$daterange = MIS::daterange($this->month, 'month', true);
		$aleady_paid_coin = ISPWallet::for($this->user->id)->Category('gold')
							->whereDate('paid_at', '<', $daterange['start_date'])
							->Completed()->sum('amount');
		
		$coin_earned_this_month = $multiple_of_coins_earned - $already_paid_coin;							

		// TODO: remove ALREADYEARNED COIN FROM THIS $multiple_of_coins_earned

		return $coin_earned_this_month;
	}

}


















?>