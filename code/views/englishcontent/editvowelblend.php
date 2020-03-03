<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Edit Vowel blend</h2>

            <form class='form-horizontal' role="form" action="<?php echo site_url('englishcontent/editvowelblend/' . $vowelblend_id);?>" method="post" name="" enctype="multipart/form-data" >

            <div class="form-group">
                    <label for="first_name" class="col-sm-4 control-label grapheme_name ">Vowel *</label>
                    <div class="col-sm-6"><input type="text" class="form-control" id="vowel" name="vowel" value="<?php echo @$vowelblend->vowel; ?>" placeholder="" required /></div>
                </div>

                <div class="form-group">
                    <label for="first_name" class="col-sm-4 control-label grapheme_name ">Combine with *</label>
                    <div class="col-sm-6"><input type="text" class="form-control" id="secondary_letter" name="secondary_letter" value="<?php echo @$vowelblend->secondary_letter; ?>" placeholder="" required /></div>
                </div>

                <div class="form-group">
                    <label for="first_name" class="col-sm-4 control-label grapheme_name ">Level</label>
                    <div class="col-sm-6">
                        <select class="form-control" id="level" name="level" required>
                        <?php
                            for($ii = 1 ; $ii <= 10 ; $ii++) {
                                if(@$vowelblend->level == $ii) {
                                    echo "<option value='".$ii."' selected='selected'>" . $ii . "</option>";
                                } else {
                                    echo "<option value='".$ii."' >" . $ii . "</option>";
                                }
                            }
                        ?>
					    </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="first_name" class="col-sm-4 control-label grapheme_name ">Unit</label>
                    <div class="col-sm-6">
                        <select class="form-control" id="unit" name="unit" required>
                        <?php
                            for($ii = 1 ; $ii <= 12 ; $ii++) {
                                if(@$vowelblend->unit == $ii) {
                                    echo "<option value='".$ii."' selected='selected'>" . $ii . "</option>";
                                } else {
                                    echo "<option value='".$ii."' >" . $ii . "</option>";
                                }
                            }
                        ?>
					    </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="first_name" class="col-sm-4 control-label grapheme_name ">Order Number</label>
                    <div class="col-sm-6"><input type="text" class="form-control" id="order_num" name="order_num" value="<?php echo @$vowelblend->order_num; ?>" placeholder="" /></div>
                </div>

                <?php
                    if($vowelblend->image != '') {
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
								<img src="<?php echo base_url("contentfiles/vowelblend/" . $vowelblend->image); ?>" width='100' />
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
                    if($vowelblend->audio != '') {
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
								<a href="<?php echo base_url("contentfiles/vowelblend/" . $vowelblend->audio); ?>" target='blank' >click here</a>
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
                    <label for="first_name" class="col-sm-4 control-label grapheme_name ">Word</label>
                    <div class="col-sm-6">
                        <select class="form-control" id="wordsegment_id" name="wordsegment_id" >
                        <?php
                            foreach($words as $word) {
                                if($vowelblend->wordsegment_id == $word->id) {
                                    echo "<option value='".$word->id."' selected='selected' >" . $word->word . "</option>";
                                } else {
                                    echo "<option value='".$word->id."' >" . $word->word . "</option>";
                                }
                            }
                        ?>
					    </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Save</button>
				<a role="button" class="btn  pull-right" href="<?php echo site_url('englishcontent/viewvowelblend'); ?>">Cancel</a>

            </form>
        </div>
    </div>
</div>