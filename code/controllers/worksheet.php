<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    /*
	Class name  : Worksheet
	Description : Worksheet for android app
	*/
    class Worksheet extends MG_Controller {

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

            //! Retrive the session details
            $user_id = $this->session->userdata('_user_id_');
            if($user_id != '') {
                //! If logedin retrieve the person details
                $this->user = User::find($user_id);
            }
        }

        /*
    	Function name   : index()
    	Parameter       : none
    	Return          : none
    	Description     : worksheet maker GUI
    	*/
        function index() {
            //$this->trackmp("Home Page",array());

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $activation_msg = "";
            if($this->session->flashdata("activation_msg")) {
                $activation_msg = @$this->session->flashdata("activation_msg");
            }
            $body['activation_msg'] = $activation_msg;

            $this->loadwstemplate("worksheet/index",$header,$body,$footer);
        }

        function loginprocess() {
            if(isset($this->user->id)) {
                redirect("worksheet");
                die();
            }
            $this->trackmp("Sign In",array("username" => $this->input->post('log_email')));
            $email = $this->input->post('log_email');
            $password = md5($this->input->post('log_password'));

            //! Check the email and password
            $euser = User::find("all",array(
                "conditions" => " (email = '$email' OR username = '$email' ) AND password = '$password' "
            ));

            $error = 0;

            //! if valid email and password
            if(isset($euser[0])) {
                if($euser[0]->status == 'active') {            //! Initiate the session variables
                    $this->session->set_userdata(array(
                        '_user_id_'       =>  $euser[0]->id,
                        '_user_email'     =>  $euser[0]->email,
                        '_username'       =>  $euser[0]->username,
                    ));
                    $this->trackmp("Sign In successful",array("username" => $this->input->post('log_email')),array(
                        '$name' => $euser[0]->name(),
                        '$user_id' => $euser[0]->id,
                        '$email' => $euser[0]->email,
                    ));
                    $error = 3;
                } else {
                    $error = 2;
                }
            } else {
                $error = 1;
            }

            //! If not valid email / password
            if($error == 1 ) {            //! Display login page
                redirect('worksheet/login/' . $error);
            } else if($error == 2 ) {
                //redirect('worksheet/login/' . $error);

                if($euser[0]->email != "") {
                    $this->session->set_flashdata("type", 1);
                } else {
                    $this->session->set_flashdata("type", 2);
                }
                $this->session->set_flashdata("success", "Activate account");

                redirect("worksheet/verifyaccount/3/" . $euser[0]->unique_id);
                die();
            } else {                                    //! Else display dasboard
                redirect('worksheet');
            }
        }

        function login($error = 1) {
            if(isset($this->user->id)) {
                redirect("worksheet");
                die();
            }
            $this->trackmp("Login Page",array());
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['error'] = $error;
            $this->loadwstemplate("worksheet/login",$header,$body,$footer);
        }

        function logout() {
            if(!isset($this->user->id)) {
                redirect("worksheet");
                die();
            }

            $this->trackmp("Sign out",array());

            $this->session->set_userdata(array('_user_id_' => '', '_user_email' => '', '_username' => ''));

            //! Destroy the sessions
            $this->session->sess_destroy();

            $header['user'] = $body['user'] = $footer['user'] = '';
            $this->loadwstemplate("worksheet/logout",$header,$body,$footer);
        }

        function signup($error = 1) {
            if(isset($this->user->id)) {
                redirect("worksheet");
                die();
            }
            $ref = 0 ;
            if(isset($_REQUEST['refcode'])) {
                $ref = 1;
            }
            /*$this->trackmp("Sign Up",array("referral" => $ref));*/
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['error'] = $error;
            $body['ref'] = $ref;
            $this->loadwstemplate("worksheet/signup",$header,$body,$footer);
        }

        function signupprocess() {
            if(isset($this->user->id)) {
                redirect("worksheet");
                die();
            }

            $ref = 0 ;
            if($this->input->post('ws_ref_code') != "") {
                $ref = 1;
            }
            $this->trackmp("Sign Up",array(
                "username" => $this->input->post('ws_username'),
                "email" => $this->input->post('email'),
                "mobile" => $this->input->post('mobile'),
                "ref_code" => $this->input->post('ref_code'),
                "referral" => $ref,
            ));

            //! initialize the data
            $username = $this->input->post('ws_username');
            $email = $this->input->post('ws_email');
            $mobile = $this->input->post('ws_mobile');
            $password = $this->input->post('ws_password');
            $ref_code = $this->input->post('ws_ref_code');
            $password = md5($password);

            //! Generate unique id
            $uid = md5(date("Y-m-d H:i:s") . $username . $password);

            //! Mobile verification code
            $mcode = rand(1000,9999);

            $check_user = User::find_by_username($username);

            if(!isset($check_user->id)) {

                //! Insert a New User
                $new_user = User::create(array(
                    'email' => $email,
                    'username' => $username,
                    'password' => $password,
                    'mobile' => $mobile,
                    'status' => 'inactive',
                    'unique_id' => $uid,
                    'password_verification_code' => '',
                    'email_verification_code' => $mcode,
                    'mobile_verification_code' => $mcode,
                    'email_verified' => 0,
                    'mobile_verified' => 0,
                    'admin' => 0,
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                ));

                //! Check if the user is added
                if(isset($new_user->id)) {
                    //! Add user profile
                    $new_user_profile = Profile::create(array(
                        'user_id' => $new_user->id,
                        'title' => '',
                        'first_name' => '',
                        'last_name' => '',
                        'display_name' => $username,
                        'profile_picture' => '',
                        'date_of_birth' => '',
                        'school_id' => '',
                        'examination_board' => '',
                        'teacher_name' => '',
                        'father_name' => '',
                        'mother_name' => '',
                        'gender' => '',
                        'current_class' => "1",
                        'caste_religion' => '',
                        'language_at_home' => '',
                        'address_line_1' => '',
                        'address_line_2' => '',
                        'city' => '',
                        'state' => '',
                        'pincode' => '',
                        'country' => '',
                        'created' => date("Y-m-d H:i:s"),
                        'updated' => date("Y-m-d H:i:s"),
                    ));

                    $ref_user = UserReferralCode::find_by_referral_code($ref_code);

                    if(isset($ref_user->id)) {
                        $uref = UserReferred::create(array(
                            'user_id' => $new_user->id,
                            'referred_by_id' => $ref_user->user_id,
                            'referred_date_time' => date("Y-m-d H:i:s"),
                            'credit_point_status' => "no",
                            'credit_point_date_time' => "",
                            'created' => date("Y-m-d H:i:s"),
                            'updated' => date("Y-m-d H:i:s"),
                        ));
                    }
                }

                if($email != "") {
                    //! email with verification code
                    $email_content = get_email_template(1);
                    $subject = $email_content['subject'];
                    $body = $email_content['body'];
                    $body = str_replace('::name::',ucwords($username),$body);
                    $body = str_replace('::activate_url::',site_url("worksheet/verifyaccount/3/" . $uid . "/" . $mcode),$body);
                    $body = str_replace('::code::',$mcode,$body);
                    $this->email_template($email,$subject,$body);
                    $this->session->set_flashdata("type", 1);
                } else {
                    // SMS the verification code
                    $merror = sendsms(1, $mobile, array($mcode));
                    $this->session->set_flashdata("type", 2);
                }

                $this->session->set_flashdata("success", "Registration done");

                redirect("worksheet/verifyaccount/1/" . $uid);
                die();

            } else {
                if($check_user->status == "active") {
                    $this->session->set_flashdata("success", "Active user");
                    redirect("worksheet/verifyaccount/2/" . $uid);
                    $this->session->set_flashdata("type", 1);
                    die();
                } else {
                    if($check_user->email != "") {
                        //! email with verification code
                       /* $email_content = get_email_template(1);
                        $subject = $email_content['subject'];
                        $body = $email_content['body'];
                        $body = str_replace('::name::',ucwords($check_user->username),$body);
                        $body = str_replace('::activate_url::',site_url("worksheet/verifyaccount/3/" . $check_user->unique_id . "/" . $check_user->mobile_verification_code),$body);
                        $body = str_replace('::code::',$check_user->mobile_verification_code,$body);
                        $this->email_template($check_user->email,$subject,$body);*/
                        $this->session->set_flashdata("type", 1);
                    } else {
                        // SMS the verification code
                        //$merror = sendsms(1, $check_user->mobile, array($check_user->mobile_verification_code));
                        $this->session->set_flashdata("type", 2);
                    }
                    $this->session->set_flashdata("success", "Activate account");

                    redirect("worksheet/verifyaccount/3/" . $uid);
                    die();
                }
            }

        }

        function verifyaccount($meta_type = 0, $uid = "", $mcode = "",$type = "") {
            if(isset($this->user->id)) {
                redirect("worksheet");
                die();
            }

            $this->trackmp("Verify Account",array(
                "uid" => $uid,
            ));

            if(isset($_REQUEST['ws_code'])) {

                $check_user = User::find_by_unique_id_and_mobile_verification_code($uid,$_REQUEST['ws_code']);

                if(!isset($check_user->id)) {

                    $this->session->set_flashdata("success", "Done");
                    $this->session->set_flashdata("type", 1);
                    redirect("worksheet/verifyaccount/4/" . $uid);
                    die();

                } else {
                    if($check_user->status == "active") {
                        $this->session->set_flashdata("success", "Active user");
                        $this->session->set_flashdata("type", 1);
                        redirect("worksheet/verifyaccount/4/" . $uid);
                        die();
                    } else {
                        if($check_user->email != "") {
                            $check_user->email_verification_code = "";
                            $check_user->email_verified = 1;
                        } else {
                            $check_user->mobile_verification_code = "";
                            $check_user->mobile_verified = 1;
                        }
                        $check_user->status = "active";
                        $check_user->save();

                        $uref = UserReferred::find_by_user_id_and_credit_point_status($check_user->id,"no");

                        if(isset($uref->id)) {
                            $uref->credit_point_status = "yes";
                            $uref->credit_point_date_time = date("Y-m-d H:i:s");
                            $uref->updated = date("Y-m-d H:i:s");
                            $uref->save();

                            $wss = UserWorksheetStatus::find($uref->referred_by_id);

                            if(isset($wss->id)) {
                                if($wss->expire_date_time == date("Y-m-t 23:59:59")) {
                                    $wss->count += 5;
                                } else {
                                    if($wss->count <= 5) {
                                        $wss->count = 5;
                                    }
                                    $wss->count += 5;
                                    $wss->expire_date_time = date("Y-m-t 23:59:59");
                                }

                                $wss->updated = date("Y-m-d H:i:s");
                                $wss->save();
                            }
                        }

                        $this->session->set_userdata(array(
                            '_user_id_'        =>  $check_user->id,
                            '_user_email'       =>  $check_user->email,
                            '_username'       =>  $check_user->username,
                        ));

                        $this->session->set_flashdata("activation_msg", "Congratulation your account has been activated! Now you can create your own worksheet.");
                        $error = 3;

                        redirect("worksheet");
                        die();
                    }
                }
            } else {

                if($type == "") {
                    $type = $this->session->flashdata("type");
                    $success = $this->session->flashdata("success");
                }

                $check_user = User::find_by_unique_id($uid);

                $header['user'] = $body['user'] = $footer['user'] = $this->user;
                $body['type'] = $type;
                $body['meta_type'] = $meta_type;
                $body['check_user'] = $check_user;
                $body['uid'] = $uid;
                $body['mcode'] = $mcode;

                $this->loadwstemplate("worksheet/verifyaccount",$header,$body,$footer);
            }
        }

        function resend($meta_type = 0, $uid = "", $mcode = "",$type = "") {

            if(isset($this->user->id)) {
                redirect("worksheet");
                die();
            }

            $this->trackmp("ReSend Code",array(
                "uid" => $uid,
            ));

            $check_user = User::find_by_unique_id($uid);

            if(!isset($check_user->id)) {

                $this->session->set_flashdata("success", "Done");
                $this->session->set_flashdata("type", 1);
                redirect("worksheet/verifyaccount/2/" . $uid);
                die();

            } else {
                if($check_user->status == "active") {
                    $this->session->set_flashdata("success", "Active user");
                    $this->session->set_flashdata("type", 1);
                    redirect("worksheet/verifyaccount/4/" . $uid);
                    die();
                } else {
                    if($check_user->email != "") {
                        //! email with verification code
                        $email_content = get_email_template(1);
                        $subject = $email_content['subject'];
                        $body = $email_content['body'];
                        $body = str_replace('::name::',ucwords($check_user->username),$body);
                        $body = str_replace('::activate_url::',site_url("worksheet/verifyaccount/3/" . $check_user->unique_id . "/" . $check_user->mobile_verification_code),$body);
                        $body = str_replace('::code::',$check_user->mobile_verification_code,$body);
                        $this->email_template($check_user->email,$subject,$body);
                        $this->session->set_flashdata("type", 1);
                    } else {
                        // SMS the verification code
                        $merror = sendsms(1, $check_user->mobile, array($check_user->mobile_verification_code));
                        $this->session->set_flashdata("type", 2);
                    }
                    $this->session->set_flashdata("success", "Activate account");

                    redirect("worksheet/verifyaccount/3/" . $uid);
                    die();
                }
            }

        }

        function refer() {
            if(!isset($this->user->id)) {
                redirect("worksheet");
                die();
            }

            //$this->trackmp("Referral Page",array());

            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $this->loadwstemplate("worksheet/refer",$header,$body,$footer);
        }

        /*
    	Function name   : create()
    	Parameter       : none
    	Return          : none
    	Description     : Create Worksheet form
    	*/
        function create() {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect("worksheet");
                die();
            }

            //$this->trackmp("New Worksheet",array("created" => "0"));
            $error = 0;

            if($this->user->user_worksheet_status->expire_date_time->format("Ymd") < date("Ymd")) {
                $this->user->user_worksheet_status->expire_date_time = date("Y-m-t 23:59:59");
                if( $this->user->user_worksheet_status->count < 5) {
                    $this->user->user_worksheet_status->count = 5;
                }
                $this->user->user_worksheet_status->save();
                $error = 0;
            } else {
                if( $this->user->user_worksheet_status->count <= 0) {
                    $error = 1;
                }
            }

            //! Setting page data
            $body['user'] = $footer['user'] = $header['user'] = $this->user;
            $body['error'] = $error;

            if($error == 0) {

                $body['units'] =  Units::find_all_by_subject_id(1);
                $body['concepts'] =  Concept::find("all");
                /*$body['questions'] =  ConceptsQuestionLinkage::find('all',array(
                    'joins' => array("question"),
                    'conditions' => array(" mg_question.status = 'active' "),
                    'group' => 'question_id,board',
                    "order" => "classes_id,order_num,sub_order_num"
                ));*/
            }

            $this->loadwstemplate("worksheet/worksheet",$header,$body,$footer);
        }

        function getquestionsdata() {
            $board = @$_REQUEST['board'];
            $cl = @$_REQUEST['cl'];

            $questions =  ConceptsQuestionLinkage::find('all',array(
                    'joins' => array("question"),
                    'conditions' => array(" mg_question.status = 'active' AND classes_id = '$cl' AND board = '$board' "),
                    'group' => 'question_id',
                    "order" => "order_num,sub_order_num"
                ));
            $mmm = array();
            foreach( $questions as $val) {
                $mmm[] = $val->question->id.",," . $val->question->question.",," . $val->question->question_template_id . ":::". $val->question->title . ":::" . $val->concepts_id. ":::" . $val->concept->units_id. ":::" . $val->classes_id . ":::" .$val->board . ":::" .$val->concept->name . ":::" .$val->concept->units->name;
            }
            echo implode(";;;" , $mmm);
        }

        /*
    	Function name   : worksheetprocess()
    	Parameter       : none
    	Return          : none
    	Description     : worksheet maker Process
    	*/
        function worksheetprocess() {
            $this->load->helper('worksheet_helper');
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect("worksheet");
                die();
            }

            $this->trackmp("New Worksheet",array(
                "created" => "1",
                "name" => $this->input->post('ws_name'),
                "Grade Level" => $this->input->post('class') - 2,
                "State Board" => $this->input->post('ws_board'),
            ));
            $error = 0;

            if($this->user->user_worksheet_status->expire_date_time->format("Ymd") < date("Ymd")) {
                $this->user->user_worksheet_status->expire_date_time = date("Y-m-t 23:59:59");
                if( $this->user->user_worksheet_status->count < 5) {
                    $this->user->user_worksheet_status->count = 5;
                }
                $this->user->user_worksheet_status->save();
                $error = 0;
            } else {
                if( $this->user->user_worksheet_status->count <= 0) {
                    redirect("worksheet/create");
                    die();
                }
            }

            $questions = array();
            $questions_template = array();
            $units = array();
            $concepts = array();
            $sub_concepts = array();
            $count = array();

            for($ii = 0 ; $ii < @$_REQUEST['count_question'] ; $ii++ ) {
                $subc = explode(",,",@$_REQUEST['sub_concept_' . $ii] );

                $method = str_replace("(","\\(",@$subc[1] );
                $method = str_replace(")","\\)",@$method );

                $units[] = $this->input->post('unit_' . $ii);
                $concepts[] = $this->input->post('concept_' . $ii);
                $sub_concepts[] = $this->input->post('sub_concept_' . $ii);
                $count[] = $this->input->post('count_' . $ii);

                for($mm = 0 ; $mm < @$_REQUEST['count_' . $ii] ; $mm++ ) {
                    //$str = shell_exec('set path="C:\Program Files\Java\jdk1.8.0_60\bin" ;2>&1 1> /dev/null set CLASSPATH="C:\wampnew\www\\mgurucode\codephp;C:\wampnew\www\mgurucode\codephp\java-json.jar" ; 2>&1 1> /dev/null java math.MG_BLL_Time; 2>&1 1> /dev/null');
                    $tempii = 0;
                    $tempcheck = 0;
                    $questionstemp = '';

                    do {
                        $tempcheck = 1;
                        $questionstemp = shell_exec('export PATH="/usr/lib/jvm/java-8-oracle/bin" && export CLASSPATH="/var/www/html:/var/www/html/java-json.jar" && java math.MG_MathMainFile ' . $method);
                        if(in_array($questionstemp,$questions)) {
                            $tempcheck = 0;
                        }
                        $tempii++;
                    } while($tempcheck == 0 && $tempii < 4 );

                    $questions[] = $questionstemp;
                    $questions_template[] = @$subc[2];
                    $questions_bll[] = @$method;

                }
            }

            $new_worksheet = UserWorksheet::create(array(
                "user_id" => $this->user->id,
                "name" => $this->input->post('ws_name'),
                "classes_id" => $this->input->post('class'),
                "units" => json_encode($units),
                "concepts" => json_encode($concepts),
                "sub_concepts" => json_encode($sub_concepts),
                "count" => json_encode($count),
                "questions" => json_encode($questions),
                "questions_bll" => json_encode($questions_bll),
                "questions_template" => json_encode($questions_template),
                "pdf_file" => "",
                "board" => $this->input->post('ws_board'),
                "created" => date("Y-m-d H:i:s"),
                "updated" => date("Y-m-d H:i:s"),
            ));

            $file_name = "mguru_worksheet_".$new_worksheet->id.".pdf";
            $url = site_url('worksheet/createworksheetpdf/' . $new_worksheet->id);
            $pdffile = "/var/www/html/pdf/" . $file_name;
            $handle = popen("/var/www/html/code/controllers/html2pdf/wkhtmltopdf --margin-left 5mm --margin-right 5mm $url $pdffile  2>&1", "r");

            $new_worksheet->pdf_file = $file_name;
            $new_worksheet->save();

            $this->user->user_worksheet_status->count -= 1;
            $this->user->user_worksheet_status->save();

            redirect("worksheet/view/" . $new_worksheet->id);
        }

        function createworksheetpdf($id,$return = false) {
            $this->load->helper('worksheet_helper');

            $ws = UserWorksheet::find($id);
            $questions = json_decode($ws->questions);
            $questions_template = json_decode($ws->questions_template);
            $questions_bll = json_decode($ws->questions_bll);
            $units = json_decode($ws->units);
            $concepts = json_decode($ws->concepts);
            $sub_concepts = json_decode($ws->sub_concepts);
            $count = json_decode($ws->count);

            //! Setting page data
            $body['user'] = $this->user;
            $body['questions'] =  $questions;
            $body['questions_template'] =  $questions_template;
            $body['questions_bll'] =  $questions_bll;
            $body['ws'] =  $ws;

            if($return) {
                return $this->load->view('worksheet/worksheetprocess', $body,true);
            } else {
                $this->load->view('worksheet/worksheetprocess', $body);
            }
        }

        function createworksheetanswerpdf($id,$return = false) {
            $this->load->helper('worksheet_helper');

            $ws = UserWorksheet::find($id);
            $questions = json_decode($ws->questions);
            $questions_template = json_decode($ws->questions_template);
            $questions_bll = json_decode($ws->questions_bll);
            $units = json_decode($ws->units);
            $concepts = json_decode($ws->concepts);
            $sub_concepts = json_decode($ws->sub_concepts);
            $count = json_decode($ws->count);

            //! Setting page data
            $body['user'] = $this->user;
            $body['questions'] =  $questions;
            $body['questions_template'] =  $questions_template;
            $body['questions_bll'] =  $questions_bll;
            $body['ws'] =  $ws;

            if($return) {
                return $this->load->view('worksheet/worksheetanswer', $body,true);
            } else {
                $this->load->view('worksheet/worksheetanswer', $body);
            }
        }

        function view($id) {
            $this->load->helper('worksheet_helper');
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect("worksheet");
                die();
            }

            $ws = UserWorksheet::find($id);

            if($this->user->id != $ws->user_id) {
                redirect("worksheet/create");
                die();
            }

            $this->trackmp("View Worksheet",array(
                "id" => $id,
                "name" => $ws->name,
                "Grade Level" => $ws->classes_id - 2,
                "State Board" => $ws->board,
            ));

            if($this->user->user_worksheet_status->expire_date_time->format("Ymd") < date("Ymd")) {
                $this->user->user_worksheet_status->expire_date_time = date("Y-m-t 23:59:59");
                if( $this->user->user_worksheet_status->count < 5) {
                    $this->user->user_worksheet_status->count = 5;
                }
                $this->user->user_worksheet_status->save();
            }

            $ws_sheet = $this->createworksheetpdf($id,true);

            //! Setting page data
            $body['user'] = $footer['user'] = $header['user'] = $this->user;
            $body['error'] = $error;
            $body['ws_sheet'] = $ws_sheet;
            $body['ws'] = $ws;

            $this->loadwstemplate("worksheet/view",$header,$body,$footer);
        }

        function downloadpdf($id) {
            $this->load->helper('worksheet_helper');
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect("worksheet");
                die();
            }

            $ws = UserWorksheet::find($id);

            if($this->user->id != $ws->user_id) {
                redirect("worksheet/create");
                die();
            }

            $this->trackmp("Download Worksheet",array(
                "id" => $id,
                "name" => @$ws->name,
                "Grade Level" => @$ws->classes_id - 2,
                "State Board" => @$ws->board,
            ));

            $file_name = "mguru_worksheet_".$ws->id.".pdf";
            $url = site_url('worksheet/createworksheetpdf/' . $ws->id);
            $pdffile = "/var/www/html/pdf/" . $file_name;
            $handle = popen("/var/www/html/code/controllers/html2pdf/wkhtmltopdf  $url $pdffile  2>&1", "r");

           //! Setting page data
            $body['user'] = $footer['user'] = $header['user'] = $this->user;
            $body['ws'] = @$ws;

            $this->loadwstemplate("worksheet/downloadpdf",$header,$body,$footer);
        }

        function downloadpdf1($id) {
            $this->load->helper('worksheet_helper');
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect("worksheet");
                die();
            }

            $ws = UserWorksheet::find($id);

            if($this->user->id != $ws->user_id) {
                redirect("worksheet/create");
                die();
            }

            $file_name = "mguru_worksheet_".$ws->id.".pdf";
            $url = site_url('worksheet/createworksheetpdf/' . $ws->id);
            $pdffile = "/var/www/html/pdf/" . $file_name;
            $handle = popen("/var/www/html/code/controllers/html2pdf/wkhtmltopdf  $url $pdffile  2>&1", "r");


            $path = "pdf/" . @$ws->pdf_file;
            $filename = @$ws->pdf_file;
            header('Content-Transfer-Encoding: binary');  // For Gecko browsers mainly
            header('Accept-Ranges: bytes');  // For download resume
            header('Content-Length: ' . filesize($path));  // File size
            header('Content-Encoding: none');
            header('Content-Type: application/pdf');  // Change this mime type if the file is not PDF
            header('Content-Disposition: attachment; filename=' . $filename);  // Make the browser display the Save As dialog
            readfile($path);  //this is necessary in order to get it to actually download the file, otherwise it will be 0Kb
        }

        function downloadanswerpdf($id) {
            $this->load->helper('worksheet_helper');
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect("worksheet");
                die();
            }

            $ws = UserWorksheet::find($id);

            if($this->user->id != $ws->user_id) {
                redirect("worksheet/create");
                die();
            }

            $this->trackmp("Download Answer Worksheet",array(
                "id" => $id,
                "name" => $ws->name,
                "Grade Level" => $ws->classes_id - 2,
                "State Board" => $ws->board,
            ));

            $file_name = "mguru_worksheet_answer_".$ws->id.".pdf";
            $url = site_url('worksheet/createworksheetanswerpdf/' . $ws->id);
            $pdffile = "/var/www/html/pdf/" . $file_name;
            $handle = popen("/var/www/html/code/controllers/html2pdf/wkhtmltopdf  $url $pdffile  2>&1", "r");

           //! Setting page data
            $body['user'] = $footer['user'] = $header['user'] = $this->user;
            $body['ws'] = @$ws;

            $this->loadwstemplate("worksheet/downloadanswerpdf",$header,$body,$footer);
        }

        function downloadanswerpdf1($id) {
            $this->load->helper('worksheet_helper');
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect("worksheet");
                die();
            }

            $ws = UserWorksheet::find($id);

            if($this->user->id != $ws->user_id) {
                redirect("worksheet/create");
                die();
            }

            $this->trackmp("Download Answer Worksheet",array(
                "id" => $id,
                "name" => $ws->name,
                "Grade Level" => $ws->classes_id - 2,
                "State Board" => $ws->board,
            ));


            $file_name = "mguru_worksheet_answer_".$ws->id.".pdf";
            $url = site_url('worksheet/createworksheetanswerpdf/' . $ws->id);
            $pdffile = "/var/www/html/pdf/" . $file_name;
            $handle = popen("/var/www/html/code/controllers/html2pdf/wkhtmltopdf  $url $pdffile  2>&1", "r");


            $path = "pdf/" . @$file_name;
            $filename = @$file_name;
            header('Content-Transfer-Encoding: binary');  // For Gecko browsers mainly
            header('Accept-Ranges: bytes');  // For download resume
            header('Content-Length: ' . filesize($path));  // File size
            header('Content-Encoding: none');
            header('Content-Type: application/pdf');  // Change this mime type if the file is not PDF
            header('Content-Disposition: attachment; filename=' . $filename);  // Make the browser display the Save As dialog
            readfile($path);  //this is necessary in order to get it to actually download the file, otherwise it will be 0Kb
        }

        function previewtemplate() {
            $this->load->helper('worksheet_helper');
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            $questions = array();
            $questions_template = array();

            $subc = explode(",,",@$_REQUEST['sub_concept'] );

            $method = str_replace("(","\\(",@$subc[1] );
            $method = str_replace(")","\\)",@$method );

            //$str = shell_exec('set path="C:\Program Files\Java\jdk1.8.0_60\bin" ;2>&1 1> /dev/null set CLASSPATH="C:\wampnew\www\\mgurucode\codephp;C:\wampnew\www\mgurucode\codephp\java-json.jar" ; 2>&1 1> /dev/null java math.MG_BLL_Time; 2>&1 1> /dev/null');
            $questions[] = shell_exec('export PATH="/usr/lib/jvm/java-8-oracle/bin" && export CLASSPATH="/var/www/html:/var/www/html/java-json.jar" && java math.MG_MathMainFile ' . $method);

            $questions_template[] = @$subc[2];
            $questions_bll[] = @$method;

            //! Setting page data
            $body['user'] = $this->user;
            $body['questions'] =  $questions;
            $body['questions_template'] =  $questions_template;
            $body['questions_bll'] =  $questions_bll;

            $this->load->view('worksheet/worksheetpreview', $body);
        }

        /*
    	Function name   : list()
    	Parameter       : none
    	Return          : none
    	Description     : List Worksheet form
    	*/
        function listview() {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect("worksheet");
                die();
            }

            //$this->trackmp("List Worksheet",array( ));

            if($this->user->user_worksheet_status->expire_date_time->format("Ymd") < date("Ymd")) {
                $this->user->user_worksheet_status->expire_date_time = date("Y-m-t 23:59:59");
                if( $this->user->user_worksheet_status->count < 5) {
                    $this->user->user_worksheet_status->count = 5;
                }
                $this->user->user_worksheet_status->save();
            }

            $ws_credit = $this->user->user_worksheet_status->count;

            //! Setting page data
            $body['user'] = $footer['user'] = $header['user'] = $this->user;
            $body['ws_credit'] = $ws_credit;

            $body['ws'] =  UserWorksheet::find("all",array(
                "conditions" => "user_id = '".$this->user->id."'",
                "order" => "id DESC",
            ));

            $this->loadwstemplate("worksheet/listview",$header,$body,$footer);
        }

        function sendemail() {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect("worksheet");
                die();
            }

            $emails = explode(",",trim(@$_REQUEST['emails']));

            $this->trackmp("Referral Sent",array(
                "num" => count($emails)
            ));

            $email_content = get_email_template(2);
            $subject = $email_content['subject'];
            $subject = str_replace('::name::',ucwords($this->user->name()),$subject);
            $body = $email_content['body'];
            $body = str_replace('::name::',ucwords($this->user->name()),$body);
            $body = str_replace('::refer_url::',site_url("worksheet/signup?refcode=".$this->user->user_referral_code->referral_code),$body);

            foreach($emails as $ema) {
                if(trim($ema) != '') {
                    $this->email_template(trim($ema),$subject,$body);

                    $ref = UserReferralEmails::create(array(
                        "user_id" => $this->user->id,
                        "email" => $ema,
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s"),
                    ));
                }
            }
        }

        function sendemail1() {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect("worksheet");
                die();
            }

            $emails = explode(",",trim(@$_REQUEST['emails']));

            $this->trackmp("Referral Sent",array(
                "num" => count($emails)
            ));

            $email_content = get_email_template(4);
            $subject = $email_content['subject'];
            $subject = str_replace('::name::',ucwords($this->user->name()),$subject);
            $body = $email_content['body'];
            $body = str_replace('::name::',ucwords($this->user->name()),$body);
            $body = str_replace('::refer_url::',"http://www.mguruenglish.com/registration/".$this->user->user_referral_code->referral_code,$body);

            foreach($emails as $ema) {
                if(trim($ema) != '') {
                    $this->email_template(trim($ema),$subject,$body);

                    $ref = UserReferralEmails::create(array(
                        "user_id" => $this->user->id,
                        "email" => $ema,
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s"),
                    ));
                }
            }
        }

        function trackmp($msg,$options = array(), $mainoptions = array()) {
            include_once("mixpanel/Mixpanel.php");

            $mp = Mixpanel::getInstance("id");

            if(isset($this->user->id)) {
                $mp->identify($this->user->id);
                //$mp->createAlias($this->user->id, $this->user->name());
                if(count($mainoptions) > 0 ) {
                    $mp->people->set($this->user->id, $mainoptions);
                }
            }

            $mp->track($msg, $options);
        }

        function forgotpassword($error = 0) {
            if(isset($this->user->id)) {
                redirect("worksheet");
                die();
            }

            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['error'] = $error;
            $this->loadwstemplate("worksheet/forgotpassword",$header,$body,$footer);
        }

        function forgotpasswordprocess() {
            if(isset($this->user->id)) {
                redirect("worksheet");
                die();
            }

            $this->trackmp("Forgort Password",array(
                "username" => $this->input->post('ws_username')
            ));

            //! initialize the data
            $username = $this->input->post('ws_username');

            //! Mobile verification code
            $mcode = rand(1000,9999);

            $check_user = User::find_by_username($username);

            $error = 1;

            //! if valid username / email / mobile
            if(isset($check_user->id)) {
                //! check for password_verification_code
                if($check_user->password_verification_code == '') {
                    //! Set it in the database
                    $check_user->password_verification_code = $mcode;
                } else {
                    $mcode = $check_user->password_verification_code;

                    if(strlen($mcode) != 4) {
                        $mcode = rand(1000,9999);
                        $check_user->password_verification_code = $mcode;
                    }
                }
                $check_user->updated = date("Y-m-d H:i:s");
                $check_user->save();

                if($check_user->email != '') {
                    //! Retrieve the email template for forgot password
                    $email_content = get_email_template(5);
                    $subject = $email_content['subject'];
                    $body = $email_content['body'];
                    $body = str_replace('::name::',ucwords($check_user->name()),$body);
                    $body = str_replace('::reset_url::',site_url("worksheet/resetpassword/2/" . $mcode ),$body);
                    $this->email_template($check_user->email,$subject,$body);
                    $error = 2;
                } else {
                    // SMS the verification code
                    $merror = sendsms(1, $check_user->mobile, array($mcode));
                    $error = 3;
                }
                redirect("worksheet/resetpassword/" . $error);
            } else {
                redirect("worksheet/forgotpassword/1");
                die();
            }
        }

        function resetpassword($meta_type = 0, $mcode = "") {
            if(isset($this->user->id)) {
                redirect("worksheet");
                die();
            }

            $this->trackmp("Reset Password",array(
                "type" => $meta_type,
            ));

            if(isset($_REQUEST['ws_password'])) {

                $check_user = User::find("all",array(
                    "conditions" => " updated >= '".date("Y-m-d H:i:s",mktime(date("H") - 7))."' AND password_verification_code = '".$_REQUEST['ws_code']."' "
                ));

                if(!isset($check_user[0])) {
                    redirect("worksheet/resetpassword/1");
                    die();
                } else {
                    $check_user = $check_user[0];
                    $check_user->password_verification_code = "";
                    $check_user->password = md5($_REQUEST['ws_password']);
                    $check_user->save();
                    $this->session->set_flashdata("activation_msg", "Your password is changed successfully. Login to create more worksheet");
                    redirect("worksheet");
                    die();
                }
            } else {
                $header['user'] = $body['user'] = $footer['user'] = $this->user;
                $body['meta_type'] = $meta_type;
                $body['mcode'] = $mcode;

                $this->loadwstemplate("worksheet/resetpassword",$header,$body,$footer);
            }
        }
    }
?>