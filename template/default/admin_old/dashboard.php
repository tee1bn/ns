<?php

$page_title = "Dashboard";


 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                    <div class="col-md-6 col-4 align-self-center">
<!--                         <button class="right-side-toggle waves-effect waves-light btn-info btn-circle btn-sm float-right ml-2"><i class="fa fa-clock text-white"></i></button>
 -->                        <div class="dropdown float-right mr-2 hidden-sm-down">
                            <button class="btn btn-secondary " type="button"> 
                                Server Time: <?=date("M j, d g:i A");?>
                                <i class="fa fa-clock"></i>
                           </button>
                           
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <?php
                    $urgent_match = $this->auth()->urgent_match();
                    if ($urgent_match != null):
                        $recipient = $urgent_match->gh->user;
                  ?>
                 <div class="row">
                    <div class="col-12">

                               <div class="alert alert-danger text-danger">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                                    <h3 class="text-danger"><i class="fa fa-exclamation-circle"></i> Information
                                        <small class="badge badge-danger pull-right">
                                            Urgent -PH
                                        </small>
                                    </h3> 

 <div class="row">
                                     <div class="col-md-6">
                                    

                                                <i class="fa fa-user"></i>
                                                <?=$recipient->fullname?> - Recipient<br>
                                                   <a href="tel:<?=$recipient->phone;?>">
                                                        <i class="fa fa-phone-square"></i> <?=$recipient->phone?>
                                                    </a><br>
                                                    
                                                   <a href="mailto://<?=$recipient->email;?>">
                                                    <i class="fa fa-envelope"></i> <?=$recipient->email?></a><br>
                                    </div>  
                                    <div class="col-md-6">
                                    #<?=$urgent_match->id;?> <?=$urgent_match->status();?><br>

                                                <i class="fa fa-calendar"></i>

                                                    <?=$urgent_match->created_at->toFormattedDateString();?><br>
                                                     <?php if (! $urgent_match->is_complete()):?>
                                                <i class="fa fa-clock"></i>
                                                     <span class="label label-danger" id="demo_<?=$urgent_match->id;?>">8:9:0</span>        
                                     <script>
                                          // Set the date we're counting down to
                                              var $now = new Date();
                                                  $now.add_secs(<?=$urgent_match->secs_to_expire();?>);
                                          var countDownDate_<?=$urgent_match->id;?> = $now.getTime();

                                          // Update the count down every 1 second
                                          var x_<?=$urgent_match->id;?> = setInterval(function() {

                                              // Get todays date and time
                                              var now = new Date().getTime();


                                              
                                              // Find the distance between now an the count down date
                                              var distance = countDownDate_<?=$urgent_match->id;?> - now;
                                              
                                              // Time calculations for days, hours, minutes and seconds
                                              var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                              var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                              var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                              var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                                  hours+= days * 24;
                                              
                                              // Output the result in an element with id="demo_<?=$urgent_match->id;?>"
                                              document.getElementById("demo_<?=$urgent_match->id;?>").innerHTML =  hours + "h "
                                              + minutes + "m " + seconds + "s ";
                                              
                                              // If the count down is over, write some tex_<?=$urgent_match->id;?>t 
                                              if (distance < 0) {
                                                  clearInterval(x_<?=$urgent_match->id;?>);
                                                  document.getElementById("demo_<?=$urgent_match->id;?>").innerHTML = "TIMEOUT";
                                              }
                                          }, 1000);
                                    </script>

                                                     <?php endif;?>



                                </div>
                            </div>




                                </div>
                         
                    </div>
                </div>
            <?php endif ;?>

            <?php include 'includes/earnings_tab.php';?>


                <div class="row">
                    <!-- Column -->
<!--                     <div class="col-md-4">
                        <div class="card card-inverse card-info">
                            <div class="box bg-secondary text-center">
                                <h1 class="font-light text-white"><i class="fa fa-phone-square"></i></h1>
                                <h6 class="text-white"><a  href="javascript:void;" class="btn btn-primary">Verify Phone</a></h6>
                                <small class="text-white">You will be unable to get help if you do not verify your phone number</small>
                            </div>
                        </div>
                    </div>
 -->                    <!-- Column -->
                    <div class="col-md-6">
                        <div class="card card-inverse card-info">
                            <div class="box bg-secondary text-center">
                                <h1 class="font-light text-white">Telegram</h1>
                                <h6 class="text-white">
                                    <a target="_blank" href="<?=$settings['telegram_group_link'];?>"
                                 class="btn btn-primary">Join</a></h6>
                                <small class="text-white">Join the <?=project_name;?> Official Telegram Group</small>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                     <!-- Column -->
                    <!-- <div class="col-md-6">
                        <div class="card card-inverse card-info">
                            <div class="box bg-success text-center">
                                <h1 class="font-light text-white">Whatsapp</h1>
                                <h6 class="text-white"><a href="<?=domain;?>/verify/phone" class="btn btn-primary">Join</a></h6>
                                <small class="text-white">Join the <?=project_name;?> Official Whatsapp Group</small>
                            </div>
                        </div>
                    </div> -->
                    <!-- Column -->
                    <div class="col-md-6">
                        <div class="card card-secondary card-inverse">
                            <div class="box text-center">
                                <h1 class="font-light text-danger"><i class="fa fa-exclamation-triangle"></i></h1>
                                <small class="text-danger">WARNING!!! THIS IS A COMMUNITY OF MUTUAL FINANCIAL HELP! Participate only with spare money. Don't contribute all the money you have.</small>
                            </div>
                        </div>
                    </div>
                   
                </div>

                <div class="row">
                    <!-- Column -->
                    <div class="col-md-6 ">
                        <div class="card card-inverse card-info">
                            <div class="box bg-info text-center">
                                <h1 class="font-light text-white"><i class="fa fa-heart"></i></h1>
                                <h6 class="text-white"><a href="<?=domain;?>/user/ph" class="btn btn-primary">Provide Help</a></h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 ">
                        <div class="card card-success card-inverse">
                            <div class="box text-center">
                                <h1 class="font-light text-white"><i class="fa fa-gift"></i></h1>
                                <h6 class="text-white"><a href="<?=domain;?>/user/gh" class="btn btn-danger">Get Help</a></h6>
                            </div>
                        </div>
                    </div>
                </div>

<?php include 'includes/footer.php';?>
