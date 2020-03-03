<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Question edited successfully. </p>";
                } else if ( $error == 2 ) {
                    echo "<br /><p class='alert alert-success' >Question edited successfully. </p>";
                } else if ( $error == 3 ) {
                    echo "<br /><p class='alert alert-success' >Question deleted successfully. </p>";
                }
            ?>
            <h2>View questions</h2>
            <?php
                echo $total = ConceptsQuestionLinkage::count(array(
                    'joins' => array("question"),
                    'conditions' => array(" mg_question.status = 'active' ")
                ));

                $totalpagecount = 50;
                $start = $page * $totalpagecount;

                $questions = ConceptsQuestionLinkage::find('all',array(
                    'joins' => array("question"),
                    'conditions' => array(" mg_question.status = 'active' "),
                    "order" => 'created DESC',
                    /*'limit' => $totalpagecount,
                    'offset' => $start,*/
                    'group' => 'question_id'
                ));

                if( $total > 50 ) {
                    echo "Page";
                    $pages = round( $total / $totalpagecount );
                    for($ii = 0 ; $ii < $pages ; $ii++) {
                        echo "<a href='".site_url("admin/viewquestion/" . $ii)."' >$ii</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
                    echo "<br /><br />";
                }

            ?>
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Template</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Question</th>
                    <th>Level</th>
                    <th>Score</th>
                    <th>Concepts</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Action</th>
                </tr>
                <?php
                    foreach($questions as $question) {
                        echo "
                        <tr>
                            <td>".$question->question->id."</td>
                            <td>";
                            if($question->question->question_template_id != 0 && $question->question->question_template_id != '' ) {
                                echo "<img src='".base_url("questiontemplate/" . $question->question->question_template->image)."' width='50' /> <br />
                                " . $question->question->question_template->name;
                            } else {
                                echo "No-Template";
                            }
                            echo "
                            </td>
                            <td>".$question->question->title."</td>
                            <td>".$question->question->meta_type."</td>
                            <td>";
                            if($question->question->meta_type == 'fixed' ) {
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
                            <td>";
                            foreach($question->question->concepts_question_linkage as $val) {
                                echo $val->concept->units->classes->name . " - " . $val->concept->units->subject->name . " - " . $val->concept->units->name . " - " . $val->concept->name . "<br />";
                            }
                            echo "</td>
                            <td>".$question->question->added_by->name()."<br />
                            ".$question->question->created->format("d/m/Y")."</td>
                            <td>".$question->question->updated_by->name()."<br />
                            ".$question->question->updated->format("d/m/Y")."</td>
                            <td><a href='".site_url("admin/editquestion/" . $question->question->id)."' >edit</a><br />
                            <a href='".site_url("admin/deletequestion/" . $question->question->id)."' onclick='return confirm(\"Are you sure?\");' >delete</a></td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </div>
</div>