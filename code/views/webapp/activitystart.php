<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>
<section id="dailyquest" class="mg-activity" style='padding-top: 5px !important;'>

    <!-- Please add/remove the activity as per the requirement -->
    <div class="mg-activity-2 ">
        <img src="<?php echo base_url("webapp_asset/images/story-complete-bg.jpg"); ?>" alt="mGuru Stories" class="mg-activity-main-bg">
        <div class="container-fluid">
            <div class="row-fluid clearfix">
                <div class="col-md-12 text-center">
                    <h1 class="mg-h1-header" style='margin-bottom: 0px !important; font-size: 50px !important;'>
                        <?php echo $activity->name; ?>
                    </h1>
                    <div class="mg-quest-help-text" style='margin-top: 10px !important;'>
                        <?php
                            $mmm = 0;
                            foreach($activity->description_translation as $val){
                                if($_lang_db == $val->language_id) {
                                    $mmm = 1;
                                    echo $val->translation;
                                }
                            }

                            if($mmm != 1) {
                                echo $activity->description;
                            }
                        ?>
                    </div>
                </div>
            </div>
            <?php $tags = explode(",",$activity->tags); ?>
            <div class="row mg-daily-activity-wrapper clearfix" style='margin-top: 0px !important;'>
                <div class="col-md-12 text-center">
                    <div class="mg-correct-word mg-new-sound">
                        <ul class="mg-options-wrapper list-unstyled list-inline">
                            <?php
                                if($activity->tags != '') {
                                    $ii = 0;
                                    foreach($tags as $val) {
                                        if($ii < 6)
                                            echo "<li class='mg-void'><span class='mg-text-primary'>$val</span></li>";
                                        $ii++;
                                    }
                                } else {
                                    echo "<li class='mg-void' style='visibility: hidden;'><span class='mg-text-primary'>Word</span></li>";
                                }
                            ?>
                        </ul>
                        <div class="mg-motu-mango-wrapper" style='margin-top:130px !important;'>
                            <img src="<?php echo base_url("webapp_asset/images/motu_2_with_shadow_1.svg"); ?>" alt="mGuru Motu" class="mg-motu">
                            <div class="mg-mango-points" style='margin-right: 35% !important;'>
                                <img src="<?php echo base_url("webapp_asset/images/sounds_motu_bubble_1.svg"); ?>" alt="mGuru Bubble" class="mg-bubble">
                                <img src="<?php echo base_url("webapp_asset/images/mango_1_main_1.svg"); ?>" alt="mGuru Mango" class="mg-mango">
                                <span class="mg-mango-score"><?php echo $activity->score; ?></span>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo site_url("activity/question/" . $activity->id ); ?>" class="mg-btn-danger mg-btn-rounded mg-submit text-center text-uppercase"><?php echo @$_translation->array[$_lang_map]->item[25]; ?></a>
                </div>
            </div>
        </div>
    </div>

</section>

<div class="mg-modal modal fade" role="dialog" id="mgCongratulationModal" tabindex="-1" aria-labelledby="mgCongratulationModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="<?php echo base_url("webapp_asset/images/popup_close_1.svg"); ?>" alt="mGuru Pop-up close">
                </button>
            </div>
            <div class="modal-body text-center">
                <h1 class="mg-modal-title">
                    <?php echo @$_translation->array[$_lang_map]->item[75]; ?>
                </h1>
                <!--<p class="mg-modal-desc">
                    You finished
                </p> -->
                <h3><?php echo $activity->name; ?></h3>
                <img src="<?php echo base_url("webapp_asset/images/mg-motu-congrats.svg"); ?>" alt="mGuru Motu" class="mg-motu">
                <div class="progress mg-progress">
                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%">
                    </div>
                </div>
                <h2 class="mg-h1-header">
                    10%
                </h2>
                <a href="javascript:void(0);" class="mg-unlock-btn text-uppercase"><?php echo @$_translation->array[$_lang_map]->item[165]; ?></a>
                <a href="javascript:void(0);" data-dismiss="modal" class="mg-btn-back"><?php echo @$_translation->array[$_lang_map]->item[27]; ?></a>
            </div>
        </div>
    </div>
</div>
<style>
body {
    height: 100%;
    overflow: hidden !important;
}
</style>