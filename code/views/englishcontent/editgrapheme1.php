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
                            $grapheme_index = '';
                            $pword_id = '';

                            if($grapheme->grapheme_word_linkage_primary) {
                                $grapheme_index = @$grapheme->grapheme_word_linkage_primary[0]->grapheme_index;
                                $pword_id = @$grapheme->grapheme_word_linkage_primary[0]->word_id;
                            }
                        ?>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Word *</label>
							<div class="col-sm-6">
                                <select class="form-control" id="word_id" name="word_id" required>
                                    <?php
                                        foreach($words as $word) {
                                            if($word->id == $pword_id) {
                                                echo "<option value='".$word->id."' selected='selected' >" . $word->word . "</option>";
                                            } else {
                                                echo "<option value='".$word->id."' >" . $word->word . "</option>";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_indx">Grapheme Index *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="grapheme_index" name="grapheme_index" value="<?php echo $grapheme_index; ?>" placeholder="Index" required/>
							</div>
						</div>

                        <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Save</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('englishcontent/viewgrapheme'); ?>">Cancel</a>

                     </form>
        </div>
    </div>
</div>

<script>
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