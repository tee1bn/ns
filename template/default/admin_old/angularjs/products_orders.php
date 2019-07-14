<?php
$page_title = "Products Orders";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Products Orders</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Products Orders</li>
                        </ol>
                    </div>
                  
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->

                    <?php 
                    $settings = SiteSettings::company_account_details();
                     ?>
                    <div class="row">
                    <div class="col-12">

              <!--          <div class="card-body">
                            <div class="card card-success card-inverse">
                                <div class="box text">
                                <h1 class="font-light text-white "><i class="fa fa-home"></i>
                                  <span class="float-right"><?=$settings['account_name'];?></span>
                                 <small>
                                 </small>
                                </h1>

                                  <a href="" class="btn btn-success float-right">Acc Num: <?=$settings['account_number'];?> <br>
                                      
                                        Bank: <?=$settings['bank'];?>
                                  </a>
                                  <small class="text-white">Kindly pay to this account detail</small>
                                <h6 class="text-white">
                                </h6>
                            </div>
                          
                        </div> -->

                            <div class="card-header"  data-toggle="collapse" data-target="#demo">
                                <a href="javascript:void;">Products Orders</a>
                            </div>
                            <div class="card-body collapse show" id="demo">


                            <div class="card-body table-responsive">
                                
                                <table id="myTable" class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th>#Ref</th>
                                        <th>Items x Qty</th>
                                        <th>Amount(<?=$currency;?>)</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                     <?php foreach ($this->auth()->products_orders as $order):?>
                                      <tr>
                                        <td><?=$order->id;?></td>
                                        <td><?=$order->total_item();?> x <?=$order->total_qty();?></td>
                                        <td>
                                            <?=$this->money_format($order['amount_payable']);?>
                                        </td>
                                        <td><span class="badge badge-primary"><?=$order->created_at->toFormattedDateString();?></span></td>
                                        <td><?=$order->payment;?></td>
                                        <td>
                                            <div class="dropdown">
                                              <a href="javascript:void;" class="dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-circle"></i>
                                                <i class="fa fa-circle"></i>
                                                <i class="fa fa-circle"></i>
                                              </a>
                                              <div class="dropdown-menu">
                                                <form id="payment_proof_form<?=$order->id;?>" action="<?=domain;?>/user/upload_payment_proof/<?=$order->id;?>" method="post" enctype="multipart/form-data">
                                                    <input 
                                                    style="display: none" 
                                                    type="file" 
                                                    onchange="document.getElementById('payment_proof_form<?=$order->id;?>').submit();" id="payment_proof_input<?=$order->id;?>"  
                                                    name="payment_proof">

                                                    <input type="hidden" name="order_id" value="<?=$order->id;?>">
                                                </form>


                                                <a href="<?=domain;?>/user/order/<?=$order->id;?>" class="dropdown-item" >
                                                    Open
                                                </a>

<!--                                                 <a href="javascript:void;" class="dropdown-item"  onclick="document.getElementById('payment_proof_input<?=$order->id;?>').click()" >
                                                    Upload Proof
                                                </a>
 -->


                                                <?php if($order->payment_proof !=null) :?>
<!--                                                     <a class="dropdown-item" target="_blank" href="<?=domain;?>/<?=$order->payment_proof;?>">See Proof</a>
 -->                                                <?php endif;?>

                                                <?php if(! $order->is_paid()) :?>
                                                <a class="dropdown-item" 
                                                href="<?=domain;?>/shop/make_payment/<?=$order->id;?>">
                                                                        Pay Now
                                                </a>
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
