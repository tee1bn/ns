<?php
$page_title = "Online Shop";
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

            <h3 class="content-header-title mb-0">Online Shop</h3>
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

            <style>
                .product-img{
                    width: 100% !important;
                    height: 400px !important;
                    object-fit: cover;
                }
            </style>

          <div class="row match-height">

            <div class="col-md-7">
                        <div class="card" style="">
                            <div class="card-content">
                                <div class="card-body">
                                   
                                    <div class="row">
                                        <div class="col-md-12">
                                           <img class="product-img" src="<?=domain;?>/<?=$auth->profilepic;?>">
                                        </div>
                                        <div class="col-md-10">
                                            <p></p>
                                            <h3>Dimontis HUP</h3>
                                            <span> Basic workshop for partners</span>
                                            <div class="row">
                                                
                                                <div class="col-md-6">
                                                    <label>Piece</label>
                                                    <input type="number" class="form-control" name="">
                                                </div>

                                                <div class="col-md-6 text-right">
                                                    <h3>4253<?=$currency;?></h3>
                                                    <small>Incl. VAT 20%</small>
                                            </div>
                                            </div>

                                        </div>
                                     
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                            <select class="form-control" >
                                <option>Select a payment method</option>
                            </select>
                            </div>
                            <div class="form-group col-md-6">
                                    <button class="btn btn-outline-dark btn-block">Buy Now</button>
                            </div>
                        </div>

                    </div>

  <div class=" col-md-5">
                        <div class="card" style="">
                            <div class="card-content">
                                <div class="card-body">
                                    <h4 class="card-tile border-0">Product description</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <?=CMS::fetch('media_content_of_lesson');?>
                                                
                                        </div>
                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

  


                   

</div>




        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>

