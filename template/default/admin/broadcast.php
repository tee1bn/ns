<?php
$page_title = "Broadcast";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Broadcast</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Broadcast</li>
                        </ol>
                    </div>
                </div>



                     <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header"  data-toggle="collapse" data-target="#demo1">
                                <a href="javascript:void;">
                                        Create Broadcast <i class="fa fa-plus"></i>
                                </a>
                            </div>

                            <div class="card-body collapse" id="demo1">

                                <form action="<?=domain;?>/admin/create_news" method="post" >
                                  <div class="form-group">
                                    
                                    <div class="">
                                      <textarea placeholder="Type your Message" class="form-control textarea" name="news" placeholder="" style="height: 150px"></textarea>
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
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="myTable" class="table table-hover">
                                        <thead>
                                            <th>Sn</th>
                                            <th style="width: 60%;">Message</th>
                                            <th>Date</th>
                                            <th>*</th>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; foreach (BroadCast::all() as $broadcast) :?>
                                            <tr>
                                                <td><?=$i;?></td>
                                                <td><?=$broadcast->broadcast_message;?></td>
                                                <td><?=$broadcast->created_at->toFormattedDateString();?></td>

                                                <td><a href="<?=domain;?>/admin/toggle_news/<?=$broadcast->id;?>"><button class="btn-xs btn-secondary btn">toggle Publish</button></a>
                    <a href="<?=domain;?>/admin/delete_news/<?=$broadcast->id;?>"><button class="btn-xs btn btn-danger"><i class="fa fa-trash"></i></button></a>

                   <?=$broadcast->status();?>
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
<script>
    $(function() {
        $('#myTable').DataTable();
    });
</script>
