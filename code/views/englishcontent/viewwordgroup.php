<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Word group story added successfully.</p>";
                } else if($error == 2) {
                    echo "<br /><p class='alert alert-success' >Word group story edited successfully.</p>";
                } else if($error == 3) {
                    echo "<br /><p class='alert alert-danger' >Access denied, this incident will be reported to administration.</p>";
                } else if($error == 4) {
                    echo "<br /><p class='alert alert-success' >Word group story deleted successfully.</p>";
                }
            ?>
            <h2>Word group</h2>
            <br /><br />
            <a type="button" href='<?php echo site_url("englishcontent/addwordgroup"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add word group</a>
            <br /><br /><br /><br />
            <?php
                $wordgroups = StoryTextbookGroup::find('all',array(
                    'conditions' => " delete_flag = 0 OR delete_flag IS NULL ",
                    "order" => 'id ASC'
                ));
            ?>
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Group</th>
                    <th>Unit</th>
                    <th>Class</th>
                    <th>Board</th>
                    <th>Page Number</th>
                    <th>Source</th>
                    <th>Words</th>
                    <th>Status</th>
                    <th>Added By</th>
                    <th>Updated By</th>
                    <th>Action</th>
                </tr>
                <?php
                    foreach($wordgroups as $tx) {
                        echo "
                        <tr>
                            <td>".$tx->id."</td>
                            <td>".$tx->name."</td>
                            <td>".$tx->unit."</td>
                            <td>".$tx->class."</td>
                            <td>".$tx->board."</td>
                            <td>".$tx->page_number."</td>
                            <td>".$tx->source."</td><td>";
                        foreach($tx->story_textbook_group_word_linkage as $gw_linkage) {
                                echo $gw_linkage->word->word . " (".$gw_linkage->word->hindi_translation.") [".$gw_linkage->word->marathi_translation."]<br />";
                            }
                        echo "</td><td>".$tx->status."</td>
                            <td>".$tx->added_by->name()."<br />
                            ".$tx->created->format("d/m/Y")."</td>
                            <td>".$tx->updated_by->name()."<br />
                            ".$tx->updated->format("d/m/Y")."</td>
                            <td><a href='".site_url("englishcontent/editwordgroup/" . $tx->id)."' >edit</a><br /><br />
                            <a href='".site_url("englishcontent/deletewordgroup/" . $tx->id)."' onclick='return confirm(\"Are you sure?\");' style='color: red;' >delete</a></td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </div>
</div>