<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Edit NCRT Activity</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('englishcontent/editncrt/' . $ncrt_id);?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Name *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="name" name="name" value="<?php echo @$ncrt->name; ?>" placeholder="" required />
								<input type="hidden" id="order_number" name="order_number" value="<?php echo @$ncrt->order_number; ?>" />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Grade Level Skill</label>
							<div class="col-sm-3">
								<select class="form-control" id="unit" name="unit">
                                    <?php
                                        for($ii = 1 ; $ii <= 100 ; $ii++) {
                                            if(@$ncrt->unit == $ii) {
                                                echo "<option value='".$ii."' selected='selected'>" . $ii . "</option>";
                                            } else {
                                                echo "<option value='".$ii."' >" . $ii . "</option>";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>


                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Level</label>
							<div class="col-sm-3">
								<select class="form-control" id="level" name="level">
                                    <?php
                                        for($ii = 1 ; $ii <= 100 ; $ii++) {
                                            if(@$ncrt->level == $ii) {
                                                echo "<option value='".$ii."' selected='selected'>" . $ii . "</option>";
                                            } else {
                                                echo "<option value='".$ii."' >" . $ii . "</option>";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Description </label>
							<div class="col-sm-6">
								<textarea class="form-control" id="description" name="description" ><?php echo @$ncrt->description; ?></textarea>
							</div>
						</div>

                        <br style='clear:both;'  />

                        <div class="form-group activity_types1">
                            <div class="form-group activity_types">
                                <label for='first_name' class='col-sm-6'><h4>Activity</h4></label>
                                <label for='first_name' class='col-sm-2'><h4>Order Number</h4></label>
                                <label for='first_name' class='col-sm-4'>&nbsp;</label>

                                <div class='col-sm-12 act_0'>
                                    <div class='col-sm-6'>
                                        <select id='activity_0' name='activity[]' class='form-control '  >
                                            <option value='' ></option>
                                            <?php
                                                foreach( $activities as $vva ) {
                                                    echo "<option value='".$vva->id."' >" . $vva->level . " - " . $vva->activity_num . " - " . $vva->name . "</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class='col-sm-2'>
                                        <select id='order_number_0' name='order_number[]' class='form-control col-sm-6' >
                                            <?php
                                                for($ii = 1 ; $ii < 50 ; $ii++ ) {
                                                    echo "<option value='$ii'>$ii</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class='col-sm-4'>
                                        &nbsp;
                                    </div>
                                </div>
                            </div>
                            <br />
                            <button type="button" class="btn ruhe-btn-default-submit1 pull-left" onclick='addanother();' >ADD</button>
                        </div>
                        <br style='clear:both;' />

                        <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Save</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('englishcontent/viewncrt'); ?>">Cancel</a>

                    </form>
        </div>
    </div>
</div>

<?php
    $activity = array();
    $order_numbers = array();
?>
<script>
    var counter = 0;

    function addanother() {
        counter++;
        var divtxt = "<div class='col-sm-12 act_"+counter+"'>" + $( ".act_0" ).clone().html() + "</div>";

        divtxt = divtxt.replace(/_0/g, "_" + counter);
        $( divtxt ).appendTo( ".activity_types" );

        $("#activity_"+counter).val("");
        $("#order_number_"+counter).val(counter + 1);
    }

    function func1() {
        <?php
            $counter = 0;

            foreach($ncrt->activity as $val) {
                if($counter != 0) {
                    echo "addanother();";
                }
                echo "\$('#activity_' + counter).val('".$val->activity_id."');";
                echo "\$('#order_number_' + counter).val('".$val->order_number."');";

                $counter++;
            }
        ?>
    }

    window.onload=func1;
</script>