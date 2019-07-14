<?php
$page_title = "Mavro";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Mavro</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Mavro</li>
                        </ol>
                    </div>
                  
                </div>
            

                <?php
                $mavros =  PH::Completed()->get();
                ;?>

                 <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header"  data-toggle="collapse" data-target="#demo">
                                <a href="javascript:void;">Mavro</a>
                                <span class="float-right">Total:
                                    <?=$currency;?><?=$this->money_format($mavros->sum('amount'));?></span>
                            </div>
                            <div class="card-body collapse show" id="demo">
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-striped">
                                        <thead>
                                            <th>#Ref</th>
                                            <th>User</th>
                                            <th>Amount (<?=$currency;?>)</th>
                                            <th>Worth (<?=$currency;?>)</th>
                                            <th>Growth</th>
                                            <th>Completed</th>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; foreach ($mavros as $mavro) :?>
                                            <tr>
                                                <td><?=$mavro->id;?></td>
                                                <td>
                                                  <a target="_blank" href="<?=$user->AdminViewUrl;?>">
                                                    <?=$mavro->user->fullname;?> (<?=$mavro->user->username;?>)
                                                </a>
                                                </td>
                                                <td><?=$this->money_format($mavro->amount);?></td>
                                                <td><?=$this->money_format($mavro->worth_after_maturity);?></td>
                                                <td>
                                                   
                                                    <span class="progress mt-1 ">
                                                        <span class="progress-bar active progress-bar-striped bg-success" style="width: <?=$mavro->maturity_growth();?>%; height:15px;" role="progressbar"><?=$mavro->maturity_growth();?>%
                                                        </span>
                                                    </span>                                            </td>
                                                <td>
                                                    <span class="badge badge-secondary">
                                                        <?=date('M j, Y', strtotime($mavro->fufilled_at));?>
                                                    </span>
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
