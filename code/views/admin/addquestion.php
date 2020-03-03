<?php
    if($story_id != 0 && $story_id != '') {
        //! Get the story Details
        $temp = Story::find($story_id);
        if(isset($temp->id)) {
            $story = $temp;
        }
    }

    if($helpvideo_id != 0 && $helpvideo_id != '') {
        $temp = HelpVideo::find($helpvideo_id);
        if(isset($temp->id)) {
            $helpvideo = $temp;
        }
    }
?>
<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Add new question <?php
              if(isset($story)) {
                    echo " for " . $story->name . "(".$story->language->name.")";
              }
              if(isset($helpvideo)) {
                    echo " for Help Video '" . $helpvideo->title ."'";
              }
            ?> </h2>
            <?php
		        if(@$error == 2) {
			        echo "<p class='alert alert-success'>New question added.</p>";
			    } else {
            ?>
                    <form class='form-horizontal' role="form" action="<?php echo site_url('admin/addquestion/0/' . $story_id ."/" . $helpvideo_id . "?for=" . @$_REQUEST['for']);?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">
                        <?php
                            if(isset($story)) {
                        ?>
                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label">Story Question type *</label>
    							<div class="col-sm-6">
                                    <select class="form-control" id="type" name="type" onchange='changestory_pagedis();'>
                                        <?php
                                            $_sqt = array("pre",'post',"during",'own_story');
                                            foreach($_sqt as $val) {
                                                echo "<option value='$val' >$val</option>";
                                            }
                                        ?>
    								</select>
    							</div>
    						</div>

                            <div class="form-group" style='display:none;' id='story_pagedis' >
    							<label for="first_name" class="col-sm-4 control-label">Page No *</label>
    							<div class="col-sm-6">
                                    <select class="form-control" id="storypage_id" name="storypage_id" >
                                        <?php
                                           foreach($story->storypage as $page) {
                                                echo "<option value='".$page->id."' >Page ".$page->pageno."</option>";
                                            }
                                        ?>
    								</select>
    							</div>
    						</div>
                            <div class="form-group" >
    							<label for="first_name" class="col-sm-4 control-label">Order Number *</label>
    							<div class="col-sm-6">
                                    <select class="form-control" id="order_number" name="order_number" >
                                        <?php
                                           for($ii = 1 ; $ii <= 30 ; $ii++) {
                                                echo "<option value='".$ii."' >".$ii."</option>";
                                            }
                                        ?>
    								</select>
    							</div>
    						</div>
                        <?php
                            }
                        ?>
                        <?php
                            if(isset($helpvideo)) {
                        ?>
                            <div class="form-group" >
    							<label for="first_name" class="col-sm-4 control-label">Order Number *</label>
    							<div class="col-sm-6">
                                    <select class="form-control" id="order_number" name="order_number" >
                                        <?php
                                           for($ii = 1 ; $ii <= 30 ; $ii++) {
                                                echo "<option value='".$ii."' >".$ii."</option>";
                                            }
                                        ?>
    								</select>
    							</div>
    						</div>
                        <?php
                            }
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Title *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="title" name="title" value="" placeholder="Question Title" required />
							</div>
						</div>

                        <div class="form-group">
							<div class="col-sm-4"> </div>
							<div class="col-sm-2">
								<input type="button" class="form-control btn btn-default" id="titlebutton" name="titlebutton" value="Title Translation" onclick='opentranslationdiv();' />
							</div>
						</div>

                        <div style='margin-top: 5px;padding:5px; background-color: #EAEAFF; display:none;' id='titletranslation'>
                            <div class="form-group">
                                <label for="first_name" class="col-sm-12 "><h4>Title Translation</h4></label>
                                <?php
                                    $language = Language::find("all", array(
                                        "conditions" => " id != 3 AND id != 4 ",
                                        "order" => " name ASC ",
                                    ));

                                    $mm = 0;
                                    foreach($language as $val) {
                                ?>
                                    <label for="first_name" class="col-sm-4 control-label"><?php echo $val->name; ?></label>
        					        <div class="col-sm-6">
                                        <input type="hidden" class="form-control" id='language_id_<?php echo $val->id; ?>' name="language_id[]" value="<?php echo $val->id; ?>" />
        						        <input type="text" class="form-control alltranslate" id='language_trans_<?php echo $val->id; ?>' name="language_trans[]" value="" />
        					        </div>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>

                        <?php
                            if(isset($story)) {
                        ?>
                            <input type="hidden" class="form-control" id="meta_type" name="meta_type" value="fixed" />
                        <?php
                            } else if(isset($helpvideo)) {
                        ?>
                            <input type="hidden" class="form-control" id="meta_type" name="meta_type" value="fixed" />
                        <?php
                            } else {
                        ?>
                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Meta Type *</label>
							<div class="col-sm-3">

								<select class="form-control" id="meta_type" name="meta_type" required onchange='change_mt(this);'>
                                    <?php
                                        $_mt = array("template",'fixed');
                                        foreach($_mt as $val) {
                                            if(@$_REQUEST['for'] == "grammar" && $val == 'fixed') {
                                                echo "<option value='$val' selected>$val</option>";
                                            } else {
                                                echo "<option value='$val' >$val</option>";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>
                        <?php
                            }
                        ?>

                        <div class="form-group qtemplate">
							<label for="status" class="col-sm-4 control-label">Question Template</label>
							<div class="col-sm-6">
								<select class="form-control" id="qtemplate" name="qtemplate" onchange='change_question_template(this);'>
                                    <option value=''></option>
                                    <?php
                                        $templates = new ReflectionClass('Mathtemplate');
                                        $methods = $templates->getMethods();

                                        for($ii = 1 ; $ii < count($methods) ; $ii++ ) {
                                            $para = array();
                                            foreach($methods[$ii]->getParameters() as $val1) {
                                                $para[] = $val1->name;
                                            }
                                            $val = $methods[$ii]->name . "( " . implode(" , " , $para) . " )";
                                            echo "<option value='$val' >$val</option>";
                                        }
                                    ?>
								</select><br />
                                <input type="text" class="form-control" id="question_template" name="question_template" value="" placeholder="Question Template" />
							</div>
						</div>

                        <div class="form-group ftemplate">
							<label for="status" class="col-sm-4 control-label">Question Type</label>
							<div class="col-sm-3">
								<select class="form-control" id="question_type" name="question_type" onchange='change_question_type(this);'>
                                    <option value=''></option>
                                    <?php
                                        $_qt = array("mcq_single_answer",'fill_blank','match_column','mcq_multiple_answer','vocabulary','story_read_aloud','conversation','make_the_sentence','correct_the_sentence','record_missing_word');
                                        foreach($_qt as $val) {
                                            echo "<option value='$val' >$val</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group ftemplate all_t t1 t2 t3 t4 t5 t6 t7 t8 t9">
							<label for="display_name" class="col-sm-4 control-label">Question</label>
							<div class="col-sm-6">
								<textarea class="form-control" id="question_text" name="question_text" placeholder="Question" ></textarea> <br />
                                <input type="file" class="form-control" id="question_image" name="question_image" placeholder="Question image" value="" />
							</div>
						</div>

                        <div class="form-group ftemplate all_t t2">
                            <div class="col-sm-6">     </div>
                            <div class="col-sm-6">
							<em><i>For fill in the blank put ::blank:: in the question itself</i></em>
                            </div>
						</div>

                        <div class="form-group ftemplate all_t t8">
                            <div class="col-sm-2">     </div>
                            <div class="col-sm-8">
							<em><i>Write the answer in the box called "Question." Then in the box below, rewrite the answer and use hash(#) to separate the sentence into the parts you want. Ensure you separate punctuation also. E.g. "Question: They are eating dinner; Box Below: They# are# eating dinner# ." Note the hash before the full stop.</i></em><br />

                            <textarea class="form-control" id="wrong_options" name="wrong_options" placeholder="" ></textarea> <br />
                            </div>
						</div>

                        <div class="form-group ftemplate all_t t9">
                            <div class="col-sm-2">     </div>
                            <div class="col-sm-8">
							<em><i>For Correct the sentence put the sentence with ::blank:: in the question ( like [I ::blank:: a boy.] ) </i></em><br /><br />
                            <div class="col-sm-3 control-label"><label class=''>Wrong answer</label></div>
                            <div class="col-sm-5"><input type="text" class="form-control" id="cts_wrong_answer" name="cts_wrong_answer" placeholder="" value="" /></div>
                            <br style='clear: both;'/>
                            <br style='clear: both;'/>
                            <div class="col-sm-3 control-label"><label class=''>Correct answer</label></div>
                            <div class="col-sm-5"><input type="text" class="form-control" id="cts_correct_answer" name="cts_correct_answer" placeholder="" value="" /></div>
                            </div>
						</div>

                        <div class="form-group ftemplate all_t t1 t4">
                            <div class="col-sm-2">
                                &nbsp;
                            </div>
                            <div class="col-sm-6">
							    <label for="email" class="col-sm-4 control-label">Options</label>
                            </div>
						</div>

                        <?php
                            for($ii = 1 ; $ii <= 5 ; $ii++) {
                        ?>
                        <div class="form-group ftemplate all_t t1 t4">
                            <div class="col-sm-2">
                                &nbsp;
                            </div>
							<div class="col-sm-1">
                                Option <?php echo $ii; ?>
                            </div>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="option_<?php echo $ii; ?>" name="option_<?php echo $ii; ?>" placeholder="Option <?php echo $ii; ?>" value="" />
							</div>
                            <div class="col-sm-2">
								<input type="file" class="form-control" id="option_image_<?php echo $ii; ?>" name="option_image_<?php echo $ii; ?>" placeholder="Option image <?php echo $ii; ?>" value="" />
							</div>
                            <div class="col-sm-1">
								Ans
							</div>
                            <div class="col-sm-1">
								<input type="checkbox" class="form-control" id="option_ans_<?php echo $ii; ?>" name="option_ans_<?php echo $ii; ?>" value="1" />
							</div>
                            <div class="col-sm-2">
                                &nbsp;
                            </div>
						</div>
                        <?php
                            }
                        ?>

                        <div class="form-group ftemplate all_t t5">
                            <div class="col-sm-2">
                                &nbsp;
                            </div>
                            <div class="col-sm-6">
							    <label for="email" class="col-sm-4 control-label">Vocabulary Words</label>
                            </div>
						</div>

                        <?php
                            for($ii = 1 ; $ii <= 5 ; $ii++) {
                        ?>
                        <div class="form-group ftemplate all_t t5">
                            <div class="col-sm-2">
                                &nbsp;
                            </div>
							<div class="col-sm-1">
                                Word <?php echo $ii; ?>
                            </div>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="vocab_word_<?php echo $ii; ?>" name="vocab_word_<?php echo $ii; ?>" placeholder="Word <?php echo $ii; ?>" value="" />
							</div>
                            <div class="col-sm-3">
								<input type="file" class="form-control" id="vocab_image_<?php echo $ii; ?>" name="vocab_image_<?php echo $ii; ?>" placeholder="Word image <?php echo $ii; ?>" value="" />
							</div>
                            <div class="col-sm-2">
                                &nbsp;
                            </div>
						</div>
                        <?php
                            }
                        ?>

                        <div class="form-group ftemplate all_t t7">
                            <div class="col-sm-2">
                                &nbsp;
                            </div>
                            <div class="col-sm-6">
							    <label for="email" class="col-sm-4 control-label">Conversation</label>
                            </div>
						</div>

                        <?php
                            for($ii = 1 ; $ii <= 10 ; $ii++) {
                        ?>
                        <div class="form-group ftemplate all_t t7">
                            <div class="col-sm-2">
                                &nbsp;
                            </div>
							<div class="col-sm-1">
                                <?php echo $ii; ?>
                            </div>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="sentence_<?php echo $ii; ?>" name="sentence_<?php echo $ii; ?>" placeholder="Sentence <?php echo $ii; ?>" value="" />
							</div>
                            <div class="col-sm-2">
								<input type="file" class="form-control" id="sentence_image_<?php echo $ii; ?>" name="sentence_image_<?php echo $ii; ?>" placeholder="Sentence image <?php echo $ii; ?>" value="" />
							</div>
                            <div class="col-sm-1">
								<input type="checkbox" class="form-control" id="sentence_question_<?php echo $ii; ?>" name="sentence_question_<?php echo $ii; ?>" value="1" />
							</div>
                            <div class="col-sm-2">
                                &nbsp;
                            </div>
						</div>
                        <?php
                            }
                        ?>

                        <div class="form-group ftemplate all_t t2">
                            <div class="col-sm-2">
                                &nbsp;
                            </div>
							<label for="email" class="col-sm-6 control-label">Answers</label>
						</div>
                        <?php
                            for($ii = 1 ; $ii <= 5 ; $ii++) {
                        ?>
                        <div class="form-group ftemplate all_t t2">
                            <div class="col-sm-2">
                                &nbsp;
                            </div>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="ans_<?php echo $ii; ?>" name="ans_<?php echo $ii; ?>" placeholder="Answer <?php echo $ii; ?>" value="" />
							</div>
                            <div class="col-sm-2">
                                &nbsp;
                            </div>
						</div>
                        <?php
                            }
                        ?>

                        <div class="form-group ftemplate all_t t3">
                            <div class="col-sm-2">
                                &nbsp;
                            </div>
							<div class="col-sm-4"><b>Column 1</b>
                            <br /><br />
                            <?php
                                for($ii = 1 ; $ii <= 5 ; $ii++) {
                            ?>
                            	<div class="col-sm-6">
    								<input type="text" class="form-control" id="c1_text_<?php echo $ii; ?>" name="c1_text_<?php echo $ii; ?>" placeholder="Column 1 text <?php echo $ii; ?>" value="" />
    							</div>
                                <div class="col-sm-6">
    								<input type="file" class="form-control" id="c1_image_<?php echo $ii; ?>" name="c1_image_<?php echo $ii; ?>" placeholder="Column 1 image <?php echo $ii; ?>" value="" />
    							</div>
                            <?php
                                }
                            ?>

                            </div>
							<div class="col-sm-4"><b>Column 2</b>
                            <br /><br />
                            <?php
                                for($ii = 1 ; $ii <= 5 ; $ii++) {
                            ?>
                            	<div class="col-sm-6">
    								<input type="text" class="form-control" id="c2_text_<?php echo $ii; ?>" name="c2_text_<?php echo $ii; ?>" placeholder="Column 2 text <?php echo $ii; ?>" value="" />
    							</div>
                                <div class="col-sm-6">
    								<input type="file" class="form-control" id="c2_image_<?php echo $ii; ?>" name="c2_image_<?php echo $ii; ?>" placeholder="Column 2 image <?php echo $ii; ?>" value="" />
    							</div>
                            <?php
                                }
                            ?>
                            </div>
                            <div class="col-sm-2">
                                &nbsp;
                            </div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Level *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="level" name="level" value="" placeholder="Question level" required />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Score *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="score" name="score" value="" placeholder="Question Score" required />
							</div>
						</div>

                        <?php
                            if(isset($story)) {

                            } else if(isset($helpvideo)) {

                            } else {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Concept*</label>
                            <div class="col-sm-6">
                            <div id='concepts_div' >
						    <div class='form-group'  class='col-lg-12  col-md-12 col-sm-12  col-xs-12'>
                                    <select  class="form-control" name='concepts[]'>
                                        <option value=''></option>
                                        <?php
                                            if(@$_REQUEST['for'] == "grammar") {
                                                foreach($concepts as $val) {
                                                    if($val->units->subject_id == 2) {
                                                        echo "<option value='".$val->id."'>".$val->units->classes->name." - ".$val->units->subject->name." - ".$val->units->name." - ".$val->name."</option>   ";
                                                    }
                                                }
                                            } else {
                                                foreach($concepts as $val) {
                                                    echo "<option value='".$val->id."'>".$val->units->classes->name." - ".$val->units->subject->name." - ".$val->units->name." - ".$val->name."</option>   ";
                                                }
                                            }
                                        ?>
                                    </select>
                            </div>
						</div>
                        <button type="button" class="btn btn-danger <?php if(@$_REQUEST['for'] == 'grammar') echo " hidden ";  ?> " id="addanother1" name="addanother1" onclick='addanother();' >Add another concept</button>
                        <br />
                            </div>
						</div>
                        <?php
                            }
                        ?>

                        <div class="form-group <?php if(@$_REQUEST['for'] == 'grammar') echo " hidden ";  ?>">
    					    <label for="first_name" class="col-sm-4 control-label">Question Template *</label>
    							<div class="col-sm-6">
                                    <select class="form-control" id="question_template_id" name="question_template_id" onchange='changedisplayimage(this);'>
                                        <?php
                                            $imgg = '';
                                            foreach($questiontemplate as $val) {
                                                if($imgg == '') {
                                                    $imgg = $val->image;
                                                }
                                                echo "<option value='".$val->id."' data-src='".$val->image."' >".$val->name."</option>";
                                            }
                                        ?>
    								</select>
                                    <br /><br />
                                    <img src='<?php echo base_url("questiontemplate/" . $imgg); ?>' width=100 id='imagg' />
    							</div>
    						</div>



					    <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Submit</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('site/home'); ?>">Cancel</a>

                     </form>
                <?php
                    }
                ?>
        </div>
    </div>
</div>
<script>
    function change_question_template(dis) {
        $("#question_template").val(dis.value);
    }

    function change_mt(dis){
        if(dis.value == 'fixed') {
            $(".ftemplate").css("display","block");
            $(".qtemplate").css("display","none");
        } else {
            $(".ftemplate").css("display","none");
            $(".qtemplate").css("display","block");
        }
        change_question_type(document.getElementById('question_type')) ;
    }

    function change_question_type(dis) {
        $(".all_t").css("display","none");
        if(dis.value == 'mcq_single_answer' || dis.value == 'mcq_multiple_answer' ) {
            $(".t1").css("display","block");
            $(".t4").css("display","block");
            $("#question_template_id").val("2");
            if( dis.value == 'mcq_multiple_answer' ) {
                $("#question_template_id").val("12");
            }
        } else if(dis.value == 'fill_blank' || dis.value == "record_missing_word") {
            $(".t2").css("display","block");
            $("#question_template_id").val("19");
        } else if(dis.value == 'match_column') {
            $(".t3").css("display","block");
            $("#question_template_id").val("20");
        } else if(dis.value == 'vocabulary') {
            $(".t5").css("display","block");
            $("#question_template_id").val("21");
        } else if(dis.value == 'story_read_aloud') {
            $(".t6").css("display","block");
            $("#question_template_id").val("8");
        } else if(dis.value == 'conversation') {
            $(".t7").css("display","block");
            $("#question_template_id").val("6");
        } else if(dis.value == 'make_the_sentence') {
            $(".t8").css("display","block");
            $("#question_template_id").val("51");
        } else if(dis.value == 'correct_the_sentence') {
            $(".t9").css("display","block");
            $("#question_template_id").val("19");
        }

        changedisplayimage(document.getElementById('question_template_id'))
    }

    window.onload=function(){
        change_mt(document.getElementById('meta_type'));
    };

    function addanother() {
        var root=document.getElementById('concepts_div');
        var divs=root.getElementsByTagName('div');
        var clone=divs[divs.length-1].cloneNode(true);
        root.appendChild(clone);
        var root=document.getElementById('concepts_div');
        var divs=root.getElementsByTagName('div');
        var aaa = divs.length-1;
        var abc = divs[divs.length-1];
        abc1 = abc.getElementsByTagName("select");
        abc1[0].value = '';
    }

    function changestory_pagedis() {
        if($("#type").val() == 'during') {
            $("#story_pagedis").css("display","block");
        } else {
            $("#story_pagedis").css("display","none");
        }
    }

    function changedisplayimage(dis) {
        imgg = $('option:selected', dis).attr('data-src');

        $("#imagg").attr("src","<?php echo base_url('questiontemplate'); ?>/" + imgg);
    }

    function opentranslationdiv() {
        if($("#titletranslation").css("display") == "none") {
            $("#titletranslation").css("display","block");
        } else {
            $("#titletranslation").css("display","none");
        }
    }

</script>