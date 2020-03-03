<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 2) {
                    echo "<br /><p class='alert alert-success' >Word segment edited successfully.</p>";
                } else if($error == 3) {
                    echo "<br /><p class='alert alert-danger' >Access denied, this incident will be reported to administration.</p>";
                } else if($error == 4) {
                    echo "<br /><p class='alert alert-success' >Word segment deleted successfully.</p>";
                }
            ?> 
            <h2>Word segment</h2>
            <br /><br />
            <a type="button" href='<?php echo site_url("englishcontent/addwordsegment"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add word segment</a>
            <br /><br /><br /><br />
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>image</th>
                    <th>Word</th>
                    <th>Unit</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th>Trans</th>
                    <th>Concept</th>
                    <th>Added By</th>
                    <th>Updated By</th>
                    <th>Action</th>
                </tr>
                <?php
                    $language = Language::find("all", array(
                        "conditions" => " id != 3 AND id != 4 ",
                        "order" => " name ASC ",
                    ));




                    foreach($wordsegments as $ws) {
                        echo "
                        <tr>
                            <td>".$ws->id."</td>";
                        if($ws->image != '') {
                           echo "<td><img src='".base_url("contentfiles/word/" . $ws->image)."' width='50' /></td>";
                        } else {
                            echo "<td> no-image </td>";
                        }
                        echo "<td>".$ws->word."</td>
                            <td>".$ws->unit."</td>
                            <td>".$ws->level."</td>
                            <td>".$ws->status."</td><td>";
                            $www = Word::find_by_word(trim($ws->word));

                            if(isset($www->id)) {
                                foreach($www->word_translation as $val) {
                                    echo $val->language_id . " - " . $val->translation . "<br />";
                                }
                                echo "---------------<br />";
                                foreach($www->word_transliteration as $val) {
                                    echo $val->language_id . " - " . $val->translation . "<br />";
                                }
                            }
                            echo "</td>
                            <td>".$ws->concept."</td>
                            <td>".$ws->added_by->name()."<br />
                            ".$ws->created->format("d/m/Y")."</td>
                            <td>".$ws->updated_by->name()."<br />
                            ".$ws->updated->format("d/m/Y")."</td>
                            <td><a href='".site_url("englishcontent/editwordsegment/" . $ws->id)."' >edit</a><br /><br />
                            <a href='".site_url("englishcontent/deletewordsegment/" . $ws->id)."' onclick='return confirm(\"Are you sure?\");' style='color: red;' >delete</a></td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </div>
</div>