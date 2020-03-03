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
                <h1 class="mg-h2-header"  style='margin-top: 0px;margin-bottom: 0px;' >

                    <a href="#"   onclick='return checkreturnexit();'  data-target="#mgAreYouSureModal1" class="pull-left">
                        <img class="mg-icon-back" src="<?php echo base_url("webapp_asset/images/back_1.svg"); ?>" alt="mGuru Back">
                    </a>
                    <?php echo $story->name; ?>
                    <!-- <img class="mg-icon-hint" data-toggle="tooltip" data-placement="bottom" title="This is mGuru hint" src="<?php echo base_url("webapp_asset/images/hint_1.svg"); ?>" alt="mGuru Hint"> -->
                </h1>
            </div>
            <?php
                $languages = StorypageLanguage::find('all',array(
                    'conditions' => " storypage_id = '".$storypage->id."' ",
                ));

                $audio_text = @str_replace("&nbsp;"," ",@file_get_contents("story/" . $storypage->audio_map));

                if(count($languages) > 0) {
            ?>
            <div class="col-md-2">

                <a href="#" onclick='return openLangModal();'  data-target="#mgLearnEngModalStoryLangChange" class="pull-left" style='margin-top: 25px; font-size: 15px; color: #000000; font-weight:600; '>
                    <?php echo @$_translation->array[$_lang_map]->item[137]; ?>
                </a>
            </div>
            <?php
                }
            ?>
        </div>
        <div class="row-fluid mg-stories-videos-wrapper clearfix">
            <?php
    if($audio_text == '') {
?>
            <div class="col-md-12 ">
<?php
    } else {
?>
            <div class="col-md-6 ">
<?php
    }
?>
                <div class="text-center" style='/*padding-bottom: 32%;*/'>
                    <?php
                        list($width, $height, $type, $attr) = getimagesize("story/" . $storypage->image);

                        if( $width > ($height + 180 )){
                            echo "<img src='".base_url("story/" . $storypage->image)."' style='width: 550px;' />";
                        } else {
                            echo "<img src='".base_url("story/" . $storypage->image)."' style='height: 400px;' />";
                        }
                    ?>

                </div>
            </div>

            <div class="col-md-6  mg-stories-videos-desc clearfix  <?php
    if($audio_text == '') {  echo " hidden "; }
?>" style='visibility: hidden; padding: 20px; background-color: #F2F2F2; opacity: 0.7; height: 400px; overflow-y: scroll; overflow-x: hidden; vertical-align: middle;'>
                <div class="" style="display: table-cell;  vertical-align: middle;">
                    <div class="text-center all_lang lang_4" id='subtitles' style="font-family: 'Nunito', sans-serif; font-size: 22px; font-weight: 600;margin-left: auto; margin-right: auto;">

                    </div>
                    <?php
                        foreach($languages as $val) {
                    ?>
                    <div class="text-center all_lang lang_<?php echo $val->language_id; ?>" style="display:none;font-family: 'Nunito', sans-serif; font-size: 22px; font-weight: 600;margin-left: auto; margin-right: auto;">
                        <?php echo $val->content; ?>
                    </div>
                    <?php
                        }
                    ?>

                </div>
            </div>
        </div>
        <div class="mg-stories-btn-wrapper" style='clear:both; '>
            <div class="row-fluid mg-stories-videos-wrapper clearfix">
                <div class="col-md-10 col-md-offset-1" style='z-index:1000;'>
                    <?php
                            if($audio_text == '') {
                    ?>
                                <div class="col-md-5 text-left">
                    <?php
                        } else {
                    ?>
                                <div class="col-md-6 text-left">
                    <?php
                        }
                    ?>
                        <a href="#" onclick='return playpause();' class="mg-narrate mg-play" style='display:block;margin-top: 8px;'>
                            <img class="mg-icon-narrate" src="<?php echo base_url("webapp_asset/images/narrate_1.svg"); ?>" alt="Play">
                            Narrate the story
                        </a>
                        <a href="#" onclick='return playpause();' class="mg-narrate mg-pause" style='display: none;margin-top: 8px;'>
                            <img class="mg-icon-narrate" src="<?php echo base_url("webapp_asset/images/pause_1.svg"); ?>" alt="mGuru Hint">
                            Pause Narration
                        </a>

                    </div>
                    <?php
                            if($audio_text == '') {
                    ?>
                        <div class="col-md-2 text-right">
                            <div class="text-center" style='color: grey; font-weight: 800;'>No Audio</div>
                        </div>
                                <div class="col-md-5 text-right">
                    <?php
                        } else {
                    ?>
                                <div class="col-md-6 text-right">
                    <?php
                        }
                    ?>
                        <?php
                            if($audio_text == '') {
                         ?>

                         <?php
                            }
                         ?>
                        <?php if($page != 0) { ?>
                        <a href="<?php echo site_url("stories/pages/".$story->id."/" . ($page - 1)); ?>" class="mg-btn-back text-center "><?php echo @$_translation->array[$_lang_map]->item[27]; ?></a>
                        <?php } ?>
                        <a href="<?php echo site_url("stories/pages/".$story->id."/" . ($page + 1)); ?>" class="mg-btn-next text-center"><?php echo @$_translation->array[$_lang_map]->item[26]; ?></a>
                    </div>
                </div>
            </div>
        </div>
        <audio id="audiofile" src="<?php echo base_url("story/" . $storypage->audio); ?>" controls style='display:none;' preload='auto'></audio>
    </div>
</section>
  <br style='clear:both;' />
  <br style='clear:both;' />
<script>

var audioPlayer = document.getElementById("audiofile");
var subtitles = document.getElementById("subtitles");
<?php
    if($audio_text == '') {
?>
        var syncData;
        $(".mg-play").css("display",'none');
        $(".mg-pause").css("display",'none');
<?php
    } else {
?>
        var syncData = <?php echo $audio_text ?>;

createSubtitle();

function createSubtitle()
{
    var flagg = 0;
    var element;
    for (var i = 0; i < syncData.fragments.length; i++) {
        element = document.createElement('span');
        element.setAttribute("id", "c_" + i);
        element.innerText = syncData.fragments[i].lines.join(" ") + " ";
        subtitles.appendChild(element);
        flagg = 1;
    }

    if(flagg == 0) {
        $(".mg-play").css("display",'none');
        $(".mg-pause").css("display",'none');
    }
    $('#audiofile').trigger("load");
}

<?php
    }
?>

audioPlayer.addEventListener("timeupdate", function(e){
    syncData.fragments.forEach(function(element, index, array){
        //console.log(element.begin + element.end);
        if( audioPlayer.currentTime > element.begin && audioPlayer.currentTime <= element.end ) {
        //if( audioPlayer.currentTime >= ( ( parseFloat(element.begin) + parseFloat(element.end) )  / 2 ) ) {
            var s_index = index - 7;
            if(s_index <= 0) {
                s_index = 0;
            }

            for(var mmm = s_index ; mmm <= index ; mmm++) {
                subtitles.children[mmm].style.color = '#00DC1D';
            }
        }

        if(audioPlayer.currentTime >= audioPlayer.duration) {
            for(var mmm = 0 ; mmm < subtitles.children.length ; mmm++) {
                subtitles.children[mmm].style.color = '#00DC1D';
            }
            $(".mg-play").css("display",'block');
            $(".mg-pause").css("display",'none');
            setTimeout(function(){ defaultthetext(); }, 2000);

            $(".mg-stories-videos-desc").css("visibility","visible");
        }
    });
});

function playpause() {
    //audioPlayer = document.getElementById("audiofile");
    if($('#audiofile').prop("paused") == false) {
        $('#audiofile').trigger("pause");
        $(".mg-play").css("display",'block');
        $(".mg-pause").css("display",'none');
    } else {
        $('#audiofile').trigger("play");
        $(".mg-play").css("display",'none');
        $(".mg-pause").css("display",'block');
    }

    return false;
}

function defaultthetext() {

     for(var mmm = 0 ; mmm < subtitles.children.length ; mmm++) {
        subtitles.children[mmm].style.color = '#333333';
     }
}

function change_story_language(num) {
    $(".all_lang").css("display","none");
    $(".lang_" + num ).css("display","block");
    $("#mgLearnEngModalStoryLangChange").modal('hide');
}

function openLangModal() {
    $("#mgLearnEngModalStoryLangChange").modal('show');
    return false;
}

function checkreturnexit() {
    $("#mgAreYouSureModal1").modal('show');
    return false;
}

</script>

<div class="mg-modal modal fade" role="dialog" id="mgLearnEngModalStoryLangChange" tabindex="-1" aria-labelledby="mgLearnEngModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="background:#ffffff;height:auto;">
            <div class="modal-header  pull-right" style=' height: 0px; padding: 0px;'>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close" style='margin-top: -28px; margin-right: -23px'>
                    <img src="<?php echo base_url("webapp_asset/images/popup_close_1.svg"); ?>" alt="mGuru Pop-up close">
                </button>
            </div>
            <div class="modal-body text-center" style='padding: 0px;'>

                    <ul class="list-group" style='margin:0px;box-shadow: none; border-radius: 12px;'>
                        <button type="button" class="list-group-item list-group-item-action lang_english " onclick="change_story_language(4);">English</button>
                        <?php
                            foreach($languages as $val) {
                        ?>
                                <button type="button" class="list-group-item list-group-item-action lang_<?php echo strtolower($val->language->name); ?>" onclick="change_story_language(<?php echo strtolower($val->language_id); ?>);"><?php echo $val->language->name; ?></button>
                        <?php
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>


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
                    <!-- <p class="mg-modal-desc">
                        you want to exit this story?
                    </p> -->
                    <div class="mg-motu-lock-wrapper">
                        <img src="<?php echo base_url("webapp_asset/images/motu_6_without_shadow_1.svg"); ?>" alt="mGuru Motu" class="mg-motu">
                        <img src="<?php echo base_url("webapp_asset/images/motu_shadhow_1.svg"); ?>" alt="mGuru Motu" class="mg-motu-shadow">
                    </div>
                    <a href="<?php echo site_url("stories/books"); ?>" class="mg-unlock-btn" style="margin: 1.5em auto 0;"><?php echo @$_translation->array[$_lang_map]->item[122]; ?></a>
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