<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>
<section id="dailyquest" class="mg-activity">
    <div class="mg-activity-1">
        <img src="<?php echo base_url("webapp_asset/images/activity-main-bg.jpg"); ?>" alt="mGuru Activity" class="mg-activity-main-bg">
        <div class="container compress-75">
            <div class="row clearfix">
                <div class="col-md-12 text-center">
                    <h1 class="mg-h1-header mg-text-primary mg-shadow-text">
                        <?php echo $question['phrase']; ?>
                        <!-- <img class="mg-icon-hint" data-toggle="tooltip" data-placement="bottom" title="This is mGuru hint" src="<?php echo base_url("webapp_asset/images/hint_1.svg"); ?>" alt="mGuru Hint"> -->
                    </h1>
                </div>
            </div>


            <div class="row-fluid mg-stories-videos-wrapper clearfix">

            <div class="col-md-6 ">
                <div class="text-center ">
                    <?php
                        list($width, $height, $type, $attr) = getimagesize("contentfiles/sentence/" . $question['sentences'][0]['image']);

                        if( $width > ($height + 150 )){
                            echo "<img src='".base_url("contentfiles/sentence/" . $question['sentences'][0]['image'])."' style='width: 550px; background-color: #ffffff;' />";
                        } else {
                            echo "<img src='".base_url("contentfiles/sentence/" . $question['sentences'][0]['image'])."' style='height: 400px; background-color: #ffffff;' />";
                        }
                    ?>
                </div>
            </div>
            <div class="col-md-6  mg-stories-videos-desc clearfix " style=' padding: 20px; background-color: #F2F2F2; opacity: 0.7; height: 400px; overflow-y: scroll; overflow-x: hidden; vertical-align: middle;'>
                <div class="" style="display: block;  vertical-align: middle;">
                    <div class="text-center all_lang lang_4" id='subtitles' style="font-family: 'Nunito', sans-serif; font-size: 22px; font-weight: 600;margin-left: auto; margin-right: auto;">

                    </div>

                </div>
            </div>
        </div>

        <div class="mg-stories-btn-wrapper" style='clear:both; '>
            <div class="row-fluid mg-stories-videos-wrapper clearfix">
                <div class="col-md-10 col-md-offset-1" style='z-index:1000;'>
                    <div class="col-md-6 text-left">
                        <a href="#" onclick='return playpause();' class="mg-narrate mg-play" style='display:block;margin-top: 8px;'>
                            <img class="mg-icon-narrate" src="<?php echo base_url("webapp_asset/images/narrate_1.svg"); ?>" alt="Play" width='20' height='22'>
                            Narrate the rhyme
                        </a>
                        <a href="#" onclick='return playpause();' class="mg-narrate mg-pause" style='display: none;margin-top: 8px;' >
                            <img class="mg-icon-narrate" src="<?php echo base_url("webapp_asset/images/pause_1.svg"); ?>" alt="mGuru Hint" width='20' height='22'>
                            Pause Narration
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="mg-match-pairs-chat clearfix text-center">
                        <div style="clear:both;">
                            <ul class="mg-activity-sound-wrapper list-unstyled list-inline">
                                <li class="mg-void">
                                    <img src="<?php echo base_url("webapp_asset/images/volume_icon_1.svg"); ?>" alt="mGuru Listen" class="mg-say-img mg-listen" data-step=1 />
                                    <img src="<?php echo base_url("webapp_asset/images/record_icon_1.svg"); ?>" alt="mGuru Play" class="mg-say-img mg-record hide" data-step=2 />

                                </li>
                            </ul>
                        </div>
                    </div>




            <div class="row mg-daily-activity-wrapper clearfix">
                <div class="col-md-8 col-md-offset-2 text-center">

                    <!-- <a href="#" class="mg-btn-danger mg-btn-rounded mg-reply text-center text-uppercase">Try Again</a> -->
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


    <input type='hidden' id='score_full' value='5' />
    <audio id="audiofile" src="<?php echo base_url("contentfiles/sentence/" . $question['sentences'][0]['audio']); ?>" controls style='display:none;'></audio>

<script>
var audioPlayer = document.getElementById("audiofile");
var subtitles = document.getElementById("subtitles");
<?php $audio_text = @str_replace("&nbsp;"," ",@file_get_contents("contentfiles/sentence/" . $question['sentences'][0]['audio_map']));
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
}

<?php
    }
?>

audioPlayer.addEventListener("timeupdate", function(e){
    syncData.fragments.forEach(function(element, index, array){
        if( audioPlayer.currentTime >= element.begin && audioPlayer.currentTime <= element.end ) {
            var s_index = index - 5;
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

            $(".mg-submit").removeClass("mg-btn-disabled");
        }

    });
});

function playpause() {
    if(audioPlayer.paused) {
        audioPlayer.play();
        $(".mg-play").css("display",'none');
        $(".mg-pause").css("display",'block');
    } else {
        audioPlayer.pause();
        $(".mg-play").css("display",'block');
        $(".mg-pause").css("display",'none');
    }

    return false;
}

function defaultthetext() {

     for(var mmm = 0 ; mmm < subtitles.children.length ; mmm++) {
        subtitles.children[mmm].style.color = '#333333';
     }
}

</script>
<div id='recordingslist'></div>