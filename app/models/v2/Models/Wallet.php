<?php

namespace v2\Models;

include_once 'app/controllers/home.php';
use Illuminate\Database\Capsule\Manager as DB;

use Illuminate\Database\Eloquent\Model as Eloquent;
use SiteSettings, User, Config, Notifications, Session, home;
use v2\Shop\Contracts\OrderInterface;

use  v2\Models\InvestmentPackage;
use  v2\Traits\Wallet as BookRecords;
use  Filters\Traits\Filterable;



/**
This represent
deposit wallet
investment wallet
*/
class Wallet extends Eloquent implements OrderInterface
{
	
	use BookRecords, Filterable;

	protected $fillable = [
		'user_id',
		'order_id',
		'admin_id',
		'upon_user_id',
		'amount',
		'payment_method',
		'payment_details',
		'payment_state',
		'paid_at',
		'type',
		'earning_category',
		'status',
		'identifier',
		'comment',
		'extra_detail'	
	];


	protected $table = 'wallet';


	
	public  static $payment_types = [
		'paypal'=> 'one_time',
		'coinpay'=> 'one_time',
	];

	public static $wallets = [
			'deposit' => [
				'name' => "Deposit Wallet",
				'class' => "v2\Models\Wallet",
				'category' => "deposit"
			],

			'commission' => [
				'name' => "Commission Wallet",
				'class' => "v2\Models\Commission",
				'category' => "commission"
			],

			'investment' => [
				'name' => "Hot Wallet",
				'class' => "v2\Models\Wallet",
				'category' => "investment"
			],


		];


		public static $statuses = [
								'pending'=> 'pending',
								'completed'=> 'completed',
								 'cancelled'=> 'cancelled'
								];


	public function available_wallets($user = null)
	{
		$wallets = self::$wallets;

		if ($user == null) {
			return $wallets;
		}

		foreach ($wallets as $key => $wallet) {
			$class = $wallet['class'];
			$balance = $class::bookBalanceOnUser($user->id, $wallet['category']);
			$wallets[$key]['balance'] = $balance;
		}

		return $wallets;
	}




	
	public function user()
	{
		return $this->belongsTo('User', 'user_id');

	}


	public function getExtraDetailArrayAttribute()
	{
		if ($this->extra_detail == null) {
			return [];
		}

		return json_decode($this->extra_detail, true);
	}




	public function total_qty()
	{
		return 1;
	}



	public function getPriceBreakdownAttribute()
	{
		$percent_vat = 0;
		$tax = 0.01 * $percent_vat * $this->amount;
		$breakdown = [
			'before_tax'=> $this->amount,
			'set_price'=> $this->amount,
			'total_percent_tax'=> $percent_vat,
			'tax'=>  $tax,
			'type'=>  "exclusive",
			'total_payable'=>  $this->amount,
		];

		return $breakdown;
	}


	public function total_tax_inclusive()
	{

		$breakdown = $this->PriceBreakdown;

		$tax = [
			'price_inclusive_of_tax' => $breakdown['total_payable'],
			'price_exclusive_of_tax' => $breakdown['set_price'],
			'total_sum_tax' => $breakdown['tax'],
		];

		return $tax;
	}


	public function total_price()
	{
		return $this->amount;
	}





	public function getTransactionIDAttribute()
	{

		$payment_details = json_decode($this->payment_details,true);
		$method = "{$payment_details['ref']}<br><span class='badge badge-primary'>{$payment_details['gateway']}</span>";

		return $method;
	}



	public function mark_paid()
	{	

		if ($this->is_paid()) {
			Session::putFlash('info', 'Deposit Completed');
			return false;
		}

		DB::beginTransaction();
		try {

			$this->update([
				'paid_at' => date("Y-m-d H:i:s"),
				'status' => 'completed',
			]);


			$currency = Config::currency();
			$url =  "user/scheme";
			$heading = $this->TransactionID."  Deposit";
			$short_message = "See Details of Current Package.";

			$message="Deposit of  $currency $this->amount completed";
			Notifications::create_notification(
				$this->user_id,
				$url, 
				$heading, 
				$message, 
				$short_message
			);
			

			DB::commit();
			Session::putFlash('success', 'Order marked as completed');
			return true;
		} catch (Exception $e) {
			DB::rollback();
			print_r($e->getMessage());
			Session::putFlash('danger', 'Order could not mark as completed');
		}

		return false;
	}



	public function is_paid()
	{

		return (bool) ($this->paid_at != null);
	}




	public function generateOrderID()
	{

		$substr = substr(strval(time()), 7 );
		$order_id = "NSW{$this->id}P{$substr}";

		return $order_id;
	}




	public function getDepositPaymentStatusAttribute()
	{
		if ($this->paid_at != null) {

			$label = '<span class="badge badge-success">Paid</span>';
		}else{
			$label = '<span class="badge badge-danger">Unpaid</span>';
		}

		return $label;
	}


	public function setPayment($payment_method,array $payment_details)
	{


		$this->update([
			'payment_method' => $payment_method,
			'payment_state' => @$payment_details['payment_type'],
			'payment_details' => json_encode($payment_details),
		]);

		return $this;
	}




	public  function create_order($cart)
	{
		extract($cart);
		$new_payment_order = self::create([
			'user_id' 		=> $user_id,
			'amount'   		=> $amount,
			'details'		=> json_encode($payment_plan),
		]);

		return $new_payment_order;
	}






	public static function give_bonus($user_id, $upon_user_id=null)
	{

		$identifier = "$user_id welcome bonus";
		$amount = 500;
		$comment = "welcome bonus";
		try {
			
			$credit  = self::createTransaction(
				'credit',
				$user_id,
				$upon_user_id,
				$amount,
				'pending',
				'bonus',
				$comment,
				$identifier 
			);
			return $credit;
		} catch (Exception $e) {

			print_r($e->getMessage());
			die();
		}


	}





}


















?>