<?php
$page_title = "View Cart";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">View Cart</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">View Cart</li>
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
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">

                                <div class="table-responsive">

                                      <table class="table text-center" style="color: black !important;">
                                                <thead>
                                                    <tr>
                                                        <th>&nbsp;</th>
                                                        <th>&nbsp;</th>
                                                        <th class="text-left"
                                                        style="width: 40%;">Product</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr  ng-repeat ="($index, $item) in $shop.$cart.$items">
                                                        <td class="product-remove text-left">
                                                            <a href="javascript:void;"  ng-click="$shop.$cart.remove_item($item)" >
                                                                <i class="fa fa-times"></i>
                                                            </a>
                                                        </td>
                                                        <td class="product-thumbnail text-left">

                                                            <img src="{{$item.mainimage}}"  alt="Product Thumnail" style="width: 75px; object-fit: cover;" >
                                                        </td>
                                                        <td class="product-name text-left wide-column" >
                                                            <h3>
                                                                <a style="text-transform: capitalize;
                                                                color: black;">   {{$item.name}}
                                                                </a>
                                                            </h3>
                                                        </td>
                                                        <td class="product-price">
                                                            <span class="product-price-wrapper">
                                                                <span class="money">
                                                                    <?=$currency;?>{{$item.price}}</span>
                                                            </span>
                                                        </td>
                                                        <td class="product-quantity">
                                                            <div class="quantity">
                                                                <input style="width: 35px;" ng-change="$shop.$cart.update_server();" type="number" class="quantity-input" ng-model="$item.qty" id="qty-4"  min="1">
                                                            </div>
                                                        </td>
                                                        <td class="product-total-price">
                                                            <span class="product-price-wrapper">
                                                                <span class="money">
                                                                    <strong>
                                                                    <?=$currency;?>{{($item.price * $item.qty)}}
                                                                    </strong>
                                                                </span>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                      <a href="javascript:void;" ng-click="$shop.$cart.empty_cart()"  class="btn btn-primary">Empty Cart</a>

                        <a href="<?=domain;?>/user/shop" class="float-right btn btn-secondary"> Continue Shopping</a><br>
                                     
                                </div>
                            </div>
                        </div>
                    </div>

                     <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">Summary</div>
                            <div class="card-body">
                                <div class="table-content table-responsive">
                                        <table class="table order-table">
                                            <tbody>
                                                <tr>
                                                    <th>Subtotal</th>
                                                    <td class="text-right"><?=$currency;?> {{($shop.$cart.$total) |  currency:''}} </td>  
                                                </tr>



                                                <tr>
                                                    <th>Scheme (- <?=$percent_off =$this->auth()->subscription->percent_off;?>%)</th>
                                                    <td class="text-right"><?=$currency;?> 
                                                {{(
                                                (<?=$percent_off;?> * 0.01* $shop.$cart.$total)
                                                ) |  currency:''}} </td>  
                                                </tr>




                                                <tr class="order-total">
                                                    <th>Total</th>
                                                       <td class="text-right"><b>
                                                        <?=$currency;?> 
                                                {{($shop.$cart.$total -
                                                (<?=$percent_off;?> * 0.01* $shop.$cart.$total)
                                                ) |  currency:''}}
                                                    </b>
                                                 </td>  
                                                </tr>
                                            </tbody>
                                        </table>

                            <form id="cart_form" method="post" action="<?=domain;?>/shop/complete_order">
                                <textarea style="display: none;" name="cart">
                                    {{$shop.$cart}}
                                </textarea>
                                <button type="submit"  id="proceed_to_checkout_btn" 
                                    class="btn btn-secondary">
                                        Proceed To Checkout
                                </button>                                        
                            </form>



        <script>

    

            $("body").on("submit", "#cart_form", function (e) {
             e.preventDefault();


                $("#proceed_to_checkout_btn").attr("disabled", true);
                $("#proceed_to_checkout_btn").append(" <i class='fa fa-spinner fa-spin'></i>");




                dataString = $("#cart_form").serialize() ;


                    $.ajax({
                        type: "POST",
                        url: $base_url+"/shop/complete_order",
                        data: dataString,
                        cache: false,
                        success: function(data) {
                            console.log(data);
                            InitPayment(data.id);                          
                            window.notify();
                  
                        },
                        error: function (data) {
                        },
                        complete: function(){
                            
                            $("#proceed_to_checkout_btn").attr("disabled", false);
                            $("#proceed_to_checkout_btn").html("Proceed To Checkout");

                        }
                    });
            });





        </script>     









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
<script>
    $(function() {
        $('#myTable').DataTable();
    });
</script>
