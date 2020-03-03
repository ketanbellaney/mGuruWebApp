<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>
<div class='signup_div'>
    <h1 class='hey-there' style='margin-top: 25px;'><?php echo stripcslashes(@$_translation->array[$_lang_map]->item[75]); ?></h1>
    <h3 class='sign-up-text' style='width: 60%; margin-top: 25px;margin-left:20%; line-height: 1.4;'><?php echo nl2br( stripcslashes(@$_translation->array[$_lang_map]->item[76])); ?></h3>
</div>


<div class='image_circular_land_1_div'>
    <img src='<?php echo base_url("webapp_asset/images/cloud_1.svg"); ?>' class='cloud_1_2' />
    <img src='<?php echo base_url("webapp_asset/images/sparrow_right_1.svg"); ?>' class='sparrow_right_1' />
    <img src='<?php echo base_url("webapp_asset/images/sparrow_left_2.svg"); ?>' class='sparrow_left_2' style='left: 60%;' />
    <img src='<?php echo base_url("webapp_asset/images/cloud_1.svg"); ?>' class='cloud_1_1' />
    <img src='<?php echo base_url("webapp_asset/images/cloud_1.svg"); ?>' class='cloud_1' style='left: 40%;' />
    <img src='<?php echo base_url("webapp_asset/images/rainbow_1.svg"); ?>' class='rainbow_1' />
    <img src='<?php echo base_url("webapp_asset/images/grass_1.svg"); ?>' class='image_grass_1' />
    <img src='<?php echo base_url("webapp_asset/images/tree_1.svg"); ?>' class='image_tree_1' />
    <img src='<?php echo base_url("webapp_asset/images/grass_2.svg"); ?>' class='image_grass_2' />
    <img src='<?php echo base_url("webapp_asset/images/motu_4_with_shadow_1.svg"); ?>' class='motu_2_with_shadow_1' style='width: 165px;right: 42%;top: -15%;' />
    <img src='<?php echo base_url("webapp_asset/images/grass_3.svg"); ?>' class='image_grass_3' />
    <img src='<?php echo base_url("webapp_asset/images/circular_land_1.svg"); ?>' class='image_circular_land_1' />

    <a href="#" onclick="skiponboarding();" class="mg-submit-btn mg-btn-rounded" style='left: 42%; background-color: white; border: 3px solid #ffce00; width: 125px; '>
        <span style='color: #ffce00 !important; font-weight: bold;'><?php echo @$_translation->array[$_lang_map]->item[77]; ?></span>
    </a>
    <a href="#" onclick="startonboarding();" class="mg-submit-btn mg-btn-rounded" style='width: 125px; left: 52%'>
        <span style=' font-weight: bold;'><?php echo @$_translation->array[$_lang_map]->item[78]; ?></span>
    </a>
</div>

<script>
    function skiponboarding() {
        window.location.href = "<?php echo site_url('daily-quest'); ?>";
    }
    function startonboarding() {
        window.location.href = "<?php echo site_url('daily-quest'); ?>";
    }
</script>