<div class='language_selection_div'>
    <ul class="list-group">
        <?php
            $default = 'english';
            if($defaultlanguages != '') {
                $default = $defaultlanguages;
            }
            foreach($languages as $lang => $text) {
                if($default == $lang) {
                    echo '<button type="button" class="list-group-item list-group-item-action lang_'.$lang.' active" onclick="select_language(\''.$lang.'\');">'.$text.'</button>';
                } else {
                    echo '<button type="button" class="list-group-item list-group-item-action lang_'.$lang.' " onclick="select_language(\''.$lang.'\');">'.$text.'</button>';
                }
            }
        ?>
    </ul>
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
    <img src='<?php echo base_url("webapp_asset/images/motu_1_with_shadow_1.svg"); ?>' class='motu_1_with_shadow_1' />
    <img src='<?php echo base_url("webapp_asset/images/grass_3.svg"); ?>' class='image_grass_3' />
    <img src='<?php echo base_url("webapp_asset/images/circular_land_1.png"); ?>' class='image_circular_land_1' />
    <a href="#" class="mg-submit-btn mg-btn-rounded" onclick="changelanguage();" >
        <span>Submit</span>
    </a>
</div>

<script type="text/javascript">
    var _lang_selected = '<?php echo $default?$default:'english'; ?>';
    function select_language(langg) {
        _lang_selected = langg;
        $(".list-group-item").removeClass("active");
        $(".lang_" + langg).addClass("active");
    }

    function changelanguage() {
        window.location.href = "<?php echo site_url("changelanguage"); ?>/" + _lang_selected;
    }
</script>
