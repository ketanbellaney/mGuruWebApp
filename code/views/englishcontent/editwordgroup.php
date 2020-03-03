<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Edit word group</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('englishcontent/editwordgroup/' . $group_word_id);?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Group *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="name" name="name" value="<?php echo @$wordgroup->name; ?>" placeholder="Group Name" required />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Unit *</label>
							<div class="col-sm-3">
								<select class="form-control" id="unit" name="unit" required>
                                    <?php
                                        for($ii = 1 ; $ii <= 12 ; $ii++) {
                                            if(@$wordgroup->unit == $ii) {
                                                echo "<option value='".$ii."' selected='selected' >" . $ii . "</option>";
                                            } else {
                                                echo "<option value='".$ii."' >" . $ii . "</option>";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Class *</label>
							<div class="col-sm-6">
                                <select class="form-control" id="class" name="class" required>
                                    <?php
                                        $_class = array("JKG","SKG",1,2,3,4,5);
                                        foreach($_class as $cla) {
                                            if(@$wordgroup->class == $cla) {
                                                echo "<option value='".$cla."' selected='selected' >" . $cla . "</option>";
                                            } else {
                                                echo "<option value='".$cla."' >" . $cla . "</option>";
                                            }
                                        }
                                    ?>
                                </select>
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Examination Board *</label>
							<div class="col-sm-3">
								<select class="form-control" id="board" name="board" onchange="changeeb(this);" required>
                                    <option value=''></option>
                                    <?php
                                        $_eb = array("ISCE","CBSE","IGCSE","SSC","other");
                                        $flagg = 0;
                                        foreach($_eb as $val) {
                                            if(@$wordgroup->board == $val) {
                                                echo "<option value='".$val."' selected='selected' >" . $val . "</option>";
                                                $flagg = 1;
                                            } else {
                                                echo "<option value='".$val."' >" . $val . "</option>";
                                            }
                                        }
                                        if($flagg == 0) {
                                            echo "<option value='".@$wordgroup->board."' selected='selected' >" . @$wordgroup->board . "</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Page Number</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="page_number" name="page_number" value="<?php echo @$wordgroup->page_number; ?>" placeholder="Page Number" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Source</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="source" name="source" value="<?php echo @$wordgroup->source; ?>" placeholder="Source" />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Status *</label>
							<div class="col-sm-3">
								<select class="form-control" id="status" name="status" required>
                                    <?php
                                        $_status = array("active","inactive");
                                        foreach($_status as $sta) {
                                            if(@$storytextbook->status == $sta) {
                                                echo "<option value='".$sta."' selected='selected' >" . $sta . "</option>";
                                            } else {
                                                echo "<option value='".$sta."' >" . $sta . "</option>";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
                            <br /><br />
							<label for="first_name" class="col-sm-4 control-label"><h4>Words</h4></label>
						</div>

                        <div id='wordset'>
                        <?php
                            $wc = count(@$wordgroup->story_textbook_group_word_linkage);
                            if($wc < $wordcount) {
                                $wc = $wordcount;
                            } else {
                                $wc += 1;
                            }
                            for($mm = 0 ; $mm < $wc ; $mm++) {

                            $aword = '';
                            $aimage = '';
                            $aaudio = '';
                            $aword_id = '';
                            $alevel = '';
                            $adefination = '';
                            $aexample = '';
                            $ahindi_translation = '';
                            $amarathi_translation = '';

                            if(@$wordgroup->story_textbook_group_word_linkage[$mm]) {
                                $aword = $wordgroup->story_textbook_group_word_linkage[$mm]->word->word;
                                $aimage = $wordgroup->story_textbook_group_word_linkage[$mm]->word->image;
                                $aaudio = $wordgroup->story_textbook_group_word_linkage[$mm]->word->audio;
                                $alevel = $wordgroup->story_textbook_group_word_linkage[$mm]->word->level;
                                $adefination = $wordgroup->story_textbook_group_word_linkage[$mm]->word->defination;
                                $aexample = $wordgroup->story_textbook_group_word_linkage[$mm]->word->example;
                                $ahindi_translation = $wordgroup->story_textbook_group_word_linkage[$mm]->word->hindi_translation;
                                $amarathi_translation = $wordgroup->story_textbook_group_word_linkage[$mm]->word->marathi_translation;
                                $aword_id = $wordgroup->story_textbook_group_word_linkage[$mm]->word_id;
                            }
                        ?>
                            <div style='margin-top: 5px;padding:5px; background-color: #EAEAFF;'  class='wordset_<?php echo $mm; ?>'>
                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label">Word</label>
    							<div class="col-sm-6">
    								<input type="text" class="form-control" id="aword_<?php echo $mm; ?>" name="aword_<?php echo $mm; ?>" value="<?php echo $aword; ?>" placeholder="Word"/>
    								<input type="hidden" class="form-control" id="aword_id_<?php echo $mm; ?>" name="aword_id_<?php echo $mm; ?>" value="<?php echo $aword_id; ?>" placeholder="Word"/>
    							</div>
    						</div>

                            <div class="form-group">
    							<label for="status" class="col-sm-4 control-label">Level</label>
    							<div class="col-sm-3">
    								<select class="form-control" id="alevel_<?php echo $mm; ?>" name="alevel_<?php echo $mm; ?>" >
                                        <?php
                                            for($ii = 1 ; $ii <= 2 ; $ii++) {
                                                if($alevel == $ii) {
                                                    echo "<option value='".$ii."' selected='selected' >" . $ii . "</option>";
                                                } else {
                                                    echo "<option value='".$ii."' >" . $ii . "</option>";
                                                }
                                            }
                                        ?>
    								</select>
    							</div>
    						</div>

                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label">Word Defination</label>
    							<div class="col-sm-6">
    								<input type="text" class="form-control" id="adefination_<?php echo $mm; ?>" name="adefination_<?php echo $mm; ?>" value="<?php echo $adefination; ?>" placeholder="Word Defination" />
    							</div>
    						</div>

                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label">Example</label>
    							<div class="col-sm-6">
    								<textarea class="form-control" id="aexample_<?php echo $mm; ?>" name="aexample_<?php echo $mm; ?>" placeholder="Example" ><?php echo $aexample; ?></textarea>
    							</div>
    						</div>

                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label">Hindi Translation</label>
    							<div class="col-sm-6">
    								<input type="text" class="form-control" id="ahindi_translation_<?php echo $mm; ?>" name="ahindi_translation_<?php echo $mm; ?>" value="<?php echo $ahindi_translation; ?>" placeholder="Hindi Translation" />
    							</div>
    						</div>

                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label">Marathi Translation</label>
    							<div class="col-sm-6">
    								<input type="text" class="form-control" id="amarathi_translation_<?php echo $mm; ?>" name="amarathi_translation_<?php echo $mm; ?>" value="<?php echo $amarathi_translation; ?>" placeholder="Marathi Translation" />
    							</div>
    						</div>


                            <?php
                                if($aimage != '') {
                            ?>
                              <div class="form-group">
      							<label for="first_name" class="col-sm-4 control-label">Image<br />
                                  <small id='existing_img_<?php echo $mm; ?>' ><em>Upload a new image to replace the existing image only else leave it blank</em></small></label>
      							<div class="col-sm-6">
      								<input type="file" class="form-control" id="aimage_<?php echo $mm; ?>" name="aimage_<?php echo $mm; ?>" value=""/>
      							</div>
      						</div>

                              <div class="form-group"  id='existing_img1_<?php echo $mm; ?>' >
      							<label for="first_name" class="col-sm-4 control-label">Existing Image</label>
                                  <div class="col-sm-6">
      								<img src="<?php echo base_url("contentfiles/word/" . $aimage); ?>" width='100' />
      							</div>
      						</div>
                              <?php
                                  } else {
                              ?>
                              <div class="form-group">
      							<label for="first_name" class="col-sm-4 control-label">Image</label>
      							<div class="col-sm-6">
      								<input type="file" class="form-control" id="aimage_<?php echo $mm; ?>" name="aimage_<?php echo $mm; ?>" value=""/>
      							</div>
      						</div>
                              <?php
                                  }
                              ?>

                              <?php
                                  if($aaudio != '') {
                              ?>
                              <div class="form-group">
      							<label for="first_name" class="col-sm-4 control-label">Audio<br />
                                  <small id='existing_aud_<?php echo $mm; ?>'><em>Upload a new audio to replace the existing audio only else leave it blank</em></small></label>
      							<div class="col-sm-6">
      								<input type="file" class="form-control" id="aaudio_<?php echo $mm; ?>" name="aaudio_<?php echo $mm; ?>" value=""/>
      							</div>
      						</div>

                              <div class="form-group" id='existing_aud1_<?php echo $mm; ?>'>
      							<label for="first_name" class="col-sm-4 control-label">Existing Audio</label>
                                  <div class="col-sm-6">
      								<a href="<?php echo base_url("contentfiles/word/" . $aaudio); ?>" target='blank' >click here</a>
      							</div>
      						</div>
                              <?php
                                  } else {
                              ?>
                              <div class="form-group">
      							<label for="first_name" class="col-sm-4 control-label">Audio</label>
      							<div class="col-sm-6">
      								<input type="file" class="form-control" id="aaudio_<?php echo $mm; ?>" name="aaudio_<?php echo $mm; ?>" value=""/>
      							</div>
      						</div>
                              <?php
                                  }
                              ?>
                              </div>
                        <?php
                            }
                        ?>
                        </div>
                        <input type='hidden' name='count_word' id='count_word' value='<?php echo $wc; ?>' />
                        <br /><br />
                        <button type="button" class="btn ruhe-btn-default-submit1 pull-left" onclick='addanotherword();' >ADD</button>

                        <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Save</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('englishcontent/viewwordgroup'); ?>">Cancel</a>

                     </form>
        </div>
    </div>
</div>

<script>
    var next_num = <?php echo $wc; ?>;

    function addanotherword() {
        var divtxt = "<div style='margin-top: 5px;padding:5px; background-color: #EAEAFF;' class='wordset_"+next_num+"'>" + $( ".wordset_0").clone().html() + "</div>";
        divtxt = divtxt.replace(/_0/g, "_" + next_num);
        divtxt = divtxt.replace(/ 0/g, " " + next_num);
        divtxt = divtxt.replace(/\(0/g, "(" + next_num);
        $( divtxt ).appendTo( "#wordset" );

        $("#aword_"+next_num).val("");
        $("#adefination_"+next_num).val("");
        $("#aexample_"+next_num).val("");
        $("#aimage_"+next_num).val("");
        $("#aaudio_"+next_num).val("");
        $("#aword_id_"+next_num).val("");
        $("#alevel_"+next_num).val(1);
        $("#ahindi_translation_"+next_num).val("");
        $("#amarathi_translation_"+next_num).val("");

        if(document.getElementById('existing_img_' + next_num)) {
            $("#existing_img_"+next_num).html("");
            $("#existing_img1_"+next_num).html("");
        }
        if(document.getElementById('existing_aud_' + next_num)) {
            $("#existing_aud_"+next_num).html("");
            $("#existing_aud1_"+next_num).html("");
        }
        next_num++;

        $("#count_word").val(next_num);
    }


    function changeeb(dis){
        if(dis.value == 'other') {
            dis.parentNode.innerHTML = "<input type='text' class='form-control' id='examination_board' name='examination_board' placeholder='Examination Board' value='' />";
        }
    }
</script>