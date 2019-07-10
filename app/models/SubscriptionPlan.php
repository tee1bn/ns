<?php


use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as DB;


class SubscriptionPlan extends Eloquent 
{
	
	protected $fillable = [
							'package_type',
							 'price' ,
							 'hierarchy' ,
							 'percent_off' ,
							 'fund_source' ,
							'features',
							'availability',
							'confirmation_message',
							'created_at'
						];
	
	protected $table = 'subscription_plans';



	public static function fund_sources()
	{
		return ['cash', 'website'];


	}


	public function get_action()
	{
		$domain = Config::domain();
		$action = "";

		switch ($this->fund_source) {
			case 'website':
					$action = "$domain/user/create_secret_upgrade_request/{$this->id}";
					$function = "complete_secret_upgrade";
				break;
			
			case 'cash':
					$action = "$domain/user/create_upgrade_request/{$this->id}";
					$function = "complete_upgrade";
				break;
			
			default:
				# code...
				break;
		}

		return compact('action','function');
	}

	public static function buyable_with($cost)
	{
		$all_prices =  self::available()->get()->pluck('price')->toArray();
		$all_prices[] = $cost;
		rsort($all_prices);
		$price = $all_prices[1];

		return self::where('price', $price)->where('availability', on)->first();


	}






	public static function create_secret_subscription_request($subscription_id, $user_id)
	{
			$user  			= User::find($user_id);
			$previous_sub 	= self::find($user->account_plan);
			$new_sub 		= self::find($subscription_id);


			$cost 	=  ($previous_sub->price ==null) ?  $new_sub->price  : ($new_sub->price - (int)$previous_sub->price) ;
            $balance = $user->available_balance();


			$previous_hierachy = ($previous_sub->hierarchy != null) ? $previous_sub->hierarchy : $new_sub->hierarchy ;


			DB::beginTransaction();

			try {
				

					//ensure this is not downgrade
				if ($new_sub->hierarchy  > $previous_hierachy  ) {

					Session::putFlash('danger', "You cannot downgrade your subscription to {$new_sub->package_type}.");

						return;					
				}



				if ($cost > $balance) {
					Session::putFlash('danger', "This scheme unlocks only by commission earned by referring people. 
						Right now you have insufficient balance. Earn more by referring to unlock <b> {$new_sub->package_type}</b>.");
					return;
				}



				$new_order =  SubscriptionOrder::create_order($subscription_id, $user_id, $cost);
				$new_order->mark_as_paid();



				$debit =LevelIncomeReport::create_withdrawal_request($user->id, $cost, "{$new_sub->package_type} Upgrade" );
				$debit->mark_withdrawal_paid();

				DB::commit();
				Session::putFlash('success', 
					"CONGRATULATIONS!! You now own the secret MLM Scheme {$new_sub->package_type}.");
			return $new_order;
		} catch (Exception $e) {
			DB::rollback();
			print_r($e->getMessage());
		}



	}


	public static function create_subscription_request($subscription_id, $user_id)
	{	


			$month = date('m');



		DB::beginTransaction();

		try {


			$existing_requests = SubscriptionOrder::where('user_id', $user_id)
												// ->whereMonth('created_at', $month )
												->where('plan_id', $subscription_id)
												->get();

			$user  			= User::find($user_id);
			$previous_sub 	= self::find($user->account_plan);
			$new_sub 		= self::find($subscription_id);


			$cost 	=  ($previous_sub->price ==null) ?  $new_sub->price  : ($new_sub->price - (int)$previous_sub->price) ;


		


			$previous_hierachy = ($previous_sub->hierarchy != null) ? $previous_sub->hierarchy : $new_sub->hierarchy ;


					//ensure this is not downgrade
				if ($new_sub->hierarchy  > $previous_hierachy  ) {

					Session::putFlash('danger', 
						"You cannot downgrade your subscription to {$new_sub->package_type}.");
					throw new Exception("Error Processing Request", 1);

				}

					//ensure no request is existing for the month
					//ie one subscription per calendar month
				if ($existing_requests->count() > 0) {
						$month = date('F');
						Session::putFlash('info', 
							"You already have a request on {$new_sub->package_type}");
						// throw new Exception("You already have a request on {$new_sub->package_type}", 1);

						return $existing_requests->first();

				}


			//if user has enough balance, put on subscription
			if (false) {


			}else{
				//create subscription request
				if (SubscriptionOrder::user_has_pending_order($user_id, $new_sub->id)) {
					Session::putFlash('danger', 
						"You have pending order for {$new_sub->package_type}.");
					throw new Exception("You have pending order for {$new_sub->package_type}.", 1);
				}

				$new_order =  SubscriptionOrder::create_order($subscription_id, $user_id, $cost);
			}

			DB::commit();
				Session::putFlash('success', 
					"Order for {$new_sub->package_type} created successfully.");
			return $new_order;
		} catch (Exception $e) {
			DB::rollback();
			print_r($e->getMessage());
		}

		return false;
	}

	public function is_available()
	{
		return (bool) ($this->availability =='on');
	}



	public function available()
	{
		return self::where('availability', 'on');
	}

	public function getfeatureslistAttribute()
	{
		return explode(',', $this->features);
	}


}


















?>