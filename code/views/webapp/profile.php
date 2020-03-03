<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>
<section id="profile">
    <img src="<?php echo base_url("webapp_asset/images/profile-bg.jpg"); ?>" alt="mGuru Profile" class="mg-profile-main-bg">
    <small class="mg-days-left pull-left">
        <?php
            if($days_expired >= 1) {
                echo $days_expired . " " . @$_translation->array[$_lang_map]->item[208];
            } else {
                echo @$_translation->array[$_lang_map]->item[189];
            }
        ?>
    </small>
    <div class="container-fluid">
        <div class="row-fluid clearfix">
            <div class="col-md-8 col-md-offset-2 text-center">
                <h1 class="mg-h1-header" style='margin-top: 5px !important;'>
                    Hey <?php
                        $name = trim($user->profile->display_name);
                        if($name == '') {
                            $name = trim($user->username);
                        }
                        echo $name;
                    ?>!!
                </h1>
                <!-- <a href="#" class="mg-btn-primary mg-btn-sm mg-btn-rounded text-center">Sign In</a>-->
                <div class="mg-quest-help-text">
                    Following is your performance so far
                </div>
            </div>
        </div>
        <div class="row-fluid clearfix mg-profile-performance">
            <div class="col-md-8 col-md-offset-2 text-center">
                <div class="col-md-4">
                    <div class="mg-square-white">
                        <div class="mg-top-overlay"></div>
                        <img src="<?php echo base_url("webapp_asset/images/profile_report_1.svg"); ?>" alt="mGuru Report Card " class="mg-activity icon_profile_card">
                        <div class="mg-activity-title mg-report-card text-center icon_profile_card">
                            <?php echo @$_translation->array[$_lang_map]->item[165]; ?>
                        </div>
                        <div class="mg-activity-content-wrapper text-center rc_card_details">

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mg-square-white">
                        <div class="mg-top-overlay"></div>
                        <img src="<?php echo base_url("webapp_asset/images/profile_mango_1.svg"); ?>" alt="mGuru Recent Activity " class="mg-activity icon_profile_card">
                        <div class="mg-activity-title mg-recent-activity text-center icon_profile_card">
                            <?php echo @$_translation->array[$_lang_map]->item[166]; ?>
                        </div>
                        <div class="mg-activity-content-wrapper recent_act_user">

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mg-square-white">
                        <img src="<?php echo base_url("webapp_asset/images/motu_4_without_shadow_1.svg"); ?>" alt="mGuru Motu" class="mg-word-learned-motu icon_profile_card">
                        <div class="mg-top-overlay"></div>
                        <img src="<?php echo base_url("webapp_asset/images/profile_words_1.svg"); ?>" alt="mGuru Words Learned" class="mg-activity icon_profile_card">
                        <div class="mg-activity-title mg-words-learned text-center icon_profile_card">
                            <?php echo @$_translation->array[$_lang_map]->item[167]; ?>
                        </div>
                        <div class="mg-activity-content-wrapper text-left pro_word">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $( document ).ready(function() {
        var loading_string = "<br /><br /><img src='<?php echo base_url("webapp_asset/images/loading.gif"); ?>' class='text-center' style='margin: auto auto; display: block;' />";

        $(".pro_word").html(loading_string);

        $.post("<?php echo site_url("webapp/getprofilewords"); ?>",function( data ) {
            $(".pro_word").html(data);
        });

        $(".rc_card_details").html(loading_string);

        $.post("<?php echo site_url("webapp/rccarddetails"); ?>",function( data ) {
            $(".rc_card_details").html(data);
            var rcc = $("#rcc").val().split(":::");
            $("#rcc2").html(rcc[1] + " on " + rcc[2]);
            $("#rcc3").html($("#rcc1").html());
            $("#rcc4").html(rcc[0]);
        });

        $(".recent_act_user").html(loading_string);

        $.post("<?php echo site_url("webapp/recentactuser"); ?>",function( data ) {
            $(".recent_act_user").html(data);
        });



    });
</script>


<style>
.mg-top-overlay {
    z-index: 10;
}
.mg-activity-content-wrapper {
    z-index: 1;
}

.icon_profile_card{
    z-index:20;
}

body {
    height: 100%;
    overflow: hidden !important;
}
</style>