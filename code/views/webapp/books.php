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
                    <?php echo @$_translation->array[$_lang_map]->item[210]; ?>
                </h1>
            </div>
        </div>
        <div class="row-fluid mg-stories-videos-wrapper clearfix">
            <div class="col-md-8 col-md-offset-2">
                <div class="row">
                    <div class="mg-level-search-wrapper">
                        <div class="col-md-6">
                            <div class="mg-sub-nav">
                                <ul class="list-unstyled list-inline text-center">
                                    <li <?php if($level == 1) { ?>class="active" <?php } ?>>
                                        <a href="<?php echo site_url("stories/books"); ?>?level=1">Level 1</a>
                                    </li>
                                    <li <?php if($level == 2) { ?>class="active" <?php } ?>>
                                        <a href="<?php echo site_url("stories/books"); ?>?level=2">Level 2</a>
                                    </li>
                                    <li <?php if($level == 3) { ?>class="active" <?php } ?>>
                                        <a href="<?php echo site_url("stories/books"); ?>?level=3">Level 3</a>
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
                        <form id='searchform'  method='post' action="<?php echo site_url("stories/books"); ?>" >
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

                    <?php if (@$stories[0]->id != '') { ?>
                    <div class="col-md-6">
                        <a href='<?php echo site_url("stories/start/" . $stories[0]->id ); ?>' ><div class="mg-video mg-video-lg" >
                            <img src='<?php echo base_url("story/" . $stories[0]->image) ?>' style='height: 100%; width: 100%;' />
                            <div class="mg-video-bottom-overlay text-left">
                                <?php echo $stories[0]->name; ?>
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

                            <?php if (@$stories[1]->id != '') { ?>
                            <div class="col-md-6">
                                <a href='<?php echo site_url("stories/start/" . $stories[1]->id ); ?>' ><div class="mg-video mg-video-sm">
                                    <img src='<?php echo base_url("story/" . $stories[1]->image) ?>' style='height: 100%; width: 100%;' />
                                    <div class="mg-video-bottom-overlay text-left">
                                        <?php echo $stories[1]->name; ?>
                                    </div>
                                </div></a>
                            </div>
                            <?php } ?>
                            <?php if (@$stories[2]->id != '') { ?>
                            <div class="col-md-6">
                                <a href='<?php echo site_url("stories/start/" . $stories[2]->id ); ?>' ><div class="mg-video mg-video-sm">
                                    <img src='<?php echo base_url("story/" . $stories[2]->image) ?>' style='height: 100%; width: 100%;' />
                                    <div class="mg-video-bottom-overlay text-left">
                                        <?php echo $stories[2]->name; ?>
                                    </div>
                                </div></a>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="row clearfix">
                            <?php if (@$stories[3]->id != '') { ?>
                            <div class="col-md-6">
                                <a href='<?php echo site_url("stories/start/" . $stories[3]->id ); ?>' ><div class="mg-video mg-video-sm">
                                    <img src='<?php echo base_url("story/" . $stories[3]->image) ?>' style='height: 100%; width: 100%;' />
                                    <div class="mg-video-bottom-overlay text-left">
                                        <?php echo $stories[3]->name; ?>
                                    </div>
                                </div></a>
                            </div>
                            <?php } ?>
                            <?php if (@$stories[4]->id != '') { ?>
                            <div class="col-md-6">
                                <a href='<?php echo site_url("stories/start/" . $stories[4]->id ); ?>' ><div class="mg-video mg-video-sm">
                                    <img src='<?php echo base_url("story/" . $stories[4]->image) ?>' style='height: 100%; width: 100%;' />
                                    <div class="mg-video-bottom-overlay text-left">
                                        <?php echo $stories[4]->name; ?>
                                    </div>
                                </div></a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <?php
                        for($ii = 5 ; $ii < count($stories) ; $ii++ ) {
                    ?>
                              <div class="col-md-3">
                                  <a href='<?php echo site_url("stories/start/" . $stories[$ii]->id ); ?>' ><div class="mg-video mg-video-sm">
                                      <img src='<?php echo base_url("story/" . $stories[$ii]->image) ?>' style='height: 100%; width: 100%;' />
                                      <div class="mg-video-bottom-overlay text-left">
                                          <?php echo $stories[$ii]->name; ?>
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

.footer {
    bottom: 0px !important;
}

body {
    height: 100%;
    overflow: hidden !important;
}


</style>