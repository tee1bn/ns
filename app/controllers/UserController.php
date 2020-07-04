<?php

use Filters\Filters\SupportTicketFilter;
use Filters\Filters\UserFilter;
use Filters\Filters\WalletFilter;
use Filters\Filters\OrderFilter;
use Filters\Filters\WithdrawalFilter;
use Filters\Filters\SubscriptionOrderFilter;
use Filters\Filters\MerchantFilter;
use Illuminate\Database\Capsule\Manager as DB;
use v2\Models\Document;
use v2\Models\Wallet;
use v2\Models\Withdrawal;
use v2\Shop\Shop;
use Apis\CoinWayApi;

require_once "app/controllers/shopController.php";


/**
 * this class is the default controller of our application,
 *
 */
class UserController extends controller
{


    public function __construct()
    {


        $company = $this->auth()->company;
        if ($company == null) {
            $company = Company::create(['user_id' => $this->auth()->id]);
        }


        if (!$this->admin()) {
            $this->middleware('current_user')
                ->mustbe_loggedin()
                ->must_have_verified_email();
            // ->must_have_verified_company()
        }


    }



    public function bank_transfer($order_id, $type)
    {
        $auth = $this->auth();


        $shop = new Shop;
        $class = $shop->available_type_of_orders[$type]['class'];


       $order = $class::where('id', $order_id)->where('payment_method', 'bank_transfer')
                                    ->where('user_id', $auth->id)
                                    ->where('paid_at', null)->first();




        if ($order==null) {
            // Session::putFlash('danger','Invalid Request');
            // Redirect::back();
        }

        Shop::empty_cart_in_session();

        $this->view('auth/deposit_bank_transfer', compact('order','type'));

    }


    public function show_invoice($order_id, $type)
    {
        $auth = $this->auth();
              

        $shop = new Shop;
        $class = $shop->available_type_of_orders[$type]['class'];



        $order = $class::where('id', $order_id)->where('payment_method', 'bank_transfer')
                                     ->where('user_id', $auth->id)
                                     ->where('paid_at', null)->first();


        if ($order==null) {
            // Session::putFlash('danger','Invalid Request');
            Redirect::back();
        }

        Shop::empty_cart_in_session();

        // $invoice = 
        // $invoice = 
        $order->getInvoice();


    }

    


    public function resources($category_key = null)
    {

        $category = Document::$categories[$category_key] ?? null;

        $documents = Document::where('category', $category)->get();
        $title = "$category";

        if ($documents->isEmpty()) {
            $documents = Document::get();
            $title = "All Documents";
        }

        $this->view('auth/resources', compact('title', 'documents'));

    }

    public function supportmessages($value = '')
    {
        $this->view('auth/support-messages');
    }

    public function invite_pro()
    {
        $this->view('auth/invite_pro');
    }


    public function merchant_packages()
    {
        $auth = $this->auth();



           $sieve = $_REQUEST;
           $coin_way = new CoinWayApi;
           $today = date("Y-m-d");


           $url = "https://api.coinwaypay.com/api/supervisor/accounts";

            $page = $_GET['page'] ?? 1;
            $per_page = 100;
            $coin_way->per_page = $per_page;
            $skip = ($per_page * ($page-1));


            $response = $coin_way
                ->setUrl($url)
                ->connect(['supervisor_number'=> $auth->id, 
                            '$top'=>$per_page,
                            '$skip'=>$skip
                        ], true, true)
                ->get_response()->toArray();



        $records = collect($response['values'])->countBy('licenseName')->toArray();

        $all_licenses = [
            'basic',
            'premium',
            'pro',
            // 'alt',
        ];
        

        foreach ($all_licenses as $licenseName => $value) {
             $license_key = strtoupper($value);
            if (! array_key_exists($license_key, $records)) {
                $records[$license_key] = 0;
            }
        }

        $collection = collect($response['values']);
        // print_r($collection);


        $sieve = $_REQUEST;
        $filter = new MerchantFilter($sieve);
        $result = $filter->sieve($collection);

        $note = MIS::filter_note($result->count(), count($response['values']), ($response['meta']['total']),  $sieve, 1);
       
        $this->view('auth/merchant_packages', compact('records','result', 'page', 'response', 'sieve','note','per_page'));
    }

    public function vp_packages()
    {
        $auth = $this->auth();

        $query = $auth->all_downlines_by_path('placement');


        $sieve = $_REQUEST;
        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $per_page = 50;
        $skip = (($page - 1) * $per_page);

        $filter = new  UserFilter($sieve);

        $total_sales_partner = $query->count();
        $data = $query->Filter($filter)->count();



        $today = date("Y-m-d");
        $subscriptions = SubscriptionOrder::where('paid_at', '!=', null)
            ->whereDate('expires_at', '<', $today)
        ;
        $query_2 = $auth->all_downlines_by_path('placement');
        $packages_count = $query_2
            ->joinSub($subscriptions, '$subscriptions', function ($join) {
                $join->on('users.id', '=', '$subscriptions.user_id');
            })
            ->select(DB::raw('count(*) as total'), 'plan_id')->groupBy('plan_id');

        $packages_count = $packages_count->get()->keyBy('plan_id');

        $ids = [
            'basic' => [1],
            'advanced' => [9],
            'professional' => [10]
        ];
        $packages_count_array = $packages_count->toArray();
        $total = [];
        foreach ($ids as $key =>  $id) {
            foreach ($id as $item) {
                $total[$key][] = $packages_count_array[$item]['total'] ?? 0;
            }
        }

        foreach ($ids as $key => $id) {
            $total[$key] = array_sum($total[$key]);
        }

        $total['basic'] = $total_sales_partner - ($total['advanced']) - ($total['professional']);

        $all_downlines = $query->Filter($filter)
            ->offset($skip)
            ->take($per_page)
            ->get();  //filtered

        $note = MIS::filter_note($all_downlines->count() , $data, $total_sales_partner,  $sieve, 1);

        $this->view('auth/vp_packages', compact('total','total_sales_partner','all_downlines', 'sieve', 'data','note','per_page'));
    }


    public function partner_packages()
    {
        $auth = $this->auth();

        $query = $auth->all_downlines_by_path('placement');


        $sieve = $_REQUEST;
        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $per_page = 50;
        $skip = (($page - 1) * $per_page);

        $filter = new  UserFilter($sieve);

        $total_sales_partner = $query->count();
        $data = $query->Filter($filter)->count();



        $today = date("Y-m-d");
        $subscriptions = SubscriptionOrder::where('paid_at', '!=', null)
            ->whereDate('expires_at', '<', $today)
        ;
        $query_2 = $auth->all_downlines_by_path('placement');
        $packages_count = $query_2
            ->joinSub($subscriptions, '$subscriptions', function ($join) {
                $join->on('users.id', '=', '$subscriptions.user_id');
            })
            ->select(DB::raw('count(*) as total'), 'plan_id')->groupBy('plan_id');

        $packages_count = $packages_count->get()->keyBy('plan_id');

        $ids = [
            'basic' => [1],
            'advanced' => [9],
            'professional' => [10]
        ];
        $packages_count_array = $packages_count->toArray();
        $total = [];
        foreach ($ids as $key =>  $id) {
            foreach ($id as $item) {
                $total[$key][] = $packages_count_array[$item]['total'] ?? 0;
            }
        }

        foreach ($ids as $key => $id) {
            $total[$key] = array_sum($total[$key]);
        }

        $total['basic'] = $total_sales_partner - ($total['advanced']) - ($total['professional']);

        $all_downlines = $query->Filter($filter)
            ->offset($skip)
            ->take($per_page)
            ->get();  //filtered

        $note = MIS::filter_note($all_downlines->count() , $data, $total_sales_partner,  $sieve, 1);

        $this->view('auth/partner_packages', compact('total','total_sales_partner','all_downlines', 'sieve', 'data','note','per_page'));
    }

    public function online_shop()
    {

        /*shop/full-view/41/product/*/

        $this->view('auth/online_shop_dummy');

        return;
        
        /*$shopController = new shopController;
        $shopController->full_view(41, 'product');*/
    }


    public function notifications($notification_id = 'all')
    {

        $auth = $this->auth();
        $per_page= 50;
        $page = $_GET['page']??1;

        switch ($notification_id) {
            case 'all':
            $notifications = Notifications::all_notifications($auth->id, $per_page, $page);
            $total = Notifications::all_notifications($auth->id)->count();
                break;
            
            default:
            
            $total = null;

            $notifications = Notifications::where('user_id', $auth->id)->where('id', $notification_id)->first();

            Notifications::mark_as_seen([$notifications->id]);


            if ($notifications == null) {
                Session::putFlash("danger", "Invalid Request");
                Redirect::back();
            }



            if ($notifications->DefaultUrl != $notifications->UsefulUrl) {

                Redirect::to($notifications->UsefulUrl);
            }

            break;
        }



        $this->view('auth/notifications', compact('notifications','per_page','total'));
    }




    public function company()
    {
        $company = $this->auth()->company;
        $this->view('auth/company', compact('company'));
    }



    public function download_request($item_id = null, $order_id = null)
    {

        $order = Orders::where('id', $order_id)
            ->where('user_id', $this->auth()->id)
            ->where('paid_at', '!=', null)
            ->first();
        $item = Products::find($item_id);

        if (($order_id == null) || ($item_id == null) || ($order == null) || (!$order->has_item($item_id))) {
            Redirect::back();
        }


        $item->download();
        Redirect::back();

        // print_r($order->order_detail());/

    }



    public function product_order($order_id=null)
    {

        $order  =  Orders::where('id', $order_id)->where('user_id', $this->auth()->id)->first();
        if ($order == null) {
            Redirect::back();
        }


        $this->view('auth/order_detail', compact('order'));
    }



    public function order($order_id = null)
    {

        $order = SubscriptionOrder::where('id', $order_id)->where('user_id', $this->auth()->id)->first();
        echo $this->buildView('auth/order_detail', compact('order'));

    }

    public function package_invoice($order_id = null)
    {
        $order = SubscriptionOrder::where('id', $order_id)->where('user_id', $this->auth()->id)->first();

        if ($order == null) {
            Redirect::back();
        }

        $order->getInvoice();
    }

    public function download_invoice($order_id = null)
    {
        $order_id = MIS::dec_enc('decrypt', $order_id);
        $order = SubscriptionOrder::where('id', $order_id)->first();

        if ($order == null) {
            Redirect::back();
        }

        $order->invoice();
    }


    public function products_orders()
    {


            $sieve = $_REQUEST;
            $query = Orders::where('id', '!=', null)->where('user_id', $this->auth()->id);
            $sieve = array_merge($sieve);
            
            $page = (isset($_GET['page']))?  $_GET['page'] : 1 ;
            $per_page = 50;
            $skip = (($page -1 ) * $per_page) ;

            $filter =  new  OrderFilter($sieve);

            $data =  $query->Filter($filter)->count();

            $result_query = Orders::query()->Filter($filter);

            $orders =  $query->Filter($filter)
                            ->offset($skip)
                            ->take($per_page)
                            ->latest()
                            ->get();  //filtered

        

            $shop = new Shop;


            $this->view('auth/products_orders', compact('orders',
                                                            'data',
                                                            'per_page',
                                                            'shop',
                                                            'sieve'));
        
    }




    public function cart()
    {
        $shop = new Shop;

        $cart = json_decode($_SESSION['cart'], true)['$items'];

        if (count($cart) == 0) {
            Session::putFlash("info","Your cart is empty.");
            Redirect::to('user/shop');
        }
        
        $this->view('auth/cart', compact('shop'));
    }






    public function view_cart()
    {

        $cart = json_decode($_SESSION['cart'], true)['$items'];

        if (count($cart) == 0) {
            Session::putFlash("info", "Your cart is empty.");
            Redirect::to('user/shop');
        }
        $this->view('auth/view_cart');
    }


    public function shop()
    {
        Redirect::to('user/online_shop');

        $products = $this->auth()->accessible_products();

        $this->view('auth/shop', compact('products'));
    }


    public function scheme()
    {

        $subscription = $this->auth()->subscription;

        if ($subscription == null) {

            Redirect::back();
        }

        $this->view('auth/subscription_confirmation', compact('subscription'));
    }


    public function download($ebook_id)
    {

        $ebook = Ebooks::find($ebook_id);
        $ebook->download();
    }


    public function create_upgrade_request($subscription_id = null)
    {

        $subscription_id = $_REQUEST['subscription_id'];
        /*
            $order = $this->auth()->subscription;
            if ($order->payment_state == 'automatic') {
                 $order->cancelAgreement();
            }
    */
        
        $response = SubscriptionPlan::create_subscription_request($subscription_id, $this->auth()->id);


        header("content-type:application/json");
        echo $response;

        // Redirect::back();
    }


    public function create_secret_upgrade_request($subscription_id)
    {

        $response = SubscriptionPlan::create_secret_subscription_request($subscription_id, $this->auth()->id);


        // Redirect::back();
    }

    public function my_invoices()
    {
        $this->package_orders();
    }

    public function package_orders()
    {
            $auth = $this->auth();
            $sieve = $_REQUEST;
            // $sieve = array_merge($sieve, $extra_sieve);

            $query = SubscriptionOrder::latest()->where('user_id', $auth->id);
            // ->where('status', 1);  //in review
            $sieve = array_merge($sieve);
            $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
            $per_page = 50;
            $skip = (($page - 1) * $per_page);

            $filter = new  SubscriptionOrderFilter($sieve);

            $data = $query->Filter($filter)->count();

            $subscription_orders = $query->Filter($filter)
                ->offset($skip)
                ->take($per_page)
                ->latest()
                ->get();  //filtered

            $this->view('auth/package_orders', compact('subscription_orders', 'sieve', 'data', 'per_page'));


        }


    public function package()
    {
        $shop = new Shop;
        $this->view('auth/package', compact('shop'));
    }


    public function reports()
    {
        $this->view('auth/report');
    }


    public function media()
    {
        $documents = Document::NotByCategory('downloads')->get()->groupBy('category')->toArray();
        $this->view('auth/media', compact('documents'));
    }


    public function downloads()
    {
        $documents = Document::ByCategory('downloads')->get()->groupBy('category')->toArray();


        $this->view('auth/downloads', compact('documents'));
    }



    public function make_withdrawal_request()
    {

        $settings = SiteSettings::site_settings();
        $min_withdrawal = $settings['minimum_withdrawal'];

        $currency = Config::currency();
        $amount = $_POST['amount'];


        if ($amount < $min_withdrawal) {
            Session::putFlash('info', "Sorry, Minimum Withdrawal is  $currency$min_withdrawal. ");
            Redirect::back();
        }

        LevelIncomeReport::create_withdrawal_request($this->auth()->id, $amount);

        Redirect::back();

    }




    public function make_withdrawal()
    {
        $this->view('auth/make_withdrawal');
    }

    public function payouts()
    {
        $this->withdrawals();
    }

    public function withdrawals()
    {

        $auth = $this->auth();

        $query = Withdrawal::where('user_id', $auth->id)->latest();

        $total = $query->count();

        $query = Withdrawal::where('user_id', $auth->id)->latest();
        $sieve = $_REQUEST;
        // ->where('status', 1);  //in review
        $sieve = array_merge($sieve);
        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $per_page = 50;
        $skip = (($page - 1) * $per_page);

        $filter = new  WithdrawalFilter($sieve);

        $data = $query->Filter($filter)->count();

        $withdrawals = $query->Filter($filter)
            ->offset($skip)
            ->take($per_page)
            ->get();  //filtered


        $note = MIS::filter_note($withdrawals->count() , $data, $total,  $sieve, 1);


        $this->view('auth/withdrawal-history', compact('withdrawals', 'sieve', 'data', 'per_page','note'));
    }




    public function update_testimonial()
    {

        echo "<pre>";
        $testimony_id = Input::get('testimony_id');
        $testimony = Testimonials::find($testimony_id);

        $attester = $this->auth()->lastname . ' ' . $this->auth()->firstname;


        $testimony->update([
            'attester' => $attester,
            'user_id' => $this->auth()->id,
            'content' => Input::get('testimony'),
            'approval_status' => 0
        ]);


        Session::putFlash('success', 'Testimonial updated successfully. Awaiting approval');

        Redirect::back();
    }


    public function create_testimonial()
    {
        if (Input::exists() || true) {

            $auth = $this->auth();

            $testimony = Testimonials::create([
                'attester' => $auth->lastname . ' ' . $auth->firstname,
                'user_id' => $auth->id,
                'content' => Input::get('testimony')]);

        }
        Redirect::to("user/edit_testimony/{$testimony->id}");
    }


    public function edit_testimony($testimony_id = null)
    {
        if (($testimony_id != null)) {
            $testimony = Testimonials::find($testimony_id);
            if (($testimony != null) && ($testimony->user_id == $this->auth()->id)) {

                $this->view('auth/edit_testimony', ['testimony' => $testimony]);
                return;
            } else {
                Session::putFlash('danger', 'Invalid Request');
                Redirect::back();
            }

        }

    }


    public function view_testimony()
    {
        $this->view('auth/view-testimony');
    }


    public function testimony()
    {
        $this->view('auth/testimony');
    }


    public function documents()
    {
        $show = false;
        $this->view('auth/documents', compact('show'));
    }


    public function news()
    {
        $this->view('auth/news');
    }

    public function language()
    {
        $this->view('auth/language');
    }


    public function profile()
    {
        $this->company();
        // $this->view('auth/profile');
    }



    public function commissions()
    {
        $this->earnings();
    }


    public function events_and_webinar()
    {
        $this->view("auth/events_and_webinar");
    }


    public function earnings()
    {

        $auth = $this->auth();

        $sieve = $_REQUEST;
        $sieve = array_merge($sieve);

        $query = Wallet::for ($auth->id)->latest();
        // ->where('status', 1);  //in review
        $sieve = array_merge($sieve);
        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $per_page = 50;
        $skip = (($page - 1) * $per_page);

        $filter = new  WalletFilter($sieve);

        $balance = $query->Credit()->sum('amount');

        $total = $query->count();

        $data = $query->Filter($filter)->count();

        $sql = $query->Filter($filter);

        $records = $query->Filter($filter)
            ->offset($skip)
            ->take($per_page)
            ->get();  //filtered


        $balance = Wallet::availableBalanceOnUser($auth->id);

        $note = MIS::filter_note($records->count() , $data, $total,  $sieve, 1);

        $this->view('auth/earnings', compact('records', 'balance', 'sieve', 'data', 'per_page', 'note'));
    }


    public function upload_payment_proof($id=null, $type='packages')
    {
        $order_id = $_POST['order_id'];


        $shop = new Shop;
        $class = $shop->available_type_of_orders[$type]['class'];


        $order = $class::find($order_id);

        if ($order->is_paid()) {

            Session::putFlash('danger', "#$order_id is already marked paid");
            Redirect::back();
        }

        $order->upload_payment_proof($_FILES['payment_proof']);
        Session::putFlash('success', "#$order_id Proof Uploaded Successfully!");
        Redirect::back();
    }


    public function upload_ph_payment_proof()
    {
        $directory = 'uploads/images/payment_proofs';

        $handle = new Upload($_FILES['payment_proof']);
        $match = Match::find(Input::get('match_id'));

        //if it is image, generate thumbnail
        if (explode('/', $handle->file_src_mime)[0] == 'image') {

            $handle->Process($directory);
            $original_file = $directory . '/' . $handle->file_dst_name;

            (new Upload($match->payment_proof))->clean();
            $match->update(['payment_proof' => $original_file]);


            Session::putFlash('success', 'Proof Uploaded Successfully!');
            Redirect::back();

        }

    }


    public function contact_us()
    {
        $this->view('auth/contact-us');

    }


    public function support()
    {
        $auth = $this->auth();

        $sieve = $_REQUEST;
        $sieve = array_merge($sieve);

        $query = SupportTicket::where('user_id', $auth->id)->latest();
        // ->where('status', 1);  //in review
        $sieve = array_merge($sieve);
        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $per_page = 50;
        $skip = (($page - 1) * $per_page);

        $filter = new  SupportTicketFilter($sieve);

        $data = $query->Filter($filter)->count();

        $tickets = $query->Filter($filter)
            ->offset($skip)
            ->take($per_page)
            ->get();  //filtered


        $this->view('auth/support', compact('tickets', 'sieve', 'data', 'per_page'));

    }


    public function view_ticket($ticket_id)
    {

        $support_ticket = SupportTicket::find($ticket_id);

        $this->view('auth/support-messages', [
            'support_ticket' => $support_ticket
        ]);


    }


    public function index()
    {
        Redirect::to('user/dashboard');

        $settings = SiteSettings::site_settings();
        $this->view('auth/dashboard', compact('settings'));
    }


    public function accounts()
    {
        $this->view('auth/accounts');

    }


    public function dashboard()
    {

        $settings = SiteSettings::site_settings();
        $this->view('auth/dashboard', compact('settings'));
    }

    public function broadcast()
    {

        $auth = $this->auth();

        $sieve = $_REQUEST;
        $query = BroadCast::Published()->latest();
        // ->where('status', 1);  //in review
        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $per_page = 50;
        $skip = (($page - 1) * $per_page);

        $data = $query->count();

        $news = $query
            ->offset($skip)
            ->take($per_page)
            ->get();  //filtered


        $this->view('auth/broadcast', compact('news', 'sieve', 'data', 'per_page'));

    }


}


?>