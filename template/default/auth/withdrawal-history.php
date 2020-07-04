<?php
$page_title = "Payout History";
include 'includes/header.php';



use v2\Models\Withdrawal;
$balances = Withdrawal::payoutBalanceFor($auth->id);


;?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Payout History</h3>
      </div>

        <div class="content-header-right col-6">
          <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-sm btn-outline-secondary" href="javascript:void(0);">
              Bal: <?=$currency;?><?=MIS::money_format($balances['payout_book_balance']);?>
            </a>
            <a class="btn btn-sm btn-outline-secondary" href="javascript:void(0);">
             Avail Bal: <?=$currency;?><?=MIS::money_format($balances['available_payout_balance']);?>
            </a>
          </div>
        </div>

        </div>
        <div class="content-body">

          <section id="video-gallery" class="card">
            <div class="card-header">
              <?php include_once 'template/default/composed/filters/auth_withdrawals.php';?>
              <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <?=$note;?>
              </div>
            </div>
            <div class="card-content">


              <div class="card-body table-responsive">

                <table id="myTabl" class="table table-stripe">
                  <thead>
                    <tr>
                      <th>#ID</th>
                      <th>Amount / Fee(<?=$currency;?>)</th>
                      <th>Payable(<?=$currency;?>)</th>
                      <th>IBAN</th>
                      <th>Status</th>
                      <th>Month</th>
                      <th>*</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php foreach ($withdrawals as $withdrawal):
                    $detail = $withdrawal->ExtraDetailArray;
                    ?>
                    <tr>
                      <td><?=$withdrawal->id;?></td>

                      <td><?=MIS::money_format($withdrawal['amount']);?>/<?=MIS::money_format($withdrawal['fee']);?></td>
                      <td><?=MIS::money_format($withdrawal['AmountToPay']);?></td>
                      <td><?=$withdrawal->MethodDetailsArray['iban'];?></td>
                      <td><?=$withdrawal->DisplayStatus;?></td>

                      <td>
                        <span class="badge badge-primary"><?=date("F Y" , strtotime($withdrawal->payment_month));?></span>
                      </td>

                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">Action
                          </button>
                          <div class="dropdown-menu">

                              <a  class="dropdown-item"  href="<?=domain;?>/user/print-commission/<?=$withdrawal->id;?>">
                                Print Commission
                              </a>



                          </div>
                        </div>



                        
                      </td>
                    </tr>
                  <?php endforeach ;?>

                </tbody>
              </table>

            </div>

          </div>
        </section>
        
        <ul class="pagination">
            <?= $this->pagination_links($data, $per_page);?>
        </ul>



      </div>
    </div>
  </div>
  <!-- END: Content-->

  <?php include 'includes/footer.php';?>
