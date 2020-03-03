<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Question template added successfully. </p>";
                } else if ( $error == 2 ) {
                    echo "<br /><p class='alert alert-success' >Question template edited successfully. </p>";
                }
            ?>
            <h2>View questions template</h2>
            <?php
                $questiontemplates = QuestionTemplate::find('all');
            ?>
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Action</th>
                </tr>
                <?php
                    foreach($questiontemplates as $question) {
                        echo "
                            <tr>
                                <td>".$question->id."</td>
                                <td>";
                        if( $question->image != '' ) {
                            echo "<img src='".base_url("questiontemplate/" . $question->image )."' width='75' />";
                        } else {
                            echo "No-image";
                        }

                        echo "</td>
                            <td>".$question->name."</td>
                            <td>".$question->added_by->name()."<br />
                            ".$question->created->format("d/m/Y")."</td>
                            <td>".$question->updated_by->name()."<br />
                            ".$question->updated->format("d/m/Y")."</td>
                            <td><a href='".site_url("admin/editquestiontemplate/" . $question->id)."' >edit</a></td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </div>
</div>