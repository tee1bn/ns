<?php
$page_title = "Get Help";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Get Help</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Get Help</li>
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
                                                   Simulate Get Help <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                      
                                        <div class="card-body card-body-bordered collapse show" id="demo1" >

                                            <form action="<?=domain;?>/admin/create_gh_request" method="post">
                                                
                                                <div class="form-group">
                                                    <label>Amount (<?=$currency;?>)</label>
                                                    <input required="" value="<?=Input::old('amount');?>"
                                                     type="number" class="form-control" name="amount">
                                                    <small class="text-danger"><?=Input::inputError('amount');?></small>
                                                </div>

                                                <div class="form-group">
                                                    <label>Select Pioneer</label>
                                                    <select required="" class="form-control" name="pioneer">
                                                        <option value="">Select Active Pioneer</option>
                                                        <?php 
                                                        foreach (User::Pioneers()
                                                            ->where('blocked_on', null)
                                                            ->get() as $pioneer)
                                                         :?>
                                                            <option value="<?=$pioneer->id;?>">
                                                                <?=$pioneer->fullname;?> - <?=$pioneer->username;?></option>
                                                        <?php endforeach ;?>
                                                    </select>
                                                    <small class="text-danger"><?=Input::inputError('pioneer');?></small>
                                                </div>
                                                <div class="form-group">
                                                    <button class="btn btn-success">Create GH</button>
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
                                <a href="javascript:void;">Get Help Requests</a>
                            </div>
                            <div class="card-body collapse show" id="demo">
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-hover">
                                        <thead>
                                            <th>#Ref</th>
                                            <th>User</th>
                                            <th>Amount (<?=$currency;?>)</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>*</th>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; foreach (GH::all() as $gh_request) :

                                            $user = $gh_request->user;
                                            ?>
                                            <tr>
                                                <td><?=$gh_request->id;?></td>
                                                 <td>
                                              <a target="_blank" href="<?=$user->AdminViewUrl;?>">
                                                    <?=$user->fullname;?> 
                                                    (<?=$user->username;?>)
                                                    </a> 
                                                </td>
                                                <td><?=$this->money_format($gh_request->amount);?></td>
                                                <td>
                                                    <span class="badge badge-sm badge-secondary">
                                                        <?=$gh_request->created_at->toFormattedDateString();?></td>
                                                    </span>
                                                <td><?=$gh_request->status();?>
  
                                                    <span class="badge badge-sm badge-secondary">
                                                        <?=$gh_request->matched->count();?>                                                        
                                                    </span>                                              
                                                </td>
                                                <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-secondary btn-xs dropdown-toggle" data-toggle="dropdown">
                                      
                                    </button>
                                    <div class="dropdown-menu">
                                        <?php if($gh_request->matched->isNotEmpty()) :?>
                                                        <a  class="dropdown-item"  href="<?=domain;?>/admin/gh_matches/<?=$gh_request->id;?>">
                                                            <span class="label label-sm label-warning">Open</span>
                                                        </a>
                                        <?php endif;?>

                                        <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                                            new ConfirmationDialog('<?=domain;?>/admin/delete_gh/<?=$gh_request->id;?>')">
                                            <span type='span' class='label label-xs label-danger'>Delete</span>
                                        </a>
                                    </div>
                                </div>


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

<?php include 'includes/footer.php';?>
<script>
    $(function() {
        $('#myTable').DataTable();
    });
</script>
