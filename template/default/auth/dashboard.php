<?php

$page_title = "Dashboard";


 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                    <div class="col-md-6 col-4 align-self-center">
<!--                         <button class="right-side-toggle waves-effect waves-light btn-info btn-circle btn-sm float-right ml-2"><i class="fa fa-clock text-white"></i></button>
 -->                        <div class="dropdown float-right mr-2 hidden-sm-down">
                            <button class="btn btn-secondary " type="button"> 
                                Server Time: <?=date("M j, d g:i A");?>
                                <i class="fa fa-clock"></i>
                           </button>
                           
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
              
            <?php// include 'includes/earnings_tab.php';?>

 <div class="row">

                    <div class="col-md-4">
                        <div class="card card-success card-inverse">
                          <a href="javascript:void;" class="">
                            <div class="box text">
                                <h1 class="font-light text-white "><i class="fa fa-briefcase"></i>
                                  <span class="float-right">
                                    <?=$this->auth()->Sub;?>
                                  </span>
                                 
                               </h1>

                                 <small>
                                   
                                 </small>
                                  <a  class="btn btn-success text-white float-right">Subscription</a>

                                <h6 class="text-white">
                                </h6>
                            </div>
                          </a>
                        </div>
                    </div>
         <!--          
              <div class="col-md-4">
                        <div class="card card-success card-inverse">
                          <a href="javascript:void;" class="">
                            <div class="box text">
                                <h1 class="font-light text-white "><i class="fa fa-money"></i>
                                  <span class="float-right">
                                    <?=$this->auth()->subscription->package_type;?>
                                  </span>
                                  <small>
                                    <?=$currency;?><?=$this->money_format($this->auth()->Payout->sum('amount_earned'));?>
                                  </small>
                               </h1>

                                 <small>
                                   
                                 </small>
                                  <a  class="btn btn-success text-white float-right">
                                    <?=date('M');?>
                                     Payout -
                                     <?=$this->auth()->PayoutEligibity;?>
                                  </a>

                                <h6 class="text-white">
                                </h6>
                            </div>
                          </a>
                        </div>
                    </div>
                  

                    <div class="col-md-4">
                        <div class="card card-success card-inverse">
                          <a href="javascript:void;" class="">
                            <div class="box text">
                                <h1 class="font-light text-white "><i class="fa fa-sitemap"></i>
                                  <span class="float-right">
                                    <?=count($this->auth()->referred_members_downlines(1)[1]);?>
                                  </span>
                                  <small>
                                  </small>
                               </h1>

                                 <small>
                                   
                                 </small>
                                  <a  class="btn btn-success text-white float-right">Referrals</a>

                                <h6 class="text-white">
                                </h6>
                            </div>
                          </a>
                        </div>
                    </div> -->
                  
                  <!--   <div class="col-md-4 ">
                        <div class="card card-success card-inverse">
                          <a href="javascript:void;" class="">
                            <div class="box text">
                                <h1 class="font-light text-white "><i class="fa fa-plus"></i>
                                  <span class="float-right">
                                    <?=$currency;?><?=$this->money_format($this->auth()->earnings()->sum('amount_earned'));?>
                                  </span>
                                  <small>
                                  </small>
                               </h1>

                                 <small>
                                   
                                 </small>
                                  <a  class="btn btn-success text-white float-right">Total Credits</a>

                                <h6 class="text-white">
                                </h6>
                            </div>
                          </a>
                        </div>
                    </div>
                  

     
                    <div class="col-md-4 ">
                        <div class="card card-danger card-inverse">
                          <a href="javascript:void;" class="">
                            <div class="box text">
                                <h1 class="font-light text-white "><i class="fa fa-minus"></i>
                                  <span class="float-right">
                                    <?=$currency;?><?=$this->money_format($this->auth()->total_withdrawals());?>
                                  </span>
                                  <small>
                                  </small>
                               </h1>

                                 <small>
                                   
                                 </small>
                                  <a  class="btn btn-danger text-white float-right">Total Debits</a>

                                <h6 class="text-white">
                                </h6>
                            </div>
                          </a>
                        </div>
                    </div>
                  

     
                    <div class="col-md-4 ">
                        <div class="card card-inverse card-info">
                          <a href="javascript:void;" class="">
                            <div class="box text">
                                <h1 class="font-light text-white "><i class="fa fa-minus"></i>
                                  <span class="float-right">
                                    <?=$currency;?><?=$this->money_format($this->auth()->available_balance());?>
                                  </span>
                                  <small>
                                  </small>
                               </h1>

                                 <small>
                                   
                                 </small>
                                  <a  class="btn btn-info text-white float-right">Balance</a>

                                <h6 class="text-white">
                                </h6>
                            </div>
                          </a>
                        </div>
                    </div>
                  
 -->



                </div>

                <div class="row">
              
<!--                     <div class="col-md-12">
                        <div class="card card-inverse card-info">
                            <div class="box bg-secondary text-center">
                                <h1 class="font-light text-white"></h1>
                                <h6 class="text-white">
                                   </h6>
                                <small class="text-white">Join the <?=project_name;?> Official Telegram Group
                                
                                 <a target="_blank" href="<?=$settings['telegram_group_link'];?>"
                                 class="btn btn-primary">Join</a>
                                </small>


                            </div>
                        </div>
                    </div>
 -->           
                  <!--   <div class="col-md-12">
                        <div class="card card-warning card-inverse">
                            <div class="box text-center">
                                <h1 class="font-light text-danger"></h1>
                                <small class="text-danger"><i class="fa fa-exclamation-triangle"></i> WARNING!!! THIS IS A COMMUNITY OF MUTUAL FINANCIAL HELP! Participate only with spare money. Don't contribute all the money you have.</small>
                            </div>
                        </div>
                    </div>
                    -->
                </div>

               

<?php include 'includes/footer.php';?>
