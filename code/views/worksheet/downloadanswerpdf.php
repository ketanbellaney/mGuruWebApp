<div class="container main-container" style='min-height:400px;'>

    <div class="row">
        <div class="col-md-12 text-center">
            <h4 class='alert alert-success'>Your download will start in few seconds! Thank you! <a href='<?php echo site_url("worksheet/downloadanswerpdf1/" . @$ws->id); ?>' >click here for direct download</a></h4>
            <h1 align="center" style='font-family: din,Calibri,Cantarell,sans-serif; margin-bottom: 5px;'><b>Try mGuru English<br />Tell your colleagues and friends. And earn more worksheets credit</b></h1>
            <br />
            <img src='<?php echo base_url("images/englishshare.png"); ?>' class='img-responsive' style='margin: 0 auto;'  />
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <br />
            <h3 align="center" style='color:#595959; font-family: din,Calibri,Cantarell,sans-serif; font-size: 20px; margin-top: 5px;' >So spread the word, and you can earn 5 worksheets credit for each one who uses mGuru English Learning App - no limit!</h3>
            <br />
            <div class="col-md-4">
                <div class="input-group">
                    <textarea class="form-control custom-control" id="emails" name="emails" rows="1" style="resize:none" placeholder="Add emails separated by comma (,)"></textarea>
                    <span class="input-group-addon btn btn-primary" onclick="sendemails();">Send</span>
                </div>
                <span style='display:none;' id='sendtext' ><div style='padding:3px; color: green;' align='center'>
                        Email(s) sent!
                    </div></span>
                <br /><br />
            </div>
            <div class="col-md-4">
                <a target='_blank' class="btn btn-primary btn-lg btn-block" href="https://www.facebook.com/sharer/sharer.php?sdk=joey&u=<?php
                echo urlencode("http://www.mguruenglish.com/registration/".$user->user_referral_code->referral_code);
                //echo urlencode("http://www.mgurumath.com/worksheet/signup?refcode=".$user->user_referral_code->referral_code);
                ?>&display=popup&ref=plugin&src=share_button"  onclick="return fbshare();" >share on facebook</a>
                <br /><br />
            </div>
            <div class="col-md-4">
                <button class="btn btn-default btn-lg btn-block" onclick="copytoclip()" >copy my link</button>
                <span style='display:none;' id='copytext' ><div style='padding:3px; color: green;' align='center'>
                    Link copied to clipboard
                </div></span>
                <br /><br />
            </div>
            <span id='eleme' style='display:none;'><?php echo "http://www.mguruenglish.com/registration/".$user->user_referral_code->referral_code; ?></span>
        </div>
    </div>

</div>
<br style='clear:both;' />
<script>
mixpanel.identify('<?php echo $user->id; ?>');
mixpanel.alias('<?php echo $user->id; ?>');
mixpanel.track("Referral Page");

    function sendemails() {
        if(checkemail("#emails")) {
            $("#sendtext").css("display","block");
            setTimeout(hidediv1, 5000);
            $.post( "<?php echo site_url("worksheet/sendemail1"); ?>", { emails: $("#emails").val().trim() } , function (data) {

            });
            $("#emails").val("");
        }

    }

    function checkemail(ele) {
        var emails =  $(ele).val().trim();

        if(emails == "") {
            alert("Please provide atleast single email address!");
            return false;
        }

        var emails1 = emails.split(",");

        var error = 0;
        for(var ii = 0 ; ii < emails1.length ; ii++) {
            if(!validateEmail(emails1[ii])) {
                alert("Invalid email address '"+emails1[ii]+"'!");
                error = 1;
            }
        }

        if(error != 0) {
            return false;
        }

        return true;
    }

    function validateEmail(email) {
        var email_validation_template = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return email_validation_template.test(email);
    }

    function copytoclip () {
        var element = "#eleme";
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
        $("#copytext").css("display","block");

        setTimeout(hidediv, 5000);

        mixpanel.identify('<?php echo $user->id; ?>');
        mixpanel.alias('<?php echo $user->id; ?>');
        mixpanel.track("Referral Link Copied", {
          "url": "<?php echo "http://www.mguruenglish.com/registration/".$user->user_referral_code->referral_code; ?>"
        });
    }

    function fbshare() {
        mixpanel.identify('<?php echo $user->id; ?>');
        mixpanel.alias('<?php echo $user->id; ?>');
        mixpanel.track("Referral Link Fb share", {
          "url": "<?php "http://www.mguruenglish.com/registration/".$user->user_referral_code->referral_code; ?>"
        });

        return true;
    }

    var hidediv = function(){
        $("#copytext").css("display","none");
    };

    var hidediv1 = function(){
        $("#sendtext").css("display","none");
    };

    function onloaddothis() {
        window.location.href='<?php echo site_url("worksheet/downloadanswerpdf1/" . $ws->id); ?>';
    }

    setTimeout(onloaddothis, 5000);
</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=237201023111138";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>