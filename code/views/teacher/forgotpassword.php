<div class="container main-container" >
    <div class="row">

        <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">

        <form class="form-horizontal form-group" action='<?php echo site_url("teacher/forgotpasswordprocess"); ?>' data-toggle="validator" method="POST" onsubmit='return validateregistration();' >
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
        <div class="col-md-8 col-lg-8">
            <br /><br /><br /><br /><br /><br />
            <h1 align="center" style='font-family: din,Calibri,Cantarell,sans-serif; margin: 0px;'><b>Welcome to mGuru Teacher Panel</b></h1>
            <h3 align="center" style='color:#7f7f7f; font-family: din,Calibri,Cantarell,sans-serif; font-size: 20px; margin-top: 5px;' >Analyse your student progress and improve their learning.</h3>
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

    //mixpanel.track("Forgot Password", {});

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