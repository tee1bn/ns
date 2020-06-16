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
							'details',
							'confirmation_message',
							'created_at'
						];
	
	protected $table = 'subscription_plans';

	public static $popular = 10;
	public static $display_order = [1,9, 10];



	public static $benefits = [
		   'basis_online_workshop' => [
		   		'title'=> 'Basis online Workshop',
		   ],
		   'media_center_small' => [
		   		'title'=> 'Media Center Small',
		   ],

		   'nsw_online_office_small' => [
		   		'title'=> 'NSW Online Office Small',
		   ],
		   'finance_schulung' => [
		   		'title'=> 'Finance Schulung ',
		   ],
		   'invitepro_tool' => [
		   		'title'=> "InvitePro Tool",
		   ],
		   'basis_online_v_material' => [
		   		'title'=> 'Basis online Vertriebsmaterial',
		   ],
		   'erw_marketing_pack' => [
		   		'title'=> 'Erweitertes Marketing-Pack',
		   ],
		   'nsw_online_shop' => [
		   		'title'=> 'NSW Online Shop',
		   ],
		   'isp' => [
		   		'title'=> 'Incentive Silber Taler: ISP',
		   ],
		   'incentive_ebene_3' => [
		   		'title'=> 'Incentive:Ebene 3',
		   ],

		];

		public static $colors = [
						1 => '#404E67',
						9 => '#d4d4d4',
						10 => '#f0d355'
					];

	public function getImageAttribute()
	{
		$domain = Config::domain();

		$name = strtolower($this->id);
		$src = "$domain/template/default/app-assets/images/logo/package$name.png";
		return $src;
	}

	public function getBackgroundAttribute()
	{
		$name = strtolower($this->id);
		

		$color = self::$colors[$name] ?? '#404E67';
		return  $color; 
	}

	public function scopeAvailableForAdmin($query)
	{
		return $query->where('show_admin', 1);
	}


	public function getDecodeGatewaysIdsAttribute($value='')
	{
		if ($this->gateways_ids == null) {
			
			return  [
						'paypal' => [
							'id' => ''
						],
					];
		}

        return  json_decode($this->gateways_ids ,true);    
	}

	public static function default_sub()
	{
		return self::where('price', 0)->first();
	}

	public function getFinalcostAttribute()
	{
		return (0.01 * $this->percent_vat * $this->price) + $this->price;
	}

	public function PriceBreakdowns($no_of_month = 1)
	{
		$price = $this->price * $no_of_month;

		$tax = 0.01 * $this->percent_vat * $price;
		$final_cost = (0.01 * $this->percent_vat * $price) + $price;
		$breakdown = [
			'before_tax'=> $price,
			'set_price'=> $price,
			'total_percent_tax'=> $this->percent_vat,
			'tax'=>  $tax,
			'type'=>  "exclusive",
			'total_payable'=>  $final_cost,
		];

		return $breakdown;
	}

	public function getPlanId($gateway)
	{
		return $this->DecodeGatewaysIds[$gateway]['id'];
	}

	public static function create_subscription_request($subscription_id, $user_id)
	{	


		DB::beginTransaction();


		try {


			$existing_requests = SubscriptionOrder::where('user_id', $user_id)
												->where('plan_id', $subscription_id)
												->get();

			$user  			= User::find($user_id);
			$previous_sub 	= $user->subscription;
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


			 	//cancel current subscription if automatic

			 	$payment_type = SubscriptionOrder::$payment_types[$_POST['payment_method']];


			 	$plan_id = $subscription_id;
			 	$no_of_month = $_POST['prepaid_month'] ?? 1;
			 	$price = $new_sub->PriceBreakdowns($no_of_month)['total_payable'];

			 	$cart = compact('plan_id','user_id','price','no_of_month');



		 		$shop = new Shop();
		 		$payment_details =	$shop
		 							->setOrderType('packages') //what is being bought
		 							->receiveOrder($cart)
		 							->setPaymentMethod($_POST['payment_method'])
		 							->setPaymentType($payment_type)
		 							->initializePayment()
		 							// ->attemptPayment()
		 							;
			}

			DB::commit();
			// $shop->goToGateway();

				Session::putFlash('success', 
					"Order for {$new_sub->package_type} created successfully.");
			return $shop->order;
		} catch (Exception $e) {
			DB::rollback();

			// print_r($e->getMessage());
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

	public function getDetailsArrayAttribute()
	{
	    if ($this->details == null) {
	        return [];
	    }

	    return json_decode($this->details, true);
	}



}


















?>