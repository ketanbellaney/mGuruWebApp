<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>
<div class="mg-report-percentage">
    <span>
        <span class="mg-main-percent" id='rcc4'></span>
    </span>
    <sup>%</sup>
</div>
<div class="mg-total-outof small text-center"><?php echo @$_translation->array[$_lang_map]->item[177]; ?> <strong id='rcc2'></strong></div>
<div class="mg-report-stars text-center" id='rcc3'>

</div>

<?php
    $tot1 = 0;
    $tot2 = 0;
    foreach($report_card as $val) {
        $tot1 += $val['score'];
        $tot2 += $val['points'];
?>
    <div class="mg-report-item row">
        <div class="col-md-8">
            <div class="small text-left">
                <?php echo $val['levelname']; ?>
            </div>
            <div class="mg-item-stars text-left">
                <?php
                    if($val['stars'] >= 3) {
                ?>
                        <img src="<?php echo base_url("webapp_asset/images/report_star_2.svg"); ?>" alt="mGuru Report Star">
                        <img src="<?php echo base_url("webapp_asset/images/report_star_2.svg"); ?>" alt="mGuru Report Star">
                        <img src="<?php echo base_url("webapp_asset/images/report_star_2.svg"); ?>" alt="mGuru Report Star">
                <?php
                    } else if($val['stars'] >= 2) {
                ?>
                        <img src="<?php echo base_url("webapp_asset/images/report_star_2.svg"); ?>" alt="mGuru Report Star">
                        <img src="<?php echo base_url("webapp_asset/images/report_star_2.svg"); ?>" alt="mGuru Report Star">
                        <img src="<?php echo base_url("webapp_asset/images/report_star_1.svg"); ?>" alt="mGuru Report Star">
                <?php
                    } else if($val['stars'] >= 1) {
                ?>
                        <img src="<?php echo base_url("webapp_asset/images/report_star_2.svg"); ?>" alt="mGuru Report Star">
                        <img src="<?php echo base_url("webapp_asset/images/report_star_1.svg"); ?>" alt="mGuru Report Star">
                        <img src="<?php echo base_url("webapp_asset/images/report_star_1.svg"); ?>" alt="mGuru Report Star">
                <?php
                    } else {
                ?>
                        <img src="<?php echo base_url("webapp_asset/images/report_star_1.svg"); ?>" alt="mGuru Report Star">
                        <img src="<?php echo base_url("webapp_asset/images/report_star_1.svg"); ?>" alt="mGuru Report Star">
                        <img src="<?php echo base_url("webapp_asset/images/report_star_1.svg"); ?>" alt="mGuru Report Star">
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <strong class="mg-item-outof text-right"><?php echo $val['score']; ?> on <?php echo $val['points']; ?></strong>
        </div>
    </div>
<?php
    }

    $percentage = ( $tot1 * 100 ) / $tot2;
    $percentage = number_format($percentage);
?>
<input type='hidden' name='rcc' id='rcc' value='<?php echo $percentage . ":::". $tot1 . ":::" . $tot2;?>' />
<div class='hidden' id='rcc1'>
    <?php
        if($percentage >= 80) {
    ?>
            <img src="<?php echo base_url("webapp_asset/images/report_star_2.svg"); ?>" alt="mGuru Report Star">
            <img src="<?php echo base_url("webapp_asset/images/report_star_2.svg"); ?>" alt="mGuru Report Star">
            <img src="<?php echo base_url("webapp_asset/images/report_star_2.svg"); ?>" alt="mGuru Report Star">
    <?php
        } else if($percentage >= 60) {
    ?>
            <img src="<?php echo base_url("webapp_asset/images/report_star_2.svg"); ?>" alt="mGuru Report Star">
            <img src="<?php echo base_url("webapp_asset/images/report_star_2.svg"); ?>" alt="mGuru Report Star">
            <img src="<?php echo base_url("webapp_asset/images/report_star_1.svg"); ?>" alt="mGuru Report Star">
    <?php
        } else if($percentage >= 40) {
    ?>
            <img src="<?php echo base_url("webapp_asset/images/report_star_2.svg"); ?>" alt="mGuru Report Star">
            <img src="<?php echo base_url("webapp_asset/images/report_star_1.svg"); ?>" alt="mGuru Report Star">
            <img src="<?php echo base_url("webapp_asset/images/report_star_1.svg"); ?>" alt="mGuru Report Star">
    <?php
        } else {
    ?>
            <img src="<?php echo base_url("webapp_asset/images/report_star_1.svg"); ?>" alt="mGuru Report Star">
            <img src="<?php echo base_url("webapp_asset/images/report_star_1.svg"); ?>" alt="mGuru Report Star">
            <img src="<?php echo base_url("webapp_asset/images/report_star_1.svg"); ?>" alt="mGuru Report Star">
    <?php
        }
    ?>
</div>