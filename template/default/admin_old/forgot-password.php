
<?php 
$page_title = 'Reset Password';
include 'includes/auth_header.php';?>


                <form class="form-horizontal form-material" id="loginform" action="<?=domain;?>/forgot-password/send_link" method="post">
                    <h3 class="box-title mb-3">Reset Password</h3>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Email" name="user"> </div>
                    </div>
                   

                    <div class="form-group text-center mt-3">
                        <div class="col-xs-12">
                            <button class="btn btn-success btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset Password</button>
                        </div>
                    </div>

                    <center style="padding:10px; text-decoration: none;">* A reset link will be sent to your email</center>
                    <div class="form-group mb-0">
                        <div class="col-xs-12 text-center">
                            <a href="<?=domain;?>/login" class="text-success">Sign in</a> Or
                            <a href="<?=domain;?>/register" class="text-success">Create New account</a>
                        </div>
                    </div>


                            </form>




<?php include 'includes/auth_footer.php';?>
