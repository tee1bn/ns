<?php
$page_title = "Credits";
include 'includes/header.php';?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Wallet</h3>
      </div>
      
      <div class="content-header-right col-md-6 col-12">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
          <div class="btn-group" role="group">
          </div>


        </div>
      </div>
    </div>
    <div class="content-body">


      <section id="video-gallery" class="card">



        <div class="card-header">
          <?php include_once 'template/default/composed/filters/wallet.php';?>
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
                    <th>User</th>
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
                    <td><?=$record->user->full_name;?></td>
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



  </div>
</div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php';?>
