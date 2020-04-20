
<!DOCTYPE html>
<html ng-app="app" class="loading" lang="en" data-textdirection="ltr">
  <!-- BEGIN: Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="<?=@$page_description;?>">
    <meta name="keywords" content="<?=@$page_keywords;?>">
    <meta name="author" content="<?=$page_author;?>">
    <title><?=@$page_title;?> | <?=project_name;?></title>
    <link rel="apple-touch-icon" href="<?=$logo;?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?=$logo;?>">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->

    <link rel="stylesheet" type="text/css" href="<?=asset;?>/vendors/css/tables/datatable/datatables.min.css">    
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/vendors/css/charts/jquery-jvectormap-2.0.3.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/vendors/css/charts/morris.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/vendors/css/extensions/unslider.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/vendors/css/weather-icons/climacons.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/components.min.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/core/menu/menu-types/vertical-menu.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/core/colors/palette-gradient.min.css">
    <!-- link(rel='stylesheet', type='text/css', href=app_assets_path+'/css'+rtl+'/pages/users.css')-->
    <!-- END: Page CSS-->

    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/binary-tree.css">


    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css">
    <!-- END: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?=asset;?>/fonts/feather/style.min.css">

       <script src="https://cdn.ckeditor.com/4.11.4/full/ckeditor.js"></script>
    
    
    <script src="<?=asset;?>/tinymce/tinymce/tinymce.js" referrerpolicy="origin"></script>
    <!-- <script src="<?=asset;?>/js/jquery1.12.min.js"></script> -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  </head>
  <!-- END: Head-->


    <script src="<?=asset;?>/angulars/angularjs.js"></script>
    <script src="<?=asset;?>/angulars/angular-sanitize.js"></script>
    <script>
        let $base_url = "<?=domain;?>";
        var app = angular.module('app', ['ngSanitize']);


    </script>


  <!-- BEGIN: Body-->
  <body class="vertical-layout vertical-menu 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
      <div class="navbar-wrapper">
        <div class="navbar-header">
          <ul class="nav navbar-nav flex-row">
            <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
            <li class="nav-item"><a class="navbar-brand" href="<?=domain;?>"><img class="brand-logo" alt="stack admin logo" src="<?=$logo;?>" style="height: 32px;">
                <h2 class="brand-text" style="position: relative;font-size: 18px;bottom: 7px;"><?=project_name;?></h2></a></li>
            <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
          </ul>
        </div>
        <div class="navbar-container content">
          <div class="collapse navbar-collapse" id="navbar-mobile">
            <ul class="nav navbar-nav mr-auto float-left">
              <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>


              <!-- <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li> -->

            <!--   <li class="nav-item nav-search"><a class="nav-link nav-link-search" href="#"><i class="ficon ft-search"></i></a>
                <div class="search-input">
                  <input class="input" type="text" placeholder="Explore <?=project_name;?>...">
                </div>
              </li> -->
            </ul>
           <ul class="nav navbar-nav float-right">

                    <?php if (MIS::current_url() == "user/dashboard"):?>

                    <li class="nav-item">

                      <div>
<!-- 
                          <form action="?" method="get" style="display: inline;">

                        <div class="input-group" style="padding-top: 16px;">
                            <input type=""   class="form-control datepicker  form-control-sm" name="month" placeholder="month" aria-describedby="button-addon2">
                            <div class="input-group-append" id="button-addon2">
                              <button class="btn btn-outline-dark btn-sm " style="" type="submit">Go</button>
                            </div>
                        </div>
                          </form> -->
                      </div>
                    </li>

                    <script>

                      $(document).ready(function(){
                        var date_input=$('.datepicker'); //our date input has the name "date"
                        date_input.datepicker({
                          format: 'yyyy-mm',
                          toggleActive: true,
                          todayHighlight: true,
                          autoclose: true,
                        });
                      })
                    </script>

                    <?php endif ;?>


                    <li id="translator" class="nav-item" style="position: relative;top: 20px;"><div><?php require 'template/default/app-assets/translator.php';?> </div></li>



                
                      <!-- 

                    <li class="dropdown dropdown-user nav-item">
                      <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                        <span class="avatar avatar-online"><img src="<?=domain;?>/<?=$auth->profilepic;?>" alt="avatar">
                          <i></i></span><span class="user-name"><?=$auth->fullname;?></span></a>

                      <div class="dropdown-menu dropdown-menu-right">

                        <a class="dropdown-item" href="<?=domain;?>/user/profile">
                        <span class="badge badge-dark">
                          <?=$auth->subscription->payment_plan->package_type;?> 
                        </span>
                        </a>
                        <a class="dropdown-item" href="<?=domain;?>/user/profile">
                          <i class="ft-user"></i> Profile 
                        </a>
                        <a class="dropdown-item" href="<?=domain;?>/user/package"><i class="ft-briefcase"></i> Package</a>

                        <a class="dropdown-item" href="<?=domain;?>/user/accounts"><i class="ft-settings"></i> Account</a>
                        <div class="dropdown-divider"></div><a class="dropdown-item" href="<?=domain;?>/login/logout">
                          <i class="ft-power"></i> Logout</a>
                      </div>
                    </li> -->
                  </ul>
          </div>
        </div>
      </div>
    </nav>
    <!-- END: Header-->

    <style>
      
    .card-group,.card-header{

    border: 1px solid #c985294a;
    }

    .coin{
      
      height: 40px;
      position: absolute;
      right: 15px;
      top: 10px;
    }

    </style>

<script>
    $(function() {
        $('#myTable').DataTable();
    });
</script>

  <?php include 'sidebar.php';?>
  