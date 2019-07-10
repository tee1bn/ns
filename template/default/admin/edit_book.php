<?php
$page_title = "Edit Book";
 include 'includes/header.php';?>


                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Edit Book</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Edit Book</li>
                        </ol>
                    </div>
                        <div class="col-md-6 col-4 align-self-center">
                           <div class="dropdown float-right mr-2 hidden-sm-down">

                            <a href="<?=domain;?>/admin/add_book" class="btn btn-secondary " type="a"> 
                                Add Book <i class="fa fa-plus-circle"></i>
                           </a>
                           
                        </div>
                    </div>                </div>
             

                 <div class="row">
                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-header"  data-toggle="collapse" data-target="#demo">
                                <a href="javascript:void;">Edit Book</a>
                            </div>
                            <div class="card-body collapse in" id="demo">

                              <div class=" row">
                                
                              <div class="col-md-8" style="margin-right: 0px;">
                                <form action="<?=domain;?>/admin/update_ebook" method="post" enctype="multipart/form-data">

                                  <input type="hidden" value="<?=$ebook->id;?>" name="ebook_id">

                                  <div class="form-group">
                                    <label>Title</label>
                                    <input type="" value="<?=$ebook->title;?>" name="title" class="form-control">
                                  </div>
                                  
                                  <div class="form-group">
                                    <label>Access</label>
                                    <select class="form-control" name="subscription_access">
                                      <option value="">Select Access</option>
                                      <option value="free">Free</option>
                                      <?php foreach (SubscriptionPlan::all() as  $access) :?>
                                      <option value="<?=$access->id;?>"><?=$access->package_type;?></option>
                                      <?php endforeach ;?>
                                    </select>
                                  </div>
                                  
                                  <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description"><?=$ebook->description;?></textarea>
                                  </div>
                                            
                                  <div class="form-group">
                                    <label>Cover Image</label>
                                    <input type="file" name="cover_image" class="form-control">
                                  </div>
                                  
                                  <div class="form-group">
                                    <label>Ebook</label>
                                    <input type="file" name="ebook" class="form-control">
                                  </div>
                                       
                                  <div class="form-group">
                                    <button class="btn btn-primary">Save</button>
                                  </div>
                                  
                                </form>
                              </div>
                              <div class="col-md-4">
                                <div class="card">

                                  <div class="card-header">
                                      <a href="javascript:void;">EBook</a>
                                  </div>
                                  <div class="card-body">
                                    <ul>
                                      <li class="list-item">
                                        <a href="<?=domain;?>/admin/download_book/<?=$ebook->id;?>">Download</a></li>
                                    </ul>
                                    <img src="<?=$ebook->coverpic;?>" style="width: 100%;">
                                  </div>
                                </div>
                              </div>

                            </div>

                             </div>

                        </div>
                    </div>
                </div>

<?php include 'includes/footer.php';?>
<script>
    $(function() {
        $('#myTable').DataTable();
    });
</script>
