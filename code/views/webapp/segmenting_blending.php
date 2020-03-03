<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>
<section id="dailyquest" class="mg-activity">
    <div class="mg-activity-1">
        <img src="<?php echo base_url("webapp_asset/images/activity-main-bg.jpg"); ?>" alt="mGuru Activity" class="mg-activity-main-bg">
        <div class="container compress-75">
            <div class="row clearfix">
                <div class="col-md-12 text-center">
                    <h1 class="mg-h1-header mg-text-primary mg-shadow-text" style='font-size: 40px !important; line-height: 1.4 !important; '>
                        <?php echo @$_translation->array[$_lang_map]->item[20]; ?>
                        <!-- <img class="mg-icon-hint" data-toggle="tooltip" data-placement="bottom" title="This is mGuru hint" src="<?php echo base_url("webapp_asset/images/hint_1.svg"); ?>" alt="mGuru Hint"> -->
                    </h1>
                    <!-- <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#mgCongratulationModal"> Congratulation Modal </button> -->
                </div>
            </div>
            <div class="row mg-daily-activity-wrapper clearfix">
                <div class="col-md-8 col-md-offset-2 text-center">

                    <div class="mg-correct-word mg-listen-sound mg-drag-drop ">
                        <div class="mg-image-text-hint text-uppercase mg-drop-wrapper" style='cursor: pointer;' >
                            <?php
                                $ccc = 1;
                                foreach($question['segment'] as $val) {         ?>
                                <div class="mg-text-disabled text-uppercase mg-drop-target mg-drop-target<?php echo $ccc; ?>" data-num="<?php echo $ccc; ?>"><?php echo strtoupper($val['segment']); ?></div>
                            <?php
                                $ccc++;} ?>
                            <div class="mg-text-disabled text-uppercase"></div>
                        </div>
                        <ul class="mg-image-wrapper list-unstyled list-inline">
                            <li class="mg-void">
                                <?php if(trim($question['image']) != "") { ?>
                                <img src="<?php echo base_url("contentfiles/word/" . $question['image']); ?>" alt="<?php echo $question['word']; ?>" style='z-index: 0; height: 160px; width: 160px;    margin-top: -10px;' class="mg-img">
                                <?php } else {
                                ?>
                                    <img src="<?php echo base_url("contentfiles/word/dad.png"); ?>" alt="dad" style='z-index: 0; height: 160px; width: 160px; visibility:hidden;   margin-top: -10px;' class="mg-img">
                                <?php
                                } ?>
                                <a href="#" class="mg-btn-warning mg-btn-rounded mg-image-text text-center text-uppercase"><?php echo $question['word']; ?></a>
                            </li>
                        </ul>
                        <div class="mg-drag-wrapper">
                            <img src="<?php echo base_url("webapp_asset/images/mg-motu-text-holder.svg"); ?>" alt="mGuru Motu" class="mg-motu">
                            <?php
                                $ccc = 1;
                                foreach($question['segment'] as $val) {
                                    if($ccc == 1) {
                                ?>
                                        <div class="mg-drag-target mg-drag-target<?php echo $ccc; ?> text-uppercase mg-text-warning mg-image-text-hint" data-num="<?php echo $ccc; ?>"><?php echo strtoupper($val['segment']); ?></div>
                                <?php    } else {       ?>
                                    <div class="mg-drag-target mg-drag-target<?php echo $ccc; ?> text-uppercase mg-text-warning mg-image-text-hint hidden" data-num="<?php echo $ccc; ?>"><?php echo strtoupper($val['segment']); ?></div>
                            <?php
                                    }
                                $ccc++;} ?>

                        </div>
                    </div>

                    <a href="#" class="mg-btn-danger mg-btn-rounded mg-reply text-center text-uppercase" onclick='return reset_drag_drop(); ' ><?php echo @$_translation->array[$_lang_map]->item[32]; ?></a>
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

    <?php
        $ccc = 1;
        foreach($question['segment'] as $val) { ?>
            <audio id="vovel_sound<?php echo $ccc; ?>" src="<?php echo base_url("contentfiles/grapheme/" . $val['audio']); ?>" controls style='display:none;'></audio>
    <?php
            $ccc++;
        }
    ?>
    <input type='hidden' id='vowel_word' value='<?php echo $question['word']; ?>' />
    <input type='hidden' id='drag_count' value='<?php echo count($question['segment']); ?>' />
    <input type='hidden' id='score_full' value='5' />
    <input type='hidden' id='activity_type' value='drag_drop' />
