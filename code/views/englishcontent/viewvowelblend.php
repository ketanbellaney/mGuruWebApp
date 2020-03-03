<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Vowel blend added successfully.</p>";
                } else if($error == 2) {
                    echo "<br /><p class='alert alert-success' >Vowel blend edited successfully.</p>";
                } else if($error == 3) {
                    echo "<br /><p class='alert alert-danger' >Access denied, this incident will be reported to administration.</p>";
                } else if($error == 4) {
                    echo "<br /><p class='alert alert-success' >Vowel blend deleted successfully.</p>";
                }
            ?>
            <h2>Vowel blend</h2>
            <br /><br />
            <a type="button" href='<?php echo site_url("englishcontent/addvowelblend"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add Vowel blend</a>
            <br /><br /><br /><br />
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Vowel Blend</th>
                    <th>Word</th>
                    <th>Level</th>
                    <th>Unit</th>
                    <th>Order Number</th>
                    <th>Audio</th>
                    <th>Added By</th>
                    <th>Updated By</th>
                    <th>Action</th>
                </tr>
                <?php
                    foreach($vbs as $vb) {
                        echo "
                        <tr>
                            <td>".$vb->id."</td>
                            <td>".$vb->secondary_letter.$vb->vowel."</td>
                            <td>";
                        if($vb->wordsegment_id != 0 && $vb->wordsegment_id != '') {
                            echo $vb->wordsegment->word;
                        } else {
                            echo "no-word";
                        }
                        echo "</td>
                            <td>".$vb->level."</td>
                            <td>".$vb->unit."</td>
                            <td>".$vb->order_num."</td>
                            <td>";

                            if( $vb->audio != '' ) {
                                echo "yes";
                            } else {
                                echo "no-audio";
                            }

                        echo "</td>
                            <td>".$vb->added_by->name()."<br />
                            ".$vb->created->format("d/m/Y")."</td>
                            <td>".$vb->updated_by->name()."<br />
                            ".$vb->updated->format("d/m/Y")."</td>
                            <td><a href='".site_url("englishcontent/editvowelblend/" . $vb->id)."' >edit</a><br /><br />
                            <a href='".site_url("englishcontent/deletevowelblend/" . $vb->id)."' onclick='return confirm(\"Are you sure?\");' style='color: red;' >delete</a></td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </div>
</div>