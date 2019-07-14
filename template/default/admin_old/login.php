
<?php 
$page_title = 'Login';
include 'includes/auth_header.php';?>


                <form class="form-horizontal form-material" id="loginform" action="<?=domain;?>/login/authenticateAdmin" method="post">
                    <h3 class="box-title mb-3">Sign In</h3>
                

                <?php if($this->inputError('credentials') != '' ):?>
                   <center class="alert alert-danger" >
                    <?=$this->inputError('credentials');?>
                   </center>
                <?php endif;?>
                

                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Username or Email" name="user"> </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="password" required="" placeholder="Password"> </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                           <!--  <div class="checkbox checkbox-primary float-left pt-0">
                                <input id="checkbox-signup" type="checkbox">
                                <label for="checkbox-signup"> Remember me </label>
                            </div> --> 
                            <a href="<?=domain;?>/forgot-password" id="to-recover" class="text-dark float-right"><i class="fa fa-lock mr-1"></i> Forgot pwd?</a> </div>
                    </div>
                    <div class="form-group text-center mt-3">
                        <div class="col-xs-12">
                            <button class="btn btn-secondary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>


                    <div class="form-group mb-0">
                        <div class="col-sm-12 text-center">
                            <p>Don't have an account? <a href="<?=domain;?>/register" class="text-success ml-1"><b>Sign Up</b></a></p>
                        </div>
                    </div>
                </form>




<?php include 'includes/auth_footer.php';?>
