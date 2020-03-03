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
                                <select class="form-control" id="word_id" name="word_id" required>
                                    <?php
                                        foreach($words as $word) {
                                            echo "<option value='".$word->id."' >" . $word->word . "</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_indx">Grapheme Index *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="grapheme_index" name="grapheme_index" value="" placeholder="Index" required/>
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