<?php
$page_title = "Administrators";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Administrators</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Administrators</li>
                        </ol>
                    </div>
                  
                </div>
               

                <div class="row">
                    <div class="col-12">
                         <div class="card">
                            <div class="card-body row">
                                
                                <div class="col-md-12">

                                    <div class="card">


                                        <div class="card-header"  data-toggle="collapse" data-target="#demo1">
                                            <a href="javascript:void;">
                                                   Create Administrator <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                      
                                        <div class="card-body card-body-bordered collapse show" id="demo1" >

                                            <form action="<?=domain;?>/admin/create_admin" method="post">

                                              <div class="form-group">
                                                <label for="username" class="pull-left">Username *</label>
                                                  <input type="text" name="username"  value="<?=$admin->username;?>" id="username" class="form-control" value="">
                                              </div>

                                              <div class="form-group">
                                                    <label for="firstName" class="pull-left">First Name *</label>
                                                    <input type="text" name="firstname"  value="<?=$admin->firstname;?>" id="firstName" class="form-control">
                                              </div>

                                              <div class="form-group">
                                                    <label for="lastName" class="pull-left">Last Name <sup>*</sup></label>
                                                    <input type="text" name="lastname" id="lastName" class="form-control"  value="<?=$admin->lastname;?>">
                                              </div>

                                            <div class="form-group">
                                                <label for="email" class="pull-left">Email Address<sup>*</sup></label>
                                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <span class="input-group-btn input-group-prepend"></span>
                                                    <input id="tch3" name="email"   value="<?=$admin->email;?>"
                                                      data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline" class="form-control">
                                                    <span class="input-group-btn input-group-append">
                                                        <button class="btn btn-secondary btn-outline bootstrap-touchspin-up" type="button">Require Verification</button>
                                                    </span>
                                                </div> 
                                            </div>

                                        


                                            <div class="form-group">
                                                <label for="phone" class="pull-left">Phone<sup>*</sup></label>
                                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <span class="input-group-btn input-group-prepend"></span>
                                                    <input id="tch3" name="phone"   value="<?=$admin->phone;?>"
                                                      data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline" class="form-control">
                                                    <span class="input-group-btn input-group-append">
                                                        <button class="btn btn-secondary btn-outline bootstrap-touchspin-up" type="button">Require Verification</button>
                                                    </span>
                                                </div> 
                                            </div>                                        
                                        
                                           
                                              <div class="form-group">

                                                    <button type="submit" class="btn btn-secondary btn-block btn-flat">Update Profile</button>

                                              </div>
                                            </form>



                                           
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
                                <a href="javascript:void;">Administrators Lists</a>
                            </div>
                            <div class="card-body collapse show" id="demo">
                                <div class="table-responsive">
 <table id="myTable" class="table table-bordered table-striped">
                      <thead>
                          <tr>
              <th>#Ref</th>
                          <th>Name (Username)</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Created</th>
                          <th>Action</th>
            </tr>
          </thead>

                      

         <?php  $i=1; foreach (Admin::administrators() as $user) :
         $date   = $user->created_at->toFormattedDateString();   

         ?>

                          <tr>
                          <td><?=$user->id;?> </td>
                          <td style="text-transform: capitalize;">
                            <?=$user->fullname;?><br>
                           (<?=$user->username;?>)
                           </td>
                          <td><a href="mailto://<?=$user->email;?>"><?=$user->email;?></a></td>
                          <td><a href="tel://<?=$user->phone;?>"><?=$user->phone;?></a></td>
                          <td><span class="badge badge-secondary"><?=$date;?></span></td>
                          <td>
                      <a  href="<?=$user->AdminViewUrl;?>">
                        <span type='span' class='label label-xs label-primary'>View</span>
                      </a>
                      <?php if ($user->account_plan != 'demo') :?>
                      <a href="javascript:void;"  onclick="$confirm_dialog = 
                new ConfirmationDialog('<?=domain;?>/admin/suspending_admin/<?=$user->id;?>')">
                        <span  class='label label-xs label-danger fa fa-trash'> Delete </span>
                      </a>
                    <?php endif;?>


                          </td>
                          </tr>
           
                     
           <?php $i++; endforeach ; ?>
        
                      </tbody>
                    </table>                                </div>

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
