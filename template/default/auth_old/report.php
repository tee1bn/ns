<?php
$page_title = "Reports";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Reports</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Reports</li>
                        </ol>
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
                         <div class="card">
                            <div class="card-body row">
                                
                                <div class="col-md-12">

                                    <div class="card">

                                        <div class="card-header"  data-toggle="collapse" data-target="#demo1">
                                            <a href="javascript:void;">
                                                Help <i class="fa fa-plus"></i>
                                            </a>
                                        </div>

                                        <div class="card-body card-body-bordered collapse show" id="demo1" >





                                           
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>




                 <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header"  data-toggle="collapse" data-target="#demo">
                                <a href="javascript:void;">Reports</a>
                            </div>
                            <div class="card-body collapse show" id="demo">
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-hover">
                                        <thead>
                                            <th>Sn</th>
                                            <th style="width: 60%;">Letter</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th></th>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; foreach ($this->auth()->testimonies as $testimony) :?>
                                            <tr>
                                                <td><?=$i;?></td>
                                                <td><?=$testimony->content;?></td>
                                                <td><?=$testimony->status();?></td>
                                                <td><?=$testimony->created_at->toFormattedDateString();?></td>
                                                <td>
                                                    <a href="<?=domain;?>/user/edit-testimony/<?=$testimony->id;?>" class="btn btn-secondary btn-xs">Edit
                                                    </a>
                                            </td>
                                            </tr>
                                            <?php $i++; endforeach ;?>
                                        </tbody>
                                    </table>
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
