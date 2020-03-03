<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Add new concept</h2>
            <?php
		        if(@$error == 2) {
			        echo "<p class='alert alert-success'>New concept added.</p>";
			    } else {
                    $_status = array("active",'inactive');
            ?>
                    <form class='form-horizontal' role="form" action="<?php echo site_url('admin/addconcept?for=' . @$_REQUEST['for']);?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                       <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Concept Name *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="name" name="name" value="" placeholder="Concept name" required />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Unit *</label>
							<div class="col-sm-6">
                                <select  class="form-control" name='units_id'>
                                    <option value=''></option>
                                    <?php
                                        if(@$_REQUEST['for'] == "grammar") {
                                            foreach($units as $val) {
                                                if($val->subject_id == 2) {
                                                    echo "<option value='".$val->id."'>".$val->classes->name." - ".$val->subject->name." - ".$val->name."</option>   ";
                                                }
                                            }
                                        } else {
                                            foreach($units as $val) {
                                                echo "<option value='".$val->id."'>".$val->classes->name." - ".$val->subject->name." - ".$val->name."</option>   ";
                                            }
                                        }
                                    ?>
                                </select>
							</div>
						</div>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Previous concept</label>
							<div class="col-sm-6">
                                <select  class="form-control" name='previous_concept_id'>
                                    <option value=''></option>
                                    <?php
                                        if(@$_REQUEST['for'] == "grammar") {
                                            foreach($concepts as $val) {
                                                if($val->units->subject_id == 2) {
                                                    echo "<option value='".$val->id."'>".$val->units->classes->name." - ".$val->units->subject->name." - ".$val->units->name." - " . $val->name."</option>   ";
                                                }
                                            }
                                        } else {
                                            foreach($concepts as $val) {
                                                echo "<option value='".$val->id."'>".$val->units->classes->name." - ".$val->units->subject->name." - ".$val->units->name." - " . $val->name."</option>   ";
                                            }
                                        }
                                    ?>
                                </select>
							</div>
						</div>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Next concept</label>
							<div class="col-sm-6">
                                <select  class="form-control" name='next_concept_id'>
                                    <option value=''></option>
                                    <?php
                                        if(@$_REQUEST['for'] == "grammar") {
                                            foreach($concepts as $val) {
                                                if($val->units->subject_id == 2) {
                                                    echo "<option value='".$val->id."'>".$val->units->classes->name." - ".$val->units->subject->name." - ".$val->units->name." - " . $val->name."</option>   ";
                                                }
                                            }
                                        } else {
                                            foreach($concepts as $val) {
                                                echo "<option value='".$val->id."'>".$val->units->classes->name." - ".$val->units->subject->name." - ".$val->units->name." - " . $val->name."</option>   ";
                                            }
                                        }
                                    ?>
                                </select>
							</div>
						</div>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Lower concept</label>
							<div class="col-sm-6">
                                <select  class="form-control" name='lower_concept_id'>
                                    <option value=''></option>
                                    <?php
                                        if(@$_REQUEST['for'] == "grammar") {
                                            foreach($concepts as $val) {
                                                if($val->units->subject_id == 2) {
                                                    echo "<option value='".$val->id."'>".$val->units->classes->name." - ".$val->units->subject->name." - ".$val->units->name." - " . $val->name."</option>   ";
                                                }
                                            }
                                        } else {
                                            foreach($concepts as $val) {
                                                echo "<option value='".$val->id."'>".$val->units->classes->name." - ".$val->units->subject->name." - ".$val->units->name." - " . $val->name."</option>   ";
                                            }
                                        }
                                    ?>
                                </select>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Higher concept</label>
							<div class="col-sm-6">
                                <select  class="form-control" name='higher_concept_id'>
                                    <option value=''></option>
                                    <?php
                                        if(@$_REQUEST['for'] == "grammar") {
                                            foreach($concepts as $val) {
                                                if($val->units->subject_id == 2) {
                                                    echo "<option value='".$val->id."'>".$val->units->classes->name." - ".$val->units->subject->name." - ".$val->units->name." - " . $val->name."</option>   ";
                                                }
                                            }
                                        } else {
                                            foreach($concepts as $val) {
                                                echo "<option value='".$val->id."'>".$val->units->classes->name." - ".$val->units->subject->name." - ".$val->units->name." - " . $val->name."</option>   ";
                                            }
                                        }
                                    ?>
                                </select>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Status</label>
							<div class="col-sm-6">
                                <select class="form-control" name="status" >
                                    <option value=''></option>
                                    <?php
                                        foreach($_status as $val) {
                                            echo "<option value='$val' >$val</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <button type="submit" class="btn btn-primary pull-right" id="addsubmit" name="addsubmit">Submit</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('site/home'); ?>">Cancel</a>

                     </form>
                <?php
                    }
                ?>
        </div>
    </div>
</div>