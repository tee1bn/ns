
<?php 
$page_title = 'Reset Password';
include 'includes/auth_header.php';?>


                <form class="form-horizontal form-material" id="loginform" action="<?=domain;?>/forgot-password/reset_password"
                 method="post">
                    <h3 class="box-title mb-3">Reset Password</h3>



                         <div class="form-group">
                             <input type="hidden" class="form-control" id="email" placeholder="Email Address" name="user" value="<?=$_SESSION['change_password_email'];?>" readonly required>
                        </div>



                        <div class="form-group">
                                <input type="Password" class="form-control" id="email" placeholder="New Password" name="new_password" value=""  required>
                             <small class="pull-left" style="color: red;">   <?=$this->inputError('new_password');?></small>
                        </div>



                        <div class="form-group">
                                <input type="Password" class="form-control" id="email" placeholder="Confirm New Password" name="confirm_new_password" value=""  required>
                             <small class="pull-left" style="color: red;">   <?=$this->inputError('confirm_new_password');?></small>
                            </div>


                        <div class="form-group text-center mt-3">
                            <div class="col-xs-12">
                                <button class="btn btn-success btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset Password</button>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <div class="col-xs-12 text-center">
                                <a href="<?=domain;?>/login" class="text-success">Sign in</a> Or
                                <a href="<?=domain;?>/register" class="text-success">Create New account</a>
                            </div>
                        </div>


                </form>




<?php include 'includes/auth_footer.php';?>
