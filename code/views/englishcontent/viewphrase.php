<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Phrase added successfully.</p>";
                } else if($error == 2) {
                    echo "<br /><p class='alert alert-success' >Phrase edited successfully.</p>";
                } else if($error == 3) {
                    echo "<br /><p class='alert alert-danger' >Access denied, this incident will be reported to administration.</p>";
                } else if($error == 4) {
                    echo "<br /><p class='alert alert-success' >Phrase deleted successfully.</p>";
                }
            ?> 
            <h2>Phrase</h2>
            <br /><br />
            <a type="button" href='<?php echo site_url("englishcontent/addphrase"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add Phrase</a>
            <br /><br /><br /><br />
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Phrase</th>
                    <th>Type</th>
                    <th>Unit</th>
                    <th>Grapheme</th>
                    <th>Sentences</th>
                    <th>Added By</th>
                    <th>Updated By</th>
                    <th>Action</th>
                </tr>
                <?php
                    foreach($phrases as $phrase) {
                        echo "
                        <tr>
                            <td>".$phrase->id."</td>
                            <td>";

                        if( $phrase->image != '' ) {
                            echo "<img src='".base_url("contentfiles/phrase/" . $phrase->image )."' width='50' />";
                        } else {
                            echo "No-image";
                        }

                        echo "</td>
                            <td>".$phrase->phrase."</td>
                            <td>".$phrase->type."</td>
                            <td>" . $phrase->units_id . " </td>
                            <td>";
                            if($phrase->grapheme) {
                                echo  $phrase->grapheme->grapheme;
                            }
                            echo " </td>
                            <td>";
                            foreach($phrase->phrase_sentence_linkage as $ps_linkage) {
                                echo nl2br($ps_linkage->sentence->sentence) . "<hr style='margin: 5px;' />";
                            }
                            echo "</td>
                            <td>".$phrase->added_by->name()."<br />
                            ".$phrase->created->format("d/m/Y")."</td>
                            <td>".$phrase->updated_by->name()."<br />
                            ".$phrase->updated->format("d/m/Y")."</td>
                            <td><a href='".site_url("englishcontent/editphrase/" . $phrase->id)."' >edit</a><br /><br />
                            <a href='".site_url("englishcontent/deletephrase/" . $phrase->id)."' onclick='return confirm(\"Are you sure?\");' style='color: red;' >delete</a></td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </div>
</div>