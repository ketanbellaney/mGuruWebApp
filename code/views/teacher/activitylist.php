<div class="container main-container" >
    <div class="row">
        <div class="col-md-12">
          <br /><br />
        </div>
    </div>

    <div class="row">
        <h1 align="center" style="font-family: din,Calibri,Cantarell,sans-serif;"><b>Activity List</b></h1>

        <table class='table table-hover table-bordered table-striped'>
            <tr>
                <th>Level</th>
                <th>Number</th>
                <th>Activity</th>
                <th>Report</th>
            </tr>
            <?php
                $srno = 1;
                if(count($activities) > 0) {
                    foreach($activities as $val) {
                        if($val->challenge == 1) {
                             echo "
                            <tr>
                                    <td colspan='2'>Challenge</td>
                                    <td>".$val->name."</td>
                                    <td><a href='".site_url("teacher/viewstudentrecordactivity/" . $val->id)."' >record</a></td>
                                </tr>
                                ";
                        } else {
                             echo "
                            <tr>
                                    <td>".$val->level."</td>
                                    <td>".$val->activity_num."</td>
                                    <td>".$val->name."</td>
                                    <td><a href='".site_url("teacher/viewstudentrecordactivity/" . $val->id)."' >record</a></td>
                                </tr>
                                ";
                        }

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