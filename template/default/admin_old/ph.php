<?php
$page_title = "Provide Helps";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Provide Helps</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Provide Helps</li>
                        </ol>
                    </div>
                  
                </div>
             




                 <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header"  data-toggle="collapse" data-target="#demo">
                                <a href="javascript:void;">Provide Helps Requests</a>
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
                                            <?php $i=1; foreach (PH::all() as $ph_request) :

                                            $user = $ph_request->user;
                                            ?>
                                            <tr>
                                                <td><?=$ph_request->id;?></td>
                                                <td>
                                              <a target="_blank" href="<?=$user->AdminViewUrl;?>">
                                                    <?=$user->fullname;?> <br>
                                                    (<?=$user->username;?>)
                                                    </a> 
                                                </td>
                                                <td><?=$this->money_format($ph_request->amount);?></td>
                                                <td>
                                                    <span class="badge badge-sm badge-secondary">
                                                        <?=$ph_request->created_at->toFormattedDateString();?></td>
                                                    </span>
                                                <td><?=$ph_request->status();?>
                                                    
                                                    <span class="badge badge-sm badge-secondary">
                                                        <?=$ph_request->matched->count();?>                                                        
                                                    </span>
                                                </td>
                                                <td>

                                 <div class="dropdown">
                                    <button type="button" class="btn btn-secondary btn-xs dropdown-toggle" data-toggle="dropdown">
                                      
                                    </button>
                                    <div class="dropdown-menu">
                                        <?php if($ph_request->matched->isNotEmpty()) :?>
                                                        <a  class="dropdown-item"  href="<?=domain;?>/admin/ph_matches/<?=$ph_request->id;?>">
                                                            <span class="label label-sm label-warning">Open</span>
                                                        </a>
                                        <?php endif;?>

                                        <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                                            new ConfirmationDialog('<?=domain;?>/admin/delete_ph/<?=$ph_request->id;?>')">
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
