<div class="container main-container" >
    <div class="row">
        <div class="col-md-12">
          <br /><br />
        </div>
    </div>

    <div class="row">
        <h1 align="center" style="font-family: din,Calibri,Cantarell,sans-serif;"><b>My Student</b></h1>

        <table class='table table-hover table-bordered table-striped'>
            <tr>
                <th>Sr. No.</th>
                <th>Username</th>
                <th>Student Name</th>
                <th>School / Class</th>
                <th>Date</th>
                <th>Report</th>
            </tr>
            <?php
                $srno = 1;
                if(count($accepted_user) > 0) {
                    foreach($accepted_user as $val) {
                        $school = '';
                        if(@$val->student->profile->school_id != '') {
                            $school = $val->student->profile->school->name;
                        }
                        echo "
                            <tr>
                                    <td>".$srno."</td>
                                    <td>".$val->student->username."</td>
                                    <td>".$val->student->profile->first_name . " " . $val->student->profile->last_name."</td>
                                    <td>".$school." / " . $val->student->profile->current_class . "</td>
                                    <td>".$val->updated->format("d/m/Y")."</td>
                                    <td><a href='".site_url("teacher/viewstudentrecord/" . md5($val->student_id))."' >record</a></td>
                                </tr>
                                ";
                        $srno++;
                    }
                } else {
                    echo "
                            <tr>
                                <td colspan='12'> No record found</td>
                            </tr>
                                ";
                }
                ?>
        </table>
    </div>
    <div class="row">
        <div class="col-md-12">
          <br /><br />
          <div class="col-md-3 col-lg-3 col-sm-4 col-xs-12 text-center" style='margin-bottom: 30px;'>
            <a type="button" class="btn btn-info btn-lg col-md-12 col-lg-12 col-sm-12 col-xs-12" href="<?php echo site_url("teacher/activitylist"); ?>" >Activity List</a><br />
            </div>

        </div>
    </div>
</div>