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
                $total = ConceptsQuestionLinkage::count(array(
                    'joins' => array("question"),
                    'conditions' => array(" mg_question.status = 'active' ")
                ));

                $totalpagecount = 50;
                $start = $page * $totalpagecount;

                if(@$_REQUEST['qt']  == '' &&  @$_REQUEST['cc'] == '') {
                    $questions = ConceptsQuestionLinkage::find('all',array(
                        'joins' => array("question"),
                        'conditions' => array(" mg_question.status = 'active' "),
                        "order" => 'question_id ASC',
                        /*'limit' => $totalpagecount,
                        'offset' => $start,*/
                        'group' => 'question_id'
                    ));
                } else {
                    $condd =  " mg_question.status = 'active' ";
                    if(  @$_REQUEST['qt']  != '') {
                        $condd .=  " AND mg_question.question LIKE '%".@$_REQUEST['qt']."%'  ";
                    }
                    if(  @$_REQUEST['cc']  != '') {
                        $condd .=  " AND concepts_id =  '".@$_REQUEST['cc']."'  ";
                    }
                    $questions = ConceptsQuestionLinkage::find('all',array(
                        'joins' => array("question"),
                        'conditions' => array(" $condd  "),
                        "order" => 'question_id ASC',
                        /*'limit' => $totalpagecount,
                        'offset' => $start,*/
                        'group' => 'question_id'
                    ));
                }

                if( $total > 50 ) {
                   /* echo "Page";
                    $pages = round( $total / $totalpagecount );
                    for($ii = 0 ; $ii < $pages ; $ii++) {
                        echo "<a href='".site_url("admin/viewquestion/" . $ii)."' >$ii</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
                    echo "<br /><br />";*/
                }

                $concepts = Concept::find('all',array(
                    'conditions' => " 1 = 1 ",
                    "order" => 'units_id ASC'
                ));

            ?>
            <div class="form-group ftemplate">
							<label for="status" class="col-sm-4 control-label">Question Type</label>
							<div class="col-sm-3">
								<select class="form-control" id="question_type" name="question_type" onchange='change_question_type();'>
                                    <option value=''></option>
                                    <?php
                                        $_qt = array("mcq_single_answer",'fill_blank','match_column','mcq_multiple_answer','vocabulary','story_read_aloud','conversation','make_the_sentence','correct_the_sentence','record_missing_word');
                                        foreach($_qt as $val) {
                                            if(@$_REQUEST['qt'] == $val)
                                                echo "<option value='$val' selected='selected' >$val</option>";
                                            else
                                                echo "<option value='$val' >$val</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>
                       <br style='clear:both'/>
            <div class="form-group ftemplate">
							<label for="status" class="col-sm-4 control-label">Concept</label>
							<div class="col-sm-3">
								<select class="form-control" id="concept" name="concept" onchange='change_question_type();'>
                                    <option value=''></option>
                                    <?php
                                        foreach($concepts as $concept) {
                                            if($concept->units->subject_id == 2) {
                                                if(@$_REQUEST['cc'] == $concept->id)
                                                    echo "<option value='".$concept->id."' selected='selected' >".$concept->name."</option>";
                                                else
                                                    echo "<option value='".$concept->id."' >".$concept->name."</option>";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>
                        <br style='clear:both'/>
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
                    if(@$_REQUEST['for'] == 'grammar') {
                        foreach($questions as $question) {
                            if($question->question->concepts_question_linkage[0]->concept->units->subject_id == 2) {
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
                                    <td>".@$question->question->added_by->name()."<br />
                                    ".@$question->question->created->format("d/m/Y")."</td>
                                    <td>".@$question->question->updated_by->name()."<br />
                                    ".@$question->question->updated->format("d/m/Y")."</td>
                                    <td><a href='".site_url("admin/editquestion/" . $question->question->id . "?for=grammar")."' >edit</a><br />
                                    <a href='".site_url("admin/deletequestion/" . $question->question->id . "?for=grammar")."' onclick='return confirm(\"Are you sure?\");' >delete</a></td>
                                </tr>
                                ";
                            }
                        }
                    } else {
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
                                <td>".@$question->question->added_by->name()."<br />
                                ".@$question->question->created->format("d/m/Y")."</td>
                                <td>".@$question->question->updated_by->name()."<br />
                                ".@$question->question->updated->format("d/m/Y")."</td>
                                <td><a href='".site_url("admin/editquestion/" . $question->question->id)."' >edit</a><br />
                                <a href='".site_url("admin/deletequestion/" . $question->question->id)."' onclick='return confirm(\"Are you sure?\");' >delete</a></td>
                            </tr>
                            ";
                        }
                    }
                ?>
            </table>
        </div>
    </div>
</div>

<script>
    function change_question_type() {
        window.location.href = "<?php echo site_url("admin/viewquestion?for=" . @$_REQUEST['for']); ?>&qt=" + $("#question_type").val() + "&cc=" + $("#concept").val() ;
    }
</script>