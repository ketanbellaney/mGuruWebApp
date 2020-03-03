<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Add new word group</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('englishcontent/addwordgroup');?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                       <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Group *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="name" name="name" value="" placeholder="Group Name" required />
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
							<label for="first_name" class="col-sm-4 control-label">Class *</label>
							<div class="col-sm-6">
                                <select class="form-control" id="class" name="class" required>
                                    <?php
                                        $_class = array("JKG","SKG",1,2,3,4,5);
                                        foreach($_class as $cla) {
                                            echo "<option value='".$cla."' >" . $cla . "</option>";
                                        }
                                    ?>
                                </select>
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Examination Board *</label>
							<div class="col-sm-3">
								<select class="form-control" id="board" name="board" onchange="changeeb(this);" required>
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

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Page Number</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="page_number" name="page_number" value="" placeholder="Page Number" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Source</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="source" name="source" value="" placeholder="Source" />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Status *</label>
							<div class="col-sm-3">
								<select class="form-control" id="status" name="status" required>
                                    <?php
                                        $_status = array("active","inactive");
                                        foreach($_status as $sta) {
                                            echo "<option value='".$sta."' >" . $sta . "</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
                            <br /><br />
							<label for="first_name" class="col-sm-4 control-label"><h4>Words</h4></label>
						</div>

                        <div id='wordset'>
                        <?php
                            for($mm = 0 ; $mm < $wordcount ; $mm++) {
                        ?>
                            <div style='margin-top: 5px;padding:5px; background-color: #EAEAFF;' class='wordset_<?php echo $mm; ?>'>
                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label">Word</label>
    							<div class="col-sm-6">
    								<input type="text" class="form-control" id="aword_<?php echo $mm; ?>" name="aword_<?php echo $mm; ?>" value="" placeholder="Word"/>
    							</div>
    						</div>

                            <div class="form-group">
    							<label for="status" class="col-sm-4 control-label">Level</label>
    							<div class="col-sm-3">
    								<select class="form-control" id="alevel_<?php echo $mm; ?>" name="alevel_<?php echo $mm; ?>" >
                                        <?php
                                            for($ii = 1 ; $ii <= 2 ; $ii++) {
                                                echo "<option value='".$ii."' >" . $ii . "</option>";
                                            }
                                        ?>
    								</select>
    							</div>
    						</div>

                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label">Word Defination</label>
    							<div class="col-sm-6">
    								<input type="text" class="form-control" id="adefination_<?php echo $mm; ?>" name="adefination_<?php echo $mm; ?>" value="" placeholder="Word Defination" />
    							</div>
    						</div>

                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label">Example</label>
    							<div class="col-sm-6">
    								<textarea class="form-control" id="aexample_<?php echo $mm; ?>" name="aexample_<?php echo $mm; ?>" placeholder="Example" ></textarea>
    							</div>
    						</div>

                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label">Hindi Translation</label>
    							<div class="col-sm-6">
    								<input type="text" class="form-control" id="ahindi_translation_<?php echo $mm; ?>" name="ahindi_translation_<?php echo $mm; ?>" value="" placeholder="Hindi Translation" />
    							</div>
    						</div>

                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label">Marathi Translation</label>
    							<div class="col-sm-6">
    								<input type="text" class="form-control" id="amarathi_translation_<?php echo $mm; ?>" name="amarathi_translation_<?php echo $mm; ?>" value="" placeholder="Marathi Translation" />
    							</div>
    						</div>

                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label">Image</label>
    							<div class="col-sm-6">
    								<input type="file" class="form-control" id="aimage_<?php echo $mm; ?>" name="aimage_<?php echo $mm; ?>" value=""/>
    							</div>
    						</div>

                            <div class="form-group">
    							<label for="first_name" class="col-sm-4 control-label">Audio</label>
    							<div class="col-sm-6">
    								<input type="file" class="form-control" id="aaudio_<?php echo $mm; ?>" name="aaudio_<?php echo $mm; ?>" value=""/>
    							</div>
    						</div>
                            </div>
                        <?php
                            }
                        ?>
                        </div>
                        <input type='hidden' name='count_word' id='count_word' value='<?php echo $wordcount; ?>' />
                        <br /><br />
                        <button type="button" class="btn ruhe-btn-default-submit1 pull-left" onclick='addanotherword();' >ADD</button>
					    <button type="submit" class="btn btn-primary pull-right" id="addsubmit" name="addsubmit">Submit</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url(); ?>">Cancel</a>

                     </form>
        </div>
    </div>
</div>

<script>
    var next_num = <?php echo $wordcount; ?>;

    function addanotherword() {
        var divtxt = "<div style='margin-top: 5px;padding:5px; background-color: #EAEAFF;' class='wordset_"+next_num+"'>" + $( ".wordset_0" ).clone().html() + "</div>";
        divtxt = divtxt.replace(/_0/g, "_" + next_num);
        divtxt = divtxt.replace(/ 0/g, " " + next_num);
        divtxt = divtxt.replace(/\(0/g, "(" + next_num);
        $( divtxt ).appendTo( "#wordset" );

        $("#aword_"+next_num).val("");
        $("#adefination_"+next_num).val("");
        $("#aexample_"+next_num).val("");
        $("#aimage_"+next_num).val("");
        $("#aaudio_"+next_num).val("");
        $("#ahindi_translation_"+next_num).val("");
        $("#amarathi_translation_"+next_num).val("");
        $("#alevel_"+next_num).val(1);

        next_num++;

        $("#count_word").val(next_num);
    }

    function changeeb(dis){
        if(dis.value == 'other') {
            dis.parentNode.innerHTML = "<input type='text' class='form-control' id='examination_board' name='examination_board' placeholder='Examination Board' value='' />";
        }
    }
</script>