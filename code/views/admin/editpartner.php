<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Edit Partner</h2>

            <form class='form-horizontal' role="form" action="<?php echo site_url('admin/editpartner/' . $partner_id);?>" method="post" name="" enctype="multipart/form-data">

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Name</label>
							<div class="col-sm-6">
								<?php echo $partner->name; ?>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Limit *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="limit" name="limit" value="<?php echo $partner->limit; ?>" required />
							</div>
						</div>

                        <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Save</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('admin/viewpartner'); ?>">Cancel</a>

                     </form>
        </div>
    </div>
</div>