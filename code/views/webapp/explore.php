<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
    $long_sign_board = array(6,7);
?>
<section id="explore">
    <img src="<?php echo base_url("webapp_asset/images/explore-bg.png"); ?>" alt="mGuru Explore" class="mg-explore-main-bg">
    <div class="container-fluid">
        <div class="row-fluid clearfix">
            <div class="col-md-2 text-center">
                <img src="<?php echo base_url("webapp_asset/images/plane_1.svg"); ?>" alt="mGuru Plane" class="mg-plane">
            </div>
            <div class="col-md-8 text-center">
                <h1 class="mg-h1-header">
                    <?php echo @$_translation->array[$_lang_map]->item[89]; ?>
                </h1>
                <div class="mg-quest-help-text">

                </div>
            </div>
            <div class="col-md-2 text-right">
                <img src="<?php echo base_url("webapp_asset/images/planet_1.svg"); ?>" alt="mGuru Planet" class="mg-planet">
            </div>
        </div>
        <?php
            $current_world = 0;
            foreach($worlds as $iid => $val) {
                if($val['status'] == 1) {
                    $current_world = $iid;
                }
            }
        ?>
        <div class="row-fluid mg-explore-worlds clearfix">
            <div class="col-md-2 mg-level-1 <?php if($current_world == 0 ) { ?>mg-active<?php } ?>">
                <?php if($worlds[0]['status'] == 1 ) { ?><a href='<?php echo site_url("explore/world/1"); ?>' ><?php } ?>
                <img src="<?php echo base_url("webapp_asset/images/motu_2_without_shadow_1.svg"); ?>" alt="mGuru Motu" class="mg-motu">

                <img src="<?php echo base_url("webapp_asset/images/level1_stone_1.svg"); ?>" alt="mGugu Level1" class="mg-stone-level" style=''>
                <div class="mg-mango-wrapper">
                    <img src="<?php echo base_url("webapp_asset/images/mango_1_main_1.svg"); ?>" alt="mGuru Mango">
                    <small class="mg-mango-score-level"><?php echo $worlds[0]['total'];?></small>
                </div>
                <div class="mg-title-level text-center" <?php if (in_array($_lang_map,$long_sign_board)){ ?> style='background:url("<?php echo base_url("webapp_asset/images/signboard_long.png"); ?>") no-repeat center center !important; height: 105px !important;' <?php } ?>  >
                    <img src="<?php echo base_url("webapp_asset/images/locked_1.svg"); ?>" alt="mGuru Lock" class="mg-level-lock">
                    <small class="mg-level-title" ><?php
                      echo @$_translation->array[$_lang_map]->item[98];
                    //echo $worlds[0]['name'];?></small>
                </div>
                <?php if($worlds[0]['status'] == 1 ) { ?></a><?php } ?>
            </div>
            <div class="col-md-2 mg-level-2 <?php if($current_world == 1 ) { ?>mg-active<?php } ?> <?php if($worlds[1]['status'] == 0 ) { ?>mg-locked<?php } ?>">
                <?php if($worlds[1]['status'] == 1 ) { ?><a href='<?php echo site_url("explore/world/2"); ?>' ><?php } ?>
                <img src="<?php echo base_url("webapp_asset/images/motu_2_without_shadow_1.svg"); ?>" alt="mGuru Motu" class="mg-motu">
                <img src="<?php echo base_url("webapp_asset/images/level2_stone_1.svg"); ?>" alt="mGugu Level1" class="mg-stone-level">
                <div class="mg-mango-wrapper">
                    <img src="<?php echo base_url("webapp_asset/images/mango_1_main_1.svg"); ?>" alt="mGuru Mango">
                    <small class="mg-mango-score-level"><?php echo $worlds[1]['total'];?></small>
                </div>
                <?php
                    $imgg = base_url("webapp_asset/images/signboard_long.png");
                    if($worlds[1]['status'] == 0) {
                        $imgg = base_url("webapp_asset/images/signboard_locked_1.png");
                    }
                ?>
                <div class="mg-title-level text-center" <?php if (in_array($_lang_map,$long_sign_board)){ ?> style='background:url("<?php echo $imgg; ?>") no-repeat center center !important;  height: 105px !important;' <?php } ?>>
                    <img src="<?php echo base_url("webapp_asset/images/locked_1.svg"); ?>" alt="mGuru Lock" class="mg-level-lock">
                    <small class="mg-level-title" ><?php
                      echo @$_translation->array[$_lang_map]->item[100];
                    //echo $worlds[1]['name'];?></small>
                </div>
                <?php if($worlds[1]['status'] == 1 ) { ?></a><?php } ?>
            </div>
            <div class="col-md-2 mg-level-3 <?php if($current_world == 2 ) { ?>mg-active<?php } ?> <?php if($worlds[2]['status'] == 0 ) { ?>mg-locked<?php } ?>">
                <?php if($worlds[2]['status'] == 1 ) { ?><a href='<?php echo site_url("explore/world/3"); ?>' ><?php } ?>
                <img src="<?php echo base_url("webapp_asset/images/motu_2_without_shadow_1.svg"); ?>" alt="mGuru Motu" class="mg-motu">
                <img src="<?php echo base_url("webapp_asset/images/level3_stone_1.svg"); ?>" alt="mGugu Level1" class="mg-stone-level">
                <div class="mg-mango-wrapper">
                    <img src="<?php echo base_url("webapp_asset/images/mango_1_main_1.svg"); ?>" alt="mGuru Mango">
                    <small class="mg-mango-score-level"><?php echo $worlds[2]['total'];?></small>
                </div>
                <?php
                    $imgg = base_url("webapp_asset/images/signboard_long.png");
                    if($worlds[2]['status'] == 0) {
                        $imgg = base_url("webapp_asset/images/signboard_locked_1.png");
                    }
                ?>
                <div class="mg-title-level text-center" <?php if (in_array($_lang_map,$long_sign_board)){ ?> style='background:url("<?php echo $imgg; ?>") no-repeat center center !important;  height: 105px !important;' <?php } ?>>
                    <img src="<?php echo base_url("webapp_asset/images/locked_1.svg"); ?>" alt="mGuru Lock" class="mg-level-lock">
                    <small class="mg-level-title"><?php
                      echo @$_translation->array[$_lang_map]->item[102];
                    //echo $worlds[2]['name'];?></small>
                </div>
                <?php if($worlds[2]['status'] == 1 ) { ?></a><?php } ?>
            </div>
            <div class="col-md-2 mg-level-4 <?php if($current_world == 3 ) { ?>mg-active<?php } ?> <?php if($worlds[3]['status'] == 0 ) { ?>mg-locked<?php } ?>">
                <?php if($worlds[3]['status'] == 1 ) { ?><a href='<?php echo site_url("explore/world/4"); ?>' ><?php } ?>
                <img src="<?php echo base_url("webapp_asset/images/motu_2_without_shadow_1.svg"); ?>" alt="mGuru Motu" class="mg-motu">
                <img src="<?php echo base_url("webapp_asset/images/level4_stone_1.svg"); ?>" alt="mGugu Level1" class="mg-stone-level">
                <div class="mg-mango-wrapper">
                    <img src="<?php echo base_url("webapp_asset/images/mango_1_main_1.svg"); ?>" alt="mGuru Mango">
                    <small class="mg-mango-score-level"><?php echo $worlds[3]['total'];?></small>
                </div>
                <?php
                    $imgg = base_url("webapp_asset/images/signboard_long.png");
                    if($worlds[3]['status'] == 0) {
                        $imgg = base_url("webapp_asset/images/signboard_locked_1.png");
                    }
                ?>
                <div class="mg-title-level text-center" <?php if (in_array($_lang_map,$long_sign_board)){ ?> style='background:url("<?php echo $imgg; ?>") no-repeat center center !important;  height: 105px !important;' <?php } ?>>
                    <img src="<?php echo base_url("webapp_asset/images/locked_1.svg"); ?>" alt="mGuru Lock" class="mg-level-lock">
                    <small class="mg-level-title" ><?php
                    echo @$_translation->array[$_lang_map]->item[104];
                    //echo $worlds[3]['name'];?></small>
                </div>
                <?php if($worlds[3]['status'] == 1 ) { ?></a><?php } ?>
            </div>
            <div class="col-md-2 mg-level-5 <?php if($current_world == 4 ) { ?>mg-active<?php } ?> <?php if($worlds[4]['status'] == 0 ) { ?>mg-locked<?php } ?>">
                <?php if($worlds[4]['status'] == 1 ) { ?><a href='<?php echo site_url("explore/world/5"); ?>' ><?php } ?>
                <img src="<?php echo base_url("webapp_asset/images/motu_2_without_shadow_1.svg"); ?>" alt="mGuru Motu" class="mg-motu">
                <img src="<?php echo base_url("webapp_asset/images/level5_stone_1.svg"); ?>" alt="mGugu Level1" class="mg-stone-level">
                <div class="mg-mango-wrapper">
                    <img src="<?php echo base_url("webapp_asset/images/mango_1_main_1.svg"); ?>" alt="mGuru Mango">
                    <small class="mg-mango-score-level"><?php echo $worlds[4]['total'];?></small>
                </div>
                <?php
                    $imgg = base_url("webapp_asset/images/signboard_long.png");
                    if($worlds[4]['status'] == 0) {
                        $imgg = base_url("webapp_asset/images/signboard_locked_1.png");
                    }
                ?>
                <div class="mg-title-level text-center" <?php if (in_array($_lang_map,$long_sign_board)){ ?> style='background:url("<?php echo $imgg; ?>") no-repeat center center !important;  height: 105px !important;' <?php } ?>>
                    <img src="<?php echo base_url("webapp_asset/images/locked_1.svg"); ?>" alt="mGuru Lock" class="mg-level-lock">
                    <small class="mg-level-title" ><?php
                      echo @$_translation->array[$_lang_map]->item[106];
                    //echo $worlds[4]['name'];?></small>
                </div>
                <?php if($worlds[4]['status'] == 1 ) { ?></a><?php } ?>
            </div>
        </div>
        <div class="mg-mango-bucket-wrapper">
            <img src="<?php echo base_url("webapp_asset/images/mango-bucket.png"); ?>" alt="mGuru Mango bucket" class="mg-mango-bucket">
            <small class="mg-mango-bucket-score"><?php echo $totalmango; ?></small>
        </div>
    </div>
</section>

<style>
.mg-mango-wrapper img{
    height: 65px !important;
}

.mg-level-1 .mg-mango-wrapper .mg-mango-score-level {
    top: 14% !important;
}

.mg-level-2 .mg-mango-wrapper .mg-mango-score-level {
    top: 8% !important;
}

.mg-level-3 .mg-mango-wrapper .mg-mango-score-level {
    top: 7% !important;
}

.mg-level-4 .mg-mango-wrapper .mg-mango-score-level {
    top: 10% !important;
}

.mg-level-5 .mg-mango-wrapper .mg-mango-score-level {
    left: 13.5% !important;
    top: 15% !important;
}
 body {
        height: 100%;
        overflow: hidden !important;
    }
.mg-level-title {
    font-weight: 800 !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    position: absolute !important;
}


</style>
