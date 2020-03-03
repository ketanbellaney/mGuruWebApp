<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Textbook story added successfully.</p>";
                } else if($error == 2) {
                    echo "<br /><p class='alert alert-success' >Textbook story edited successfully.</p>";
                } else if($error == 3) {
                    echo "<br /><p class='alert alert-danger' >Access denied, this incident will be reported to administration.</p>";
                } else if($error == 4) {
                    echo "<br /><p class='alert alert-success' >Textbook story deleted successfully.</p>";
                }
            ?>
            <h2>Textbook Story</h2>
            <br /><br />
            <a type="button" href='<?php echo site_url("englishcontent/addstorytextbook"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add story textbook</a>
            <br /><br /><br /><br />
            <?php
                $textbooks = StoryTextbook::find('all',array(
                    'conditions' => " delete_flag = 0 OR delete_flag IS NULL ",
                    "order" => 'id ASC'
                ));
            ?>
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Unit</th>
                    <th>Class</th>
                    <th>Board</th>
                    <th>Page Number</th>
                    <th>Source</th>
                    <th>Status</th>
                    <th>Added By</th>
                    <th>Updated By</th>
                    <th>Action</th>
                </tr>
                <?php
                    foreach($textbooks as $tx) {
                        echo "
                        <tr>
                            <td>".$tx->id."</td>
                            <td>".$tx->title."</td>
                            <td>".$tx->unit."</td>
                            <td>".$tx->class."</td>
                            <td>".$tx->board."</td>
                            <td>".$tx->page_number."</td>
                            <td>".$tx->source."</td>
                            <td>".$tx->status."</td>
                            <td>".$tx->added_by->name()."<br />
                            ".$tx->created->format("d/m/Y")."</td>
                            <td>".$tx->updated_by->name()."<br />
                            ".$tx->updated->format("d/m/Y")."</td>
                            <td><a href='".site_url("englishcontent/editstorytextbook/" . $tx->id)."' >edit</a><br /><br />
                            <a href='".site_url("englishcontent/deletestorytextbook/" . $tx->id)."' onclick='return confirm(\"Are you sure?\");' style='color: red;' >delete</a></td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </div>
</div>