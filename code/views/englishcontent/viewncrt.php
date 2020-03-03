<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 2) {
                    echo "<br /><p class='alert alert-success' >NCRT Activity edited successfully.</p>";
                } else if($error == 3) {
                    echo "<br /><p class='alert alert-danger' >Access denied, this incident will be reported to administration.</p>";
                } else if($error == 4) {
                    echo "<br /><p class='alert alert-success' >NCRT Activity deleted successfully.</p>";
                }
            ?> 
            <h2>NCRT Activity</h2>
            <br /><br />
            <a type="button" href='<?php echo site_url("englishcontent/addncrt"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add NCRT activity</a>
            <br /><br /><br /><br />
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Grade Level Skill</th>
                    <th>Level</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Added By</th>
                    <th>Updated By</th>
                    <th>Action</th>
                </tr>
                <?php
                    foreach($ncrts as $ws) {

                        echo "
                        <tr>
                            <td>".$ws->id."</td>
                            <td>".$ws->unit."</td>
                            <td>".$ws->level."</td>
                            <td>".$ws->name."</td>
                            <td>".$ws->description."</td>
                            <td>".$ws->added_by->name()."<br />
                            ".$ws->created->format("d/m/Y")."</td>
                            <td>".$ws->updated_by->name()."<br />
                            ".$ws->updated->format("d/m/Y")."</td>
                            <td><a href='".site_url("englishcontent/editncrt/" . $ws->id)."' >edit</a><br /><br />
                            <a href='".site_url("englishcontent/deletencrt/" . $ws->id)."' onclick='return confirm(\"Are you sure?\");' style='color: red;' >delete</a></td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </div>
</div>