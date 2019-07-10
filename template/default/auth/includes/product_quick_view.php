
        <!-- Modal Start -->
        <div class="modal fade product-modal" id="productModal" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-body">
                <button type="button" class="close custom-close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true"><i class="dl-icon-close"></i></span>
                </button>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            
                            <div   class="product-image col-md-6">
                                <div class="product-image--holder">
                                    <a href="{{$shop.$quickview.url_link}}">
                                        <img src="{{$shop.$quickview.mainimage}}" alt="Product Image" class="primary-image" style="height: 200px;width: 100%;object-fit: cover;">
                                    </a>
                                </div>
                                <!-- <span class="product-badge sale" ng-if="$shop.$quickview.ribbon">{{$shop.$quickview.ribbon}}</span> -->
                                
                            </div>
                            <div class="col-md-6">

                                            
                                <br>
                                <br>
                                <div class="product-navigation mb--10">
                                    <a href="#" class="prev"><i class="dl-icon-left"></i></a>
                                    <a href="#" class="next"><i class="dl-icon-right"></i></a>
                                </div>
                                <h3 class="product-title mb--15"  >{{$shop.$quickview.name}}</h3>
                                <h1 class="product-price-wrapper mb--20">
                                    <span class="money"   >  <?=$currency;?> {{$shop.$quickview.price}}</span>
                                    <del ng-show="$shop.$quickview.old_price>0" class="text-danger">
                                        <span class="money text-danger"> <?=$currency;?> {{$shop.$quickview.old_price}}</span>
                                    </del>

                                </h1>
      <!-- <span class="badge badge-primary" ng-if="$shop.$quickview.old_price">-{{$shop.$quickview.percentdiscount}}%</span>                        -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="modal-box product-summary">
                            <div class="product-navigation mb--10">
                                <a href="#" class="prev"><i class="dl-icon-left"></i></a>
                                <a href="#" class="next"><i class="dl-icon-right"></i></a>
                            </div>
                            <br>
                            <h2 class="product-title mb--15"  >Description</h2>
                            <!-- <h3 class="product-title mb--15"  >{{$shop.$quickview.name}}</h3> -->
                           <!--  <span class="product-price-wrapper mb--20">
                                <span class="money"   >  <?=$currency;?> {{$shop.$quickview.price}}</span>
                                <del>
                                    <span class="money"> <?=$currency;?> {{$shop.$quickview.old_price}}</span>
                                </del>
                            </span> -->
                            <p class="product-short-description mb--25 mb-md--20" ng-bind-html="$shop.$quickview.description">
                            </p>
                            <div class="product-action d-flex flex-row align-items-center mb--30 mb-md--20">
                              <!--   <div class="quantity">
                                    <input type="number" class="quantity-input" name="qty" id="quick-qty" value="1" min="1">
                                </div> -->
                                <button ng-click="$shop.$cart.add_item($shop.$quickview)"  type="button" class="btn fa fa-shopping-cart btn-primary"  >
                                    Add To Cart
                                </button>
                                <!-- <a href="wishlist.html"><i class="dl-icon-heart2"></i></a> -->
                            </div>  

                            <br>
                         

                            <div class="product-summary-footer d-flex justify-content-between flex-sm-row flex-column flex-sm-row flex-column">
                                <div class="product-meta">
                            <!--         <span class="posted_in font-size-12"  >Categories: <a href="" rel="tag" style="text-transform: capitalize;"  >{{$shop.$quickview.category.category}}</a>
                                    </span> -->
                                </div>
                         
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal End -->
