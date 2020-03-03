<?php

    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>

<div class='signup_div'>
    <h1 class='hey-there'>Hey There!</h1>
    <h3 class='sign-up-text'>Login to continue</h3>

    <div class='login-white-box '>
        <form role="form" action="<?php echo site_url('login');?>" method="post" name="" enctype="multipart/form-data">

            <?php
                if($error == 2) {
                    echo "<p class='alert-warning' style='font-size: 14px;padding: 5px;'>Your account is not activated yet! Please activate your account.</p>";
                }
                if($error == 1) {
                    echo "<p class='alert-danger' style='font-size: 14px;padding: 5px;'>".@$_translation->array[$_lang_map]->item[150]." ".@$_translation->array[$_lang_map]->item[32]."</p>";
                }
            ?>
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
                    <button type='submit' class="mg-submit-btn-new"><?php echo @$_translation->array[$_lang_map]->item[68]; ?></button>
				</div>
			</div>

		</form>
    </div>
    <div class='already-user-text' style='z-index: 9999;'><a href='<?php echo site_url('sign-up');?>' ><?php echo @$_translation->array[$_lang_map]->item[69]; ?></a></div>
    <!-- <div class='continue-anyway-text'><a href='<?php echo site_url('forgot-password');?>' >Forgot Password</a></div> -->

</div>


<div class='image_circular_land_1_div'>
    <img src='<?php echo base_url("webapp_asset/images/sun_1.svg"); ?>' class='sun_1' />
    <img src='<?php echo base_url("webapp_asset/images/cloud_1.svg"); ?>' class='cloud_1_2' />
    <img src='<?php echo base_url("webapp_asset/images/sparrow_right_1.svg"); ?>' class='sparrow_right_1' />
    <img src='<?php echo base_url("webapp_asset/images/sparrow_left_2.svg"); ?>' class='sparrow_left_2' />
    <img src='<?php echo base_url("webapp_asset/images/cloud_1.svg"); ?>' class='cloud_1_1' />
    <img src='<?php echo base_url("webapp_asset/images/cloud_1.svg"); ?>' class='cloud_1' />
    <img src='<?php echo base_url("webapp_asset/images/grass_1.svg"); ?>' class='image_grass_1' />
    <img src='<?php echo base_url("webapp_asset/images/tree_1.svg"); ?>' class='image_tree_1' />
    <img src='<?php echo base_url("webapp_asset/images/grass_2.svg"); ?>' class='image_grass_2' />
    <img src='<?php echo base_url("webapp_asset/images/motu_2_with_shadow_1.svg"); ?>' class='motu_2_with_shadow_1' />
    <img src='<?php echo base_url("webapp_asset/images/grass_3.svg"); ?>' class='image_grass_3' />
    <img src='<?php echo base_url("webapp_asset/images/circular_land_1.svg"); ?>' class='image_circular_land_1' />

</div>