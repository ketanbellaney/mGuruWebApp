<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Edit Phoneme story</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('englishcontent/editphonemestory/' . $phonemestory_id);?>" method="post" name="" enctype="multipart/form-data" >

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Title *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="title" name="title" value="<?php echo @$phonemestory->title; ?>" placeholder="Title" required />
					   	    </div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Story *</label>
							<div class="col-sm-6">
                                <textarea name='story' id='story' class="form-control" required rows='6'><?php echo @$phonemestory->story; ?></textarea>
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Unit *</label>
							<div class="col-sm-3">
								<select class="form-control" id="unit" name="unit" required>
                                <?php
                                    for($ii = 1 ; $ii <= 12 ; $ii++) {
                                        if($ii == @$phonemestory->unit) {
                                            echo "<option value='".$ii."' selected='selected' >" . $ii . "</option>";
                                        } else {
                                            echo "<option value='".$ii."' >" . $ii . "</option>";
                                        }
                                    }
                                ?>
								</select>
							</div>
						</div>

                        <?php
                            if($phonemestory->image != '') {
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
								<img src="<?php echo base_url("contentfiles/phoneme_story/" . $phonemestory->image); ?>" width='100' />
							</div>
						</div>
                        <?php
                            } else {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Image</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="image" name="image" value=""/>
							</div>
						</div>
                        <?php
                            }
                        ?>

                        <?php
                            if($phonemestory->audio != '') {
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
								<a href="<?php echo base_url("contentfiles/phoneme_story/" . $phonemestory->audio); ?>" target='blank' >click here</a>
							</div>
						</div>
                        <?php
                            } else {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Audio</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="audio" name="audio" value=""/>
							</div>
						</div>
                        <?php
                            }
                        ?>

                        <br /><br />
                        <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Save</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('englishcontent/viewphrase'); ?>">Cancel</a>

                     </form>
        </div>
    </div>
</div>