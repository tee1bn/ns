<!DOCTYPE html>
<html lang="en" ng-app="app">

<head>

    <?php 

        //require 'template/default/assets/drift_installation_code.php';

    ;?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?=$page_description;?>">
    <meta name="author" content="<?=$page_author;?>">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?=fav_icon;?>">
    <title><?=$page_title;?> | <?=project_name;?></title>
    <!-- Bootstrap Core CSS -->
    <link href="<?=asset;?>/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- datatable -->
    <link href="<?=asset;?>/plugins/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?=$this_folder;?>/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?=$this_folder;?>/css/colors/green.css" id="theme" rel="stylesheet">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
    <script src="<?=asset;?>/plugins/jquery/jquery.min.js"></script>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="<?=$this_folder;?>/js/gitstar/razorpayment.js"></script>

<style>
    
    @media only screen and (max-width: 600px) {
  #site_logo {

    position: relative;
    left: 30px;
  }
</style>



<body class="fix-header card-no-border">

    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="javascript:void;">
                        <!-- Logo icon -->
                        <b>
                           
                            <!-- Dark Logo icon -->
                            <!-- <img src="<?=asset;?>/images/logo-icon.png" alt="homepage" class="dark-logo" /> -->
                            <!-- Light Logo icon -->
                            <!-- <img src="<?=asset;?>/images/logo-light-icon.png" alt="homepage" class="light-logo" /> -->
                            <img id="site_logo" src="<?=logo;?>" style="width: 116px;" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span>
                        <!-- <b class="text-white" style="font-weight: 700;"><?=project_name;?></b> -->
                         <!-- dark Logo text -->
                         <!-- <img src="<?=asset;?>/images/logo-text.png" alt="homepage" class="dark-logo" /> -->
                         <!-- Light Logo text -->    
                         <!-- <img src="<?=asset;?>/images/logo-light-text.png" class="light-logo" alt="homepage" /></span> </a> -->
                </div>



                <div class="navbar-collapse">


                    <ul class="navbar-nav mr-auto mt-md-0 ">


                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="icon-arrow-left-circle"></i></a> </li>

                <!--         <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-message"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu mailbox animated bounceInDown">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <a href="#">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Luanch Admin</h5> <span class="mail-desc">Just see the my new admin!</span> <span class="time">9:30 AM</span> </div>
                                            </a>
                                            <a href="#">
                                                <div class="btn btn-success btn-circle"><i class="ti-calendar"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Event today</h5> <span class="mail-desc">Just a reminder that you have event</span> <span class="time">9:10 AM</span> </div>
                                            </a>
                                            <a href="#">
                                                <div class="btn btn-info btn-circle"><i class="ti-settings"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Settings</h5> <span class="mail-desc">You can customize this template as you want</span> <span class="time">9:08 AM</span> </div>
                                            </a>
                                            <a href="#">
                                                <div class="btn btn-primary btn-circle"><i class="ti-user"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
 -->

                      <!--   <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-email"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu mailbox animated bounceInDown" aria-labelledby="2">
                                <ul>
                                    <li>
                                        <div class="drop-title">You have 4 new messages</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <a href="#">
                                                <div class="user-img"> <img src="<?=asset;?>/images/users/1.jpg" alt="user" class="img-circle"> <span class="profile-status online float-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                                            </a>
                                            <a href="#">
                                                <div class="user-img"> <img src="<?=asset;?>/images/users/2.jpg" alt="user" class="img-circle"> <span class="profile-status busy float-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                                            </a>
                                            <a href="#">
                                                <div class="user-img"> <img src="<?=asset;?>/images/users/3.jpg" alt="user" class="img-circle"> <span class="profile-status away float-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Arijit Sinh</h5> <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
                                            </a>
                                            <a href="#">
                                                <div class="user-img"> <img src="<?=asset;?>/images/users/4.jpg" alt="user" class="img-circle"> <span class="profile-status offline float-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> <strong>See all e-Mails</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li> -->
                      
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                       <!--  <li class="nav-item hidden-sm-down">
                            <form class="app-search">
                                <input type="text" class="form-control" placeholder="Search for..."> <a class="srh-btn"><i class="ti-search"></i></a> </form>
                        </li> -->





                        <li class="nav-item dropdown" id="header-mini-cart" ng-controller ="CartNotificationController">

                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-shopping-cart"></i>
                                <div class="notify"> 
                                    <span class="heartbit"></span>
                                     <span class="badge badge-danger badge-xs"
                                     style="position: absolute;    bottom: 0px;left: 4px;">
                                         {{$cart.$items.length}}
                                     </span>
                                </div>
                            </a>
                            <div class="dropdown-menu mailbox animated bounceInDown">
                                <ul>

                                    <li>
                                        <div class="drop-title">Your Cart 
                                            <small class="float-right">
                                             {{$cart.$items.length}} Item(s)</small>
                                        </div>
                                    </li>
                                     <li class="dropdown-menu-header" ng-show="$cart.$items.length==0">
                                        <center class="dropdown-header m-0">
                                            <span class="grey darken-2">Your Cart is Empty</span>
                                        </center>
                                    </li>

                                        <div class="message-center">
                                        <li ng-repeat="($index, $item) in $cart.$items" >
                                                <a href="#">
                                                    <div class="btn btn-secondary btn-circle">
                                                        <i class="fa fa-list"></i>
                                                    </div>
                                                    <div class="mail-contnet">
                                                        <h5>{{$item.name}}</h5> 
                                                        <span class="">
                                                           <?=$currency;?>{{$item.price }}
                                                        </span>
                                                         <span class="time float-right">
                                                         x {{$item.qty}} </span> </div>
                                                </a>
                                              
                                        </li>
                                        </div>
                                 
                                    <li>

                                            <a href="#">
                                             
                                                <div class="mail-contnet">
                                                    <h5>TOTAL :
                                                        <small> <?=$currency;?> {{$cart.$total }}</small> 
                                                    </h5> 
                                                </div>
                                            </a>
                                      <!--                
                                        <a class="btn btn-secondary
                                         nav-link text-center" href="<?=domain;?>/user/view-cart">
                                          <strong>View Cart</strong>
                                         
                                        </a>  -->
                                        <a ng-hide="$cart.$items.length==0" class="btn mb-10 btn-secondary
                                         nav-link text-center" href="<?=domain;?>/user/view-cart"> <strong>Checkout</strong>
                                         <span class="mail-desc">
                                                    </span> 
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>




                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-message"></i>
                                <div class="notify"> <span class="heartbit"></span> 
                                        <span class="badge badge-danger badge-xs"
                                     style="position: absolute;    bottom: 0px;left: 4px;">
                                         <?=Notifications::unseen_notifications($auth->id)->count();?>
                                     </span>                                    
                                    <!-- <span class="point"></span>  -->
                                </div>
                            </a>
                            <div class="dropdown-menu mailbox animated bounceInDown">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <div class="message-center">

                                            <?php foreach ($auth->unseen_notifications() as $notification):?>

                                            <a href="<?=$notification->DefaultUrl;?>">
                                                <div class="btn btn-danger btn-circle"><i class="mdi mdi-message"></i></div>
                                                <div class="mail-contnet">
                                                    <h5><?=$notification->heading;?></h5> 
                                                    <span class="mail-desc"><?=$notification->short_message;?></span> <span class="time"><?=$notification->created_at->format('M j, Y');?>
                                                <!-- 24 May 2019 - 9:30 AM -->
                                            </span> </div>
                                            </a>
                                            <?php endforeach ;?>
                                           
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="<?=domain;?>/user/notifications"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>


                        <style type="text/css">
                            @media screen and (max-width: 400px) {
                             .remove-xs {
                                display: none;
                              }
                            }
                        </style>

                        <li>&nbsp;</li>
                        <li>&nbsp;</li>
                        <li>&nbsp;</li>
                        <li>&nbsp;</li>


                        <li class="nav-item dropdown">
                            <span class="text-white remove-xs"><?=$this->auth()->fullname;?></span>
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?=domain;?>/<?=$this->auth()->profilepic;?>" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="<?=domain;?>/<?=$this->auth()->profilepic;?>" alt="user"></div>
                                            <div class="u-text">
                                                <h4><?=$this->auth()->fullname;?></h4>
                                                <p class="text-muted"><?=$this->auth()->email;?></p>

                                                <a href="<?=domain;?>/user/profile" class="btn btn-rounded btn-danger btn-sm">
                                                    <?=$this->auth()->subscription->package_type;?>
                                                </a>
                                            </div>
                                        </div>
                                    </li>

                                    
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?=domain;?>/user/profile">
                                        <i class="ti-user"></i> My Profile</a></li>
                                    <li><a href="<?=domain;?>/user/scheme">
                                        <i class="ti-briefcase"></i> My Scheme</a>
                                    </li>
                                        
                                    <li><a href="<?=domain;?>/user/accounts"><i class="ti-settings"></i> Account Settings </a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?=domain;?>/login/logout"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                      
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">PERSONAL</li>
                      <!-- 
                        <li>
                            <a href="<?=domain;?>/user/dashboard" aria-expanded="false">
                                <i class="fa fa-home"></i>
                                <span class="hide-menu">Dashboard</span></a>
                        </li>  -->


                        <li>
                            <a class="has-arrow " href="<?=domain;?>/user/profile" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu"> My Profile</span></a>
                        </li>

                    
                  <!--       <li>
                            <a href="<?=domain;?>/user/subscription-orders" aria-expanded="false"><i class="fa fa-shopping-cart"></i><span class="hide-menu"> Orders</span></a>
                        </li> 
 -->

                         <li>
                            <a class="has-arrow " href="#" aria-expanded="false"><i class="fa fa-shopping-cart"></i><span class="hide-menu">My Schemes</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li>
                                    <a href="<?=domain;?>/user/subscription-orders" aria-expanded="false">
                                        Scheme 
                                    </a>  
                                </li>

                                <li>
                                    <a href="<?=domain;?>/user/products-orders" aria-expanded="false">
                                        Products
                                    </a>  
                                </li>
                            </ul>
                        </li>


                    
<!-- 
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false"><i class="fa fa-book"></i><span class="hide-menu">Library</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?=domain;?>/user/library_list">List </a></li>
                                <li><a href="<?=domain;?>/user/library">Grid</a></li>
                            </ul>
                        </li>

                        
                         -->


                        <?php

                            $settings = SiteSettings::site_settings();

                        ;?>


                         <li>
                            <a class="has-arrow " href="<?=domain;?>/user/earnings" aria-expanded="false">
                                <i class="mdi mdi-wallet"></i><span class="hide-menu">My Wallet</span>
                            </a>
                          <!--   <ul aria-expanded="false" class="collapse">
                                <li>
                                    <a href="<?=domain;?>/user/earnings" aria-expanded="false">
                                        Credits
                                    </a>  
                                </li>
                                <li>
                                    <a href="<?=domain;?>/user/withdrawals" aria-expanded="false">
                                        Debits
                                    </a>  
                                </li>
                            </ul> -->
                        </li>




                        <li>
                            <a href="<?=domain;?>/user/subscription" aria-expanded="false"><i class="fa fa-briefcase"></i><span class="hide-menu">Available Schemes</span></a>
                        </li> 




                        <li>
                            <a class="has-arrow " href="<?=domain;?>/user/shop" aria-expanded="false"><i class="fa fa-shopping-basket"></i><span class="hide-menu"> Shop</span></a>
                        </li>



                        <li>
                            <a class="has-arrow " href="<?=domain;?>/genealogy/placement_list" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu"> My Team</span></a>
                        <!--     <ul aria-expanded="false" class="collapse">
                                <li><a href="<?=domain;?>/genealogy/placement">Team Tree</a></li>
                                <li><a href="<?=domain;?>/genealogy/placement_list">Team List</a></li>
                            </ul> -->
                        </li>


    
                        <li>
                            <a class="has-arrow " href="<?=domain;?>/user/broadcast"
                             aria-expanded="false"><i class="fa fa-bullhorn"></i><span class="hide-menu">News & Communication</span></a>
<!--                             <ul aria-expanded="false" class="collapse">
                                <li><a href="<?=$settings['support_link'];?>">Support</a></li>
                                <li><a href="<?=domain;?>/user/broadcast">Broadcasts</a></li>
                                <li><a href="<?=domain;?>/user/write-testimony">Testimonials</a></li>
                            </ul>
 -->                        </li>
    
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->

        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->

    <!-- angularjs -->
    <script src="<?=asset;?>/angulars/angularjs.js"></script>
    <script src="<?=asset;?>/angulars/angular-sanitize.js"></script>
    <script>
        let $base_url = "<?=domain;?>";
        var app = angular.module('app', ['ngSanitize']);
    </script>
    <script src="<?=asset;?>/angulars/shop.js"></script>


            
            
    <script>
            

        Date.prototype.add_secs = function($secs) {    
           this.setTime(this.getTime() + ($secs*1000)); 
           return this;   
        }

    </script>

            
    <div class="page-wrapper" ng-controller="ShopController" id="content">

            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
             
                 <style>
                   
                    .card-body-bordered{
                            border: 1px solid #0000000a;
                    }
                </style>

