<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>
<section id="explore" class="wordybirdy">
    <img src="<?php echo base_url("webapp_asset/images/wordy-birdy-main-bg.png"); ?>" alt="mGuru Wordy Birdy" class="mg-explore-main-bg">
    <div class="container-fluid">
        <div class="row-fluid clearfix">
            <div class="col-md-2 text-center">
                <img src="<?php echo base_url("webapp_asset/images/plane_1.svg"); ?>" alt="mGuru Plane" class="mg-plane">
            </div>
            <div class="col-md-8 text-center">
                <h1 class="mg-h1-header">
                    <?php echo $world_name; ?>
                    <!-- <img class="mg-icon-hint" data-toggle="tooltip" data-placement="bottom" title="This is mGuru hint" src="<?php echo base_url("webapp_asset/images/hint_1.svg"); ?>" alt="mGuru Hint"> -->
                </h1>
                <!-- <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#mgWordyBirdyModal"> Launch modal 1 </button>
                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#mgWordyBirdyModal2"> Launch modal 2 </button>    -->
            </div>
            <div class="col-md-2 text-right">
                <img src="<?php echo base_url("webapp_asset/images/planet_1.svg"); ?>" alt="mGuru Planet" class="mg-planet">
            </div>
        </div>
        <div class="row-fluid mg-wordy-birdy-wrapper clearfix">
            <div class="col-md-12">
                <div class="mg-sub-nav">
                    <!-- <ul class="list-unstyled list-inline text-center">
                        <?php
                            $mmm = 0;
                            foreach($worlds as $val) {
                                if($mmm == 0 ) {
                                    echo "<li class='active'  data-target='#mg-wordy-birdy-carousel' data-slide-to='$mmm'>
                                        <a href='javascript:void(0);'>".$val['title']."</a>
                                    </li>";
                                } else {
                                    echo "<li data-target='#mg-wordy-birdy-carousel' data-slide-to='$mmm'>
                                        <a href='javascript:void(0);'>".$val['title']."</a>
                                    </li>";
                                }

                                $mmm++;
                            }
                        ?>
                    </ul> -->
                </div>
            </div>
        </div>
        <div id="mg-wordy-birdy-carousel" class="carousel slide" data-interval="300000000" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php
                            $mmm = 0;
                            $mmm1 = 0;
                            foreach($worlds as $val1) {
                                foreach($val1['sub_activity_details'] as $val) {
                                    if($mmm == 0 ) {
                                        echo "<li data-target='#mg-wordy-birdy-carousel' data-slide-to='$mmm1' class='active'></li>";
                                        $mmm1++;
                                    } elseif ($mmm % 8 == 0) {
                                        echo "<li data-target='#mg-wordy-birdy-carousel' data-slide-to='$mmm1'></li>";
                                        $mmm1++;
                                    }
                                    $mmm++;
                                }
                            }
                        ?>
            </ol>
            <div class="row-fluid clearfix">
                <div class="col-md-6 col-md-offset-3">
                    <div class="carousel-inner" role="listbox">
                        <?php
                            $mmm = 0;
                            $iii = 0;
                            foreach($worlds as $val1) {
                                if($mmm == 0 ) {
                                    echo "<div class='item active'><div class='row-fluid clearfix mg-margin-btn-sm'>";
                                } else {
                                    //echo "<div class='item'>";
                                }
                            ?>


                                <?php

                                    foreach($val1['sub_activity_details'] as $val) {
                                        if($val['activityStatus'] == 'close') {
                                    ?>
                                                <a href='<?php echo site_url("activity/".$val['id']."/start"); ?>' ><div class="col-md-3">
                                                    <div class="mg-item mg-item-white">
                                                        <div class="mg-item-counter mg-circle-xs mg-circle-yellow text-center"><?php echo $val['activityNumber']; ?></div>
                                                        <div class="mg-circle-sm mg-circle-yellow text-center">
                                                            <img src="<?php echo base_url("webapp_asset/images/words_icon_white_1.svg"); ?>" alt="mGuru Words" class="mg-img-sm">
                                                        </div>
                                                        <div class="mg-item-desc text-center">
                                                            <?php echo $val['activityName']; ?>
                                                        </div>
                                                        <div class="mg-item-overlay text-center">
                                                            <div class="mg-stars-wrapper text-center">
                                                                <?php
                                                                    if($val['activityStar'] >= 3) {
                                                                        echo "<img src='".base_url("webapp_asset/images/starinsky_2.svg")."' alt='mGuru Star' />";
                                                                        echo "<img src='".base_url("webapp_asset/images/starinsky_2.svg")."' alt='mGuru Star' />";
                                                                        echo "<img src='".base_url("webapp_asset/images/starinsky_2.svg")."' alt='mGuru Star' />";
                                                                    } else if($val['activityStar'] >= 2) {
                                                                        echo "<img src='".base_url("webapp_asset/images/starinsky_2.svg")."' alt='mGuru Star' />";
                                                                        echo "<img src='".base_url("webapp_asset/images/starinsky_2.svg")."' alt='mGuru Star' />";
                                                                        echo "<img src='".base_url("webapp_asset/images/starinsky_3.png")."' alt='mGuru Star' />";
                                                                    }  else if($val['activityStar'] >= 1) {
                                                                        echo "<img src='".base_url("webapp_asset/images/starinsky_2.svg")."' alt='mGuru Star' />";
                                                                        echo "<img src='".base_url("webapp_asset/images/starinsky_3.png")."' alt='mGuru Star' />";
                                                                        echo "<img src='".base_url("webapp_asset/images/starinsky_3.png")."' alt='mGuru Star' />";
                                                                    } else  {
                                                                        echo "<img src='".base_url("webapp_asset/images/starinsky_3.png")."' alt='mGuru Star' />";
                                                                        echo "<img src='".base_url("webapp_asset/images/starinsky_3.png")."' alt='mGuru Star' />";
                                                                        echo "<img src='".base_url("webapp_asset/images/starinsky_3.png")."' alt='mGuru Star' />";
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> </a>
                                    <?php
                                        } else if($val['activityStatus'] == 'open') {
                                    ?>

                                               <a href='<?php echo site_url("activity/".$val['id']."/start"); ?>' ><div class="col-md-3">
                                                    <div class="mg-item mg-item-yellow">
                                                        <div class="mg-item-counter mg-circle-xs mg-circle-white text-center"><?php echo $val['activityNumber']; ?></div>
                                                        <div class="mg-mango-wrapper">
                                                            <div class="mg-circle-sm mg-circle-white text-center">
                                                                <img src="<?php echo base_url("webapp_asset/images/mango_1_main_1.svg"); ?>" alt="mGuru Mango" class="mg-img-mango">
                                                                <small class="mg-score"><?php echo $val['activityScore']; ?></small>
                                                            </div>
                                                        </div>
                                                        <div class="mg-circle-md mg-circle-violet text-center">
                                                            <img src="<?php echo base_url("webapp_asset/images/sounds_icon_white_1.svg"); ?>" alt="mGuru Words" class="mg-img-md">
                                                        </div>
                                                    </div>
                                                </div> </a>
                                    <?php
                                        } else if($val['activityStatus'] == 'locked') {
                                    ?>
                                              <a href='<?php echo site_url("activity/".$val['id']."/start"); ?>'  ><div class="col-md-3">
                                                    <div class="mg-item mg-item-gray">
                                                        <div class="mg-item-counter mg-circle-xs mg-circle-white text-center"><?php echo $val['activityNumber']; ?></div>
                                                        <div class="mg-mango-wrapper">
                                                            <div class="mg-circle-sm mg-circle-white text-center">
                                                                <img src="<?php echo base_url("webapp_asset/images/mango_1_main_1.svg"); ?>" alt="mGuru Mango" class="mg-img-mango">
                                                                <small class="mg-score"><?php echo $val['activityScore']; ?></small>
                                                            </div>
                                                        </div>
                                                        <div class="mg-circle-md mg-circle-gray text-center">
                                                            <img src="<?php echo base_url("webapp_asset/images/words_icon_white_1.svg"); ?>" alt="mGuru Words" class="mg-img-md">
                                                        </div>
                                                    </div>
                                                </div>  </a>
                                    <?php
                                        }

                                        $iii++;

                                        if($iii % 8 == 0 ) {
                                            echo "</div>
                                            </div>
                                            <div class='item'><div class='row-fluid clearfix mg-margin-btn-sm'>
                                                    ";
                                        } else if($iii % 4 == 0 ) {
                                            echo "</div>
                                                    <div class='row-fluid clearfix'>";
                                        }


                                    }
                                ?>



                        <?php
                                $mmm++;
                            }
                        ?>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="left carousel-control" href="#mg-wordy-birdy-carousel" role="button" data-slide="prev">
                <img src="<?php echo base_url("webapp_asset/images/carousel-left.png"); ?>" alt="mGuru Left">
            </a>
            <a class="right carousel-control" href="#mg-wordy-birdy-carousel" role="button" data-slide="next">
                <img src="<?php echo base_url("webapp_asset/images/carousel-right.png"); ?>" alt="mGuru Right">
            </a>
        </div>
    </div>
</section>

<div class="mg-modal modal fade" role="dialog" id="mgWordyBirdyModal" tabindex="-1" aria-labelledby="mgWordyBirdyModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="<?php echo base_url("webapp_asset/images/popup_close_1.svg"); ?>" alt="mGuru Pop-up close">
                </button>
            </div>
            <div class="modal-body text-center">
                <h1 class="mg-modal-title">
                    <?php echo @$_translation->array[$_lang_map]->item[41]; ?>
                </h1>
                <p class="mg-modal-desc">
                    <?php echo @$_translation->array[$_lang_map]->item[93]; ?>
                </p>
                <div class="mg-motu-lock-wrapper">
                    <img src="<?php echo base_url("webapp_asset/images/motu_6_without_shadow_1.svg"); ?>" alt="mGuru Motu" class="mg-motu">
                    <img src="<?php echo base_url("webapp_asset/images/locked_1.svg"); ?>" alt="mGuru Lock" class="mg-lock">
                </div>
                <a href="javascript:void(0);" class="mg-unlock-btn"><?php echo @$_translation->array[$_lang_map]->item[43]; ?></a>
                <a href="javascript:void(0);" data-dismiss="modal" class="mg-btn-back"><?php echo @$_translation->array[$_lang_map]->item[27]; ?></a>
            </div>
        </div>
    </div>
</div>

<div class="mg-modal modal fade" role="dialog" id="mgWordyBirdyModal2" tabindex="-1" aria-labelledby="mgWordyBirdyModal2Label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="<?php echo base_url("webapp_asset/images/popup_close_1.svg"); ?>" alt="mGuru Pop-up close">
                </button>
            </div>
            <div class="modal-body text-center">
                <h1 class="mg-modal-title">
                    <?php echo @$_translation->array[$_lang_map]->item[41]; ?>
                </h1>
                <!-- <p class="mg-modal-desc">
                    In this level you'll learn different Lorem<br>ipsum dolar sit amet, consectetur adipiscing<br>elit, sed do eiusmod tempor incididunt ut labore et.
                </p> -->
                <div class="mg-motu-lock-wrapper">
                    <img src="<?php echo base_url("webapp_asset/images/motu_2_without_shadow_1.svg"); ?>" alt="mGuru Motu" class="mg-motu">
                </div>
                <a href="javascript:void(0);" class="mg-unlock-btn"><?php echo @$_translation->array[$_lang_map]->item[92]; ?></a>
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
