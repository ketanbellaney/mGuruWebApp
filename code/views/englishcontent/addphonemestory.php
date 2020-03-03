<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Add new phoneme story</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('englishcontent/addphonemestory');?>" method="post" name="" enctype="multipart/form-data" >

                       <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Title *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="title" name="title" value="" placeholder="Title" required />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Story *</label>
							<div class="col-sm-6">
                                <textarea name='story' id='story' class="form-control" required rows='6'></textarea>
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Unit *</label>
							<div class="col-sm-3">
								<select class="form-control" id="unit" name="unit" required>
                                    <?php
                                        for($ii = 1 ; $ii <= 12 ; $ii++) {
                                            echo "<option value='".$ii."' >" . $ii . "</option>";
                                        }
                                    ?>
								</select>
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

                        <br /><br />
					    <button type="submit" class="btn btn-primary pull-right" id="addsubmit" name="addsubmit">Submit</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url(); ?>">Cancel</a>

                     </form>
        </div>
    </div>
</div>