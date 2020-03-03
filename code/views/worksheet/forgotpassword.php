<div class="container main-container" >
    <div class="row">

        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">

        <form class="form-horizontal form-group" action='<?php echo site_url("worksheet/forgotpasswordprocess"); ?>' data-toggle="validator" method="POST" onsubmit='return validateregistration();' >
            <fieldset>
                <br /><br />
                <?php
                    if(@$error == 1) {
                        echo "<div class='alert alert-danger' role='alert'>The username you entered could not be found.</div><br />";
                    }
                ?>
                <div id="legend">
                    <legend class="">Forgot Password</legend>
                </div>

                <div class="control-group">
                    <label class="control-label"  for="username">Username <span class='redspan'>*</span></label>
                    <div class="controls">
                        <input type="text" id="ws_username" name="ws_username" placeholder="" class="input-xlarge form-control" data-minlength="5"  />
                        <span class="error_message"></span>
                    </div>
                </div>

                <br /><br />
                <div class="control-group">
                    <div class="controls">
                        <button class="btn btn-success btn-lg">Submit</button>
                    </div>
                </div>
            </fieldset>
        </form>
        </div>
        <div class="col-md-6 col-lg-6">
            <br /><br />
            <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/qyjr_kHZ04A" frameborder="0" allowfullscreen></iframe>
                    </div>

            <br /><br />
            <h1>mGuru Math Worksheet</h1>
         <div class="col-lg-12 alert alert-success" style='margin-bottom: 5px;font-family: din,Calibri,Cantarell,sans-serif; font-size: 15px;'>Never write another worksheet or test again.</div>
         <div class="col-lg-12 alert alert-info" style='margin-bottom: 5px;font-family: din,Calibri,Cantarell,sans-serif; font-size: 15px;'>Millions of problems from any sub-concept in K-5</div>
         <div class="col-lg-12 alert alert-warning" style='margin-bottom: 5px;font-family: din,Calibri,Cantarell,sans-serif; font-size: 15px;'>Generate beautiful worksheets</div>
         <div class="col-lg-12 alert alert-danger" style='margin-bottom: 5px;font-family: din,Calibri,Cantarell,sans-serif; font-size: 15px;'>Worksheets done in less than 20 seconds</div>
        <br style='clear:both'/><br />
        </div>

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

    mixpanel.track("Forgot Password", {});

    //! Validation function
    function validateregistration() {
        var error = 0;

        //! validation data
        var ws_username = $("#ws_username").val();

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