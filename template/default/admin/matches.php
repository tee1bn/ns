<?php
$page_title = "Matches";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Matches</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Matches</li>
                        </ol>
                    </div>
                  
                </div>
             




                 <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header"  data-toggle="collapse" data-target="#demo">
                                <a href="javascript:void;">Matches</a>
                            </div>
                            <div class="card-body collapse show" id="demo">
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-hover">
                                        <thead>
                                            <th>#Ref</th>
                                            <th>PHer</th>
                                            <th>PHR-GHR</th>
                                            <th>GHer</th>

                                            <th>Amount (<?=$currency;?>)</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>*</th>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; foreach (Match::all() as $match) :

                                            $ph = $match->ph;
                                            $gh = $match->gh;
                                            $ph_user = $ph->user;
                                            $gh_user = $gh->user;
                                            ?>
                                            <tr>
                                                <td><?=$match->id;?></td>
                                                <td>
                                                    <a target="_blank" href="<?=$ph_user->AdminViewUrl;?>">
                                                    <?=$ph_user->fullname;?> <br>
                                                    (<?=$ph_user->username;?>)
                                                    </a> 
                                                </td>
                                                <td>
                                                    <?=$ph->id;?> -
                                                    <?=$gh->id;?>
                                                    
                                                </td>
                                                <td>
                                                    <a class="" target="_blank" href="<?=$gh_user->AdminViewUrl;?>">
                                                    <?=$gh_user->fullname;?> <br>
                                                    (<?=$gh_user->username;?>)
                                                    </a> <br>
                                                </td>


                                                <td><?=$this->money_format($match->ph_amount);?></td>
                                                <td>
                                                    <span class="badge badge-sm badge-secondary">
                                                        <?=$match->created_at->toFormattedDateString();?></td>
                                                    </span>
                                                <td><?=$match->status();?>
                                                    
                                                </td>
                                                <td>

                                                    <div class="dropdown">
                                                      <button type="button" class="btn btn-secondary btn-xs dropdown-toggle" data-toggle="dropdown"></button>
                                                      <div class="dropdown-menu">
                                                        <a class="dropdown-item" target="_blank"
                                                            href="<?=domain;?>/<?=$match->payment_proof;?>">
                                                             See Proof
                                                        </a>   


                                                         <a onclick="$confirm_dialog = 
                                                            new ConfirmationDialog('<?=domain;?>/admin/confirm_gh_match/<?=$match->id;?>/<?=$match->gh->id;?>')"
                                                         class="dropdown-item" href="javascript:void;">
                                                           Confirm 
                                                        </a>


                                                         <a onclick="$confirm_dialog = 
                                                            new ConfirmationDialog('<?=domain;?>/admin/delete_match/<?=$match->id;?>/<?=$match->gh->id;?>')"
                                                         class="dropdown-item" href="javascript:void;">
                                                           Delete Match 
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
