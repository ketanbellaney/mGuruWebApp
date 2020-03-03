<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Edit story</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('content/editstory/' . $story_id);?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Story Name *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="name" name="name" placeholder="Name" required value="<?php echo $story->name; ?>" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Written by</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="writtenby" name="writtenby" placeholder="Written by"  value="<?php echo $story->writtenby; ?>" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Illustrations by</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="illustrationsby" name="illustrationsby" placeholder="Illustrations by"  value="<?php echo $story->illustrationsby; ?>" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Translation by</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="translationby" name="translationby" placeholder="Translation by"  value="<?php echo $story->translationby; ?>"  />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Source</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="source" name="source" placeholder="Source"  value="<?php echo $story->source; ?>" />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Language</label>
							<div class="col-sm-3">
								<select class="form-control" id="language_id" name="language_id" required>
                                    <?php
                                        foreach($language as $val) {
                                            if($story->language_id == $val->id) {
                                                echo "<option value='".$val->id."' selected='selected' >".$val->name."</option>";
                                            } else {
                                                echo "<option value='".$val->id."' >".$val->name."</option>";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Level *</label>
							<div class="col-sm-3">
                                <input type="text" class="form-control" id="level" name="level" value="<?php echo @$story->level; ?>" placeholder="Story level" required />
							</div>
						</div>
                        <?php
                            if($story->image != '') {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Cover Image<br />
                            <small><em>Upload a new image to replace the existing image only else leave it blank</em></small></label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="image" name="image" value=""/>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Existing Image</label>
                            <div class="col-sm-6">
								<img src="<?php echo base_url("story/" . $story->image); ?>" width='400px' />
							</div>
						</div>
                        <?php
                            } else {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Cover Image<br /></label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="image" name="image" value=""/>
							</div>
						</div>
                        <?php
                            }
                        ?>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Status *</label>
							<div class="col-sm-3">
								<select class="form-control" id="status" name="status" required>
                                    <?php
                                        $_status = array("active",'inactive');
                                        foreach($_status as $val) {
                                            if($story->status == $val) {
                                                echo "<option value='$val' selected='selected'>$val</option>";
                                            } else {
                                                echo "<option value='$val' >$val</option>";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Save</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('content/story'); ?>">Cancel</a>

                     </form>
        </div>
    </div>
</div>