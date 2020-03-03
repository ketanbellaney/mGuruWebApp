<div style=''>
    <?php
    $ii = 0;
    foreach( $questions as $val) {

        $quest = json_decode($val);
        $mmm = "";

        if( in_array(@$questions_template[$ii], array(1,9,10,29,30,31,39,40,41,49)) ) {

            if(strpos(@$questions_bll[$ii],'bll_division') !== false ) {
                $quess = "\$mmm = ws_template_" . @$questions_template[$ii]. "(\$quest,'&divide;');";
            } else if(strpos(@$questions_bll[$ii],'bll_multiplication') !== false ) {
                $quess = "\$mmm = ws_template_" . @$questions_template[$ii]. "(\$quest,'x');";
            } else if(strpos(@$questions_bll[$ii],'bll_subtraction') !== false ) {
                $quess = "\$mmm = ws_template_" . @$questions_template[$ii]. "(\$quest,'-');";
            } else if(strpos(@$questions_bll[$ii],'bll_addition') !== false ) {
                $quess = "\$mmm = ws_template_" . @$questions_template[$ii]. "(\$quest,'+');";
            } else if (strpos(@$questions_bll[$ii],'mg_bll_decimals_add_and_subtract_decimals') !== false) {
                if(strpos(@$questions_bll[$ii],'1') !== false || strpos(@$questions_bll[$ii],'2') !== false || strpos(@$questions_bll[$ii],'3') !== false || strpos(@$questions_bll[$ii],'4') !== false || strpos(@$questions_bll[$ii],'5') !== false ) {
                    $quess = "\$mmm = ws_template_" . @$questions_template[$ii]. "(\$quest,'+');";
                } else {
                    $quess = "\$mmm = ws_template_" . @$questions_template[$ii]. "(\$quest,'-');";
                }
            }
        } else {
            $quess = "\$mmm = ws_template_" . @$questions_template[$ii]. "(\$quest);";
        }


        $aa = eval($quess);

        echo $mmm;

        $ii++;
    }
    ?>
</div>