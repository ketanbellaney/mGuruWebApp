<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Edit word segment</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('englishcontent/editwordsegment/' . $wordsegment_id);?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">


                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Word *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="word" name="word" value="<?php echo $wordsegment->word; ?>" placeholder="Word" required onchange="return translateword(this);" />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Unit *</label>
							<div class="col-sm-3">
								<select class="form-control" id="unit" name="unit" required>
                                    <?php
                                        for($ii = 1 ; $ii <= 12 ; $ii++) {
                                            if(@$wordsegment->unit == $ii) {
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
							<label for="first_name" class="col-sm-4 control-label">Level</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="level" name="level" value="<?php echo @$wordsegment->level; ?>" placeholder="Level" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Concept</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="concept" name="concept" value="<?php echo @$wordsegment->concept; ?>" placeholder="" />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Status *</label>
							<div class="col-sm-3">
								<select class="form-control" id="status" name="status" required>
                                    <?php
                                        $_status = array("active","inactive");
                                        foreach($_status as $sta) {
                                            if(@$wordsegment->status == $sta) {
                                                echo "<option value='".$sta."'  selected='selected' >" . $sta . "</option>";
                                            } else {
                                                echo "<option value='".$sta."' >" . $sta . "</option>";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>

                         <?php
                            if($wordsegment->image != '') {
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
								<img src="<?php echo base_url("contentfiles/word/" . $wordsegment->image); ?>" width='100' />
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


                        <div style='margin-top: 5px;padding:5px; background-color: #EAEAFF;'>
                        <div class="form-group">
                        <label for="first_name" class="col-sm-12 "><h4>Translation</h4></label>
                        <?php
                            $language = Language::find("all", array(
                                "conditions" => " id != 3 AND id != 4 ",
                                "order" => " name ASC ",
                            ));

                            $trans = array();
                            $trans1 = array();
                            $www = Word::find_by_word(trim($wordsegment->word));

                            if(isset($www->id)) {
                                foreach($www->word_translation as $val) {
                                    $trans[$val->language_id] =  $val->translation;
                                    $trans1[$val->language_id] =  $val->id;
                                }
                            }

                            $mm = 0;
                            foreach($language as $val) {
                        ?>
                            <label for="first_name" class="col-sm-1 control-label"><?php echo $val->name; ?></label>
        					<div class="col-sm-2">
                                <input type="hidden" class="form-control alltranslate" id='word_translation_id_<?php echo $val->id; ?>'  name="word_translation_id[]" value="<?php echo @$trans1[$val->id]; ?>" />
    						    <input type="hidden" class="form-control" id='language_id_<?php echo $val->id; ?>'  name="language_id[]" value="<?php echo $val->id; ?>" />
    						    <input type="text" class="form-control alltranslate" id='language_trans_<?php echo $val->id; ?>' name="language_trans[]" value="<?php echo @$trans[$val->id]; ?>" />
        					</div>
                        <?php
                            }
                        ?>
                        </div>
                        </div>
                        <br />



                        <div style='margin-top: 5px;padding:5px; background-color: #C1E0FF;'>
                        <div class="form-group">
                        <label for="first_name" class="col-sm-12 "><h4>Transliteration</h4></label>
                        <?php

                            $trans = array();
                            $trans1 = array();

                            if(isset($www->id)) {
                                foreach($www->word_transliteration as $val) {
                                    $trans[$val->language_id] =  $val->translation;
                                    $trans1[$val->language_id] =  $val->id;
                                }
                            }

                            $mm = 0;
                            foreach($language as $val) {
                        ?>
                            <label for="first_name" class="col-sm-1 control-label"><?php echo $val->name; ?></label>
        					<div class="col-sm-2">
                                <input type="hidden" class="form-control alltranslate1" id='word1_translation_id_<?php echo $val->id; ?>'  name="word1_translation_id[]" value="<?php echo @$trans1[$val->id]; ?>" />
    						    <input type="hidden" class="form-control" id='language1_id_<?php echo $val->id; ?>'  name="language1_id[]" value="<?php echo $val->id; ?>" />
    						    <input type="text" class="form-control alltranslate1" id='language1_trans_<?php echo $val->id; ?>' name="language1_trans[]" value="<?php echo @$trans[$val->id]; ?>" />
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
								<input type="text" class="form-control" id="hindi_translation" name="hindi_translation" value="<?php echo @$wordsegment->hindi_translation; ?>" placeholder="Hindi Translation" />
							</div>
						</div>

                        <div class="form-group" style='display:none;'>
							<label for="first_name" class="col-sm-4 control-label">Marathi Translation</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="marathi_translation" name="marathi_translation" value="<?php echo @$wordsegment->marathi_translation; ?>" placeholder="Marathi Translation" />
							</div>
						</div>

                        <?php
                            $count = 1;
                            if(count($wordsegment->graphemes) >= 1) {
                                $count = count($wordsegment->graphemes);
                            }
                        ?>

                        <div id='graphemeset'>

                        <?php
                            for($mm = 0 ; $mm < $count ; $mm++) {
                        ?>
                        <div class="form-group" id='graphemeset_<?php echo $mm; ?>'>
							<label for="status" class="col-sm-4 control-label">Grapheme *</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="segment_<?php echo $mm; ?>" name="segment_<?php echo $mm; ?>" value="<?php echo @$wordsegment->graphemes[$mm]->segment; ?>" placeholder="Segment" />
							</div>
							<div class="col-sm-3">
                                <input type='hidden' name='gwsl_id_<?php echo $mm; ?>' id='gwsl_id_<?php echo $mm; ?>' value="<?php echo @$wordsegment->graphemes[$mm]->id; ?>" />
								<select class="form-control" id="grapheme_id_<?php echo $mm; ?>" name="grapheme_id_<?php echo $mm; ?>" >
                                    <option value=''></option>
                                    <?php
                                        foreach($graphemes as $val) {
                                            if(@$wordsegment->graphemes[$mm]->grapheme_id == $val->id) {
                                                echo "<option value='".$val->id."' selected='selected' >" . $val->grapheme . " [".$val->phoneme."] (".$val->units_id.")</option>";
                                            } else {
                                                echo "<option value='".$val->id."' >" . $val->grapheme . " [".$val->phoneme."] (".$val->units_id.")</option>";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>
                        <?php
                            }
                        ?>
                        </div>
                        <input type='hidden' name='count_grapheme' id='count_grapheme' value='<?php echo $count; ?>' />
                        <br />
                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label"><button type="button" class="btn " onclick='addanothergrapheme();' >ADD</button></label>
                        </div>

                        <br /><br />

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Add Language Blend</label>
							<div class="col-sm-6">
								<input type="checkbox" class="" id="language_blend" name="language_blend" value="1" onclick='return checkboxxx(this);' <?php if($wordsegment->primary_segment != '') echo " checked='checked' "; ?> />
							</div>
						</div>

                        <div class="form-group lb">
							<label for="first_name" class="col-sm-4 control-label">Primary Segment</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="primary_segment" name="primary_segment" value="<?php echo $wordsegment->primary_segment; ?>" placeholder="" />
							</div>
						</div>
                        <div class="form-group lb">
							<label for="first_name" class="col-sm-4 control-label">Secondary Segment</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="secondary_segment" name="secondary_segment" value="<?php echo $wordsegment->secondary_segment; ?>" placeholder="" />
							</div>
                            <br />
						</div>



                        <div class='lb' style='margin-top: 5px;padding:5px; background-color: #C1E0FF;'>
                        <div class="form-group">
                        <label for="first_name" class="col-sm-12 "><h4>Secondary Segment Transliteration</h4></label>
                        <?php
                            $mm = 0;

                            $trans = array();
                            $trans1 = array();

                            foreach($wordsegment->language_blend as $val) {
                                $trans[$val->language_id] =  $val->translation;
                                $trans1[$val->language_id] =  $val->id;
                            }

                            foreach($language as $val) {
                        ?>
                            <label for="first_name" class="col-sm-1 control-label"><?php echo $val->name; ?></label>
        					<div class="col-sm-2">
                                <input type="hidden" class="form-control" id='lb_id_<?php echo $val->id; ?>'  name="lb_id[]" value="<?php echo @$trans1[$val->id]; ?>" />
                                <input type="hidden" class="form-control" id='l_id_<?php echo $val->id; ?>' name="l_id[]" value="<?php echo $val->id; ?>" />
        						<input type="text" class="form-control" id='l_trans_<?php echo $val->id; ?>' name="l_trans[]" value="<?php echo @$trans[$val->id]; ?>" />
        					</div>
                        <?php
                            }
                        ?>
                        </div>
                        </div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Double Grapheme / Phoneme</label>
							<div class="col-sm-6">
								<input type="checkbox" class="" id="double_flag" name="double_flag" value="1" <?php if($wordsegment->double_flag == 1) echo " checked='checked' "; ?> />
							</div>
						</div>


                        <br /><br />
                        <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Save</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('englishcontent/viewwordsegment'); ?>">Cancel</a>

                     </form>
        </div>
    </div>
</div>

<script>
    var next_num = <?php echo $count; ?>;

    function addanothergrapheme() {
        var divtxt = "<div id='graphemeset_"+next_num+"' class='form-group' >" + $( "#graphemeset_0" ).clone().html() + "</div>";
        divtxt = divtxt.replace(/_0/g, "_" + next_num);
        divtxt = divtxt.replace(/ 0/g, " " + next_num);
        divtxt = divtxt.replace(/\(0/g, "(" + next_num);
        $( divtxt ).appendTo( "#graphemeset" );

        $("#grapheme_id_"+next_num).val("");
        $("#segment_"+next_num).val("");
        $("#gwsl_id_"+next_num).val("");

        next_num++;

        $("#count_grapheme").val(next_num);
    }


    function translateword(dis) {
        var wordd = dis.value;
        $(".alltranslate").val('');
        $(".alltranslate1").val('');
        if(wordd != '') {
            $.post("<?php echo site_url("englishcontent/getwordtranslated"); ?>", { word: wordd },  function( data ) {
                if(data != "") {
                    var data1 = data.split(":::");

                    for(var ii = 0 ; ii < data1.length ; ii++) {
                        data2 = data1.split(";;;");
                        if(data2[1]) {
                            $("#language_trans_" + data2[0]).val(data2[1]);
                            $("#word_translation_id_" + data2[0]).val(data2[2]);
                        }
                    }
                }
            });

            $.post("<?php echo site_url("englishcontent/getwordtranslated1"); ?>", { word: wordd },  function( data ) {
                if(data != "") {
                    var data1 = data.split(":::");

                    for(var ii = 0 ; ii < data1.length ; ii++) {
                        data2 = data1.split(";;;");
                        if(data2[1]) {
                            $("#language1_trans_" + data2[0]).val(data2[1]);
                            $("#word1_translation_id_" + data2[0]).val(data2[2]);
                        }
                    }
                }
            });
        }
    }

    function checkboxxx(dis) {
        if(dis.checked) {
            $(".lb").css("display","block");
        } else {
            $(".lb").css("display","none");
        }
    }

    function func1() {
        checkboxxx(document.getElementById('language_blend'))
    }

    window.onload=func1;
</script>
<style>
.lb {
    display:none;
}


</style>