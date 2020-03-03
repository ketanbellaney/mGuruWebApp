<div class="container main-container" >
    <div class="row">
        <div class="col-md-12">
          <br /><br />
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h1 align="center" style="font-family: din,Calibri,Cantarell,sans-serif;"><b>Add student</b></h1>
            <?php
                if(@$error == 1 ) {
                    echo "<div class='alert alert-warning' role='alert'><b>Username does not exist</b>. Please try again.</div>";
                } else if(@$error == 2 ) {
                    echo "<div class='alert alert-success' role='alert'><b>Request sent to the student.</b>.</div>";
                } else if(@$error == 1 ) {
                    echo "<div class='alert alert-success' role='alert'><b>Student already accepted the request</b>.</div>";
                }
            ?>
                <div class="col-md-4 col-lg-4 col-sm-2 hidden-xs">
                  &nbsp;
                </div>

                <div class="col-md-4 col-lg-4 col-sm-8 col-xs-12 text-center">
                    <form class="form-horizontal form-group" action='<?php echo site_url("teacher/addstudent"); ?>' data-toggle="validator" method="POST" onsubmit='return validateregistration();' >
                        <fieldset>

                            <div class="control-group">
                                <label class="control-label"  for="username">Student Username <span class='redspan'>*</span></label>
                                <div class="controls">
                                    <input type="text" id="st_username" name="st_username" placeholder="" value='' autocomplete="off" class="input-xlarge form-control mg_usernames" required  />
                                    <span class="error_message"></span>
                                </div>
                            </div>

                            <div class="control-group">
                                <div class="controls">
                                    <br /><br />
                                    <button class="btn btn-success btn-lg" id='verbutton'>Add</button>
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
        $('.mg_usernames').typeahead({
            "source": checkusername,
            "minLength": 2
        });
    });

    function checkusername(query, process) {
        //alert(process);
        //return ["a","ab","ac","ad","ae"];
        $.post("<?php echo site_url("teacher/checkusername"); ?>", { query: query },  function( data ) {
            process(data.split(":::"));
        });
    }

    //! Validation function
    function validateregistration() {
        var error = 0;

        var st_username = $("#st_username").val();

        var error_template = "<div class='alert alert-danger' style='margin-top: 5px;padding: 5px;'><i class='glyphicon glyphicon-remove' ></i> ::error::</div>";

        $(".error_message").html("");

        if(st_username == "") {
            $( "#st_username" ).next(".error_message").html( error_template.replace("::error::","Please provide student username.") );
            $( "#st_username" ).focus();
            error = 1;
        }

        if(error) {
            scrollto(0);
            return false;
        }

        return true;
    }

    function scrollto(heightt) {
        $('html, body').stop().animate({
            scrollTop: heightt
        }, 1500, 'easeInOutExpo');

        $( ".error_message" ).effect( "slide",{},1000 );
    }
</script>