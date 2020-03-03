<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Edit question template</h2>
            <form class='form-horizontal' role="form" action="<?php echo site_url('admin/editquestiontemplate/' . $question_template->id );?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">
                <div class="form-group">
	                <label for="first_name" class="col-sm-4 control-label">Name *</label>
            		<div class="col-sm-6">
		                <input type="text" class="form-control" id="name" name="name" value="<?php echo $question_template->name; ?>" placeholder="Question Template" required />
            		</div>
            	</div>

                <div class="form-group ftemplate ">
	                <label for="display_name" class="col-sm-4 control-label">Image</label>
            		<div class="col-sm-6">
		                <input type="file" class="form-control" id="image" name="image" placeholder="Question image" value="" />
                        <?php
                            if(@$question_template->image != '') {
                                echo "<br /><small><em>Upload a new image to replace the existing image only else leave it blank</em></small></label><br />
                                <b>Existing Image</b><br />
                                <img src='".base_url("questiontemplate/" . @$question_template->image)."' width='100px' />";
                            }
                        ?>
            		</div>
            	</div>
                <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Save</button>
            	<a role="button" class="btn  pull-right" href="<?php echo site_url('admin/viewquestiontemplate'); ?>">Cancel</a>
            </form>
        </div>
    </div>
</div>