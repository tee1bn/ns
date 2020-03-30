<?php

namespace v2\Models;
use v2\Models\Wallet;
use v2\Models\Commission;
use v2\Models\HotWallet;
use v2\Models\HeldCoin;
use v2\Models\PayoutWallet;
use  Filters\Traits\Filterable;

use SiteSettings;

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


		$rules_settings =  SiteSettings::find_criteria('rules_settings');
		$setting = $rules_settings->settingsArray;
		$withdrawal_fee = $setting['withdrawal_fee_percent'];
		$min_withdrawal = $setting['min_withdrawal_usd'];


		$commission_balance =  Commission::bookBalanceOnUser($user_id);
		$hot_wallet =  HotWallet::bookBalanceOnUser($user_id);
		$rank_bonus =  HotWallet::bookBalanceOnUser($user_id,'rank');
		$available_hot_wallet =  HotWallet::bookBalanceOnUser($user_id, 'hot_wallet');
		$deposit_balance    =  Wallet::bookBalanceOnUser($user_id, 'deposit');


		$total_earnings = $hot_wallet +  $commission_balance;

		$trucash_exchange = $setting['one_trucash_is_x_usd'];

		$held_wallet = HeldCoin::bookBalanceOnUser($user_id, 'heldcoin');
		$held_wallet_in_trucash = round(($held_wallet / $trucash_exchange), 2);





		$completed_withdrawal = self::where('user_id' , $user_id)->Completed()->sum('amount');
		$pending_withdrawal = self::where('user_id' , $user_id)->Pending()->sum('amount');


		$total_amount_withdrawn = $completed_withdrawal + $pending_withdrawal ;

		$payout_wallet    =  PayoutWallet::bookBalanceOnUser($user_id);

		$payout_balance = $payout_wallet  - $total_amount_withdrawn;

		$payout_book_balance = $payout_wallet  - $completed_withdrawal;

		$available_payout_balance = ($payout_balance >= $min_withdrawal)? $payout_balance: 0 ;





		$state = compact(
			'held_wallet',
			'held_wallet_in_trucash',
			'hot_wallet',
			'available_hot_wallet',
			'withdrawal_fee',
			'min_withdrawal',
			'commission_balance',
			'deposit_balance',
			'total_earnings',
			'trucash_exchange',
			'payout_balance',
			'payout_book_balance',
			'available_payout_balance',
			'rank_bonus',
			'completed_withdrawal'
		);

		return $state;


	}

	public static function payoutBalanceForold($user_id)
	{


		$rules_settings =  SiteSettings::find_criteria('rules_settings');
		$setting = $rules_settings->settingsArray;
		$withdrawal_fee = $setting['withdrawal_fee_percent'];
		$min_withdrawal = $setting['min_withdrawal_usd'];


		$commission_balance =  Commission::bookBalanceOnUser($user_id);
		$investment_balance =  Wallet::bookBalanceOnUser($user_id, 'investment');
		$deposit_balance    =  Wallet::bookBalanceOnUser($user_id, 'deposit');



		$total_earnings = $commission_balance + $investment_balance;

		$total_earnings_split_for_cash = $setting['income_split_percent']['cash_percent'] * 0.01 * $total_earnings ;
		$total_earnings_split_for_trucash = $setting['income_split_percent']['trucash_percent'] * 0.01 * $total_earnings ;


		$investment_hot_wallet =  $setting['income_split_percent']['cash_percent'] * 0.01 * $investment_balance ;
		$commission_hot_wallet =  $setting['income_split_percent']['cash_percent'] * 0.01 * $commission_balance ;

		$hot_wallet = $investment_hot_wallet ;

		$trucash_exchange = $setting['one_trucash_is_x_usd'];


		$investment_held_wallet =  $setting['income_split_percent']['trucash_percent'] * 0.01 * $investment_balance ;
		$commission_held_wallet =  $setting['income_split_percent']['trucash_percent'] * 0.01 * $commission_balance ;

		$held_wallet = $investment_held_wallet + $commission_held_wallet;
		$held_wallet_in_trucash = round(($held_wallet / $trucash_exchange), 2);





		$trucash_equivalent_of_split_for_trucash = round(($total_earnings_split_for_trucash / $trucash_exchange), 2);

		$completed_withdrawal = self::where('user_id' , $user_id)->Completed()->sum('amount');
		$pending_withdrawal = self::where('user_id' , $user_id)->Pending()->sum('amount');


		$total_amount_withdrawn = $completed_withdrawal + $pending_withdrawal ;


		$payout_balance = $deposit_balance + $total_earnings_split_for_cash - $total_amount_withdrawn;

		$payout_book_balance = $deposit_balance + $total_earnings_split_for_cash - $completed_withdrawal;

		$available_payout_balance = ($payout_balance >= $min_withdrawal)? $payout_balance: 0 ;



/*

		echo "commission_balance: $commission_balance <br>";
		echo "investment_balance: $investment_balance <br>";
		echo "deposit_balance: $deposit_balance <br>";
		echo "total_earnings: $total_earnings <br>";
		echo "cash_percent % of total_earnings: $total_earnings_split_for_cash <br>";
		echo "trucash_percent % of total_earnings: $total_earnings_split_for_trucash <br>";*/

		$state = compact(
			'held_wallet',
			'held_wallet_in_trucash',
			'hot_wallet',
			'withdrawal_fee',
			'min_withdrawal',
			'commission_balance',
			'investment_balance',
			'deposit_balance',
			'total_earnings',
			'total_earnings_split_for_cash',
			'total_earnings_split_for_trucash',
			'trucash_exchange',
			'trucash_equivalent_of_split_for_trucash',
			'payout_balance',
			'payout_book_balance',
			'available_payout_balance',
		);

		return $state;
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
