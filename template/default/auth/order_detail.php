                       

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">


<style>
        table tbody tr:nth-child(even){ 
        background: lightgray !important;
    }

    table tbody tr td , table thead tr td { 
        padding: 5px;

    }

    table tbody tr , table thead tr { 
        line-height: 15px;
    }

    
    table thead td {
     background-color: #88b988a6;
    text-align: center;
}
    </style>                          


    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="invoice-title">
                    <h2>Invoice #<?=$order['id'];?></h2>
                </div>
                <hr>
                <div class="row">


                  <table class="table" style="width: 100%;">
                      <tbody>
                        <tr>
                          <td style="text-align: left;">
                            <address>
                            <strong></strong><br>
                                <img style="width: 40px;" src="<?=$logo;?>"> <?=project_name;?><br>
                                Status: <?=$order['paymentstatus'];?><br>
                                Order: <?=$order->TransactionID;?><br>

                                <strong>Order Date:</strong><br>
                                <?=$order->created_at->toFormattedDateString();?>
                                <br><br>
                            </address>

                          </td>
                          <td style="text-align: right;">
                          </td>
                          <td style="text-align: right;">
                            
                            <address>
                              <?php 
                                      $user = $order->user;
                              ;?>

                                <strong>
                                  <?=$user->DropSelfLink;?>
                                 </strong>
                                <br>Phone: 
                                <a href="tel:<?=$user->phone;?>">
                                 <?=$user->phone;?>
                                </a>
                                <br>Email: 
                                <a href="mailto:<?=$user->email;?>">
                                    <?=$user->email;?>
                                </a>
                            </address>

                            <strong>Generated Date:</strong><br>
                            <?=date("M d, Y");?><br><br>

                          </td>
                        </tr>
                      </tbody>
                  </table>

                </div>

                <hr>


                <div class="row">
                    <div class="col-xs-6">
                     <!--    <address>
                            <strong>Generated Date:</strong><br>
                            <?=date("M d, Y");?><br><br>
                        </address> -->
                    </div>
                    <div class="col-xs-6 text-right">
    <!--                     <address>
                            <strong>Generated Date:</strong><br>
                            March 7, 2014<br><br>
                        </address>
     -->                </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Summary</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsie">

                          <table class="table table-striped table-bordered" style="width: 100%; border:;">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th style="text-align: left;">Item &amp; Description</th>
                                <th style="text-align: left;">Rate</th>
                                <th style="text-align: right;">Qty</th>
                                <th style="text-align: right;">Amount</th>
                              </tr>
                            </thead>
                            <tbody>

                              <tr>
                                <th scope="row">1</th>
                                <td>
                                  <p><?=$order->plandetails['package_type'];?> Package</p>
                                </td>
                                <td class="text-right">
                                  <?=MIS::money_format($order->plandetails['price']);?>
                                </td>
                                <td style="text-align: right;">1</td>
                                <td style="text-align: right;"><?=$currency;?> 
                                  <?=MIS::money_format($order->plandetails['price'] );?>
                              </td>
                              </tr>
                            </tbody>
                          </table>


                          <div style="width: 40%; float: right;">
                            
                          <table class="table" style="width: 100%; border:;">
                            <tbody>
                              <tr>
                                <td style="text-align: right;">Sub Total</td>
                                <td class="" style="text-align: right;">
                                  <?=$currency;?>
                                <?=MIS::money_format($order->plandetails['price'] );?>
                                </td>
                              </tr>
                              <tr>
                                <td style="text-align: right;">TAX (<?=round($order->plandetails['percent_vat'],2);?>%)</td>
                                <td class="" style="text-align: right;">
                                  <?=$currency;?>
                                    <?=(MIS::money_format(0.01 * $order->plandetails['percent_vat'] * $order->plandetails['price']));?>

                                </td>
                              </tr>
                              <tr>
                                <td class="text-bold-800" style="text-align: right;">Total</td>
                                <td class="text-bold-800 " style="text-align: right;"> 
                                  <?=$currency;?>
                                  <?=MIS::money_format($order->plandetails['price'] + (0.01 * $order->plandetails['percent_vat'] * $order->plandetails['price']));?>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                          </div>
                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


