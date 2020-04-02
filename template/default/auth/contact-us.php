<?php
$page_title = "Contact us";
include 'includes/header.php';

;?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">

    <div class="content-body">

      <div class="app-content "  ng-controller="ShopController">

        <div class="content-header row">
          <div class="content-header-left col-md-6 mb-2">
            <h3 class="content-header-title mb-0">Contact us</h3>
          </div>
          <div class="content-header-right text-md-right col-md-6">

          </div>
        </div>
        <div class="content-body">


          <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Card Title</h4>
                  </div>
                  <div class="card-content">
                    <div class="card-body">
                      <p>Basic card without any heading elements and border.</p>
                    </div>
                  </div>
                </div>
              </div>
             
            </div>




          <form class="contact-form mt-45" id="contact" method="post" action="<?=domain;?>/ticket_crud/create_ticket">
            <div class="card">
             <div  class="card-content collapse show">
              <div class="card-body card-dashboard">

                <!-- Contact FORM -->
                <div class="row">
                  <div class="col-md-12 col-lg-12">

                    <div class="form-field">
                      <input  class="form-control"
                      value="<?=$auth->full_name;?>" 
                      readonly="readonly"
                      id="name" type="" required="" name="full_name" placeholder="Your Name">

                      <input  class="form-control" id="email"
                      value="<?=$auth->email;?>" 
                      readonly="readonly"
                      type="" required="" name="email" placeholder="Email">
                    </div>
                    <div class="form-field">
                      <input  class="form-control" id="sub"
                      value="<?=$auth->phone;?>" 
                      readonly="readonly"
                      type="" required="" name="phone" placeholder="Phone">
                    </div>

                    <input type="hidden" name="from_client" value="true">

                  </div>
                  <div class="col-md-12 col-lg-12">
                    <div class="form-field">

                      <textarea class="form-control" id="message" rows="7" name="comment" required=""
                      placeholder="Your Message"></textarea>
                    </div>
                  </div>
                  <div class="col-md-6 col-offset-md-2">
                    <br>
                    <?=MIS::use_google_recaptcha();?>
                  </div>


                </div>
                <!-- END Contact FORM -->

              </div>
            </div>
          </div>


          <div class="col-md-12 col-lg-12 mt-30">
            <button class=" btn btn-outline-warning float-right" type="submit" id="submit" name="button">
              Send Message
            </button>
          </div>
        </form>

        <p> &nbsp;</p>

        <div class="row">

          
        </div>
      </div>
    </div>


  </div>
</div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php';?>
