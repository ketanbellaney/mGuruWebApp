<div class="container main-container" style='height:600px;'>

    <div class="row">
        <div class="col-md-12">
          <br /><br />
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <?php
                echo '<h1 align="center" style="font-family: din,Calibri,Cantarell,sans-serif;"><b>Reset Password</b></h1>';
                if($meta_type == 1 ) {
                    echo "<div class='alert alert-warning' role='alert'><b>Password reset code did not match</b>. Please try again.</div>";
                } else if($meta_type == 2) {
                    echo "<div class='alert alert-success' role='alert'><b>Well done</b>. Please check your email for reset code.</div>";
                } else if($meta_type == 3) {
                    echo "<div class='alert alert-success' role='alert'><b>Well done</b>. Please check your mobile for OTP.</div>";
                }

                echo "<br /><br />";
            ?>
                <div class="col-md-4 col-lg-4 col-sm-2 hidden-xs">
                  &nbsp;
                </div>

                <div class="col-md-4 col-lg-4 col-sm-8 col-xs-12 text-center">
                    <form class="form-horizontal form-group" action='<?php echo site_url("worksheet/resetpassword/$meta_type/$mcode"); ?>' data-toggle="validator" method="POST" onsubmit='return validateregistration();' >
                        <fieldset>
                            <div class="control-group">
                                <?php
                                    $mmm = 'Reset code';
                                    if($meta_type == 2 ) {
                                    //    echo "<label class='control-label' >Reset code</label>";
                                    } if($meta_type == 3 ) {
                                    //    echo "<label class='control-label' >OTP</label>";
                                        $mmm = 'OTP';
                                    } else {
                                    //    echo "<label class='control-label' >Reset code</label>";
                                    }
                                ?>

                            </div>
                            <div class="control-group">
                                <label class="control-label"  for="username"><?php echo $mmm; ?> <span class='redspan'>*</span></label>
                                <div class="controls">
                                    <input type="text" id="ws_code" name="ws_code" placeholder="" value='<?php echo @$mcode; ?>' class="input-xlarge form-control" maxlength="4" required  />
                                    <span class="error_message"></span>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label"  for="username">Password <span class='redspan'>*</span></label>
                                <div class="controls">
                                    <input type="password" id="ws_password" name="ws_password" placeholder="" value='' class="input-xlarge form-control" data-minlength="6"  required />
                                    <span class="error_message"></span>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label"  for="username">Confirm Password <span class='redspan'>*</span></label>
                                <div class="controls">
                                    <input type="password" id="ws_password_confirm" name="ws_password_confirm" placeholder="" value='' class="input-xlarge form-control" data-minlength="6" required  />
                                    <span class="error_message"></span>
                                </div>
                            </div>

                            <div class="control-group">
                                <div class="controls">
                                    <br /><br />
                                    <button class="btn btn-success btn-lg" id='verbutton'>Submit</button>
                                    <br /><br />
                                    <a href="<?php echo site_url("worksheet/forgotpassword"); ?>" >Resend <?php echo $mmm; ?>?</a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
               <div class="col-md-4 col-lg-4 col-sm-2 hidden-xs">
                  &nbsp;
                </div>


        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
          <br /><br />
        </div>
    </div>
</div>
<script>
    
    $( document ).ready(function() {

    });

    //! Validation function
    function validateregistration() {
        var error = 0;

        var ws_password = $("#ws_password").val();
        var ws_password_confirm = $("#ws_password_confirm").val();
        var ws_code = $("#ws_code").val();

        var error_template = "<div class='alert alert-danger' style='margin-top: 5px;padding: 5px;'><i class='glyphicon glyphicon-remove' ></i> ::error::</div>";

        $(".error_message").html("");

        if(ws_password == "") {
            $( "#ws_password" ).next(".error_message").html( error_template.replace("::error::","Please provide password.") );
            $( "#ws_password" ).focus();
            error = 1;
        } else if(ws_password.length < 6) {
            $( "#ws_password" ).next(".error_message").html( error_template.replace("::error::","Please provide proper password with atleast 6 characters.") );
            $( "#ws_password" ).focus();
            error = 1;
        }

        if(ws_password_confirm != ws_password) {
            $( "#ws_password_confirm" ).next(".error_message").html( error_template.replace("::error::","Confirm password miss-match, please type confirm password again.") );
            $( "#ws_password_confirm" ).focus();
            error = 1;
        }

        if(ws_code.length != 4) {
            $( "#ws_code" ).next(".error_message").html( error_template.replace("::error::","Please provide proper <?php echo $mmm; ?>") );
            $( "#ws_code" ).focus();
            error = 1;
        }

        if(error) {
            scrollto(0);
            return false;
        }

        return true;
    }

    function validateEmail(email) {
        var email_validation_template = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return email_validation_template.test(email);
    }

    function validateMobile (mobile) {
        var mobile_validation_template = /^[1-9]{1}[0-9]{9}$/;
        return mobile_validation_template.test(mobile);
    }

    function scrollto(heightt) {
        $('html, body').stop().animate({
            scrollTop: heightt
        }, 1500, 'easeInOutExpo');

        $( ".error_message" ).effect( "slide",{},1000 );
    }
</script>