<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Edit new story page</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('content/editstorypage/' . $storypage_id);?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Story Name: <?php echo $storypage->story->name; ?></label><br />
						</div>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Language: <?php echo $storypage->story->language->name; ?></label>
                            <br /><br />
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Page No. *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="pageno" name="pageno" required value="<?php echo $storypage->pageno; ?>" placeholder="Page No. ( numeric value )" />
							</div>
						</div>

                       <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Content *</label>
							<div class="col-sm-6">
								<textarea class="form-control" id="content" name="content" ><?php echo $storypage->content; ?></textarea>
							</div>
						</div>


                        <?php
                            if($storypage->image != '') {
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
								<img src="<?php echo base_url("story/" . $storypage->image); ?>" width='400px' />
							</div>
						</div>
                        <?php
                            } else {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Image<br /></label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="image" name="image" value=""/>
							</div>
						</div>
                        <?php
                            }
                        ?>

                        <?php
                            if($storypage->audio != '') {
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
								<a href="<?php echo base_url("story/" . $storypage->audio); ?>" target='_blank'>click here</a>
							</div>
						</div>
                        <?php
                            } else {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Audio<br /></label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="audio" name="audio" value=""/>
							</div>
						</div>
                        <?php
                            }
                        ?>

                        <?php
                            if($storypage->audio_map != '') {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Audio Map<br />
                            <small><em>Upload a new audio map to replace the existing audio map only else leave it blank</em></small></label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="audio_map" name="audio_map" value=""/>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Existing Audio Map</label>
                            <div class="col-sm-6">
								<a href="<?php echo base_url("story/" . $storypage->audio_map); ?>" target='_blank'>click here</a>
							</div>
						</div>
                        <?php
                            } else {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Audio Map<br /></label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="audio_map" name="audio_map" value=""/>
							</div>
						</div>
                        <?php
                            }
                        ?>
                        <br /><br />
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Language<br /></label>
							<div class="col-sm-6">
								<?php
                                     foreach($storypage->storypage_language as $sl) {
                                        echo $sl->language->name . "<br /><br />";
                                        echo $sl->content . "<br /><br />";

                                    }
                                ?>
							</div>
						</div>


                        <button type="submit" class="btn btn-primary pull-right" id="addsubmit" name="addsubmit">Save</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('content/story'); ?>">Cancel</a>

                     </form>

        </div>
    </div>
</div>