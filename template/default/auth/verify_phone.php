<?php
$page_title = "Verify Phone";
 include 'includes/auth_header.php';
 ;?>


<script>
     
  
    function send_phone_verification_code() {
        if( window.$ ) {
            // do your action that depends on jQuery.  
            $("#phone_spiner").html('<i class="fa fa-spinner fa-spin"></i>');
          $.ajax({
              type: "POST",
              url: "<?=domain;?>/register/verify_phone",
              cache: false,
              success: function(response) {

                },error: function(response) {

                }
            });

             $("#phone_spiner").html('<i class="fa fa-spinner fa-spin"></i>');
        } else {
                // wait 50 milliseconds and try again.
                window.setTimeout( send_phone_verification_code, 1000 );
        }
    }


    send_phone_verification_code();
</script>
 




               
                <div class="row">
                    <div class="col-12">
                    <h3>Phone Verification</h3>
                        <div class="card">
                        <div class="card-header">
                            <i class="fa fa-user"></i> <?=$this->auth()->fullname;?> (<?=$this->auth()->username;?>)
                        </div>
                            <div class="card-body">

                                  <p>Hello <?=$this->auth()->firstname;?>! We have sent a code to your phone. kindly check and enter the code to continue.</p>

                                <form method="POST" action="<?=domain;?>/register/confirm_phone/">
                                <div class="form-group">
                                    <input type="text" name="phone_code" placeholder="Enter Phone code" class="form-control">
                                    <span class="text-danger"><?=$this->inputError('phone_code');?></span>
                                </div>
                                    
                                    <button type="button" class="btn btn-secondary" onclick="send_phone_verification_code();">
                                    <span id="spiner"></span> Resend</button>

                                    <button type="submit" class="btn btn-success">
                                    <span id="spiner"></span> Confirm</button>
                                </form>
                          

                            </div>
                        </div>
                    </div>
                </div>
           
<?php 

// include 'app/others/phone_verification.php';
include 'includes/auth_footer.php';

?>
