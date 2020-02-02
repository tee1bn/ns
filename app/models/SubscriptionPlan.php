<?php



use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as DB;
use  v2\Shop\Shop;


class SubscriptionPlan extends Eloquent 
{
	
	protected $fillable = [
							'package_type', //name
							 'price' ,
							 'commission_price' , // amount on which commission is calculated
							 'downline_commission_level' ,
							 'get_pool' , //whether user on this package qualify for pools commissions
							 'percent_vat' , //percent of 'price' added to arrive at final cost.
							 'hierarchy' ,
							'features',
							'gateways_ids',
							'availability',
							'confirmation_message',
							'created_at'
						];
	
	protected $table = 'subscription_plans';



	public static function default_sub()
	{
		return self::where('price', 0)->first();
	}

	public function getFinalcostAttribute()
	{
		return (0.01 * $this->percent_vat * $this->price) + $this->price;
	}





	public static function create_subscription_request($subscription_id, $user_id)
	{	

		DB::beginTransaction();

		try {


			$existing_requests = SubscriptionOrder::where('user_id', $user_id)
												->where('plan_id', $subscription_id)
												->get();

			$user  			= User::find($user_id);
			$previous_sub 	= self::find($user->account_plan);
			$new_sub 		= self::find($subscription_id);

			// $cost =  (@$previous_sub->Finalcost ==null) ?  $new_sub->Finalcost  : ($new_sub->Finalcost - (int)$previous_sub->Finalcost) ;
			$previous_price = (@$previous_sub->price != null) ? $previous_sub->price : $new_sub->price ;

					//ensure this is not downgrade
				if ($new_sub->price  < $previous_price  ) {

					Session::putFlash('danger', 
						"You cannot downgrade your subscription to {$new_sub->package_type}.");
						return;
				}

					
				//ensure the same scheme is not ordered twice
                $ordered_ids = $user->subscriptions->where('paid_at', '!=', null)->pluck('plan_id')->toArray();
                if (in_array($new_sub->id, $ordered_ids)) {
                	Session::putFlash('info', "You already purchased {$new_sub->package_type}");
                	return json_encode([]);
                }


			//if user has enough balance, put on subscription
			if (false) {


			}else{
				
				

				//delete unuseful orders
			 	SubscriptionOrder::where('user_id', $user_id)->where('plan_id', '!=', $subscription_id)->where('paid_at',null)->delete();		 	

			 	$plan_id = $subscription_id;
			 	$price = $new_sub->price;
			 	$cart = compact('plan_id','user_id','price');
		 		$shop = new Shop();
		 		$payment_details =	$shop
		 							->setOrderType('packages') //what is being bought
		 							->receiveOrder($cart)
		 							->setPaymentMethod($_POST['payment_method'])
		 							->initializePayment()
		 							->attemptPayment()
		 							;
			}

			DB::commit();
			// $shop->goToGateway();

				Session::putFlash('success', 
					"Order for {$new_sub->package_type} created successfully.");
			return $shop->order;
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



	public static function available()
	{
		return self::where('availability', 'on');
	}

	public function getfeatureslistAttribute()
	{
		return explode(',', $this->features);
	}


}


















?>