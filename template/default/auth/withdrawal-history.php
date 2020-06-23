<?php
$page_title = "Withdrawal History";
include 'includes/header.php';
;?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Withdrawal History</h3>
      </div>

         <!--  <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              <div class="btn-group" role="group">
                <button class="btn btn-outline-primary dropdown-toggle dropdown-menu-right" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Settings</button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item" href="card-bootstrap.html">Bootstrap Cards</a><a class="dropdown-item" href="component-buttons-extended.html">Buttons Extended</a></div>
              </div><a class="btn btn-outline-primary" href="full-calender-basic.html"><i class="ft-mail"></i></a><a class="btn btn-outline-primary" href="timeline-center.html"><i class="ft-pie-chart"></i></a>
            </div>
          </div> -->
        </div>
        <div class="content-body">

          <section id="video-gallery" class="card">
            <div class="card-header">
              <?php include_once 'template/default/composed/filters/auth_withdrawals.php';?>
              <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                  <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                  <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
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
                      <th>Date</th>
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
                      <td><span class="badge badge-primary"><?=date("M j, Y h:ia" , strtotime($withdrawal->created_at));?></span></td>
                      
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
