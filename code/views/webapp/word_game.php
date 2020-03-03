<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>
<section id="dailyquest" class="mg-activity ">
    <div class="mg-activity-1">
        <img src="<?php echo base_url("webapp_asset/images/activity-main-bg.jpg"); ?>" alt="mGuru Activity" class="mg-activity-main-bg">
        <div class="container compress-80">
            <div class="row clearfix">
                <div class="col-md-12 text-center">
                    <h1 class="mg-h1-header mg-text-primary mg-shadow-text" onclick="playwordgamesound('Find the sound ', ' in the word <?php echo $question['word'];?>');" style='cursor: pointer; lne-height: 1.4;'>
                        <?php echo @$_translation->array[$_lang_map]->item[141]; ?>
                       <!--  <img class="mg-icon-hint" data-toggle="tooltip" data-placement="bottom" title="This is mGuru hint" src="<?php echo base_url("webapp_asset/images/hint_1.svg"); ?>" alt="mGuru Hint"> -->
                    </h1>
                </div>
            </div>
            <?php
                $answer = $question['answer_grapheme']['segment'];
             ?>
            <div class="row mg-daily-activity-wrapper clearfix">
                <div class="col-md-12 text-center">

                    <div class="mg-letter-sound ">
                        <ul class="mg-activity-sound-wrapper list-unstyled list-inline">
                            <li class="mg-void">
                                <img src="<?php echo base_url("webapp_asset/images/volume_icon_1.svg"); ?>" alt="mGuru Listen" class="mg-listen">
                                <img src="<?php echo base_url("webapp_asset/images/mg-icon-play.svg"); ?>" alt="mGuru Play" class="mg-pause hide">
                            </li>
                        </ul>
                        <ul class="mg-options-wrapper list-unstyled list-inline">
                            <?php foreach($question['segment'] as $val) { ?>
                                <li class="mg-void" data-value="<?php echo $val['segment']; ?>" >
                                    <span class="mg-text-warning text-uppercase"><?php echo $val['segment']; ?></span>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>


                    <!-- <a href="#" class="mg-btn-danger mg-btn-rounded mg-reply text-center text-uppercase">Try Again</a> -->
                    <!-- Please add/remove the mg-btn-disabled class to disable/enable the button -->
                    <a href="#" class="mg-btn-disabled mg-btn-danger mg-btn-rounded mg-submit text-center text-uppercase"><?php echo @$_translation->array[$_lang_map]->item[33]; ?></a>
                    <a href="#" class="mg-btn-danger mg-btn-rounded mg-next text-center text-uppercase hide"><?php echo @$_translation->array[$_lang_map]->item[26]; ?></a>
                    <div class="progress mg-progress">
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo ($num + 1); ?>" aria-valuemin="0" aria-valuemax="<?php echo $activityCount; ?>" style="width: <?php echo (int)((($num + 1) / $activityCount ) * 100) ; ?>%">
                            <span class="sr-only"><?php echo (int)((($num + 1) / $activityCount ) * 100) ; ?>% Completed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <audio id="grapheme_sound" src="<?php echo base_url("contentfiles/grapheme/" . $question['answer_grapheme']['audio'] ); ?>" controls style='display:none;'></audio>

    <input type='hidden' id='score_full' value='10' />
    <input type='hidden' id='act_answer' value='<?php echo $answer; ?>' />
    <input type='hidden' id='user_answer' value='' />
<style>
.mg-void{
    min-width: 175px !important;
}


</style>