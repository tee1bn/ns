<?php
$page_title = "Accounts";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Accounts</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Accounts</li>
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
                         <div class="card">
                            <div class="card-body row">
                                
                                <div class="col-md-12">

                                    <div class="card">

                                        <div class="card-header"  data-toggle="collapse" data-target="#demo1">
                                            <a href="javascript:void;">
                                                    Change Password <i class="fa fa-lock"></i>
                                            </a>
                                        </div>

                                        <div class="card-body card-body-bordered collapse show" id="demo1" >

                                                           
         <form  method="post" action="<?=domain;?>/admin-profile/updatePassword" style="padding: 10px;">
              <?=$this->csrf_field('change_password');?>
                <div class="form-group">
               <input type="password" name="current_password" class="form-control" placeholder="Current Password">
                  <span class="text-danger"><?=$this->inputError('current_password');?></span>
                </div>

                <div class="form-group">
                  <input type="password"  name="new_password" class="form-control" placeholder="New Password">
                <span class="text-danger"><?=$this->inputError('new_password');?></span>
                </div>

                <div class="form-group">
                  <input type="password" name="confirm_password" class="form-control" placeholder="Confirm password">
                  <span class="text-danger"><?=$this->inputError('confirm_password');?></span>
               </div>

                <div class="row">
                  <div class="col-sm-6">
                    <button type="submit" class="btn btn-success btn-block btn-flat">Submit</button>
                  </div>
                  <!-- /.col -->
                </div>
            </form>






                                           
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
          

<?php include 'includes/footer.php';?>
