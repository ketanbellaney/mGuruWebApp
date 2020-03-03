<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Edit Grapheme</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('englishcontent/editgrapheme/' . $grapheme_id);?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Type *</label>
							<div class="col-sm-3">
								<select class="form-control" id="type" name="type" required='required' onchange='change_type(this);'>
                                    <?php
                                        $stypes = array("grapheme","letter","both");
                                        foreach( $stypes as $vva ) {
                                            if(@$grapheme->type == $vva) {
                                                echo "<option value='".$vva."' selected='selected' >" . $vva . "</option>";
                                            } else {
                                                echo "<option value='".$vva."' >" . $vva . "</option>";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Grapheme *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="grapheme" name="grapheme" value="<?php echo @$grapheme->grapheme; ?>" placeholder="Grapheme" required />
							</div>
						</div>

                        <div class="form-group grapheme_only">
							<label for="first_name" class="col-sm-4 control-label">Phoneme *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="phoneme" name="phoneme" value="<?php echo @$grapheme->phoneme; ?>" placeholder="Phoneme" />
								<input type="hidden" class="form-control" id="level" name="level" value="" />
							</div>
						</div>

                        <div style='margin-top: 5px;padding:5px; background-color: #EAEAFF;'>
                        <div class="form-group">
                        <label for="first_name" class="col-sm-12 "><h4>Scripts</h4></label>
                        <?php
                            $lang_script = array();
                            $lang_script1 = array();

                            foreach($grapheme->grapheme_script as $val) {
                                $lang_script[$val->language_id] = $val->script;
                                $lang_script1[$val->language_id] = $val->id;
                            }

                            $language = Language::find("all", array(
                                "conditions" => " id != 3 AND id != 4 ",
                                "order" => " name ASC ",
                            ));
                            $mm = 0;
                            foreach($language as $val) {
                        ?>
                            <label for="first_name" class="col-sm-1 control-label"><?php echo $val->name; ?></label>
    					    <div class="col-sm-1">
    						    <input type="hidden" class="form-control" name="script_id[]" value="<?php echo @$lang_script1[$val->id]; ?>" />
    						    <input type="hidden" class="form-control" name="language_script[]" value="<?php echo $val->id; ?>" />
    						    <input type="text" class="form-control" name="script[]" value="<?php echo @$lang_script[$val->id]; ?>" />
    					    </div>
                        <?php
                            }
                        ?>
                        </div>
                        </div>
                        <br style='clear:both;' />
                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Unit *</label>
							<div class="col-sm-3">
								<select class="form-control" id="units_id" name="units_id" required>
                                    <?php
                                        for($ii = 1 ; $ii <= 12 ; $ii++) {
                                            if($ii == @$grapheme->units_id) {
                                                echo "<option value='".$ii."' selected='selected' >" . $ii . "</option>";
                                            } else {
                                                echo "<option value='".$ii."' >" . $ii . "</option>";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <?php
                            if($grapheme->image != '') {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Image<br />
                            <small><em>Upload a new image to replace the existing image only else leave it blank</em></small></label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="image" name="image" value=""/>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Existing Image</label>
                            <div class="col-sm-6">
								<img src="<?php echo base_url("contentfiles/grapheme/" . $grapheme->image); ?>" width='100' />
							</div>
						</div>
                        <?php
                            } else {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Image</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="image" name="image" value=""/>
							</div>
						</div>
                        <?php
                            }
                        ?>

                        <?php
                            if($grapheme->audio != '') {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Audio<br />
                            <small><em>Upload a new audio to replace the existing audio only else leave it blank</em></small></label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="audio" name="audio" value=""/>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Existing Audio</label>
                            <div class="col-sm-6">
								<a href="<?php echo base_url("contentfiles/grapheme/" . $grapheme->audio); ?>" target='blank' >click here</a>
							</div>
						</div>
                        <?php
                            } else {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Audio</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="audio" name="audio" value=""/>
							</div>
						</div>
                        <?php
                            }
                        ?>

                        <div class="form-group">
                            <br /><br />
							<label for="first_name" class="col-sm-4 control-label"><h4>Primary Words</h4></label>
						</div>

                        <?php
                            $pword = '';
                            $grapheme_index = '';
                            $pimage = '';
                            $paudio = '';
                            $pword_id = '';
                            $plevel = '';
                            $pdefination = '';
                            $pexample = '';
                            $phindi_translation = '';
                            $pmarathi_translation = '';

                            $lang_word = array();
                            $lang_word1 = array();

                            if($grapheme->grapheme_word_linkage_primary) {
                                $pword = @$grapheme->grapheme_word_linkage_primary[0]->word->word;
                                $grapheme_index = @$grapheme->grapheme_word_linkage_primary[0]->grapheme_index;
                                $pimage = @$grapheme->grapheme_word_linkage_primary[0]->word->image;
                                $paudio = @$grapheme->grapheme_word_linkage_primary[0]->word->audio;
                                $pword_id = @$grapheme->grapheme_word_linkage_primary[0]->word_id;
                                $plevel = @$grapheme->grapheme_word_linkage_primary[0]->word->level;
                                $pdefination = @$grapheme->grapheme_word_linkage_primary[0]->word->defination;
                                $pexample = @$grapheme->grapheme_word_linkage_primary[0]->word->example;
                                $phindi_translation = @$grapheme->grapheme_word_linkage_primary[0]->word->hindi_translation;
                                $pmarathi_translation = @$grapheme->grapheme_word_linkage_primary[0]->word->marathi_translation;

                                foreach($grapheme->grapheme_word_linkage_primary[0]->word->word_translation as $val) {
                                    $lang_word[$val->language_id] = $val->translation;
                                    $lang_word1[$val->language_id] = $val->id;
                                }
                            }
                        ?>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Word *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="pword" name="pword" value="<?php echo $pword; ?>" placeholder="Word" required/>
								<input type="hidden" id="pword_id" name="pword_id" value="<?php echo $pword_id; ?>"  />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_indx">Grapheme Index *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="grapheme_index" name="grapheme_index" value="<?php echo $grapheme_index; ?>" placeholder="Index" required/>
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Level</label>
							<div class="col-sm-3">
								<select class="form-control" id="plevel" name="plevel" >
                                    <?php
                                        for($ii = 1 ; $ii <= 2 ; $ii++) {
                                            if($ii == $plevel) {
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
								<input type="text" class="form-control" id="pdefination" name="pdefination" value="<?php echo $pdefination; ?>" placeholder="Word Defination" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Example</label>
							<div class="col-sm-6">
								<textarea class="form-control" id="pexample" name="pexample" placeholder="Example" ><?php echo $pexample; ?></textarea>
							</div>
						</div>

						<div style='margin-top: 5px;padding:5px; background-color: #EAEAFF;'>
                        <div class="form-group">
                        <label for="first_name" class="col-sm-12 "><h4>Translation</h4></label>
                        <?php
                            $mm = 0;
                            foreach($language as $val) {
                        ?>
                            <label for="first_name" class="col-sm-1 control-label"><?php echo $val->name; ?></label>
        					<div class="col-sm-2">
                                <input type="hidden" class="form-control" name="word_translation_id[]" value="<?php echo @$lang_word1[$val->id]; ?>" />
    						    <input type="hidden" class="form-control" name="language_p_id[]" value="<?php echo $val->id; ?>" />
    						    <input type="text" class="form-control" name="language_p_trans[]" value="<?php echo @$lang_word[$val->id]; ?>" />
        					</div>
                        <?php
                            }
                        ?>
                        </div>
                        </div>
                        <br />
                        <div class="form-group" style='display:none;'>
							<label for="first_name" class="col-sm-4 control-label">Hindi Translation</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="phindi_translation" name="phindi_translation" value="<?php echo $phindi_translation; ?>" placeholder="Hindi Translation" />
							</div>
						</div>

                        <div class="form-group" style='display:none;'>
							<label for="first_name" class="col-sm-4 control-label">Marathi Translation</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="pmarathi_translation" name="pmarathi_translation" value="<?php echo $pmarathi_translation; ?>" placeholder="Marathi Translation" />
							</div>
						</div>

                        <?php
                            if($pimage != '') {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Image<br />
                            <small><em>Upload a new image to replace the existing image only else leave it blank</em></small></label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="pimage" name="pimage" value=""/>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Existing Image</label>
                            <div class="col-sm-6">
								<img src="<?php echo base_url("contentfiles/word/" . $pimage); ?>" width='100' />
							</div>
						</div>
                        <?php
                            } else {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Image</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="pimage" name="pimage" value=""/>
							</div>
						</div>
                        <?php
                            }
                        ?>

                        <?php
                            if($paudio != '') {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Audio<br />
                            <small><em>Upload a new audio to replace the existing audio only else leave it blank</em></small></label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="paudio" name="paudio" value=""/>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Existing Audio</label>
                            <div class="col-sm-6">
								<a href="<?php echo base_url("contentfiles/word/" . $paudio); ?>" target='blank' >click here</a>
							</div>
						</div>
                        <?php
                            } else {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Audio</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="paudio" name="paudio" value=""/>
							</div>
						</div>
                        <?php
                            }
                        ?>

                        <div class="form-group">
                            <br /><br />
							<label for="first_name" class="col-sm-4 control-label"><h4>Additional Words</h4></label>
						</div>

                        <div id='wordset'>
                        <?php
                            $wc = count(@$grapheme->grapheme_word_linkage);
                            if($wc < $wordcount) {
                                $wc = $wordcount;
                            } else {
                                $wc += 1;
                            }
                            for($mm = 0 ; $mm < $wc ; $mm++) {

                            $aword = '';
                            $agrapheme_index = '';
                            $aimage = '';
                            $aaudio = '';
                            $aword_id = '';
                            $alevel = '';
                            $adefination = '';
                            $aexample = '';
                            $ahindi_translation = '';
                            $amarathi_translation = '';

                            $lang_word = array();
                            $lang_word1 = array();


                            if(@$grapheme->grapheme_word_linkage[$mm]) {
                                $aword = $grapheme->grapheme_word_linkage[$mm]->word->word;
                                $agrapheme_index = $grapheme->grapheme_word_linkage[$mm]->grapheme_index;
                                $aimage = $grapheme->grapheme_word_linkage[$mm]->word->image;
                                $aaudio = $grapheme->grapheme_word_linkage[$mm]->word->audio;
                                $alevel = $grapheme->grapheme_word_linkage[$mm]->word->level;
                                $adefination = $grapheme->grapheme_word_linkage[$mm]->word->defination;
                                $aexample = $grapheme->grapheme_word_linkage[$mm]->word->example;
                                $ahindi_translation = $grapheme->grapheme_word_linkage[$mm]->word->hindi_translation;
                                $amarathi_translation = $grapheme->grapheme_word_linkage[$mm]->word->marathi_translation;
                                $aword_id = $grapheme->grapheme_word_linkage[$mm]->word_id;

                                foreach($grapheme->grapheme_word_linkage[$mm]->word->word_translation as $val) {
                                    $lang_word[$val->language_id] = $val->translation;
                                    $lang_word1[$val->language_id] = $val->id;
                                }
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
    							<label for="first_name" class="col-sm-4 control-label grapheme_indx">Grapheme Index</label>
    							<div class="col-sm-6">
    								<input type="text" class="form-control" id="agrapheme_index_<?php echo $mm; ?>" name="agrapheme_index_<?php echo $mm; ?>" value="<?php echo $agrapheme_index; ?>" placeholder="Index" />
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

							<div style='margin-top: 5px;padding:5px;' >
                            <div class="form-group">
                            <label for="first_name" class="col-sm-12 "><h4>Translation</h4></label>
                            <?php
                                foreach($language as $val) {
                            ?>
                                <label for="first_name" class="col-sm-1 control-label"><?php echo $val->name; ?></label>
            					<div class="col-sm-2">
            					    <input type="hidden" class="form-control atranslate_<?php echo $mm; ?>" name="word_translation_id_<?php echo $mm; ?>[]" value="<?php echo @$lang_word1[$val->id]; ?>" />
        						    <input type="hidden" class="form-control" name="language_a_id_<?php echo $mm; ?>[]" value="<?php echo $val->id; ?>" />
        						    <input type="text" class="form-control atranslate_<?php echo $mm; ?>" name="language_a_trans_<?php echo $mm; ?>[]" value="<?php echo @$lang_word[$val->id]; ?>" />
            					</div>
                            <?php
                                }
                            ?>
                            </div>
                            </div>

                            <div class="form-group" style='display:none;'>
    							<label for="first_name" class="col-sm-4 control-label">Hindi Translation</label>
    							<div class="col-sm-6">
    								<input type="text" class="form-control" id="ahindi_translation_<?php echo $mm; ?>" name="ahindi_translation_<?php echo $mm; ?>" value="<?php echo $ahindi_translation; ?>" placeholder="Hindi Translation" />
    							</div>
    						</div>

                            <div class="form-group" style='display:none;'>
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
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('englishcontent/viewgrapheme'); ?>">Cancel</a>

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
        $("#agrapheme_index_"+next_num).val("");
        $("#adefination_"+next_num).val("");
        $("#aexample_"+next_num).val("");
        $("#aimage_"+next_num).val("");
        $("#aaudio_"+next_num).val("");
        $("#aword_id_"+next_num).val("");
        $("#alevel_"+next_num).val(1);
        $("#ahindi_translation_"+next_num).val("");
        $("#amarathi_translation_"+next_num).val("");
		$(".atranslate_"+next_num).val("");

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

	function change_type(dis) {
        if( dis.value == "grapheme" ) {
            $(".grapheme_name").html("Grapheme *");
            $(".grapheme_indx").html("Grapheme Index");
            $(".grapheme_only").css("display","block");
        } else if( dis.value == "letter" ) {
            $(".grapheme_name").html("Letter *");
            $(".grapheme_indx").html("Letter Index");
            $(".grapheme_only").css("display","none");
        } else {
            $(".grapheme_name").html("Grapheme *");
            $(".grapheme_indx").html("Grapheme Index");
            $(".grapheme_only").css("display","block");
        }
    }

    function func1() {
        change_type(document.getElementById('type'))
    }

    window.onload=func1;

</script>