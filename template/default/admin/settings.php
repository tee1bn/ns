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

             <div class="row" >
                <div class="col-12">
                    <div class="card">

                        <div class="card-header"  data-toggle="collapse" data-target="#payment_gateway_settings">
                          <a href="javascript:void;" class="card-title">Payment Gateways Settings</a>
                           <div class="heading-elements">
                              <ul class="list-inline mb-0">
                                  <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                  <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                              </ul>
                            </div>
                        </div>
                        <div class="card-body row collapse " id="payment_gateway_settings">

                               <div class="col-12" ng-repeat =" ($index , $gateway) in $payment_gateway_settings">
                                   <div class="card card-bordered" >

                                       <div class="card-header"  data-toggle="collapse" data-target="#payment_gateway_settings{{$index}}">
                                         <a href="javascript:void;" class="card-title">{{$gateway.name}}</a>
                                          <div class="heading-elements">
                                             <ul class="list-inline mb-0">
                                                 <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                 <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                             </ul>
                                           </div>
                                       </div>
                                       <div class="card-body row collapse " id="payment_gateway_settings{{$index}}">


                                            
                                            <div class="col-6" ng-repeat =" (key , $setting) in $gateway.json_settings">
                                                <div class="card">

                                                    <div class="card-header"  data-toggle="collapse" data-target="#gateway_settings{{$index}}">
                                                      <a href="javascript:void;" class="card-title">{{key}}</a>
                                                    </div>
                                                    <div class="card-body row collapse show " id="gateway_settings{{$index}}">


                                                        <div class="form-group col-md-12" ng-repeat="(key, $input) in $setting" ng-init="kkey = key">
                                                          <label> {{kkey}} </label>
                                                          <input  type="" ng-model="$setting[key]" class="form-control" name="">
                                                        </div>                                                    
                                                  

                                                     </div>

                                                </div>
                                            </div>

                                            <form class="col-md-12 ajax_form" method="post" action="<?=domain;?>/settings/update_payment_settings">

                                              <input type="" style="display:none;" name="criteria" value="{{$gateway.criteria}}" >
                                              <textarea style="display: none;" class="form-control" name="settings">{{$gateway}}</textarea>

                                              <button class="form-control btn-success">Update</button>

                                            </form>
  
                                        </div>


                                   </div>
                               </div>


                            
                      

                         </div>

                    </div>
                </div>
              </div>






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
                            <div class="card-body row collapse" id="demo">

                                <div ng-repeat="($key, $setting) in $site_settings" class="form-group col-md-6">
                                    <span class="badge badge-secondary">{{$index+1}}</span>
                                    <label>{{$key |replace: '_':' '}}</label>
                                    <input type="" placeholder="{{$key}}" ng-model="$site_settings[$key]" class="form-control">
                                </div>                              



                              <form action="<?=domain;?>/settings/update_site_settings" method="post" class="ajax_form" id="site_settings_form">

                                <textarea style="display: none;" name="content">{{$site_settings}}</textarea>

                                              
                                <div class="text-center col-12">
                                    <button ng-show="$site_settings.length != 0" class="btn btn-success" type="submit">Update 
                                        </button>
                                </div>
                              </form>

                             </div>

                        </div>
                    </div>
                </div>

              
                 <div class="row" >
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header"  data-toggle="collapse" data-target="#commission_settings">
                                <a href="javascript:void;" class="card-title">Commission Settings</a>
                                 <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        </ul>
                       </div>

                            </div>
                            <div class="card-body row collapse" id="commission_settings">
                              <div class="table-responsive">
                                
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>SN</th>
                                    <th>Level</th>
                                    <th>License <br>from merchant (%) <small>Via Api</small></th>
                                    <th>Sales Packages (%)</th>
                                    <th>Disagio (%) <small>Via Api</small></th>
                                    <th>Setup Fee (%) <small>Via Api</small></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr ng-repeat="(key, $commission_setting) in $commission_settings">
                                    <td>{{$index + 1}}</td>
                                    <td>{{$commission_setting.level}}</td>
                                    <td contenteditable="true" ng-model="$commission_setting.license"></td>
                                    <td contenteditable="true" ng-model="$commission_setting.packages"></td>
                                    <td contenteditable="true" ng-model="$commission_setting.disagio"></td>
                                    <td contenteditable="true" ng-model="$commission_setting.setup"></td>
                                  </tr>
                                
                                </tbody>
                              </table>
                              </div>

                                
                              <form action="<?=domain;?>/settings/update_commission_settings" method="post" class="ajax_form" >

                                <textarea style="display: none;" name="content">{{$commission_settings}}</textarea>

                                <div class="text-center col-12">
                                    <button ng-show="$commission_settings.length != 0" class="btn btn-success" type="submit">Update </button>
                                </div>
                              </form>

                             </div>

                        </div>
                    </div>
                </div>



                 <div class="row" style="display: none;">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header"  data-toggle="collapse" data-target="#pools_settings">
                                <a href="javascript:void;" class="card-title">Pools Settings</a>
                                 <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                       </div>

                            </div>
                            <div class="card-body row collapse" id="pools_settings">
                              
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>SN</th>
                                    <th>Level</th>
                                    <th>Min Merchants </th>
                                    <th>Disagio (%)</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr ng-repeat="(key, $pools_setting) in $pools_settings">
                                    <td>{{$index + 1}}</td>
                                    <td>{{$pools_setting.level}}</td>
                                    <td contenteditable="true" ng-model="$pools_setting.min_merchant_recruitment">    
                                        {{$pools_setting.min_merchant_recruitment}}
                                    </td>

                                    <td contenteditable="true" ng-model="$pools_setting.percent_disagio">{{$pools_setting.percent_disagio}}</td>
                                  </tr>
                                
                                </tbody>
                              </table>

                                
                              <form action="<?=domain;?>/settings/update_pools_settings" method="post" class="ajax_form" >

                                <textarea style="display: none;" name="content">{{$pools_settings}}</textarea>

                                <div class="text-center col-12">
                                    <button ng-show="$pools_settings.length != 0" class="btn btn-success" type="submit">Update </button>
                                </div>
                              </form>

                             </div>

                        </div>
                    </div>
                </div>
                

                 <div class="row" >
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header"  data-toggle="collapse" data-target="#isp">
                                <a href="javascript:void;" class="card-title">International Sales Pools Settings</a>
                                 <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                       </div>

                            </div>
                            <div class="card-body row collapse show" id="isp">
                              
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>SN</th>
                                    <th>Coin</th>
                                    <th>Percent(%) </th>
                                    <th>Coin Received</th>
                                    <th>Requirement</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr ng-repeat="(key, $isp_line) in $isp.isp">
                                    <td>{{$index + 1}}</td>
                                    <td>{{$isp_line.name}}</td>
                                    <td contenteditable="true" ng-model="$isp_line.isp_percent"></td>
                                    <td contenteditable="true" ng-model="$isp_line.coin_received"></td>
                                    <td>
                                      
                                      <span  ng-repeat="(key, $requirement) in $isp_line.requirement">
                                       <br><b> {{key}}</b> <br>
                                        <span style="margin-left: 10px;"  ng-repeat="(key, $line) in $requirement">
                                          <br>{{key}} <br>
                                          <span style="margin-left: 10px;" contenteditable="true" ng-model="$requirement[key]"></span>

                                        </span>


                                       
                                      </span>


                                    </td>
                                  </tr>
                                
                                </tbody>
                              </table>

                              <div class="form-group col-12"><label>ISP Make Up</label></div>
                              <div class="form-group col-4" ng-repeat="(key, $makeup) in $isp.isp_make_up">
                                <label>{{key}} (%)</label>
                                <input type="" class="form-control" name="" ng-model="$isp.isp_make_up[key]">
                              </div>



                                
                              <form action="<?=domain;?>/settings/update/isp" method="post" class="ajax_form" >



                                <textarea style="display: none;" name="content">{{$isp}}</textarea>

                                <div class="text-center col-12">
                                    <button ng-show="$isp.length != 0" class="btn btn-success" type="submit">Update </button>
                                </div>
                              </form>

                             </div>

                        </div>
                    </div>
                </div>



                
                       <div class="row" >
                         <div class="col-12">
                           <div class="card">

                             <div class="card-header"  data-toggle="collapse" data-target="#Rules">
                               <a href="javascript:void;" class="card-title">Rules Settings</a>
                               <div class="heading-elements">
                                 <ul class="list-inline mb-0">
                                   <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                   <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                 </ul>
                               </div>

                             </div>

                             <div class="card-body row collapse" id="Rules">
                               <div class="col-12">
                                 <div class="row">
                                     
                                   <div class="form-group col-md-6">
                                     <label>Withdrawal Fee (%)</label>
                                     <input type="" class="form-control" name="" ng-model="$rules_settings.withdrawal_fee_percent">
                                   </div>


                                   <div class="form-group col-md-6">
                                     <label>Minimum Withdrawal </label>
                                     <input type="" class="form-control" name="" ng-model="$rules_settings.min_withdrawal_usd">
                                   </div>

                                <!--
                                   <div class="form-group col-md-6">
                                   <label>User Transfer Fee (%)</label>
                                   <input type="" class="form-control" name="" ng-model="$rules_settings.user_transfer_fee_percent">
                                 </div>

                                   <div class="form-group col-md-6">
                                   <label>Min Transfer Amount </label>
                                   <input type="" class="form-control" name="" ng-model="$rules_settings.min_transfer_usd">
                                 </div>
                                 </div>


                                  <div class="form-group col-12">
                                   <label>Minimum Deposit </label>
                                   <input type="" class="form-control" name="" ng-model="$rules_settings.min_deposit_usd">
                                 </div>


                                 <div class="form-group col-12">
                                   <label>The Yields of liability and bonuses by career plan are paid </label>
                                   <input type="" class="form-control" name="" ng-model="$rules_settings.yield_of_liability_and_bonuses_is_paid">
                                 </div>


                                 <div class="form-group col-12">
                                   <label>The Service Package begins to compute from <b>nth</b> day of acquiring it  </label>
                                   <input type="" class="form-control" name="" ng-model="$rules_settings.service_package_computes_returns_from_xth_day">
                                 </div>

                                 <hr/>
                                 <div class=" row">
                                   <div class="form-group col-md-12">
                                     The income and commissions generated are paid in: 
                                   </div>
                                   <div class="form-group col-md-4">
                                     <label>Cash (%)  </label>
                                     <input type="" class="form-control" name="" ng-model="$rules_settings.income_split_percent.cash_percent">
                                   </div>
                                   <div class="form-group col-md-4">
                                     <label>TruCash (%)  </label>
                                     <input type="" class="form-control" name="" ng-model="$rules_settings.income_split_percent.trucash_percent">
                                   </div>


                                   <div class="form-group col-md-4">
                                     <label>Grace Period to sell Hot Wallet Coins (Days)  </label>
                                     <input type="" class="form-control" name="" ng-model="$rules_settings.income_split_percent.grace_period_to_sell_hot_wallet">
                                   </div>


                                 </div>
                                 
                                 <hr/>
                                 <div class=" row">
                                   <div class="form-group col-md-12">
                                     This month Membership Expiry  : 
                                   </div>
                                   <div class="form-group col-md-4">
                                     <label>From  </label>
                                     <input type="" class="form-control" name="" ng-model="$rules_settings.this_month_membership_expiry_rule.from">
                                   </div>

                                   <div class="form-group col-md-4">
                                     <label>To   </label>
                                     <input type="" class="form-control" name="" ng-model="$rules_settings.this_month_membership_expiry_rule.to">
                                   </div>
                
                                   <div class="form-group col-md-4">
                                     <label>Membersihp Renewal x/month  </label>
                                     <input type="" class="form-control" name="" ng-model="$rules_settings.this_month_membership_expiry_rule.renewal_date">
                                   </div>

                -->
                                 </div>


                                 <form action="<?=domain;?>/settings/update/rules_settings" method="post" class="ajax_form" id="rules_settings_form">

                                   <textarea style="display: none;" name="content">{{$rules_settings}}</textarea>

                                   <div class="text-center col-12">
                                     <button ng-show="$rules_settings.length != 0" class="btn btn-success" type="submit">Update </button>
                                   </div>
                                 </form>





                               </div>
                             </div>

                           </div>
                         </div>
                       </div>







        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
