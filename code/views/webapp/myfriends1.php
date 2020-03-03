<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>
<section id="stories-complete" class="my-friends" class="mg-videos" style='background: url(<?php echo base_url("webapp_asset/images/story-complete-bg.jpg"); ?>);    background-position-y: -124px;height: 580px; overflow: hidden; padding-top: 20px;'>
    <div class="container-fluid">
        <div class="row-fluid clearfix">
            <div class="col-md-8 col-md-offset-2 text-center">
                <h1 class="mg-h1-header" style='margin-top: 0px;margin-bottom: 0px; <?php if( strlen($story->name) > 24 ) echo " font-size: 50px !important; "; ?>'>
                    <?php echo $story->name; ?>
                    <img class="mg-icon-hint" onclick='opencreditwindow();'  title="Credits" src="<?php echo base_url("webapp_asset/images/hint_1.svg"); ?>" style='cursor:pointer;' alt="Credits" />
                </h1>
                <div class="mg-quest-help-text" style='margin-bottom: 75px;margin-top: 15px;'>
                    <?php echo @$_translation->array[$_lang_map]->item[47]; ?>
                </div>
            </div>
        </div>
        <?php
            $words = json_decode($question->question);
        ?>
        <div class="row-fluid clearfix mg-other-stories">
            <div class="col-md-8 col-md-offset-2 text-center"  style=' z-index: 999;'>
                <div class="col-md-3">
                    <div class="mg-circle-white" onclick="return speaktext('<?php echo $words->words[0]->word; ?>');" >
                        <img src="<?php echo base_url("question/" . $words->words[0]->image); ?>" alt="<?php echo $words->words[0]->word; ?>" height='126' class="mg-img mg-clap"  />
                    </div>
                    <a href="#" onclick="return speaktext('<?php echo $words->words[0]->word; ?>');" class="mg-btn-white mg-btn-rounded vocab-word"><?php echo $words->words[0]->word; ?></a>
                </div>
                <div class="col-md-3">
                    <div class="mg-circle-white" onclick="return speaktext('<?php echo $words->words[1]->word; ?>');">
                        <img src="<?php echo base_url("question/" . $words->words[1]->image); ?>" alt="<?php echo $words->words[1]->word; ?>" height='126' class="mg-img mg-sun">
                    </div>
                    <a href="#" onclick="return speaktext('<?php echo $words->words[1]->word; ?>');" class="mg-btn-white mg-btn-rounded vocab-word"><?php echo $words->words[1]->word; ?></a>
                </div>
                <div class="col-md-3">
                    <div class="mg-circle-white" onclick="return speaktext('<?php echo $words->words[2]->word; ?>');">
                        <img src="<?php echo base_url("question/" . $words->words[2]->image); ?>" alt="<?php echo $words->words[2]->word; ?>" height='126' class="mg-img mg-tree">
                    </div>
                    <a href="#" onclick="return speaktext('<?php echo $words->words[2]->word; ?>');" class="mg-btn-white mg-btn-rounded vocab-word"><?php echo $words->words[2]->word; ?></a>
                </div>
                <div class="col-md-3">
                    <div class="mg-circle-white" onclick="return speaktext('<?php echo $words->words[3]->word; ?>');">
                        <img src="<?php echo base_url("question/" . $words->words[3]->image); ?>" alt="<?php echo $words->words[3]->word; ?>" height='126' class="mg-img mg-apple">
                    </div>
                    <a href="#" onclick="return speaktext('<?php echo $words->words[3]->word; ?>');" class="mg-btn-white mg-btn-rounded vocab-word"><?php echo $words->words[3]->word; ?></a>
                </div>
                <a href="<?php echo site_url("stories/pages/".$story->id."/0"); ?>" class="mg-btn-danger mg-btn-rounded mg-start text-center " style='margin-top: 5%;'><?php echo @$_translation->array[$_lang_map]->item[25]; ?></a>
            </div>
        </div>
    </div>
</section>

<script>
    var msg = new SpeechSynthesisUtterance();
    var voices = window.speechSynthesis.getVoices();
    for(var qw = 0 ; qw < voices.length ; qw++ ) {
        if(voices[qw].lang == "hi-IN") {
             msg.voice = voices[qw];
        }
    }
     //msg.voice = voices[10];
        msg.voiceURI = "native";
        msg.volume = 1;
        msg.rate = 0.8;
        msg.pitch = 1;
        msg.lang = 'hi-IN';
    function speaktext(text) {
        //var msg = new SpeechSynthesisUtterance(text);
        //window.speechSynthesis.speak(msg);
        //var msg = new SpeechSynthesisUtterance();
        //var voices = window.speechSynthesis.getVoices();
        /*msg.voice = voices[10];
        msg.voiceURI = "native";
        msg.volume = 1;
        msg.rate = 0.8;
        msg.pitch = 1;
        msg.lang = 'hi-IN';*/
        msg.text = text;
        speechSynthesis.speak(msg);
        return false;
    }

    function opencreditwindow() {
        $("#mgCreditModal").modal('show');
        return false;
    }
</script>
<style>
.mg-btn-white{
    width: 90% !important;
}


</style>

<div class="mg-modal mg-modal-bold modal fade" role="dialog" id="mgCreditModal" tabindex="-1" aria-labelledby="mgAreYouSureModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style='height: auto;'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="<?php echo base_url("webapp_asset/images/popup_close_1.svg"); ?>" alt="mGuru Pop-up close">
                    </button>
                </div>
                <div class="modal-body text-center">
                    <h1 class="mg-modal-title"><?php echo @$_translation->array[$_lang_map]->item[136]; ?></h1>
                    <p style='margin-bottom: 0px;'><b><?php echo @$_translation->array[$_lang_map]->item[127]; ?>: </b> <?php echo $story->writtenby; ?></p>
                    <p style='margin-bottom: 0px;'><b><?php echo @$_translation->array[$_lang_map]->item[128]; ?>: </b> <?php echo $story->illustrationsby; ?></p>
                    <p style='margin-bottom: 0px;'><b><?php echo @$_translation->array[$_lang_map]->item[130]; ?>: </b> <?php echo $story->source; ?></p>
                    <p style='margin-bottom: 0px;'><b>Released under a CC BY 4.0</b></p>
                    <div class="mg-motu-lock-wrapper">
                        <img src="<?php echo base_url("webapp_asset/images/motu_3_with_shadow_1.svg"); ?>" alt="mGuru Motu" class="mg-motu" style='width: 150px;' />
                    </div>
                    <a href="javascript:void(0);" data-dismiss="modal" class="mg-btn-back"><?php echo @$_translation->array[$_lang_map]->item[46]; ?></a>
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