<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>
<?php
    $mmm = 0;
    foreach($words as $val) {
      $mmm++;
?>
        <a href="#" onclick='return false;' class="mg-btn-info text-center mg-btn-rounded"><?php echo $val->word; ?></a>
<?php
    }

    if($mmm == 0) {
        echo "<div class='text-center small mg-activity-date' style='font-size: 12px !important;'>".@$_translation->array[$_lang_map]->item[124]."</div>";
    }
?>