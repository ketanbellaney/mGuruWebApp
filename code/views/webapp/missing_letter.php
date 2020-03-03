<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>
<section id="dailyquest" class="mg-activity ">
    <div class="mg-activity-1">
        <img src="<?php echo base_url("webapp_asset/images/activity-main-bg.jpg"); ?>" alt="mGuru Activity" class="mg-activity-main-bg">
        <div class="container compress-90">
            <div class="row clearfix">
                <div class="col-md-12 text-center">
                    <h1 class="mg-h1-header mg-text-primary mg-shadow-text">
                        <?php echo @$_translation->array[$_lang_map]->item[12]; ?>
                        <!-- <img class="mg-icon-hint" data-toggle="tooltip" data-placement="bottom" title="This is mGuru hint" src="<?php echo base_url("webapp_asset/images/hint_1.svg"); ?>" alt="mGuru Hint"> -->
                    </h1>
                </div>
            </div>

            <div class="row mg-daily-activity-wrapper clearfix">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <!-- Please add/remove the hide class if this one is disable/enable -->
                    <div class="mg-missing-letter ">
                        <ul class="mg-activity-word-wrapper list-unstyled list-inline">
                            <?php
                                $answer = '';
                                foreach($question['segment'] as $val) {
                                    if(strtolower($val['segment']) == strtolower($missing_grapheme) && $answer == '' ) {
                                        $answer = strtolower(str_replace(array(1,2,3,4,5,6,7,8,9),"", $val['grapheme']));
                                        echo "<li class='mg-void'><span class='mg-text-warning text-uppercase answerhere'>&nbsp;</span></li>";
                                    } else {
                                        echo "<li><span class='mg-text-warning text-uppercase'>".$val['segment']."</span></li>";
                                    }
                                }
                            ?>
                        </ul>
                        <div class="mg-word-image-hint text-center">
                            <img src="<?php echo base_url("contentfiles/word/" . $question['image'] ); ?>" alt="mGuru word hint" class="mg-hint-image" onclick='return  _speaktext("<?php echo $question['word']; ?>");' >
                        </div>
                        <ul class="mg-options-wrapper list-unstyled list-inline">
                            <?php
                                 $options = $question['options'];
                                 shuffle($options);
                                 foreach($options as $val) {
                                    echo "<li class='mg-void' data-value=\"".strtolower(str_replace(array(1,2,3,4,5,6,7,8,9),"", $val['grapheme']))."\" >
                                            <span class='mg-text-warning text-uppercase'>".$val['grapheme']."</span>
                                        </li>";
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
    <input type='hidden' id='act_answer' value='<?php echo $answer; ?>' />
    <input type='hidden' id='user_answer' value='' />
