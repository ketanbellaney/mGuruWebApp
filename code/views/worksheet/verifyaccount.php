<div class="container main-container" style='height:600px;'>

    <div class="row">
        <div class="col-md-12">
          <br /><br />
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <?php
                echo '<h1 align="center" style="font-family: din,Calibri,Cantarell,sans-serif;"><b>Account Activation</b></h1>';
                if($meta_type == 1 || $meta_type == 3 ) {
                    if($check_user->status == "active") {
                        echo "<div class='alert alert-warning' role='alert'><b>Your account is already activated</b>. Please login to continue.</div>";
                    } else {
                        if($meta_type == 1) {
                            echo "<div class='alert alert-success' role='alert'><b>Well done</b>.";
                            if($type == 1) {
                                echo " Please check your email for verification code.";
                            } else {
                                echo " Please check your mobile sms for OTP.";
                            }
                            echo "</div>";
                        } else {
                            echo "<div class='alert alert-info' role='alert'>";
                            if($type == 1) {
                                echo " Please check your email for verification code.";
                            } else {
                                echo " Please check your mobile sms for OTP.";
                            }
                            echo "</div>";
                        }
                    }

                } else if($meta_type == 2 )  {
                    echo "<div class='alert alert-warning' role='alert'><b>Your account is already activated</b>. Please login to continue.</div>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'><b>Invalid url</b>. Please check your url and try again.</div>";
                }

                echo "<br /><br />";

                if($meta_type == 1 || $meta_type == 3 ) {
                    if($check_user->status != "active") {
            ?>
                <div class="col-md-4 col-lg-4 col-sm-2 hidden-xs">
                  &nbsp;
                </div>

                <div class="col-md-4 col-lg-4 col-sm-8 col-xs-12 text-center">
                    <form class="form-horizontal form-group" action='<?php echo site_url("worksheet/verifyaccount/$meta_type/$uid/$mcode/$type"); ?>' data-toggle="validator" method="POST" onsubmit='return validateregistration();' >
                        <fieldset>
                            <div class="control-group">
                                <?php
                                    if($type == 1) {
                                        echo "<label class='control-label' >Verification code</label>";
                                    } else {
                                        echo "<label class='control-label' >OTP</label>";
                                    }
                                ?>
                                <div class="controls">
                                    <input type="text" id="ws_code" name="ws_code" placeholder="" value='<?php echo @$mcode; ?>' class="input-xlarge form-control" maxlength="4"  />
                                    <span class="error_message"></span>
                                </div>
                            </div>
                            <br /><br />
                            <div class="control-group">
                                <div class="controls">
                                    <button class="btn btn-success btn-lg" id='verbutton'>Verify</button>
                                    <br /><br />
                                    <a href="<?php echo site_url("worksheet/resend/$meta_type/$uid/$mcode/$type"); ?>" onclick="return confirm('Click on to resend code.');" >resend code?</a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
               <div class="col-md-4 col-lg-4 col-sm-2 hidden-xs">
                  &nbsp;
                </div>
            <?php
                    }
                }
            ?>

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
        <?php
            if($mcode != '') {
                echo "$( '#verbutton' ).trigger( 'click' );";
            }
        ?>
    });
</script>