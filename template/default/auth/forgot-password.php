<?php
$page_title = "Forgot Password";
include 'includes/auth_header.php';?>




					<h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                    <span style="padding:10px;" class="text-danger">* A reset link will be sent to your email</span>
					</h6>
				</div>
				<div class="card-content">	
					<div class="card-body" style="padding-top: 0px;">
  						
	                <form data-toggle="validator" class="ajax_form" id="loginform" action="<?=domain;?>/forgot-password/send_link" method="post">

		  							
							<fieldset class="form-group">
								<input required="" type="email" class="form-control form-control-lg" 
								placeholder="Enter Email" name="user" >
								<div class="form-control-position">
								    <i class="ft-user"></i>
								</div>
							</fieldset>


							<button type="submit" class="btn btn-primary btn-lg btn-block"><i class="ft-unlock"></i> 
							Reset Password</button>
						</form>
					</div>


                 


					<p class="text-center">Don't have an account? <a href="<?=domain;?>/register" class="card-link">Register</a> Or <a href="<?=domain;?>/login">Login</a></p>
				</div>
			</div>
		</div>
	</div>
</section>
        </div>
      </div>
    </div>
    <!-- END: Content-->
<?php include 'includes/auth_footer.php';