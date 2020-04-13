<?php

namespace v2\Models;
use v2\Models\Wallet;
use v2\Models\Commission;
use v2\Models\HotWallet;
use v2\Models\HeldCoin;
use v2\Models\PayoutWallet;
use  Filters\Traits\Filterable;
use Illuminate\Database\Capsule\Manager as DB;

use SiteSettings, MIS;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Withdrawal extends Eloquent 
{
	use Filterable;
	
	protected $fillable = [
		'user_id',
		'amount',
		'fee',
		'withdrawal_method_id',
		'method_details',
		'details',
		'admin_id',
		'completed_at',
		'status'
	];
	
	protected $table = 'users_withdrawals';


	public static $statuses = [
							'pending'=> 'pending',
							'completed'=> 'completed',
							 'cancelled'=> 'cancelled'
							];





	public static function payoutBalanceFor($user_id)
	{


		$rules_settings =  SiteSettings::find_criteria('site_settings');
		$setting = $rules_settings->settingsArray;
		$withdrawal_fee = 0;
		$min_withdrawal = $setting['minimum_withdrawal'];

		$total_earnings    =  Wallet::bookBalanceOnUser($user_id);


		 $today = date("Y-m-d");
		$last_month_date = date("Y-m-d", strtotime("first day of last month"));
		$daterange = MIS::date_range($today, 'month', true);
		$last_month_daterange = MIS::date_range($last_month_date, 'month', true);

		$this_month     =      Wallet::for($user_id)->ClearedWithin($daterange)->Credit()->Completed()->sum('amount');
		$last_month     =      Wallet::for($user_id)->ClearedWithin($last_month_daterange)->Credit()->Completed()->sum('amount');


		// $this_month     =      Wallet::select(DB::raw("sum(amount) as total"),'user_id')->ClearedWithin($daterange)->Credit()->Completed()->groupBy('user_id');

	
		$completed_withdrawal = self::where('user_id' , $user_id)->Completed()->sum('amount');
		$pending_withdrawal = self::where('user_id' , $user_id)->Pending()->sum('amount');

/*

		$total_amount_withdrawn = $completed_withdrawal + $pending_withdrawal ;

		$payout_wallet    =  PayoutWallet::bookBalanceOnUser($user_id);

		$payout_balance = $payout_wallet  - $total_amount_withdrawn;

		$payout_book_balance = $payout_wallet  - $completed_withdrawal;

		$available_payout_balance = ($payout_balance >= $min_withdrawal)? $payout_balance: 0 ;
*/

		$state = compact(
			'last_month',
			'this_month',
			'withdrawal_fee',
			'min_withdrawal',
			'total_earnings',
/*			'payout_balance',
			'payout_book_balance',
			'available_payout_balance',
			'completed_withdrawal'
*/		);


		return $state;


	}

	
	

	public function admin()
	{
		return $this->belongsTo('Admin', 'admin_id');

	}
	


	public function getAmountToPayAttribute()
	{
		$payable = $this->amount - $this->fee;
		return $payable;
	}

	public function is_complete()
	{
		return $this->status == 'completed';
	}
	public function scopeCompleted($query)
	{
		return $query->where('status','completed');
	}



	public function scopePending($query)
	{
		return $query->where('status','pending');
	}



	public function scopeDeclined($query)
	{
		return $query->where('status','declined');
	}


	public function getDisplayStatusAttribute()
	{

		switch ($this->status) {
			case 'completed':
			$return = "<span class='badge badge-success'>completed</span>";

			break;
			case 'pending':
			$return = "<span class='badge badge-warning'>pending</span>";

			break;
			case 'declined':
			$return = "<span class='badge badge-danger'>declined</span>";

			break;
			
			default:
				# code...
			break;
		}

		return $return;
	}



	public function getwithdrawalDetailsAttribute()
	{
		$method =  UserWithdrawalMethod::$method_options[$this->withdrawal_method->method];
		$detail = $method['display'];
		$line = '';
		$method_details = json_decode($this->MethodDetailsArray['details'], true);

		foreach ($detail as $key => $label) {
			$value = $method_details[$key];
			$line .= "<li>
						$label:
						$value
					</li>";
		}

		return $line;
	}


	public function getMethodDetailsArrayAttribute()
	{
		if ($this->method_details == null) {
			return [];
		}

		return json_decode($this->method_details, true);
	}



	
	public function user()
	{
		return $this->belongsTo('User', 'user_id');

	}


	
	public function withdrawal_method()
	{
		return $this->belongsTo('v2\Models\UserWithdrawalMethod', 'withdrawal_method_id');

	}



}
?>
