<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>

<div class='signup_div'>
    <h1 class='hey-there'>Hey There!</h1>
    <h3 class='sign-up-text'><?php echo @$_translation->array[$_lang_map]->item[71]; ?></h3>

    <div class='login-white-box '>
        <form role="form" action="<?php echo site_url('sign-up');?>" method="post" name="" enctype="multipart/form-data" onsubmit='return validateform();' >
		    <div class="form-group row signup-field">
                <div class="col-md-4 field">
				    <label><?php echo @$_translation->array[$_lang_map]->item[62]; ?></label>
				</div>
			    <div class="col-md-8 field">
				    <input type="text" name="username" id="username" required maxlength="100" minlength="3" class="form-control" onchange='checkusername();' />
				</div>
			</div>
            <div class="form-group row signup-field">
                <div class="col-md-4 field">
				    <label><?php echo @$_translation->array[$_lang_map]->item[63]; ?></label>
				</div>
			    <div class="col-md-8 field">
				    <input type="password" name="password" id="password" required maxlength="100" minlength="3" class="form-control" />
				</div>
			</div>

            <div class="form-group row signup-field">
                <div class="col-md-12 field text-center">
                    <button type='submit' class="mg-submit-btn-new"><?php echo @$_translation->array[$_lang_map]->item[64]; ?></button>
				</div>
			</div>

		</form>
    </div>
    <div class='already-user-text' style='z-index: 9999;'><a href='<?php echo site_url('login');?>' ><?php echo @$_translation->array[$_lang_map]->item[65]; ?></a></div>
    <!-- <div class='continue-anyway-text'><a href='<?php echo site_url('login');?>' >Continue Anyway</a></div> -->

</div>

<div class='image_circular_land_1_div'>
    <img src='<?php echo base_url("webapp_asset/images/sun_1.svg"); ?>' class='sun_1' />
    <img src='<?php echo base_url("webapp_asset/images/cloud_1.svg"); ?>' class='cloud_1_2' />
    <img src='<?php echo base_url("webapp_asset/images/sparrow_right_1.svg"); ?>' class='sparrow_right_1' />
    <img src='<?php echo base_url("webapp_asset/images/sparrow_left_2.svg"); ?>' class='sparrow_left_2' />
    <img src='<?php echo base_url("webapp_asset/images/cloud_1.svg"); ?>' class='cloud_1_1' style='top: -90%; left: 8%;' />
    <img src='<?php echo base_url("webapp_asset/images/cloud_1.svg"); ?>' class='cloud_1' style='left: 20%;' />
    <img src='<?php echo base_url("webapp_asset/images/grass_1.svg"); ?>' class='image_grass_1' />
    <img src='<?php echo base_url("webapp_asset/images/tree_1.svg"); ?>' class='image_tree_1' />
    <img src='<?php echo base_url("webapp_asset/images/grass_2.svg"); ?>' class='image_grass_2' />
    <img src='<?php echo base_url("webapp_asset/images/motu_2_with_shadow_1.svg"); ?>' class='motu_2_with_shadow_1' />
    <img src='<?php echo base_url("webapp_asset/images/grass_3.svg"); ?>' class='image_grass_3' />
    <img src='<?php echo base_url("webapp_asset/images/circular_land_1.svg"); ?>' class='image_circular_land_1' />

</div>

<script type="text/javascript">
     var c_uname = 0;
    function validateform() {

        if(c_name == 0) {
            alert("<?php echo @$_translation->array[$_lang_map]->item[111]; ?>");
            return false;
        }

        if(c_name == 2) {
            alert("<?php echo @$_translation->array[$_lang_map]->item[151]; ?>");
            return false;
        }

        if(c_name == 3) {
            alert("Please wait checking the username availability.");
            return false;
        }

        if($("#password").val() == '') {
            alert("<?php echo @$_translation->array[$_lang_map]->item[115]; ?>");
            return false;
        }

        return true;
    }

    function checkusername() {
        c_name = 3;

        var uname = $("#username").val();

        if(uname != "") {
            $.post("<?php echo site_url("webapp/checkusername"); ?>", { uname: uname },  function( data ) {
                c_name = data;

                if(c_name == 2) {
                    $("#username").val("");
                    //$("#username").css("border","red");
                    alert("<?php echo @$_translation->array[$_lang_map]->item[151]; ?>");
                    c_name = 0;
                    return false;
                }
            });
        }

        return false;
    }
</script>
