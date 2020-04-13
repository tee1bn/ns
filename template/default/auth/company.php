<?php
$page_title = "Company";
include 'includes/header.php'; ?>
<script src="<?= asset; ?>/angulars/company_documents.js"></script>

<!-- BEGIN: Content-->
<div ng-controller="CompanyController" class="app-content content" ng-cloak>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-6 mb-2">
                <?php include 'includes/breadcrumb.php'; ?>

                <h3 class="content-header-title mb-0">Profile</h3>
            </div>

            <div class="content-header-right col-6">
                <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                    <a class="btn btn-outline-primary" href="javascript:void(0);"
                       data-toggle="modal"
                       data-target="#upload_company_supporting_document">+<i class="ft-file"></i>Upload</a>
                   <!-- <a ng-click="$list.attempt_request_for_review();" id="request_review_btn"
                       class="btn btn-outline-primary"
                       href="javascript:void(0);"><i class="ft-pie-chart"></i> Request Review</a>
-->
                    <?php if ($this->admin()): ?>

                        <?php if (!$company->is_approved()): ?>
                            <a class="btn btn-outline-primary" href="javascript:void;" onclick="$confirm_dialog =
                                    new ConfirmationDialog('<?= domain; ?>/admin/approve-company/<?= $company->id; ?>', '<?= $company->ApprovalConfirmation; ?></b>')">
                                <span type='span' class='label label-xs label-primary'>Approve</span>
                            </a>
                        <?php endif; ?>


                        <?php if (!$company->is_declined()): ?>
                            <a class="btn btn-outline-primary" href="javascript:void;" onclick="$confirm_dialog =
                                    new ConfirmationDialog('<?= domain; ?>/admin/decline-company/<?= $company->id; ?>','<?= $company->DeclineConfirmation; ?>')">
                                <span type='span' class='label label-xs label-primary'>Decline</span>
                            </a>
                        <?php endif; ?>


                    <?php endif; ?>
                </div>


            </div>
        </div>
        <div class="content-body">


            <script>
                refresh_page = function () {
                    angular.element($('#document_form')).scope().fetch_page_content();
                }
            </script>


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
                        <form id="document_form" data-function="refresh_page" class="col-md-12 ajax_form"
                              enctype="multipart/form-data"
                              action="<?= domain; ?>/company/upload_company_supporting_document" method="post">
                            <div class="modal-body">
                                <style>
                                    td {
                                        padding: 0px !important;
                                    }
                                </style>


                                <button type="button" class="btn btn-secondary float-right btn-sm"
                                        ng-click="$list.add_component();">+Add Document
                                </button>
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
                                    <button ng-hide="$list.$active_list.length==0" type="submit"
                                            class="btn btn-success">Save
                                    </button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <?php if (!$company->is_approved()): ?>
                <div class="alert alert-danger mb-2" role="alert">
                    <strong>NOTE!</strong> Please fill all details accurately providing legal documents. Then, request
                    review for approval
                    <a href="javascript:void(0);" ng-click="$list.attempt_request_for_review();" class="alert-link">Request
                        Review</a>
                </div>
            <?php endif; ?>

            <style>
                .main-avatar {
                    height: 160px;
                    border-radius: 80px;
                    width: 160px;
                    object-fit: cover;
                }
            </style>
            <?php
            $package = $auth->subscription->payment_plan;
            $company = $auth->company;; ?>


            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-content">
                            <div class="media align-items-stretch">
                                <div class="p-2 text-center bg-white bg-darken-2">
                                    <i class="ft-block font-large-2"></i>
                                    <img class="icon p-1 customize-icon font-large-2 p-1" src="<?= $package->Image; ?>"
                                         style="height: 130px;width: 100px;object-fit: cover;">
                                </div>
                                <div class="pt-2 bg-gradient-x-white mt-3  media-body">
                                    <h5><b><?= $package->package_type; ?> </b></h5>
                                    <h5 class="text-bold-400 mb-0"> Package</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <h6 class="card-tile">Profile Information</h6>
                                <div class="row">
                                    <div class="col-md-12 text-center pt-2 mb-1">
                                        <img class="main-avatar img-round"
                                             src="<?= domain; ?>/<?= $auth->profilepic; ?>" alt="">
                                    </div>
                                    <div class="col-md-12 text-center">

                                        <form class="form-horizontal ajax_for"
                                              action="<?= domain; ?>/user-profile/update_profile_picture" id="p_form"
                                              method="post" enctype="multipart/form-data">
                                            <div class="user-profile-image" align="center" style="">
                                                <input type='file' name="profile_pix"
                                                       onchange="$('#change_btn').click();" id="uploadImage"
                                                       style="display:none ;"/>
                                                <button type="submit" style="display: none;" id="change_btn"></button>
                                                <label href="#" for="uploadImage"
                                                       style="text-decoration: underline;cursor: pointer;">Upload or
                                                    delete photo</label>
                                            </div>
                                        </form>

                                    </div>

                                    <div class="col-md-12 text-center">
                                        <form class="">
                                            <div class="form-group">
                                                <input type="" class="form-control" name="" placeholder="Username">

                                            </div>

                                            <div class="form-group">
                                                <input type="" class="form-control" name="" placeholder="Password">
                                            </div>

                                            <div class="form-group">
                                                <input type="" class="form-control" name=""
                                                       placeholder="Confirm Password">
                                            </div>
                                        </form>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-md-9">

                    <div class="card">

                        <form action="<?= domain; ?>/user-profile/update_user" method="post">
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
                                            <!-- <label for="title" class="pull-left">Title </label> -->
                                            <select class="form-control" name="personal[title]">
                                                <option value="">Select title</option>
                                                <?php foreach ($auth::$available_titles as $key => $value) : ?>
                                                    <option <?= ($auth->title == $key) ? 'selected' : ''; ?>
                                                            value="<?= $key; ?>"><?= $value; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="" class="form-control" name="personal[firstname]"
                                                   value="<?= $auth->firstname; ?>" placeholder="First name">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <input type="" class="form-control" name="personal[lastname]"
                                                   value="<?= $auth->lastname; ?>" placeholder="Surname">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <select class="form-control" name="personal[country]" required="">
                                                <option value="">Select Country</option>
                                                <?php foreach (World\Country::all() as $key => $country) : ?>
                                                    <option <?= ($auth->country == $country->id) ? 'selected' : ''; ?>
                                                            value="<?= $country->id; ?>"><?= $country->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-5">
                                            <input type="" class="form-control" name="personal[address][place]"
                                                   value="<?= $auth->addressArray['place'] ?? ''; ?>"
                                                   placeholder="Place">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <input type="" class="form-control" name="personal[address][post_code]"
                                                   value="<?= $auth->addressArray['post_code'] ?? ''; ?>"
                                                   placeholder="Post code">
                                        </div>


                                        <div class="form-group col-md-7">
                                            <input type="" class="form-control" name="personal[address][address]"
                                                   value="<?= $auth->addressArray['address'] ?? ''; ?>"
                                                   placeholder="Residential address">
                                        </div>


                                        <div class="form-group col-md-5">
                                            <input type="" class="form-control" name="personal[address][house_number]"
                                                   value="<?= $auth->addressArray['house_number'] ?? ''; ?>"
                                                   placeholder="House number">
                                        </div>

                                    </div>
                                    <hr>
                                    <h6 class="card-tile">Your Business</h6>
                                    <div class="row">

                                        <div class="form-group col-md-5">
                                            <input type="" class="form-control" name="company[name]"
                                                   value="<?= $company->name; ?>" placeholder="Company name">
                                        </div>

                                        <div class="form-group col-md-5">
                                            <select class="form-control" name="company[legal_form]">
                                                <option value="">Legal Form</option>
                                                <option value="">Option</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <input type="" class="form-control" name="company[vat_number]"
                                                   value="<?= $company->vat_number; ?>" placeholder="VAT Number">
                                        </div>


                                        <div class="form-group col-md-2">
                                            <select class="form-control" name="company[country]" required="">
                                                <option value="">Select Country</option>
                                                <?php foreach (World\Country::all() as $key => $country) : ?>
                                                    <option <?= ($company->country == $country->id) ? 'selected' : ''; ?>
                                                            value="<?= $country->id; ?>"><?= $country->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-5">
                                            <input type="" class="form-control" name="company[address][place]"
                                                   value="<?= $company->addressArray['place'] ?? ''; ?>"
                                                   placeholder="Place">
                                        </div>

                                        <div class="form-group col-md-5">
                                            <input type="" class="form-control" name="company[address][post_code]"
                                                   value="<?= $company->addressArray['post_code'] ?? ''; ?>"
                                                   placeholder="Post code">
                                        </div>


                                        <div class="form-group col-md-7">
                                            <input type="" class="form-control" name="company[address][address]"
                                                   value="<?= $company->addressArray['address'] ?? ''; ?>"
                                                   placeholder="Business address">
                                        </div>


                                        <div class="form-group col-md-5">
                                            <input type="" class="form-control" name="company[address][house_number]"
                                                   value="<?= $company->addressArray['house_number'] ?? ''; ?>"
                                                   placeholder="House number">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <input type="" class="form-control" name="company[office_email]"
                                                   placeholder="E-mail address"
                                                   value="<?= $company->office_email; ?>">
                                        </div>


                                        <div class="form-group col-md-6">
                                            <input type="" class="form-control" name="company[office_phone]"
                                                   value="<?= $company->office_phone; ?>" placeholder="Phone number">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <input type="" class="form-control" name="company[iban_number]"
                                                   placeholder="IBAN" value="<?= $company->iban_number; ?>">
                                            <small class="float-right">for commission payments</small>
                                        </div>


                                    </div>

                                </div>
                            </div>

                            <button id="btn_id" style="display: none;">submit</button>

                        </form>
                    </div>


                </div>
            </div>
            <div class="row match-height">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <h6 class="card-tile">Please upload the required documents here:</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 text-center"
                                         style="border: 1px dashed #0000002b ;min-height: 95px;">
                                        <a ref="javascript:void(0);"
                                           data-toggle="modal"
                                           data-target="#upload_company_supporting_document"
                                           style="cursor: pointer; padding: 0;position: absolute;left:35%;top: 20%;color: #0000002b;">

                                            <i class="ft-upload-cloud" style="font-size: 40px;"></i><br>
                                            <small>Upload files here</small>

                                        </a>

                                    </div>
                                    <small>File format: jpeg, pdf, png, with a max. Size of 2MB</small>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <h6 class="card-tile">Please download the following documents high:</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 ">

                                        <ul class="list-group list-group-flush">
                                            <li ng-repeat="(key, $doc) in $list.$lists" class="list-group-item small-padding" style="text-transform: capitalize;">
                                                <a href="javascript:void(0);" ng-click="$list.attempt_delete($doc, key);"
                                                   class="fa fa-trash text-danger float-right" style="font-size: 20px;"><i class=""></i></a>
                                                <a target="_blank" href="<?=domain;?>/{{$doc.files}}"><b>{{$doc.label}}</b></a>
                                            </li>
                                        </ul>



                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>

                </div>
                <div class="col-md-4 text-center">
                    <button class="btn btn-block btn-outline-teal btn-lg" onclick="$('#btn_id').click();">Save Changes
                    </button>
                    <p></p>
                    <p>or</p>
                    <button class="btn btn-block btn-outline-teal btn-lg"
                            ng-click="$list.attempt_request_for_review();">Verify Lets Save
                    </button>

                </div>

            </div>
        </div>
    </div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php'; ?>
