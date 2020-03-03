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
        <form role="form" action="<?php echo site_url('registration-complete');?>" method="post" name="" enctype="multipart/form-data">

		    <div class="form-group row signup-field">
                <div class="col-md-4 field">
				    <label><?php echo @$_translation->array[$_lang_map]->item[72]; ?></label>
				</div>
			    <div class="col-md-8 field">
				    <input type="number" name="phone_no" id="phone_no" maxlength="10" minlength="10" class="form-control" />
				</div>
			</div>
            <div class="form-group row signup-field">
                <div class="col-md-4 field">
				    <label><?php echo @$_translation->array[$_lang_map]->item[58]; ?></label>
				</div>
			    <div class="col-md-8 field">
				    <select name="age" id="age" class="form-control" >
                        <?php
                            for($ii = 1 ; $ii <= 70 ; $ii++) {
                                echo "<option value='$ii'>$ii</option>";
                            }
                        ?>
                    </select>
				</div>
			</div>

            <div class="form-group row signup-field hidden">
                <div class="col-md-4 field">
				    <label><?php echo @$_translation->array[$_lang_map]->item[194]; ?></label>
				</div>
			    <div class="col-md-8 field">
				    <input type="text" name="promo_code" id="promo_code" class="form-control" />
				    <input type="hidden" name="date" id="date" value='<?php echo date("Y-m-d"); ?>' maxlength="120" minlength="2" class="form-control" />
				</div>
			</div>

            <div class="form-group row signup-field">
                <div class="col-md-12 field text-center">
                    <button type='submit' class="mg-submit-btn-new"><?php echo @$_translation->array[$_lang_map]->item[33]; ?></button>
				</div>
			</div>

		</form>
    </div>

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
    <img src='<?php echo base_url("webapp_asset/images/motu_3_with_shadow_1.svg"); ?>' class='motu_2_with_shadow_1' />
    <img src='<?php echo base_url("webapp_asset/images/grass_3.svg"); ?>' class='image_grass_3' />
    <img src='<?php echo base_url("webapp_asset/images/circular_land_1.svg"); ?>' class='image_circular_land_1' />

</div>
