<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Add new question template </h2>
            <form class='form-horizontal' role="form" action="<?php echo site_url('admin/addquestiontemplate');?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">
                <div class="form-group">
	                <label for="first_name" class="col-sm-4 control-label">Name *</label>
		            <div class="col-sm-6">
		                <input type="text" class="form-control" id="name" name="name" value="" placeholder="Question Template" required />
		            </div>
	            </div>

                <div class="form-group ftemplate all_t t1 t2 t3 t4 t5 t6 t7">
	                <label for="display_name" class="col-sm-4 control-label">Image</label>
		            <div class="col-sm-6">
		                <input type="file" class="form-control" id="image" name="image" placeholder="Template image" value="" />
		            </div>
	            </div>

	            <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Submit</button>
	            <a role="button" class="btn  pull-right" href="<?php echo site_url('site/home'); ?>">Cancel</a>
            </form>
        </div>
    </div>
</div>