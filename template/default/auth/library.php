<?php
$page_title = "Library";
 include 'includes/header.php';?>




    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Library</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Library</li>
                        </ol>
                    </div>
                    <div class="col-md-6 col-4 align-self-center">
                        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle btn-sm float-right ml-2"><i class="fa fa-clock text-white"></i></button>
                        <div class="dropdown float-right mr-2 hidden-sm-down">
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
                <div class="row">
                    <div class="col-12">
                       <div class="card-body">


                            <div class="card-header"  data-toggle="collapse" data-target="#demo">
                                <a href="javascript:void;">Library</a>
                            </div>
                            <div class="card-body collapse show" id="demo">


                            <div class="card-body table-responsive">


                        <div class="row">
                            <!-- column -->
                            <?php foreach ($ebooks as  $ebook) :?>
                            <div class="col-lg-3 col-md-6">
                                <!-- Card -->
                                <div class="card">
                                    <img class="card-img-top img-responsive" style="width:240 px; height: 180px;
                                    object-fit: cover;"
                                    src="<?=$ebook->coverpic;?>" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title"><?=$ebook->title;?></h4>
                                        <p class="card-text"><?=$ebook->description;?></p>
                                        <a href="<?=domain;?>/user/download/<?=$ebook->id;?>" class="btn btn-primary">Open</a>
                                    </div>
                                </div>
                                <!-- Card -->
                            </div>
                        <?php endforeach ;?>


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
