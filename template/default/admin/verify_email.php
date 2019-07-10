<?php
$page_title = "Verify Email";
 include 'includes/auth_header.php';
 ;?>


<script>
     
    function send_verification_email() {
        if( window.$ ) {
                // do your action that depends on jQuery.  
          $.ajax({
              type: "POST",
              url: "<?=domain;?>/register/verify_email/<?=$this->auth()->email;?>",
              cache: false,
              success: function(response) {
                    window.notify();
                },
                error: function(response) {}
            });

            $("#spiner").html('<i class="fa fa-spinner fa-spin"></i>');
        } else {
                // wait 50 milliseconds and try again.
                window.setTimeout( send_verification_email, 1000 );
        }
    }
    send_verification_email();
</script>
 




               
                <div class="row">
                    <div class="col-12">
                    <h3>Email Verification</h3>
                        <div class="card">
                        <div class="card-header">
                            <i class="fa fa-user"></i> <?=$this->auth()->fullname;?> (<?=$this->auth()->username;?>)
                        </div>
                            <div class="card-body">
                                <p>Hello <?=$this->auth()->firstname;?>! We have sent you a mail. kindly check your mail box to verify your email.
                                </p>
                                <button type="button" class="btn btn-success" onclick="send_verification_email();">
                                <span id="spiner"></span> Resend</button>

                            </div>
                        </div>
                    </div>
                </div>
           
<?php include 'includes/auth_footer.php';?>
