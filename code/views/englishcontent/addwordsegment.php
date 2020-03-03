<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Wordsegment added successfully.</p>";
                } else if($error == 2) {
                    echo "<br /><p class='alert alert-success' >Some error occured, Please add wordsegment again.</p>";
                }
            ?>
            <br /><br />
            <a type="button" href='<?php echo site_url("englishcontent/viewwordsegment"); ?>' class="btn btn-primary btn-lg col-lg-4 col-md-4 col-sm-11 col-xs-11 " style='margin:5px;'>View all word segment</a>
            <br /><br />

            <h2>Add word segment</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('englishcontent/addwordsegment');?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                       <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Word *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="word" name="word" value="" placeholder="Word" required onchange="return translateword(this);" />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Unit *</label>
							<div class="col-sm-3">
								<select class="form-control" id="unit" name="unit" required>
                                    <?php
                                        for($ii = 1 ; $ii <= 12 ; $ii++) {
                                            echo "<option value='".$ii."' >" . $ii . "</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Level</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="level" name="level" value="" placeholder="Level" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Concept</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="concept" name="concept" value="" placeholder="" />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Status *</label>
							<div class="col-sm-3">
								<select class="form-control" id="status" name="status" required>
                                    <?php
                                        $_status = array("active","inactive");
                                        foreach($_status as $sta) {
                                            echo "<option value='".$sta."' >" . $sta . "</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Image</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="image" name="image" value=""/>
							</div>
						</div>


                        <div style='margin-top: 5px;padding:5px; background-color: #EAEAFF;'>
                        <div class="form-group">
                        <label for="first_name" class="col-sm-12 "><h4>Translation</h4></label>
                        <?php
                            $language = Language::find("all", array(
                                "conditions" => " id != 3 AND id != 4 ",
                                "order" => " name ASC ",
                            ));

                            $mm = 0;
                            foreach($language as $val) {
                        ?>
                            <label for="first_name" class="col-sm-1 control-label"><?php echo $val->name; ?></label>
        					<div class="col-sm-2">
                                <input type="hidden" class="form-control alltranslate" id='word_translation_id_<?php echo $val->id; ?>'  name="word_translation_id[]" value="" />
        					    <input type="hidden" class="form-control" id='language_id_<?php echo $val->id; ?>' name="language_id[]" value="<?php echo $val->id; ?>" />
        						<input type="text" class="form-control alltranslate" id='language_trans_<?php echo $val->id; ?>' name="language_trans[]" value="" />
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
                            $mm = 0;
                            foreach($language as $val) {
                        ?>
                            <label for="first_name" class="col-sm-1 control-label"><?php echo $val->name; ?></label>
        					<div class="col-sm-2">
                                <input type="hidden" class="form-control alltranslate1" id='word1_translation_id_<?php echo $val->id; ?>'  name="word1_translation_id[]" value="" />
        					    <input type="hidden" class="form-control" id='language1_id_<?php echo $val->id; ?>' name="language1_id[]" value="<?php echo $val->id; ?>" />
        						<input type="text" class="form-control alltranslate1" id='language1_trans_<?php echo $val->id; ?>' name="language1_trans[]" value="" />
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
								<input type="text" class="form-control" id="hindi_translation" name="hindi_translation" value="" placeholder="Hindi Translation" />
							</div>
						</div>

                        <div class="form-group" style='display:none;'>
							<label for="first_name" class="col-sm-4 control-label">Marathi Translation</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="marathi_translation" name="marathi_translation" value="" placeholder="Marathi Translation" />
							</div>
						</div>

                        <div id='graphemeset'>
                        <div class="form-group" id='graphemeset_0'>
							<label for="status" class="col-sm-4 control-label">Grapheme *</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="segment_0" name="segment_0" value="" placeholder="Segment" />
							</div>
							<div class="col-sm-3">
								<select class="form-control" id="grapheme_id_0" name="grapheme_id_0" >
                                    <option value=''></option>
                                    <?php
                                        foreach($graphemes as $val) {
                                            echo "<option value='".$val->id."' >" . $val->grapheme . " [".$val->phoneme."] (".$val->units_id.")</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>
                        </div>
                        <input type='hidden' name='count_grapheme' id='count_grapheme' value='1' />
                        <br />
                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label"><button type="button" class="btn ruhe-btn-default-submit1" onclick='addanothergrapheme();' >ADD</button></label>
                        </div>
                        <br /><br />

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Add Language Blend</label>
							<div class="col-sm-6">
								<input type="checkbox" class="" id="language_blend" name="language_blend" value="1" onclick='return checkboxxx(this);'  />
							</div>
						</div>

                        <div class="form-group lb">
							<label for="first_name" class="col-sm-4 control-label">Primary Segment</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="primary_segment" name="primary_segment" value="" placeholder="" />
							</div>
						</div>
                        <div class="form-group lb">
							<label for="first_name" class="col-sm-4 control-label">Secondary Segment</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="secondary_segment" name="secondary_segment" value="" placeholder="" />
							</div>
                            <br />
						</div>



                        <div class='lb' style='margin-top: 5px;padding:5px; background-color: #C1E0FF;'>
                        <div class="form-group">
                        <label for="first_name" class="col-sm-12 "><h4>Secondary Segment Transliteration</h4></label>
                        <?php
                            $mm = 0;
                            foreach($language as $val) {
                        ?>
                            <label for="first_name" class="col-sm-1 control-label"><?php echo $val->name; ?></label>
        					<div class="col-sm-2">
                                <input type="hidden" class="form-control" id='l_id_<?php echo $val->id; ?>' name="l_id[]" value="<?php echo $val->id; ?>" />
        						<input type="text" class="form-control" id='l_trans_<?php echo $val->id; ?>' name="l_trans[]" value="" />
        					</div>
                        <?php
                            }
                        ?>
                        </div>
                        </div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Double Grapheme / Phoneme</label>
							<div class="col-sm-6">
								<input type="checkbox" class="" id="double_flag" name="double_flag" value="1" />
							</div>
						</div>



                        <br /><br />
					    <button type="submit" class="btn btn-primary pull-right" id="addsubmit" name="addsubmit">Submit</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url(); ?>">Cancel</a>

                     </form>
        </div>
    </div>
</div>

<script>
    var next_num = 1;

    function addanothergrapheme() {
        var divtxt = "<div id='graphemeset_"+next_num+"' class='form-group' >" + $( "#graphemeset_0" ).clone().html() + "</div>";
        divtxt = divtxt.replace(/_0/g, "_" + next_num);
        divtxt = divtxt.replace(/ 0/g, " " + next_num);
        divtxt = divtxt.replace(/\(0/g, "(" + next_num);
        $( divtxt ).appendTo( "#graphemeset" );

        $("#grapheme_id_"+next_num).val("");
        $("#segment_"+next_num).val("");

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
</script>
<style>
.lb {
    display:none;
}


</style>