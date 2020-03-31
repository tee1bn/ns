<?php
// error_reporting(E_ERROR | E_PARSE);

use Illuminate\Database\Capsule\Manager as DB;
use v2\Models\Wallet;
use v2\Models\Withdrawal;


/**



*/
class IspUpgradeController extends controller
{

	public function test()
	{
		Withdrawal::payoutBalanceFor(43);

		
	}


	public function update_expires_at()
	{
		$subscriptions = SubscriptionOrder::Paid()->get();
		foreach ($subscriptions as $key => $subscription) {

			$subscription->update(['expires_at' => $subscription->ExpiryDate]);
		}
	}


	public function transfer_wallet()
	{

		$earnings =  LevelIncomeReport::all();	
		echo "<pre>";

		// print_r($earnings->toArray());

		foreach ($earnings as $key => $earning) {

				$type = strtolower($earning->status);
				$user_id = ($earning->owner_user_id);
				$upon_user_id = ($earning->downline_id);
				$amount = ($earning->amount_earned);
				$status = 'completed';


				if (strpos(strtolower($earning->commission_type), 'package') !== false) {
					$earning_category = 'package';

				}elseif (strpos(strtolower($earning->commission_type), 'disagio') !== false) {
					$earning_category = 'disagio';

				}elseif (strpos(strtolower($earning->commission_type), 'license') !== false) {
					$earning_category = 'license';
				}else{
					$earning_category=="bonus";
				}

				$comment = $earning->commission_type;
				$paid_at = $earning->created_at;
				$order_id = $earning->order_id;




			Wallet::createTransaction(	
				$type,
				$user_id,
				$upon_user_id,
				$amount,
				$status,
				$earning_category,
				$comment ,
				 null, 
				$order_id , 
				 null,
				null,
				$paid_at
			);

		}

	}


	public function set_users_positions()
	{

		$users = User::all();

		foreach ($users as $user ) {
			$user->setTreesPosition();
		}
		
	}

}
















?>