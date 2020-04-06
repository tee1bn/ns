<?php
$page_title = "Dashboard";
 include 'includes/header.php';?>
  <?php
    use v2\Models\Withdrawal;

    $balances = Withdrawal::payoutBalanceFor($auth->id);


    // $pool_target = $auth->pool_target();

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
                      <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                        <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                          <span class="card-icon primary d-flex justify-content-center mr-3">
                            <i class="icon p-1 ft-box customize-icon font-large-2 p-1"></i>
                          </span>
                          <div class="stats-amount mr-3">
                            <h3 class="heading-text text-bold-600">Professional</h3>
                            <p class="sub-heading">Package</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                        <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                          <span class="card-icon danger d-flex justify-content-center mr-3">

                            <div class="b-box">
                                <span class="d-box">
                                    453
                                </span>
                            </div>
                          </span>
                          <div class="stats-amount mr-3">
                            <h3 class="heading-text text-bold-600">Own</h3>
                            <small>Merchant Connections</small>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                        <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">
                          <span class="card-icon success d-flex justify-content-center mr-3">

                            <div class="b-box">
                                <span class="d-box">
                                    453
                                </span>
                            </div>
                          </span>
                          <div class="stats-amount mr-3">
                            <h3 class="heading-text text-bold-600">Total</h3>
                            <small>Merchant Connections</small>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                        <div class="d-flex align-items-start">
                          <span class="card-icon warning d-flex justify-content-center mr-3">

                            <div class="b-box">
                                <span class="d-box">
                                    453
                                </span>
                            </div>
                                </span>
                          <div class="stats-amount mr-3">
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

            <style>
               .d-box{
                    min-width: 70px;
                padding: 5px;
                padding-top: 20px;
                padding-bottom: 20px;
                display: block;
                text-align: center;
                border-radius: 5px;
                box-shadow: 0 10px 40px 0 rgba(62,57,107,.07), 0 2px 9px 0 rgba(62,57,107,.06);
                }
                .b-box{
                    margin-top: 5px;
                    margin-bottom: 10px;
                }
               
            </style>


          <div class="row">

            <div class="col-md-6">
                        <div class="card" style="">
                            <div class="card-content">
                                <div class="card-body">
                                    <h4 class="card-tile border-0">International Sales Pool - Silver Incentive</h4>
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
                                                <li class="list-group-item small-padding">
                                                    <span class=" float-right">
                                                        <i class="ft-check fa-2x"></i>
                                                    </span>
                                                    Package: Professional 
                                                </li>
                                                <li class="list-group-item small-padding">
                                                    <span class="float-right">02/04/2020</span>
                                                    Initial activation: 
                                                </li>
                                                <li class="list-group-item small-padding">
                                                    <span class="float-right">02/04/2020</span>
                                                    Without interuption since: 
                                                </li>
                                                <li class="list-group-item small-padding">
                                                    <span class="float-right">02/04/2020</span>
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
                                    <h4 class="card-tile border-0">International Sales Pool - Silver </h4>
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
                                    <h4 class="card-tile border-0">International Sales Pool - Gold</h4>
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
                                                <li class="list-group-item small-padding">

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
                                                <li class="list-group-item small-padding">

                                                    <div class="row">
                                                        
                                                    <span class="col-6">
                                                        Own merchant connections:
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
                                                <li class="list-group-item small-padding">

                                                    <div class="row">
                                                        
                                                    <span class="col-6">
                                                        Direct sales partner
                                                        merchant connections:
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
                                                <li class="list-group-item small-padding">

                                                    <div class="row">
                                                        
                                                    <span class="col-6">
                                                        Total sales partner:
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
                        <button class="btn btn-block btn-outline-teal ">MY COMMISSIONS</button>
                    </div>


</div>




        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>

