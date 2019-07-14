<?php
$page_title = "Users";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Users</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div>
                 <!--    <div class="col-md-6 col-4 align-self-center">
                        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle btn-sm float-right ml-2"><i class="ti-settings text-white"></i></button>
                        <button class="btn float-right hidden-sm-down btn-success"><i class="mdi mdi-plus-circle"></i> Create</button>
                        <div class="dropdown float-right mr-2 hidden-sm-down">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> January 2019 </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"> <a class="dropdown-item" href="#">February 2019</a> <a class="dropdown-item" href="#">March 2019</a> <a class="dropdown-item" href="#">April 2019</a> </div>
                        </div>
                    </div> -->
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
                                        Users <i class="fa fa-plus"></i>
                                </a>
                            </div>

                            <div class="card-body collapse show" id="demo1">
                                <table id="myTable" class="table table-bordered table-striped">
                      <thead>
                          <tr>
              <th>#Ref</th>
                          <th>Name (Username)</th>
                          <th>Membership</th>
                          <th>Email</th>
                          <th>Joined</th>
                          <th>Status</th>
                          <th>Action</th>
            </tr>
          </thead>

                      

         <?php  $i=1; foreach (User::get() as $user) :
         $date   = $user->created_at->toFormattedDateString();   

         ?>

                          <tr>
                          <td><?=$user->id;?> </td>
                          <td style="text-transform: capitalize;">
                            <?=$user->fullname;?><br>
                           (<?=$user->username;?>)
                           </td>
                          <td><?=$user->subscription->package_type;?> </td>
                          <td><a href="mailto://<?=$user->email;?>"><?=$user->email;?></a></td>
                          <td><span class="badge badge-secondary"><?=$date;?></span></td>
                          <td><?=$user->activeStatus;?> </td>
                          <td>

                      <div class="dropdown">
                        <button type="button" class="btn btn-secondary btn-xs dropdown-toggle" data-toggle="dropdown">
                          
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" target="_blank" href="<?=$user->AdminViewUrl;?>">
                              <span type='span' class='label label-xs label-primary'>View</span>
                            </a>

                              <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                                new ConfirmationDialog('<?=domain;?>/admin/suspending_user/<?=$user->id;?>')">
                                        <span type='span' class='label label-xs label-primary'>Toggle Ban</span>
                                      </a>



                        </div>
                      </div>

                          </td>
                          </tr>
           
                     
           <?php $i++; endforeach ; ?>
        
                      </tbody>
                    </table>


                                
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
