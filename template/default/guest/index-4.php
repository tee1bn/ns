        
<?php 
$page_title = "Welcome Home";
$page_description = "";
include 'inc/header.php';


$settings = SiteSettings::site_settings();

$email = $settings['contact_email'];


;?>



        <!-- header end -->
        <!-- Start Slider Area -->
        <div class="intro-area intro-area-3">
           <div class="main-overly"></div>
            <div class="intro-carousel">
                <div class="intro-content">
                    <div class="slider-images">
                        <img src="<?=$this_folder;?>/img/slider/h1.jpg" alt="">
                    </div>
                    <div class="slider-content">
                        <div class="display-table">
                            <div class="display-table-cell">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- layer 1 -->
                                            <div class="layer-1-2">
                                                <h1 class="title2">Unleash <span class="color">Your Potential</span> convert 3rupees into 200 times!</h1>
                                            </div>
                                            <!-- layer 2 -->
                                            <div class="layer-1-1 ">
                                                <p>Here, we provide amazing schemes at unbelievable rates just to help you earn easily great amounts.</p>
                                            </div>
                                            <!-- layer 3 -->
                                            <div class="layer-1-3">
                                                <a href="<?=domain;?>/register" class="ready-btn left-btn" >Get started</a>
                                                <a href="<?=domain;?>/login" class="ready-btn right-btn">Sign In</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             
                <div class="intro-content">
                    <div class="slider-images">
                        <img src="<?=$this_folder;?>/img/slider/h1.jpg" alt="">
                    </div>
                    <div class="slider-content">
                        <div class="display-table">
                            <div class="display-table-cell">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- layer 1 -->
                                            <div class="layer-1-2">
                                                <h1 class="title2">Unleash <span class="color">Your Potential</span> convert 3rupees into 200 times!</h1>
                                            </div>
                                            <!-- layer 2 -->
                                            <div class="layer-1-1 ">
                                                <p>Here, we provide amazing schemes at unbelievable rates just to help you earn easily great amounts.</p>
                                            </div>
                                            <!-- layer 3 -->
                                            <div class="layer-1-3">
                                                <a href="<?=domain;?>/register" class="ready-btn left-btn" >Get started</a>
                                                <a href="<?=domain;?>/login" class="ready-btn right-btn">Sign In</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>

   <style type="text/css">
                    .owl-nav{
                        display: none;
                    }

                    .well-services{
                        padding: 0px !important;
                    }
                    
                </style>        </div>
        <!-- End Slider Area -->
        <!-- Welcome service area start -->
      <!--   <div class="welcome-area-2 area-padding">
            <div class="container">
                <div class="row">
                    <div class="all-services-top">
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="well-services">
							    <span class="base"><i class="flaticon-graph-6" ></i></span>
								<div class="well-icon">
									<a href="#">01</a>
								</div>
								<div class="well-content">
									<h4>Strategy & <br/> planning</h4>
									<p>programmes can generate dummy text using the starting sequence "Lorem ipsum". Fortunately, the phrase 'Lorem Ipsum' is now recognized by electronic pre-press systems and, when found, an alarm can be raised</p>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="well-services">
							    <span class="base"><i class="flaticon-graph" ></i></span>
								<div class="well-icon">
									<a href="#">02</a>
								</div>
								<div class="well-content">
									<h4>Marketing <br/> research</h4>
									<p>programmes can generate dummy text using the starting sequence "Lorem ipsum". Fortunately, the phrase 'Lorem Ipsum' is now recognized by electronic pre-press systems and, when found, an alarm can be raised</p>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="well-services">
							    <span class="base"><i class="flaticon-notes" ></i></span>
								<div class="well-icon">
									<a href="#">03</a>
								</div>
								<div class="well-content">
									<h4>Financial <br/> services</h4>
									<p>programmes can generate dummy text using the starting sequence "Lorem ipsum". Fortunately, the phrase 'Lorem Ipsum' is now recognized by electronic pre-press systems and, when found, an alarm can be raised</p>
								</div>
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
         -->

        <div class="welcome-area-2 area-padding">
            <div class="container">
                <div class="row">
                    <div class="all-services-top">
                       
                        <div class="col-md-6">
                            <div class="well-services">
                                <img src="<?=asset;?>/images/branding/in-img.png">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="well-services">
                                <img src="<?=asset;?>/images/branding/en-img.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Welcome service area End -->


        <div class="counter-area fix">
            <div class="container-full">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="fun-title">
                            <h3>This is our number of clients in worldwide. Clients wants to be work with us</h3>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="fun-content">
                            <div class="fun_text">
                                <i class="icon icon-smile"></i>
                                <span class="counter">5060</span>
                                <h5>Happy Customer</h5>
                            </div>
                            <!-- fun_text  -->
                            <div class="fun_text">
                                <i class="icon icon-license"></i>
                                <span class="counter">10050</span>
                                <h5>Complete project</h5>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end Row -->
            </div>
        </div>
        <!-- about-area start -->
     <!--    <div class="about-area bg-gray area-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="about-image">
                            <img src="<?=$this_folder;?>/img/about/ab.jpg" alt="">
                            <div class="video-content">
								<a href="https://www.youtube.com/watch?v=O33uuBh6nXA" class="video-play vid-zone">
									<i class="fa fa-play"></i>
								</a>
							</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="about-content">
                            <h4>The Present World Most Prestigious Consulting Firms In 2018.</h4>
                            <p class="hidden-sm">The phrasal sequence of the Lorem Ipsum text is now so widespread and commonplace that many DTP programmes can generate dummy text using the starting sequence "Lorem ipsum". Fortunately, the phrase 'Lorem Ipsum' is now recognized by electronic pre-press systems and, when found, an alarm can be raised.</p>
                            <div class="about-details">
                                <div class="single-about">
                                    <a href="#"><i class="icon icon-chart-bars"></i></a>
                                    <div class="icon-text">
                                        <h5>Certified company</h5>
                                        <p>The phrasal sequence of the Lorem Ipsum text is now so widespread that many the starting sequence</p>
                                    </div>
                                </div>
                                <div class="single-about">
                                    <a href="#"><i class="icon icon-license"></i></a>
                                    <div class="icon-text">
                                        <h5>Our experience</h5>
                                        <p>The phrasal sequence of the Lorem Ipsum text is now so widespread that many the starting sequence</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

      
      <!--   <div class="banner-area banner-area-2 fix area-padding" data-stellar-background-ratio="0.6">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="banner-content">
                            <div class="banner-text text-center">
                               <h3> We are expert teams for all Consultant work platfrom. You wants to be any advices.</h3>
                               <a class="hire-btn" href="#">Contact us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- End brand Banner area -->
    
        <!-- Start overview area -->
     <!--    <div class="overview-area bg-gray area-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="overview-inner">
                           <h6 class="small-title">Strong number</h6>
                           <h4><?=project_name;?> consultant firm worldwide serving 500+ clients and  globally with us 5500+ <span class="color">international consultants</span></h4>
                            <p>
                                Our independent consultants, free from the internal demands of traditional firms, can focus on what really matters: delivering lasting impact. Our consultants opt in to the projects they genuinely want to work on, committing wholeheartedly to delivering transformational change for the client, while being part of a strong team of like-minded professionals.
                            </p>
                            <p>
                                Our independent consultants, free from the internal demands of traditional firms, can focus on what really matters: delivering lasting impact. Our consultants opt in to the projects they genuinely want to work on, committing wholeheartedly.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="overview-images">
                           <canvas id="bissChart" width="300" height="240"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- End overview area -->
    
        <!-- Start Add area -->
        <div class="add-area area-padding parallax-bg" data-stellar-background-ratio="0.6">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="add-content">
                            <h4><?=project_name;?> consultant corporate company established since 1986</h4>
                            <div class="add-contact">
                                <!-- <span class="call-us"><i class="icon icon-phone-handset"></i>Toll free : +4321-7654543</span> -->
                                <span class="call-us mail-us"><i class="icon icon-envelope"></i>Mail us : 
                                    <?=$email;?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Add area -->
       


<?php include "inc/footer.php";?>