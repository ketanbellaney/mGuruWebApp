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
                    <h1 class="mg-h1-header mg-text-primary mg-shadow-text" onclick="_speaktext('<?php echo addslashes($question['sentence']); ?>');" style='cursor: pointer;'>
                        <?php echo @$_translation->array[$_lang_map]->item[11]; ?>
                        <!-- <img class="mg-icon-hint" data-toggle="tooltip" data-placement="bottom" title="This is mGuru hint" src="<?php echo base_url("webapp_asset/images/hint_1.svg"); ?>" alt="mGuru Hint"> -->
                    </h1>
                    <!-- <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#mgCongratulationModal"> Congratulation Modal </button>!-->
                </div>
            </div>
            <?php
                $obj = json_decode($activityLinkage->additional_info);
                $answer = $obj->missing_word;
            ?>
            <div class="row mg-daily-activity-wrapper clearfix">
                <div class="col-md-12 text-center">

                    <div class="mg-missing-word fillintheblank">
                        <div class="mg-query-text text-center" onclick="_speaktext('<?php echo addslashes($question['sentence']); ?>');" style='cursor: pointer;' >
                            <?php
                                echo str_ireplace($answer,'<span class="mg-void answerhere" contenteditable onkeyup="checkanswerr();" onchange="checkanswerr();" id="phrase_answer" ></span>',$question['sentence']);
                            ?>

                        </div>
                        <ul class="mg-options-wrapper list-unstyled list-inline" style='visibility: hidden;'>
                            <li class="mg-void">
                                <span class="mg-text-black">Gun</span>
                            </li>
                            <li class="mg-void">
                                <span class="mg-text-black">Snake</span>
                            </li>
                            <li class="mg-void">
                                <span class="mg-text-black">Wallet</span>
                            </li>
                            <li class="mg-void">
                                <span class="mg-text-black">Food</span>
                            </li>
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

    <input type='hidden' id='score_full' value='10' />
    <input type='hidden' id='act_answer' value='<?php echo $answer; ?>' />
    <input type='hidden' id='user_answer' value='' />
