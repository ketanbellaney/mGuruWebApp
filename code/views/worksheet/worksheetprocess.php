<div style='width: 630px; padding: 5px; margin: 5px;'>
    <table style='width: 630px;'>
        <tr>
            <td align="left" valign="middle"><b style='font-size: 18px;'><img src="<?php echo base_url("images/logo.png"); ?>" width='40' style='display: inline; margin-top: -9px;' /> mGuru</b><br />
            <b style='font-size: 18px;'><em style='font-size: 12px;'>Go to <a href='http://www.mguru.co.in'>www.mguru.co.in</a> check out our apps!</em></b></td>
            <td align="right" valign="middle">
            <table>
                <tr>
                    <td colspan='2'><b style='font-size: 14px;'><?php echo @$ws->name; ?></b></td>
                </tr>
                <tr>
                    <td><b style='font-size: 14px;'>Name:</b></td>
                    <td><b style='font-size: 14px;'>_________________________</b></td>
                </tr>
            </table>
            </td>
        </tr>
    </table>
    <hr />
    <table>
        <tr>
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
        $iii = $ii + 1;
        echo "<td><span style='float:left; margin:left: 5px; width: 300px;padding: 5px; margin: 5px; border-right: 1px solid #C5C5C5;'><b style='float: left; margin-right: 5px;'>Q$iii)</b>" .$mmm . "</span></td>";
        if($iii % 2 == 0) {
//            echo "<br style='clear:both;' /><hr /><br />";
        }
        if($iii % 2 == 0) {
            echo "</tr><tr>";
        }
        $ii++;
    }
    ?>
    </tr>
    </table>
</div>