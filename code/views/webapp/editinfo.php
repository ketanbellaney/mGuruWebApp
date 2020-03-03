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
                <h1 class="mg-h1-header" style='margin-top: 5px !important; '>
                    Hey <?php
                        $name = trim($user->profile->display_name);
                        if($name == '') {
                            $name = trim($user->username);
                        }
                        echo $name;
                    ?>!!
                </h1>
                <div class="mg-quest-help-text">
                    <?php
                                if(@$error == 1) {
                                    echo "<script> alert('Account updated successfully.');</script>";
                                }
                            ?>
                </div>
            </div>
        </div>

        <form role="form" action="<?php echo site_url('profile/edit-info');?>" method="post" name="" enctype="multipart/form-data">
        <div class="row-fluid clearfix mg-profile-performance">
            <div class="col-md-8 col-md-offset-2 text-center">
                <div class="mg-user-profile-info-wrapper">
                    <div class="mg-square-white" style='height: 340px !important;'>
                        <div class="mg-dot mg-dot-left"></div>
                        <div class="mg-top-overlay mg-overlay-yellow"></div>
                        <div class="mg-dot mg-dot-right"></div>
                        <svg class="clip-svg">
                            <defs>
                                <clipPath id="polygon-clip-hexagon" clipPathUnits="objectBoundingBox">
                                    <polygon points="0.5 0, 1 0.25, 1 0.75, 0.5 1, 0 0.75, 0 0.25" />
                                </clipPath>
                            </defs>
                        </svg>
                        <div class="polygon-each-img-wrap">
                            <img src="<?php echo $user->profile->profile_photo(); ?>" alt="<?php echo $name; ?>" class="polygon-clip-hexagon mg-user">
                        </div>
                        <div class="mg-activity-title mg-id-card text-center">
                            mGuru ID card
                        </div>
                        <div class="mg-user-name clearfix text-center">

                        </div>
                        <div class="mg-report-item text-center row clearfix">
                            <div class="col-md-3">
                                <div class="small name_field">
                                    <?php echo @$_translation->array[$_lang_map]->item[57]; ?>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <strong class="mg-user-data">
                                    <input type="text" name="name" id="name" required maxlength="100" minlength="3" class="form-control" value="<?php echo trim($user->profile->display_name); ?>" />
                                </strong>
                            </div>
                        </div>
                        <div class="mg-report-item text-center row">
                            <div class="col-md-3">
                                <div class="small name_field">
                                    <?php echo @$_translation->array[$_lang_map]->item[72]; ?>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <strong class="mg-user-data">
                                    <input type="number" name="phone_no" id="phone_no" maxlength="10" minlength="10"  class="form-control" value="<?php echo trim($user->mobile); ?>" />
                                </strong>
                            </div>
                        </div>
                        <div class="mg-report-item text-center row">
                            <div class="col-md-3">
                                <div class="small name_field">
                                    <?php echo @$_translation->array[$_lang_map]->item[73]; ?>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <strong class="mg-user-data">
                                    <select name="class_txt" id="class_txt" class="form-control" >
                                        <?php
                                            $_class = array("JKG","KG",1,2,3,4,5,6,7,8,9,10);

                                            foreach($_class as $val) {
                                                if($val == $user->profile->current_class) {
                                                    echo "<option value='$val' selected='selected'>$val</option>";
                                                } else {
                                                    echo "<option value='$val' >$val</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </strong>
                            </div>
                        </div>
                        <div class="mg-report-item text-center row">
                            <div class="col-md-3">
                                <div class="small name_field ">
                                    <?php echo @$_translation->array[$_lang_map]->item[60]; ?>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <strong class="mg-user-data">
                                    <?php
                                        $school_name = '';
                                        if($user->profile->school) {
                                            $school_name = $user->profile->school->name;
                                        }
                                    ?>
                                    <input type="text" name="school" id="school" required maxlength="100" minlength="3" class="form-control" value="<?php echo trim($school_name); ?>" />
                                </strong>
                            </div>
                        </div>

                        <!-- <img src="<?php echo base_url("webapp_asset/images/motu_4_with_shadow_1.svg"); ?>" alt="mGuru Motu" class="mg-profile-edit-motu"> -->
                        <input type='submit' class="mg-btn-danger mg-btn-rounded mg-save text-center" value='<?php echo @$_translation->array[$_lang_map]->item[61]; ?>' />
                        <br style='clear:both;' />
                    </div>
                </div>
            </div>
        </div>

        </form>
    </div>
</section>

<style>
    .name_field {
        font-size: 16px !important;
        line-height: 2.8 !important;
    }
    body {
    height: 100%;
    overflow: hidden !important;
}
</style>