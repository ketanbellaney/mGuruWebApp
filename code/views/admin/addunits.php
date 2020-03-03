<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Add new units</h2>
            <?php
		        if(@$error == 2) {
			        echo "<p class='alert alert-success'>New units added.</p>";
			    } else {
                    $_status = array("active",'inactive');
            ?>
                    <form class='form-horizontal' role="form" action="<?php echo site_url('admin/addunits');?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                       <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Unit Name *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="name" name="name" value="" placeholder="Unit name" required />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Examination Board </label>
							<div class="col-sm-3">
								<select class="form-control" id="examination_board" name="examination_board" onchange="changeeb(this);">
                                    <option value=''></option>
                                    <?php
                                        $_eb = array("ISCE","CBSE","IGCSE","SSC","other");
                                        foreach($_eb as $val) {
                                            echo "<option value='$val' >$val</option>";
                                        }
                                    ?>
								</select>
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
                                                echo "<option value='".$val->id."'>".$val->name."</option>   ";
                                            }
                                        ?>
                                    </select>
                                </span>
                                <span class='col-lg-3  col-md-3  col-sm-6  col-xs-6' >
                                    <select  class="form-control" name='subject_id'>
                                        <option value=''></option>
                                        <?php
                                            foreach($subjects as $val) {
                                                echo "<option value='".$val->id."'>".$val->name."</option>   ";
                                            }
                                        ?>
                                    </select>
                                </span>
                                <span class='col-lg-3  col-md-3  col-sm-6  col-xs-6' >
                                    <select class="form-control" name="status" >
                                        <option value=''></option>
                                    <?php
                                        foreach($_status as $val) {
                                            echo "<option value='$val' >$val</option>";
                                        }
                                    ?>
								    </select>
                                </span>
                            </div>
						</div>
                        <br />


					    <button type="submit" class="btn btn-primary pull-right" id="addsubmit" name="addsubmit">Submit</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('site/home'); ?>">Cancel</a>

                     </form>
                <?php
                    }
                ?>
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