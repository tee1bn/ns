<!doctype html>
<html class="no-js" lang="en">
	
<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title><?=$page_title;?> | <?=project_name;?></title>
		<meta name="description" content="<?=$page_description;?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- favicon -->		
		<link rel="shortcut icon" type="image/x-icon" href="<?=$logo;?>">

		<!-- all css here -->

		<!-- bootstrap v3.3.6 css -->
		<link rel="stylesheet" href="<?=$this_folder;?>/css/bootstrap.min.css">
		<!-- owl.carousel css -->
		<link rel="stylesheet" href="<?=$this_folder;?>/css/owl.carousel.css">
		<link rel="stylesheet" href="<?=$this_folder;?>/css/owl.transitions.css">
        <!-- meanmenu css -->
        <link rel="stylesheet" href="<?=$this_folder;?>/css/meanmenu.min.css">
		<!-- font-awesome css -->
		<link rel="stylesheet" href="<?=$this_folder;?>/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?=$this_folder;?>/css/icon.css">
		<link rel="stylesheet" href="<?=$this_folder;?>/css/flaticon.css">
		<!-- magnific css -->
        <link rel="stylesheet" href="<?=$this_folder;?>/css/magnific.min.css">
		<!-- venobox css -->
		<link rel="stylesheet" href="<?=$this_folder;?>/css/venobox.css">
		<!-- style css -->
		<link rel="stylesheet" href="<?=$this_folder;?>/style.css">
		<!-- responsive css -->
		<link rel="stylesheet" href="<?=$this_folder;?>/css/responsive.css">

		<!-- modernizr css -->
		<script src="<?=$this_folder;?>/js/vendor/modernizr-2.8.3.min.js"></script>
	</head>
		<body>

		<!--[if lt IE 8]>
			<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->

        <!-- <div id="preloader"></div> -->
        <header class="header-two">
            <!-- header-area start -->
            <div id="sticker" class="header-area header-area-3 hidden-xs">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="header-center">
                                <div class="row">
                                    <!-- logo start -->
                                    <div class="col-md-3 col-sm-3">
                                        <div class="logo">
                                            <!-- Brand -->
                                            <a class="navbar-brand page-scroll sticky-logo" href="#">
                                                <img src="<?=$logo;?>" style="height: 58px;object-fit: cover;" alt="">
                                                <!-- MLE !)! -->
                                            </a>
                                        </div>
                                    </div>
                                    <!-- logo end -->

                                    <?php

                                        $menu =  [

                                                0=> [
                                                    'menu' => 'Home',
                                                    'link' =>  domain,
                                                    ],

                                                1=> [
                                                    'menu' => 'About us',
                                                    'link' =>  domain."/w/about-us",
                                                    ],

                                                2=> [
                                                    'menu' => 'How it works',
                                                    'link' =>  domain."/w/how-it-works",
                                                    ],

                                                3=> [
                                                    'menu' => 'Faqs',
                                                    'link' =>  domain."/w/faqs",
                                                    ],

                                                4=> [
                                                    'menu' => 'Contacts',
                                                    'link' =>  domain."/w/contacts",
                                                    ],

                                                ];




                                    ;?>





                                    <div class="col-md-9 col-sm-9">
                                       
                                        <!-- mainmenu start -->
                                        <nav class="navbar navbar-default">
                                            <div class="collapse navbar-collapse" id="navbar-example">
                                                <div class="main-menu">
                                                    <ul class="nav navbar-nav navbar-right">

                                                        <?php foreach ($menu as $item):?>
                                                            <li><a class="pagess" href="<?=$item['link'];?>"><?=$item['menu'];?></a>
                                                            </li>
                                                        <?php endforeach;?>
                                                           
                                                     
                                       
                                                        <li>
                                                            <a style="margin-bottom: 0px; " href="<?=domain;?>/register">
                                                            <button 
                                                                style="position: relative;top: -11px; margin-bottom: -29px;" 
                                                             class="btn-lg btn btn-success" >Sign Up</button>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </nav>
                                        <!-- mainmenu end -->
                                    </div>
                                    <!-- End column -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- header-area end -->
            <!-- mobile-menu-area start -->
            <div class="mobile-menu-area hidden-lg hidden-md hidden-sm">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mobile-menu">
                                <div class="logo">
                                    <a href="<?=domain;?>"><img src="<?=$logo;?>" style="margin-top:-20px; height: 72px;" alt="" /></a>
                                </div>
                                <nav id="dropdown">
                                    <ul>


                                        <?php foreach ($menu as $item):?>
                                            <li><a class="pagess" href="<?=$item['link'];?>"><?=$item['menu'];?></a>
                                            </li>
                                        <?php endforeach;?>
                                           
                                     
                                         <li><a class="pagess" href="<?=domain;?>/login">Sign in</a></li>
                                         <li><a class="pagess" href="<?=domain;?>/register">Sign up</a></li>


                                    </ul>
                                </nav>
                            </div>					
                        </div>
                    </div>
                </div>
            </div>
            <!-- mobile-menu-area end -->		
        </header>

