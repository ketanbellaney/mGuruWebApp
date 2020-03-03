<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 2) {
                    echo "<br /><p class='alert alert-success' >Activity edited successfully.</p>";
                } else if($error == 3) {
                    echo "<br /><p class='alert alert-danger' >Access denied, this incident will be reported to administration.</p>";
                } else if($error == 4) {
                    echo "<br /><p class='alert alert-success' >Activity deleted successfully.</p>";
                }
            ?> 
            <h2>Activity</h2>
            <br /><br />
            <a type="button" href='<?php echo site_url("englishcontent/addactivity"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add activity</a>
            <br /><br /><br /><br />
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Activity</th>
                    <th>Level - Act. No.</th>
                    <th>Score</th>
                    <th>Challenge</th>
                    <th>World</th>
                    <th>Category</th>
                    <th>Added By</th>
                    <th>Updated By</th>
                    <th>Action</th>
                </tr>
                <?php
                    foreach($activities as $ws) {
                        $chall = "no";
                        if( $ws->challenge == 1) {
                            $chall = "yes";
                        }
                        echo "
                        <tr>
                            <td>".$ws->id."</td>
                            <td>".$ws->name."</td>
                            <td>".$ws->level." - ".$ws->activity_num."</td>
                            <td>".$ws->score."</td>
                            <td>$chall</td>
                            <td>".ucwords(str_replace("_"," ", $ws->world))."</td>
                            <td>".ucwords(str_replace("_"," ", $ws->category))."</td>
                            <td>".$ws->added_by->name()."<br />
                            ".$ws->created->format("d/m/Y")."</td>
                            <td>".$ws->updated_by->name()."<br />
                            ".$ws->updated->format("d/m/Y")."</td>
                            <td><a href='".site_url("englishcontent/editactivity/" . $ws->id)."' >edit</a><br /><br />
                            <a href='".site_url("englishcontent/duplicateactivity/" . $ws->id)."' onclick='return confirm(\"Are you sure?\");' style='color: orange;' >duplicate</a><br /><br />
                            <a href='".site_url("englishcontent/deleteactivity/" . $ws->id)."' onclick='return confirm(\"Are you sure?\");' style='color: red;' >delete</a></td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </div>
</div>