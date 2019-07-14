<?php
$page_title = "Settings";
 include 'includes/header.php';?>

<script type="text/javascript" src="<?=$this_folder;?>/angularjs/settings.js"></script>
    <script src="<?=asset;?>/angulars/admin_settings.js"></script>



    <!-- BEGIN: Content-->
    <div ng-controller="Settings" ng-cloak class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Settings</h3>
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

                <form >
                 <div class="row" >
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header"  data-toggle="collapse" data-target="#demo">
                                <a href="javascript:void;" class="card-title">Settings</a>
                                 <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                       </div>

                            </div>
                            <div class="card-body row collapse show" id="demo">

                                <div ng-repeat="($key, $setting) in $site_settings" class="form-group col-lg-6">
                                    <span class="badge badge-secondary">{{$index+1}}</span>
                                    <label>{{$key |replace: '_':' '}}</label>
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
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
