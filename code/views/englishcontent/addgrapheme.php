<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Add new grapheme</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('englishcontent/addgrapheme');?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Type *</label>
							<div class="col-sm-3">
								<select class="form-control" id="type" name="type" required='required' onchange='change_type(this);'>
                                    <?php
                                        $stypes = array("grapheme","letter","both");
                                        foreach( $stypes as $vva ) {
                                            echo "<option value='".$vva."' >" . $vva . "</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                       <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Grapheme *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="grapheme" name="grapheme" value="" placeholder="Grapheme" required />
							</div>
						</div>

                        <div class="form-group grapheme_only">
							<label for="first_name" class="col-sm-4 control-label">Phoneme *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="phoneme" name="phoneme" value="" placeholder="Phoneme" />
								<input type="hidden" class="form-control" id="level" name="level" value="" />
							</div>
						</div>

                        <div style='margin-top: 5px;padding:5px; background-color: #EAEAFF;'>
                        <div class="form-group">
                        <label for="first_name" class="col-sm-12 "><h4>Scripts</h4></label>
                        <?php
                            $language = Language::find("all", array(
                                "conditions" => " id != 3 AND id != 4 ",
                                "order" => " name ASC ",
                            ));
                            $mm = 0;
                            foreach($language as $val) {
                        ?>
                            <label for="first_name" class="col-sm-1 control-label"><?php echo $val->name; ?></label>
        					<div class="col-sm-1">
        					    <input type="hidden" class="form-control" name="language_script[]" value="<?php echo $val->id; ?>" />
        						<input type="text" class="form-control" name="script[]" value="" />
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
                                            echo "<option value='".$ii."' >" . $ii . "</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Trace Image</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="image" name="image" value=""/>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Audio</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="audio" name="audio" value=""/>
							</div>
						</div>


                        <div class="form-group">
                            <br /><br />
							<label for="first_name" class="col-sm-4 control-label"><h4>Primary Words</h4></label>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Word *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="pword" name="pword" value="" placeholder="Word" required/>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_indx">Grapheme Index *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="grapheme_index" name="grapheme_index" value="" placeholder="Index" required/>
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Level</label>
							<div class="col-sm-3">
								<select class="form-control" id="plevel" name="plevel" >
                                    <?php
                                        for($ii = 1 ; $ii <= 2 ; $ii++) {
                                            echo "<option value='".$ii."' >" . $ii . "</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Word Defination</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="pdefination" name="pdefination" value="" placeholder="Word Defination" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Example</label>
							<div class="col-sm-6">
								<textarea class="form-control" id="pexample" name="pexample" placeholder="Example" ></textarea>
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
        					    <input type="hidden" class="form-control" name="language_p_id[]" value="<?php echo $val->id; ?>" />
        						<input type="text" class="form-control" name="language_p_trans[]" value="" />
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
								<input type="text" class="form-control" id="phindi_translation" name="phindi_translation" value="" placeholder="Hindi Translation" />
							</div>
						</div>

                        <div class="form-group" style='display:none;'>
							<label for="first_name" class="col-sm-4 control-label">Marathi Translation</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="pmarathi_translation" name="pmarathi_translation" value="" placeholder="Marathi Translation" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Image</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="pimage" name="pimage" value=""/>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Audio</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="paudio" name="paudio" value=""/>
							</div>
						</div>


                        <div class="form-group">
                            <br /><br />
							<label for="first_name" class="col-sm-4 control-label"><h4>Additional Words</h4></label>
						</div>

                        <div id='wordset'>
                        <?php
                            for($mm = 0 ; $mm < $wordcount ; $mm++) {
                        ?>
                            <div style='margin-top: 5px;padding:5px; background-color: #EAEAFF;' class='wordset_<?php echo $mm; ?>'>
                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label">Word</label>
    							<div class="col-sm-6">
    								<input type="text" class="form-control" id="aword_<?php echo $mm; ?>" name="aword_<?php echo $mm; ?>" value="" placeholder="Word"/>
    							</div>
    						</div>

                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label grapheme_indx">Grapheme Index</label>
    							<div class="col-sm-6">
    								<input type="text" class="form-control" id="agrapheme_index_<?php echo $mm; ?>" name="agrapheme_index_<?php echo $mm; ?>" value="" placeholder="Index" />
    							</div>
    						</div>

                            <div class="form-group">
    							<label for="status" class="col-sm-4 control-label">Level</label>
    							<div class="col-sm-3">
    								<select class="form-control" id="alevel_<?php echo $mm; ?>" name="alevel_<?php echo $mm; ?>" >
                                        <?php
                                            for($ii = 1 ; $ii <= 2 ; $ii++) {
                                                echo "<option value='".$ii."' >" . $ii . "</option>";
                                            }
                                        ?>
    								</select>
    							</div>
    						</div>

                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label">Word Defination</label>
    							<div class="col-sm-6">
    								<input type="text" class="form-control" id="adefination_<?php echo $mm; ?>" name="adefination_<?php echo $mm; ?>" value="" placeholder="Word Defination" />
    							</div>
    						</div>

                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label">Example</label>
    							<div class="col-sm-6">
    								<textarea class="form-control" id="aexample_<?php echo $mm; ?>" name="aexample_<?php echo $mm; ?>" placeholder="Example" ></textarea>
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
            					    <input type="hidden" class="form-control" name="language_a_id_<?php echo $mm; ?>[]" value="<?php echo $val->id; ?>" />
            						<input type="text" class="form-control atranslate_<?php echo $mm; ?>" name="language_a_trans_<?php echo $mm; ?>[]" value="" />
            					</div>
                            <?php
                                }
                            ?>
                            </div>
                            </div>

                            <div class="form-group" style='display:none;'>
    							<label for="first_name" class="col-sm-4 control-label">Hindi Translation</label>
    							<div class="col-sm-6">
    								<input type="text" class="form-control" id="ahindi_translation_<?php echo $mm; ?>" name="ahindi_translation_<?php echo $mm; ?>" value="" placeholder="Hindi Translation" />
    							</div>
    						</div>

                            <div class="form-group" style='display:none;'>
    							<label for="first_name" class="col-sm-4 control-label">Marathi Translation</label>
    							<div class="col-sm-6">
    								<input type="text" class="form-control" id="amarathi_translation_<?php echo $mm; ?>" name="amarathi_translation_<?php echo $mm; ?>" value="" placeholder="Marathi Translation" />
    							</div>
    						</div>

                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label">Image</label>
    							<div class="col-sm-6">
    								<input type="file" class="form-control" id="aimage_<?php echo $mm; ?>" name="aimage_<?php echo $mm; ?>" value=""/>
    							</div>
    						</div>

                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label">Audio</label>
    							<div class="col-sm-6">
    								<input type="file" class="form-control" id="aaudio_<?php echo $mm; ?>" name="aaudio_<?php echo $mm; ?>" value=""/>
    							</div>
    						</div>
                            </div>
                        <?php
                            }
                        ?>
                        </div>
                        <input type='hidden' name='count_word' id='count_word' value='<?php echo $wordcount; ?>' />
                        <br /><br />
                        <button type="button" class="btn ruhe-btn-default-submit1 pull-left" onclick='addanotherword();' >ADD</button>
					    <button type="submit" class="btn btn-primary pull-right" id="addsubmit" name="addsubmit">Submit</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url(); ?>">Cancel</a>

                     </form>
        </div>
    </div>
</div>

<script>
    var next_num = <?php echo $wordcount; ?>;

    function addanotherword() {
        var divtxt = "<div style='margin-top: 5px;padding:5px; background-color: #EAEAFF;' class='wordset_"+next_num+"'>" + $( ".wordset_0" ).clone().html() + "</div>";
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
        $("#ahindi_translation_"+next_num).val("");
        $("#amarathi_translation_"+next_num).val("");
        $(".atranslate_"+next_num).val("");
        $("#alevel_"+next_num).val(1);

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
</script>