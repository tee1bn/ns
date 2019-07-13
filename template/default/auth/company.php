<?php
$page_title = "Company";
 include 'includes/header.php';?>
    <script src="<?=asset;?>/angulars/company_documents.js"></script>

    <!-- BEGIN: Content-->
    <div ng-controller="CompanyController" class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Company</h3>
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



                                  <!-- The Modal -->
<div class="modal" id="upload_company_supporting_document">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Company Documents</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>

      <!-- Modal body -->
        <form id="re" class="col-md-12" action="<?=domain;?>/accounts/upload_company_supporting_document" method="post" >  
          <div class="modal-body">
            <style>
              td{padding:0px !important;}
            </style>


                              <button type="button" class="btn btn-secondary float-right btn-sm" 
                              ng-click="$list.add_component();">+Add Document</button>
                                <br>
                                <br>
                                   <table class="table table-hover table-condensed">

                                      <thead>
                                        <tr>
                                          <th>Label</th>
                                          <th>Files</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr ng-repeat="(key, $hospital) in $list.$data">
                                         <td>
                                            <input 
                                                placeholder="Name" required="" 
                                               class="form-control" type=""  ng-model="$list.$data[$index].name" name=""></td>

                                          <td>

                                                <div
                                                 class="input-group col-md-12">
                                                     
                                            <input 
                                                placeholder="Name" required="" 
                                               class="form-control" type="file"  ng-model="$list.$data[$index].file"
                                                name="">

                                        
                                                      <span class="input-group-btn">
                                                        <button ng-click="$list.delete_component($hospital);"
                                                         class="btn btn-default" type="button">
                                                            <span class="fa fa-times text-danger"></span>
                                                        </button>
                                                      </span>
                                                </div>  

                                            </td>
                                        </tr>
                                      </tbody>
                                    </table>

                
          <!-- Modal footer -->
          <div class="modal-footer">
                    <button type="submit" class="btn btn-success" >Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

          </div>
        </form>  

    </div>
  </div>
</div>



      <section id="video-gallery" class="card">
        <div class="card-header">
          <h4 class="card-title">Company</h4>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li  data-toggle="modal" data-backdrop="static" data-target="#upload_company_supporting_document" 
                    title="Upload supporting company documents"><a>
                      <i  class="float-right ft-paperclip fa-2x"></i></a>
                    </li>
                </ul>
            </div>
        </div>

         <style>
                    .full_pro_pix{
                          width: 120px;
                          height: 120px;
                          object-fit: cover;
                          border-radius: 100%;
                          border: 1px solid #cc444433;
                    }
                </style>


         <div class="card-content">

                                    <div class="card-body row">
                                <div class="col-md-4" style="
    margin-bottom: 20px;
    border: 1px solid #14181f42;
    padding: 19px;">
                                  <form class="form-horizontal ajax_form" 
                                    id="p_form" method="post" enctype="multipart/form-data" action="<?=domain;?>/company/update_company_logo">
                                      <div class="user-profile-image" align="center" style="">
                                        <img id="myImage" src="<?=$company->getLogo;?>" alt="your-image" class="full_pro_pix" />
                                        <input type='file' name="profile_pix" onchange="form.submit();" id="uploadImage" style="display:none ;" />
                                        <h6><?=$company->name;?></h6>
                                        <?=$company->Approval;?>
                                        <label for="uploadImage" class="btn btn-secondary" style=""> Change Logo</label>
                                        
                                        <br>
                                        <!-- <span class="text-danger">*click update profile to apply change</span> -->
                                      </div>
                                      <input type="hidden" name="company_id" value="<?=$company->id;?>">
                                    </form>

                                </div>

                                <div class="col-md-8" style="
    margin-bottom: 20px;
    border: 1px solid #14181f42;
    padding: 19px;">

          
                                        <div class="card-body card-body-bordered collapse show" id="demo1" >
                                            

                                         <form id="profile_form"
                                            class="ajax_form m-t-30 " 
                                            action="<?=domain;?>/company/update_company" method="post">
                                              <div class="form-group">
                                                <label for="name" class="pull-left">Name *</label>
                                                  <input type="text" required="" name="name" value="<?=$company->name;?>"  class="form-control" value="">
                                              </div>

                                              <div class="form-group">
                                                    <label for="address" class="pull-left">Address *</label>
                                                    <input type="text" name="address"  value="<?=$company->address;?>" id="address" class="form-control">
                                              </div>


                                              <input type="hidden" name="id" value="<?=$company->id;?>">
                                          

                                            <div class="form-group">
                                                <label for="email" class="pull-left">Official Email Address<sup>*</sup></label>
                                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <span class="input-group-btn input-group-prepend"></span>
                                                    <input id="tch3" name="office_email"   value="<?=$company->office_email;?>"
                                                      data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline" class="form-control">
                                                    <span class="input-group-btn input-group-append">
                                                        <button class="btn btn-secondary btn-outline bootstrap-touchspin-up" type="button">Require Verification</button>
                                                    </span>
                                                </div> 
                                            </div>

                                        


                                            <div class="form-group">
                                                <label for="office_phone" class="pull-left">Official Phone<sup>*</sup></label>
                                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <span class="input-group-btn input-group-prepend"></span>
                                                    <input id="tch3" name="office_phone"   value="<?=$company->office_phone;?>"
                                                      data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline" class="form-control">
                                                    <span class="input-group-btn input-group-append">
                                                        <button class="btn btn-secondary btn-outline bootstrap-touchspin-up" type="button">Require Verification</button>
                                                    </span>
                                                </div> 
                                            </div>                                        

                                            <div style="display:none;" class="form-group">
                                                <label for="lastName" class="pull-left">Pefcom Id <sup></sup></label>
                                                <input type="text" name="pefcom_id" class="form-control"  value="<?=$company->pefcom_id;?>">
                                          </div>


                                            <div class="form-group">
                                                <label for="rc_number" class="pull-left">Registration Number <sup></sup></label>
                                                <input type="text" name="rc_number" class="form-control"  value="<?=$company->rc_number;?>">
                                          </div>



                                              <div class="form-group">

                                                    <button type="submit" class="btn btn-secondary btn-block btn-flat">Save</button>

                                              </div>
                                            </form>


                                           
                                        </div>


                                </div>


          
      </div>
    </div>
      </section>



        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
