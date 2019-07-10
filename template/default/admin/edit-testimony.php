<?php
$page_title = "Eidt Letter of Happiness";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Edit Letter of Happiness</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Edit Letter of Happiness</li>
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
                                        Edit Your Letter <i class="fa fa-plus"></i>
                                </a>
                            </div>

                            <div class="card-body collapse show" id="demo1">
                                <form action="<?=domain;?>/admin/update_testimonial" method="post" >
                                    <input type="hidden" name="testimony_id" value="<?=$testimony->id;?>">

                                  <div class="form-group">


                                    <div class="">
                                      <input required="" class="form-control textarea" value="<?=$testimony->attester;?>" name="attester" placeholder="Enter Name">
                                    </div>
                                    <br>


                                    
                                    <div class="">
                                      <textarea class="form-control textarea" name="testimony" placeholder="" style="height: 150px"><?=$testimony->content;?></textarea>
                                    </div>
                                  </div>

                                  <div class="">
                                    <button type="submit" class="btn btn-success">Update</button>
                                  </div>
                                </form>
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
