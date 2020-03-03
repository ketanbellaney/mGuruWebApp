<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Edit Unit</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('admin/editunits/' . $unit_id);?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Unit *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="name" name="name" value="<?php echo $units->name; ?>" placeholder="Unit Name" required />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Examination Board </label>
							<div class="col-sm-3">
                                <?php
                                    $ebstatus = 0;
                                    $_eb = array("ISCE","CBSE","IGCSE","SSC","other");
                                    foreach( $_eb as $val ) {
                                        if($val == $units->examination_board || $units->examination_board == '') {
                                            $ebstatus = 1;
                                        }
                                    }

                                    if($ebstatus == 1) {
                                ?>
								<select class="form-control" id="examination_board" name="examination_board" onchange="changeeb(this);">
                                    <option value=''></option>
                                    <?php

                                        foreach($_eb as $val) {
                                            if($val == $user1->profile->examination_board ) {
                                                echo "<option value='$val' selected='selected'>$val</option>";
                                            } else {
                                                echo "<option value='$val' >$val</option>";
                                            }
                                        }
                                    ?>
								</select>
                                <?php
                                    } else {
                                ?>
                                <input type="text" class="form-control" id="examination_board" name="examination_board" placeholder="Examination Board" value="<?php echo $units->examination_board; ?>" />
                                <?php
                                    }
                                ?>
							</div>
						</div>

                        <div class='col-lg-12  col-md-12 col-sm-12  col-xs-12'>
                            <span class='form-group col-lg-3  col-md-3  col-sm-6  col-xs-6 text-center' >
                                <label for="status" class="control-label">Class</label>
                            </span>
						    <span class='form-group col-lg-3  col-md-3  col-sm-6  col-xs-6 text-center' >
                                <label for="status" class="control-label">Subject</label>
                            </span>
                            <span class='form-group col-lg-3  col-md-3  col-sm-6  col-xs-6 text-center' >
                                <label for="status" class="control-label">Status</label>
                            </span>
						</div>
                        <div id='classes_div' >
						    <div class='form-group'  class='col-lg-12  col-md-12 col-sm-12  col-xs-12'>
                                <span class='col-lg-3  col-md-3  col-sm-6  col-xs-6' >
                                    <select  class="form-control" name='classes_id'>
                                        <option value=''></option>
                                        <?php
                                            foreach($classes as $val) {
                                                if($units->classes_id == $val->id) {
                                                    echo "<option value='".$val->id."' selected='selected'>".$val->name."</option>   ";
                                                } else {
                                                    echo "<option value='".$val->id."'>".$val->name."</option>   ";
                                                }
                                            }
                                        ?>
                                    </select>
                                </span>
                                <span class='col-lg-3  col-md-3  col-sm-6  col-xs-6' >
                                    <select  class="form-control" name='subject_id'>
                                        <option value=''></option>
                                        <?php
                                            foreach($subjects as $val) {
                                                if($units->subject_id == $val->id) {
                                                    echo "<option value='".$val->id."' selected='selected'>".$val->name."</option>   ";
                                                } else {
                                                    echo "<option value='".$val->id."'>".$val->name."</option>   ";
                                                }
                                            }
                                        ?>
                                    </select>
                                </span>
                                <span class='col-lg-3  col-md-3  col-sm-6  col-xs-6' >
                                    <select class="form-control" name="status" >
                                        <option value=''></option>
                                    <?php
                                         $_status = array("active",'inactive');
                                        foreach($_status as $val) {
                                            if($units->status == $val) {
                                                echo "<option value='$val'  selected='selected'>$val</option>";
                                            } else {
                                                echo "<option value='$val' >$val</option>";
                                            }
                                        }
                                    ?>
								    </select>
                                </span>
                            </div>
						</div>
                        <br />



                        <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Save</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('admin/viewunits'); ?>">Cancel</a>

                     </form>
        </div>
    </div>
</div>
<script>
    function changeeb(dis){
        if(dis.value == 'other') {
            dis.parentNode.innerHTML = "<input type='text' class='form-control' id='examination_board' name='examination_board' placeholder='Examination Board' value='' />";
        }
    }
</script>