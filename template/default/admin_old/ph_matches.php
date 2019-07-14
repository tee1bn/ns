<?php
$page_title = "PH Matches";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">PH Matches</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">PH Matches</li>
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
                    <div class="card">
                            <div class="card-header">
                                Ref #<?=$ph->id;?>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">
                                  <?=$currency;?><?=$this->money_format($ph->amount);?>
                                   Pledged 
                                 <?=$ph->created_at->toFormattedDateString();?></h4>
                                 <?php 
                                 $ph_er =  $ph->user;
                                 ;?>
                                <p class="card-text">
                                   <i class="fa fa-user"></i> 
                                                <?=$ph_er->fullname?> - Payer<br>
                                                   <a href="tel:<?=$ph_er->phone;?>">
                                                        <i class="fa fa-phone-square"></i> <?=$ph_er->phone?>
                                                    </a><br>
                                                    
                                                   <a href="mailto://<?=$ph_er->email;?>">
                                                    <i class="fa fa-envelope"></i> <?=$ph_er->email?></a><br>




                                 Bal: <?=$currency;?><?=$this->money_format($ph->payout_left);?>
                                </p>
                                 
                                <p class="card-text">
                                  <?=$ph->status();?>
                                </p>
                            </div>
                        </div>
                      </div>
                </div>




                 <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header"  data-toggle="collapse" data-target="#demo">
                                <a href="javascript:void;">PH Matches 
                                    <span class="badge badge-success">
                                        <?=$ph->matched->count();?>
                                    </span>
                                </a>
                            </div>
                            <div class="card-body collapse show" id="demo">
                                <div class="">
                                    <table id="myTable" class="table table-striped">
                                        <thead>
                                            <th style="width: 90%"></th>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; foreach ($ph->matched as $key => $match) :
                                            $recipient = $match->gh->user;
                                            ?>
                                            <tr>
                                                <td>
                                                     <div class="card">
                            <div class="card-header row">
                                <div class="col-md-6">
                                    

                                                <i class="fa fa-user"></i> 
                                                <?=$recipient->fullname?> - Recipient<br>
                                                   <a href="tel:<?=$recipient->phone;?>">
                                                        <i class="fa fa-phone-square"></i> <?=$recipient->phone?>
                                                    </a><br>
                                                    
                                                   <a href="mailto://<?=$recipient->email;?>">
                                                    <i class="fa fa-envelope"></i> <?=$recipient->email?></a><br>
                                </div>  
                                 <div class="col-md-6">
                                    #<?=$match->id;?> <?=$match->status();?><br>

                                                <i class="fa fa-calendar"></i>

                                                    <?=$match->created_at->toFormattedDateString();?><br>
                                                     <?php if (! $match->is_complete()):?>
                                                <i class="fa fa-clock"></i>
                                                     <span class="label label-primary" id="demo_<?=$match->id;?>">8:9:0</span>        
 <script>
      // Set the date we're counting down to
          var $now = new Date();
              $now.add_secs(<?=$match->secs_to_expire();?>);
      var countDownDate_<?=$match->id;?> = $now.getTime();

      // Update the count down every 1 second
      var x_<?=$match->id;?> = setInterval(function() {

          // Get todays date and time
          var now = new Date().getTime();


          
          // Find the distance between now an the count down date
          var distance = countDownDate_<?=$match->id;?> - now;
          
          // Time calculations for days, hours, minutes and seconds
          var days = Math.floor(distance / (1000 * 60 * 60 * 24));
          var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          var seconds = Math.floor((distance % (1000 * 60)) / 1000);
              hours+= days * 24;
          
          // Output the result in an element with id="demo_<?=$match->id;?>"
          document.getElementById("demo_<?=$match->id;?>").innerHTML =  hours + "h "
          + minutes + "m " + seconds + "s ";
          
          // If the count down is over, write some tex_<?=$match->id;?>t 
          if (distance < 0) {
              clearInterval(x_<?=$match->id;?>);
              document.getElementById("demo_<?=$match->id;?>").innerHTML = "TIMEOUT";
          }
      }, 1000);
</script>

                                                     <?php endif;?>



                                </div>
                            </div>
                            <div class="card-body">
                                                
                                <h4 class="card-title">
                                    Account Details
                                </h4>
                                <p class="card-text">
                                    Name: <b> <?=ucfirst($recipient->bank_account_name);?></b><br>
                                    Acct: <b> <?=ucfirst($recipient->bank_account_number);?></b><br>
                                    Bank: <b> <?=ucfirst($recipient->bank_name);?></b><br>
                                    Amt : <b> <?=$currency;?><?=$this->money_format($match->ph_amount);?></b><br>
                                </p>
                                        <div class="dropdown">
                                                      <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                                                         Action
                                                      </button>
                                                      <div class="dropdown-menu">
                                                     <?php if (! $match->is_complete()):?>
                                                        <a class="dropdown-item" href="javascript:void;">
                                                             <form action="<?=domain;?>/user/upload_ph_payment_proof" method="post"  enctype="multipart/form-data">
                                                          <input type="hidden" name="match_id" value="<?=$match->id;?>">
                                                          <input style="display: none;" type="file"  onchange="form.submit();"  name="payment_proof">
                                                          <button type="button" class="btn btn-primary" onclick="form.payment_proof.click()"
                                                          >Upload Proof</button>
                                                      </form>     
                                                        </a>
                                                     <?php endif;?>
                                                        <a class="dropdown-item" target="_blank"
                                                        href="<?=domain;?>/<?=$match->payment_proof;?>">
                                                             See Proof
                                                        </a>
                                                      </div>
                                                    </div>


                                                                               </div>
                        </div>
                                                </td>
                                             
                                            </tr>
                                            <?php $i++; endforeach ;?>
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
