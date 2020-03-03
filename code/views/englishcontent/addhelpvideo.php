<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Add Help video</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('englishcontent/addhelpvideo');?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Title *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="title" name="title" value="" placeholder="" required />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Description </label>
							<div class="col-sm-6">
								<textarea class="form-control" id="description" name="description" ></textarea>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Link *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="link" name="link" value="" placeholder="" required />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Category</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="category" name="category" value="" placeholder=""  />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Level</label>
							<div class="col-sm-3">
								<select class="form-control" id="level" name="level">
                                    <?php
                                        for($ii = 1 ; $ii <= 100 ; $ii++) {
                                            echo "<option value='".$ii."' >" . $ii . "</option>";
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
                                            echo "<option value='".$vid."' >" . $vname . "</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Series</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="series" name="series" value="" placeholder=""  />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Age range [Format Num-Num] like 5-9</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="age_range" name="age_range" value="" placeholder=""  />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Premium</label>
							<div class="col-sm-3">
								<select class="form-control" id="is_premium" name="is_premium">
                                    <option value='1' >Yes</option>
                                    <option value='0' >No</option>
								</select>
							</div>
						</div>

                        <br style='clear:both;' />

					    <button type="submit" class="btn btn-primary pull-right" id="addsubmit" name="addsubmit">Submit</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url(); ?>">Cancel</a>
                     </form>
        </div>
    </div>
</div>