<div class="container main-container" >
    <div class="row">
        <div class="col-md-12">
          <br /><br />
        </div>
    </div>

    <div class="row">
        <h1 align="center" style="font-family: din,Calibri,Cantarell,sans-serif;"><b> <span style='color: #336699'><?php echo $activity->name; ?></span> ( <?php echo $activity->level . " - " . $activity->activity_num; ?> )</b></h1>

        <br />
        <a href='<?php echo site_url("teacher/activitylist"); ?>' class='btn btn-default pull-right' >back</a>
        <br style='clear: both;'/><br />
        <table class='table table-hover table-bordered table-striped'>
            <tr>
                <th>Sr. No.</th>
                <th>Username</th>
                <th>Name</th>
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

                            echo "<td>".$val->user->username."</td>";
                            echo "<td>".$val->user->profile->first_name . " " . $val->user->profile->last_name."</td>";
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