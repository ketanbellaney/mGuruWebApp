<?php
    $numshow = 1;
?>
<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Worksheet</h2>
            <?php
                if($error != 0) {
                    echo "<div class='alert alert-info' role='alert'>You have run out of worksheet credit, refer your friends and colleague to get more credits. <a href='".site_url("worksheet/refer")."' >Click here</a></div>";
                } else {
            ?>
                    <form class='form-horizontal' role="form" action="<?php echo site_url('worksheet/worksheetprocess');?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                        <div class="form-group class_display2" align="center" style='text-align: center;'>
                            <img src="<?php echo base_url("images/loading-x.gif"); ?>" />
					    </div>
                        <div class="form-group class_display">
                            <label for="first_name" class="col-sm-2 control-label">Board</label>
							<div class="col-sm-4">
                                <select class="form-control" id="ws_board" name="ws_board" required >
                                    <option value='' >Please select board</option>
                                    <?php
                                        $board = array("Andhra Pradesh State Board","Bihar State Board","CBSE","Gujrat State Board","Maharashtra State Board","Rajasthan State Board","Tamil Nadu State Board","West Bengal State Board" );
                                        foreach($board as $val) {
                                            echo "<option value='$val' >" . $val . "</option>";
                                        }
                                    ?>
                                </select>
							</div>
							<label for="first_name" class="col-sm-2 control-label">Class</label>
							<div class="col-sm-4">
                                <select class="form-control" id="class" name="class" required onchange='startworksheet();' >
                                    <option value='' >Please select class</option>
                                    <?php
                                        for($ii = 1 ; $ii <= 5 ; $ii++) {
                                            echo "<option value='".($ii + 2)."' >" . $ii . "</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>


                        <div class="form-group class_display1">
                            <label for="first_name" class="col-sm-2 control-label">Board</label>
							<div class="col-sm-4">
                            <b class="boardshow form-control"></b>
                            </div>
							<label for="first_name" class="col-sm-2 control-label">Class</label>
							<div class="col-sm-3">
                                <b class="classshow form-control"></b>
                            </div>
                            <div class="col-sm-1">
                                <button type="button" class="btn class_display1" onclick='changeclass();' >change</button>
                            </div>
						</div>

                        <br />
                        <div class="form-group class_display1">
                            <label for="first_name" class="col-sm-2 control-label">Worksheet Name</label>
							<div class="col-sm-6">
                                <input type="text" id="ws_name" name="ws_name" placeholder="Please provide a name for the worksheet" class="input-xlarge form-control" />
							</div>
						</div>

                        <div class=" class_display1">
                            <br />
							<label for="first_name" class="col-sm-4"><h3>Add Questions to Worksheet</h3></label>
						</div>
                        <br style='clear:both;' />
                        <div id='questionset' class="class_display1">
                            <div style='margin-top: 5px;padding:5px;'>
                                <div class="form-group col-sm-2">
        							<label for="first_name" class="control-label">Unit</label>
        						</div>
                                <div class="form-group col-sm-3">
        							<label for="first_name" class="control-label">Concept</label>
        						</div>
                                <div class="form-group col-sm-4">
        							<label for="first_name" class="control-label">Sub-Concept</label>
        						</div>
                                <div class="form-group col-sm-1">
        							<label for="first_name" class="control-label">Count</label>
        						</div>
                                <div class="form-group col-sm-1">
        							<label for="first_name" class="control-label">Delete</label>
        						</div>
                                <div class="form-group col-sm-1">
        							<label for="first_name" class="control-label">Preview</label>
        						</div>
                            </div>
                        <?php
                            for($mm = 0 ; $mm < $numshow; $mm++) {
                        ?>
                            <div style='margin-top: 5px;padding:5px;clear:both;' class='questionset_<?php echo $mm; ?>'>
                                <div class="form-group  col-sm-2">
                                    <select class="form-control" id="unit_<?php echo $mm; ?>" name="unit_<?php echo $mm; ?>" onchange="changeunits(1,this);" >
                                        <option value=''></option>
    								</select>
        						</div>
                                <div class="form-group  col-sm-3">
                                    <select class="form-control" id="concept_<?php echo $mm; ?>" name="concept_<?php echo $mm; ?>" onchange="changeunits(2,this);" >
                                        <option value=''></option>
    								</select>
        						</div>
                                <div class="form-group  col-sm-4">
                                    <select class="form-control" id="sub_concept_<?php echo $mm; ?>" name="sub_concept_<?php echo $mm; ?>" >
                                        <option value=''></option>
    								</select>
        						</div>

                                <div class="form-group  col-sm-1">
                                    <select class="form-control" id="count_<?php echo $mm; ?>" name="count_<?php echo $mm; ?>" >
                                        <?php
                                            for($ii = 1 ; $ii <= 5 ; $ii++) {
                                                echo "<option value='".$ii."' >" . $ii . "</option>";
                                            }
                                        ?>
    								</select>
        						</div>
                                <div class="form-group  col-sm-1">
                                    <input type='button' class="btn btn-danger" class="form-control" onclick="deletethis(this);" id="delete_<?php echo $mm; ?>" name="delete_<?php echo $mm; ?>" value="x" />
        						</div>
                                <div class="form-group  col-sm-1">
                                    <input type='button' class="btn btn-primary" class="form-control" onclick="previewtemplate(this);" id="preview_<?php echo $mm; ?>" name="preview_<?php echo $mm; ?>" value="Preview" />
        						</div>
                            </div>
                        <?php
                            }
                        ?>
                        </div>
                        <input type='hidden' name='count_question' id='count_question' value='<?php echo $numshow; ?>' />
                        <br style='clear:both;'/><br />
                        <button type="button" class="btn pull-left class_display1" onclick='addanotherquestion();' >ADD</button>
					    <button type="submit" class="btn pull-right class_display1" id="addsubmit" name="addsubmit">Submit</button>
					    <a role="button" class="btn  pull-right class_display1" href="<?php echo site_url(); ?>">Cancel</a>

                     </form>
                     <br style='clear: both;'/><br />


                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 preview_tab class_display1s" style="background-color: #eeeeee; display:none;">
                        <h2>Preview <span class='preview_title'></span></h2>
                        <div class="preview_div" style='border: 2px solid #cccccc; margin: 20px; padding: 20px;'>

                        </div>
                     </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
<?php
    if($error == 0) {
?>
<div id='unitsdata' style='display:none;'><?php
$mmm = array();
foreach( $units as $val) {
    $mmm[] = $val->id . ":::". $val->name. ":::". $val->classes_id;
}
echo implode(";;;" , $mmm);
?></div>

<div id='conceptsdata' style='display:none;'><?php
$mmm = array();
foreach( $concepts as $val) {
    $mmm[] = $val->id . ":::". $val->name . ":::" . $val->units_id . ":::" . $val->units->classes_id;
}
echo implode(";;;" , $mmm);
?></div>

<div id='questionsdata' style='display:none;'><?php
/*$mmm = array();
foreach( $questions as $val) {
    $mmm[] = $val->question->id.",," . $val->question->question.",," . $val->question->question_template_id . ":::". $val->question->title . ":::" . $val->concepts_id. ":::" . $val->concept->units_id. ":::" . $val->classes_id . ":::" .$val->board . ":::" .$val->concept->name . ":::" .$val->concept->units->name;
}
echo implode(";;;" , $mmm);*/
?></div>


<script>

mixpanel.identify('<?php echo $user->id; ?>');
mixpanel.alias('<?php echo $user->id; ?>');
mixpanel.track("New Worksheet", {
    "created": "0"
});

var unitsdata = document.getElementById("unitsdata").innerHTML.split(";;;");
var conceptsdata = document.getElementById("conceptsdata").innerHTML.split(";;;");
var questionsdata = document.getElementById("questionsdata").innerHTML.split(";;;");


    function startworksheet() {
        var ws_board = $("#ws_board").val();
        var cl = $("#class").val();
        if( cl != "" && ws_board != '') {
            $(".classshow").html(( cl - 2));
            $(".boardshow").html(ws_board);

            $(".class_display").hide(1000);
            $(".class_display2").show(1000);

            $.post("<?php echo site_url("worksheet/getquestionsdata"); ?>", { board: ws_board, cl: cl},  function( data ) {
                questionsdata = data.split(";;;");
                $(".class_display2").hide(1000);
                $(".class_display1").show(1000);

                changeunits(3,document.getElementById("unit_0"));
            });
        }
    }

    function changeclass() {
        $(".class_display1").hide(1000);
        $(".class_display").show(1000);
    }

    var next_num = <?php echo $numshow; ?>;

    function addanotherquestion() {
        var temp = next_num - 1;

        /*if($("#unit_"+temp).val() == '' || $("#concept_"+temp).val() == '' || $("#sub_concept_"+temp).val() == '' || $("#count_"+temp).val() == '') {
            alert("Please provide all details before adding another row!");
            return false;
        }*/

        var divtxt = "<div style='margin-top: 5px;padding:5px;clear:both;' class='questionset_"+next_num+"'>" + $( ".questionset_0" ).clone().html() + "</div>";
        divtxt = divtxt.replace(/_0/g, "_" + next_num);
        divtxt = divtxt.replace(/ 0/g, " " + next_num);
        divtxt = divtxt.replace(/\(0/g, "(" + next_num);
        $( divtxt ).appendTo( "#questionset" );

        $("#unit_"+next_num).val("");
        $("#concept_"+next_num).val("");
        $("#sub_concept_"+next_num).val("");
        $("#count_"+next_num).val("1");

        changeunits(3,document.getElementById("unit_" + next_num));

        $(".questionset_"+next_num).css("display","block");

        next_num++;

        $("#count_question").val(next_num);

    }

    function changeunits(nums, dis) {
        var numm = dis.id.split("_");
        var num = numm[numm.length - 1];

        var classs = document.getElementById("class").value;
        var board = document.getElementById("ws_board").value;

        if(nums == 1) {
            removeoptions("concept_" + num);
            removeoptions("sub_concept_" + num);
            addoption("concept_" + num, '', '');
            addoption("sub_concept_" + num, '', '');

            var concep = new Array();
            for(var ii = 0 ; ii < questionsdata.length ; ii++ ) {
                temp = questionsdata[ii].split(":::");
                if(temp[1]) {
                    if(temp[4] == classs && temp[3] == dis.value && board == temp[5] ) {
                        concep[temp[2]] = temp[6];
                    }
                }
            }

            for(var ii = 0 ; ii < conceptsdata.length ; ii++ ) {
                temp = conceptsdata[ii].split(":::");
                if(temp[1]) {
                    if(concep[temp[0]]) {
                        addoption("concept_" + num, temp[1], temp[0]);
                    }
                }
            }
        }

        if(nums == 2) {
            removeoptions("sub_concept_" + num);
            addoption("sub_concept_" + num, '', '');

            for(var ii = 0 ; ii < questionsdata.length ; ii++ ) {
                temp = questionsdata[ii].split(":::");
                if(temp[1]) {
                    if(temp[2] == dis.value && temp[4] == classs && board == temp[5] ) {
                        addoption("sub_concept_" + num, temp[1], temp[0]);
                    }
                }
            }
        }

        if(nums == 3) {
            removeoptions("unit_" + num);
            removeoptions("concept_" + num);
            removeoptions("sub_concept_" + num);
            addoption("unit_" + num, '', '');
            addoption("concept_" + num, '', '');
            addoption("sub_concept_" + num, '', '');

            var unitss = new Array();
            for(var ii = 0 ; ii < questionsdata.length ; ii++ ) {
                temp = questionsdata[ii].split(":::");
                if(temp[1]) {
                    if(temp[4] == classs && board == temp[5]  ) {
                        unitss[temp[3]] = temp[7];
                    }
                }
            }

            for(var ii = 0 ; ii < unitsdata.length ; ii++ ) {
                temp = unitsdata[ii].split(":::");
                if(temp[1]) {
                    if(unitss[temp[0]]) {
                        addoption("unit_" + num, temp[1], temp[0]);
                    }
                }
            }
        }
    }

    function removeoptions(iid) {
        var elSel = document.getElementById(iid);
        for (var i = elSel.length - 1; i>=0; i--) {
            elSel.remove(i);
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

    function previewtemplate(dis) {
        var numm = dis.id.split("_");
        var num = numm[numm.length - 1];

        var unit_id = $("#unit_" + num).val();
        var unit = "";
        var concept_id = $("#concept_" + num).val();
        var concept = "";
        var sub_concept_id = $("#sub_concept_" + num).val();
        var sub_concept = "";


        for(var ii = 0 ; ii < unitsdata.length ; ii++ ) {
            temp = unitsdata[ii].split(":::");
            if(temp[1]) {
                if(temp[0] == unit_id) {
                    unit = temp[1];
                }
            }
        }

        for(var ii = 0 ; ii < conceptsdata.length ; ii++ ) {
            temp = conceptsdata[ii].split(":::");
            if(temp[1]) {
                if(temp[0] == concept_id) {
                    concept = temp[1];
                }
            }
        }

        for(var ii = 0 ; ii < questionsdata.length ; ii++ ) {
            temp = questionsdata[ii].split(":::");
            if(temp[1]) {
                if(temp[0] == sub_concept_id) {
                    sub_concept = temp[1];
                }
            }
        }

        $(".preview_tab").css("display","block");
        $(".preview_title").html(unit + " - " + concept + " - " + sub_concept);
        $(".preview_div").html("");


        $.post("<?php echo site_url("worksheet/previewtemplate"); ?>", { unit: unit_id, concept: concept_id, sub_concept: sub_concept_id },  function( data ) {
            $(".preview_div").html(data);
        });

    }

    function deletethis(dis) {
        var numm = dis.id.split("_");
        var num = numm[numm.length - 1];


        $("#unit_"+num).val("");
        $("#concept_"+num).val("");
        $("#sub_concept_"+num).val("");
        $("#count_"+num).val("1");
        $(".questionset_"+num).css("display","none");

    }

</script>

<style>
.class_display1 , .class_display2{
    display:none;
}
</style>
<?php
    }
?>