<?php
$page_title = "News";
include 'includes/header.php';?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-6 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">News</h3>
      </div>

          <div class="content-header-right col-6">
            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
              <a class="btn btn-outline-primary" href="<?=domain;?>/admin/create_broadcast"><i class="ft-plus"></i> Create News</a>
            </div>
          </div>


        </div>
        <div class="content-body">



        <section id="create" class="card">
          <div class="card-header">
            <h4 class="card-title">News</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
              <?=$note;?>
            </div>
          </div>
          <div class="card-content">
            <div class="card-body">
              <div class="table-responsive">
                
             <table id="myTable" class="table table-hover">
              <tbody>
                <?php $i=1; foreach ($broadcasts as $broadcast) :?>
                <tr>

                  <div class="alert bg-dark text-white  alert-dismissible mb-2 " role="alert">
                  <span style="margin-right: 7px;">
                       <?=$i++;?>)
                  </span>
                  <a class="btn btn-sm btn-outline-secondary"><?=date("M j Y, h:ia", strtotime($broadcast->created_at));?></a><br>
                  <small><?=$broadcast->SmallIntro;?></small><br>

                      <div style="position: absolute;top: 10px;right: 25px;">
                        <?=$broadcast->status();?>
                      <div class="dropdown">
                        <button type="button" class="btn btn-secondary  btn-sm dropdown-toggle" data-toggle="dropdown">
                          Actions
                        </button>
                        <div class="dropdown-menu">
    
                              <a  class="dropdown-item"  href="<?=domain;?>/admin/open_broadcast/<?=$broadcast->id;?>">Open</a>

                               
                              <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                              new ConfirmationDialog('<?=domain;?>/admin/toggle_news/<?=$broadcast->id;?>')">
                              <span type='span' class='label label-xs label-danger'>Toggle Publsh</span>
                            </a>


                              <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                              new ConfirmationDialog('<?=domain;?>/admin/delete_news/<?=$broadcast->id;?>')">
                              <span type='span' class='label label-xs label-danger'>Delete</span>
                            </a>
                        </div>
                      </div>
                    </div>
                      </div>


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
