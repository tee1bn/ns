<?php

use Illuminate\Database\Capsule\Manager as DB;
use v2\Models\Wallet;

use Illuminate\Database\Eloquent\Model as Eloquent;

class SettlementTracker extends Eloquent 
{
	
	protected $fillable = [
		'user_id',
		'user_no',
		'period',
		'dump',
		'settled_disagio',
		'settled_license_fee',
		'no_of_merchants',
		'paid_at'
	];
	

	protected $table = 'settlement_tracker';





	public function user()
	{
		return $this->belongsTo('User', 'user_id');

	}

	public function give_commission()
	{
		$settings= SiteSettings::commission_settings();
		$user 	 = $this->user;

		$month_index = date('m', strtotime($this->period));
		$month 	 = date('F Y', strtotime($this->period));

		$tree = $user->referred_members_uplines(3);

		$disagio = $this->settled_disagio;
		$license_fee = $this->settled_license_fee;

	
		$credit = [];

		DB::beginTransaction();

		echo "string";

		try {
			

			foreach ($tree as $level => $upline) {

				$amount_earned = $settings[$level]['disagio'] * 0.01 * $disagio;
				$comment = "{$month} Disagio Bonus";

				if ($level == 0) {
					$comment = "{$month} Disagio Self Bonus";
				}

							// ensure  upliner is qualified for commission
				if (! $upline->is_qualified_for_commission($level)) {
					continue;
				}



				$paid_at = date("Y-m-d H:i:s");
				$identifier = "disagio{$upline->id}$this->user_id/$this->period";
				$extra = json_encode([
					'period' => $this->period
				]);

				try {
					

					$credit['disagio'][]   = Wallet::createTransaction(	
												'credit',
												$upline['id'],
												$this->user_id,
												$amount_earned,
												'completed',
												'disagio',
												$comment ,
												$identifier, 
												$this->id , 
												null,
												$extra,
												$paid_at
											);

				} catch (Exception $e) {
					
				}



				$amount_earned = $settings[$level]['license'] * 0.01 * $license_fee;
				$comment = "{$month} License Bonus";

				if ($level == 0) {
					$comment = "{$month} License Self Bonus";
				}

				// ensure  upliner is qualified for commission
				if (! $upline->is_qualified_for_commission($level)) {
					continue;
				}

				$identifier = "license{$upline->id}$this->user_id/$this->period";
				$extra = json_encode([
					'period' => $this->period
				]);


				try {
					

					$credit['license'][]  = Wallet::createTransaction(	
												'credit',
												$upline['id'],
												$this->user_id,
												$amount_earned,
												'completed',
												'license',
												$comment ,
												$identifier, 
												$this->id , 
												null,
												$extra,
												$paid_at
											);

				} catch (Exception $e) {
					
				}


			}

			$this->mark_paid();
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			print_r($e->getMessage());
			
		}


	}


	public function mark_paid()
	{
		$this->update(['paid_at' => date("Y-m-d H:i:s")]);
	}

	public function getPeriodDaterangeAttribute()
	{
		return MIS::date_range($this->period);
	}


}


















?>