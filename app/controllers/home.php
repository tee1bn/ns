<?php


use Apis\CoinWayApi;
use v2\Shop\Payments\Paypal\PaypalAgreement;
use v2\Shop\Shop;

// use v2\Shop\Payments\Paypal\Paypal as cPaypal;
// use v2\Shop\Payments\Paypal\Subscription;


/**
 * this class is the default controller of our application,
 *
 */
class home extends controller
{


    public function __construct()
    {

    }

    public function test2()
    {


        echo "<pre>";

        $coin_way = new CoinWayApi;
        $date = '2019-08-01';
        $today = $date ?? date("Y-m-d");
        $date_range = MIS::date_range($today);
        $url = "https://api.coinwaypay.com/api/supervisor/accounts?supervisor_number=1";
        $response = $coin_way->setPeriod($date_range['start_date'], $date_range['end_date'])
            ->setUrl($url)
            ->connect()
            ->get_response()
            ->keyBy('supervisorNumber');



            $response =  CoinWayApi::api($date);
            print_r($response);


        return;
        $wallet = SubscriptionOrder::find(87);


        print_r($wallet->toArray());

        $wallet->mark_paid();


        return;

        /*
                $gateway_ids = [
                    'paypal' => [
                        'id' => 'P-3NY20404Y0599152GCMJ5ZYY'
                    ],
                ];

                print_r($gateway_ids);
                print_r(json_encode($gateway_ids));

                return;
                // print_r($_SESSION['new_plan']);

                $plan = $_SESSION['new_plan'];

                print_r(current($plan)['id']);
        */
        // $agreement = new Subscription();
        $agreement = new PaypalAgreement();

        // print_r($agreement->activatePlan('P-13394434NH906533N6THFEZI'));

        // $plans = $agreement->listPlan();

        // print_r((array) $plans);
        // return;

        // print_r($seal);
        $subscription_plan = SubscriptionPlan::find(2);

        echo $id = $subscription_plan->getPlanId('paypal');


        $seal = $agreement->setPlanId($id)
            ->create();

        print_r($seal);
        return;
        // print_r($agreement->activatePlan('P-13394434NH906533N6THFEZI'));
        return;
        $_SESSION['new_plan'] = (array)$agreement->createSubscriptionPlan($subscription_plan);

        $plan = (array)$agreement->createSubscriptionPlan($subscription_plan);
        $subscription_id = current($plan)['id'];


        return;

        $subscription = new Subscription();

        print_r($subscription->activatePlan('P-13394434NH906533N6THFEZI'));
        // print_r($subscription->listPlan());
        // print_r($subscription->createSubscriptionPlan());


        $order = SubscriptionOrder::first();


        $shop = new Shop();

        $payment_details = $shop
            ->setOrder($order)//what is being bought
            ->setPaymentMethod('paypal')
            ->setOrderType('packages')//what is being bought
            ->initializePayment()
            ->attemptPayment();

        print_r($payment_details);

        return;/*							->receiveOrder($cart)
*/;


        // print_r($shop);


        return;


        $payment_settings =

            [
                'live' => [
                    'public_key' => "pk",
                    'secret_key' => "sk",
                    'wallet_id' => "wl",
                ],
                'test' => [
                    'public_key' => "pk",
                    'secret_key' => "sk",
                    'wallet_id' => "wl",
                ],

                'credential' => [
                    'public_key' => "pk",
                    'secret_key' => "sk",
                    'wallet_id' => "wl",
                ],

                'mode' => 'test'
            ];


        print_r(json_encode($payment_settings));


        return;


        /*$no_of_merchants = 20;
        $pools_settings = SiteSettings::pools_settings();
        foreach ($pools_settings as $key => $settings) {
            if ($no_of_merchants <= $settings['min_merchant_recruitment']) {
                $next_pool = $settings;
                break;
            }
        }


        print_r($next_pool);

        return;*/


        $coin_way = new CoinWayApi;

        $date_range = MIS::date_range(date("Y-m-d"));

        print_r($date_range);
        $response = $coin_way->setPeriod($date_range['start_date'], $date_range['end_date'])
            ->connect()
            ->get_response();

        echo "<pre>";

        print_r($response);


    }


    public function contact_us()
    {


        // verify_google_captcha();

        echo "<pre>";

        print_r($_REQUEST);
        extract($_REQUEST);

        $project_name = Config::project_name();
        $domain = Config::domain();

        $settings = SiteSettings::site_settings();
        $noreply_email = $settings['noreply_email'];
        $support_email = $settings['support_email'];
        $full_name = $_POST['firstname']." ".$_POST['lastname'];

        $email_message = "
			       <p>Dear Admin, Please respond to this support ticket on the $project_name admin </p>


			       <p>Details:</p>
			       <p>
			       Name: " . $full_name . "<br>
			       Phone Number: " . $phone . "<br>
			       Email: " . $email . "<br>
			       Comment: " . $comment . "<br>
			       </p>

			       ";


        $client = User::where('email', $_POST['email'])->first();
        $support_ticket = SupportTicket::create([
            'subject_of_ticket' => $_POST['comment'],
            'user_id' => $client->id,
            'customer_name' => $full_name,
            'customer_phone' => $_POST['phone'],
            'customer_email' => $_POST['email'],
        ]);

        $code = $support_ticket->id . MIS::random_string(7);
        $support_ticket->update(['code' => $code]);
        //log in the DB

        $client_email_message = "
			       Hello {$support_ticket->customer_name},

			       <p>We have received your inquiry and a support ticket with the ID: <b>{$support_ticket->code}</b>
			        has been generated for you. We would respond shortly.</p>

			      <p>You can click the link below to update your inquiry.</p>

			       <p><a href='{$support_ticket->link}'>{$support_ticket->link}</a></p>

	               <br />
	               <br />
	               <br />
	               <a href='$domain'> $project_name </a>


	               ";


        $support_email_address = $noreply_email;

        $client_email_message = MIS::compile_email($client_email_message);
        $email_message = MIS::compile_email($email_message);

        $mailer = new Mailer();

        $mailer->sendMail(
            $email_message,
            "$project_name Support - Ticket ID: $support_ticket->code",
            $client_email_message,
            "Support");


        $response = $mailer->sendMail(
            "$support_ticket->customer_email",
            "$project_name Support - Ticket ID: $support_ticket->code",
            $client_email_message,
            $support_ticket->customer_name
        );

        Session::putFlash('primary', "Message sent successfully.");

        Redirect::back();

        die();


    }


    public function test()
    {
        echo "<pre>";

        $site_settings = [];


        print_r(json_encode($site_settings));

    }


    /**
     * [flash_notification for application notifications]
     * @return [type] [description]
     */
    public function flash_notification()
    {
        header("Content-type: application/json");

        if (isset($_SESSION['flash'])) {
            echo json_encode($_SESSION['flash']);
        } else {
            echo "[]";
        }


        unset($_SESSION['flash']);

    }


    public function index($page = null)
    {

        Redirect::to('login');
    }


    public function about_us()
    {
        $this->view('guest/about');
    }


    public function how_it_works()
    {
        $this->view('guest/how-it-works');
    }

    public function contacts()
    {
        $this->view('guest/contact');
    }

    public function faqs()
    {
        $this->view('guest/faq');
    }


}


?>