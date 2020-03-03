<?php
    if($activation_msg != "" ) {
        echo "<div class='col-md-12'><br /><br />  <div class='alert alert-success' role='alert'>$activation_msg</div><br /><br /></div>";
    }
?>

<div class="col-md-12">
    <br /><br /><br /><br /><br /><br /><br />
    <h1 align="center" style='font-family: din,Calibri,Cantarell,sans-serif; margin: 0px;'><b>Welcome to mGuru Teacher Panel</b></h1>
    <h3 align="center" style='color:#7f7f7f; font-family: din,Calibri,Cantarell,sans-serif; font-size: 20px; margin-top: 5px;' >Analyse your student progress and improve their learning.</h3>
    <br /><br /><br /><br />
</div>

<?php
    if(isset($user->id)) {
?>
    <div class="col-md-1 col-lg-1 hidden-sm hidden-xs">&nbsp;</div>

    <div class="col-md-3 col-lg-3 col-sm-4 col-xs-12 text-center" style='margin-bottom: 30px;'>
        <a type="button" class="btn btn-info btn-lg col-md-12 col-lg-12 col-sm-12 col-xs-12" href="<?php echo site_url("teacher/liststudents"); ?>" >My students</a><br />
    </div>

    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12 text-center" style='margin-bottom: 30px;'>
        <a type="button" class="btn btn-info btn-lg col-md-12 col-lg-12 col-sm-12 col-xs-12" href="<?php echo site_url("teacher/addstudent"); ?>" >Add student</a><br />
    </div>

    <div class="col-md-3 col-lg-3 col-sm-4 col-xs-12 text-center" style='margin-bottom: 30px;'>
        <a type="button" class="btn btn-info btn-lg col-md-12 col-lg-12 col-sm-12 col-xs-12" href="<?php echo site_url("teacher/pendingrequest"); ?>">Pending Request</a><br />
    </div>

    <div class="col-md-1 col-lg-1 hidden-sm hidden-xs">&nbsp;</div>

    <br style='clear:both;'/><br /><br /><br />
<?php
    } else {
        echo "<br style='clear:both;'/><br /><br /><br />";
    }
?>

<script>
    $(".loginhere"  ).click(function() {
        $( "#log_email" ).effect( "shake" );
        $( "#log_password" ).effect( "shake" );
        $( "#log_email" ).focus();
        return false;
    });
    //mixpanel.track("Home Page");
</script>