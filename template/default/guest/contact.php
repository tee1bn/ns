       
<?php 
$page_title = "Contact us ";
$page_description = "";
include 'inc/header.php';

$settings = SiteSettings::site_settings();

$email = $settings['contact_email'];

;?>


        <!-- Start breadcumb Area -->
        <div class="page-area">
            <div class="breadcumb-overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcrumb">
                            <div class="bread-inner">
                            	<div class="section-headline white-headline">
									<h2>Contact <span class="color">us</span></h2>
								</div>
								<ul class="breadcrumb-bg">
									<li class="home-bread">Home</li>
									<li>Contact us</li>
								</ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End breadcumb Area -->
         <!-- Start contact Area -->
        <div class="contact-page area-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="contact-head">
                            <h3>Contact <span class="color">Details</span></h3>
                            <p>Any doubt or query contact us. We are there for you.</p>
                            <div class="contact-icon">
								<div class="contact-inner">
									<!-- <a href="#"><i class="icon icon-map"></i><span>Road-7 old Street, Manhatan</span></a>
									<a href="#"><i class="icon icon-phone"></i><span>+132-6565 7654</span></a> -->
									<a href="mailto://<?=$email;?>"><i class="icon icon-envelope"></i><span><?=$email;?></span></a>
								</div>
							</div>
                        </div>
                    </div>
                    <!-- End contact icon -->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="contact-form">
                            <div class="row">
                                <form  method="POST" class="ajax_form" id="sa" action="<?=domain;?>/home/send_message" >
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="name" class="form-control" placeholder="Name" required 
                                        >
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="email" class="email form-control" name="email" placeholder="Email" required 
                                        >
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" name="subject" class="form-control" placeholder="Subject" required 
                                        >
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <textarea name="message" rows="7" placeholder="Massage" class="form-control" required></textarea>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                        <button type="submit" id="submit" class="contact-btn">Submit</button>
                                        <div class="clearfix"></div>
                                    </div>   
                                </form>  
                            </div>
                        </div>
                    </div>
                    <!-- End contact Form -->
                </div>
            </div>
        </div>
        <!-- Start contact Area -->
      <!--   <div class="map-area area-padding bg-gray">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="map-area">
                            <div id="googleMap" style="width:100%;height:450px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 -->


<?php include 'inc/footer.php';?>
