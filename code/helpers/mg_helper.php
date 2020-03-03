<?php
    function get_email_template($email_id) {

        $email = array();

        $email[0]['subject'] = "Reset your mGuru account password";
        $email[0]['body'] = "<p>Dear ::name::</p>
<p>This message has been sent as you have indicated that you wish to reset your password. To do so please use the reset code given below.</p>
<p style='text-align:center;'><br /><b style='font-size:15px;'>::forgorpassword_code::</b><br /></p>
<p>If you have not requested for your password to be reset and believe this email to have been sent in error, please ignore this message.</p>
<p>With best wishes</p>
<p>mGuru team</p>
<p><a href='http://www.mguru.co.in' >mGuru</a></p>";

        $email[1]['subject'] = "Account activation from mGuru";
        $email[1]['body'] = "<p>Dear ::name::</p>
<p>Welcome to mGuru Worksheet Maker!</p>
<p>To activate your account, you'll need to verify your email address.</p>
<p>Verify by clicking on <a href='::activate_url::'>verify my account</a> or paste this url into your browser:</p>
<p style='text-align:center;'><br />::activate_url::<br /></p>
<p style='text-align:center;'><br /><b style='font-size:15px;'>Activation Code: ::code::</b><br /></p>
<p>With best wishes</p>
<p>mGuru team</p>
<p><a href='http://www.mguru.co.in' >mGuru</a></p>";

        $email[2]['subject'] = "::name:: invited you to check out mGuru Math Worksheet";
        $email[2]['body'] = "<p>Hi there,</p>
         <!--[if gte MSO 9]>
<table width='640'><tr><td>
<![endif]-->
<table width='100%' style='' ><tr><td><img src='".base_url("images/shareimage2.png")."' width='100%' /></td</tr></table>
<!--[if gte MSO 9]>
</td></tr></table>
<![endif]-->
<center>
<a style=\"border-radius:3px;font-size:15px;color:white;border:1px #0D8E64 solid;text-decoration:none;padding:14px 7px 14px 7px;width:280px;max-width:280px;font-family:proxima_nova,'Open Sans','lucida grande','Segoe UI',arial,verdana,'lucida sans unicode',tahoma,sans-serif;margin:6px auto;display:block;background-color:#11B781;text-align:center\" href='::refer_url::' target='_blank'>Accept invite</a>
</center>
<p>::name:: wants you to try the mGuru Worksheet Maker! You'll never have to write another worksheet again. It lets you make personalized worksheets for students in Standards 1-5 with problems for CBSE and State Boards. Make a worksheet in under 20 second!</p>
<p>Plus, you'll both get 5 worksheet credits for free if you get started through this email.</p>
<center>
<a style=\"border-radius:3px;font-size:15px;color:white;border:1px #1373b5 solid;text-decoration:none;padding:14px 7px 14px 7px;width:280px;max-width:280px;font-family:proxima_nova,'Open Sans','lucida grande','Segoe UI',arial,verdana,'lucida sans unicode',tahoma,sans-serif;margin:6px auto;display:block;background-color:#007ee6;text-align:center\" href='::refer_url::' target='_blank'>Start Now</a>
</center>
<p>Thanks</p>
<p>- mGuru team</p>
<p><a href='http://www.mgurumaths.com/worksheet' >mGuru worksheet</a></p>
<p><a href='http://www.mguru.co.in' >mGuru</a></p>";

        $email[3]['subject'] = "mGuru Payment Confirmation - ::order_number::";
        $email[3]['body'] = "
        <p>Hello ::name::,</p>
        <p>Thanks for your purchase. Your order has been successfully accepted by mGuru.</p>
        <table width='400' border='1'>
    <caption>Order Details</caption>
    <tr>
        <td width='150'>Order No:</td>
        <td width='250'>::order_number::</td>
    </tr>
    <tr>
        <td>Status:</td>
        <td>successful</td>
    </tr>
    <tr>
        <td>Purchase Date:</td>
        <td>::date::</td>
    </tr>
    <tr>
        <td>Amount:</td>
        <td>Rs. ::amount::</td>
    </tr>
</table>
<p>Thanks</p>
<p>- mGuru team</p>
<p><a href='http://www.mguru.co.in' >mGuru</a></p>";

        $email[4]['subject'] = "::name:: invited you to check out mGuru English";
        $email[4]['body'] = "<p>Hi there,</p>
        <!--[if gte MSO 9]>
<table width='640'><tr><td>
<![endif]-->
<table width='100%' style='' ><tr><td><img src='".base_url("images/englishshare.png")."' width='100%' /></td</tr></table>
<!--[if gte MSO 9]>
</td></tr></table>
<![endif]-->
<center>
<a style=\"border-radius:3px;font-size:15px;color:white;border:1px #0D8E64 solid;text-decoration:none;padding:14px 7px 14px 7px;width:280px;max-width:280px;font-family:proxima_nova,'Open Sans','lucida grande','Segoe UI',arial,verdana,'lucida sans unicode',tahoma,sans-serif;margin:6px auto;display:block;background-color:#11B781;text-align:center\" href='::refer_url::' target='_blank'>Accept invite</a>
</center>
<p>::name:: wants you to try the mGuru English! mGuru English is a fast and interactive way for children to learn English. Designed for kids aged 4 - 10, the app provides a range of activities, games, stories, and content that helps children gain the skills they need to read and speak English. With dozens of stories with learning activities from Pratham, a comprehensive early learners and phonics program, and textbook texts with audio and questions, mGuru English provides an interactive learning journey for students trying to learn English. Parents and teachers can monitor learning progress and results, but do not need to supervise the child. The app so easy to use that students can use it by themselves!</p>
<p>Instructions are available in English, Hindi, and Marathi. Internet only required for sign in and downloading new content.</p>
<p>Plus, you'll get 7 days Premium for free if you get started through this email.</p>
<center>
<a style=\"border-radius:3px;font-size:15px;color:white;border:1px #1373b5 solid;text-decoration:none;padding:14px 7px 14px 7px;width:280px;max-width:280px;font-family:proxima_nova,'Open Sans','lucida grande','Segoe UI',arial,verdana,'lucida sans unicode',tahoma,sans-serif;margin:6px auto;display:block;background-color:#007ee6;text-align:center\" href='::refer_url::' target='_blank'>Start Now!</a>
</center>
<p>Thanks</p>
<p>- mGuru team</p>
<p><a href='http://www.mguru.co.in' >mGuru</a></p>";

        $email[5]['subject'] = "Reset your mGuru account password";
        $email[5]['body'] = "<p>Dear ::name::</p>
<p>This message has been sent as you have indicated that you wish to reset your password. To do so please click on the button given below.</p>
<center>
<a style=\"border-radius:3px;font-size:15px;color:white;border:1px #1373b5 solid;text-decoration:none;padding:14px 7px 14px 7px;width:280px;max-width:280px;font-family:proxima_nova,'Open Sans','lucida grande','Segoe UI',arial,verdana,'lucida sans unicode',tahoma,sans-serif;margin:6px auto;display:block;background-color:#007ee6;text-align:center\" href='::reset_url::' target='_blank'>Reset Password</a>
</center>
<p>If you have not requested for your password to be reset and believe this email to have been sent in error, please ignore this message.</p>
<p>With best wishes</p>
<p>mGuru team</p>
<p><a href='http://www.mgurumaths.com/worksheet' >mGuru worksheet</a></p>
<p><a href='http://www.mguru.co.in' >mGuru</a></p>";


        return $email[$email_id];
    }

    function create_random_alphanumeric_string($num = 6) {
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $string = '';
        for ($i = 0; $i < $num; $i++) {
            $string .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $string;
    }

    function convert_int_to_string($num) {
        $_numbersUnder20 = array( 'zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen' );

        $_tensDigits = array( 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety' );

        $_orderOfMagnitude = array( 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion' );

        // 0 or no value in the lowest digits
        if($num == 0) {
            return 'zero';
        }

        // 1-19
        if($num < 20) {
            return $_numbersUnder20[$num];
        }

        // 20 - 99
        if($num < 100) {
            $highDigitValue = intval(floor($num / 10) - 2); // Value of the highest-order digit
            $remainingValue = $num % 10; // Value of the remaining digits
            return $_tensDigits[$highDigitValue] . ' ' . convert_int_to_string($remainingValue);
        }

        // 100 - 999
        if($num < 1000) {
            $highDigitValue = intval(floor($num / 100)); // Value of the highest-order digit
            $remainingValue = $num % 100; // Value of the remaining digits
            return convert_int_to_string($highDigitValue) . ' hundred ' . convert_int_to_string($remainingValue);
        }

        // 1,000+
        $quotient = $num;
        $divideCount = 0;
        while($quotient >= 1000) {
            $quotient /= 1000;
            ++$divideCount;
        }
        $highDigitValue = intval(floor($quotient)); // Value of the highest-order digit
        $remainingValue = $num - ($highDigitValue * pow(1000, $divideCount)); // Value of the remaining digits
        return convert_int_to_string($highDigitValue) . ' ' . $_orderOfMagnitude[$divideCount - 1] . ' ' . convert_int_to_string($remainingValue);
    }

    /*
  	Function name   : sendsms()
  	Parameter       : $number - int - Transactional SMS Number
                      $mobileno - string - Mobile number
                      $data - array - data for the sms ( transactional sms )
  	Return          : boolean - true for sms sent / false for sms not sent
  	Description     : gets all story details in json string
  	*/
    function sendsms($number = 1, $mobileno = 0, $data = '') {

        //! Transactional SMS Template
	    $template = array(
		    1 => "OTP ".@$data[0].". Please enter this OTP to get access to mGuru.",
		    2 => "Hello ".@$data[0]."! This is a message from mGuru. Please go to this link to download mGuru English: ".@$data[1].". Once you have downloaded the app, please sign up. ".@$data[2].".",
		    3 => "Download mGuru English app, the best way for children to read and speak English! From stories to phonics and learning games, the app has everything students needs to improve their English. Download and share the app here: " . @$data[0],
		    4 => "Download the mGuru English app! It's an amazing way for children ages 4-11 to learn English. Now compatible with more versions of Android! Download: " . @$data[0],
		    5 => "Hi ".@$data[0].", your payment of Rs.".@$data[1]." for mGuru Premium Order # ".@$data[2]." has been made successfully. Happy learning!",
		    6 => "Check out mGuru Math Worksheet! Never write another worksheet again. UNLIMITED problems in K-5 for curriculum across India. Find it at " .@$data[0],
		    7 => "Check out the latest stories, phonetics activities and more on mGuru English! Get 7 days free premium now by downloading it here: " .@$data[0],
		    8 => "Download mGuru English app, the best way for children to read and speak English! From stories to phonics and learning games, the app has everything students needs to improve their English. Download and share the app here: ".@$data[0]." or Search 'mGuru English' in Google Playstore.",
		    9 => "Hello ".@$data[0]."! Click on the link to reset your password: ".@$data[1].".",
		    10 => "Check out the brand new mGuru English! It has been completely redesigned, with new stories, rhymes, and games. Check it out now here (bit.ly/mgneric) or on the Google Play store. Search \"mGuru English.\"",
		    11 => @$data[0]." finished the \"".@$data[1]."\" ".@$data[2]." with a score of ".@$data[3]."%! Read the report card on mGuru English: ".@$data[4],
		    12 => @$data[0]." finished the ".@$data[1]."  and the story test, with a score of ".@$data[2]."%! Read the report card on mGuru English: ".@$data[3],
		    13 => @$data[0]." hasn't learned on mGuru English for ".@$data[1]." days! Reading and playing everyday = learning English faster. Give your child mGuru English to do the Daily Quest now! ".@$data[2],
		    14 => @$data[0]." mGuru English Weekly Report:
Total Percent and Marks: ".@$data[1]."% and ".@$data[2]."
Activities Completed: ".@$data[3]."
Stories Completed: ".@$data[4]."
Read the full report here: ".@$data[5],
            15 => "Hey there! Click here to download mGuru English " . @$data[0],
            16 => "Congrats! ".@$data[0]." has gone up ".@$data[1]." ranking places to ".@$data[2]." on mGuru English. Keep it up and keep learning :) http://bit.ly/mGuruConcept",
            17 => @$data[0]." has gone down ".@$data[1]." ranking places to ".@$data[2]." on mGuru English. Come back and catch up! http://bit.ly/mGuruConcept",
            18 => @$data[0]." is ranked ".@$data[1]." out of ".@$data[2]." in the country for mGuru English! That is the ".@$data[3]." percentile. Check out your rankings here http://bit.ly/mGuruConcept .",
            19 => @$data[0]." mGuru English Weekly Report:
Total Percent and Marks: ".@$data[1]."% and ".@$data[2].", ".@$data[3]." ".@$data[4]."%
Rank: ".@$data[5]." out of ".@$data[6].", ".@$data[7]." ".@$data[8]." places.
Read the full report here: http://bit.ly/mGuruWeeklyReport",
            20 => @$data[0]." mGuru English Weekly Report:
English Percent and Marks: ".@$data[1]."% and ".@$data[2].", ".@$data[3]." ".@$data[4]."%
Math Percent and Marks: ".@$data[5]."% and ".@$data[6].", ".@$data[7]." ".@$data[8]."%
Rank: ".@$data[9]." out of ".@$data[10].", ".@$data[11]." ".@$data[12]." places.
Read the full report here: http://bit.ly/mGuruWeeklyReport",
            21 => "Welcome to mGuru! Use the promo code 'mvprimary ' to get the Topper Plan for FREE. Download now: http://bit.ly/mgneric",
            22 => "Your mGuru free trial has expired. Help your child learn English with the Topper Plan, and get unlimited access to the mGuru app! http://bit.ly/topperp",
		);

        //! Check for valid sms template
        if(!isset($template[$number])) {
	        return false;
	    }

        //! Setting ISD code
        $isd_code = 91;

        //! Check for valid mobile no.
        if(ereg("(^\+91)",$mobileno)) {
            $mobileno = substr($mobileno,3);
        }
        if(ereg("(^\91)",$mobileno) && strlen($mobileno) == 12) {
            $mobileno = substr($mobileno,2);
        }
        if(ereg("(^\0)",$mobileno) && strlen($mobileno) == 11) {
            $mobileno = substr($mobileno,1);
        }
	    if(strlen($mobileno) != 10) {
	        return false;
	    }

	    //! SMS Gateway Config
	    $method = "SendMessage";
	    $userid = "userid";
	    $auth_scheme = "plain";
	    $password = "password";
	    $version = "1.1";
	    $format = "text";

	    $url = "http://enterprise.smsgupshup.com/GatewayAPI/rest?method=" . $method . "&send_to=".$isd_code . $mobileno . "&msg=".urlencode($template[$number])."&msg_type=TEXT&userid=" . $userid . "&auth_scheme=" . $auth_scheme . "&password=" . $password . "&v=" . $version . "&format=" . $format;

        //! Sending sms
	    $curl = curl_init();
	    curl_setopt ($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_HEADER, 0);
	    curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt ($curl, CURLOPT_CONNECTTIMEOUT, 0);

        $response = curl_exec($curl);

        //! Return boolean
	    return $response;
	}

?>