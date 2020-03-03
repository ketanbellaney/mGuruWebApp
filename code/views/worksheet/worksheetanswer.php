<div style='width: 630px; padding: 5px; margin: 5px;'>
    <table style='width: 630px;'>
        <tr>
            <td align="left" valign="middle"><b style='font-size: 18px;'><img src="<?php echo base_url("images/logo.png"); ?>" width='40' style='display: inline; margin-top: -9px;' /> mGuru</b><br />
            <b style='font-size: 18px;'><em style='font-size: 12px;'>Go to <a href='http://www.mguru.co.in'>www.mguru.co.in</a> check out our apps!</em></b></td>
            <td align="right" valign="bottom"><b style='font-size: 14px;'><?php echo @$ws->name; ?></b></td>
        </tr>
    </table>
    <hr />
    <table>
        <tr>
    <?php
    $ii = 0;

    function ws_replace_special_fields_answer($string) {

        $string = preg_replace('/\$frac\((.{1,11}),(.{1,11}),(.{1,11})\)/', '$1&nbsp; $2/$3', $string);
        $string = preg_replace('/\$frac\((.{1,11}),(.{1,11})\)/', '$1/$2', $string);

        return $string;
    }

    foreach( $questions as $val) {

        $quest = json_decode($val);
        $iii = $ii + 1;


        $answer = array();
        if(isset($quest->data->answer)) {
            if(ereg("(\.)(png$)", $quest->data->answer)) {
                $answer[] = "<img src='".base_url("mathimages/" .  $quest->data->answer)."' width='90' style='margin-left: 3px; margin-top: 3px; padding:2px; border: 1px solid #FF6633; display: inline; border-radius: 15px;' />";
            } else {
                $answer[] = ws_replace_special_fields_answer($quest->data->answer);
            }
        }
        if(isset($quest->data->answer1)) {
            if(ereg("(\.)(png$)", $quest->data->answer1)) {
                $answer[] = "<img src='".base_url("mathimages/" .  $quest->data->answer1)."' width='90' style='margin-left: 3px; margin-top: 3px; padding:2px; border: 1px solid #FF6633; display: inline; border-radius: 15px;' />";
            } else {
                $answer[] = ws_replace_special_fields_answer($quest->data->answer1);
            }
        }
        if(isset($quest->data->answer2)) {
            if(ereg("(\.)(png$)", $quest->data->answer2)) {
                $answer[] = "<img src='".base_url("mathimages/" .  $quest->data->answer2)."' width='90' style='margin-left: 3px; margin-top: 3px; padding:2px; border: 1px solid #FF6633; display: inline; border-radius: 15px;' />";
            } else {
                $answer[] = ws_replace_special_fields_answer($quest->data->answer2);
            }
        }
        if(isset($quest->data->answer3)) {
            if(ereg("(\.)(png$)", $quest->data->answer3)) {
                $answer[] = "<img src='".base_url("mathimages/" .  $quest->data->answer3)."' width='90' style='margin-left: 3px; margin-top: 3px; padding:2px; border: 1px solid #FF6633; display: inline; border-radius: 15px;' />";
            } else {
                $answer[] = ws_replace_special_fields_answer($quest->data->answer3);
            }
        }
        if(isset($quest->data->answer4)) {
            if(ereg("(\.)(png$)", $quest->data->answer4)) {
                $answer[] = "<img src='".base_url("mathimages/" .  $quest->data->answer4)."' width='90' style='margin-left: 3px; margin-top: 3px; padding:2px; border: 1px solid #FF6633; display: inline; border-radius: 15px;' />";
            } else {
                $answer[] = ws_replace_special_fields_answer($quest->data->answer4);
            }
        }
        if(isset($quest->data->answer5)) {
            if(ereg("(\.)(png$)", $quest->data->answer5)) {
                $answer[] = "<img src='".base_url("mathimages/" .  $quest->data->answer5)."' width='90' style='margin-left: 3px; margin-top: 3px; padding:2px; border: 1px solid #FF6633; display: inline; border-radius: 15px;' />";
            } else {
                $answer[] = ws_replace_special_fields_answer($quest->data->answer5);
            }
        }
        if(isset($quest->data->answer6)) {
            if(ereg("(\.)(png$)", $quest->data->answer6)) {
                $answer[] = "<img src='".base_url("mathimages/" .  $quest->data->answer6)."' width='90' style='margin-left: 3px; margin-top: 3px; padding:2px; border: 1px solid #FF6633; display: inline; border-radius: 15px;' />";
            } else {
                $answer[] = ws_replace_special_fields_answer($quest->data->answer6);
            }
        }
        if(isset($quest->data->answer_array)) {
            foreach( $quest->data->answer_array as $val1) {
                if(ereg("(\.)(png$)", $val)) {
                    $answer[] = "<img src='".base_url("mathimages/" .  $val1)."' width='90' style='margin-left: 3px; margin-top: 3px; padding:2px; border: 1px solid #FF6633; display: inline; border-radius: 15px;' />";
                } else {
                    $answer[] = ws_replace_special_fields_answer($val1);
                }
            }
        }
        if(isset($quest->data->answer_array1)) {
            foreach( $quest->data->answer_array1 as $val1) {
                if(ereg("(\.)(png$)", $val)) {
                    $answer[] = "<img src='".base_url("mathimages/" .  $val1)."' width='90' style='margin-left: 3px; margin-top: 3px; padding:2px; border: 1px solid #FF6633; display: inline; border-radius: 15px;' />";
                } else {
                    $answer[] = ws_replace_special_fields_answer($val1);
                }
            }
        }
        if(isset($quest->data->answer_array2)) {
            foreach( $quest->data->answer_array2 as $val1) {
                if(ereg("(\.)(png$)", $val)) {
                    $answer[] = "<img src='".base_url("mathimages/" .  $val1)."' width='90' style='margin-left: 3px; margin-top: 3px; padding:2px; border: 1px solid #FF6633; display: inline; border-radius: 15px;' />";
                } else {
                    $answer[] = ws_replace_special_fields_answer($val1);
                }
            }
        }
        if(isset($quest->data->answer_pattern)) {
            if(ereg("(\.)(png$)", $quest->data->C_answer_value)) {
                $answer[] = str_replace(array("A","B","C"),array("<img src='".base_url("mathimages/" . @$quest->data->A_answer_value)."' width='25' style='margin-left:1px;display:inline;border:1px solid #5F5F5F;' />","<img src='".base_url("mathimages/" . @$quest->data->B_answer_value)."' width='25' style='margin-left:1px;display:inline;border:1px solid #5F5F5F;' />","<img src='".base_url("mathimages/" . @$quest->data->C_answer_value)."' width='25' style='margin-left:1px;display:inline;border:1px solid #5F5F5F;' />"),@$quest->data->answer_pattern);
            } else {
                $answer[] = str_replace(array("A","B","C"),array(@$quest->data->A_answer_value,@$quest->data->B_answer_value,@$quest->data->C_answer_value),@$quest->data->answer_pattern);
            }
        }



        echo "<td><span style='float:left; margin:left: 5px; width: 300px;padding: 5px; margin: 5px; border-right: 1px solid #C5C5C5;'>
            <b style='float: left; margin-right: 5px;'>Q$iii)</b>".implode(", ", $answer). "</span></td>";

        if($iii % 2 == 0) {
            echo "</tr><tr>";
        }
        $ii++;
    }
    ?>
    </tr>
    </table>
</div>