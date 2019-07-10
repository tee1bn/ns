<?php
$page_title = "Notifications";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Notifications</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Notifications</li>
                        </ol>
                    </div>
                  
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->

                <style>
                    .notification{

                        border: 1px solid #5bc28c73 !important;
                        padding: 10px;
                        margin: 5px;
                        text-align: justify;
                    }
                </style>



                <div class="row">
                    <div class="col-12">
                         <div class="card">
                            <div class="card-body row">
                                
                                <div class="col-md-12">

                                    <div class="card">

                                        <div class="card-header"  data-toggle="collapse" data-target="#demo1">
                                            <a href="javascript:void;">
                                                    Notifications <i class="fa fa-bell"></i>
                                            </a>
                                                    <span class="badge badge-lg badge-primary">
                                                        <?=$notifications->count();?>
                                                    </span>
                                        </div>

                                        <div class="card-body card-body-bordered collapse show" id="demo1" >


                                            <?php if(is_iterable($notifications)):?>

                                                <?php foreach ($notifications as $notification):?>


                                                    <div class="timeline-panel notification">
                                                        <div class="timeline-heading">
                                                            <h4 class="timeline-title"><?=$notification->heading;?></h4>
                                                            <p>
                                                                <small class="text-muted"><i class="far fa-clock"></i> 
                                                                    <?=$notification->created_at->format("M j Y - H:i A");?>
                                                                </small>

                                                                <small class="text-muted float-right">
                                                                    <?=$notification->seen_status();?>
                                                                </small>
                                                            </p>
                                                        </div>
                                                        <div class="timeline-body">
                                                            <p><?=$notification->message;?></p>
                                                        </div>
                                                    </div>


                                                <?php endforeach;?>


                                                
                                            <?php else:?>


                                                <div class="timeline-panel notification">
                                                    <div class="timeline-heading">
                                                        <h4 class="timeline-title"><?=$notifications->heading;?></h4>
                                                        <p>
                                                            <small class="text-muted"><i class="far fa-clock"></i> 
                                                                <?=$notifications->created_at->format("M j Y - H:i A");?>
                                                            </small>
                                                        </p>
                                                    </div>
                                                    <div class="timeline-body">
                                                        <p><?=$notifications->message;?></p>
                                                    </div>
                                                </div>

                                            <?php endif;?>


                                           
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
          

<?php include 'includes/footer.php';?>
