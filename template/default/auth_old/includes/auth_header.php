<!DOCTYPE html>
<!-- this header is for all login, registration, email verification and all -->
<html lang="en">

<head>
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
    <!-- Custom CSS -->
    <link href="<?=$this_folder;?>/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?=$this_folder;?>/css/colors/green.css" id="theme" rel="stylesheet">
   
     <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
</head>

<body>
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
    <section id="wrapper">
        <div class="login-register" style="background-image:url(<?=asset;?>/images/background/faces.jpgg);
        position: static; overflow-y: scroll;">    
        <div style="
                background: #0a1627;
                position: absolute;
                top: 0px;
                width: 100%;
                height: 100%;
                "

                > </div>    

                <div class="text-center">
                    <!-- <h1 class=" text-white"><?=project_name;?></h1> -->
                    <img style="width: 290px; position: relative; margin-bottom: 10px;" src="<?=logo;?>">
                </div>
            <div class="login-box card">
            <div class="card-body">
 <style>
        .login-register{
            padding: 2% 0 40% !important;
        }
    </style>
