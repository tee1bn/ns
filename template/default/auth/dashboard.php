<?php
$page_title = "Dashboard";
 include 'includes/header.php';?>
  <?php
    use v2\Models\Withdrawal;
    use v2\Models\ISPWallet;
    use Filters\Filters\UserFilter;
    use Apis\CoinWayApi;

    // $balances = Withdrawal::payoutBalanceFor($auth->id);

      $package =  $auth->subscription->payment_plan;
    // $pool_target = $auth->pool_target();

     $sieve = $_REQUEST;
     $filter = new  UserFilter($sieve);

      $direct_sales = $auth->all_downlines_by_path()->where('referred_by', $auth->mlm_id)->Filter($filter);
      $direct_sales_count = $direct_sales->count();

      $direct_merchants_ids =  $direct_sales->get(['id'])->pluck('id')->toArray();
      $direct_merchants_ids[] = $auth->id;


      $month = $_REQUEST['month'] ?? null;

      $api_response  = CoinWayApi::api($month);
      $own_merchants = $api_response[$auth->id]['tenantCount'] ?? 0;

      $total_merchants = $api_response->whereIn('supervisorNumber', $direct_merchants_ids)->sum('tenantCount');


      $professional_check = $auth->isp_silver(10);

      $today = date("Y-m-d");
      $silver_total_credit_incentive = ISPWallet::availableBalanceOnUser($auth->id, 'silber');
      $silver_total_entitled_incentive = ISPWallet::for($auth->id)->Category('silber')->Cleared( $today, 'month')->Pending()->sum('amount');

      $domain = Config::domain();
      $silver_coin = "$domain/template/default/app-assets/images/logo/silver-coin.png";
      $gold_coin = "$domain/template/default/app-assets/images/logo/gold-coin.png";

      $silver_total_credit_incentive = ISPWallet::availableBalanceOnUser($auth->id, 'silber');

      $gold_tab  = $auth->isp_gold();

      // die();
    ;?>




    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Dashboard</h3>
          </div>
          
         <!--  <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              <div class="btn-group" role="group">
                <button class="btn btn-outline-primary dropdown-toggle dropdown-menu-right" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Settings</button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item" href="card-bootstrap.html">Bootstrap Cards</a><a class="dropdown-item" href="component-buttons-extended.html">Buttons Extended</a></div>
              </div><a class="btn btn-outline-primary" href="full-calender-basic.html"><i class="ft-mail"></i></a><a class="btn btn-outline-primary" href="timeline-center.html"><i class="ft-pie-chart"></i></a>
            </div>
          </div> -->
        </div>
        <div class="content-body">



            <div class="row grouped-multiple-statistics-card">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                          <span class="card-icon primary d-flex justify-content-center mr-3">
                            <img class="icon p-1  customize-icon font-large-2 p-1" src="<?=$package->Image;?>" style="height: 130px;width: 100px;object-fit: cover;">
                          </span>
                          <div class="stats-amount mr-3 mt-3">
                            <h3 class="heading-text text-bold-600"> <?=$package->package_type;?> </h3>
                            <p class="sub-heading">Package</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                          <span class="card-icon danger d-flex justify-content-center mr-3 mt-3">

                            <div class="b-box">
                                <span class="d-box">
                                    <?=$own_merchants;?>
                                </span>
                            </div>
                          </span>
                          <div class="stats-amount mr-3 mt-3">
                            <h3 class="heading-text text-bold-600">Own</h3>
                            <small>Merchant Connections</small>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">
                          <span class="card-icon danger d-flex justify-content-center mr-3 mt-3">

                            <div class="b-box">
                                <span class="d-box">
                                    <?=$total_merchants;?>
                                </span>
                            </div>
                          </span>
                          <div class="stats-amount mr-3 mt-3">
                            <h3 class="heading-text text-bold-600">Total</h3>
                            <small>Merchant Connections</small>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="d-flex align-items-start">
                          <span class="card-icon danger d-flex justify-content-center mr-3 mt-3">

                            <div class="b-box">
                                <span class="d-box">
                                    <?=$direct_sales_count;?>
                                </span>
                            </div>
                                </span>
                          <div class="stats-amount mr-3 mt-3">
                            <h3 class="heading-text text-bold-600">Direct</h3>
                            <small>Sales Partner</small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

           

          <div class="row match-height">

            <div class="col-md-6">
                        <div class="card" style="">
                            <div class="card-content">
                                <div class="card-body">
                                    <h4 class="card-tile border-0">International Sales Pool - Silver Incentive
                                        <img src="<?=$silver_coin;?>" class="coin">
                                    </h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="b-box">
                                                <small>Total Credits</small>
                                                <span class="d-box">
                                                    <?=$silver_total_credit_incentive;?>
                                                </span>
                                            </div>

                                            <div class="b-box">
                                                <small>Entitled</small>
                                                <span class="d-box">
                                                    <?=$silver_total_entitled_incentive;?>
                                                </span>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-10">
                                            
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item small-padding">
                                                    <span class=" float-right">
                                                        <?=$professional_check['fa'];?>
                                                    </span>
                                                    Package: Professional 
                                                </li>
                                                <li class="list-group-item small-padding">
                                                    <span class="float-right"><?=$professional_check['initial_activation'];?></span>
                                                    Initial activation: 
                                                </li>
                                                <li class="list-group-item small-padding">
                                                    <span class="float-right"><?=$professional_check['without_interuption'];?></span>
                                                    Without interuption since: 
                                                </li>
                                                <li class="list-group-item small-padding">
                                                    <span class="float-right"><?=$professional_check['next_coin'];?></span>
                                                  Next Silver-Coin: 
                                                </li>                                               
                                            </ul>

                                        </div>
                                     
                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

  <div class=" col-md-6">
                        <div class="card" style="">
                            <div class="card-content">
                                <div class="card-body">
                                    <h4 class="card-tile border-0">International Sales Pool - Silver 
                                        <img src="<?=$silver_coin;?>" class="coin">
                                    </h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="b-box">
                                                <small>Total Credits</small>
                                                <span class="d-box">
                                                    43453
                                                </span>
                                            </div>

                                            <div class="b-box">
                                                <small>Entitled</small>
                                                <span class="d-box">
                                                    43453
                                                </span>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-10">
                                            
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item ">
                                                    <div class="row">
                                                        
                                                    <span class="col-6">
                                                        Direct sales partner: 
                                                    </span>
                                                    <span class="col-4">
                                                        02/4  
                                                    </span>
                                                    <span class=" col-2">
                                                        <span class=" float-right">
                                                            <i class="ft-check fa-2x"></i>
                                                        </span>
                                                    </span>
                                                    </div>
                                                </li>

                                                <li class="list-group-item ">
                                                    <div class="row">
                                                        
                                                    <span class="col-6">
                                                        Own merchant connection: 
                                                    </span>
                                                    <span class="col-4">
                                                        02/4  
                                                    </span>
                                                    <span class=" col-2">
                                                        <span class=" float-right">
                                                            <i class="ft-check fa-2x"></i>
                                                        </span>
                                                    </span>
                                                    </div>
                                                </li>


                                            </ul>

                                        </div>
                                     
                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

  


  


            <div class=" col-md-6">
                        <div class="card" style="">
                            <div class="card-content">
                                <div class="card-body">
                                    <h4 class="card-tile border-0">International Sales Pool - Gold
                                        <img src="<?=$gold_coin;?>" class="coin">

                                    </h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="b-box">
                                                <small>Total Credits</small>
                                                <span class="d-box">
                                                    <?=$gold_tab['gold_total_credit'];?>
                                                </span>
                                            </div>

                                            <div class="b-box">
                                                <small>Entitled</small>
                                                <span class="d-box">
                                                    <?=$gold_tab['gold_total_entitled'];?>
                                                </span>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-10">
                                           
                                            
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item small-padding">

                                                    <div class="row">
                                                        
                                                    <span class="col-6">
                                                         Direct sales partner: 
                                                    </span>
                                                    <span class="col-4">
                                                        <?=$gold_tab['direct_sales_partner_count'];?>/<?=$gold_tab['direct_sales_partner_required'];?>
                                                    </span>
                                                    <span class=" col-2">
                                                        <span class=" float-right">
                                                            <?=$gold_tab['direct_sales_check'];?>
                                                        </span>
                                                    </span>
                                                    </div>

                                                   
                                                </li>

                                                  <!-- [total_sales_partner_required] => 10                                                -->
                                                <li class="list-group-item small-padding">

                                                    <div class="row">
                                                        
                                                    <span class="col-6">
                                                        Own merchant connections:
                                                    </span>
                                                    <span class="col-4">
                                                        <?=$gold_tab['own_merchants'];?>
                                                    </span>
                                                    <!-- <span class=" col-2">
                                                        <span class=" float-right">
                                                            <i class="ft-check fa-2x"></i>
                                                        </span>
                                                    </span> -->
                                                    </div>

                                                   
                                                </li>
                                                <li class="list-group-item small-padding">

                                                    <div class="row">
                                                        
                                                    <span class="col-6">
                                                        Direct sales partner
                                                        merchant connections:
                                                    </span>
                                                    <span class="col-4">
                                                        <?=$gold_tab['direct_sales_partner_merchant_connections'];?>/<?=$gold_tab['in_direct_active_merchants_required'];?>
                                                    </span>
                                                    <span class=" col-2">
                                                        <span class=" float-right">
                                                            <?=$gold_tab['in_direct_merchant_check'];?>
                                                        </span>
                                                    </span>
                                                    </div>

                                                   
                                                </li>
                                                <li class="list-group-item small-padding">

                                                    <div class="row">
                                                        
                                                    <span class="col-6">
                                                        Total sales partner:
                                                    </span>
                                                    <span class="col-4">
                                                        <?=$gold_tab['all_sales_partner'];?> 
                                                    </span>
                                                  
                                                    </div>

                                                   
                                                </li>
                                            </ul>

                                        </div>
                                     
                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>



            <div class=" col-md-6">
                        <div class="card" style="">
                            <div class="card-content">
                                <div class="card-body">
                                    <h4 class="card-tile border-0">Note: Clain for ISP</h4>
                                    <hr>
                                     <p class="card-text">
                                       <?=CMS::fetch('isp_dashboard_note');?>
                                     </p>
                                     
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <a href="<?=domain;?>/user/earnings" class="btn btn-block btn-outline-teal ">MY COMMISSIONS</a>
                    </div>


</div>




        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>

