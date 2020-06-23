<?php
$page_title = "Package";
include 'includes/header.php';; ?>


<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <?php include 'includes/breadcrumb.php'; ?>

        <h3 class="content-header-title mb-0">Overview of all support packages</h3>
            </div>

        </div>
        <div class="content-body">

            <style>
                .small-padding {
                    padding: 3px;
                }

                .xm-padding {
                    padding: 1px;
                }

                .popular {

                    text-align: center;
                    position: absolute;
                    top: -12px;
                    padding: 0px 10px 0px 10px;
                    border-radius: 4px;
                }
            </style>

            <div class="row match-height">
                <?php
                $subscriptions = SubscriptionPlan::available()->get();
                $display_order = SubscriptionPlan::$display_order;

                $sorted = $subscriptions->sortBy(function ($subscriptions) use ($display_order) {
                    return array_search($subscriptions->getKey(), $display_order);
                });

                foreach ($sorted as $subscription):?>

                    <div class=" col-md-4">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <img class="icon  customize-icon font-large-2" src="<?=$subscription->Image;?>"
                                         style="height: 110px;width: 100px;object-fit: contain;">

                                    <?php if ($subscription->id == $subscription::$popular) : ?>
                                        <h4 class="popular bg-primary text-white">Most Popular</h4>
                                    <?php endif; ?>

                                    <h6 class="card-subtitle text-muted"><b class="float-right">
                                            <?= $currency; ?><?= MIS::money_format($subscription->price); ?>
                                            /Month</b><br>
                                        <span class="float-left" style="font-size: 15px;font-weight: 900;"><?= $subscription->package_type; ?>
                                        </span>
                                        <small class="float-right">Excluding VAT <?= (int)$subscription->percent_vat; ?>
                                            %
                                        </small>
                                    </h6>
                                </div>

                                <div class="card-body">
                                                       <!-- <h6 class="card-subtitle text-muted">Support card subtitle</h6> -->
                                    <!-- <p class="card-text">Excluding VAT <?= (int)$subscription->percent_vat; ?>% </p> -->


                                    <ul class="list-group list-group-flush">
                                        <?php foreach (SubscriptionPlan::$benefits as $key => $benefit): ?>

                                            <li class="list-group-item use-bg xm-padding">
                                                <?php if (isset($subscription->DetailsArray['benefits'][$key]) && $subscription->DetailsArray['benefits'][$key] == 1) : ?>
                                                    <span class="badge badge-primary float-left"><i
                                                                class="fa fa-check-circle"></i></span>
                                                <?php else : ?>
                                                    <span class="badge bg-danger float-left"><i
                                                                class="fa fa-times-circle"></i></span>
                                                <?php endif; ?>
                                                &nbsp; &nbsp; <i class="text-muted"><?= $benefit['title']; ?></i>

                                            </li>

                                        <?php endforeach; ?>
                                    </ul>
                                    <br>

                                    <?php if (@$auth->subscription->payment_plan['price'] < $subscription->price): ?>
                                        <form
                                                id="upgrade_form<?= $subscription->id; ?>"
                                                method="post"
                                                class="ajax_form"
                                                data-overlay="in"
                                                data-function="initiate_payment"
                                                action="<?= domain; ?>/user/create_upgrade_request">


                                            <label>
                                                <input type="radio" required="" name="prepaid_month" value="1" onchange="set_payments(this);"> Monthly
                                                payment (Monthly automatic direct debit)
                                            </label>
                                            <br>

                                            <label>
                                                <input type="radio" required="" name="prepaid_month" value="6" onchange="set_payments(this);"> Service for 6 Months
                                            </label>
                                            <br>

                                            <label>
                                                <input type="radio" required="" name="prepaid_month" value="12" onchange="set_payments(this);"> Service for 12
                                                Months
                                            </label>

                                            <br>
                                            <br>
                                            <div class="form-group">
                                                <select class="form-control payment_method_selection" required="" name="payment_method">
                                                    <option value="">Select Payment method</option>
                                                    <?php foreach ($shop->get_available_payment_methods() as $key => $option): ?>
                                                        <option value="<?= $key; ?>"><?= $option['name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <input type="checkbox" name="" required="">
                                                    Accept the terms of Invite Solution Ltd.
                                                </label>
                                            </div>

                                            <input type="hidden" name="subscription_id"
                                                   value="<?= $subscription->id; ?>">

                                            <div class="form-group">
                                                <button href="#" class="btn btn-outline-teal">Buy</button>
                                            </div>
                                        </form>
                                    <?php endif; ?>

                                    <?php if (@$auth->subscription->payment_plan['id'] == $subscription->id): ?>
                                        <div class="form-group text-center">
                                            <button type="button" class="btn btn-primary btn-sm">Current <i
                                                        class="fa fa-check-circle"></i></button>
                                            <small><?= $auth->subscription->NotificationText; ?></small>
                                        </div>

                                    <?php endif; ?>

                                    <?php if ($subscription['id'] == 1): ?>
                                    <div class="text-center">
                                        <label>
                                            Tipster for merchant connection
                                        </label>
                                    </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>





            <br>

            <script>


                set_payments = function($radio){
                    if($radio.value==1){

                        $allowed = ['paypal', ''];

                    }else{
                        $allowed = ['coinpay', 'bank_transfer','paypal', ''];
                    }

                    $selects = $('.payment_method_selection');

                    for (var i = 0; i < $selects.length; i++) {
                        $select = $selects[i];

                        $select.value = "";

                        for (var x = 0; x < $select.children.length; x++) {
                            $option = $select.children[x]
                            $value = $option.value;

                            if ($allowed.includes($value)) {
                                $option.style.display = 'block';

                            }else{

                                $option.style.display = 'none';
                            }
                        }

                    }
                }







                initiate_payment = function ($data) {
                    try {

                        switch ($data.payment_method) {
                            case 'coinpay':
                                // code block
                                window.location.href = $base_url +
                                    "/shop/checkout?item_purchased=packages&order_unique_id=" + $data.id + "&payment_method=coinpay";

                                break;

                            case 'paypal':
                                // code block
                                window.location.href = $base_url +
                                    "/shop/checkout?item_purchased=packages&order_unique_id=" + $data.id + "&payment_method=paypal";

                                break;


                                case 'bank_transfer':

                                  window.location.href = $base_url+"/user/bank-transfer/"+$data.id+"/packages";

                                break;


                            case 'razor_pay':
                                // code block
                                window.SchemeInitPayment($data.id);
                                break;
                            default:
                            // code block
                        }

                    } catch (e) {

                    }

                }
            </script>

        </div>
    </div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php'; ?>
