<?php
$page_title = "Order Detail";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Order Detail</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Order Detail</li>
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
                    <div class="card">

                    <!--<div class="card-body">
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
                                <a href="javascript:void;">Order Detail</a>
                            </div>
                            <div class="card-body collapse show" id="demo">


                            <div class="">
                                <section class="content invoice">
                                      <!-- title row -->
                                      <div class="row">
                                        <div class="col-xs-12 invoice-header">
                                        
                                        </div>
                                        <!-- /.col -->
                                      </div>
                                      <!-- info row -->
                                      <div class="row invoice-info">
                        
                                        <div class="col-md-6 invoice-col">
                                          Billing Details
                                          <address>
                                            <?php 
                                                    $user = $order->user;
                                            ;?>

                                                          <strong>
                                                            <?=$user->DropSelfLink;?>
                                                           </strong>
                                                          <!-- <br>Company: <?=$order->billing_company;?>
                                                          <br>Street: <?=$order->billing_street_address;?>
                                                          <br>Apartment: <?=$order->billing_apartment;?>
                                                          <br>State: <?=$order->billing_state;?>
                                                          <br>City: <?=$order->billing_city;?>
                                                          <br>Country: <?=$order->billing_country;?> -->
                                                          <br>Phone: 
                                                          <a href="tel:<?=$user->phone;?>">
                                                           <?=$user->phone;?>
                                                          </a>
                                                          <br>Email: 
                                                          <a href="mailto:<?=$user->email;?>">
                                                              <?=$user->email;?>
                                                          </a>
                                                      </address>
                                        </div>

                                        
                            <!-- 
                                        <div class="col-md-6 invoice-col">
                                          Shipping Details
                                          <address>
                                                          <strong><?=$order->shipping_lastname;?> <?=$order->shipping_lastname;?></strong>
                                                          <br>Company: <?=$order->shipping_company;?>
                                                          <br>Street: <?=$order->shipping_street_address;?>
                                                          <br>Apartment: <?=$order->shipping_apartment;?>
                                                          <br>State: <?=$order->shipping_state;?>
                                                          <br>City: <?=$order->shipping_city;?>
                                                          <br>Country: <?=$order->shipping_country;?>
                                                          <br>Phone: <?=$order->shipping_phone;?>
                                                          <br>Email: <?=$order->shipping_email;?>
                                                      </address>
                                        </div>
 -->
                                        
                            


                                        <!-- /.col -->
                                        <div class="col-md-6 invoice-col text-right">
                                          <b>Order #<?=$order->id;?></b>
                                          <br>
                                          <span class="label label-primary"> 
                                            <?=$order->created_at->toFormattedDateString();?></span>
                                          <br>
                                          <b><?=$order->payment;?></b>
                                          
                                         <!--  <br>
                                          <br>
                                          <b>Payment Due:</b> 2/22/2014
                                          <br>
                                          <b>Account:</b> 968-34567 -->
                                        </div>
                                        <!-- /.col -->
                                      </div>
                                      <!-- /.row -->

                                      <!-- Table row -->
                                      <div class="row">
                                        <div class="col-md-12 table-responsive">
                                          <table class="table table-striped">
                                            <thead>
                                              <tr>
                                                <th>Product</th>
                                                <th style="width: 39%">Description</th>
                                                <th>Qty</th>
                                                <th>Unit Price</th>
                                                <th>Subtotal</th>
                                                <th></th>
                                              </tr>
                                            </thead>
                                            <tbody>

                                            <?php foreach ($order->order_detail() as $item):?>
                                              <tr>
                                                <td>
                                                    <a href="javascript:void;"><?=$item['name'];?></a>
                                                </td>
                                                <td>

                                                    <button class="btn-primary btn" data-toggle="collapse" data-target="#de<?=$item['id'];?>">Description 
                                                        <span class="fa fa-caret"></span>
                                                    </button>

                                                    <div id="de<?=$item['id'];?>" class="collapse"
                                                        style="text-align: justify;">
                                                        <?=($item['description']);?>
                                                    </div>




                                                </td>
                                                <td><?=$item['qty'];?></td>
                                                <td><?=$currency;?> <?=$this->money_format($item['price']);?></td>

                                                <td><?=$currency;?> <?=$this->money_format($item['price'] * $item['qty'] );?></td>
                                                <td>
                                                    <a 
                                                    href="<?=domain;?>/user/download_request/<?=$item['id'];?>/<?=$order->id;?>">
                                                     Download
                                                    </a>
                                                </td>
                                              </tr>
                                            <?php endforeach ;?>
                                
                                            </tbody>
                                          </table>
                                        </div>
                                        <!-- /.col -->
                                      </div>
                                      <!-- /.row -->

                                      <div class="row">
                                        <!-- accepted payments column -->
                                        <div class="col-md-8">
                                          <!-- <p class="lead">Additional Note:</p> -->
                                         <!--  <img src="images/visa.png" alt="Visa">
                                          <img src="images/mastercard.png" alt="Mastercard">
                                          <img src="images/american-express.png" alt="American Express">
                                          <img src="images/paypal.png" alt="Paypal"> -->
                                          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                           <?=$order->additional_note;?>
                                          </p>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-md-4">
                                          <p class="lead">Amount </p>
                                          <div class="table-responsive">
                                            <table class="table">
                                              <tbody>
                                                <tr>
                                                  <th style="width:50%">Subtotal:</th>
                                                  <td><?=$currency;?> <?=$this->money_format($order->total_price());?></td>
                                                </tr><!-- 
                                                <tr>
                                                  <th>Tax (9.3%)</th>
                                                  <td>$10.34</td>
                                                </tr> -->
                                                <tr>
                                                  <th>Scheme (-<?=$order->percent_off;?>%):</th>
                                                  <td><?=$currency;?><?=$this->money_format($order->SchemeOff);?>
                                                   </td>
                                                </tr>
                                                <tr>
                                                  <th>Total:</th>
                                                  <td><?=$currency;?> <?=$this->money_format($order->AmountPayable);?></td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </div>
                                        </div>
                                        <!-- /.col -->
                                      </div>
                                      <!-- /.row -->

                                      <!-- this row will not appear when printing -->
                                      <div class="row">
                                        <div class="col-xs-12 text-right">
                                          <?php if ($order->status !== 'complete'):?>
                                          <button   onclick="$confirm_dialog = new ConfirmationDialog('<?=domain;?>/admin-products/mark_as_complete/<?=$order->id;?>')" 
                                           class="btn btn-primary float-right">
                                           <i class="fa fa-check-circle"></i> Mark as Paid 
                                         </button>
                                        <?php endif;?>
                                        </div>
                                      </div>
                                    </section>



                               
                            </div>

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
