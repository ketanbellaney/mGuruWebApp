<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Webapp extends MG_Controller {

        var $user = '';
        var $_translator = null;
        var $_totalmango = 0;
        var $_new_stories = array(174, 184, 194, 204, 224, 374, 364, 354, 344, 324, 314, 304, 294, 274, 264, 254, 244);
        var $_oldDate = '2016-03-10 00:00:00';

        function __construct() {
            parent::__construct();

            $this->ci =& get_instance();

             if(strpos(site_url(),'https://mguruenglish.com') !== false || strpos(site_url(),'localhost') !== false ) {

             } else {
                 header("location: https://mguruenglish.com");
                 die;
             }

            //! Retrive the session details
            $user_id = $this->session->userdata('_user_id');
            if($user_id != '') {
                //! If logedin retrieve the person details
                $this->user = User::find($user_id);
                $this->_totalmango = $this->session->userdata('_totalmango');
            }

            $this->_translator = simplexml_load_file("webapp_asset/lang/strings.xml");
        }

        function trackmp($msg,$options = array(), $sign_up = false, $sign_in = false, $increment = '') {
            include_once("mixpanel/Mixpanel.php");

            $mp = Mixpanel::getInstance("id");

            if(isset($this->user->id)) {
                $mp->identify($this->user->id);
                //$mp->createAlias($this->user->id, $this->user->name());
                if($sign_up) {

                    $mainArray = array(
                        "User ID" => $this->user->id,
                        "User Name" => $this->user->username,
                        "Phone Number" => $this->user->mobile,
                        "Standard" => $this->user->profile->current_class,
                        "Mangoes Earned" => $this->_totalmango,
                        "Select Language Medium" => ucfirst($this->getdefaultLanguage()),
                        "Words Learned Count" => $this->getUserProfileWordsCount($this->user->id),
                        "Concepts Completed Count" => $this->getUserProfileConceptsCount($this->user->id),
                        "First Time Date" => $this->user->created->format("Y-m-d")."T".$this->user->created->format("H:i:s"),
                        "Activities Started" => 0,
                        "Activities  Completed" => 0,
                        "Stories Started" => 0,
                        "Stories Completed" => 0,
                        "Stories Downloaded" => 0,
                        "Promo code" => '',
                        "English Report Card" => $this->getUserReportCardPercentage($this->user->id),
                        "Math Report Card" => 0,
                        "Premium Status" => "Free Trial",
                    );
                    $mp->people->set($this->user->id, $mainArray);
                }

                if($sign_in) {

                    $mainArray = array(
                        "User ID" => $this->user->id,
                        "User Name" => $this->user->username,
                        "Phone Number" => $this->user->mobile,
                        "Standard" => $this->user->profile->current_class,
                        "Mangoes Earned" => $this->_totalmango,
                        "Select Language Medium" => ucfirst($this->getdefaultLanguage()),
                        "Words Learned Count" => $this->getUserProfileWordsCount($this->user->id),
                        "Concepts Completed Count" => $this->getUserProfileConceptsCount($this->user->id),
                    );
                    $mp->people->set($this->user->id, $mainArray);
                }
            }

            $mp->track($msg, $options);

            if($increment != "") {
                $mp->people->increment($this->user->id, $increment, 1);
            }
        }

        function language() {
            $this->checkForLoggedIn();
            $data['user'] = $this->user;
            $data['languages'] = $this->getLanguages();
            $data['defaultlanguages'] = $this->getdefaultLanguage();

            if($this->user) {
                $this->trackmp("Open App",array(
                    "User Id" => $this->user->id,
                    "User Name" => $this->user->username,
                    "First Time" => false,
                ),false,false);
            } else {
                $this->trackmp("Open App",array(
                    "First Time" => true,
                ),false,false);
            }

            $this->loadwebapptemplatenewwithoutheader("webapp/language",$data);
        }

        function dailyquest() {
            // $data['user'] = $this->user;
            $this->checkForNotLoggedIn();

            $user = $this->user;

            $dail_quest = $this->getDailyQuestData($user);
            //print_r($dail_quest);
            //die();
            $data['user'] = $user;
            $data['dail_quest'] = $dail_quest;
            $data['totalmango'] = $this->_totalmango;
            $this->loadwebapptemplatenew("webapp/dailyquest",$data);
        }

		function activity() {
            $this->checkForNotLoggedIn();
            $user = $this->user;
            $dail_quest = $this->getDailyQuestData($user);
            $data['user'] = $user;
            $data['dail_quest'] = $dail_quest;
            $this->loadwebapptemplatenew("webapp/activity",$data);
        }

        function explore() {
            $this->checkForNotLoggedIn();

            $data['user'] = $this->user;
            $data['worlds'] = $this->getUserActivityStatus($this->user->id);
            $data['totalmango'] = $this->_totalmango;
            $this->loadwebapptemplatenew("webapp/explore",$data);
        }

        function wordybirdy() {
            $data['user'] = $this->user;
            $this->loadwebapptemplatenew("webapp/wordybirdy",$data);
        }

        function video() {
            $this->checkForNotLoggedIn();
            $data['user'] = $this->user;
            $level = @$_REQUEST['level'];
            $keyword = @$_REQUEST['keyword'];
            if($keyword == '' && $level == '') {
                $level = 1;
            }
            $data['videos'] = $this->getAllHelpVideoData($this->user->id,$level,$keyword);
            $data['level'] = $level;
            $data['keyword'] = $keyword;
            $this->loadwebapptemplatenew("webapp/video",$data);
        }

        function books() {
            $this->checkForNotLoggedIn();
            $data['user'] = $this->user;
            $level = @$_REQUEST['level'];
            $keyword = @$_REQUEST['keyword'];
            if($keyword == '' && $level == '') {
                $level = 1;
            }
            $data['stories'] = $this->getAllStoryData($this->user->id,$level,$keyword);
            $data['level'] = $level;
            $data['keyword'] = $keyword;
            $this->loadwebapptemplatenew("webapp/books",$data);
        }

        function rhymes() {
            $this->checkForNotLoggedIn();
            $data['user'] = $this->user;
            $level = @$_REQUEST['level'];
            $keyword = @$_REQUEST['keyword'];
            if($keyword == '' && $level == '') {
                $level = 1;
            }
            //$data['stories'] = $this->getAllStoryData($this->user->id,$level,$keyword);
            $data['level'] = $level;
            $data['keyword'] = $keyword;
            $this->loadwebapptemplatenew("webapp/rhymespage",$data);
        }

        function myfriends() {
            $data['user'] = $this->user;
            $this->loadwebapptemplatenew("webapp/myfriends",$data);
        }

        function myfriends1() {
            $data['user'] = $this->user;
            $this->loadwebapptemplatenew("webapp/myfriends1",$data);
        }

        function story1() {
            $data['user'] = $this->user;
            $this->loadwebapptemplatenew("webapp/story1",$data);
        }

        function story2() {
            $data['user'] = $this->user;
            $this->loadwebapptemplatenew("webapp/story2",$data);
        }

        function profile() {
            $this->checkForNotLoggedIn();
            $data['user'] = $this->user;
            //$data['concepts'] = $this->getUserProfileConcepts($this->user->id);
            //$data['words'] = $this->getUserProfileWords($this->user->id);
            //$data['profile_details'] = $this->getUserProfileDetails($this->user->id);
            $data['days_expired'] = $this->getUserDaysToExpire($this->user->id);
            //$data['percentage'] = $this->getTotalProgressPercentageForReportCard($this->user->id);
            //$data['report_card'] = $this->getUserReportCard($this->user->id);

            $this->trackmp("Profile Check",array(
                "User Id" => $this->user->id,
                "User Name" => $this->user->username,
                "Mangoes" => $this->_totalmango,
                "Word Count" => $this->getUserProfileWordsCount($this->user->id),
                "Concepts Completed Count" => $this->getUserProfileConceptsCount($this->user->id),
            ),false,false);

            $this->loadwebapptemplatenew("webapp/profile",$data);
        }

        function getprofilewords() {
            $lang = get_cookie("language");
            if($lang != '') {
                $data['_lang'] = $lang;
                $data['_lang_map'] = @$this->_language_map[$lang];
                $data['_lang_db'] = @$this->_language_db_map[$lang];
            } else {
                $lang = 'english';
                $data['_lang'] = $lang;
                $data['_lang_map'] = @$this->_language_map[$lang];
                $data['_lang_db'] = @$this->_language_db_map[$lang];
            }

            $data['_translation'] = $this->_translator;
            $data['words'] = $this->getUserProfileWords($this->user->id);
            $this->load->view("webapp/getprofilewords",$data);
        }

        function rccarddetails() {
            $lang = get_cookie("language");
            if($lang != '') {
                $data['_lang'] = $lang;
                $data['_lang_map'] = @$this->_language_map[$lang];
                $data['_lang_db'] = @$this->_language_db_map[$lang];
            } else {
                $lang = 'english';
                $data['_lang'] = $lang;
                $data['_lang_map'] = @$this->_language_map[$lang];
                $data['_lang_db'] = @$this->_language_db_map[$lang];
            }

            $data['_translation'] = $this->_translator;
            $data['report_card'] = $this->getUserReportCard($this->user->id);
            $this->load->view("webapp/rccarddetails",$data);
        }

        function recentactuser() {
            $lang = get_cookie("language");
            if($lang != '') {
                $data['_lang'] = $lang;
                $data['_lang_map'] = @$this->_language_map[$lang];
                $data['_lang_db'] = @$this->_language_db_map[$lang];
            } else {
                $lang = 'english';
                $data['_lang'] = $lang;
                $data['_lang_map'] = @$this->_language_map[$lang];
                $data['_lang_db'] = @$this->_language_db_map[$lang];
            }

            $data['_translation'] = $this->_translator;
            $data['activity'] = $this->getUserRecentActivity($this->user->id);
            $this->load->view("webapp/recentactuser",$data);
        }

        function editinfo() {
            $this->checkForNotLoggedIn();

            $data['user'] = $this->user;
            $data['days_expired'] = $this->getUserDaysToExpire($this->user->id);
            //! Validation rules
            $this->form_validation->set_rules('name','Name', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $this->loadwebapptemplatenew("webapp/editinfo",$data);
            } else {

                $this->user->mobile = $this->input->post('phone_no');
                //$this->user->age = $this->input->post('age');
                $this->user->updated = date("Y-m-d H:i:s");
                $this->user->save();

                //!TODO
                //$this->input->post('promo_code')

                $this->user->profile->display_name = $this->input->post('name');
                $this->user->profile->current_class = $this->input->post('class_txt');

                //
                //! Setting school data
                $school_id = '';
                if($_REQUEST['school'] != '') {
                    //! Check if the school exists
                    $check_school = School::find_by_name($this->input->post('school'));
                    if(isset($check_school->id)) {
                        $school_id = $check_school->id;
                    } else {
                      //! Create a new school record
                      $new_school = School::create(array(
                          'name' => $this->input->post('school'),
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

                  $this->user->profile->school_id = $school_id;
                  $this->user->profile->updated = date("Y-m-d H:i:s");
                  $this->user->profile->save();

                  $this->user = User::find( $this->user->id);

                  $data['user'] = $this->user;
                  $data['error'] = 1;
                  $this->loadwebapptemplatenew("webapp/editinfo",$data);

                }
            }
        }

        function changelanguage($language) {
            $this->setdefaultLanguage($language);

            if($this->user) {
                $this->trackmp("Select Language Medium",array(
                    "User Id" => $this->user->id,
                    "User Name" => $this->user->username,
                    "Language Medium" => $language
                ),false,false);
            }

            redirect('login');
        }

        function index() {
            //$data['user'] = $this->user;
            //$this->loadwebapptemplate("webapp/index",$data);
            redirect('language');
        }

        function signup() {
             $this->checkForLoggedIn();

            //! Validation rules
            $this->form_validation->set_rules('username','Username / Email', 'trim|required');
            $this->form_validation->set_rules('password','Password', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $data['user'] = $this->user;
                $this->loadwebapptemplatenewwithoutheader("webapp/signupnew",$data);
            } else {
                 //! Else create a new user process
                $error = 1;

                //! Add data to user table
                $new_user = User::create(array(
                    'email' => '',
                    'username' => $this->input->post('username'),
                    'password' => md5($this->input->post('password')),
                    'mobile' => '',
                    'status' => 'active',
                    'unique_id' => md5(date("Y-m-d H:i:s") . $this->input->post('username')),
                    'password_verification_code' => '',
                    'email_verification_code' => md5(date("Y-m-d H:i:s"). "email_verification_code" . $this->input->post('username')),
                    'mobile_verification_code' => rand(100000,999999),
                    'email_verified' => 0,
                    'mobile_verified' => 0,
                    'admin' => 0,
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                    'last_login' => mdate("%Y-%m-%d %H:%i:%s"),
                    'login_count' => 1
                ));

                if(isset($new_user->id)) {

                    //! Add data to profile table
                    $new_user_profile = Profile::create(array(
                        'user_id' => $new_user->id,
                        'title' => '',
                        'first_name' => $this->input->post('username'),
                        'last_name' => '',
                        'display_name' => $this->input->post('username'),
                        'profile_picture' => '',
                        'date_of_birth' => '',
                        'school_id' => '',
                        'examination_board' => '',
                        'teacher_name' => '',
                        'father_name' => '',
                        'mother_name' => '',
                        'gender' => '',
                        'current_class' => '',
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
                    $error = 2;

                    $this->session->set_userdata(array(
                        '_user_id'        =>  $new_user->id,
                        '_user_email'     =>  '',
                        '_username'       =>  $new_user->username,
                        '_totalmango'     =>  $this->getUserTotalMango($new_user),
                    ));

                    $this->trackmp("Sign Up",array(
                        "User Id" => $new_user->id,
                        "User Name" => $new_user->username,
                        "Sign In" => false,
                    ),true,false);

                }

                //! Redirect to add user page
                redirect('registration-complete/' . $error);
            }
        }

        function registrationcomplete($error = 0) {
            $this->checkForNotLoggedIn();

            //! Validation rules
            $this->form_validation->set_rules('date','Date', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $data['user'] = $this->user;
                $data['error'] = $error;
                $this->loadwebapptemplatenewwithoutheader("webapp/registrationcompletenew",$data);
            } else {

                $this->user->mobile = $this->input->post('phone_no');
                $this->user->age = $this->input->post('age');
                $this->user->updated = date("Y-m-d H:i:s");
                $this->user->save();

                //!TODO
                //$this->input->post('promo_code')

                //$this->user->profile->examination_board = $this->input->post('board');
                //$this->user->profile->current_class = $this->input->post('class');
                //$this->user->profile->updated = date("Y-m-d H:i:s");
                //$this->user->profile->save();

                //! Redirect to add user page
                redirect('onboarding');
            }
        }

        function onboarding() {
            $this->checkForNotLoggedIn();

            $data['user'] = $this->user;
            $this->loadwebapptemplatenewwithoutheader("webapp/onboarding",$data);
        }


        function login($error = 0) {
            $this->checkForLoggedIn();

            //! Validation rules
            $this->form_validation->set_rules('username','Username / Email', 'trim|required');
            $this->form_validation->set_rules('password','Password', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $data['user'] = $this->user;
                $data['error'] = $error;
                $this->loadwebapptemplatenewwithoutheader("webapp/loginnew",$data);
            } else {
                $username = $this->input->post('username');
                $password = md5($this->input->post('password'));

                //! Check the email and password
                $euser = User::find("all",array(
                    "conditions" => " (email = '$username' OR username = '$username' ) AND password = '$password' "
                ));

                $error = 0;

                //! if valid email and password
                if(isset($euser[0])) {
                    if($euser[0]->status == 'active') {            //! Initiate the session variables
                        $total_mango = $this->getUserTotalMango($euser[0]);
                        $this->session->set_userdata(array(
                            '_user_id'        =>  $euser[0]->id,
                            '_user_email'       =>  $euser[0]->email,
                            '_username'       =>  $euser[0]->username,
                            '_totalmango'       =>  $total_mango,
                        ));

                        $this->user = $euser[0];
                        $this->_totalmango = $total_mango;

                        $this->trackmp("Sign Up",array(
                            "User Id" => $euser[0]->id,
                            "User Name" => $euser[0]->username,
                            "Sign In" => true,
                        ),false,true);

                        $this->user->last_login = mdate("%Y-%m-%d %H:%i:%s");
                        $this->user->login_count = $this->user->login_count + 1;
                        $this->user->save();

                        $error = 3;
                    } else {
                        $error = 2;
                    }
                } else {
                    $error = 1;
                }

                //! If not valid email / password
                if($error == 1 || $error == 2) {            //! Display login page
                    redirect('login/' . $error);
                } else {                                    //! Else display dasboard
                    redirect('stories/books');
                }
            }
        }

        function checkForLoggedIn() {
            if(isset($this->user->id)) {
                redirect('stories/books');
                die();
            }
        }

        function checkForNotLoggedIn() {
            if(!isset($this->user->id)) {
                redirect('login');
                die();
            }
        }

        function logout() {
            $this->checkForNotLoggedIn();

            $this->session->set_userdata(array('_user_id' => '', '_user_email' => '', '_username' => ''));

            //! Destroy the sessions
            $this->session->sess_destroy();

            redirect();
        }

        function checkusername() {
            $uname = $_POST['uname'];

            $udname = User::find_by_username($uname);

            if(isset($udname)) {
                echo 2;
            } else {
                echo 1;
            }
        }

        function exploreworld($world) {
            $this->checkForNotLoggedIn();

            $data['user'] = $this->user;
            $data['worlds'] = $this->getWorldActivity($world,$this->user->id);
            $data['world_name'] = $this->getWorldName($this->getWorldCode($world));
            $this->loadwebapptemplatenew("webapp/wordybirdy",$data);
        }

        function storiesstart($story_id) {
            $this->checkForNotLoggedIn();

            $data['user'] = $this->user;
            $data['story'] = Story::find($story_id);
            $data['question'] = $this->getStoryQuestionDetailsPreVocab($story_id);

            $this->trackmp("Story Start",array(
                "User Id" => $this->user->id,
                "User Name" => $this->user->username,
                "Story Title" => $data['story']->name,
            ),false,false,"Stories Started");

            $this->loadwebapptemplatenew("webapp/myfriends1",$data);
        }

        function storiespage($story_id, $page) {
            $this->checkForNotLoggedIn();

            $data['user'] = $this->user;
            $data['story_id'] = $story_id;
            $data['page'] = $page;
            $data['story'] = Story::find($story_id);
            $data['storypage'] = $this->getStoryPageDetails($story_id,$page);

            if(@$data['storypage']->id == '') {
                redirect('stories/complete/' . $story_id);
                die;
            }

            /*if(@$data['storypage']->audio_map == '') {
                $next_page = $page + 1;
                redirect('stories/pages/' . $story_id."/" .$next_page);
                die;
            }*/

            $data['storypagelanguage'] = $this->getStoryPageLanguageDetails($data['storypage']->id,$page);

            $this->loadwebapptemplatenew("webapp/myfriends",$data);
        }

        function storiescomplete($story_id) {
            $this->checkForNotLoggedIn();

            $data['user'] = $this->user;
            $data['story_id'] = $story_id;
            $data['story'] = Story::find($story_id);
            $data['other_stories'] = $this->otherstories($story_id,$data['story']->level);

            $data['question_count'] = $this->getStoryTotalQuestionCount($story_id);
            //_new_stories

            $this->trackmp("Story End",array(
                "User Id" => $this->user->id,
                "User Name" => $this->user->username,
                "Story Title" => $data['story']->name,
                "Completed" => true,
            ),false,false,"Stories Completed");

            $this->loadwebapptemplatenew("webapp/storycomplete",$data);
        }

        function storiesquestions($story_id) {
            $this->checkForNotLoggedIn();

            $data['user'] = $this->user;
            $data['story_id'] = $story_id;
            $data['story'] = Story::find($story_id);
            $data['question_count'] = $this->getStoryTotalQuestionCount($story_id);

            $this->trackmp("Story Question Start",array(
                "User Id" => $this->user->id,
                "User Name" => $this->user->username,
                "Story Title" => $data['story']->name,
            ),false,false);

            $this->loadwebapptemplatenew("webapp/storiesquestions",$data);
        }

        function getstoryquestion() {
            $lang = get_cookie("language");
            if($lang != '') {
                $data['_lang'] = $lang;
                $data['_lang_map'] = @$this->_language_map[$lang];
                $data['_lang_db'] = @$this->_language_db_map[$lang];
            } else {
                $lang = 'english';
                $data['_lang'] = $lang;
                $data['_lang_map'] = @$this->_language_map[$lang];
                $data['_lang_db'] = @$this->_language_db_map[$lang];
            }

            $data['_translation'] = $this->_translator;

            $num = $_REQUEST['num'];
            $activity_id = $_REQUEST['activity_id'];
            $act_link = $_REQUEST['act_link'];
            $activityCount = $_REQUEST['activityCount'];

            $activity = Story::find($activity_id);
            $activityLinkage = $this->getStoryQuestionDetailsAll($activity_id,$num);

            //$act_data = $this->getSpecificActivityDetails($data['activity']->level,$data['activity']->activity_num,$data['activity']->world);

            $data['num'] = $num;
            $data['activity_id'] = $activity_id;
            $data['act_link'] = $act_link;
            $data['activity'] = $activity;
            $data['activityLinkage'] = $activityLinkage;
            $data['activityCount'] = $activityCount;
            $data['story_id'] = $activity_id;

            $data['question'] = $this->getStoryQuestionByID($activityLinkage->id);
            $data['question_set'] = json_decode($data['question']['question']);

            if ($data['question_set']->question_type == "fill_blank") {
                $this->load->view("webapp/fill_blank",$data);
            } else if ($data['question_set']->question_type == "mcq_single_answer") {
                $this->load->view("webapp/mcq_single_answer",$data);
            } else if ($data['question_set']->question_type == "match_column") {
                $this->load->view("webapp/match_column",$data);
            } else if ($data['question_set']->question_type == "make_the_sentence") {
                $this->load->view("webapp/make_the_sentence",$data);
            } else if ($data['question_set']->question_type == "conversation") {
                $this->load->view("webapp/conversation",$data);
            } else if ($data['question_set']->question_type == "record_missing_word") {
                $this->load->view("webapp/record_missing_word",$data);
            }  else if ($data['question_set']->question_type == "mcq_multiple_answer") {
                $this->load->view("webapp/mcq_multiple_answer",$data);
            } else {
                $this->load->view("webapp/trace_grapheme",$data);
            }
        }

        function savestoryquestion() {
            $score = @$_REQUEST['score'];
            $points = @$_REQUEST['points'];
            $story_id = @$_REQUEST['activity_id'];
            $questions_id = @$_REQUEST['act_link'];
            $questions = @$_REQUEST['question'];
            $scorearray = @$_REQUEST['scorearray'];
            $pointsarray = @$_REQUEST['pointsarray'];
            $answersarray = @$_REQUEST['answersarray'];
            $canswersarray = @$_REQUEST['canswersarray'];

            $story = Story::find($story_id);

            $per =  (($points / $score) * 100);
            if($per >= 80) {
                $stars = 3;
            } else if($per >= 60) {
                $stars = 2;
            } else if($per >= 40) {
                $stars = 1;
            } else {
                $stars = 0;
            }

            for($ii = 0 ; $ii < count( $questions_id ) ; $ii++) {
                $fff = "correct";
                if( $pointsarray[$ii] == 0) {
                    $fff = "wrong";
                }

                $answer = Answer::create(array(
                    'user_id' => $this->user->id,
                    'question_id' => $questions_id[$ii],
                    'concepts_id' => 0,
                    'units_id' => 0,
                    'subject_id' => 0,
                    'classes_id' => 0,
                    'result' => $fff,
                    'score' => $pointsarray[$ii],
                    'answered_dtm' => date("Y-m-d H:i:s"),
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                    'meta_type' => 0,
                ));

                $answerquestion = AnswerQuestion::create(array(
                    'user_id' => $this->user->id,
                    'answer_id' => $answer->id,
                    'question_id' => $questions_id[$ii],
                    'question' => $questions[$ii],
                    'variables' => '',
                    'answer' => '["'.$answersarray[$ii].'"]',
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s")
                ));
            }

            $tots = $this->getUserTotalMango($this->user);
            $this->session->set_userdata(array('_totalmango'  =>  $tots));
            $this->_totalmango = $tots;

            $per =  (($points / $score) * 100);
            if($per >= 80) {
                $stars = 3;
            } else if($per >= 60) {
                $stars = 2;
            } else if($per >= 40) {
                $stars = 1;
            } else {
                $stars = 0;
            }

            $this->trackmp("Story Question End",array(
                "User Id" => $this->user->id,
                "User Name" => $this->user->username,
                "Story Title" => $story->name,
                "Completed" => true,
                "Last Question Number" => count( $questions_id ),
            ),false,false);

            echo $tots . ":::1:::" . $stars;
        }

        function storiesvstart($video_id) {
            $this->checkForNotLoggedIn();

            $data['user'] = $this->user;
            $data['video'] = HelpVideo::find($video_id);
            $data['video_id'] = $video_id;

            $this->trackmp("Video start",array(
                "User Id" => $this->user->id,
                "User Name" => $this->user->username,
                "Video Name" => $data['video']->title,
                "Video Category" => $data['video']->category,
                "Video Level" => $data['video']->level,
            ),false,false);

            $this->loadwebapptemplatenew("webapp/videopage",$data);
        }

        function storiesvcomplete($video_id) {
            $this->checkForNotLoggedIn();

            $data['user'] = $this->user;
            $data['video_id'] = $video_id;
            $data['video'] = HelpVideo::find($video_id);
            $data['other_video'] = $this->othervideos($video_id,$data['video']->level);
            $data['question_count'] = $this->getCountInActivityForHelpVideo($video_id, 1) + $this->getHelpVideoTotalQuestionCount($video_id);

            $this->trackmp("Video end",array(
                "User Id" => $this->user->id,
                "User Name" => $this->user->username,
                "Video Name" => $data['video']->title,
                "Video Category" => $data['video']->category,
                "Video Level" => $data['video']->level,
                "Completed" => true,
            ),false,false);

            $this->loadwebapptemplatenew("webapp/storyvcomplete",$data);
        }

        function storiesquestionsv($hv_id) {
            $this->checkForNotLoggedIn();

            $data['user'] = $this->user;
            $data['hv_id'] = $hv_id;
            $data['activity'] = HelpVideo::find($hv_id);
            $data['activityCount'] = $this->getCountInActivityForHelpVideo($hv_id, 1) + $this->getHelpVideoTotalQuestionCount($hv_id);
            //$data['activity'] = Activity::find($activity_id);
            $data['activityLinkage'] = $this->getHelpVideoActivityLinkageData($hv_id,1);

            $this->trackmp("Video Question Start",array(
                "User Id" => $this->user->id,
                "User Name" => $this->user->username,
                "Video Name" => $data['activity']->title,
            ),false,false);

            $this->loadwebapptemplatenew("webapp/storiesquestionsv",$data);
        }

        function getstoryquestionv() {
            $lang = get_cookie("language");
            if($lang != '') {
                $data['_lang'] = $lang;
                $data['_lang_map'] = @$this->_language_map[$lang];
                $data['_lang_db'] = @$this->_language_db_map[$lang];
            } else {
                $lang = 'english';
                $data['_lang'] = $lang;
                $data['_lang_map'] = @$this->_language_map[$lang];
                $data['_lang_db'] = @$this->_language_db_map[$lang];
            }

            $data['_translation'] = $this->_translator;
            $data['_video_id'] = $_REQUEST['activity_id'];

            $num = $_REQUEST['num'];
            $activity_id = $_REQUEST['activity_id'];
            $act_link = $_REQUEST['act_link'];
            $activityCount = $_REQUEST['activityCount'];

            $activity = HelpVideo::find($activity_id);

            if($this->getHelpVideoTotalQuestionCount($activity_id) > 0) {
                $activityLinkage = $this->getQuestionHV($act_link);
                //$act_data = $this->getSpecificActivityDetails($data['activity']->level,$data['activity']->activity_num,$data['activity']->world);

                $data['num'] = $num;
                $data['activity_id'] = $activity_id;
                $data['act_link'] = $act_link;
                $data['activity'] = $activity;
                $data['activityLinkage'] = $activityLinkage;
                $data['activityCount'] = $activityCount;

                $data['question'] = $activityLinkage;
                $data['question_set'] = json_decode($data['question']['question']);

                if ($data['question_set']->question_type == "fill_blank") {
                    $this->load->view("webapp/fill_blank",$data);
                } else if ($data['question_set']->question_type == "mcq_single_answer") {
                    $this->load->view("webapp/mcq_single_answer",$data);
                } else if ($data['question_set']->question_type == "match_column") {
                    $this->load->view("webapp/match_column",$data);
                } else if ($data['question_set']->question_type == "make_the_sentence") {
                    $this->load->view("webapp/make_the_sentence",$data);
                } else if ($data['question_set']->question_type == "mcq_multiple_answer") {
                    $this->load->view("webapp/mcq_multiple_answer",$data);
                } else {
                    $this->load->view("webapp/trace_grapheme",$data);
                }

            } else {

                $activityLinkage = HelpActivityLinkage::find($act_link);

                //$act_data = $this->getSpecificActivityDetails($data['activity']->level,$data['activity']->activity_num,$data['activity']->world);

                $data['num'] = $num;
                $data['activity_id'] = $activity_id;
                $data['act_link'] = $act_link;
                $data['activity'] = $activity;
                $data['activityLinkage'] = $activityLinkage;
                $data['activityCount'] = $activityCount;

                if($activityLinkage->type == "learn_letter") {
                    $data['grapheme'] = $this->getGraphemeData($activityLinkage->type_id);
                    $this->load->view("webapp/learn_letter",$data);
                } else if ($activityLinkage->type == "learn_grapheme") {
                    $data['grapheme'] = $this->getGraphemeData($activityLinkage->type_id);
                    $this->load->view("webapp/learn_grapheme",$data);
                } else if ($activityLinkage->type == "trace_grapheme") {
                    $data['grapheme'] = $this->getGraphemeData($activityLinkage->type_id);
                    $this->load->view("webapp/trace_grapheme",$data);
                } else if ($activityLinkage->type == "first_last_sound") {
                    $data['grapheme'] = $this->getGraphemeData($activityLinkage->type_id);
                    $koibe = json_decode($activityLinkage->additional_info);
                    $position = $koibe->letter_at;
                    if($position == '') {
                        $position = "first";
                    }
                    $data['position'] = $position;
                    $data['question'] = $this->getFirstLastMiddleSoundData($data['grapheme']['grapheme'], $position, 1);
                    $this->load->view("webapp/first_last_sound",$data);
                } else if ($activityLinkage->type == "first_last_sound_random") {
                    $array1 = array("first", "last");
                    $array2 = array("first", "middle");
                    $array3 = array("a", "e", "i", "o", "u");
                    $array5 = array("j", 'q', 'v', 'x', 'z','h','c' );
                    $array4 = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");

                    $gra = $array4[rand(0,count($array4) - 1)];
                    $pos = "";
                    if(in_array($gra, $array5)) {
                        $pos = "first";
                    } else if(in_array($gra, $array3)) {
                        $pos = $array2[rand(0,count($array2) - 1)];
                    } else {
                        $pos = $array1[rand(0,count($array1) - 1)];
                    }

                    $data['grapheme'] = $this->getGraphemeDataByGrapheme($gra);

                    $data['position'] = $pos;
                    $data['question'] = $this->getFirstLastMiddleSoundData($gra, $pos, 1);
                    $this->load->view("webapp/first_last_sound",$data);
                } else if ($activityLinkage->type == "missing_letter") {
                    $missing_grapheme = "";
                    $koibe = json_decode($activityLinkage->additional_info);
                    $missing_grapheme = $koibe->missing_letter;

                    $data['question'] = $this->getWordsegmentData($activityLinkage->type_id, $missing_grapheme);
                    $data['missing_grapheme'] = $missing_grapheme;

                    $this->load->view("webapp/missing_letter",$data);
                } else if ($activityLinkage->type == "listen_to_a_sound") {
                    $data['question'] = $this->getListenToASound($activityLinkage->type_id);
                    $this->load->view("webapp/listen_to_a_sound",$data);
                } else if ($activityLinkage->type == "listen_to_a_sound_random") {
                    $graphemes = "";
                    $koibe = json_decode($activityLinkage->additional_info);
                    $graphemes = $koibe->graphemes;
                    $graphemesarray = explode(",",$graphemes);
                    shuffle($graphemesarray);
                    $data['question'] = $this->getListenToASoundRandom($graphemesarray[rand(0,count($graphemesarray)-1)]);
                    $this->load->view("webapp/listen_to_a_sound",$data);
                } else if ($activityLinkage->type == "vocab") {
                    $data['question'] = $this->getVocab($activityLinkage->type_id);
                    $this->load->view("webapp/vocab",$data);
                } else if ($activityLinkage->type == "vocabrandom") {
                    $data['question'] = $this->getVocabRandomSingle($activityLinkage->type_id);
                    $this->load->view("webapp/vocab",$data);
                } else if ($activityLinkage->type == "vocabconceptrandom") {
                    $data['question'] = $this->getVocabConceptRandomSingle($activityLinkage->type_id);
                    $this->load->view("webapp/vocab",$data);
                } else if ($activityLinkage->type == "rhymes") {
                    $data['question'] = $this->getPhrase($activityLinkage->type_id,100);
                    $this->load->view("webapp/rhymes",$data);
                } else if ($activityLinkage->type == "vowel_blend") {
                    $data['question'] = $this->getVowelBlend($activityLinkage->type_id);
                    $this->load->view("webapp/vowel_blend",$data);
                } else if ($activityLinkage->type == "vowel_blend_trace") {
                    $data['question'] = $this->getVowelBlend($activityLinkage->type_id);
                    $this->load->view("webapp/vowel_blend_trace",$data);
                } else if ($activityLinkage->type == "segmenting_blending") {
                    $data['question'] = $this->getSegmentBlending($activityLinkage->type_id);
                    $this->load->view("webapp/segmenting_blending",$data);
                } else if ($activityLinkage->type == "word_game") {
                    $data['question'] = $this->getWordGame($activityLinkage->type_id);
                    $this->load->view("webapp/word_game",$data);
                } else if ($activityLinkage->type == "segmenting_blending_random") {
                    $data['question'] = $this->getSegmentBlendingRandom($activityLinkage->type_id,1);
                    $this->load->view("webapp/segmenting_blending",$data);
                } else if ($activityLinkage->type == "word_game_random") {
                    $data['question'] = $this->getWordGameRandom($activityLinkage->type_id, 1);
                    $this->load->view("webapp/word_game",$data);
                } else if ($activityLinkage->type == "word_game_random_grapheme") {
                    $data['question'] = $this->getWordGameRandomGrapheme($activityLinkage->type_id, 1);
                    $this->load->view("webapp/word_game",$data);
                } else if ($activityLinkage->type == "reading_test") {
                    $data['question'] = $this->getConceptQuestion($activityLinkage->type_id, 1);
                    $this->load->view("webapp/reading_test",$data);
                } else if ($activityLinkage->type == "phrase") {
                    $data['question'] = $this->getPhrase($activityLinkage->type_id, 1);
                    $this->load->view("webapp/phrase",$data);
                } else if ($activityLinkage->type == "phrase_game") {
                    $data['question'] = $this->getPhraseGame($activityLinkage->type_id);
                    $this->load->view("webapp/phrase_game",$data);
                } else if ($activityLinkage->type == "grammar") {
                     $data['question'] = $this->getQuestion($activityLinkage->type_id);
                     $data['question_set'] = json_decode($data['question']['question']);

                    if ($data['question_set']->question_type == "fill_blank") {
                        $this->load->view("webapp/fill_blank",$data);
                    } else if ($data['question_set']->question_type == "mcq_single_answer") {
                        $this->load->view("webapp/mcq_single_answer",$data);
                    } else if ($data['question_set']->question_type == "match_column") {
                        $this->load->view("webapp/match_column",$data);
                    } else if ($data['question_set']->question_type == "make_the_sentence") {
                        $this->load->view("webapp/make_the_sentence",$data);
                    } else if ($data['question_set']->question_type == "mcq_multiple_answer") {
                        $this->load->view("webapp/mcq_multiple_answer",$data);
                    }
                } else if ($activityLinkage->type == "grammarrandom") {
                    $data['question'] = $this->getConceptQuestion($activityLinkage->type_id,1);
                    $data['question_set'] = json_decode($data['question']['question']);

                    if ($data['question_set']->question_type == "fill_blank") {
                        $this->load->view("webapp/fill_blank",$data);
                    } else if ($data['question_set']->question_type == "mcq_single_answer") {
                        $this->load->view("webapp/mcq_single_answer",$data);
                    } else if ($data['question_set']->question_type == "match_column") {
                        $this->load->view("webapp/match_column",$data);
                    } else if ($data['question_set']->question_type == "make_the_sentence") {
                        $this->load->view("webapp/make_the_sentence",$data);
                    } else if ($data['question_set']->question_type == "mcq_multiple_answer") {
                        $this->load->view("webapp/mcq_multiple_answer",$data);
                    }
                } else if ($activityLinkage->type == "grammarrandom_specific") {
                    $data['question'] = $this->getSpecificQuestion($activityLinkage->type_id,1);
                    $data['question_set'] = json_decode($data['question']['question']);

                    if ($data['question_set']->question_type == "fill_blank") {
                        $this->load->view("webapp/fill_blank",$data);
                    } else if ($data['question_set']->question_type == "mcq_single_answer") {
                        $this->load->view("webapp/mcq_single_answer",$data);
                    } else if ($data['question_set']->question_type == "match_column") {
                        $this->load->view("webapp/match_column",$data);
                    } else if ($data['question_set']->question_type == "make_the_sentence") {
                        $this->load->view("webapp/make_the_sentence",$data);
                    } else if ($data['question_set']->question_type == "mcq_multiple_answer") {
                        $this->load->view("webapp/mcq_multiple_answer",$data);
                    }
                } else if ($activityLinkage->type == "oddity_starts_with_grapheme") {
                    $data['question'] = $this->getOddityStartsWithGrapheme($activityLinkage->type_id);
                    $this->load->view("webapp/oddity_starts_with_grapheme",$data);
                } else if ($activityLinkage->type == "oddity_ends_with_grapheme") {
                    $data['question'] = $this->getOddityEndsWithGrapheme($activityLinkage->type_id);
                    $this->load->view("webapp/oddity_ends_with_grapheme",$data);
                } else {
                    $this->load->view("webapp/trace_grapheme",$data);
                }
            }
        }

        function savestoryquestionv() {
            $score = @$_REQUEST['score'];
            $points = @$_REQUEST['points'];
            $activity_id = @$_REQUEST['activity_id'];    //! this is help video id
            $act_link = @$_REQUEST['act_link'];
            $activityLinkage = @$_REQUEST['act_link'];
            $scorearray = @$_REQUEST['scorearray'];
            $pointsarray = @$_REQUEST['pointsarray'];
            $answersarray = @$_REQUEST['answersarray'];
            $canswersarray = @$_REQUEST['canswersarray'];

            $help_video = HelpVideo::find($activity_id);

            $per =  (($points / $score) * 100);
            if($per >= 80) {
                $stars = 3;
            } else if($per >= 60) {
                $stars = 2;
            } else if($per >= 40) {
                $stars = 1;
            } else {
                $stars = 0;
            }

            //$activity = $this->getHelpVideoActivity($activity_id);

            $user_activity = UserActivity::create(array(
                'user_id' => $this->user->id,
                'activity_id' => $activity_id,
                'points' => $score,   // points is score and vice versa
                'score' => $points,
                'stars' => $stars,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s"),
                'level' => 1,
                'activity_number' => 1,
                'meta_type' => 1,
            ));

            //if($user_activity->id) {
                for($ii = 0 ; $ii < count( $activityLinkage ) ; $ii++) {

                    //$activity_linkage = HelpActivityLinkage::find($activityLinkage[$ii]);

                    $fff = "right";
                    if( $pointsarray[$ii] == 0) {
                        $fff = "wrong";
                    }

                    $user_activity_record = UserActivityRecord::create(array(
                        'user_id' => $this->user->id,
                        'activity_id' => $activity_id,
                        'points' => $pointsarray[$ii],
                        'score' => $scorearray[$ii],
                        'stars' => 0,
                        'status' => $fff,
                        'date_time' => date("Y-m-d H:i:s"),
                        'created' => date("Y-m-d H:i:s"),
                        'updated' => date("Y-m-d H:i:s"),
                        'activity_linkage_id' => $activityLinkage[$ii],
                        'audio' => '',
                        'image' => '',
                        'unique_id' => $user_activity->id,
                        'type_id' => $activityLinkage[$ii],
                        'meta_type' => 1,
                    ));
                }
           // }

            $tots = $this->getUserTotalMango($this->user);
            $this->session->set_userdata(array('_totalmango'  =>  $tots));
            $this->_totalmango = $tots;

            $this->trackmp("Video Question End",array(
                "User Id" => $this->user->id,
                "User Name" => $this->user->username,
                "Video Name" => $help_video->title,
                "Completed" => true,
                "Last Question No" => count( $activityLinkage ),
            ),false,false);

            echo $tots . ":::1:::" . $stars;
        }


        function activitystart($activity_id) {
            $this->checkForNotLoggedIn();

            if(strpos(@$_SERVER["HTTP_REFERER"],'rhymes') !== false ) {
                $this->session->set_userdata(array(
                        '_from'        =>  "rhymes",
                ));
            } else {
                $this->session->set_userdata(array(
                        '_from'        =>  "activity",
                ));
            }

            $data['user'] = $this->user;
            $data['activity'] = Activity::find($activity_id);

            $this->loadwebapptemplatenew("webapp/activitystart",$data);
        }

        function activitypage($activity_id) {
            $this->checkForNotLoggedIn();

            //$this->session->userdata('_activity_id')

            $data['user'] = $this->user;
            $data['activity'] = Activity::find($activity_id);
            //$data['activityCount'] = $this->getCountInActivity($data['activity']->level,$data['activity']->activity_num,$data['activity']->world);
            $data['activityLinkage'] = $this->getActivityLinkageData($data['activity']->level,$data['activity']->activity_num,$data['activity']->world,$data['activity']->category);

            $this->trackmp("Activity Start",array(
                "User Id" => $this->user->id,
                "User Name" => $this->user->username,
                "Activity" => $data['activity']->level,
                "Activity Title" => $data['activity']->name,
                "Sub-Activity Number" => $data['activity']->activity_num,
                "Source" => "Explore",
            ),false,false,"Activities Started");

            $_from = $this->session->userdata('_from');

            $data['_from'] = $_from;

            $this->loadwebapptemplatenew("webapp/activitypage",$data);
        }

        function saveactivitylinkage() {
            $score = @$_REQUEST['score'];
            $points = @$_REQUEST['points'];
            $activity_id = @$_REQUEST['activity_id'];
            $act_link = @$_REQUEST['act_link'];
            $activityLinkage = @$_REQUEST['act_link'];
            $scorearray = @$_REQUEST['scorearray'];
            $pointsarray = @$_REQUEST['pointsarray'];
            $answersarray = @$_REQUEST['answersarray'];
            $canswersarray = @$_REQUEST['canswersarray'];

            $activity = Activity::find($activity_id);

            $per =  (($points / $score) * 100);
            if($per >= 80) {
                $stars = 3;
            } else if($per >= 60) {
                $stars = 2;
            } else if($per >= 40) {
                $stars = 1;
            } else {
                $stars = 0;
            }

            $activitylevel = $activity->level;
            $activityactivity_num = $activity->activity_num;
            if(in_array($activity_id,array(320,321,322,323))) {
                $activitylevel = $activityactivity_num = 0;
            }

            $user_activity = UserActivity::create(array(
                'user_id' => $this->user->id,
                'activity_id' => $activity_id,
                'points' => $score,   // points is score and vice versa
                'score' => $points,
                'stars' => $stars,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s"),
                'level' => $activitylevel,
                'activity_number' => $activityactivity_num,
                'meta_type' => 0,
            ));

            //if($user_activity->id) {
                for($ii = 0 ; $ii < count( $activityLinkage ) ; $ii++) {

                    $activity_linkage = ActivityLinkage::find($activityLinkage[$ii]);

                    $fff = "right";
                    if( $pointsarray[$ii] == 0) {
                        $fff = "wrong";
                    }

                    $user_activity_record = UserActivityRecord::create(array(
                        'user_id' => $this->user->id,
                        'activity_id' => $activity_id,
                        'points' => $pointsarray[$ii],
                        'score' => $scorearray[$ii],
                        'stars' => 0,
                        'status' => $fff,
                        'date_time' => date("Y-m-d H:i:s"),
                        'created' => date("Y-m-d H:i:s"),
                        'updated' => date("Y-m-d H:i:s"),
                        'activity_linkage_id' => $activity_linkage->id,
                        'audio' => '',
                        'image' => '',
                        'unique_id' => $user_activity->id,
                        'type_id' => $activity_linkage->type_id,
                        'meta_type' => 0,
                    ));
                }
           // }

            $tots = $this->getUserTotalMango($this->user);
            $this->session->set_userdata(array('_totalmango'  =>  $tots));
            $this->_totalmango = $tots;

            if($activity_id == 320 ) {
                $currentL1 = 8;
                $currentAN1 = 1;
            } else if($activity_id == 321 ) {
                $currentL1 = 16;
                $currentAN1 = 1;
            } else if($activity_id == 322 ) {
                $currentL1 = 29;
                $currentAN1 = 1;
            } else if($activity_id == 323 ) {
                $currentL1 = 43;
                $currentAN1 = 1;
            } else {
                $currentL1 = $activity->level;
                $currentAN1 = $activity->activity_num + 1;
            }

            $sql5 = "SELECT level, MAX(activity_num) AS activity_num1 FROM mg_activity WHERE ( delete_flag = 0 OR delete_flag IS NULL ) AND challenge = 0 AND level = '" . $currentL1 . "' GROUP BY level ORDER BY level;";
            $cursor5 = User::find_by_sql( $sql5 );

            if (isset($cursor5[0])) {
                if ($currentAN1 > $cursor5[0]->activity_num1) {
                    $currentL1++;
                    $currentAN1 = 1;
                }
            }

            if ($currentL1 == 47) {
                $currentL1 = 48;
                $currentAN1 = 1;
            }

            if ($currentL1 == 6 && $currentAN1 == 7) {
                $currentL1 = 6;
                $currentAN1 = 8;
            }

            $next_id = $activity_id;

            $sql3 = "SELECT id FROM mg_activity WHERE level = '" . $currentL1 . "' AND activity_num = '" . $currentAN1 . "' AND challenge = 0 AND ( delete_flag = 0 OR delete_flag IS NULL );";
            $cursor3 = User::find_by_sql( $sql3 );

            if(isset($cursor3[0])) {
                $next_id = $cursor3[0]->id;
            }

            if($per >= 80) {
                if(in_array($activity_id,array(320,321,322,323))) {
                    $error = $this->checkChallengeUserActivity($activitylevel, $score, $activity->world, $this->user->id);
                }

            }

            $this->trackmp("Activity End",array(
                "User Id" => $this->user->id,
                "User Name" => $this->user->username,
                "Activity" => $activity->level,
                "Activity Title" => $activity->name,
                "Sub-Activity Number" => $activity->activity_num,
                "Percentage" => $per ."%",
                "Source" => "Explore",
                "Completed" => true,
            ),false,false,"Activities  Completed");

            echo $tots . ":::" . $next_id . ":::" . $stars;
        }

        function getactivitylinkage() {
            $lang = get_cookie("language");
            if($lang != '') {
                $data['_lang'] = $lang;
                $data['_lang_map'] = @$this->_language_map[$lang];
                $data['_lang_db'] = @$this->_language_db_map[$lang];
            } else {
                $lang = 'english';
                $data['_lang'] = $lang;
                $data['_lang_map'] = @$this->_language_map[$lang];
                $data['_lang_db'] = @$this->_language_db_map[$lang];
            }

            $data['_translation'] = $this->_translator;

            $num = $_REQUEST['num'];
            $activity_id = $_REQUEST['activity_id'];
            $act_link = $_REQUEST['act_link'];
            $activityCount = $_REQUEST['activityCount'];

            $activity = Activity::find($activity_id);
            $activityLinkage = ActivityLinkage::find($act_link);

            //$act_data = $this->getSpecificActivityDetails($data['activity']->level,$data['activity']->activity_num,$data['activity']->world);

            $data['num'] = $num;
            $data['activity_id'] = $activity_id;
            $data['act_link'] = $act_link;
            $data['activity'] = $activity;
            $data['activityLinkage'] = $activityLinkage;
            $data['activityCount'] = $activityCount;

            if($activityLinkage->type == "learn_letter") {
                $data['grapheme'] = $this->getGraphemeData($activityLinkage->type_id);
                $this->load->view("webapp/learn_letter",$data);
            } else if ($activityLinkage->type == "learn_grapheme") {
                $data['grapheme'] = $this->getGraphemeData($activityLinkage->type_id);
                $this->load->view("webapp/learn_grapheme",$data);
            } else if ($activityLinkage->type == "trace_grapheme") {
                $data['grapheme'] = $this->getGraphemeData($activityLinkage->type_id);
                $this->load->view("webapp/trace_grapheme",$data);
            } else if ($activityLinkage->type == "first_last_sound") {
                $data['grapheme'] = $this->getGraphemeData($activityLinkage->type_id);
                $koibe = json_decode($activityLinkage->additional_info);
                $position = $koibe->letter_at;
                if($position == '') {
                    $position = "first";
                }
                $data['position'] = $position;
                $data['question'] = $this->getFirstLastMiddleSoundData($data['grapheme']['grapheme'], $position, 1);
                $this->load->view("webapp/first_last_sound",$data);
            } else if ($activityLinkage->type == "first_last_sound_random") {
                $array1 = array("first", "last");
                $array2 = array("first", "middle");
                $array3 = array("a", "e", "i", "o", "u");
                $array5 = array("j", 'q', 'v', 'x', 'z','h','c' );
                $array4 = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");

                $gra = $array4[rand(0,count($array4) - 1)];
                $pos = "";
                if(in_array($gra, $array5)) {
                    $pos = "first";
                } else if(in_array($gra, $array3)) {
                    $pos = $array2[rand(0,count($array2) - 1)];
                } else {
                    $pos = $array1[rand(0,count($array1) - 1)];
                }

                $data['grapheme'] = $this->getGraphemeDataByGrapheme($gra);

                $data['position'] = $pos;
                $data['question'] = $this->getFirstLastMiddleSoundData($gra, $pos, 1);
                $this->load->view("webapp/first_last_sound",$data);
            } else if ($activityLinkage->type == "missing_letter") {
                $missing_grapheme = "";
                $koibe = json_decode($activityLinkage->additional_info);
                $missing_grapheme = $koibe->missing_letter;

                $data['question'] = $this->getWordsegmentData($activityLinkage->type_id, $missing_grapheme);
                $data['missing_grapheme'] = $missing_grapheme;

                $this->load->view("webapp/missing_letter",$data);
            } else if ($activityLinkage->type == "listen_to_a_sound") {
                $data['question'] = $this->getListenToASound($activityLinkage->type_id);
                $this->load->view("webapp/listen_to_a_sound",$data);
            } else if ($activityLinkage->type == "listen_to_a_sound_random") {
                $graphemes = "";
                $koibe = json_decode($activityLinkage->additional_info);
                $graphemes = $koibe->graphemes;
                $graphemesarray = explode(",",$graphemes);
                shuffle($graphemesarray);
                $data['question'] = $this->getListenToASoundRandom($graphemesarray[rand(0,count($graphemesarray)-1)]);
                $this->load->view("webapp/listen_to_a_sound",$data);
            } else if ($activityLinkage->type == "vocab") {
                $data['question'] = $this->getVocab($activityLinkage->type_id);
                $this->load->view("webapp/vocab",$data);
            } else if ($activityLinkage->type == "vocabrandom") {
                $data['question'] = $this->getVocabRandomSingle($activityLinkage->type_id);
                $this->load->view("webapp/vocab",$data);
            } else if ($activityLinkage->type == "vocabconceptrandom") {
                $data['question'] = $this->getVocabConceptRandomSingle($activityLinkage->type_id);
                $this->load->view("webapp/vocab",$data);
            } else if ($activityLinkage->type == "rhymes") {
                $data['question'] = $this->getPhrase($activityLinkage->type_id,100);
                $this->load->view("webapp/rhymes",$data);
            } else if ($activityLinkage->type == "vowel_blend") {
                $data['question'] = $this->getVowelBlend($activityLinkage->type_id);
                $this->load->view("webapp/vowel_blend",$data);
            } else if ($activityLinkage->type == "vowel_blend_trace") {
                $data['question'] = $this->getVowelBlend($activityLinkage->type_id);
                $this->load->view("webapp/vowel_blend_trace",$data);
            } else if ($activityLinkage->type == "segmenting_blending") {
                $data['question'] = $this->getSegmentBlending($activityLinkage->type_id);
                $this->load->view("webapp/segmenting_blending",$data);
            } else if ($activityLinkage->type == "word_game") {
                $data['question'] = $this->getWordGame($activityLinkage->type_id);
                $this->load->view("webapp/word_game",$data);
            } else if ($activityLinkage->type == "segmenting_blending_random") {
                $data['question'] = $this->getSegmentBlendingRandom($activityLinkage->type_id,1);
                $this->load->view("webapp/segmenting_blending",$data);
            } else if ($activityLinkage->type == "word_game_random") {
                $data['question'] = $this->getWordGameRandom($activityLinkage->type_id, 1);
                $this->load->view("webapp/word_game",$data);
            } else if ($activityLinkage->type == "word_game_random_grapheme") {
                $data['question'] = $this->getWordGameRandomGrapheme($activityLinkage->type_id, 1);
                $this->load->view("webapp/word_game",$data);
            } else if ($activityLinkage->type == "reading_test") {
                $data['question'] = $this->getConceptQuestion($activityLinkage->type_id, 1);
                $this->load->view("webapp/reading_test",$data);
            } else if ($activityLinkage->type == "phrase") {
                $data['question'] = $this->getPhrase($activityLinkage->type_id, 1);
                $this->load->view("webapp/phrase",$data);
            } else if ($activityLinkage->type == "phrase_game") {
                $data['question'] = $this->getPhraseGame($activityLinkage->type_id);
                $this->load->view("webapp/phrase_game",$data);
            } else if ($activityLinkage->type == "grammar") {
                 $data['question'] = $this->getQuestion($activityLinkage->type_id);
                 $data['question_set'] = json_decode($data['question']['question']);

                if ($data['question_set']->question_type == "fill_blank") {
                    $this->load->view("webapp/fill_blank",$data);
                } else if ($data['question_set']->question_type == "mcq_single_answer") {
                    $this->load->view("webapp/mcq_single_answer",$data);
                } else if ($data['question_set']->question_type == "match_column") {
                    $this->load->view("webapp/match_column",$data);
                } else if ($data['question_set']->question_type == "make_the_sentence") {
                    $this->load->view("webapp/make_the_sentence",$data);
                } else if ($data['question_set']->question_type == "mcq_multiple_answer") {
                    $this->load->view("webapp/mcq_multiple_answer",$data);
                }
            } else if ($activityLinkage->type == "grammarrandom") {
                $data['question'] = $this->getConceptQuestion($activityLinkage->type_id,1);
                $data['question_set'] = json_decode($data['question']['question']);

                if ($data['question_set']->question_type == "fill_blank") {
                    $this->load->view("webapp/fill_blank",$data);
                } else if ($data['question_set']->question_type == "mcq_single_answer") {
                    $this->load->view("webapp/mcq_single_answer",$data);
                } else if ($data['question_set']->question_type == "match_column") {
                    $this->load->view("webapp/match_column",$data);
                } else if ($data['question_set']->question_type == "make_the_sentence") {
                    $this->load->view("webapp/make_the_sentence",$data);
                } else if ($data['question_set']->question_type == "mcq_multiple_answer") {
                    $this->load->view("webapp/mcq_multiple_answer",$data);
                }
            } else if ($activityLinkage->type == "grammarrandom_specific") {
                $data['question'] = $this->getSpecificQuestion($activityLinkage->type_id,1);
                $data['question_set'] = json_decode($data['question']['question']);

                if ($data['question_set']->question_type == "fill_blank") {
                    $this->load->view("webapp/fill_blank",$data);
                } else if ($data['question_set']->question_type == "mcq_single_answer") {
                    $this->load->view("webapp/mcq_single_answer",$data);
                } else if ($data['question_set']->question_type == "match_column") {
                    $this->load->view("webapp/match_column",$data);
                } else if ($data['question_set']->question_type == "make_the_sentence") {
                    $this->load->view("webapp/make_the_sentence",$data);
                } else if ($data['question_set']->question_type == "mcq_multiple_answer") {
                    $this->load->view("webapp/mcq_multiple_answer",$data);
                }
            } else if ($activityLinkage->type == "oddity_starts_with_grapheme") {
                $data['question'] = $this->getOddityStartsWithGrapheme($activityLinkage->type_id);
                $this->load->view("webapp/oddity_starts_with_grapheme",$data);
            } else if ($activityLinkage->type == "oddity_ends_with_grapheme") {
                $data['question'] = $this->getOddityEndsWithGrapheme($activityLinkage->type_id);
                $this->load->view("webapp/oddity_ends_with_grapheme",$data);
            } else {
                $this->load->view("webapp/trace_grapheme",$data);
            }
        }

        /// Internal Functions

        //! Daily Quest functions
        private function getDailyQuestData($user = NULL ) {
            if(!$user) {
                return array();
            }

            $dcact = array();

            //! Get the previous date ( current - 1 )
            $prev_date = date( "Y-m-d 23:59:59", mktime( 1,1,1,date("m"),date("d")-1, date("Y") ) );

            //! Get the max level and activity number
            $sql4 = "SELECT MAX(level) AS level, MAX(activity_number) AS activity_number FROM mg_user_activity WHERE meta_type= '0' AND user_id = '" . $user->id . "' AND created <= '" . $prev_date . "' GROUP BY level ORDER BY level DESC LIMIT 0,1";

            $cursor4 = User::find_by_sql( $sql4 );

            $currentL1 = 1;
            $currentAN1 = 1;
            $currentL2 = 1;
            $currentAN2 = 2;
            $currentL3 = 1;
            $currentAN3 = 3;

            //Max User Level
            if (isset($cursor4[0])) {
                $currentL3 = $currentL2 = $currentL1 = $cursor4[0]->level;
                $currentAN1 = $cursor4[0]->activity_number + 1;
                $currentAN2 = $currentAN1 + 1;
                $currentAN3 = $currentAN2 + 1;

                $sql5 = "SELECT level, MAX(activity_num) AS activity_num FROM mg_activity WHERE ( delete_flag = 0 OR delete_flag IS NULL ) AND challenge = 0 AND level = '" . $currentL1 . "' GROUP BY level ORDER BY level;";
                $cursor5 = User::find_by_sql( $sql5 );

                if (isset($cursor5[0])) {
                    if ($currentAN1 > $cursor5[0]->activity_num) {
                        $currentL1++;
                        $currentL2++;
                        $currentL3++;
                        $currentAN1 = 1;
                        $currentAN2 = 2;
                        $currentAN3 = 3;
                    } else if ($currentAN2 > $cursor5[0]->activity_num) {
                        $currentL2++;
                        $currentL3++;
                        $currentAN2 = 1;
                        $currentAN3 = 2;
                    } else if ($currentAN3 > $cursor5[0]->activity_num) {
                        $currentL3++;
                        $currentAN3 = 1;
                    }
                }
            }

            if ($currentL1 == 47) {
                $currentL1 = $currentL2 = $currentL3 = 48;
                $currentAN1 = 1;
                $currentAN2 = 2;
                $currentAN3 = 3;
            }

            if ($currentL1 >= 76) {
                $currentL1 = $currentL2 = $currentL3 = 76;
                if($currentAN1 >= 2) {
                    $currentAN1 = 2;
                    $currentAN2 = 3;
                    $currentAN3 = 4;
                }
            }

            if ($currentL1 == 6 && $currentAN1 == 7) {
                $currentL1 = $currentL2 = $currentL3 = 7;
                $currentAN1 = 1;
                $currentAN2 = 2;
                $currentAN3 = 3;
            }

            if ($currentL2 == 6 && $currentAN2 == 7) {
                $currentL2 = $currentL3 = 7;
                $currentAN2 = 1;
                $currentAN3 = 2;
            }

            if ($currentL3 == 6 && $currentAN3 == 7) {
                $currentL3 = 7;
                $currentAN3 = 1;
            }

            $user_star = array();
            $user_score_per = array();

            $sql3 = "SELECT level, activity_number, MAX(stars) as stars,points, score FROM mg_user_activity WHERE user_id = '" . $user->id . "' AND ( ( level = '" . $currentL1 . "' AND activity_number = '" . $currentAN1 . "' ) OR ( level = '" . $currentL2 . "' AND activity_number = '" . $currentAN2 . "' ) OR ( level = '" . $currentL3 . "' AND activity_number = '" . $currentAN3 . "' ) ) AND meta_type = '0' GROUP BY level,activity_number ORDER BY level,activity_number;";
            $cursor3 = User::find_by_sql( $sql3 );

            if(isset($cursor3[0])) {
                foreach($cursor3 as $val) {
                    $user_star[$val->level . "_" . $val->activity_number] = $val->stars;
                    $scoree = 0;
                    $pointss = 0;
                    $sql31 = "SELECT points, score FROM mg_user_activity WHERE level = '". $val->level. "' AND activity_number = '" .$val->activity_number. "' AND meta_type = '0' AND user_id = '" . $user->id . "' ORDER BY score DESC LIMIT 0,1;";
                    $cursor31 = User::find_by_sql( $sql31 );
                    if (isset($cursor31[0])) {
                        $pointss = $cursor31[0]->points;
                        $scoree = $cursor31[0]->score;
                    }

                    $user_score_per[$val->level . "_" . $val->activity_number] = 0;
                    if ($pointss > 0) {
                        $perc = ($scoree / $pointss) * 100;
                        $perc = round($perc,2);
                        $user_score_per[$val->level . "_" . $val->activity_number] = $perc;
                    }
                }
            }

            $activity_level = array();
            $sql1 = "SELECT level, title FROM mg_activity_level WHERE level = '" .$currentL1. "' OR level = '".$currentL2."' OR level = '".$currentL3."' ORDER BY level;";
            $cursor1 = User::find_by_sql( $sql1 );
            if (isset($cursor1[0])) {
                foreach($cursor1 as $val) {
                    $activity_level[$val->level] = $val->title;
                }
            }

            $sql2 = "SELECT id, level, activity_num, name, score, category, world FROM mg_activity WHERE ( delete_flag = 0 OR delete_flag IS NULL ) AND challenge = 0 AND ( ( level = '" .$currentL1 . "' AND activity_num = '".$currentAN1."' ) OR ( level = '".$currentL2."' AND activity_num = '".$currentAN2."' ) OR ( level = '".$currentL3."' AND activity_num = '".$currentAN3."' ) ) ORDER BY level,activity_num;";
            $cursor2 = User::find_by_sql( $sql2 );

            $previous = -1;
            $activitySubActivityDetails = array();
            $flagg = 0;
            if(isset($cursor2[0])) {
                $mmm = 0;
                foreach($cursor2 as $val) {
                    $activitySubActivityDetails[$mmm]['id'] = $val->id;
                    $activitySubActivityDetails[$mmm]['activityLevelName'] = $activity_level[$val->level];
                    $activitySubActivityDetails[$mmm]['activityLevel'] = $val->level;
                    $activitySubActivityDetails[$mmm]['activityNumber'] = $val->activity_num;
                    $activitySubActivityDetails[$mmm]['activityName'] = $val->name;
                    $activitySubActivityDetails[$mmm]['activityScore'] = $val->score;
                    $activitySubActivityDetails[$mmm]['activityCategory'] = $val->category;
                    $activitySubActivityDetails[$mmm]['activityWorld'] = $val->world;

                    if($val->world == "grammar_space") {
                        $activitySubActivityDetails[$mmm]["index"] = $val->level - 43;  // 43 is the start level of grammar activity
                    } else {
                        $activitySubActivityDetails[$mmm]["index"] = 0;
                    }

                    if (isset($user_star[$val->level . "_" . $val->activity_num])) {
                        $activitySubActivityDetails[$mmm]["activityStar"] = $user_star[$val->level . "_" . $val->activity_num];
                        $activitySubActivityDetails[$mmm]["activityStatus"] = "close";
                        $previous = $user_score_per[$val->level . "_" . $val->activity_num];
                    } else {
                        $activitySubActivityDetails[$mmm]["activityStar"] = 0;
                        if ($flagg == 0) {
                            if ($previous == -1) {
                                $activitySubActivityDetails[$mmm]["activityStatus"] = "open";
                            } else if ($previous < 30) {
                                $activitySubActivityDetails[$mmm]["activityStatus"] = "locked";
                            } else {
                                $activitySubActivityDetails[$mmm]["activityStatus"] = "open";
                            }
                            $flagg = 1;
                        } else {
                            $activitySubActivityDetails[$mmm]["activityStatus"] = "locked";
                        }
                    }
                    $mmm++;
                }
            }
            return $activitySubActivityDetails;

        }

        function getLanguages() {
            $language_needed = array("english","hindi","marathi","gujrati","bengali","kannada","tamil","manayalam");

            $language_texts = array();

            foreach($language_needed as $val) {
                $temp =  $this->_translator->xpath('//*[@name="'.$val.'"]');
                $language_texts[$val] = $temp[0];
            }

            return $language_texts;
        }

        function setdefaultLanguage($language) {
            $expire = 30 * 24 * 60 * 60;
            set_cookie("language", $language , $expire );
        }

        function getdefaultLanguage() {
            if(get_cookie("language") == "") {
                return 'english';
            }
            return get_cookie("language");
        }

        //! Get user totalMango
        function getUserTotalMango($user) {
            $totalMango = 0;

            //if($this->user) {
            $sql = "SELECT SUM(icc) AS isum FROM (SELECT MAX(score) AS icc FROM mg_user_activity WHERE meta_type = '0' AND user_id = '".$user->id."' GROUP BY activity_id) AS T";
            $cursor = User::find_by_sql( $sql );

            if(isset($cursor[0])) {
                $totalMango += $cursor[0]->isum;
            }

            $sql111 = "SELECT SUM(icc) AS isum FROM (SELECT MAX(score) AS icc FROM mg_user_activity WHERE meta_type = '1' AND user_id = '".$user->id."' GROUP BY activity_id) AS T";
            $cursor111 = User::find_by_sql( $sql111 );

            if(isset($cursor111[0])) {
                $totalMango += $cursor111[0]->isum;
            }

            $sql1 = "SELECT SUM(icc) AS isum FROM (SELECT MAX(points_used) AS icc FROM mg_user_story_unlock WHERE user_id = '".$user->id."' GROUP BY story_id) AS T";
            $cursor1 = User::find_by_sql( $sql1 );

            if(isset($cursor1[0])) {
                $totalMango -= $cursor1[0]->isum;
            }

            $sql11 = "SELECT SUM(icc) AS isum FROM (SELECT MAX(points_used) AS icc FROM mg_user_help_video_unlock WHERE user_id = '".$user->id."' GROUP BY help_video_id) AS T";
            $cursor11 = User::find_by_sql( $sql11 );

            if(isset($cursor11[0])) {
                $totalMango -= $cursor11[0]->isum;
            }

            $sql2 = "SELECT COUNT(icc) AS icount FROM (SELECT question_id AS icc FROM mg_answer WHERE user_id = '".$user->id."' AND meta_type = 0 AND result = 'correct' GROUP BY question_id) AS T";
            $cursor2 = User::find_by_sql( $sql2 );

            if(isset($cursor2[0])) {
                $totalMango += ($cursor2[0]->icount * 10);
            }

            $uref_count = UserReferred::count(array(
                "conditions" => " referred_by_id = '".$user->id."' AND credit_point_status = 'yes' "
            ));

            $additional_mango = 0;

            if($uref_count > 0 ) {
                  $additional_mango = $uref_count * 400;
            }

            if($user->created->format("Ymd") >= 20160817) {
                  $additional_mango += 200;
            }

            $totalMango += $additional_mango;

            $sql4 = "SELECT SUM(score) AS isum FROM mg_math_set WHERE user_id = '".$user->id."';";
            $cursor4 = User::find_by_sql( $sql4 );

            if(isset($cursor4[0])) {
                $totalMango += $cursor4[0]->isum;
            }

            //}
            return $totalMango;
        }

        //! Get activie world
        function getUserActivityStatus($user_id) {
            $worlds = array();

            $sql = "SELECT world, SUM(score) AS iscore, MAX(Level) AS ilevel FROM mg_activity WHERE ( delete_flag = 0 OR delete_flag IS NULL ) AND challenge = 0 AND world != '' GROUP BY world ORDER BY level;";
            $sql1 = "SELECT level, MAX(activity_num) AS inum FROM mg_activity WHERE ( delete_flag = 0 OR delete_flag IS NULL ) AND challenge = 0 GROUP BY level ORDER BY level;";
            $sql2 = "SELECT MAX(level) AS ilevel, MAX(activity_number) AS inum FROM mg_user_activity WHERE meta_type = '0' AND user_id = '" . $user_id . "' AND activity_number != 0  GROUP BY level ORDER BY level DESC LIMIT 0,1";

            $cursor = User::find_by_sql( $sql );
            $cursor1 = User::find_by_sql( $sql1 );
            $cursor2 = User::find_by_sql( $sql2 );

            $currentlevel = 1;
            $maxactivity_numer = 1;

            if(isset($cursor2[0])) {
                $currentlevel = $cursor2[0]->ilevel;
                $maxactivity_numer = $cursor2[0]->inum;
            }

            if(isset($cursor1[0])) {
                foreach($cursor1 as $val) {
                    if ($currentlevel == $val->level && $maxactivity_numer == $val->inum) {
                        $currentlevel++;
                    }
                }
            }

            if(isset($cursor[0])) {
                $mmm = 0;
                foreach($cursor as $val) {
                    $worlds[$mmm]['name'] = $this->getWorldName($val->world);
                    $worlds[$mmm]['total'] = $val->iscore;
                    if($currentlevel > $mmm) {
                        $worlds[$mmm]['status'] = 1;
                    } else {
                        $worlds[$mmm]['status'] = 0;
                    }

                    $mmm++;
                }
            }

            return $worlds;
        }

        function getWorldName($world_code) {

            if ($world_code == "sound_of_letters") {
                return "Sound of Letters";
            } else if ($world_code == "vowel_friends") {
                return "Vowel Friends";
            } else if ($world_code == "wordy_birdy") {
                return "Wordy Birdy";
            } else if ($world_code == "phrases_in_the_sky") {
                return "Phrases in the Sky";
            } else if ($world_code == "grammar_space") {
                return "Grammar Space";
            }

            return $world_code;
        }

        function getWorldCode($world_code) {

            if ($world_code == 1) {
                return "sound_of_letters";
            } else if ($world_code == 2) {
                return "vowel_friends";
            } else if ($world_code == 3) {
                return "wordy_birdy";
            } else if ($world_code == 4) {
                return "phrases_in_the_sky";
            } else if ($world_code == 5) {
                return "grammar_space";
            }

            return "sound_of_letters";
        }


        function getWorldActivity($world_num, $user_id) {

            $worldact = array();

            $world = $this->getWorldCode($world_num);

            $sql = "SELECT MIN(level) AS minlvl, MAX(level) AS maxlvl FROM mg_activity WHERE ( delete_flag = 0 OR delete_flag IS NULL ) AND challenge = 0 AND world = '" . $world . "';";

            $cursor = User::find_by_sql( $sql );

            if(isset($cursor[0])) {
                $start = $cursor[0]->minlvl;
                $end = $cursor[0]->maxlvl;

                $activity_level = array();

                $sql1 = "SELECT level, title FROM mg_activity_level WHERE level >= '" . $start . "' AND level <= '" . $end . "' ORDER BY level;";

                $cursor1 = User::find_by_sql( $sql1 );

                if(isset($cursor1[0])) {
                    foreach($cursor1 as $val) {
                        $activity_level[$val->level] = $val->title;
                    }
                }

                $user_star = array();
                $user_score_per = array();

                //! get user activity for those levels and activity numbers
                $sql3 = "SELECT level, activity_number, MAX(stars) AS mstar, MAX(points) AS mpoints, MAX(score) AS mscore FROM mg_user_activity WHERE meta_type = '0' AND user_id = '" . $user_id . "' AND level >= '" . $start . "' AND level <= '" . $end . "' GROUP BY level,activity_number ORDER BY level,activity_number;";
                $cursor3 = User::find_by_sql( $sql3 );

                if(isset($cursor3[0])) {
                    foreach($cursor3 as $val) {
                        $user_star[$val->level . "_" . $val->activity_number] = $val->mstar;

                        $scoree = $val->mscore;
                        $pointss = $val->mpoints;

                        /*$sql31 = "SELECT points, score FROM mg_user_activity WHERE level = '" . $val->level . "' AND activity_number = '" . $val->activity_number . "' AND meta_type = '0' AND user_id = '" . $user_id . "' ORDER BY score DESC LIMIT 0,1;";
                        $cursor31 = User::find_by_sql( $sql31 );

                        if(isset($cursor31[0])) {
                            $pointss = $cursor31[0]->points;
                            $scoree = $cursor31[0]->score;
                        } */

                        if ($pointss > 0) {
                            $perc = $this->calculatePercentage($scoree, $pointss);
                            $user_score_per[$val->level . "_" . $val->activity_number] = $perc;
                        } else {
                            $user_score_per[$val->level . "_" . $val->activity_number] = 0;
                        }
                    }
                }

                //! get user max completed level / activity
                $sql4 = "SELECT MAX(level) AS maxlvl, MAX(activity_number) AS maxan FROM mg_user_activity WHERE meta_type = '0' AND user_id = '" . $user_id . "' GROUP BY level ORDER BY level DESC LIMIT 0,1";
                $cursor4 = User::find_by_sql( $sql4 );

                $currentL = 1;
                $currentAN = 1;

                //Max User Level
                if(isset($cursor4[0])) {
                    $currentL = $cursor4[0]->maxlvl;
                    $currentAN = $cursor4[0]->maxan;

                    $sql5 = "SELECT level, MAX(activity_num) AS maxan FROM mg_activity WHERE ( delete_flag = 0 OR delete_flag IS NULL ) AND level = '" . $currentL . "' AND challenge = 0 GROUP BY level ORDER BY level LIMIT 0,1;";
                    $cursor5 = User::find_by_sql( $sql5 );

                    if(isset($cursor5[0])) {
                        if ($currentAN == $cursor5[0]->maxan) {
                            $currentL++;
                            $currentAN = 1;
                        } else {
                            $currentAN++;
                        }
                    }
                }

                if ($currentL == 47) {
                    $currentL = 48;
                    $currentAN = 1;
                }

                if ($currentL == 6 && $currentAN == 7) {
                    $currentL = 7;
                    $currentAN = 1;
                }

                $sql2 = "SELECT id,level, activity_num, name, score, category FROM mg_activity WHERE ( delete_flag = 0 OR delete_flag IS NULL ) AND challenge = 0 AND level >= '" . $start . "' AND level <= '" . $end . "' ORDER BY level,activity_num;";
                $cursor2 = User::find_by_sql( $sql2 );

                if(isset($cursor2[0])) {
                    $level = 0;
                    $index = 0;
                    $activitySubActivity = array();
                    $activityDetailsData = array();
                    $activitySubActivityDetails = array();
                    $previous = -1;
                    foreach($cursor2 as $val) {
                        if(($val->level == 47) || ($val->level == 6 && $val->activity_num == 7) ) {

                        } else {
                            if($val->level != $level) {
                                if ($level != 0) {
                                    $activityDetailsData['title'] = $activity_level[$level];
                                    $activityDetailsData["sub_activity_details"] = $activitySubActivity;
                                    $worldact[] = $activityDetailsData;
                                    $activityDetailsData = array();
                                    $activitySubActivity = array();
                                    $index++;
                                }
                                $level = $val->level;
                            }

                            $activitySubActivityDetails = array();
                            $activitySubActivityDetails["id"] = $val->id;
                            $activitySubActivityDetails["activityLevel"] = $val->level;
                            $activitySubActivityDetails["activityNumber"] = $val->activity_num;
                            $activitySubActivityDetails["activityName"] = $val->name;
                            $activitySubActivityDetails["activityScore"] = $val->score;
                            $activitySubActivityDetails["activityCategory"] = $val->category;
                            $activitySubActivityDetails["index"] = $index;
                            if (isset($user_star[$val->level . "_" . $val->activity_num])) {
                                if ($user_star[$val->level . "_" . $val->activity_num] > 0) {
                                    $activitySubActivityDetails["activityStar"] = $user_star[$val->level . "_" . $val->activity_num];
                                    $activitySubActivityDetails["activityStatus"] = "close";
                                } else {
                                    $activitySubActivityDetails["activityStar"] = 0;
                                    $activitySubActivityDetails["activityStatus"] = "open";
                                }
                                $previous = $user_score_per[$val->level . "_" . $val->activity_num];
                            } else {
                                $activitySubActivityDetails["activityStar"] = 0;
                                if ($currentL > $val->level) {
                                    $activitySubActivityDetails["activityStatus"] = "close";
                                } else if ($currentL < $val->level) {
                                    $activitySubActivityDetails["activityStatus"] = "locked";
                                } else {
                                    if ($currentAN > $val->activity_num) {
                                        $activitySubActivityDetails["activityStatus"] = "close";
                                    } else if ($currentAN < $val->activity_num) {
                                        $activitySubActivityDetails["activityStatus"] = "locked";
                                    } else {
                                        if ($previous == -1) {
                                            $activitySubActivityDetails["activityStatus"] = "open";
                                        } else if ($previous < 30) {
                                            $activitySubActivityDetails["activityStatus"] = "locked";
                                        } else {
                                            $activitySubActivityDetails["activityStatus"] = "open";
                                        }
                                    }
                                }
                            }
                            $activitySubActivity[] = $activitySubActivityDetails;
                        }
                    }

                    $cid = 0;
                    if ($world == "sound_of_letters") {
                        $cid = 320;
                    } else if ($world == "vowel_friends") {
                        $cid = 321;
                    } else if ($world == "wordy_birdy") {
                        $cid = 322;
                    } else if ($world == "phrases_in_the_sky") {
                        $cid = 323;
                    }

                    if ($cid != 0) {
                        $sql5 = "SELECT id,level, activity_num, name, score, category FROM mg_activity WHERE id = '" .$cid . "';";
                        $sql6 = "SELECT level, activity_number, MAX(stars) AS maxstar FROM mg_user_activity WHERE meta_type = '0' AND user_id = '" . $user_id . "' AND activity_id = '" . $cid . "' GROUP BY activity_id;";
                        $stars = -1;

                        $cursor6 = User::find_by_sql( $sql6 );
                        if (isset($cursor6[0])) {
                            $stars = $cursor6[0]->maxstar;
                        }

                        $cursor5 = User::find_by_sql( $sql5 );

                        if (isset($cursor5[0])) {
                            $activitySubActivityDetails = array();
                            $activitySubActivityDetails['id'] = $cursor5[0]->id;
                            $activitySubActivityDetails['activityLevel'] = 0;
                            $activitySubActivityDetails['activityNumber'] = 0;
                            $activitySubActivityDetails['activityName'] = $cursor5[0]->name;
                            $activitySubActivityDetails['activityScore'] = $cursor5[0]->score;
                            $activitySubActivityDetails['activityCategory'] = $cursor5[0]->category;
                            $activitySubActivityDetails['index'] = $index;

                            if ($stars != -1) {
                                $activitySubActivityDetails['activityStar'] = $stars;
                                $activitySubActivityDetails['activityStatus'] = "close";
                            } else {
                                $activitySubActivityDetails['activityStar'] = 0;
                                $activitySubActivityDetails['activityStatus'] = "open";
                            }

                            $activitySubActivity[] = $activitySubActivityDetails;
                        }
                    }
                    $activityDetailsData['title'] = $activity_level[$level];
                    $activityDetailsData["sub_activity_details"] = $activitySubActivity;
                    $worldact[] = $activityDetailsData;
                }
            }
            return $worldact;
        }

        function calculatePercentage($totalScore, $totalCount) {
            $percentage = 0;
            if ($totalCount > 0) {
                $percentage = ($totalScore * 100) / $totalCount;
                $percentage = number_format($percentage);
            }
            return $percentage;
        }

        function getAllStoryData($user_id, $level, $keyword) {
            $new_storr = " id <> '174',id <> '184',id <> '194',id <> '204',id <> '224',id <> '374',id <> '364',id <> '354',id <> '344',id <> '324',id <> '314',id <> '304',id <> '294',id <> '274',id <> '264',id <> '254',id <> '244' ";
            if($level != "") {
                $sql = "SELECT * FROM mg_story WHERE status = 'active' AND level = '$level' GROUP BY id ORDER BY $new_storr ,level,name ;";
            } else if($keyword != "") {
                $sql = "SELECT * FROM mg_story WHERE status = 'active' AND name LIKE '$keyword"."%' GROUP BY id ORDER BY $new_storr ,level,name ;";
            } else {
                $sql = "SELECT * FROM mg_story WHERE status = 'active' GROUP BY id ORDER BY $new_storr ,level,name ;";
            }
            $data = User::find_by_sql( $sql );
            return $data;
        }

        function getStoryQuestionDetailsPreVocab($storyId) {

            $sql = "SELECT * FROM mg_question, mg_story_question_linkage WHERE mg_question.id = mg_story_question_linkage.question_id AND mg_story_question_linkage.story_id = '" . $storyId . "' AND mg_story_question_linkage.type = 'pre' AND mg_question.question LIKE '%vocabulary%' ORDER BY mg_story_question_linkage.order_number LIMIT 0,1";

            $storyDetails = array();

            $storyDetailsCursor = User::find_by_sql( $sql );

            if(isset($storyDetailsCursor[0])) {
                $storyDetails = $storyDetailsCursor[0];
            }
            return $storyDetails;
        }

        function getStoryPageDetails($storyId, $start) {

            $sql = "SELECT * FROM mg_storypage WHERE story_id = '" . $storyId . "' ORDER BY pageno ASC LIMIT " . $start . ",1";

            $storyDetails = array();

            $storyPageCursor = User::find_by_sql( $sql );

            if(isset($storyPageCursor[0])) {
                $storyDetails = $storyPageCursor[0];
            }

            return $storyDetails;
        }

        function otherstories($storyId, $level) {
            $sql = "SELECT * FROM mg_story WHERE status = 'active' AND id != '".$storyId."' AND level = '".$level."'  GROUP BY id ORDER BY rand() LIMIT 0,4 ;";
            $data = User::find_by_sql( $sql );
            return $data;
        }

        function getAllHelpVideoData($user_id,$level,$keyword) {
            if($level != "") {
                $sql = "SELECT * FROM mg_help_video WHERE (delete_flag IS NULL OR delete_flag = '') AND level = '$level' GROUP BY id ORDER BY level,id ;";
            } else if($keyword != "") {
                $sql = "SELECT * FROM mg_help_video WHERE (delete_flag IS NULL OR delete_flag = '') AND title LIKE '$keyword"."%' GROUP BY id ORDER BY level,id ;";
            } else {
                $sql = "SELECT * FROM mg_help_video WHERE delete_flag IS NULL OR delete_flag = '' GROUP BY id ORDER BY level,id ;";
            }

            $data = User::find_by_sql( $sql );
            return $data;
        }

        function othervideos($videoId,$level) {
            $sql = "SELECT * FROM mg_help_video WHERE ( delete_flag IS NULL OR delete_flag = '' ) AND id != '".$videoId."' AND level = '".$level."' GROUP BY id ORDER BY rand() LIMIT 0,4 ;";
            $data = User::find_by_sql( $sql );
            return $data;
        }

        function getUserProfileConcepts($user_id) {
            $sql = "SELECT mg_activity_level.title FROM mg_user_activity, mg_activity_level WHERE mg_user_activity.level = mg_activity_level.level AND mg_user_activity.score > 0 AND mg_user_activity.user_id = '" . $user_id . "' GROUP BY mg_activity_level.level ORDER BY mg_activity_level.level;";
            $data = User::find_by_sql( $sql );
            return $data;
        }

        function getUserProfileConceptsCount($user_id) {
            $sql = "SELECT COUNT(mg_activity_level.title) AS icount FROM mg_user_activity, mg_activity_level WHERE mg_user_activity.level = mg_activity_level.level AND mg_user_activity.score > 0 AND mg_user_activity.user_id = '" . $user_id . "' GROUP BY mg_activity_level.level ORDER BY mg_activity_level.level;";
            $data = User::find_by_sql( $sql );
            $icount = 0;
            if(isset($data[0])) {
                $icount = $data[0]->icount;
            }
            return $icount;
        }

        function getUserProfileWords($user_id) {
            $sql = "SELECT mg_wordsegment.word FROM mg_user_activity_record, mg_activity_linkage, mg_wordsegment WHERE mg_user_activity_record.activity_linkage_id = mg_activity_linkage.id AND mg_activity_linkage.type_id = mg_wordsegment.id AND mg_activity_linkage.type IN ('first_last_sound','first_last_sound_random','missing_letter','segmenting_blending','segmenting_blending_random','segmenting_blending_random_grapheme','vocab','vocabconceptrandom','vocabrandom','word_game','word_game_random','word_game_random_grapheme') AND mg_user_activity_record.user_id = '" . $user_id . "' GROUP BY mg_wordsegment.word ORDER BY mg_activity_linkage.id;";
            $data = User::find_by_sql( $sql );
            return $data;
        }

        function getUserProfileWordsCount($user_id) {
            $sql = "SELECT COUNT(mg_wordsegment.word) as icount FROM mg_user_activity_record, mg_activity_linkage, mg_wordsegment WHERE mg_user_activity_record.activity_linkage_id = mg_activity_linkage.id AND mg_activity_linkage.type_id = mg_wordsegment.id AND mg_activity_linkage.type IN ('first_last_sound','first_last_sound_random','missing_letter','segmenting_blending','segmenting_blending_random','segmenting_blending_random_grapheme','vocab','vocabconceptrandom','vocabrandom','word_game','word_game_random','word_game_random_grapheme') AND mg_user_activity_record.user_id = '" . $user_id . "' GROUP BY mg_wordsegment.word ORDER BY mg_activity_linkage.id;";
            $data = User::find_by_sql( $sql );
            $icount = 0;
            if(isset($data[0])) {
                $icount = $data[0]->icount;
            }
            return $icount;
        }

        function getUserProfileDetails($user_id) {
            $details = array();
            $sql = "SELECT world, COUNT(id) AS icount FROM mg_activity WHERE ( delete_flag = 0 OR delete_flag IS NULL ) AND challenge = 0 AND TRIM(world) != '' AND world IS NOT NULL GROUP BY world ORDER BY level;";
            $sql1 = "SELECT mg_activity.world, COUNT(DISTINCT(mg_user_activity.level || '-' || mg_user_activity.activity_number)) AS icount FROM mg_user_activity, mg_activity WHERE  ( mg_activity.delete_flag = 0 OR mg_activity.delete_flag IS NULL ) AND mg_activity.challenge = 0 AND mg_user_activity.activity_id = mg_activity.id AND mg_user_activity.user_id = '" . $user_id . "' GROUP BY mg_activity.world ORDER BY mg_activity.level;";

            $cursor1 = User::find_by_sql( $sql1 );

            $usercompleted = array();

            //Max User Level
            if(isset($cursor1[0] )) {
                foreach($cursor1 as $val) {
                    $usercompleted[$val->world] = $val->icount;
                }
            }

            $cursor = User::find_by_sql( $sql );
            //Max User Level
            if(isset($cursor[0] )) {
                foreach($cursor as $val) {
                    if ($val->world != "") {
                        $det = array();
                        $det['world_slug'] = $val->world;
                        $det['world'] = $this->getWorldName($val->world);
                        $per = 0;
                        if ($val->icount != 0) {
                            if (isset($usercompleted[$val->world])) {
                                $per = ( $usercompleted[$val->world] * 100 ) / $val->icount;
                                $per = number_format($per);
                            }
                        }
                        $det["percentage"] = $per;
                        $details[] = $det;
                    }
                }
            }
            return $details;
        }

        function getUserDaysToExpire($user_id) {
            $exp = $this->user->expire_date;
            if($exp == '') {
                $exp = date("Y-m-d",mktime(1,1,1,1,1,2018));
            }
            $now = time();
            $your_date = strtotime($exp);
            $datediff = $now - $your_date;

            return round($datediff / (60 * 60 * 24));
        }

        function getTotalProgressPercentageForReportCard($userId) {
            $totalActivityCount = 0;
            $totalUserActivityCompleteCount = 0;

            $sql = "SELECT count(*) AS icount FROM mg_activity WHERE ( delete_flag = 0 OR delete_flag IS NULL )AND challenge=0;";
            $sql1 = "SELECT count(DISTINCT(activity_id)) AS icount FROM mg_user_activity WHERE meta_type = '0' AND user_id = '" . $userId . "'";

            $cursor = User::find_by_sql( $sql );
            if(isset($cursor[0])) {
                $totalActivityCount = $cursor[0]->icount;
            }

            $cursor1 = User::find_by_sql( $sql1 );
            if(isset($cursor1[0])) {
                $totalUserActivityCompleteCount = $cursor1[0]->icount;
            }

            $per = ( $totalUserActivityCompleteCount * 100 ) / $totalActivityCount;
            $per = number_format($per);

            return $per;
        }

        function getUserReportCard($user_id) {
            $details = array();
            $sql = "SELECT mg_activity_level.title, MAX(mg_user_activity.points) AS ipoints, MAX(mg_user_activity.score) AS iscore, MAX(mg_user_activity.stars) AS istars, mg_activity.category, mg_activity.world, mg_activity.challenge  FROM mg_user_activity, mg_activity, mg_activity_level WHERE mg_user_activity.meta_type = '0' AND mg_user_activity.activity_id = mg_activity.id AND mg_activity.level = mg_activity_level.level AND mg_user_activity.score > 0 AND mg_user_activity.user_id = '" . $user_id . "' AND ( mg_activity.category = 'review' OR mg_activity.category = 'challenge' ) GROUP BY mg_activity.id ORDER BY mg_user_activity.created DESC";
            $cursor = User::find_by_sql( $sql );

            if(isset($cursor[0])) {
                $det = array();
                foreach($cursor as $val) {
                    if ($val->title != "" ) {
                        $det = array();
                        if ($val->challenge == 1) {
                            $det['levelname'] = $this->getWorldName($val->world);
                        } else {
                            $det['levelname'] = $val->title;
                        }
                        $det['points'] = $val->ipoints;
                        $det['score'] = $val->iscore;
                        $det['stars'] = $val->istars;
                        $per = ( $val->iscore * 100 ) / $val->ipoints;
                        $per = number_format($per);
                        $det['percentage'] = $per;
                        $details[] = $det;
                    }
                }
            }
            return $details;
        }

        function getUserReportCardPercentage($user_id) {

            $sql = "SELECT SUM(MAX(mg_user_activity.points)) AS ipoints, SUM(MAX(mg_user_activity.score)) AS iscore FROM mg_user_activity, mg_activity, mg_activity_level WHERE mg_user_activity.meta_type = '0' AND mg_user_activity.activity_id = mg_activity.id AND mg_activity.level = mg_activity_level.level AND mg_user_activity.score > 0 AND mg_user_activity.user_id = '" . $user_id . "' AND ( mg_activity.category = 'review' OR mg_activity.category = 'challenge' ) GROUP BY mg_activity.id ORDER BY mg_user_activity.created DESC";
            $cursor = User::find_by_sql( $sql );

            $percentage = 0;

            if(isset($cursor[0])) {
                $percentage = ($cursor[0]->iscore / $cursor[0]->ipoints ) * 100;
                $percentage = number_format($percentage);
            }
            return $percentage;
        }

        function getFormattedDateAgo($date1, $date2) {
            $date1 = strtotime($date1);
            $date2 = strtotime($date2);
            $datediff = $date2 - $date1;

            $days_ago = round($datediff / (60 * 60 * 24));

            if($days_ago <= 0) {
                return "Today";
            } else if($days_ago == 1) {
                return "Yesterday";
            } else if ($days_ago <= 9 ) {
                return $days_ago . " days ago";
            } else {
                return date("D j, M, Y",$date1);
            }
        }

        function getUserRecentActivity($user_id) {
            $details = array();

            $sql = "SELECT mg_activity_level.title, mg_activity.name, mg_activity.category, mg_user_activity.points, mg_user_activity.score,
            mg_user_activity.created , mg_activity.world, mg_activity.challenge, mg_activity.level, mg_activity.activity_num  FROM mg_user_activity, mg_activity, mg_activity_level WHERE mg_user_activity.activity_id = mg_activity.id AND mg_activity.level = mg_activity_level.level AND mg_user_activity.score > 0 AND mg_user_activity.user_id = '" . $user_id . "' AND mg_user_activity.meta_type = '0' GROUP BY mg_activity.id ORDER BY mg_user_activity.created DESC;";

            $maxlevel = array();
            $cursor = User::find_by_sql( $sql );

            $now = date("Y-m-d");
            $format1 = "yyyy-MM-dd HH:mm:ss";
            $format = "YmdHis";

            if(isset($cursor[0])) {
                $det = array();

                foreach($cursor as $val) {
                    if ($val->title != "") {
                        if ($val->challenge == 1) {
                            $det = array();
                            $det['levelname'] = "World Complete!";
                            $det['activityname'] = $this->getWorldName($val->world);
                            $det['worldName'] = $this->getWorldName($val->world);
                            $det['activityLevel'] = $val->level;
                            $det['activityNumber'] = $val->activity_num;
                            $det['category'] = $val->category;
                            $det['points'] = $val->points;
                            $det['score'] = $val->score;
                            $det['datetime'] = $val->created->format($format);
                            $det['formatted_date'] = $this->getFormattedDateAgo($val->created->format("Y-m-d"), $now);
                            $det['id'] = 0;
                            $det['type'] = 2;
                            $details[$det['datetime']][] = $det;

                            $det['levelname'] = "Challenge";
                            $det['activityname'] = $this->getWorldName($val->world);
                            $det['worldName'] = $this->getWorldName($val->world);
                            $det['activityLevel'] = $val->level;
                            $det['activityNumber'] = $val->activity_num;
                            $det['category'] = $val->category;
                            $det['points'] = $val->points;
                            $det['score'] = $val->score;
                            $det['datetime'] = $val->created->format($format);
                            $det['formatted_date'] = $this->getFormattedDateAgo($val->created->format("Y-m-d"), $now);
                            $det['id'] = 0;
                            $det['type'] = 1;
                            $details[$det['datetime']][] = $det;
                        } else {
                            $flagg = 0;
                            if(isset($maxlevel[$val->level])) {
                                if ($maxlevel[$val->level] == $val->activity_num) {
                                    $flagg = 1;
                                }
                            } else {
                                $sql3 = "SELECT MAX(activity_num) AS maxan FROM mg_activity WHERE ( delete_flag = 0 OR delete_flag IS NULL ) AND level = '" . $val->level . "';";

                                $cursor3 = User::find_by_sql( $sql3 );

                                if(isset($cursor3[0])) {
                                    $maxlevel[$val->level] = $cursor3[0]->maxan;

                                    if ($maxlevel[$val->level] == $val->activity_num) {
                                        $flagg = 1;
                                    }
                                }

                                if ($flagg == 1) {
                                    $det['levelname'] = "Concept Complete!";
                                    $det['activityname'] = $val->title;
                                    $det['worldName'] = $this->getWorldName($val->world);
                                    $det['activityLevel'] = $val->level;
                                    $det['activityNumber'] = $val->activity_num;
                                    $det['category'] = $val->category;
                                    $det['points'] = $val->points;
                                    $det['score'] = $val->score;
                                    $det['datetime'] = $val->created->format($format);
                                    $det['formatted_date'] = $this->getFormattedDateAgo($val->created->format("Y-m-d"), $now);
                                    $det['id'] = 0;
                                    $det['type'] = 2;
                                    $details[$det['datetime']][] = $det;
                                }

                                $det['levelname'] = $val->title;
                                $det['activityname'] = $val->name;
                                $det['worldName'] = $this->getWorldName($val->world);
                                $det['activityLevel'] = $val->level;
                                $det['activityNumber'] = $val->activity_num;
                                $det['category'] = $val->category;
                                $det['points'] = $val->points;
                                $det['score'] = $val->score;
                                $det['datetime'] = $val->created->format($format);
                                $det['formatted_date'] = $this->getFormattedDateAgo($val->created->format("Y-m-d"), $now);
                                $det['id'] = 0;
                                $det['type'] = 1;
                                $details[$det['datetime']][] = $det;
                            }
                        }
                    }
                }
            }

            $sql1 = "SELECT SQ.sname, SUM(SQ.sscore) AS ssscore, COUNT(SQ.sscore) AS icount, SQ.sdate_time,SQ.sstory_id FROM
            (SELECT mg_story.name AS sname, mg_answer.score AS sscore, mg_answer.answered_dtm AS sdate_time,
            mg_story.id AS sstory_id FROM mg_story, mg_answer, mg_story_question_linkage WHERE
            mg_story.id = mg_story_question_linkage.story_id AND mg_story_question_linkage.question_id = mg_answer.question_id
            AND mg_answer.user_id = '" . $user_id . "' AND mg_answer.meta_type = '0' AND mg_answer.question_id != 0
            GROUP BY mg_answer.question_id, mg_story.id,
            DATE(sdate_time) ORDER BY sdate_time DESC) SQ GROUP BY SQ.sstory_id, DATE(SQ.sdate_time) ORDER BY SQ.sdate_time DESC;";

            $cursor1 = User::find_by_sql( $sql1 );

            if(isset($cursor1[0])) {
                $det = array();

                foreach($cursor1 as $val) {
                    if ($val->sname != "" ) {

                        $det['levelname'] = "Story Complete";
                        $det['activityname'] = $val->sname;
                        $det['worldName'] = '';
                        $det['activityLevel'] = 0;
                        $det['activityNumber'] = 0;
                        $det['category'] = 'story';
                        $det['points'] = 0;
                        $det['score'] = 0;
                        $det['datetime'] = $val->sdate_time;
                        $det['formatted_date'] = $this->getFormattedDateAgo($val->sdate_time, $now);
                        $det['id'] = $val->sstory_id;
                        $det['type'] = 1;
                        $details[$det['datetime']][] = $det;

                        $det['levelname'] = "Story Question";
                        $det['activityname'] = $val->sname;
                        $det['worldName'] = '';
                        $det['activityLevel'] = 0;
                        $det['activityNumber'] = 0;
                        $det['category'] = 'story';
                        $det['points'] = $val->icount * 10;
                        $det['score'] = $val->ssscore;
                        $det['datetime'] = $val->sdate_time;
                        $det['formatted_date'] = $this->getFormattedDateAgo($val->sdate_time, $now);
                        $det['id'] = $val->sstory_id;
                        $det['type'] = 1;
                        $details[$det['datetime']][] = $det;
                    }
                }
            }

            //! Help video Question
            $sql4 = "SELECT mg_help_video.title, MAX(mg_user_activity.points) AS ipoints, MAX(mg_user_activity.score) AS iscore, mg_user_activity.created, mg_help_video.id FROM mg_user_activity, mg_help_video WHERE mg_user_activity.activity_id = mg_help_video.id AND mg_user_activity.user_id = '" . $user_id . "' AND mg_user_activity.meta_type = '1' GROUP BY mg_help_video.id ORDER BY mg_user_activity.created DESC;";

            $cursor4 = User::find_by_sql( $sql4 );

            if(isset($cursor4[0])) {


                foreach($cursor4 as $val) {
                    if ($val->title != "" ) {
                        $det = array();
                        $det['levelname'] = "Video Complete";
                        $det['activityname'] = $val->title;
                        $det['worldName'] = '';
                        $det['activityLevel'] = 0;
                        $det['activityNumber'] = 0;
                        $det['category'] = 'help_video';
                        $det['points'] = 0;
                        $det['score'] = 0;
                        $det['datetime'] = $val->created->format($format);
                        $det['formatted_date'] = $this->getFormattedDateAgo($val->created->format("Y-m-d"), $now);
                        $det['id'] = $val->id;
                        $det['type'] = 1;
                        $details[$det['datetime']][] = $det;

                        $det = array();
                        $det['levelname'] = "Video Question";
                        $det['activityname'] = $val->title;
                        $det['worldName'] = '';
                        $det['activityLevel'] = 0;
                        $det['activityNumber'] = 0;
                        $det['category'] = 'help_video_question';
                        $det['points'] = $val->ipoints;
                        $det['score'] = $val->iscore;
                        $det['datetime'] = $val->created->format($format);
                        $det['formatted_date'] = $this->getFormattedDateAgo($val->created->format("Y-m-d"), $now);
                        $det['id'] = $val->id;
                        $det['type'] = 1;
                        $details[$det['datetime']][] = $det;
                    }
                }
            }



            /*String sql5 = "SELECT * FROM mg_math_set WHERE user_id = '" + user_id + "' ORDER BY attempt_dtm DESC;";

            Cursor cursor5 = db.rawQuery(sql5, null);
            if (cursor5 != null) {
                if (cursor5.getCount() > 0) {
                    cursor5.moveToFirst();

                    HashMap<String, Object> det;

                    do {
                        det = new HashMap<>();
                        det.put("levelname", "Math");

                        String actname = "";

                        if (cursor5.getInt(5) != 0) {
                            String sql51 = "SELECT substr( mg_question.title , 1, length(mg_question.title) - 11 ) AS qname FROM mg_question WHERE id = '" + cursor5.getInt(5) + "';";

                            Cursor cursor51 = db.rawQuery(sql51, null);
                            //Max User Level

                            if (cursor51 != null) {
                                if (cursor51.getCount() > 0) {
                                    cursor51.moveToFirst();
                                    actname = cursor51.getString(0);
                                }
                                cursor51.close();
                            }
                        } else if (cursor5.getInt(6) != 0) {
                            String sql51 = "SELECT name FROM mg_concepts WHERE id = '" + cursor5.getInt(6) + "';";

                            Cursor cursor51 = db.rawQuery(sql51, null);
                            //Max User Level

                            if (cursor51 != null) {
                                if (cursor51.getCount() > 0) {
                                    cursor51.moveToFirst();
                                    actname = cursor51.getString(0);
                                }
                                cursor51.close();
                            }
                        } else {
                            String sql51 = "SELECT name FROM mg_units WHERE id = '" + cursor5.getInt(7) + "';";

                            Cursor cursor51 = db.rawQuery(sql51, null);
                            //Max User Level

                            if (cursor51 != null) {
                                if (cursor51.getCount() > 0) {
                                    cursor51.moveToFirst();
                                    actname = cursor51.getString(0);
                                }
                                cursor51.close();
                            }
                        }

                        det.put("activityname", actname);
                        det.put("worldName", "");
                        det.put("activityLevel", 0);
                        det.put("activityNumber", 0);
                        det.put("category", "math_set");
                        det.put("points", cursor5.getInt(8));
                        det.put("score", cursor5.getInt(9));
                        det.put("datetime", cursor5.getString(10));
                        try {
                            Date past1 = format1.parse(cursor5.getString(10));  //yyyy-MM-dd HH:mm:ss
                            String str = format.format(past1.getTime());      // dd/MM/yyyy
                            Date past = format.parse(str);
                            if (TimeUnit.MILLISECONDS.toDays(now.getTime() - past.getTime()) == 0) {
                                det.put("formatted_date", "Today");
                            } else if (TimeUnit.MILLISECONDS.toDays(now.getTime() - past.getTime()) == 1) {
                                det.put("formatted_date", "Yesterday");
                            } else {
                                det.put("formatted_date", TimeUnit.MILLISECONDS.toDays(now.getTime() - past.getTime()) + " days ago");
                            }
                        } catch (Exception e) {
                            e.printStackTrace();
                        }
                        det.put("id", cursor5.getInt(0));
                        det.put("type", 1);
                        details.add(det);

                    } while (cursor5.moveToNext());
                }
                cursor5.close();
            } */

            krsort($details);
            return $details;
        }

        function getStoryPageLanguageDetails($storypageId, $pageNo) {
            $sql = "SELECT * FROM mg_storypage_language WHERE storypage_id = '" . $storypageId . "' AND pageno = '" . $pageNo . "'";
            return User::find_by_sql( $sql );
        }


        function getStoryQuestionDetailsAll($storyId, $start) {
            if(in_array( $storyId, $this->_new_stories )) {
                $sql = "SELECT mg_question.* FROM mg_story_question_linkage, mg_question WHERE mg_story_question_linkage.question_id = mg_question.id AND mg_story_question_linkage.story_id = '" . $storyId . "' AND ( mg_story_question_linkage.type = 'during' OR mg_story_question_linkage.type = 'post') AND ( mg_question.question LIKE '%mcq_single_answer%' OR mg_question.question LIKE '%fill_blank%' OR mg_question.question LIKE '%match_column%' OR mg_question.question LIKE '%mcq_multiple_answer%' OR mg_question.question LIKE '%conversation%' OR mg_question.question LIKE '%record_missing_word%' )  AND mg_question.status = 'active'  ORDER BY mg_story_question_linkage.type, mg_story_question_linkage.order_number LIMIT " . $start . ",1";
            } else {
                $sql = "SELECT mg_question.* FROM mg_story_question_linkage, mg_question WHERE mg_story_question_linkage.question_id = mg_question.id AND mg_story_question_linkage.story_id = '" . $storyId . "' AND ( mg_story_question_linkage.type = 'during' OR mg_story_question_linkage.type = 'post') AND ( mg_question.question LIKE '%mcq_single_answer%' OR mg_question.question LIKE '%fill_blank%' OR mg_question.question LIKE '%match_column%' OR mg_question.question LIKE '%mcq_multiple_answer%' )  AND mg_question.status = 'active'  ORDER BY mg_story_question_linkage.type, mg_story_question_linkage.order_number LIMIT " . $start . ",1";
            }
            $storyDetails = array();

            $storyDetailsCursor = User::find_by_sql( $sql );
            if(isset($storyDetailsCursor[0])) {
                /*$hashMap = array();
                $hashMap["questionId"] = $storyDetailsCursor[0]->question_id;
                $hashMap["storyId"] = $storyDetailsCursor[0]->story_id;
                $hashMap["type"] = $storyDetailsCursor[0]->type;
                $hashMap["questionType"] = $storyDetailsCursor[0]->meta_type;
                $hashMap["storypageId"] = $storyDetailsCursor[0]->storypage_id;
                $hashMap["orderNumber"] = $storyDetailsCursor[0]->order_number;
                $hashMap["title"] = $storyDetailsCursor[0]->title;
                $hashMap["question"] = $storyDetailsCursor[0]->question;

                $jsonObject = json_decode($storyDetailsCursor[0]->question);
                $questionType = $jsonObject->question_type;

                if ($questionType == "mcq_single_answer" || $questionType == "mcq_multiple_answer") {
                    $optionsArray = $jsonObject->options;
                    $optionAnswerStatus = array();
                    $optionSelectStatus = array();
                    for ($ii = 0; $ii < count($optionsArray); $ii++) {
                        $optionSelectStatus[] = -1;
                        $optionAnswerStatus[] = -1;
                    }
                    $suffleIndexList = $this->getRandomSuffleIndex(count($optionsArray) - 1 );
                    $hashMap["suffleIndexList"] = $suffleIndexList;
                    $hashMap["optionSelectStatus"] = $optionSelectStatus;
                    $hashMap["optionAnswerStatus"] = $optionAnswerStatus;
                    $hashMap["isFirstClick"] = true;
                    $hashMap["isCorrect"] = false;
                }
                  */
                //$storyDetails = $hashMap;
                $storyDetails = $storyDetailsCursor[0];
            }

            return $storyDetails;
        }

        function getRandomSuffleIndex($size) {
            $solution = range(0, $size);
            shuffle($solution);
            return $solution;
        }

        function getStoryListenCount($story_id) {
            $count = 0;
            $sql = "SELECT count(*) AS icount FROM mg_storypage WHERE story_id ='" . $story_id . "'";
            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                $count = $cursor[0]->icount;
            }
            return $count;
        }


        function getSpecificActivityDetails($activity_level, $activity_num, $world) {
            $hashMapArrayList = array();
            $world = str_replace(" ", "_", $world);

            if ($activity_level == 0) {
                $cid = 0;
                if ($world == "sound_of_letters") {
                    $cid = 320;
                } else if ($world == "vowel_friends") {
                    $cid = 321;
                } else if ($world == "wordy_birdy") {
                    $cid = 322;
                } else if ($world == "phrases_in_the_sky") {
                    $cid = 323;
                }
                $sql = "SELECT mg_activity_linkage.* FROM mg_activity_linkage,mg_activity
                WHERE mg_activity.id = mg_activity_linkage.activity_id AND ( mg_activity.delete_flag = 0 OR mg_activity.delete_flag IS NULL )
                AND mg_activity.id = '" . $cid . "' AND mg_activity.challenge = 1 ORDER BY mg_activity_linkage.order_num ASC";
            } else {
                $sql = "SELECT mg_activity_linkage.* FROM mg_activity_linkage,mg_activity  WHERE mg_activity.id = mg_activity_linkage.activity_id AND
                ( mg_activity.delete_flag = 0 OR mg_activity.delete_flag IS NULL ) AND mg_activity.level = '" . $activity_level . "' AND
                mg_activity.activity_num = '" . $activity_num . "' AND mg_activity.challenge = 0 ORDER BY mg_activity_linkage.order_num ASC";
            }

            $cursor = User::find_by_sql( $sql );

            return $cursor;
        }

        function getGraphemeData($grapheme_id) {
            $hashMapData = array();
            $graphemeScriptDetails = array();
            $sql = "SELECT mg_grapheme_word_linkage.grapheme_id, mg_grapheme.grapheme,
            mg_grapheme.phoneme,
            mg_grapheme.audio, mg_word.word, mg_grapheme_word_linkage.word_id, mg_word.image,
            mg_word.concept FROM mg_grapheme, mg_grapheme_word_linkage,
            mg_word WHERE mg_grapheme.id = mg_grapheme_word_linkage.grapheme_id AND mg_word.id = mg_grapheme_word_linkage.word_id
            AND mg_grapheme.id = '" . $grapheme_id . "' AND  mg_grapheme_word_linkage.`primary` = 'yes';";

            $cursor = User::find_by_sql( $sql );

            if (isset($cursor[0])) {
                $hashMapData['id'] = $cursor[0]->grapheme_id;
                $hashMapData['grapheme_id'] = $cursor[0]->grapheme_id;
                $hashMapData['grapheme'] = $cursor[0]->grapheme;
                $hashMapData['phoneme'] = $cursor[0]->phoneme;
                $hashMapData['audio'] = $cursor[0]->audio;
                $hashMapData['word'] = $cursor[0]->word;
                $hashMapData['word_id'] = $cursor[0]->word_id;
                $hashMapData['image'] = $cursor[0]->image;
                $hashMapData['concept'] = $cursor[0]->concept;

                $sql1 = "SELECT language_id,script FROM mg_grapheme_script where grapheme_id='" . $cursor[0]->grapheme_id . "';";
                $cursor1 = User::find_by_sql( $sql1 );

                $graphemeScriptDetails = array();
                if (isset($cursor1[0])) {
                    foreach($cursor1 as $val) {
                        $hashMap = array();
                        $hashMap['language_id'] = $val->language_id;
                        $hashMap['script'] = $val->script;
                        $graphemeScriptDetails[] = $hashMap;
                    }
                }
                $hashMapData['grapheme_script'] = $graphemeScriptDetails;

                $sql2 = "SELECT id FROM mg_word WHERE LOWER(TRIM(word)) = '" . strtolower(trim($cursor[0]->word)) . "';";

                $word_id = 0;
                $cursor2 = User::find_by_sql( $sql2 );
                if (isset($cursor2[0])) {
                    $word_id = $cursor2[0]->id;
                }

                $sql3 = "SELECT language_id, translation FROM mg_word_transliteration WHERE word_id = '" . $word_id . "';";

                $data3 = array();

                $cursor3 = User::find_by_sql( $sql3 );
                if (isset($cursor3[0])) {
                    foreach($cursor3 as $val) {
                        $hashMap3 = array();
                        $hashMap3['language_id'] = $val->language_id;
                        $hashMap3['transliteration'] = $val->translation;
                        $data3[] = $hashMap3;
                    }
                }

                $hashMapData['transliteration'] = $data3;
            }

            return $hashMapData;
        }

        function getGraphemeDataByGrapheme($grapheme) {
             $hashMapData = array();
            $graphemeScriptDetails = array();
            $sql = "SELECT mg_grapheme_word_linkage.grapheme_id, mg_grapheme.grapheme,
            mg_grapheme.phoneme,
            mg_grapheme.audio, mg_word.word, mg_grapheme_word_linkage.word_id, mg_word.image,
            mg_word.concept FROM mg_grapheme, mg_grapheme_word_linkage,
            mg_word WHERE mg_grapheme.id = mg_grapheme_word_linkage.grapheme_id AND mg_word.id = mg_grapheme_word_linkage.word_id
            AND mg_grapheme.grapheme = '" . $grapheme . "' AND mg_grapheme.created >= '".$this->_oldDate."' AND  mg_grapheme_word_linkage.`primary` = 'yes';";

            $cursor = User::find_by_sql( $sql );

            if (isset($cursor[0])) {
                $hashMapData['id'] = $cursor[0]->grapheme_id;
                $hashMapData['grapheme_id'] = $cursor[0]->grapheme_id;
                $hashMapData['grapheme'] = $cursor[0]->grapheme;
                $hashMapData['phoneme'] = $cursor[0]->phoneme;
                $hashMapData['audio'] = $cursor[0]->audio;
                $hashMapData['word'] = $cursor[0]->word;
                $hashMapData['word_id'] = $cursor[0]->word_id;
                $hashMapData['image'] = $cursor[0]->image;
                $hashMapData['concept'] = $cursor[0]->concept;

                $sql1 = "SELECT language_id,script FROM mg_grapheme_script where grapheme_id='" . $cursor[0]->grapheme_id . "';";
                $cursor1 = User::find_by_sql( $sql1 );

                $graphemeScriptDetails = array();
                if (isset($cursor1[0])) {
                    foreach($cursor1 as $val) {
                        $hashMap = array();
                        $hashMap['language_id'] = $val->language_id;
                        $hashMap['script'] = $val->script;
                        $graphemeScriptDetails[] = $hashMap;
                    }
                }
                $hashMapData['grapheme_script'] = $graphemeScriptDetails;
            }

            return $hashMapData;
        }

        function getFirstLastMiddleSoundData($grapheme, $position, $count) {
            $data = array();
            $sql = '';
            $sql1 = '';
            $sql2 = '';
            $phoneme = '';
            $grap_id = 0;

            $sql2 = "SELECT phoneme,id FROM mg_grapheme WHERE grapheme = '" . $grapheme . "' AND created >= '".$this->_oldDate."' AND ( delete_flag = 0 OR delete_flag IS NULL ) LIMIT 0,1;";

            $cursor2 = User::find_by_sql( $sql2 );

            if (isset($cursor2[0])) {
                $phoneme = $cursor2[0]->phoneme;
                $grap_id = $cursor2[0]->id;
            }

            if ($phoneme == '') {
                $phoneme = $grapheme;
            }

            $similarImage = "'kid','boy','wax','candle','beat','bash','died','die','killed','believe','hope','cost','value','sail','boat','book','knowledge','glass','bottom','car','entity','famous','celebrity','edge','table','hunt','hunting','fell','hurt','jute','knot','laugh','laughed','pay','lend','pick','picked','loud','speak','win','prize','scale','inches','lot','people','melt','ice','bomb','wick','present','gift','way','road','exam','test','ankle','foot','west','east','trade','buy','sell'";
            if ($position == "middle") {
                $sql = "SELECT mg_wordsegment.id,mg_wordsegment.word,mg_wordsegment.image FROM mg_wordsegment,mg_grapheme_wordsegment_linkage WHERE mg_wordsegment.id = mg_grapheme_wordsegment_linkage.wordsegment_id AND mg_grapheme_wordsegment_linkage.grapheme_id = '" . $grap_id . "' AND ( mg_wordsegment.delete_flag = 0 OR mg_wordsegment.delete_flag IS NULL ) AND mg_wordsegment.image != '' AND length(mg_wordsegment.word) <= 5 AND mg_wordsegment.word LIKE '%" . $grapheme . "%' AND mg_wordsegment.word NOT LIKE '" . $grapheme . "%' AND mg_wordsegment.word NOT LIKE '%" . $grapheme . "' GROUP BY mg_wordsegment.word ORDER BY RAND() LIMIT 0," . $count . ";";
                $sql1 = "SELECT mg_wordsegment.id, mg_wordsegment.word, mg_wordsegment.image FROM mg_wordsegment,mg_grapheme_wordsegment_linkage WHERE mg_wordsegment.id = mg_grapheme_wordsegment_linkage.wordsegment_id AND mg_grapheme_wordsegment_linkage.grapheme_id != '" . $grap_id . "' AND ( mg_wordsegment.delete_flag = 0 OR mg_wordsegment.delete_flag IS NULL ) AND mg_wordsegment.image != '' AND mg_wordsegment.word NOT LIKE '%" . $grapheme . "%' AND mg_wordsegment.word NOT LIKE '%" . $phoneme . "%' AND length(mg_wordsegment.word) <= 5 AND mg_wordsegment.word NOT IN (" . $similarImage . ") GROUP BY LOWER(mg_wordsegment.word) ORDER BY RAND() LIMIT 0," . ($count * 3) . ";";
            } else if ($position == "last") {
                $sql = "SELECT mg_wordsegment.id,mg_wordsegment.word,mg_wordsegment.image FROM mg_wordsegment,mg_grapheme_wordsegment_linkage WHERE mg_wordsegment.id = mg_grapheme_wordsegment_linkage.wordsegment_id AND mg_grapheme_wordsegment_linkage.grapheme_id = '" . $grap_id . "' AND ( mg_wordsegment.delete_flag = 0 OR mg_wordsegment.delete_flag IS NULL ) AND mg_wordsegment.image != '' AND length(mg_wordsegment.word) <= 5 AND mg_wordsegment.word LIKE '%" . $grapheme . "' GROUP BY mg_wordsegment.word ORDER BY RAND() LIMIT 0," . $count . ";";
                $sql1 = "SELECT mg_wordsegment.id,mg_wordsegment.word,mg_wordsegment.image FROM mg_wordsegment,mg_grapheme_wordsegment_linkage WHERE mg_wordsegment.id = mg_grapheme_wordsegment_linkage.wordsegment_id AND mg_grapheme_wordsegment_linkage.grapheme_id != '" . $grap_id . "' AND ( mg_wordsegment.delete_flag = 0 OR mg_wordsegment.delete_flag IS NULL ) AND mg_wordsegment.image != '' AND mg_wordsegment.word NOT LIKE '%" . $grapheme . "' AND mg_wordsegment.word NOT LIKE '%" . $phoneme . "' AND length(mg_wordsegment.word) <= 5 AND mg_wordsegment.word NOT IN (" . $similarImage . ") GROUP BY LOWER(mg_wordsegment.word) ORDER BY RAND() LIMIT 0," . ($count * 3) . ";";
            } else {
                $sql = "SELECT mg_wordsegment.id,mg_wordsegment.word,mg_wordsegment.image FROM mg_wordsegment,mg_grapheme_wordsegment_linkage WHERE mg_wordsegment.id = mg_grapheme_wordsegment_linkage.wordsegment_id AND mg_grapheme_wordsegment_linkage.grapheme_id = '" . $grap_id . "' AND ( mg_wordsegment.delete_flag = 0 OR mg_wordsegment.delete_flag IS NULL ) AND mg_wordsegment.image != '' AND length(mg_wordsegment.word) <= 5 AND mg_wordsegment.word LIKE '" . $grapheme . "%' GROUP BY mg_wordsegment.word ORDER BY RAND() LIMIT 0," . $count . ";";
                $sql1 = "SELECT mg_wordsegment.id,mg_wordsegment.word,mg_wordsegment.image FROM mg_wordsegment,mg_grapheme_wordsegment_linkage WHERE mg_wordsegment.id = mg_grapheme_wordsegment_linkage.wordsegment_id AND mg_grapheme_wordsegment_linkage.grapheme_id != '" . $grap_id . "' AND ( mg_wordsegment.delete_flag = 0 OR mg_wordsegment.delete_flag IS NULL ) AND mg_wordsegment.image != '' AND mg_wordsegment.word NOT LIKE '" . $grapheme . "%' AND mg_wordsegment.word NOT LIKE '" . $phoneme . "%' AND length(mg_wordsegment.word) <= 5 AND mg_wordsegment.word NOT IN (" . $similarImage . ") GROUP BY LOWER(mg_wordsegment.word) ORDER BY RAND() LIMIT 0," . ($count * 3) . ";";
            }

            $cursor1 = User::find_by_sql( $sql1 );

            $data1 = array();

            if (isset($cursor1[0])) {
                foreach($cursor1 as $val) {
                    $hashMap1 = array();
                    $hashMap1['word_id'] = $val->id;
                    $hashMap1['word'] = $val->word;
                    $hashMap1['image'] = $val->image;
                    $data1[] = $hashMap1;
                }
            }

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                $data = array();

                $ii = 0;
                foreach($cursor as $val) {
                    $hashMap = array();
                    $hashMap['word_id'] = $val->id;
                    $hashMap['word'] = $val->word;
                    $hashMap['image'] = $val->image;

                    $hashMap1 = array();
                    $hashMap1['word_id'] = $val->id;
                    $hashMap1['word'] = $val->word;
                    $hashMap1['image'] = $val->image;

                    $data2 = array();
                    $data2[] = $hashMap1;
                    for ($jj = 0; $jj < 3; $jj++) {
                        $data2[] = $data1[$ii];
                        $ii++;
                    }
                    $hashMap["options"] = $data2;
                    $data[] = $hashMap;
                }
            }
            return $data;
        }

        function getWordsegmentData($word_id, $missing_grapheme) {
            $data = array();

            $sql = "SELECT id,word,image FROM mg_wordsegment WHERE id = '" . $word_id . "';";
            $sql1 = "SELECT grapheme,audio,id FROM mg_grapheme WHERE ( delete_flag = 0 OR delete_flag IS NULL ) AND grapheme != '" . $missing_grapheme . "' AND LENGTH(grapheme) = 1 AND created >= '".$this->_oldDate."' GROUP BY grapheme ORDER BY RAND() LIMIT 0,3;";
            $sql2 = "SELECT grapheme,audio,id FROM mg_grapheme WHERE ( delete_flag = 0 OR delete_flag IS NULL ) AND grapheme = '" . $missing_grapheme . "' AND created >= '".$this->_oldDate."' LIMIT 0,1;";

            $data1 = array();

            $cursor2 = User::find_by_sql( $sql2 );
            if (isset($cursor2[0])) {
                $data1 = array();

                $hashMap1 = array();
                $hashMap1['grapheme'] = $cursor2[0]->grapheme;
                $hashMap1['audio'] = $cursor2[0]->audio;

                $sql21 = "SELECT language_id,script FROM mg_grapheme_script where grapheme_id='" . $cursor2[0]->id . "';";
                $cursor21 = User::find_by_sql( $sql21 );
                $graphemeScriptDetails = array();

                if (isset($cursor21[0])) {
                    foreach($cursor21 as $val) {
                        $hashMap11 = array();
                        $hashMap11['language_id'] = $val->language_id;
                        $hashMap11['script'] = $val->script;
                        $graphemeScriptDetails[] = $hashMap11;
                    }
                }
                $hashMap1['grapheme_script'] = $graphemeScriptDetails;

                $data1[] = $hashMap1;
            }

            $cursor1 = User::find_by_sql( $sql1 );
            if (isset($cursor1[0])) {
                foreach($cursor1 as $val) {
                    $hashMap1 = array();
                    $hashMap1["grapheme"] = $val->grapheme;
                    $hashMap1["audio"] = $val->audio;

                    $sql21 = "SELECT language_id,script FROM mg_grapheme_script where grapheme_id='" . $cursor2[0]->id . "';";
                    $cursor21 = User::find_by_sql( $sql21 );
                    $graphemeScriptDetails = array();

                    if (isset($cursor21[0])) {
                        foreach($cursor21 as $val) {
                            $hashMap11 = array();
                            $hashMap11['language_id'] = $val->language_id;
                            $hashMap11['script'] = $val->script;
                            $graphemeScriptDetails[] = $hashMap11;
                        }
                    }
                    $hashMap1['grapheme_script'] = $graphemeScriptDetails;
                    $data1[] = $hashMap1;
                }
            }

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {

                $data["word_id"] = $cursor[0]->id;
                $data["word"] = $cursor[0]->word;
                $data["image"] = $cursor[0]->image;
                $data["options"] = $data1;

                $sql11 = "SELECT mg_grapheme_wordsegment_linkage.grapheme_id, mg_grapheme_wordsegment_linkage.segment, mg_grapheme.grapheme, mg_grapheme.audio FROM mg_grapheme_wordsegment_linkage, mg_grapheme WHERE mg_grapheme_wordsegment_linkage.grapheme_id = mg_grapheme.id AND wordsegment_id = '" . $word_id . "' ORDER BY order_number ASC;";

                $data11 = array();

                $cursor11 = User::find_by_sql( $sql11 );
                if (isset($cursor11[0])) {
                    $data11 = array();
                    foreach($cursor11 as $val ){
                        $hashMap11 = array();
                        $hashMap11["grapheme_id"] = $val->grapheme_id;
                        $hashMap11["segment"] = $val->segment;
                        $hashMap11["grapheme"] = $val->grapheme;
                        $hashMap11["audio"] = $val->audio;

                        $graphemeScriptDetails = array();

                        $sql21 = "SELECT language_id,script FROM mg_grapheme_script WHERE grapheme_id='" . $val->grapheme_id . "';";
                        $cursor21 = User::find_by_sql( $sql21 );
                        if (isset($cursor21[0])) {
                            foreach($cursor21 as $val1) {
                                $hashMap21 = array();
                                $hashMap21["language_id"] = $val1->language_id;
                                $hashMap21["script"] = $val1->script;
                                $graphemeScriptDetails[] = $hashMap21;
                            }
                        }
                        $hashMap11["grapheme_script"] = $graphemeScriptDetails;

                        $data11[] = $hashMap11;
                    }
                }
                $data["segment"] = $data11;
            }
            return $data;
        }

        function getLanguageBlending($wordsegment_id) {
            $data = array();

            $sql = "SELECT id,word,image,primary_segment,secondary_segment,concept FROM mg_wordsegment WHERE id = '" . $wordsegment_id . "';";
            $sql1 = "SELECT language_id,translation FROM mg_language_blend WHERE wordsegment_id = '" . $wordsegment_id . "';";

            $data1 = array();

            $cursor1 = User::find_by_sql( $sql1 );
            if (isset($cursor1[0])) {
                $data1 = array();
                foreach($cursor1 as $val) {
                    $hashMap1 = array();
                    $hashMap1["language_id"] = $val->language_id;
                    $hashMap1["translation"] = $val->translation;
                    $data1[] = $hashMap1;
                }
            }

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                $data['word_id'] = $cursor[0]->id;
                $data['word'] = $cursor[0]->word;
                $data['image'] = $cursor[0]->image;
                $data['primary_segment'] = $cursor[0]->primary_segment;
                $data['secondary_segment'] = $cursor[0]->secondary_segment;
                $data['concept'] = $cursor[0]->concept;
                $data['segment'] = $data1;
            }

            return $data;
        }


        function getSegmentBlending($wordsegment_id) {
            $data = array();

            $sql = "SELECT mg_wordsegment.id, mg_wordsegment.word, mg_wordsegment.image, mg_wordsegment.concept, mg_word.id AS wwid FROM mg_wordsegment, mg_word WHERE mg_wordsegment.word = mg_word.word AND mg_wordsegment.id = '" . $wordsegment_id . "' GROUP BY mg_wordsegment.word;";
            $sql1 = "SELECT mg_grapheme_wordsegment_linkage.grapheme_id,
            mg_grapheme_wordsegment_linkage.segment, mg_grapheme.grapheme, mg_grapheme.audio FROM mg_grapheme_wordsegment_linkage, mg_grapheme WHERE mg_grapheme_wordsegment_linkage.grapheme_id = mg_grapheme.id AND wordsegment_id = '" . $wordsegment_id . "' ORDER BY order_number ASC;";

            $data1 = array();

            $cursor1 = User::find_by_sql( $sql1 );
            if (isset($cursor1[0])) {
                $data1 = array();
                foreach($cursor1 as $val) {
                    $hashMap1 = array();
                    $hashMap1["grapheme_id"] = $val->grapheme_id;
                    $hashMap1["segment"] = $val->segment;
                    $hashMap1["grapheme"] = $val->grapheme;
                    $hashMap1["audio"] = $val->audio;

                    $graphemeScriptDetails = array();

                    $sql2 = "SELECT language_id,script FROM mg_grapheme_script WHERE grapheme_id='" . $val->grapheme_id . "';";
                    $cursor2 = User::find_by_sql( $sql2 );
                    if (isset($cursor2[0])) {
                        foreach($cursor2 as $val1) {
                            $hashMap2 = array();
                            $hashMap2["language_id"] = $val1->language_id;
                            $hashMap2["script"] = $val1->script;
                            $graphemeScriptDetails[] = $hashMap2;
                        }
                    }

                    $hashMap1["grapheme_script"] = $graphemeScriptDetails;
                    $data1[] = $hashMap1;

                }
            }

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {

                $data["word_id"] = $cursor[0]->id;
                $data["word"] = $cursor[0]->word;
                $data["image"] = $cursor[0]->image;
                $data["concept"] = $cursor[0]->concept;
                $data["segment"] = $data1;

                $wordtransliteration = array();

                $sql2 = "SELECT language_id, translation FROM mg_word_transliteration WHERE word_id ='" . $cursor[0]->wwid . "';";
                $cursor2 = User::find_by_sql( $sql2 );
                if (isset($cursor2[0])) {
                    foreach($cursor2 as $val) {
                        $hashMap2 = array();
                        $hashMap2["language_id"] = $val->language_id;
                        $hashMap2["transliteration"] = $val->translation;
                        $wordtransliteration[] = $hashMap2;
                    }
                }
                $data["transliteration"] = $wordtransliteration;
            }
            return $data;
        }

        function getSegmentBlendingRandom($wordsegment_id, $icount) {

            $data = array();

            $sql = "SELECT concept FROM mg_wordsegment WHERE id = '" . $wordsegment_id . "';";

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {

                $sql1 = "SELECT id FROM mg_wordsegment WHERE concept = '" . $cursor[0]->concept . "' AND ( delete_flag = 0 OR delete_flag IS NULL )  ORDER BY RAND() LIMIT 0," . $icount . ";";

                $cursor1 = User::find_by_sql( $sql1 );
                if (isset($cursor1[0])) {
                    foreach($cursor1 as $val) {
                        $data = $this->getSegmentBlending($val->id);
                    }
                }
            }
            return $data;
        }

        function getWordGame($wordsegment_id) {
            $data = array();

            $sql = "SELECT id, word FROM mg_wordsegment WHERE id = '" . $wordsegment_id . "';";
            $sql1 = "SELECT mg_grapheme_wordsegment_linkage.grapheme_id, mg_grapheme_wordsegment_linkage.segment, mg_grapheme.grapheme, mg_grapheme.audio FROM mg_grapheme_wordsegment_linkage, mg_grapheme WHERE mg_grapheme_wordsegment_linkage.grapheme_id = mg_grapheme.id AND wordsegment_id = '" . $wordsegment_id . "' ORDER BY order_number ASC;";

            $data1 = array();

            $cursor1 = User::find_by_sql( $sql1 );
            if (isset($cursor1[0])) {
                $data1 = array();
                foreach($cursor1 as $val) {
                    $hashMap1 = array();
                    $hashMap1["grapheme_id"] = $val->grapheme_id;
                    $hashMap1["segment"] = $val->segment;
                    $hashMap1["grapheme"] = $val->grapheme;
                    $hashMap1["audio"] = $val->audio;

                    $graphemeScriptDetails = array();

                    $sql2 = "SELECT language_id,script FROM mg_grapheme_script WHERE grapheme_id='" . $val->grapheme_id . "';";
                    $cursor2 = User::find_by_sql( $sql2 );
                    if (isset($cursor2[0])) {
                        foreach($cursor2 as $val1) {
                            $hashMap2 = array();
                            $hashMap2["language_id"] = $val1->language_id;
                            $hashMap2["script"] = $val1->script;
                            $graphemeScriptDetails[] = $hashMap2;
                        }
                    }
                    $hashMap1['grapheme_script'] = $graphemeScriptDetails;
                    $data1[] = $hashMap1;
                }
            }

            $cursor = User::find_by_sql( $sql );
            $optionSelectStatus = array();
            $optionAnswerStatus = array();
            if (isset($cursor[0])) {

                $data["word_id"] = $cursor[0]->id;
                $data["word"] = $cursor[0]->word;
                $suffleIndexList = $this->getRandomSuffleIndex(count($data1) - 1);
                $data["segment"] = $data1;
                $data["answer_grapheme"] = $data1[0];
                for ($ii = 0; $ii < count($data1); $ii++) {
                    $optionSelectStatus[] = -1;
                    $optionAnswerStatus[] = -1;
                }
                $data["optionAnswerStatus"] = $optionAnswerStatus;
                $data["optionSelectStatus"] = $optionSelectStatus;
                $data["suffleIndexList"] = $suffleIndexList;
            }
            return $data;
        }

        function getWordGameRandom($wordsegment_id, $icount) {
            $data = array();

            $sql = "SELECT concept FROM mg_wordsegment WHERE id = '" . $wordsegment_id . "';";

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {

                $sql1 = "SELECT id FROM mg_wordsegment WHERE concept = '" . $cursor[0]->concept . "' AND double_flag != 1 AND LENGTH(word) <= 9    ORDER BY RAND() LIMIT 0," . $icount . ";";
                $cursor1 = User::find_by_sql( $sql1 );
                if (isset($cursor1[0])) {
                    foreach($cursor1 as $val){
                        $data = $this->getWordGame($val->id);
                    }
                }
            }

            return $data;
        }

        function getWordGameRandomGrapheme($grapheme_id, $icount) {
            $data = array();

            $sql = "SELECT mg_wordsegment.id FROM mg_wordsegment, mg_grapheme_wordsegment_linkage WHERE mg_wordsegment.id = mg_grapheme_wordsegment_linkage.wordsegment_id AND mg_grapheme_wordsegment_linkage.grapheme_id = '" . $grapheme_id . "' AND mg_wordsegment.double_flag != 1 AND LENGTH(mg_wordsegment.word) <= 9 GROUP BY mg_wordsegment.word ORDER BY RAND() LIMIT 0," . $icount . ";";

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                foreach($cursor as $val) {
                    $data = $this->getWordGame($val->id);
                }
            }
            return $data;
        }

        function getVocab($wordsegment_id) {
            $data = array();

            $sql = "SELECT id, word, image FROM mg_wordsegment WHERE id = '" . $wordsegment_id . "';";

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {

                $data["word_id"] = $cursor[0]->id;
                $data["word"] = $cursor[0]->word;

                $hashMap1 = array();
                $hashMap1["word_id"] = $cursor[0]->id;
                $hashMap1["word"] = $cursor[0]->word;
                $hashMap1["image"] = $cursor[0]->image;

                $similarImage = "'kid','boy','wax','candle','beat','bash','died','die','killed','believe','hope','cost','value','sail','boat','book','knowledge','glass','bottom','car','entity','famous','celebrity','edge','table','hunt','hunting','fell','hurt','jute','knot','laugh','laughed','pay','lend','pick','picked','loud','speak','win','prize','scale','inches','lot','people','melt','ice','bomb','wick','present','gift','way','road','exam','test','ankle','foot','west','east','trade','buy','sell'";
                $sql1 = "SELECT id, word, image FROM mg_wordsegment WHERE id != '" . $wordsegment_id . "' AND LOWER(TRIM(word)) != '" . strtolower(trim($cursor[0]->word)) . "' AND ( delete_flag = 0 OR delete_flag IS NULL ) AND image != '' AND word NOT in (" . $similarImage . ") GROUP BY word ORDER BY RAND() LIMIT 0,3;";

                $data1 = array();

                $cursor1 = User::find_by_sql( $sql1 );
                if (isset($cursor1[0])) {
                    foreach($cursor1 as $val) {
                        $hashMap2 = array();
                        $hashMap2["word_id"] = $val->id;
                        $hashMap2["word"] = $val->word;
                        $hashMap2["image"] = $val->image;

                        $sql21 = "SELECT id FROM mg_word WHERE LOWER(TRIM(word)) = '" . strtolower(trim($val->word)) . "';";

                        $word_id1 = 0;

                        $cursor21 = User::find_by_sql( $sql21 );
                        if (isset($cursor21[0])) {
                            $word_id1 = $cursor21[0]->id;
                        }

                        $sql31 = "SELECT language_id, translation FROM mg_word_translation WHERE word_id = '" . $word_id1 . "';";

                        $data31 = null;

                        $cursor31 = User::find_by_sql( $sql31 );
                        if (isset($cursor31[0])) {
                            $data31 = array();
                            foreach($cursor31 as $val1){
                                $hashMap31 = array();
                                $hashMap31["language_id"] = $val1->language_id;
                                $hashMap31["translation"] = $val1->translation;
                                $data31[] = $hashMap31;
                            }
                        }

                        $hashMap2["translation"] = $data31;

                        $data1[] = $hashMap2;
                    }
                }

                $sql2 = "SELECT id FROM mg_word WHERE LOWER(TRIM(word)) = '" . strtolower(trim($cursor[0]->word)) . "';";

                $word_id = 0;

                $cursor2 = User::find_by_sql( $sql2 );
                if (isset($cursor2[0])) {
                    $word_id = $cursor2[0]->id;
                }

                $sql3 = "SELECT language_id, translation FROM mg_word_transliteration WHERE word_id = '" . $word_id . "';";

                $data3 = array();

                $cursor3 = User::find_by_sql( $sql3 );
                if (isset($cursor3[0])) {
                    $data3 = array();
                    foreach($cursor3 as $val) {
                        $hashMap3 = array();
                        $hashMap3["language_id"] = $val->language_id;
                        $hashMap3["transliteration"] = $val->translation;
                        $data3[] = $hashMap3;
                    }
                }

                $data["transliteration"] = $data3;

                $sql31 = "SELECT language_id, translation FROM mg_word_translation WHERE word_id = '" . $word_id . "';";

                $data31 = array();

                $cursor31 = User::find_by_sql( $sql31 );
                if (isset($cursor31[0])) {
                    $data31 = array();
                    foreach($cursor31 as $val) {
                        $hashMap31 = array();
                        $hashMap31["language_id"] = $val->language_id;
                        $hashMap31["translation"] = $val->translation;
                        $data31[] = $hashMap31;
                    }
                }

                $data["translation"] = $data31;
                $hashMap1["translation"] = $data31;
                $data1[] = $hashMap1;
                $data["options"] = $data1;
            }
            return $data;
        }

        function getVocabRandom($grapheme_id, $icount) {
            $data = array();

            $sql = "SELECT mg_grapheme_wordsegment_linkage.wordsegment_id FROM mg_wordsegment, mg_grapheme_wordsegment_linkage WHERE mg_grapheme_wordsegment_linkage.wordsegment_id = mg_wordsegment.id AND ( mg_wordsegment.delete_flag = 0 OR mg_wordsegment.delete_flag IS NULL ) AND mg_grapheme_wordsegment_linkage.grapheme_id = '" . $grapheme_id . "' AND mg_wordsegment.image != '' GROUP BY LOWER(TRIM(mg_wordsegment.word)) ORDER BY RAND() LIMIT 0," . $icount . ";";

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                foreach($cursor as $val) {
                    $data[] = $this->getVocab($val->wordsegment_id);
                }
            }
            return $data;
        }

        function getVocabRandomSingle($grapheme_id) {
            $data = array();

            $sql = "SELECT mg_grapheme_wordsegment_linkage.wordsegment_id FROM mg_wordsegment, mg_grapheme_wordsegment_linkage WHERE mg_grapheme_wordsegment_linkage.wordsegment_id = mg_wordsegment.id AND ( mg_wordsegment.delete_flag = 0 OR mg_wordsegment.delete_flag IS NULL ) AND mg_grapheme_wordsegment_linkage.grapheme_id = '" . $grapheme_id . "' AND mg_wordsegment.image != '' GROUP BY LOWER(TRIM(mg_wordsegment.word)) ORDER BY RAND() LIMIT 0,1;";

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                foreach($cursor as $val) {
                    $data = $this->getVocab($val->wordsegment_id);
                }
            }
            return $data;
        }

        function getVocabConceptRandom($wordsegment_id, $icount) {
            $data = array();

            $sql = "SELECT concept FROM mg_wordsegment WHERE id = '" . $wordsegment_id . "';";

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {

                $sql1 = "SELECT id FROM mg_wordsegment WHERE concept = '" . addslashes($cursor[0]->concept) . "' AND ( delete_flag = 0 OR delete_flag IS NULL ) AND  image != '' GROUP BY LOWER(TRIM(word)) ORDER BY RAND() LIMIT 0," . $icount . ";";

                $cursor1 = User::find_by_sql( $sql1 );
                if (isset($cursor1[0])) {
                    foreach($cursor1 as $val) {
                        $data[] = $this->getVocab($val->id);
                    }
                }
            }
            return $data;
        }

        function getVocabConceptRandomSingle($wordsegment_id) {
            $data = array();

            $sql = "SELECT concept FROM mg_wordsegment WHERE id = '" . $wordsegment_id . "';";

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {

                $sql1 = "SELECT id FROM mg_wordsegment WHERE concept = '" . addslashes($cursor[0]->concept) . "' AND ( delete_flag = 0 OR delete_flag IS NULL ) AND  image != '' GROUP BY LOWER(TRIM(word)) ORDER BY RAND() LIMIT 0,1;";

                $cursor1 = User::find_by_sql( $sql1 );
                if (isset($cursor1[0])) {
                    foreach($cursor1 as $val) {
                        $data = $this->getVocab($val->id);
                    }
                }
            }
            return $data;
        }

        function getPhrase($phrase_id, $icount) {
            $data = array();

            $sql = "SELECT id, phrase FROM mg_phrase WHERE id = '" . $phrase_id . "';";
            $sql1 = "SELECT mg_sentence.id, mg_sentence.sentence, mg_sentence.image, mg_sentence.audio, mg_sentence.audio_map  FROM mg_phrase_sentence_linkage, mg_sentence WHERE mg_phrase_sentence_linkage.sentence_id = mg_sentence.id AND phrase_id = '" . $phrase_id . "' ORDER BY rand() ASC LIMIT 0," . $icount . ";";

            $data1 = array();

            $cursor1 = User::find_by_sql( $sql1 );
            if (isset($cursor1[0])) {
                $data1 = array();
                foreach($cursor1 as $val) {
                    $hashMap1 = array();
                    $hashMap1["sentence_id"] = $val->id;
                    $hashMap1["sentence"] = $val->sentence;
                    $hashMap1["image"] = $val->image;
                    $hashMap1["audio"] = $val->audio;
                    $hashMap1["audio_map"] = $val->audio_map;
                    $data1[] = $hashMap1;
                }
            }

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                $data["phrase_id"] = $cursor[0]->id;
                $data["phrase"] = $cursor[0]->phrase;
                $data["sentences"] = $data1;
            }
            return $data;
        }

        function getPhraseGame($sentence_id) {
            $data = array();

            $sql = "SELECT id, sentence FROM mg_sentence WHERE id = '" . $sentence_id . "';";

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                $data["sentence_id"] = $cursor[0]->id;
                $data["sentence"] = $cursor[0]->sentence;
            }
            return $data;
        }

        function getListenToASound($grapheme_id) {
            $hashMapData = array();
            $graphemeoptions = array();

            $sql = "SELECT id, grapheme, phoneme, audio FROM mg_grapheme WHERE id = '" . $grapheme_id . "';";

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                $hashMapData['id'] = $cursor[0]->id;
                $hashMapData['grapheme_id'] = $cursor[0]->id;
                $hashMapData['grapheme'] = $cursor[0]->grapheme;
                $hashMapData['phoneme'] = $cursor[0]->phoneme;
                $hashMapData['audio'] = $cursor[0]->audio;

                $graphemeoptions = array();
                $hashMap = array();
                $hashMap["grapheme"] = $cursor[0]->grapheme;

                $sql2 = "SELECT language_id,script FROM mg_grapheme_script where grapheme_id='" . $cursor[0]->id . "';";
                $cursor2 = User::find_by_sql( $sql2 );
                $graphemeScriptDetails = array();
                if (isset($cursor2[0])) {
                    foreach ($cursor2 as $val) {
                        $hashMap1 = array();
                        $hashMap1["language_id"] = $val->language_id;
                        $hashMap1["script"] = $val->script;
                        $graphemeScriptDetails[] = $hashMap1;
                    }
                }
                $hashMap['grapheme_script'] = $graphemeScriptDetails;

                $graphemeoptions[] = $hashMap;

                $strr = str_replace(array("0","1","2","3","4","5","6","7","8","9"), array("","","","","","","","","",""), $cursor[0]->grapheme);
                $strr1 = str_replace(array("0","1","2","3","4","5","6","7","8","9"), array("","","","","","","","","",""), $cursor[0]->phoneme);

                $sql1 = "SELECT grapheme FROM mg_grapheme WHERE grapheme NOT LIKE '%" . $strr . "%' AND phoneme NOT LIKE '%" . $strr . "%' AND grapheme NOT LIKE '%" . $strr1 . "%' AND phoneme NOT LIKE '%" . $strr1 . "%' AND id != '" . $cursor[0]->id . "' ORDER BY RAND() LIMIT 0, 3;";
                $cursor1 = User::find_by_sql( $sql1 );
                if (isset($cursor1[0])) {
                    foreach($cursor1 as $val){
                        $hashMap1 = array();
                        $hashMap1["grapheme"] = $val->grapheme;

                        $sql2 = "SELECT language_id,script FROM mg_grapheme_script where grapheme_id='" . $val->grapheme . "';";
                        $cursor2 = User::find_by_sql( $sql2 );

                        $graphemeScriptDetails = array();
                        if (isset($cursor2[0])) {
                            foreach($cursor2 as $val1) {
                                $hashMap2 = array();
                                $hashMap2["language_id"] = $val1->language_id ;
                                $hashMap2["script"] = $val1->script ;
                                $graphemeScriptDetails[] = $hashMap2;
                            }
                        }
                        $hashMap1['graphere_script'] = $graphemeScriptDetails;
                        $graphemeoptions[] = $hashMap1;
                    }
                }
                $hashMapData['options'] = $graphemeoptions;
            }
            return $hashMapData;
        }

        function getListenToASoundRandom($grapheme) {
            $hashMapData = array();

            $sql = "SELECT id FROM mg_grapheme WHERE grapheme = '" . trim($grapheme) . "';";

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                $hashMapData = $this->getListenToASound($cursor[0]->id);
            }
            return $hashMapData;
        }

        function getOddityStartsWithGrapheme($grapheme_id) {

            $arrayListOption = array();
            $hashMapData = array();

            $sql = "SELECT mg_wordsegment.word FROM mg_wordsegment, mg_grapheme_wordsegment_linkage WHERE mg_wordsegment.id = mg_grapheme_wordsegment_linkage.wordsegment_id AND mg_grapheme_wordsegment_linkage.grapheme_id = '" . $grapheme_id . "' AND mg_grapheme_wordsegment_linkage.order_number = 1 AND ( mg_wordsegment.delete_flag = 0 OR mg_wordsegment.delete_flag IS NULL ) AND mg_wordsegment.status='active' GROUP BY mg_wordsegment.word ORDER BY RAND() LIMIT 0,3;";
            $sql1 = "SELECT mg_wordsegment.word FROM mg_wordsegment, mg_grapheme_wordsegment_linkage WHERE mg_wordsegment.id = mg_grapheme_wordsegment_linkage.wordsegment_id AND mg_grapheme_wordsegment_linkage.grapheme_id != '" . $grapheme_id . "' AND ( mg_wordsegment.delete_flag = 0 OR mg_wordsegment.delete_flag IS NULL ) AND mg_wordsegment.status='active' ORDER BY RAND() LIMIT 0,1;";

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                foreach($cursor as $val) {
                    $arrayListOption[] = $val->word;
                }

                $cursor1 = User::find_by_sql( $sql1 );
                if (isset($cursor1[0])) {
                    $arrayListOption[] = $cursor1[0]->word;
                    $hashMapData["options"] = $arrayListOption;
                    $hashMapData["answer"] = $cursor1[0]->word;
                }
            }
            return $hashMapData;
        }

        function getOddityEndsWithGrapheme($grapheme_id) {
            $arrayListOption = array();
            $hashMapData = array();

            //      $sql = "SELECT DISTINCT (mg_wordsegment.word) FROM mg_wordsegment, mg_grapheme_wordsegment_linkage u WHERE u.wordsegment_id = mg_wordsegment.id AND ( mg_wordsegment.delete_flag = 0 OR mg_wordsegment.delete_flag IS NULL ) AND mg_wordsegment.status='active' AND u.grapheme_id = '" . $grapheme_id . "' AND u.order_number = (SELECT MAX(m.order_number) FROM mg_grapheme_wordsegment_linkage m WHERE m.wordsegment_id = u.wordsegment_id ) ORDER BY RAND() LIMIT 0,3;";​
            $sql = "SELECT mg_wordsegment.word AS wword FROM mg_wordsegment, mg_grapheme_wordsegment_linkage u WHERE u.wordsegment_id = mg_wordsegment.id AND ( mg_wordsegment.delete_flag = 0 OR mg_wordsegment.delete_flag IS NULL ) AND mg_wordsegment.status='active' AND u.grapheme_id = '" . $grapheme_id . "' AND u.order_number = (SELECT MAX(m.order_number) FROM mg_grapheme_wordsegment_linkage m WHERE m.wordsegment_id = u.wordsegment_id ) GROUP BY mg_wordsegment.word ORDER BY RAND() LIMIT 0,3;";
            $sql1 = "SELECT mg_wordsegment.word FROM mg_wordsegment, mg_grapheme_wordsegment_linkage WHERE mg_grapheme_wordsegment_linkage.wordsegment_id = mg_wordsegment.id AND ( mg_wordsegment.delete_flag = 0 OR mg_wordsegment.delete_flag IS NULL ) AND mg_wordsegment.status='active' AND  mg_grapheme_wordsegment_linkage.grapheme_id != '" . $grapheme_id . "' ORDER BY RAND() LIMIT 0,1;";

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                foreach($cursor as $val){
                    $arrayListOption[] = $val->wword;
                }

                $cursor1 = User::find_by_sql( $sql1 );
                if (isset($cursor1[0])) {
                    $arrayListOption[] = $cursor1[0]->word;
                    $hashMapData["options"] = $arrayListOption;
                    $hashMapData["answer"] = $cursor1[0]->word;
                }
            }
            return $hashMapData;
        }

        function getVowelBlend($vowelblend_id) {
            $hashMapData = array();

            $sql = "SELECT id, vowel, secondary_letter, audio,wordsegment_id FROM mg_vowel_blend WHERE id = '" . $vowelblend_id . "';";

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                $hashMapData["vowelblend_id"] = $cursor[0]->id;
                $hashMapData["vowel"] = $cursor[0]->vowel;
                $hashMapData["secondary_letter"] = $cursor[0]->secondary_letter;
                $hashMapData["audio"] = $cursor[0]->audio;
                $hashMapData["wordsegment_id"] = $cursor[0]->wordsegment_id;

                $wordsegment_id = $cursor[0]->wordsegment_id;
                $secondary_letter = $cursor[0]->secondary_letter;
                $vowel = $cursor[0]->vowel;
                $sql2 = "SELECT id, grapheme, audio FROM mg_grapheme WHERE ( delete_flag = 0 OR delete_flag IS NULL ) AND grapheme = '" . $secondary_letter . "' LIMIT 0,1;";

                $cursor2 = User::find_by_sql( $sql2 );
                if (isset($cursor2[0])) {
                    $hashMap1 = array();
                    $hashMap1["id"] = $cursor2[0]->id;
                    $hashMap1["grapheme"] = $cursor2[0]->grapheme;
                    $hashMap1["audio"] = $cursor2[0]->audio;

                    $sql21 = "SELECT language_id,script FROM mg_grapheme_script where grapheme_id='" . $cursor2[0]->id . "';";
                    $cursor21 = User::find_by_sql( $sql21 );

                    $graphemeScriptDetails = array();
                    if (isset($cursor21[0])) {
                        foreach($cursor21 as $val) {
                            $hashMap11 = array();
                            $hashMap11["language_id"] = $val->language_id;
                            $hashMap11["script"] = $val->script;
                            $graphemeScriptDetails[] = $hashMap11;
                        }
                    }
                    $hashMap1['grapheme_script'] = $graphemeScriptDetails;
                    $hashMapData["letter1"] = $hashMap1;
                }

                $sql2 = "SELECT id, grapheme, audio FROM mg_grapheme WHERE ( delete_flag = 0 OR delete_flag IS NULL ) AND grapheme = '" . $vowel . "' LIMIT 0,1;";

                $cursor2 = User::find_by_sql( $sql2 );
                if (isset($cursor2[0])) {
                    $hashMap1 = array();
                    $hashMap1["id"] = $cursor2[0]->id;
                    $hashMap1["grapheme"] = $cursor2[0]->grapheme;
                    $hashMap1["audio"] = $cursor2[0]->audio;

                    $sql21 = "SELECT language_id,script FROM mg_grapheme_script where grapheme_id='" . $cursor2[0]->id . "';";

                    $cursor21 = User::find_by_sql( $sql21 );
                    $graphemeScriptDetails = array();
                    if (isset($cursor21[0])) {
                        foreach($cursor21 as $val) {
                            $hashMap11 = array();
                            $hashMap11["language_id"] = $val->language_id;
                            $hashMap11["script"] = $val->script;
                            $graphemeScriptDetails[] = $hashMap11;
                        }
                    }
                    $hashMap1['grapheme_script'] = $graphemeScriptDetails;

                    $hashMapData["letter2"] = $hashMap1;
                }

                $sql2 = "SELECT word, image FROM mg_wordsegment WHERE id = '" . $wordsegment_id . "' LIMIT 0,1;";

                $hashMapData["word"] = $cursor[0]->secondary_letter . $cursor[0]->vowel;
                $hashMapData["word_image"] = "";

                $cursor2 = User::find_by_sql( $sql2 );
                if (isset($cursor2[0])) {
                    $hashMapData["word"] = $cursor2[0]->word;
                    $hashMapData["word_image"] = $cursor2[0]->image;
                }
            }
            return $hashMapData;
        }

        function getQuestion($question_id) {
            $hashMapData = array();
            $sql = "SELECT mg_question.title, mg_question.question, mg_question.score, mg_question.question_template_id, mg_concepts.name FROM mg_question, mg_concepts_question_linkage, mg_concepts WHERE mg_concepts_question_linkage.question_id = mg_question.id AND mg_concepts.id = mg_concepts_question_linkage.concepts_id AND mg_question.id = '" . $question_id . "';";
            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                $hashMapData["question_id"] = $question_id;
                $hashMapData["title"] = $cursor[0]->title;
                $hashMapData["question"] = $cursor[0]->question;
                $hashMapData["score"] = $cursor[0]->score;
                $hashMapData["question_template_id"] = $cursor[0]->question_template_id;
                $hashMapData["concept"] = $cursor[0]->name;

                $sql1 = "SELECT language_id,translation FROM mg_question_translation WHERE question_id = '" . $question_id . "';";

                $lang = array();

                $cursor1 = User::find_by_sql( $sql1 );

                if (isset($cursor1[0])) {
                    foreach($cursor1 as $val) {
                        $hashMap = array();
                        $hashMap["language_id"] = $val->language_id;
                        $hashMap["translation"] = $val->translation;
                        $lang[] = $hashMap;
                    }
                }

                $hashMapData["translation"] = $lang;
            }
            return $hashMapData;
        }

        function getQuestionHV($question_id) {
            $hashMapData = array();
            $sql = "SELECT mg_question.title, mg_question.question, mg_question.score, mg_question.question_template_id FROM mg_question WHERE mg_question.id = '" . $question_id . "';";
            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                $hashMapData["question_id"] = $question_id;
                $hashMapData["title"] = $cursor[0]->title;
                $hashMapData["question"] = $cursor[0]->question;
                $hashMapData["score"] = $cursor[0]->score;
                $hashMapData["question_template_id"] = $cursor[0]->question_template_id;
                //$hashMapData["concept"] = $cursor[0]->name;

                $sql1 = "SELECT language_id,translation FROM mg_question_translation WHERE question_id = '" . $question_id . "';";

                $lang = array();

                $cursor1 = User::find_by_sql( $sql1 );

                if (isset($cursor1[0])) {
                    foreach($cursor1 as $val) {
                        $hashMap = array();
                        $hashMap["language_id"] = $val->language_id;
                        $hashMap["translation"] = $val->translation;
                        $lang[] = $hashMap;
                    }
                }

                $hashMapData["translation"] = $lang;
            }
            return $hashMapData;
        }

        function getStoryQuestionByID($question_id) {
            $hashMapData = array();
            $sql = "SELECT mg_question.title, mg_question.question, mg_question.score, mg_question.question_template_id FROM mg_question WHERE mg_question.id = '" . $question_id . "';";
            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                $hashMapData["question_id"] = $question_id;
                $hashMapData["title"] = $cursor[0]->title;
                $hashMapData["question"] = $cursor[0]->question;
                $hashMapData["score"] = $cursor[0]->score;
                $hashMapData["question_template_id"] = $cursor[0]->question_template_id;
                //$hashMapData["concept"] = $cursor[0]->name;

                $sql1 = "SELECT language_id,translation FROM mg_question_translation WHERE question_id = '" . $question_id . "';";

                $lang = array();

                $cursor1 = User::find_by_sql( $sql1 );

                if (isset($cursor1[0])) {
                    foreach($cursor1 as $val) {
                        $hashMap = array();
                        $hashMap["language_id"] = $val->language_id;
                        $hashMap["translation"] = $val->translation;
                        $lang[] = $hashMap;
                    }
                }

                $hashMapData["translation"] = $lang;
            }
            return $hashMapData;
        }

        function getConceptQuestion($concept_id, $icount) {
            $hashMapData1 = array();

            $sql = "SELECT mg_question.id,mg_question.title, mg_question.question, mg_question.score, mg_question.question_template_id, mg_concepts.name FROM mg_question, mg_concepts_question_linkage, mg_concepts WHERE mg_concepts_question_linkage.question_id = mg_question.id AND mg_concepts.id = mg_concepts_question_linkage.concepts_id AND mg_concepts_question_linkage.concepts_id = '" . $concept_id . "' ORDER BY RAND() LIMIT 0," . $icount . ";";

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                foreach($cursor as $val) {
                    $hashMapData = array();
                    $hashMapData["question_id"] = $val->id;
                    $hashMapData["title"] = $val->title;
                    $hashMapData["question"] = $val->question;
                    $hashMapData["score"] = $val->score;
                    $hashMapData["question_template_id"] = $val->question_template_id;
                    $hashMapData["concept"] = $val->name;

                    $sql1 = "SELECT language_id,translation FROM mg_question_translation WHERE question_id = '" . $val->id . "';";

                    $lang = array();

                    $cursor1 = User::find_by_sql( $sql1 );

                    if (isset($cursor1[0])) {
                        foreach($cursor1 as $val1) {
                            $hashMap = array();
                            $hashMap["language_id"] = $val1->language_id;
                            $hashMap["translation"] = $val1->translation;
                            $lang[] = $hashMap;
                        }
                    }

                    $hashMapData["translation"] = $lang;

                    $hashMapData1 = $hashMapData;
                }
            }
            return $hashMapData1;
        }

        function getSpecificQuestion($type_id, $icount) {
            $hashMapData1 = array();

            $sql = "SELECT mg_question.title FROM mg_question WHERE mg_question.id = '" . $type_id . "' LIMIT 0,1;";

            $title = "";

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                $title = $cursor[0]->title;
            }

            $sql1 = "SELECT mg_question.id,mg_question.title, mg_question.question, mg_question.score, mg_question.question_template_id, mg_concepts.name FROM mg_question, mg_concepts_question_linkage, mg_concepts WHERE mg_concepts_question_linkage.question_id = mg_question.id AND mg_concepts.id = mg_concepts_question_linkage.concepts_id AND mg_question.title = '" . addslashes($title) . "' ORDER BY RAND() LIMIT 0," . $icount . ";";

            $cursor1 = User::find_by_sql( $sql1 );
            if (isset($cursor1[0])) {
                foreach($cursor1 as $val) {
                    $hashMapData = array();
                    $hashMapData["question_id"] = $val->id;
                    $hashMapData["title"] = $val->title;
                    $hashMapData["question"] = $val->question;
                    $hashMapData["score"] = $val->score;
                    $hashMapData["question_template_id"] = $val->question_template_id;
                    $hashMapData["concept"] = $val->name;

                    $sql2 = "SELECT language_id,translation FROM mg_question_translation WHERE question_id = '" . $val->id . "';";

                    $lang = array();

                    $cursor2 = User::find_by_sql( $sql2 );

                    if (isset($cursor2[0])) {
                        foreach($cursor2 as $val1){
                            $hashMap = array();
                            $hashMap["language_id"] = $val1->language_id;
                            $hashMap["translation"] = $val1->translation;
                            $lang[] = $hashMap;
                        }
                    }

                    $hashMapData["translation"] = $lang;

                    $hashMapData1 = $hashMapData;
                }
            }
            return $hashMapData1;
        }

        function getCountInActivity($activity_level, $activity_num, $world) {
            $world = strtolower(str_replace(" ", "_", $world));

            $sql = '';
            if ($activity_level == 0) {
                $cid = 0;
                if ($world == "sound_of_letters") {
                    $cid = 320;
                } else if ($world == "vowel_friends") {
                    $cid = 321;
                } else if ($world == "wordy_birdy") {
                    $cid = 322;
                } else if ($world == "phrases_in_the_sky") {
                    $cid = 323;
                }
                $sql = "SELECT mg_activity_linkage.* FROM mg_activity_linkage,mg_activity WHERE mg_activity.id = mg_activity_linkage.activity_id AND ( mg_activity.delete_flag = 0 OR mg_activity.delete_flag IS NULL ) AND mg_activity.id = '" . $cid . "' AND mg_activity.challenge = 1;";
            } else {
                $sql = "SELECT mg_activity_linkage.* FROM mg_activity_linkage,mg_activity WHERE mg_activity.id = mg_activity_linkage.activity_id AND ( mg_activity.delete_flag = 0 OR mg_activity.delete_flag IS NULL ) AND mg_activity.level = '" . $activity_level . "' AND mg_activity.activity_num = '" . $activity_num . "' AND mg_activity.challenge = 0;";
            }

            $icount = 0;
            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                foreach($cursor as $val) {
                    if ($val->type == "learn_letter") {
                        $icount++;
                    } else if ($val->type == "learn_grapheme") {
                        $icount++;
                    } else if ($val->type == "trace_grapheme") {
                        $icount++;
                    } else if ($val->type == "local_language_blend") {
                        $icount++;
                    } else if ($val->type == "vowel_blend") {
                        $icount++;
                    } else if ($val->type == "vowel_blend_trace") {
                        $icount++;
                    } else if ($val->type == "segmenting_blending") {
                        $icount++;
                    } else if ($val->type == "segmenting_blending_random") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "word_game") {
                        $icount++;
                    } else if ($val->type == "word_game_random") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "word_game_random_grapheme") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "vocab") {
                        $icount++;
                    } else if ($val->type == "vocabrandom") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "vocabconceptrandom") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "story") {
                        $sql1 = "SELECT count(*) AS icount FROM story_page_table WHERE story_id = '" . $val->type_id . "';";
                        $cursor1 = User::find_by_sql( $sql1 );
                        if (isset($cursor1[0])) {
                            $icount += $val->icount + 2;
                        }
                    } else if ($val->type == "rhymes") {
                        $icount++;
                    } else if ($val->type == "phrase") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "phrase_game") {
                        $icount++;
                    } else if ($val->type == "grammar") {
                        $icount++;
                    } else if ($val->type == "grammarrandom") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "grammarrandom_specific") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "spelling") {
                        $icount++;
                    } else if ($val->type == "reading_test") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "first_last_sound") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "first_last_sound_random") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "missing_letter") {
                        $icount++;
                    } else if ($val->type == "listen_to_a_sound") {
                        $icount++;
                    } else if ($val->type == "listen_to_a_sound_random") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "oddity_starts_with_grapheme") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "oddity_ends_with_grapheme") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    }
                }
            }
            return $icount;
        }

        function getActivityLinkageData($activity_level, $activity_num, $world,$category) {
            $world = strtolower(str_replace(" ", "_", $world));

            $sql = '';
            if ($category == 'challenge') {
                $cid = 0;
                if ($world == "sound_of_letters") {
                    $cid = 320;
                } else if ($world == "vowel_friends") {
                    $cid = 321;
                } else if ($world == "wordy_birdy") {
                    $cid = 322;
                } else if ($world == "phrases_in_the_sky") {
                    $cid = 323;
                }
                $sql = "SELECT mg_activity_linkage.* FROM mg_activity_linkage,mg_activity WHERE mg_activity.id = mg_activity_linkage.activity_id AND ( mg_activity.delete_flag = 0 OR mg_activity.delete_flag IS NULL ) AND mg_activity.id = '" . $cid . "' AND mg_activity.challenge = 1;";
            } else {
                $sql = "SELECT mg_activity_linkage.* FROM mg_activity_linkage,mg_activity WHERE mg_activity.id = mg_activity_linkage.activity_id AND ( mg_activity.delete_flag = 0 OR mg_activity.delete_flag IS NULL ) AND mg_activity.level = '" . $activity_level . "' AND mg_activity.activity_num = '" . $activity_num . "' AND mg_activity.challenge = 0;";
            }

            $acl = array();
            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                foreach($cursor as $val) {
                    if ($val->type == "learn_letter") {
                        $acl[] = $val->id;
                    } else if ($val->type == "learn_grapheme") {
                        $acl[] = $val->id;
                    } else if ($val->type == "trace_grapheme") {
                        $acl[] = $val->id;
                    } else if ($val->type == "local_language_blend") {
                        $acl[] = $val->id;
                    } else if ($val->type == "vowel_blend") {
                        $acl[] = $val->id;
                    } else if ($val->type == "vowel_blend_trace") {
                        $acl[] = $val->id;
                    } else if ($val->type == "segmenting_blending") {
                        $acl[] = $val->id;
                    } else if ($val->type == "segmenting_blending_random") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "word_game") {
                        $acl[] = $val->id;
                    } else if ($val->type == "word_game_random") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "word_game_random_grapheme") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "vocab") {
                        $acl[] = $val->id;
                    } else if ($val->type == "vocabrandom") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "vocabconceptrandom") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "story") {
                        $acl[] = $val->id;
                    } else if ($val->type == "rhymes") {
                        $acl[] = $val->id;
                    } else if ($val->type == "phrase") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "phrase_game") {
                        $acl[] = $val->id;
                    } else if ($val->type == "grammar") {
                        $acl[] = $val->id;
                    } else if ($val->type == "grammarrandom") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "grammarrandom_specific") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "spelling") {
                        $acl[] = $val->id;
                    } else if ($val->type == "reading_test") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "first_last_sound") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "first_last_sound_random") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "missing_letter") {
                        $acl[] = $val->id;
                    } else if ($val->type == "listen_to_a_sound") {
                        $acl[] = $val->id;
                    } else if ($val->type == "listen_to_a_sound_random") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "oddity_starts_with_grapheme") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "oddity_ends_with_grapheme") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    }
                }
            }
            return $acl;
        }

        function checkChallengeUserActivity($level, $score, $world, $user_id) {

            if ($level == 0 && $score >= 120) {

                $world = strtolower(str_replace(" ", "_", $world));

                $sql = "SELECT id, score, level, activity_num FROM mg_activity WHERE ( delete_flag = 0 OR delete_flag IS NULL ) AND challenge = 0 AND world = '" . $world . "';";

                $cursor = User::find_by_sql( $sql );
                if (isset($cursor[0])) {
                    foreach($cursor as $val) {
                        $sql1 = "SELECT id FROM mg_user_activity WHERE activity_id = '" . $val->id . "' AND user_id = '" . $user_id . "' LIMIT 0,1;";

                        $cursor1 = User::find_by_sql( $sql1 );
                        $flagg = 1;
                        if (isset($cursor1[0])) {
                            $flagg = 0;
                        }

                        if ($flagg == 1) {

                            $user_act = UserActivity::create(array(
                                "user_id" => $user_id,
                                "activity_id" => $val->id,
                                "points" => $val->score,
                                "score" => 0,
                                "stars" => 0,
                                "created" => date("Y-m-d H:i:s"),
                                "updated" => date("Y-m-d H:i:s"),
                                "level" => $val->level,
                                "activity_number" => $val->activity_num,
                                "meta_type" => 0,
                            ));
                        }
                    }
                }
            }
        }


        function getWorldChallenge($world, $user_id) {
            $chall = false;
            $world = strtolower(str_replace(" ", "_", $world));

            $cid = 0;
            if ($world == "sound_of_letters") {
                $cid = 320;
            } else if ($world == "vowel_friends") {
                $cid = 321;
            } else if ($world == "wordy_birdy") {
                $cid = 322;
            } else if ($world == "phrases_in_the_sky") {
                $cid = 323;
            }

            if ($cid != 0) {
                $sql6 = "SELECT level, activity_number, MAX(stars) AS starss FROM mg_user_activity WHERE user_id = '" . $user_id . "' AND activity_id = '" . $cid . "' GROUP BY activity_id;";

                $cursor6 = User::find_by_sql( $sql6 );
                if (isset($cursor6[0])) {
                    if ($cursor6[0]->starss > 0) {
                        $chall = true;
                    }
                }
            }
            return $chall;
        }


        function getStoryTotalQuestionCount($story_id) {
            $total = 0;

            if(in_array($story_id,$this->_new_stories) ) {
                $sql = "SELECT COUNT(mg_story_question_linkage.id) AS icount FROM mg_question, mg_story_question_linkage WHERE mg_question.id = mg_story_question_linkage.question_id AND mg_story_question_linkage.story_id = '" . $story_id . "' AND (mg_story_question_linkage.type = 'during' OR mg_story_question_linkage.type = 'post') AND ( mg_question.question LIKE '%mcq_single_answer%' OR mg_question.question LIKE '%fill_blank%' OR mg_question.question LIKE '%match_column%' OR mg_question.question LIKE '%mcq_multiple_answer%' OR mg_question.question LIKE '%conversation%' OR mg_question.question LIKE '%record_missing_word%' ) AND mg_question.status = 'active' ;";
            } else {
                $sql = "SELECT COUNT(mg_story_question_linkage.id) AS icount FROM mg_question, mg_story_question_linkage WHERE mg_question.id = mg_story_question_linkage.question_id AND mg_story_question_linkage.story_id = '" . $story_id . "' AND (mg_story_question_linkage.type = 'during' OR mg_story_question_linkage.type = 'post') AND ( mg_question.question LIKE '%mcq_single_answer%' OR mg_question.question LIKE '%fill_blank%' OR mg_question.question LIKE '%match_column%' OR mg_question.question LIKE '%mcq_multiple_answer%' )  AND mg_question.status = 'active' ;";
            }

            $cursor = User::find_by_sql( $sql );

            if (isset($cursor[0])) {
                $total = $cursor[0]->icount;
            }
            return $total;
        }

        function activityTagsAndDescriptionValue($activityNum, $level, $category, $world) {
            $tagValue = array();
            $world = strtolower(str_replace(" ", "_", $world));

            if ($activityNum == 0) {
                $cid = 0;
                if ($world == "sound_of_letters") {
                    $cid = 320;
                } else if ($world == "vowel_friends") {
                    $cid = 321;
                } else if ($world == "wordy_birdy") {
                    $cid = 322;
                } else if ($world == "phrases_in_the_sky") {
                    $cid = 323;
                }
                $sql = "SELECT tags,description,id FROM mg_activity WHERE id = '" . $cid . "';";
            } else {
                $sql = "SELECT tags,description,id FROM mg_activity WHERE ( delete_flag = 0 OR delete_flag IS NULL ) AND challenge = 0 AND activity_num = '" . $activityNum . "' AND level = '" . $level . "' LIMIT 0,1";
            }

            $cursor = User::find_by_sql( $sql );

            if (isset($cursor[0])) {
                $tagValue = array();
                $tagValue["tags"] = $cursor[0]->tags;
                $tagValue["description"] = $cursor[0]->description;

                $sql1 = "SELECT language_id,translation FROM mg_activity_translation WHERE activity_id = '" . $cursor[0]->id . "';";

                $lang = array();

                $cursor1 = User::find_by_sql( $sql1 );

                if (isset($cursor1[0])) {
                    foreach($cursor1 as $val){
                        $hashMap = array();
                        $hashMap["language_id"] = $val->language_id;
                        $hashMap["translation"] = $val->translation;
                        $lang[] = $hashMap;
                    }
                    $tagValue["translation"] = $lang;
                }
            }
            return $tagValue;
        }

        function activityTagsAndDescriptionValueBid($activity_id) {
            $tagValue = array();
            $sql = "SELECT tags,description,id FROM mg_activity WHERE id = '" . $activity_id . "';";

            $cursor = User::find_by_sql( $sql );

            if (isset($cursor[0])) {
                $tagValue = array();
                $tagValue["tags"] = $cursor[0]->tags;
                $tagValue["description"] = $cursor[0]->description;

                $sql1 = "SELECT language_id,translation FROM mg_activity_translation WHERE activity_id = '" . $cursor[0]->id . "';";

                $lang = array();

                $cursor1 = User::find_by_sql( $sql1 );

                if (isset($cursor1[0])) {
                    foreach($cursor1 as $val){
                        $hashMap = array();
                        $hashMap["language_id"] = $val->language_id;
                        $hashMap["translation"] = $val->translation;
                        $lang[] = $hashMap;
                    }
                    $tagValue["translation"] = $lang;
                }
            }
            return $tagValue;
        }

        function helpActivityTagsAndDescriptionValue($level) {
            $tagValue = null;
            $sql = "SELECT tags,description,id FROM mg_help_activity WHERE ( delete_flag = 0 OR delete_flag IS NULL ) AND challenge = 0 AND level = '" . $level . "' LIMIT 0,1";

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                $tagValue = array();
                $tagValue["tags"] = $cursor[0]->tags;
                $tagValue["description"] = $cursor[0]->description;

                $sql1 = "SELECT language_id,translation FROM mg_help_activity_translation WHERE help_activity_id = '" . $cursor[0]->id . "';";

                $lang = array();

                $cursor1 = User::find_by_sql( $sql1 );

                if (isset($cursor1[0])) {
                    foreach($cursor1 as $val){
                        $hashMap = array();
                        $hashMap["language_id"] = $val->language_id;
                        $hashMap["translation"] = $val->translation;
                        $lang[] = $hashMap;
                    }
                    $tagValue["translation"] = $lang;
                }
            }
            return $tagValue;
        }

        function getOnboardingActivityDetails() {
            $hashMapArrayList = array();

            $sql1 = "SELECT mg_activity_linkage.* FROM mg_activity_linkage,mg_activity  WHERE mg_activity.id = mg_activity_linkage.activity_id AND ( mg_activity.delete_flag = 0 OR mg_activity.delete_flag IS NULL ) AND mg_activity.id = '320' AND mg_activity.challenge = 1 ORDER BY RAND();";
            $sql2 = "SELECT mg_activity_linkage.* FROM mg_activity_linkage,mg_activity  WHERE mg_activity.id = mg_activity_linkage.activity_id AND ( mg_activity.delete_flag = 0 OR mg_activity.delete_flag IS NULL ) AND mg_activity.id = '321' AND mg_activity.challenge = 1 ORDER BY RAND();";
            $sql3 = "SELECT mg_activity_linkage.* FROM mg_activity_linkage,mg_activity  WHERE mg_activity.id = mg_activity_linkage.activity_id AND ( mg_activity.delete_flag = 0 OR mg_activity.delete_flag IS NULL ) AND mg_activity.id = '322' AND mg_activity.challenge = 1 ORDER BY RAND();";
            $sql4 = "SELECT mg_activity_linkage.* FROM mg_activity_linkage,mg_activity  WHERE mg_activity.id = mg_activity_linkage.activity_id AND ( mg_activity.delete_flag = 0 OR mg_activity.delete_flag IS NULL ) AND mg_activity.id = '323' AND mg_activity.challenge = 1 ORDER BY RAND();";

            $cursor1 = User::find_by_sql( $sql1 );
            if (isset($cursor1[0])) {
                $hashMapArrayList1 = array();
                foreach($cursor1 as $val) {
                    $hashMap = array();
                    $hashMap['activity_linkage_id'] = $val->id;
                    $hashMap['activity_id'] = $val->activity_id;
                    $hashMap['type_id'] = $val->type_id;
                    $hashMap['type'] = $val->type;
                    $hashMap['order_num'] = $val->order_num;
                    $hashMap['additional_info'] = $val->additional_info;
                    $hashMap['added_by_id'] = $val->added_by_id;
                    $hashMap['updated_by_id'] = $val->updated_by_id;
                    $hashMapArrayList1[] = $hashMap;
                }
                $hashMapArrayList[] = $hashMapArrayList1;
            }

            $cursor2 = User::find_by_sql( $sql2 );
            if (isset($cursor2[0])) {
                $hashMapArrayList1 = array();
                foreach($cursor2 as $val) {
                    $hashMap = array();
                    $hashMap['activity_linkage_id'] = $val->id;
                    $hashMap['activity_id'] = $val->activity_id;
                    $hashMap['type_id'] = $val->type_id;
                    $hashMap['type'] = $val->type;
                    $hashMap['order_num'] = $val->order_num;
                    $hashMap['additional_info'] = $val->additional_info;
                    $hashMap['added_by_id'] = $val->added_by_id;
                    $hashMap['updated_by_id'] = $val->updated_by_id;
                    $hashMapArrayList1[] = $hashMap;
                }
                $hashMapArrayList[] = $hashMapArrayList1;
            }

            $cursor3 = User::find_by_sql( $sql3 );
            if (isset($cursor3[0])) {
                $hashMapArrayList1 = array();
                foreach($cursor3 as $val) {
                    $hashMap = array();
                    $hashMap['activity_linkage_id'] = $val->id;
                    $hashMap['activity_id'] = $val->activity_id;
                    $hashMap['type_id'] = $val->type_id;
                    $hashMap['type'] = $val->type;
                    $hashMap['order_num'] = $val->order_num;
                    $hashMap['additional_info'] = $val->additional_info;
                    $hashMap['added_by_id'] = $val->added_by_id;
                    $hashMap['updated_by_id'] = $val->updated_by_id;
                    $hashMapArrayList1[] = $hashMap;
                }
                $hashMapArrayList[] = $hashMapArrayList1;
            }

            $cursor4 = User::find_by_sql( $sql4 );
            if (isset($cursor4[0])) {
                $hashMapArrayList1 = array();
                foreach($cursor4 as $val) {
                    $hashMap = array();
                    $hashMap['activity_linkage_id'] = $val->id;
                    $hashMap['activity_id'] = $val->activity_id;
                    $hashMap['type_id'] = $val->type_id;
                    $hashMap['type'] = $val->type;
                    $hashMap['order_num'] = $val->order_num;
                    $hashMap['additional_info'] = $val->additional_info;
                    $hashMap['added_by_id'] = $val->added_by_id;
                    $hashMap['updated_by_id'] = $val->updated_by_id;
                    $hashMapArrayList1[] = $hashMap;
                }
                $hashMapArrayList[] = $hashMapArrayList1;
            }

            return $hashMapArrayList;
        }

        function checkConsecutiveActivityStars($wordName, $userId) {
            $hashMap = array();
            $wordName = strtolower(str_replace(" ", "_", $wordName));
            $sql = "SELECT COUNT(mg_user_activity.id) AS icount, SUM(mg_user_activity.stars) AS isum  FROM `mg_user_activity`, `mg_activity` WHERE mg_user_activity.meta_type = '0' AND mg_user_activity.activity_id = mg_activity.id AND mg_user_activity.user_id = '" . $userId . "' AND mg_activity.world = '" . $wordName . "' AND mg_activity.challenge != 1 GROUP BY mg_activity.world";

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                $hashMap = array();
                $hashMap["icount"] = $cursor[0]->icount;
                $hashMap["isum"] = $cursor[0]->isum;
            }
            return $hashMap;
        }


        function getSpecificActivityDetailsForHelpVideo($help_video_id, $order_number) {
            $hashMapArrayList = array();

            $sql = "SELECT mg_help_activity_linkage.* FROM mg_help_activity_linkage,mg_help_activity, mg_help_video_activity_linkage  WHERE mg_help_activity.id = mg_help_activity_linkage.help_activity_id AND mg_help_video_activity_linkage.help_activity_id = mg_help_activity.id AND ( mg_help_activity.delete_flag = 0 OR mg_help_activity.delete_flag IS NULL ) AND mg_help_video_activity_linkage.help_video_id = '" . $help_video_id . "' AND mg_help_video_activity_linkage.order_number = '" . $order_number . "' ORDER BY mg_help_activity_linkage.order_num ASC";

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                $hashMapArrayList = array();
                foreach($cursor as $val) {
                    $hashMap = array();
                    $hashMap["activity_linkage_id"] = $val->activity_linkage_id;
                    $hashMap["activity_id"] = $val->activity_id;
                    $hashMap["type_id"] = $val->type_id;
                    $hashMap["type"] = $val->type;
                    $hashMap["order_num"] = $val->order_num;
                    $hashMap["additional_info"] = $val->additional_info;
                    $hashMap["added_by_id"] = $val->added_by_id;
                    $hashMap["update_by_id"] = $val->update_by_id;
                    $hashMapArrayList[] = $hashMap;
                }
            }
            return $hashMapArrayList;
        }


        function getCountInActivityForHelpVideo($help_video_id, $activity_num) {
            $sql = "SELECT mg_help_activity_linkage.* FROM mg_help_activity_linkage,mg_help_activity, mg_help_video_activity_linkage  WHERE mg_help_activity.id = mg_help_activity_linkage.help_activity_id AND mg_help_video_activity_linkage.help_activity_id = mg_help_activity.id AND ( mg_help_activity.delete_flag = 0 OR mg_help_activity.delete_flag IS NULL ) AND mg_help_video_activity_linkage.help_video_id = '" . $help_video_id . "' AND mg_help_video_activity_linkage.order_number = '" . $activity_num . "' ORDER BY mg_help_activity_linkage.order_num ASC";
            $icount = 0;
            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                foreach($cursor as $val) {
                    if ($val->type == "learn_letter") {
                        $icount++;
                    } else if ($val->type == "learn_grapheme") {
                        $icount++;
                    } else if ($val->type == "trace_grapheme") {
                        $icount++;
                    } else if ($val->type == "local_language_blend") {
                        $icount++;
                    } else if ($val->type == "vowel_blend") {
                        $icount++;
                    } else if ($val->type == "vowel_blend_trace") {
                        $icount++;
                    } else if ($val->type == "segmenting_blending") {
                        $icount++;
                    } else if ($val->type == "segmenting_blending_random") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "word_game") {
                        $icount++;
                    } else if ($val->type == "word_game_random") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "word_game_random_grapheme") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "vocab") {
                        $icount++;
                    } else if ($val->type == "vocabrandom") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "vocabconceptrandom") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "story") {
                        $sql1 = "SELECT count(*) AS icount FROM story_page_table WHERE story_id = '" . $val->type_id . "';";
                        $cursor1 = User::find_by_sql( $sql1 );
                        if (isset($cursor1[0])) {
                            $icount += $val->icount + 2;
                        }
                    } else if ($val->type == "rhymes") {
                        $icount++;
                    } else if ($val->type == "phrase") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "phrase_game") {
                        $icount++;
                    } else if ($val->type == "grammar") {
                        $icount++;
                    } else if ($val->type == "grammarrandom") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "grammarrandom_specific") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "spelling") {
                        $icount++;
                    } else if ($val->type == "reading_test") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "first_last_sound") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "first_last_sound_random") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "missing_letter") {
                        $icount++;
                    } else if ($val->type == "listen_to_a_sound") {
                        $icount++;
                    } else if ($val->type == "listen_to_a_sound_random") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "oddity_starts_with_grapheme") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    } else if ($val->type == "oddity_ends_with_grapheme") {
                        $koibe = json_decode($val->additional_info);
                        $icount += $koibe->count;
                    }
                }
            }
            return $icount;
        }

        function getHelpVideoTotalQuestionCount($help_video_id) {
            $total = 0;
            $sql = "SELECT COUNT(mg_help_video_question_linkage.question_id) AS icount FROM mg_help_video_question_linkage, mg_question WHERE mg_help_video_question_linkage.question_id = mg_question.id AND mg_help_video_question_linkage.help_video_id = '" . $help_video_id . "' AND mg_question.status = 'active';";
            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                $total = $cursor[0]->icount;
            }
            return $total;
        }

        function getHelpVideoQuestionDetailsAll($help_video_id, $start) {
            $sql = "SELECT mg_question.id, mg_help_video_question_linkage.order_number, mg_question.title, mg_question.question  FROM mg_help_video_question_linkage, mg_question WHERE mg_help_video_question_linkage.question_id = mg_question.id AND mg_help_video_question_linkage.help_video_id = '" . $help_video_id . "' AND mg_question.status = 'active' ORDER BY mg_help_video_question_linkage.order_number LIMIT " . $start . ",1;";
            $storyDetails = array();
            $storyDetailsCursor = User::find_by_sql( $sql );
            if (isset($storyDetailsCursor[0])) {
                $hashMap = array();
                $hashMap["questionId"] = $storyDetailsCursor[0]->id;
                $hashMap["help_video_id"] = $help_video_id;
                $hashMap["storypageId"] = '';
                $hashMap["orderNumber"] = $storyDetailsCursor[0]->order_number;
                $hashMap["title"] = $storyDetailsCursor[0]->title;
                $hashMap["question"] = $storyDetailsCursor[0]->question;

                $jsonObject = json_decode($storyDetailsCursor[0]->question);
                $questionType = $jsonObject->question_type;
                $hashMap["questionType"] = $questionType;

                if ($questionType == "mcq_single_answer" || $questionType == "mcq_multiple_answer") {
                    $optionsArray = $jsonObject->options;
                    $optionAnswerStatus = array();
                    $optionSelectStatus = array();
                    for ($ii = 0; $ii < count($optionsArray); $ii++) {
                        $optionSelectStatus[] = -1;
                        $optionAnswerStatus[] = -1;
                    }
                    $suffleIndexList = $this->getRandomSuffleIndex(count($optionsArray) - 1 );
                    $hashMap["suffleIndexList"] = $suffleIndexList;
                    $hashMap["optionSelectStatus"] = $optionSelectStatus;
                    $hashMap["optionAnswerStatus"] = $optionAnswerStatus;
                    $hashMap["isFirstClick"] = true;
                    $hashMap["isCorrect"] = false;
                }

                $storyDetails[] = $hashMap;
            }
            return $storyDetails;
        }

        function getHelpVideoActivity($help_video_id) {
            $hashMapArrayList = array();

            $sql = "SELECT mg_help_activity.* FROM mg_help_video_activity_linkage,mg_help_activity  WHERE mg_help_activity.id = mg_help_video_activity_linkage.help_activity_id AND ( mg_help_activity.delete_flag = 0 OR mg_help_activity.delete_flag IS NULL ) AND mg_help_video_activity_linkage.help_video_id = '" . $help_video_id . "' AND mg_help_video_activity_linkage.order_number = '1';";

            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                $hashMapArrayList = $cursor[0];
            }
            return $hashMapArrayList;
        }


        function getHelpVideoActivityLinkageData($help_video_id, $order_number) {
            $sql = "SELECT mg_help_activity_linkage.* FROM mg_help_activity_linkage,mg_help_activity, mg_help_video_activity_linkage  WHERE mg_help_activity.id = mg_help_activity_linkage.help_activity_id AND mg_help_video_activity_linkage.help_activity_id = mg_help_activity.id AND ( mg_help_activity.delete_flag = 0 OR mg_help_activity.delete_flag IS NULL ) AND mg_help_video_activity_linkage.help_video_id = '" . $help_video_id . "' AND mg_help_video_activity_linkage.order_number = '" . $order_number . "' ORDER BY mg_help_activity_linkage.order_num ASC;";

            $acl = array();
            $cursor = User::find_by_sql( $sql );
            if (isset($cursor[0])) {
                foreach($cursor as $val) {
                    if ($val->type == "learn_letter") {
                        $acl[] = $val->id;
                    } else if ($val->type == "learn_grapheme") {
                        $acl[] = $val->id;
                    } else if ($val->type == "trace_grapheme") {
                        $acl[] = $val->id;
                    } else if ($val->type == "local_language_blend") {
                        $acl[] = $val->id;
                    } else if ($val->type == "vowel_blend") {
                        $acl[] = $val->id;
                    } else if ($val->type == "vowel_blend_trace") {
                        $acl[] = $val->id;
                    } else if ($val->type == "segmenting_blending") {
                        $acl[] = $val->id;
                    } else if ($val->type == "segmenting_blending_random") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "word_game") {
                        $acl[] = $val->id;
                    } else if ($val->type == "word_game_random") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "word_game_random_grapheme") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "vocab") {
                        $acl[] = $val->id;
                    } else if ($val->type == "vocabrandom") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "vocabconceptrandom") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "story") {
                        $acl[] = $val->id;
                    } else if ($val->type == "rhymes") {
                        $acl[] = $val->id;
                    } else if ($val->type == "phrase") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "phrase_game") {
                        $acl[] = $val->id;
                    } else if ($val->type == "grammar") {
                        $acl[] = $val->id;
                    } else if ($val->type == "grammarrandom") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "grammarrandom_specific") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "spelling") {
                        $acl[] = $val->id;
                    } else if ($val->type == "reading_test") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "first_last_sound") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "first_last_sound_random") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "missing_letter") {
                        $acl[] = $val->id;
                    } else if ($val->type == "listen_to_a_sound") {
                        $acl[] = $val->id;
                    } else if ($val->type == "listen_to_a_sound_random") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "oddity_starts_with_grapheme") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    } else if ($val->type == "oddity_ends_with_grapheme") {
                        $koibe = json_decode($val->additional_info);
                        for($ii = 0 ; $ii < $koibe->count ; $ii++) {
                            $acl[] = $val->id;
                        }
                    }
                }
            }

            $sql = "SELECT mg_question.id  FROM mg_help_video_question_linkage, mg_question WHERE mg_help_video_question_linkage.question_id = mg_question.id AND mg_help_video_question_linkage.help_video_id = '" . $help_video_id . "' AND mg_question.status = 'active' ORDER BY mg_help_video_question_linkage.order_number;";

            $cursor1 = User::find_by_sql( $sql );
            if (isset($cursor1[0])) {
                foreach($cursor1 as $val) {
                    $acl[] = $val->id;
                }
            }
            return $acl;
        }



        //! API for Samagra
        function authenticateuser() {
            $username = @$_REQUEST['username'];
            $password = @$_REQUEST['password'];
            $password_md5 = md5($password);
            $mobile = @$_REQUEST['mobile'];

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            if($username == '' || $password == '') {
                $response->message = "Invalid data passed!";
                die(json_encode($response));
            }

            //! Check the email and password
            $euser = User::find("all",array(
                "conditions" => " (email = '$username' OR username = '$username' ) AND password = '$password_md5' "
            ));

            //! if valid username and password
            if(isset($euser[0])) {
                $response->success = true;
                $token = md5(date("U") . $username) . md5($euser[0]->id) . md5(date("Y-m-d H:i:s") . $password_md5);
                $response->token = $token;
                $response->message = "Token Generated.";

                $euser[0]->last_login =mdate("%Y-%m-%d %H:%i:%s");
                $euser[0]->login_count = $euser[0]->login_count + 1;
                $euser[0]->save();

                die(json_encode($response));
            }

            //! Check the username
            $euser = User::find("all",array(
                "conditions" => " (email = '$username' OR username = '$username' ) "
            ));

            //! if valid username but wrong password
            if(isset($euser[0])) {
                $response->message = "Invalid username / password.";
                die(json_encode($response));
            }

            //! Add data to user table
            $new_user = User::create(array(
                'email' => '',
                'username' => $username,
                'password' => md5($password),
                'mobile' => $mobile,
                'status' => 'active',
                'unique_id' => md5(date("Y-m-d H:i:s") . $username),
                'password_verification_code' => '',
                'email_verification_code' => md5(date("Y-m-d H:i:s"). "email_verification_code" . $username),
                'mobile_verification_code' => rand(100000,999999),
                'email_verified' => 0,
                'mobile_verified' => 0,
                'admin' => 0,
                'samagra_flag' => 1,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s"),
            ));

            if(isset($new_user->id)) {

                //! Add data to profile table
                $new_user_profile = Profile::create(array(
                    'user_id' => $new_user->id,
                    'title' => '',
                    'first_name' => $username,
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
                    'current_class' => '',
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

                $new_user->last_login = mdate("%Y-%m-%d %H:%i:%s");
                $new_user->login_count = $new_user->login_count + 1;
                $new_user->save();

                $response->success = true;
                $token = md5(date("U") . $username) . md5($new_user->id) . md5(date("Y-m-d H:i:s") . $password_md5);
                $response->token = $token;
                $response->message = "Token Generated.";
                die(json_encode($response));
            }

            $response->message = "Invalid data passed!";
            die(json_encode($response));
        }

        function ssotoken($token = '', $param1 = '' , $param2 = '', $param3 = '', $param4 = '') {

            if($token == '') {
                //redirect('login');
                echo "Invalid Token";
                die;
            }

            $code = substr($token,32,32);

            //! Check the username
            $euser = User::find("all",array(
                "conditions" => " md5(id) = '$code' "
            ));

            if(isset($euser[0])) {
                $this->session->set_userdata(array(
                    '_user_id'        =>  $euser[0]->id,
                    '_user_email'     =>  $euser[0]->email,
                    '_username'       =>  $euser[0]->username,
                    '_totalmango'     =>  $this->getUserTotalMango($euser[0]),
                ));

                if($param4 != '') {
                    redirect($param1.'/'.$param2.'/'.$param3.'/'.$param4);
                    die;
                }
                if($param3 != '') {
                    redirect($param1.'/'.$param2.'/'.$param3);
                    die;
                }
                if($param2 != '') {
                    redirect($param1.'/'.$param2);
                    die;
                }
                if($param1 != '') {
                    redirect($param1);
                    die;
                }

                redirect('stories/books');
                die;
            } else {
                redirect('login');
                die;
            }

        }
       
         //! API for Samagra
        function studetrecord() {
            $username = @$_REQUEST['username'];
            $token = @$_REQUEST['token'];

            //! initiate the response
            $response = new stdClass;
            $response->success = false;

            if($username == '' || $token == '') {
                $response->message = "Invalid data passed!";
                die(json_encode($response));
            }

            if($token != "25afa44727cf331ac9ac5655a2bcbaca") {
                $response->message = "Invalid token passed!";
                die(json_encode($response));
            }

            //! Check the email and password
            $euser = User::find("all",array(
                //"conditions" => " email = '$username' "
                "conditions" => " ( email = '$username' OR username = '$username' ) AND samagra_flag = 1 "
            ));

            //! if valid username and password
            if(isset($euser[0])) {
                $response->success = true;
                $response->message = "Student record";

                $response->last_visit_date = $euser[0]->last_login->format("d/m/Y");
                $response->number_visit = $euser[0]->login_count;
                $response->mobile = $euser[0]->mobile;
                $response->current_class = @$euser[0]->profile->current_class;
                $response->school_name = @$euser[0]->profile->school->name;

                $report_card = $this->getUserReportCard($euser[0]->id);

                $tot1 = 0;
                $tot2 = 0;
                foreach($report_card as $val) {
                    $tot1 += $val['score'];
                    $tot2 += $val['points'];
                }

                $percentage = ( $tot1 * 100 ) / $tot2;
                $percentage = number_format($percentage);

                $response->report_card = (int)$percentage;

                unset($report_card);

                $activity = $this->getUserRecentActivity($euser[0]->id);

                $activities = array();
                foreach($activity as $val1) {
                    foreach($val1 as $val) {
                        $act = array();
                        $act['date'] = $val['formatted_date'];
                        $act['activity'] = $val['activityname'];
                        $act['level'] = $val['levelname'];
                        $act['category'] = $val['category'];
                        if($val['points'] == 0) {
                            $act['score'] = 100;
                        } else {
                            $percentage = ( (int)$val['score'] * 100 ) / (int)$val['points'];
                            $percentage = number_format($percentage);
                            $act['score'] = (int)$percentage;
                        }
                        $activities[] = $act;
                    }
                }

                $response->recent_activity = $activities;

                unset($activity);

                $wordsss = $this->getUserProfileWords($euser[0]->id);

                $words = array();

                foreach($wordsss as $val) {
                    $words[] = $val->word;
                }

                $response->words_learned = $words;

                unset($wordsss);

                die(json_encode($response));
            }

            $response->message = "Invalid username!";
            die(json_encode($response));
        }
    }
?>