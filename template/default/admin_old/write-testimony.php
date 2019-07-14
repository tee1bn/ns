<?php
$page_title = "Letter of Happiness";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Letter of Happiness</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Letter of Happiness</li>
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

                            <div class="card-header"  data-toggle="collapse" data-target="#demo1">
                                <a href="javascript:void;">
                                        Compose Your Letter <i class="fa fa-plus"></i>
                                </a>
                            </div>

                            <div class="card-body collapse" id="demo1">

                                <form id="testimony_form" 
                                class="ajax_form"
                                 action="<?=domain;?>/admin/create_testimonial" method="post" >
                                  <div class="form-group">
                                    
                                    <div class="">
                                      <input required="" class="form-control textarea" name="attester" placeholder="Enter Name">
                                    </div>
                                    <br>
                                    <div class="">
                                      <textarea required="" class="form-control textarea" name="testimony" placeholder="Enter Testimony" style="height: 150px"></textarea>
                                    </div>
                                  </div>

                                  <div class="">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                  </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



                 <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header"  data-toggle="collapse" data-target="#demo">
                                <a href="javascript:void;">Lists of Letters</a>
                            </div>
                            <div class="card-body collapse show" id="demo">
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-hover">
                                        <thead>
                                            <th>Sn</th>
                                            <th>Attester</th>
                                            <th style="width: 60%;">Letter</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th></th>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; foreach (Testimonials::all() as $testimony) :?>
                                            <tr>
                                                <td><?=$i;?></td>
                                                <td><?=$testimony->attester;?></td>
                                                <td><?=$testimony->content;?></td>
                                                <td><?=$testimony->status();?></td>
                                                <td><span class="badge badge-primary">
                                                    <?=$testimony->created_at;?></span></td>
                                                <td>
                                                    <a href="<?=domain;?>/admin/edit-testimony/<?=$testimony->id;?>" class="btn btn-secondary btn-xs">Edit
                                                    </a>

                                                      <a href="<?=domain;?>/admin/approve_testimonial/<?=$testimony->id;?>" class="btn btn-secondary btn-xs">Toogle Approval
                                                    </a>
                                                    <a href="<?=domain;?>/admin/delete_testimonial/<?=$testimony->id;?>" class="btn btn-danger btn-xs">Delete
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

                
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
          
<?php include 'includes/footer.php';?>
<script>
    $(function() {
        $('#myTable').DataTable();
    });
</script>
