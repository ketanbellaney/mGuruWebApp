<div class="container main-container" >
    <div class="row">

        <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
        <form class="form-horizontal form-group" action='<?php echo site_url("registrations/signupprocess"); ?>' data-toggle="validator" method="POST" onsubmit='return validateregistration();' >
            <fieldset>
                <br /><br />
                <div id="legend">
                    <legend class="">Register</legend>
                </div>

                <div class="control-group">
                    <label class="control-label"  for="username">Username <span class='redspan'>*</span></label>
                    <div class="controls">
                        <input type="text" id="ws_username" name="ws_username" placeholder="Username should be alphanumeric" class="input-xlarge form-control" data-minlength="5"  />
                        <span class="error_message"></span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="email">E-mail <span class='ornagespan'>*</span> <p class="help-block">(Provide either mobile or email-Id.)</p></label>
                    <div class="controls">
                        <input type="text" id="ws_email" name="ws_email" placeholder="Please provide your E-mail" class="input-xlarge form-control" />
                        <span class="error_message"></span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="email">Mobile <span class='ornagespan'>*</span> </label>
                    <div class="controls">
                        <input type="mobile" id="ws_mobile" name="ws_mobile" placeholder="Please provide your mobile number" class="input-xlarge form-control" />
                        <span class="error_message"></span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="password">Password <span class='redspan'>*</span> <p class="help-block">( least 6 characters )</p></label>
                    <div class="controls">
                        <input type="password" id="ws_password" name="ws_password" placeholder="" class="input-xlarge form-control" data-minlength="6"  />
                        <span class="error_message"></span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label"  for="password_confirm">Password (Confirm) <span class='redspan'>*</span></label>
                    <div class="controls">
                        <input type="password" id="ws_password_confirm" name="ws_password_confirm" placeholder="" class="input-xlarge form-control" data-match="#ws_password" data-minlength="6"  />
                        <span class="error_message"></span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label"  for="password_confirm">Referral Code (Optional)</label>
                    <div class="controls">
                        <input type="text" id="ws_ref_code" name="ws_ref_code" placeholder="If any" class="input-xlarge form-control" value="<?php echo @$refcode; ?>" />
                        <span class="error_message"></span>
                    </div>
                </div>
                <br /><br />
                <div class="control-group">
                    <div class="controls">
                        <button class="btn btn-success btn-lg">Register Now and get 7 days Premium</button>
                    </div>
                </div>
            </fieldset>
        </form>
        </div>
        <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
           <br /><br />
           <img src='<?php echo base_url("images/englishshare.png"); ?>' class='img-responsive' style='margin: 0 auto;'  />

            <br /><br />
            <h1>mGuru English</h1>
            <p>mGuru English is a fast and interactive way for children to learn English. Designed for kids aged 4 - 10, the app provides a range of activities, games, stories, and content that helps children gain the skills they need to read and speak English. With dozens of stories with learning activities from Pratham, a comprehensive early learners and phonics program, and textbook texts with audio and questions, mGuru English provides an interactive learning journey for students trying to learn English. Parents and teachers can monitor learning progress and results, but do not need to supervise the child. The app so easy to use that students can use it by themselves!
            <br /><br />Instructions are available in English, Hindi, and Marathi. Internet only required for sign in and downloading new content.</p>
            <br style='clear:both'/><br />
        </div>
        <br />
    </div>
</div>

<style>
.redspan, .error_message {
    color: red;
}

.ornagespan {
    color: orange;
}

.help-block{
    display: inline;
}

.control-group{
    margin-top: 10px;
}


</style>

<script>
    //! Validation function
    function validateregistration() {
        var error = 0;

        //! validation data
        var ws_username = $("#ws_username").val();
        var ws_email = $("#ws_email").val();
        var ws_mobile = $("#ws_mobile").val();
        var ws_password = $("#ws_password").val();
        var ws_password_confirm = $("#ws_password_confirm").val();
        var ws_ref_code = $("#ws_ref_code").val();

        var error_template = "<div class='alert alert-danger' style='margin-top: 5px;padding: 5px;'><i class='glyphicon glyphicon-remove' ></i> ::error::</div>";

        $(".error_message").html("");

        if(ws_username == "") {
            $( "#ws_username" ).next(".error_message").html( error_template.replace("::error::","Please provide username.") );
            $( "#ws_username" ).focus();
            error = 1;
        } else if(ws_username.length < 5) {
            $( "#ws_username" ).next(".error_message").html( error_template.replace("::error::","Please provide proper username with atleast 5 characters.") );
            $( "#ws_username" ).focus();
            error = 1;
        }

        if(ws_email != '') {
            if(!validateEmail(ws_email)) {
                $( "#ws_email" ).next(".error_message").html( error_template.replace("::error::","Please provide proper email-id.") );
                $( "#ws_email" ).focus();
                error = 1;
            }
        }

        if(ws_mobile != '') {
            if(!validateMobile(ws_mobile)) {
                $( "#ws_mobile" ).next(".error_message").html( error_template.replace("::error::","Please provide proper mobile number of 10 digits only.") );
                $( "#ws_mobile" ).focus();
                error = 1;
            }
        }

        if(ws_email == '' && ws_mobile == '' ) {
            $( "#ws_email" ).next(".error_message").html( error_template.replace("::error::","Please provide atleast mobile number or email id.") );
            $( "#ws_mobile" ).next(".error_message").html( error_template.replace("::error::","Please provide atleast mobile number or email id.") );
            $( "#ws_email" ).focus();
            error = 1;
        }

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