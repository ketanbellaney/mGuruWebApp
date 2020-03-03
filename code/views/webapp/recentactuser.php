<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>

<?php
    $mmm = "";
    foreach($activity as $val1) {
    foreach($val1 as $val) {
        if($val['formatted_date'] != $mmm) {
            echo "<div class='text-center small mg-activity-date'>".$val['formatted_date']."</div>";
            $mmm = $val['formatted_date'];
        }
?>
        <div class="mg-activity-item text-left">
            <img src="<?php echo base_url("webapp_asset/images/reviewicon_1.svg"); ?>" alt="mGuru Icon" class="mg-activity-item-icon">
            <span class="mg-activity-item-desc text-left"><?php echo $val['activityname']; ?></span>
            <small class="mg-activity-item-story-status"><?php echo $val['levelname']; ?></small>
        </div>
<?php
    }
    }

    if($mmm == '')  {
        echo "<div class='text-center small mg-activity-date' style='font-size: 12px !important;'>".@$_translation->array[$_lang_map]->item[171]."</div>";
    }
?>