<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    /*
	Class name  : API
	Description : Api for android app
	*/
    class Api extends MG_Controller {

        var $user = '';

        /*
	    Function name   : __construct()
    	Parameter       : none
    	Return          : none
    	Description     : Constructor  Called as soon as the class instance is created
    	*/
        function __construct() {
            parent::__construct();

            //! Get the current instance
            $this->ci =& get_instance();

            //! Retrive the session details
            $user_id = $this->session->userdata('_user_id');
            if($user_id != '') {
                //! If logedin retrieve the person details
                $this->user = User::find($user_id);
            }
        }

        /*
    	Function name   : index()
    	Parameter       : none
    	Return          : Redirect to home page
    	Description     : Do not require index page redirect to home page
    	*/
        function index() {
            redirect();
        }

        /*
    	Function name   : login()
    	Parameter       : none
    	Return          : json string
    	Description     : Used to verify user login
    	*/
        function login() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid username
            if(!isset($api_request->user->username)) {
                $response->message = array("Invalid username");
                die(json_encode($response));
            } else if($api_request->user->username == '') {
                $response->message = array("Invalid username");
                die(json_encode($response));
            }

            //! Check for valid password
            if(!isset($api_request->user->password)) {
                $response->message = array("Invalid password");
                die(json_encode($response));
            } else if($api_request->user->password == '') {
                $response->message = array("Invalid password");
                die(json_encode($response));
            }

            //! initialize the data
            $username = addslashes($api_request->user->username);
            $password = md5($api_request->user->password);

            //! Check the username/email and password
            $euser = User::find("all",array(
                "conditions" => " (email = '$username' OR username = '$username' ) AND password = '$password' "
            ));

            //! if valid email/username and password
            if(isset($euser[0])) {
                if($euser[0]->status == 'active') {
                    //! set data in json object
                    $response->success = true;
                    $response->message = array("Login Success");
                    $response->user = new stdClass;
                    $response->user->id = $euser[0]->id;
                    $response->user->username = $euser[0]->username;
                    $response->user->email = $euser[0]->email;
                    $response->user->mobile = $euser[0]->mobile;
                    $response->user->uid = $euser[0]->unique_id;
                    $response->user->current_class = $euser[0]->profile->current_class;

                    /// Profile combine

                    $date_of_birth = '';
                    if($euser[0]->profile->date_of_birth) {
                        $date_of_birth = $euser[0]->profile->date_of_birth->format("d/m/Y");
                    }
                    $response->user->date_of_birth = $date_of_birth;

                    $school_name = '';
                    if($euser[0]->profile->school) {
                        $school_name = $euser[0]->profile->school->name;
                    }
                    $response->user->school_name = $school_name;
                    $response->user->examination_board = $euser[0]->profile->examination_board;
                    $response->user->title = $euser[0]->profile->title;
                    $response->user->first_name = $euser[0]->profile->first_name;
                    $response->user->last_name = $euser[0]->profile->last_name;
                    $response->user->display_name = $euser[0]->profile->display_name;
                    $response->user->teacher_name = $euser[0]->profile->teacher_name;
                    $response->user->father_name = $euser[0]->profile->father_name;
                    $response->user->mother_name = $euser[0]->profile->mother_name;
                    $response->user->gender = $euser[0]->profile->gender;
                    $response->user->caste_religion = $euser[0]->profile->caste_religion;
                    $response->user->language_at_home = $euser[0]->profile->language_at_home;
                    $response->user->address_line_1 = $euser[0]->profile->address_line_1;
                    $response->user->address_line_2 = $euser[0]->profile->address_line_2;
                    $response->user->city = $euser[0]->profile->city;
                    $response->user->state = $euser[0]->profile->state;
                    $response->user->pincode = $euser[0]->profile->pincode;
                    $response->user->country = $euser[0]->profile->country;

                    ///

                    $expire_dt = date("Y-m-d", mktime(1,1,1,date("m"),date("d") + 14,date("Y")));

                    if($euser[0]->expire_date){
                        $expire_dt = $euser[0]->expire_date->format("Y-m-d");
                    } else {
                        $euser[0]->expire_date = $expire_dt;
                        $euser[0]->updated = date("Y-m-d H:i:s");
                        $euser[0]->save();
                    }

                    $response->user->expire_date = $expire_dt;
                    $response->user->referral_code = $euser[0]->user_referral_code->referral_code;

                    $profile_url = $euser[0]->profile->profile_photo();
                    $type = pathinfo($profile_url, PATHINFO_EXTENSION);
                    $data = file_get_contents($profile_url);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    $response->user->profile_picture = $base64;


                    $uref = UserReferred::find_by_user_id_and_credit_point_status($euser[0]->id,"no");

                      if(isset($uref->id)) {
                          $uref->credit_point_status = "yes";
                          $uref->credit_point_date_time = date("Y-m-d H:i:s");
                          $uref->updated = date("Y-m-d H:i:s");
                          $uref->save();

                          if(date("Ymd") >= $uref->referred_by->expire_date->format("Ymd")) {
                              $expire_date = date("Y-m-d",mktime(1,1,1,date("m"),date("d") + 14,date("Y")));
                          } else {
                              $expire_date = date("Y-m-d" , mktime(1,1,1,$uref->referred_by->expire_date->format("m"),$uref->referred_by->expire_date->format("d") + 14,$uref->referred_by->expire_date->format("Y")));
                          }

                          $uref->referred_by->expire_date = $expire_date;
                          $uref->referred_by->updated = date("Y-m-d H:i:s");
                          $uref->referred_by->save();

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

                      $uref_count = UserReferred::count(array(
                            "conditions" => " referred_by_id = '".$euser[0]->id."' AND credit_point_status = 'yes' "
                      ));

                      $additional_mango = 0;

                      if($uref_count > 0 ) {
                            $additional_mango = $uref_count * 400;
                      }

                      if($euser[0]->created->format("Ymd") >= 20160817) {
                            $additional_mango += 200;
                      }

                      $response->user->additional_mango = $additional_mango;

                    //! convert json object to string
                    die(json_encode($response));
                } else {

                    //! set data in json object
                    $response->success = false;
                    $response->message = array("Please activate your account");
                    $response->user = new stdClass;
                    $response->user->id = $euser[0]->id;
                    $response->user->username = $euser[0]->username;
                    $response->user->email = $euser[0]->email;
                    $response->user->mobile = $euser[0]->mobile;
                    $response->user->uid = $euser[0]->unique_id;
                    $response->user->current_class = $euser[0]->profile->current_class;

                    /// Profile combine

                    $date_of_birth = '';
                    if($euser[0]->profile->date_of_birth) {
                        $date_of_birth = $euser[0]->profile->date_of_birth->format("d/m/Y");
                    }
                    $response->user->date_of_birth = $date_of_birth;

                    $school_name = '';
                    if($euser[0]->profile->school) {
                        $school_name = $euser[0]->profile->school->name;
                    }
                    $response->user->school_name = $school_name;
                    $response->user->examination_board = $euser[0]->profile->examination_board;
                    $response->user->title = $euser[0]->profile->title;
                    $response->user->first_name = $euser[0]->profile->first_name;
                    $response->user->last_name = $euser[0]->profile->last_name;
                    $response->user->display_name = $euser[0]->profile->display_name;
                    $response->user->teacher_name = $euser[0]->profile->teacher_name;
                    $response->user->father_name = $euser[0]->profile->father_name;
                    $response->user->mother_name = $euser[0]->profile->mother_name;
                    $response->user->gender = $euser[0]->profile->gender;
                    $response->user->caste_religion = $euser[0]->profile->caste_religion;
                    $response->user->language_at_home = $euser[0]->profile->language_at_home;
                    $response->user->address_line_1 = $euser[0]->profile->address_line_1;
                    $response->user->address_line_2 = $euser[0]->profile->address_line_2;
                    $response->user->city = $euser[0]->profile->city;
                    $response->user->state = $euser[0]->profile->state;
                    $response->user->pincode = $euser[0]->profile->pincode;
                    $response->user->country = $euser[0]->profile->country;

                    ///

                    $expire_dt = date("Y-m-d", mktime(1,1,1,date("m") ,date("d") + 14,date("Y")));

                    if($euser[0]->expire_date){
                        $expire_dt = $euser[0]->expire_date->format("Y-m-d");
                    } else {
                        $euser[0]->expire_date = $expire_dt;
                        $euser[0]->updated = date("Y-m-d H:i:s");
                        $euser[0]->save();
                    }

                    $response->user->expire_date = $expire_dt;
                    $response->user->referral_code = $euser[0]->user_referral_code->referral_code;

                    $profile_url = $euser[0]->profile->profile_photo();
                    $type = pathinfo($profile_url, PATHINFO_EXTENSION);
                    $data = file_get_contents($profile_url);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    $response->user->profile_picture = $base64;

                    //! Send sms for the mobile verification
                    $merror = sendsms(1, $euser[0]->mobile, array($euser[0]->mobile_verification_code));

                    //! convert json object to string
                    die(json_encode($response));
                }
            } else {
                //! set data in json object
                $response->message = array("Invalid username / password.");
                //! convert json object to string
                die(json_encode($response));
            }
        }

        /*
    	Function name   : check_for_duplicate_email()
    	Parameter       : none
    	Return          : json string
    	Description     : Check for duplicate email
    	*/
        function check_for_duplicate_email() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid email
            if(!isset($api_request->user->email)) {
                $response->message = array("Invalid email");
                die(json_encode($response));
            } else if($api_request->user->email == '') {
                $response->message = array("Invalid email");
                die(json_encode($response));
            }

            //! initialize the data
            $email = addslashes($api_request->user->email);

            //! Check for duplicate email
            $euser = User::find("all",array(
                "conditions" => " email = '$email' "
            ));

            //! if email exists
            if(isset($euser[0])) {
                //! set data in json object
                $response->message = array("Email already exits!");
                //! convert json object to string
                die(json_encode($response));
            } else {
                //! set data in json object
                $response->success = true;
                $response->message = array("Email available");
                //! convert json object to string
                die(json_encode($response));
            }
        }

        /*
    	Function name   : check_for_duplicate_email_return()
    	Parameter       : $email - string - Email address
    	Return          : boolean true / false
    	Description     : Check for duplicate email
    	*/
        function check_for_duplicate_email_return($email = '') {

            //! Check for duplicate email
            $euser = User::find("all",array(
                "conditions" => " email = '$email' "
            ));

            //! if email exists
            if(isset($euser[0])) {
                return false;
            } else {
                return true;
            }
        }

        /*
    	Function name   : check_for_duplicate_mobile()
    	Parameter       : none
    	Return          : json string
    	Description     : Check for duplicate mobile
    	*/
        function check_for_duplicate_mobile() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid mobile
            if(!isset($api_request->user->mobile)) {
                $response->message = array("Invalid mobile");
                die(json_encode($response));
            } else if($api_request->user->mobile == '') {
                $response->message = array("Invalid mobile");
                die(json_encode($response));
            }

            //! initialize the data
            $mobile = addslashes($api_request->user->mobile);

            //! Check for duplicate mobile
            $euser = User::find("all",array(
                "conditions" => " mobile = '$mobile' "
            ));

            //! if mobile exists
            if(isset($euser[0])) {
                //! set data in json object
                $response->message = array("Mobile already exits!");
                //! convert json object to string
                die(json_encode($response));
            } else {
                //! set data in json object
                $response->success = true;
                $response->message = array("mobile available");
                //! convert json object to string
                die(json_encode($response));
            }
        }

        /*
    	Function name   : check_for_duplicate_mobile_return()
    	Parameter       : $mobile - string - Mobile Number
    	Return          : boolean true / false
    	Description     : Check for duplicate mobile
    	*/
        function check_for_duplicate_mobile_return($mobile = '') {

            //! Check for duplicate mobile
            $euser = User::find("all",array(
                "conditions" => " mobile = '$mobile' "
            ));

            //! if mobile exists
            if(isset($euser[0])) {
                return false;
            } else {
                return true;
            }
        }

        /*
    	Function name   : check_for_duplicate_username()
    	Parameter       : none
    	Return          : json string
    	Description     : Check for duplicate username
    	*/
        function check_for_duplicate_username() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid username
            if(!isset($api_request->user->username)) {
                $response->message = array("Invalid username");
                die(json_encode($response));
            } else if($api_request->user->username == '') {
                $response->message = array("Invalid username");
                die(json_encode($response));
            }

            //! initialize the data
            $username = addslashes($api_request->user->username);

            //! Check for duplicate username
            $euser = User::find("all",array(
                "conditions" => " username = '$username' "
            ));

            //! if username exists
            if(isset($euser[0])) {
                //! set data in json object
                $response->message = array("Username '".$api_request->user->username."' already in use, please select another username.");
                //! convert json object to string
                die(json_encode($response));
            } else {
                //! set data in json object
                $response->success = true;
                $response->message = array("Username available");
                //! convert json object to string
                die(json_encode($response));
            }
        }

        /*
    	Function name   : check_for_duplicate_username_return()
    	Parameter       : $username - string - Username
    	Return          : boolean true / false
    	Description     : Check for duplicate username
    	*/
        function check_for_duplicate_username_return($username = '') {

            //! Check for duplicate username
            $euser = User::find("all",array(
                "conditions" => " username = '$username' "
            ));

            //! if username exists
            if(isset($euser[0])) {
                return false;
            } else {
                return true;
            }
        }

        /*
    	Function name   : register()
    	Parameter       : none
    	Return          : json string
    	Description     : Register a new user
    	*/
        function register() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid username
            if(!isset($api_request->user->username)) {
                $response->message = array("Invalid username");
                die(json_encode($response));
            } else if($api_request->user->username == '') {
                $response->message = array("Invalid username");
                die(json_encode($response));
            }

            //! Check for duplicate username
            $euser = User::find("all",array(
                "conditions" => " username = '".$api_request->user->username."' "
            ));

            //! if username exists
            if(isset($euser[0])) {
                //if($euser[0]->status == "active") {
                    $response->message = array("Username '".$api_request->user->username."' already in use, please select another username.");
                    die(json_encode($response));
               // } else {
//
//                    $expire_dt = date("Y-m-d", mktime(1,1,1,date("m"),date("d") + 14,date("Y")));
//
//                    if($euser[0]->expire_date){
//                        $expire_dt = $euser[0]->expire_date->format("Y-m-d");
//                    } else {
//                        $euser[0]->expire_date = $expire_dt;
//                        $euser[0]->updated = date("Y-m-d H:i:s");
//                        $euser[0]->save();
//                    }
//
//                    //! set data in json object
//                    $response->success = true;
//                    $response->id = $euser[0]->id;
//                    $response->uid = $euser[0]->unique_id;
//                    $response->mobile = $euser[0]->mobile;
//                    $response->expire_date = $expire_dt;
//                    $response->referral_code = $euser[0]->user_referral_code->referral_code;
//                    $response->message = array("Registration Success");
//
//                    //! Send sms for the mobile verification
//                    $merror = sendsms(1, $euser[0]->mobile, array($euser[0]->mobile_verification_code));
//
//                    //! convert json object to string
//                    die(json_encode($response));
//                }
            }


            //! Check for valid email
            /*if(!isset($api_request->user->email)) {
                $response->message = array("Invalid email");
                die(json_encode($response));
            } else if($api_request->user->email == '') {
                $response->message = array("Invalid email");
                die(json_encode($response));
            }*/

            //! Check for valid mobile
            //if(!isset($api_request->user->mobile)) {
//                $response->message = array("Invalid mobile");
//                die(json_encode($response));
//            } else if($api_request->user->mobile == '') {
//                $response->message = array("Invalid mobile");
//                die(json_encode($response));
//            }

            //! Check for valid password
            if(!isset($api_request->user->password)) {
                $response->message = array("Invalid password");
                die(json_encode($response));
            } else if($api_request->user->password == '') {
                $response->message = array("Invalid password");
                die(json_encode($response));
            }

            /*if(!isset($api_request->user->device_id)) {
                $response->message = array("Invalid Device ID");
                die(json_encode($response));
            } else if($api_request->user->device_id == '') {
                $response->message = array("Invalid Device ID");
                die(json_encode($response));
            }*/

            //! initialize the data
            $mobile = '';
            $current_class = '';
            $username = addslashes($api_request->user->username);
            $email = addslashes($api_request->user->email);
            if(isset($api_request->user->mobile))
                $mobile = addslashes($api_request->user->mobile);
            if(isset($api_request->user->current_class))
                $current_class = addslashes($api_request->user->current_class);
            $password = md5($api_request->user->password);

            //! Generate unique id
            $uid = md5(date("Y-m-d H:i:s") . $username);

            //! Mobile verification code
            $mcode = rand(1000,9999);

            $expire_dt = date("Y-m-d" , mktime(1,1,1,date("m"),date("d") + 14,date("Y")));

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
                'expire_date' => $expire_dt,
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
                    'current_class' => $current_class,
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

                $sd = UserDevice::create("all",array(
                    "user_id" => $new_user->id,
                    "device_code" => @$api_request->user->device_id,
                    "status" => "active",
                    "created" => date("Y-m-d H:i:s"),
                    "updated" => date("Y-m-d H:i:s"),
                ));

                //! set data in json object
                $response->success = true;
                $response->id = $new_user->id;
                $response->uid = $uid;
                $response->mobile = $mobile;
                $response->expire_date = $expire_dt;
                $response->referral_code = $new_user->user_referral_code->referral_code;
                $response->message = array("Registration Success");
                $response->additional_mango = 200;

                //! Send sms for the mobile verification
                //$merror = sendsms(1, $mobile, array($mcode));

                //! convert json object to string
                die(json_encode($response));
            }
            //! set data in json object
            $response->message = array("Invalid Input");
            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : resendotp()
    	Parameter       : none
    	Return          : json string
    	Description     : Resend the otp
    	*/
        function resendotp() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

           //! Check for valid user id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user");
                die(json_encode($response));
            } else {
                if($user->status == 'active') {
                    //! set data in json object
                    $response->success = false;
                    $response->message = array("You have already activated your account, please login.");

                    //! convert json object to string
                    die(json_encode($response));
                } else {
                    //! set data in json object
                    $response->success = true;
                    $response->message = array("OTP sent to your registered mobile number " . $user->mobile);
                    $response->user = new stdClass;
                    $response->user->id = $user->id;
                    $response->user->username = $user->username;
                    $response->user->email = $user->email;
                    $response->user->mobile = $user->mobile;
                    $response->user->uid = $user->unique_id;

                    $expire_dt = date("Y-m-d", mktime(1,1,1,date("m"),date("d") + 14,date("Y")));

                    if($user->expire_date){
                        $expire_dt = $user->expire_date->format("Y-m-d");
                    } else {
                        $user->expire_date = $expire_dt;
                        $user->updated = date("Y-m-d H:i:s");
                        $user->save();
                    }

                    $response->user->expire_date = $expire_dt;
                    $response->user->referral_code = $user->user_referral_code->referral_code;

                    //! Send sms for the mobile verification
                    $merror = sendsms(1, $user->mobile, array($user->mobile_verification_code));

                    //! convert json object to string
                    die(json_encode($response));
                }
            }
        }

        /*
    	Function name   : getpremiumdate()
    	Parameter       : none
    	Return          : json string
    	Description     : get premium date
    	*/
        function getpremiumdate() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

           //! Check for valid user id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user");
                die(json_encode($response));
            } else {

                $response->success = true;
                $response->message = array("Premium date available");

                $response->user = new stdClass;
                $response->user->id = $user->id;
                $response->user->uid = $user->unique_id;

                $expire_dt = date("Y-m-d", mktime(1,1,1,date("m"),date("d") + 14,date("Y")));

                if($user->expire_date){
                    $expire_dt = $user->expire_date->format("Y-m-d");
                } else {
                    $user->expire_date = $expire_dt;
                    $user->updated = date("Y-m-d H:i:s");
                    $user->save();
                }

                $response->user->expire_date = $expire_dt;
                $response->user->referral_code = $user->user_referral_code->referral_code;

                //! Refered users
                $uref_count = UserReferred::count(array(
                    "conditions" => " referred_by_id = '".$user->id."' AND credit_point_status = 'yes' "
                ));

                $additional_mango = 0;

                //! Additional mangoes
                if($uref_count > 0 ) {
                    $additional_mango = $uref_count * 400;
                }

                if($user->created->format("Ymd") >= 20160817) {
                    $additional_mango += 200;
                }

                $response->user->additional_mango = $additional_mango;

                //! convert json object to string
                die(json_encode($response));
            }
        }

        /*
    	Function name   : forgotpassword()
    	Parameter       : none
    	Return          : json string
    	Description     : Register a new user
    	*/
        function forgotpassword() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid username
            if(!isset($api_request->user->username)) {
                $response->message = array("Invalid username.");
                die(json_encode($response));
            } else if($api_request->user->username == '') {
                $response->message = array("Invalid username.");
                die(json_encode($response));
            } else {
                $type = 'username';
                //! Find user by username
                $euser = User::find_by_username($api_request->user->username);
            }

            //! if valid username / email / mobile
            if(isset($euser->id)) {
                //! check for password_verification_code
                if($euser->password_verification_code == '') {
                    //! Generate random 6 character password_verification_code
                    $password_verification_code = create_random_alphanumeric_string(6);
                    //! Set it in the database
                    $euser->password_verification_code = $password_verification_code;
                    $euser->save();
                } else {
                    $password_verification_code = $euser->password_verification_code;
                }

                //! Retrieve the email template for forgot password
                $email_content = get_email_template(0);
                $subject = $email_content['subject'];
                $body = $email_content['body'];
                $body = str_replace('::name::',ucwords($euser->name()),$body);
                $body = str_replace('::forgorpassword_code::',$password_verification_code,$body);
                $this->email_template($euser->email,$subject,$body);

                //! set data in json object
                $response->success = true;
                $response->message = array("Reset password code sent to email");
                //! convert json object to string
                die(json_encode($response));
            } else {
                //! set data in json object
                $response->message = array("Invalid username / password.");
                //! convert json object to string
                die(json_encode($response));
            }
        }

        /*
    	Function name   : forgotpassword()
    	Parameter       : none
    	Return          : json string
    	Description     : Register a new user
    	*/
        function forgotpasswordnew() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid username
            if(!isset($api_request->user->username)) {
                $response->message = array("Invalid username.");
                die(json_encode($response));
            } else if($api_request->user->username == '') {
                $response->message = array("Invalid username.");
                die(json_encode($response));
            }

            $username = $api_request->user->username;
            //$username = 'ketanbb';
            $type = 'username';
            //! Find user by username
            $euser = User::find_by_username($username);


            //! if valid username / email / mobile
            if(isset($euser->id)) {

                if($euser->mobile != '') {
                    //! check for password_verification_code
                    if($euser->password_verification_code == '') {
                        //! Generate random 6 character password_verification_code
                        $password_verification_code = create_random_alphanumeric_string(6);
                        //! Set it in the database
                        $euser->password_verification_code = $password_verification_code;
                        $euser->save();
                    } else {
                        $password_verification_code = $euser->password_verification_code;
                    }

                    $url_new = site_url("api/resetpassword/" . urlencode($username));

                    require_once('bitly/bitly.php');

                    $client_id = '2c448c55f1f87dfa2a4f6c30de1ab524f47b6982';
                    $client_secret = '97ca680fe45ea4c79aca8ecabc57661a148c474c';
                    $user_access_token = '2e9068688b7ac869b8747599117ca69bb5da68cf';
                    $user_login = 'ketanmguru';
                    //$user_api_key = '2e9068688b7ac869b8747599117ca69bb5da68cf';

                    $params = array();
                    $params['access_token'] = $user_access_token;
                    $params['longUrl'] = $url_new;
                    $params['title'] = $username . " reset";
                    $results = bitly_get('shorten', $params);

                    $short_url =  $results['data']['url'];

                    //! Send sms for the mobile verification
                    $merror = sendsms(9, $euser->mobile, array($euser->username,$short_url));

                    //! set data in json object
                    $response->success = true;
                    $response->message = array("Reset link sent to mobile");

                    die(json_encode($response));
                } else {
                    //! set data in json object
                    $response->message = array("Invalid mobile number.");
                    //! convert json object to string
                    die(json_encode($response));
                }
                //! convert json object to string

            } else {
                //! set data in json object
                $response->message = array("Invalid username.");
                //! convert json object to string
                die(json_encode($response));
            }
        }

        function resetpassword($username = "") {
            if(trim($username) == "") {
                echo "<a href='intent://home/#Intent;scheme=mguru;package=com.mguru.english;S.browser_fallback_url=market://;end' id='clickTarget'>Click here</a>
                <script type='text/javascript'>
                    window.onload = function() {
                    var clickTarget = document.getElementById('clickTarget');
                    var fakeMouseEvent = document.createEvent('MouseEvents');
                    fakeMouseEvent.initMouseEvent('click', true, true, window, 0, 0, 0, 20, 10, false, false, false, false, 0, null);
                    clickTarget.dispatchEvent(fakeMouseEvent);
                };
                </script>";
                die();
            } else {
                $euser = User::find_by_username(urldecode($username));
                if(isset($euser->id)) {
                    if($euser->password_verification_code == '') {
                        echo "<a href='intent://home/#Intent;scheme=mguru;package=com.mguru.english;S.browser_fallback_url=market://;end' id='clickTarget'>Click here</a>
                          <script type='text/javascript'>
                              window.onload = function() {
                              var clickTarget = document.getElementById('clickTarget');
                              var fakeMouseEvent = document.createEvent('MouseEvents');
                              fakeMouseEvent.initMouseEvent('click', true, true, window, 0, 0, 0, 20, 10, false, false, false, false, 0, null);
                              clickTarget.dispatchEvent(fakeMouseEvent);
                          };
                          </script>";
                          die();
                    } else {
                        echo "<a href='intent://resetpassword/#Intent;scheme=mguru;package=com.mguru.english;S.browser_fallback_url=market://;S.username=".urlencode($euser->username).";end' id='clickTarget'>Click here</a>
                          <script type='text/javascript'>
                              window.onload = function() {
                              var clickTarget = document.getElementById('clickTarget');
                              var fakeMouseEvent = document.createEvent('MouseEvents');
                              fakeMouseEvent.initMouseEvent('click', true, true, window, 0, 0, 0, 20, 10, false, false, false, false, 0, null);
                              clickTarget.dispatchEvent(fakeMouseEvent);
                          };
                          </script>";
                          die();
                    }

                } else {
                    echo "<a href='intent://home/#Intent;scheme=mguru;package=com.mguru.english;S.browser_fallback_url=market://;end' id='clickTarget'>Click here</a>
                      <script type='text/javascript'>
                          window.onload = function() {
                          var clickTarget = document.getElementById('clickTarget');
                          var fakeMouseEvent = document.createEvent('MouseEvents');
                          fakeMouseEvent.initMouseEvent('click', true, true, window, 0, 0, 0, 20, 10, false, false, false, false, 0, null);
                          clickTarget.dispatchEvent(fakeMouseEvent);
                      };
                      </script>";
                      die();
                }
            }
        }

        /*
    	Function name   : changepassword()
    	Parameter       : none
    	Return          : json string
    	Description     : Change the password
    	*/
        function changepassword() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid unique id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid user");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid user");
                die(json_encode($response));
            }

            //! Check for valid old password
            if(!isset($api_request->user->oldpassword)) {
                $response->message = array("Invalid old password");
                die(json_encode($response));
            } else if($api_request->user->oldpassword == '') {
                $response->message = array("Invalid old password");
                die(json_encode($response));
            }

            //! Check for valid new password
            if(!isset($api_request->user->newpassword)) {
                $response->message = array("Invalid new password");
                die(json_encode($response));
            } else if($api_request->user->newpassword == '') {
                $response->message = array("Invalid new password");
                die(json_encode($response));
            }

            //! Check for valid confirm password
            if(!isset($api_request->user->newconfirmpassword)) {
                $response->message = array("Invalid new confirm password");
                die(json_encode($response));
            } else if($api_request->user->newconfirmpassword == '') {
                $response->message = array("Invalid new confirm password");
                die(json_encode($response));
            }

            //! match the password and the confirm password
            if( $api_request->user->newconfirmpassword != $api_request->user->newpassword) {
                $response->message = array("Invalid confirm password did not match.");
                die(json_encode($response));
            }

            //! initialize the data
            $uid = addslashes($api_request->user->uid);
            $password = md5($api_request->user->oldpassword);
            $newpassword = md5($api_request->user->newpassword);

            //! Find the user with matching unique id  and the password
            $euser = User::find_by_unique_id_and_password($uid,$password);

            //! if valid user
            if(isset($euser->id)) {
                //! Change the password to new password
                $euser->password = $newpassword;
                $euser->save();
                //! set data in json object
                $response->success = true;
                $response->message = array("Password changed successfully");
                //! convert json object to string
                die(json_encode($response));
            } else {
                //! set data in json object
                $response->message = array("Invalid user.");
                //! convert json object to string
                die(json_encode($response));
            }
        }

        /*
    	Function name   : changepasswordbycode()
    	Parameter       : none
    	Return          : json string
    	Description     : Change the password
    	*/
        function changepasswordbycode() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid code
            if(!isset($api_request->user->code)) {
                $response->message = array("Invalid password reset code");
                die(json_encode($response));
            } else if($api_request->user->code == '') {
                $response->message = array("Invalid password reset code");
                die(json_encode($response));
            }

            //! Check for valid new password
            if(!isset($api_request->user->newpassword)) {
                $response->message = array("Invalid new password");
                die(json_encode($response));
            } else if($api_request->user->newpassword == '') {
                $response->message = array("Invalid new password");
                die(json_encode($response));
            }

            //! Check for valid confirm password
            if(!isset($api_request->user->newconfirmpassword)) {
                $response->message = array("Invalid new confirm password");
                die(json_encode($response));
            } else if($api_request->user->newconfirmpassword == '') {
                $response->message = array("Invalid new confirm password");
                die(json_encode($response));
            }

            //! match the password and the confirm password
            if( $api_request->user->newconfirmpassword != $api_request->user->newpassword) {
                $response->message = array("Invalid confirm password did not match.");
                die(json_encode($response));
            }

            //! initialize the data
            $code = addslashes($api_request->user->code);
            $newpassword = md5($api_request->user->newpassword);

            //! Find the user by password_verification_code ( which was sent to their email
            $euser = User::find_by_password_verification_code($code);

            //! if valid user
            if(isset($euser->id)) {
                //! Change the password to new password
                $euser->password = $newpassword;
                $euser->save();
                //! set data in json object
                $response->success = true;
                $response->message = array("Password changed successfully");
                //! convert json object to string
                die(json_encode($response));
            } else {
                //! set data in json object
                $response->message = array("Invalid password reset code.");
                //! convert json object to string
                die(json_encode($response));
            }
        }

        /*
    	Function name   : changepasswordbyusername()
    	Parameter       : none
    	Return          : json string
    	Description     : Change the password
    	*/
        function changepasswordbyusername() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid code
            if(!isset($api_request->user->username)) {
                $response->message = array("Invalid username");
                die(json_encode($response));
            } else if($api_request->user->username == '') {
                $response->message = array("Invalid username");
                die(json_encode($response));
            }

            //! Check for valid new password
            if(!isset($api_request->user->newpassword)) {
                $response->message = array("Invalid new password");
                die(json_encode($response));
            } else if($api_request->user->newpassword == '') {
                $response->message = array("Invalid new password");
                die(json_encode($response));
            }

            //! Check for valid confirm password
            if(!isset($api_request->user->newconfirmpassword)) {
                $response->message = array("Invalid new confirm password");
                die(json_encode($response));
            } else if($api_request->user->newconfirmpassword == '') {
                $response->message = array("Invalid new confirm password");
                die(json_encode($response));
            }

            //! match the password and the confirm password
            if( $api_request->user->newconfirmpassword != $api_request->user->newpassword) {
                $response->message = array("Invalid confirm password did not match.");
                die(json_encode($response));
            }

            //! initialize the data
            $username = addslashes($api_request->user->username);
            $newpassword = md5($api_request->user->newpassword);

            //! Find the user by password_verification_code ( which was sent to their email
            $euser = User::find_by_username($username);

            //! if valid user
            if(isset($euser->id)) {
                //! Change the password to new password
                $euser->password = $newpassword;
                $euser->password_verification_code = '';
                $euser->save();
                //! set data in json object
                $response->success = true;
                $response->message = array("Password changed successfully");
                //! convert json object to string
                die(json_encode($response));
            } else {
                //! set data in json object
                $response->message = array("Invalid password reset code.");
                //! convert json object to string
                die(json_encode($response));
            }
        }

        /*
    	Function name   : updateprofile()
    	Parameter       : none
    	Return          : json string
    	Description     : Update user profile
    	*/
        function updateprofile() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Update user profile data
            if(isset($api_request->user->email))
                $user->email = @$api_request->user->email;
            if(isset($api_request->user->mobile))
                $user->mobile = @$api_request->user->mobile;
            $user->updated = date("Y-m-d H:i:s");
            $user->save();

            //! Update profile_picture
            if(isset($api_request->user->profile_picture)) {
                if(@$api_request->user->profile_picture != '') {
                    //! Get Extension
                    $extension = 'jpg';
                    if(strpos( @$api_request->user->profile_picture , 'png;base64') !== false) {
                        $extension = 'png';
                    }
                    //! Generate the filename
                    $filename = md5(date('Y-m-d H:i:s U' . rand(0,9999999))) . "." . $extension;
                    $data = explode(',', @$api_request->user->profile_picture);

                    //! Store the file
                    file_put_contents($this->config->item("root_url") . "user/photo/" . $filename, base64_decode($data[1]));
                    //file_put_contents($this->config->item("root_url") . "user/photo/" . $filename . "1", @$api_request->user->profile_picture);
                    $user->profile->profile_picture = $filename;
                }
            }

            //! Date of birth
            if(isset($api_request->user->date_of_birth)) {
                $date_of_birth = '';
                if(@$api_request->user->date_of_birth != '') {
                    $temp = explode("/",@$api_request->user->date_of_birth);
                    if(isset($temp[2])) {
                        $date_of_birth = $temp[2] . "-" . $temp[1] . "-" . $temp[0];
                    }
                }
                $user->profile->date_of_birth = $date_of_birth;
            }

            //! School
            if(isset($api_request->user->school_name)) {
                $school_id = '';
                if(@$api_request->user->school_name != '') {
                    //! Check if the school exists
                    $check_school = School::find_by_name(@$api_request->user->school_name);
                    if(isset($check_school->id)) {
                        //! if exisits retrieve its id
                        $school_id = $check_school->id;
                    } else {
                        //! Else create a new school in database
                        $new_school = School::create(array(
                            'name' => @$api_request->user->school_name,
                            'school_type' => '',
                            'principal' => '',
                            'address_line_1' => '',
                            'address_line_2' => '',
                            'city' => '',
                            'state' => '',
                            'pincode' => '',
                            'country' => '',
                            'contact_person' => '',
                            'contact_number' => '',
                            'contact_email' => '',
                            'created' => date("Y-m-d H:i:s"),
                            'updated' => date("Y-m-d H:i:s"),
                        ));

                        if(isset($new_school->id)) {
                            $school_id = $new_school->id;
                        }
                    }
                }
                $user->profile->school_id = $school_id;
            }

            if(isset($api_request->user->title))
                $user->profile->title = @$api_request->user->title;
            if(isset($api_request->user->first_name))
                $user->profile->first_name = @$api_request->user->first_name;
            if(isset($api_request->user->last_name))
                $user->profile->last_name = @$api_request->user->last_name;
            if(isset($api_request->user->display_name))
                $user->profile->display_name = @$api_request->user->display_name;
            if(isset($api_request->user->teacher_name))
                $user->profile->teacher_name = @$api_request->user->teacher_name;
            if(isset($api_request->user->father_name))
                $user->profile->father_name = @$api_request->user->father_name;
            if(isset($api_request->user->mother_name))
                $user->profile->mother_name = @$api_request->user->mother_name;
            if(isset($api_request->user->gender))
                $user->profile->gender = @$api_request->user->gender;
            if(isset($api_request->user->current_class))
                $user->profile->current_class = @$api_request->user->current_class;
            if(isset($api_request->user->caste_religion))
                $user->profile->caste_religion = @$api_request->user->caste_religion;
            if(isset($api_request->user->language_at_home))
                $user->profile->language_at_home = @$api_request->user->language_at_home;
            if(isset($api_request->user->address_line_1))
                $user->profile->address_line_1 = @$api_request->user->address_line_1;
            if(isset($api_request->user->address_line_2))
                $user->profile->address_line_2 = @$api_request->user->address_line_2;
            if(isset($api_request->user->city))
                $user->profile->city = @$api_request->user->city;
            if(isset($api_request->user->state))
                $user->profile->state = @$api_request->user->state;
            if(isset($api_request->user->pincode))
                $user->profile->pincode = @$api_request->user->pincode;
            if(isset($api_request->user->country))
                $user->profile->country = @$api_request->user->country;
            if(isset($api_request->user->examination_board))
                $user->profile->examination_board = @$api_request->user->examination_board;
            
            $user->profile->updated = date("Y-m-d H:i:s");
            $user->profile->save();

            //! set data in json object
            $response->success = true;
            $response->message = array("Profile updated successfully");
            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : verifymobilecode()
    	Parameter       : none
    	Return          : json string
    	Description     : Verify mobile code
    	*/
        function verifymobilecode() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Check for valid mobile number
            if(!isset($api_request->user->mobile)) {
                $response->message = array("Invalid mobile");
                die(json_encode($response));
            } else if($api_request->user->mobile == '') {
                $response->message = array("Invalid mobile");
                die(json_encode($response));
            }

            //! Check for valid mobile code
            if(!isset($api_request->user->mobile_code)) {
                $response->message = array("Invalid mobile code");
                die(json_encode($response));
            } else if($api_request->user->mobile_code == '') {
                $response->message = array("Invalid mobile code");
                die(json_encode($response));
            }

            //! Find the user
            $user = User::find_by_id_and_unique_id_and_mobile_and_mobile_verification_code($api_request->user->id,$api_request->user->uid,$api_request->user->mobile,$api_request->user->mobile_code);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user");
                die(json_encode($response));
            }

            //! Mobile number verified
            $user->mobile_verified = 1;
            $user->status = "active";
            $user->save();

            //! set data in json object
            $response->success = true;
            $response->message = array("Mobile number verified successfully");
            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : getprofile()
    	Parameter       : none
    	Return          : json string
    	Description     : get user profile data
    	*/
        function getprofile() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Setting user data in json object
            $response->user = new stdClass;
            $response->user->email = $user->email;
            $response->user->mobile = $user->mobile;

            //! Fetching the image and converting it into base 64 format
            $profile_url = $user->profile->profile_photo();
            $type = pathinfo($profile_url, PATHINFO_EXTENSION);
            $data = file_get_contents($profile_url);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

            $response->user->profile_picture = $base64;

            $date_of_birth = '';
            if($user->profile->date_of_birth) {
                $date_of_birth = $user->profile->date_of_birth->format("d/m/Y");
            }
            $response->user->date_of_birth = $date_of_birth;

            $school_name = '';
            if($user->profile->school) {
                $school_name = $user->profile->school->name;
            }
            $response->user->school_name = $school_name;
            $response->user->examination_board = $user->profile->examination_board;
            $response->user->title = $user->profile->title;
            $response->user->first_name = $user->profile->first_name;
            $response->user->last_name = $user->profile->last_name;
            $response->user->display_name = $user->profile->display_name;
            $response->user->teacher_name = $user->profile->teacher_name;
            $response->user->father_name = $user->profile->father_name;
            $response->user->mother_name = $user->profile->mother_name;
            $response->user->gender = $user->profile->gender;
            $response->user->current_class = $user->profile->current_class;
            $response->user->caste_religion = $user->profile->caste_religion;
            $response->user->language_at_home = $user->profile->language_at_home;
            $response->user->address_line_1 = $user->profile->address_line_1;
            $response->user->address_line_2 = $user->profile->address_line_2;
            $response->user->city = $user->profile->city;
            $response->user->state = $user->profile->state;
            $response->user->pincode = $user->profile->pincode;
            $response->user->country = $user->profile->country;
            $response->success = true;
            $response->message = array("Profile data");

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : getsubjectsforclass()
    	Parameter       : none
    	Return          : json string
    	Description     : get subjects for the class provided
    	*/
        function getsubjectsforclass() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Check for valid class
            if(!isset($api_request->user->class)) {
                $response->message = array("Invalid class");
                die(json_encode($response));
            } else if($api_request->user->class == '') {
                $response->message = array("Invalid class");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Find the sibjectfor the class provided
            $classes = Classes::find_by_name($api_request->user->class);

            //! Check if a valid class
            if(!isset($classes->id)) {
                $response->message = array("Invalid class");
                die(json_encode($response));
            }

            //! Setting subject data in json object
            $response->class_id = $classes->id;
            $response->class = $classes->name;
            $response->subjects = array();

            //! Loop through all the subjects
            foreach( $classes->class_subject_linkage as $val ) {
                //! Get current concept for that subject
                $current_concept = Answer::find("all",array(
                    "conditions" => " user_id = '".$api_request->user->id."' AND subject_id = '".$val->subject_id."' ",
                    "order" => " answered_dtm DESC",
                    "offset" => "0",
                    "limit" => "1",
                ));
                $learn_current_concept_id = '';
                $learn_current_concept_name = '';
                $learn_current_score = 0;
                if(isset($current_concept[0])) {
                    $learn_current_concept_id = $current_concept[0]->concepts_id;
                    $learn_current_concept_name = $current_concept[0]->concept->name;
                }

                //! Get the subject score
                $current_score = Answer::find("all",array(
                    "select" => "SUM(score) as currentscore",
                    "conditions" => " user_id = '".$api_request->user->id."' AND subject_id = '".$val->subject_id."' ",
                ));
                if(isset($current_score[0])) {
                    $learn_current_score = $current_score[0]->currentscore;
                }

                $subject = new stdClass;
                $subject->id = $val->subject_id;
                $subject->name = $val->subject->name;
                $subject->current_concept_id = $learn_current_concept_id;
                $subject->current_concept_name = $learn_current_concept_name;
                $subject->subject_score = $learn_current_score;
                $response->subjects[] = $subject;
            }

            $response->success = true;
            $response->message = array("Subject retrieved");

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : getunitsforclasssubject()
    	Parameter       : none
    	Return          : json string
    	Description     : get units for the class and subject provided
    	*/
        function getunitsforclasssubject() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Check for valid class_id
            if(!isset($api_request->user->class_id)) {
                $response->message = array("Invalid class");
                die(json_encode($response));
            } else if($api_request->user->class_id == '') {
                $response->message = array("Invalid class");
                die(json_encode($response));
            }

            //! Check for valid subject_id
            if(!isset($api_request->user->subject_id)) {
                $response->message = array("Invalid subject");
                die(json_encode($response));
            } else if($api_request->user->subject_id == '') {
                $response->message = array("Invalid subject");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Find the class
            $classes = Classes::find($api_request->user->class_id);

            //! Check if a valid class
            if(!isset($classes->id)) {
                $response->message = array("Invalid class");
                die(json_encode($response));
            }

            //! Find the subject
            $subject = Subject::find($api_request->user->subject_id);

            //! Check if a valid subject
            if(!isset($subject->id)) {
                $response->message = array("Invalid subject");
                die(json_encode($response));
            }

            //! Find all units
            $units = Units::find_all_by_classes_id_and_subject_id($classes->id,$subject->id);

            //! Check if a valid class
            if(!isset($units[0])) {
                $response->message = array("No Units");
                die(json_encode($response));
            }

            //! Setting units data in json object
            $response->class = $classes->name;
            $response->class_id = $classes->id;
            $response->subject = $subject->name;
            $response->subject_id = $subject->id;
            $response->units = array();

            //! Loop through all the units
            foreach( $units as $val ) {
                $unit = new stdClass;
                $unit->id = $val->id;
                $unit->name = $val->name;
                $response->units[] = $unit;
            }

            $response->success = true;
            $response->message = array("Units retrieved");

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : getconceptsforunitid()
    	Parameter       : none
    	Return          : json string
    	Description     : get concepts for the unit id provided provided
    	*/
        function getconceptsforunitid() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Check for valid unit_id
            if(!isset($api_request->user->unit_id)) {
                $response->message = array("Invalid unit");
                die(json_encode($response));
            } else if($api_request->user->unit_id == '') {
                $response->message = array("Invalid unit");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Find the unit
            $unit = Units::find($api_request->user->unit_id);

            //! Check if a valid class
            if(!isset($unit->id)) {
                $response->message = array("Invalid unit");
                die(json_encode($response));
            }

            //! Find all concepts
            $concepts = Concept::find_all_by_units_id($unit->id);

            //! Check if a valid class
            if(!isset($concepts[0])) {
                $response->message = array("No Concept");
                die(json_encode($response));
            }

            //! Setting concepts data in json object
            $response->class = $unit->classes->name;
            $response->class_id = $unit->classes_id;
            $response->subject = $unit->subject->name;
            $response->subject_id = $unit->subject_id;
            $response->unit = $unit->name;
            $response->unit_id = $unit->id;
            $response->concepts = array();

            //! Loop through all the concepts
            foreach( $concepts as $val ) {
                $concept = new stdClass;
                $concept->id = $val->id;
                $concept->name = $val->name;

                if($val->next_concept_id != 0 && $val->next_concept_id != '') {
                    $concept->next_concept = $val->next_concept->name;
                    $concept->next_concept_id = $val->next_concept_id;
                } else {
                    $concept->next_concept = '';
                    $concept->next_concept_id = '';
                }
                if($val->previous_concept_id != 0 && $val->previous_concept_id != '') {
                    $concept->previous_concept = $val->previous_concept->name;
                    $concept->previous_concept_id = $val->previous_concept_id;
                } else {
                    $concept->previous_concept = '';
                    $concept->previous_concept_id = '';
                }
                if($val->lower_concept_id != 0 && $val->lower_concept_id != '') {
                    $concept->lower_concept = $val->lower_concept->name;
                    $concept->lower_concept_id = $val->lower_concept_id;
                } else {
                    $concept->lower_concept = '';
                    $concept->lower_concept_id = '';
                }
                if($val->higher_concept_id != 0 && $val->higher_concept_id != '') {
                    $concept->higher_concept = $val->higher_concept->name;
                    $concept->higher_concept_id = $val->higher_concept_id;
                } else {
                    $concept->higher_concept = '';
                    $concept->higher_concept_id = '';
                }
                $response->concepts[] = $concept;
            }

            $response->success = true;
            $response->message = array("Concepts retrieved");

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : getstorydetailsforstoryid()
    	Parameter       : none
    	Return          : json string
    	Description     : get story details for the story id provided
    	*/
        function getstorydetailsforstoryid() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Check for valid story_id
            if(!isset($api_request->story_id)) {
                $response->message = array("Invalid story id");
                die(json_encode($response));
            } else if($api_request->story_id == '') {
                $response->message = array("Invalid story id");
                die(json_encode($response));
            }

            /*//! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user");
                die(json_encode($response));
            }*/

            //! Check if the file exists
            if(file_exists($this->config->item("root_url") . "story/story_" . $api_request->story_id . ".json")) {
            //if(file_exists("story/story_" . $api_request->story_id . ".json")) {
                $key = pack('H*', "bcb04b7e103a0cd8b54763089a7c08bc55abe029fdebae5e1d417e2ffb2a00a3");
                $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
                $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

                $storyenc = file_get_contents($this->config->item("root_url") . "story/story_" . $api_request->story_id . ".json");
                //$storyenc = file_get_contents("story/story_" . $api_request->story_id . ".json");

                $storydec = base64_decode($storyenc);
                $iv_dec = substr($storydec, 0, $iv_size);
                $storydec = substr($storydec, $iv_size);
                $storydec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $storydec, MCRYPT_MODE_CBC, $iv_dec);

                $response = json_decode(trim($storydec));
                $response->success = true;
                $response->message = array("Story retrieved");

                //!check the user story status
                $story_user_status = StoryUserStatus::find_by_user_id_and_story_id($api_request->user->id,$api_request->story_id);

                if(!isset($story_user_status->id)) {
                    //! Create a user story status record
                    $story_user_status = StoryUserStatus::create(array(
                        "story_id" => $api_request->story_id,
                        "user_id" => $api_request->user->id,
                        "status" => 'reading',
                        "sub_status" => 0,
                        "score" => 0,
                        "point" => 0,
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s"),
                    ));
                }

                unset($storydec);
                unset($storyenc);
            } else {
                $response = new stdClass;
                $response->success = false;
                $response->message = array("Invalid Story");
            }

            /*//! Get the story details
            $response = $this->getstoryforid($api_request->story_id);

            if(@$response->name != '') {
                $response->success = true;
                $response->message = array("Story retrieved");

                //!check the user story status
                $story_user_status = StoryUserStatus::find_by_user_id_and_story_id($api_request->user->id,$response->id);

                if(!isset($story_user_status->id)) {
                    //! Create a user story status record
                    $story_user_status = StoryUserStatus::create(array(
                        "story_id" => $response->id,
                        "user_id" => $api_request->user->id,
                        "status" => 'reading',
                        "score" => 0,
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s"),
                    ));
                }
            } else {
                $response = new stdClass;
                $response->success = false;
                $response->message = array("Invalid Story");
            }*/

            //! convert json object to string
            $mmm = json_encode($response);
            die($mmm);
        }

        function getstorydetailsforstoryidnew() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Check for valid story_id
            if(!isset($api_request->story_id)) {
                $response->message = array("Invalid story id");
                die(json_encode($response));
            } else if($api_request->story_id == '') {
                $response->message = array("Invalid story id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user");
                die(json_encode($response));
            }

            //! Check if the file exists
            if(file_exists($this->config->item("root_url") . "story/story_" . $api_request->story_id . ".json")) {
            //if(file_exists("story/story_" . $api_request->story_id . ".json")) {
                $key = pack('H*', "bcb04b7e103a0cd8b54763089a7c08bc55abe029fdebae5e1d417e2ffb2a00a3");
                $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
                $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

                $storyenc = file_get_contents($this->config->item("root_url") . "story/story_" . $api_request->story_id . ".json");
                //$storyenc = file_get_contents("story/story_" . $api_request->story_id . ".json");

                $storydec = base64_decode($storyenc);
                $iv_dec = substr($storydec, 0, $iv_size);
                $storydec = substr($storydec, $iv_size);
                $storydec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $storydec, MCRYPT_MODE_CBC, $iv_dec);



                $response = json_decode(trim($storydec));
                $response->success = true;
                $response->message = array("Story retrieved");

                //!check the user story status
                $story_user_status = StoryUserStatus::find_by_user_id_and_story_id($api_request->user->id,$api_request->story_id);

                if(!isset($story_user_status->id)) {
                    //! Create a user story status record
                    $story_user_status = StoryUserStatus::create(array(
                        "story_id" => $api_request->story_id,
                        "user_id" => $api_request->user->id,
                        "status" => 'reading',
                        "sub_status" => 0,
                        "score" => 0,
                        "point" => 0,
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s"),
                    ));
                }

                //!check the user story status
                $story_user_unlock = UserStoryUnlock::find_by_user_id_and_story_id($api_request->user->id,$api_request->story_id);

                if(!isset($story_user_unlock->id)) {
					$points_used = 400;
					
					if($user->expire_date->format("Ymd") >= date("Ymd")) {
						$points_used = 0;
					}
					
                    //! Create a user story status record
                    $story_user_unlock = UserStoryUnlock::create(array(
                        "story_id" => $api_request->story_id,
                        "user_id" => $api_request->user->id,
                        "datetime" => date("Y-m-d H:i:s"),
                        "points_used" => $points_used,
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s"),
                    ));
                }

                unset($storydec);
                unset($storyenc);
            } else {
                $response = new stdClass;
                $response->success = false;
                $response->message = array("Invalid Story");
            }


            //! convert json object to string
            $mmm = json_encode($response);
            //die($mmm);

            $rand = rand(0,99999);

            file_put_contents($this->config->item("root_url") . "story/mstory_".$rand.".json", $mmm);
            $size = filesize($this->config->item("root_url") . "story/mstory_".$rand.".json");
            header('Content-type: text/json; charset=UTF-8');
            header("Content-length: $size");
            header('Content-Disposition: attachment; filename="mstory_'.$rand.'.json"');
            readfile($this->config->item("root_url") . "story/mstory_".$rand.".json");
        }

        /*
    	Function name   : getstorydetailsforstoryid()
    	Parameter       : none
    	Return          : json string
    	Description     : get story details for the story id provided
    	*/
        function getstorydetailsforstoryid1() {

            //! initiate the response
            $response = new stdClass;
            $response->success = false;


            //! Check if the file exists                                  4
            if(file_exists($this->config->item("root_url") . "story/story_3.json")) {
            //if(file_exists("story/story_" . $api_request->story_id . ".json")) {
                $key = pack('H*', "bcb04b7e103a0cd8b54763089a7c08bc55abe029fdebae5e1d417e2ffb2a00a3");
                $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
                $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

                $storyenc = file_get_contents($this->config->item("root_url") . "story/story_3.json");
                //$storyenc = file_get_contents("story/story_" . $api_request->story_id . ".json");

                $storydec = base64_decode($storyenc);
                $iv_dec = substr($storydec, 0, $iv_size);
                $storydec = substr($storydec, $iv_size);
                $storydec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $storydec, MCRYPT_MODE_CBC, $iv_dec);

                $response = json_decode(trim($storydec));
                $response->success = true;
                $response->message = array("Story retrieved");
                //!check the user story status
                $story_user_status = StoryUserStatus::find_by_user_id_and_story_id($api_request->user->id,$api_request->story_id);

                if(!isset($story_user_status->id)) {
                    //! Create a user story status record
                    $story_user_status = StoryUserStatus::create(array(
                        "story_id" => $api_request->story_id,
                        "user_id" => $api_request->user->id,
                        "status" => 'reading',
                        "sub_status" => 0,
                        "score" => 0,
                        "point" => 0,
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s"),
                    ));
                }


                unset($storydec);
                unset($storyenc);
            } else {
                $response = new stdClass;
                $response->success = false;
                $response->message = array("Invalid Story");
            }
            /*//! Get the story details
            $response = $this->getstoryforid($api_request->story_id);

            if(@$response->name != '') {
                $response->success = true;
                $response->message = array("Story retrieved");

                //!check the user story status
                $story_user_status = StoryUserStatus::find_by_user_id_and_story_id($api_request->user->id,$response->id);

                if(!isset($story_user_status->id)) {
                    //! Create a user story status record
                    $story_user_status = StoryUserStatus::create(array(
                        "story_id" => $response->id,
                        "user_id" => $api_request->user->id,
                        "status" => 'reading',
                        "score" => 0,
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s"),
                    ));
                }
            } else {
                $response = new stdClass;
                $response->success = false;
                $response->message = array("Invalid Story");
            }*/


            //! convert json object to string
            $mmm = json_encode($response);
            file_put_contents($this->config->item("root_url") . "story/mstory.json", $mmm);
            $size = filesize($this->config->item("root_url") . "story/mstory.json");
            header('Content-type: text/json; charset=UTF-8');
            header("Content-length: $size");
            header('Content-Disposition: attachment; filename="mstory.json"');
            readfile($this->config->item("root_url") . "story/mstory.json");
        }

        /*
    	Function name   : storestoryuserstatusforstoryid()
    	Parameter       : none
    	Return          : json string
    	Description     : Stores the story user status for story id
    	*/
        function storestoryuserstatusforstoryid() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user");
                die(json_encode($response));
            }

            //! Check for valid story_id
            if(!isset($api_request->story_id)) {
                $response->message = array("Invalid story id");
                die(json_encode($response));
            } else if($api_request->story_id == '') {
                $response->message = array("Invalid story id");
                die(json_encode($response));
            }

            //! Check for valid status
            if(!isset($api_request->status)) {
                $response->message = array("Invalid status");
                die(json_encode($response));
            } else if($api_request->status != 'locked' && $api_request->status != 'reading' && $api_request->status != 'completed') {
                $response->message = array("Invalid status");
                die(json_encode($response));
            }

            //! Check for valid status
            if(!isset($api_request->score)) {
                $response->message = array("Invalid score");
                die(json_encode($response));
            } else if($api_request->score == '') {
                $response->message = array("Invalid score");
                die(json_encode($response));
            }

            //!check the user story status
            $story_user_status = StoryUserStatus::find_by_user_id_and_story_id($api_request->user->id,$api_request->story_id);

            if(!isset($story_user_status->id)) {
                //! Create a user story status record
                $story_user_status = StoryUserStatus::create(array(
                    "story_id" => $api_request->story_id,
                    "user_id" => $api_request->user->id,
                    "status" => $api_request->status,
                    "sub_status" => $api_request->sub_status,
                    "score" => $api_request->score,
                    "point" => @$api_request->point,
                    "created" => date("Y-m-d H:i:s"),
                    "updated" => date("Y-m-d H:i:s"),
                ));
            } else {
                $story_user_status->status = $api_request->status;
                $story_user_status->sub_status = $api_request->sub_status;
                $story_user_status->score = $api_request->score;
                $story_user_status->point = $api_request->point;
                $story_user_status->updated = date("Y-m-d H:i:s");
                $story_user_status->save();
            }

            $response->success = true;
            $response->message = array("Story User Status saved");

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : storestoryuserstatusforstoryidmultiple()
    	Parameter       : none
    	Return          : json string
    	Description     : Stores the story user status for story id
    	*/
        function storestoryuserstatusforstoryidmultiple() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid stories
            if(!isset($api_request->stories)) {
                $response->message = array("Invalid stories");
                die(json_encode($response));
            } else if(!is_array($api_request->stories )) {
                $response->message = array("Invalid stories");
                die(json_encode($response));
            }

            $response->stories = array();
            $counter = 0;
            foreach($api_request->stories as $storyy) {
                $response->stories[$counter]->success = true;
                $response->stories[$counter]->story_id = $storyy->story_id;
                $response->stories[$counter]->a_id = $storyy->a_id;
                $response->stories[$counter]->message = array();

                //! Check for valid story_id
                if(!isset($storyy->story_id)) {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid story id";
                } else if($storyy->story_id == '') {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid story id";
                }

                //! Check for valid status
                if(!isset($storyy->status)) {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid status";
                } else if($storyy->status != 'locked' && $storyy->status != 'reading' && $storyy->status != 'completed') {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid status";
                }

                if($response->stories[$counter]->success) {

                    //!check the user story status
                    $story_user_status = StoryUserStatus::find_by_user_id_and_story_id($api_request->user->id,$storyy->story_id);

                    if(!isset($story_user_status->id)) {
                        //! Create a user story status record
                        $story_user_status = StoryUserStatus::create(array(
                            "story_id" => $storyy->story_id,
                            "user_id" => $api_request->user->id,
                            "status" => @$storyy->status,
                            "point" => @$storyy->point,
                            "sub_status" => @$storyy->sub_status,
                            "score" => @$storyy->score,
                            "created" => date("Y-m-d H:i:s"),
                            "updated" => date("Y-m-d H:i:s"),
                        ));
                    } else {
                        $story_user_status->status = @$storyy->status;
                        $story_user_status->sub_status = @$storyy->sub_status;
                        $story_user_status->score = @$storyy->score;
                        $story_user_status->point = @$storyy->point;
                        $story_user_status->updated = date("Y-m-d H:i:s");
                        $story_user_status->save();
                    }

                    $response->stories[$counter]->message[] = "Story User Status save";
                }

                $counter++;
            }

            $response->success = true;

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : storestoryuserstatusforstoryidmultiple1()
    	Parameter       : none
    	Return          : json string
    	Description     : Stores the story user status for story id for multiple users
    	*/
        function storestoryuserstatusforstoryidmultiple1() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid stories
            if(!isset($api_request->stories)) {
                $response->message = array("Invalid stories");
                die(json_encode($response));
            } else if(!is_array($api_request->stories )) {
                $response->message = array("Invalid stories");
                die(json_encode($response));
            }

            $response->stories = array();
            $counter = 0;
            foreach($api_request->stories as $storyy) {
                $response->stories[$counter]->success = true;
                $response->stories[$counter]->story_id = $storyy->story_id;
                $response->stories[$counter]->a_id = $storyy->a_id;
                $response->stories[$counter]->message = array();

                //! Check for valid userdata format
                if(!isset($storyy->user)) {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid input / structure.";
                }

                //! Check for valid user_id
                if(!isset($storyy->user->id)) {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid user id";
                } else if($storyy->user->id == '') {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid user id";
                }

                //! Check for valid unique_id
                if(!isset($storyy->user->uid)) {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid Unique id";
                } else if($storyy->user->uid == '') {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid Unique id";
                }

                //! Find the user by user_id and unique_id
                $user = User::find_by_id_and_unique_id($storyy->user->id,$storyy->user->uid);

                //! Check if a valid user
                if(!isset($user->id)) {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid user id";
                }

                //! Check for valid story_id
                if(!isset($storyy->story_id)) {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid story id";
                } else if($storyy->story_id == '') {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid story id";
                }

                //! Check for valid status
                if(!isset($storyy->status)) {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid status";
                } else if($storyy->status != 'locked' && $storyy->status != 'reading' && $storyy->status != 'completed') {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid status";
                }

                if($response->stories[$counter]->success) {

                    //!check the user story status
                    $story_user_status = StoryUserStatus::find_by_user_id_and_story_id($storyy->user->id,$storyy->story_id);

                    if(!isset($story_user_status->id)) {
                        //! Create a user story status record
                        $story_user_status = StoryUserStatus::create(array(
                            "story_id" => $storyy->story_id,
                            "user_id" => $storyy->user->id,
                            "status" => @$storyy->status,
                            "point" => @$storyy->point,
                            "sub_status" => @$storyy->sub_status,
                            "score" => @$storyy->score,
                            "created" => date("Y-m-d H:i:s"),
                            "updated" => date("Y-m-d H:i:s"),
                        ));
                    } else {
                        $story_user_status->status = @$storyy->status;
                        $story_user_status->sub_status = @$storyy->sub_status;
                        $story_user_status->score = @$storyy->score;
                        $story_user_status->point = @$storyy->point;
                        $story_user_status->updated = date("Y-m-d H:i:s");
                        $story_user_status->save();
                    }

                    $response->stories[$counter]->message[] = "Story User Status save";
                }

                $counter++;
            }

            $response->success = true;

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : storestoryuseraudiorecordings()
    	Parameter       : none
    	Return          : json string
    	Description     : Stores the story user audio recordings
    	*/
        function storestoryuseraudiorecordings() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Check for valid story_id
            if(!isset($api_request->story_id)) {
                $response->message = array("Invalid story id");
                die(json_encode($response));
            } else if($api_request->story_id == '') {
                $response->message = array("Invalid story id");
                die(json_encode($response));
            }

            //! Check for valid status
            if(!isset($api_request->type)) {
                $response->message = array("Invalid type");
                die(json_encode($response));
            } else if($api_request->type != 'read_aloud' && $api_request->type != 'conversation' && $api_request->type != 'describe_image') {
                $response->message = array("Invalid type");
                die(json_encode($response));
            }

            $audio_file = '';
            if(isset($api_request->audio)) {
                if(@$api_request->audio != '') {
                    //! Get Extension
                    $extension = 'mp3';

                    //! Generate the filename
                    $filename = md5(date('Y-m-d H:i:s U' . rand(0,9999999))) . "." . $extension;
                    $data = explode(',', @$api_request->audio);
                    if(!isset($data[1])) {
                        $data[1] = $data[0];
                    }

                    //! Store the file
                    file_put_contents($this->config->item("root_url") . "user/story/" . $filename, base64_decode($data[1]));
                    $audio_file = $filename;
                }
            }

            //! Create a user story status record
            $story_user_audio_recording = StoryUserAudioRecording::create(array(
                "story_id" => $api_request->story_id,
                "user_id" => $api_request->user->id,
                "type" => $api_request->type,
                "audio_file" => $audio_file,
                "order_number" => @$api_request->order_number,
                "created" => date("Y-m-d H:i:s"),
                "updated" => date("Y-m-d H:i:s"),
            ));

            if(isset($story_user_audio_recording->id)) {
                $response->success = true;
                $response->message = array("Story User Audio Recording saved");
            } else {
                $response->success = false;
                $response->message = array("Invalid data");
            }

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : storestoryuseraudiorecordingsmultiple()
    	Parameter       : none
    	Return          : json string
    	Description     : Stores the story user multiple audio recordings
    	*/
        function storestoryuseraudiorecordingsmultiple() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid stories
            if(!isset($api_request->stories)) {
                $response->message = array("Invalid stories");
                die(json_encode($response));
            } else if(!is_array($api_request->stories )) {
                $response->message = array("Invalid stories");
                die(json_encode($response));
            }

            $response->stories = array();
            $counter = 0;

            //! Loop for all the stories
            foreach($api_request->stories as $storyy) {
                $response->stories[$counter]->success = true;
                $response->stories[$counter]->a_id = $storyy->a_id;
                $response->stories[$counter]->story_id = $storyy->story_id;
                $response->stories[$counter]->type = $storyy->type;
                $response->stories[$counter]->order_number = $storyy->order_number;
                $response->stories[$counter]->message = array();

                //! Check for valid story_id
                if(!isset($storyy->story_id)) {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid story id";
                } else if($storyy->story_id == '') {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid story id";
                }

                //! Check for valid typr
                if(!isset($storyy->type)) {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid type";
                } else if($storyy->type != 'read_aloud' && $storyy->type != 'conversation' && $storyy->type != 'describe_image') {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid type";
                }

                $audio_file = '';
                if(isset($storyy->audio)) {
                    if(@$storyy->audio != '') {
                        //! Get Extension
                        $extension = 'mp3';

                        //! Generate the filename
                        $filename = md5(date('Y-m-d H:i:s U'. rand(0,9999999))) . "." . $extension;
                        $data = explode(',', @$storyy->audio);
                        if(!isset($data[1])) {
                            $data[1] = $data[0];
                        }

                        //! Store the file
                        file_put_contents($this->config->item("root_url") . "user/story/" . $filename, base64_decode($data[1]));
                        $audio_file = $filename;
                    } else {
                        $response->stories[$counter]->success = false;
                        $response->stories[$counter]->message[] = "Invalid audio";
                    }
                } else {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid audio";
                }

                if($response->stories[$counter]->success) {
                    //! Create a user story status record
                    $story_user_audio_recording = StoryUserAudioRecording::create(array(
                        "story_id" => $storyy->story_id,
                        "user_id" => $api_request->user->id,
                        "type" => @$storyy->type,
                        "audio_file" => $audio_file,
                        "order_number" => @$storyy->order_number,
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s"),
                    ));

                    if(isset($story_user_audio_recording->id)) {
                        $response->stories[$counter]->message[] = "Story User Audio Recording saved";
                    } else {
                        $response->stories[$counter]->message[] = "Invalid data";
                        $response->stories[$counter]->success = false;
                    }
                }

                $counter++;
            }

            $response->success = true;

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : storestoryuseraudiorecordingsmultiple1()
    	Parameter       : none
    	Return          : json string
    	Description     : Stores the story user multiple audio recordings for multiple users
    	*/
        function storestoryuseraudiorecordingsmultiple1() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid stories
            if(!isset($api_request->stories)) {
                $response->message = array("Invalid stories");
                die(json_encode($response));
            } else if(!is_array($api_request->stories )) {
                $response->message = array("Invalid stories");
                die(json_encode($response));
            }

            $response->stories = array();
            $counter = 0;

            //! Loop for all the stories
            foreach($api_request->stories as $storyy) {
                $response->stories[$counter]->success = true;
                $response->stories[$counter]->a_id = $storyy->a_id;
                $response->stories[$counter]->story_id = $storyy->story_id;
                $response->stories[$counter]->type = $storyy->type;
                $response->stories[$counter]->order_number = $storyy->order_number;
                $response->stories[$counter]->message = array();

                //! Check for valid userdata format
                if(!isset($storyy->user)) {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid input / structure.";
                }

                //! Check for valid user_id
                if(!isset($storyy->user->id)) {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid user id";
                } else if($storyy->user->id == '') {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid user id";
                }

                //! Check for valid unique_id
                if(!isset($storyy->user->uid)) {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid Unique id";
                } else if($storyy->user->uid == '') {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid Unique id";
                }

                //! Find the user by user_id and unique_id
                $user = User::find_by_id_and_unique_id($storyy->user->id,$storyy->user->uid);

                //! Check if a valid user
                if(!isset($user->id)) {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid user id";
                }

                //! Check for valid story_id
                if(!isset($storyy->story_id)) {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid story id";
                } else if($storyy->story_id == '') {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid story id";
                }

                //! Check for valid typr
                if(!isset($storyy->type)) {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid type";
                } else if($storyy->type != 'read_aloud' && $storyy->type != 'conversation' && $storyy->type != 'describe_image') {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid type";
                }

                $audio_file = '';
                if(isset($storyy->audio)) {
                    if(@$storyy->audio != '') {
                        //! Get Extension
                        $extension = 'mp3';

                        //! Generate the filename
                        $filename = md5(date('Y-m-d H:i:s U'. rand(0,9999999))) . "." . $extension;
                        $data = explode(',', @$storyy->audio);
                        if(!isset($data[1])) {
                            $data[1] = $data[0];
                        }

                        //! Store the file
                        file_put_contents($this->config->item("root_url") . "user/story/" . $filename, base64_decode($data[1]));
                        $audio_file = $filename;
                    } else {
                        $response->stories[$counter]->success = false;
                        $response->stories[$counter]->message[] = "Invalid audio";
                    }
                } else {
                    $response->stories[$counter]->success = false;
                    $response->stories[$counter]->message[] = "Invalid audio";
                }

                if($response->stories[$counter]->success) {
                    //! Create a user story status record
                    $story_user_audio_recording = StoryUserAudioRecording::create(array(
                        "story_id" => $storyy->story_id,
                        "user_id" => $storyy->user->id,
                        "type" => @$storyy->type,
                        "audio_file" => $audio_file,
                        "order_number" => @$storyy->order_number,
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s"),
                    ));

                    if(isset($story_user_audio_recording->id)) {
                        $response->stories[$counter]->message[] = "Story User Audio Recording saved";
                    } else {
                        $response->stories[$counter]->message[] = "Invalid data";
                        $response->stories[$counter]->success = false;
                    }
                }

                $counter++;
            }

            $response->success = true;

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : getstoryuserstatus()
    	Parameter       : none
    	Return          : json string
    	Description     : Gets the all story user status
    	*/
        function getstoryuserstatus() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Get all the user story status
            $story_user_status = StoryUserStatus::find_all_by_user_id($api_request->user->id);

            $response->stories = array();

            foreach($story_user_status as $val) {
                $story = new stdClass;
                $story->id = $val->story_id;
                $story->status = $val->status;
                if($val->sub_status > 0)
                    $story->sub_status = $val->sub_status;
                else
                    $story->sub_status = 0;
                $story->score = $val->score;
                $story->point = $val->point;
                $response->stories[] = $story;
            }

            $response->success = true;
            $response->message = array("User all story status details");

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : storeuseranswer()
    	Parameter       : none
    	Return          : json string
    	Description     : Store User answers
    	*/
        function storeuseranswer() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid question_id
            if(!isset($api_request->question_id)) {
                $response->message = array("Invalid Question id");
                die(json_encode($response));
            } else if($api_request->question_id == '') {
                $response->message = array("Invalid Question id");
                die(json_encode($response));
            }

            //! Retrieve Question
            $question = Question::find($api_request->question_id);

            //! Check for valid question record
            if(!isset($question->id)) {
                $response->message = array("Invalid Question id");
                die(json_encode($response));
            }

            //! Check for valid answer
            if(!isset($api_request->answer)) {
                $response->message = array("Invalid Answer");
                die(json_encode($response));
            }

            $meta_type = 0;
            if(isset($api_request->meta_type)) {
                $meta_type = $api_request->meta_type;
            }

            //! Store Answer meta data
            $answer = Answer::create(array(
                "user_id" => $api_request->user->id,
                "question_id" => $api_request->question_id,
                "concepts_id" => '',
                "units_id" => '',
                "subject_id" => '',
                "classes_id" => '',
                "result" => $api_request->answer->result,
                "score" => $api_request->answer->score,
                "meta_type" => $meta_type,
                "answered_dtm" => date("Y-m-d H:i:s",strtotime(str_replace("/","-",$api_request->answer->answered_dtm))),
                "created" => date("Y-m-d H:i:s"),
                "updated" => date("Y-m-d H:i:s")
            ));

            if(isset($answer->id)) {
                $response->success = true;
                $response->message = array("Story Question answer stored");

                //! Store Answer complete data
                $answer_question = AnswerQuestion::create(array(
                    "user_id" => $api_request->user->id,
                    "answer_id" => $answer->id,
                    "question_id" => $api_request->question_id,
                    "question" => $question->question,
                    "variables" => '',
                    "answer" => json_encode($api_request->answer->answer),
                    "created" => date("Y-m-d H:i:s"),
                    "updated" => date("Y-m-d H:i:s")
                ));
            } else {
                $response->success = false;
                $response->message = array("Invalid data");
            }

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : storeuseranswermultiple()
    	Parameter       : none
    	Return          : json string
    	Description     : Store User multiple answers
    	*/
        function storeuseranswermultiple() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid questions
            if(!isset($api_request->questions)) {
                $response->message = array("Invalid questions");
                die(json_encode($response));
            } else if(!is_array($api_request->questions )) {
                $response->message = array("Invalid questions");
                die(json_encode($response));
            }

            $response->questions = array();
            $counter = 0;

            //! Loop for all the questions
            foreach($api_request->questions as $storyy) {
                $response->questions[$counter]->success = true;
                $response->questions[$counter]->a_id = $storyy->a_id;
                $response->questions[$counter]->question_id = $storyy->question_id;
                $response->questions[$counter]->message = array();

                //! Check for valid question_id
                if(!isset($storyy->question_id)) {
                    $response->questions[$counter]->success = false;
                    $response->questions[$counter]->message[] = "Invalid Question id";
                } else if($storyy->question_id == '') {
                    $response->questions[$counter]->success = false;
                    $response->questions[$counter]->message[] = "Invalid Question id";
                }

                //! Retrieve Question
                $question = Question::find($storyy->question_id);

                //! Check for valid question record
                if(!isset($question->id)) {
                    $response->questions[$counter]->success = false;
                    $response->questions[$counter]->message[] = "Invalid Question id";
                }

                //! Check for valid answer
                if(!isset($storyy->answer)) {
                    $response->questions[$counter]->success = false;
                    $response->questions[$counter]->message[] = "Invalid Answer";
                }

                $meta_type = 0;
                if(isset($storyy->meta_type)) {
                    $meta_type = $storyy->meta_type;
                }

                if($response->questions[$counter]->success) {
                    //! Store Answer meta data
                    $answer = Answer::create(array(
                        "user_id" => $api_request->user->id,
                        "question_id" => $storyy->question_id,
                        "concepts_id" => '',
                        "units_id" => '',
                        "subject_id" => '',
                        "classes_id" => '',
                        "result" => @$storyy->answer->result,
                        "score" => @$storyy->answer->score,
                        "meta_type" => @$meta_type,
                        "answered_dtm" => date("Y-m-d H:i:s",strtotime(str_replace("/","-",@$storyy->answer->answered_dtm))),
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s")
                    ));

                    if(isset($answer->id)) {
                        $response->questions[$counter]->message[] = "Question answer stored";

                        //! Store Answer complete data
                        $answer_question = AnswerQuestion::create(array(
                            "user_id" => $api_request->user->id,
                            "answer_id" => $answer->id,
                            "question_id" => $storyy->question_id,
                            "question" => $question->question,
                            "variables" => '',
                            "answer" => json_encode($storyy->answer->answer),
                            "created" => date("Y-m-d H:i:s"),
                            "updated" => date("Y-m-d H:i:s")
                        ));
                    } else {
                        $response->questions[$counter]->success = false;
                        $response->questions[$counter]->message[] = "Invalid data";
                    }
                }

                $counter++;
            }

            $response->success = true;

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : storeuseranswermultiple1()
    	Parameter       : none
    	Return          : json string
    	Description     : Store User multiple answers for multiple users
    	*/
        function storeuseranswermultiple1() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid questions
            if(!isset($api_request->questions)) {
                $response->message = array("Invalid questions");
                die(json_encode($response));
            } else if(!is_array($api_request->questions )) {
                $response->message = array("Invalid questions");
                die(json_encode($response));
            }

            $response->questions = array();
            $counter = 0;

            //! Loop for all the questions
            foreach($api_request->questions as $storyy) {
                $response->questions[$counter]->success = true;
                $response->questions[$counter]->a_id = $storyy->a_id;
                $response->questions[$counter]->question_id = $storyy->question_id;
                $response->questions[$counter]->message = array();

                //! Check for valid userdata format
                if(!isset($storyy->user)) {
                    $response->questions[$counter]->success = false;
                    $response->questions[$counter]->message[] = "Invalid input / structure.";
                }

                //! Check for valid user_id
                if(!isset($storyy->user->id)) {
                    $response->questions[$counter]->success = false;
                    $response->questions[$counter]->message[] = "Invalid user id.";
                } else if($storyy->user->id == '') {
                    $response->questions[$counter]->success = false;
                    $response->questions[$counter]->message[] = "Invalid user id.";
                }

                //! Check for valid unique_id
                if(!isset($storyy->user->uid)) {
                    $response->questions[$counter]->success = false;
                    $response->questions[$counter]->message[] = "Invalid Unique id";
                } else if($storyy->user->uid == '') {
                    $response->questions[$counter]->success = false;
                    $response->questions[$counter]->message[] = "Invalid Unique id";
                }

                //! Find the user by user_id and unique_id
                $user = User::find_by_id_and_unique_id($storyy->user->id,$storyy->user->uid);

                //! Check if a valid user
                if(!isset($user->id)) {
                    $response->questions[$counter]->success = false;
                    $response->questions[$counter]->message[] = "Invalid Unique id";
                }

                //! Check for valid question_id
                if(!isset($storyy->question_id)) {
                    $response->questions[$counter]->success = false;
                    $response->questions[$counter]->message[] = "Invalid Question id";
                } else if($storyy->question_id == '') {
                    $response->questions[$counter]->success = false;
                    $response->questions[$counter]->message[] = "Invalid Question id";
                }

                //! Retrieve Question
                //$question = Question::find($storyy->question_id);

                //! Check for valid question record
                //if(!isset($question->id)) {
                //    $response->questions[$counter]->success = false;
                //    $response->questions[$counter]->message[] = "Invalid Question id";
                //}

                //! Check for valid answer
                if(!isset($storyy->answer)) {
                    $response->questions[$counter]->success = false;
                    $response->questions[$counter]->message[] = "Invalid Answer";
                }

                $meta_type = 0;
                if(isset($storyy->meta_type)) {
                    $meta_type = $storyy->meta_type;
                }

                if($response->questions[$counter]->success) {
                    //! Store Answer meta data
                    $answer = Answer::create(array(
                        "user_id" => $storyy->user->id,
                        "question_id" => $storyy->question_id,
                        "concepts_id" => '',
                        "units_id" => '',
                        "subject_id" => '',
                        "classes_id" => '',
                        "result" => @$storyy->answer->result,
                        "score" => @$storyy->answer->score,
                        "meta_type" => @$meta_type,
                        "answered_dtm" => date("Y-m-d H:i:s",strtotime(str_replace("/","-",@$storyy->answer->answered_dtm))),
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s")
                    ));

                    if(isset($answer->id)) {
                        $response->questions[$counter]->message[] = "Question answer stored";

                        //! Store Answer complete data
                        $answer_question = AnswerQuestion::create(array(
                            "user_id" => $storyy->user->id,
                            "answer_id" => $answer->id,
                            "question_id" => $storyy->question_id,
                            "question" => $question->question,
                            "variables" => '',
                            "answer" => json_encode($storyy->answer->answer),
                            "created" => date("Y-m-d H:i:s"),
                            "updated" => date("Y-m-d H:i:s")
                        ));
                    } else {
                        $response->questions[$counter]->success = false;
                        $response->questions[$counter]->message[] = "Invalid data";
                    }
                }

                $counter++;
            }

            $response->success = true;

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : storegraphemeuseraudiorecordingsandtrace()
    	Parameter       : none
    	Return          : json string
    	Description     : Stores the grapheme user audio recordings and trace
    	*/
        function storegraphemeuseraudiorecordingsandtrace() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid type
            if(!isset($api_request->type)) {
                $response->message = array("Invalid type");
                die(json_encode($response));
            } else if($api_request->type != 'learn' && $api_request->type != 'trace' && $api_request->type != 'phrase' && $api_request->type != 'word') {
                $response->message = array("Invalid type");
                die(json_encode($response));
            }

            //! Store audio file
            $audio_file = '';
            if(isset($api_request->audio)) {
                if(@$api_request->audio != '') {
                    //! Get Extension
                    $extension = 'mp3';

                    //! Generate the filename
                    $filename = md5(date('Y-m-d H:i:s U'.rand(0,9999999))) . "." . $extension;
                    $data = explode(',', @$api_request->audio);
                    if(!isset($data[1])) {
                        $data[1] = $data[0];
                    }

                    //! Store the file
                    file_put_contents($this->config->item("root_url") . "user/grapheme/" . $filename, base64_decode($data[1]));
                    $audio_file = $filename;
                }
            }

            //! Store image file
            $image_file = '';
            if(isset($api_request->image)) {
                if(@$api_request->image != '') {
                    //! Get Extension
                    $extension = 'jpg';
                    if(strpos( @$api_request->image , 'png;base64') !== false) {
                        $extension = 'png';
                    }
                    //! Generate the filename
                    $filename = md5(date('Y-m-d H:i:s U'.rand(0,9999999))) . "." . $extension;
                    $data = explode(',', @$api_request->image);
                    if(!isset($data[1])) {
                        $data[1] = $data[0];
                    }

                    //! Store the file
                    file_put_contents($this->config->item("root_url") . "user/grapheme/" . $filename, base64_decode($data[1]));
                    $image_file = $filename;
                }
            }

            //! Create a user grapheme audio recording and trace record
            $record = GraphemeWordUserAudioRecordingTrace::create(array(
                "grapheme_id" => @$api_request->grapheme_id,
                "word_id" => @$api_request->word_id,
                "phrase_id" => @$api_request->phrase_id,
                "wordsegment_id" => @$api_request->wordsegment_id,
                "user_id" => $api_request->user->id,
                "type" => $api_request->type,
                "audio_file" => $audio_file,
                "trace_file" => $image_file,
                "created" => date("Y-m-d H:i:s"),
                "updated" => date("Y-m-d H:i:s"),
            ));

            if(isset($record->id)) {
                $response->success = true;
                $response->message = array("Grapheme user audio Recording and trace saved");
            } else {
                $response->success = false;
                $response->message = array("Invalid data");
            }

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : storegraphemeuseraudiorecordingsandtracemultiple()
    	Parameter       : none
    	Return          : json string
    	Description     : Stores the grapheme user audio recordings and trace multiple
    	*/
        function storegraphemeuseraudiorecordingsandtracemultiple() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid graphemes
            if(!isset($api_request->graphemes)) {
                $response->message = array("Invalid graphemes");
                die(json_encode($response));
            } else if(!is_array($api_request->graphemes )) {
                $response->message = array("Invalid graphemes");
                die(json_encode($response));
            }

            $response->graphemes = array();
            $counter = 0;

            //! A loop for all the graphemes
            foreach($api_request->graphemes as $element) {

                $response->graphemes[$counter]->success = true;
                $response->graphemes[$counter]->a_id = $element->a_id;
                $response->graphemes[$counter]->grapheme_id = $element->grapheme_id;
                $response->graphemes[$counter]->word_id = $element->word_id;
                $response->graphemes[$counter]->phrase_id = $element->phrase_id;
                $response->graphemes[$counter]->wordsegment_id = $element->wordsegment_id;
                $response->graphemes[$counter]->type = $element->type;
                $response->graphemes[$counter]->message = array();

                //! Check for valid type
                if(!isset($element->type)) {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid type";
                } else if($element->type != 'learn' && $element->type != 'trace' && $element->type != 'phrase' && $element->type != 'word') {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid type";
                }

                //! Store audio file
                $audio_file = '';
                if(isset($element->audio)) {
                    if(@$element->audio != '') {
                        //! Get Extension
                        $extension = 'mp3';

                        //! Generate the filename
                        $filename = md5(date('Y-m-d H:i:s U'. rand(0,9999999))) . "." . $extension;
                        $data = explode(',', @$element->audio);
                        if(!isset($data[1])) {
                            $data[1] = $data[0];
                        }

                        //! Store the file
                        file_put_contents($this->config->item("root_url") . "user/grapheme/" . $filename, base64_decode($data[1]));
                        $audio_file = $filename;
                    }
                }

                //! Store image file
                $image_file = '';
                if(isset($element->image)) {
                    if(@$element->image != '') {
                        //! Get Extension
                        $extension = 'jpg';
                        if(strpos( @$element->image , 'png;base64') !== false) {
                            $extension = 'png';
                        }
                        //! Generate the filename
                        $filename = md5(date('Y-m-d H:i:s U' . rand(0,9999999))) . "." . $extension;
                        $data = explode(',', @$element->image);
                        if(!isset($data[1])) {
                            $data[1] = $data[0];
                        }

                        //! Store the file
                        file_put_contents($this->config->item("root_url") . "user/grapheme/" . $filename, base64_decode($data[1]));
                        $image_file = $filename;
                    }
                }

                //! Check for image or audio
                if($audio_file == '' && $image_file == '') {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid audio / image";
                }

                if($response->graphemes[$counter]->success) {

                    //! Create a user grapheme audio recording and trace record
                    $record = GraphemeWordUserAudioRecordingTrace::create(array(
                        "grapheme_id" => @$element->grapheme_id,
                        "word_id" => @$element->word_id,
                        "phrase_id" => @$element->phrase_id,
                        "wordsegment_id" => @$element->wordsegment_id,
                        "user_id" => $api_request->user->id,
                        "type" => $element->type,
                        "audio_file" => $audio_file,
                        "trace_file" => $image_file,
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s"),
                    ));

                    if(isset($record->id)) {
                        $response->graphemes[$counter]->success = true;
                        $response->graphemes[$counter]->message[] = "Grapheme user audio Recording and trace saved";
                    } else {
                        $response->graphemes[$counter]->success = false;
                        $response->graphemes[$counter]->message[] = "Invalid data";
                    }
                }

                $counter++;
            }

            $response->success = true;

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : storegraphemeuseraudiorecordingsandtracemultiple1()
    	Parameter       : none
    	Return          : json string
    	Description     : Stores the grapheme user audio recordings and trace multiple for multiple users
    	*/
        function storegraphemeuseraudiorecordingsandtracemultiple1() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid graphemes
            if(!isset($api_request->graphemes)) {
                $response->message = array("Invalid graphemes");
                die(json_encode($response));
            } else if(!is_array($api_request->graphemes )) {
                $response->message = array("Invalid graphemes");
                die(json_encode($response));
            }

            $response->graphemes = array();
            $counter = 0;

            //! A loop for all the graphemes
            foreach($api_request->graphemes as $element) {

                $response->graphemes[$counter]->success = true;
                $response->graphemes[$counter]->a_id = $element->a_id;
                $response->graphemes[$counter]->grapheme_id = $element->grapheme_id;
                $response->graphemes[$counter]->word_id = $element->word_id;
                $response->graphemes[$counter]->phrase_id = $element->phrase_id;
                $response->graphemes[$counter]->wordsegment_id = $element->wordsegment_id;
                $response->graphemes[$counter]->type = $element->type;
                $response->graphemes[$counter]->message = array();

                //! Check for valid userdata format
                if(!isset($element->user)) {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid input / structure.";
                }

                //! Check for valid user_id
                if(!isset($element->user->id)) {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid user id";
                } else if($element->user->id == '') {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid user id";
                }

                //! Check for valid unique_id
                if(!isset($element->user->uid)) {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid Unique id";
                } else if($element->user->uid == '') {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid Unique id";
                }

                //! Find the user by user_id and unique_id
                $user = User::find_by_id_and_unique_id($element->user->id,$element->user->uid);

                //! Check if a valid user
                if(!isset($user->id)) {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid user id";
                }


                //! Check for valid type
                if(!isset($element->type)) {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid type";
                } else if($element->type != 'learn' && $element->type != 'trace' && $element->type != 'phrase' && $element->type != 'word') {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid type";
                }

                //! Store audio file
                $audio_file = '';
                if(isset($element->audio)) {
                    if(@$element->audio != '') {
                        //! Get Extension
                        $extension = 'mp3';

                        //! Generate the filename
                        $filename = md5(date('Y-m-d H:i:s U'. rand(0,9999999))) . "." . $extension;
                        $data = explode(',', @$element->audio);
                        if(!isset($data[1])) {
                            $data[1] = $data[0];
                        }

                        //! Store the file
                        file_put_contents($this->config->item("root_url") . "user/grapheme/" . $filename, base64_decode($data[1]));
                        $audio_file = $filename;
                    }
                }

                //! Store image file
                $image_file = '';
                if(isset($element->image)) {
                    if(@$element->image != '') {
                        //! Get Extension
                        $extension = 'jpg';
                        if(strpos( @$element->image , 'png;base64') !== false) {
                            $extension = 'png';
                        }
                        //! Generate the filename
                        $filename = md5(date('Y-m-d H:i:s U' . rand(0,9999999))) . "." . $extension;
                        $data = explode(',', @$element->image);
                        if(!isset($data[1])) {
                            $data[1] = $data[0];
                        }

                        //! Store the file
                        file_put_contents($this->config->item("root_url") . "user/grapheme/" . $filename, base64_decode($data[1]));
                        $image_file = $filename;
                    }
                }

                //! Check for image or audio
                if($audio_file == '' && $image_file == '') {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid audio / image";
                }

                if($response->graphemes[$counter]->success) {

                    //! Create a user grapheme audio recording and trace record
                    $record = GraphemeWordUserAudioRecordingTrace::create(array(
                        "grapheme_id" => @$element->grapheme_id,
                        "word_id" => @$element->word_id,
                        "phrase_id" => @$element->phrase_id,
                        "wordsegment_id" => @$element->wordsegment_id,
                        "user_id" => $element->user->id,
                        "type" => $element->type,
                        "audio_file" => $audio_file,
                        "trace_file" => $image_file,
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s"),
                    ));

                    if(isset($record->id)) {
                        $response->graphemes[$counter]->success = true;
                        $response->graphemes[$counter]->message[] = "Grapheme user audio Recording and trace saved";
                    } else {
                        $response->graphemes[$counter]->success = false;
                        $response->graphemes[$counter]->message[] = "Invalid data";
                    }
                }

                $counter++;
            }

            $response->success = true;

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : storeworduseranswer()
    	Parameter       : none
    	Return          : json string
    	Description     : Stores the word user answer
    	*/
        function storeworduseranswer() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid word_id
            /*if(!isset($api_request->word_id)) {
                $response->message = array("Invalid Word id");
                die(json_encode($response));
            } else if($api_request->word_id == '') {
                $response->message = array("Invalid Word id");
                die(json_encode($response));
            }*/

            //! Check for valid status
            if(!isset($api_request->status)) {
                $response->message = array("Invalid status");
                die(json_encode($response));
            } else if($api_request->status != 'correct' && $api_request->status != 'wrong' ) {
                $response->message = array("Invalid status");
                die(json_encode($response));
            }

            //! Check for valid answer
            if(!isset($api_request->answer)) {
                $response->message = array("Invalid answer");
                die(json_encode($response));
            }

            //! Check for valid type
            if(!isset($api_request->type)) {
                $response->message = array("Invalid type");
                die(json_encode($response));
            } else if($api_request->type != 'normal' && $api_request->type != 'test' ) {
                $response->message = array("Invalid type");
                die(json_encode($response));
            }

            //! Create a user word answer record
            $record = WordUserAnswers::create(array(
                "word_id" => @$api_request->word_id,
                "grapheme_id" => @$api_request->grapheme_id,
                "user_id" => $api_request->user->id,
                "status" => $api_request->status,
                "user_answer" => $api_request->answer,
                "score" => $api_request->score,
                "type" => $api_request->type,
                "created" => date("Y-m-d H:i:s"),
                "updated" => date("Y-m-d H:i:s"),
            ));

            if(isset($record->id)) {
                $response->success = true;
                $response->message = array("Word user answer saved");
            } else {
                $response->success = false;
                $response->message = array("Invalid data");
            }

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : storeworduseranswermultiple()
    	Parameter       : none
    	Return          : json string
    	Description     : Stores the word user answer multiple
    	*/
        function storeworduseranswermultiple() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid words
            if(!isset($api_request->words)) {
                $response->message = array("Invalid words");
                die(json_encode($response));
            } else if(!is_array($api_request->words )) {
                $response->message = array("Invalid words");
                die(json_encode($response));
            }

            $response->words = array();
            $counter = 0;

            //! A loop for the words
            foreach($api_request->words as $element) {
                $response->words[$counter]->success = true;
                $response->words[$counter]->a_id = $element->a_id;
                $response->words[$counter]->word_id = @$element->word_id;
                $response->words[$counter]->grapheme_id = @$element->grapheme_id;
                $response->words[$counter]->type = $element->type;
                $response->words[$counter]->message = array();

                //! Check for valid word_id
                /*if(!isset($element->word_id)) {
                    $response->words[$counter]->success = false;
                    $response->words[$counter]->message[] = "Invalid Word id";
                } else if($element->word_id == '') {
                    $response->words[$counter]->success = false;
                    $response->words[$counter]->message[] = "Invalid Word id";
                }*/

                //! Check for valid status
                if(!isset($element->status)) {
                    $response->words[$counter]->success = false;
                    $response->words[$counter]->message[] = "Invalid status";
                } else if($element->status != 'correct' && $element->status != 'wrong' ) {
                    $response->words[$counter]->success = false;
                    $response->words[$counter]->message[] = "Invalid status";
                }

                //! Check for valid answer
                if(!isset($element->answer)) {
                    $response->words[$counter]->success = false;
                    $response->words[$counter]->message[] = "Invalid answer";
                }

                //! Check for valid type
                if(!isset($element->type)) {
                    $response->words[$counter]->success = false;
                    $response->words[$counter]->message[] = "Invalid type";
                } else if($element->type != 'normal' && $element->type != 'test' ) {
                    $response->words[$counter]->success = false;
                    $response->words[$counter]->message[] = "Invalid type";
                }

                if($response->words[$counter]->success) {

                    //! Create a user word answer record
                    $record = WordUserAnswers::create(array(
                        "word_id" => @$element->word_id,
                        "grapheme_id" => @$element->grapheme_id,
                        "user_id" => $api_request->user->id,
                        "status" => $element->status,
                        "user_answer" => $element->answer,
                        "score" => $element->score,
                        "type" => $element->type,
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s"),
                    ));

                    if(isset($record->id)) {
                        $response->words[$counter]->success = true;
                        $response->words[$counter]->message[] = "Word user answer saved";
                    } else {
                        $response->words[$counter]->success = false;
                        $response->words[$counter]->message[] = "Invalid data";
                    }
                }

                $counter++;
            }

            $response->success = true;

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : storeworduseranswermultiple1()
    	Parameter       : none
    	Return          : json string
    	Description     : Stores the word user answer multiple for multiple users
    	*/
        function storeworduseranswermultiple1() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid words
            if(!isset($api_request->words)) {
                $response->message = array("Invalid words");
                die(json_encode($response));
            } else if(!is_array($api_request->words )) {
                $response->message = array("Invalid words");
                die(json_encode($response));
            }

            $response->words = array();
            $counter = 0;

            //! A loop for the words
            foreach($api_request->words as $element) {
                $response->words[$counter]->success = true;
                $response->words[$counter]->a_id = $element->a_id;
                $response->words[$counter]->word_id = @$element->word_id;
                $response->words[$counter]->grapheme_id = @$element->grapheme_id;
                $response->words[$counter]->type = $element->type;
                $response->words[$counter]->message = array();

                //! Check for valid userdata format
                if(!isset($element->user)) {
                    $response->words[$counter]->success = false;
                    $response->words[$counter]->message[] = "Invalid input / structure.";
                }

                //! Check for valid user_id
                if(!isset($element->user->id)) {
                    $response->words[$counter]->success = false;
                    $response->words[$counter]->message[] = "Invalid user id";
                } else if($element->user->id == '') {
                    $response->words[$counter]->success = false;
                    $response->words[$counter]->message[] = "Invalid user id";
                }

                //! Check for valid unique_id
                if(!isset($element->user->uid)) {
                    $response->words[$counter]->success = false;
                    $response->words[$counter]->message[] = "Invalid Unique id";
                } else if($element->user->uid == '') {
                    $response->words[$counter]->success = false;
                    $response->words[$counter]->message[] = "Invalid Unique id";
                }

                //! Find the user by user_id and unique_id
                $user = User::find_by_id_and_unique_id($element->user->id,$element->user->uid);

                //! Check if a valid user
                if(!isset($user->id)) {
                    $response->words[$counter]->success = false;
                    $response->words[$counter]->message[] = "Invalid user id";
                }

                //! Check for valid word_id
                /*if(!isset($element->word_id)) {
                    $response->words[$counter]->success = false;
                    $response->words[$counter]->message[] = "Invalid Word id";
                } else if($element->word_id == '') {
                    $response->words[$counter]->success = false;
                    $response->words[$counter]->message[] = "Invalid Word id";
                }*/

                //! Check for valid status
                if(!isset($element->status)) {
                    $response->words[$counter]->success = false;
                    $response->words[$counter]->message[] = "Invalid status";
                } else if($element->status != 'correct' && $element->status != 'wrong' ) {
                    $response->words[$counter]->success = false;
                    $response->words[$counter]->message[] = "Invalid status";
                }

                //! Check for valid answer
                if(!isset($element->answer)) {
                    $response->words[$counter]->success = false;
                    $response->words[$counter]->message[] = "Invalid answer";
                }

                //! Check for valid type
                if(!isset($element->type)) {
                    $response->words[$counter]->success = false;
                    $response->words[$counter]->message[] = "Invalid type";
                } else if($element->type != 'normal' && $element->type != 'test' ) {
                    $response->words[$counter]->success = false;
                    $response->words[$counter]->message[] = "Invalid type";
                }

                if($response->words[$counter]->success) {

                    //! Create a user word answer record
                    $record = WordUserAnswers::create(array(
                        "word_id" => @$element->word_id,
                        "grapheme_id" => @$element->grapheme_id,
                        "user_id" => $element->user->id,
                        "status" => $element->status,
                        "user_answer" => $element->answer,
                        "score" => $element->score,
                        "type" => $element->type,
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s"),
                    ));

                    if(isset($record->id)) {
                        $response->words[$counter]->success = true;
                        $response->words[$counter]->message[] = "Word user answer saved";
                    } else {
                        $response->words[$counter]->success = false;
                        $response->words[$counter]->message[] = "Invalid data";
                    }
                }

                $counter++;
            }

            $response->success = true;

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : storephraseuseranswer()
    	Parameter       : none
    	Return          : json string
    	Description     : Stores the phrase user answer
    	*/
        function storephraseuseranswer() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Check for valid sentence_id
            if(!isset($api_request->sentence_id)) {
                $response->message = array("Invalid sentence id");
                die(json_encode($response));
            } else if($api_request->sentence_id == '') {
                $response->message = array("Invalid sentence id");
                die(json_encode($response));
            }

            //! Check for valid status
            if(!isset($api_request->status)) {
                $response->message = array("Invalid status");
                die(json_encode($response));
            } else if($api_request->status != 'correct' && $api_request->status != 'wrong' ) {
                $response->message = array("Invalid status");
                die(json_encode($response));
            }

            //! Check for valid answer
            if(!isset($api_request->answer)) {
                $response->message = array("Invalid answer");
                die(json_encode($response));
            }

            //! Check for valid type
            if(!isset($api_request->type)) {
                $response->message = array("Invalid type");
                die(json_encode($response));
            } else if($api_request->type != 'normal' && $api_request->type != 'test' ) {
                $response->message = array("Invalid type");
                die(json_encode($response));
            }

            //! Create a user phrase answer record
            $record = PhraseUserAnswer::create(array(
                "sentence_id" => @$api_request->sentence_id,
                "user_id" => $api_request->user->id,
                "status" => $api_request->status,
                "user_answer" => $api_request->answer,
                "score" => $api_request->score,
                "type" => $api_request->type,
                "created" => date("Y-m-d H:i:s"),
                "updated" => date("Y-m-d H:i:s"),
            ));

            if(isset($record->id)) {
                $response->success = true;
                $response->message = array("Phrase user answer saved");
            } else {
                $response->success = false;
                $response->message = array("Invalid data");
            }

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : storephraseuseranswermultiple()
    	Parameter       : none
    	Return          : json string
    	Description     : Stores the phrase user answer multiple
    	*/
        function storephraseuseranswermultiple() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid phrases
            if(!isset($api_request->phrases)) {
                $response->message = array("Invalid phrases");
                die(json_encode($response));
            } else if(!is_array($api_request->phrases )) {
                $response->message = array("Invalid phrases");
                die(json_encode($response));
            }

            $response->phrases = array();
            $counter = 0;

            //! A loop for  all the phrases
            foreach($api_request->phrases as $element) {

                $response->phrases[$counter]->success = true;
                $response->phrases[$counter]->a_id = $element->a_id;
                $response->phrases[$counter]->sentence_id = $element->sentence_id;
                $response->phrases[$counter]->type = $element->type;
                $response->phrases[$counter]->message = array();

                //! Check for valid sentence_id
                if(!isset($element->sentence_id)) {
                    $response->phrases[$counter]->success = false;
                    $response->phrases[$counter]->message[] = "Invalid sentence id1";
                } else if($element->sentence_id == '') {
                    $response->phrases[$counter]->success = false;
                    $response->phrases[$counter]->message[] = "Invalid sentence id2";
                }

                //! Check for valid status
                if(!isset($element->status)) {
                    $response->phrases[$counter]->success = false;
                    $response->phrases[$counter]->message[] = "Invalid status";
                } else if($element->status != 'correct' && $element->status != 'wrong' ) {
                    $response->phrases[$counter]->success = false;
                    $response->phrases[$counter]->message[] = "Invalid status";
                }

                //! Check for valid answer
                if(!isset($element->answer)) {
                    $response->phrases[$counter]->success = false;
                    $response->phrases[$counter]->message[] = "Invalid answer";
                }

                //! Check for valid type
                if(!isset($element->type)) {
                    $response->phrases[$counter]->success = false;
                    $response->phrases[$counter]->message[] = "Invalid type";
                } else if($element->type != 'normal' && $element->type != 'test' ) {
                    $response->phrases[$counter]->success = false;
                    $response->phrases[$counter]->message[] = "Invalid type";
                }

                if($response->phrases[$counter]->success) {
                    //! Create a user phrase answer record
                    $record = PhraseUserAnswer::create(array(
                        "sentence_id" => @$element->sentence_id,
                        "user_id" => $api_request->user->id,
                        "status" => $element->status,
                        "user_answer" => $element->answer,
                        "score" => $element->score,
                        "type" => $element->type,
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s"),
                    ));

                    if(isset($record->id)) {
                        $response->phrases[$counter]->success = true;
                        $response->phrases[$counter]->message[] = "Phrase user answer saved";
                    } else {
                        $response->phrases[$counter]->success = false;
                        $response->phrases[$counter]->message[] = "Invalid data";
                    }
                }

                $counter++;
            }

            $response->success = true;

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : storephraseuseranswermultiple1()
    	Parameter       : none
    	Return          : json string
    	Description     : Stores the phrase user answer multiple  for multiple user
    	*/
        function storephraseuseranswermultiple1() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid phrases
            if(!isset($api_request->phrases)) {
                $response->message = array("Invalid phrases");
                die(json_encode($response));
            } else if(!is_array($api_request->phrases )) {
                $response->message = array("Invalid phrases");
                die(json_encode($response));
            }

            $response->phrases = array();
            $counter = 0;

            //! A loop for  all the phrases
            foreach($api_request->phrases as $element) {

                $response->phrases[$counter]->success = true;
                $response->phrases[$counter]->a_id = $element->a_id;
                $response->phrases[$counter]->sentence_id = $element->sentence_id;
                $response->phrases[$counter]->type = $element->type;
                $response->phrases[$counter]->message = array();

                //! Check for valid userdata format
                if(!isset($element->user)) {
                    $response->phrases[$counter]->success = false;
                    $response->phrases[$counter]->message[] = "Invalid input / structure.";
                }

                //! Check for valid user_id
                if(!isset($element->user->id)) {
                    $response->phrases[$counter]->success = false;
                    $response->phrases[$counter]->message[] = "Invalid user id";
                } else if($element->user->id == '') {
                    $response->phrases[$counter]->success = false;
                    $response->phrases[$counter]->message[] = "Invalid user id";
                }

                //! Check for valid unique_id
                if(!isset($element->user->uid)) {
                    $response->phrases[$counter]->success = false;
                    $response->phrases[$counter]->message[] = "Invalid Unique id";
                } else if($element->user->uid == '') {
                    $response->phrases[$counter]->success = false;
                    $response->phrases[$counter]->message[] = "Invalid Unique id";
                }

                //! Find the user by user_id and unique_id
                $user = User::find_by_id_and_unique_id($element->user->id,$element->user->uid);

                //! Check if a valid user
                if(!isset($user->id)) {
                    $response->phrases[$counter]->success = false;
                    $response->phrases[$counter]->message[] = "Invalid user id";
                }

                //! Check for valid sentence_id
                if(!isset($element->sentence_id)) {
                    $response->phrases[$counter]->success = false;
                    $response->phrases[$counter]->message[] = "Invalid sentence id1";
                } else if($element->sentence_id == '') {
                    $response->phrases[$counter]->success = false;
                    $response->phrases[$counter]->message[] = "Invalid sentence id2";
                }

                //! Check for valid status
                if(!isset($element->status)) {
                    $response->phrases[$counter]->success = false;
                    $response->phrases[$counter]->message[] = "Invalid status";
                } else if($element->status != 'correct' && $element->status != 'wrong' ) {
                    $response->phrases[$counter]->success = false;
                    $response->phrases[$counter]->message[] = "Invalid status";
                }

                //! Check for valid answer
                if(!isset($element->answer)) {
                    $response->phrases[$counter]->success = false;
                    $response->phrases[$counter]->message[] = "Invalid answer";
                }

                //! Check for valid type
                if(!isset($element->type)) {
                    $response->phrases[$counter]->success = false;
                    $response->phrases[$counter]->message[] = "Invalid type";
                } else if($element->type != 'normal' && $element->type != 'test' ) {
                    $response->phrases[$counter]->success = false;
                    $response->phrases[$counter]->message[] = "Invalid type";
                }

                if($response->phrases[$counter]->success) {
                    //! Create a user phrase answer record
                    $record = PhraseUserAnswer::create(array(
                        "sentence_id" => @$element->sentence_id,
                        "user_id" => $element->user->id,
                        "status" => $element->status,
                        "user_answer" => $element->answer,
                        "score" => $element->score,
                        "type" => $element->type,
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s"),
                    ));

                    if(isset($record->id)) {
                        $response->phrases[$counter]->success = true;
                        $response->phrases[$counter]->message[] = "Phrase user answer saved";
                    } else {
                        $response->phrases[$counter]->success = false;
                        $response->phrases[$counter]->message[] = "Invalid data";
                    }
                }

                $counter++;
            }

            $response->success = true;

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : storegraphemeuserstatus()
    	Parameter       : none
    	Return          : json string
    	Description     : Stores the grapheme user status
    	*/
        function storegraphemeuserstatus() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unit
            if(!isset($api_request->unit)) {
                $response->message = array("Invalid unit");
                die(json_encode($response));
            } else if($api_request->unit == '') {
                $response->message = array("Invalid unit");
                die(json_encode($response));
            }

            //! Check for valid status
            if(!isset($api_request->status)) {
                $response->message = array("Invalid status");
                die(json_encode($response));
            } else if($api_request->status != 'pending' && $api_request->status != 'completed' ) {
                $response->message = array("Invalid status");
                die(json_encode($response));
            }

            //! Check for valid sub status
            if(!isset($api_request->sub_status)) {
                $response->message = array("Invalid sub status");
                die(json_encode($response));
            } else if($api_request->sub_status != '1' && $api_request->sub_status != '2' && $api_request->sub_status != '3' && $api_request->sub_status != '4' && $api_request->sub_status != '5' && $api_request->sub_status != '6' && $api_request->sub_status != '7' ) {
                $response->message = array("Invalid sub status");
                die(json_encode($response));
            }

            //! Check for valid score
            if(!isset($api_request->score)) {
                $response->message = array("Invalid score");
                die(json_encode($response));
            } else if($api_request->score == '') {
                $response->message = array("Invalid score");
                die(json_encode($response));
            }

            //!check the user grapheme status
            $record = GraphemeUserStatus::find_by_user_id_and_unit($api_request->user->id,$api_request->unit);

            if(!isset($record->id)) {
                //! Create a user grapheme status record
                $record = GraphemeUserStatus::create(array(
                    "unit" => @$api_request->unit,
                    "user_id" => $api_request->user->id,
                    "status" => $api_request->status,
                    "sub_status" => @$api_request->sub_status,
                    "score" => $api_request->score,
                    "total_star" => @$api_request->total_star,
                    "sub_unit" => @$api_request->sub_unit,
                    "total_point" => @$api_request->total_point,
                    "created" => date("Y-m-d H:i:s"),
                    "updated" => date("Y-m-d H:i:s"),
                ));
            } else {
                $record->status = $api_request->status;
                $record->sub_status = $api_request->sub_status;
                $record->score = $api_request->score;
                $record->total_star = @$api_request->total_star;
                $record->sub_unit = @$api_request->sub_unit;
                $record->total_point = @$api_request->total_point;
                $record->updated = date("Y-m-d H:i:s");
                $record->save();
            }

            $response->success = true;
            $response->message = array("Grapheme user status saved");

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : storegraphemeuserstatusmultiple()
    	Parameter       : none
    	Return          : json string
    	Description     : Stores the grapheme user status multiple
    	*/
        function storegraphemeuserstatusmultiple() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid graphemes
            if(!isset($api_request->graphemes)) {
                $response->message = array("Invalid graphemes");
                die(json_encode($response));
            } else if(!is_array($api_request->graphemes )) {
                $response->message = array("Invalid graphemes");
                die(json_encode($response));
            }

            $response->graphemes = array();
            $counter = 0;

            //! A loop for all the graphemes status
            foreach($api_request->graphemes as $element) {

                $response->graphemes[$counter]->success = true;
                $response->graphemes[$counter]->a_id = $element->a_id;
                $response->graphemes[$counter]->unit = $element->unit;
                $response->graphemes[$counter]->message = array();

                //! Check for valid unit
                if(!isset($element->unit)) {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid unit";
                } else if($element->unit == '') {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid unit";
                }

                //! Check for valid status
                if(!isset($element->status)) {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid status";
                }

                //! Check for valid sub status
                if(!isset($element->sub_status)) {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid sub status";
                }

                //! Check for valid score
                if(!isset($element->score)) {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid score";
                }

                if($response->graphemes[$counter]->success) {

                    //!check the user grapheme status
                    $record = GraphemeUserStatus::find_by_user_id_and_unit($api_request->user->id,$element->unit);

                    if(!isset($record->id)) {
                        //! Create a user grapheme status record
                        $record = GraphemeUserStatus::create(array(
                            "unit" => @$element->unit,
                            "user_id" => $api_request->user->id,
                            "status" => @$element->status,
                            "sub_status" => @$element->sub_status,
                            "score" => @$element->score,
                            "total_star" => @$element->total_star,
                            "sub_unit" => @$element->sub_unit,
                            "total_point" => @$element->total_point,
                            "created" => date("Y-m-d H:i:s"),
                            "updated" => date("Y-m-d H:i:s"),
                        ));
                    } else {
                        $record->status = @$element->status;
                        $record->sub_status = @$element->sub_status;
                        $record->score = @$element->score;
                        $record->total_star = @$element->total_star;
                        $record->sub_unit = @$element->sub_unit;
                        $record->total_point = @$element->total_point;
                        $record->updated = date("Y-m-d H:i:s");
                        $record->save();
                    }

                    $response->graphemes[$counter]->success = true;
                    $response->graphemes[$counter]->message[] = "Grapheme user status saved";
                }

                $counter++;
            }

            $response->success = true;

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : storegraphemeuserstatusmultiple1()
    	Parameter       : none
    	Return          : json string
    	Description     : Stores the grapheme user status multiple for multiple users
    	*/
        function storegraphemeuserstatusmultiple1() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid graphemes
            if(!isset($api_request->graphemes)) {
                $response->message = array("Invalid graphemes");
                die(json_encode($response));
            } else if(!is_array($api_request->graphemes )) {
                $response->message = array("Invalid graphemes");
                die(json_encode($response));
            }

            $response->graphemes = array();
            $counter = 0;

            //! A loop for all the graphemes status
            foreach($api_request->graphemes as $element) {

                $response->graphemes[$counter]->success = true;
                $response->graphemes[$counter]->a_id = $element->a_id;
                $response->graphemes[$counter]->unit = $element->unit;
                $response->graphemes[$counter]->message = array();

                //! Check for valid userdata format
                if(!isset($element->user)) {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid input / structure.";
                }

                //! Check for valid user_id
                if(!isset($element->user->id)) {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid user id";
                } else if($element->user->id == '') {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid user id";
                }

                //! Check for valid unique_id
                if(!isset($element->user->uid)) {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid Unique id";
                } else if($element->user->uid == '') {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid Unique id";
                }

                //! Find the user by user_id and unique_id
                $user = User::find_by_id_and_unique_id($element->user->id,$element->user->uid);

                //! Check if a valid user
                if(!isset($user->id)) {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid user id";
                }

                //! Check for valid unit
                if(!isset($element->unit)) {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid unit";
                } else if($element->unit == '') {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid unit";
                }

                //! Check for valid status
                if(!isset($element->status)) {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid status";
                }

                //! Check for valid sub status
                if(!isset($element->sub_status)) {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid sub status";
                }

                //! Check for valid score
                if(!isset($element->score)) {
                    $response->graphemes[$counter]->success = false;
                    $response->graphemes[$counter]->message[] = "Invalid score";
                }

                if($response->graphemes[$counter]->success) {

                    //!check the user grapheme status
                    $record = GraphemeUserStatus::find_by_user_id_and_unit($element->user->id,$element->unit);

                    if(!isset($record->id)) {
                        //! Create a user grapheme status record
                        $record = GraphemeUserStatus::create(array(
                            "unit" => @$element->unit,
                            "user_id" => $element->user->id,
                            "status" => @$element->status,
                            "sub_status" => @$element->sub_status,
                            "score" => @$element->score,
                            "total_star" => @$element->total_star,
                            "sub_unit" => @$element->sub_unit,
                            "total_point" => @$element->total_point,
                            "created" => date("Y-m-d H:i:s"),
                            "updated" => date("Y-m-d H:i:s"),
                        ));
                    } else {
                        $record->status = @$element->status;
                        $record->sub_status = @$element->sub_status;
                        $record->score = @$element->score;
                        $record->total_star = @$element->total_star;
                        $record->sub_unit = @$element->sub_unit;
                        $record->total_point = @$element->total_point;
                        $record->updated = date("Y-m-d H:i:s");
                        $record->save();
                    }

                    $response->graphemes[$counter]->success = true;
                    $response->graphemes[$counter]->message[] = "Grapheme user status saved";
                }

                $counter++;
            }

            $response->success = true;

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : getgraphemeuserstatus()
    	Parameter       : none
    	Return          : json string
    	Description     : Gets the all grapheme user status
    	*/
        function getgraphemeuserstatus() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Get all the user grapheme status
            $grapheme_user_status = GraphemeUserStatus::find_all_by_user_id($api_request->user->id);

            $response->graphemes = array();

            foreach($grapheme_user_status as $val) {
                $grapheme = new stdClass;
                $grapheme->unit = $val->unit;
                $grapheme->status = $val->status;
                $grapheme->sub_status = $val->sub_status;
                $grapheme->score = $val->score;
                $grapheme->total_star = $val->total_star;
                $grapheme->sub_unit = $val->sub_unit;
                $grapheme->total_point = $val->total_point;
                $response->graphemes[] = $grapheme;
            }

            $response->success = true;
            $response->message = array("User all grapheme status details");

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : setusertransaction()
    	Parameter       : none
    	Return          : json string
    	Description     : Set user transactino details
    	*/
        function setusertransaction() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            if(@$api_request->order_id == '') {
                $oi =  "ORDER" . ((1 + rand(1,8)) * 10000) . rand(1000,9999);
                $api_request->order_id = $oi;
            }

            $transactionDetails = Transaction::create(array(
                "user_id" => $api_request->user->id,
                "amount" => $api_request->amount,
                "currency" => $api_request->currency,
                "request_id" => $api_request->request_id,
                "order_id" => $api_request->order_id,
                "status" => $api_request->status,
                "customer_code" => $api_request->customer_code,
                "transaction_id" => $api_request->transaction_id,
                "transaction_date" => $api_request->transaction_date,
                "request_item" => $api_request->request_item,
                "error_code" => $api_request->error_code,
                "error_message" => $api_request->error_message,
                "purchase_day" => $api_request->purchase_day,
                "type" => $api_request->type,
                "created" => date("Y-m-d H:i:s"),
                "updated" => date("Y-m-d H:i:s"),
            ));

            if($api_request->status == "successful" ) {
                $user->expire_date = $api_request->expire_date;
                $user->updated = date("Y-m-d H:i:s");
                $user->save();

                if($user->email!= '') {
                    //! Retrieve the email template
                    $email_content = get_email_template(3);
                    $subject = $email_content['subject'];
                    $subject = str_replace('::order_number::',$api_request->order_id,$subject);
                    $body = $email_content['body'];
                    $body = str_replace('::name::',ucwords($user->name()),$body);
                    $body = str_replace('::order_number::',$api_request->order_id,$body);
                    $body = str_replace('::date::',date("d/m/Y"),$body);
                    $body = str_replace('::amount::',$api_request->amount,$body);
                    $this->email_template($user->email,$subject,$body);
                } else {
                    //! Send sms for the mobile verification
                    $merror = sendsms(5, $user->mobile, array($user->name(), $api_request->amount,  $api_request->order_id));
                }
            }

            $response->success = true;
            $response->message = array("Transaction Details saved");

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : applypromocode()
    	Parameter       : none
    	Return          : json string
    	Description     : Apply promocode for the user
    	*/
        function applypromocode() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Check for valid promocode
            if(!isset($api_request->promocode)) {
                $response->message = array("Invalid Promocode");
                die(json_encode($response));
            } else if($api_request->promocode == '') {
                $response->message = array("Invalid Promocode");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user");
                die(json_encode($response));
            }

            //! Find the promocode
            $promocode = Promocode::find_by_promocode($api_request->promocode);

            //! Check if a valid promocode
            if(!isset($promocode->id)) {
                $response->message = array("Invalid promocode");
                die(json_encode($response));
            }

            //! Check for valid promocode
            if(date("Ymd") < $promocode->start_date->format("Ymd")) {
                $response->message = array("Promocode '".$api_request->promocode."' can be used from " . $promocode->start_date->format("d/m/Y"));
                die(json_encode($response));
            } else if(date("Ymd") > $promocode->end_date->format("Ymd")){
                $response->message = array("Promocode '".$api_request->promocode."' has expired.");
                die(json_encode($response));
            } else if($promocode->count <= 0){
                $response->message = array("Promocode '".$api_request->promocode."' has been used.");
                die(json_encode($response));
            }

            $promo_type = "normal";

			$amt = explode(",",$promocode->amount);

            if(isset($amt[1])) {
				$promo_type = "special";
			}

            if($promo_type != "special") {

                $usedpromo = PromocodeUsed::find_by_user_id_and_promocode_id($api_request->user->id,$promocode->id);

                if(isset($usedpromo->id)) {
                    $response->message = array("Promocode '".$api_request->promocode."' has been used.");
                    die(json_encode($response));
                }
            } else {
                $usedpromo = PromocodeUsed::find_by_user_id_and_promocode_id($api_request->user->id,$promocode->id);

                if(isset($usedpromo->id)) {
                    $trans = Transaction::find("all",array(
                        "conditions" => " user_id = '".$api_request->user->id."' AND status = 'successful' AND transaction_date >= '".$usedpromo->promocode_used_date->format("Y-m-d H:i:s")."' AND amount IN (".$usedpromo->amount.") "
                    ));

                    if(isset($trans[0])) {
                        $response->message = array("Promocode '".$api_request->promocode."' has been used.");
                        die(json_encode($response));
                    }
                }
            }

            $promocode->count -= 1;
            $promo_image = "";
            if($promocode->promo_image != "") {
				$promo_image = base_url("images/" . $promocode->promo_image);
			}
			
			$promocode->save();

            $promocodeused = PromocodeUsed::create(array(
                "user_id" => $api_request->user->id,
                "promocode" => $api_request->promocode,
                "promocode_id" => $promocode->id,
                "status" => "successful",
                "amount" => $promocode->amount,
                "days" => $promocode->days,
                "promocode_used_date" => date("Y-m-d H:i:s"),
                "created" => date("Y-m-d H:i:s"),
                "updated" => date("Y-m-d H:i:s"),
            ));

			$expire_date = "";
			if($promo_type != "special") {
				
				if(date("Ymd") >= $user->expire_date->format("Ymd")) {
					$expire_date = date("Y-m-d",mktime(1,1,1,date("m"),date("d") + $promocode->days,date("Y")));
				} else {
					$expire_date = date("Y-m-d" , mktime(1,1,1,$user->expire_date->format("m"),$user->expire_date->format("d") + $promocode->days,$user->expire_date->format("Y")));
				}

				$user->expire_date = $expire_date;
				$user->updated = date("Y-m-d H:i:s");
				$user->save();
			}

            $response->success = true;
            $response->promo_type = $promo_type;
            $response->expire_date = $expire_date;
            $response->promo_image = $promo_image;
            $response->amount = $promocode->amount;
            $response->days = $promocode->days;
            $response->message = array("Promocode applied successfully!");

            //! convert json object to string
            die(json_encode($response));
        }

        function getnewcover() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;
            $response->update = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Check for valid element
            if(!isset($api_request->count)) {
                $response->message = array("Invalid story count");
                die(json_encode($response));
            } else if($api_request->count == '') {
                $response->message = array("Invalid story count");
                die(json_encode($response));
            }

            //! Check for valid element
            if(!isset($api_request->story_ids)) {
                $response->message = array("Invalid story ids");
                die(json_encode($response));
            } else if($api_request->story_ids == '') {
                $response->message = array("Invalid story ids");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user");
                die(json_encode($response));
            }

            //! Find All the story cover
            $stories_count = Story::count(array(
                "conditions" => " status = 'active' "
            ));

            //if($stories_count == $api_request->count) {
                $response->success = true;
                $response->update = false;
                $response->message = array("Story Cover uptodate");
                die(json_encode($response));
            //}

            //! Find All the story cover
            $stories = Story::find("all",array(
                "conditions" => " status = 'active' AND id NOT IN (".$api_request->story_ids.") ",
                "order" => "level,name ASC"
            ));

            //! Setting All stories
            $response->stories = array();

            //! Loop through all the stories
            foreach( $stories as $val ) {
                $story = new stdClass;
                $story->id = $val->id;
                $story->name = $val->name;
                $story->level = $val->level;

                if($val->image != '') {
                    $story->image = $val->image;
                    $story->image_base64 = $this->getimagebase64("story/" . $val->image,1000);
                } else {
                    $story->image = '';
                    $story->image_base64 = '';
                }

                $response->stories[] = $story;
            }

            $response->success = true;
            $response->update = true;
            $response->message = array("Stories Cover retrieved");

            die(json_encode($response));
        }


        /**********************************************************************
         * Admin functionality Do Not touch anything below not public api     *
         **********************************************************************/


        /*
    	Function name   : getstoryforid()
    	Parameter       : $story_id - int - Story ID
    	Return          : story - json object
    	Description     : gets all story details in json string
    	*/
        private function getstoryforid($story_id = '') {

            //! Find the story
            $storydb = Story::find($story_id);

            //! Story Object
            $story = new stdClass;
            $story->id = $storydb->id;
            $story->name = $storydb->name;
            $story->writtenby = $storydb->writtenby;
            $story->illustrationsby = $storydb->illustrationsby;
            $story->translationby = $storydb->translationby;
            $story->source = $storydb->source;
            //$story->language = $storydb->language->name;

            /*if($storydb->image != '') {
                $story->image = $storydb->image;
                $story->image_base64 = $this->getimagebase64("story/" . $story->image,1000);
            } else {
                $story->image = '';
                $story->image_base64 = '';
            }*/

            $story->status = $storydb->status;
            $story->level = $storydb->level;

            $story->pages = array();

            $lang = array();

            //! For all the story page
            foreach($storydb->storypage as $spage) {
                $page = new stdClass;
                $page->id = $spage->id;
                $page->content = $spage->content;
                $page->pageno = $spage->pageno;

                if($spage->image != '') {
                    $page->image = $spage->image;
                    $page->image_base64 = $this->getimagebase64("story/" . $spage->image,0);
                    if( $page->image_base64 == '') {
                        $page->image = '';
                    }
                } else {
                    $page->image = '';
                    $page->image_base64 = '';
                }

                if($spage->audio != '') {
                    $page->audio = $spage->audio;
                    $page->audio_base64 = $this->getaudiobase64("story/" . $spage->audio);
                } else {
                    $page->audio = '';
                    $page->audio_base64 = '';
                }

                if($spage->audio_map != '') {
                    $page->audio_map = $spage->audio_map;
                    $page->audio_map_obj = json_decode(file_get_contents("story/" . $spage->audio_map));
                } else {
                    $page->audio_map = '';
                    $page->audio_map_obj = '';
                }

                $page->language = array();
                foreach($spage->storypage_language as $sl) {
                    $slobj = new stdClass;
                    $slobj->language_id = $sl->language_id;
                    $slobj->content = $sl->content;
                    $page->language[] = $slobj;

                    $langg = new stdClass;
                    $langg->id = $sl->language_id;
                    $langg->name = $sl->language->name;
                    $lang[$sl->language_id] = $langg;
                }

                $story->pages[] = $page;
            }

            $story->language = array();
            foreach($lang as $vall) {
                $story->language[] = $vall;
            }

            //! All the story questions
            $story->questions = array();


            foreach($storydb->story_question_linkage as $squestion) {
                if($squestion->question->status == 'active') {
                    $question_obj = json_decode($squestion->question->question);
                    //if( $question_obj->question_type != "match_column" && $question_obj->question_type != "fill_blank" ) {
                    $question = new stdClass;
                    $question->id = $squestion->question_id;
                    $question->type = $squestion->type;
                    $question->storypage_id = $squestion->storypage_id;
                    $question->order_number = $squestion->order_number;
                    $question->title = $squestion->question->title;

                    if($question_obj->question->image != '') {
                        $question_obj->question->image_base64 = $this->getimagebase64("question/" . $question_obj->question->image,0);
                        if( $question_obj->question->image_base64 == '') {
                            $question_obj->question->image = '';
                        }
                    } else {
                        $question_obj->question->image_base64 = '';
                    }

                    //! Question types
                    if($question_obj->question_type == 'mcq_single_answer' || $question_obj->question_type == 'mcq_multiple_answer') {
                        for($ii = 0 ; $ii < count($question_obj->options) ; $ii++) {
                            if($question_obj->options[$ii]->image != '') {
                                $question_obj->options[$ii]->image_base64 = $this->getimagebase64("question/" . $question_obj->options[$ii]->image,200);
                                if( $question_obj->options[$ii]->image_base64 == '') {
                                    $question_obj->options[$ii]->image = '';
                                }
                            } else {
                                $question_obj->options[$ii]->image_base64 = '';
                            }
                        }
                    } else if($question_obj->question_type == 'match_column') {
                        for($ii = 0 ; $ii < count($question_obj->column1) ; $ii++) {
                            if($question_obj->column1[$ii]->image != '') {
                                $question_obj->column1[$ii]->image_base64 = $this->getimagebase64("question/" . $question_obj->column1[$ii]->image,200);
                                if( $question_obj->column1[$ii]->image_base64 == '') {
                                    $question_obj->column1[$ii]->image = '';
                                }
                            } else {
                                $question_obj->column1[$ii]->image_base64 = '';
                            }
                        }
                        for($ii = 0 ; $ii < count($question_obj->column2) ; $ii++) {
                            if($question_obj->column2[$ii]->image != '') {
                                $question_obj->column2[$ii]->image_base64 = $this->getimagebase64("question/" . $question_obj->column2[$ii]->image,200);
                                if( $question_obj->column2[$ii]->image_base64 == '') {
                                    $question_obj->column2[$ii]->image = '';
                                }
                            } else {
                                $question_obj->column2[$ii]->image_base64 = '';
                            }
                        }
                    } else if($question_obj->question_type == 'vocabulary') {
                        for($ii = 0 ; $ii < count($question_obj->words) ; $ii++) {
                            if($question_obj->words[$ii]->image != '') {
                                $question_obj->words[$ii]->image_base64 = $this->getimagebase64("question/" . $question_obj->words[$ii]->image,200);
                                if( $question_obj->words[$ii]->image_base64 == '') {
                                    $question_obj->words[$ii]->image = '';
                                }
                            } else {
                                $question_obj->words[$ii]->image_base64 = '';
                            }
                        }
                    } else if($this->input->post('question_type') == 'conversation') {
                        for($ii = 0 ; $ii < count($question_obj->conversation) ; $ii++) {
                            if($question_obj->conversation[$ii]->image != '') {
                                $question_obj->conversation[$ii]->image_base64 = $this->getimagebase64("question/" . $question_obj->conversation[$ii]->image,200);
                                if( $question_obj->conversation[$ii]->image_base64 == '') {
                                    $question_obj->conversation[$ii]->image = '';
                                }
                            } else {
                                $question_obj->conversation[$ii]->image_base64 = '';
                            }
                        }
                    }

                    $question->question = $question_obj;
                    $question->score = $squestion->question->score;
                    $question->question_template_id = $squestion->question->question_template_id;
                    $question->question_template = @$squestion->question->question_template->name;

                    $story->questions[] = $question;
                    //}
                }
            }

            return $story;
        }

        /*
    	Function name   : getstoryforid()
    	Parameter       : $story_id - int - Story ID
    	Return          : story - json object
    	Description     : gets all story details in json string
    	*/
        private function getstoryforidzip($story_id = '') {
            //include_once("zip/CreateZipFile.inc.php");

            $zipName="story/story_".$story_id.".zip";
            $createZipFile = new ZipArchive;
            $createZipFile->open($zipName, ZipArchive::CREATE|ZipArchive::OVERWRITE);

            //! Find the story
            $storydb = Story::find($story_id);

            //! Story Object
            $story = new stdClass;
            $story->id = $storydb->id;
            $story->name = $storydb->name;
            $story->writtenby = $storydb->writtenby;
            $story->illustrationsby = $storydb->illustrationsby;
            $story->translationby = $storydb->translationby;
            $story->source = $storydb->source;

            $story->status = $storydb->status;
            $story->level = $storydb->level;

            $story->pages = array();

            $lang = array();

            //! For all the story page
            foreach($storydb->storypage as $spage) {
                $page = new stdClass;
                $page->id = $spage->id;
                $page->content = $spage->content;
                $page->pageno = $spage->pageno;

                if($spage->image != '') {
                    $page->image = $spage->image;
                    $createZipFile->addFile("story/" . $spage->image,$spage->image);
                } else {
                    $page->image = '';
                }

                if($spage->audio != '') {
                    $page->audio = $spage->audio;
                    $createZipFile->addFile("story/" . $spage->audio,$spage->audio);
                } else {
                    $page->audio = '';
                }

                if($spage->audio_map != '') {
                    $page->audio_map = $spage->audio_map;
                    $createZipFile->addFile("story/" . $spage->audio_map,$spage->audio_map);
                } else {
                    $page->audio_map = '';
                    $page->audio_map_obj = '';
                }

                $page->language = array();
                foreach($spage->storypage_language as $sl) {
                    $slobj = new stdClass;
                    $slobj->language_id = $sl->language_id;
                    $slobj->content = $sl->content;
                    $page->language[] = $slobj;

                    $langg = new stdClass;
                    $langg->id = $sl->language_id;
                    $langg->name = $sl->language->name;
                    $lang[$sl->language_id] = $langg;
                }

                $story->pages[] = $page;
            }

            $story->language = array();
            foreach($lang as $vall) {
                $story->language[] = $vall;
            }

            //! All the story questions
            $story->questions = array();


            foreach($storydb->story_question_linkage as $squestion) {
                if($squestion->question->status == 'active') {
                    $question_obj = json_decode($squestion->question->question);
                    //if( $question_obj->question_type != "match_column" && $question_obj->question_type != "fill_blank" ) {
                    $question = new stdClass;
                    $question->id = $squestion->question_id;
                    $question->type = $squestion->type;
                    $question->storypage_id = $squestion->storypage_id;
                    $question->order_number = $squestion->order_number;
                    $question->title = $squestion->question->title;

                    if($question_obj->question->image != '') {
                        $createZipFile->addFile("question/" . $question_obj->question->image,$question_obj->question->image);
                    }

                    //! Question types
                    if($question_obj->question_type == 'mcq_single_answer' || $question_obj->question_type == 'mcq_multiple_answer') {
                        for($ii = 0 ; $ii < count($question_obj->options) ; $ii++) {
                            if($question_obj->options[$ii]->image != '') {
                                $createZipFile->addFile("question/" . $question_obj->options[$ii]->image,$question_obj->options[$ii]->image);
                            }
                        }
                    } else if($question_obj->question_type == 'match_column') {
                        for($ii = 0 ; $ii < count($question_obj->column1) ; $ii++) {
                            if($question_obj->column1[$ii]->image != '') {
                                $createZipFile->addFile("question/" . $question_obj->column1[$ii]->image,$question_obj->column1[$ii]->image);
                            }
                        }
                        for($ii = 0 ; $ii < count($question_obj->column2) ; $ii++) {
                            if($question_obj->column2[$ii]->image != '') {
                                $createZipFile->addFile("question/" . $question_obj->column2[$ii]->image,$question_obj->column2[$ii]->image);
                            }
                        }
                    } else if($question_obj->question_type == 'vocabulary') {
                        for($ii = 0 ; $ii < count($question_obj->words) ; $ii++) {
                            if($question_obj->words[$ii]->image != '') {
                                $createZipFile->addFile("question/" . $question_obj->words[$ii]->image,$question_obj->words[$ii]->image);
                            }
                        }
                    } else if($this->input->post('question_type') == 'conversation') {
                        for($ii = 0 ; $ii < count($question_obj->conversation) ; $ii++) {
                            if($question_obj->conversation[$ii]->image != '') {
                                $createZipFile->addFile("question/" . $question_obj->conversation[$ii]->image,$question_obj->conversation[$ii]->image);
                            }
                        }
                    }

                    $question->question = $question_obj;
                    $question->score = $squestion->question->score;
                    $question->question_template_id = $squestion->question->question_template_id;
                    $question->question_template = @$squestion->question->question_template->name;

                    $story->questions[] = $question;
                    //}
                }
            }


            $createZipFile->addFromString($story_id.".json",json_encode($story));
            $createZipFile->close();

            //$fd = fopen("story/" . $zipName, "wb");
            //$out = fwrite($fd,$createZipFile->getZippedfile());
            //fclose($fd);
            //$createZipFile->forceDownload($zipName);
            return $story;
        }

        /*
    	Function name   : getgraphemeforid()
    	Parameter       : $grapheme_id - int - Grapheme ID
    	Return          : grapheme - json object
    	Description     : gets grapheme details in json string
    	*/
        private function getgraphemeforid($grapheme_id = '') {

            //! Find the Grapheme
            $graphemedb = Grapheme::find($grapheme_id);

            //! Grapheme Object
            $grapheme = new stdClass;
            $grapheme->id = $graphemedb->id;
            $grapheme->grapheme = $graphemedb->grapheme;
            $grapheme->phoneme = $graphemedb->phoneme;
            //$grapheme->script = $graphemedb->script;
            $grapheme->unit = $graphemedb->units_id;

            //! Grapheme image
            /*if($graphemedb->image != '') {
                $grapheme->image = $graphemedb->image;
                $grapheme->image_base64 = $this->getimagebase64("contentfiles/grapheme/" . $graphemedb->image,400);
                if($grapheme->image_base64 == '') {
                    $grapheme->image = '';
                }
            } else {*/
                $grapheme->image = '';
                $grapheme->image_base64 = '';
            //}

            //! Grapheme audio
            if($graphemedb->audio != '') {
                $grapheme->audio = $graphemedb->audio;
                $grapheme->audio_base64 = $this->getaudiobase64("contentfiles/grapheme/" . $graphemedb->audio);
                if($grapheme->audio_base64 == '') {
                    $grapheme->audio = '';
                }
            } else {
                $grapheme->audio = '';
                $grapheme->audio_base64 = '';
            }

            //! Primary word
            $grapheme->primary_word = new stdClass;
            $grapheme->primary_word->id = $graphemedb->grapheme_word_linkage_primary[0]->word->id;
            $grapheme->primary_word->word = $graphemedb->grapheme_word_linkage_primary[0]->word->word;
            $grapheme->primary_word->hindi_translation = $graphemedb->grapheme_word_linkage_primary[0]->word->hindi_translation;
            $grapheme->primary_word->marathi_translation = $graphemedb->grapheme_word_linkage_primary[0]->word->marathi_translation;
            $grapheme->primary_word->grapheme_index = $graphemedb->grapheme_word_linkage_primary[0]->grapheme_index;

            //! Primary word image
            if($graphemedb->grapheme_word_linkage_primary[0]->word->image != '') {
                $grapheme->primary_word->image = $graphemedb->grapheme_word_linkage_primary[0]->word->image;
                $grapheme->primary_word->image_base64 = $this->getimagebase64("contentfiles/word/" . $graphemedb->grapheme_word_linkage_primary[0]->word->image,400,false);
                if($grapheme->primary_word->image_base64 == '') {
                    $grapheme->primary_word->image = '';
                }
            } else {
                $grapheme->primary_word->image = '';
                $grapheme->primary_word->image_base64 = '';
            }

            //! Primary word audio
            /*if($graphemedb->grapheme_word_linkage_primary[0]->word->audio != '') {
                $grapheme->primary_word->audio = $graphemedb->grapheme_word_linkage_primary[0]->word->audio;
                $grapheme->primary_word->audio_base64 = $this->getaudiobase64("contentfiles/word/" . $graphemedb->grapheme_word_linkage_primary[0]->word->audio);
                if($grapheme->primary_word->audio_base64 == '') {
                    $grapheme->primary_word->audio = '';
                }
            } else {*/
                $grapheme->primary_word->audio = '';
                $grapheme->primary_word->audio_base64 = '';
            //}

            //! For additional words
            $grapheme->words = array();

            foreach($graphemedb->grapheme_word_linkage as $gw_linkage) {

                $word = new stdClass;
                $word->id = $gw_linkage->word->id;
                $word->word = $gw_linkage->word->word;
                $word->hindi_translation = $gw_linkage->word->hindi_translation;
                $word->marathi_translation = $gw_linkage->word->marathi_translation;
                $word->grapheme_index = $gw_linkage->grapheme_index;

                //! additional word image
                /*if($gw_linkage->word->image != '') {
                    $word->image = $gw_linkage->word->image;
                    $word->image_base64 = $this->getimagebase64("contentfiles/word/" . $gw_linkage->word->image,0);
                    if($word->image_base64 == '') {
                        $word->image = '';
                    }
                } else {*/
                    $word->image = '';
                    $word->image_base64 = '';
                //}

                //! additional word audio
                /*if($gw_linkage->word->audio != '') {
                    $word->audio = $gw_linkage->word->audio;
                    $word->audio_base64 = $this->getaudiobase64("contentfiles/word/" . $gw_linkage->word->audio);
                    if($word->audio_base64 == '') {
                        $word->audio = '';
                    }
                } else {*/
                    $word->audio = '';
                    $word->audio_base64 = '';
                //}

                $grapheme->words[] = $word;
            }

            return $grapheme;
        }

        /*
    	Function name   : getphraseforid()
    	Parameter       : $phrase_id - int - Phrase ID
    	Return          : phrase - json object
    	Description     : gets phrase details in json string
    	*/
        private function getphraseforid($phrase_id = '') {

            //! Find the Phrase
            $phrasedb = Phrase::find($phrase_id);

            //! Phrase Object
            $phrase = new stdClass;
            $phrase->id = $phrasedb->id;
            $phrase->phrase = $phrasedb->phrase;
            $phrase->level = $phrasedb->level;
            $phrase->unit = $phrasedb->units_id;
            $phrase->grapheme_id = $phrasedb->grapheme_id;

            //! Phrase image
            if($phrasedb->image != '') {
                $phrase->image = $phrasedb->image;
                $phrase->image_base64 = $this->getimagebase64("contentfiles/phrase/" . $phrasedb->image,200);
                if($phrase->image_base64 == '') {
                    $phrase->image = '';
                }
            } else {
                $phrase->image = '';
                $phrase->image_base64 = '';
            }

            //! Phrase audio
            if($phrasedb->audio != '') {
                $phrase->audio = $phrasedb->audio;
                $phrase->audio_base64 = $this->getaudiobase64("contentfiles/phrase/" . $phrasedb->audio);
                if($phrase->audio_base64 == '') {
                    $phrase->audio = '';
                }
            } else {
                $phrase->audio = '';
                $phrase->audio_base64 = '';
            }

            //! For sentences
            $phrase->sentences = array();

            foreach($phrasedb->phrase_sentence_linkage as $ps_linkage) {
                $sentence = new stdClass;
                $sentence->id = $ps_linkage->sentence->id;
                $sentence->sentence = $ps_linkage->sentence->sentence;
                $sentence->order_number = $ps_linkage->order_number;

                //! sentence  image
                if($ps_linkage->sentence->image != '') {
                    $sentence->image = $ps_linkage->sentence->image;
                    $sentence->image_base64 = $this->getimagebase64("contentfiles/sentence/" . $ps_linkage->sentence->image,200);
                    if($sentence->image_base64 == '') {
                        $sentence->image = '';
                    }
                } else {
                    $sentence->image = '';
                    $sentence->image_base64 = '';
                }

                //! additional word audio
                if($ps_linkage->sentence->audio != '') {
                    $sentence->audio = $ps_linkage->sentence->audio;
                    $sentence->audio_base64 = $this->getaudiobase64("contentfiles/sentence/" . $ps_linkage->sentence->audio);
                    if($sentence->audio_base64 == '') {
                        $sentence->audio = '';
                    }
                } else {
                    $sentence->audio = '';
                    $sentence->audio_base64 = '';
                }

                $phrase->sentences[] = $sentence;
            }

            return $phrase;
        }

        /*
    	Function name   : getwordsegmentforid()
    	Parameter       : $wordsegment_id - int - Wordsegment ID
    	Return          : wordsegment - json object
    	Description     : gets wordsegment details in json string
    	*/
        private function getwordsegmentforid($wordsegment_id = '') {

            //! Find the Worsegment
            $wordsegmentdb = Wordsegment::find($wordsegment_id);

            //! Wordsegment Object
            $wordsegment = new stdClass;
            $wordsegment->id = $wordsegmentdb->id;
            $wordsegment->word = $wordsegmentdb->word;
            $wordsegment->unit = $wordsegmentdb->unit;
            $wordsegment->level = $wordsegmentdb->level;
            $wordsegment->hindi_translation = $wordsegmentdb->hindi_translation;
            $wordsegment->marathi_translation = $wordsegmentdb->marathi_translation;

            //! For graphemes
            $wordsegment->graphemes = array();

            foreach($wordsegmentdb->graphemes as $val) {

                $grapheme = new stdClass;
                $grapheme->id = $val->grapheme->id;
                $grapheme->grapheme = $val->grapheme->grapheme;
                $grapheme->segment = $val->segment;
                $grapheme->order_number = $val->order_number;

                $wordsegment->graphemes[] = $grapheme;
            }

            return $wordsegment;
        }

        /*
    	Function name   : getphonemestoryforid()
    	Parameter       : $phonemestory_id - int - Phoneme story ID
    	Return          : phoneme story - json object
    	Description     : gets phoneme story details in json
    	*/
        private function getphonemestoryforid($phonemestory_id = '') {

            //! Find the Phoneme story
            $phonemestorydb = PhonemeStory::find($phonemestory_id);

            //! phoneme story Object
            $phonemestory = new stdClass;
            $phonemestory->id = $phonemestorydb->id;
            $phonemestory->title = $phonemestorydb->title;
            $phonemestory->unit = $phonemestorydb->unit;
            $phonemestory->story = $phonemestorydb->story;
            $phonemestory->story = $phonemestorydb->story;

            //! phoneme story image
            if($phonemestorydb->image != '') {
                $phonemestory->image = $phonemestorydb->image;
                $phonemestory->image_base64 = $this->getimagebase64("contentfiles/phoneme_story/" . $phonemestorydb->image,200);
                if($phonemestory->image_base64 == '') {
                    $phonemestory->image = '';
                }
            } else {
                $phonemestory->image = '';
                $phonemestory->image_base64 = '';
            }

            //! phoneme story audio
            if($phonemestorydb->audio != '') {
                $phonemestory->audio = $phonemestorydb->audio;
                $phonemestory->audio_base64 = $this->getaudiobase64("contentfiles/phoneme_story/" . $phonemestorydb->audio);
                if($phonemestory->audio_base64 == '') {
                    $phonemestory->audio = '';
                }
            } else {
                $phonemestory->audio = '';
                $phonemestory->audio_base64 = '';
            }

            return $phonemestory;
        }

        /*
    	Function name   : getstorytextbookforid()
    	Parameter       : $id - int - ID
    	Return          : textbook - json object
    	Description     : gets textbook details in json string
    	*/
        private function getstorytextbookforid($id = '') {

            //! Find the StoryTextbook
            $data = StoryTextbook::find($id);

            //! StoryTextbook Object
            $book = new stdClass;
            $book->id = $data->id;
            $book->title = $data->title;
            $book->title_hindi = $data->title_hindi;
            $book->title_marathi = $data->title_marathi;
            $book->content = $data->content;
            $book->content_hindi = $data->content_hindi;
            $book->content_marathi = $data->content_marathi;
            $book->unit = $data->unit;
            $book->class = $data->class;
            $book->board = $data->board;
            $book->order_number = $data->order_number;
            $book->page_number = $data->page_number;
            $book->source = $data->source;
            $book->author = $data->author;

            if($data->audio != '') {
                $book->audio = $data->audio;
                $book->audio_base64 = $this->getaudiobase64("contentfiles/textbook/" . $data->audio);
                if($book->audio_base64 == '') {
                    $book->audio = '';
                }
            } else {
                $book->audio = '';
                $book->audio_base64 = '';
            }

            if($data->image != '') {
                $book->image = $data->image;
                $book->image_base64 = $this->getaudiobase64("contentfiles/textbook/" . $data->image);
                if($book->image_base64 == '') {
                    $book->image = '';
                }
            } else {
                $book->image = '';
                $book->image_base64 = '';
            }

            return $book;
        }

        /*
    	Function name   : getwordgroupforid()
    	Parameter       : $id - int - ID
    	Return          : word group - json object
    	Description     : gets word group details in json string
    	*/
        private function getwordgroupforid($id = '') {

            //! Find the StoryTextbookGroup
            $data = StoryTextbookGroup::find($id);

            //! StoryTextbook Object
            $group = new stdClass;
            $group->id = $data->id;
            $group->name = $data->name;
            $group->unit = $data->unit;
            $group->class = $data->class;
            $group->board = $data->board;
            $group->source = $data->source;
            $group->page_number = $data->page_number;

            //! For words
            $group->words = array();

            foreach($data->story_textbook_group_word_linkage as $val) {

                $word = new stdClass;
                $word->id = $val->word->id;
                $word->word = $val->word->word;
                $word->level = $val->word->level;
                $word->hindi_translation = $val->word->hindi_translation;
                $word->marathi_translation = $val->word->marathi_translation;
                $word->defination = $val->word->defination;
                $word->example = $val->word->example;
                $word->order_number = $val->order_number;

                if($val->word->audio != '') {
                    $word->audio = $val->word->audio;
                    $word->audio_base64 = $this->getaudiobase64("contentfiles/word/" . $val->word->audio);
                    if($word->audio_base64 == '') {
                        $word->audio = '';
                    }
                } else {
                    $word->audio = '';
                    $word->audio_base64 = '';
                }

                if($val->word->image != '') {
                    $word->image = $val->word->image;
                    $word->image_base64 = $this->getaudiobase64("contentfiles/word/" . $val->word->image);
                    if($word->image_base64 == '') {
                        $word->image = '';
                    }
                } else {
                    $word->image = '';
                    $word->image_base64 = '';
                }

                $group->words[] = $word;
            }

            return $group;
        }

        /*
    	Function name   : getimagebase64()
    	Parameter       : $image - string - image name
                          $newwidth - int - resize image width
    	Return          : base64 image with new width - string
    	Description     : Gets the base 64 image with resized width
    	*/
        private function getimagebase64($image = '' , $newwidth = 100, $resizegreater = false) {
            if(file_exists($this->config->item("root_url") .$image)) {
                $image_url = base_url($image );
                $type = pathinfo($this->config->item("root_url") .$image, PATHINFO_EXTENSION);

                //! If want to retain the original image if 0 => retain original else resize to newwidth
                if($newwidth != 0) {
                    // resize
                    list($width, $height) = getimagesize($this->config->item("root_url") .$image );

                    $dothis = 1;
                    if($resizegreater) {
                        $dothis = 0;
                        if( $width > $newwidth ) {
                            $dothis = 1;
                        }
                    }

                    if($dothis == 1) {
                        $percent  = $newwidth / $width;
                        $newheight = $height * $percent;
                        $thumb = imagecreatetruecolor($newwidth, $newheight);

                        if(strtolower($type) == 'jpg' || strtolower($type) == 'jpeg' ) {
                            $source = imagecreatefromjpeg($image_url);
                        } else {
                            $source = imagecreatefrompng($image_url);
                            imagealphablending($thumb, false);
                            imagesavealpha($thumb, true);
                            imagealphablending($source, true);
                        }

                        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

                        // Output
                        if(strtolower($type) == 'jpg' || strtolower($type) == 'jpeg' ) {
                            imagejpeg($thumb,$this->config->item("root_url") . "story/test.jpg",50);
                            $image_url = base_url("story/test.jpg" );
                        } else {
                            imagepng($thumb,$this->config->item("root_url") ."story/test.png",9,PNG_ALL_FILTERS);
                            $image_url = base_url("story/test.png");
                        }
                    }
                }

                $data = file_get_contents($image_url);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                return $base64;
            }
            return '';
        }

        function getimagebase64_1($image = '' , $newwidth = 400, $resizegreater = false) {
            $image = "contentfiles/word/a5ba7524e5eb4027f55f419ce90e6f60.png";
            if(file_exists($this->config->item("root_url") .$image)) {
                $image_url = base_url($image );
                $type = pathinfo($this->config->item("root_url") .$image, PATHINFO_EXTENSION);

                //! If want to retain the original image if 0 => retain original else resize to newwidth
                if($newwidth != 0) {
                    // resize
                    list($width, $height) = getimagesize($this->config->item("root_url") .$image );

                    $dothis = 1;
                    if($resizegreater) {
                        $dothis = 0;
                        if( $width > $newwidth ) {
                            $dothis = 1;
                        }
                    }

                    if($dothis == 1) {
                        $percent  = $newwidth / $width;
                        $newheight = $height * $percent;
                        $thumb = imagecreatetruecolor($newwidth, $newheight);

                        if(strtolower($type) == 'jpg' || strtolower($type) == 'jpeg' ) {
                            $source = imagecreatefromjpeg($image_url);
                        } else {
                            $source = imagecreatefrompng($image_url);
                            imagealphablending($thumb, false);
                            imagesavealpha($thumb, true);
                            imagealphablending($source, true);
                        }

                        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

                        // Output
                        if(strtolower($type) == 'jpg' || strtolower($type) == 'jpeg' ) {
                            imagejpeg($thumb,$this->config->item("root_url") . "story/test.jpg",50);
                            $image_url = base_url("story/test.jpg" );
                        } else {
                            imagepng($thumb,$this->config->item("root_url") ."story/test.png",9,PNG_ALL_FILTERS);
                            $image_url = base_url("story/test.png");
                        }
                    }
                }

                $data = file_get_contents($image_url);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                echo $base64;
            }
            echo '';
        }

        /*
    	Function name   : getaudiobase64()
    	Parameter       : $audio - string - audio name
    	Return          : base64 audio - string
    	Description     : Gets the base 64 audio
    	*/
        private function getaudiobase64($audio = '' ) {
            $audio_url = base_url($audio );
            $type = pathinfo($audio_url, PATHINFO_EXTENSION);
            $data = file_get_contents($audio_url);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            return $base64;
        }

        /*
    	Function name   : generateallthestoryjson()
    	Parameter       : none
    	Return          : none
    	Description     : generate all the story json format
    	*/
        function generateallthestoryjson() {

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! get all the stories
            $stories = Story::find("all",array(
                "select" => "id",
                "conditions" => " status = 'active' ",
                "order" => "id ASC"
            ));

            $key = pack('H*', "bcb04b7e103a0cd8b54763089a7c08bc55abe029fdebae5e1d417e2ffb2a00a3");
            $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
            $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

            foreach($stories as $storyid) {
                //! Get the story details
                $story1 = $this->getstoryforid($storyid->id);

                //! Json story string
                $story = json_encode($story1);

                //! Encrypt string
                $storyenc = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $story, MCRYPT_MODE_CBC, $iv);
                $storyenc = $iv . $storyenc;
                $storyenc = base64_encode($storyenc);

                file_put_contents($this->config->item("root_url") . "story/story_" . $storyid->id . ".json",$storyenc);
                //file_put_contents("story/story_" . $storyid->id . ".json",$storyenc);

                unset($story1);
                unset($story);
                unset($storyenc);
            }
        }

        /*
    	Function name   : onlyonce_getallstorycover()
    	Parameter       : none
    	Return          : json string
    	Description     : gets all story cover ( title / id  / coverimage / level )
    	*/
        function onlyonce_getallstorycover() {

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Find All the story cover
            $stories = Story::find("all",array(
                "conditions" => " status = 'active' ",
                "order" => "level,name ASC"
            ));

            //! Setting All stories
            $response->stories = array();

            //! Loop through all the stories
            foreach( $stories as $val ) {
                $story = new stdClass;
                $story->id = $val->id;
                $story->name = $val->name;
                $story->level = $val->level;

                if($val->image != '') {
                    $story->image = $val->image;
                    $story->image_base64 = $this->getimagebase64("story/" . $val->image,1000);
                } else {
                    $story->image = '';
                    $story->image_base64 = '';
                }

                $response->stories[] = $story;
            }

            $response->success = true;
            $response->message = array("Stories Cover retrieved");

            //! convert json object to string
            //die(json_encode($response));
            file_put_contents($this->config->item("root_url") . "grapheme/story_cover.json" , json_encode($response));
        }

        /*
    	Function name   : onlyonce_getallstorycover_sql()
    	Parameter       : none
    	Return          : sql string
    	Description     : gets all story cover ( title / id  / coverimage / level )
    	*/
        function onlyonce_getallstorycover_sql() {

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! initiate the response
            $struct = "INSERT INTO `story_table` (`id`,`story_id`,`name`,`level`,`image_name`,`is_premium`,`user_id`) VALUES ";

            $response = array();

            //! Find All the story cover
            $stories = Story::find("all",array(
                "conditions" => " status = 'active' ",
                "order" => "level,name ASC"
            ));

            $mm = 0;
            //! Loop through all the stories
            foreach( $stories as $val ) {
                $mm++;
                $is_p = 1;
                if($mm <= 4) {
                    $is_p = 0;
                }
                $response[] = " (NULL,'".$val->id."','".str_replace("'","''",$val->name)."','".$val->level."','".$val->image."','$is_p','0')";
            }

            //! convert json object to string
            //die($struct . implode(" , ",$response) . " ;");
            file_put_contents($this->config->item("root_url") . "grapheme/storycover.sql", $struct . implode(",",$response));
        }

        /*
    	Function name   : generateallgraphemejson()
    	Parameter       : none
    	Return          : none
    	Description     : generate all the grapheme json format
    	*/
        function generateallgraphemejson($unit = 1) {
            ini_set('memory_limit', '256M');
            ini_set('memory_limit', '-1');

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! get all the graphemes
            $graphemes = Grapheme::find("all",array(
                "select" => "id",
                "conditions" => " ( delete_flag = 0 OR delete_flag IS NULL ) AND units_id = '".$unit."' AND ( type = 'grapheme' OR type = 'both' )  ",
                "order" => "id ASC"
            ));

            echo "totalcount: " . count($graphemes);
            //! initiate the response
            $response = new stdClass;
            $response->success = true;
            $response->graphemes = array();

            foreach($graphemes as $graphemeid) {
                //! Get the grapheme details
                $response->graphemes[] = $this->getgraphemeforid($graphemeid->id);

            }

            $response->message = array("All Graphemes retrieved");
            file_put_contents($this->config->item("root_url") . "grapheme/unit".$unit.".json" , json_encode($response));
            //! convert json object to string
            //die(json_encode($response));
        }

        /*
    	Function name   : generateallphrasejson()
    	Parameter       : none
    	Return          : none
    	Description     : generate all the phrase json format
    	*/
        function generateallphrasejson() {
            ini_set('memory_limit', '256M');
            ini_set('memory_limit', '-1');

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! get all the phrases
            $phrases = Phrase::find("all",array(
                "select" => "id",
                "conditions" => " delete_flag = 0 OR delete_flag IS NULL ",
                "order" => "id ASC"
            ));

            //! initiate the response
            $response = new stdClass;
            $response->success = true;
            $response->phrases = array();

            foreach($phrases as $phraseid) {
                //! Get the phrase details
                $response->phrases[] = $this->getphraseforid($phraseid->id);
            }

            $response->message = array("All phrases retrieved");

            //! convert json object to string
            //die(json_encode($response));
            file_put_contents($this->config->item("root_url") . "grapheme/phrases.json" , json_encode($response));
        }

        /*
    	Function name   : generateallphonemestoryjson()
    	Parameter       : none
    	Return          : none
    	Description     : generate all the phoneme story json format
    	*/
        function generateallphonemestoryjson() {
            ini_set('memory_limit', '256M');
            ini_set('memory_limit', '-1');

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! get all the phoneme stories
            $phonemestories = PhonemeStory::find("all",array(
                "select" => "id",
                "conditions" => " delete_flag = 0 OR delete_flag IS NULL ",
                "order" => "unit ASC"
            ));

            //! initiate the response
            $response = new stdClass;
            $response->success = true;
            $response->phonemestories = array();

            foreach($phonemestories as $phonemestoryid) {
                //! Get the phoneme stories details
                $response->phonemestories[] = $this->getphonemestoryforid($phonemestoryid->id);
            }

            $response->message = array("All phoneme stories retrieved");

            //! convert json object to string
            //die(json_encode($response));
            file_put_contents($this->config->item("root_url") . "grapheme/phoneme_stories.json" , json_encode($response));
        }

        /*
    	Function name   : generateallwordsegmentjson()
    	Parameter       : none
    	Return          : none
    	Description     : generate all the word segment json format
    	*/
        function generateallwordsegmentjson() {
            ini_set('memory_limit', '256M');
            ini_set('memory_limit', '-1');

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! get all the wordsegment
            $wordsegments = Wordsegment::find("all",array(
                "select" => "id",
                "conditions" => " ( delete_flag = 0 OR delete_flag IS NULL ) AND status = 'active' ",
                "order" => "unit,id ASC"
            ));

            //! initiate the response
            $response = new stdClass;
            $response->success = true;
            $response->wordsegments = array();

            foreach($wordsegments as $wordsegment) {
                //! Get the wordsegments details
                $response->wordsegments[] = $this->getwordsegmentforid($wordsegment->id);
            }

            $response->message = array("All word segments retrieved");

            //! convert json object to string
            //die(json_encode($response));
            file_put_contents($this->config->item("root_url") . "grapheme/wordsegments.json", json_encode($response));

        }

        /*
    	Function name   : generateallstorytextbookjson()
    	Parameter       : none
    	Return          : none
    	Description     : generate all the story textbook json format
    	*/
        function generateallstorytextbookjson() {
            ini_set('memory_limit', '256M');
            ini_set('memory_limit', '-1');

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! get all the textbook
            $textbooks = StoryTextbook::find("all",array(
                "select" => "id",
                "conditions" => " ( delete_flag = 0 OR delete_flag IS NULL ) AND status = 'active' ",
                "order" => "unit,id ASC"
            ));

            //! initiate the response
            $response = new stdClass;
            $response->success = true;
            $response->storytextbooks = array();

            foreach($textbooks as $book) {
                //! Get the storytextbooks details
                $response->storytextbooks[] = $this->getstorytextbookforid($book->id);
            }

            $response->message = array("All story textbook retrieved");

            //! convert json object to string
            //die(json_encode($response));
            file_put_contents($this->config->item("root_url") . "grapheme/storytextbook.json", json_encode($response));

        }

        /*
    	Function name   : generateallwordgroupjson()
    	Parameter       : none
    	Return          : none
    	Description     : generate all the word group json format
    	*/
        function generateallwordgroupjson() {
            ini_set('memory_limit', '256M');
            ini_set('memory_limit', '-1');

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! get all the word group
            $wordgroups = StoryTextbookGroup::find("all",array(
                "select" => "id",
                "conditions" => " ( delete_flag = 0 OR delete_flag IS NULL ) AND status = 'active' ",
                "order" => "unit,id ASC"
            ));

            //! initiate the response
            $response = new stdClass;
            $response->success = true;
            $response->wordgroups = array();

            foreach($wordgroups as $group) {
                //! Get the word groups details
                $response->wordgroups[] = $this->getwordgroupforid($group->id);
            }

            $response->message = array("All word group retrieved");

            //! convert json object to string
            //die(json_encode($response));
            file_put_contents($this->config->item("root_url") . "grapheme/wordgroup.json", json_encode($response));
        }

        /*
    	Function name   : onlyonce_generateallwordgroup_sql()
    	Parameter       : none
    	Return          : sql string
    	Description     : generate all the word group sql format
    	*/
        function onlyonce_generateallwordgroup_sql() {

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! get all the word group
            $wordgroups = StoryTextbookGroup::find("all",array(
                "conditions" => " ( delete_flag = 0 OR delete_flag IS NULL ) AND status = 'active' ",
                "order" => "unit,id ASC"
            ));

            //! initiate the response
            $struct = "INSERT INTO `wordgroup` (`a_id`,`group_id`,`name`,`unit`,`class`,`board`,`source`,`page_number`,`word_id`,`word`,`level`,`hindi_translation`,`marathi_translation`,`defination`,`example`,`order_number`,`audio`,`image`) VALUES";
            $response = array();
            $response1 = array();

            $ii = 0 ;
            //! Loop through all the stories
            foreach( $wordgroups as $data ) {
                foreach($data->story_textbook_group_word_linkage as $val) {
                    $response[] = ' (NULL,"'.($data->id).'",\''.str_replace("'","''",$data->name).'\',"'.($data->unit).'","'.($data->class).'","'.($data->board).'","'.($data->source).'","'.($data->page_number).'","'.($val->word->id).'",\''.str_replace("'","''",$val->word->word).'\',"'.($val->word->level).'","'.($val->word->hindi_translation).'","'.($val->word->marathi_translation).'","'.($val->word->defination).'","'.($val->word->example).'","'.($val->order_number).'","'.($val->word->audio).'","'.($val->word->image).'")';
                    $ii++;
                    /*if($ii % 20 == 0 ) {
                        $response1[] = $struct . implode(",",$response) . ";";
                        $response = array();
                    }*/
                }
            }

            //! convert json object to string
            //die($struct . implode(" , ",$response) . " ;");
            file_put_contents($this->config->item("root_url") . "grapheme/wordgroup.sql", $struct . implode(",",$response));
        }

        /*
    	Function name   : onlyonce_generateallgrapheme_sql()
    	Parameter       : none
    	Return          : sql string
    	Description     : generate all the grapheme sql format
    	*/
        function onlyonce_generateallgrapheme_sql($unit) {

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! get all the word group
            $data1 = Grapheme::find("all",array(
                "conditions" => " ( delete_flag = 0 OR delete_flag IS NULL ) AND units_id = '".$unit."'  AND ( type = 'grapheme' OR type = 'both' )  ",
                "order" => "units_id,id ASC"
            ));

            //! initiate the response
            $struct = "INSERT INTO `grapheme_table` (`a_id`,`id`,`grapheme`,`phoneme`,`unit`,`primary_word`,`p_w_id`,`p_w_word`,`p_w_hindi_trans`,`p_w_marathi_trans`,`p_w_graphe_index`,`p_w_image_name`,`p_w_image_path`,`p_w_audio_path`,`sub_unit`) VALUES";
            //$struct = "INSERT INTO `grapheme_table` (`a_id`,`id`,`grapheme`,`phoneme`,`script`,`unit`,`primary_word`,`p_w_id`,`p_w_word`,`p_w_hindi_trans`,`p_w_marathi_trans`,`p_w_graphe_index`,`p_w_image_name`,`p_w_image_path`,`p_w_audio_path`,`sub_unit`) VALUES";
            $struct1 = "INSERT INTO `word_table` (`a_id`,`word_id`,`word`,`hindi_translation`,`marathi_translation`,`grapheme_index`,`image`,`image_path`,`audio`,`audio_path`,`unit`,`grapheme_count`,`grapheme`,`id`) VALUES";
            $response = array();
            $response1 = array();

            $ii = 0 ;
            $size = count($data1);
            $remainder = $size % 4;
            $sub_unit = 1;

            //! Loop through all the stories
            foreach( $data1 as $data ) {

                if($ii != 0 && $ii % 4 == 0 && $ii + 4 <= $size ) {
                    $sub_unit++;
                }
                $response[] = ' (NULL,"'.($data->id).'","'.($data->grapheme).'","'.($data->phoneme).'","'.($data->units_id).'","","'.($data->grapheme_word_linkage_primary[0]->word->id).'","'.($data->grapheme_word_linkage_primary[0]->word->word).'","'.($data->grapheme_word_linkage_primary[0]->word->hindi_translation).'","'.($data->grapheme_word_linkage_primary[0]->word->marathi_translation).'","'.($data->grapheme_word_linkage_primary[0]->grapheme_index).'","'.($data->grapheme_word_linkage_primary[0]->word->image).'","/storage/emulated/0/MGuru/MGuruGrapheme/'.($data->grapheme_word_linkage_primary[0]->word->image).'","/storage/emulated/0/MGuru/MGuruGrapheme/'.($data->audio).'","'.$sub_unit.'")';
                //$response[] = ' (NULL,"'.($data->id).'","'.($data->grapheme).'","'.($data->phoneme).'","'.($data->script).'","'.($data->units_id).'","","'.($data->grapheme_word_linkage_primary[0]->word->id).'","'.($data->grapheme_word_linkage_primary[0]->word->word).'","'.($data->grapheme_word_linkage_primary[0]->word->hindi_translation).'","'.($data->grapheme_word_linkage_primary[0]->word->marathi_translation).'","'.($data->grapheme_word_linkage_primary[0]->grapheme_index).'","'.($data->grapheme_word_linkage_primary[0]->word->image).'","/storage/emulated/0/MGuru/MGuruGrapheme/'.($data->grapheme_word_linkage_primary[0]->word->image).'","/storage/emulated/0/MGuru/MGuruGrapheme/'.($data->audio).'","'.$sub_unit.'")';
                foreach($data->grapheme_word_linkage as $gw_linkage) {
                    $response1[] = ' (NULL,"'.($gw_linkage->word->id).'","'.($gw_linkage->word->word).'","'.($gw_linkage->word->hindi_translation).'","'.($gw_linkage->word->marathi_translation).'","'.($gw_linkage->grapheme_index).'","","","","","'.($data->units_id).'","'.strlen($data->grapheme).'","'.($data->grapheme).'","'.($data->id).'")';
                }
                $ii++;
            }

            //! convert json object to string
            //die($struct . implode(" , ",$response) . " ;");
            file_put_contents($this->config->item("root_url") . "grapheme/grapheme_".$unit.".sql", $struct . implode(",",$response));
            file_put_contents($this->config->item("root_url") . "grapheme/word_".$unit.".sql", $struct1 . implode(",",$response1));
        }

        /*
    	Function name   : onlyonce_generateallphonemestory_sql()
    	Parameter       : none
    	Return          : sql string
    	Description     : generate all the phoneme story sql format
    	*/
        function onlyonce_generateallphonemestory_sql() {

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! get all the phoneme stories
            $phonemestories = PhonemeStory::find("all",array(
                "conditions" => " delete_flag = 0 OR delete_flag IS NULL ",
                "order" => "unit ASC"
            ));

            //! initiate the response
            $struct = "INSERT INTO `phonic_story_table` (`a_id`,`phonic_id`,`phonic_unit`,`phonic_story`,`audio_file_name`,`audio_file_path`) VALUES";

            $response = array();

            $ii = 0 ;

            //! Loop through all the stories
            foreach( $phonemestories as $data ) {
                $response[] = ' (NULL,"'.($data->id).'","'.($data->unit).'",\''.str_replace("'","''",$data->story).'\',"","")';

                $ii++;
            }

            //! convert json object to string
            //die($struct . implode(" , ",$response) . " ;");
            file_put_contents($this->config->item("root_url") . "grapheme/phonemestory.sql", $struct . implode(",",$response));
        }

        /*
    	Function name   : onlyonce_generateallphrase_sql()
    	Parameter       : none
    	Return          : sql string
    	Description     : generate all the phrase sql format
    	*/
        function onlyonce_generateallphrase_sql() {

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! get all the phoneme stories
            $phrasedb = Phrase::find("all",array(
                "conditions" => " delete_flag = 0 OR delete_flag IS NULL ",
                "order" => "units_id ASC"
            ));

            //! initiate the response
            $struct = "INSERT INTO `phrase_table` (`a_id`,`phrase_id`,`level`,`grapheme_id`,`sentence`,`audio_file_name`,`audio_file_path`,`unit`) VALUES";

            $response = array();

            $ii = 0 ;

            //! Loop through all the stories
            foreach( $phrasedb as $data ) {
                //! For sentences
                $sentences = array();

                foreach($data->phrase_sentence_linkage as $ps_linkage) {
                    $sentence = new stdClass;
                    $sentence->id = $ps_linkage->sentence->id;
                    $sentence->sentence = str_replace("'","''",$ps_linkage->sentence->sentence);
                    $sentence->order_number = $ps_linkage->order_number;
                    $sentence->image = '';
                    $sentence->image_base64 = '';
                    $sentence->audio = '';
                    $sentence->audio_base64 = '';
                    $sentences[] = $sentence;
                }

                $response[] = ' (NULL,"'.($data->id).'","'.($data->level).'","'.($data->grapheme_id).'",\''.json_encode($sentences).'\',"","","'.($data->units_id).'")';

                $ii++;
            }

            //! convert json object to string
            //die($struct . implode(" , ",$response) . " ;");
            file_put_contents($this->config->item("root_url") . "grapheme/phrase.sql", $struct . implode(",",$response));
        }

        /*
    	Function name   : onlyonce_generatealltextbookstory_sql()
    	Parameter       : none
    	Return          : sql string
    	Description     : generate all the textbook story sql format
    	*/
        function onlyonce_generatealltextbookstory_sql() {

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! get all
            $data1 = StoryTextbook::find("all",array(
                "conditions" => " ( delete_flag = 0 OR delete_flag IS NULL ) AND status = 'active' ",
                "order" => "class,unit ASC"
            ));

            //! initiate the response
            $struct = "INSERT INTO `text_book_table` (`a_id`,`_id`,`title`,`hindi`,`marathi`,`content`,`c_in_hindi`,`c_in_marathi`,`unit`,`_class`,`board`,`order_number`,`page_number`,`source`,`author`,`audio_name`,`image_name`) VALUES";

            $response = array();

            $ii = 0 ;

            //! Loop through all record
            foreach( $data1 as $data ) {
                $response[] = ' (NULL,"'.($data->id).'","'.($data->title).'","'.($data->title_hindi).'","'.$data->title_marathi.'","'.str_replace('"','\'"',$data->content).'","'.($data->content_hindi).'","'.($data->content_marathi).'","'.($data->unit).'","'.($data->class).'","'.($data->board).'","'.($data->order_number).'","'.($data->page_number).'","'.($data->source).'","'.($data->author).'","","")';

                $ii++;
            }

            //! convert json object to string
            //die($struct . implode(" , ",$response) . " ;");
            file_put_contents($this->config->item("root_url") . "grapheme/textbook.sql", $struct . implode(",",$response));
        }

        /*
    	Function name   : onlyonce_generateallwordsegment_sql()
    	Parameter       : none
    	Return          : sql string
    	Description     : generate all the word segement sql format
    	*/
        function onlyonce_generateallwordsegment_sql() {

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! get all
            $data1 = Wordsegment::find("all",array(
                "conditions" => " ( delete_flag = 0 OR delete_flag IS NULL ) AND status = 'active' ",
                "order" => "unit,id ASC"
            ));

            //! initiate the response
            $struct = "INSERT INTO `word_segment_table` (`a_id`,`word_segment_id`,`word_segment_word`,`word_segment_unit`,`word_segment_level`,`word_segment_in_hindi`,`word_segment_in_marathi`,`word_segment_graphemes`,`word_segment_grapheme_id`) VALUES";

            $response = array();

            $ii = 0 ;

            //! Loop through all record
            foreach( $data1 as $data ) {
                //! For graphemes
                $graphemes = array();

                foreach($data->graphemes as $val) {

                    $grapheme = new stdClass;
                    $grapheme->id = $val->grapheme->id;
                    $grapheme->grapheme = $val->grapheme->grapheme;
                    $grapheme->segment = $val->segment;
                    $grapheme->order_number = $val->order_number;

                    $graphemes[] = $grapheme;
                }

                $response[] = ' (NULL,"'.($data->id).'","'.($data->word).'","'.($data->unit).'","'.$data->level.'","'.($data->hindi_translation).'","'.($data->marathi_translation).'",\''.json_encode($graphemes).'\',"'.($data->id).'")';

                $ii++;
            }

            //! convert json object to string
            //die($struct . implode(" , ",$response) . " ;");
            file_put_contents($this->config->item("root_url") . "grapheme/wordsegment.sql", $struct . implode(",",$response));
        }

        function getstory($story_id = 0) {

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            if($story_id == 0 || $story_id == '' ) {
                redirect();
                die();
            }

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check if the file exists
            if(file_exists($this->config->item("root_url") . "story/story_" . $story_id . ".json")) {
            //if(file_exists("story/story_" . $api_request->story_id . ".json")) {
                $key = pack('H*', "bcb04b7e103a0cd8b54763089a7c08bc55abe029fdebae5e1d417e2ffb2a00a3");
                $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
                $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

                $storyenc = file_get_contents($this->config->item("root_url") . "story/story_" . $story_id . ".json");
                //$storyenc = file_get_contents("story/story_" . $api_request->story_id . ".json");

                $storydec = base64_decode($storyenc);
                $iv_dec = substr($storydec, 0, $iv_size);
                $storydec = substr($storydec, $iv_size);
                $storydec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $storydec, MCRYPT_MODE_CBC, $iv_dec);

                $response = json_decode(trim($storydec));
                $response->success = true;
                $response->message = array("Story retrieved");

                unset($storydec);
                unset($storyenc);
            } else {
                $response = new stdClass;
                $response->success = false;
                $response->message = array("Invalid Story");
            }

            //! convert json object to string
            file_put_contents($this->config->item("root_url") . "grapheme/story_".$story_id.".json", json_encode($response) );
            die();
        }

        /*
    	Function name   : storeuseractivityrecordmultiple()
    	Parameter       : none
    	Return          : json string
    	Description     : Stores the user activity record
    	*/
        function storeuseractivityrecordmultiple() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid activities
            if(!isset($api_request->activities)) {
                $response->message = array("Invalid activities");
                die(json_encode($response));
            } else if(!is_array($api_request->activities )) {
                $response->message = array("Invalid activities");
                die(json_encode($response));
            }

            $response->activities = array();
            $counter = 0;

            //! A loop for all the activities
            foreach($api_request->activities as $element) {

                $response->activities[$counter]->success = true;
                $response->activities[$counter]->a_id = $element->a_id;
                $response->activities[$counter]->message = array();

                //! Check for valid user_id
                if(!isset($element->user_id)) {
                    $response->activities[$counter]->success = false;
                    $response->activities[$counter]->message[] = "Invalid user id";
                } else if($element->user_id == '') {
                    $response->activities[$counter]->success = false;
                    $response->activities[$counter]->message[] = "Invalid user id";
                }

                //! Check for valid unique_id
                if(!isset($element->user_uid)) {
                    $response->activities[$counter]->success = false;
                    $response->activities[$counter]->message[] = "Invalid Unique id";
                } else if($element->user_uid == '') {
                    $response->activities[$counter]->success = false;
                    $response->activities[$counter]->message[] = "Invalid Unique id";
                }

                //! Find the user by user_id and unique_id
                $user = User::find_by_id_and_unique_id($element->user_id,$element->user_uid);

                //! Check if a valid user
                if(!isset($user->id)) {
                    $response->activities[$counter]->success = false;
                    $response->activities[$counter]->message[] = "Invalid user";
                }

                //! Check for valid activity_id
                if(!isset($element->activity_id)) {
                    $response->activities[$counter]->success = false;
                    $response->activities[$counter]->message[] = "Invalid activity";
                } else if($element->activity_id == '') {
                    $response->activities[$counter]->success = false;
                    $response->activities[$counter]->message[] = "Invalid activity";
                }

                if(!isset($element->activity_linkage_id)) {
                    $response->activities[$counter]->success = false;
                    $response->activities[$counter]->message[] = "Invalid activity linkage";
                } else if($element->activity_linkage_id == '') {
                    $response->activities[$counter]->success = false;
                    $response->activities[$counter]->message[] = "Invalid activity linkage";
                }

                //! Store audio file
                $audio_file = '';
                if(isset($element->audio)) {
                    if(@$element->audio != '') {
                        //! Get Extension
                        $extension = 'mp3';

                        //! Generate the filename
                        $filename = md5(date('Y-m-d H:i:s U'. rand(0,9999999))) . "." . $extension;
                        $data = explode(',', @$element->audio);
                        if(!isset($data[1])) {
                            $data[1] = $data[0];
                        }

                        //! Store the file
                        file_put_contents($this->config->item("root_url") . "user/activity/" . $filename, base64_decode($data[1]));
                        $audio_file = $filename;
                    }
                }

                //! Store image file
                $image_file = '';
                if(isset($element->image)) {
                    if(@$element->image != '') {
                        //! Get Extension
                        $extension = 'jpg';
                        if(strpos( @$element->image , 'png;base64') !== false) {
                            $extension = 'png';
                        }
                        //! Generate the filename
                        $filename = md5(date('Y-m-d H:i:s U' . rand(0,9999999))) . "." . $extension;
                        $data = explode(',', @$element->image);
                        if(!isset($data[1])) {
                            $data[1] = $data[0];
                        }

                        //! Store the file
                        file_put_contents($this->config->item("root_url") . "user/activity/" . $filename, base64_decode($data[1]));
                        $image_file = $filename;
                    }
                }

                if($response->activities[$counter]->success) {

                    $meta_type = 0 ;
                    if(isset($element->meta_type)) {
                        $meta_type = $element->meta_type;
                    }
                    //! Create a record
                    $record = UserActivityRecord::create(array(
                        "user_id" => @$element->user_id,
                        "activity_id" => @$element->activity_id,
                        "points" => @$element->points,
                        "score" => @$element->score,
                        "stars" => @$element->stars,
                        "status" => @$element->status,
                        "date_time" => @$element->date_time,
                        "activity_linkage_id" => @$element->activity_linkage_id,
                        "unique_id" => @$element->unique_id,
                        "type_id" => @$element->type_id,
                        "audio" => $audio_file,
                        "image" => $image_file,
                        "meta_type" => $meta_type,
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s"),
                    ));

                    if(isset($record->id)) {
                        $response->activities[$counter]->success = true;
                        $response->activities[$counter]->message[] = "User activity record saved";
                    } else {
                        $response->activities[$counter]->success = false;
                        $response->activities[$counter]->message[] = "Invalid data";
                    }
                }

                $counter++;
            }

            $response->success = true;

            //! convert json object to string
            die(json_encode($response));
        }

         /*
    	Function name   : storeuseractivitymultiple()
    	Parameter       : none
    	Return          : json string
    	Description     : Stores the user activity
    	*/
        function storeuseractivitymultiple() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid activities
            if(!isset($api_request->activities)) {
                $response->message = array("Invalid activities");
                die(json_encode($response));
            } else if(!is_array($api_request->activities )) {
                $response->message = array("Invalid activities");
                die(json_encode($response));
            }

            $response->activities = array();
            $counter = 0;

            //! A loop for all the activities
            foreach($api_request->activities as $element) {

                $response->activities[$counter]->success = true;
                $response->activities[$counter]->a_id = $element->a_id;

                $response->activities[$counter]->message = array();

                //! Check for valid user_id
                if(!isset($element->user_id)) {
                    $response->activities[$counter]->success = false;
                    $response->activities[$counter]->message[] = "Invalid user id";
                } else if($element->user_id == '') {
                    $response->activities[$counter]->success = false;
                    $response->activities[$counter]->message[] = "Invalid user id";
                }

                //! Check for valid unique_id
                if(!isset($element->user_uid)) {
                    $response->activities[$counter]->success = false;
                    $response->activities[$counter]->message[] = "Invalid Unique id";
                } else if($element->user_uid == '') {
                    $response->activities[$counter]->success = false;
                    $response->activities[$counter]->message[] = "Invalid Unique id";
                }

                //! Find the user by user_id and unique_id
                $user = User::find_by_id_and_unique_id($element->user_id,$element->user_uid);

                //! Check if a valid user
                if(!isset($user->id)) {
                    $response->activities[$counter]->success = false;
                    $response->activities[$counter]->message[] = "Invalid user";
                }

                //! Check for valid activity_id
                if(!isset($element->activity_id)) {
                    $response->activities[$counter]->success = false;
                    $response->activities[$counter]->message[] = "Invalid activity";
                } else if($element->activity_id == '') {
                    $response->activities[$counter]->success = false;
                    $response->activities[$counter]->message[] = "Invalid activity";
                }

                /*if(!isset($element->level)) {
                    $response->activities[$counter]->success = false;
                    $response->activities[$counter]->message[] = "Invalid level";
                } else if($element->level == '') {
                    $response->activities[$counter]->success = false;
                    $response->activities[$counter]->message[] = "Invalid level";
                }

                if(!isset($element->activity_number)) {
                    $response->activities[$counter]->success = false;
                    $response->activities[$counter]->message[] = "Invalid activity number";
                } else if($element->activity_number == '') {
                    $response->activities[$counter]->success = false;
                    $response->activities[$counter]->message[] = "Invalid activity number";
                }*/


                if($response->activities[$counter]->success) {

                    //! Find the activity by user_id, activity_id
                    //$activity = UserActivity::find_by_user_id_and_activity_id($element->user_id,$element->activity_id);

                    /*if( isset($activity->id)) {
                        $activity->points = @$element->points;
                        $activity->score = @$element->score;
                        $activity->stars = @$element->stars;
                        $activity->updated = date("Y-m-d H:i:s");
                        $activity->save();

                        $response->activities[$counter]->success = true;
                        $response->activities[$counter]->message[] = "User activity saved";
                    } else {*/
                        //! Create a record
                        $meta_type = 0;
                        if(isset($element->meta_type)) {
                            $meta_type = $element->meta_type;
                        }
                        $record = UserActivity::create(array(
                            "user_id" => @$element->user_id,
                            "activity_id" => @$element->activity_id,
                            "points" => @$element->points,
                            "score" => @$element->score,
                            "stars" => @$element->stars,
                            "level" => @$element->level,
                            "activity_number" => @$element->activity_number,
                            "meta_type" => @$meta_type,
                            "created" => date("Y-m-d H:i:s"),
                            "updated" => date("Y-m-d H:i:s"),
                        ));

                        if(isset($record->id)) {
                            $response->activities[$counter]->success = true;
                            $response->activities[$counter]->message[] = "User activity saved";
                        } else {
                            $response->activities[$counter]->success = false;
                            $response->activities[$counter]->message[] = "Invalid data";
                        }
                    //}
                }

                $counter++;
            }

            $response->success = true;

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : getuseractivity()
    	Parameter       : none
    	Return          : json string
    	Description     : Gets the all user activity
    	*/
        function getuseractivity() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Get all the user activity details
            $user_activity = UserActivity::find("all",array(
                "select" => "user_id,activity_id,points,MAX(score) AS scores,MAX(stars) AS stars11,`level`,activity_number,meta_type",
                "conditions" => " user_id = '".$api_request->user->id."' ",
                "order" => "score DESC",
                "group" => "activity_id"
            ));

            $response->activities = array();

            foreach($user_activity as $act) {

                    $activity = new stdClass;
                    $activity->activity_id = $act->activity_id;
                    $activity->points = $act->points;
                    $activity->score = $act->scores;
                    $activity->stars = $act->stars11;
                    $activity->level = $act->level;
                    $activity->activity_number = $act->activity_number;
                    $activity->meta_type = $act->meta_type;
                    $response->activities[] = $activity;

            }

            $response->success = true;
            $response->message = array("User all activity details");

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : getuserunlockstory()
    	Parameter       : none
    	Return          : json string
    	Description     : Gets the all user activity
    	*/
        function getuserunlockstory() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Get all the user activity details
            $user_unlock = UserStoryUnlock::find_all_by_user_id($api_request->user->id);

            $response->stories = array();

            foreach($user_unlock as $act) {
                $un = new stdClass;
                $un->id = $act->id;
                $un->user_id = $act->user_id;
                $un->story_id = $act->story_id;
                $un->points_used = $act->points_used;
                $un->datetime = $act->datetime->format("Y-m-d H:i:s");
                $un->created = $act->created->format("Y-m-d H:i:s");
                $un->updated = $act->updated->format("Y-m-d H:i:s");
                $response->stories[] = $un;
            }

            $response->success = true;
            $response->message = array("User all unlock stories details");

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : getupdate()
    	Parameter       : none
    	Return          : json string
    	Description     : Gets the update
    	*/
        function getupdate($vno = '') {
            if($vno == '') {
                echo "";
            } else {
                $vno++;
                if(file_exists($this->config->item("root_url") . "contentfiles/update/" . $vno . ".zip")) {
                //if(file_exists("contentfiles/update/" . $vno . ".zip")) {
                    //echo file_get_contents("contentfiles/update/" . $vno . ".zip");
                    echo file_get_contents($this->config->item("root_url") . "contentfiles/update/" . $vno . ".zip");
                }
            }
            die();
        }

        /*
    	Function name   : getteacherpendingrequest()
    	Parameter       : none
    	Return          : json string
    	Description     : get teacher date
    	*/
        function getteacherpendingrequest() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

           //! Check for valid user id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user");
                die(json_encode($response));
            } else {

                $pendingrequests = StudentTeacherLinkage::find("all", array(
                    "conditions" => " student_id = '".$api_request->user->id."' AND status = 'pending'  ",
                ));

                $response->success = true;
                if(isset($pendingrequests[0])) {
                    $response->requests = array();
                    foreach($pendingrequests as $val) {
                        $request = new stdClass;
                        $request->request_id = $val->id;
                        $request->teacher = $val->teacher->name();
                        $response->requests[] = $request;
                    }

                    $response->message = array("Pending request available.");
                } else {
                    $response->message = array("No request pending.");
                }

                //! convert json object to string
                die(json_encode($response));
            }
        }

        /*
    	Function name   : setteacherpendingrequest()
    	Parameter       : none
    	Return          : json string
    	Description     : get teacher date
    	*/
        function setteacherpendingrequest() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

           //! Check for valid user id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Check for valid request_id
            if(!isset($api_request->request_id)) {
                $response->message = array("Invalid Request id");
                die(json_encode($response));
            } else if($api_request->request_id == '') {
                $response->message = array("Invalid Request id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user");
                die(json_encode($response));
            } else {

                $pendingrequest = StudentTeacherLinkage::find_by_id_and_status($api_request->request_id,'pending');

                $response->request_id = $api_request->request_id;

                if(isset($pendingrequest->id)) {
                    $response->success = true;

                    $pendingrequest->status = $api_request->status;
                    $pendingrequest->updated = date("Y-m-d H:i:s");
                    $pendingrequest->save();

                    $response->message = array("Request done.");
                } else {
                    $response->message = array("Request failed.");
                }

                //! convert json object to string
                die(json_encode($response));
            }
        }

        function loginsync() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            $user_id = $api_request->user->id;
            //$user_id = 1619;

            $sqls = array();
            $sqls1 = array();

            $sss = 0;

            //! Get all the ans
            //SELECT question_id AS icc FROM answer_table WHERE user_id = '" + user_id + "' AND answer_status = 'correct' GROUP BY question_id
            $answers = Answer::find("all",array(
                "conditions" => " user_id = '".$user_id."' AND result = 'correct' ",
                "group" => "question_id"
            ));

            $limit = 1;

            $mmm = 0;
            foreach($answers as $val) {
                $sqls[$sss][] = "INSERT INTO answer_table (\"a_id\",\"user_id\",\"story_id\",\"phrase_id\",\"sentence_id\",\"word_id\",\"unit\",\"sub_unit\",\"level\",\"question_id\",\"type\",\"answer_status\",\"user_answer\",\"correct_answer\",\"score\",\"sync_status\",\"date_time\",\"latest\",\"activity_type\",\"grapheme_id\",\"primary_word_id\") VALUES (NULL,\"".$user_id."\",0,0,0,0,0,0,0,\"".$val->question_id."\",0,\"".$val->result."\",0,0,\"".$val->score."\",1,\"".$val->answered_dtm->format("Y-m-d H:i:s")."\",0,0,0,0);";

                $mmm++;
                if($mmm % $limit == 0){
                    $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }

            }

            //! Get all the user activity details
            $user_activity = UserActivity::find("all",array(
                "select" => "user_id,activity_id,points,MAX(score) AS scores,MAX(stars) AS stars11,`level`,activity_number,created,updated",
                "conditions" => " user_id = '".$user_id."' ",
                "order" => "scores DESC",
                "group" => "activity_id"
            ));

            foreach($user_activity as $act) {
                $sqls[$sss][] = "INSERT INTO mg_user_activity (\"id\",\"user_id\",\"activity_id\",\"points\",\"score\",\"stars\",\"created\",\"updated\",\"sync_status\",\"level\",\"activity_number\") VALUES (NULL,\"".$user_id."\",\"".$act->activity_id."\",\"".$act->points."\",\"".$act->scores."\",\"".$act->stars11."\",\"".$act->created->format("Y-m-d H:i:s")."\",\"".$act->updated->format("Y-m-d H:i:s")."\",1,\"".$act->level."\",\"".$act->activity_number."\");";

                $mmm++;
                if($mmm % $limit == 0){
                  $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }
            }

            //! Get all the user activity record details
            $user_activity_records = UserActivityRecord::find("all",array(
                "joins" => array("activity_linkage"),
                "conditions" => " mg_activity_linkage.type IN ('first_last_sound','first_last_sound_random','missing_letter','segmenting_blending','segmenting_blending_random','segmenting_blending_random_grapheme','vocab','vocabconceptrandom','vocabrandom','word_game','word_game_random','word_game_random_grapheme') AND mg_user_activity_record.user_id = '".$user_id."' ",
                "order" => "mg_user_activity_record.id",
                "group" => "mg_user_activity_record.type_id, mg_activity_linkage.type"
            ));

            foreach($user_activity_records as $act) {
                $sqls[$sss][] = "INSERT INTO mg_user_activity_record (\"id\",\"user_id\",\"activity_id\",\"points\",\"score\",\"stars\",\"status\",\"date_time\",\"created\",\"updated\",\"activity_linkage_id\",\"image\",\"audio\",\"sync_status\",\"unique_id\",\"type_id\") VALUES (NULL,\"".$user_id."\",\"".$act->activity_id."\",\"".$act->points."\",\"".$act->score."\",\"".$act->stars."\",\"".$act->status."\",\"".$act->date_time->format("Y-m-d H:i:s")."\",\"".$act->created->format("Y-m-d H:i:s")."\",\"".$act->updated->format("Y-m-d H:i:s")."\",\"".$act->activity_linkage_id."\",\"".$act->image."\",\"".$act->audio."\",1,\"".$act->unique_id."\",\"".$act->type_id."\");";

                $mmm++;
                if($mmm % $limit == 0){
                  $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }
            }

            //! Get all the user unlock story details
            $user_unlock = UserStoryUnlock::find_all_by_user_id($user_id);

            foreach($user_unlock as $act) {
                $sqls[$sss][] = "INSERT INTO mg_user_story_unlock (\"id\",\"user_id\",\"story_id\",\"datetime\",\"points_used\",\"created\",\"updated\") VALUES(NULL,\"".$user_id."\",\"".$act->story_id."\",\"".$act->datetime->format("Y-m-d H:i:s")."\",\"".$act->points_used."\",\"".$act->created->format("Y-m-d H:i:s")."\",\"".$act->updated->format("Y-m-d H:i:s")."\");";

                $mmm++;
                if($mmm % $limit == 0){
                  $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }
            }

            if(count($sqls[$sss]) > 0 ) {
                $sqls1[] = implode("",$sqls[$sss]);
                $sss++;
            }

            $response->success = true;
            $response->sql = $sqls1;
            die(json_encode($response));
            //header('Content-type: text/sql; charset=UTF-8');
            //header('Content-Disposition: attachment; filename="loginsync.sql"');
            //echo implode("
//",$sqls);

        }

        function loginsync_new() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            $user_id = $api_request->user->id;
            //$user_id = 1619;

            $sqls = array();
            $sqls1 = array();

            $sss = 0;

            //! Get all the ans
            //SELECT question_id AS icc FROM answer_table WHERE user_id = '" + user_id + "' AND answer_status = 'correct' GROUP BY question_id
            $answers = Answer::find("all",array(
                "conditions" => " user_id = '".$user_id."' AND result = 'correct' ",
                "group" => "question_id"
            ));

            $limit = 1;

            $mmm = 0;
            foreach($answers as $val) {
                $sqls[$sss][] = "INSERT INTO answer_table (\"a_id\",\"user_id\",\"story_id\",\"phrase_id\",\"sentence_id\",\"word_id\",\"unit\",\"sub_unit\",\"level\",\"question_id\",\"type\",\"answer_status\",\"user_answer\",\"correct_answer\",\"score\",\"sync_status\",\"date_time\",\"latest\",\"activity_type\",\"grapheme_id\",\"primary_word_id\",\"meta_type\") VALUES (NULL,\"".$user_id."\",0,0,0,0,0,0,0,\"".$val->question_id."\",0,\"".$val->result."\",0,0,\"".$val->score."\",1,\"".$val->answered_dtm->format("Y-m-d H:i:s")."\",0,0,0,0,\"".$val->meta_type."\");";

                $mmm++;
                if($mmm % $limit == 0){
                    $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }

            }

            //! Get all the user activity details
            $user_activity = UserActivity::find("all",array(
                "select" => "user_id,activity_id,points,MAX(score) AS scores,MAX(stars) AS stars11,`level`,activity_number,created,updated,meta_type",
                "conditions" => " user_id = '".$user_id."' ",
                "order" => "scores DESC",
                "group" => "activity_id"
            ));

            foreach($user_activity as $act) {
                $sqls[$sss][] = "INSERT INTO mg_user_activity (\"id\",\"user_id\",\"activity_id\",\"points\",\"score\",\"stars\",\"created\",\"updated\",\"sync_status\",\"level\",\"activity_number\",\"meta_type\") VALUES (NULL,\"".$user_id."\",\"".$act->activity_id."\",\"".$act->points."\",\"".$act->scores."\",\"".$act->stars11."\",\"".$act->created->format("Y-m-d H:i:s")."\",\"".$act->updated->format("Y-m-d H:i:s")."\",1,\"".$act->level."\",\"".$act->activity_number."\",\"".$act->meta_type."\");";

                $mmm++;
                if($mmm % $limit == 0){
                  $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }
            }

            //! Get all the user activity record details
            $user_activity_records = UserActivityRecord::find("all",array(
                "joins" => array("activity_linkage"),
                "conditions" => " mg_activity_linkage.type IN ('first_last_sound','first_last_sound_random','missing_letter','segmenting_blending','segmenting_blending_random','segmenting_blending_random_grapheme','vocab','vocabconceptrandom','vocabrandom','word_game','word_game_random','word_game_random_grapheme') AND mg_user_activity_record.user_id = '".$user_id."' ",
                "order" => "mg_user_activity_record.id",
                "group" => "mg_user_activity_record.type_id, mg_activity_linkage.type"
            ));

            foreach($user_activity_records as $act) {
                $sqls[$sss][] = "INSERT INTO mg_user_activity_record (\"id\",\"user_id\",\"activity_id\",\"points\",\"score\",\"stars\",\"status\",\"date_time\",\"created\",\"updated\",\"activity_linkage_id\",\"image\",\"audio\",\"sync_status\",\"unique_id\",\"type_id\",\"meta_type\") VALUES (NULL,\"".$user_id."\",\"".$act->activity_id."\",\"".$act->points."\",\"".$act->score."\",\"".$act->stars."\",\"".$act->status."\",\"".$act->date_time->format("Y-m-d H:i:s")."\",\"".$act->created->format("Y-m-d H:i:s")."\",\"".$act->updated->format("Y-m-d H:i:s")."\",\"".$act->activity_linkage_id."\",\"".$act->image."\",\"".$act->audio."\",1,\"".$act->unique_id."\",\"".$act->type_id."\",\"".$act->meta_type."\");";

                $mmm++;
                if($mmm % $limit == 0){
                  $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }
            }

            //! Get all the user unlock story details
            $user_unlock = UserStoryUnlock::find_all_by_user_id($user_id);

            foreach($user_unlock as $act) {
                $sqls[$sss][] = "INSERT INTO mg_user_story_unlock (\"id\",\"user_id\",\"story_id\",\"datetime\",\"points_used\",\"created\",\"updated\") VALUES(NULL,\"".$user_id."\",\"".$act->story_id."\",\"".$act->datetime->format("Y-m-d H:i:s")."\",\"".$act->points_used."\",\"".$act->created->format("Y-m-d H:i:s")."\",\"".$act->updated->format("Y-m-d H:i:s")."\");";

                $mmm++;
                if($mmm % $limit == 0){
                  $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }
            }

            //! Get all the user unlock help_video details
            $user_unlock_helpvideo = UserHelpVideoUnlock::find_all_by_user_id($user_id);

            foreach($user_unlock_helpvideo as $act) {
                $sqls[$sss][] = "INSERT INTO mg_user_help_video_unlock (\"id\",\"user_id\",\"help_video_id\",\"datetime\",\"points_used\",\"created\",\"updated\") VALUES(NULL,\"".$user_id."\",\"".$act->help_video_id."\",\"".$act->datetime->format("Y-m-d H:i:s")."\",\"".$act->points_used."\",\"".$act->created->format("Y-m-d H:i:s")."\",\"".$act->updated->format("Y-m-d H:i:s")."\");";

                $mmm++;
                if($mmm % $limit == 0){
                  $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }
            }

            if(count($sqls[$sss]) > 0 ) {
                $sqls1[] = implode("",$sqls[$sss]);
                $sss++;
            }

            $response->success = true;
            $response->sql = $sqls1;
            die(json_encode($response));
            //header('Content-type: text/sql; charset=UTF-8');
            //header('Content-Disposition: attachment; filename="loginsync.sql"');
            //echo implode("
//",$sqls);

        }

        function loginsync_new1() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            $user_id = $api_request->user->id;
            //$user_id = 1619;

            $sqls = array();
            $sqls1 = array();

            $sss = 0;

            //! Get all the ans
            //SELECT question_id AS icc FROM answer_table WHERE user_id = '" + user_id + "' AND answer_status = 'correct' GROUP BY question_id
            $answers = Answer::find("all",array(
                "conditions" => " user_id = '".$user_id."' AND result = 'correct' ",
                "group" => "question_id"
            ));

            $limit = 1;

            $mmm = 0;
            foreach($answers as $val) {
                $sqls[$sss][] = "INSERT INTO answer_table (\"a_id\",\"user_id\",\"story_id\",\"phrase_id\",\"sentence_id\",\"word_id\",\"unit\",\"sub_unit\",\"level\",\"question_id\",\"type\",\"answer_status\",\"user_answer\",\"correct_answer\",\"score\",\"sync_status\",\"date_time\",\"latest\",\"activity_type\",\"grapheme_id\",\"primary_word_id\",\"meta_type\") VALUES (NULL,\"".$user_id."\",0,0,0,0,0,0,0,\"".$val->question_id."\",0,\"".$val->result."\",0,0,\"".$val->score."\",1,\"".$val->answered_dtm->format("Y-m-d H:i:s")."\",0,0,0,0,\"".$val->meta_type."\");";

                $mmm++;
                if($mmm % $limit == 0){
                    $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }

            }

            //! Get all the user activity details
            $user_activity = UserActivity::find("all",array(
                "select" => "user_id,activity_id,points,MAX(score) AS scores,MAX(stars) AS stars11,`level`,activity_number,created,updated,meta_type",
                "conditions" => " user_id = '".$user_id."' ",
                "order" => "scores DESC",
                "group" => "activity_id"
            ));

            foreach($user_activity as $act) {
                $sqls[$sss][] = "INSERT INTO mg_user_activity (\"id\",\"user_id\",\"activity_id\",\"points\",\"score\",\"stars\",\"created\",\"updated\",\"sync_status\",\"level\",\"activity_number\",\"meta_type\") VALUES (NULL,\"".$user_id."\",\"".$act->activity_id."\",\"".$act->points."\",\"".$act->scores."\",\"".$act->stars11."\",\"".$act->created->format("Y-m-d H:i:s")."\",\"".$act->updated->format("Y-m-d H:i:s")."\",1,\"".$act->level."\",\"".$act->activity_number."\",\"".$act->meta_type."\");";

                $mmm++;
                if($mmm % $limit == 0){
                  $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }
            }

            //! Get all the user activity record details
            $user_activity_records = UserActivityRecord::find("all",array(
                "joins" => array("activity_linkage"),
                "conditions" => " mg_activity_linkage.type IN ('first_last_sound','first_last_sound_random','missing_letter','segmenting_blending','segmenting_blending_random','segmenting_blending_random_grapheme','vocab','vocabconceptrandom','vocabrandom','word_game','word_game_random','word_game_random_grapheme') AND mg_user_activity_record.user_id = '".$user_id."' ",
                "order" => "mg_user_activity_record.id",
                "group" => "mg_user_activity_record.type_id, mg_activity_linkage.type"
            ));

            foreach($user_activity_records as $act) {
                $sqls[$sss][] = "INSERT INTO mg_user_activity_record (\"id\",\"user_id\",\"activity_id\",\"points\",\"score\",\"stars\",\"status\",\"date_time\",\"created\",\"updated\",\"activity_linkage_id\",\"image\",\"audio\",\"sync_status\",\"unique_id\",\"type_id\",\"meta_type\") VALUES (NULL,\"".$user_id."\",\"".$act->activity_id."\",\"".$act->points."\",\"".$act->score."\",\"".$act->stars."\",\"".$act->status."\",\"".$act->date_time->format("Y-m-d H:i:s")."\",\"".$act->created->format("Y-m-d H:i:s")."\",\"".$act->updated->format("Y-m-d H:i:s")."\",\"".$act->activity_linkage_id."\",\"".$act->image."\",\"".$act->audio."\",1,\"".$act->unique_id."\",\"".$act->type_id."\",\"".$act->meta_type."\");";

                $mmm++;
                if($mmm % $limit == 0){
                  $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }
            }

            //! Get all the user unlock story details
            $user_unlock = UserStoryUnlock::find_all_by_user_id($user_id);

            foreach($user_unlock as $act) {
                $sqls[$sss][] = "INSERT INTO mg_user_story_unlock (\"id\",\"user_id\",\"story_id\",\"datetime\",\"points_used\",\"created\",\"updated\") VALUES(NULL,\"".$user_id."\",\"".$act->story_id."\",\"".$act->datetime->format("Y-m-d H:i:s")."\",\"".$act->points_used."\",\"".$act->created->format("Y-m-d H:i:s")."\",\"".$act->updated->format("Y-m-d H:i:s")."\");";

                $mmm++;
                if($mmm % $limit == 0){
                  $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }
            }

            //! Get all the user unlock help_video details
            $user_unlock_helpvideo = UserHelpVideoUnlock::find_all_by_user_id($user_id);

            foreach($user_unlock_helpvideo as $act) {
                $sqls[$sss][] = "INSERT INTO mg_user_help_video_unlock (\"id\",\"user_id\",\"help_video_id\",\"datetime\",\"points_used\",\"created\",\"updated\") VALUES(NULL,\"".$user_id."\",\"".$act->help_video_id."\",\"".$act->datetime->format("Y-m-d H:i:s")."\",\"".$act->points_used."\",\"".$act->created->format("Y-m-d H:i:s")."\",\"".$act->updated->format("Y-m-d H:i:s")."\");";

                $mmm++;
                if($mmm % $limit == 0){
                  $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }
            }


            //! Get all the user math_set Details
            $math_set = MathSet::find_all_by_user_id($user_id);

            foreach($math_set as $act) {
                $sqls[$sss][] = "INSERT INTO mg_math_set (\"id\",\"user_id\",\"classes_id\",\"subject_id\",\"board\",\"question_id\",\"concepts_id\",\"units_id\",\"total\",\"score\",\"count\",\"attempt_dtm\",\"created\",\"updated\",\"meta_type\",\"sync_status\") VALUES(NULL,\"".$user_id."\",\"".$act->classes_id."\",\"".$act->subject_id."\",\"".$act->board."\",\"".$act->question_id."\",\"".$act->concepts_id."\",\"".$act->units_id."\",\"".$act->total."\",\"".$act->score."\",\"".$act->count."\",\"".$act->attempt_dtm->format("Y-m-d H:i:s")."\",\"".$act->created->format("Y-m-d H:i:s")."\",\"".$act->updated->format("Y-m-d H:i:s")."\",\"".$act->meta_type."\",\"1\");";

                $mmm++;
                if($mmm % $limit == 0){
                  $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }
            }

            //! Get all the user mg_math_answer Details
            $math_set1 = MathAnswer::find_all_by_user_id($user_id);

            foreach($math_set1 as $act) {
                $sqls[$sss][] = "INSERT INTO mg_math_answer (\"id\",\"user_id\",\"question_id\",\"concepts_id\",\"units_id\",\"subject_id\",\"classes_id\",\"math_set_id\",\"result\",\"score\",\"meta_type\",\"answered_dtm\",\"created\",\"updated\") VALUES(NULL,\"".$user_id."\",\"".$act->question_id."\",\"".$act->concepts_id."\",\"".$act->units_id."\",\"".$act->subject_id."\",\"".$act->classes_id."\",\"".$act->math_set_id."\",\"".$act->result."\",\"".$act->score."\",\"".$act->meta_type."\",\"".$act->answered_dtm->format("Y-m-d H:i:s")."\",\"".$act->created->format("Y-m-d H:i:s")."\",\"".$act->updated->format("Y-m-d H:i:s")."\");";

                $mmm++;
                if($mmm % $limit == 0){
                  $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }
            }

            //! Get all the user mg_math_answer_question Details
            $math_set2 = MathAnswerQuestion::find_all_by_user_id($user_id);

            foreach($math_set2 as $act) {
                $sqls[$sss][] = "INSERT INTO mg_math_answer_question (\"id\",\"user_id\",\"math_answer_id\",\"question_id\",\"question\",\"variables\",\"answer\",\"created\",\"updated\") VALUES (NULL,\"".$user_id."\",\"".$act->math_answer_id."\",\"".$act->question_id."\",\"".$act->question."\",\"".$act->variables."\",\"".$act->answer."\",\"".$act->created->format("Y-m-d H:i:s")."\",\"".$act->updated->format("Y-m-d H:i:s")."\");";

                $mmm++;
                if($mmm % $limit == 0){
                  $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }
            }

            if(count($sqls[$sss]) > 0 ) {
                $sqls1[] = implode("",$sqls[$sss]);
                $sss++;
            }

            $response->success = true;
            $response->sql = $sqls1;
            die(json_encode($response));
            //header('Content-type: text/sql; charset=UTF-8');
            //header('Content-Disposition: attachment; filename="loginsync.sql"');
            //echo implode("
//",$sqls);

        }

        /*
    	Function name   : generateallthestoryjson()
    	Parameter       : none
    	Return          : none
    	Description     : generate all the story json format
    	*/
        function generateallthestoryzip() {

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! get all the stories
            $stories = Story::find("all",array(
                "select" => "id",
                "conditions" => " status = 'active' ",
                "order" => "id ASC"
            ));

            foreach($stories as $storyid) {
                //! Get the story details
                $story1 = $this->getstoryforidzip($storyid->id);
            }
        }

        function getstorydetailsforstoryidnewzip() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

            //! Check for valid user_id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique_id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Check for valid story_id
            if(!isset($api_request->story_id)) {
                $response->message = array("Invalid story id");
                die(json_encode($response));
            } else if($api_request->story_id == '') {
                $response->message = array("Invalid story id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user");
                die(json_encode($response));
            }

            //! Check if the file exists
            if(file_exists($this->config->item("root_url") . "story/story_" . $api_request->story_id . ".zip")) {
            //if(file_exists("story/story_" . $api_request->story_id . ".json")) {
                $response->success = true;
                $response->message = array("Story retrieved");

                //!check the user story status
                $story_user_status = StoryUserStatus::find_by_user_id_and_story_id($api_request->user->id,$api_request->story_id);

                if(!isset($story_user_status->id)) {
                    //! Create a user story status record
                    $story_user_status = StoryUserStatus::create(array(
                        "story_id" => $api_request->story_id,
                        "user_id" => $api_request->user->id,
                        "status" => 'reading',
                        "sub_status" => 0,
                        "score" => 0,
                        "point" => 0,
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s"),
                    ));
                }

                //!check the user story status
                $story_user_unlock = UserStoryUnlock::find_by_user_id_and_story_id($api_request->user->id,$api_request->story_id);

                if(!isset($story_user_unlock->id)) {
					$points_used = 400;
					
					if($user->expire_date->format("Ymd") >= date("Ymd")) {
						$points_used = 0;
					}
					

                    //! Create a user story status record
                    $story_user_unlock = UserStoryUnlock::create(array(
                        "story_id" => $api_request->story_id,
                        "user_id" => $api_request->user->id,
                        "datetime" => date("Y-m-d H:i:s"),
                        "points_used" => $points_used,
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s"),
                    ));
                }

                unset($storydec);
                unset($storyenc);
            } else {
                $response = new stdClass;
                $response->success = false;
                $response->message = array("Invalid Story");
                die(json_encode($response));
            }


            $size = filesize($this->config->item("root_url") . "story/story_".$api_request->story_id.".zip");

            header("Pragma: public");
		    header("Expires: 0");
	    	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		    header("Cache-Control: private",false);
		    header("Content-Type: application/zip");
		    header("Content-Disposition: attachment; filename=story_".$api_request->story_id.".zip;" );
		    header("Content-Transfer-Encoding: binary");
		    header("Content-Length: ".$size);
            readfile($this->config->item("root_url") . "story/story_".$api_request->story_id.".zip");
        }

        function storehelpvideouserunlockmultiple() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid helpvideo
            if(!isset($api_request->helpvideo)) {
                $response->message = array("Invalid help video");
                die(json_encode($response));
            } else if(!is_array($api_request->helpvideo )) {
                $response->message = array("Invalid help video");
                die(json_encode($response));
            }

            $response->helpvideo = array();
            $counter = 0;
            foreach($api_request->helpvideo as $ele) {
                $response->helpvideo[$counter]->success = true;
                $response->helpvideo[$counter]->help_video_id = $ele->help_video_id;
                $response->helpvideo[$counter]->message = array();

                //! Check for valid userdata format
                if(!isset($ele->user)) {
                    $response->helpvideo[$counter]->success = false;
                    $response->helpvideo[$counter]->message[] = "Invalid input / structure.";
                }

                //! Check for valid user_id
                if(!isset($ele->user->id)) {
                    $response->helpvideo[$counter]->success = false;
                    $response->helpvideo[$counter]->message[] = "Invalid user id";
                } else if($ele->user->id == '') {
                    $response->helpvideo[$counter]->success = false;
                    $response->helpvideo[$counter]->message[] = "Invalid user id";
                }

                //! Check for valid unique_id
                if(!isset($ele->user->uid)) {
                    $response->helpvideo[$counter]->success = false;
                    $response->helpvideo[$counter]->message[] = "Invalid Unique id";
                } else if($ele->user->uid == '') {
                    $response->helpvideo[$counter]->success = false;
                    $response->helpvideo[$counter]->message[] = "Invalid Unique id";
                }

                //! Find the user by user_id and unique_id
                $user = User::find_by_id_and_unique_id($ele->user->id,$ele->user->uid);

                //! Check if a valid user
                if(!isset($user->id)) {
                    $response->helpvideo[$counter]->success = false;
                    $response->helpvideo[$counter]->message[] = "Invalid user id";
                }

                //! Check for valid help_video_id
                if(!isset($ele->help_video_id)) {
                    $response->helpvideo[$counter]->success = false;
                    $response->helpvideo[$counter]->message[] = "Invalid help video id";
                } else if($ele->help_video_id == '') {
                    $response->helpvideo[$counter]->success = false;
                    $response->helpvideo[$counter]->message[] = "Invalid help video id";
                }

                if($response->helpvideo[$counter]->success) {

                    //!check the user helpvideo status
                    $helpvideo_user_unlock = UserHelpVideoUnlock::find_by_user_id_and_help_video_id($ele->user->id,$ele->help_video_id);

                    if(!isset($helpvideo_user_unlock->id)) {
                        $helpvideo_user_unlock = UserHelpVideoUnlock::create(array(
                            "help_video_id" => $ele->help_video_id,
                            "user_id" => $ele->user->id,
                            "datetime" => @$ele->datetime,
                            "points_used" => @$ele->points_used,
                            "created" => date("Y-m-d H:i:s"),
                            "updated" => date("Y-m-d H:i:s"),
                        ));
                    }
                    /*else {
                        $helpvideo_user_status->datetime = @$ele->datetime;
                        $helpvideo_user_status->points_used = @$ele->points_used;
                        $helpvideo_user_status->updated = date("Y-m-d H:i:s");
                        $helpvideo_user_status->save();
                    }  */

                    $response->helpvideo[$counter]->message[] = "Help Video User Status save";
                }

                $counter++;
            }

            $response->success = true;

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : getranking()
    	Parameter       : none
    	Return          : json string
    	Description     : get ranking 
    	*/
        function getranking() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

           //! Check for valid user id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user");
                die(json_encode($response));
            } else {

				//! User Ranking
				$ranking1 = User::find_by_sql("SELECT * FROM (SELECT t.*,  @rownum := @rownum + 1 AS rank FROM mg_user_ranking t, (SELECT @rownum := 0) r ORDER BY t.current_mango DESC) v WHere v.user_id = ".$user->id.";");
				$ranking2 = User::find_by_sql("SELECT COUNT(id) AS total FROM mg_user_ranking;");

				$ranking = 0;
				$mangoes = 0;
				$total = @$ranking2[0]->total;

				if(isset($ranking1[0])) {
					$ranking = $ranking1[0]->rank;
					$mangoes = $ranking1[0]->current_mango;
				}
				
				$percentile = 0;
				
				if($ranking != 0) {
					$percentile = ( ( $ranking - $total ) /  $total) * 100;
					$percentile = round($percentile , 2);
				}


                $response->success = true;
                $response->message = array("Ranking available");
                $response->overall = new stdClass;
				$response->overall->rank = $ranking;
                $response->overall->total = $total;
                $response->overall->percentile = $percentile;
                $response->overall->mangoes = $mangoes;
                
                
                $lwranking1 = User::find_by_sql("SELECT * FROM (SELECT t.*,  @rownum := @rownum + 1 AS rank FROM mg_user_ranking t, (SELECT @rownum := 0) r WHERE t.last_week_effort > 0 ORDER BY t.last_week_effort  DESC) v WHere v.user_id = ".$user->id.";");
				$lwranking2 = User::find_by_sql("SELECT COUNT(id) AS total FROM mg_user_ranking WHERE last_week_effort > 0;");
				
				$lwranking = 0;
				$lwefforts = 0;
				$lwtotal = @$lwranking2[0]->total;
				
				if(isset($lwranking1[0])) {
					$lwranking = $lwranking1[0]->rank;
					$lwefforts = $lwranking1[0]->last_week_effort;
				} 
				
				$lwpercentile = 0;
				
				if($lwranking != 0) {
					$lwpercentile = ( ( $lwranking - $lwtotal ) /  $lwtotal) * 100;
					$lwpercentile = round($lwpercentile , 2);
				}
                
                $response->lastweek = new stdClass;
                $response->lastweek->rank = $lwranking;
                $response->lastweek->total = $lwtotal;
                $response->lastweek->percentile = $lwpercentile;
                $response->lastweek->efforts = $lwefforts;
                
                
                $toranking1 = User::find_by_sql("SELECT * FROM (SELECT t.*,  @rownum := @rownum + 1 AS rank FROM mg_user_ranking t, (SELECT @rownum := 0) r WHERE t.today_effort > 0 ORDER BY t.today_effort  DESC) v WHere v.user_id = ".$user->id.";");
				$toranking2 = User::find_by_sql("SELECT COUNT(id) AS total FROM mg_user_ranking WHERE today_effort > 0;");
				
				$toranking = 0;
				$toefforts = 0;
				$tototal = @$toranking2[0]->total;
				
				if(isset($toranking1[0])) {
					$toranking = $toranking1[0]->rank;
					$toefforts = $toranking1[0]->today_effort;
				} 
				
				$topercentile = 0;
				
				if($toranking != 0) {
					$topercentile = ( ( $toranking - $tototal ) /  $tototal) * 100;
					$topercentile = round($topercentile , 2);
				}
                
                $response->today = new stdClass;
                $response->today->rank = $toranking;
                $response->today->total = $tototal;
                $response->today->percentile = $topercentile;
                $response->today->efforts = $toefforts;

                
                //! convert json object to string
                die(json_encode($response));
            }
        }
        
        /*
    	Function name   : getoveralllist()
    	Parameter       : none
    	Return          : json string
    	Description     : get ranking 
    	*/
        function getoveralllist() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

           //! Check for valid user id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }
            
            $start = '';
            if(isset($api_request->start)) {
                $start = $api_request->start;
            } 

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user");
                die(json_encode($response));
            } else {
				
				$ranking2 = User::find_by_sql("SELECT COUNT(id) AS total FROM mg_user_ranking;");
				
				if($start == '') {
					$ranking1 = User::find_by_sql("SELECT * FROM (SELECT t.*,  @rownum := @rownum + 1 AS rank FROM mg_user_ranking t, (SELECT @rownum := 0) r ORDER BY t.current_mango DESC) v WHere v.user_id = ".$user->id.";");
				
					$ranking = 0;
				
					if(isset($ranking1[0])) {
						$ranking = $ranking1[0]->rank;
						$start = $ranking - ( $ranking % 10 ) + 1;
					}
				}
				
				if($start == '') {
					$start = 1;
				}
				
				
				$ranking3 = User::find_by_sql("SELECT * FROM (SELECT t.*,  @rownum := @rownum + 1 AS rank FROM mg_user_ranking t, (SELECT @rownum := 0) r ORDER BY t.current_mango DESC) v WHERE 1 = 1 LIMIT ".($start - 1).",".($start + 9).";");
				
				$response->success = true;
                $response->message = array("Ranking available");
                $response->start = $start;
                $response->total = $ranking2[0]->total;
                $response->count = count($ranking3);
                
                $response->overall = array();
				
				foreach($ranking3 as $val) {
				
					$rank = new stdClass;
					$rank->rank = $val->rank;
					
					$percentile = 0;
					if($val->rank != 0) {
						$percentile = ( ( $ranking2[0]->total - $val->rank ) /  $ranking2[0]->total) * 100;
						$percentile = round($percentile , 2);
					}
					
					$rank->percentile = $percentile;
					$rank->mangoes = $val->current_mango;
					$mmuser = User::find($val->user_id);
					$rank->name = $mmuser->name();
					$rank->user_id = $val->user_id;
                
					$response->overall[] = $rank;
				}
				
                //! convert json object to string
                die(json_encode($response));
            }
        }
        
        /*
    	Function name   : getweeklylist()
    	Parameter       : none
    	Return          : json string
    	Description     : get ranking 
    	*/
        function getweeklylist() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

           //! Check for valid user id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }
            
            $start = '';
            if(isset($api_request->start)) {
                $start = $api_request->start;
            } 

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user");
                die(json_encode($response));
            } else {
				
				$ranking2 = User::find_by_sql("SELECT COUNT(id) AS total FROM mg_user_ranking WHERE last_week_effort > 0;");
				
				if($start == '') {
					$ranking1 = User::find_by_sql("SELECT * FROM (SELECT t.*,  @rownum := @rownum + 1 AS rank FROM mg_user_ranking t, (SELECT @rownum := 0) r ORDER BY t.current_mango DESC) v WHERE v.last_week_effort > 0 AND v.user_id = ".$user->id.";");
				
					$ranking = 0;
				
					if(isset($ranking1[0])) {
						$ranking = $ranking1[0]->rank;
						$start = $ranking - ( $ranking % 10 ) + 1;
					}
				}
				
				if($start == '') {
					$start = 1;
				}
				
				
				$ranking3 = User::find_by_sql("SELECT * FROM (SELECT t.*,  @rownum := @rownum + 1 AS rank FROM mg_user_ranking t, (SELECT @rownum := 0) r ORDER BY t.current_mango DESC) v WHERE v.last_week_effort > 0 LIMIT ".($start - 1).",".($start + 9).";");
				
				$response->success = true;
                $response->message = array("Ranking available");
                $response->start = $start;
                $response->total = $ranking2[0]->total;
                $response->count = count($ranking3);
                
                $response->weekly = array();
				
				foreach($ranking3 as $val) {
				
					$rank = new stdClass;
					$rank->rank = $val->rank;
					
					$percentile = 0;
					if($val->rank != 0) {
						$percentile = ( ( $ranking2[0]->total - $val->rank ) /  $ranking2[0]->total) * 100;
						$percentile = round($percentile , 2);
					}
					
					$rank->percentile = $percentile;
					$rank->efforts = $val->last_week_effort;
					$mmuser = User::find($val->user_id);
					$rank->name = $mmuser->name();
					$rank->user_id = $val->user_id;

					$response->weekly[] = $rank;
				}

                //! convert json object to string
                die(json_encode($response));
            }
        }

        /*
    	Function name   : getuserrankingwithtop10()
    	Parameter       : none
    	Return          : json string
    	Description     : get ranking 
    	*/
        function getuserrankingwithtop10() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid userdata format
            if(!isset($api_request->user)) {
                $response->message = array("Invalid input / structure.");
                die(json_encode($response));
            }

           //! Check for valid user id
            if(!isset($api_request->user->id)) {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            } else if($api_request->user->id == '') {
                $response->message = array("Invalid user id");
                die(json_encode($response));
            }

            //! Check for valid unique id
            if(!isset($api_request->user->uid)) {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            } else if($api_request->user->uid == '') {
                $response->message = array("Invalid Unique id");
                die(json_encode($response));
            }

            //! Find the user by user_id and unique_id
            $user = User::find_by_id_and_unique_id($api_request->user->id,$api_request->user->uid);

            //! Check if a valid user
            if(!isset($user->id)) {
                $response->message = array("Invalid user");
                die(json_encode($response));
            } else {

				//! User Ranking
				$ranking1 = User::find_by_sql("SELECT * FROM (SELECT t.*,  @rownum := @rownum + 1 AS rank FROM mg_user_ranking t, (SELECT @rownum := 0) r ORDER BY t.current_mango DESC) v WHere v.user_id = ".$user->id.";");
                $ranking2 = User::find_by_sql("SELECT COUNT(id) AS total FROM mg_user_ranking;");

				$ranking = 0;
				$mangoes = 0;
				$total = @$ranking2[0]->total;
				
				if(isset($ranking1[0])) {
					$ranking = $ranking1[0]->rank;
					$mangoes = $ranking1[0]->current_mango;
				}

                if(!$ranking) {
                    $ranking = 0;
                }

				$percentile = 0;

				if($ranking != 0) {
					$percentile = ( ( $total - $ranking ) /  $total) * 100;
					$percentile = round($percentile , 2);
				}

				$ranking1_lastweek = User::find_by_sql("SELECT * FROM (SELECT t.*,  @rownum := @rownum + 1 AS rank FROM mg_user_ranking t, (SELECT @rownum := 0) r ORDER BY t.till_last_week_mango DESC) v WHere v.user_id = ".$user->id.";");
				$ranking_lastweek = 0;

				if(isset($ranking1_lastweek[0])) {
					$ranking_lastweek = $ranking1_lastweek[0]->rank;
				}


                $response->success = true;
                $response->message = array("Ranking available");
                $response->rank = $ranking;
                $response->rank_lastweek = $ranking_lastweek;
                $response->total = $total;
                $response->percentile = $percentile;
                $response->mangoes = $mangoes;

                $ranking3 = User::find_by_sql("SELECT * FROM (SELECT t.*,  @rownum := @rownum + 1 AS rank FROM mg_user_ranking t, (SELECT @rownum := 0) r ORDER BY t.current_mango DESC) v WHERE 1 = 1 LIMIT 0,10;");

				$response->overalltop10 = array();

				foreach($ranking3 as $val) {

					$rank = new stdClass;
					$rank->rank = $val->rank;

					$percentile = 0;
					if($val->rank != 0) {
						$percentile = ( ( $ranking2[0]->total - $val->rank ) /  $ranking2[0]->total) * 100;
						$percentile = round($percentile , 2);
					}
					
					$rank->percentile = $percentile;
					$rank->mangoes = $val->current_mango;
					$mmuser = User::find($val->user_id);
					$rank->name = $mmuser->name();
					$rank->user_id = $val->user_id;

					$response->overalltop10[] = $rank;
				}

				$ranking3 = User::find_by_sql("SELECT * FROM (SELECT t.*,  @rownum := @rownum + 1 AS rank FROM mg_user_ranking t, (SELECT @rownum := 0) r ORDER BY t.last_week_effort DESC) v WHERE v.last_week_effort > 0 LIMIT 0,10;");

				$response->effortstop10 = array();

				foreach($ranking3 as $val) {

					$rank = new stdClass;
					$rank->rank = $val->rank;

					$percentile = 0;
					if($val->rank != 0) {
						$percentile = ( ( $ranking2[0]->total - $val->rank ) /  $ranking2[0]->total) * 100;
						$percentile = round($percentile , 2);
					}

					$rank->percentile = $percentile;
					$rank->efforts = $val->last_week_effort;
					$mmuser = User::find($val->user_id);
					$rank->name = $mmuser->name();
					$rank->user_id = $val->user_id;

					$response->effortstop10[] = $rank;
				}
                
                //! convert json object to string
                die(json_encode($response));
            }
        }

        /*
    	Function name   : storeuseranswermultiple1()
    	Parameter       : none
    	Return          : json string
    	Description     : Store User multiple answers for multiple users
    	*/
        function storeusermathanswermultiple() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid questions
            if(!isset($api_request->questions)) {
                $response->message = array("Invalid questions");
                die(json_encode($response));
            } else if(!is_array($api_request->questions )) {
                $response->message = array("Invalid questions");
                die(json_encode($response));
            }

            $response->questions = array();
            $counter = 0;

            //! Loop for all the questions
            foreach($api_request->questions as $obj) {
                $response->questions[$counter]->success = true;
                $response->questions[$counter]->id = $obj->id;
                $response->questions[$counter]->user_id = $obj->user_id;
                $response->questions[$counter]->uid = $obj->user_uid;

                //! Check for valid user_id
                if(!isset($obj->user_id)) {
                    $response->questions[$counter]->success = false;
                    $response->questions[$counter]->message[] = "Invalid user id.";
                } else if($obj->user_id == '') {
                    $response->questions[$counter]->success = false;
                    $response->questions[$counter]->message[] = "Invalid user id.";
                }

                //! Check for valid unique_id
                if(!isset($obj->user_uid)) {
                    $response->questions[$counter]->success = false;
                    $response->questions[$counter]->message[] = "Invalid Unique id";
                } else if($obj->user_uid == '') {
                    $response->questions[$counter]->success = false;
                    $response->questions[$counter]->message[] = "Invalid Unique id";
                }

                //! Find the user by user_id and unique_id
                $user = User::find_by_id_and_unique_id($obj->user_id,$obj->user_uid);

                //! Check if a valid user
                if(!isset($user->id)) {
                    $response->questions[$counter]->success = false;
                    $response->questions[$counter]->message[] = "Invalid Unique id";
                }

                $meta_type = 0;
                if(isset($obj->meta_type)) {
                    $meta_type = $obj->meta_type;
                }

                if($response->questions[$counter]->success) {
                    //! Store Answer meta data
                    $mathset = MathSet::create(array(
                        "user_id" => $obj->user_id,
                        "classes_id" => $obj->classes_id,
                        "subject_id" => $obj->subject_id,
                        "board" => $obj->board,
                        "question_id" => $obj->question_id,
                        "concepts_id" => $obj->concepts_id,
                        "units_id" => $obj->units_id,
                        "total" => $obj->total,
                        "score" => $obj->score,
                        "count" => $obj->count,
                        "attempt_dtm" => date("Y-m-d H:i:s",strtotime(str_replace("/","-",@$obj->attempt_dtm))),
                        "created" => date("Y-m-d H:i:s",strtotime(str_replace("/","-",@$obj->created))),
                        "updated" => date("Y-m-d H:i:s",strtotime(str_replace("/","-",@$obj->updated))),
                        "meta_type" => @$meta_type,
                    ));

                    foreach($obj->answers as $ans) {
                        $answer = MathAnswer::create(array(
                            "user_id" => $obj->user_id,
                            "question_id" => $ans->question_id,
                            "concepts_id" => $ans->concepts_id,
                            "units_id" => $ans->units_id,
                            "subject_id" => $ans->subject_id,
                            "classes_id" => $ans->classes_id,
                            "math_set_id" => $mathset->id,
                            "result" => @$ans->result,
                            "score" => @$ans->score,
                            "meta_type" => @$meta_type,
                            "answered_dtm" => date("Y-m-d H:i:s",strtotime(str_replace("/","-",@$obj->answered_dtm))),
                            "created" => date("Y-m-d H:i:s",strtotime(str_replace("/","-",@$obj->created))),
                            "updated" => date("Y-m-d H:i:s",strtotime(str_replace("/","-",@$obj->updated)))
                        ));

                        //! Store Answer complete data
                        $answer_question = MathAnswerQuestion::create(array(
                            "user_id" => $obj->user_id,
                            "math_answer_id" => $answer->id,
                            "question_id" => $ans->question_id,
                            "question" => $ans->question,
                            "variables" => '',
                            "answer" => $ans->answer,
                            "created" => date("Y-m-d H:i:s",strtotime(str_replace("/","-",@$obj->created))),
                            "updated" => date("Y-m-d H:i:s",strtotime(str_replace("/","-",@$obj->updated)))
                        ));
                    }
                    $response->questions[$counter]->success = true;
                    $response->questions[$counter]->message[] = "Math answer stored";

                } else {
                    $response->questions[$counter]->success = false;
                    $response->questions[$counter]->message[] = "Invalid data";
                }

                $counter++;
            }

            $response->success = true;

            //! convert json object to string
            die(json_encode($response));
        }

        /*
    	Function name   : cgauth()
    	Parameter       : none
    	Return          : json string
    	Description     : Register a new user
    	*/
        function cgauth() {
            //! Retrieve the user data
            $api_request = json_decode(@$_REQUEST['userdata']);

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            //! Check for valid child_id
            if(!isset($api_request->child_id)) {
                $response->message = array("Invalid child id");
                die(json_encode($response));
            } else if($api_request->child_id == '') {
                $response->message = array("Invalid child id");
                die(json_encode($response));
            }

            if(!isset($api_request->parent_id)) {
                $response->message = array("Invalid parent id");
                die(json_encode($response));
            } else if($api_request->parent_id == '') {
                $response->message = array("Invalid parent id");
                die(json_encode($response));
            }

            //! Check for duplicate username
            $euser = User::find("all",array(
                "conditions" => " username = 'cg_".$api_request->child_id."' AND cg_parent_id = '".$api_request->parent_id."' AND user_type = 'cg_student' "
            ));

            //! if username exists
            if(!isset($euser[0])) {
                $countlimit1 = User::find_by_sql("SELECT COUNT(DISTINCT(cg_parent_id)) AS total FROM mg_user WHERE user_type = 'cg_student';");
                $countlimit = @$countlimit1[0]->total;

                $partner = Partner::find(1);

                if($countlimit > $partner->limit ) {
                    $response->message = array("Limit Reached. Please contact system admin.");
                    die(json_encode($response));
                }

                //! initialize the data
                $username = "cg_" . $api_request->child_id;
                $password = md5("cg" . $api_request->child_id."123");
                $uid = md5(date("Y-m-d H:i:s") . $username);
                $mcode = rand(1000,9999);
                $expire_dt = date("Y-m-d" , mktime(1,1,1,date("m"),date("d"),date("Y") + 5));

                //! Insert a New User
                $new_user = User::create(array(
                    'email' => "",
                    'username' => $username,
                    'password' => $password,
                    'mobile' => "",
                    'status' => 'active',
                    'unique_id' => $uid,
                    'password_verification_code' => '',
                    'email_verification_code' => $mcode,
                    'mobile_verification_code' => $mcode,
                    'email_verified' => 0,
                    'mobile_verified' => 0,
                    'admin' => 0,
                    'user_type' => "cg_student",
                    'expire_date' => $expire_dt,
                    'cg_parent_id' => $api_request->parent_id,
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                ));

                //! Check if the user is added
                if(isset($new_user->id)) {
                    $name = $username;
                    if(@$api_request->name != '') {
                         $name = @$api_request->name;
                    }
                    //! Add user profile
                    $new_user_profile = Profile::create(array(
                        'user_id' => $new_user->id,
                        'title' => '',
                        'first_name' => '',
                        'last_name' => '',
                        'display_name' => $name,
                        'profile_picture' => '',
                        'date_of_birth' => '',
                        'school_id' => '',
                        'examination_board' => '',
                        'teacher_name' => '',
                        'father_name' => '',
                        'mother_name' => '',
                        'gender' => '',
                        'current_class' => "",
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

                    $sd = UserDevice::create("all",array(
                        "user_id" => $new_user->id,
                        "device_code" => @$api_request->device_id,
                        "status" => "active",
                        "created" => date("Y-m-d H:i:s"),
                        "updated" => date("Y-m-d H:i:s"),
                    ));

                    //! set data in json object
                    $response->success = true;
                    $response->user = new stdClass;
                    $response->user->id = $new_user->id;
                    $response->user->username = $new_user->username;
                    $response->user->email = $new_user->email;
                    $response->user->mobile = $new_user->mobile;
                    $response->user->uid = $new_user->unique_id;
                    $response->user->current_class = $new_user->profile->current_class;
                    $response->user->expire_date = $expire_dt;
                    $response->user->referral_code = $new_user->user_referral_code->referral_code;

                    $profile_url = $new_user->profile->profile_photo();
                    $type = pathinfo($profile_url, PATHINFO_EXTENSION);
                    $data = file_get_contents($profile_url);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    $response->user->profile_picture = $base64;

                    $response->message = array("Success");
                    $response->user->additional_mango = 200;

                    $user_id =  $new_user->id;
                }
            } else {
                $user_id =  $euser[0]->id;

                $response->success = true;
                $response->message = array("Success");
                $response->user = new stdClass;
                $response->user->id = $euser[0]->id;
                $response->user->username = $euser[0]->username;
                $response->user->email = $euser[0]->email;
                $response->user->mobile = $euser[0]->mobile;
                $response->user->uid = $euser[0]->unique_id;
                $response->user->current_class = $euser[0]->profile->current_class;

                $expire_dt = date("Y-m-d", mktime(1,1,1,date("m"),date("d") + 14,date("Y")));

                if($euser[0]->expire_date){
                    $expire_dt = $euser[0]->expire_date->format("Y-m-d");
                } else {
                    $euser[0]->expire_date = $expire_dt;
                    $euser[0]->updated = date("Y-m-d H:i:s");
                    $euser[0]->save();
                }

                $response->user->expire_date = $expire_dt;
                $response->user->referral_code = $euser[0]->user_referral_code->referral_code;

                $profile_url = $euser[0]->profile->profile_photo();
                $type = pathinfo($profile_url, PATHINFO_EXTENSION);
                $data = file_get_contents($profile_url);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                $response->user->profile_picture = $base64;

                $uref = UserReferred::find_by_user_id_and_credit_point_status($euser[0]->id,"no");

                if(isset($uref->id)) {
                    $uref->credit_point_status = "yes";
                    $uref->credit_point_date_time = date("Y-m-d H:i:s");
                    $uref->updated = date("Y-m-d H:i:s");
                    $uref->save();

                    if(date("Ymd") >= $uref->referred_by->expire_date->format("Ymd")) {
                        $expire_date = date("Y-m-d",mktime(1,1,1,date("m"),date("d") + 14,date("Y")));
                    } else {
                        $expire_date = date("Y-m-d" , mktime(1,1,1,$uref->referred_by->expire_date->format("m"),$uref->referred_by->expire_date->format("d") + 14,$uref->referred_by->expire_date->format("Y")));
                    }

                    $uref->referred_by->expire_date = $expire_date;
                    $uref->referred_by->updated = date("Y-m-d H:i:s");
                    $uref->referred_by->save();

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

                $uref_count = UserReferred::count(array(
                      "conditions" => " referred_by_id = '".$euser[0]->id."' AND credit_point_status = 'yes' "
                ));

                $additional_mango = 0;

                if($uref_count > 0 ) {
                      $additional_mango = $uref_count * 400;
                }

                if($euser[0]->created->format("Ymd") >= 20160817) {
                      $additional_mango += 200;
                }

                $response->user->additional_mango = $additional_mango;

            }

            $sqls = array();
            $sqls1 = array();

            $sss = 0;

            //! Get all the ans
            //SELECT question_id AS icc FROM answer_table WHERE user_id = '" + user_id + "' AND answer_status = 'correct' GROUP BY question_id
            $answers = Answer::find("all",array(
                "conditions" => " user_id = '".$user_id."' AND result = 'correct' ",
                "group" => "question_id"
            ));

            $limit = 1;

            $mmm = 0;
            foreach($answers as $val) {
                $sqls[$sss][] = "INSERT INTO answer_table (\"a_id\",\"user_id\",\"story_id\",\"phrase_id\",\"sentence_id\",\"word_id\",\"unit\",\"sub_unit\",\"level\",\"question_id\",\"type\",\"answer_status\",\"user_answer\",\"correct_answer\",\"score\",\"sync_status\",\"date_time\",\"latest\",\"activity_type\",\"grapheme_id\",\"primary_word_id\",\"meta_type\") VALUES (NULL,\"".$user_id."\",0,0,0,0,0,0,0,\"".$val->question_id."\",0,\"".$val->result."\",0,0,\"".$val->score."\",1,\"".$val->answered_dtm->format("Y-m-d H:i:s")."\",0,0,0,0,\"".$val->meta_type."\");";

                $mmm++;
                if($mmm % $limit == 0){
                    $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }

            }

            //! Get all the user activity details
            $user_activity = UserActivity::find("all",array(
                "select" => "user_id,activity_id,points,MAX(score) AS scores,MAX(stars) AS stars11,`level`,activity_number,created,updated,meta_type",
                "conditions" => " user_id = '".$user_id."' ",
                "order" => "scores DESC",
                "group" => "activity_id"
            ));

            foreach($user_activity as $act) {
                $sqls[$sss][] = "INSERT INTO mg_user_activity (\"id\",\"user_id\",\"activity_id\",\"points\",\"score\",\"stars\",\"created\",\"updated\",\"sync_status\",\"level\",\"activity_number\",\"meta_type\") VALUES (NULL,\"".$user_id."\",\"".$act->activity_id."\",\"".$act->points."\",\"".$act->scores."\",\"".$act->stars11."\",\"".$act->created->format("Y-m-d H:i:s")."\",\"".$act->updated->format("Y-m-d H:i:s")."\",1,\"".$act->level."\",\"".$act->activity_number."\",\"".$act->meta_type."\");";

                $mmm++;
                if($mmm % $limit == 0){
                  $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }
            }

            //! Get all the user activity record details
            $user_activity_records = UserActivityRecord::find("all",array(
                "joins" => array("activity_linkage"),
                "conditions" => " mg_activity_linkage.type IN ('first_last_sound','first_last_sound_random','missing_letter','segmenting_blending','segmenting_blending_random','segmenting_blending_random_grapheme','vocab','vocabconceptrandom','vocabrandom','word_game','word_game_random','word_game_random_grapheme') AND mg_user_activity_record.user_id = '".$user_id."' ",
                "order" => "mg_user_activity_record.id",
                "group" => "mg_user_activity_record.type_id, mg_activity_linkage.type"
            ));

            foreach($user_activity_records as $act) {
                $sqls[$sss][] = "INSERT INTO mg_user_activity_record (\"id\",\"user_id\",\"activity_id\",\"points\",\"score\",\"stars\",\"status\",\"date_time\",\"created\",\"updated\",\"activity_linkage_id\",\"image\",\"audio\",\"sync_status\",\"unique_id\",\"type_id\",\"meta_type\") VALUES (NULL,\"".$user_id."\",\"".$act->activity_id."\",\"".$act->points."\",\"".$act->score."\",\"".$act->stars."\",\"".$act->status."\",\"".$act->date_time->format("Y-m-d H:i:s")."\",\"".$act->created->format("Y-m-d H:i:s")."\",\"".$act->updated->format("Y-m-d H:i:s")."\",\"".$act->activity_linkage_id."\",\"".$act->image."\",\"".$act->audio."\",1,\"".$act->unique_id."\",\"".$act->type_id."\",\"".$act->meta_type."\");";

                $mmm++;
                if($mmm % $limit == 0){
                  $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }
            }

            //! Get all the user unlock story details
            $user_unlock = UserStoryUnlock::find_all_by_user_id($user_id);

            foreach($user_unlock as $act) {
                $sqls[$sss][] = "INSERT INTO mg_user_story_unlock (\"id\",\"user_id\",\"story_id\",\"datetime\",\"points_used\",\"created\",\"updated\") VALUES(NULL,\"".$user_id."\",\"".$act->story_id."\",\"".$act->datetime->format("Y-m-d H:i:s")."\",\"".$act->points_used."\",\"".$act->created->format("Y-m-d H:i:s")."\",\"".$act->updated->format("Y-m-d H:i:s")."\");";

                $mmm++;
                if($mmm % $limit == 0){
                  $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }
            }

            //! Get all the user unlock help_video details
            $user_unlock_helpvideo = UserHelpVideoUnlock::find_all_by_user_id($user_id);

            foreach($user_unlock_helpvideo as $act) {
                $sqls[$sss][] = "INSERT INTO mg_user_help_video_unlock (\"id\",\"user_id\",\"help_video_id\",\"datetime\",\"points_used\",\"created\",\"updated\") VALUES(NULL,\"".$user_id."\",\"".$act->help_video_id."\",\"".$act->datetime->format("Y-m-d H:i:s")."\",\"".$act->points_used."\",\"".$act->created->format("Y-m-d H:i:s")."\",\"".$act->updated->format("Y-m-d H:i:s")."\");";

                $mmm++;
                if($mmm % $limit == 0){
                  $sqls1[] = implode("",$sqls[$sss]);
                    $sss++;
                }
            }

            if(count(@$sqls[$sss]) > 0 ) {
                $sqls1[] = implode("",$sqls[$sss]);
                $sss++;
            }

            $response->success = true;
            $response->sql = $sqls1;
            die(json_encode($response));


        }
    }
?>