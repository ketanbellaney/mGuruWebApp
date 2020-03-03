<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Edit Help video </h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('englishcontent/edithelpvideo/' . $helpvideo_id);?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Title *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="title" name="title" value="<?php echo @$helpvideo->title; ?>" placeholder="" required />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Description </label>
							<div class="col-sm-6">
								<textarea class="form-control" id="description" name="description" ><?php echo @$helpvideo->description; ?></textarea>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Link *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="link" name="link" value="<?php echo @$helpvideo->link; ?>" placeholder="" required />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Category</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="category" name="category" value="<?php echo @$helpvideo->category; ?>" placeholder=""  />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Level</label>
							<div class="col-sm-3">
								<select class="form-control" id="level" name="level">
                                    <?php
                                        for($ii = 1 ; $ii <= 100 ; $ii++) {
                                            if($ii == @$helpvideo->level) {
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
							<label for="status" class="col-sm-4 control-label">Concept</label>
							<div class="col-sm-3">
								<select class="form-control" id="concept_id" name="concept_id">
                                    <option value='' ></option>
                                    <?php
                                        foreach( $concepts as $vid => $vname ) {
                                            if($vid == @$helpvideo->concept_id) {
                                                echo "<option value='".$vid."' selected='selected'>" . $vname . "</option>";
                                            } else {
                                                echo "<option value='".$vid."' >" . $vname . "</option>";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Series</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="series" name="series" value="<?php echo @$helpvideo->series; ?>" placeholder=""  />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Age range [Format Num-Num] like 5-9</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="age_range" name="age_range" value="<?php echo @$helpvideo->age_range; ?>" placeholder=""  />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Premium</label>
							<div class="col-sm-3">
								<select class="form-control" id="is_premium" name="is_premium">
                                    <?php
                                        $iss1 = "";
                                        $iss2 = " selected='selected' ";
                                        if( @$helpvideo->is_premium == 1 ) {
                                            $iss1 = " selected='selected' ";
                                            $iss2 = "";
                                        }
                                    ?>
                                    <option value='1' <?php echo $iss1; ?> >Yes</option>
                                    <option value='0' <?php echo $iss2; ?> >No</option>
								</select>
							</div>
						</div>

                        <br style='clear:both;' />

                        <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Save</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('englishcontent/viewhelpvideo'); ?>">Cancel</a>

                    </form>
        </div>
    </div>
</div>