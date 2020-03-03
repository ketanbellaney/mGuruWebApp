<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    /*
	Class name  : Paytm
	Description : Paytm
	*/
    class Paytm extends MG_Controller {

        var $user = '';

        /*
	    Function name   : __construct()
    	Parameter       : none
    	Return          : none
    	Description     : Constructor  Called as soon as the class instance is created
    	*/
        function __construct() {
            parent::__construct();

            $this->ci =& get_instance();

        }

        /*
    	Function name   : index()
    	Parameter       : none
    	Return          : none
    	Description     : worksheet maker GUI
    	*/
        function index() {
            header("location: http://www.mguru.co.in");
        }

        function generatechecksum() {
            header("Pragma: no-cache");
            header("Cache-Control: no-cache");
            header("Expires: 0");

            // following files need to be included
            require_once("paytm/config_paytm.php");
            require_once("paytm/encdec_paytm.php");

            $checkSum = "";

            //Here checksum string will return by getChecksumFromArray() function.  
            $checkSum = getChecksumFromArray($_POST,PAYTM_MERCHANT_KEY);
            //print_r($_POST);

            echo json_encode(array("CHECKSUMHASH" => $checkSum,"ORDER_ID" => $_POST["ORDER_ID"], "payt_STATUS" => "1"));

            //Sample response return to SDK

            //  {"CHECKSUMHASH":"GhAJV057opOCD3KJuVWesQ9pUxMtyUGLPAiIRtkEQXBeSws2hYvxaj7jRn33rTYGRLx2TosFkgReyCslu4OUj\/A85AvNC6E4wUP+CZnrBGM=","ORDER_ID":"asgasfgasfsdfhl7","payt_STATUS":"1"}
        }

        function verifychecksum() {
            header("Pragma: no-cache");
            header("Cache-Control: no-cache");
            header("Expires: 0");

            // following files need to be included
            require_once("paytm/config_paytm.php");
            require_once("paytm/encdec_paytm.php");

            $paytmChecksum = "";
            $paramList = array();
            $isValidChecksum = FALSE;

            $paramList = $_POST;
            $return_array = $_POST;
            $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

            //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
            $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.

            $return_array["IS_CHECKSUM_VALID"] = $isValidChecksum ? "Y" : "N";
            unset($return_array["CHECKSUMHASH"]);

            $encoded_json = htmlentities(json_encode($return_array));

            echo "
            <html>
                <head>
            	    <meta http-equiv='Content-Type' content='text/html;charset=ISO-8859-I'>
	                <title>Paytm</title>
	                <script type='text/javascript'>
		                function response(){
			                return document.getElementById('response').value;
		                }
	                </script>
                </head>
                <body>
                    Redirect back to the app<br>
                    <form name='frm' method='post'>
                        <input type='hidden' id='response' name='responseField' value='".$encoded_json."' >
                    </form>
                </body>
            </html>";
        }
    }
?>