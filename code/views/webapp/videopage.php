<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>
<section id="stories" class="mg-videos mg-my-friends mg-story" style='background: url(<?php echo base_url("webapp_asset/images/stories-bg.png"); ?>);    background-position-y: -124px;height: 580px; overflow: hidden;'>
    <div class="container-fluid">
        <div class="row-fluid clearfix">
            <div class="col-md-8 col-md-offset-2 text-center">
                <h1 class="mg-h2-header" style='margin-top: 0px;margin-bottom: 0px;'>
                    <a href="#"   onclick='return checkreturnexit();'  data-target="#mgAreYouSureModal1" class="pull-left">
                        <img class="mg-icon-back" src="<?php echo base_url("webapp_asset/images/back_1.svg"); ?>" alt="mGuru Back">
                    </a>
                    <?php echo $video->title; ?>
                    <!-- <img class="mg-icon-hint" data-toggle="tooltip" data-placement="bottom" title="This is mGuru hint" src="<?php echo base_url("webapp_asset/images/hint_1.svg"); ?>" alt="mGuru Hint"> -->
                </h1>
            </div>
        </div>
        <div class="row-fluid mg-stories-videos-wrapper clearfix">
            <div class="col-md-8 col-md-offset-2">
                <div class="embed-responsive embed-responsive-16by9" style='padding-bottom: 40%;'>
                     <?php
                        $ytid = explode("?v=",$video->link);
                        if(!isset($ytid[1])) {
                            $ytid[1] = "Vp2SIPuPT80";
                        }
                    ?>
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $ytid[1]; ?>?rel=0&showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
            </div>
        </div>
        <div class="row-fluid mg-stories-videos-desc clearfix">
            <div class="col-md-8 col-md-offset-2" id='subtitles'>

            </div>
        </div>
        <div class="mg-stories-btn-wrapper">
            <div class="row-fluid mg-stories-videos-wrapper clearfix">
                <div class="col-md-8 col-md-offset-2">
                    <div class="col-md-6 text-left">

                    </div>
                    <div class="col-md-6 text-right">
                        <a href="<?php echo site_url("stories/vcomplete/".$video->id); ?>" class="mg-btn-next text-center"><?php echo @$_translation->array[$_lang_map]->item[180]; ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>

function checkreturnexit() {
    $("#mgAreYouSureModal1").modal('show');
    return false;
}

</script>



<div class="mg-modal mg-modal-bold modal fade" role="dialog" id="mgAreYouSureModal1" tabindex="-1" aria-labelledby="mgAreYouSureModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style='height: auto;'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="<?php echo base_url("webapp_asset/images/popup_close_1.svg"); ?>" alt="mGuru Pop-up close">
                    </button>
                </div>
                <div class="modal-body text-center">
                    <h1 class="mg-modal-title">
                        <?php echo @$_translation->array[$_lang_map]->item[135]; ?>
                    </h1>
                    <!--<p class="mg-modal-desc">
                        you want to exit this video?
                    </p> -->
                    <div class="mg-motu-lock-wrapper">
                        <img src="<?php echo base_url("webapp_asset/images/motu_6_without_shadow_1.svg"); ?>" alt="mGuru Motu" class="mg-motu">
                        <img src="<?php echo base_url("webapp_asset/images/motu_shadhow_1.svg"); ?>" alt="mGuru Motu" class="mg-motu-shadow">
                    </div>
                    <a href="<?php echo site_url("stories/video"); ?>" class="mg-unlock-btn" style="margin: 1.5em auto 0;"><?php echo @$_translation->array[$_lang_map]->item[122]; ?></a>
                    <a href="javascript:void(0);" data-dismiss="modal" class="mg-btn-back"><?php echo @$_translation->array[$_lang_map]->item[120]; ?></a>
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