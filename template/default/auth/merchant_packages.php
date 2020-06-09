<?php
$page_title = "Merchant Packages";
 include 'includes/header.php';?>
  <?php
    use v2\Models\Withdrawal;

    ;?>




    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Merchant</h3>
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

                      <?php foreach ($supervisor_turnover['licenses']??[] as $key => $license) :?>

                      <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                        <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                          <span class="card-icon primary d-flex justify-content-center mr-3">
                            <div class="b-box">
                                <span class="d-box">
                                    <?=$license['licenseCount'];?>
                                </span>
                            </div>                          </span>
                          <div class="stats-amount mr-3">
                            <h3 class="heading-text text-bold-600"><?=$license['licenseName'];?></h3>
                            <p class="sub-heading">Package</p>
                          </div>
                        </div>
                      </div>

                      <?php endforeach ;?>
<!-- 

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
                            <h3 class="heading-text text-bold-600">Advanced</h3>
                            <small>Package</small>
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
                            <h3 class="heading-text text-bold-600">Professional</h3>
                            <small>Package</small>
                          </div>
                        </div>
                      </div>
 -->

                      <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                        <div class="d-flex align-items-start">
                          <span class="card-icon warning d-flex justify-content-center mr-3">

                            <div class="b-box">
                                <span class="d-box">
                                    <?=$response['meta']['total'];?>
                                </span>
                            </div>
                                </span>
                          <div class="stats-amount mr-3">
                            <h3 class="heading-text text-bold-600">Merchant Connections</h3>
                            <small>Total</small>
                          </div>
                        </div>
                      </div>


                    </div>
                  </div>
                </div>
              </div>
            </div>

           

          <div class="row">

  
            <div class=" col-md-12">
                        <div class="card" style="">
                            <div class="card-content">
                                <div class="card-body">
                                  <?php //include_once 'template/default/composed/filters/merchant_packages.php';?>
                                    <hr>
                                    <div class="row table-responsive">

                                        <table class="table">
                                            <tr>
                                                <td></td>
                                                <td>Merchant ID</td>
                                                <td>Companies</td>
                                                <td>Level</td>
                                                <td>Package</td>
                                                <td>Phone</td>
                                                <td>Order date</td>
                                                <td>Status</td>
                                            </tr>
                                            <tbody>
                                              <?php $i=1; foreach ($response['values'] as $key => $merchant) :?>
                                                <tr>
                                                    <td><?=$i++;?></td>
                                                    <td><?=$merchant['id'];?></td>
                                                    <td><?=$merchant['name'];?></td>
                                                    <td>2</td>
                                                    <td>Professional</td>
                                                    <td><?=$merchant['phone'];?></td>
                                                    <td><?=date("d/m/Y", strtotime($merchant['createdAt']));?></td>
                                                    <td><?=$merchant['setupFeeState'];?></td>
                                                </tr>
                                              <?php endforeach  ;?>
                                            </tbody>
                                        </table>
                                     
                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>




</div>


<div>
    <small> * * Due to data protection regulations only contacts data may be angzeigt of dealers which you have connected personally. 
</small>
</div>


        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>

