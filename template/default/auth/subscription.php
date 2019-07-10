<?php
$page_title = "Schemes";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Schemes</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Schemes</li>
                        </ol>
                    </div>
                  
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                       <div class="card-body">
                                <div class="row pricing-plan">
                                    <?php
                                    $auth = $this->auth();

                                     foreach (SubscriptionPlan::available()->get() as  $subscription):
                                    ?>

                                    <div class="col-md-4 no-padding">
                                        <div class="pricing-box">
                                            <div class="pricing-body border-left">
                                                <div class="pricing-header">
                                                    <h4 class="text-center">
                                                        <?=$subscription->package_type;?>
                                                    </h4>
                                                    <h2 class="text-center"><span class="price-sign"><?=$currency;?></span><?=$subscription->price;?></h2>
                                                    <p class="uppercase">One time</p>
                                                </div>
                                                <div class="price-table-content">
                                                    <?php foreach 
                                                    ($subscription->featureslist as $feature):?>
                                                        <div class="price-row" 
                                                            style="text-transform: capitalize;">
                                                            <i class="icon-check"></i>
                                                             <?=$feature;?>
                                                        </div>
                                                    <?php endforeach;?>
                                                   
                                                    <div class="price-row">
                                                       <!--  <button 
                                                        onclick="$confirm_dialog = 
                                                        new ConfirmationDialog('<?=domain;?>/user/create_upgrade_request/<?=$subscription->id;?>')"         

                                                         class="btn btn-success waves-effect waves-light mt-3">Upgrade</button>
                                                          -->
                                                    <?php 
                                                        if (($subscription->hierarchy < $auth->subscription->hierarchy)
                                                            || ($auth->subscription==null)
                                                            ):




                                                            ?>
                                                        <form 
                                                        id="upgrade_form<?=$subscription->id;?>"
                                                        method="post"
                                                        class="ajax_form"
                                                        data-function="<?=$subscription->get_action()['function'];?>"
                                                        action="<?=$subscription->get_action()['action'];?>">
                                                                        
                                                                <button  
                                                                 class="btn btn-success waves-effect waves-light mt-3">Buy Now
                                                                </button>
                                                        </form>
                                                    <?php endif;?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach;?>
                                </div>
                            </div>
                    </div>
                </div>


                <script>
                    complete_upgrade = function($data){
                        window.SchemeInitPayment($data.id);
                    }

                    complete_secret_upgrade = function($data){
                        console.log('fddfs');

                        // window.notify();
                    }
                </script>


                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
          

<?php include 'includes/footer.php';?>
