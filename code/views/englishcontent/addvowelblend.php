<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Add new vowel blend</h2>

            <form class='form-horizontal' role="form" action="<?php echo site_url('englishcontent/addvowelblend');?>" method="post" name="" enctype="multipart/form-data" >

                <div class="form-group">
                    <label for="first_name" class="col-sm-4 control-label grapheme_name ">Vowel *</label>
                    <div class="col-sm-6"><input type="text" class="form-control" id="vowel" name="vowel" value="" placeholder="" required /></div>
                </div>

                <div class="form-group">
                    <label for="first_name" class="col-sm-4 control-label grapheme_name ">Combine with *</label>
                    <div class="col-sm-6"><input type="text" class="form-control" id="secondary_letter" name="secondary_letter" value="" placeholder="" required /></div>
                </div>

                <div class="form-group">
                    <label for="first_name" class="col-sm-4 control-label grapheme_name ">Level</label>
                    <div class="col-sm-6">
                        <select class="form-control" id="level" name="level" required>
                        <?php
                            for($ii = 1 ; $ii <= 10 ; $ii++) {
                                echo "<option value='".$ii."' >" . $ii . "</option>";
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
                                echo "<option value='".$ii."' >" . $ii . "</option>";
                            }
                        ?>
					    </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="first_name" class="col-sm-4 control-label grapheme_name ">Order Number</label>
                    <div class="col-sm-6"><input type="text" class="form-control" id="order_num" name="order_num" value="" placeholder="" /></div>
                </div>

                <div class="form-group">
				    <label for="first_name" class="col-sm-4 control-label">Image</label>
					<div class="col-sm-6"><input type="file" class="form-control" id="image" name="image" value=""/></div>
				</div>

                <div class="form-group">
				    <label for="first_name" class="col-sm-4 control-label">Audio</label>
					<div class="col-sm-6"><input type="file" class="form-control" id="audio" name="audio" value=""/></div>
				</div>

                <div class="form-group">
                    <label for="first_name" class="col-sm-4 control-label grapheme_name ">Word</label>
                    <div class="col-sm-6">
                        <select class="form-control" id="wordsegment_id" name="wordsegment_id" >
                        <?php
                            foreach($words as $word) {
                                echo "<option value='".$word->id."' >" . $word->word . "</option>";
                            }
                        ?>
					    </select>
                    </div>
                </div>

                <br /><br />
                <button type="submit" class="btn btn-primary pull-right" id="addsubmit" name="addsubmit">Save</button>
				<a role="button" class="btn  pull-right" href="<?php echo site_url(); ?>">Cancel</a>

            </form>
        </div>
    </div>
</div>