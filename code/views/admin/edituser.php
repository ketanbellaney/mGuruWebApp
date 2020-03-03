<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Edit user</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('admin/edituser/' . $user_id);?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                        <div class="form-group">
							<label for="title" class="col-sm-4 control-label">Title</label>
							<div class="col-sm-3">
								<select class="form-control" id="title" name="title" autofocus >
                                    <?php
                                        $_title = array('Mr','Ms','Mrs','Dr','Prof');

                                        foreach($_title as $val) {
                                            if($val == @$user1->profile->title) {
                                                echo "<option value='$val' selected='selected' >$val</option>";
                                            } else {
                                                echo "<option value='$val' >$val</option>  ";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">First Name *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user1->profile->first_name; ?>" placeholder="First Name" required />
							</div>
						</div>


						<div class="form-group">
							<label for="last_name" class="col-sm-4 control-label">Last Name *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="<?php echo $user1->profile->last_name; ?>" required />
							</div>
						</div>

                        <div class="form-group">
							<label for="display_name" class="col-sm-4 control-label">Display Name </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="display_name" name="display_name" placeholder="Display Name" value="<?php echo $user1->profile->display_name; ?>" />
							</div>
						</div>

                        <div class="form-group">
							<label for="email" class="col-sm-4 control-label">Email</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $user1->email; ?>" />
							</div>
						</div>

                        <div class="form-group">
							<label for="email" class="col-sm-4 control-label">Username *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $user1->username; ?>" required />
							</div>
						</div>


                        <div class="form-group">
							<label for="mobile" class="col-sm-4 control-label">Mobile</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile" value="<?php echo $user1->mobile; ?>" />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Status *</label>
							<div class="col-sm-3">
								<select class="form-control" id="status" name="status" required>
                                    <?php
                                        $_status = array("active","inactive",'disabled');
                                        foreach($_status as $val) {
                                            if($val == $user1->status) {
                                                echo "<option value='$val' selected='selected'> $val </option>";
                                            } else {
                                                echo "<option value='$val' > $val </option>";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="date_of_birth" class="col-sm-4 control-label">Date of Birth</label>
							<div class="col-sm-6">
                                <?php
                                    $dob1 = '';
                                    $dob = '';
                                    if($user1->profile->date_of_birth) {
                                        $dob1 = $user1->profile->date_of_birth->format("d/m/Y");
                                        $dob = $user1->profile->date_of_birth->format("Y-m-d");
                                    }
                                ?>
                                <input type="text" class="form-control" id="date_of_birth1" name="date_of_birth1" placeholder="Date of Birth" value="<?php echo $dob1; ?>" readonly='readonly' />
								<input type="hidden" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="Date of Birth" value="<?php echo $dob; ?>" readonly='readonly' />
							</div>
						</div>

                        <div class="form-group">
							<label for="school_name" class="col-sm-4 control-label">School name</label>
							<div class="col-sm-6">
                                <?php
                                    $school_name = '';
                                    if($user1->profile->school) {
                                        $school_name = $user1->profile->school->name;
                                    }
                                ?>
								<input type="text" class="form-control" id="school_name" name="school_name" placeholder="School name" value="<?php echo $school_name; ?>" />
							</div>
						</div>
                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Examination Board </label>
							<div class="col-sm-3">
                                <?php
                                    $ebstatus = 0;
                                    $_eb = array("ISCE","CBSE","IGCSE","SSC","other");
                                    foreach( $_eb as $val ) {
                                        if($val == $user1->profile->examination_board || $user1->profile->examination_board == '') {
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
                                <input type="text" class="form-control" id="examination_board" name="examination_board" placeholder="Examination Board" value="<?php echo $user1->profile->examination_board; ?>" />
                                <?php
                                    }
                                ?>
							</div>
						</div>

                        <div class="form-group">
							<label for="teacher_name" class="col-sm-4 control-label">Teacher name</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="teacher_name" name="teacher_name" placeholder="Teacher name" value="<?php echo $user1->profile->teacher_name; ?>" />
							</div>
						</div>

                        <div class="form-group">
							<label for="father_name" class="col-sm-4 control-label">Father name</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="father_name" name="father_name" placeholder="Father name" value="<?php echo $user1->profile->father_name; ?>" />
							</div>
						</div>

                        <div class="form-group">
							<label for="mother_name" class="col-sm-4 control-label">Mother name</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="mother_name" name="mother_name" placeholder="Mother name" value="<?php echo $user1->profile->mother_name; ?>" />
							</div>
						</div>

						<div class="form-group">
							<label for="gender" class="col-sm-4 control-label">Gender </label>
							<div class="col-sm-3">
								<select class="form-control" id="gender" name="gender" required>
                                    <?php
                                        $_gender = array("male","female","other");

                                        foreach($_gender as $val) {
                                            if($val == $user1->profile->gender) {
                                                echo "<option value='$val' selected='selected'>$val</option>";
                                            } else {
                                                echo "<option value='$val' >$val</option>";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="current_class" class="col-sm-4 control-label">Current Class </label>
							<div class="col-sm-3">
								<select class="form-control" id="current_class" name="current_class" required >
                                    <?php
                                        $_class = array("JKG","KG",1,2,3,4,5,6,7,8,9,10);

                                        foreach($_class as $val) {
                                            if($val == $user1->profile->current_class) {
                                                echo "<option value='$val' selected='selected'>$val</option>";
                                            } else {
                                                echo "<option value='$val' >$val</option>";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="caste_religion" class="col-sm-4 control-label">Caste / Religion</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="caste_religion" name="caste_religion" placeholder="Caste / Religion" value="<?php echo $user1->profile->caste_religion; ?>" />
							</div>
						</div>

                        <div class="form-group">
							<label for="language_at_home" class="col-sm-4 control-label">Language  at home</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="language_at_home" name="language_at_home" placeholder="Language at home" value="<?php echo $user1->profile->language_at_home; ?>" />
							</div>
						</div>

                        <div class="form-group">
							<label for="address_line_1" class="col-sm-4 control-label">Address line 1</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="address_line_1" name="address_line_1" placeholder="Address line 1" value="<?php echo $user1->profile->address_line_1; ?>" />
							</div>
						</div>

                        <div class="form-group">
							<label for="address_line_2" class="col-sm-4 control-label">Address line 2</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="address_line_2" name="address_line_2" placeholder="Address line 2" value="<?php echo $user1->profile->address_line_2; ?>" />
							</div>
						</div>
                        <div class="form-group">
							<label for="city" class="col-sm-4 control-label">City</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?php echo $user1->profile->city; ?>" />
							</div>
						</div>

                        <div class="form-group">
							<label for="pincode" class="col-sm-4 control-label">Pincode</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode" value="<?php echo $user1->profile->pincode; ?>" />
							</div>
						</div>

                        <div class="form-group">
							<label for="state" class="col-sm-4 control-label">State</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="state" name="state" placeholder="State" value="<?php echo $user1->profile->state; ?>" />
							</div>
						</div>

                        <div class="form-group">
							<label for="country" class="col-sm-4 control-label">Country</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="country" name="country" placeholder="Country" value="<?php echo $user1->profile->country; ?>" />
							</div>
						</div>


					    <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Save</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('admin/viewuser'); ?>">Cancel</a>

                     </form>
        </div>
    </div>
</div>
<script>
    $( "#date_of_birth1" ).datepicker({
        dateFormat: 'dd/mm/yy',
        altField: "#date_of_birth",
        altFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        maxDate: "+0D"
    });


    function changeeb(dis){
        if(dis.value == 'other') {
            dis.parentNode.innerHTML = "<input type='text' class='form-control' id='examination_board' name='examination_board' placeholder='Examination Board' value='' />";
        }
    }
</script>