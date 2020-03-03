<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Grapheme added successfully.</p>";
                } else if($error == 2) {
                    echo "<br /><p class='alert alert-success' >Grapheme edited successfully.</p>";
                } else if($error == 3) {
                    echo "<br /><p class='alert alert-danger' >Access denied, this incident will be reported to administration.</p>";
                } else if($error == 4) {
                    echo "<br /><p class='alert alert-success' >Grapheme deleted successfully.</p>";
                }
            ?>
            <h2>Grapheme</h2>
            <br /><br />
            <a type="button" href='<?php echo site_url("englishcontent/addgrapheme"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add Grapheme</a>
            <br /><br /><br /><br />
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Grapheme</th>
                    <th>Phoneme</th>
                    <th>Type</th>
                    <th>Script</th>
                    <th>Audio</th>
                    <th>Unit</th>
                    <th>Word</th>
                    <th>Added By</th>
                    <th>Updated By</th>
                    <th>Action</th>
                </tr>
                <?php
                    foreach($graphemes as $grapheme) {
                        echo "
                        <tr>
                            <td>".$grapheme->id."</td>
                            <td>";

                        if( $grapheme->image != '' ) {
                            echo "<img src='".base_url("contentfiles/grapheme/" . $grapheme->image )."' width='50' />";
                        } else {
                            echo "No-image";
                        }

                        echo "</td>
                            <td>".$grapheme->grapheme."</td>
                            <td>".$grapheme->phoneme."</td>
                            <td>".$grapheme->type."</td>
                            <td>";
                        foreach($grapheme->grapheme_script as $val) {
                            echo $val->language->name . " - " . $val->script . "<br />";
                        }
                        echo "</td><td>";
                        if($grapheme->audio != '') {
                            echo "<a href='".base_url("contentfiles/grapheme/" . $grapheme->audio )."' target='_blank'>yes</a><br />" . $grapheme->audio;
                        } else {
                            echo "no";
                        }
                        echo "</td>
                            <td>" . $grapheme->units_id . " </td>
                            <td><b>Primary</b><br />";
                            foreach($grapheme->grapheme_word_linkage_primary as $gw_linkage) {
                                echo $gw_linkage->word->word . " (".$gw_linkage->word->hindi_translation.") [".$gw_linkage->word->marathi_translation."]<br />";
                            }
                            echo "<hr style='margin: 5px;' /><b>Aditional</b><br />";
                            foreach($grapheme->grapheme_word_linkage as $gw_linkage) {
                                echo $gw_linkage->word->word . " (".$gw_linkage->word->hindi_translation.") [".$gw_linkage->word->marathi_translation."]<br />";
                            }
                            echo "</td>
                            <td>".$grapheme->added_by->name()."<br />
                            ".$grapheme->created->format("d/m/Y")."</td>
                            <td>".$grapheme->updated_by->name()."<br />
                            ".$grapheme->updated->format("d/m/Y")."</td>
                            <td><a href='".site_url("englishcontent/editgrapheme/" . $grapheme->id)."' >edit</a><br /><br />
                            <a href='".site_url("englishcontent/deletegrapheme/" . $grapheme->id)."' onclick='return confirm(\"Are you sure?\");' style='color: red;' >delete</a></td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </div>
</div>