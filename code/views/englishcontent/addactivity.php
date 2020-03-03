<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Add Activity</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('englishcontent/addactivity');?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Challenge</label>
							<div class="col-sm-1">
								<input type="checkbox" class="form-control" id="challenge" name="challenge" value="1" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Activity Name *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="name" name="name" value="" placeholder="" required />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Level</label>
							<div class="col-sm-3">
								<select class="form-control" id="level" name="level">
                                    <?php
                                        for($ii = 1 ; $ii <= 100 ; $ii++) {
                                            echo "<option value='".$ii."' >" . $ii . "</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Activity Number *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="activity_num" name="activity_num" value="" placeholder="" required />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Activity Tags </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="tags" name="tags" value="" placeholder="" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Activity Description </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="description" name="description" value="" placeholder="" />
							</div>
						</div>

                        <div class="form-group">
							<div class="col-sm-4"> </div>
							<div class="col-sm-2">
								<input type="button" class="form-control btn btn-default" id="titlebutton" name="titlebutton" value="Description Translation" onclick='opentranslationdiv();' />
							</div>
						</div>

                        <div style='margin-top: 5px;padding:5px; background-color: #EAEAFF; display:none;' id='titletranslation'>
                            <div class="form-group">
                                <label for="first_name" class="col-sm-12 "><h4>Description Translation</h4></label>
                                <?php
                                    $language = Language::find("all", array(
                                        "conditions" => " id != 3 AND id != 4 ",
                                        "order" => " name ASC ",
                                    ));

                                    $mm = 0;
                                    foreach($language as $val) {
                                ?>
                                    <label for="first_name" class="col-sm-4 control-label"><?php echo $val->name; ?></label>
        					        <div class="col-sm-6">
                                        <input type="hidden" class="form-control" id='language_id_<?php echo $val->id; ?>' name="language_id[]" value="<?php echo $val->id; ?>" />
        						        <input type="text" class="form-control alltranslate" id='language_trans_<?php echo $val->id; ?>' name="language_trans[]" value="" />
        					        </div>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="form-group" style='display:none;'>
							<label for="status" class="col-sm-4 control-label">Unit</label>
							<div class="col-sm-3">
								<select class="form-control" id="unit" name="unit" >
                                    <?php
                                        for($ii = 1 ; $ii <= 12 ; $ii++) {
                                            echo "<option value='".$ii."' >" . $ii . "</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">World</label>
							<div class="col-sm-3">
								<select class="form-control" id="world" name="world">
                                    <option value='' ></option>
                                    <?php
                                        foreach($worlds as $wid => $wval) {
                                            echo "<option value='".$wid."' >" . $wval . "</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Category</label>
							<div class="col-sm-3">
								<select class="form-control" id="category" name="category">
                                    <option value='' ></option>
                                    <?php
                                        foreach($categories as $wid => $wval) {
                                            echo "<option value='".$wid."' >" . $wval . "</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group" style='display:none;'>
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Points</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="point" name="point" value="" placeholder="" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label grapheme_name ">Score</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="score" name="score" value="" placeholder="" />
							</div>
						</div>

                         <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Stars</label>
							<div class="col-sm-3">
								<select class="form-control" id="stars" name="stars" >
                                    <?php
                                        for($ii = 0 ; $ii <= 5 ; $ii++) {
                                            echo "<option value='".$ii."' >" . $ii . "</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group" style='display:none;'>
							<label for="status" class="col-sm-4 control-label">Activity Type *</label>
							<div class="col-sm-3">
								<select class="form-control" id="activity_type1" name="activity_type1" >
                                    <option value='' ></option>
                                    <?php
                                        foreach( $stypes as $vid => $vva ) {
                                            echo "<option value='".$vid."' >" . $vva . "</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <br style='clear:both;'  />
                        <div class="form-group activity_types1">
                        <div class="form-group activity_types">
                            <label for='first_name' class='col-sm-2'><h4>Order Number</h4></label>
                            <label for='first_name' class='col-sm-4'><h4>Activity type</h4></label>
                            <label for='first_name' class='col-sm-4'><h4>Activity</h4></label>
                            <label for='first_name' class='col-sm-1'>Letter / word</label>
                            <label for='first_name' class='col-sm-1'>Count</label>

                            <div class='col-sm-12 act_0'>
                                <div class='col-sm-2'>
                                    <select id='order_num_0' name='order_num[]' class='form-control col-sm-6' >
                                        <?php
                                            for($ii = 1 ; $ii < 20 ; $ii++ ) {
                                                echo "<option value='$ii'>$ii</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class='col-sm-4'>
                                    <select id='activity_type_0' name='activity_type[]' class='form-control ' onchange='return change_type(this);' >
                                        <option value='' ></option>
                                        <?php
                                            foreach( $stypes as $vid => $vva ) {
                                                echo "<option value='".$vid."' >" . $vva . "</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class='col-sm-4'>
                                    <select id='type_id_0' name='type_id[]' class='form-control ' >
                                        <option value='' ></option>
                                    </select>
                                    <input type="text" class="form-control hidden"  id='type_id1_0' name='type_id1[]' value="" placeholder="" />
                                </div>
                                <div class='col-sm-1'>
                                    <input type="text" class="form-control hidden"  id='ml_grapheme_0' name='ml_grapheme[]' value="" placeholder="" />
                                </div>
                                <div class='col-sm-1'>
                                    <input type="text" class="form-control hidden"  id='act_count_0' name='act_count[]' value="" placeholder="" />
                                </div>
                            </div>
                        </div>
                        <br />
                        <button type="button" class="btn ruhe-btn-default-submit1 pull-left" onclick='addanother();' >ADD</button>
                        </div>
                        <br style='clear:both;' />

					    <button type="submit" class="btn btn-primary pull-right" id="addsubmit" name="addsubmit">Submit</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url(); ?>">Cancel</a>

                     </form>
        </div>
    </div>
</div>

<script>
    var counter = 0;
    function change_type(dis) {
        var idd1 = dis.id.split("_");
        var idd = idd1[idd1.length - 1];
        $("#ml_grapheme_"+idd).addClass("hidden");
        $("#type_id_"+idd).removeClass("hidden");
        $("#act_count_"+idd).addClass("hidden");
        convertitintoselect("type_id_"+idd,idd);
        removeoptions("type_id_" + idd);
        if(dis.value != '') {
            if( $.inArray(dis.value, ["missing_letter","phrase_game" ] )  != -1 ) {
                $("#ml_grapheme_"+idd).removeClass("hidden");
            }

            if( $.inArray(dis.value, ["listen_to_a_sound","vocabconceptrandom","word_game_random","segmenting_blending_random","grammarrandom","reading_test","first_last_sound","vocabrandom","first_last_sound_random","listen_to_a_sound_random","phrase","grammarrandom_specific","word_game_random_grapheme","segmenting_blending_random_grapheme","oddity_starts_with_grapheme","oddity_ends_with_grapheme" ] )  != -1 ) {
                $("#act_count_"+idd).removeClass("hidden");
            }

            if( dis.value == "first_last_sound_random" ) {
                $("#type_id_"+idd).addClass("hidden");
            } else if( dis.value == "listen_to_a_sound_random" ) {
                convertitintotextbox("type_id_"+idd,idd);
            } else {
                $.post("<?php echo site_url("englishcontent/getactivitydata"); ?>", { type: dis.value },  function( data ) {
                    var data1 = data.split(";;;");
                    for(var ii = 0 ; ii < data1.length ; ii++ ) {
                        temp = data1[ii].split(":::");
                        if(temp[1])
                            addoption("type_id_" + idd, temp[1], temp[0]);
                    }
                });
            }
        }
    }

    function addanother() {
        counter++;
        var divtxt = "<div class='col-sm-12 act_"+counter+"'>" + $( ".act_0" ).clone().html() + "</div>";
        divtxt = divtxt.replace(/_0/g, "_" + counter);
        $( divtxt ).appendTo( ".activity_types" );

        $("#activity_type_"+counter).val("");
        $("#type_id_"+counter).val("");
        $("#type_id1_"+counter).val("");
        $("#order_num_"+counter).val(counter + 1);
        $("#ml_grapheme_"+counter).val('');
        $("#act_count_"+counter).val('');
        $("#ml_grapheme_"+counter).addClass("hidden");
        $("#act_count_"+counter).addClass("hidden");
        $("#type_id_"+counter).removeClass("hidden");
        $("#type_id1_"+counter).addClass("hidden");
        convertitintoselect("type_id_"+counter,counter);
        removeoptions("type_id_"+counter);
    }

    function removeoptions(iid) {
        var elSel = document.getElementById(iid);
        for (var i = elSel.length - 1; i>=0; i--) {
            elSel.remove(i);
        }

        var elOptNew = document.createElement('option');
        elOptNew.text = '';
        elOptNew.value = '';
        var elSel = document.getElementById(iid);

        try {
            elSel.add(elOptNew, null); // standards compliant; doesn't work in IE
        } catch(ex) {
            elSel.add(elOptNew); // IE only
        }
    }

    function addoption(iid, text, value) {
        var elOptNew = document.createElement('option');
        elOptNew.text = text;
        elOptNew.value = value;
        var elSel = document.getElementById(iid);

        try {
            elSel.add(elOptNew, null); // standards compliant; doesn't work in IE
        } catch(ex) {
            elSel.add(elOptNew); // IE only
        }
    }

    function convertitintoselect(idd,numm) {
        $("#type_id_"+numm).removeClass("hidden");
        $("#type_id1_"+numm).addClass("hidden");
    }

    function convertitintotextbox(idd,numm) {
        $("#type_id_"+numm).addClass("hidden");
        $("#type_id1_"+numm).removeClass("hidden");
    }


    function opentranslationdiv() {
        if($("#titletranslation").css("display") == "none") {
            $("#titletranslation").css("display","block");
        } else {
            $("#titletranslation").css("display","none");
        }
    }
</script>