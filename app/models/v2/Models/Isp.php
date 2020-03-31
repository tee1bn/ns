<?php


namespace v2\Models;
use SiteSettings,SubscriptionOrder;

class Isp
{

	private $user;
	private $isp_setting;

	private $coins = [];

	public function __construct()
	{

		$this->isp_setting = SiteSettings::find_criteria('isp')->settingsArray;


		print_r($this->isp_setting);

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


	public function doCheck()
	{

		foreach ($this->isp_setting['isp'] as $key => $coin) {

			foreach ($coin['requirement'] as $requirement => $conditions) {

				if(method_exists($this, $requirement)){
					$response[$coin['key']][$requirement] =  (int)	$this->$requirement($conditions);
				}
			}
		}


		print_r($response);
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


	public function step_2($conditions)
	{
		foreach ($conditions as $requirement => $condition) {

			if(method_exists($this, $requirement)){
				$response[$requirement] =  (int) $this->$requirement($condition);
			}
		}


			return false;
	}



	public function step_3($conditions)
	{
/*		echo "step_3";
*//*		print_r($conditions);
*/	}



	public function direct_line($direct_line)
	{
		$response = false;

		$no_direct_line = count($this->user->referred_members_downlines(1, 'placement')[1]);
		if ($no_direct_line >= $direct_line) {
			$response = true;
		}


		return $response;
	}

	public function in_direct_active_member($expected_no)
	{
		$response = false;

		$no_indirect_line = $this->user->all_downlines_by_path('placement');

		$today = date("Y-m-d");
		$active_subscriptions = SubscriptionOrder::Paid()->whereDate('expires_at','<' , $today);



        $active_members = $no_indirect_line
                ->joinSub($active_subscriptions, 'active_subscriptions', function ($join) {
                    $join->on('users.id', '=', 'active_subscriptions.user_id');
                }); 

         $no_indirect_active_line =   $active_members->count();

		if ($no_indirect_active_line >= $expected_no) {
			$response = true;
		}

		return $response;
	}


	public function each_x_in_whole_network($chunk)
	{

		$no_in_whole_network = $this->user->all_downlines_by_path('placement')->count();
		$coins_earned = floor($no_in_whole_network / $chunk) ;

		print_r($this->isp_setting);
	}

}


















?>