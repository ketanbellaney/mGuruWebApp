<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Add new story page</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('content/addstorypage/' . $story_id);?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Story Name: <?php echo $story->name; ?></label><br />
						</div>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Language: <?php echo $story->language->name; ?></label>
                            <br /><br />
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Page No. *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="pageno" name="pageno" required value="" placeholder="Page No. ( numeric value )" />
							</div>
						</div>

                       <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Content *</label>
							<div class="col-sm-6">
								<textarea class="form-control" id="content" name="content" ></textarea>
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
							<label for="first_name" class="col-sm-4 control-label">Audio Map</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="audio_map" name="audio_map" value=""/>
							</div>
						</div>

                        <button type="submit" class="btn btn-primary pull-right" id="addsubmit" name="addsubmit">Submit</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('content/story'); ?>">Cancel</a>

                     </form>

        </div>
    </div>
</div>