<?php
$page_title = "Credits";
 include 'includes/header.php';?>

     
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Credits</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Credits</li>
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
                                    onclick="window.location.href = '<?=domain;?>/admin/credits/'+$start_date+'/'+$end_date;">Sort
                                </button>
                                </span>
                        </div>        
                        <br>               




                        <div class="card">

                            <div class="card-header"  data-toggle="collapse" data-target="#demo">
                                <a href="javascript:void;">Credits</a>
                            </div>
                            <div class="card-body row collapse in" id="demo">

                            <div class="card-body table-responsive">
                                
                                <table id="myTable" class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th>#Ref</th>
                                        <th>User</th>
                                        <th>Downline</th>
                                        <th>Amount(<?=$currency;?>)</th>
                                        <th>Remark</th>
                                        <th>Date</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                     <?php foreach ($credits as $credit):?>
                                      <tr>
                                        <td><?=$credit->id;?></td>
                                        <td><?=$credit->owned_by->DropSelfLink;?></td>
                                        <td><?=$credit->earned_off->DropSelfLink;?></td>
                                        <td><?=$this->money_format($credit['amount_earned']);?></td>
                                        <td><?=$credit->commission_type;?></td>
                                        <td><span class="badge badge-primary"><?=$credit->created_at->toFormattedDateString();?></span></td>
                                      
                                      </tr>
                                    <?php endforeach ;?>
                                    
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
