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

                                    <div class="table-responsive">
                                    <table id="myTable" class="table table-striped">
            <thead>
              <tr>
                <th>Sn</th>
                <th>Title</th>
                <th>Description</th>
                <th>Cover</th>
                <th>Date</th>
                <th>Access</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach ($ebooks as $book):
                ?>
              <tr>
                <td><?=$i;?></td>
                <td>
                   <?=$book->title;?> <br>
               </td>

                <td>
                     <?=$book->description;?> <br>
               </td>


                <td><img src="<?=$book->coverpic;?>" style="width:40px;"></td>

                <td><span class="label label-primary"><?=$book->created_at->toFormattedDateString();?></span></td>
                <td><?=$book->AccessType;?></td>
                  <td>


                    <div class="dropdown">
                        <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
                            Action
                            <span class="caret"></span>
                        </button>
                      <ul class="dropdown-menu">
                            
                        <li>
                                     <a href="<?=domain;?>/user/download/<?=$book->id;?>" target="_blank" class="btn btn-primary btn-xs">
                                        Download                
                                    </a>
                        </li>
                      </ul>
                    </div>
                  
                    
                       



                </td>
              </tr>
                <?php $i++; endforeach;?>

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
