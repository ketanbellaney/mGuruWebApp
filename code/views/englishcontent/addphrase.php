<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Add new phrase</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('englishcontent/addphrase');?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Type *</label>
							<div class="col-sm-3">
								<select class="form-control" id="type" name="type" required='required' onchange='change_type(this);'>
                                    <?php
                                        $stypes = array("phrase","rhymes");
                                        foreach( $stypes as $vva ) {
                                            echo "<option value='".$vva."' >" . $vva . "</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>
                       <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label phrase_name">Phrase *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="phrase" name="phrase" value="" placeholder="" required />
								<input type="hidden" class="form-control" id="level" name="level" value="" />
							</div>
						</div>

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
							<label for="status" class="col-sm-4 control-label">Grapheme *</label>
							<div class="col-sm-3">
								<select class="form-control" id="grapheme_id" name="grapheme_id" required>
                                    <option value=''></option>
                                    <?php
                                        foreach($graphemes as $val) {
                                            echo "<option value='".$val->id."' >" . $val->grapheme . "</option>";
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

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Audio</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="audio" name="audio" value=""/>
							</div>
						</div>

                        <div class="form-group">
                            <br /><br />
							<label for="first_name" class="col-sm-4 control-label sentence_name "><h4>Sentences</h4></label>
						</div>

                        <?php
                            for($mm = 0 ; $mm < $sentencecount ; $mm++) {
                        ?>
                            <div style='margin-top: 5px;padding:5px; background-color: #EAEAFF;'>
                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label sentence_name2">Order Number </label>
    							<div class="col-sm-3">
    								<input type="text" class="form-control" id="order_number_<?php echo $mm; ?>" name="order_number_<?php echo $mm; ?>" value="<?php echo $mm + 1; ?>" placeholder=""/>
    							</div>
    						</div>

                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label sentence_name1">Sentence</label>
    							<div class="col-sm-6 ">
    								<input type="text" class="form-control sentencethis" id="sentence_<?php echo $mm; ?>" name="sentence_<?php echo $mm; ?>" value="" />
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
                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label">Audio map</label>
    							<div class="col-sm-6">
    								<input type="file" class="form-control" id="aaudio_map_<?php echo $mm; ?>" name="aaudio_map_<?php echo $mm; ?>" value=""/>
    							</div>
    						</div>
                            </div>
                        <?php
                            }
                        ?>

                        <br /><br />
					    <button type="submit" class="btn btn-primary pull-right" id="addsubmit" name="addsubmit">Submit</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url(); ?>">Cancel</a>

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
                $(this).replaceWith(textbox);
                $(this).val(val);
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
                $(this).replaceWith(textbox);
                $(this).val(val);
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
                $(this).replaceWith(textbox);
                $(this).val(val);
            });
        }

    }
</script>