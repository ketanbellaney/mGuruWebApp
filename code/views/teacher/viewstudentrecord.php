<div class="container main-container" >
    <div class="row">
        <div class="col-md-12">
          <br /><br />
        </div>
    </div>
    <?php
        $name = $userm->profile->first_name . " " . $userm->profile->last_name;
        if($userm->profile->first_name == '') {
            $name = $userm->username;
        }
    ?>

    <div class="row">
        <h1 align="center" style="font-family: din,Calibri,Cantarell,sans-serif;"><b>Student <span style='color: #336699'><?php echo $name; ?></span> record</b></h1>

        <br />
        <a href='<?php echo site_url("teacher/liststudents"); ?>' class='btn btn-default pull-right' >back</a>
        <br style='clear: both;'/><br />
        <table class='table table-hover table-bordered table-striped'>
            <tr>
                <th>Sr. No.</th>
                <th>World</th>
                <th>Concept Name</th>
                <th>Activity Name</th>
                <th>Activity Type</th>
                <th>Score (%)</th>
                <th>Date</th>
            </tr>
            <?php
                $srno = 1;
                if(count($data) > 0) {
                    foreach($data as $val) {
                        $per = ( $val->score / $val->points ) * 100;
                        $per = round($per,0);
                        if($per != 0) {
                            echo "
                                <tr>
                                        <td>".$srno."</td>";

                            echo "<td>".ucwords(str_replace("_"," ",$val->activity->world))."</td>";
                            if( $val->level == 0 && $val->activity_number == 0) {
                                echo "<td>Challenge</td>";
                            } else {
                              echo "<td>".@$activity_levels[$val->activity->level]."</td>";
                            }

                            echo "<td>".$val->activity->name."</td>";
                                if( $val->level == 0 && $val->activity_number == 0) {
                                    echo "<td>Challenge</td>";
                                } else {
                                    echo "<td>".ucwords($val->activity->category ). "</td>";
                                }
                                echo "<td>".$per."</td>
                                        <td>".$val->updated->format("d/m/Y")."</td>
                                    </tr>
                                    ";
                            $srno++;
                        }
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