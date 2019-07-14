<?php
$page_title = "Schemes Orders";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Schemes Orders</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Schemes Orders</li>
                        </ol>
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
            
                        <div class="row">
                            <span class="col-md-5">From
                                    <input type="date" name=""  value="<?=$from;?>" onchange="$start_date=this.value" class="form-control">
                                </span> 
                                <span class="col-md-5">To
                                    <input type="date" name=""   value="<?=$to;?>"  onchange="$end_date=this.value" class="form-control">
                                </span> 
                                 <span class="col-md-2">&nbsp;
                                    <button class="form-control" 
                                    onclick="window.location.href = '<?=domain;?>/admin/orders/'+$start_date+'/'+$end_date;">Sort
                                </button>
                                </span>
                        </div>        
                        <br>               

                            <div class="card-header"  data-toggle="collapse" data-target="#demo">
                                <a href="javascript:void;">Subscription Orders</a>
                                <a class="float-right"
                                 href="javascript:void;">Total: <?=$currency;?>
                                <?=$this->money_format($inflows_total);?></a>
                            </div>
                            <div class="card-body collapse show" id="demo">


                            <div class="card-body table-responsive">
                                
                                <table id="myTable" class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th>#Ref</th>
                                        <th>User</th>
                                        <th>Plan</th>
                                        <th>Price(<?=$currency;?>)</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                     <?php foreach ($subscription_orders as $order):
                                        $subscriber = $order->user;
                                        ?>
                                      <tr>
                                        <td><?=$order->id;?></td>
                                        <td><?=$subscriber->DropSelfLink;?></td>
                                        <td><?=$order->plandetails['package_type'];?></td>
                                        <td><?=$this->money_format($order['price']);?></td>
                                        <td><span class="badge badge-primary"><?=$order->created_at->toFormattedDateString();?></span></td>
                                        <td><?=$order->paymentstatus;?></td>
                                        <td>
                                            <div class="dropdown">
                                              <a href="javascript:void;" class="dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-circle"></i>
                                                <i class="fa fa-circle"></i>
                                                <i class="fa fa-circle"></i>
                                              </a>
                                              <div class="dropdown-menu">

                                                <a  href="javascript:void;" class="dropdown-item" onclick="$confirm_dialog = 
                                                new ConfirmationDialog('<?=domain;?>/admin/confirm_payment/<?=$order->id;?>')"
                                                class="btn btn-primary btn-xs">
                                                    Confirm Payment              
                                                </a>
                                                
                                                <form id="payment_proof_form<?=$order->id;?>" action="<?=domain;?>/user/upload_payment_proof/<?=$order->id;?>" method="post" enctype="multipart/form-data">

                                                   <input 
                                                    style="display: none" 
                                                    type="file" 
                                                    onchange="document.getElementById('payment_proof_form<?=$order->id;?>').submit();" id="payment_proof_input<?=$order->id;?>"  
                                                    name="payment_proof">

                                                    <input type="hidden" name="order_id" value="<?=$order->id;?>">
                                                </form>
                                               <!--  <a href="javascript:void;" class="dropdown-item"  onclick="document.getElementById('payment_proof_input<?=$order->id;?>').click()" >
                                                    Upload Proof
                                                </a> -->
                                                <?php if($order->payment_proof !=null) :?>
                                                    <a class="dropdown-item" target="_blank" href="<?=domain;?>/<?=$order->payment_proof;?>">See Proof</a>
                                                <?php endif;?>

                                               
                                              </div>
                                            </div>
                                        </td>
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
