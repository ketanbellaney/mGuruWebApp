<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>
<section id="stories" class="mg-videos" style='background: url(<?php echo base_url("webapp_asset/images/stories-bg.png"); ?>);    background-position-y: -124px;height: 580px; overflow: hidden;'>

    <div class="container-fluid">
        <div class="row-fluid clearfix">
            <div class="col-md-8 col-md-offset-2 text-center">
                <h1 class="mg-h1-header" style='margin-top: 15px;margin-bottom: 0px;'>
                    <?php echo @$_translation->array[$_lang_map]->item[211]; ?>
                </h1>
            </div>
        </div>
        <div class="row-fluid mg-stories-videos-wrapper clearfix">
            <div class="col-md-8 col-md-offset-2">
                <div class="row">
                    <div class="mg-level-search-wrapper">
                        <div class="col-md-6">
                            <div class="mg-sub-nav" style='width: 175px;'>
                                <ul class="list-unstyled list-inline text-center">
                                    <li <?php if($level == 1) { ?>class="active" <?php } ?>>
                                        <a href="<?php echo site_url("stories/video"); ?>?level=1">Level 1</a>
                                    </li>
                                    <li <?php if($level == 2) { ?>class="active" <?php } ?>>
                                        <a href="<?php echo site_url("stories/video"); ?>?level=2">Level 2</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="javascript:void(0);" class="mg-search">
                                <img src="<?php echo base_url("webapp_asset/images/search_1.svg"); ?>" alt="mGuru Search">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12 mg-search-box-wrapper hide">
                        <form id='searchform'  method='post' action="<?php echo site_url("stories/video"); ?>" >
                        <input type="text" name="keyword" required>
                        <a href="javascript:void(0);" class="mg-search-hide">
                            <img src="<?php echo base_url("webapp_asset/images/back_1.svg"); ?>" alt="mGuru Search Hide">
                        </a>
                        <a type='submit' href="#" onclick="document.getElementById('searchform').submit();" class="mg-search-btn">Search</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid clearfix mg-stories-videos">
            <div class="col-md-8 col-md-offset-2 mg-stories-videos-wrapper-inner">
                <div class="row">

                    <?php if (@$videos[0]->id != '') { ?>
                    <div class="col-md-6">
                        <a href='<?php echo site_url("stories/vstart/" . $videos[0]->id ); ?>' ><div class="mg-video mg-video-lg" >
                            <?php
                                $ytid = explode("?v=",$videos[0]->link);
                                if(!isset($ytid[1])) {
                                    $ytid[1] = "Vp2SIPuPT80";
                                }
                            ?>
                            <img src='https://img.youtube.com/vi/<?php echo $ytid[1]; ?>/hqdefault.jpg' style='height: 100%; width: 100%;' />
                            <div class="mg-video-bottom-overlay text-left">
                                <?php echo $videos[0]->title; ?>
                            </div>
                        </div></a>
                    </div>
                    <?php } else { ?>
                        <div class="col-md-6">
                                <h3>No result found for keyword <b>"<?php echo $keyword; ?>"</b>.</h3>
                        </div>
                    <?php } ?>
                    <div class="col-md-6">
                        <div class="row clearfix">
                            <?php if (@$videos[1]->id != '') { ?>
                            <div class="col-md-6">
                                <a href='<?php echo site_url("stories/vstart/" . $videos[1]->id ); ?>' ><div class="mg-video mg-video-sm">
                                    <?php
                                        $ytid = explode("?v=",$videos[1]->link);
                                        if(!isset($ytid[1])) {
                                            $ytid[1] = "Vp2SIPuPT80";
                                        }
                                    ?>
                                    <img src='https://img.youtube.com/vi/<?php echo $ytid[1]; ?>/hqdefault.jpg' style='height: 100%; width: 100%;' />
                                    <div class="mg-video-bottom-overlay text-left">
                                        <?php echo $videos[1]->title; ?>
                                    </div>
                                </div></a>
                            </div>
                            <?php } ?>
                            <?php if (@$videos[2]->id != '') { ?>
                            <div class="col-md-6">
                                <a href='<?php echo site_url("stories/vstart/" . $videos[2]->id ); ?>' ><div class="mg-video mg-video-sm">
                                    <?php
                                        $ytid = explode("?v=",$videos[2]->link);
                                        if(!isset($ytid[1])) {
                                            $ytid[1] = "Vp2SIPuPT80";
                                        }
                                    ?>
                                    <img src='https://img.youtube.com/vi/<?php echo $ytid[1]; ?>/hqdefault.jpg' style='height: 100%; width: 100%;' />
                                    <div class="mg-video-bottom-overlay text-left">
                                        <?php echo $videos[2]->title; ?>
                                    </div>
                                </div></a>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="row clearfix">
                            <?php if (@$videos[3]->id != '') { ?>
                            <div class="col-md-6">
                                <a href='<?php echo site_url("stories/vstart/" . $videos[3]->id ); ?>' ><div class="mg-video mg-video-sm">
                                    <?php
                                        $ytid = explode("?v=",$videos[3]->link);
                                        if(!isset($ytid[1])) {
                                            $ytid[1] = "Vp2SIPuPT80";
                                        }
                                    ?>
                                    <img src='https://img.youtube.com/vi/<?php echo $ytid[1]; ?>/hqdefault.jpg' style='height: 100%; width: 100%;' />
                                    <div class="mg-video-bottom-overlay text-left">
                                        <?php echo $videos[3]->title; ?>
                                    </div>
                                </div></a>
                            </div>
                            <?php } ?>
                            <?php if (@$videos[4]->id != '') { ?>
                            <div class="col-md-6">
                                <a href='<?php echo site_url("stories/vstart/" . $videos[4]->id ); ?>' ><div class="mg-video mg-video-sm">
                                    <?php
                                        $ytid = explode("?v=",$videos[4]->link);
                                        if(!isset($ytid[1])) {
                                            $ytid[1] = "Vp2SIPuPT80";
                                        }
                                    ?>
                                    <img src='https://img.youtube.com/vi/<?php echo $ytid[1]; ?>/hqdefault.jpg' style='height: 100%; width: 100%;' />
                                    <div class="mg-video-bottom-overlay text-left">
                                        <?php echo $videos[4]->title; ?>
                                    </div>
                                </div></a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <?php
                        for($ii = 5 ; $ii < count($videos) ; $ii++ ) {
                    ?>
                              <div class="col-md-3">
                                  <a href='<?php echo site_url("stories/vstart/" . $videos[$ii]->id ); ?>' ><div class="mg-video mg-video-sm">
                                        <?php
                                            $ytid = explode("?v=",$videos[$ii]->link);
                                            if(!isset($ytid[1])) {
                                                $ytid[1] = "Vp2SIPuPT80";
                                            }
                                        ?>
                                      <img src='https://img.youtube.com/vi/<?php echo $ytid[1]; ?>/hqdefault.jpg' style='height: 100%; width: 100%;' />
                                      <div class="mg-video-bottom-overlay text-left">
                                          <?php echo $videos[$ii]->title; ?>
                                      </div>
                                  </div></a>
                              </div>
                    <?php
                            if($ii % 4 == 0 ) {
                                echo "</div><div class='row clearfix'> ";
                            }
                        }
                    ?>

                </div>
            </div>
        </div>
    </div>
</section>

<style>
.mg-video {
     overflow: hidden;
     box-shadow: 2px 2px #cccccc;
}

.mg-video-bottom-overlay {
    border-top: 2px solid #00DC1D;
}

body {
    height: 100%;
    overflow: hidden !important;
}
</style>