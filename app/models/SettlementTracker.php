<?php

use Illuminate\Database\Capsule\Manager as DB;

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

	public function give_commission($disagio=null, $license_fee =null)
	{
		$settings= SiteSettings::commission_settings();
		$user 	 = $this->user;

		$month_index = date('m', strtotime($this->period));
		$month 	 = date('F Y', strtotime($this->period));

		$tree = $user->referred_members_uplines(3);


		 if ($disagio == null) {
			 $disagio = $this->settled_disagio;
		 }

		 if ($license_fee == null) {
			 $license_fee = $this->settled_license_fee;
		 }
		 
		 $credit = [];

		 DB::beginTransaction();


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

							$credit['disagio'][]  = LevelIncomeReport::credit_user($upline['id'], $amount_earned, $comment , $upline->id, $this->id, $this->period);



				 		     $amount_earned = $settings[$level]['license'] * 0.01 * $license_fee;
							 $comment = "{$month} License Bonus";

							 if ($level == 0) {
								 $comment = "{$month} License Self Bonus";
							 }

							// ensure  upliner is qualified for commission
							if (! $upline->is_qualified_for_commission($level)) {
									continue;
							}

						$credit['license'][]  = LevelIncomeReport::credit_user($upline['id'], $amount_earned, $comment , $upline->id, $this->id, $this->period);
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