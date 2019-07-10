<?php
$page_title = "Subscription";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Subscription</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Subscription</li>
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

                            <form 
                              id="scheme_form"
                              class="ajax_form"
                              action="<?=domain;?>/admin/update_subscription_plans" method="post" >
                                <div class="card-body table-responsive">
                                    
                                    <table id="myTable" class="table table-striped">
                                        <thead>
                                          <tr>
                                            <th>SN</th>
                                            <th>Plan</th>
                                            <th style="width:10px;">% Off</th>
                                            <th>Price(<?=$currency;?>)</th>
                                            <th>Features <small class="text-danger">*separated commas</small></th>
                                            <th>Hierarchy</th>
                                            <th>Fund Source</th>
                                            <th>Availability</th>
                                          </tr>
                                        </thead>
                                        <tbody>

                                            <?php $i=1; foreach (SubscriptionPlan::all() as $key => $plan) :?>

                                            <tr>
                                                <td>
                                                   <?=$i++;?>
                                                </td>
                                                <td>
                                                    <input type="" value="<?=$plan->package_type;?>"
                                                    name="plan[<?=$plan->id;?>][package_type]">
                                                </td>


                                                <td>
                                                    <input style="width: 35px;" step="0.01" type="number" value="<?=$plan->percent_off;?>" name="plan[<?=$plan->id;?>][percent_off]">
                                                </td>
                                                <td>
                                                    <input style="width: 55px;" type="number" step="0.01" value="<?=$plan->price;?>" name="plan[<?=$plan->id;?>][price]">
                                                </td>
                                                <td>
                                                    <input type="" value="<?=$plan->features;?>" name="plan[<?=$plan->id;?>][features]">
                                                </td>
                                                <td>
                                                    <input style="width: 35px;"  type="number" value="<?=$plan->hierarchy;?>" name="plan[<?=$plan->id;?>][hierarchy]">
                                                </td>
                                                <td>

                                                  <select required="" name="plan[<?=$plan->id;?>][fund_source]" class="form-control">
                                                    <option value="">Select Fund Source</option>
                                                    <?php foreach (SubscriptionPlan::fund_sources() as $source):?>
                                                    <option <?=($source== $plan->fund_source)? "selected" : "";?> value="<?=$source;?>"><?=$source;?></option>
                                                    <?php endforeach ;?>
                                                  </select>

                                                </td>
                                                <td>
                                                    <input type="checkbox" <?=($plan->is_available())? 'checked' :'';?> name="plan[<?=$plan->id;?>][availability]">
                                                </td>
                                            </tr>                                     
                                        
                                            <?php  endforeach ;?>
                                        </tbody>
                                      </table>

                                </div>                           

                                <div class="form-group text-center">
                                    <button class="btn btn-primary">Update</button>
                                </div>

                                
                            </form>





                        </div>


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
