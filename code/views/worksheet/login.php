<div class="container main-container" style='min-height: auto;'>
    <div class="row">
        <div class="col-md-12">
        <br /><br />
            <p class='alert alert-danger'>
            <?php
                if($error == 2) {
                    echo "Your account is not activated yet! Please activate your account.";
                } else {
                    echo "Invalid username / password! Please try again.";
                }
            ?>
            </p>
            <br /><br />
        </div>
    </div>
</div>

<img src='<?php echo base_url("images/worksheetsplash1.jpg"); ?>' class='img-responsive' style='margin: 0 auto;width: 100%;'  />

        <div class="col-md-12">
            <h1 align="center" style='font-family: din,Calibri,Cantarell,sans-serif; margin: 0px;'><b>Welcome to mGuru Math Worksheet</b></h1>
            <h3 align="center" style='color:#7f7f7f; font-family: din,Calibri,Cantarell,sans-serif; font-size: 20px; margin-top: 5px;' >
            Never write another worksheet or test again.<br />Available for CBSE and 7 State Boards in Standards 1 to 5.</h3>
        </div>

        <div class="col-md-2 col-lg-2 hidden-sm hidden-xs">
          &nbsp;
        </div>

        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6 text-center">
            <a type="button" class="btn btn-info btn-lg col-md-12 col-lg-12 col-sm-12 col-xs-12" href="<?php echo site_url("worksheet/signup"); ?>" >Sign Up</a><br />
            <em>Have an account? <a href='#' class='loginhere'> Login here! </a></em>
        </div>
        <div class="col-md-2 col-lg-2 hidden-sm hidden-xs">
          <br />
        </div>
        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6 text-center">
            <a type="button" class="btn btn-info btn-lg col-md-12 col-lg-12 col-sm-12 col-xs-12 page-scroll" href="#how_it_works">See How it Works</a>
        </div>
        <div class="col-md-2 col-lg-2 hidden-sm hidden-xs">
          &nbsp;
        </div>

<img src='<?php echo base_url("images/worksheetsplash2.jpg"); ?>' class='img-responsive' style='margin: 0 auto;width:100%'  />
    <div class=" "  style='background-color: #FDD1A6;' id="how_it_works" >
        <br />
         <h1 align="center" style='font-family: din,Calibri,Cantarell,sans-serif; margin: 0px;'><b>mGuru Math Worksheet</b></h1>
         <br />
         <div class="col-lg-3 alert alert-success" style='font-family: din,Calibri,Cantarell,sans-serif; font-size: 15px;'>Never write another worksheet or test again.</div>
         <div class="col-lg-3 alert alert-info" style='font-family: din,Calibri,Cantarell,sans-serif; font-size: 15px;'>Millions of problems from any sub-concept in K-5</div>
         <div class="col-lg-3 alert alert-warning" style='font-family: din,Calibri,Cantarell,sans-serif; font-size: 15px;'>Generate beautiful worksheets</div>
         <div class="col-lg-3 alert alert-danger" style='font-family: din,Calibri,Cantarell,sans-serif; font-size: 15px;'>Worksheets done in less than 20 seconds</div>
        <br style='clear:both'/><br />
    </div>
    <div class=" "  style='background-color: #EBEBEB;' >
     <br />
                <div class="col-lg-12" >
                    <h1 align="center" style='font-family: din,Calibri,Cantarell,sans-serif; margin-bottom: 5px;'>How it Works</h1>
                    <br />
                    <h3 align="center" style='font-family: din,Calibri,Cantarell,sans-serif;margin-top: 5px;' >Make a worksheet in less than 20 seconds.</h3>
                    <div class="col-lg-3 col-md-3 col-sm-2 hidden-xs" > &nbsp;&nbsp;</div>
                    <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12" ><div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/qyjr_kHZ04A" frameborder="0" allowfullscreen></iframe>
                    </div></div>

                    <br style='clear:both;' /><br />
                </div>

                <div class="col-md-2 col-lg-2 hidden-sm hidden-xs">
                  &nbsp;
                </div>

                <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12 text-center">
                    <a type="button" class="btn btn-info btn-lg col-md-12 col-lg-12 col-sm-12 col-xs-12" href="<?php echo site_url("worksheet/signup"); ?>" >Sign Up</a><br />
                    <em>Have an account? <a href='#' class='loginhere'> Login here! </a></em>
                </div>
                <div class="col-md-2 col-lg-2 hidden-sm col-xs-12">
                  <br /><br /><br />
                </div>
                <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12 text-center">
                    <a type="button" class="btn btn-info btn-lg col-md-12 col-lg-12 col-sm-12 col-xs-12 page-scroll" href="<?php echo base_url("images/sample.pdf"); ?>" >See Sample</a>
                </div>
                <div class="col-md-2 col-lg-2 hidden-sm hidden-xs">
                  &nbsp;
                </div>
                <br /><br /> <br /><br />


         <br  style='clear:both;'/>
         <br /><br />
    </div>



<script>
$(".loginhere"  ).click(function() {
  $( "#log_email" ).effect( "shake" );
  $( "#log_password" ).effect( "shake" );
  $( "#log_email" ).focus();
  return false;
});

//jQuery for page scrolling feature - requires jQuery Easing plugin
$(function() {
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top - 50
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });
});
mixpanel.track("Login Page");
</script>