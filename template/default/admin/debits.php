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
             

                 <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <span class="col-md-5">From
                                    <input type="date" name=""  value="<?=$from;?>" onchange="$start_date=this.value" class="form-control">
                                </span> 
                                <span class="col-md-5">To
                                    <input type="date" name=""   value="<?=$to;?>"  onchange="$end_date=this.value" class="form-control">
                                </span> 
                                 <span class="col-md-2">&nbsp;
                                    <button class="form-control" 
                                    onclick="window.location.href = '<?=domain;?>/admin/debits/'+$start_date+'/'+$end_date;">Sort
                                </button>
                                </span>
                        </div>        
                        <br>               



                        <div class="card">

                            <div class="card-header"  data-toggle="collapse" data-target="#demo">
                                <a href="javascript:void;">Debits</a>
                                <a class="float-right"
                                 href="javascript:void;">Total: <?=$currency;?>
                                <?=$this->money_format($inflows_total);?></a>
                            </div>
                            <div class="card-body row collapse in" id="demo">
                            
                            <div class="card-body table-responsive">
                                
                                <table id="myTable" class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th>#Ref</th>
                                        <th>User</th>
                                        <th>Amount(<?=$currency;?>)</th>
                                        <th>Remark</th>
                                        <th>Date</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                     <?php foreach ($debits as $debit):?>
                                      <tr>
                                        <td><?=$debit->id;?></td>
                                        <td><?=$debit->owned_by->DropSelfLink;?></td>
                                        <td><?=$this->money_format($debit['amount_earned']);?></td>
                                        <td>
                                            <?=$debit->commission_type;?>

                                            <br>
                                            <small>
                                                <?=$debit->extra_detail;?>
                                                
                                            </small>
                                            
                                        </td>
                                        <td><span class="badge badge-primary"><?=$debit->created_at->toFormattedDateString();?></span></td>
                                      
                                      </tr>
                                    <?php endforeach ;?>
                                    
                                    </tbody>
                                  </table>

                            </div>                             </div>

                        </div>
                    </div>
                </div>

<?php include 'includes/footer.php';?>
<script>
    $(function() {
        $('#myTable').DataTable();
    });
</script>
