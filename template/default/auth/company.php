<?php
$page_title = "Company";
include 'includes/header.php';?>
<script src="<?=asset;?>/angulars/company_documents.js"></script>

<!-- BEGIN: Content-->
<div ng-controller="CompanyController" class="app-content content" ng-cloak>
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Profile</h3>
      </div>
      
      <div class="content-header-right col-md-6">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
          <a class="btn btn-outline-primary" href="javascript:void(0);" 
          data-toggle="modal"
          data-target="#upload_company_supporting_document" >+<i class="ft-file"></i>Upload</a>
          <a ng-click="$list.attempt_request_for_review();" class="btn btn-outline-primary" href="javascript:void(0);"><i class="ft-pie-chart"></i> Request Review</a>

          <?php if ($this->admin()):?>

            <?php if (!$company->is_approved()):?>
              <a  class="btn btn-outline-primary"  href="javascript:void;"  onclick="$confirm_dialog = 
              new ConfirmationDialog('<?=domain;?>/admin/approve-company/<?=$company->id;?>', '<?=$company->ApprovalConfirmation;?></b>')">
              <span type='span' class='label label-xs label-primary'>Approve</span>
            </a>
          <?php endif;?>


          <?php if (!$company->is_declined()):?>
            <a  class="btn btn-outline-primary"  href="javascript:void;"  onclick="$confirm_dialog = 
            new ConfirmationDialog('<?=domain;?>/admin/decline-company/<?=$company->id;?>','<?=$company->DeclineConfirmation;?>')">
            <span type='span' class='label label-xs label-primary'>Decline</span>
          </a>
        <?php endif;?>


      <?php endif ;?>
    </div>


  </div>
</div>
<div class="content-body">


  <script>
    refresh_page = function(){
      angular.element($('#document_form')).scope().fetch_page_content();
    }
  </script>


  <!-- The Modal -->
  <div class="modal" id="upload_company_supporting_document">
    <div class="modal-dialog modal-lg" >
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Company Documents</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>



        <!-- Modal body -->
        <form id="document_form" data-function="refresh_page"  class="col-md-12 ajax_form" enctype="multipart/form-data" 
        action="<?=domain;?>/company/upload_company_supporting_document" method="post" >  
        <div class="modal-body">
          <style>
            td{padding:0px !important;}
          </style>



          <button type="button" class="btn btn-secondary float-right btn-sm" 
          ng-click="$list.add_component();">+Add Document</button>
          <br>
          <i class="card-text"> *All documents will be verified.</i>
          <br>
          <table class="table table-hover table-condensed">

            <thead>
              <tr>
                <th>Label</th>
                <th>Files</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="(key, $hospital) in $list.$active_list">
               <td>
                <input 
                placeholder="Name" required="" 
                class="form-control" type=""  
                name="label[]"></td>

                <td>

                  <div
                  class="input-group col-md-12">
                  
                  <input 
                  placeholder="Name" required="" 
                  class="form-control" type="file" 
                  name="files[]">                                        
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
        <button ng-hide="$list.$active_list.length==0" type="submit" class="btn btn-success" >Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </form>  

</div>
</div>
</div>
<?php if (!$company->is_approved()):?>
  <div class="alert alert-danger mb-2" role="alert">
    <strong>NOTE!</strong> Please fill all details accurately providing legal documents. Then, request review for approval
    <a href="javascript:void(0);" ng-click="$list.attempt_request_for_review();" class="alert-link">Request Review</a>
  </div>
<?php endif;?>

<style>
  .main-avatar{
    height: 160px;
    border-radius: 80px;
    width: 160px;
    object-fit: cover;
    }
</style>

<div class="row">
  <div class="col-md-3">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-white bg-darken-2">
                            <i class="ft-block font-large-2"></i>
                        </div>
                        <div class="p-2 bg-gradient-x-white  media-body">
                            <h5>Professional</h5>
                            <h5 class="text-bold-400 mb-0"> Package</h5>
                        </div>
                    </div>
                </div>
            </div>
           <div class="card" >
               <div class="card-content">
                   <div class="card-body">
                       <h6 class="card-tile">Profile Information</h6>
                       <div class="row">
                        <div class="col-md-12 text-center pt-2 mb-1" >
                          <img class="main-avatar img-round" src="<?=domain;?>/<?=$auth->profilepic;?>" alt=""  >
                        </div>
                        <div class="col-md-12 text-center" >
                                       
                          <form class="form-horizontal ajax_for" action="<?=domain;?>/user-profile/update_profile_picture" id="p_form" method="post" enctype="multipart/form-data" >
                            <div class="user-profile-image" align="center" style="">
                              <input type='file' name="profile_pix" onchange="$('#change_btn').click();" id="uploadImage" style="display:none ;" />
                              <button type="submit" style="display: none;" id="change_btn"></button>
                              <label href="#" for="uploadImage" style="text-decoration: underline;cursor: pointer;">Upload or delete photo</label>
                            </div>
                          </form>

                          </div>

                        <div class="col-md-12 text-center" >
                          <form class="">
                            <div class="form-group">
                              <input type="" class="form-control" name="" placeholder="Username">
                             
                            </div>

                            <div class="form-group">
                              <input type="" class="form-control" name="" placeholder="Password">
                            </div>

                            <div class="form-group">
                              <input type="" class="form-control" name="" placeholder="Confirm Password">
                            </div>
                          </form>
                        </div>

                          
                       </div>

                   </div>
               </div>
       </div>


  </div>
  <div class="col-md-9">

        <div class="card" >
            <div class="card-content">
                <div class="card-body">
                    <h6 class="card-tile">Contact Person</h6>
                    <div class="row">
                         <div class="form-group col-md-2">
                            <select class="form-control" name="personal[salutation]">
                              <option value="">Salutation</option>
                              <option value="">Option</option>
                            </select>
                          </div>
                         <div class="form-group col-md-2">
                           <input type="" class="form-control" name="personal[title]" placeholder="Title">
                         </div>

                         <div class="form-group col-md-4">
                           <input type="" class="form-control" name="personal[firstname]" placeholder="First name">
                         </div>

                         <div class="form-group col-md-4">
                           <input type="" class="form-control" name="personal[lastname]" placeholder="Surname">
                         </div>

                         <div class="form-group col-md-3">
                            <select class="form-control" name="personal[country]">
                              <option value="">Country</option>
                              <option value="">Option</option>
                            </select>
                          </div>
                       
                         <div class="form-group col-md-5">
                           <input type="" class="form-control" name="personal[address][place]" placeholder="Place">
                         </div>

                         <div class="form-group col-md-4">
                           <input type="" class="form-control" name="personal[address][postcode]" placeholder="Postcode">
                         </div>

                       
                         <div class="form-group col-md-7">
                           <input type="" class="form-control" name="personal[address][address]" placeholder="Residential address">
                         </div>

                       
                         <div class="form-group col-md-5">
                           <input type="" class="form-control" name="personal[address][house_number]" placeholder="House number">
                         </div>

                    </div>
                       <hr>
                    <h6 class="card-tile">Your Business</h6>
                    <div class="row">

                      <div class="form-group col-md-5">
                        <input type="" class="form-control" name="company[name]" placeholder="Company name">
                      </div>

                      <div class="form-group col-md-5">
                         <select class="form-control" name="company[legal_form]">
                           <option value="">Legal Form</option>
                           <option value="">Option</option>
                         </select>
                       </div>
                      
                      <div class="form-group col-md-2">
                        <input type="" class="form-control" name="company[tax]" placeholder="Taxes">
                      </div>



                      <div class="form-group col-md-2">
                         <select class="form-control" name="company[country]">
                           <option value="">Country</option>
                           <option value="">Option</option>
                         </select>
                       </div>

                      <div class="form-group col-md-5">
                        <input type="" class="form-control" name="company[place]" placeholder="Place">
                      </div>

                      <div class="form-group col-md-5">
                        <input type="" class="form-control" name="company[postcode]" placeholder="Postcode">
                      </div>


                      
                      <div class="form-group col-md-7">
                        <input type="" class="form-control" name="company[address][address]" placeholder="Business address">
                      </div>

                      
                      <div class="form-group col-md-5">
                        <input type="" class="form-control" name="company[address][house_number]" placeholder="House number">
                      </div>

                      <div class="form-group col-md-6">
                        <input type="" class="form-control" name="company[office_email]" placeholder="E-mail address">
                      </div>

                      
                      <div class="form-group col-md-6">
                        <input type="" class="form-control" name="company[office_phone]" placeholder="Phone number">
                      </div>
                      
                      <div class="form-group col-md-12">
                        <input type="" class="form-control" name="company[iban_number]" placeholder="IBAN">
                        <small class="float-right">for commission payments </small>
                      </div>


                    </div>

                </div>
            </div>
        </div>


  </div>

  <div class="col-md-4">
        <div class="card" >
            <div class="card-content">
                <div class="card-body">
                    <h6 class="card-tile">Please upload the required documents here:</h6>
                    <hr>
                    <div class="row">
                     <div class="col-md-12 text-center" >
                                    
                     
                    </div>

                </div>
            </div>
    </div>


      
  </div>
  
</div>
  <div class="col-md-4">
        <div class="card" >
            <div class="card-content">
                <div class="card-body">
                    <h6 class="card-tile">Please download the following documents high:</h6>
                    <hr>
                    <div class="row">
                     <div class="col-md-12 " >
                                    
                      
                      <ul class="list-group list-group-flush">
                          <li class="list-group-item small-padding ">
                              <div class="row">
                                  
                              <span class="col-6">
                                 <small>
                                   
                                  Direct sales partner: 
                                 </small>
                              </span>
                              <span class="col-4">
                                  02/4  
                              </span>
                              <span class=" col-2">
                                  <span class=" float-right">
                                      <i class="ft-check fa-2x"></i>
                                  </span>
                              </span>
                              </div>
                          </li>

                          <li class="list-group-item small-padding ">
                              <div class="row">
                                  
                              <span class="col-6">
                                  Own merchant connection: 
                              </span>
                              <span class="col-4">
                                  02/4  
                              </span>
                              <span class=" col-2">
                                  <span class=" float-right">
                                      <i class="ft-check fa-2x"></i>
                                  </span>
                              </span>
                              </div>
                          </li>


                      </ul>

                    </div>

                </div>
            </div>
    </div>


      
  </div>
  
</div>
  <div class="col-md-4 text-center">
       <button class="btn btn-block btn-outline-teal btn-lg">Save Changes</button>
       <p></p>
       <p>or</p>
       <button class="btn btn-block btn-outline-teal btn-lg">Verify Lets Save</button>
  
</div>






                    </div>
                  </div>
                </div>
                <!-- END: Content-->

                <?php include 'includes/footer.php';?>
