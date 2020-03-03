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
                    <h1 style='cursor:pointer; margin-top: 10px;'  class="mg-h1-header mg-text-primary mg-shadow-text" onclick='playfirstlastsound("Find the image <?php if($position == 'first') echo "starting with"; else if($position == 'middle') echo "has"; else   echo "ending with"; ?>");'>
                        <?php
                            $rep_array = array(
                                "-----------",
                                "----------",
                                "---------",
                                "--------",
                                "-------",
                                "------",
                                "-----",
                                "----",
                                "---",
                                "--",
                                "............",
                                "...........",
                                "..........",
                                ".........",
                                "........",
                                ".......",
                                "......",
                                ".....",
                                "....",
                                "...",
                            );
                            if($position == 'first')
                                echo str_replace($rep_array, "<span style='color: #ffce00;'>" . $grapheme['grapheme'] . "</span>", @$_translation->array[$_lang_map]->item[0]);
                            else if($position == 'middle')
                                echo str_replace($rep_array, "<span style='color: #ffce00;'>" . $grapheme['grapheme'] . "</span>", @$_translation->array[$_lang_map]->item[5]);
                            else
                                echo str_replace($rep_array, "<span style='color: #ffce00;'>" . $grapheme['grapheme'] . "</span>", @$_translation->array[$_lang_map]->item[7]);
                        ?>
                        <!-- <img class="mg-icon-hint" data-toggle="tooltip" data-placement="bottom" title="This is mGuru hint" src="<?php echo base_url("webapp_asset/images/hint_1.svg"); ?>" alt="mGuru Hint"> -->
                    </h1>
                    <!-- <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#mgCongratulationModal"> Congratulation Modal </button>-->
                </div>
            </div>
            <div class="row mg-daily-activity-wrapper clearfix">
                <div class="col-md-8 col-md-offset-2 text-center">

                    <div class="mg-word-starts-with ">
                        <div class="mg-image-text-hint text-uppercase mg-text-warning" onclick='playfirstlastsound1();' style='cursor:pointer;' >
                            <?php echo $grapheme['grapheme']; ?>
                        </div>
                        <?php
                            $answer = $question[0]['word_id'];

                            $options = $question[0]['options'];
                            shuffle($options);
                        ?>

                        <ul class="mg-options-wrapper list-unstyled list-inline">
                            <li class="mg-void" data-value="<?php echo $options[0]['word_id']; ?>" data-word="<?php echo $options[0]['word']; ?>" >
                                <img src="<?php echo base_url("contentfiles/word/" . $options[0]['image']);?>" alt="<?php echo $options[0]['word']; ?>" class="mg-img">
                            </li>
                            <li class="mg-void" data-value="<?php echo $options[1]['word_id']; ?>" data-word="<?php echo $options[1]['word']; ?>" >
                                <img src="<?php echo base_url("contentfiles/word/" . $options[1]['image']);?>" alt="<?php echo $options[1]['word']; ?>" class="mg-img">
                            </li>
                            <li class="mg-void" data-value="<?php echo $options[2]['word_id']; ?>" data-word="<?php echo $options[2]['word']; ?>" >
                                <img src="<?php echo base_url("contentfiles/word/" . $options[2]['image']);?>" alt="<?php echo $options[2]['word']; ?>" class="mg-img">
                            </li>
                            <li class="mg-void" data-value="<?php echo $options[3]['word_id']; ?>" data-word="<?php echo $options[3]['word']; ?>" >
                                <img src="<?php echo base_url("contentfiles/word/" . $options[3]['image']);?>" alt="<?php echo $options[3]['word']; ?>" class="mg-img">
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
    <audio id="defaultaudio" src="<?php echo base_url("contentfiles/grapheme/" . $grapheme['phoneme'] . ".mp3"); ?>" controls style='display:none;'></audio>
    <input type='hidden' id='score_full' value='10' />
    <input type='hidden' id='act_answer' value='<?php echo $answer; ?>' />
    <input type='hidden' id='user_answer' value='' />
