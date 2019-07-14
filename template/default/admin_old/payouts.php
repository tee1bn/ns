<?php
$page_title = "Payouts";
 include 'includes/header.php';?>

     
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Payouts</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Payouts</li>
                        </ol>
                    </div>


                    <div class="col-md-6 col-4 align-self-center">
<!--                         <button class="right-side-toggle waves-effect waves-light btn-info btn-circle btn-sm float-right ml-2"><i class="fa fa-clock text-white"></i></button>
 -->                        <div class="dropdown float-right mr-2 hidden-sm-down">
                            <a class="btn btn-secondary " href="?print=pdf" target="_blank"> 
                                Print
                                <i class="fa fa-print"></i>
                           </a>
                           
                        </div>
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
                                    onclick="window.location.href = '<?=domain;?>/admin/payouts/'+$start_date+'/'+$end_date;">Sort
                                </button>
                                </span>
                        </div>        
                        <br>               




                        <div class="card">

                            <div class="card-header"  data-toggle="collapse" data-target="#demo">
                                <a href="javascript:void;">Credits</a>
                            </div>
                            <div class="card-body row collapse in" id="demo">

                           <div class="table-responsive" >
         
    <table id="myTable" class="table table-striped">
    <thead>
      <tr>
        <th>Ref</th>
        <th>User</th>
        <th>Account</th>
        <th>Amount</th>
        <th>Date</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
        <?php $i=1; foreach ($withdrawals as $withdrawal):
        $owner = User::find($withdrawal->owner_user_id);
        ?>
      <tr>
        <td>#<?=$withdrawal->id;?></td>
        <td>
           <?=$owner->DropSelfLink;?> <br>
       </td>

        <td>
            Name: <?=$owner->account_name;?> <br>
            Num: <?=$owner->account_number;?> <br>
            Bank: <?=$owner->bank;?> <br>
       </td>


        <td><?=$currency;?><?=$this->money_format($withdrawal->amount_earned);?></td>

        <td><span class="label label-primary"><?=$withdrawal->created_at->toFormattedDateString();?></span></td>
        <td><?=$withdrawal->commission_type;?></td>
          <td>


            <div class="dropdown">
                <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
                    Action
                    <span class="caret"></span>
                </button>
              <ul class="dropdown-menu">
                <li>  
                    <form action="<?=domain;?>/admin/upload_withdrawal_payment_proof" method="post"  enctype="multipart/form-data">

                        <input type="hidden" name="withrawal_id" value="<?=$withdrawal->id;?>">
                        <input style="display: none;" type="file"  onchange="form.submit();"  name="withdrawal_payment_proof">
                        <button type="button" class="btn btn-primary btn-xs" onclick="form.withdrawal_payment_proof.click()"
                        >Upload Proof</button>
                    </form>
                </li>


                <li>
                    <span   onclick="$confirm_dialog = 
                        new ConfirmationDialog('<?=domain;?>/admin/mark_withdrawal_paid/<?=$withdrawal->id;?>')"
                        class="btn btn-primary btn-xs">
                        Mark Paid              
                    </span>
                </li>

                <!-- <li>
                    <a  href="javacript:void;" onclick="$confirm_dialog = 
                        new ConfirmationDialog('<?=domain;?>/admin/cancel_withdrawal_request/<?=$withdrawal->id;?>')"
                        class=" btn-danger btn-xs">
                        Cancel Request              
                    </a>
                </li> -->
                    
                    <?php if ($withdrawal->proof != ''):?>
                <li>
                             <a href="<?=domain;?>/<?=$withdrawal->proof;?>" target="_blank" class="btn btn-primary btn-xs">
                                See Proof                
                            </a>
                </li>
                    <?php endif;?>

              </ul>
            </div>
          
            
               



        </td>
      </tr>
        <?php $i++; endforeach;?>

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
