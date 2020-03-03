<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Edit class</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('admin/editclass/' . $class_id);?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Class *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="name" name="name" value="<?php echo $class->name; ?>" placeholder="Class Name" required />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Status *</label>
							<div class="col-sm-3">
								<select class="form-control" id="status" name="status" required>
                                    <?php
                                        $_status = array("active","inactive");
                                        foreach($_status as $val) {
                                            if($val == $class->status) {
                                                echo "<option value='$val' selected='selected'> $val </option>";
                                            } else {
                                                echo "<option value='$val' > $val </option>";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Save</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('admin/viewclass'); ?>">Cancel</a>

                     </form>
        </div>
    </div>
</div>