<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>
<section id="dailyquest" class="mg-activity ">
    <div class='main-activity-div' style='min-height: 500px;'></div>

    <!-- Show if correct -->
    <div class="mg-active-correct hide">
        <img src="<?php echo base_url("webapp_asset/images/correct.jpg"); ?>" alt="mGuru Correct" class="mg-activity-main-bg">
        <div class="container-fluid compress-80">
            <div class="row-fluid clearfix">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <h1 class="mg-h1-header mg-text-warning mg-text-lg correct_text" style='margin-top: 20px; display:none;'>
                        <?php echo @$_translation->array[$_lang_map]->item[36]; ?>
                    </h1>
                    <h1 class="mg-h1-header mg-text-warning mg-text-lg done_text" style='margin-top: 20px; display:none;'>
                        <?php
                            echo "Submitted";
                            //echo @$_translation->array[$_lang_map]->item[28];
                        ?>
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
        <div class="container-fluid compress-80">
            <div class="row-fluid clearfix">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <h1 class="mg-h1-header mg-text-danger mg-text-lg" style='margin-top: 20px;'>
                        <?php echo @$_translation->array[$_lang_map]->item[35]; ?>
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
                    <img src="<?php echo base_url("webapp_asset/images/motu-incorrect.png"); ?>" alt="mGuru Motu" class="mg-motu">
                </div>
            </div>
        </div>
    </div>

    <!-- Show on successful completion of an activity -->
    <div class="mg-active-complete  hide">
        <img src="<?php echo base_url("webapp_asset/images/story-complete-bg.jpg"); ?>" alt="mGuru Correct" class="mg-activity-main-bg">
        <div class="container-fluid compress-80">
            <div class="row-fluid clearfix">
                <div class="col-md-12 text-center">
                    <h1 class="mg-h1-header mg-text-danger" >
                        <?php echo @$_translation->array[$_lang_map]->item[155]; ?>
                    </h1>
                    <div class="mg-quest-help-text">
                        <?php echo @$_translation->array[$_lang_map]->item[30]; ?>
                    </div>
                </div>
            </div>
            <div class="row mg-daily-activity-wrapper clearfix">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="mg-activity-score">
                        <h2 class="mg-text-lg mg-text-white" id='mangoo'>
                        </h2>
                    </div>
                    <div class="mg-star-rating">
                        <h3 class="mg-text-white text-uppercase"><?php echo @$_translation->array[$_lang_map]->item[31]; ?></h3>
                        <img src="<?php echo base_url("webapp_asset/images/result_ribbon_1.svg"); ?>" alt="mGuru Star Ribbon" class="mg-ribbon">
                        <img src="<?php echo base_url("webapp_asset/images/report_star_1.svg"); ?>" alt="mGuru Star" class="mg-star mg-star1 s1">
                        <img src="<?php echo base_url("webapp_asset/images/report_star_1.svg"); ?>" alt="mGuru Star" class="mg-star mg-star2 s2">
                        <img src="<?php echo base_url("webapp_asset/images/report_star_1.svg"); ?>" alt="mGuru Star" class="mg-star mg-star3 s3">
                    </div>
                    <img src="<?php echo base_url("webapp_asset/images/mg-motu-feed.png"); ?>" alt="mGuru Motu" class="mg-motu">
                    <img src="<?php echo base_url("webapp_asset/images/mg-bucket-with-shadow.png"); ?>" alt="mGuru Motu" class="mg-bucket">
                    <small class="mg-result-score mg-text-white totsmango" ></small>
                    <a href="<?php echo site_url("stories/video"); ?>" class="mg-btn-danger mg-btn-rounded mg-next text-center text-uppercase next-level"><?php echo @$_translation->array[$_lang_map]->item[211]; ?></a>
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
                    <?php echo @$_translation->array[$_lang_map]->item[175]; ?>
                </h1>
                <!-- <p class="mg-modal-desc">
                    You finished
                </p> -->
                <h3>b,c,d,f</h3>
                <img src="<?php echo base_url("webapp_asset/images/mg-motu-congrats.svg"); ?>" alt="mGuru Motu" class="mg-motu">
                <div class="progress mg-progress">
                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%">
                    </div>
                </div>
                <h2 class="mg-h1-header">
                    10%
                </h2>
                <a href="javascript:void(0);" class="mg-unlock-btn text-uppercase"><?php echo @$_translation->array[$_lang_map]->item[165]; ?></a>
                <a href="javascript:void(0);" data-dismiss="modal" class="mg-btn-back"><?php echo @$_translation->array[$_lang_map]->item[27]; ?></a>
            </div>
        </div>
    </div>
</div>

<audio id="defaultcorrectaudio" src="<?php echo base_url("webapp_asset/audio/correct.mp3"); ?>" controls style='display:none;'></audio>
<audio id="defaultwrongaudio" src="<?php echo base_url("webapp_asset/audio/wrong.mp3"); ?>" controls style='display:none;'></audio>

<script>
    var orderNumber = 0;
    var activityCount = <?php echo count($activityLinkage); ?>;
    var activityId = <?php echo $activity->id; ?>;
    var activityLinkage = new Array();
    var scorearray = new Array();
    var pointsarray = new Array();
    var answersarray = new Array();
    var canswersarray = new Array();
    var score = 0;
    var points = 0;
    var audioPlayercorrect = document.getElementById("defaultcorrectaudio");
    var audioPlayerwrong = document.getElementById("defaultwrongaudio");


    <?php
        foreach($activityLinkage as $val) {
            echo "activityLinkage.push($val);";
        }

    ?>

    var loading_string = "<br /><br /><img src='<?php echo base_url("webapp_asset/images/loading.gif"); ?>' class='text-center' style='margin: auto auto; display: block;' />";
    var star2 = "<?php echo base_url("webapp_asset/images/report_star_2.svg"); ?>";
    var mangoo = "<img src='<?php echo base_url("webapp_asset/images/mango_1_main_1.svg"); ?>' alt='mGuru Mango' class='mg-mango'>";

    var mActivityDetails = new Array();

    $( document ).ready(function() {
        callnextquestionpull();
    });

    function callnextquestion() {
        if($("#skip_act").val() == 'true') {
            callnextquestionpull();
        } else {
            $(".correct_text").css("display","none");
            $(".done_text").css("display","none");
            if($("#act_answer").val()) {
                var correct_ans_flag = 0;

                var answers = $("#act_answer").val().split(":::");

                for(var ii = 0 ; ii < answers.length ; ii++) {
                    if(answers[ii].toUpperCase() == $("#user_answer").val().toUpperCase()) {
                        correct_ans_flag = 1;
                    }
                }

                answersarray.push($("#user_answer").val());
                canswersarray.push($("#act_answer").val());
                if(correct_ans_flag == 1) {
                    $(".correct_text").css("display","block");
                    $(".done_text").css("display","none");
                    $(".main-activity-div").addClass('hide');
                    $(".mg-active-correct").removeClass('hide');
                    points += parseInt($("#score_full").val());
                    pointsarray.push(parseInt($("#score_full").val()));
                    audioPlayercorrect.play();

                    setTimeout(function() {
                        callnextquestionpull();
                    }, 2000);
                } else {
                    $(".main-activity-div").addClass('hide');
                    $(".mg-active-incorrect").removeClass('hide');
                    pointsarray.push(0);
                    audioPlayerwrong.play();

                    setTimeout(function() {
                        $(".mg-submit").addClass('hide');
                        $(".mg-next").removeClass('hide');
                        $(".mg-active-incorrect").addClass('hide');
                        $(".main-activity-div").removeClass('hide');

                        showcorrectanswer();

                    }, 2000);
                }
            } else {
                answersarray.push('');
                canswersarray.push('');
                $(".correct_text").css("display","none");
                $(".done_text").css("display","block");
                $(".main-activity-div").addClass('hide');
                $(".mg-active-correct").removeClass('hide');
                audioPlayercorrect.play();

                setTimeout(function() {
                    callnextquestionpull();
                }, 2000);
            }


        }

        return false;
    }


    function callnextquestiondirect() {
        callnextquestionpull();
    }

    function callnextquestionpull() {
        $(".mg-active-correct").addClass('hide');
        $(".mg-active-incorrect").addClass('hide');
        $(".main-activity-div").removeClass('hide');

        if(orderNumber >= activityCount)  {
            $(".main-activity-div").html(loading_string);
            $.post("<?php echo site_url("webapp/savestoryquestionv"); ?>",{ score: score, points:points, activity_id: activityId, act_link: activityLinkage,scorearray:scorearray,pointsarray:pointsarray,answersarray:answersarray,canswersarray:canswersarray  },function( data ) {
                $(".main-activity-div").addClass('hide');
                $(".mg-active-complete").removeClass('hide');
                $("#mangoo").html(points + " " + mangoo);
                var ddd = data.split(":::");
                $(".totsmango").html(ddd[0]);
                //var urrl = $(".next-level").attr('href');
                //urrl = urrl.replace("10",ddd[1]);
                //$(".next-level").attr('href',urrl);
                if(ddd[2] >= 3) {
                    $(".s1").attr('src',star2);
                    $(".s2").attr('src',star2);
                    $(".s3").attr('src',star2);
                } else if(ddd[2] >= 2) {
                    $(".s1").attr('src',star2);
                    $(".s2").attr('src',star2);
                } else if(ddd[2] >= 1) {
                    $(".s1").attr('src',star2);
                }

            });
        } else {
            $(".main-activity-div").html(loading_string);

            $.post("<?php echo site_url("webapp/getstoryquestionv"); ?>",{num: orderNumber,activityCount:activityCount, activity_id: activityId, act_link: activityLinkage[orderNumber]  },function( data ) {
                mActivityDetails.push(data);
                $(".main-activity-div").html(data);
                score += parseInt($("#score_full").val());
                scorearray.push(parseInt($("#score_full").val()));
                if($("#score_full").val() == 5) {
                    points += parseInt($("#score_full").val());
                    pointsarray.push(parseInt($("#score_full").val()));
                }
                orderNumber++;

                if($("#skip_act").val() == 'true') {
                    callnextquestion();
                }

                if($("#activity_type").val() == "drag_drop" ) {
                    start_drag_drop();
                }
            });
        }
    }

    function showcorrectanswer() {
        if($(".mg-word-starts-with").length > 0 ) {
            $.each($(".mg-word-starts-with .mg-void"), function( index, value ) {
                if($(value).data("value") == $("#act_answer").val()) {
                    $(value).css("border-color","green");
                } else {
                    $(value).css("border-color","red");
                    $(value).css("opacity","0.2");
                }
            });
        } else if ($(".mg-missing-letter").length > 0 ) {
            $(".mg-missing-letter .mg-options-wrapper").css("visibility", "hidden");
            $(".mg-missing-letter .answerhere").html($("#act_answer").val());
        } else if($(".mg-letter-sound").length > 0 ) {
            $.each($(".mg-letter-sound .mg-options-wrapper .mg-void"), function( index, value ) {
                if($(value).data("value") == $("#act_answer").val()) {
                    $(value).css("border-color","green");
                } else {
                    $(value).css("border-color","red");
                    $(value).css("opacity","0.2");
                }
            });
        } else if ($(".fillintheblank").length > 0 ) {
            var ansss = $("#act_answer").val().split(":::");
            $(".fillintheblank .answerhere").html(ansss[0]);
        } else if ($(".mg-arrange-phrase").length > 0 ) {
            $(".mg-arrange-phrase .mg-options-wrapper").css("visibility", "hidden");
            $(".mg-arrange-phrase .mg-query-text .mg-void").html("<span class='mg-text-black'>"+$("#act_answer_readable").val()+'</span>');
        } else if($(".mg-missing-word").length > 0 ) {
            var ansss = $("#act_answer").val().split(",");

            $(".mg-missing-word .mg-query-text .mg-void").html($("#act_answer").val());

            $.each($(".mg-missing-word .mg-options-wrapper .mg-void"), function( index, value ) {
                if( $.inArray( $(value).data("value"), ansss ) >= 0) {
                    $(value).css("border-color","green");
                } else {
                    $(value).css("border-color","red");
                    $(value).css("opacity","0.2");
                }
            });
        } else if ($(".mg-match-pairs").length > 0 ) {
            $(".mg-right-panel li").sort(asc_sort).appendTo('.mg-right-panel');
            function asc_sort(a, b){
                return ($(b).data("value")) < ($(a).data("value")) ? 1 : -1;
            }
        } else if($(".mg-correct-image").length > 0 ) {
            $.each($(".mg-correct-image .mg-options-wrapper .mg-void"), function( index, value ) {
                if($(value).data("value") == $("#act_answer").val()) {
                    $(value).css("border-color","green");
                } else {
                    $(value).css("border-color","red");
                    $(value).css("opacity","0.2");
                }
            });
        }




    }
</script>

<style>
    .mg-h1-50px {
        font-size: 50px !important;
    }

    .mg-activity {
        padding-top: 5px !important;
    }


    .mg-daily-activity-wrapper {
        margin-top: 0px !important;
    }

    .compress-75{
        top: -80px;
        position: relative;
        transform: scale(0.75, 0.75);
        -ms-transform: scale(0.75, 0.75); /* IE 9 */
        -webkit-transform: scale(0.75, 0.75); /* Safari and Chrome */
        -o-transform: scale(0.75, 0.75); /* Opera */
        -moz-transform: scale(0.75, 0.75); /* Firefox */
    }

    .compress-80{
        top: -45px;
        position: relative;
        transform: scale(0.8, 0.8);
        -ms-transform: scale(0.8, 0.8); /* IE 9 */
        -webkit-transform: scale(0.8, 0.8); /* Safari and Chrome */
        -o-transform: scale(0.8, 0.8); /* Opera */
        -moz-transform: scale(0.8, 0.8); /* Firefox */
    }

    .compress-80-1{
        transform: scale(0.8, 0.8);
        -ms-transform: scale(0.8, 0.8); /* IE 9 */
        -webkit-transform: scale(0.8, 0.8); /* Safari and Chrome */
        -o-transform: scale(0.8, 0.8); /* Opera */
        -moz-transform: scale(0.8, 0.8); /* Firefox */
    }

    .compress-85{
        top: -45px;
        position: relative;
        transform: scale(0.85, 0.85);
        -ms-transform: scale(0.85, 0.85); /* IE 9 */
        -webkit-transform: scale(0.85, 0.85); /* Safari and Chrome */
        -o-transform: scale(0.85, 0.85); /* Opera */
        -moz-transform: scale(0.85, 0.85); /* Firefox */
    }

    .compress-90{
        top: -20px;
        position: relative;
        transform: scale(0.9, 0.9);
        -ms-transform: scale(0.9, 0.9); /* IE 9 */
        -webkit-transform: scale(0.9, 0.9); /* Safari and Chrome */
        -o-transform: scale(0.9, 0.9); /* Opera */
        -moz-transform: scale(0.9, 0.9); /* Firefox */
    }

    .compress-95 .container{
        top: -20px;
        position: relative;
        transform: scale(0.95, 0.95);
        -ms-transform: scale(0.95, 0.95); /* IE 9 */
        -webkit-transform: scale(0.95, 0.95); /* Safari and Chrome */
        -o-transform: scale(0.95, 0.95); /* Opera */
        -moz-transform: scale(0.95, 0.95); /* Firefox */
    }
    .compress-95-1{
        transform: scale(0.95, 0.95);
        -ms-transform: scale(0.95, 0.95); /* IE 9 */
        -webkit-transform: scale(0.95, 0.95); /* Safari and Chrome */
        -o-transform: scale(0.95, 0.95); /* Opera */
        -moz-transform: scale(0.95, 0.95); /* Firefox */
    }

    body {
        height: 100%;
        overflow: hidden !important;
    }
</style>