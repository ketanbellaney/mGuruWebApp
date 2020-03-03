<?php

    /***********************************
     *   Common Functions              *
     ***********************************/

    //! Replace special characters
    function ws_replace_special_fields($string) {

        $string = preg_replace('/\$frac\((.{1,11}),(.{1,11}),(.{1,11})\)/', '$1&nbsp; $2/$3', $string);
        $string = preg_replace('/\$frac\((.{1,11}),(.{1,11})\)/', '$1/$2', $string);

        $string = str_replace("::blank::","&nbsp;<div style='display:inline; border: 1px solid #FF6633; border-radius: 10px; width:75px; height: 25px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>&nbsp;",$string);

        $string = nl2br($string);

        return $string;
    }

    //! Replace special characters
    function ws_replace_special_fields1($string) {

        $string = preg_replace('/\$frac\((.{1,11}),(.{1,11}),(.{1,11})\)/', '$1&nbsp; $2/$3', $string);
        $string = preg_replace('/\$frac\((.{1,11}),(.{1,11})\)/', '$1/$2', $string);

        $string = str_replace("::blank::","&nbsp;<div style='display:inline; border: 1px solid #FF6633; border-radius: 10px; width:75px; height: 25px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>&nbsp;",$string);

        $string = nl2br($string);

        return $string;
    }

    //! Develop Question
    function ws_develop_question($obj) {
        $string = '';

        if(isset($obj->data->question)) {
            $string = ws_replace_special_fields(@$obj->data->question) ."<br /><br />";
        }

        return $string;
    }

    //! Develop Main Image
    function ws_develop_main_image($obj,$width = 300) {
        $string = '';
        if(isset($obj->data->top_image)) {
            $string = "<img src='".base_url("mathimages/" . @$obj->data->top_image)."' width='60' style='margin-left: 10px; display:inline;' /><br />";
            if(isset($obj->data->middle_image)) {
                $string .= "<img src='".base_url("mathimages/" . @$obj->data->middle_image)."' width='60' style='margin-left: 10px; display:inline;' /><br />";
            }
            $string .= "<img src='".base_url("mathimages/" . @$obj->data->bottom_image)."' width='60' style='margin-left: 10px; display:inline;' />";

            $string .= "<br /><br />";
        } else if(isset($obj->data->image1)) {
            $string = "<img src='".base_url("mathimages/" . @$obj->data->image1)."' width='100' style='margin-left: 10px; display:inline;' />
            <img src='".base_url("mathimages/" . @$obj->data->image2)."' width='100' style='margin-left: 10px; display:inline;' />";
            if(isset($obj->data->image3)) {
                $string .= "<img src='".base_url("mathimages/" . @$obj->data->image3)."' width='100' style='margin-left: 10px; display:inline;' />";
            }
            $string .= "<br /><br />";
        } else if(isset($obj->data->image)) {
            $string = "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='".$width."' style='' /><br /><br />";
        }

        return $string;
    }

    //! Develop MCQ or text box
    function ws_develop_mcq_or_textbox_image($obj,$width = 70) {
        $string = '';

        if(isset($obj->data->mcq_options)) {
            foreach($obj->data->mcq_options as $options) {
                if(ereg("(\.)(png$)", $options)) {
                    $string .= "<img src='".base_url("mathimages/" . @$options)."' width='".$width."' style='margin-left: 3px; margin-top: 3px; padding:2px; border: 1px solid #FF6633; display: inline; border-radius: 15px;' />";
                } else {
                    $mmm = ws_replace_special_fields1($options);
                    if(strpos($mmm,"<table") !== false) {
                        $string .= "<div style='margin-left: 3px;  margin-top: 3px; padding:5px; border: 1px solid #FF6633; display: inline-block; border-radius: 5px;height: 50px;vertical-align: middle;' >".$mmm."</div>";
                    } else {
                        $string .= "<div style='margin-left: 3px;  margin-top: 3px; padding:5px; border: 1px solid #FF6633; display: inline-block; border-radius: 5px;height: 35px;vertical-align: middle;' >".$mmm."</div>";
                    }
                }
            }

            $string .= "<br /><br />";
        } else {
            $string .= "<div style='margin-left: 3px; padding:5px; border: 1px solid #FF6633; display: inline; border-radius: 15px; width:200px;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><br /><br />";
        }

        return $string;
    }



    /***********************************
     *   Template Functions            *
     ***********************************/

    //! Template id 1 Vertical Text Input
    function ws_template_1($obj,$operator = "+") {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            $html_string .= "<table style='margin-left: 50px; font-size: 15px;' >
                <tr>
                    <td width='30' align='left'>&nbsp;</td>
                    <td width='40' align='right' style='padding-right: 15px;'>".@$obj->data->number1."</td>
                    <td width='10' align='right'>&nbsp;</td>
                </tr>
                <tr>
                    <td align='left'>$operator</td>
                    <td align='right' style='padding-right: 15px;'>".@$obj->data->number2."</td>
                </tr>";
            if(isset($obj->data->number3)) {
                $html_string .= "<tr>
                    <td align='left'>$operator</td>
                    <td align='right' style='padding-right: 15px;'>".@$obj->data->number3."</td>
                </tr>";
            }
            if(isset($obj->data->number4)) {
                $html_string .= "<tr>
                    <td align='left'>$operator</td>
                    <td align='right' style='padding-right: 15px;'>".@$obj->data->number4."</td>
                </tr>";
            }
            if(isset($obj->data->number5)) {
                $html_string .= "<tr>
                    <td align='left'>$operator</td>
                    <td align='right' style='padding-right: 15px;'>".@$obj->data->number5."</td>
                </tr>";
            }
            if(isset($obj->data->number6)) {
                $html_string .= "<tr>
                    <td align='left'>$operator</td>
                    <td align='right' style='padding-right: 15px;'>".@$obj->data->number6."</td>
                </tr>";
            }

            $html_string .= "
            <tr>
                    <td colspan='3' style='border-top: 1px solid #000000;' ></td>
            </tr><tr>
                    <td colspan='3' ><div style='border: 1px solid #FF6633; border-radius: 10px; width:75px; height:25px;' >&nbsp;&nbsp;&nbsp;</div></td>
            </tr>
            </table>


            <br /><br />";
        }
        return $html_string;
    }

    //! Template id 2 Text MCQ
    function ws_template_2($obj) {

        $html_string = ws_template_23($obj);

        return $html_string;
    }

    //! Template id 3 Simple QA Long
    function ws_template_3($obj) {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            $html_string .= "<div style='margin-left: 10px; padding:5px; border: 1px solid #FF6633; border-radius: 15px; width:200px;' >&nbsp;&nbsp;</div><br /><br />";

        }
        return $html_string;
    }

    //! Template id 4 Simple QA Short
    function ws_template_4($obj) {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            $html_string .= "<div style='margin-left: 10px; padding:5px; border: 1px solid #FF6633; border-radius: 15px; width:100px;' >&nbsp;&nbsp;</div><br /><br />";

        }
        return $html_string;
    }

    //! Template id 5 Simple QA Short
    function ws_template_5($obj) {

        $html_string = '';

        if(isset($obj->data)) {
            if(isset($obj->data->left_image)) {
                $html_string .= ws_develop_question($obj);

                $html_string .= "<table style='font-size: 15px; ' >
                <tr>
                    <td width='100' valign='middle'><img src='".base_url("mathimages/" . @$obj->data->left_image)."' width='90' /></td>
                    <td width='20' valign='middle' align='center'>=</td>
                    <td width='50' valign='middle' align='center'><div style='margin-left: 10px; padding:5px; border: 1px solid #FF6633; border-radius: 15px; width:50px;' >&nbsp;&nbsp;</div></td>
                    <td width='30' valign='middle' align='center'>x</td>
                    <td width='100' valign='middle'><img src='".base_url("mathimages/" . @$obj->data->right_image)."' width='90' /></td>
                </tr>
                        </table><br /><br />";
            } else {
                $html_string .= ws_develop_question($obj);

                $html_string .= "<table style='font-size: 15px;' >
                <tr>";
                if(isset($obj->data->image)) {
                    $html_string .= "<td width='100' valign='middle' align='center'><img src='".base_url("mathimages/" . @$obj->data->image)."' width='90' /><br />
                    Rs. ".@$obj->data->object_price."</td>";
                } else {
                    $html_string .= "<td width='50' valign='middle' align='center'>Rs. ".@$obj->data->object_price."</td>";
                }
                $html_string .= "<td width='20' valign='middle' align='center'>=</td>
                    <td width='50' valign='middle' align='center'><div style='margin-left: 10px; padding:5px; border: 1px solid #FF6633; border-radius: 15px; width:50px;' >&nbsp;&nbsp;</div></td>
                    <td width='30' valign='middle' align='center'>x</td>
                    <td width='100' valign='middle'><img src='".base_url("mathimages/" . @$obj->data->image1)."' width='90' /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td valign='middle' align='center'>+</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td valign='middle' align='center'><div style='margin-left: 10px; padding:5px; border: 1px solid #FF6633; border-radius: 15px; width:50px;' >&nbsp;&nbsp;</div></td>
                    <td valign='middle' align='center'>x</td>
                    <td valign='middle'><img src='".base_url("mathimages/" . @$obj->data->image2)."' width='90' /></td>
                </tr>";
                if(isset($obj->data->image3)) {
                    $html_string .= "<tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td valign='middle' align='center'>+</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td valign='middle' align='center'><div style='margin-left: 10px; padding:5px; border: 1px solid #FF6633; border-radius: 15px; width:50px;' >&nbsp;&nbsp;</div></td>
                        <td valign='middle' align='center'>x</td>
                        <td valign='middle'><img src='".base_url("mathimages/" . @$obj->data->image3)."' width='90' /></td>
                    </tr>";
                }
                $html_string .= "</table><br /><br />";
            }
        }
        return $html_string;
    }

    //! Template id 8 MCQ with images
    function ws_template_8($obj) {

        $html_string = '';

        if(isset($obj->data)) {

            if(isset($obj->data->C_value)) {
                $html_string .= "<div style='margin-top: 10px; margin-bottom: 10px;font-size: 15px;' >";

                if(ereg("(\.)(png$)", $obj->data->C_value)) {
                    $html_string .= str_replace(array("A","B","C"),array("<img src='".base_url("mathimages/" . @$obj->data->A_value)."' width='25' style='margin-left:1px;display:inline;border:1px solid #5F5F5F;' />","<img src='".base_url("mathimages/" . @$obj->data->B_value)."' width='25' style='margin-left:1px;display:inline;border:1px solid #5F5F5F;' />","<img src='".base_url("mathimages/" . @$obj->data->C_value)."' width='25' style='margin-left:1px;display:inline;border:1px solid #5F5F5F;' />"),@$obj->data->pattern);
                } else {
                    $html_string .= str_replace(array("A","B","C"),array(@$obj->data->A_value,@$obj->data->B_value,@$obj->data->C_value),@$obj->data->pattern);
                }

                $html_string .= "</div><br />";

                $html_string .= ws_develop_question($obj);

                $html_string .= "<table style='font-size: 15px;' cellspacing='5' >";

                $iii = 1;
                foreach($obj->data->mcq_options as $options) {
                    if(isset($obj->data->C_answer_value)) {
                        if(ereg("(\.)(png$)", $obj->data->C_answer_value)) {
                            $html_string .= "<tr><td style='padding-top: 5px;'>$iii) ".str_replace(array("A","B","C"),array("<img src='".base_url("mathimages/" . @$obj->data->A_answer_value)."' width='25' style='margin-left: 1px; display: inline; border: 1px solid #5F5F5F;' />","<img src='".base_url("mathimages/" . @$obj->data->B_answer_value)."' width='25' style='margin-left: 1px; display: inline;  border: 1px solid #5F5F5F;' />","<img src='".base_url("mathimages/" . @$obj->data->C_answer_value)."' width='25' style='margin-left: 1px; display: inline;  border: 1px solid #5F5F5F;' />"),@$options)."</td></tr>";
                        } else {
                            $html_string .= "<tr><td style='padding-top: 5px;'>$iii) ".str_replace(array("A","B","C"),array(@$obj->data->A_answer_value,@$obj->data->B_answer_value,@$obj->data->C_answer_value),@$options)."</td></tr>";
                        }
                    } else {
                        if(ereg("(\.)(png$)", $obj->data->C_value)) {
                            $html_string .= "<tr><td style='padding-top: 5px;'>$iii) ".str_replace(array("A","B","C"),array("<img src='".base_url("mathimages/" . @$obj->data->A_value)."' width='25' style='margin-left: 1px; display: inline; border: 1px solid #5F5F5F;' />","<img src='".base_url("mathimages/" . @$obj->data->B_value)."' width='25' style='margin-left: 1px; display: inline; border: 1px solid #5F5F5F;' />","<img src='".base_url("mathimages/" . @$obj->data->C_value)."' width='25' style='margin-left: 1px; display: inline; border: 1px solid #5F5F5F;' />"),@$options)."</td></tr>";
                        } else {
                            $html_string .= "<tr><td style='padding-top: 5px;'>$iii) ".str_replace(array("A","B","C"),array(@$obj->data->A_value,@$obj->data->B_value,@$obj->data->C_value),@$options)."</td></tr>";
                        }
                    }
                    $iii++;
                }
                $html_string .= "</tr>
                    </table><br /><br />";
            } else {
                $html_string .= ws_develop_question($obj);

                $html_string .= "<table style='font-size: 15px;' cellspacing='5'>";

                $iii = 1;
                foreach($obj->data->mcq_options as $options) {
                    $html_string .= "<tr>
                        <td width='300' valign='middle' style='border: 1px solid #FF6633;'>$iii ) ";
                    for($ii = 0 ; $ii < $options ; $ii++) {

                        if($ii % 10 == 0 && $ii != 0) {
                            $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='25' style='margin-left: 22px; display: inline; ' />";
                        } else {
                            $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='25' style='margin-left: 1px; display: inline; ' />";
                        }
                    }

                    $html_string .= "</td></tr>";
                    $iii++;
                }

                $html_string .= "</table><br /><br />";
            }
        }
        return $html_string;
    }

    //! Template id 9 Horizontal Text-Input
    function ws_template_9($obj,$operator = "+") {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            $html_string .= @$obj->data->number1."&nbsp;&nbsp;".$operator."&nbsp;&nbsp;".@$obj->data->number2;

            if(isset($obj->data->number3)) {
                $html_string .= "&nbsp;&nbsp;".$operator."&nbsp;&nbsp;".@$obj->data->number3;
            }
            if(isset($obj->data->number4)) {
                $html_string .= "&nbsp;&nbsp;".$operator."&nbsp;&nbsp;".@$obj->data->number4;
            }
            if(isset($obj->data->number5)) {
                $html_string .= "&nbsp;&nbsp;".$operator."&nbsp;&nbsp;".@$obj->data->number5;
            }
            if(isset($obj->data->number6)) {
                $html_string .= "&nbsp;&nbsp;".$operator."&nbsp;&nbsp;".@$obj->data->number6;
            }

            $html_string .= "&nbsp;&nbsp;=&nbsp;&nbsp;<div style='padding:5px; border: 1px solid #FF6633; display: inline; border-radius: 15px; width:100px;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><br /><br />";
        }
        return $html_string;
    }

    //! Template id 10 Multiple Horizontal Text-Inputs
    function ws_template_10($obj,$operator = "+") {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            $html_string .= @$obj->data->number1."&nbsp;&nbsp;".$operator."&nbsp;&nbsp;".@$obj->data->number2 . "&nbsp;&nbsp;=&nbsp;&nbsp;";

            $html_string .= "<div style='padding:5px; border: 1px solid #FF6633; display: inline; border-radius: 15px; width:200px;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><br /><br />";

            $html_string .= @$obj->data->number1_related."&nbsp;&nbsp;".$operator."&nbsp;&nbsp;".@$obj->data->number2_related . "&nbsp;&nbsp;=&nbsp;&nbsp;";

            $html_string .= "<div style='padding:5px; border: 1px solid #FF6633; display: inline; border-radius: 15px; width:200px;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><br /><br />";
        }
        return $html_string;
    }

    //! Template id 11 Images and Horizontal Text-Input
    function ws_template_11($obj) {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            $width = 500 / (@$obj->data->number1 + @$obj->data->number2) ;

            for($ii = 0 ; $ii < (@$obj->data->number1 - @$obj->data->number2) ; $ii++) {
                $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='$width' style='margin-left: 5px; padding:2px; display: inline;' />";
            }

            $cross_image = str_replace(".png","_cross.png",@$obj->data->image);

            for($ii = 0 ; $ii < @$obj->data->number2 ; $ii++) {
                $html_string .= "<img src='".base_url("mathimages/" . @$cross_image)."' width='$width' style='margin-left: 5px; padding:2px; display: inline;' />";
            }

            $html_string .= "<br /><br />";
            $html_string .= @$obj->data->number1."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".@$obj->data->number2 . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

            $html_string .= "<div style='padding:5px; border: 1px solid #FF6633; display: inline; border-radius: 15px; width:100px;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><br /><br />";

        }
        return $html_string;
    }

    //! Template id 14 Simple Fraction QA
    function ws_template_14($obj) {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            if(isset($obj->data->image1_num)) {
                $html_string .= "<div>";

                for($ii = 0 ; $ii < $obj->data->image1_num ; $ii++) {
                    $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image1)."' width='40' style='margin-left: 5px; display: inline; float:left' />";
                }
                for($ii = 0 ; $ii < $obj->data->image2_num ; $ii++) {
                    $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image2)."' width='40' style='margin-left: 5px; display: inline; float:left' />";
                }
                $html_string .= "</div>";
            } else if(isset($obj->data->image2)) {
                $html_string .= "<div>";

                for($ii = 0 ; $ii < $obj->data->answer1 ; $ii++) {
                    $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image1)."' width='100' style='margin-left: 5px; display: inline; float:left' />";
                }
                $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image2)."' width='100' style='margin-left: 5px; display: inline; float:left' />";
                $html_string .= "</div>";
            }
            if(isset($obj->data->whole_number)) {
                $html_string .= "<br style='clear:both;'/>
                <table style='font-size: 15px;' >
                    <tr>";
                if($obj->data->whole_number == "::blank::") {
                    $html_string .= "<td width='150' rowspan='2' valign='middle' align='center'><div style='margin:5px; border: 1px solid #FF6633; border-radius: 5px; width:100px;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>";
                } else {
                    $html_string .= "<td width='150' rowspan='2' valign='middle' align='center'>".$obj->data->whole_number."</td>";
                }
                if($obj->data->numerator == "::blank::") {
                    $html_string .= "<td width='150' valign='middle' align='center'><div style='margin:5px; border: 1px solid #FF6633; border-radius: 5px; width:100px;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>";
                } else {
                    $html_string .= "<td width='150' valign='middle' align='center'>".$obj->data->numerator."</td>";
                }
                $html_string .= "</tr>
                    <tr >";
                if($obj->data->denominator == "::blank::") {
                    $html_string .= "<td width='150' valign='middle' align='center' style='border-top : 2px solid #000000; ' ><div style='margin:5px; border: 1px solid #FF6633; border-radius: 5px; width:100px;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>";
                } else {
                    $html_string .= "<td width='150' valign='middle' align='center' style='border-top : 2px solid #000000; ' >".$obj->data->denominator."</td>";
                }

                $html_string .= "</tr>
                    </table>";
            } else {
                $html_string .= "<br />
                <table style='font-size: 15px;' >
                    <tr>";
                if($obj->data->numerator == "::blank::") {
                    $html_string .= "<td width='150' valign='middle' align='center'><div style='margin:5px; border: 1px solid #FF6633; border-radius: 5px; width:100px;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>";
                } else {
                    $html_string .= "<td width='150' valign='middle' align='center'>".$obj->data->numerator."</td>";
                }
                $html_string .= "</tr>
                    <tr >";
                if($obj->data->denominator == "::blank::") {
                    $html_string .= "<td width='150' valign='middle' style='border-top : 2px solid #000000; ' align='center'><div style='margin:5px; border: 1px solid #FF6633; border-radius: 5px; width:100px;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>";
                } else {
                    $html_string .= "<td width='150' valign='middle' style='border-top : 2px solid #000000; '  align='center'>".$obj->data->denominator."</td>";
                }

                $html_string .= "</tr>
                    </table>";
            }

        }
        return $html_string;
    }

    //! Template id 17 Mixed Fraction Input
    function ws_template_17($obj) {

        $html_string = ws_template_14($obj);

        return $html_string;
    }

    //! Template id 18 Grouped Images + Multiline Input Fill in the blank
    function ws_template_18($obj) {

        $html_string = '';

        if(isset($obj->data)) {

            if(isset($obj->data->bundled_image)) {
                $num_1 =  (int)( $obj->data->number / 10 );
                $num_2 =  $obj->data->number % 10;

                $html_string .= "<div style='margin-top: 10px; margin-bottom: 10px;' >";

                for($ii = 0 ; $ii < $num_1 ; $ii++) {
                    $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->bundled_image)."' width='50' style='margin-left: 5px; display: inline;' />";
                }

                for($ii = 0 ; $ii < $num_2 ; $ii++) {
                    $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='50' style='margin-left: 5px; display: inline;' />";
                }

                $html_string .= "</div>";

            } else {
                if(isset($obj->data->number)) {
                    if(isset($obj->data->number_statc)) {
                        $html_string .= "<div style='margin-top: 10px; margin-bottom: 10px;' >";

                        for($ii = 0 ; $ii < $obj->data->number_statc ; $ii++) {
                            $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='50' style='margin-left: 5px; display: inline;' />";
                        }

                        $html_string .= "</div>";
                    } else {
                        $html_string .= "<div style='margin-top: 10px; margin-bottom: 10px;' >";

                        for($ii = 0 ; $ii < $obj->data->number ; $ii++) {
                            $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='50' style='margin-left: 5px; display: inline;' />";
                        }

                        $html_string .= "</div>";
                    }

                } else if(isset($obj->data->division_group)) {
                    $num_1 = $obj->data->number1;
                    $num_2 = $obj->data->number2;
                    $num_3 = $obj->data->number3;

                    $div_width = (600 / $num_1) - 5;

                    for($ii = 0 ; $ii < $num_1 ; $ii++) {
                        $html_string .= "<div style='margin-top: 10px; margin-bottom: 10px; width: ".$div_width."px; float: left; border: 1px solid #eeeeee; margin-left: 5px;' >";

                        for($iii = 0 ; $iii < $num_2 ; $iii++) {
                            $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='25' style='margin-left: 5px; display: inline;' />";
                        }

                        $html_string .= "</div>";
                    }
                } else if(isset($obj->data->number3)) {
                    $num_1 = $obj->data->number1;
                    $num_2 = $obj->data->number2;
                    $num_3 = $obj->data->number3;

                    if( $num_1 == "::blank::" ) {
                        $num_1 = $obj->data->answer;
                    }

                    if( $num_2 == "::blank::" ) {
                        $num_2 = $obj->data->answer;
                    }

                    if( $num_3 == "::blank::" ) {
                        $num_3 = $obj->data->answer;
                    }

                    $html_string .= "<div style='margin-top: 10px; margin-bottom: 10px;' >";

                    for($ii = 0 ; $ii < $num_3 ; $ii++) {
                        $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='50' style='margin-left: 5px; display: inline;' />";
                    }

                    $img_cross = str_replace(".png","_cross.png",@$obj->data->image);

                    for($ii = 0 ; $ii < $num_2 ; $ii++) {
                        $html_string .= "<img src='".base_url("mathimages/" . @$img_cross)."' width='50' style='margin-left: 5px; display: inline;' />";
                    }

                    $html_string .= "</div>";

                } else if(isset($obj->data->number1)) {
                    $html_string .= "<div style='margin-top: 10px; margin-bottom: 10px; width: 250px; float: left; border: 1px solid #eeeeee; ' >";

                    for($ii = 0 ; $ii < $obj->data->number1 ; $ii++) {
                        if(isset($obj->data->image1)) {
                            $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image1)."' width='50' style='margin-left: 5px; display: inline;' />";
                        } else {
                            $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='50' style='margin-left: 5px; display: inline;' />";
                        }
                    }

                    $html_string .= "</div>";

                    $html_string .= "<div style='margin-top: 10px; margin-bottom: 10px; width: 250px; float: left; border: 1px solid #eeeeee; margin-left: 20px;' >";

                    for($ii = 0 ; $ii < $obj->data->number2 ; $ii++) {
                        if(isset($obj->data->image2)) {
                            $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image2)."' width='50' style='margin-left: 5px; display: inline;' />";
                        } else {
                            $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='50' style='margin-left: 5px; display: inline;' />";
                        }
                    }

                    $html_string .= "</div>";
                }
            }

            $html_string .= "<br  style='clear:both;' /><br />" . ws_develop_question($obj);
        }
        return $html_string;
    }

    //! Template id 19 Simple fill in the blanks
    function ws_template_19($obj) {
        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);
        }
        return $html_string;
    }

    //! Template id 23 Image - Question - Image Button
    function ws_template_23($obj,$top = true) {

        $html_string = '';

        if(isset($obj->data)) {

            if($top) {
                $html_string .= ws_develop_main_image($obj);
            }

            $html_string .= ws_develop_question($obj);

            if(!$top) {
                $html_string .= ws_develop_main_image($obj);
            }

            $html_string .= ws_develop_mcq_or_textbox_image($obj);
        }
        return $html_string;
    }

    //! Template id 24 Question - Image Button
    function ws_template_24($obj) {

        $html_string = ws_template_23($obj);

        return $html_string;
    }

    //! Template id 25 Image - Question - Text Button
    function ws_template_25($obj,$top = true) {

        $html_string = ws_template_23($obj,$top);

        return $html_string;
    }

    //! Template id 26 Question - Text Button
    function ws_template_26($obj) {

        $html_string = ws_template_23($obj);

        return $html_string;
    }

    //! Template id 27 Question - Image - Text box
    function ws_template_27($obj) {

        $html_string = ws_template_23($obj,false);

        return $html_string;
    }

    //! Template id 28 Question - Image - Text button
    function ws_template_28($obj) {

        $html_string = ws_template_23($obj,false);

        return $html_string;
    }

    //! Template id 29 Vertical Operations with Image
    function ws_template_29($obj,$operator = "+") {

        $html_string = '';

        if(isset($obj->data)) {

            $num_1 = $obj->data->number1;
            $num_2 = $obj->data->number2;
            if(isset($obj->data->number3)) {
                $num_3 = $obj->data->number3;
            } else {
                $num_3 = "::blank::";
            }

            $answer = $obj->data->answer;

            if($num_1 == "::blank::") {
                $num_11 = $obj->data->answer;
            } else {
                $num_11 = $num_1;
            }

            if($num_2 == "::blank::") {
                $num_21 = $obj->data->answer;
            } else {
                $num_21 = $num_2;
            }

            if($num_3 == "::blank::") {
                $num_31 = $obj->data->answer;
            } else {
                $num_31 = $num_3;
            }

            $html_string .= ws_develop_question($obj);

            $html_string .= "<table style='margin-left: 5px; font-size: 15px; font-weight: bold;' >
                <tr>
                    <td width='240' valign='middle' style='border: 1px solid #cccccc;'>";

            for($ii = 0 ; $ii < $num_11 ; $ii++) {
                $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='22' style='margin-left: 1px; display: inline;' />";
            }

            $html_string .= "</td>
                    <td width='20' align='center' valign='middle'>&nbsp;</td>";
            if($num_1 == "::blank::") {
                $html_string .= "<td width='30' align='right' valign='middle'><div style='border: 1px solid #FF6633; border-radius: 10px; height: 25px;' >&nbsp;&nbsp;</div></td>";
            } else {
                $html_string .= "<td width='30' align='right' valign='middle'>".@$obj->data->number1."</td>";
            }

            $html_string .= "</tr>
                <tr>
                    <td valign='middle' style='border: 1px solid #cccccc;'>";

            for($ii = 0 ; $ii < $num_21 ; $ii++) {
                $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='22' style='margin-left: 1px; display: inline;' />";
            }

            $html_string .= "</td>
                    <td align='center' valign='middle'>&nbsp;$operator&nbsp;</td>";
            if($num_2 == "::blank::") {
                $html_string .= "<td align='right' valign='middle'><div style='border: 1px solid #FF6633; border-radius: 10px; height: 25px;' >&nbsp;&nbsp;</div></td>";
            } else {
                $html_string .= "<td align='right' valign='middle'>".@$obj->data->number2."</td>";
            }

            $html_string .= "
                </tr>
                <tr style='border-top: 1px solid #000000;'>
                    <td valign='middle' style='border: 1px solid #cccccc;'>";

            for($ii = 0 ; $ii < @$num_31 ; $ii++) {
                $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='22' style='margin-left: 1px; display: inline;' />";
            }

            $html_string .= "</td>
                    <td align='center' valign='middle'>&nbsp;</td>";
            if($num_3 == "::blank::") {
                $html_string .= "<td align='right' valign='middle'><div style='border: 1px solid #FF6633; border-radius: 10px; height: 25px;' >&nbsp;&nbsp;</div></td>";
            } else {
                $html_string .= "<td align='right' valign='middle'>".@$num_3."</td>";
            }

            $html_string .= "
                </tr>
                </table><br /><br />";
        }
        return $html_string;
    }

    //! Template id 30 Multiple Vertical Text Input
    function ws_template_30($obj,$operator = "+") {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            $html_string .= "<table style='font-size: 15px;' width='300' >
                <tr>
                    <td width='20' align='left'>&nbsp;</td>
                    <td width='50' align='right' style='padding-right:15px;'>".@$obj->data->number1."</td>
                    <td width='50' align='right'>&nbsp;</td>
                    <td width='20' align='left'>&nbsp;</td>
                    <td width='50' align='right' style='padding-right:15px;'>".@$obj->data->number1_related."</td>

                </tr>
                <tr>
                    <td align='right'>$operator</td>
                    <td align='right' style='padding-right:15px;'>".@$obj->data->number2."</td>
                    <td align='right'>&nbsp;</td>
                    <td align='right'>$operator</td>
                    <td align='right' style='padding-right:15px;'>".@$obj->data->number2_related."</td>
                </tr>
                <tr>
                    <td colspan='2' style='border-top: 1px solid #000000;'  ></td>
                    <td align='right'></td>
                    <td colspan='2' style='border-top: 1px solid #000000;'  ></td>
                </tr>
                <tr>
                    <td colspan='2' ><div style='border: 1px solid #FF6633; border-radius: 10px; height:25px;'>&nbsp;&nbsp;</div></td>
                    <td align='right'>&nbsp;</td>
                    <td colspan='2' ><div style='border: 1px solid #FF6633; border-radius: 10px; height:25px;'>&nbsp;&nbsp;</div></td>
                </tr>
            </table><br /><br />";
        }

        return $html_string;
    }

    //! Template id 31 Vertical Text Input with heading
    function ws_template_31($obj,$operator = "+") {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            $num1 = (string)@$obj->data->number1;
            $num2 = (string)@$obj->data->number2;
            $num3 = (string)@$obj->data->number3;
            $num4 = (string)@$obj->data->number4;
            $num5 = (string)@$obj->data->number5;
            $ans = (string)@$obj->data->answer;

            $len1 = strlen($num1);
            $len2 = strlen($num2);
            $len3 = strlen($num3);
            $len4 = strlen($num4);
            $len5 = strlen($num5);
            $anslen = strlen($ans);

            $max_len = $len1;
            if($max_len < $len2) {
                $max_len = $len2;
            }
            if($max_len < $len3) {
                $max_len = $len3;
            }
            if($max_len < $len4) {
                $max_len = $len4;
            }
            if($max_len < $len5) {
                $max_len = $len5;
            }

            if($max_len < $anslen) {
                $max_len = $anslen;
            }

            $assist_header = array("TTh","Th","H","T","U");

            $html_string .= "<table style='font-size: 15px; ' >";
            //if(isset($obj->data->assist)) {
                $html_string .= "<tr>
                    <td width='30' align='right'>&nbsp;</td>";

                for($ii = 0 ; $ii < $max_len ; $ii++) {
                    $html_string .= "<td width='40' align='center'>".@$assist_header[count($assist_header) + $ii - $max_len]."</td>";
                }
                $html_string .= "</tr>";
            //}
            $html_string .= "<tr>
                <td align='right'>&nbsp;</td>";
            for($ii = 0 ; $ii < $max_len ; $ii++) {
                if(strlen($num1) == $max_len) {
                    $html_string .= "<td align='center' >".@$num1[$ii]."</td>";
                } else {
                    $diff = $max_len - strlen($num1);
                    if($diff > $ii) {
                        $html_string .= "<td align='center'>&nbsp;</td>";
                    } else {
                        $html_string .= "<td align='center' >".@$num1[$ii - $diff]."</td>";
                    }
                }
            }
            $html_string .= "</tr>";
            $html_string .= "<tr>
                <td align='right'>$operator</td>";
            for($ii = 0 ; $ii < $max_len ; $ii++) {
                if(strlen($num2) == $max_len) {
                    $html_string .= "<td align='center' >".@$num2[$ii]."</td>";
                } else {
                    $diff = $max_len - strlen($num2);
                    if($diff > $ii) {
                        $html_string .= "<td align='center'>&nbsp;</td>";
                    } else {
                        $html_string .= "<td align='center' >".@$num2[$ii - $diff]."</td>";
                    }
                }
            }
            $html_string .= "</tr>";

            if(isset($obj->data->number3)) {
                $html_string .= "<tr>
                    <td align='right'>$operator</td>";
                for($ii = 0 ; $ii < $max_len ; $ii++) {
                    if(strlen($num3) == $max_len) {
                        $html_string .= "<td align='center' >".@$num3[$ii]."</td>";
                    } else {
                        $diff = $max_len - strlen($num3);
                        if($diff > $ii) {
                            $html_string .= "<td align='center'>&nbsp;</td>";
                        } else {
                            $html_string .= "<td align='center'>".@$num3[$ii - $diff]."</td>";
                        }
                    }
                }
                $html_string .= "</tr>";
            }

            if(isset($obj->data->number4)) {
                $html_string .= "<tr>
                    <td align='right'>$operator</td>";
                for($ii = 0 ; $ii < $max_len ; $ii++) {
                    if(strlen($num4) == $max_len) {
                        $html_string .= "<td align='center' >".@$num4[$ii]."</td>";
                    } else {
                        $diff = $max_len - strlen($num4);
                        if($diff > $ii) {
                            $html_string .= "<td align='center'>&nbsp;</td>";
                        } else {
                            $html_string .= "<td align='center' >".@$num4[$ii - $diff]."</td>";
                        }
                    }
                }
                $html_string .= "</tr>";
            }

            if(isset($obj->data->number5)) {
                $html_string .= "<tr>
                    <td align='right'>$operator</td>";
                for($ii = 0 ; $ii < $max_len ; $ii++) {
                    if(strlen($num5) == $max_len) {
                        $html_string .= "<td align='center' >".@$num5[$ii]."</td>";
                    } else {
                        $diff = $max_len - strlen($num5);
                        if($diff > $ii) {
                            $html_string .= "<td align='center'>&nbsp;</td>";
                        } else {
                            $html_string .= "<td align='center' >".@$num5[$ii - $diff]."</td>";
                        }
                    }
                }
                $html_string .= "</tr>";
            }

            $html_string .= "
            <tr>
                <td colspan='9' style='border-top: 1px solid #000000;'></td>
            </tr>
            <tr>
                    <td align='right' >&nbsp;</td>";
            for($ii = 0 ; $ii < $max_len ; $ii++) {
                $html_string .= "<td align='right' style='border: 1px solid #000000;'><div style='padding:5px; border: 1px solid #FF6633; border-radius: 10px; height: 25px;'> </div></td>";
            }
            $html_string .= "</tr>
            </table><br /><br />";
        }

        return $html_string;
    }

    //! Template id 32 Math Table
    function ws_template_32($obj) {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            $html_string .= "<table style='margin-left: 50px; font-size: 15px; font-weight: bold;' >";

            $ii = 1;

            $oprand = " times ";
            if(rand(1,2) == 1) {
                $oprand = " x ";
            } else if(rand(1,2) == 1) {
                $oprand = " times ";
            }

            $number = $obj->data->number;

            foreach( $obj->data->answer_array as $val) {
                $html_string .= "
                <tr>
                    <td width='20' align='center' valign='middle' >$number</td>
                    <td width='20' align='center' valign='middle' >$oprand</td>
                    <td width='20' align='center' valign='middle' >$ii</td>
                    <td width='20' align='center' valign='middle' > = </td>
                    <td width='50' align='center'><div style='width:40px; height: 25px;border: 1px solid #000000;'>&nbsp;&nbsp;</div></td>
                </tr>";
                $ii++;
            }

            $html_string .= "</table><br /><br />";
        }

        return $html_string;
    }

    //! Template id 33 Question - Image - Text box - relative multiplication
    function ws_template_33($obj) {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            $html_string .= "<table>
                <tr>
                    <td width='140' valign='middle' align='center'>";
            for($ii = 0 ; $ii < @$obj->data->number1 ; $ii++) {
                $html_string .= "<div style='margin-top: 5px; border: 1px solid #eeeeee;padding: 5px;' >";
                for($iii = 0 ; $iii < @$obj->data->number2 ; $iii++) {
                    $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='25' style='margin-left: 5px; display: inline;' />";
                }
                $html_string .= "</div>";
            }

            $html_string .= "</td>
                <td width='140' valign='middle' align='center'>";
            for($ii = 0 ; $ii < @$obj->data->number1_related ; $ii++) {
                $html_string .= "<div style='margin-top: 5px; border: 1px solid #eeeeee;padding: 5px;' >";
                for($iii = 0 ; $iii < @$obj->data->number2_related ; $iii++) {
                    $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='25' style='margin-left: 5px; display: inline;' />";
                }
                $html_string .= "</div>";
            }

            $html_string .= "</td>
                </tr>
                <tr>
                    <td valign='middle' align='center'>&nbsp;&nbsp;".@$obj->data->number1."&nbsp;&nbsp;x&nbsp;&nbsp;".@$obj->data->number2."&nbsp;&nbsp;=&nbsp;&nbsp;<div style='display:inline; border: 1px solid #FF6633; border-radius: 10px; width:40px; height: 25px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
                    <td valign='middle' align='center'>&nbsp;&nbsp;".@$obj->data->number1_related."&nbsp;&nbsp;x&nbsp;&nbsp;".@$obj->data->number2_related."&nbsp;&nbsp;=&nbsp;&nbsp;<div style='display:inline; border: 1px solid #FF6633; border-radius: 10px; width:40px; height: 25px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
                </tr>
                </table><br /><br />";
        }
        return $html_string;
    }

    //! Template id 34 Lattice method
    function ws_template_34($obj) {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            $html_string .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".@$obj->data->number1."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;x&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".@$obj->data->number2."<br /><br />
            <table border='1'>";

            foreach($obj->data->question_array as $val) {
                $html_string .= "<tr>";

                foreach($val as $val1) {
                    if($val1 == "::blank::") {
                        $html_string .= "<td width='75' valign='middle' align='center' style='padding:3px;'><div style='width:50px; height: 25px;border: 1px solid #FF6633; border-radius: 10px; '>&nbsp;&nbsp;</div></td>";
                    } else {
                        $html_string .= "<td width='75' valign='middle' align='center' style='padding:3px;'>".$val1."</td>";
                    }
                }

                $html_string .= "</tr>";
            }

            $html_string .= "</table><br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".@$obj->data->number1."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;x&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".@$obj->data->number2."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div style='display:inline; padding:5px; border: 1px solid #FF6633; border-radius: 10px; width:75px; height: 25px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><br /><br />";

        }
        return $html_string;
    }

    //! Template id 35 Tabular Fill in the blank
    function ws_template_35($obj) {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            $html_string .= "<table border=1>";

            if(isset($obj->data->table_row1)) {
                $html_string .= "<tr>
                    <td width='75' valign='middle' align='center'>".@$obj->data->unit1."</td>";
                foreach($obj->data->table_row1 as $val1) {
                    if($val1 == "::blank::") {
                        $html_string .= "<td width='75' valign='middle' align='center'><div style=' width:50px; height: 25px;border: 1px solid #FF6633; border-radius: 10px;'>&nbsp;&nbsp;</div></td>";
                    } else {
                        $html_string .= "<td width='75' valign='middle' align='center'>".$val1."</td>";
                    }
                }
                $html_string .= "</tr>
                    <tr>
                        <td width='75' valign='middle' align='center'>".@$obj->data->unit2."</td>";
                foreach($obj->data->table_row2 as $val1) {
                    if($val1 == "::blank::") {
                        $html_string .= "<td width='75' valign='middle' align='center'><div style='width:50px; height: 25px;border: 1px solid #FF6633; border-radius: 10px;'>&nbsp;&nbsp;</div></td>";
                    } else {
                        $html_string .= "<td width='75' valign='middle' align='center'>".$val1."</td>";
                    }
                }
                $html_string .= "</tr>";
            } else {

                foreach($obj->data->question_array as $val) {
                    $html_string .= "<tr>";

                    foreach($val as $val1) {
                        if($val1 == "::blank::") {
                            $html_string .= "<td width='75' valign='middle' align='center'><div style=' width:50px; height: 25px;border: 1px solid #FF6633; border-radius: 10px;'>&nbsp;&nbsp;</div></td>";
                        } else {
                            $html_string .= "<td width='75' valign='middle' align='center'>".$val1."</td>";
                        }
                    }

                    $html_string .= "</tr>";
                }
            }

            $html_string .= "</table><br /><br />";

        }
        return $html_string;
    }

    //! Template id 36 Drag Drop QA
    function ws_template_36($obj) {
        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='50' style='margin-left: 5px; display: inline;' /><br /><br />
            <div style='width:300px; height: 45px;border: 1px solid #000000; background-color: #cccccc;'>&nbsp;&nbsp;</div><br /><br />";
        }
        return $html_string;
    }

    //! Template id 37 Line Number QA
    function ws_template_37($obj) {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='300' /><br /><br />
            <div style='border:1px solid #FF6633; border-radius: 10px; width:75px; height: 25px;'>&nbsp;&nbsp;</div><br /><br />
            ";

        }
        return $html_string;
    }

    //! Template id 38 Fill in the missing number
    function ws_template_38($obj) {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            $html_string .= "<table>
                <tr>";
            foreach($obj->data->question_array as $val1) {
                $html_string .= "<td width='40' valign='middle' align='center'><img src='".base_url("mathimages/" . @$obj->data->image)."' width='35' /></td>";
            }
            $html_string .= "</tr>
                <tr>";
            foreach($obj->data->question_array as $val1) {
                if($val1 == "::blank::") {
                    $html_string .= "<td valign='middle' align='center'><div style='width:40px; height: 25px;border: 1px solid #000000;'>&nbsp;&nbsp;</div></td>";
                } else {
                    $html_string .= "<td valign='middle' align='center'>".$val1."</td>";
                }
            }
            $html_string .= "</tr>";

            $html_string .= "</table><br /><br />";

        }
        return $html_string;
    }

    //! Template id 39 Random Horizontal or Vertical Text-Input
    function ws_template_39($obj,$operator = "+") {

        if(rand(0,1) == 0) {
            $html_string = ws_template_1($obj,$operator);
        } else {
            $html_string = ws_template_9($obj,$operator);
        }

        return $html_string;
    }

    //! Template id 40 Random Multiple Horizontal or Vertical Text-Inputs
    function ws_template_40($obj,$operator = "+") {

        if(rand(0,1) == 0) {
            $html_string = ws_template_10($obj,$operator);
        } else {
            $html_string = ws_template_30($obj,$operator);
        }

        return $html_string;
    }

    //! Template id 41 Number - image - text input
    function ws_template_41($obj,$operator = "+") {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            $html_string .= @$obj->data->number1." " . @$obj->data->image_title;

            for($ii = 0 ; $ii < $obj->data->number2 ; $ii++) {
                $html_string .= "&nbsp;&nbsp;".$operator."&nbsp;&nbsp;&nbsp;<img src='".base_url("mathimages/" . @$obj->data->image)."' width='25' style='display: inline;' />";
            }

            $html_string .= "<br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div style='padding:5px; border: 1px solid #FF6633; display: inline; border-radius: 15px; width:100px;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>&nbsp;&nbsp;" . @$obj->data->image_title . "&nbsp;<br /><br />";

        }
        return $html_string;
    }

    //! Template id 42 Fill in the missing number
    function ws_template_42($obj) {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            if(isset($obj->data->image3)) {
                $html_string .= "<table>
                    <tr>
                        <td width='90' valign='middle' >
                        <img src='".base_url("mathimages/" . @$obj->data->image1)."' width='90' style='display:inline; border:1px solid #FF6633; border-radius: 10px; margin-top: 2px; margin-left: 3px;' />
                        </td>
                        <td width='90' valign='middle'  >
                        <img src='".base_url("mathimages/" . @$obj->data->image2)."' width='90' style='display:inline; border:1px solid #FF6633; border-radius: 10px; margin-top: 2px; margin-left: 3px;'  />
                        </td>
                        <td width='90' valign='middle' >
                        <img src='".base_url("mathimages/" . @$obj->data->image3)."' width='90' style='display:inline; border:1px solid #FF6633; border-radius: 10px; margin-top: 2px; margin-left: 3px;'  />
                        </td>
                    </tr>
                    </table><br /><br />";

            } else {
                if(isset($obj->data->number2)) {
                    $html_string .= "<table>
                        <tr>
                            <td width='300' valign='middle' style='border:1px solid #FF6633; border-radius: 10px; margin-top: 5px;' >&nbsp;A)&nbsp;&nbsp;";
                            for($ii = 0 ; $ii < $obj->data->number1 ; $ii++ ) {
                                if(isset($obj->data->image1)) {
                                    $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image1)."' width='25' style='display:inline; margin-left: 3px;' />";
                                } else {
                                    $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='25' style='display:inline; margin-left: 3px;' />";
                                }
                            }

                    $html_string .= "</td>
                        </tr>
                        <tr>
                            <td width='300' valign='middle' style='border:1px solid #FF6633; border-radius: 10px; margin-top: 5px;' >&nbsp;B)&nbsp;&nbsp;";
                    for($ii = 0 ; $ii < $obj->data->number2 ; $ii++ ) {
                                if(isset($obj->data->image2)) {
                                    $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image2)."' width='25' style='display:inline; margin-left: 3px;' />";
                                } else {
                                    $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='25' style='display:inline; margin-left: 3px;' />";
                                }
                    }

                    $html_string .= "</td>
                        </tr>
                        <tr>
                            <td width='300' valign='middle' style='border:1px solid #FF6633; border-radius: 10px; margin-top: 5px;' >&nbsp;C)&nbsp;&nbsp;neither, they are equal.</td>
                        </tr>";

                    $html_string .= "</table><br /><br />";
                } else {
                    $html_string .= "<table>
                        <tr>
                            <td width='90' valign='middle'  >";
                            $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image1)."' width='90' style='display:inline; border:1px solid #FF6633; border-radius: 10px; margin-top: 2px; margin-left: 3px;'  />";
                    $html_string .= "</td>

                            <td width='90' valign='middle' >";
                            $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image2)."' width='90' style='display:inline; border:1px solid #FF6633; border-radius: 10px; margin-top: 2px; margin-left: 3px;'  />";
                    $html_string .= "</td>
                            </tr>
                            <tr>
                            <td colspan='2' valign='middle' ><br /><div style='display:inline;padding:5px; border:1px solid #FF6633; border-radius: 10px; margin-top: 2px; margin-left: 3px;' > both are equal.</div></td>
                        </tr>";

                    $html_string .= "</table><br /><br />";
                }
            }

        }
        return $html_string;
    }

    //! Template id 43 Question Counting object linear
    function ws_template_43($obj) {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            if(isset($obj->data->object_individual_image)) {
                $html_string .= "<table>
                    <tr>
                        <td width='300' valign='middle' align='center' >";
                for($ii = 0 ; $ii < $obj->data->tens ; $ii++ ) {
                    $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->object_bundle_image)."' width='50' style='display:inline; margin-left: 3px;' />";
                }
                for($ii = 0 ; $ii < $obj->data->ones ; $ii++ ) {
                    $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->object_individual_image)."' width='50' style='display:inline; margin-left: 3px;' />";
                }

                $html_string .= "<br /><br /></td>
                    </tr>
                    <tr>
                        <td width='300' valign='middle' align='center' ><div style='padding:5px; border: 1px solid #FF6633; border-radius: 15px; width:100px;' >&nbsp;&nbsp;</div></td>
                    </tr>
                </table><br /><br />";
            } else if(isset($obj->data->image_array)) {
                $html_string .= "<table>
                    <tr>
                        <td width='300' valign='middle' align='center' >";
                foreach($obj->data->image_array as $val) {
                    $html_string .= "<img src='".base_url("mathimages/" . @$val)."' width='140' style='display:inline; margin-left: 3px;' />";
                }

                $html_string .= "<br /><br /></td>
                    </tr>
                    <tr>
                        <td width='300' valign='middle' ><div style='padding:5px; border: 1px solid #FF6633;  border-radius: 15px; width:100px;' >&nbsp;&nbsp;</div></td>
                    </tr>
                </table><br /><br />";
            } else {
                $html_string .= "<table>
                    <tr>
                        <td width='300'>";
                for($ii = 0 ; $ii < $obj->data->answer ; $ii++ ) {
                    $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='29' style='display:inline; margin-left: 1px;' />";
                }

                $html_string .= "<br /><br /></td>
                    </tr>
                    <tr>
                        <td><div style='padding:5px; border: 1px solid #FF6633;  border-radius: 15px; width:100px;' >&nbsp;&nbsp;</div></td>
                    </tr>
                </table><br /><br />";
            }

        }
        return $html_string;
    }

    //! Template id 44 Question Counting object non-linear
    function ws_template_44($obj) {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            $html_string .= "<table>
                <tr>
                    <td width='300' valign='middle' align='center' >";
                for($ii = 0 ; $ii < $obj->data->answer ; $ii++ ) {
                    $mt = rand(-30, 30);
                    $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='50' style='display:inline; margin-left: 3px; margin-top: ".$mt."px;' />";
                }

                $html_string .= "<br /><br /></td>
                    </tr>
                    <tr>
                        <td width='300' valign='middle' align='center' ><div style='padding:5px; border: 1px solid #FF6633; border-radius: 15px; width:100px;' >&nbsp;&nbsp;</div></td>
                    </tr>
                </table><br /><br />";


        }
        return $html_string;
    }

    //! Template id 45 Question - counting image - MCQ
    function ws_template_45($obj) {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            if(isset($obj->data->question_array)) {
                $html_string .= "<table>
                    <tr>
                        <td width='300'>";
                foreach($obj->data->question_array as $val) {
                    $html_string .= "<img src='".base_url("mathimages/" . @$val)."' width='25' style='display:inline; margin-left: 3px;border:1px solid #000000;' />";
                }

                $html_string .= "</td>
                    </tr>
                </table><br />";
            } else {
                $html_string .= "<table>
                    <tr>
                        <td width=''>
                        <table><tr><td valign='top' style='width: 40px;' >";
                for($ii = 0 ; $ii < $obj->data->number ; $ii++ ) {
                    if($ii % 2 == 0 && $ii > 1) {
                        $html_string .= "</td><td  valign='top'  style='width: 40px;' ><img src='".base_url("mathimages/" . @$obj->data->image)."' width='25' style='display:inline; margin-left: 3px;margin-bottom: 3px;border:1px solid #000000;' /><br />";
                    } else {
                        $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='25' style='display:inline; margin-left: 3px;margin-bottom: 3px;border:1px solid #000000;' /><br />";
                    }
                }

                $html_string .= "</td></tr></table></td>
                    </tr>
                </table><br />";
            }

            $html_string .= ws_develop_mcq_or_textbox_image($obj);

        }
        return $html_string;
    }

    //! Template id 46 Drag Drop arrange in order
    function ws_template_46($obj) {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            $html_string .= "<table>
                <tr>";
            foreach($obj->data->question_array as $val) {
                $html_string .= "<td width='75' valign='middle' align='center' style='margin:10px; border: 1px solid #000000; border-radius: 10px; ' >$val</td>";
            }

            $html_string .= "</tr>
            <tr><td colspan=20 >&nbsp;</td></tr>
            <tr>";
            foreach($obj->data->question_array as $val) {
                $html_string .= "<td width='75' valign='middle' align='center' style='margin:10px; border: 1px solid #000000; border-radius: 10px; ' >&nbsp;&nbsp;</td>";
            }

            $html_string .= "</tr>


            </table><br /><br />";

        }
        return $html_string;
    }

    //! Template id 47 Group Image - Question - Text input
    function ws_template_47($obj) {

        $html_string = '';

        if(isset($obj->data)) {
            $html_string .= "<br style='clear:both;' />";
            if(isset($obj->data->divide)) {
                if($obj->data->divide == 2) {
                    for($ii = 0 ; $ii < @$obj->data->answer ; $ii++) {
                        $html_string .= "<div style='margin-top: 5px;margin-right: 15px; border: 1px solid #FF8040;padding: 5px; width: 200px;float: left;'  >";
                        for($iii = 0 ; $iii < @$obj->data->number2 ; $iii++) {
                            $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='25' style='margin-left: 5px; display: inline;' />";
                        }
                        $html_string .= "</div>";
                    }
                } else {
                    for($ii = 0 ; $ii < @$obj->data->number2 ; $ii++) {
                        $html_string .= "<div style='margin-top: 5px;margin-right: 15px; border: 1px solid #FF8040;padding: 5px; width: 200px;float: left;'  >";
                        for($iii = 0 ; $iii < @$obj->data->answer ; $iii++) {
                            $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='25' style='margin-left: 5px; display: inline;' />";
                        }
                        $html_string .= "</div>";
                    }
                }
            } else {
                for($ii = 0 ; $ii < @$obj->data->number1 ; $ii++) {
                    $html_string .= "<div style='margin-top: 5px;margin-right: 15px; border: 1px solid #FF8040;padding: 5px; width: 200px;float: left;'  >";
                    for($iii = 0 ; $iii < @$obj->data->number2 ; $iii++) {
                        $html_string .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='25' style='margin-left: 5px; display: inline;' />";
                    }
                    $html_string .= "</div>";
                }
            }

            $html_string .= "<br style='clear: both;' /><br />";

            $html_string .= ws_develop_question($obj);
        }
        return $html_string;
    }

    //! Template id 48 Division Question
    function ws_template_48($obj) {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= "<table cellpadding='2'>";


            $html_string .= "<tr><td width='50' >&nbsp;</td>";
            if($obj->data->quotient == "::blank::") {
                $html_string .= "<td width='150' align='center' valign='middle' ><div style='border: 1px solid #FF6633; border-radius: 5px; width:30px; height: 25px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>";
            } else {
                $html_string .= "<td width='150' align='center' valign='middle' >".$obj->data->quotient."</td>";
            }

            $html_string .= "</tr>";
            $html_string .= "<tr>";
            if($obj->data->divisor == "::blank::") {
                $html_string .= "<td width='50' align='center' valign='middle' style='border-bottom: 1px solid #000000;border-right: 1px solid #000000;' ><div style='border: 1px solid #FF6633; border-radius: 5px; width:30px; height: 25px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>";
            } else {
                $html_string .= "<td width='50' align='center' valign='middle' style='border-bottom: 1px solid #000000;border-right: 1px solid #000000;' >".$obj->data->divisor."</td>";
            }

            if($obj->data->dividend == "::blank::") {
                $html_string .= "<td width='150' align='center' valign='middle' style='border-top: 1px solid #000000;' ><div style='border: 1px solid #FF6633; border-radius: 5px; width:30px; height: 25px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>";
            } else {
                $html_string .= "<td width='150' align='center' valign='middle' style='border-top: 1px solid #000000;' >".$obj->data->dividend."</td>";
            }
            $html_string .= "</tr>
            <tr><td colspan='2'>&nbsp;</td></tr>";
            $html_string .= "<tr><td width='50' >&nbsp;</td>";

            if($obj->data->remainder == "::blank::" && $obj->data->remainder != "0") {
                $html_string .= "<td width='150' align='center' valign='middle' style='border-top: 1px solid #000000;' ><div style='border: 1px solid #FF6633; border-radius: 5px; width:30px; height: 25px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>";
            } else {
                $html_string .= "<td width='150' align='center' valign='middle' style='border-top: 1px solid #000000;' >".$obj->data->remainder."</td>";
            }

            $html_string .= "</tr></table><br /><br />";

            $html_string .= ws_develop_question($obj);
            $html_string .= ws_develop_mcq_or_textbox_image($obj);

        }
        return $html_string;
    }

    //! Template id 49 Question - Relative facts - side by side
    function ws_template_49($obj,$operator = "+") {

        $html_string = '';

        if(isset($obj->data)) {

            $html_string .= ws_develop_question($obj);

            if(@$obj->data->number1 != "::blank::") {
                $html_string .= @$obj->data->number1."&nbsp;&nbsp;".$operator."&nbsp;&nbsp;";
            } else {
                $html_string .= "<div style='padding:5px; border: 1px solid #FF6633; display: inline; border-radius: 15px; width:100px;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>&nbsp;&nbsp;".$operator."&nbsp;&nbsp;";
            }

            if(@$obj->data->number2 != "::blank::") {
                $html_string .= @$obj->data->number2."&nbsp;&nbsp;=&nbsp;&nbsp;";
            } else {
                $html_string .= "<div style='padding:5px; border: 1px solid #FF6633; display: inline; border-radius: 15px; width:100px;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>&nbsp;&nbsp;=&nbsp;&nbsp;";
            }

            if(@$obj->data->number1_related != "::blank::") {
                $html_string .= @$obj->data->number1_related."&nbsp;&nbsp;".$operator."&nbsp;&nbsp;";
            } else {
                $html_string .= "<div style='padding:5px; border: 1px solid #FF6633; display: inline; border-radius: 15px; width:100px;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>&nbsp;&nbsp;".$operator."&nbsp;&nbsp;";
            }

            if(@$obj->data->number2_related != "::blank::") {
                $html_string .= @$obj->data->number2_related;
            } else {
                $html_string .= "<div style='padding:5px; border: 1px solid #FF6633; display: inline; border-radius: 15px; width:100px;' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>";
            }

            $html_string .= "<br /><br />";

        }
        return $html_string;
    }

    //! Template id 50 Fill in the blank with image set in between
    function ws_template_50($obj) {

        $html_string = '';

        if(isset($obj->data)) {

            //$html_string .= ws_develop_question($obj);
            $temp_string = ws_develop_question($obj);


            $image_set_1 = "<span>";
            for($ii = 0 ; $ii < $obj->data->number1 ; $ii++ ) {
                $image_set_1 .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='25' style='display:inline; margin-left: 3px;' />";
            }
            $image_set_1 .= "</span>";

            $image_set_2 = "<span>";
            for($ii = 0 ; $ii < $obj->data->number2 ; $ii++ ) {
                $image_set_2 .= "<img src='".base_url("mathimages/" . @$obj->data->image)."' width='25' style='display:inline; margin-left: 3px;' />";
            }
            $image_set_2 .= "</span>";

            $temp_string = str_replace("::images_set_1::",$image_set_1,$temp_string);
            $temp_string = str_replace("::images_set_2::",$image_set_2,$temp_string);

            $html_string .= $temp_string ;

            $html_string .= ws_develop_mcq_or_textbox_image($obj);

        }

        return $html_string;
    }
?>