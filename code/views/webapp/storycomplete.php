<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>
<section id="stories-complete" class="story-complete" style='background: url(<?php echo base_url("webapp_asset/images/story-complete-bg.jpg"); ?>);    background-position-y: -124px;height: 580px; overflow: hidden; padding-top: 20px;'>
    <div class="container-fluid">
        <div class="row-fluid clearfix">
            <div class="col-md-12 text-center">
                <h1 class="mg-h1-header"  style='margin-top: 0px;margin-bottom: 0px;'>
                    <?php echo @$_translation->array[$_lang_map]->item[49]; ?>
                </h1>
                <div class="mg-quest-help-text"  style='margin-top: 25px; margin-bottom: 40px;'>
                    <?php echo @$_translation->array[$_lang_map]->item[50]; ?>
                </div>
                <a href="<?php echo site_url("stories/books"); ?>" class="mg-btn-white mg-btn-rounded text-center"><?php echo @$_translation->array[$_lang_map]->item[51]; ?></a>
                <?php
                    if($question_count > 0 ) {
                ?>
                        <a href="<?php echo site_url("stories/questions/" . $story_id); ?>" class="mg-btn-danger mg-btn-rounded text-center"><?php echo @$_translation->array[$_lang_map]->item[52]; ?></a>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="row-fluid clearfix mg-other-stories" style='margin-top: 50px;'>
            <div class="col-md-8 col-md-offset-2 text-center">
                <div class="mg-other-stories-title"><?php echo @$_translation->array[$_lang_map]->item[51]; ?></div>

                <?php foreach($other_stories as $val) { ?>
                    <div class="col-md-3">
                        <a href='<?php echo site_url("stories/start/" . $val->id ); ?>' ><div class="mg-video mg-video-sm">
                            <img src='<?php echo base_url("story/" . $val->image) ?>' style='height: 100%; width: 100%;' />
                            <div class="mg-video-bottom-overlay text-left">
                                <?php echo $val->name; ?>
                            </div>
                        </div></a>
                    </div>
                <?php } ?>
                <!--<a href="#" class="mg-btn-danger mg-btn-rounded mg-start text-center">Start</a> -->
            </div>
        </div>
    </div>
    <br style='clear: both;' />
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