<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Edit Subject</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('admin/editsubject/' . $subject_id);?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Subject *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="name" name="name" value="<?php echo $subject->name; ?>" placeholder="Subject Name" required />
							</div>
						</div>

                        <div class='form-group'>
							<label for="status" class="col-sm-4 control-label">Class it Belongs to</label>
						</div>

                        <div class='col-lg-12  col-md-12 col-sm-12  col-xs-12'>
						    <span class='form-group col-lg-3  col-md-3  col-sm-6  col-xs-6 text-center' >
                                <label for="status" class="control-label">Class</label>
                            </span>
                            <span class='form-group col-lg-3  col-md-3  col-sm-6  col-xs-6 text-center' >
                                <label for="status" class="control-label">Status</label>
                            </span>
						</div>
                        <div id='classes_div' >
                            <?php
                                $_status = array("active",'inactive');
                                $sta = 0;
                                foreach($subject->class_subject_linkage as $class) {
                                  $sta = 1;
                            ?>
						    <div class='form-group'  class='col-lg-12  col-md-12 col-sm-12  col-xs-12'>
                                <span class='col-lg-3  col-md-3  col-sm-6  col-xs-6' >
                                    <select  class="form-control" name='classes[]'>
                                        <option value=''></option>
                                        <?php
                                            foreach($classes as $val) {
                                                if($class->classes_id == $val->id) {
                                                    echo "<option value='".$val->id."' selected='selected'>".$val->name."</option>   ";
                                                } else {
                                                    echo "<option value='".$val->id."'>".$val->name."</option>   ";
                                                }
                                            }
                                        ?>
                                    </select>
                                </span>
                                <span class='col-lg-3  col-md-3  col-sm-6  col-xs-6' >
                                    <select class="form-control" name="status[]" >
                                        <option value=''></option>
                                    <?php
                                        foreach($_status as $val) {
                                            if($class->status == $val) {
                                                echo "<option value='$val' selected='selected' >$val</option>";
                                            } else {
                                                echo "<option value='$val' >$val</option>";
                                            }
                                        }
                                    ?>
								    </select>
                                </span>
                            </div>
                            <?php
                                }

                                if($sta == 0) {
                            ?>
                            <div class='form-group'  class='col-lg-12  col-md-12 col-sm-12  col-xs-12'>
                                <span class='col-lg-3  col-md-3  col-sm-6  col-xs-6' >
                                    <select  class="form-control" name='classes[]'>
                                        <option value=''></option>
                                        <?php
                                            foreach($classes as $val) {
                                                echo "<option value='".$val->id."'>".$val->name."</option>   ";
                                            }
                                        ?>
                                    </select>
                                </span>
                                <span class='col-lg-3  col-md-3  col-sm-6  col-xs-6' >
                                    <select class="form-control" name="status[]" >
                                        <option value=''></option>
                                    <?php
                                        foreach($_status as $val) {
                                            echo "<option value='$val' >$val</option>";
                                        }
                                    ?>
								    </select>
                                </span>
                            </div>
                            <?php
                                }
                            ?>
						</div>
                        <button type="button" class="btn btn-danger" id="addanother1" name="addanother1" onclick='addanother();' >Add another class</button>
                        <br />



                        <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Save</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('admin/viewsubject'); ?>">Cancel</a>

                     </form>
        </div>
    </div>
</div>


<script type="text/javascript">
function addanother() {
    var root=document.getElementById('classes_div');
    var divs=root.getElementsByTagName('div');
    var clone=divs[divs.length-1].cloneNode(true);
    root.appendChild(clone);
    var root=document.getElementById('classes_div');
    var divs=root.getElementsByTagName('div');
    var aaa = divs.length-1;
    var abc = divs[divs.length-1];
    abc1 = abc.getElementsByTagName("select");
    abc1[0].value = '';
    abc1[1].value = '';
}
</script>