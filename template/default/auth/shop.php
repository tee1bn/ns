<?php
$page_title = "Shop";
 include 'includes/header.php';?>



    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Shop</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Shop</li>
                        </ol>
                    </div>
                    <div class="col-md-6 col-4 align-self-center">



                       

                    </div>

                  
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row" >
                     <?php include 'includes/product_quick_view.php';?>
                       <div class="col-12">
                          <div class="card-body">


                            <div class="card-header"  data-toggle="collapse" data-target="#demo">
                                <a href="javascript:void;">Showing {{$shop.$items.length}} Item(s)</a>
                            </div>
                            <div class="card-body collapse show" id="demo">


                            <div class="card-body table-responsive">


                        <div class="row">
                            <!-- column -->
                            <div class="col-lg-3 col-md-6" ng-repeat ="($index, $item) in $shop.$items  | filter:searchText">
                                <!-- Card -->
                                <div class="card">
                                    <img class="card-img-top img-responsive" style="width:240 px; height: 180px;
                                    object-fit: cover;"
                                    src="{{$item.mainimage}}" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title">{{$item.name}}</h4>
                                        <p class="card-text">  <span class="money">
                                            <?=$currency;?>
                                            {{$item.price}}</span>
                                        </p>


                                        <a href="javascript:void(0);" ng-click="$shop.quickview($item)"
                                         class="quickview-btn btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Quick Shop">
                                                                <span>
                                                                    <i class="fa fa-eye"></i>
                                                                </span>
                                                            </a>

                                            <a href="javascript:void(0);" ng-click="$shop.$cart.add_item($item)"  class="add_to_cart_btn btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Add to Cart">
                                                <i class="fa fa-shopping-cart"></i>
                                            </a>



                                    </div>
                                </div>
                                <!-- Card -->
                            </div>


                        </div>

                    <center  ng-show="$shop.$no_more_product==false">
                        <button class="btn btn-secondary" ng-click="$shop.fetch_products()">Load More</button>
                    </center>

                            </div>

                            </div>



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
