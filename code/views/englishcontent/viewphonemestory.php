<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Phoneme story added successfully.</p>";
                } else if($error == 2) {
                    echo "<br /><p class='alert alert-success' >Phoneme story edited successfully.</p>";
                } else if($error == 3) {
                    echo "<br /><p class='alert alert-danger' >Access denied, this incident will be reported to administration.</p>";
                } else if($error == 4) {
                    echo "<br /><p class='alert alert-success' >Phoneme story deleted successfully.</p>";
                }
            ?>
            <h2>Phoneme Story</h2>
            <br /><br />
            <a type="button" href='<?php echo site_url("englishcontent/addphonemestory"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add Phoneme Story</a>
            <br /><br /><br /><br />
            <?php
                $phonemestories = PhonemeStory::find('all',array(
                    'conditions' => " delete_flag = 0 OR delete_flag IS NULL ",
                    "order" => 'id ASC'
                ));
            ?>
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Unit</th>
                    <th>Story</th>
                    <th>Added By</th>
                    <th>Updated By</th>
                    <th>Action</th>
                </tr>
                <?php
                    foreach($phonemestories as $phonemestory) {
                        echo "
                        <tr>
                            <td>".$phonemestory->id."</td>
                            <td>";

                        if( $phonemestory->image != '' ) {
                            echo "<img src='".base_url("contentfiles/phoneme_story/" . $phonemestory->image )."' width='50' />";
                        } else {
                            echo "No-image";
                        }

                        echo "</td>
                            <td>".$phonemestory->title."</td>
                            <td>" . $phonemestory->unit . " </td>
                            <td>" . nl2br($phonemestory->story) . " </td>
                            <td>".$phonemestory->added_by->name()."<br />
                            ".$phonemestory->created->format("d/m/Y")."</td>
                            <td>".$phonemestory->updated_by->name()."<br />
                            ".$phonemestory->updated->format("d/m/Y")."</td>
                            <td><a href='".site_url("englishcontent/editphonemestory/" . $phonemestory->id)."' >edit</a><br />
                            <a href='".site_url("englishcontent/deletephonemestory/" . $phonemestory->id)."' onclick='return confirm(\"Are you sure?\");' style='color: red;' >delete</a></td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </div>
</div>