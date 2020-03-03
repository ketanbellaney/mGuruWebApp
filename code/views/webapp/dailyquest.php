<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>
<section id="dailyquest" style='padding-top: 5px !important;'>
    <div class="container-fluid">
        <div class="row-fluid clearfix">
            <div class="col-md-2">
                <img src="<?php echo base_url("webapp_asset/images/sun-cloud.png"); ?>" alt="mGuru Sun Cloud" class="mg-sun-cloud">
            </div>
            <div class="col-md-8 text-center">
                <h1 class="mg-h1-header">
                    Today's Challenge
                </h1>
                <div class="mg-quest-help-text">
                    <?php echo stripslashes(@$_translation->array[$_lang_map]->item[76]); ?>
                </div>
                <?php
                    if( $dail_quest[0]['activityWorld'] != 'grammar_space' ) {

                        if ($dail_quest[0]['activityWorld'] == "sound_of_letters") {
                            $chall_id = 320;
                        } else if ($dail_quest[0]['activityWorld'] == "vowel_friends") {
                            $chall_id = 321;
                        } else if ($dail_quest[0]['activityWorld'] == "wordy_birdy") {
                            $chall_id = 322;
                        } else {
                            $chall_id = 323;
                        }
                ?>
                        <a href="<?php echo site_url("activity/" . $chall_id ."/start" ); ?>" class="mg-btn-primary mg-btn-rounded too-easy" style='width: 200px !important;' ><?php echo @$_translation->array[$_lang_map]->item[209]; ?></a>
                <?php
                    }
                ?>
            </div>
            <div class="col-md-2">
                <img src="<?php echo base_url("webapp_asset/images/helicopter_1.svg"); ?>" alt="mGuru Helicopter" class="mg-helicopter">
                <img src="<?php echo base_url("webapp_asset/images/cloud_1.svg"); ?>" alt="mGuru Cloud" class="mguru-cloud">
            </div>
        </div>
        <div class="row-fluid mg-quest-board clearfix">
            <div class="col-md-4">
                <a href='<?php echo site_url("activity/" . $dail_quest[0]['id'] ."/start" ); ?>'><div class="mg-board-wrapper-1 text-center">
                    <img src="<?php echo base_url("webapp_asset/images/house_1.svg"); ?>" alt="mGuru House" class="mg-house">
                    <?php if (@$dail_quest[0]['activityStatus'] == "open" ) { ?>
                        <img src="<?php echo base_url("webapp_asset/images/motu_10_without_shadow_1.png"); ?>" alt="mGuru Motu" class="mg-motu" />
                    <?php } ?>
                    <img src="<?php echo base_url("webapp_asset/images/dailyquestboard_1.svg"); ?>" alt="mGuru Board 1" class="mg-board-1">
                    <img src="<?php echo base_url("webapp_asset/images/mango_1_main_1.svg"); ?>" alt="mGuru Grass" class="mg-mango-1">
                    <small class="mg-mango-score-1"><?php echo @$dail_quest[0]['activityScore']; ?></small>
                    <img src="<?php echo base_url("webapp_asset/images/grass_2.svg"); ?>" alt="mGuru Grass" class="mg-grass-1">
                    <img src="<?php echo base_url("webapp_asset/images/wordiconhover_1.svg"); ?>" alt="mGuru Word Icon" class="mg-board-icon mg-icon-word">
                    <div class='dq-al-1 dq-activity-lable'><?php echo @$dail_quest[0]['activityName']; ?></div>
                    <!-- <div class='dq-an-1 dq-activity-name'><?php echo @$dail_quest[0]['activityLevelName']; ?></div> -->
                </div> </a>
            </div>
            <div class="col-md-4">
                <?php if (@$dail_quest[1]['activityStatus'] == "open" || @$dail_quest[1]['activityStatus'] == "close" ) { ?><a href='<?php echo site_url("activity/" . $dail_quest[1]['id'] ."/start" ); ?>'><?php } ?><div class="mg-board-wrapper-2 text-center">
                    <img src="<?php echo base_url("webapp_asset/images/mango_1_main_1.svg"); ?>" alt="mGuru Grass" class="mg-mango-1">
                    <?php if (@$dail_quest[1]['activityStatus'] == "open" ) { ?>
                        <img src="<?php echo base_url("webapp_asset/images/motu_10_without_shadow_1.png"); ?>" alt="mGuru Motu" class="mg-motu" style='margin-left: 175px; bottom: 13px;'> -->
                    <?php } ?>
                    <small class="mg-mango-score-1"><?php echo @$dail_quest[1]['activityScore']; ?></small>
                    <img src="<?php echo base_url("webapp_asset/images/dailyquestboard_2.svg"); ?>" alt="mGuru Board 2" class="mg-board-2">
                    <img src="<?php echo base_url("webapp_asset/images/storyicondefault_1.svg"); ?>" alt="mGuru Story Icon" class="mg-board-icon mg-icon-story">
                    <div class='dq-al-2 dq-activity-lable'><?php echo @$dail_quest[1]['activityName']; ?></div>
                    <!-- <div class='dq-an-2 dq-activity-name'><?php echo @$dail_quest[1]['activityLevelName']; ?></div> -->
                </div>
                <?php if (@$dail_quest[1]['activityStatus'] == "open" ) { ?></a> <?php } ?>
            </div>
            <div class="col-md-4">
                <?php if (@$dail_quest[2]['activityStatus'] == "open"  || @$dail_quest[2]['activityStatus'] == "close" ) { ?><a href='<?php echo site_url("activity/" . $dail_quest[2]['id'] ."/start" ); ?>'><?php } ?><div class="mg-board-wrapper-3 text-center">
                    <img src="<?php echo base_url("webapp_asset/images/mango_1_main_1.svg"); ?>" alt="mGuru Grass" class="mg-mango-1">
                    <?php if (@$dail_quest[2]['activityStatus'] == "open" ) { ?>
                        <img src="<?php echo base_url("webapp_asset/images/motu_10_without_shadow_1.png"); ?>" alt="mGuru Motu" class="mg-motu" style='margin-left: 148px; bottom: -3px;' />
                    <?php } ?>
                    <small class="mg-mango-score-1"><?php echo @$dail_quest[2]['activityScore']; ?></small>
                    <img src="<?php echo base_url("webapp_asset/images/grass_1.svg"); ?>" alt="mGuru Grass" class="mg-grass-2">
                    <img src="<?php echo base_url("webapp_asset/images/dailyquestboard_3.svg"); ?>" alt="mGuru Board 3" class="mg-board-3">
                    <img src="<?php echo base_url("webapp_asset/images/soundicondefault_1.svg"); ?>" alt="mGuru Sound Icon" class="mg-board-icon mg-icon-sound">
                    <div class='dq-al-1 dq-activity-lable'><?php echo @$dail_quest[2]['activityName']; ?></div>
                    <!-- <div class='dq-an-3 dq-activity-name'><?php echo @$dail_quest[2]['activityLevelName']; ?></div> -->
                </div> <?php if (@$dail_quest[2]['activityStatus'] == "open" ) { ?></a><?php } ?>

                <img src="<?php echo base_url("webapp_asset/images/mango-bucket.png"); ?>" alt="mGuru Mango bucket" class="mg-mango-bucket">
                <small class="mg-mango-bucket-score"><?php echo $totalmango; ?></small>
            </div>
        </div>
    </div>
    <div class="dailyquest-footer-hills">
        <img src="<?php echo base_url("webapp_asset/images/hills_1.svg"); ?>" alt="mGuru Hills">
    </div>
</section>
<div class="mg-footer">
    <img src='<?php echo base_url("webapp_asset/images/circular_land_1.png"); ?>' class='image_circular_land_1' />
</div>

<style>
body{
    background-color: #ffffff !important;
    height: 100%;
    overflow: hidden !important;
}
</style>