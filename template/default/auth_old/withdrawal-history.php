<?php
$page_title = "Debits";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Debits</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Debits</li>
                        </ol>
                    </div>
                  
                </div>
               





                <?php

                    $withdrawals_history = $this->auth()->withdrawals_history()->get();


                    $settings = SiteSettings::site_settings();
                    $min_withdrawal = $settings['minimum_withdrawal'];      
                    $balance = $this->auth()->available_balance();
                    $withdrawable_balance =  $settings['withdrawable_percent'] * 0.01 * $balance;      

                ;?>


                <div class="row">
                    <div class="col-12">
                       <div class="card-body">


                                <small>
                                  Balance: <?=$currency;?><?=MIS::money_format($balance);?>
                                 <br>
                                    Available Balance:<?=$currency;?><?=MIS::money_format($withdrawable_balance);?> 

                                 <br>
                                    Min Withdrawal:<?=$currency;?><?=MIS::money_format($min_withdrawal);?> 

                             </small>
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
                                <a href="javascript:void;">Debits</a>
                                <a href="javascript:void;" class="float-right text-black">
                                    Total: <?=$currency;?>
                                    <?=$withdrawals_history->sum('amount_earned');?></a>
                            </div>
                            <div class="card-body collapse show" id="demo">


                            <div class="card-body table-responsive">
                                
                                <table id="myTable" class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th>#Ref</th>
                                        <th>Amount(<?=$currency;?>)</th>
                                        <th>Remark</th>
                                        <th>Date</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                     <?php foreach ($withdrawals_history as $earning):?>
                                      <tr>
                                        <td><?=$earning->id;?></td>
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
