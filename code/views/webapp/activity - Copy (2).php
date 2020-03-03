<section id="dailyquest" class="mg-activity">
    <div class="mg-activity-1">
        <img src="<?php echo base_url("webapp_asset/images/activity-main-bg.jpg"); ?>" alt="mGuru Activity" class="mg-activity-main-bg">
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <h1 class="mg-h1-header mg-text-primary mg-shadow-text">
                        Fill in the missing letter
                        <img class="mg-icon-hint" data-toggle="tooltip" data-placement="bottom" title="This is mGuru hint" src="<?php echo base_url("webapp_asset/images/hint_1.svg"); ?>" alt="mGuru Hint">
                    </h1>
                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#mgCongratulationModal"> Congratulation Modal </button>
                </div>
            </div>
            <div class="row mg-daily-activity-wrapper clearfix">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <!-- Please add/remove the hide class if this one is disable/enable -->
                    <div class="mg-missing-letter hide">
                        <ul class="mg-activity-word-wrapper list-unstyled list-inline">
                            <li class="mg-void">
                                <span class="mg-text-warning text-uppercase">&nbsp;</span>
                            </li>
                            <li>
                                <span class="mg-text-warning text-uppercase">O</span>
                            </li>
                            <li>
                                <span class="mg-text-warning text-uppercase">Y</span>
                            </li>
                        </ul>
                        <div class="mg-word-image-hint text-center">
                            <img src="<?php echo base_url("webapp_asset/images/missing_letter_icon_1.svg"); ?>" alt="mGuru word hint" class="mg-hint-image">
                        </div>
                        <ul class="mg-options-wrapper list-unstyled list-inline">
                            <li class="mg-void">
                                <span class="mg-text-warning text-uppercase">D</span>
                            </li>
                            <li class="mg-void">
                                <span class="mg-text-warning text-uppercase">K</span>
                            </li>
                            <li class="mg-void">
                                <span class="mg-text-warning text-uppercase">B</span>
                            </li>
                            <li class="mg-void">
                                <span class="mg-text-warning text-uppercase">M</span>
                            </li>
                        </ul>
                    </div>
                    <!-- Please add/remove the hide class if this one is disable/enable -->
                    <div class="mg-missing-word hide">
                        <div class="mg-query-text text-center">
                            The boy ran away after stealing the old man's
                            <span class="mg-void" contenteditable></span>
                        </div>
                        <ul class="mg-options-wrapper list-unstyled list-inline">
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
                    <!-- Please add/remove the hide class if this one is disable/enable -->
                    <div class="mg-correct-image hide">
                        <div class="mg-image-text-hint text-uppercase mg-text-warning">
                            SUN
                        </div>
                        <ul class="mg-options-wrapper list-unstyled list-inline">
                            <li class="mg-void">
                                <img src="<?php echo base_url("webapp_asset/images/activity_clap_1.svg");?>" alt="mGuru Clap" class="mg-img">
                            </li>
                            <li class="mg-void">
                                <img src="<?php echo base_url("webapp_asset/images/activity_sun_1.svg");?>" alt="mGuru Clap" class="mg-img">
                            </li>
                            <li class="mg-void">
                                <img src="<?php echo base_url("webapp_asset/images/activity_tree_1.svg");?>" alt="mGuru Clap" class="mg-img">
                            </li>
                            <li class="mg-void">
                                <img src="<?php echo base_url("webapp_asset/images/activity_apple_1.svg");?>" alt="mGuru Clap" class="mg-img">
                            </li>
                        </ul>
                    </div>
                    <!-- Please add/remove the hide class if this one is disable/enable -->
                    <div class="mg-word-starts-with hide">
                        <div class="mg-image-text-hint text-uppercase mg-text-warning">
                            t
                        </div>
                        <ul class="mg-options-wrapper list-unstyled list-inline">
                            <li class="mg-void">
                                <img src="<?php echo base_url("webapp_asset/images/activity_clap_1.svg");?>" alt="mGuru Clap" class="mg-img">
                            </li>
                            <li class="mg-void">
                                <img src="<?php echo base_url("webapp_asset/images/activity_sun_1.svg");?>" alt="mGuru Clap" class="mg-img">
                            </li>
                            <li class="mg-void">
                                <img src="<?php echo base_url("webapp_asset/images/activity_tree_1.svg");?>" alt="mGuru Clap" class="mg-img">
                            </li>
                            <li class="mg-void">
                                <img src="<?php echo base_url("webapp_asset/images/activity_apple_1.svg");?>" alt="mGuru Clap" class="mg-img">
                            </li>
                        </ul>
                    </div>
                    <!-- Please add/remove the hide class if this one is disable/enable -->
                    <div class="mg-correct-word hide">
                        <ul class="mg-image-wrapper list-unstyled list-inline">
                            <li class="mg-void">
                                <img src="<?php echo base_url("webapp_asset/images/activity_sun_1.svg");?>" alt="mGuru Clap" class="mg-img">
                            </li>
                        </ul>
                        <ul class="mg-options-wrapper list-unstyled list-inline">
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
                                <span class="mg-text-black">Sun</span>
                            </li>
                        </ul>
                    </div>
                    <!-- Please add/remove the hide class if this one is disable/enable -->
                    <div class="mg-correct-word mg-listen-sound hide">
                        <div class="mg-image-text-hint text-uppercase mg-text-disabled">
                            B<span class="mg-text-warning">A</span>LL
                        </div>
                        <ul class="mg-image-wrapper list-unstyled list-inline">
                            <li class="mg-void">
                                <img src="<?php echo base_url("webapp_asset/images/ball.png"); ?>" alt="mGuru Ball" class="mg-img">
                                <a href="#" class="mg-btn-warning mg-btn-rounded mg-image-text text-center">बॉल</a>
                            </li>
                        </ul>
                    </div>
                    <!-- Please add/remove the hide class if this one is disable/enable -->
                    <div class="mg-correct-word mg-listen-sound mg-trace-letter">
                        <div class="mg-image-text-hint text-uppercase mg-text-disabled">
                            <span class="mg-text-danger">A</span>PPLE
                            <div class="mg-image-text-hint mg-small">
                                <span class="mg-text-danger">ऍ</span>पलअ
                            </div>
                        </div>
                        <ul class="mg-image-wrapper list-unstyled list-inline">
                            <li class="mg-void">
                                <img src="<?php echo base_url("webapp_asset/images/activity_apple_1.svg");?>" alt="mGuru Apple" class="mg-img">
                            </li>
                        </ul>
                    </div>
                    <!-- Please add/remove the hide class if this one is disable/enable -->
                    <div class="mg-missing-word mg-true-false hide">
                        <div class="mg-query-text text-center">
                            One who maintains cleanliness keeps away diseases
                        </div>
                        <ul class="mg-options-wrapper list-unstyled list-inline">
                            <li class="mg-void">
                                <span class="mg-text-black">True</span>
                            </li>
                            <li class="mg-void">
                                <span class="mg-text-black">False</span>
                            </li>
                        </ul>
                    </div>
                    <!-- Please add/remove the hide class if this one is disable/enable -->
                    <div class="mg-missing-word mg-find-true hide">
                        <ul class="mg-options-wrapper list-unstyled list-inline">
                            <li class="mg-void">
                                <span class="mg-text-black">The boy stole the old man’s wallet and ran away.</span>
                            </li>
                            <li class="mg-void">
                                <span class="mg-text-black">The boy stole the old man’s glasses and ran away.</span>
                            </li>
                            <li class="mg-void">
                                <span class="mg-text-black">The old man stole the boy’s wallet and ran away.</span>
                            </li>
                            <li class="mg-void">
                                <span class="mg-text-black">The boy stole the old man’s bag and ran away.</span>
                            </li>
                        </ul>
                    </div>
                    <!-- Please add/remove the hide class if this one is disable/enable -->
                    <div class="mg-letter-sound hide">
                        <ul class="mg-activity-sound-wrapper list-unstyled list-inline">
                            <li class="mg-void">
                                <img src="<?php echo base_url("webapp_asset/images/volume_icon_1.svg"); ?>" alt="mGuru Listen" class="mg-listen">
                                <img src="<?php echo base_url("webapp_asset/images/mg-icon-play.svg"); ?>" alt="mGuru Play" class="mg-pause hide">
                            </li>
                        </ul>
                        <ul class="mg-options-wrapper list-unstyled list-inline">
                            <li class="mg-void">
                                <span class="mg-text-warning text-uppercase">B</span>
                            </li>
                            <li class="mg-void">
                                <span class="mg-text-warning text-uppercase">A</span>
                            </li>
                            <li class="mg-void">
                                <span class="mg-text-warning text-uppercase">L</span>
                            </li>
                            <li class="mg-void">
                                <span class="mg-text-warning text-uppercase">L</span>
                            </li>
                        </ul>
                    </div>
                    <!-- Please add/remove the hide class if this one is disable/enable -->
                    <div class="mg-arrange-phrase hide">
                        <div class="mg-query-text text-center">
                            <span class="mg-void">&nbsp;</span>
                        </div>
                        <ul class="mg-options-wrapper list-unstyled list-inline">
                            <li class="mg-void">
                                <span class="mg-text-black">up</span>
                                <small class="mg-counter"></small>
                            </li>
                            <li class="mg-void">
                                <span class="mg-text-black">mind</span>
                                <small class="mg-counter"></small>
                            </li>
                            <li class="mg-void">
                                <span class="mg-text-black">make</span>
                                <small class="mg-counter"></small>
                            </li>
                            <li class="mg-void">
                                <span class="mg-text-black">one's</span>
                                <small class="mg-counter"></small>
                            </li>
                        </ul>
                    </div>
                    <!-- Please add/remove the hide class if this one is disable/enable -->
                    <div class="mg-correct-word mg-listen-sound mg-drag-drop hide">
                        <div class="mg-image-text-hint text-uppercase mg-drop-wrapper">
                            <div class="mg-text-disabled text-uppercase mg-drop-target">B</div>
                            <div class="mg-text-disabled text-uppercase">A</div>
                        </div>
                        <ul class="mg-image-wrapper list-unstyled list-inline">
                            <li class="mg-void">
                                <img src="<?php echo base_url("webapp_asset/images/ball.png"); ?>" alt="mGuru Ball" class="mg-img">
                                <a href="#" class="mg-btn-warning mg-btn-rounded mg-image-text text-center text-uppercase">Ball</a>
                            </li>
                        </ul>
                        <div class="mg-drag-wrapper">
                            <img src="<?php echo base_url("webapp_asset/images/mg-motu-text-holder.svg"); ?>" alt="mGuru Motu" class="mg-motu">
                            <div class="mg-drag-target text-uppercase mg-text-warning mg-image-text-hint">B</div>
                        </div>
                    </div>
                    <!-- Please add/remove the hide class if this one is disable/enable -->
                    <div class="mg-say hide">
                        <div class="mg-image-text-hint text-uppercase mg-drop-wrapper">
                            <div class="mg-text-disabled text-uppercase">BA</div>
                        </div>
                        <ul class="mg-activity-sound-wrapper list-unstyled list-inline">
                            <li class="mg-void">
                                <img src="<?php echo base_url("webapp_asset/images/volume_icon_1.svg"); ?>" alt="mGuru Listen" class="mg-say-img mg-listen" data-step=1 />
                                <img src="<?php echo base_url("webapp_asset/images/mg-icon-play.svg"); ?>" alt="mGuru Play" class="mg-say-img mg-pause hide"  data-step=2 />
                                <img src="<?php echo base_url("webapp_asset/images/record_icon_1.svg"); ?>" alt="mGuru Play" class="mg-say-img mg-record hide"  data-step=3 />
                                <img src="<?php echo base_url("webapp_asset/images/mg-recording.svg"); ?>" alt="mGuru Play" class="mg-say-img mg-recording hide"  data-step=4 />
                            </li>
                        </ul>
                        <ul class="mg-options-wrapper list-unstyled list-inline">
                            <li>
                                <img src="<?php echo base_url("webapp_asset/images/mg-motu-listen.svg"); ?>" alt="mGuru Motu" class="mg-motu-listen">
                                <img src="<?php echo base_url("webapp_asset/images/mg-motu-recording.svg"); ?>" alt="mGuru Motu" class="mg-motu-record hide">
                            </li>
                        </ul>
                    </div>
                    <a href="#" class="mg-btn-danger mg-btn-rounded mg-reply text-center text-uppercase">Try Again</a>
                    <!-- Please add/remove the mg-btn-disabled class to disable/enable the button -->
                    <a href="#" class="mg-btn-disabled mg-btn-danger mg-btn-rounded mg-submit text-center text-uppercase">Submit</a>
                    <div class="progress mg-progress">
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                            <span class="sr-only">60% Completed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Please add/remove the activity as per the requirement -->
    <div class="mg-activity-2 hide">
        <img src="<?php echo base_url("webapp_asset/images/story-complete-bg.svg"); ?>" alt="mGuru Stories" class="mg-activity-main-bg">
        <div class="container-fluid">
            <div class="row-fluid clearfix">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <h1 class="mg-h1-header">
                        Lorem Ipsum
                    </h1>
                    <div class="mg-quest-help-text">
                        Lorem Ipsum dummy text
                    </div>
                </div>
            </div>
            <div class="row mg-daily-activity-wrapper clearfix">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="mg-correct-word mg-new-sound">
                        <ul class="mg-options-wrapper list-unstyled list-inline">
                            <li class="mg-void">
                                <span class="mg-text-primary">A</span>
                            </li>
                            <li class="mg-void">
                                <span class="mg-text-primary">B</span>
                            </li>
                            <li class="mg-void">
                                <span class="mg-text-primary">C</span>
                            </li>
                            <li class="mg-void">
                                <span class="mg-text-primary">D</span>
                            </li>
                        </ul>
                        <div class="mg-motu-mango-wrapper">
                            <img src="<?php echo base_url("webapp_asset/images/motu_2_with_shadow_1.svg"); ?>" alt="mGuru Motu" class="mg-motu">
                            <div class="mg-mango-points">
                                <img src="<?php echo base_url("webapp_asset/images/sounds_motu_bubble_1.svg"); ?>" alt="mGuru Bubble" class="mg-bubble">
                                <img src="<?php echo base_url("webapp_asset/images/mango_1_main_1.svg"); ?>" alt="mGuru Mango" class="mg-mango">
                                <span class="mg-mango-score">40</span>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="mg-btn-disabled mg-btn-danger mg-btn-rounded mg-submit text-center text-uppercase">Start</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Show if correct -->
    <div class="mg-active-correct hide">
        <img src="<?php echo base_url("webapp_asset/images/correct.jpg"); ?>" alt="mGuru Correct" class="mg-activity-main-bg">
        <div class="container-fluid">
            <div class="row-fluid clearfix">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <h1 class="mg-h1-header mg-text-warning mg-text-lg">
                        Correct
                    </h1>
                </div>
            </div>
            <div class="row mg-daily-activity-wrapper clearfix">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="mg-correct">
                        <ul class="mg-options-wrapper list-unstyled list-inline">
                            <li class="mg-void">
                                <img src="<?php echo base_url("webapp_asset/images/correct_sign_1.svg"); ?>" alt="mGuru Correct Sign" class="mg-img">
                            </li>
                        </ul>
                    </div>
                    <img src="<?php echo base_url("webapp_asset/images/motu-9-with-shadow.png"); ?>" alt="mGuru Motu" class="mg-motu">
                </div>
            </div>
        </div>
    </div>

    <!-- Show if incorrect -->
    <div class="mg-active-incorrect hide">
        <img src="<?php echo base_url("webapp_asset/images/incorrect.jpg"); ?>" alt="mGuru Correct" class="mg-activity-main-bg">
        <div class="container-fluid">
            <div class="row-fluid clearfix">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <h1 class="mg-h1-header mg-text-danger mg-text-lg">
                        Incorrect
                    </h1>
                </div>
            </div>
            <div class="row mg-daily-activity-wrapper clearfix">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="mg-correct">
                        <ul class="mg-options-wrapper list-unstyled list-inline">
                            <li class="mg-void">
                                <img src="<?php echo base_url("webapp_asset/images/incorrect_sign_1.svg"); ?>" alt="mGuru Incorrect Sign" class="mg-img">
                            </li>
                        </ul>
                    </div>
                    <img src="<?php echo base_url("webapp_asset/images/motu-incorrect.jpg"); ?>" alt="mGuru Motu" class="mg-motu">
                </div>
            </div>
        </div>
    </div>

    <!-- Show on successful completion of an activity -->
    <div class="mg-active-complete hide">
        <img src="<?php echo base_url("webapp_asset/images/story-complete-bg.svg"); ?>" alt="mGuru Correct" class="mg-activity-main-bg">
        <div class="container-fluid">
            <div class="row-fluid clearfix">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <h1 class="mg-h1-header mg-text-danger">
                        Good job!
                    </h1>
                    <div class="mg-quest-help-text">
                        You feed me well.
                    </div>
                </div>
            </div>
            <div class="row mg-daily-activity-wrapper clearfix">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="mg-activity-score">
                        <h2 class="mg-text-lg mg-text-white">
                            100
                            <img src="<?php echo base_url("webapp_asset/images/mango_1_main_1.svg"); ?>" alt="mGuru Mango" class="mg-mango">
                        </h2>
                    </div>
                    <div class="mg-star-rating">
                        <h3 class="mg-text-white text-uppercase">Star Rating</h3>
                        <img src="<?php echo base_url("webapp_asset/images/result_ribbon_1.svg"); ?>" alt="mGuru Star Ribbon" class="mg-ribbon">
                        <img src="<?php echo base_url("webapp_asset/images/report_star_2.svg"); ?>" alt="mGuru Star" class="mg-star mg-star1">
                        <img src="<?php echo base_url("webapp_asset/images/report_star_2.svg"); ?>" alt="mGuru Star" class="mg-star mg-star2">
                        <img src="<?php echo base_url("webapp_asset/images/report_star_1.svg"); ?>" alt="mGuru Star" class="mg-star mg-star3">
                    </div>
                    <img src="<?php echo base_url("webapp_asset/images/mg-motu-feed.png"); ?>" alt="mGuru Motu" class="mg-motu">
                    <img src="<?php echo base_url("webapp_asset/images/mg-bucket-with-shadow.png"); ?>" alt="mGuru Motu" class="mg-bucket">
                    <small class="mg-result-score mg-text-white">60750</small>
                    <a href="#" class="mg-btn-danger mg-btn-rounded mg-next text-center text-uppercase">Next</a>
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
                    Congratulation
                </h1>
                <p class="mg-modal-desc">
                    You finished
                </p>
                <h3>b,c,d,f</h3>
                <img src="<?php echo base_url("webapp_asset/images/mg-motu-congrats.svg"); ?>" alt="mGuru Motu" class="mg-motu">
                <div class="progress mg-progress">
                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%">
                    </div>
                </div>
                <h2 class="mg-h1-header">
                    10%
                </h2>
                <a href="javascript:void(0);" class="mg-unlock-btn text-uppercase">View Report Card</a>
                <a href="javascript:void(0);" data-dismiss="modal" class="mg-btn-back">Back</a>
            </div>
        </div>
    </div>
</div>
