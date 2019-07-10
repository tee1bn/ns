<?php
$page_title = "Profile";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">My Profile</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">My Profile</li>
                        </ol>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <style>
                    .full_pro_pix{
                          width: 180px;
                          height: 180px;
                          object-fit: cover;
                          border-radius: 100%;
                          border: 1px solid #cc444433;
                    }
                </style>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body row">
                                <div class="col-md-4" style="margin-bottom: 20px;">
                                    <form class="form-horizontal ajax_form" id="p_form" method="post" enctype="multipart/form-data" action="<?=domain;?>/user-profile/update_profile_picture">
                                      <div class="user-profile-image" align="center" style="">
                                        <img id="myImage" src="<?=domain;?>/<?=$this->auth()->profilepic;?>" alt="your-image" class="full_pro_pix" />
                                        <input type='file' name="profile_pix" onchange="form.submit();" id="uploadImage" style="display:none ;" />
                                        <h4><?=ucfirst($this->auth()->username);?></h4>
                                        <h4><?=ucfirst($this->auth()->fullname);?></h4>
                                        <?=$this->auth()->activeStatus;?>
                                        <label for="uploadImage" class="btn btn-secondary " style=""> Change Picture</label>
                                        <span class="label label-primary">
                                            <?=$this->auth()->subscription->package_type;?>
                                        </span>
                                        <br>
                                        <!-- <span class="text-danger">*click update profile to apply change</span> -->
                                      </div>
                                    </form>
                                </div>

                                <div class="col-md-8">

                                    <div class="card">

                                        <div class="card-header"  data-toggle="collapse" data-target="#demo1">
                                            <a href="javascript:void;">
                                                    Edit Profile <i class="fa fa-plus"></i>
                                            </a>
                                        </div>

                                        <div class="card-body card-body-bordered collapse show" id="demo1" >

                                            <form id="profile_form"
                                            class="ajax_form" 
                                            action="<?=domain;?>/user-profile/update_profile" method="post">
                                              <div class="form-group">
                                                <label for="username" class="pull-left">Username *</label>
                                                  <input type="text" name="username" disabled="disabled" value="<?=$this->auth()->username;?>" id="username" class="form-control" value="">
                                              </div>

                                              <div class="form-group">
                                                    <label for="firstName" class="pull-left">First Name *</label>
                                                    <input type="text" name="firstname"  value="<?=$this->auth()->firstname;?>" id="firstName" class="form-control">
                                              </div>

                                              <div class="form-group">
                                                    <label for="lastName" class="pull-left">Last Name <sup>*</sup></label>
                                                    <input type="text" name="lastname" id="lastName" class="form-control"  value="<?=$this->auth()->lastname;?>">
                                              </div>

                                            <div class="form-group">
                                                <label for="email" class="pull-left">Email Address<sup>*</sup></label>
                                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <span class="input-group-btn input-group-prepend"></span>
                                                    <input id="tch3" name="email"   value="<?=$this->auth()->email;?>"
                                                      data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline" class="form-control">
                                                    <span class="input-group-btn input-group-append">
                                                        <button class="btn btn-secondary btn-outline bootstrap-touchspin-up" type="button">Require Verification</button>
                                                    </span>
                                                </div> 
                                            </div>

                                        


                                            <div class="form-group">
                                                <label for="phone" class="pull-left">Phone<sup>*</sup></label>
                                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <span class="input-group-btn input-group-prepend"></span>
                                                    <input id="tch3" name="phone"   value="<?=$this->auth()->phone;?>"
                                                      data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline" class="form-control">
                                                    <span class="input-group-btn input-group-append">
                                                        <button class="btn btn-secondary btn-outline bootstrap-touchspin-up" type="button">Require Verification</button>
                                                    </span>
                                                </div> 
                                            </div>                                        
                                        
                                            
                                           <!--    <div class="form-group">
                                                  <label for="bank_name" class="pull-left">Bank Name <sup>*</sup></label>
                                                  <input type="" name="bank_name"  value="<?=$this->auth()->bank_name;?>" id="bank_name" class="form-control" >
                                              </div>

                                                
                                            
                                              <div class="form-group">
                                                 <label for="bank_account_name" class="pull-left">Bank Account Name<sup></sup></label>
                                                  <input type="bank_account_name" name="bank_account_name"  value="<?=$this->auth()->bank_account_name;?>" id="bank_account_name" class="form-control" >
                                              </div>

                                            
                                            

                                            
                                              <div class="form-group">
                                                 <label for="bank_account_number" class="pull-left">Bank Account Number <sup></sup></label>
                                                  <input type="bank_account_number" name="bank_account_number"  value="<?=$this->auth()->bank_account_number;?>" id="bank_account_number" class="form-control" >
                                              </div> -->


                                              <div class="form-group">

                                                    <button type="submit" class="btn btn-secondary btn-block btn-flat">Update Profile</button>

                                              </div>
                                            </form>








                                           
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
               



<?php include 'includes/footer.php';?>
