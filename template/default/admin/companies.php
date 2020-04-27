<?php
$page_title = "Companies";
include 'includes/header.php';?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Companies</h3>
      </div>

          <div class="content-header-right col-md-6 col-12">
           <small class="float-right">Showing <?=$companies->count();?> of <?=$data;?> </small>

          </div>
        </div>
        <div class="content-body">

          <section id="video-gallery" class="card">
            <div class="card-header">
              <!-- <h4 class="card-title">Companies</h4> -->
              <?php include_once 'template/default/composed/filters/companies.php';?>

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


                <table id="" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#Ref</th>
                      <th>Name</th>
                      <th>User</th>
                      <th>Created</th>
                      <th>Status</th>
                      <!-- <th>Action</th> -->
                    </tr>
                  </thead>



                  <?php  $i=1; foreach ($companies as $company) :
                  $date   = $company->created_at->toFormattedDateString();   
                  $owner = $company->user;
                  ?>

                  <tr>
                    <td><?=$company->id;?> </td>
                    <td style="text-transform: capitalize;">
                      <?=$company->name;?>
                    </td>
                    <td style="text-transform: capitalize;">
                      <a href="<?=$owner->AdminViewUrl;?>" target="_blank" ><?=$owner->fullname ?? '';?></a>
                    </td>
                    <td><span class="badge badge-secondary"><?=$date;?></span></td>

                    <td><?=$owner->VerifiedBagde ?? '';?> </td>
                        <!--   <td>

                            <div class="dropdown">
                              <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                                
                              </button>
                              <div class="dropdown-menu">
                                  <a class="dropdown-item" target="_blank" href="<?=domain;?>/admin/view-company/<?=$company->id;?>">
                                    <span type='span' class='label label-xs label-primary'>View</span>
                                  </a>

                                  <?php if (!$company->is_approved()):?>
                                    <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                                      new ConfirmationDialog('<?=domain;?>/admin/approve-company/<?=$company->id;?>', '<?=$company->ApprovalConfirmation;?></b>')">
                                              <span type='span' class='label label-xs label-primary'>Approve</span>
                                            </a>
                                  <?php endif;?>


                                  <?php if (!$company->is_declined()):?>
                                    <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                                      new ConfirmationDialog('<?=domain;?>/admin/decline-company/<?=$company->id;?>','<?=$company->DeclineConfirmation;?>')">
                                              <span type='span' class='label label-xs label-primary'>Decline</span>
                                            </a>
                                  <?php endif;?>



                              </div>
                            </div>

                          </td> -->
                        </tr>


                        <?php $i++; endforeach ; ?>

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
