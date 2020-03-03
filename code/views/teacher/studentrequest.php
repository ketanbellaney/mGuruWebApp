<div class="container main-container" >
    <div class="row">
        <div class="col-md-12">
          <br /><br />
        </div>
    </div>

    <div class="row">
        <h1 align="center" style="font-family: din,Calibri,Cantarell,sans-serif;"><b>Add student</b></h1>
        <?php
            $img = "default.png";
            if($userm->profile->profile_picture != '') {
                $img = $userm->profile->profile_picture;
            }

            $sch = '';
            if( $userm->profile->school_id != '') {
                $sch = $userm->profile->school->name;
            }
        ?>
        <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12"><img src="<?php echo base_url("user/photo/" . $img); ?>" class='img-responsive' /></div>
        <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12"><b>Username: </b> <?php echo $userm->username; ?></div>
        <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12"><b>Name: </b> <?php echo $userm->profile->first_name . " " . $userm->profile->last_name; ?></div>
        <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12"><b>School: </b> <?php echo $sch; ?></div>
        <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12"><b>Class: </b> <?php echo $userm->profile->current_class; ?></div>
        <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12"><b>Board: </b> <?php echo $userm->profile->examination_board; ?></div>
        <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12"><b>Teacher Name: </b> <?php echo $userm->profile->teacher_name; ?></div>
        <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12"><b>Father Name: </b> <?php echo $userm->profile->father_name; ?></div>
        <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12"><b>Mother Name: </b> <?php echo $userm->profile->mother_name; ?></div>
        <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12"><b>Gender: </b> <?php echo $userm->profile->gender; ?></div>
    </div>
    <div class="row">
        <div class="control-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="controls pull-right">
                <button class="btn btn-default" id='verbutton' onclick='clickbutton(1);' >Cancel</button>
            </div>
            <div class="controls pull-right" style='margin-right: 30px;'>
                <button class="btn btn-success" id='verbutton' onclick='clickbutton(2);' >Confirm</button>
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
    function clickbutton(num) {
        if(num == 1) {
            window.location.href = '<?php echo site_url("teacher/addstudent"); ?>';
        } else {
            window.location.href = '<?php echo site_url("teacher/studentrequestprocess/" . md5($userm->id)); ?>';
        }
    }
</script>