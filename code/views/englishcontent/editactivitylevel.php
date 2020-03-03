<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Edit Activity level</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('englishcontent/editactivitylevel/' . $activity_level->id);?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Level *</label>
							<div class="col-sm-6">
                                <select class="form-control" id="level" name="level" required>
                                    <?php
                                        for($ii = 1 ; $ii <= 100 ; $ii++) {
                                            if($activity_level->level == $ii) {
                                                echo "<option value='".$ii."' selected='selected' >" . $ii . "</option>";
                                            } else {
                                                echo "<option value='".$ii."' >" . $ii . "</option>";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group grapheme_only">
							<label for="first_name" class="col-sm-4 control-label">Title *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="title" name="title" value="<?php echo @$activity_level->title; ?>" />
							</div>
						</div>
                       <br />
                        <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Save</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('englishcontent/viewactivitylevel'); ?>">Cancel</a>

                     </form>
        </div>
    </div>
</div>