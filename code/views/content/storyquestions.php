<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Story Question added successfully.</p>";
                } else if($error == 2) {
                    echo "<br /><p class='alert alert-success' >Story Question edited successfully.</p>";
                } else if ( $error == 3 ) {
                    echo "<br /><p class='alert alert-success' >Story Question deleted successfully. </p>";
                }
            ?>
            <h2>Story Question For <?php echo $story->name; ?> (<?php echo $story->language->name; ?>)</h2>
            <br /><br />
            <a type="button" href='<?php echo site_url("admin/addquestion/0/" . $story->id); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add Question</a>
            <br /><br /><br /><br />
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Order Number</th>
                    <th>Story Page No</th>
                    <th>Question</th>
                    <th>Level</th>
                    <th>Score</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Action</th>
                </tr>
                <?php
                    foreach($story->story_question_linkage as $question) {
                        if($question->question->status == 'active') {
                        echo "
                        <tr>
                            <td>".$question->question->id."</td>
                            <td>".$question->question->title."</td>
                            <td>".$question->type."</td>
                            <td>".$question->order_number."</td>
                            <td>".@$question->storypage->pageno."</td>
                            <td>";
                            if($question->question->meta_type == 'fixed' ) {
                                echo "<span style='display:none;'>".$question->question->question."</span>";
                                $question_object = json_decode($question->question->question);
                                if( $question_object->question_type == 'vocabulary') {
                                    $words_arr = array();
                                    foreach($question_object->words as $www) {
                                        $words_arr[] = $www->word;
                                    }
                                    echo implode(" - ", $words_arr);
                                } else {
                                    echo $question_object->question->text;
                                }
                            } else {
                                echo $question->question->question;
                            }
                            echo "
                            </td>
                            <td>".$question->question->level."</td>
                            <td>".$question->question->score."</td>
                            <td>".$question->question->added_by->name()."<br />
                            ".$question->question->created->format("d/m/Y")."</td>
                            <td>".$question->question->updated_by->name()."<br />
                            ".$question->question->updated->format("d/m/Y")."</td>
                            <td><a href='".site_url("admin/editquestion/" . $question->question->id."/" . $story->id)."' >edit</a><br />
                            <a href='".site_url("admin/deletequestion/" . $question->question->id."/" . $story->id)."' onclick='return confirm(\"Are you sure?\");' >delete</a></td>
                        </tr>
                        ";
                        }
                    }
                ?>
            </table>
        </div>
    </div>
</div>