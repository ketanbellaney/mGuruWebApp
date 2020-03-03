<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 2) {
                    echo "<br /><p class='alert alert-success' >Help video edited successfully.</p>";
                } else if($error == 3) {
                    echo "<br /><p class='alert alert-danger' >Access denied, this incident will be reported to administration.</p>";
                } else if($error == 4) {
                    echo "<br /><p class='alert alert-success' >Help video deleted successfully.</p>";
                }
            ?> 
            <h2>Help video</h2>
            <br /><br />
            <a type="button" href='<?php echo site_url("englishcontent/addhelpvideo"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add Help video</a>
            <br /><br /><br /><br />
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Level</th>
                    <th>Title</th>
                    <th>Link</th>
                    <th>Category</th>
                    <th>Premium</th>
                    <th>Added By</th>
                    <th>Updated By</th>
                    <th>Questions</th>
                    <th>Activity</th>
                    <th>Action</th>
                </tr>
                <?php
                    $pree = array(0=> "No", 1 => "Yes" );
                    foreach($helpvideos as $ws) {
                        $sq = $ws->help_video_question_linkage;
                        $sq1 = $ws->help_video_activity_linkage;
                        echo "
                        <tr>
                            <td>".$ws->id."</td>
                            <td>".$ws->level."</td>
                            <td>".$ws->title."</td>
                            <td>".$ws->link."</td>
                            <td>".$ws->category."</td>
                            <td>".@$pree[$ws->is_premium]."</td>
                            <td>".$ws->added_by->name()."<br />
                            ".$ws->created->format("d/m/Y")."</td>
                            <td>".$ws->updated_by->name()."<br />
                            ".$ws->updated->format("d/m/Y")."</td>
                            <td><a href='".site_url("englishcontent/helpvideoquestions/" . $ws->id)."' >questions</a><br /><br />Count: ".count($sq)."</td>
                            <td><a href='".site_url("englishcontent/helpvideoactivity/" . $ws->id)."' >activity</a><br /><br />Count: ".count($sq1)."</td>
                            <td><a href='".site_url("englishcontent/edithelpvideo/" . $ws->id)."' >edit</a><br /><br />
                            <a href='".site_url("englishcontent/deletehelpvideo/" . $ws->id)."' onclick='return confirm(\"Are you sure?\");' style='color: red;' >delete</a></td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </div>
</div>