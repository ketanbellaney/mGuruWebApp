<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Editors Choice Story</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('content/editorschoicestory');?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                        <br />
                        <br />
                        <br />
                       <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Story Name</label>
							<div class="col-sm-6">
								<select class="form-control" id="story_id" name="story_id" required >
                                    <?php
                                        $current = "";
                                        foreach($stories as $val) {
                                            if(@$ecs[0] == $val->id) {
                                                $current = "Level-".$val->level." --- ".$val->name ;
                                                echo "<option value='".$val->id."' selected='selected' >Level-".$val->level." --- ".$val->name."</option>";
                                            } else {
                                                echo "<option value='".$val->id."' >Level-".$val->level." --- ".$val->name."</option>";
                                            }
                                        }
                                    ?>
                                </select>
							</div>
						</div>
                          <br />
                          <br />
                          <br />
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Current Editors Choice Story</label>
							<div class="col-sm-6">
								<?php
                                    echo $current;
                                    ?>
							</div>
						</div>

					    <button type="submit" class="btn btn-primary pull-right" id="addsubmit" name="addsubmit">Submit</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('content/story'); ?>">Cancel</a>

                     </form>

        </div>
    </div>
</div>