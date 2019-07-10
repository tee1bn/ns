<?php
$page_title = "My Wallet";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-4 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">My Wallet</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">My Wallet</li>
                        </ol>
                    </div>

                    <?php


                    $settings = SiteSettings::site_settings();
                    $min_withdrawal = $settings['minimum_withdrawal'];      
                    $balance = $this->auth()->available_balance();
                    $withdrawable_balance =  $settings['withdrawable_percent'] * 0.01 * $balance;      
                    ;?>



                    <div class="col-md-8  align-self-center">
<!--                         <button class="right-side-toggle waves-effect waves-light btn-info btn-circle btn-sm float-right ml-2"><i class="fa fa-clock text-white"></i></button>
 -->                        <div class="dropdown float-right mr-2 ">
                            <button class="btn btn-primary " type="button"> 
                                Bal:   <?=$currency;?><?=MIS::money_format($balance);?>
                           </button>
                            <button class="btn btn-success " type="button"> 
                                Avail: <?=$currency;?><?=MIS::money_format($withdrawable_balance);?>
                           </button>
                           
                        </div>
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
                                <form method="post"  action="<?=domain;?>/user/make_withdrawal_request">
                                        <div class="input-group mb-3">
                                            <input class="form-control" required="" type="number" 
                                                min="<?=$min_withdrawal;?>"
                                                name="amount"
                                                max="<?=$withdrawable_balance;?>" 
                                                placeholder="Enter Amount">
                                            <div class="input-group-append">
                                                <button class="input-group-text">Withdraw</button>
                                            </div>
                                        </div>
                                </form>




                            <div class="card-header"  data-toggle="collapse" data-target="#demo">
                                <a href="javascript:void;">Credits</a>
                            </div>
                            <div class="card-body collapse show" id="demo">


                            <div class="card-body table-responsive">
                                
                                <table id="myTable" class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th>#Ref</th>
                                        <th>Upon</th>
                                        <th>Amount(<?=$currency;?>)</th>
                                        <th>Remark</th>
                                        <th>Date</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                     <?php foreach ($this->auth()->earnings()->get() as $earning):?>
                                      <tr>
                                        <td><?=$earning->id;?></td>
                                        <td><?=$earning->earned_off->full_name;?></td>
                                        <td><?=$this->money_format($earning['amount_earned']);?></td>
                                        <td><?=$earning->commission_type;?></td>
                                        <td><span class="badge badge-primary"><?=$earning->created_at->toFormattedDateString();?></span></td>
                                      
                                      </tr>
                                    <?php endforeach ;?>

                                     <?php foreach ($this->auth()->withdrawals_history()->get() as $earning):?>
                                      <tr>
                                        <td><?=$earning->id;?></td>
                                        <td>*</td>
                                        <td><?=$this->money_format($earning['amount_earned']);?></td>
                                        <td>
                                            <?=$earning->commission_type;?>

                                            <br>
                                            <small>
                                                <?=$earning->extra_detail;?>
                                                
                                            </small>
                                            
                                        </td>
                                        <td><span class="badge badge-primary"><?=$earning->created_at->toFormattedDateString();?></span></td>
                                      
                                      </tr>
                                    <?php endforeach ;?>
                                    
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
