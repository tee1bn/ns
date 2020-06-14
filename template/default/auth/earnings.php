<?php
$page_title = "Commissions";
include 'includes/header.php';?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-6 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Commissions</h3>
      </div>
      
      <div class="content-header-right col-6">
        <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
          <div class="btn-group" role="group">
          </div>
          <a class="btn btn-outline-primary" href="#"><small>Last Month:</small> <?=$currency;?><?=MIS::money_format($balances['last_month']);?></a>
          <a class="btn btn-outline-primary" href="#"><small>This Month:</small> <?=$currency;?><?=MIS::money_format($balances['this_month']);?></a>
          <!-- <a class="btn btn-outline-primary" href="timeline-center.html"><i class="ft-pie-chart"></i></a> -->
        </div>
      </div>
    </div>
    <div class="content-body">


      <section id="video-gallery" class="card">



        <div class="card-header">
          <?php include_once 'template/default/composed/filters/auth_wallet.php';?>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
          <div class="heading-elements">
            <ul class="list-inline mb-0">
              <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
              <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
            </ul>
          </div>
        </div>



        <div class="card-content">





          <div class="card-body">


            <div class="table-responsive">

              <table id="myTabl" class="table table-stripe">
                <thead>
                  <tr>

                    <th>#Ref</th>
                    <th>Upon</th>
                    <th>Amount(<?=$currency;?>)</th>
                    <th>Remark</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                 <?php foreach ($records as $record):?>
                  <tr>
                    <td><?=$record->id;?></td>
                    <td><?=$record->upon->full_name;?></td>
                    <td><?=MIS::money_format($record['amount']);?></td>
                    <td><?=$record->comment;?></td>
                    <td><span class="badge badge-primary"><?=date("M j, Y h:ia" , strtotime($record->paid_at));?></span></td>
                  </tr>
                <?php endforeach ;?>

              </tbody>
            </table>


          </div>


          
        </div>
      </div>


    </section>
    
    <ul class="pagination">
      <?= $this->pagination_links($data, $per_page);?>
    </ul>


    
    <p class="text-danger">*This ad is only a preview, not binding and may differ from the actual billing!</p>



  </div>
</div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php';?>
