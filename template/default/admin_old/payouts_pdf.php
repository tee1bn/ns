<?php // include  'inc/headers.php';?>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

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

            <div class="col-md-12">
                 <h5 class="text-center"><?=project_name;?></h5>
                <h4 class="text-center">Payouts</h4>                    
                </h5>

                <h6 class="text-center"><?=date("d/m/Y" ,strtotime($from));?> - <?=date("d/m/Y" ,strtotime($to));?></h6>

                            <div class="col-md-12">
                                
                                <hr>
                                
                            </div>
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <!-- <div class="panel-heading">
                                        <h3 class="text-center"><strong>Order summary</strong></h3>
                                    </div> -->
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table autosize="1" class="" width="100%">
                                                <thead>
                                                    <tr>
                                                        <td class="text-left">
                                                            <strong>SN</strong>
                                                        </td>
                                                        <td class="text-left"><strong>User</strong></td>
                                                        <td class="text-left"><strong>Account</strong></td>
                                                        <td class="text-right"><strong>Bank</strong></td>
                                                        <td class="text-right"><strong>Credit (<?=$currency;?>)</strong>
                                                        </td>
                                                        <td class="text-right"><strong>Date</strong></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i=1; foreach ($withdrawals as $withdrawal):
                                                        $owner = User::find($withdrawal->owner_user_id);
                                                        ?>

                                                        <tr>
                                                            <td class="text-left">
                                                                <b><?=$i++;?></b>
                                                            </td>
                                                            <td class="text-left">
                                                                <strong>
                                                                    <?=$owner['DropSelfLink'];?>
                                                                </strong>
                                                            </td>
                                                            <td class=""> 
                                                                Name: <?=$owner->account_name;?> <br>
                                                                Num: <?=$owner->account_number;?> <br>
                                                            </td>

                                                            <td class="text-right"> 
                                                               <b> <?=$owner->bank;?> Bank</b>
                                                            </td>
                                                            
                                                            <td class="text-right">
                                                                <?=$this->money_format($withdrawal->amount_earned);?></td>
                                                <td class="text-right"><?=$withdrawal->created_at->toFormattedDateString();?></td>
                                                        </tr>

                                                    <?php endforeach;?>


                                                 
                                                    <tr>
                                                        <td class="emptyrow text-center">
                                                        </td>
                                                        <td class="emptyrow  text-center"></td>
                                                        <td class="emptyrow text-right">
                                                        </td>
                                                            <td class="emptyrow text-rght">
                                                                <strong>Total</strong>
                                                            </td>
                                                            <td class="emptyrow text-right">
                                                                <?=$currency;?><?=$this->money_format($total);?>
                                                            </td>
                                                            <td class="emptyrow text-right">
                                                            </td>
                                                    </tr>
                                                
                                                  
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                <style>
                        .height {
                            min-height: 200px;
                        }

                        .icon {
                            font-size: 47px;
                            color: #5CB85C;
                        }

                        .iconbig {
                            font-size: 77px;
                            color: #5CB85C;
                        }

                        .table > tbody > tr > .emptyrow {
                            border-top: none;
                        }

                        .table > thead > tr > .emptyrow {
                            border-bottom: none;
                        }

                        .table > tbody > tr > .highrow {
                            border-top: 3px solid;
                        }
                </style>






            </div>
        </div>

    </div>
    


<?php include 'inc/footers.php';?>


