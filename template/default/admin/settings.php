<?php
$page_title = "Settings";
 include 'includes/header.php';?>

<script type="text/javascript" src="<?=$this_folder;?>/angularjs/angular.js"></script>
<script>
    $base_url = '<?=domain;?>';
</script>
<script type="text/javascript" src="<?=$this_folder;?>/angularjs/settings.js"></script>


    <div ng-controller="Settings">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Settings</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Settings</li>
                        </ol>
                    </div>
                  
                </div>
             


<!-- 
            <div class="col-12">
                        <div class="card">

                            <div class="card-header"  data-toggle="collapse" data-target="#demo22">
                                <a href="javascript:void;">Bank Details</a>
                            </div>
                            <div class="card-body row collapse show" id="demo22">
                                                           

                                <div  class="form-group col-lg-12">
                                    <label>Bank Account Name</label>
                                    <input type="" placeholder="" ng-model="$admin_bank_details.account_name"
                                     class="form-control">
                                </div>                              

                                <div  class="form-group col-lg-12">
                                    <label>Bank Account Number</label>
                                    <input type="" placeholder="" ng-model="$admin_bank_details.account_number"
                                     class="form-control">
                                </div>                              

                                <div  class="form-group col-lg-12">
                                    <label>Bank</label>
                                    <input type="" placeholder="" ng-model="$admin_bank_details.bank"
                                     class="form-control">
                                </div>                              

                                
                                <div class="text-center col-12">
                                    <button class="btn btn-success" ng-click="update_admin_bank_details()">Update 
                                        <i class="fa fa-cog"></i></button>
                                </div>

                                
                             </div>

                        </div>
                    </div>
 -->

                <form >
                 <div class="row" >
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header"  data-toggle="collapse" data-target="#demo">
                                <a href="javascript:void;">Settings</a>
                            </div>
                            <div class="card-body row collapse show" id="demo">

                                <div ng-repeat="($key, $setting) in $site_settings" class="form-group col-lg-6">
                                    <span class="badge badge-secondary">{{$index+1}}</span>
                                    <label>{{$key}}</label>
                                    <input type="" placeholder="{{$key}}" ng-model="$site_settings[$key]" class="form-control">
                                </div>                              

                                
                                <div class="text-center col-12">
                                    <button class="btn btn-success" ng-click="update_site_settings()">Update 
                                        <i class="fa fa-cog"></i></button>
                                </div>

                             </div>

                        </div>
                    </div>
                </div>
            </form>

        </div>
<?php include 'includes/footer.php';?>
<script>
    $(function() {
        $('#myTable').DataTable();
    });
</script>
