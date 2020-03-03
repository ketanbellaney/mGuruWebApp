<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    /*
	Class name  : Registration
	Description : Registration of the user for referral
	*/
    class Registrations extends MG_Controller {

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
    	Description     : Registration form
    	*/
        function index($refcode = '') {
            $body['refcode'] = $refcode;
            $this->loadtemplateblank("registration/index",array(),$body,array());
        }

        /*
    	Function name   : signupprocess()
    	Parameter       : none
    	Return          : none
    	Description     : Registration form processing
    	*/
        function signupprocess() {
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
                    'status' => 'active',
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
            }

            header("location: https://play.google.com/store/apps/details?id=com.mguru.english");
        }
    }
?>