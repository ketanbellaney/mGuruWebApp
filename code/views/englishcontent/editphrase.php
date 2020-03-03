<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Edit Phrase</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('englishcontent/editphrase/' . $phrase_id);?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

						<div class="form-group">
							<label for="status" class="col-sm-4 control-label">Type *</label>
							<div class="col-sm-3">
								<select class="form-control" id="type" name="type" required='required' onchange='change_type(this);'>
                                    <?php
                                        $stypes = array("phrase","rhymes");
                                        foreach( $stypes as $vva ) {
                                            if(@$phrase->type == $vva) {
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
							<label for="first_name" class="col-sm-4 control-label phrase_name">Phrase *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="phrase" name="phrase" value="<?php echo @$phrase->phrase; ?>" placeholder="" required />
								<input type="hidden" class="form-control" id="level" name="level" value="" />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Unit *</label>
							<div class="col-sm-3">
								<select class="form-control" id="units_id" name="units_id" required>
                                <?php
                                    for($ii = 1 ; $ii <= 12 ; $ii++) {
                                        if($ii == @$phrase->units_id) {
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
							<label for="status" class="col-sm-4 control-label">Grapheme *</label>
							<div class="col-sm-3">
								<select class="form-control" id="grapheme_id" name="grapheme_id" required>
                                    <option value=''></option>
                                    <?php
                                        foreach($graphemes as $val) {
                                            if($val->id == @$phrase->grapheme_id) {
                                                echo "<option value='".$val->id."' selected='selected' >" . $val->grapheme . "</option>";
                                            } else {
                                                echo "<option value='".$val->id."' >" . $val->grapheme . "</option>";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <?php
                            if($phrase->image != '') {
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
								<img src="<?php echo base_url("contentfiles/phrase/" . $phrase->image); ?>" width='100' />
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
                            if($phrase->audio != '') {
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
								<a href="<?php echo base_url("contentfiles/phrase/" . $phrase->audio); ?>" target='blank' >click here</a>
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
							<label for="first_name" class="col-sm-4 control-label sentence_name "><h4>Sentences</h4></label>
						</div>

                        <?php
                            for($mm = 0 ; $mm < $sentencecount ; $mm++) {

                            $order_number = '';
                            $sentence = '';
                            $aimage = '';
                            $aaudio = '';
                            $aaudio_map = '';
                            $asentence_id = '';

                            if(@$phrase->phrase_sentence_linkage[$mm]) {
                                $order_number = @$phrase->phrase_sentence_linkage[$mm]->order_number;
                                $sentence = @$phrase->phrase_sentence_linkage[$mm]->sentence->sentence;
                                $aimage = @$phrase->phrase_sentence_linkage[$mm]->sentence->image;
                                $aaudio = @$phrase->phrase_sentence_linkage[$mm]->sentence->audio;
                                $aaudio_map = @$phrase->phrase_sentence_linkage[$mm]->sentence->audio_map;
                                $asentence_id = @$phrase->phrase_sentence_linkage[$mm]->sentence_id;
                            }
                        ?>
                            <div style='margin-top: 5px;padding:5px; background-color: #EAEAFF;'>
                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label sentence_name2">Order Number </label>
    							<div class="col-sm-3">
    								<input type="text" class="form-control" id="order_number_<?php echo $mm; ?>" name="order_number_<?php echo $mm; ?>" value="<?php echo $order_number; ?>" placeholder="" />
    								<input type="hidden" class="form-control" id="asentence_id_<?php echo $mm; ?>" name="asentence_id_<?php echo $mm; ?>" value="<?php echo $asentence_id; ?>" />
    							</div>
    						</div>

                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label sentence_name1">Sentence</label>
    							<div class="col-sm-6">
                                <?php
                                    if(@$phrase->type == 'rhymes') {
                                ?>
                                        <textarea class="form-control sentencethis" id="sentence_<?php echo $mm; ?>" name="sentence_<?php echo $mm; ?>" ><?php echo $sentence; ?></textarea>
                                <?php
                                    } else {
                                ?>
                                        <input type="text" class="form-control sentencethis" id="sentence_<?php echo $mm; ?>" name="sentence_<?php echo $mm; ?>" value="<?php echo $sentence; ?>" placeholder=""/>
                                <?php
                                    }
                                ?>
    							</div>
    						</div>

                            <?php
                                if($aimage != '') {
                            ?>
                              <div class="form-group">
      							<label for="first_name" class="col-sm-4 control-label">Image<br />
                                  <small><em>Upload a new image to replace the existing image only else leave it blank</em></small></label>
      							<div class="col-sm-6">
      								<input type="file" class="form-control" id="aimage_<?php echo $mm; ?>" name="aimage_<?php echo $mm; ?>" value=""/>
      							</div>
      						</div>

                              <div class="form-group">
      							<label for="first_name" class="col-sm-4 control-label">Existing Image</label>
                                  <div class="col-sm-6">
      								<img src="<?php echo base_url("contentfiles/sentence/" . $aimage); ?>" width='100' />
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
                                  <small><em>Upload a new audio to replace the existing audio only else leave it blank</em></small></label>
      							  <div class="col-sm-6">
      								    <input type="file" class="form-control" id="aaudio_<?php echo $mm; ?>" name="aaudio_<?php echo $mm; ?>" value=""/>
      							  </div>
      						</div>

                              <div class="form-group">
      							<label for="first_name" class="col-sm-4 control-label">Existing Audio</label>
                                  <div class="col-sm-6">
      								<a href="<?php echo base_url("contentfiles/sentence/" . $aaudio); ?>" target='blank' >click here</a>
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

                                <?php
                                  if($aaudio_map != '') {
                              ?>
                              <div class="form-group">
      							<label for="first_name" class="col-sm-4 control-label">Audio map<br />
                                  <small><em>Upload a new audio map to replace the existing audio map only else leave it blank</em></small></label>
      							  <div class="col-sm-6">
      								    <input type="file" class="form-control" id="aaudio_map_<?php echo $mm; ?>" name="aaudio_map_<?php echo $mm; ?>" value=""/>
      							  </div>
      						</div>

                              <div class="form-group">
      							<label for="first_name" class="col-sm-4 control-label">Existing Audio Map</label>
                                  <div class="col-sm-6">
      								<a href="<?php echo base_url("contentfiles/sentence/" . $aaudio_map); ?>" target='blank' >click here</a>
      							</div>
      						</div>
                              <?php
                                  } else {
                              ?>
                              <div class="form-group">
      							<label for="first_name" class="col-sm-4 control-label">Audio map</label>
      							<div class="col-sm-6">
      								<input type="file" class="form-control" id="aaudio_map_<?php echo $mm; ?>" name="aaudio_map_<?php echo $mm; ?>" value=""/>
      							</div>
      						  </div>
                                <?php
                                  }
                                ?>
                    </div>
                <?php
                    }
                ?>
                <br /><br />
                <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Save</button>
			    <a role="button" class="btn  pull-right" href="<?php echo site_url('englishcontent/viewphrase'); ?>">Cancel</a>
            </form>
        </div>
    </div>
</div>

<script>

    function change_type(dis) {
        if( dis.value == "phrase" ) {
            $(".phrase_name").html("Phrase *");
            $(".sentence_name").html("Sentences");
            $(".sentence_name2").html("Order Number");
            $(".sentence_name1").html("Sentence");

            $('.sentencethis').each(function () {
                var val = $(this).val();
                var textbox = $(document.createElement('input'))
                    .attr('type', "text")
                    .attr('class', $(this).attr('class'))
                    .attr('id', $(this).attr('id'))
                    .attr('name', $(this).attr('name'))
                    .attr('style', $(this).attr('style'));
                textbox.val(val);
                $(this).replaceWith(textbox);
            });

        } else if( dis.value == "rhymes" ) {
            $(".phrase_name").html("Rhymes *");
            $(".sentence_name").html("Pages");
            $(".sentence_name2").html("Page Number");
            $(".sentence_name1").html("Page Content");

            $('.sentencethis').each(function () {
                var val = $(this).val();
                var textbox = $(document.createElement('textarea'))
                    .attr('class', $(this).attr('class'))
                    .attr('id', $(this).attr('id'))
                    .attr('name', $(this).attr('name'))
                    .attr('style', $(this).attr('style'));
                textbox.val(val);
                $(this).replaceWith(textbox);
            });
        } else {
            $(".phrase_name").html("Phrase *");
            $(".sentence_name").html("Sentences");
            $(".sentence_name2").html("Order Number");
            $(".sentence_name1").html("Sentence");

            $('.sentencethis').each(function () {
                var val = $(this).val();
                var textbox = $(document.createElement('input'))
                    .attr('type', "text")
                    .attr('class', $(this).attr('class'))
                    .attr('id', $(this).attr('id'))
                    .attr('name', $(this).attr('name'))
                    .attr('style', $(this).attr('style'));
                textbox.val(val);
                $(this).replaceWith(textbox);
            });
        }
    }

    function func1() {
        change_type(document.getElementById('type'))
    }

    window.onload=func1;
</script>