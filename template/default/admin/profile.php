<?php
$page_title = "Profile";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0"> Profile</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active"> Profile</li>
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
                        width: 200px;
                        height: auto;
                        object-fit: contain;
                        border-radius: 100%;
                        border: 1px solid #0000000a;
                    }
                </style>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body row">
                                <div class="col-md-4" style="margin-bottom: 20px;">
                                    <form class="form-horizontal" id="p_form" method="post" enctype="multipart/form-data" action="<?=domain;?>/user-profile/update_profile_picture">
                                      <div class="user-profile-image" align="center" style="">
                                        <img id="myImage" src="<?=domain;?>/<?=$admin->profilepic;?>" alt="your-image" class="full_pro_pix" />
                                        <input type='file' name="profile_pix" onchange="form.submit();" id="uploadImage" style="display:none ;" />
                                        <h4><?=ucfirst($admin->username);?></h4>
                                        <h4><?=ucfirst($admin->fullname);?></h4>
                                        <?=$admin->activeStatus;?>
                                        <!-- <label for="uploadImage" class="btn btn-secondary " style=""> Change Picture</label> -->
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

                                            <form action="<?=domain;?>/admin-profile/updateAdminProfile/<?=$admin->id;?>" method="post">
                                              <input type="hidden" name="admin_id" value="">
                                              <div class="form-group">
                                                <label for="username" class="pull-left">Username *</label>
                                                  <input type="text" name="username"  value="<?=$admin->username;?>" id="username" class="form-control" value="">
                                              </div>

                                              <div class="form-group">
                                                    <label for="firstName" class="pull-left">First Name *</label>
                                                    <input type="text" name="firstname"  value="<?=$admin->firstname;?>" id="firstName" class="form-control">
                                              </div>

                                              <div class="form-group">
                                                    <label for="lastName" class="pull-left">Last Name <sup>*</sup></label>
                                                    <input type="text" name="lastname" id="lastName" class="form-control"  value="<?=$admin->lastname;?>">
                                              </div>

                                            <div class="form-group">
                                                <label for="email" class="pull-left">Email Address<sup>*</sup></label>
                                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <span class="input-group-btn input-group-prepend"></span>
                                                    <input id="tch3" name="email"   value="<?=$admin->email;?>"
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
                                                    <input id="tch3" name="phone"   value="<?=$admin->phone;?>"
                                                      data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline" class="form-control">
                                                    <span class="input-group-btn input-group-append">
                                                        <button class="btn btn-secondary btn-outline bootstrap-touchspin-up" type="button">Require Verification</button>
                                                    </span>
                                                </div> 
                                            </div>                                        
                                        
                                           
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
