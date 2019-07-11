<?php
$page_title = "Register";
include 'includes/auth_header.php';?>




					<h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>Create Account</span></h6>
				</div>
				<div class="card-content">	
					<div class="card-body">
						<form class="form-horizontal form-simple" action="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/html/ltr/vertical-menu-template-semi-dark/index.html" novalidate>
							<fieldset class="form-group position-relative has-icon-left mb-1">
								<input type="text" class="form-control form-control-lg" id="user-name" placeholder="User Name">
								<div class="form-control-position">
								    <i class="ft-user"></i>
								</div>
							</fieldset>
							<fieldset class="form-group position-relative has-icon-left mb-1">
								<input type="email" class="form-control form-control-lg" id="user-email" placeholder="Your Email Address" required>
								<div class="form-control-position">
								    <i class="ft-mail"></i>
								</div>
							</fieldset>
							<fieldset class="form-group position-relative has-icon-left">
								<input type="password" class="form-control form-control-lg" id="user-password" placeholder="Enter Password" required>
								<div class="form-control-position">
								    <i class="fa fa-key"></i>
								</div>
							</fieldset>
							<button type="submit" class="btn btn-primary btn-lg btn-block"><i class="ft-unlock"></i> Register</button>
						</form>
					</div>
					<p class="text-center">Already have an account ? <a href="<?=domain;?>/login" class="card-link">Login</a></p>
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