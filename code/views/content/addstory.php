<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Add new story</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('content/addstory');?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                       <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Story Name *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="name" name="name" value="" placeholder="Name" required />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Written by</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="writtenby" name="writtenby" value="" placeholder="Written by" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Illustrations by</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="illustrationsby" name="illustrationsby" value="" placeholder="Illustrations by" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Translation by</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="translationby" name="translationby" value="" placeholder="Translation by" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Source</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="source" name="source" value="" placeholder="Source" />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Language</label>
							<div class="col-sm-3">
								<select class="form-control" id="language_id" name="language_id" required>
                                    <?php
                                        foreach($language as $val) {
                                            echo "<option value='".$val->id."' >".$val->name."</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Level *</label>
							<div class="col-sm-3">
                                <input type="text" class="form-control" id="level" name="level" value="" placeholder="Story level" required />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Cover Image</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="image" name="image" value=""/>
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Status *</label>
							<div class="col-sm-3">
								<select class="form-control" id="status" name="status" required>
                                    <?php
                                        $_status = array("active",'inactive');
                                        foreach($_status as $val) {
                                            echo "<option value='$val' >$val</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

					    <button type="submit" class="btn btn-primary pull-right" id="addsubmit" name="addsubmit">Submit</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('content/story'); ?>">Cancel</a>

                     </form>

        </div>
    </div>
</div>