<?php
$page_title = "Contact us";
include 'includes/header.php';; ?>


<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">

        <div class="content-body">

            <div class="app-content " ng-controller="ShopController">

                <div class="content-header row">
                    <div class="content-header-left col-md-6 mb-2">
                        <h3 class="content-header-title mb-0">Contact us</h3>
                    </div>
                    <div class="content-header-right text-md-right col-md-6">

                    </div>
                </div>
                <div class="content-body">


                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">

                                <div class="card-content">
                                    <div class="card-body">
                                        <h4 class="card-tile border-0">You have a concern or an unanswered
                                            question?</h4>
                                        <hr>
                                        <p>- Fill out our form and send us your request, a representative will contact
                                            you shortly.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <form class="contact-form mt-45 ajax_form" id="contact" method="post"
                          action="<?= domain; ?>/ticket_crud/create_ticket">
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">

                                    <!-- Contact FORM -->
                                    <div class="row">


                                        <div class="form-group col-md-4">
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
                                            <input class="form-control"
                                                   value="<?= $auth->firstname; ?>"
                                                   readonly="readonly"
                                                   id="name" type="" required="" name="firstname"
                                                   placeholder="First Name">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <input class="form-control"
                                                   value="<?= $auth->lastname; ?>"
                                                   readonly="readonly"
                                                   id="name" type="" required="" name="lastname" placeholder="Surname">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <input class="form-control" id="email"
                                                   value="<?= $auth->email; ?>"
                                                   readonly="readonly"
                                                   type="" required="" name="email" placeholder="Email">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <input class="form-control" id="sub"
                                                   value="<?= $auth->phone; ?>"
                                                   readonly="readonly"
                                                   type="" required="" name="phone" placeholder="Phone">
                                        </div>

                                        <input type="hidden" name="from_client" value="true">

                                        <div class="form-group col-md-12">

                                            <textarea class="form-control" id="message" rows="7" name="comment"
                                                      required="" placeholder="Your concern to us"></textarea>
                                        </div>
                                        <div class="col-md-6 col-offset-md-2">
                                            <br>
                                            <?= MIS::use_google_recaptcha(); ?>
                                        </div>


                                    </div>
                                    <!-- END Contact FORM -->

                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 col-lg-12 mt-30">
                            <button class="text-uppercase btn btn-outline-dark float-right" type="submit" id="submit"
                                    name="button" >
                                Send an inquiry
                            </button>
                        </div>
                    </form>

                    <p> &nbsp;</p>

                    <div class="row">


                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php'; ?>
