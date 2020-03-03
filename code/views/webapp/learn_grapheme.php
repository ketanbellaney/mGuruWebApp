<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>
    <div class="mg-activity-1 ">
        <img src="<?php echo base_url("webapp_asset/images/activity-main-bg.jpg"); ?>" alt="mGuru Activity" class="mg-activity-main-bg">
        <div class="container compress-75">
            <div class="row clearfix">
                <div class="col-md-12 text-center">
                    <h1 class="mg-h1-header mg-text-primary mg-shadow-text" style='font-size: 40px !important;line-height: 1.2 !important;'>
                        <?php echo @$_translation->array[$_lang_map]->item[10]; ?>
                        <!-- <img class="mg-icon-hint" data-toggle="tooltip" data-placement="bottom" title="This is mGuru hint" src="<?php echo base_url("webapp_asset/images/hint_1.svg"); ?>" alt="mGuru Hint"> -->
                    </h1>
                    <!-- <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#mgCongratulationModal"> Congratulation Modal </button> -->
                </div>
            </div>
            <div class="row mg-daily-activity-wrapper clearfix">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <!-- Please add/remove the hide class if this one is disable/enable -->
                    <div class="mg-say">
                        <?php
                            $gra = $grapheme['grapheme'];
                            $gra = str_replace("1","",$gra);
                            $gra = str_replace("2","",$gra);
                            $gra = str_replace("3","",$gra);
                            $gra = str_replace("4","",$gra);
                            $gra = str_replace("5","",$gra);
                            $gra = str_replace("6","",$gra);
                            $gra = str_replace("7","",$gra);
                            $gra = str_replace("8","",$gra);
                            $gra = str_replace("9","",$gra);
                        ?>
                        <div class="mg-image-text-hint text-uppercase mg-drop-wrapper">
                            <div class=" text-uppercase" onclick='playfirstlastsound1();' style='cursor:pointer;'><?php echo $gra; ?></div>
                        </div>
                        <ul class="mg-activity-sound-wrapper list-unstyled list-inline">
                            <li class="mg-void ">
                                <img src="<?php echo base_url("contentfiles/word/" . $grapheme['image'] ); ?>" alt="mGuru Listen" style='z-index: 0 !important;height: 180px;margin-top: -68px;' class="mg-say-img mg-listen" data-step=1 />
                                <div style='z-index: 100;' ><div class='mg-listen-word text-uppercase' style='height: auto;margin-left: auto; margin-right: auto; width: 70%; border-radius: 30px; margin-top: 0px; color: white; background-color: #FEE51A; font-size: 20px; font-weight: 600;' ><?php echo $grapheme['word']; ?></div></div>
                                <img src="<?php echo base_url("webapp_asset/images/mg-icon-play.svg"); ?>" alt="mGuru Play" class="mg-say-img mg-pause hide"  data-step=2 />
                                <img src="<?php echo base_url("webapp_asset/images/record_icon_1.svg"); ?>" alt="mGuru Play" class="mg-say-img mg-record hide"  data-step=3 />
                                <img src="<?php echo base_url("webapp_asset/images/mg-recording.svg"); ?>" alt="mGuru Play" class="mg-say-img mg-recording hide"  data-step=4 />
                                <img src="<?php echo base_url("webapp_asset/images/volume_icon_1.svg"); ?>" alt="mGuru Play" class="mg-say-img mg-record hide"  data-step=5 />
                            </li>
                        </ul>

                        <ul class="mg-options-wrapper list-unstyled list-inline">
                            <li>
                                <img src="<?php echo base_url("webapp_asset/images/mg-motu-listen.svg"); ?>" alt="mGuru Motu" class="mg-motu-listen">
                                <img src="<?php echo base_url("webapp_asset/images/mg-motu-recording.svg"); ?>" style='margin-top: -30px !important; margin-left: 100px !important;' alt="mGuru Motu" class="mg-motu-record hide">
                            </li>
                        </ul>
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
    <audio id="defaultaudio" src="<?php echo base_url("contentfiles/grapheme/" . $grapheme['audio']); ?>" controls style='display:none;'></audio>
    <audio id="recordedaudio" src="" controls style='display:none;'></audio>
    <input type='hidden' id='score_full' value='5' />
    <input type='hidden' id='defaultaudio_word' value='<?php echo $grapheme['word']; ?>' />

    <div id='recordingslist'></div>