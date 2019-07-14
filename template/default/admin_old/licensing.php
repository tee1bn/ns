<?php
$page_title = "Licensing";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Licensing</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Licensing</li>
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

                          <div class="card" ng-controller="SchemeController">

                          <div class="card-header">
                            Edit Scheme Confirmation Message 
                          </div>

                            <form 
                              id="sub_form"
                              class="ajax_form"
                            action="<?=domain;?>/admin/update_subscription_confirmation_message" method="post" >
                                <div class="card-body">

                                      <div class="form-group">
                                  <label>Job title</label>
                                   <select required="" ng-model="$selected_scheme" ng-change="change($selected_scheme)"
                                     class="form-control">
                                     <option value="">Select Scheme</option>
                                     <option  ng-repeat="($index,  $scheme) in $schemes" value="{{$scheme}}">
                                       {{$scheme.package_type}}
                                    </option>
                                   </select>
                                 </div>


                                  <input type="" style="display: none;" ng-model="$jd.id"
                                   name="id">
                                  
                                    <div class="form-group">
                                      <label>Job Description</label>
                                       <textarea id="editor1" required=""
                                        name="confirmation_message" ng-model="$jd.confirmation_message"
                                        class="form-control"></textarea>
                                    </div>


                                    <script>    
                                        CKEDITOR.replace( 'editor1' );
                                    </script>

                                  <button id="job_description_save_btn" 
                                  class="btn btn-sm btn-success pull-right">Save</button>


                                </div>                           



                                
                            </form>





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
