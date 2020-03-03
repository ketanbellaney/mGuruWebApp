<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    /*
	Class name  : Teacher
	*/
    class Teacher extends MG_Controller {

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
            $user_id = $this->session->userdata('_tuser_id_');
            if($user_id != '') {
                //! If logedin retrieve the person details
                $this->user = User::find($user_id);
            }
        }

        /*
    	Function name   : index()
    	Parameter       : none
    	Return          : none
    	Description     : teacher maker GUI
    	*/
        function index() {

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $activation_msg = "";
            if($this->session->flashdata("activation_msg")) {
                $activation_msg = @$this->session->flashdata("activation_msg");
            }
            $body['activation_msg'] = $activation_msg;

            $this->loadtatemplate("teacher/index",$header,$body,$footer);
        }

        function loginprocess() {
            if(isset($this->user->id)) {
                redirect("teacher");
                die();
            }
            //$this->trackmp("Sign In",array("username" => $this->input->post('log_email')));
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
                        '_tuser_id_'       =>  $euser[0]->id,
                        '_user_email'     =>  $euser[0]->email,
                        '_username'       =>  $euser[0]->username,
                    ));
                    /*$this->trackmp("Sign In successful",array("username" => $this->input->post('log_email')),array(
                        '$name' => $euser[0]->name(),
                        '$user_id' => $euser[0]->id,
                        '$email' => $euser[0]->email,
                    ));*/
                    $error = 3;
                } else {
                    $error = 2;
                }
            } else {
                $error = 1;
            }

            //! If not valid email / password
            if($error == 1 ) {            //! Display login page
                redirect('teacher/login/' . $error);
            } else {                                    //! Else display dasboard
                redirect('teacher');
            }
        }

        function login($error = 1) {
            if(isset($this->user->id)) {
                redirect("teacher");
                die();
            }
            //$this->trackmp("Login Page",array());
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['error'] = $error;
            $this->loadtatemplate("teacher/login",$header,$body,$footer);
        }

        function logout() {
            if(!isset($this->user->id)) {
                redirect("teacher");
                die();
            }

            //$this->trackmp("Sign out",array());

            $this->session->set_userdata(array('_tuser_id_' => '', '_user_email' => '', '_username' => ''));

            //! Destroy the sessions
            $this->session->sess_destroy();

            $header['user'] = $body['user'] = $footer['user'] = '';
            $this->loadtatemplate("teacher/logout",$header,$body,$footer);
        }

        function forgotpassword($error = 0) {
            if(isset($this->user->id)) {
                redirect("teacher");
                die();
            }

            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['error'] = $error;
            $this->loadtatemplate("teacher/forgotpassword",$header,$body,$footer);
        }

        function forgotpasswordprocess() {
            if(isset($this->user->id)) {
                redirect("teacher");
                die();
            }

            /*$this->trackmp("Forgort Password",array(
                "username" => $this->input->post('ws_username')
            ));*/

            //! initialize the data
            $username = $this->input->post('ws_username');

            //! Mobile verification code
            $mcode = rand(1000,9999);

            $check_user1 = User::find("all", array(
                "conditions" => " username = '$username' "
            ));

            $error = 1;

            //! if valid username / email / mobile
            if(isset($check_user1[0]->id)) {
                $check_user = $check_user1[0];
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
                    $body = str_replace('::reset_url::',site_url("teacher/resetpassword/2/" . $mcode ),$body);
                    $this->email_template($check_user->email,$subject,$body);
                    $error = 2;
                } else {
                    // SMS the verification code
                    $merror = sendsms(1, $check_user->mobile, array($mcode));
                    $error = 3;
                }
                redirect("teacher/resetpassword/" . $error);
            } else {
                redirect("teacher/forgotpassword/1");
                die();
            }
        }

        function resetpassword($meta_type = 0, $mcode = "") {
            if(isset($this->user->id)) {
                redirect("teacher");
                die();
            }

            /*$this->trackmp("Reset Password",array(
                "type" => $meta_type,
            ));*/

            if(isset($_REQUEST['ws_password'])) {

                $check_user = User::find("all",array(
                    "conditions" => " updated >= '".date("Y-m-d H:i:s",mktime(date("H") - 7))."' AND password_verification_code = '".$_REQUEST['ws_code']."' "
                ));

                if(!isset($check_user[0])) {
                    redirect("teacher/resetpassword/1");
                    die();
                } else {
                    $check_user = $check_user[0];
                    $check_user->password_verification_code = "";
                    $check_user->password = md5($_REQUEST['ws_password']);
                    $check_user->save();
                    $this->session->set_flashdata("activation_msg", "Your password is changed successfully. Login to get started.");
                    redirect("teacher");
                    die();
                }
            } else {
                $header['user'] = $body['user'] = $footer['user'] = $this->user;
                $body['meta_type'] = $meta_type;
                $body['mcode'] = $mcode;

                $this->loadtatemplate("teacher/resetpassword",$header,$body,$footer);
            }
        }

        function addstudent($error = 0) {
            if(!isset($this->user->id)) {
                redirect("teacher");
                die();
            }

            //! Validation rules
            $this->form_validation->set_rules('st_username','Student username', 'trim|required');

             //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {

                $header['user'] = $body['user'] = $footer['user'] = $this->user;
                $body['error'] = $error;
                $this->loadtatemplate("teacher/addstudent",$header,$body,$footer);

            } else {

                $username = $this->input->post('st_username');

                $userm = User::find("all",array(
                    "select" => "id",
                    "conditions" => " username = '$username' "
                ));

                if(isset($userm[0])) {

                    redirect("teacher/studentrequest/" . md5($userm[0]->id));
                    die();
                } else {
                    redirect("teacher/addstudent/1");
                    die();
                }
            }
        }

        function checkusername() {
            if(!isset($this->user->id)) {
                echo "";
                die();
            }

            $userm = @$_REQUEST['query'];

            $mmm = User::find("all",array(
                "select" => "username",
                "conditions" => " username LIKE '$userm"."%' ",
                "order" => "username ASC",
                "limit" => 10,
            ));

            $xxx = array();

            foreach($mmm as $val) {
                $xxx[] = $val->username;
            }

            echo implode(":::",$xxx);
        }

        function studentrequest($code = '') {
            if(!isset($this->user->id)) {
                redirect("teacher");
                die();
            }

            $userm_id = "";
            if($code != '') {
                $userm = User::find("all",array(
                    "conditions" => " MD5(id) = '$code' "
                ));
                if(isset($userm[0])) {
                    $header['user'] = $body['user'] = $footer['user'] = $this->user;
                    $body['userm'] = $userm[0];
                    $this->loadtatemplate("teacher/studentrequest",$header,$body,$footer);

                } else {
                    redirect("teacher/addstudent/1");
                    die();
                }

            } else {
                redirect("teacher/addstudent");
                die();
            }
        }

        function studentrequestprocess($code = '') {
            if(!isset($this->user->id)) {
                redirect("teacher");
                die();
            }

            $userm_id = "";

            if($code != '') {

                $userm = User::find("all",array(
                    "conditions" => " MD5(id) = '$code' "
                ));
                if(isset($userm[0])) {
                    $linkage = StudentTeacherLinkage::find_by_student_id_and_teacher_id($userm[0]->id, $this->user->id);

                    if(isset($linkage->id)) {
                        if( $linkage->status == 'pending' ) {
                            $linkage->updated = date("Y-m-d H:i:s");
                            $linkage->save();
                            redirect("teacher/addstudent/2");
                            die();
                        } else if( $linkage->status == 'accepted' ) {
                            redirect("teacher/addstudent/3");
                            die();
                        } else {
                            $linkage->status = 'pending';
                            $linkage->updated = date("Y-m-d H:i:s");
                            $linkage->save();
                            redirect("teacher/addstudent/2");
                            die();
                        }
                    } else {
                        $error = StudentTeacherLinkage::create(array(
                            'student_id' => $userm[0]->id,
                            'teacher_id' => $this->user->id,
                            'status' => 'pending',
                            'created' => date("Y-m-d H:i:s"),
                            'updated' => date("Y-m-d H:i:s"),
                        ));

                        redirect("teacher/addstudent/2");
                        die();
                    }
                } else {
                    redirect("teacher/addstudent/1");
                    die();
                }

            } else {
                redirect("teacher/addstudent");
                die();
            }
        }

        function pendingrequest($error = 0) {
            if(!isset($this->user->id)) {
                redirect("teacher");
                die();
            }

            $header['user'] = $body['user'] = $footer['user'] = $this->user;

            $pending_user = StudentTeacherLinkage::find("all",array(
                "conditions" => " teacher_id = '".$this->user->id."' AND ( status = 'pending' OR status = 'declined' ) ",
                "order" => "updated DESC"
            ));

            $body['pending_user'] = $pending_user;
            $this->loadtatemplate("teacher/pendingrequest",$header,$body,$footer);
        }

        function liststudents() {
            if(!isset($this->user->id)) {
                redirect("teacher");
                die();
            }

            $header['user'] = $body['user'] = $footer['user'] = $this->user;

            $accepted_user = StudentTeacherLinkage::find("all",array(
                "conditions" => " teacher_id = '".$this->user->id."' AND status = 'accepted' ",
                "order" => "updated DESC"
            ));

            $body['accepted_user'] = $accepted_user;
            $this->loadtatemplate("teacher/liststudents",$header,$body,$footer);
        }

        function viewstudentrecord($code = '') {
            if(!isset($this->user->id)) {
                redirect("teacher");
                die();
            }

            $userm_id = "";
            if($code != '') {
                $userm = User::find("all",array(
                    "conditions" => " MD5(id) = '$code' "
                ));
                if(isset($userm[0])) {

                    $accepted_user = StudentTeacherLinkage::find("all",array(
                        "conditions" => " teacher_id = '".$this->user->id."' AND student_id = '".$userm[0]->id."' AND status = 'accepted' ",
                        "order" => "updated DESC"
                    ));

                    if(isset($accepted_user[0])) {
                        $header['user'] = $body['user'] = $footer['user'] = $this->user;
                        $body['userm'] = $userm[0];
                        $data = UserActivity::find("all",array(
                            "conditions" => " user_id = '".$userm[0]->id."' ",
                            "order" => " updated DESC "
                        ));
                        $body['data'] = $data;

                        $activity_levels1 = ActivityLevel::find("all");
                        $activity_levels = array();

                        foreach($activity_levels1 as $val) {
                            $activity_levels[$val->level] = $val->title;
                        }
                        $body['activity_levels'] = $activity_levels;
                        $this->loadtatemplate("teacher/viewstudentrecord",$header,$body,$footer);
                    } else {
                        redirect("teacher/liststudents");
                        die();
                    }

                } else {
                    redirect("teacher/liststudents");
                    die();
                }

            } else {
                redirect("teacher/liststudents");
                die();
            }
        }

        function activitylist() {
            if(!isset($this->user->id)) {
                redirect("teacher");
                die();
            }

            $header['user'] = $body['user'] = $footer['user'] = $this->user;

            $activities = Activity::find("all",array(
                "conditions" => " delete_flag IS NULL OR delete_flag = 0 ",
                "order" => "challenge,level,activity_num   ASC"
            ));

            $body['activities'] = $activities;
            $this->loadtatemplate("teacher/activitylist",$header,$body,$footer);
        }

        function viewstudentrecordactivity($activity_id = '') {
            if(!isset($this->user->id)) {
                redirect("teacher");
                die();
            }

            $userm_id = "";
            if($activity_id != '') {
                $activity = Activity::find($activity_id);
                if(isset($activity->id)) {

                    $accepted_user = StudentTeacherLinkage::find("all",array(
                        "conditions" => " teacher_id = '".$this->user->id."' AND status = 'accepted' ",
                        "order" => "updated DESC"
                    ));

                    if(isset($accepted_user[0])) {
                        $ac = array();

                        foreach($accepted_user as $val) {
                            $ac[$val->student_id] = $val->student_id;
                        }

                        $header['user'] = $body['user'] = $footer['user'] = $this->user;

                        $data = UserActivity::find("all",array(
                            "conditions" => " user_id IN (".implode(",",$ac).") AND activity_id = '".$activity_id."' ",
                            "order" => " updated DESC "
                        ));
                        $body['data'] = $data;
                        $body['activity'] = $activity;

                        $this->loadtatemplate("teacher/viewstudentrecordactivity",$header,$body,$footer);
                    } else {
                        redirect("teacher/activitylist");
                        die();
                    }

                } else {
                    redirect("teacher/activitylist");
                    die();
                }

            } else {
                redirect("teacher/activitylist");
                die();
            }
        }
    }
?>