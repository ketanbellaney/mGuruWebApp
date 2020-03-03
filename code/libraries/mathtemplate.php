<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    /*
	Class name  : Mathtemplate
	Description : Generates the data / question for the maths problem
	*/
    class Mathtemplate {

        /*
	    Function name   : __construct()
    	Parameter       : none
    	Return          : none
    	Description     : Constructor  Called as soon as the class instance is created
    	*/
        function __construct() {
            $this->ci =& get_instance();
        }


        /*
    	Function name   : get_addition_of_two_numbers()
    	Parameter       : sum_less_than - int - Sum should be less than a specific value - default value is 10
                          mcq - boolean - Multiple choice options required ture / false - default is false
                          allow_zero - boolean - To alow zero in the addition ture / false - default is true
    	Return          : array ( first random number , second random number , sum of the 2 random number, array of mcq options )
    	Description     : Gets the problem set data for addition of 2 numbers less than a specific value
    	*/
        function get_addition_of_two_numbers($sum_less_than = 10, $mcq = false, $allow_zero = true) {

            //! Check for allow 0
            if($allow_zero) {
                //! generate first random number
                $random_number_1 = rand(0,$sum_less_than);
                //! generate second random number
                $random_number_2 = rand(0,$sum_less_than - $random_number_1);
            } else {
                //! generate first random number
                $random_number_1 = rand(1,$sum_less_than);
                //! generate second random number
                $random_number_2 = rand(1,$sum_less_than - $random_number_1);
            }
            //! MCQ options
            if($mcq) {
                $mcq_option = array($random_number_1 + $random_number_2);
                if($allow_zero) {
                    $array = range(0,$sum_less_than);
                } else {
                    $array = range(1,$sum_less_than);
                }
                shuffle($array); // shuffle data
                foreach($array as $val) {
                    if(!in_array($val,$mcq_option) && count($mcq_option) < 4) {
                        $mcq_option[] = $val;
                    }
                }
                shuffle($mcq_option);

                //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
                return array( "number1" => $random_number_1 , "number2" => $random_number_2 , "answer" => ($random_number_1 + $random_number_2), "mcq" => $mcq_option );
            } else {
                //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
                return array( "number1" => $random_number_1 , "number2" => $random_number_2 , "answer" => ($random_number_1 + $random_number_2) );
            }
        }

        /*
    	Function name   : get_addition_of_two_numbers_with_images()
    	Parameter       : sum_less_than - int - Sum should be less than a specific value - default value is 10
                          mcq - boolean - Multiple choice options required ture / false - default is false
    	Return          : array ( first random number , second random number , sum of the 2 random number, array of mcq options , string of file name , title, complete url   )
    	Description     : Gets the proble set data for addition of 2 numbers less than a specific value
    	*/
        function get_addition_of_two_numbers_with_images($sum_less_than = 10, $mcq = false) {

            //! Gets the problem set data for addition of 2 numbers less than a specific value
            $result = $this->get_addition_of_two_numbers($sum_less_than, $mcq, false);

            //! Array of images
            $images = array("apple",'ball','bike','book','car','diya','mango','pencil','plate','samosa');

            $random_index = rand(0,count($images));

            $result['image'] =  @$images[$random_index] . ".png";
            $result['image_title'] =  ucwords(@$images[$random_index]);
            $result['image_url'] =  base_url("images/stock/" . @$images[$random_index] . ".png");

            //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
            return $result;
        }

        /*
    	Function name   : get_addition_sentence_of_two_numbers
    	Parameter       : sum_less_than - int - Sum should be less than a specific value - default value is 10
                          mcq - boolean - Multiple choice options required ture / false - default is false
                          allow_zero - boolean - To alow zero in the addition ture / false - default is true
    	Return          : array ( first random number , second random number , sum of the 2 random number, array of mcq options , string of file name , title, complete url   )
    	Description     : Gets the proble set data for addition of 2 numbers less than a specific value
    	*/
        function get_addition_sentence_of_two_numbers($sum_less_than = 10, $mcq = false, $allow_zero = true) {

            //! Gets the problem set data for addition of 2 numbers less than a specific value
            $result = $this->get_addition_of_two_numbers($sum_less_than, false,$allow_zero);

            if($mcq) {
                $random_number_1 = $result['number1'];
                $random_number_2 = $result['number2'];
                $mcq_option = array();
                $mcq_option[] = array($random_number_1,$random_number_2);
                while( in_array( ($rand1 = rand(1,$sum_less_than)), array($random_number_1) ) );
                while( in_array( ($rand2 = rand(1,$sum_less_than)), array($random_number_1) ) );
                while( in_array( ($rand3 = rand(1,$sum_less_than)), array($random_number_2) ) );
                while( in_array( ($rand4 = rand(1,$sum_less_than)), array($random_number_2) ) );
                $mcq_option[] = array($rand1,$rand3);
                $mcq_option[] = array($rand2,$random_number_2);
                $mcq_option[] = array($random_number_1,$rand4);

                shuffle($mcq_option);
                $result['mcq'] =  @$mcq_option;
            }

            //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
            return $result;
        }

        /*
    	Function name   : get_addition_sentence_of_two_numbers_with_images
    	Parameter       : sum_less_than - int - Sum should be less than a specific value - default value is 10
                          mcq - boolean - Multiple choice options required ture / false - default is false
    	Return          : array ( first random number , second random number , sum of the 2 random number, array of mcq options , string of file name , title, complete url   )
    	Description     : Gets the proble set data for addition of 2 numbers less than a specific value
    	*/
        function get_addition_sentence_of_two_numbers_with_images($sum_less_than = 10, $mcq = false) {

            //! Gets the problem set data for addition of 2 numbers less than a specific value
            $result = $this->get_addition_sentence_of_two_numbers($sum_less_than, $mcq,false);

            //! Array of images
            $images = array("apple",'ball','bike','book','car','diya','mango','pencil','plate','samosa');

            $random_index1 = rand(0,count($images));

            $result['image1'] =  @$images[$random_index1] . ".png";
            $result['image_title1'] =  ucwords(@$images[$random_index1]);
            $result['image_url1'] =  base_url("images/stock/" . @$images[$random_index1] . ".png");

            if($random_index1 > ( count( $images ) / 2 ) ) {
                $random_index2 = rand(0,$random_index1 - 1);
            } else {
                $random_index2 = rand($random_index1 + 1 ,count($images));
            }

            $result['image2'] =  @$images[$random_index2] . ".png";
            $result['image_title2'] =  ucwords(@$images[$random_index2]);
            $result['image_url2'] =  base_url("images/stock/" . @$images[$random_index2] . ".png");

            //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
            return $result;
        }

        /*
    	Function name   : get_addition_sentence_of_two_numbers_not_a_way_to_make_answer
    	Parameter       : num_less_than - int - Number should be less than a specific value - default value is 10
                          mcq - boolean - Multiple choice options required ture / false - default is false
                          allow_zero - boolean - To alow zero in the addition ture / false - default is true
    	Return          : array ( first random number , second random number , sum of the 2 random number, array of mcq options , string of file name , title, complete url   )
    	Description     : Gets the proble set data for addition of 2 numbers less than a specific value
    	*/
        function get_addition_sentence_of_two_numbers_not_a_way_to_make_answer($num_less_than = 10, $mcq = false, $allow_zero = true) {

            //! Gets the problem set data for addition of 2 numbers less than a specific value
            $result = $this->get_addition_of_two_numbers($sum_less_than, false,$allow_zero);

            if($mcq) {
                $random_number_1 = $result['number1'];
                $random_number_2 = $result['number2'];
                $mcq_option = array();
                while( in_array( ($rand = rand(-3,3)), array(0) ) );
                while( in_array( ($rand1 = rand(-3,3)), array(0,$rand) ) );
                while( in_array( ($rand2 = rand(-3,3)), array(0) ) );

                $mcq_option[] = array($random_number_1,$random_number_2);
                $mcq_option[] = array($random_number_1+$rand,$random_number_2-$rand);
                $mcq_option[] = array($random_number_1-$rand1,$random_number_2+$rand1);

                $mcq_option[] = array($random_number_1+$rand2,$random_number_2);

                shuffle($mcq_option);
                $result['mcq'] =  @$mcq_option;
                $result['answer'] =  ($random_number_1+$rand2 + $random_number_2);
            }

            //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
            return $result;
        }

        /*
    	Function name   : get_addition_sentence_of_two_numbers_way_to_make_answer
    	Parameter       : num_less_than - int - Number should be less than a specific value - default value is 10
                          mcq - boolean - Multiple choice options required ture / false - default is false
                          allow_zero - boolean - To alow zero in the addition ture / false - default is true
    	Return          : array ( first random number , second random number , sum of the 2 random number, array of mcq options , string of file name , title, complete url   )
    	Description     : Gets the proble set data for addition of 2 numbers less than a specific value
    	*/
        function get_addition_sentence_of_two_numbers_way_to_make_answer($num_less_than = 10, $mcq = false, $allow_zero = true) {

            //! Gets the problem set data for addition of 2 numbers less than a specific value
            $result = $this->get_addition_of_two_numbers($num_less_than, false,$allow_zero);

            if($mcq) {
                $random_number_1 = $result['number1'];
                $random_number_2 = $result['number2'];
                $mcq_option = array();
                while( in_array( ($rand = rand(-3,3)), array(0) ) );
                while( in_array( ($rand1 = rand(-3,3)), array(0,$rand) ) );
                while( in_array( ($rand2 = rand(-3,3)), array(0) ) );

                $mcq_option[] = array($random_number_1,$random_number_2);
                $mcq_option[] = array($random_number_1+$rand,$random_number_2-$rand);
                $mcq_option[] = array($random_number_1-$rand1,$random_number_2+$rand1);

                $mcq_option[] = array($random_number_1+$rand2,$random_number_2);

                shuffle($mcq_option);
                $result['mcq'] =  @$mcq_option;
                $result['answer'] =  ($random_number_1+$random_number_2);
            }

            //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
            return $result;
        }

        /*
    	Function name   : get_addition_sentence_of_two_numbers_way_to_make_answer
    	Parameter       : sum_less_than - int - Sum should be less than a specific value - default value is 10
                          shuffle - boolean - shuffle the options ture / false - default is false
    	Return          : array ( first random number , second random number , sum of the 2 random number, array of mcq options , string of file name , title, complete url   )
    	Description     : Gets the proble set data for addition of 2 numbers less than a specific value
    	*/
        function get_addition_of_two_numbers_with_patern($sum_less_than = 10, $shuffle = false) {

            //! generate random number
            if(!$shuffle) {
                $random_number = rand(5,$sum_less_than);
                $random_number1 = rand(0,$random_number - 1);
            } else {
                $random_number = rand(2,$sum_less_than);
                $random_number1 = $random_number - 1;
            }

            //! Patterns options
            $pattern_num = $random_number;
            $other_num = 0;
            $mcq_option = array();
            $answer = '';
            while ( $pattern_num >= 0 ) {
                if($other_num == $random_number1 ) {
                    if(!$shuffle) {
                        $mcq_option[] = "::blank::";
                    }
                    $answer = "$other_num + $pattern_num = $random_number";
                } else {
                    $mcq_option[] = "$other_num + $pattern_num = $random_number";
                }
                $other_num++;
                $pattern_num--;
            }

            if($shuffle) {
                shuffle($mcq_option);
            }

            $result = array("number" => $random_number, "options" => $mcq_option, "answer" => $answer);

            //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
            return $result;
        }

        /*
    	Function name   : get_addition_of_two_numbers_doubles()
    	Parameter       : sum_less_than - int - Sum should be less than a specific value - default value is 10
                          mcq - boolean - Multiple choice options required ture / false - default is false
    	Return          : array ( first random number , second random number , sum of the 2 random number, array of mcq options )
    	Description     : Gets the problem set data for addition of 2 numbers less than a specific value
    	*/
        function get_addition_of_two_numbers_doubles($sum_less_than = 10, $mcq = false) {

            //! generate first random number
            $random_number_1 = rand(0, (int)( $sum_less_than / 2));
            $random_number_2 = $random_number_1;

            //! MCQ options
            if($mcq) {
                $mcq_option = array($random_number_1 + $random_number_2);
                $array = range(0,$sum_less_than);

                shuffle($array); // shuffle data
                foreach($array as $val) {
                    if(!in_array($val,$mcq_option) && count($mcq_option) < 4) {
                        $mcq_option[] = $val;
                    }
                }
                shuffle($mcq_option);

                //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
                return array( "number1" => $random_number_1 , "number2" => $random_number_2 , "answer" => ($random_number_1 + $random_number_2), "mcq" => $mcq_option );
            } else {
                //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
                return array( "number1" => $random_number_1 , "number2" => $random_number_2 , "answer" => ($random_number_1 + $random_number_2) );
            }
        }

        /*
    	Function name   : get_addition_of_two_numbers_with_one_default_number()
    	Parameter       : sum_less_than - int - Sum should be less than a specific value - default value is 10
                          mcq - boolean - Multiple choice options required ture / false - default is false
                          allow_zero - boolean - To alow zero in the addition ture / false - default is true
                          default_value - INT - second number can be default which can be specified - default is 0
    	Return          : array ( first random number , second random number , sum of the 2 random number, array of mcq options )
    	Description     : Gets the problem set data for addition of 2 numbers less than a specific value
    	*/
        function get_addition_of_two_numbers_with_one_default_number($sum_less_than = 10, $mcq = false, $allow_zero = true,$default_value = 0) {

            //! Check for allow 0
            if($allow_zero) {
                //! generate first random number
                $random_number_1 = rand(0,$sum_less_than);
                $random_number_2 = $default_value;
            } else {
                //! generate first random number
                $random_number_1 = rand(1,$sum_less_than);
                $random_number_2 = $default_value;
            }
            //! MCQ options
            if($mcq) {
                $mcq_option = array($random_number_1 + $random_number_2);
                if($allow_zero) {
                    $array = range(0,$sum_less_than);
                } else {
                    $array = range(1,$sum_less_than);
                }
                shuffle($array); // shuffle data
                foreach($array as $val) {
                    if(!in_array($val,$mcq_option) && count($mcq_option) < 4) {
                        $mcq_option[] = $val;
                    }
                }
                shuffle($mcq_option);

                //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
                return array( "number1" => $random_number_1 , "number2" => $random_number_2 , "answer" => ($random_number_1 + $random_number_2), "mcq" => $mcq_option );
            } else {
                //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
                return array( "number1" => $random_number_1 , "number2" => $random_number_2 , "answer" => ($random_number_1 + $random_number_2) );
            }
        }

        /*
    	Function name   : get_addition_of_three_numbers()
    	Parameter       : sum_less_than - int - Sum should be less than a specific value - default value is 10
                          mcq - boolean - Multiple choice options required ture / false - default is false
                          allow_zero - boolean - To alow zero in the addition ture / false - default is true
    	Return          : array ( first random number , second random number , sum of the 2 random number, array of mcq options )
    	Description     : Gets the problem set data for addition of 2 numbers less than a specific value
    	*/
        function get_addition_of_three_numbers($sum_less_than = 10, $mcq = false, $allow_zero = true) {

            //! Check for allow 0
            if($allow_zero) {
                //! generate first random number
                $random_number_1 = rand(0,$sum_less_than);
                //! generate second random number
                $random_number_2 = rand(0,$sum_less_than - $random_number_1);
                //! generate third random number
                $random_number_3 = rand(0,$sum_less_than - $random_number_1 - $random_number_2);
            } else {
                //! generate first random number
                $random_number_1 = rand(1,$sum_less_than);
                //! generate second random number
                $random_number_2 = rand(1,$sum_less_than - $random_number_1);
                //! generate third random number
                $random_number_3 = rand(1,$sum_less_than - $random_number_1 - $random_number_2);
            }
            //! MCQ options
            if($mcq) {
                $mcq_option = array($random_number_1 + $random_number_2 + $random_number_3);
                if($allow_zero) {
                    $array = range(0,$sum_less_than);
                } else {
                    $array = range(1,$sum_less_than);
                }
                shuffle($array); // shuffle data
                foreach($array as $val) {
                    if(!in_array($val,$mcq_option) && count($mcq_option) < 4) {
                        $mcq_option[] = $val;
                    }
                }
                shuffle($mcq_option);

                //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
                return array( "number1" => $random_number_1 , "number2" => $random_number_2 , "number3" => $random_number_3 , "answer" => ($random_number_1 + $random_number_2 + $random_number_3), "mcq" => $mcq_option );
            } else {
                //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
                return array( "number1" => $random_number_1 , "number2" => $random_number_2 , "number3" => $random_number_3 , "answer" => ($random_number_1 + $random_number_2 + $random_number_3) );
            }
        }

        /*
    	Function name   : get_addition_sentence_of_two_numbers_way_to_make_answer
    	Parameter       : sum_less_than - int - Sum should be less than a specific value - default value is 10
                          mcq - boolean - Multiple choice options required ture / false - default is false
    	Return          : array ( first random number , second random number , sum of the 2 random number, array of mcq options , string of file name , title, complete url   )
    	Description     : Gets the proble set data for addition of 2 numbers less than a specific value
    	*/
        function get_addition_of_two_numbers_with_related_facts($sum_less_than = 10, $mcq = false) {

            //! generate random number
            $random_number1 = rand(0,$sum_less_than);
            while( in_array( ($random_number2 = rand(0,$sum_less_than - $random_number1)), array($random_number1) ) );

            //! Patterns options
            $answer = "$random_number2 + $random_number1 = " . ($random_number2 + $random_number1);

            if($mcq) {
                $mcq_option = array("$random_number2 + $random_number1 = " . ($random_number2 + $random_number1));
                $mcq_option1 = array("$random_number2 + $random_number1");
                $mcq_option1[] = "$random_number1 + $random_number2";

                do {
                    while( in_array( ($rand = rand(0,$sum_less_than) . " + " . rand(0,$sum_less_than)), $mcq_option1 ) );
                    eval('$ans = ' . $rand . ";");
                } while ($ans > $sum_less_than);
                $mcq_option1[] = $rand;
                $mcq_option[] = $rand . " = " . $ans;

                do {
                    while( in_array( ($rand1 = rand(0,$sum_less_than) . " + " . rand(0,$sum_less_than)), $mcq_option1 ) );
                    eval('$ans = ' . $rand1 . ";");
                } while ($ans > $sum_less_than);
                $mcq_option1[] = $rand1;
                $mcq_option[] = $rand1 . " = " . $ans;

                do {
                    while( in_array( ($rand2 = rand(0,$sum_less_than) . " + " . rand(0,$sum_less_than)), $mcq_option1 ) );
                    eval('$ans = ' . $rand2 . ";");
                } while ($ans > $sum_less_than);
                $mcq_option1[] = $rand2;
                $mcq_option[] = $rand2 . " = " . $ans;

                shuffle($mcq_option);

                $result = array("number1" => $random_number1, "number2" => $random_number2, "mcq" => $mcq_option, "answer" => $answer);
            } else {
                $result = array("number1" => $random_number1, "number2" => $random_number2, "answer" => $answer);
            }

            //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
            return $result;
        }

        /*
    	Function name   : get_addition_of_doubles_plus_one_fill_the_blank()
    	Parameter       : sum_less_than - int - Sum should be less than a specific value - default value is 10
                          allow_zero - boolean - To alow zero in the addition ture / false - default is true
    	Return          : array ( first random number , second random number , sum of the 2 random number, array of mcq options )
    	Description     : Gets the problem set data for addition of 2 numbers less than a specific value
    	*/
        function get_addition_of_doubles_plus_one_fill_the_blank($sum_less_than = 10, $allow_zero = true) {

            //! Check for allow 0
            if($allow_zero) {
                //! generate first random number
                $random_number_1 = rand(0,(int)($sum_less_than- 1 / 2));
                //! generate second random number
                $random_number_2 = $random_number_1;
                //! generate third random number
                $random_number_3 = rand(0,$sum_less_than - $random_number_1 - $random_number_2);

                $random_number_4 = 1;
                $random_number_5 = $random_number_1 + $random_number_2 + $random_number_3 - $random_number_4;
            } else {
                //! generate first random number
                $random_number_1 = rand(1,(int)($sum_less_than- 1 / 2));
                //! generate second random number
                $random_number_2 = $random_number_1;
                //! generate third random number
                $random_number_3 = rand(1,$sum_less_than - $random_number_1 - $random_number_2);

                $random_number_4 = 1;
                $random_number_5 = $random_number_1 + $random_number_2 + $random_number_3 - $random_number_4;
            }

            //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
            return array( "number1" => $random_number_1 , "number2" => $random_number_2 , "number3" => $random_number_3 , "number4" => $random_number_4 , "number5" => $random_number_5 , "answer" => ($random_number_1 + $random_number_2 + $random_number_3) );
        }

        /*
    	Function name   : get_addition_of_doubles_minus_one_fill_the_blank()
    	Parameter       : sum_less_than - int - Sum should be less than a specific value - default value is 10
                          allow_zero - boolean - To alow zero in the addition ture / false - default is true
    	Return          : array ( first random number , second random number , sum of the 2 random number, array of mcq options )
    	Description     : Gets the problem set data for addition of 2 numbers less than a specific value
    	*/
        function get_addition_of_doubles_minus_one_fill_the_blank($sum_less_than = 10, $allow_zero = true) {

            //! Check for allow 0
            if($allow_zero) {
                //! generate first random number
                $random_number_1 = rand(0,(int)( ($sum_less_than) / 2));
                //! generate second random number
                $random_number_2 = $random_number_1;
                //! generate third random number
                while( in_array( ($random_number_3 = rand(-1,1)), array(0) ) );

                if($random_number_3 < 0) {
                    while( in_array( ($random_number_5 = rand(-1,1)), array(0) ) );
                } else {
                    $random_number_5 = -1;
                }
                $random_number_4 = $random_number_1 + $random_number_2 + $random_number_3 - $random_number_5;
            } else {
                //! generate first random number
                $random_number_1 = rand(1,(int)( ($sum_less_than- 1) / 2));
                //! generate second random number
                $random_number_2 = $random_number_1;
                //! generate third random number
                while( in_array( ($random_number_3 = rand(-1,1)), array(0) ) );

                if($random_number_3 < 0) {
                    while( in_array( ($random_number_5 = rand(-1,1)), array(0) ) );
                } else {
                    $random_number_5 = -1;
                }
                $random_number_4 = $random_number_1 + $random_number_2 + $random_number_3 - $random_number_5;
            }

            //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
            return array( "number1" => $random_number_1 , "number2" => $random_number_2 , "number3" => $random_number_3 , "number4" => $random_number_4 , "number5" => $random_number_5 , "answer" => ($random_number_1 + $random_number_2 + $random_number_3) );
        }

        /*
    	Function name   : get_addition_of_three_numbers_and_two_numbers_fill_the_blank()
    	Parameter       : sum_less_than - int - Sum should be less than a specific value - default value is 10
                          allow_zero - boolean - To alow zero in the addition ture / false - default is true
    	Return          : array ( first random number , second random number , sum of the 2 random number, array of mcq options )
    	Description     : Gets the problem set data for addition of 2 numbers less than a specific value
    	*/
        function get_addition_of_three_numbers_and_two_numbers_fill_the_blank($sum_less_than = 10, $allow_zero = true) {

            //! Check for allow 0
            if($allow_zero) {
                //! generate first random number
                $random_number_1 = rand(0,$sum_less_than);
                //! generate second random number
                $random_number_2 = rand(0,$sum_less_than - $random_number_1);
                //! generate third random number
                $random_number_3 = rand(0,$sum_less_than - $random_number_1 - $random_number_2);

                $random_number_4 = rand(0,$random_number_1 + $random_number_2 + $random_number_3);
                $random_number_5 = $random_number_1 + $random_number_2 + $random_number_3 - $random_number_4;
            } else {
                //! generate first random number
                $random_number_1 = rand(1,$sum_less_than);
                //! generate second random number
                $random_number_2 = rand(1,$sum_less_than - $random_number_1);
                //! generate third random number
                $random_number_3 = rand(1,$sum_less_than - $random_number_1 - $random_number_2);

                $random_number_4 = rand(1,$random_number_1 + $random_number_2 + $random_number_3);
                $random_number_5 = $random_number_1 + $random_number_2 + $random_number_3 - $random_number_4;
            }

            //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
            return array( "number1" => $random_number_1 , "number2" => $random_number_2 , "number3" => $random_number_3 , "number4" => $random_number_4 , "number5" => $random_number_5 , "answer" => ($random_number_1 + $random_number_2 + $random_number_3) );
        }

        /*
    	Function name   : get_addition_of_2_digit_and_1_digit_without_regrouping()
    	Parameter       : sum_less_than - int - Sum should be less than a specific value - default value is 10
                          mcq - boolean - Multiple choice options required ture / false - default is false
    	Return          : array ( first random number , second random number , sum of the 2 random number, array of mcq options )
    	Description     : Gets the problem set data for addition of 2 numbers less than a specific value
    	*/
        function get_addition_of_2_digit_and_1_digit_without_regrouping($sum_less_than = 20, $mcq = false) {

            //! generate first random number
            $random_number_1 = rand(10,$sum_less_than - 1);
            $random_number_1_mod = $random_number_1 % 10;
            $random_number_2 = rand(0, 9 - $random_number_1_mod);

            if($mcq) {
                $mcq_option = array($random_number_1 + $random_number_2);
                $array = range(0,9);
                shuffle($array); // shuffle data
                foreach($array as $val) {
                    if(!in_array($val,$mcq_option) && count($mcq_option) < 4) {
                        $mcq_option[] = $val;
                    }
                }
                shuffle($mcq_option);

                //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
                return array( "number1" => $random_number_1 , "number2" => $random_number_2 , "answer" => ($random_number_1 + $random_number_2), "mcq" => $mcq_option );
            } else {
                //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
                return array( "number1" => $random_number_1 , "number2" => $random_number_2 , "answer" => ($random_number_1 + $random_number_2) );
            }
        }

        /*
    	Function name   : get_addition_of_2_digit_and_1_digit_with_regrouping()
    	Parameter       : first_num_less_than - int - First number should be less than a specific value - default value is 10
                          mcq - boolean - Multiple choice options required ture / false - default is false
    	Return          : array ( first random number , second random number , sum of the 2 random number, array of mcq options )
    	Description     : Gets the problem set data for addition of 2 numbers less than a specific value
    	*/
        function get_addition_of_2_digit_and_1_digit_with_regrouping($first_num_less_than = 20, $mcq = false) {

            //! generate first random number
            $random_number_1 = rand(10,$first_num_less_than - 1);
            $random_number_1_mod = $random_number_1 % 10;
            $random_number_2 = rand(10-$random_number_1_mod, 9);

            if($mcq) {
                $mcq_option = array($random_number_1 + $random_number_2);
                $array = range(0,9);
                shuffle($array); // shuffle data
                foreach($array as $val) {
                    if(!in_array($val,$mcq_option) && count($mcq_option) < 4) {
                        $mcq_option[] = $val;
                    }
                }
                shuffle($mcq_option);

                //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
                return array( "number1" => $random_number_1 , "number2" => $random_number_2 , "answer" => ($random_number_1 + $random_number_2), "mcq" => $mcq_option );
            } else {
                //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
                return array( "number1" => $random_number_1 , "number2" => $random_number_2 , "answer" => ($random_number_1 + $random_number_2) );
            }
        }

        /*
    	Function name   : get_addition_of_two_numbers_with_string()
    	Parameter       : sum_less_than - int - Sum should be less than a specific value - default value is 10
                          mcq - boolean - Multiple choice options required ture / false - default is false
                          allow_zero - boolean - To alow zero in the addition ture / false - default is true
    	Return          : array ( first random number , second random number , sum of the 2 random number, array of mcq options )
    	Description     : Gets the problem set data for addition of 2 numbers less than a specific value
    	*/
        function get_addition_of_two_numbers_with_string($sum_less_than = 10, $mcq = false, $allow_zero = true) {

            //! Check for allow 0
            if($allow_zero) {
                //! generate first random number
                $random_number_1 = rand(0,$sum_less_than);
                //! generate second random number
                $random_number_2 = rand(0,$sum_less_than - $random_number_1);
            } else {
                //! generate first random number
                $random_number_1 = rand(1,$sum_less_than);
                //! generate second random number
                $random_number_2 = rand(1,$sum_less_than - $random_number_1);
            }

            // Convert int to string
            $random_number_1_string = convert_int_to_string($random_number_1);
            $random_number_2_string = convert_int_to_string($random_number_2);
            $answer_string = convert_int_to_string($random_number_1 + $random_number_2);

            //! MCQ options
            if($mcq) {
                $mcq_option = array($random_number_1 + $random_number_2);
                $mcq_option_string = array();
                if($allow_zero) {
                    $array = range(0,$sum_less_than);
                } else {
                    $array = range(1,$sum_less_than);
                }
                shuffle($array); // shuffle data
                foreach($array as $val) {
                    if(!in_array($val,$mcq_option) && count($mcq_option) < 4) {
                        $mcq_option[] = $val;
                    }
                }
                shuffle($mcq_option);

                foreach($mcq_option as $val) {
                    $mcq_option_string[] = convert_int_to_string($val);
                }

                //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
                return array( "number1" => $random_number_1 , "number1_string" => $random_number_1_string , "number2" => $random_number_2 , "number2_string" => $random_number_2_string , "answer" => ($random_number_1 + $random_number_2), "answer_string" => $answer_string , "mcq" => $mcq_option, 'mcq_string' => $mcq_option_string );
            } else {
                //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
                return array( "number1" => $random_number_1 , "number1_string" => $random_number_1_string , "number2" => $random_number_2 , "number2_string" => $random_number_2_string , "answer" => ($random_number_1 + $random_number_2), "answer_string" => $answer_string  );
            }
        }

        /*
    	Function name   : get_addition_of_two_numbers_1_digit_each() 
    	Parameter       : mcq - boolean - Multiple choice options required ture / false - default is false
                          allow_zero - boolean - To alow zero in the addition ture / false - default is true
    	Return          : array ( first random number , second random number , sum of the 2 random number, array of mcq options )
    	Description     : Gets the problem set data for addition of 2 numbers less than a specific value
    	*/
        function get_addition_of_two_numbers_1_digit_each($mcq = false, $allow_zero = true) {

            //! Check for allow 0
            if($allow_zero) {
                //! generate first random number
                $random_number_1 = rand(0,9);
                //! generate second random number
                $random_number_2 = rand(0,9);
            } else {
                //! generate first random number
                $random_number_1 = rand(1,9);
                //! generate second random number
                $random_number_2 = rand(1,9);
            }
            //! MCQ options
            if($mcq) {
                $mcq_option = array($random_number_1 + $random_number_2);
                if($allow_zero) {
                    $array = range(0,9);
                } else {
                    $array = range(1,9);
                }
                shuffle($array); // shuffle data
                foreach($array as $val) {
                    if(!in_array($val,$mcq_option) && count($mcq_option) < 4) {
                        $mcq_option[] = $val;
                    }
                }
                shuffle($mcq_option);

                //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
                return array( "number1" => $random_number_1 , "number2" => $random_number_2 , "answer" => ($random_number_1 + $random_number_2), "mcq" => $mcq_option );
            } else {
                //! Return the array with first random number , second random number , sum of the 2 random number [] the answer
                return array( "number1" => $random_number_1 , "number2" => $random_number_2 , "answer" => ($random_number_1 + $random_number_2) );
            }
        }
    }
?>