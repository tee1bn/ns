<?php


use Apis\CoinWayApi;
use Filters\Traits\Filterable;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Model as Eloquent;
use v2\Models\UserDocument;
use v2\Models\ISPWallet;
use Filters\Filters\UserFilter;


class User extends Eloquent
{
    use Filterable;
    protected $fillable = [
        'mlm_id',
        'referred_by',
        'introduced_by',
        'binary_id',
        'binary_position',
        'placement_position',
        'enrolment_position',
        'settings',
        'placement_cut_off',
        'type_of_registration',
        'rejoin_id', //former id
        'rejoin_email',
        'placed',        //determines whether the user has been placed
        'firstname',
        'lastname',
        'username',
        'account_plan',
        'locked_to_receive',
        'rank',
        'rank_history',
        'email',
        'email_verification',
        'phone',
        'age',
        'country',
        'title',
        'address',
        'worthy_cause_for_donation',
        'phone_verification',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'profile_pix',
        'resized_profile_pix',
        'password',
        'lastseen_at',
        'lastlogin_ip',
        'blocked_on',

    ];

    protected $table = 'users';
    protected $dates = [
        'created_at',
        'updated_at',
        'lastseen_at'

    ];
    protected $hidden = ['password'];


    public static $available_titles = [
        1 => 'Mr.',
        2 => 'Mrs.',
        3 => 'Miss.',
        4 => 'Dr.',
        5 => 'Prof.',
        6 => 'Chief'
    ];
    public static $compulsory_personal_data = [
        'firstname',
        'lastname',
        'username',
        'email',
        'phone',
        'country',
        'title',
        'address',
        // 'profile_pix',
    ];

    public static $compulsory_company_data = [
        'name',
        'country',
        'address',
        'office_email',
        'office_phone',
        'iban_number',
    ];

    public static $max_level = 4;


    public static $tree = [
        'enrolment' => [
            'width' => 10000,
            'depth' => 20,
            'column' => 'introduced_by',
            'title' => 'Enrolment',
            'position' => 'enrolment_position',
            'point' => null,
        ],

        'placement' => [
            'width' => 10000,
            'depth' => 20,
            'column' => 'referred_by',
            'title' => 'Direct Referral',
            'position' => 'placement_position',
            'point' => null,
        ],

        /*    'binary' =>[
                'width' => 2,
                'depth' => 4,
                'column' => 'binary_id',
                'title' => 'Binary Tree',
                'position' => 'binary_position',
                'point' => 'binary_point',
            ],*/
    ];


    /**
     * @param $mlm_id
     * @param string $tree_key
     * @return array
     */
    public function getContact($mlm_id, $tree_key = 'placement')
    {
        $tree = self::$tree[$tree_key];
        $user_column = $tree['column'];

        $package = $this->subscription;
        $domain = Config::domain();
        $d_link = MIS::dec_enc('encrypt', $package);

        if (isset($package->paid_at)){

        $link = <<<ELL
        <a target='_blank'
           href='$domain/user/download_invoice/<?= '>.Pdf</a>
ELL;
        }else{
            $link = "-";

        }




        $contact = [
            'fullname' => $this->fullname,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phone' => $this->phone,
            'invoice' => $link,
        ];
        $no_contact = [
            'fullname' => "***",
            'firstname' => "***",
            'lastname' => "***",
            'email' => "***",
            'phone' => "***",
            'invoice' => "-",
        ];


        if ($mlm_id == $this->$user_column) {
            return $contact;
        }
        $contact_availability = $this->SettingsArray['contact_availability'] ?? null;
        switch ($contact_availability) {
            case 1:
                return $contact;
                break;
            default:
                return $no_contact;
                break;
        }

    }

    //for  dashboard
    public function isp_gold()
    {
        $gold = collect(SiteSettings::find_criteria('isp')->settingsArray['isp'])->keyBy('key')['gold'];



        $today = date("Y-m-d");
        $gold_total_credit = ISPWallet::availableBalanceOnUser($this->id, 'gold');
        $gold_total_entitled = (int)ISPWallet::for($this->id)->Category('gold')->Cleared( $today, 'month')->Pending()->sum('amount');


        $in_direct_active_merchants_required = $gold['requirement']['step_1']['in_direct_active_merchants'];
        $direct_sales_partner_required = $gold['requirement']['step_1']['direct_line'];


        $direct_sales = $this->all_downlines_by_path()->where('referred_by', $this->mlm_id);

        $all_sales_partner = $this->all_downlines_by_path()->count();



                //indirect_lines
                $all_sales_partner_q = $this->all_downlines_by_path('placement', false);


                //get those with active subscription
                $today = date("Y-m-01");
                $active_subscriptions = SubscriptionOrder::Paid()->whereDate('expires_at','<' , $today);
                $active_members = $all_sales_partner_q
                        ->joinSub($active_subscriptions, 'active_subscriptions', function ($join) {
                            $join->on('users.id', '=', 'active_subscriptions.user_id');
                        }); 

                        $active_members_count = $active_members->count();

        $direct_merchants_ids =  $direct_sales->get(['id'])->pluck('id')->toArray();


        $direct_sales_partner_count = $direct_sales->count();
        $api_response  = CoinWayApi::api($today);
        $own_merchants = $api_response[$this->id]['tenantCount'] ?? 0;

        $direct_sales_partner_merchant_connections = $api_response->whereIn('supervisorNumber', $direct_merchants_ids)->sum('tenantCount');

        $total_sales_partner_required  =  $gold['requirement']['step_2']['each_x_in_whole_network'];


        $direct_sales_check = ($direct_sales_partner_count >= $direct_sales_partner_required) ?
         '<i class="ft-check text-success fa-2x"></i>' : '<i class="ft-x text-danger fa-2x"></i>' ;


        $in_direct_merchant_check = ($direct_sales_partner_merchant_connections >= $in_direct_active_merchants_required) ?
         '<i class="ft-check text-success fa-2x"></i>' : '<i class="ft-x text-danger fa-2x"></i>' ;

        $result = compact('gold_total_credit' ,
                         'gold_total_entitled',
                         'in_direct_active_merchants_required',
                         'direct_sales_partner_merchant_connections',
                         'direct_sales_partner_count',
                         'direct_sales_partner_required',
                         'all_sales_partner',
                         'total_sales_partner_required',
                         'direct_sales_check',
                         'in_direct_merchant_check',
                         'active_members_count',
                         'own_merchants'
                     );

  /*      print_r($result);
        print_r($gold);*/
        
        return $result;
    }


    public function isp_silver2($value='')
    {

              $silber = collect(SiteSettings::find_criteria('isp')->settingsArray['isp'])->keyBy('key')['silber'];




              $today = date("Y-m-d");
              $silber2_total_credit = ISPWallet::availableBalanceOnUser($this->id, 'silber2');
              $silber2_total_entitled = (int)ISPWallet::for($this->id)->Category('silber2')->Cleared( $today, 'month')->Pending()->sum('amount');


              $direct_sales = $this->all_downlines_by_path()->where('referred_by', $this->mlm_id);

              // $all_sales_partner = $this->all_downlines_by_path()->count();

              $direct_merchants_ids =  $direct_sales->get(['id'])->pluck('id')->toArray();


              $direct_sales_partner_count = $direct_sales->count();
              $api_response  = CoinWayApi::api($today);
              $own_merchants = $api_response[$this->id]['tenantCount'] ?? 0;

              $direct_sales_partner_required  =  $silber['requirement']['step_4']['no_of_direct_paid_line'];


              $direct_merchant_required  =  $silber['requirement']['step_4']['each_x_active_direct_merchant'];


              $direct_sales_check = ($direct_sales_partner_count >= $direct_sales_partner_required) ?
               '<i class="ft-check text-success fa-2x"></i>' : '<i class="ft-x text-danger fa-2x"></i>' ;


              $direct_merchant_check = ($own_merchants >= $direct_merchant_required) ?
               '<i class="ft-check text-success fa-2x"></i>' : '<i class="ft-x text-danger fa-2x"></i>' ;



              $result = compact('silber2_total_credit' ,
                               'silber2_total_entitled',
                               'direct_merchant_required',
                               'direct_sales_partner_count',
                               'direct_sales_partner_required',
                               // 'all_sales_partner',
                               'direct_sales_check',
                               'direct_merchant_check',
                               'own_merchants'
                           );
              
              return $result;

    }



    //for dashboard each 6 months subscription for silver coins
    public function isp_silver($plan_id)
    {

        $silber = collect(SiteSettings::find_criteria('isp')->settingsArray['isp'])->keyBy('key')['silber'];
        $no_of_month = $silber['requirement']['step_3']['each_x_month'];


        $first_subscription = SubscriptionOrder::where('user_id', $this->id)->Paid()
                                ->where('plan_id', $plan_id)
                                ->where('no_of_month' ,'>=', $no_of_month)
                                ->oldest('paid_at')
                                ->first();


        $initial_activation = ($first_subscription != null) ? date("d/m/Y", strtotime($first_subscription->paid_at)) : '<i class="ft-x text-danger fa-2x "></i>';

        $default = SubscriptionPlan::default_sub();
        $another = SubscriptionPlan::default_sub();
        $default->payment_plan = $another;



        if ($first_subscription ) {
            $display = "<em class='text-success'>Active</em>";
            $fa = '<i class="ft-check fa-2x "></i>';
            $value = 1;
            $subscription = $this->subscription;

            if ($subscription->id == 1) {

                $without_interuption = '<i class="ft-x text-danger fa-2x "></i>';
                $next_coin = '<i class="ft-x text-danger fa-2x "></i>';


            }else{

                $without_interuption = date("d/m/Y", strtotime($subscription->paid_at)) ;
                $next_coin = date("d/m/Y", strtotime("$subscription->paid_at +6 months"));

            }


        }else{

            $display = "<em class='text-danger'>Inactive</em>";
            $fa = '<i class="ft-x fa-2x text-danger"></i>';
            $value = 0;

            $subscription = $default;

            $without_interuption =  '<i class="ft-x text-danger fa-2x "></i>';
            $next_coin =  '<i class="ft-x text-danger fa-2x "></i>';
        }



        //silber2



/*
        print_r($silber);

        $isp2 = [];*/



        $result = compact('display','value', 'subscription','fa', 'initial_activation','without_interuption','next_coin' );

        return $result;

    }

    public function getaddressArrayAttribute()
    {
        $value = $this->address;


        if ($value == null) {

            return [];
        }
        $response = json_decode($value, true);

        if (is_array($response)) {
            return $response;
        }

        return ['address' => $value];
    }

    public function determine_level($position, $tree_key)
    {
        $tree = self::$tree[$tree_key];
        $user_column = $tree['position'];

        $mlm_id_1 = explode("/", $this->$user_column);
        $mlm_id_2 = explode("/", $position);

        $level = abs(count($mlm_id_1) - count($mlm_id_2));

        return $level;

    }

    public function max_uplevel($tree_key)
    {

        $tree = self::$tree[$tree_key];
        $user_column = $tree['position'];

        $mlm_ids = explode("/", $this->$user_column);

        $max_level = count($mlm_ids) - 1;

        return compact('mlm_ids', 'max_level');
    }


    public function scopeVerified($query)
    {
        $no_of_documents = count(v2\Models\UserDocument::$document_types) - 1;

        $eloquent = UserDocument::from("users_documents as user_doc")->select('user_doc.user_id', DB::raw("COUNT(*) as approved_docs"))
            ->where('user_doc.status', 2)
            ->groupBy('user_doc.user_id')
            ->having('approved_docs', '>', $no_of_documents)
            ->leftJoin('users_documents', function ($join) {
                $join
                    ->on('user_doc.document_type', '=', 'users_documents.document_type')
                    ->on('user_doc.id', '<', 'users_documents.id');
            })
            ->where('users_documents.id', null);


        $userss = User::query()
            ->joinSub($eloquent, 'approved_documents', function ($join) {
                $join->on('users.id', '=', 'approved_documents.user_id');
            });

        return $userss;

    }

    public function has_verified_profile()
    {

        $id = $this->id;
        $no_of_documents = count(v2\Models\UserDocument::$document_types);
        /*
                $approved_ids = collect( DB::select("SELECT m1.user_id, COUNT(*) as approved_docs
                    FROM users_documents m1 LEFT JOIN users_documents m2
                     ON (m1.document_type = m2.document_type AND m1.id < m2.id)
                    WHERE m2.id IS NULL
                    AND m1.status = '2'
                    GROUP BY m1.user_id
                    Having  approved_docs = $no_of_documents
                    ;

                    "));*/

        $approved_ids = self::Verified()->where('id', $this->id);

        return $approved_ids->count() > 0;
    }

    public function getVerifiedBagdeAttribute()
    {

        if ($this->has_verified_profile()) {

            $status = "<span class='badge badge-success'>Verified</span>";
        } else {

            $status = "<span class='badge badge-danger'>Not Verified</span>";
        }

        return $status;

    }


    public function getphoneVerificationStatusAttribute()
    {
        return;
        if ($this->has_verified_phone()) {

            $status = "<span class='badge badge-success'>Verified</span>";
        } else {

            $status = "<span class='badge badge-danger'>Not Verified</span>";
        }

        return $status;
    }


    public function has_verified_email()
    {
        return (strlen($this->email_verification) == 1);
    }


    public function getemailVerificationStatusAttribute()
    {

        if ($this->has_verified_email()) {

            $status = "<span class='badge badge-success'>Verified</span>";
        } else {

            $status = "<span class='badge badge-danger'>Not Verified</span>";
        }

        return $status;
    }


    public function documents()
    {
        return $this->hasMany('v2\Models\UserDocument', 'user_id')->latest();
    }

    public function approved_documents()
    {
        $id = $this->id;
        $approved_ids = collect(DB::select("SELECT m1.*
                FROM users_documents m1 LEFT JOIN users_documents m2
                 ON (m1.document_type = m2.document_type AND m1.id < m2.id)
                WHERE m2.id IS NULL 
                AND m1.status = '2'
                AND m1.user_id = $id
                ;
                "))->pluck('id')->toArray();


        return $this->hasMany('v2\Models\UserDocument', 'user_id')->whereIn('id', $approved_ids)->Approved();
    }

    public function pending_documents()
    {
        $id = $this->id;
        $approved_ids = collect(DB::select("SELECT m1.*
                FROM users_documents m1 LEFT JOIN users_documents m2
                 ON (m1.document_type = m2.document_type AND m1.id < m2.id)
                WHERE m2.id IS NULL 
                AND m1.status != '2'
                AND m1.user_id = $id
                ;
                "))->pluck('id')->toArray();


        return $this->hasMany('v2\Models\UserDocument', 'user_id')->whereIn('id', $approved_ids);
    }


    public function binary_status()
    {
        return count($this->referred_members_downlines(1, "binary")[1]) == 2;
    }

    public function getBinaryStatusDisplayAttribute()
    {
        if ($this->binary_status()) {
            $display = "<em class='text-success'>Active</em>";
        } else {
            $display = "<em class='text-danger'>Inactive</em>";
        }

        return $display;
    }

    public function all_uplines($tree_key = 'placement')
    {

        $tree = self::$tree[$tree_key];
        $user_column = $tree['column'];


        //first include self
        $this_user_uplines[0] = $this->toArray();
        $upline = $this->$user_column;

        $level = 0;
        do {

            $level++;
            $found = self::where('mlm_id', $upline)->where('mlm_id', '!=', null)->first();
            if ($found != null) {
                $this_user_uplines[$level] = $found->toArray();
            } else {
                $this_user_uplines[$level] = null;

            }

            $upline = $this_user_uplines[$level][$user_column];


        } while ($this_user_uplines[$level] != null);


        return ($this_user_uplines);
    }


    public function downline_at_level($level, $tree_key)
    {
        $tree = self::$tree[$tree_key];
        $user_column = $tree['position'];

        $self_identifier = "{$this->$user_column}";

        $stitch = "";
        for ($i = 0; $i < $level; $i++) {
            $stitch .= "%/";
        }

        $identifier = $stitch . $self_identifier;
        // echo "$stitch";
        echo "<br>";


        // $identifier = "[0-9]/[0-9]/1";

        // echo "$identifier";
        $generation = self::where($user_column, 'like', $identifier);
        // echo $generation->toSql();
/*
        echo "<pre>";
        print_r($generation->get(['id', 'mlm_id'])->toArray());*/
    }

    //0=left, 1=right
    public function all_downlines_at_position($position, $tree_key = 'placement')
    {

        $tree = self::$tree[$tree_key];
        $user_column = $tree['column'];
        $downline_at_position = $this->referred_members_downlines(1, $tree_key)[1][$position];

        if ($downline_at_position == null) {
            return self::where('id', null);
        }

        $downline = self::find($downline_at_position['id']);

        return $downline->all_downlines_by_path($tree_key, true);

    }


    public function all_downlines_by_path($tree_key = 'placement', $add_self = false, $sieve=[])
    {

          $tree = self::$tree[$tree_key];
          $user_column = $tree['position'];


          if ($add_self == true) {
            // $query = self::query();
               $identifier = "/$this->mlm_id";
               $mlm_id = $this->mlm_id;
                $query = self::WhereRaw("(mlm_id = '$mlm_id' OR $user_column like '%$identifier%')")
                ;

          }else{
               $identifier = "/$this->mlm_id";
                $query = self::where($user_column, 'like', "%$identifier%");

          }


        return $query;
    }


    public function setTreesPosition()
    {

        $position = [];
        foreach (self::$tree as $key => $value) {
            $user_column = $value['position'];
            $all_uplines = collect($this->all_uplines($key))->pluck('mlm_id')->toArray();

            $all_uplines = array_filter($all_uplines, function ($item) {
                return $item != null;
            });

            $position_value = (implode('/', $all_uplines));

            $position[$user_column] = $position_value;
        }

        $this->update($position);
        // print_r($position);

    }


    public function can_received_compensation()
    {
        $plan_details = $this->subscription->payment_plan->DetailsArray;

        if ($plan_details['benefits']['participate_in_compensation_plan'] == 1) {
            return true;
        }
        return false;
    }


    public function getTwofaDisplayAttribute()
    {

        if ($this->has_2fa_enabled()) {
            $display = "<span class='badge badge-success'>ON</span>";
        } else {
            $display = "<span class='badge badge-danger'>OFF</span>";
        }

        return $display;
    }

    public function save_settings($settings)
    {
        $update = $this->update([
            'settings' => json_encode($settings)
        ]);

        return $update;
    }

    public function has_2fa_enabled()
    {
        return @$this->SettingsArray['enable_2fa'] == 1;
    }

    public function getSettingsArrayAttribute()
    {
        if ($this->settings == null) {
            return [];
        }

        return json_decode($this->settings, true);
    }




    public function getMembershipStatusDisplayAttribute()
    {
        $last_subscription = SubscriptionOrder::where('user_id', $this->id)->Paid()->latest('paid_at')->first();

        $default = SubscriptionPlan::default_sub();
        $another = SubscriptionPlan::default_sub();
        $default->payment_plan = $another;



        if ($last_subscription == null) {

            $display = "<em class='text-danger'>Inactive</em>";
            $fa = "<i style='background: white; border-radius:15px;' class='fa fa-times-circle text-danger'></i>";
            $fa2 = "<i style='background: white;' class='ft-x text-danger'></i>";
            $value = 0;
            $subscription = $default;
            $result = compact('display','value', 'subscription','fa' );
            return $result;

        }

        if ($last_subscription->is_expired()) {
            $display = "<em class='text-danger'>Inactive</em>";
            $fa = "<i style='background: white; border-radius:15px;' class='fa fa-times-circle text-danger'></i>";
            $fa2 = "<i style='background: white;' class='ft-x text-danger'></i>";
            $value = 0;
            $subscription = $last_subscription;
        }else{
            $fa = "<i style='background: white; border-radius:15px;' class='fa fa-check-circle text-success'></i>";
            $fa2 = "<i style='background: white;' class='ft-check text-success'></i>";
            $display = "<em class='text-success'>Active</em>";
            $value = 1;
            $subscription = $last_subscription;
        }

        $result = compact('display','value','subscription' ,'fa','fa2');
        return $result;
    }


    public function getDecodedTitleAttribute()
    {
        return self::$available_titles[$this->title];
    }


    public function getDisplayCompleteProfileStatusAttribute()
    {

        $response = $this->has_complete_profile();

        if (($response['company_data'] == 1) && ($response['personal_data'] == 1)) {

            $status = "<span class='badge badge-success'></span>";
        } else {

            $status = "<span class='badge badge-danger float-right'> </span>";
        }

        return $status;
    }


    public function has_complete_profile()
    {


        $result = ['company_data' => 1, 'personal_data' => 1,];

        foreach (self::$compulsory_company_data as $key => $meta_data) {

            if ($this->company->$meta_data == null) {
                $result['company_data'] = 0;
                break;
            }
        }

        foreach (self::$compulsory_personal_data as $key => $personal_data) {
            if ($this->$personal_data == null) {
                $result['personal_data'] = 0;
                break;
            }
        }


        return $result;
    }



    public function pool_target()
    {


        $coin_way = new CoinWayApi;

        $today = date("Y-m-d");

        $date_range = MIS::date_range($today);
        $response = $coin_way->setPeriod($date_range['start_date'], $date_range['end_date'])
            ->connect()->get_response()->keyBy('supervisorNumber');

        $no_of_merchants = $response[$this->id]['tenantCount'] ?? 0;

        // $no_of_merchants = 20;

        $pools_settings = SiteSettings::pools_settings();
        foreach ($pools_settings as $key => $settings) {
            if ($no_of_merchants <= $settings['min_merchant_recruitment']) {
                $next_pool = $settings;
                break;
            }
        }

        $next_pool['current_no_of_merchants'] = $no_of_merchants;
        $next_pool['month'] = date("F y");
        return $next_pool;

    }


    public function company()
    {

        return $this->hasOne('Company', 'user_id');
    }


    public function unseen_notifications()
    {
        return Notifications::unseen_notifications($this->id);
    }


    public function all_notifications()
    {
        return Notifications::all_notifications($this->id, $per_page = null, $page = 1);
    }


    public function products_orders()
    {

        return $this->hasMany('Orders', 'user_id');
    }


    public function accessible_products()
    {

        return Products::accessible($this->subscription->id)->get();
    }


    public function getPayoutAttribute($month = null)
    {
        return LevelIncomeReport::payout_for_month($this->id, $month);
    }


    public function getPayoutEligibityAttribute($month = null)
    {

        if ($this->is_qualified_for_commission($month)) {

            return "<span class='badge badge-success'><i class='fa fa-2x fa-check-circle'></i></span>";
        }
        return "<span class='badge badge-danger'><i class='fa fa-2x fa-times'></i></span>";
    }


    public function commission_eligibility($month=null)
    {

        $production_month = $month ?? date("Y-m-01");

        $date_range = MIS::date_range($production_month, 'month', true);



        $setting = SiteSettings::find_criteria('rules_settings')->settingsArray;
        $min_net_turnover = $setting['min_net_turnover_for_commission_eligibility'];


        $direct_lines = $this->all_downlines_by_path('placement', false)->where('referred_by', $this->mlm_id)->orWhere('mlm_id', $this->mlm_id);

       

        $active_subscriptions = SubscriptionOrder::Paid()
                                ->whereDate('paid_at','>=',  $date_range['start_date'])
                                ->whereDate('paid_at', '<=',$date_range['end_date']);

        $from_direct_lines_and_self_sales_of_packages = $direct_lines
                ->joinSub($active_subscriptions, 'active_subscriptions', function ($join) {
                    $join->on('users.id', '=', 'active_subscriptions.user_id');
                })->sum('commission_price'); 




        if ($from_direct_lines_and_self_sales_of_packages >= $min_net_turnover) {
            return true;
        }



        $api_response  = CoinWayApi::api('2019-07-01');
        $license_sum = $api_response[$this->id]['licenseSum'] ?? 0;


        $total = $license_sum + $from_direct_lines_and_self_sales_of_packages;




        //get total orders from own merchants
        if ($total >= $min_net_turnover) {
            return true;
        }


        return false;
    }



    //must have package able to receive level commission
    public function is_qualified_for_commission($level)
    {
        $eligible_level = $this->subscription->payment_plan->downline_commission_level;

        if ($eligible_level >= $level) {
            return true;
        }

        return false;

    }


    public function getSubAttribute()
    {

        if ($this->subscription != null) {
            return $this->subscription->plandetails['package_type'];
        }

        return 'Nil';
    }


    public function getsubscriptionAttribute()
    {
        $today = strtotime(date("Y-m-d"));
        $subscription = SubscriptionOrder::where('user_id', $this->id)->Paid()->latest('paid_at')->first();

        $default = SubscriptionPlan::default_sub();
        $another = SubscriptionPlan::default_sub();
        $default->payment_plan = $another;

        if ($subscription == null) {
            return $default;
        }


        $expiry_time = strtotime($subscription->ExpiryDate);
        if (($subscription->payment_state == 'manual') || ($subscription->payment_state == null)) {

            if ($expiry_time < $today) {

                return $default;
            } else {
                return $subscription;
            }

        } elseif ($subscription->payment_state == 'automatic') {

            return $subscription;

        } elseif ($subscription->payment_state == 'cancelled') {

            if ($expiry_time < $today) {

                return $default;

            } else {
                return $subscription;
            }

        } else {

            return $default;
        }

        return $default;

    }

    public function subscriptions()
    {
        return $this->hasMany('SubscriptionOrder', 'user_id');
    }


    public function scopeBlockedUsers($query)
    {

        return $query->where('blocked_on', '!=', null);

    }


    public static function generate_phone_code_for($user_id)
    {

        $remaining_code_length = 6 - strlen($user_id);
        $min = pow(10, ($remaining_code_length - 1));
        $max = pow(10, ($remaining_code_length)) - 1;

        $remaining_code = random_int($min, $max);

        return $phone_code = $user_id . $remaining_code;
    }


    public function getqualifyStatusAttribute()
    {

        $status = (($this->is_qualified_for_commission(null)))
            ? "<span type='span' class='badge badge-success'>Active</span>" :
            "<span type='span' class='badge badge-danger'>Not Active</span>";

        return $status;
    }


    public function getactiveStatusAttribute()
    {

        $status = (($this->blocked_on == null))
            ? "<span type='span' class='badge badge-xs badge-success'>Active</span>" :
            "<span type='span' class='badge badge-xs badge-danger'>Blocked</span>";

        return $status;
    }


    public function getDropSelfLinkAttribute()
    {
        return "<a target='_blank' href='{$this->AdminViewUrl}'>{$this->full_name}</a>";
    }


    public function getAdminViewUrlAttribute()
    {
        $href = Config::domain() . "/admin/user_profile/" . $this->id;
        return $href;

    }


    public function testimonies()
    {
        return $this->hasMany('Testimonials', 'user_id');
    }


    public function no_of_rejoin()
    {
        if ($this->rejoin_id != null) {

            return count(explode(",", rtrim($this->rejoin_id, ',')));
        } else {
            return 0;
        }
    }


    public function ripe_for_rejoin()
    {
        $mustbe_on_highest_level = ($this->rank == self::$max_level);
        $payments_received = Payouts::where('payer_id', $this->id)->where('status', 'Approved')->count();


        $must_have_received_all_payments = ($payments_received == 30);

        return ($mustbe_on_highest_level && $must_have_received_all_payments);

    }


    public function rejoin()
    {

        $email = $this->email;
        $referred_by = User::where_to_place_new_user_within_team_introduced_by($this->id);
        $username = User::generate_username_from_email($email);


        $replicate = $this->replicate();


        $this->rejoin_email = $this->email;
        $this->email = null;
        $this->username = null;

        print_r($this->toArray());


        $replicate->email = $this->rejoin_email;
        $replicate->referred_by = $referred_by;
        $replicate->introduced_by = $this->id;
        $replicate->rank = null;
        $replicate->rejoin_id = ($this->rejoin_id == null) ? $this->id : "{$this->rejoin_id},$this->id";

        $this->save();
        $replicate->save();


        // print_r($replicate->toArray());

        // $newTask->save();
        Session::putFlash('', "Congrats!! You completed the level" . self::$max_level . " and hence rejoined!");

    }


    public function generate_username_from_email($email)
    {
        $username = explode('@', $email)[0];
        $i = 1;
        do {
            $loop_username = ($i == 1) ? "$username" : "$username" . ($i - 1);
            $i++;
        } while (User::where('username', $loop_username)->get()->isNotEmpty());


        return $loop_username;

    }


    public function which_leg($sponsor_id)
    {

        $sponsor = User::find($sponsor_id);
        $mlm_width = 2;


        $direct_lines = ($sponsor->referred_members_downlines(1)[1]);

        for ($leg_index = 0; $leg_index < $mlm_width; $leg_index++) {
            if ($direct_lines[$leg_index] == '') {
                return $leg_index;
            }

        }
    }


    public function replace_any_cutoff_mlm_placement_position($sponsor_id, $substitute_id)
    {
        $placement_sponsor = User::find($sponsor_id);

        $former_downline_mlm_id = (array_values($placement_sponsor->placement_cut_off))[0]; //mlm_id


        if ($former_downline_mlm_id != '') {


            print_r(array_values($placement_sponsor->placement_cut_off));


            $former_downline = User::where('mlm_id', $former_downline_mlm_id)->first();
            $former_downline_replica = $former_downline->replicate();

            $former_downline->mlm_id = null;
            $former_downline->save();

            $substitute = User::find($substitute_id);
            $substitute->mlm_id = $former_downline_mlm_id;

            $substitute->save();


            //update cutoff history
            $cutoff_history = $placement_sponsor->placement_cut_off;
            $cutoff_index = array_search($former_downline_mlm_id, $cutoff_history);
            unset($cutoff_history[$cutoff_index]);

            $placement_sponsor->update(['placement_cut_off' => json_encode($cutoff_history)]);

        }

    }


    public function getplacementcutoffAttribute($value = '')
    {
        return json_decode($value, true);
    }


    public function prepare_placement_cutoff()
    {

        try {


            $placement_sponsor = User::where('mlm_id', $this->referred_by)->where('mlm_id', '!=', null)->first();

            if ($placement_sponsor == null) {
                // Redirect::to('login/logout');
            }

            $leg_index = $placement_sponsor->leg_of_user($this->mlm_id);


            $cutoff_history = ($placement_sponsor->placement_cut_off);
            $cutoff_history[$leg_index] = $this->mlm_id;


            $placement_sponsor->update([
                'placement_cut_off' => json_encode($cutoff_history),
            ]);

        } catch (Exception $e) {
            echo "string";
        }

    }


    public function remove_from_mlm_tree()
    {
        $this->prepare_placement_cutoff();
        $this->update([
            'referred_by' => null,
            'introduced_by' => null,
        ]);
    }

    public function block_user()
    {

        $this->update([
            'blocked_on' => date("Y-m-d H:i:s"),
        ]);
    }


    /**
     * [higher_level_leaders for generational bonuses]
     * @return [type] [description]
     */
    public static function higher_level_leaders()
    {
        $min_rank_to_earn_generational_bonus = json_decode(
            MlmSetting::where('rank_criteria', 'min_rank_to_earn_generational_bonus')->first()->settings, true);


        return User::where('rank', '>=', $min_rank_to_earn_generational_bonus)->where('blocked_on', null);
    }


    /**
     *
     * @param   $team_leader_id [this determines the
     * placement sponsor of a new user introduced/enrolled by the
     * supplied $team_leader.
     * the spill over is automatic and even within the downline]
     * the first downline not having complete mlm width is selected
     * @return [int]                 [description]
     */
    public static function where_to_place_new_user_within_team_introduced_by($team_leader_id, $tree_key = 'placement')
    {


        $tree = self::$tree[$tree_key];
        $user_column = $tree['column'];
        $mlm_width = $tree['width'];

        $team_leader = User::find($team_leader_id);

        if ($team_leader->mlm_id == '') {
            $team_leader = User::find(1);
        }


        $team_leader_downline_level = 1;
        do {
            $downline_at_level = $team_leader->referred_members_downlines($team_leader_downline_level, $tree_key)[$team_leader_downline_level];

            if ((count($downline_at_level) < $mlm_width) && ($team_leader_downline_level == 1)) {
                return $team_leader->mlm_id;
            }


            $downline_at_level_obj = collect($downline_at_level);
            $max = ($downline_at_level_obj->max('no_of_direct_line'));
            $min = ($downline_at_level_obj->min('no_of_direct_line'));


            foreach ($downline_at_level as $key => $downline) {
                if ($downline['no_of_direct_line'] == $min) {  //select user with list downline
                    $referrer_user = ($downline);
                    break;
                }
            }
            // print_r($referrer_user);

            if ($referrer_user['no_of_direct_line'] < $mlm_width) {
                return $referrer_user['mlm_id'];
            }

            $team_leader_downline_level++;
        } while ($referrer_user != null);

    }


    public function referral_link()
    {
        $link = Config::domain() . "/ref/" . $this->username;
        return $link;

    }


    /**
     * [available_balance fetches this user available balance]
     * @return [type] [description]
     */
    public function available_balance()
    {

        $available_balance = LevelIncomeReport::available_balance($this->id);
        return $available_balance;
    }


    /**
     * [withdrawals fetches this users records of withdrawals]
     * @return [eloquent query builder]
     */
    public function total_withdrawals()
    {
        return LevelIncomeReport::total_withdrawals($this->id);
    }

    public function withdrawals_history()
    {
        return LevelIncomeReport::withdrawals_history($this->id);
    }


    /**
     * [sum_total_earnings calculates the total earnings of this user]
     * @return [int] [description]
     */
    public function sum_total_earnings()
    {
        return LevelIncomeReport::sum_total_earnings($this->id);
    }


    /**
     * [earnings returns records of this users earnings]
     * @return [query buider] [description]
     */
    public function earnings()
    {
        return LevelIncomeReport::earnings($this->id);
    }


    public function next_rank()
    {

        $next_rank = intval($this->rank) + 1;
        if ($next_rank > self::$max_level) {
            $next_rank = self::$max_level;
        }
        return $next_rank;
    }


    public function current_rank()
    {
        if ($this->rank == 0) {
            return 'N/A';
        }
        return $this->rank;

    }


    public function factorial($n)
    {
        if ($n == 1) {
            return 1;
        } else {
            return $n * $this->factorial($n - 1);
        }
    }


    /*
        This returns the volume of sales in a leg for this user
        $postion is the leg
        $tree_key determines the tree to consider
        $add_self whether to add personal sales
        $volume determine the actual volume to calcuate
    */

    public function total_volumes($position = 0, $tree_key = 'binary', $date_range = [])
    {

        $users = $this->all_downlines_at_position($position, $tree_key);
        if ($users->count() < 1) {
            return 0;
        }

        if (count($date_range) == 2) {
            $total_volume = $users->join('wallet_for_hot_wallet', function ($join) use ($date_range) {
                extract($date_range);
                $join->on('users.id', '=', 'wallet_for_hot_wallet.user_id')
                    ->where('wallet_for_hot_wallet.earning_category', 'investment')
                    ->where('wallet_for_hot_wallet.type', 'credit')
                    ->whereDate('wallet_for_hot_wallet.created_at', '>=', $start_date)
                    ->whereDate('wallet_for_hot_wallet.created_at', '<=', $end_date);
            })->sum('wallet_for_hot_wallet.cost');;


        } else {

            $total_volume = $users->join('wallet_for_hot_wallet', function ($join) {
                $join->on('users.id', '=', 'wallet_for_hot_wallet.user_id')
                    ->where('wallet_for_hot_wallet.earning_category', 'investment')
                    ->where('wallet_for_hot_wallet.type', 'credit');

            })->sum('wallet_for_hot_wallet.cost');

        }
        return $total_volume;
    }


    public function total_member_qualifiers_by_path($position = 0, $tree_key = 'binary')
    {

        $TheRank = $this->TheRank;
        $tree = self::$tree[$tree_key];
        $user_column = $tree['column'];

        $users = $this->all_downlines_at_position($position, $tree_key);


        $qualifiers = $users->select('rank', DB::raw('count(*) as total'), 'mlm_id', $user_column)
            ->where('rank', '!=', null)
            ->where('rank', '>', -1)
            ->groupBy('rank')->get()->toArray();


        $qualifiers_text = "";
        foreach ($qualifiers as $qualifier) {
            if ($qualifier['rank'] == -1) {continue;}
            $count = $qualifier['total'];
            $name = $TheRank['all_ranks'][$qualifier['rank']]['name'];
            $qualifiers_text .= "$count $name <br>";
        }

        $response = compact('qualifiers', 'qualifiers_text');

        return ($response);

    }


    public function total_member_qualifiers($position = 0, $tree_key = 'binary')
    {

        $rank = $this->TheRank;
        $ranks_to_find = $rank['next']['rank_qualifications']['rating']['in_team'];
        $ranks_to_find = collect($ranks_to_find)->pluck('member_rank')->toArray();

        $tree = self::$tree[$tree_key];
        $user_column = $tree['column'];


        $downline_at_position = @$this->referred_members_downlines(1, $tree_key)[1][$position];

        if ((isset($downline_at_position['no_of_direct_line']))) {
            $user = self::find($downline_at_position['id']);

            if (in_array($downline_at_position['rank'], $ranks_to_find)) {
                $result[] = $downline_at_position['rank'];
            }

            return array_merge($result, $user->total_member_qualifiers($position, $tree_key));

        } else {

            if (in_array($downline_at_position['rank'], $ranks_to_find)) {
                $result[] = $downline_at_position['rank'];
            }

            return $result;
        }
    }


    public function total_downlines($position = 0, $tree_key = 'placement')
    {

        $tree = self::$tree[$tree_key];
        $user_column = $tree['column'];

        $downline_at_position = $this->referred_members_downlines(1, $tree_key)[1][$position];

        if ((isset($downline_at_position['no_of_direct_line'])) && ($downline_at_position['no_of_direct_line'] > 0)) {
            // print_r($downline_at_position);
            $user = self::find($downline_at_position['id']);
            return 1 + $user->total_downlines($position, $tree_key);
        } elseif (isset($downline_at_position['no_of_direct_line'])) {

            return 1;

        } else {
            return 0;

        }
    }

    public function find_rank_in($position = 0, $tree_key = 'placement', $rank, $number)
    {

        return $this->all_downlines_at_position($position, $tree_key)->where('rank', $rank)->count();

    }


    //trailing
    public function find_rank_in_old($position = 0, $tree_key = 'placement', $rank, $number)
    {

        $tree = self::$tree[$tree_key];
        $user_column = $tree['column'];

        $downline_at_position = @$this->referred_members_downlines(1, $tree_key)[1][$position];

        /*  if (isset($downline_at_position[$position])) {
              $downline_at_position =  $downline_at_position[$position];
          }else{
              return 0;
          }*/

        $found_rank = [];
        if ((isset($downline_at_position['no_of_direct_line'])) && ($downline_at_position['no_of_direct_line'] > 0)) {

            if ($downline_at_position['rank'] == $rank) {
                $found_rank[] = $downline_at_position;
            }
            // print_r($downline_at_position);
            $user = self::find($downline_at_position['id']);

            if (count($found_rank) == $number) {
                return count($found_rank);
            }

            return count($found_rank) + $user->find_rank_in($position, $tree_key, $rank, $number);

        } elseif (isset($downline_at_position['no_of_direct_line'])) {

            if ($downline_at_position['rank'] == $rank) {
                $found_rank[] = $downline_at_position;
            }

            return count($found_rank);

        } else {

            return 0;

        }
    }


    /**
     * [users_with_no_placements fetches ids of users who have placments]
     * @return [type] [description]
     */
    public static function users_with_placements($tree_key = 'placement')
    {


        $tree = self::$tree[$tree_key];
        $user_column = $tree['column'];

        $referrals_ids = User::where($user_column, '!=', null)
            ->where($user_column, '!=', 0)->pluck($user_column)->toArray();

        $referrals_ids = array_unique($referrals_ids);

        return $referrals_ids;
    }


    /**
     * [users_with_no_placements fetches ids of users who have placments]
     * @return [type] [description]
     */
    public static function users_with_no_placements()
    {
        $users_ids_with_no_placements = User::whereNotIn('id', User::users_with_placements())->pluck('id')->toArray();
        $users_ids_with_no_placements = array_unique($users_ids_with_no_placements);
        return $users_ids_with_no_placements;
    }


    /**
     * [possible_placement fetches all possible placements for a user in a users team]
     * @param  [type] $enroler_id  [team lead]
     * @param  [type] $downline_id [new team memeber]
     * @return [array]              [ids of users where new memeber can ber placed]
     */
    public function possible_placement($enroler_id, $downline_id = null, $tree_key = 'placement')
    {

        $tree = self::$tree[$tree_key];
        $user_column = $tree['column'];

        $user = User::find($enroler_id);
        $placement_tree = $user->all_downlines();
        $downlines_id = User::where($user_column, $enroler_id)->get(['id', $user_column]);

        $users_with_no_placements = User::users_with_no_placements();


        /*
        print_r($downlines_id->toArray());
        print_r($placement_tree);
        print_r($downline_level);*/
// print_r($users_with_no_placements);

        foreach ($users_with_no_placements as $user_id) {
            $downline_level = $user->downline_level_of($user_id);
            if ($downline_level['present'] == 1) {
                $possible_placement[$downline_level['level']][] = $user_id;
            }

        }

        ksort($possible_placement);

        return $possible_placement;

    }


    /**
     * [is_placeable tells whether a user is placeable in the placement structure
     * ]
     * @return boolean
     */
    public function is_placeable()
    {
        $max_duration = json_decode(MlmSetting::where('rank_criteria', 'placement_duration')->first()->settings, true);
        $one_day = 24 * 60 * 60;
        $difference = (int)((time() - strtotime($this->created_at)) / $one_day);

        return (bool)($difference < $max_duration);


    }


    public function life_rank()
    {
        $rank_history = json_decode($this->rank_history, true);
        return (max(array_values($rank_history)));
    }

    public function getRankHistoryArrayAttribute()
    {
        if ($this->rank_history == '') {
            return [];
        }
        return json_decode($this->rank_history, true);
    }


    public function getTheRankAttribute()
    {


        $rank_setting = SiteSettings::find_criteria('leadership_ranks')->settingsArray;
        // print_r($rank_setting);

        $all_ranks = $rank_setting['all_ranks'];
        $rank_qualifications = $rank_setting['rank_qualifications'];

        $next_rank = intval($this->rank) + 1;
        if ($next_rank > self::$max_level) {
            $next_rank = self::$max_level;
        }

        if (($this->rank == -1) || ($this->rank === null)) {

            $rank = [
                'all_ranks' => $all_ranks,
                'index' => $this->rank,
                'name' => "Nil",
                'rank_qualifications' => $rank_qualifications[$this->rank],
                'next' => [
                    'index' => $next_rank,
                    'name' => $all_ranks[$next_rank]['name'],
                    'rank_qualifications' => $rank_qualifications[$next_rank],

                ]
            ];

            return $rank;
        }


        $rank = [
            'all_ranks' => $all_ranks,
            'index' => $this->rank,
            'name' => $all_ranks[$this->rank]['name'],
            'rank_qualifications' => $rank_qualifications[$this->rank],
            'next' => [
                'index' => $next_rank,
                'name' => $all_ranks[$next_rank]['name'],
                'rank_qualifications' => $rank_qualifications[$next_rank],

            ]
        ];

        return $rank;
    }

    /*the placement structure begins*/

    /**
     * [leg_of_user this returns the leg in which the suplied user is on this users team/donwline]
     * @param  string $user_id [the id of the user we want to check in this instance user]
     * @return [int]          [the actual leg not leg index ]
     */
    public function leg_of_user($user_mlm_id = '', $tree_key = 'placement')
    {
        /**
         * [$i this is the leg we want to check if the supplied user is in
         * usually, maximum leg will be equal the width of the matrix]
         * @var integer
         */
        $i = 1;
        do {

            //if the supplied user is the direct downline of this instance user in this leg we are in
            if ($this->user_at_leg($i, $tree_key)->mlm_id == $user_mlm_id) {
                $leg = $i;
                break;
            }

            //if the supplied user is in downline of this instance user direct downline in this leg
            if ($this->user_at_leg($i, $tree_key)->downline_level_of($user_mlm_id, $tree_key)['present']) {
                $leg = $i;
                break;
            }

            $i++;
        } while ($this->user_at_leg($i, $tree_key) != null);//ensure this instance user has started building the leg


        // print_r($user_at_leg);

        return ($leg);
    }


    /**
     * [downline_level_of retruns the downline level of a user in this instance user team]
     * @param  string $user_id [the id of the user we want to check in this instnace user]
     * @return [array]          [description] //placement structure
     */
    public function downline_level_of($user_id = '', $tree_key = 'placement')
    {

        foreach ($this->all_downlines($tree_key) as $level => $downline_users) {

            foreach ($downline_users as $user) {

                if ($user_id == $user['id']) {
                    $downline_level = $level;
                    break(2);
                }
            }

        }


        return ['present' => boolval($downline_level), 'level' => $downline_level];
    }


    /**
     * [all_downlines fetches all the ids of this users doenlines users infinitely
     * @return [array] [with keys as the downline level and values as all the users ids in the level]
     */
    public function all_downlines($tree_key = 'placement')
    {


        $tree = self::$tree[$tree_key];
        $user_column = $tree['column'];


        $depth_level = 1;
        $downlines_at[0] = [
            'id' => $this->id,
            'rank' => $this->rank,
            'mlm_id' => $this->mlm_id,
            $user_column => $this->$user_column
        ]; // self is on downline zero
        do {
            foreach ($this->referred_members_downlines($depth_level, $tree_key) as $level => $downlines) {
                $downlines_at[$level] = $downlines;
            }
            $depth_level++;
        } while (count($this->referred_members_downlines($depth_level, $tree_key)[$depth_level]) != '');


        return ($downlines_at);

    }


    /**
     * [user_at_leg returns the first user at the leg supplied]
     * @param  [type] $leg
     * @return [type]      [description]
     */
    public function user_at_leg($leg, $tree_key = 'placement')
    {

        $tree = self::$tree[$tree_key];
        $user_column = $tree['column'];


        $leg--;
        $user_id_at_leg = $this->referred_members_downlines(1, $tree_key)[1][$leg]['mlm_id'];
        $user_at_leg = self::where('mlm_id', $user_id_at_leg)->first();
        return $user_at_leg;
    }

    /**
     * [number_of_all_downlines_at_leg tells how many users are in this user particular leg]
     * @param  int $leg [ the leg index we wish to check on i.e for leg 1, $leg=0]
     * @return [type]      [description]
     */
    protected function number_of_all_downlines_at_leg($leg = '', $tree_key = 'placement')
    {

        $user_at_leg = $this->user_at_leg($leg + 1);


        if ($user_at_leg == null) {
            return 0;
        }

        $depth_level = 1;
        do {
            foreach ($user_at_leg->referred_members_downlines($depth_level, $tree_key) as $level => $downlines) {
                $number_of_downlines_at_level[$level] = count($downlines);
            }
            $depth_level++;
        } while (count($user_at_leg->referred_members_downlines($depth_level, $tree_key)[$depth_level]) != '');

        $number_of_all_downlines = array_sum($number_of_downlines_at_level);
        return ($number_of_all_downlines + 1);
    }


    /**
     * [user_legs returns array with key as this user leg and value as number of downlines]
     * @return [array] [description]
     */
    public function user_legs($tree_key = 'placement')
    {
        $leg = 0;
        do {
            $users_leg[($leg + 1)] = $this->number_of_all_downlines_at_leg($leg, $tree_key);
            $leg++;
        } while ($users_leg[($leg)] != 0);


        return ($users_leg);

    }


    /**
     * [referred_members_uplines fetches all this uses uplines up to the level
     * supplied :placement structure]
     * @param  int $level [description]
     * @return [type]        [description]
     */
    public function referred_members_uplines($level, $tree_key = 'placement')
    {

        $tree = self::$tree[$tree_key];
        $user_column = $tree['column'];


        //first include self
        $this_user_uplines[0] = $this;
        $upline = $this->$user_column;


        for ($iteration = 1; $iteration <= $level; $iteration++) {

            $upline_here = self::where('mlm_id', $upline)->where('mlm_id', '!=', null)->first();

            if ($upline_here != null) {

                $this_user_uplines[$iteration] = $upline_here;
            } else {
                break;
            }


            $upline = $this_user_uplines[$iteration][$user_column];

        }
        return $this_user_uplines;

    }


    public static function referred_members_downlines_paginated($user_id, $level_of_referral = 1, $requested_per_page = 1, $requested_page = 1, $tree_key = 'placement')
    {


        $tree = self::$tree[$tree_key];
        $user_column = $tree['column'];


        $recruiters = [$user_id];
        for ($iteration = 1; $iteration <= $level_of_referral; $iteration++) {

            //ensure the pagination is on the last result set
            if ($iteration == $level_of_referral) {
                $page = $requested_page;
                $per_page = $requested_per_page;
            } else {
                $page = 1;
                $per_page = 'all';
            }

            $downlines = User::referred_members_downlines_optimised($recruiters, $page);
            $recruiters = $downlines['list'];
        }

        $query = self::whereIn('mlm_id', $downlines['list']);


        $sieve = $_REQUEST;
        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $skip = (($page - 1) * $per_page);

        $filter = new  UserFilter($sieve);
        $total = $query->count();
        $data = $query->Filter($filter)->count();

        $list = $query->Filter($filter)
                        ->offset($skip)
                        ->take($per_page)
                        ->get();  //filtered

        $downlines = compact('list', 'total','sieve', 'data');


//        $downlines['list'] = self::whereIn('mlm_id', $downlines['list'])->get();
        return $downlines;
    }


    public static function referred_members_downlines_optimised(array $recruiters = [], $page = 1, $per_page = 'all', $tree_key = 'placement')
    {

        $tree = self::$tree[$tree_key];
        $user_column = $tree['column'];


        @$skip = ($page - 1) * $per_page;
        $sql_query = self::whereIn($user_column, $recruiters);
        $downlines['total'] = $sql_query->count();

        if ($per_page == 'all') {
            $downlines['list'] = $sql_query->get()->pluck(['mlm_id'])->toArray();
            $page = 1;
        } else {
            $downlines['list'] = $sql_query->offset($skip)->take($per_page)->get()->pluck(['mlm_id'])->toArray();

        }

        $downlines['page'] = $page;
        return $downlines;

    }


    /*
    *@param takes the depth of doenlnes to calaclate
    *returns array of this downlines
    */
    public function referred_members_downlines($level, $tree_key = "placement", $dedicated_sieve=null)
    {
        $tree = self::$tree[$tree_key];
        $user_column = $tree['column'];


        $recruiters = [$this->mlm_id];

        $sieve = $dedicated_sieve ?? $_REQUEST;


        $filter = new  UserFilter($sieve);
        for ($iteration = 1; $iteration <= $level; $iteration++) {

            $this_user_downlines[$iteration] = self::whereIn($user_column, $recruiters)
            ->where('mlm_id', '!=', null)
            ->Filter($filter)
            ->get(['mlm_id'])->toArray();




            $recruiters = $this_user_downlines[$iteration];
        }

        $this_user_downlines[0][0]['mlm_id'] = $this->mlm_id;


        foreach ($this_user_downlines as $downline => $members) {
            foreach ($members as $key => $member) {
                $member_full = $this::where('mlm_id', $member['mlm_id'])->first();
                $this_user_downlines[$downline][$key][$user_column] = $member_full->$user_column;
                $this_user_downlines[$downline][$key]['id'] = $member_full->id;
                $this_user_downlines[$downline][$key]['rank'] = $member_full->rank;
                $this_user_downlines[$downline][$key]['username'] = $member_full->username;
                $this_user_downlines[$downline][$key]['no_of_direct_line'] = User::where($user_column, $member['mlm_id'])->count();
            }

        }


        $this_user_downlines = array_filter($this_user_downlines, function ($item) {
            return $item != null;
        });

        return $this_user_downlines;

    }

    /*the placement structure ends*/


    /*the enroller strucure begins*/


    /**
     * [placement_legs returns all the user ids in all the available legs for this user]
     * @return [type] [array with key representing the leg index and value an array of userids]
     */
    public function placement_legs($tree_key = 'placement', $pluck = 'id')
    {
        $legs = ($this->referred_members_downlines(1, $tree_key)[1]);

        // print_r($legs);
        // $plucked_legs_ids =  $legs->pluck('id');


        foreach ($legs as $key => $user_array) {
            $user_obj = User::find($user_array['id']);
            $downlines = ($user_obj->all_downlines($tree_key));
            unset($downlines[0]);
            // echo "downlines<br>"; print_r($downlines);

            foreach ($downlines as $level => $downline) {
                $downline = collect($downline);
                /*
                 echo "leg $key and level $level <br>";
                     print_r($downline->pluck('id'));*/
                $user_ids = ($downline->pluck($pluck));

                foreach ($user_ids as $id) {
                    $result[$key][] = $id;
                }


            }

        }

        //include the front line user_id in the legs
        foreach ($legs as $key => $value) {
            $result[$key][] = $legs[$key][$pluck];
        }
        ksort($result);


        return ($result);

    }


    /*the enroller strucure ends*/


    public function supportTickets()
    {
        return $this->hasMany('SupportTicket', 'user_id');
    }


    public function getfullnameAttribute()
    {

        return "{$this->lastname} {$this->firstname}";
    }


    public function getNameInitialsAttribute()
    {

        return substr($this->lastname, 0 ,1)."".substr($this->firstname, 0 ,1);
    }


    public function getfullAddressAttribute()
    {
        $house_number ='';
        $address ='';
        $place ='';

        $getaddress = $this->addressArray;
        extract($getaddress);
        $country = $this->decoded_country->name ??'';
        $full_address = "$house_number, $address, $place. $country";

        return "$full_address";
    }



    public function decoded_country()
    {
        return $this->belongsTo('World\Country', 'country');
    }

    public function decoded_state()
    {
        return $this->belongsTo('World\State', 'state');
    }



    /**
     * is_blocked() tells whether a user is blocked or not
     * @return boolean true when blocked and false ff otherwise
     */
    public function is_blocked()
    {
        return boolval($this->blocked_on);
    }


    public function getresizedprofilepixAttribute($value)
    {
        $value = $this->resized_profile_pix;
        if (!file_exists($value) && (!is_dir($value))) {
            return (Config::default_profile_pix());
        }
        return $value;
    }

    public function getprofilepicAttribute()
    {
        $value = $this->profile_pix;
        if (!file_exists($value) && (!is_dir($value))) {
            return (Config::default_profile_pix());
        }

        return $value;

    }


    /**
     * [getFirstNameAttribute eloquent accessor for firstname column]
     * @param  [type] $value [description]
     * @return [string]        [description]
     */
    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * [getFirstNameAttribute eloquent accessor for firstname column]
     * @param  [type] $value [description]
     * @return [string]        [description]
     */
    public function getLastNameAttribute($value)
    {
        return ucfirst($value);
    }


    /**
     * eloquent mutators for password hashing
     * hashes user password on insert or update
     * @return
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = password_hash($value, PASSWORD_DEFAULT);
    }


}


?>