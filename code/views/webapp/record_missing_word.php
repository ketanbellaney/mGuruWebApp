<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>
<section id="dailyquest" class="mg-activity">
    <div class="mg-activity-1">
        <img src="<?php echo base_url("webapp_asset/images/activity-main-bg.jpg"); ?>" alt="mGuru Activity" class="mg-activity-main-bg">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-12 text-center">
                    <h1 class="mg-h1-header mg-text-primary mg-shadow-text" style='font-size: 50px !important;'>
                        <?php
                            //echo $question['title'];
                            $mmm = 0;
                            foreach(@$question['translation'] as $val){
                                if($_lang_db == $val['language_id']) {
                                    $mmm = 1;
                                    echo $val['translation'];
                                }
                            }

                            if($mmm != 1) {
                               echo $question['title'];
                            }
                        ?>
                        <!-- <img class="mg-icon-hint" data-toggle="tooltip" data-placement="bottom" title="This is mGuru hint" src="<?php echo base_url("webapp_asset/images/hint_1.svg"); ?>" alt="mGuru Hint"> -->
                    </h1>
                    <!-- <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#mgCongratulationModal"> Congratulation Modal </button>!-->
                </div>
            </div>
            <?php
                $obj = $question_set;
            ?>
            <div class="row mg-daily-activity-wrapper clearfix">
                <div class="col-md-8 col-md-offset-2 text-center">

                    <div class="mg-missing-word mg-match-pairs-chat clearfix">
                        <div class="mg-query-text text-center">
                            <?php
                                echo str_ireplace("::blank::",'<span class="mg-void contentreadonly" >&nbsp;&nbsp;&nbsp;</span>',$obj->question->text);
                            ?>
                        </div>
                        <div style="clear:both;margin-top: 50px;">
                            <ul class="mg-activity-sound-wrapper list-unstyled list-inline">
                                <li class="mg-void">
                                    <img src="<?php echo base_url("webapp_asset/images/volume_icon_1.svg"); ?>" alt="mGuru Listen" class="mg-say-img mg-listen" data-step=1 />
                                    <img src="<?php echo base_url("webapp_asset/images/record_icon_1.svg"); ?>" alt="mGuru Play" class="mg-say-img mg-record hide" data-step=2 />

                                </li>
                            </ul>
                        </div>
                    </div>

                    <a href="#" class="mg-btn-danger mg-btn-rounded mg-reply text-center text-uppercase"><?php echo @$_translation->array[$_lang_map]->item[32]; ?></a>
                    <!-- Please add/remove the mg-btn-disabled class to disable/enable the button -->
                    <a href="#" class="mg-btn-disabled mg-btn-danger mg-btn-rounded mg-submit text-center text-uppercase"><?php echo @$_translation->array[$_lang_map]->item[33]; ?></a>
                    <div class="progress mg-progress">
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo ($num + 1); ?>" aria-valuemin="0" aria-valuemax="<?php echo $activityCount; ?>" style="width: <?php echo (int)((($num + 1) / $activityCount ) * 100) ; ?>%">
                            <span class="sr-only"><?php echo (int)((($num + 1) / $activityCount ) * 100) ; ?>% Completed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type='hidden' id='score_full' value='5' />
    <input type='hidden' id='question_used' value='<?php echo $question['question']; ?>' />
    <input type='hidden' id='question_id_used' value='<?php echo $question['question_id']; ?>' />

    <div id='recordingslist'></div>

<style>
.contentreadonly {
    display: inline-block;
    background: #ffffff;
    color: #ffce00;
    padding: 0px 25px;
    border-radius: 20px;
    min-width: 170px;
    box-shadow: 2px 2px 1px #acacac;
    text-shadow: none;
    outline: none !important;
}


</style>