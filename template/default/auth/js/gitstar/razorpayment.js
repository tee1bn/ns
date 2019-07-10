  InitPayment = function ($order_id) {
                        $.ajax({
                                    type: "POST",
                                    url: $base_url+'/shop/fetch_order/'+$order_id,
                                    cache: false,
                                    data: null,
                                    success: function(data) {
                                        $option = new PaymentOptions(data);
                                         var rzp1 = new Razorpay($option);
                                            rzp1.open();

                                    },
                                    error: function (data) {
                                         //alert("fail"+data);
                                    }
                            });
    }




    PaymentOptions = function ($data) {

            this.key =  $data.razorpay_public_key,
            this.amount = $data.razorpay_amount, // INR 299.35
            this.name =  $data.company,
            this.$data =$data;
            this.order_id =$data.razorpay_order_id;


            // this.image: https://example.com/your_logo,
            this.handler = function (response){
                    
                    var $mle_order_id = $data.id;
                    razorpay_payment_id = response.razorpay_payment_id;
                    // alert(response.razorpay_payment_id);

                    $form = new FormData;

                    $form.append('razorpay_response' , JSON.stringify(response));

                    // console.log(response)
                  $.ajax({
                            type: "POST",
                            url: $base_url+'/shop/capture_payment/'+razorpay_payment_id+"/"+$mle_order_id,
                            cache: false,
                            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                            processData: false, 
                            data: $form,
                            success: function(data) {

                                // console.log(data);

                                window.notify();                               
                                window.location.replace($base_url+"/user/products-orders");
                            },
                            error: function (data) {
                                 //alert("fail"+data);
                            }
                            });


            }


    }


  SchemeInitPayment = function ($order_id) {
                        $.ajax({
                                    type: "POST",
                                    url: $base_url+'/shop/fetch_suborder/'+$order_id,
                                    cache: false,
                                    data: null,
                                    success: function(data) {
                                        $option = new SchemePaymentOptions(data);
                                         var rzp1 = new Razorpay($option);
                                            rzp1.open();

                                    },
                                    error: function (data) {
                                         //alert("fail"+data);
                                    }
                            });
    }




    SchemePaymentOptions = function ($data) {

            this.key =  $data.razorpay_public_key,
            this.amount = $data.razorpay_amount, // INR 299.35
            this.name =  $data.company,
            this.$data =$data;
            this.order_id =$data.razorpay_order_id;


            // this.image: https://example.com/your_logo,
            this.handler = function (response){
                    
                    var $mle_order_id = $data.id;
                    razorpay_payment_id = response.razorpay_payment_id;
                    // alert(response.razorpay_payment_id);

                    $form = new FormData;

                    $form.append('razorpay_response' , JSON.stringify(response));

                    console.log(response)
                  $.ajax({
                            type: "POST",
                            url: $base_url+'/shop/capture_sub_payment/'+razorpay_payment_id+"/"+$mle_order_id,
                            cache: false,
                            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                            processData: false, 
                            data: $form,
                            success: function(data) {

                                // console.log(data);

                                window.notify();                               
                                window.location.replace($base_url+"/user/subscription-orders");
                            },
                            error: function (data) {
                                 //alert("fail"+data);
                            }
                            });


            }


    }


