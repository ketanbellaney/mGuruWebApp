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
                    <h1 class="mg-h1-header mg-text-primary mg-shadow-text" style='font-size: 40px !important;'>
                        <?php
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
                $answer = "";
                $ii = 1;
                foreach($question_set->column1 as $val) {
                    $answer .= $ii . $ii;
                    $ii++;
                }
                $column1 = $question_set->column1;
                $column2 = $question_set->column2;
                shuffle($column2);
            ?>
            <div class="row mg-daily-activity-wrapper clearfix">
                <div class="col-md-8 col-md-offset-2 text-center">

                    <div class="mg-match-pairs clearfix">
                        <ul class="mg-options-wrapper list-unstyled mg-left-panel">
                            <?php
                                $ii = 1;
                                foreach($column1 as $val) {
                            ?>
                            <li class="mg-void" data-value="<?php echo $val->match; ?>">
                                <span class="mg-text-black"><?php echo $val->text; ?></span>
                                <small class="mg-counter">0<?php echo $ii; ?></small>
                            </li>
                            <?php
                                    $ii++;
                                }
                            ?>
                        </ul>
                        <ul class="mg-options-wrapper list-unstyled mg-right-panel">
                            <?php
                                $ii = 1;
                                foreach($column2 as $val) {
                            ?>
                            <li class="mg-void" data-value="<?php echo $val->match; ?>">
                                <span class="mg-text-black"><?php echo $val->text; ?></span>
                                <small class="mg-counter hide"></small>
                            </li>
                            <?php
                                    $ii++;
                                }
                            ?>

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
    <input type='hidden' id='act_answer' value="<?php echo $answer; ?>" />
    <input type='hidden' id='user_answer' value='' />
    <input type='hidden' id='question_used' value='<?php echo $question['question']; ?>' />
    <input type='hidden' id='question_id_used' value='<?php echo $question['question_id']; ?>' />
<script>
    $(function() {
        matchthecolumninit();
    });
</script>