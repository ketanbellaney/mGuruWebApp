<div class="container main-container" >
    <div class="row">
        <div class="col-md-12">
          <br /><br />
        </div>
    </div>

    <div class="row">
        <h1 align="center" style="font-family: din,Calibri,Cantarell,sans-serif;"><b>Student Request</b></h1>

        <table class='table table-hover table-bordered table-striped'>
            <tr>
                <th>Sr. No.</th>
                <th>Username</th>
                <th>Student Name</th>
                <th>School / Class</th>
                <th>Father Name</th>
                <th>Mother Name</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
            <?php
                $srno = 1;
                if(count($pending_user) > 0) {
                    foreach($pending_user as $val) {
                        $school = '';
                        if(@$val->student->profile->school_id != '') {
                            $school = $val->student->profile->school->name;
                        }
                        echo "
                            <tr>
                                    <td>".$srno."</td>
                                    <td>".$val->student->username."</td>
                                    <td>".$val->student->profile->first_name . " " . $val->student->profile->last_name."</td>
                                    <td>".$school." / " . @$val->student->profile->current_class . "</td>
                                    <td>".$val->student->profile->father_name."</td>
                                    <td>".$val->student->profile->mother_name."</td>
                                    <td>".$val->status."</td>
                                    <td>".$val->updated->format("d/m/Y")."</td>
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
        </div>
    </div>
</div>