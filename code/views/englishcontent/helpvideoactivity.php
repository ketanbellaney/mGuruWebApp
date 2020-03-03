<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Help Video Activity added successfully.</p>";
                } else if($error == 2) {
                    echo "<br /><p class='alert alert-success' >Help Video Activity edited successfully.</p>";
                } else if ( $error == 3 ) {
                    echo "<br /><p class='alert alert-success' >Help Video Activity deleted successfully. </p>";
                }
            ?>
            <h2>Help Video Activity For <?php echo $helpvideo->title; ?></h2>
            <br /><br />
            <a type="button" href='<?php echo site_url("englishcontent/addhelpactivity/" . $helpvideo->id); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add Activity</a>
            <br /><br /><br /><br />
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Activity</th>
                    <th>Order Number</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Action</th>
                </tr>
                <?php
                    foreach($helpvideo->help_video_activity_linkage as $helpactivity) {
                        if($helpactivity->help_activity->delete_flag != 1 ) {
                        echo "
                        <tr>
                            <td>".$helpactivity->help_activity->id."</td>
                            <td>".$helpactivity->help_activity->name."</td>
                            <td>".$helpactivity->order_number."</td>
                            <td>".$helpactivity->help_activity->added_by->name()."<br />
                            ".$helpactivity->help_activity->created->format("d/m/Y")."</td>
                            <td>".$helpactivity->help_activity->updated_by->name()."<br />
                            ".$helpactivity->help_activity->updated->format("d/m/Y")."</td>
                            <td><a href='".site_url("englishcontent/edithelpactivity/" . $helpactivity->help_activity->id."/" . $helpvideo->id)."' >edit</a><br />
                            <a href='".site_url("englishcontent/deletehelpactivity/" . $helpactivity->help_activity->id."/" . $helpvideo->id)."' onclick='return confirm(\"Are you sure?\");' >delete</a></td>
                        </tr>
                        ";
                        }
                    }
                ?>
            </table>
        </div>
    </div>
</div>