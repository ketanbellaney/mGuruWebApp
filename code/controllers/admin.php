<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    /*
	Class name  : Admin
	Description : Admin operations functionality
	*/
    class Admin extends MG_Controller {

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
    	Function name   : adduser()
    	Parameter       : $error - int - Stores error no. if any default is 0
    	Return          : none
    	Description     : Add new user
    	*/
        function adduser($error = 0) {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['error'] = $error;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('first_name','First Name', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Add User";
                $this->loadtemplate("admin/adduser",$header,$body,$footer);
            } else {
                //! Else create a new user process
                $error = 1;

                //! Add data to user table
                $new_user = User::create(array(
                    'email' => $this->input->post('email'),
                    'username' => $this->input->post('username'),
                    'password' => md5($this->input->post('password')),
                    'mobile' => $this->input->post('mobile'),
                    'status' => $this->input->post('status'),
                    'unique_id' => md5(date("Y-m-d H:i:s") . $this->input->post('email')),
                    'password_verification_code' => '',
                    'email_verification_code' => md5(date("Y-m-d H:i:s"). "email_verification_code" . $this->input->post('email')),
                    'mobile_verification_code' => rand(100000,999999),
                    'email_verified' => 0,
                    'mobile_verified' => 0,
                    'admin' => 0,
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                ));

                if(isset($new_user->id)) {
                    //! Setting school data
                    $school_id = '';
                    if($_REQUEST['school_name'] != '') {
                        //! Check if the school exists
                        $check_school = School::find_by_name($this->input->post('school_name'));
                        if(isset($check_school->id)) {
                            $school_id = $check_school->id;
                        } else {
                            //! Create a new school record
                            $new_school = School::create(array(
                                'name' => $this->input->post('school_name'),
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

                    //! Add data to profile table
                    $new_user_profile = Profile::create(array(
                        'user_id' => $new_user->id,
                        'title' => $this->input->post('title'),
                        'first_name' => $this->input->post('first_name'),
                        'last_name' => $this->input->post('last_name'),
                        'display_name' => $this->input->post('display_name'),
                        'profile_picture' => '',
                        'date_of_birth' => $this->input->post('date_of_birth'),
                        'school_id' => $school_id,
                        'examination_board' => $this->input->post('examination_board'),
                        'teacher_name' => $this->input->post('teacher_name'),
                        'father_name' => $this->input->post('father_name'),
                        'mother_name' => $this->input->post('mother_name'),
                        'gender' => $this->input->post('gender'),
                        'current_class' => $this->input->post('current_class'),
                        'caste_religion' => $this->input->post('caste_religion'),
                        'language_at_home' => $this->input->post('language_at_home'),
                        'address_line_1' => $this->input->post('address_line_1'),
                        'address_line_2' => $this->input->post('address_line_2'),
                        'city' => $this->input->post('city'),
                        'state' => $this->input->post('state'),
                        'pincode' => $this->input->post('pincode'),
                        'country' => $this->input->post('country'),
                        'created' => date("Y-m-d H:i:s"),
                        'updated' => date("Y-m-d H:i:s"),
                    ));
                    $error = 2;
                }

                //! Redirect to add user page
                redirect('admin/adduser/' . $error);
            }
        }

        /*
    	Function name   : viewuser()
    	Parameter       : $page - int - Stores the page no. if any, default is 0
                          $error - int - Stores error no. if any, default is 0
    	Return          : none
    	Description     : View user list
    	*/
        function viewuser($page = 0,$error = 0) {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['page'] = $page;
            $body['error'] = $error;
            $footer['user'] = $this->user;
            $header['title'] = "View User";

            //! Display the list
            $this->loadtemplate("admin/viewuser",$header,$body,$footer);
        }

        /*
    	Function name   : edituser()
    	Parameter       : $user_id - int - user id to be edited
    	Return          : none
    	Description     : edit user data
    	*/
        function edituser($user_id = 0) {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! check if user_id is valid
            if($user_id == 0 || $user_id == '') {
                redirect("admin/viewuser");
                die();
            }

            //! Setting page data
            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $user1 = User::find($user_id);
            $body['user1'] = $user1;
            $body['user_id'] = $user_id;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('first_name','First Name', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Edit User";
                $this->loadtemplate("admin/edituser",$header,$body,$footer);
            } else {
                //! Else update hthe user data
                $error = 1;

                //! Edit data in user table
                $user1->email = $this->input->post('email');
                $user1->username = $this->input->post('username');
                $user1->mobile = $this->input->post('mobile');
                $user1->status = $this->input->post('status');
                $user1->updated = date("Y-m-d H:i:s");
                $user1->save();

                $school_id = $user1->profile->school_id;

                if($_REQUEST['school_name'] != '') {
                    //! Scheck if the school exisits
                    $check_school = School::find_by_name($this->input->post('school_name'));
                    if(isset($check_school->id)) {
                        $school_id = $check_school->id;
                    } else {
                        //! Create a new school record
                        $new_school = School::create(array(
                            'name' => $this->input->post('school_name'),
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
                } else {
                    $school_id = '';
                }

                //! Edit data in profile table
                $user1->profile->title = $this->input->post('title');
                $user1->profile->first_name = $this->input->post('first_name');
                $user1->profile->last_name = $this->input->post('last_name');
                $user1->profile->display_name = $this->input->post('display_name');
                $user1->profile->date_of_birth = $this->input->post('date_of_birth');
                $user1->profile->school_id = $school_id;
                $user1->profile->examination_board = $this->input->post('examination_board');
                $user1->profile->teacher_name = $this->input->post('teacher_name');
                $user1->profile->father_name = $this->input->post('father_name');
                $user1->profile->mother_name = $this->input->post('mother_name');
                $user1->profile->gender = $this->input->post('gender');
                $user1->profile->current_class = $this->input->post('current_class');
                $user1->profile->caste_religion = $this->input->post('caste_religion');
                $user1->profile->language_at_home = $this->input->post('language_at_home');
                $user1->profile->address_line_1 = $this->input->post('address_line_1');
                $user1->profile->address_line_2 = $this->input->post('address_line_2');
                $user1->profile->city = $this->input->post('city');
                $user1->profile->state = $this->input->post('state');
                $user1->profile->pincode = $this->input->post('pincode');
                $user1->profile->country = $this->input->post('country');
                $user1->profile->updated = date("Y-m-d H:i:s");
                $user1->profile->save();

                //! Redirect to view user page
                redirect('admin/viewuser/0/1');
            }
        }

        function addclass($error = 0) {
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            if($this->user->admin != 1) {
                redirect();
                die();
            }

            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['error'] = $error;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('name','Class', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $header['title'] = "Add class";
                $this->loadtemplate("admin/addclass",$header,$body,$footer);
            } else {
                $error = 2;
                $new_class = Classes::create(array(
                    'name' => $this->input->post('name'),
                    'status' => $this->input->post('status'),
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                ));

                redirect('admin/addclass/' . $error);
            }
        }

        function viewclass($page = 0,$error = 0) {
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            if($this->user->admin != 1) {
                redirect();
                die();
            }

            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['page'] = $page;
            $body['error'] = $error;
            $footer['user'] = $this->user;
            $header['title'] = "View Class";
            $this->loadtemplate("admin/viewclass",$header,$body,$footer);
        }

        function editclass($class_id = 0) {
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            if($this->user->admin != 1) {
                redirect();
                die();
            }

            if($class_id == 0 || $class_id == '') {
                redirect("admin/viewclass");
                die();
            }

            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $class = Classes::find($class_id);
            $body['class'] = $class;
            $body['class_id'] = $class_id;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('name','Class Name', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $header['title'] = "Edit Class";
                $this->loadtemplate("admin/editclass",$header,$body,$footer);
            } else {
                $error = 1;
                $class->name = $this->input->post('name');
                $class->status = $this->input->post('status');
                $class->updated = date("Y-m-d H:i:s");
                $class->save();

                redirect('admin/viewclass/0/1');
            }
        }

        function addsubject($error = 0) {
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            if($this->user->admin != 1) {
                redirect();
                die();
            }

            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['error'] = $error;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('name','Subject', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $body['classes'] = Classes::find("all");
                $header['title'] = "Add subject";
                $this->loadtemplate("admin/addsubject",$header,$body,$footer);
            } else {
                $error = 1;
                $new_sub = Subject::create(array(
                    'name' => $this->input->post('name'),
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                ));

                if(isset($new_sub->id)) {
                    $error = 2;
                    for($ii = 0 ; $ii < count($_REQUEST['classes']) ; $ii++) {
                        if( @$_REQUEST['classes'][$ii] != '' ) {
                            $linkage = ClassSubjectLinkage::create(array(
                                'classes_id' => @$_REQUEST['classes'][$ii],
                                'subject_id' => $new_sub->id,
                                'status' => @$_REQUEST['status'][$ii],
                            ));
                        }
                    }
                }

                redirect('admin/addsubject/' . $error);
            }
        }

        function viewsubject($page = 0,$error = 0) {
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            if($this->user->admin != 1) {
                redirect();
                die();
            }

            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['page'] = $page;
            $body['error'] = $error;
            $footer['user'] = $this->user;
            $header['title'] = "View Subject";
            $this->loadtemplate("admin/viewsubject",$header,$body,$footer);
        }

        function editsubject($subject_id = 0) {
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            if($this->user->admin != 1) {
                redirect();
                die();
            }

            if($subject_id == 0 || $subject_id == '') {
                redirect("admin/viewsubject");
                die();
            }

            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $subject = Subject::find($subject_id);
            $body['subject'] = $subject;
            $body['subject_id'] = $subject_id;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('name','Subject', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $body['classes'] = Classes::find("all");
                $header['title'] = "Edit Subject";
                $this->loadtemplate("admin/editsubject",$header,$body,$footer);
            } else {
                $error = 1;
                $subject->name = $this->input->post('name');
                $subject->updated = date("Y-m-d H:i:s");
                $subject->save();

                ClassSubjectLinkage::delete_all(array(
				    'conditions' => array(
					    'subject_id' => $subject->id,
					)
				));

                for($ii = 0 ; $ii < count($_REQUEST['classes']) ; $ii++) {
                    if( @$_REQUEST['classes'][$ii] != '' ) {
                        $linkage = ClassSubjectLinkage::create(array(
                            'classes_id' => @$_REQUEST['classes'][$ii],
                            'subject_id' => $subject->id,
                            'status' => @$_REQUEST['status'][$ii],
                        ));
                    }
                }

                redirect('admin/viewsubject/0/1');
            }
        }

        function addunits($error = 0) {
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            if($this->user->admin != 1) {
                redirect();
                die();
            }

            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['error'] = $error;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('name','Unit', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $body['classes'] = Classes::find("all");
                $body['subjects'] = Subject::find("all");
                $header['title'] = "Add units";
                $this->loadtemplate("admin/addunits",$header,$body,$footer);
            } else {
                $error = 1;
                if($this->input->post('classes_id') != '' && $this->input->post('subject_id') != '' && $this->input->post('status') != '') {
                    $new_unit = Units::create(array(
                        'name' => $this->input->post('name'),
                        'classes_id' => $this->input->post('classes_id'),
                        'subject_id' => $this->input->post('subject_id'),
                        'status' => $this->input->post('status'),
                        'examination_board' => $this->input->post('examination_board'),
                        'created' => date("Y-m-d H:i:s"),
                        'updated' => date("Y-m-d H:i:s"),
                    ));
                    $error = 2;
                }


                redirect('admin/addunits/' . $error);
            }
        }

        function viewunits($page = 0,$error = 0) {
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            if($this->user->admin != 1) {
                redirect();
                die();
            }

            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['page'] = $page;
            $body['error'] = $error;
            $footer['user'] = $this->user;
            $header['title'] = "View Units";
            $this->loadtemplate("admin/viewunits",$header,$body,$footer);
        }

        function editunits($unit_id = 0) {
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            if($this->user->admin != 1) {
                redirect();
                die();
            }

            if($unit_id == 0 || $unit_id == '') {
                redirect("admin/viewunits");
                die();
            }

            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $units = Units::find($unit_id);
            $body['units'] = $units;
            $body['unit_id'] = $unit_id;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('name','Unit', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $body['classes'] = Classes::find("all");
                $body['subjects'] = Subject::find("all");
                $header['title'] = "Edit Units";
                $this->loadtemplate("admin/editunits",$header,$body,$footer);
            } else {
                $error = 1;
                if($this->input->post('classes_id') != '' && $this->input->post('subject_id') != '' && $this->input->post('status') != '') {
                    $units->name = $this->input->post('name');
                    $units->classes_id = $this->input->post('classes_id');
                    $units->subject_id = $this->input->post('subject_id');
                    $units->status = $this->input->post('status');
                    $units->examination_board = $this->input->post('examination_board');
                    $units->updated = date("Y-m-d H:i:s");
                    $units->save();
                }

                redirect('admin/viewunits/0/1');
            }
        }

        function addconcept($error = 0) {
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            if($this->user->admin != 1) {
                redirect();
                die();
            }

            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['error'] = $error;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('name','Concept', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $body['units'] = Units::find("all");
                $body['concepts'] = Concept::find("all");
                $header['title'] = "Add Concept";
                $this->loadtemplate("admin/addconcept",$header,$body,$footer);
            } else {
                $error = 1;
                if($this->input->post('units_id') != '' ) {
                    $new_concept = Concept::create(array(
                        'name' => $this->input->post('name'),
                        'units_id' => $this->input->post('units_id'),
                        'next_concept_id' => $this->input->post('next_concept_id'),
                        'previous_concept_id' => $this->input->post('next_concept_id'),
                        'lower_concept_id' => $this->input->post('lower_concept_id'),
                        'higher_concept_id' => $this->input->post('higher_concept_id'),
                        'status' => $this->input->post('status'),
                        'created' => date("Y-m-d H:i:s"),
                        'updated' => date("Y-m-d H:i:s"),
                    ));

                    $error = 2;
                }

                if(@$_REQUEST['for'] == "grammar") {
                    redirect('admin/addconcept/' . $error . "?for=grammar" );
                } else {
                    redirect('admin/addconcept/' . $error);
                }
            }
        }

        function viewconcept($page = 0,$error = 0) {
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            if($this->user->admin != 1) {
                redirect();
                die();
            }

            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['page'] = $page;
            $body['error'] = $error;
            $footer['user'] = $this->user;
            $header['title'] = "View Concept";
            $this->loadtemplate("admin/viewconcept",$header,$body,$footer);
        }

        function editconcept($concept_id = 0) {
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            if($this->user->admin != 1) {
                redirect();
                die();
            }

            if($concept_id == 0 || $concept_id == '') {
                redirect("admin/viewconcept");
                die();
            }

            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $concept = Concept::find($concept_id);
            $body['concept'] = $concept;
            $body['concept_id'] = $concept_id;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('name','Concept', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $body['units'] = Units::find("all");
                $body['concepts'] = Concept::find("all",array("conditions" => " id != '".$concept_id."' " ));
                $header['title'] = "Edit Concept";
                $this->loadtemplate("admin/editconcept",$header,$body,$footer);
            } else {
                $error = 1;
                if($this->input->post('units_id') != '' ) {
                    $concept->name = $this->input->post('name');
                    $concept->units_id = $this->input->post('units_id');
                    $concept->next_concept_id = $this->input->post('next_concept_id');
                    $concept->previous_concept_id = $this->input->post('previous_concept_id');
                    $concept->lower_concept_id = $this->input->post('lower_concept_id');
                    $concept->higher_concept_id = $this->input->post('higher_concept_id');
                    $concept->status = $this->input->post('status');
                    $concept->updated = date("Y-m-d H:i:s");
                    $concept->save();
                }
                if(@$_REQUEST['for'] == "grammar") {
                    redirect('admin/viewconcept/0/1?for=grammar');
                } else {
                    redirect('admin/viewconcept/0/1');
                }
            }
        }

        /*
    	Function name   : addquestion()
    	Parameter       : $error - int - Stores error no. if any default is 0
    	Return          : none
    	Description     : Add new question
    	*/
        function addquestion($error = 0, $story_id = 0, $helpvideo_id = 0) {
            //! Include maths template
            $this->load->library('mathtemplate');

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin or intern
            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['error'] = $error;
            $body['story_id'] = $story_id;
            $body['helpvideo_id'] = $helpvideo_id;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('title','Question Title', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Add Question";
                $body['concepts'] = Concept::find("all");
                $body['questiontemplate'] = QuestionTemplate::find("all");
                $this->loadtemplate("admin/addquestion",$header,$body,$footer);
            } else {
                if($story_id != 0 && $story_id != '') {
                    //! Get the story Details
                    $temp = Story::find($story_id);
                    if(isset($temp->id)) {
                        $story = $temp;
                    }
                }

                if($helpvideo_id != 0 && $helpvideo_id != '') {
                    $temp = HelpVideo::find($helpvideo_id);
                    if(isset($temp->id)) {
                        $helpvideo = $temp;
                    }
                }


                //! Else create a new user process
                $error = 1;

                $question = '';
                if($this->input->post('meta_type') == 'template') {
                    $question = $this->input->post('question_template');
                } else {
                    //! Creating question json object
                    $question_obj = new stdClass;
                    $question_obj->question_type = $this->input->post('question_type');

                    //! Question Part
                    $question_obj->question = new stdClass;
                    $question_obj->question->text = $this->input->post('question_text');
                    $question_obj->question->image = '';
                    $question_obj->question->type = '';

                    //! Question Image upload
                    if($_FILES["question_image"]["name"] != '') {
                        $question_obj->question->image = $this->upload_image('question_image', "question/");
                    }

                    if($question_obj->question->text != '' && $question_obj->question->image != '') {
                        $question_obj->question->type = 'both';
                    } else if($question_obj->question->text == '' && $question_obj->question->image != '') {
                        $question_obj->question->type = 'image';
                    } else if($question_obj->question->text != '' && $question_obj->question->image == '') {
                        $question_obj->question->type = 'text';
                    }

                    //! Question types
                    if($this->input->post('question_type') == 'mcq_single_answer' || $this->input->post('question_type') == 'mcq_multiple_answer') {
                        //! For MCQ type of questions
                        $question_obj->options = array();
                        $question_obj->answers = array();
                        for($ii = 1 ; $ii <= 5 ; $ii++) {
                            if( $this->input->post('option_' . $ii) != '' || $_FILES["option_image_" . $ii]["name"] != '' ) {

                                $option = new stdClass;
                                $option->text = $this->input->post('option_' . $ii);
                                $option->type = '';
                                $option->image = '';
                                $option->ans = 0;
                                if($_FILES["option_image_" . $ii]["name"] != '') {
                                    $option->image = $this->upload_image("option_image_" . $ii, "question/");
                                }

                                if($option->text != '' && $option->image != '') {
                                    $option->type = 'both';
                                    if(isset($_REQUEST['option_ans_' . $ii])) {
                                        $question_obj->answers[] = $option->text;
                                        $option->ans = 1;
                                    }
                                } else if($option->text == '' && $option->image != '') {
                                    $option->type = 'image';
                                    if(isset($_REQUEST['option_ans_' . $ii])) {
                                        $question_obj->answers[] = $option->image;
                                        $option->ans = 1;
                                    }
                                } else if($option->text != '' && $option->image == '') {
                                    $option->type = 'text';
                                    if(isset($_REQUEST['option_ans_' . $ii])) {
                                        $question_obj->answers[] = $option->text;
                                        $option->ans = 1;
                                    }
                                }
                                $question_obj->options[] = $option;
                            }
                        }
                    } else if($this->input->post('question_type') == 'fill_blank' || $this->input->post('question_type') == 'record_missing_word') {
                        //! For Fill in the blank type of questions
                        $question_obj->answers = array();
                        for($ii = 1 ; $ii <= 5 ; $ii++) {
                            if( $this->input->post('ans_' . $ii) != '' ) {
                                $question_obj->answers[] = $this->input->post('ans_' . $ii);
                            }
                        }
                    } else if($this->input->post('question_type') == 'match_column') {
                        //! For match the column type of questions
                        $question_obj->column1 = array();
                        $question_obj->column2 = array();
                        for($ii = 1 ; $ii <= 5 ; $ii++) {
                            if( $this->input->post('c1_text_' . $ii) != '' || $this->input->post('c1_image_' . $ii) != '' || $this->input->post('c2_text_' . $ii) != '' || $this->input->post('c2_image_' . $ii) != '') {
                                $column1 = new stdClass;
                                $column2 = new stdClass;

                                $column1->text = $this->input->post('c1_text_' . $ii);
                                $column2->text = $this->input->post('c2_text_' . $ii);

                                $column1->type = '';
                                $column2->type = '';

                                $column1->image = '';
                                $column2->image = '';

                                $column1->match = $ii;
                                $column2->match = $ii;

                                if($_FILES["c1_image_" . $ii]["name"] != '') {
                                    $column1->image = $this->upload_image("c1_image_" . $ii, "question/");
                                }
                                if($_FILES["c2_image_" . $ii]["name"] != '') {
                                    $column2->image = $this->upload_image("c2_image_" . $ii, "question/");
                                }

                                if($column1->text != '' && $column1->image != '') {
                                    $column1->type = 'both';
                                } else if($column1->text == '' && $column1->image != '') {
                                    $column1->type = 'image';
                                } else if($column1->text != '' && $column1->image == '') {
                                    $column1->type = 'text';
                                }
                                if($column2->text != '' && $column2->image != '') {
                                    $column2->type = 'both';
                                } else if($column2->text == '' && $column2->image != '') {
                                    $column2->type = 'image';
                                } else if($column2->text != '' && $column2->image == '') {
                                    $column2->type = 'text';
                                }

                                $question_obj->column1[] = $column1;
                                $question_obj->column2[] = $column2;
                            }
                        }
                    } else if($this->input->post('question_type') == 'vocabulary') {
                        //! For words
                        $question_obj->words = array();
                        for($ii = 1 ; $ii <= 5 ; $ii++) {
                            if( $this->input->post('vocab_word_' . $ii) != '' ) {

                                $word = new stdClass;
                                $word->word = $this->input->post('vocab_word_' . $ii);
                                $word->image = '';
                                if($_FILES["vocab_image_" . $ii]["name"] != '') {
                                    $word->image = $this->upload_image("vocab_image_" . $ii, "question/");
                                }
                                $question_obj->words[] = $word;
                            }
                        }
                    } else if($this->input->post('question_type') == 'conversation') {
                        //! For conversation
                        $question_obj->conversation = array();
                        for($ii = 1 ; $ii <= 10 ; $ii++) {
                            if( $this->input->post('sentence_' . $ii) != '' ) {

                                $conversation = new stdClass;
                                $conversation->sentence = $this->input->post('sentence_' . $ii);
                                $conversation->image = '';
                                $conversation->question = 0;
                                if(isset($_REQUEST['sentence_question_' . $ii])) {
                                    $conversation->question = 1;
                                }
                                if($_FILES["sentence_image_" . $ii]["name"] != '') {
                                    $conversation->image = $this->upload_image("sentence_image_" . $ii, "question/");
                                }
                                $question_obj->conversation[] = $conversation;
                            }
                        }
                    } else if($this->input->post('question_type') == 'make_the_sentence') {
                        //! For MCQ type of questions
                        $question_obj->wrong_options = $this->input->post('wrong_options');
                    } else if($this->input->post('question_type') == 'correct_the_sentence') {
                        //! For MCQ type of questions
                        $question_obj->wrong_answer = $this->input->post('cts_wrong_answer');
                        $question_obj->correct_answer = $this->input->post('cts_correct_answer');
                    }


                    $question = json_encode($question_obj);
                }

                //! Add data to question table
                $new_question = Question::create(array(
                    'title' => $this->input->post('title'),
                    'meta_type' => $this->input->post('meta_type'),
                    'question' => $question,
                    'level' => $this->input->post('level'),
                    'score' => $this->input->post('score'),
                    'question_template_id' => $this->input->post('question_template_id'),
                    'added_by_id' => $this->user->id,
                    'updated_by_id' => $this->user->id,
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                ));

                if(isset($new_question->id)) {

                    for($mm = 0 ; $mm < count($_REQUEST['language_trans']) ; $mm++ ) {
                        if( @$_REQUEST['language_trans'][$mm] != '' ) {
                            $new_wt = QuestionTranslation::create(array(
                                'question_id' => $new_question->id,
                                'language_id' => @$_REQUEST['language_id'][$mm],
                                'translation' => @$_REQUEST['language_trans'][$mm],
                                'added_by_id' => $this->user->id,
                                'updated_by_id' => $this->user->id,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));
                        }
                    }

                    $error = 2;
                    if(isset($story)) {
                        $storypage_id = '';
                        if($this->input->post('type') == 'during') {
                            $storypage_id = $this->input->post('storypage_id');
                        }
                        //! Add data to story question linkage table
                        $story_question_linkage = StoryQuestionLinkage::create(array(
                            'story_id' => $story->id,
                            'question_id' => $new_question->id,
                            'type' => $this->input->post('type'),
                            'storypage_id' => $storypage_id,
                            'order_number' => $this->input->post('order_number'),
                            'level' => $this->input->post('level'),
                            'added_by_id' => $this->user->id,
                            'updated_by_id' => $this->user->id,
                            'created' => date("Y-m-d H:i:s"),
                            'updated' => date("Y-m-d H:i:s"),
                        ));
                    } else if(isset($helpvideo)) {
                        $help_video_question_linkage = HelpVideoQuestionLinkage::create(array(
                            'help_video_id' => $helpvideo->id,
                            'question_id' => $new_question->id,
                            'order_number' => $this->input->post('order_number'),
                            'added_by_id' => $this->user->id,
                            'updated_by_id' => $this->user->id,
                            'created' => date("Y-m-d H:i:s"),
                            'updated' => date("Y-m-d H:i:s"),
                        ));
                    } else {
                        for($ii = 0 ; $ii < count($_REQUEST['concepts']) ; $ii++) {
                            //! Add multiple concept
                            if( @$_REQUEST['concepts'][$ii] != '' ) {
                                $linkage = ConceptsQuestionLinkage::create(array(
                                    'concepts_id' => @$_REQUEST['concepts'][$ii],
                                    'question_id' => $new_question->id,
                                    'created' => date("Y-m-d H:i:s"),
                                    'updated' => date("Y-m-d H:i:s"),
                                ));
                            }
                        }
                    }
                }

                if(isset($story)) {
                    //! Redirect to story question page
                    redirect('content/storyquestions/' .$story->id . "/1");
                } else if(isset($helpvideo)) {
                    redirect('englishcontent/helpvideoquestions/' .$helpvideo->id . "/1");
                } else {
                    if(@$_REQUEST['for'] == "grammar") {
                        //! Redirect to add question page
                        redirect('admin/addquestion/' . $error . "?for=grammar");
                    } else {
                        //! Redirect to add question page
                        redirect('admin/addquestion/' . $error);
                    }
                }
            }
        }

        /*
    	Function name   : viewquestion()
    	Parameter       : $page - int - Stores the page no. if any, default is 0
                          $error - int - Stores error no. if any, default is 0
    	Return          : none
    	Description     : View question list
    	*/
        function viewquestion($page = 0,$error = 0) {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['page'] = $page;
            $body['error'] = $error;
            $footer['user'] = $this->user;
            $header['title'] = "View Question";

            //! Display the list
            $this->loadtemplate("admin/viewquestion",$header,$body,$footer);
        }

        /*
    	Function name   : editquestion()
    	Parameter       : $question_id - int - question id to be edited
    	Return          : none
    	Description     : edit question data
    	*/
        function editquestion($question_id = 0,$story_id = 0, $helpvideo_id = 0) {
            //! Include maths template
            $this->load->library('mathtemplate');

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            //! check if question_id is valid
            if($question_id == 0 || $question_id == '') {
                redirect("admin/viewquestion");
                die();
            }

            //! Setting page data
            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $questiondb = Question::find($question_id);
            $body['question'] = $questiondb;
            $body['question_id'] = $question_id;
            $body['story_id'] = $story_id;
            $body['helpvideo_id'] = $helpvideo_id;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('title','Question Title', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Edit Question";
                $body['concepts'] = Concept::find("all");
                $body['questiontemplate'] = QuestionTemplate::find("all");
                $this->loadtemplate("admin/editquestion",$header,$body,$footer);
            } else {
                if($story_id != 0 && $story_id != '') {
                    //! Get the story Details
                    $temp = Story::find($story_id);
                    if(isset($temp->id)) {
                        $story = $temp;
                    }
                }

                if($helpvideo_id != 0 && $helpvideo_id != '') {
                    $temp = HelpVideo::find($helpvideo_id);
                    if(isset($temp->id)) {
                        $helpvideo = $temp;
                    }
                }
                //! Else update the question data
                $error = 1;

                $question = '';
                if($this->input->post('meta_type') == 'template') {
                    $question = $this->input->post('question_template');
                } else {
                    $question_obj_db = @json_decode(@$questiondb->question);
                    //! Creating question json object
                    $question_obj = new stdClass;
                    $question_obj->question_type = $this->input->post('question_type');

                    //! Question Part
                    $question_obj->question = new stdClass;
                    $question_obj->question->text = $this->input->post('question_text');
                    $question_obj->question->image = @$question_obj_db->question->image;
                    $question_obj->question->type = '';

                    //! Question Image upload
                    if($_FILES["question_image"]["name"] != '') {
                        $question_obj->question->image = $this->upload_image('question_image', "question/");
                    }

                    if($question_obj->question->text != '' && $question_obj->question->image != '') {
                        $question_obj->question->type = 'both';
                    } else if($question_obj->question->text == '' && $question_obj->question->image != '') {
                        $question_obj->question->type = 'image';
                    } else if($question_obj->question->text != '' && $question_obj->question->image == '') {
                        $question_obj->question->type = 'text';
                    }

                    //! Question types
                    if($this->input->post('question_type') == 'mcq_single_answer' || $this->input->post('question_type') == 'mcq_multiple_answer') {
                        //! For MCQ type of questions
                        $question_obj->options = array();
                        $question_obj->answers = array();
                        for($ii = 1 ; $ii <= 5 ; $ii++) {
                            if( $this->input->post('option_' . $ii) != '' || $_FILES["option_image_" . $ii]["name"] != '' ) {
                                $iii = $ii - 1;
                                $option = new stdClass;
                                $option->text = $this->input->post('option_' . $ii);
                                $option->type = '';
                                $option->image = @$question_obj_db->options[$iii]->image;
                                $option->ans = 0;
                                if($_FILES["option_image_" . $ii]["name"] != '') {
                                    $option->image = $this->upload_image("option_image_" . $ii, "question/");
                                }

                                if($option->text != '' && $option->image != '') {
                                    $option->type = 'both';
                                    if(isset($_REQUEST['option_ans_' . $ii])) {
                                        $question_obj->answers[] = $option->text;
                                        $option->ans = 1;
                                    }
                                } else if($option->text == '' && $option->image != '') {
                                    $option->type = 'image';
                                    if(isset($_REQUEST['option_ans_' . $ii])) {
                                        $question_obj->answers[] = $option->image;
                                        $option->ans = 1;
                                    }
                                } else if($option->text != '' && $option->image == '') {
                                    $option->type = 'text';
                                    if(isset($_REQUEST['option_ans_' . $ii])) {
                                        $question_obj->answers[] = $option->text;
                                        $option->ans = 1;
                                    }
                                }
                                $question_obj->options[] = $option;
                            }
                        }
                    } else if($this->input->post('question_type') == 'fill_blank' || $this->input->post('question_type') == 'record_missing_word') {
                        //! For Fill in the blank type of questions
                        $question_obj->answers = array();
                        for($ii = 1 ; $ii <= 5 ; $ii++) {
                            if( $this->input->post('ans_' . $ii) != '' ) {
                                $question_obj->answers[] = $this->input->post('ans_' . $ii);
                            }
                        }
                    } else if($this->input->post('question_type') == 'match_column') {
                        //! For match the column type of questions
                        $question_obj->column1 = array();
                        $question_obj->column2 = array();
                        for($ii = 1 ; $ii <= 5 ; $ii++) {
                            $iii = $ii - 1;
                            if( $this->input->post('c1_text_' . $ii) != '' || $this->input->post('c1_image_' . $ii) != '' || $this->input->post('c2_text_' . $ii) != '' || $this->input->post('c2_image_' . $ii) != '') {
                                $column1 = new stdClass;
                                $column2 = new stdClass;

                                $column1->text = $this->input->post('c1_text_' . $ii);
                                $column2->text = $this->input->post('c2_text_' . $ii);

                                $column1->type = '';
                                $column2->type = '';

                                $column1->image = @$question_obj_db->column1[$iii]->image;
                                $column2->image = @$question_obj_db->column2[$iii]->image;

                                $column1->match = $ii;
                                $column2->match = $ii;

                                if($_FILES["c1_image_" . $ii]["name"] != '') {
                                    $column1->image = $this->upload_image("c1_image_" . $ii, "question/");
                                }
                                if($_FILES["c2_image_" . $ii]["name"] != '') {
                                    $column2->image = $this->upload_image("c2_image_" . $ii, "question/");
                                }

                                if($column1->text != '' && $column1->image != '') {
                                    $column1->type = 'both';
                                } else if($column1->text == '' && $column1->image != '') {
                                    $column1->type = 'image';
                                } else if($column1->text != '' && $column1->image == '') {
                                    $column1->type = 'text';
                                }
                                if($column2->text != '' && $column2->image != '') {
                                    $column2->type = 'both';
                                } else if($column2->text == '' && $column2->image != '') {
                                    $column2->type = 'image';
                                } else if($column2->text != '' && $column2->image == '') {
                                    $column2->type = 'text';
                                }

                                $question_obj->column1[] = $column1;
                                $question_obj->column2[] = $column2;
                            }
                        }
                    } else if($this->input->post('question_type') == 'vocabulary') {
                        //! For words
                        $question_obj->words = array();
                        for($ii = 1 ; $ii <= 5 ; $ii++) {
                            $iii = $ii -1;
                            if( $this->input->post('vocab_word_' . $ii) != '' ) {

                                $word = new stdClass;
                                $word->word = $this->input->post('vocab_word_' . $ii);
                                $word->image = @$question_obj_db->words[$iii]->image;
                                if($_FILES["vocab_image_" . $ii]["name"] != '') {
                                    $word->image = $this->upload_image("vocab_image_" . $ii, "question/");
                                }
                                $question_obj->words[] = $word;
                            }
                        }
                    }  else if($this->input->post('question_type') == 'conversation') {
                        //! For conversation
                        $question_obj->conversation = array();
                        for($ii = 1 ; $ii <= 10 ; $ii++) {
                            $iii = $ii -1;
                            if( $this->input->post('sentence_' . $ii) != '' ) {

                                $conversation = new stdClass;
                                $conversation->sentence = $this->input->post('sentence_' . $ii);
                                $conversation->image = @$question_obj_db->conversation[$iii]->image;
                                $conversation->question = 0;
                                if(isset($_REQUEST['sentence_question_' . $ii])) {
                                    $conversation->question = 1;
                                }
                                if($_FILES["sentence_image_" . $ii]["name"] != '') {
                                    $conversation->image = $this->upload_image("sentence_image_" . $ii, "question/");
                                }
                                $question_obj->conversation[] = $conversation;
                            }
                        }
                    } else if($this->input->post('question_type') == 'make_the_sentence') {
                        $question_obj->wrong_options = $this->input->post('wrong_options');
                    } else if($this->input->post('question_type') == 'correct_the_sentence') {
                        //! For MCQ type of questions
                        $question_obj->wrong_answer = $this->input->post('cts_wrong_answer');
                        $question_obj->correct_answer = $this->input->post('cts_correct_answer');
                    }

                    $question = json_encode($question_obj);
                }

                //! Edit data in question table
                $questiondb->title = $this->input->post('title');
                $questiondb->meta_type = $this->input->post('meta_type');
                $questiondb->question = $question;
                $questiondb->level = $this->input->post('level');
                $questiondb->score = $this->input->post('score');
                $questiondb->question_template_id = $this->input->post('question_template_id');
                $questiondb->updated_by_id = $this->user->id;
                $questiondb->updated = date("Y-m-d H:i:s");
                $questiondb->save();

                for($mm = 0 ; $mm < count($_REQUEST['language_trans']) ; $mm++ ) {
                    if( @$_REQUEST['language_trans'][$mm] != '' ) {
                        //! Check for the primary word
                        if( @$_REQUEST['qt_id'][$mm] != '') {

                            $wt = QuestionTranslation::find(@$_REQUEST['qt_id'][$mm]);

                            $wt->translation = @$_REQUEST['language_trans'][$mm];
                            $wt->updated_by_id = $this->user->id;
                            $wt->updated = date("Y-m-d H:i:s");
                            $wt->save();
                        } else {
                            //! Create record
                            $new_wt = QuestionTranslation::create(array(
                                'question_id' => $questiondb->id,
                                'language_id' => @$_REQUEST['language_id'][$mm],
                                'translation' => @$_REQUEST['language_trans'][$mm],
                                'added_by_id' => $this->user->id,
                                'updated_by_id' => $this->user->id,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));
                        }
                    } else {
                        if(@$_REQUEST['qt_id'][$mm] != '') {
                            QuestionTranslation::delete_all(array(
        	    			    'conditions' => array(
        		    			    'id' => @$_REQUEST['qt_id'][$mm],
        			    		)
        				    ));
                        }
                    }
                }

                if(isset($story)) {
                    $storypage_id = '';
                    if($this->input->post('type') == 'during') {
                        $storypage_id = $this->input->post('storypage_id');
                    }
                    $storyquestionlinkage = StoryQuestionLinkage::find_by_story_id_and_question_id($story->id,$questiondb->id);

                    $storyquestionlinkage->type = $this->input->post('type');
                    $storyquestionlinkage->storypage_id = $storypage_id;
                    $storyquestionlinkage->order_number = $this->input->post('order_number');
                    $storyquestionlinkage->level = $this->input->post('level');
                    $storyquestionlinkage->updated_by_id = $this->user->id;
                    $storyquestionlinkage->updated = date("Y-m-d H:i:s");
                    $storyquestionlinkage->save();

                } else if(isset($helpvideo)) {

                    $helpvideoquestionlinkage = HelpVideoQuestionLinkage::find_by_help_video_id_and_question_id($helpvideo->id,$questiondb->id);

                    $helpvideoquestionlinkage->order_number = $this->input->post('order_number');
                    $helpvideoquestionlinkage->updated_by_id = $this->user->id;
                    $helpvideoquestionlinkage->updated = date("Y-m-d H:i:s");
                    $helpvideoquestionlinkage->save();

                } else {
                    ConceptsQuestionLinkage::delete_all(array(
    				    'conditions' => array(
    					    'question_id' => $questiondb->id,
    					)
    				));

                    for($ii = 0 ; $ii < count($_REQUEST['concepts']) ; $ii++) {
                        if( @$_REQUEST['concepts'][$ii] != '' ) {
                            $linkage = ConceptsQuestionLinkage::create(array(
                                'concepts_id' => @$_REQUEST['concepts'][$ii],
                                'question_id' => $questiondb->id,
                                'classes_id' => @$_REQUEST['classes'][$ii],
                                'board' => @$_REQUEST['board'][$ii],
                                'order_num' => @$_REQUEST['order_num'][$ii],
                                'sub_order_num' => @$_REQUEST['sub_order_num'][$ii],
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));
                        }
                    }
                }

                if(isset($story)) {
                    //! Redirect to story question page
                    redirect('content/storyquestions/' .$story->id . "/2");
                } else if(isset($helpvideo)) {
                    redirect('englishcontent/helpvideoquestions/' .$helpvideo->id . "/2");
                } else {
                    if(@$_REQUEST['for'] == "grammar") {
                        //! Redirect to view question page
                        redirect('admin/viewquestion/0/1?for=grammar');
                    } else {
                        //! Redirect to view question page
                        redirect('admin/viewquestion/0/1');
                    }
                }
            }
        }

        /*
    	Function name   : deletequestion()
    	Parameter       : $question_id - int - question id to be made inactive
    	Return          : none
    	Description     : delete question data
    	*/
        function deletequestion($question_id = 0,$story_id = 0,$helpvideo_id = 0) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                redirect();
                die();
            }

            //! check if question_id is valid
            if($question_id == 0 || $question_id == '') {
                redirect("admin/viewquestion");
                die();
            }


            $questiondb = Question::find($question_id);

            if($story_id != 0 && $story_id != '') {
                //! Get the story Details
                $temp = Story::find($story_id);
                if(isset($temp->id)) {
                    $story = $temp;
                }
            }

            if($helpvideo_id != 0 && $helpvideo_id != '') {
                $temp = HelpVideo::find($helpvideo_id);
                if(isset($temp->id)) {
                    $helpvideo = $temp;
                }
            }

            //! Edit data in question table
            $questiondb->status = 'inactive';
            $questiondb->updated_by_id = $this->user->id;
            $questiondb->updated = date("Y-m-d H:i:s");
            $questiondb->save();

            if(isset($story)) {
                //! Redirect to story question page
                redirect('content/storyquestions/' .$story->id . "/3");
            } else if(isset($helpvideo)) {
                redirect('englishcontent/helpvideoquestions/' .$helpvideo->id . "/3");
            } else {
                if(@$_REQUEST['for'] == "grammar") {
                    //! Redirect to view question page
                    redirect('admin/viewquestion/0/3?for=grammar');
                } else {
                    //! Redirect to view question page
                    redirect('admin/viewquestion/0/3');
                }
            }
        }

        /*
    	Function name   : upload_image()
    	Parameter       : $input_name - string - file input field name
                          $folder - string - file to be uploaded to which folder
    	Return          : $image_name - string - new uploaded file name ( excluding the folder / path )
    	Description     : Upload the file on the server
    	*/
        function upload_image ($input_name = '', $folder = '') {
            if($input_name != '' && $folder != '') {
                $type = pathinfo($_FILES[$input_name]["name"], PATHINFO_EXTENSION);
                $image_name = md5(date("Y-m-d H:i:s") . $_FILES[$input_name]["name"]) . "." . $type;
                if(strpos(site_url(),'localhost') !== false ) {
                    move_uploaded_file ( $_FILES[$input_name]["tmp_name"] , $folder . $image_name);
                } else {
                    move_uploaded_file ( $_FILES[$input_name]["tmp_name"] , $this->config->item("root_url") . $folder . $image_name);
                }
                return $image_name;
            } else {
                return '';
            }
        }

        /*
    	Function name   : addquestiontemplate()
    	Parameter       : $error - int - Stores error no. if any default is 0
    	Return          : none
    	Description     : Add new question template
    	*/
        function addquestiontemplate($error = 0) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin or intern
            if($this->user->admin != 1 ) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['error'] = $error;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('name','Question Template', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Add Question Template";
                $this->loadtemplate("admin/addquestiontemplate",$header,$body,$footer);
            } else {
                //! Else create a new user process
                $error = 1;

                //! Question Image upload
                $image = '';
                if($_FILES["image"]["name"] != '') {
                    $image = $this->upload_image('image', "questiontemplate/");
                }

                //! Add data to question template table
                $new_question_template = QuestionTemplate::create(array(
                    'name' => $this->input->post('name'),
                    'image' => $image,
                    'added_by_id' => $this->user->id,
                    'updated_by_id' => $this->user->id,
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                ));

                //! Redirect to add question page
                redirect('admin/viewquestiontemplate/' . $error);
            }
        }

        /*
    	Function name   : viewquestiontemplate()
    	Parameter       : $page - int - Stores the page no. if any, default is 0
                          $error - int - Stores error no. if any, default is 0
    	Return          : none
    	Description     : View question template list
    	*/
        function viewquestiontemplate($page = 0,$error = 0) {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['page'] = $page;
            $body['error'] = $error;
            $footer['user'] = $this->user;
            $header['title'] = "View Question template";

            //! Display the list
            $this->loadtemplate("admin/viewquestiontemplate",$header,$body,$footer);
        }

        /*
    	Function name   : editquestiontemplate()
    	Parameter       : $question_template_id - int - question template id to be edited
    	Return          : none
    	Description     : edit question template data
    	*/
        function editquestiontemplate($question_template_id = 0) {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                redirect();
                die();
            }

            //! check if question_template_id is valid
            if($question_template_id == 0 || $question_template_id == '') {
                redirect("admin/viewquestiontemplate");
                die();
            }

            //! Setting page data
            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $question_template = QuestionTemplate::find($question_template_id);
            $body['question_template'] = $question_template;
            $body['question_template_id'] = $question_template_id;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('name','Question Template', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Edit Question Template";
                $this->loadtemplate("admin/editquestiontemplate",$header,$body,$footer);
            } else {
                //! Else update the question data
                $error = 2;

                //! Question template Image upload
                if($_FILES["image"]["name"] != '') {
                    $question_template->image = $this->upload_image('image', "questiontemplate/");
                }

                //! Edit data in question template table
                $question_template->name = $this->input->post('name');
                $question_template->updated_by_id = $this->user->id;
                $question_template->updated = date("Y-m-d H:i:s");
                $question_template->save();

                //! Redirect to view question page
                redirect('admin/viewquestiontemplate/0/' . $error);
            }
        }

        /*
    	Function name   : translatetohindi()
    	Parameter       : none
    	Return          : none
    	Description     : Convert english to hindi
    	*/
        function translatetohindi($start= 0,$limit = 1) {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                redirect();
                die();
            }

            //! Get all Graphemes
            $words = Word::find("all",array(
                "conditions" => " 1 = 1",
                "offset" => $start,
                "limit" => $limit,
                "order" => "id ASC"
            ));


            foreach($words as $word) {
                $curl = curl_init("https://www.googleapis.com/language/translate/v2?q=".urlencode($word->word)."&target=hi&format=text&source=en&key=AIzaSyCvna4NOmIjbSexHlGaMgby17uIJ6-4y_U");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                $string = curl_exec($curl);
                curl_close($curl);

                $obj = json_decode($string);
                $word->hindi_translation = $obj->data->translations[0]->translatedText;
                $word->save();

            }

        }

        /*
    	Function name   : translatetomarathi()
    	Parameter       : none
    	Return          : none
    	Description     : Convert english to marathi
    	*/
        function translatetomarathi($start= 0,$limit = 1) {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                redirect();
                die();
            }

            //! Get all Graphemes
            $words = Word::find("all",array(
                "conditions" => " 1 = 1",
                "offset" => $start,
                "limit" => $limit,
                "order" => "id ASC"
            ));


            foreach($words as $word) {
                $curl = curl_init("https://www.googleapis.com/language/translate/v2?q=".urlencode($word->word)."&target=mr&format=text&source=en&key=AIzaSyCvna4NOmIjbSexHlGaMgby17uIJ6-4y_U");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                $string = curl_exec($curl);
                curl_close($curl);

                $obj = json_decode($string);
                $word->marathi_translation = $obj->data->translations[0]->translatedText;
                $word->save();

            }
        }

        /*
    	Function name   : populatewordsegment()
    	Parameter       : none
    	Return          : none
    	Description     : populate word segment
    	*/
        function populatewordsegment() {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                redirect();
                die();
            }

            //! Get all words
            $words = Word::find("all",array(
                "select" => " DISTINCT(word),level ",
                "conditions" => " 1 = 1",
                "order" => "id ASC"
            ));


            foreach($words as $word) {
                $www = $word->word;
                $grap = array();
                $awww = $www;
                $unit = 1;
                for($ii = 0 ; $ii < strlen($awww) ; $ii++) {
                    $gg1 = $awww[$ii] . @$awww[$ii+ 1];
                    $sg = Grapheme::find_by_grapheme($gg1);

                    if(isset($sg->id)) {
                        $grap[] = $sg->id;
                        if($sg->units_id > $unit) {
                            $unit = $sg->units_id;
                        }
                        $ii++;
                    } else {
                        $gg2 = $awww[$ii];
                        $sg1 = Grapheme::find_by_grapheme($gg2);

                        if(isset($sg1->id)) {
                            $grap[] = $sg1->id;
                            if($sg1->units_id > $unit) {
                                $unit = $sg1->units_id;
                            }
                        }
                    }
                }

                //! Creating phoneme story record
                $ws = Wordsegment::find_by_word($www);
                if(isset($ws->id)){
                    $ws->unit = $unit;
                    $ws->save();
                }
                /*$new_wordsegment = Wordsegment::create(array(
                    'word' => $www,
                    'unit' => $unit,
                    'level' => $word->level,
                    'hindi_translation' => '',
                    'marathi_translation' => '',
                    'added_by_id' => 1,
                    'updated_by_id' => 1,
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                ));*/

                /*if(isset($new_wordsegment->id)) {
                    $mmm = 1;
                    for($mm = 0 ; $mm < count($grap) ; $mm++ ) {
                        if( @$grap[$mm] != '' ) {
                            //! wordsegment grapheme linkage
                            $new_wordsegment_grapheme_linkage = GraphemeWordsegmentLinkage::create(array(
                                'wordsegment_id' => $new_wordsegment->id,
                                'grapheme_id' => @$grap[$mm],
                                'order_number' => $mmm,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));

                            $mmm++;
                        }
                    }
                }*/
            }
        }

        /*
    	Function name   : populatewordsegment_segment()
    	Parameter       : none
    	Return          : none
    	Description     : populate word segment
    	*/
        function populatewordsegment_segment() {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                redirect();
                die();
            }

            //! Get all wordsegment
            $words = Wordsegment::find("all",array(
                "conditions" => " 1 = 1",
                "order" => "id ASC"
            ));


            foreach($words as $word) {
                if($word->graphemes) {
                    foreach( $word->graphemes as $wsg) {
                        $wsg->segment = $wsg->grapheme->grapheme;
                        $wsg->save();
                    }
                }
            }
        }

        /*
    	Function name   : populatewordsegment_unit()
    	Parameter       : none
    	Return          : none
    	Description     : populate word unit
    	*/
        function populatewordsegment_unit() {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                redirect();
                die();
            }

            //! Get all wordsegment
            $words = Wordsegment::find("all",array(
                "conditions" => " 1 = 1",
                "order" => "id ASC"
            ));


            foreach($words as $word) {
                if($word->graphemes) {
                    $unit = 1;
                    foreach( $word->graphemes as $wsg) {
                        if($unit < $wsg->grapheme->units_id) {
                            $unit = $wsg->grapheme->units_id;
                        }
                    }
                    $word->unit = $unit;
                    $word->save();
                }
            }
        }

        /*
    	Function name   : generateallthestoryfolder()
    	Parameter       : none
    	Return          : none
    	Description     : generate all the story folder
    	*/
        function generateallthestoryfolder() {

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! get all the stories
            $stories = Story::find("all",array(
                "conditions" => " status = 'inactive' ",
                "order" => "id ASC"
            ));

            foreach($stories as $story) {
                $folder_name =  $this->cleanstring($story->name) . "_" . $story->id;
                mkdir($this->config->item("root_url") . "storypage/" . $folder_name);
                //mkdir("storypage/" . $folder_name);

                //! For all the story page
                foreach($story->storypage as $spage) {
                    $content = nl2br($spage->content);
                    $content = str_replace("<br />", "",$content);
                    $content = str_replace("  ", " ",$content);
                    $content1 = explode(" ",$content);
                    //$content1 = array_map('trim', $content1);
                    //$content1 = array_filter($content1);


                    file_put_contents($this->config->item("root_url") . "storypage/" . $folder_name . "/" . $spage->pageno .".txt",implode("
",$content1));
                    //file_put_contents("storypage/" . $folder_name . "/" . $spage->pageno .".txt",implode("
//",$content1));
                }
            }
        }

        function cleanstring($string) {
            $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.

            return preg_replace('/[^A-Za-z0-9\-]/', '_', $string); // Removes special chars.
        }

        /*
    	Function name   : addallgraphemeaudio()
    	Parameter       : none
    	Return          : none
    	Description     : add all grapheme audio
    	*/
        function addallgraphemeaudio() {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                redirect();
                die();
            }

            //! Get all grapheme
            $graphemes = Grapheme::find("all",array(
                "conditions" => " 1 = 1",
                "order" => "id ASC"
            ));


            foreach($graphemes as $grapheme) {
                $phoneme = $grapheme->phoneme;

                if(file_exists($this->config->item("root_url") . "phoneme_audio/" . $phoneme . ".mp3")) {
                //if(file_exists("phoneme_audio/" . $phoneme . ".mp3")) {
                    $newfilename = md5($grapheme->phoneme . date("U") .  $grapheme->id) . ".mp3";

                    //if(copy("phoneme_audio/" . $phoneme . ".mp3","contentfiles/grapheme/" . $newfilename)){
                    if(copy($this->config->item("root_url") . "phoneme_audio/" . $phoneme . ".mp3",$this->config->item("root_url") . "contentfiles/grapheme/" . $newfilename)) {
                        $grapheme->audio = $newfilename;
                        $grapheme->save();
                    }
                }
            }
        }

        /*
    	Function name   : makeallstoryinactive()
    	Parameter       : none
    	Return          : none
    	Description     : make all story inactive
    	*/
        function makeallstoryinactive() {

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! get all the stories
            $stories = Story::find("all",array(
                "conditions" => " 1 = 1 ",
                "order" => "id ASC"
            ));

            foreach($stories as $story) {
                $story->status = 'inactive';
                $story->save();
            }
        }

        /*
    	Function name   : addstorymp3files()
    	Parameter       : none
    	Return          : none
    	Description     : add story mp3 files
    	*/
        function addstorymp3files() {

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! get all the stories
            $stories = Story::find("all",array(
                "conditions" => " 1 = 1 ",
                "order" => "id ASC"
            ));

            foreach($stories as $story) {

                //if(file_exists($this->config->item("root_url") . "storypage1/" . $story->id)) {
                if(file_exists("storypage1/" . $story->id)) {

                    foreach($story->storypage as $page) {
                        //if(file_exists($this->config->item("root_url") . "storypage1/" . $story->id . "/Files/" . $page->pageno . ".json")) {
                        if(file_exists("storypage1/" . $story->id . "/Files/" . $page->pageno . ".json")) {
                            $newfilename = md5($page->pageno . date("U") .  $page->id) . ".mp3";
                            $newfilename1 = md5($page->pageno . date("U") .  $page->id) . ".json";
                            //copy($this->config->item("root_url") . "storypage1/" . $story->id . "/Files/" . $page->pageno . ".mp3",$this->config->item("root_url") . "story/" . $newfilename);
                            //copy($this->config->item("root_url") . "storypage1/" . $story->id . "/Files/" . $page->pageno . ".json",$this->config->item("root_url") . "story/" . $newfilename1);
                            copy("storypage1/" . $story->id . "/Files/" . $page->pageno . ".mp3","story/" . $newfilename);
                            copy("storypage1/" . $story->id . "/Files/" . $page->pageno . ".json","story/" . $newfilename1);
                            $page->audio = $newfilename;
                            $page->audio_map = $newfilename1;
                            $page->save();
                        }
                    }

                    $story->status = 'active';
                    $story->save();
                }
            }
        }

        /*
    	Function name   : addalltextbookwordgroupexamples()
    	Parameter       : none
    	Return          : none
    	Description     : add all textbook word group word's examples files
    	*/
        function addalltextbookwordgroupexamples() {

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! get all the wordgroups
            $wordgroups = StoryTextbookGroup::find("all",array(
                "conditions" => " 1 = 1 ",
                "order" => "id ASC"
            ));

            foreach($wordgroups as $words) {
                foreach($words->story_textbook_group_word_linkage as $gw_linkage) {
                    $exm = array();
                    $sp = StoryPage::find("all",array(
                        "conditions" => " content LIKE '% ".$gw_linkage->word->word." %' ",
                        "limit" => 2
                    ));

                    if(isset($sp[0])) {
                        $content = explode(".",$sp[0]->content);

                        foreach($content as $val) {
                            if(strpos($val,$gw_linkage->word->word) !== false){
                                $exm[] = trim($val) . ".";
                            }
                        }
                    }

                    $sp = StoryPage::find("all",array(
                        "conditions" => " content LIKE '% ".$gw_linkage->word->word." %' ",
                        "limit" => 2
                    ));

                    if(isset($sp[0])) {
                        $content = explode(".",$sp[0]->content);

                        foreach($content as $val) {
                            if(strpos($val,$gw_linkage->word->word) !== false){
                                $exm[] = trim($val) . ".";
                            }
                        }
                    }

                    echo $gw_linkage->word->word . " (".$gw_linkage->word->hindi_translation.") [".$gw_linkage->word->marathi_translation."]<br />";
                            }



                //if(file_exists($this->config->item("root_url") . "storypage1/" . $story->id)) {
                if(file_exists("storypage1/" . $story->id)) {

                    foreach($story->storypage as $page) {
                        //if(file_exists($this->config->item("root_url") . "storypage1/" . $story->id . "/Files/" . $page->pageno . ".json")) {
                        if(file_exists("storypage1/" . $story->id . "/Files/" . $page->pageno . ".json")) {
                            $newfilename = md5($page->pageno . date("U") .  $page->id) . ".mp3";
                            $newfilename1 = md5($page->pageno . date("U") .  $page->id) . ".json";
                            //copy($this->config->item("root_url") . "storypage1/" . $story->id . "/Files/" . $page->pageno . ".mp3",$this->config->item("root_url") . "story/" . $newfilename);
                            //copy($this->config->item("root_url") . "storypage1/" . $story->id . "/Files/" . $page->pageno . ".json",$this->config->item("root_url") . "story/" . $newfilename1);
                            copy("storypage1/" . $story->id . "/Files/" . $page->pageno . ".mp3","story/" . $newfilename);
                            copy("storypage1/" . $story->id . "/Files/" . $page->pageno . ".json","story/" . $newfilename1);
                            $page->audio = $newfilename;
                            $page->audio_map = $newfilename1;
                            $page->save();
                        }
                    }

                    $story->status = 'active';
                    $story->save();
                }
            }
        }

        /*
    	Function name   : uploadstudentdata()
    	Parameter       : none
    	Return          : none
    	Description     : Upload student data
    	*/
        function uploadstudentdata() {
            require_once 'excel/reader.php';

            $xl_reader = new Spreadsheet_Excel_Reader();

            //! Read Excel
            //$xl_reader->read($this->config->item("root_url") . "user/1.xls");
            $xl_reader->read("user/1.xls");

            //! Check Excel sheet
            if(@$xl_reader->sheets[0]['cells'][2][1] != '' ) {
                for ($ii = 2; $ii <= $xl_reader->sheets[0]['numRows']; $ii++) {
                    if(@$xl_reader->sheets[0]['cells'][$ii][1] != ''  ) {


                    //! Add data to user table
                    $new_user = User::create(array(
                        'email' => '',
                        'username' => strtolower(trim(@$xl_reader->sheets[0]['cells'][$ii][4]) . ".". trim(@$xl_reader->sheets[0]['cells'][$ii][3])),
                        'password' => md5("mguru1"),
                        'mobile' => '',
                        'status' => "active",
                        'unique_id' => md5(date("Y-m-d H:i:s") . trim(@$xl_reader->sheets[0]['cells'][$ii][4]) . ".". trim(@$xl_reader->sheets[0]['cells'][$ii][3])),
                        'password_verification_code' => '',
                        'email_verification_code' => md5(date("Y-m-d H:i:s"). "email_verification_code" . trim(@$xl_reader->sheets[0]['cells'][$ii][4]) . ".". trim(@$xl_reader->sheets[0]['cells'][$ii][3])),
                        'mobile_verification_code' => rand(1000,9999),
                        'email_verified' => 0,
                        'mobile_verified' => 0,
                        'admin' => 0,
                        'created' => date("Y-m-d H:i:s"),
                        'updated' => date("Y-m-d H:i:s"),
                    ));

                    if(isset($new_user->id)) {
                        //! Setting school data
                        $school_id = '';
                        if(trim(@$xl_reader->sheets[0]['cells'][$ii][9]) != '') {
                            //! Check if the school exists
                            $check_school = School::find_by_name(trim(@$xl_reader->sheets[0]['cells'][$ii][9]));
                            if(isset($check_school->id)) {
                                $school_id = $check_school->id;
                            } else {
                                //! Create a new school record
                                $new_school = School::create(array(
                                    'name' => trim(@$xl_reader->sheets[0]['cells'][$ii][9]),
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

                        $title = "Mr";
                        if(trim(@$xl_reader->sheets[0]['cells'][$ii][8]) == "Female") {
                            $title = 'Ms';
                        }
                        $dob = '';
                        if(trim(@$xl_reader->sheets[0]['cells'][$ii][7]) != '') {
                            $dob1 = explode("/",trim(@$xl_reader->sheets[0]['cells'][$ii][7]));
                            if(isset($dob1[2])) {
                                $dob = $dob1[2] . "-" . $dob1[1] . "-" . $dob1[0];
                            }
                        }

                        //! Add data to profile table
                        $new_user_profile = Profile::create(array(
                            'user_id' => $new_user->id,
                            'title' => $title,
                            'first_name' => trim(@$xl_reader->sheets[0]['cells'][$ii][3]),
                            'last_name' => trim(@$xl_reader->sheets[0]['cells'][$ii][4]),
                            'display_name' => trim(@$xl_reader->sheets[0]['cells'][$ii][3]),
                            'profile_picture' => '',
                            'date_of_birth' => $dob,
                            'school_id' => $school_id,
                            'examination_board' => 'SSC',
                            'teacher_name' => '',
                            'father_name' => trim(@$xl_reader->sheets[0]['cells'][$ii][5]) . " " . trim(@$xl_reader->sheets[0]['cells'][$ii][4]),
                            'mother_name' => trim(@$xl_reader->sheets[0]['cells'][$ii][6]) . " " . trim(@$xl_reader->sheets[0]['cells'][$ii][5]) . " " . trim(@$xl_reader->sheets[0]['cells'][$ii][4]),
                            'gender' => strtolower( trim(@$xl_reader->sheets[0]['cells'][$ii][8])),
                            'current_class' => trim(@$xl_reader->sheets[0]['cells'][$ii][2]),
                            'caste_religion' => '',
                            'language_at_home' => '',
                            'address_line_1' => '',
                            'address_line_2' => '',
                            'city' => "Mumbai",
                            'state' => "Maharashtra",
                            'pincode' => '',
                            'country' => "India",
                            'created' => date("Y-m-d H:i:s"),
                            'updated' => date("Y-m-d H:i:s"),
                        ));
                    }
                    }
                }
            }
        }

        /*
    	Function name   : addpromocode()
    	Parameter       : $error - int - Stores error no. if any default is 0
    	Return          : none
    	Description     : Add new promocode
    	*/
        function addpromocode($error = 0) {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['error'] = $error;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('promocode','Promocode', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Add promocode";
                $this->loadtemplate("admin/addpromocode",$header,$body,$footer);
            } else {
                //! Else create a new record
                $error = 1;

                $promo = Promocode::find_by_promocode($this->input->post('promocode'));

                if(!isset($promo->id)) {
                    $error = 2;
                    //$package = explode(",,",$this->input->post('package'));

                    //! Image
                    $image = "";
                    if($_FILES["promo_image"]["name"] != '') {
                        $type = pathinfo($_FILES["promo_image"]["name"], PATHINFO_EXTENSION);
                        $image = "_".md5(date("Y-m-d H:i:s") . $_FILES["promo_image"]["name"]) . "." . $type;
                        if(strpos(site_url(),'localhost') !== false ) {
                            move_uploaded_file ( $_FILES["promo_image"]["tmp_name"] , "images/" . $image);
                        } else {
                            move_uploaded_file ( $_FILES["promo_image"]["tmp_name"] , $this->config->item("root_url") . "images/" . $image);
                        }
                    }

                    //! Add data to table
                    $new_promocode = Promocode::create(array(
                        'promocode' => $this->input->post('promocode'),
                        'start_date' => $this->input->post('start_date'),
                        'end_date' => $this->input->post('end_date'),
                        'amount' => $this->input->post('amount'),
                        'days' => $this->input->post('days'),
                        'count' =>  $this->input->post('count'),
                        'promo_image' =>  $image,
                        'created_by_id' =>  $this->user->id,
                        'updated_by_id' =>  $this->user->id,
                        'created' => date("Y-m-d H:i:s"),
                        'updated' => date("Y-m-d H:i:s")
                    ));
                }

                //! Redirect to add page
                redirect('admin/addpromocode/' . $error);
            }
        }

        /*
    	Function name   : viewpromocode()
    	Parameter       : $page - int - Stores the page no. if any, default is 0
                          $error - int - Stores error no. if any, default is 0
    	Return          : none
    	Description     : View promocode list
    	*/
        function viewpromocode($page = 0,$error = 0) {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['page'] = $page;
            $body['error'] = $error;
            $footer['user'] = $this->user;
            $header['title'] = "View Promocode";

            //! Display the list
            $this->loadtemplate("admin/viewpromocode",$header,$body,$footer);
        }

        /*
    	Function name   : editpromocode()
    	Parameter       : $promocode_id - int - promocode id to be edited
    	Return          : none
    	Description     : edit promocode data
    	*/
        function editpromocode($promocode_id = 0) {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! check if user_id is valid
            if($promocode_id == 0 || $promocode_id == '') {
                redirect("admin/viewpromocode");
                die();
            }

            //! Setting page data
            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $promocode = Promocode::find($promocode_id);
            $body['promocode'] = $promocode;
            $body['promocode_id'] = $promocode_id;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('count','Promocode count', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Edit Promocode";
                $this->loadtemplate("admin/editpromocode",$header,$body,$footer);
            } else {
                //! Else update data
                $error = 1;

                //$package = explode(",,",$this->input->post('package'));

                $image = "";
                if($_FILES["promo_image"]["name"] != '') {
                    $type = pathinfo($_FILES["promo_image"]["name"], PATHINFO_EXTENSION);
                    $image = "_".md5(date("Y-m-d H:i:s") . $_FILES["promo_image"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["promo_image"]["tmp_name"] , "images/" . $image);
                    } else {
                        move_uploaded_file ( $_FILES["promo_image"]["tmp_name"] , $this->config->item("root_url") . "images/" . $image);
                    }
                    $promocode->promo_image = $image;
                }

                //! Edit data in table
                $promocode->start_date = $this->input->post('start_date');
                $promocode->end_date = $this->input->post('end_date');
                $promocode->amount = $this->input->post('amount');
                $promocode->days = $this->input->post('days');
                $promocode->count = $this->input->post('count');
                $promocode->updated_by_id = $this->user->id;
                $promocode->updated = date("Y-m-d H:i:s");
                $promocode->save();

                //! Redirect to view promocode page
                redirect('admin/viewpromocode/0/1');
            }
        }

        function progressuser($user_id = 0) {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! check if user_id is valid
            if($user_id == 0 || $user_id == '') {
                redirect("admin/viewuser");
                die();
            }

            $user1 = User::find($user_id);

            if(!isset($user1->id)) {
                redirect("admin/viewuser");
                die();
            }

            $graphemeUserStatus = GraphemeUserStatus::find("all", array(
                "conditions" => " user_id = '".$user1->id."' "
            ));

            $learn_data_sql = "
            SELECT
                mg_grapheme.units_id AS unit,
                COUNT(
                    CASE WHEN ( mg_grapheme_word_user_audio_recording_trace.grapheme_id != '' AND mg_grapheme_word_user_audio_recording_trace.grapheme_id != 0 AND mg_grapheme_word_user_audio_recording_trace.grapheme_id IS NOT NULL AND mg_grapheme_word_user_audio_recording_trace.type = 'learn' ) THEN ( mg_grapheme_word_user_audio_recording_trace.id ) END
                ) AS learn_count,
                COUNT(
                    CASE WHEN ( mg_grapheme_word_user_audio_recording_trace.grapheme_id != '' AND mg_grapheme_word_user_audio_recording_trace.grapheme_id != 0 AND mg_grapheme_word_user_audio_recording_trace.grapheme_id IS NOT NULL AND mg_grapheme_word_user_audio_recording_trace.type = 'trace' ) THEN ( mg_grapheme_word_user_audio_recording_trace.id ) END
                ) AS trace_count
            FROM mg_grapheme, mg_grapheme_word_user_audio_recording_trace
            WHERE mg_grapheme_word_user_audio_recording_trace.grapheme_id = mg_grapheme.id AND mg_grapheme_word_user_audio_recording_trace.user_id = '".$user1->id."'
            GROUP BY mg_grapheme.units_id
            ORDER BY mg_grapheme.units_id ASC;";

            $learn_data = User::find_by_sql( $learn_data_sql );

            $phrase_data_sql = "
            SELECT
                mg_phrase.units_id AS unit,
                COUNT(
                    CASE WHEN ( mg_grapheme_word_user_audio_recording_trace.phrase_id != '' AND mg_grapheme_word_user_audio_recording_trace.phrase_id != 0 AND mg_grapheme_word_user_audio_recording_trace.phrase_id IS NOT NULL AND mg_grapheme_word_user_audio_recording_trace.type = 'phrase' ) THEN ( mg_grapheme_word_user_audio_recording_trace.id ) END
                ) AS phrase_count
            FROM mg_phrase, mg_grapheme_word_user_audio_recording_trace
            WHERE mg_grapheme_word_user_audio_recording_trace.phrase_id = mg_phrase.id AND mg_grapheme_word_user_audio_recording_trace.user_id = '".$user1->id."'
            GROUP BY mg_phrase.units_id
            ORDER BY mg_phrase.units_id ASC;";

            $phrase_data = User::find_by_sql( $phrase_data_sql );

            $word_data_sql = "
            SELECT
                mg_wordsegment.unit,
                COUNT(
                    CASE WHEN ( mg_grapheme_word_user_audio_recording_trace.wordsegment_id != '' AND mg_grapheme_word_user_audio_recording_trace.wordsegment_id != 0 AND mg_grapheme_word_user_audio_recording_trace.wordsegment_id IS NOT NULL AND mg_grapheme_word_user_audio_recording_trace.type = 'word' ) THEN ( mg_grapheme_word_user_audio_recording_trace.id ) END
                ) AS word_count
            FROM mg_wordsegment, mg_grapheme_word_user_audio_recording_trace
            WHERE mg_grapheme_word_user_audio_recording_trace.wordsegment_id = mg_wordsegment.id AND mg_grapheme_word_user_audio_recording_trace.user_id = '".$user1->id."'
            GROUP BY mg_wordsegment.unit
            ORDER BY mg_wordsegment.unit ASC;";

            $word_data = User::find_by_sql( $word_data_sql );

            $phrase_ans_data_sql = "
            SELECT
                mg_sentence.units_id AS unit,
                COUNT(
                    CASE WHEN ( mg_phrase_user_answer.type = 'normal') THEN ( mg_phrase_user_answer.id )  END
                ) AS total_count_normal,
                COUNT(
                    CASE WHEN ( mg_phrase_user_answer.type = 'test') THEN ( mg_phrase_user_answer.id )  END
                ) AS total_count_test,
                COUNT(
                    CASE WHEN ( mg_phrase_user_answer.status = 'correct' AND mg_phrase_user_answer.type = 'normal') THEN ( mg_phrase_user_answer.id )  END
                ) AS correct_count_normal,
                COUNT(
                    CASE WHEN ( mg_phrase_user_answer.status = 'correct' AND mg_phrase_user_answer.type = 'test') THEN ( mg_phrase_user_answer.id )  END
                ) AS correct_count_test
            FROM mg_sentence, mg_phrase_user_answer
            WHERE mg_phrase_user_answer.sentence_id = mg_sentence.id AND mg_phrase_user_answer.user_id = '".$user1->id."'
            GROUP BY mg_sentence.units_id
            ORDER BY mg_sentence.units_id ASC;";

            $phrase_ans_data = User::find_by_sql( $phrase_ans_data_sql );

            $word_ans_data_sql = "
            SELECT
                mg_grapheme.units_id AS unit,
                COUNT(
                    CASE WHEN ( mg_word_user_answers.type = 'normal') THEN ( mg_word_user_answers.id )  END
                ) AS total_count_normal,
                COUNT(
                    CASE WHEN ( mg_word_user_answers.status = 'correct' AND mg_word_user_answers.type = 'normal') THEN ( mg_word_user_answers.id )  END
                ) AS correct_count_normal,
                COUNT(
                    CASE WHEN ( mg_word_user_answers.type = 'test') THEN ( mg_word_user_answers.id )  END
                ) AS total_count_test,
                COUNT(
                    CASE WHEN ( mg_word_user_answers.status = 'correct' AND mg_word_user_answers.type = 'test') THEN ( mg_word_user_answers.id )  END
                ) AS correct_count_test
            FROM mg_grapheme, mg_word_user_answers, mg_grapheme_word_linkage
            WHERE mg_word_user_answers.grapheme_id = 0 AND mg_word_user_answers.word_id != 0 AND mg_word_user_answers.word_id = mg_grapheme_word_linkage.word_id AND mg_grapheme_word_linkage.grapheme_id = mg_grapheme.id AND mg_word_user_answers.user_id = '".$user1->id."'
            GROUP BY mg_grapheme.units_id
            ORDER BY mg_grapheme.units_id ASC;";

            $word_ans_data = User::find_by_sql( $word_ans_data_sql );

            $word_ans_data_sql1 = "
            SELECT
                mg_grapheme.units_id AS unit,
                COUNT(
                    CASE WHEN ( mg_word_user_answers.type = 'test') THEN ( mg_word_user_answers.id )  END
                ) AS total_count_test,
                COUNT(
                    CASE WHEN ( mg_word_user_answers.status = 'correct' AND mg_word_user_answers.type = 'test') THEN ( mg_word_user_answers.id )  END
                ) AS correct_count_test
            FROM mg_grapheme, mg_word_user_answers
            WHERE mg_word_user_answers.grapheme_id != 0 AND mg_word_user_answers.word_id = 0 AND mg_word_user_answers.grapheme_id = mg_grapheme.id AND mg_word_user_answers.user_id = '".$user1->id."'
            GROUP BY mg_grapheme.units_id
            ORDER BY mg_grapheme.units_id ASC;";

            $word_ans_data1 = User::find_by_sql( $word_ans_data_sql1 );

            $story_user_status_sql = "
            SELECT
                mg_story.level,
                COUNT(
                    CASE WHEN ( mg_story_user_status.status != 'locked' ) THEN ( mg_story_user_status.id )  END
                ) AS total_download,
                SUM( mg_story_user_status.score ) AS total_score,
                COUNT(
                    CASE WHEN ( mg_story_user_status.status = 'reading' ) THEN ( mg_story_user_status.id )  END
                ) AS total_reading,
                COUNT(
                    CASE WHEN ( mg_story_user_status.status = 'completed' ) THEN ( mg_story_user_status.id )  END
                ) AS total_completed
            FROM mg_story, mg_story_user_status
            WHERE mg_story_user_status.story_id = mg_story.id AND mg_story_user_status.user_id = '".$user1->id."'
            GROUP BY mg_story.level
            ORDER BY mg_story.level ASC;";

            $story_user_status = User::find_by_sql( $story_user_status_sql );

            $story_audio_data_sql = "
            SELECT
                mg_story.level,
                COUNT(
                    CASE WHEN ( mg_story_user_audio_recording.type = 'read_aloud') THEN ( mg_story_user_audio_recording.id )  END
                ) AS total_count_read_aloud,
                COUNT(
                    CASE WHEN ( mg_story_user_audio_recording.type = 'conversation') THEN ( mg_story_user_audio_recording.id )  END
                ) AS total_count_conversation,
                COUNT(
                    CASE WHEN ( mg_story_user_audio_recording.type = 'describe_image') THEN ( mg_story_user_audio_recording.id )  END
                ) AS total_count_describe_image
            FROM mg_story, mg_story_user_audio_recording
            WHERE mg_story_user_audio_recording.story_id = mg_story.id AND mg_story_user_audio_recording.user_id = '".$user1->id."'
            GROUP BY mg_story.level
            ORDER BY mg_story.level ASC;";

            $story_audio_data = User::find_by_sql( $story_audio_data_sql );

            $story_question_data_sql = "
            SELECT
                mg_story.level,
                COUNT(
                    CASE WHEN ( mg_story_question_linkage.type = 'pre' ) THEN ( mg_story_question_linkage.id )  END
                ) AS total_questions_pre_count,
                COUNT(
                    CASE WHEN ( mg_story_question_linkage.type = 'pre' AND mg_answer.result = 'correct' ) THEN ( mg_answer.id )  END
                ) AS total_questions_pre_correct,
                COUNT(
                    CASE WHEN ( mg_story_question_linkage.type = 'during' ) THEN ( mg_answer.id )  END
                ) AS total_questions_during_count,
                COUNT(
                    CASE WHEN ( mg_story_question_linkage.type = 'during' AND mg_answer.result = 'correct' ) THEN ( mg_answer.id )  END
                ) AS total_questions_during_correct,
                COUNT(
                    CASE WHEN ( mg_story_question_linkage.type = 'post' ) THEN ( mg_answer.id )  END
                ) AS total_questions_post_count,
                COUNT(
                    CASE WHEN ( mg_story_question_linkage.type = 'post' AND mg_answer.result = 'correct' ) THEN ( mg_answer.id )  END
                ) AS total_questions_post_correct
            FROM mg_story, mg_story_question_linkage,mg_answer
            WHERE mg_story_question_linkage.story_id = mg_story.id AND mg_answer.question_id = mg_story_question_linkage.question_id AND mg_answer.user_id = '".$user1->id."'
            GROUP BY mg_story.level
            ORDER BY mg_story.level ASC;";

            $story_question_data = User::find_by_sql( $story_question_data_sql );

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['user1'] = $user1;
            $body['user_id'] = $user_id;
            $body['graphemeUserStatus'] = $graphemeUserStatus;
            $body['learn_data'] = $learn_data;
            $body['phrase_data'] = $phrase_data;
            $body['word_data'] = $word_data;
            $body['phrase_ans_data'] = $phrase_ans_data;
            $body['word_ans_data'] = $word_ans_data;
            $body['word_ans_data1'] = $word_ans_data1;
            $body['story_user_status'] = $story_user_status;
            $body['story_audio_data'] = $story_audio_data;
            $body['story_question_data'] = $story_question_data;

           //! If not submitted or validation fails display the form
           $header['title'] = "Progress User";
           $this->loadtemplate("admin/progressuser",$header,$body,$footer);
        }

        function progressall() {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            $learn_data_sql = "
            SELECT
                mg_grapheme.units_id AS unit,
                COUNT(
                    CASE WHEN ( mg_grapheme_word_user_audio_recording_trace.grapheme_id != '' AND mg_grapheme_word_user_audio_recording_trace.grapheme_id != 0 AND mg_grapheme_word_user_audio_recording_trace.grapheme_id IS NOT NULL AND mg_grapheme_word_user_audio_recording_trace.type = 'learn' ) THEN ( mg_grapheme_word_user_audio_recording_trace.id ) END
                ) AS learn_count,
                COUNT(
                    CASE WHEN ( mg_grapheme_word_user_audio_recording_trace.grapheme_id != '' AND mg_grapheme_word_user_audio_recording_trace.grapheme_id != 0 AND mg_grapheme_word_user_audio_recording_trace.grapheme_id IS NOT NULL AND mg_grapheme_word_user_audio_recording_trace.type = 'trace' ) THEN ( mg_grapheme_word_user_audio_recording_trace.id ) END
                ) AS trace_count
            FROM mg_grapheme, mg_grapheme_word_user_audio_recording_trace
            WHERE mg_grapheme_word_user_audio_recording_trace.grapheme_id = mg_grapheme.id
            GROUP BY mg_grapheme.units_id
            ORDER BY mg_grapheme.units_id ASC;";

            $learn_data = User::find_by_sql( $learn_data_sql );

            $phrase_data_sql = "
            SELECT
                mg_phrase.units_id AS unit,
                COUNT(
                    CASE WHEN ( mg_grapheme_word_user_audio_recording_trace.phrase_id != '' AND mg_grapheme_word_user_audio_recording_trace.phrase_id != 0 AND mg_grapheme_word_user_audio_recording_trace.phrase_id IS NOT NULL AND mg_grapheme_word_user_audio_recording_trace.type = 'phrase' ) THEN ( mg_grapheme_word_user_audio_recording_trace.id ) END
                ) AS phrase_count
            FROM mg_phrase, mg_grapheme_word_user_audio_recording_trace
            WHERE mg_grapheme_word_user_audio_recording_trace.phrase_id = mg_phrase.id
            GROUP BY mg_phrase.units_id
            ORDER BY mg_phrase.units_id ASC;";

            $phrase_data = User::find_by_sql( $phrase_data_sql );

            $word_data_sql = "
            SELECT
                mg_wordsegment.unit,
                COUNT(
                    CASE WHEN ( mg_grapheme_word_user_audio_recording_trace.wordsegment_id != '' AND mg_grapheme_word_user_audio_recording_trace.wordsegment_id != 0 AND mg_grapheme_word_user_audio_recording_trace.wordsegment_id IS NOT NULL AND mg_grapheme_word_user_audio_recording_trace.type = 'word' ) THEN ( mg_grapheme_word_user_audio_recording_trace.id ) END
                ) AS word_count
            FROM mg_wordsegment, mg_grapheme_word_user_audio_recording_trace
            WHERE mg_grapheme_word_user_audio_recording_trace.wordsegment_id = mg_wordsegment.id
            GROUP BY mg_wordsegment.unit
            ORDER BY mg_wordsegment.unit ASC;";

            $word_data = User::find_by_sql( $word_data_sql );

            $phrase_ans_data_sql = "
            SELECT
                mg_sentence.units_id AS unit,
                COUNT(
                    CASE WHEN ( mg_phrase_user_answer.type = 'normal') THEN ( mg_phrase_user_answer.id )  END
                ) AS total_count_normal,
                COUNT(
                    CASE WHEN ( mg_phrase_user_answer.type = 'test') THEN ( mg_phrase_user_answer.id )  END
                ) AS total_count_test,
                COUNT(
                    CASE WHEN ( mg_phrase_user_answer.status = 'correct' AND mg_phrase_user_answer.type = 'normal') THEN ( mg_phrase_user_answer.id )  END
                ) AS correct_count_normal,
                COUNT(
                    CASE WHEN ( mg_phrase_user_answer.status = 'correct' AND mg_phrase_user_answer.type = 'test') THEN ( mg_phrase_user_answer.id )  END
                ) AS correct_count_test
            FROM mg_sentence, mg_phrase_user_answer
            WHERE mg_phrase_user_answer.sentence_id = mg_sentence.id
            GROUP BY mg_sentence.units_id
            ORDER BY mg_sentence.units_id ASC;";

            $phrase_ans_data = User::find_by_sql( $phrase_ans_data_sql );

            $word_ans_data_sql = "
            SELECT
                mg_grapheme.units_id AS unit,
                COUNT(
                    CASE WHEN ( mg_word_user_answers.type = 'normal') THEN ( mg_word_user_answers.id )  END
                ) AS total_count_normal,
                COUNT(
                    CASE WHEN ( mg_word_user_answers.status = 'correct' AND mg_word_user_answers.type = 'normal') THEN ( mg_word_user_answers.id )  END
                ) AS correct_count_normal,
                COUNT(
                    CASE WHEN ( mg_word_user_answers.type = 'test') THEN ( mg_word_user_answers.id )  END
                ) AS total_count_test,
                COUNT(
                    CASE WHEN ( mg_word_user_answers.status = 'correct' AND mg_word_user_answers.type = 'test') THEN ( mg_word_user_answers.id )  END
                ) AS correct_count_test
            FROM mg_grapheme, mg_word_user_answers, mg_grapheme_word_linkage
            WHERE mg_word_user_answers.grapheme_id = 0 AND mg_word_user_answers.word_id != 0 AND mg_word_user_answers.word_id = mg_grapheme_word_linkage.word_id AND mg_grapheme_word_linkage.grapheme_id = mg_grapheme.id
            GROUP BY mg_grapheme.units_id
            ORDER BY mg_grapheme.units_id ASC;";

            $word_ans_data = User::find_by_sql( $word_ans_data_sql );

            $word_ans_data_sql1 = "
            SELECT
                mg_grapheme.units_id AS unit,
                COUNT(
                    CASE WHEN ( mg_word_user_answers.type = 'test') THEN ( mg_word_user_answers.id )  END
                ) AS total_count_test,
                COUNT(
                    CASE WHEN ( mg_word_user_answers.status = 'correct' AND mg_word_user_answers.type = 'test') THEN ( mg_word_user_answers.id )  END
                ) AS correct_count_test
            FROM mg_grapheme, mg_word_user_answers
            WHERE mg_word_user_answers.grapheme_id != 0 AND mg_word_user_answers.word_id = 0 AND mg_word_user_answers.grapheme_id = mg_grapheme.id
            GROUP BY mg_grapheme.units_id
            ORDER BY mg_grapheme.units_id ASC;";

            $word_ans_data1 = User::find_by_sql( $word_ans_data_sql1 );

            $story_user_status_sql = "
            SELECT
                mg_story.level,
                COUNT(
                    CASE WHEN ( mg_story_user_status.status != 'locked' ) THEN ( mg_story_user_status.id )  END
                ) AS total_download,
                SUM( mg_story_user_status.score ) AS total_score,
                COUNT(
                    CASE WHEN ( mg_story_user_status.status = 'reading' ) THEN ( mg_story_user_status.id )  END
                ) AS total_reading,
                COUNT(
                    CASE WHEN ( mg_story_user_status.status = 'completed' ) THEN ( mg_story_user_status.id )  END
                ) AS total_completed
            FROM mg_story, mg_story_user_status
            WHERE mg_story_user_status.story_id = mg_story.id
            GROUP BY mg_story.level
            ORDER BY mg_story.level ASC;";

            $story_user_status = User::find_by_sql( $story_user_status_sql );

            $story_audio_data_sql = "
            SELECT
                mg_story.level,
                COUNT(
                    CASE WHEN ( mg_story_user_audio_recording.type = 'read_aloud') THEN ( mg_story_user_audio_recording.id )  END
                ) AS total_count_read_aloud,
                COUNT(
                    CASE WHEN ( mg_story_user_audio_recording.type = 'conversation') THEN ( mg_story_user_audio_recording.id )  END
                ) AS total_count_conversation,
                COUNT(
                    CASE WHEN ( mg_story_user_audio_recording.type = 'describe_image') THEN ( mg_story_user_audio_recording.id )  END
                ) AS total_count_describe_image
            FROM mg_story, mg_story_user_audio_recording
            WHERE mg_story_user_audio_recording.story_id = mg_story.id
            GROUP BY mg_story.level
            ORDER BY mg_story.level ASC;";

            $story_audio_data = User::find_by_sql( $story_audio_data_sql );

            $story_question_data_sql = "
            SELECT
                mg_story.level,
                COUNT(
                    CASE WHEN ( mg_story_question_linkage.type = 'pre' ) THEN ( mg_story_question_linkage.id )  END
                ) AS total_questions_pre_count,
                COUNT(
                    CASE WHEN ( mg_story_question_linkage.type = 'pre' AND mg_answer.result = 'correct' ) THEN ( mg_answer.id )  END
                ) AS total_questions_pre_correct,
                COUNT(
                    CASE WHEN ( mg_story_question_linkage.type = 'during' ) THEN ( mg_answer.id )  END
                ) AS total_questions_during_count,
                COUNT(
                    CASE WHEN ( mg_story_question_linkage.type = 'during' AND mg_answer.result = 'correct' ) THEN ( mg_answer.id )  END
                ) AS total_questions_during_correct,
                COUNT(
                    CASE WHEN ( mg_story_question_linkage.type = 'post' ) THEN ( mg_answer.id )  END
                ) AS total_questions_post_count,
                COUNT(
                    CASE WHEN ( mg_story_question_linkage.type = 'post' AND mg_answer.result = 'correct' ) THEN ( mg_answer.id )  END
                ) AS total_questions_post_correct
            FROM mg_story, mg_story_question_linkage,mg_answer
            WHERE mg_story_question_linkage.story_id = mg_story.id AND mg_answer.question_id = mg_story_question_linkage.question_id
            GROUP BY mg_story.level
            ORDER BY mg_story.level ASC;";

            $story_question_data = User::find_by_sql( $story_question_data_sql );

            $user_count_sql = "
            SELECT
                COUNT(id) AS all_count,
                COUNT(
                    CASE WHEN ( status = 'active' ) THEN ( id )  END
                ) AS active_count
            FROM mg_user;";

            $user_count = User::find_by_sql( $user_count_sql );

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['user1'] = $user1;
            $body['user_id'] = $user_id;
            $body['learn_data'] = $learn_data;
            $body['phrase_data'] = $phrase_data;
            $body['word_data'] = $word_data;
            $body['phrase_ans_data'] = $phrase_ans_data;
            $body['word_ans_data'] = $word_ans_data;
            $body['word_ans_data1'] = $word_ans_data1;
            $body['story_user_status'] = $story_user_status;
            $body['story_audio_data'] = $story_audio_data;
            $body['story_question_data'] = $story_question_data;
            $body['user_count'] = $user_count;

            //! If not submitted or validation fails display the form
           $header['title'] = "Progress All";
           $this->loadtemplate("admin/progressall",$header,$body,$footer);
        }

        function checkmixpanel () {
            include_once("mixpanel/mixpanelapi.php");

            //Example usage
            $api_key = '0c2ac1f8f2bbbabe6a7c8c2c0686f4bc';
            $api_secret = 'e4a206c84a45377e4c8665ce32ae5a47';

            $mp = new Mixpanelapi($api_key, $api_secret);
            $data = $mp->request(
                array('events',"properties"),
                array(
                    'event' => array("Sign Up"),
                    'name' => "App Version",
                    "value" => "1.6",
                    'type' => 'general',
                    'unit' => 'day',
                    'interval' => '40'
                )
            );

            print_r($data);
            //var_dump($data);
        }

        function addallreadingconcepts() {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            $current_id = 202;

            for($ii = 3 ; $ii <= 45 ; $ii++) {
                $new_concept = Concept::create(array(
                    'name' => "Test " . $ii,
                    'units_id' => 22,
                    'next_concept_id' => $current_id + 1,
                    'previous_concept_id' => $current_id - 1,
                    'lower_concept_id' => '',
                    'higher_concept_id' => '',
                    'status' => 'active',
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                ));
                $current_id++;
            }

        }

        function addworksheetapikey($error = 0) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user has right privilege
            if($this->user->admin != 1 ) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['error'] = $error;

            //! Validation rules
            $this->form_validation->set_rules('user_id','User ID', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Add worksheet apikey";

                $this->loadtemplate("admin/addworksheetapikey",$header,$body,$footer);
            } else {
                $error = 1;

                $apikey = WorksheetApikey::generateapikey();

                $data_array = array(
                    'user_id' => $this->input->post('user_id'),
                    'apikey' => $apikey,
                    'limit_hourly' => $this->input->post('limit_hourly'),
                    'limit_monthly' => $this->input->post('limit_monthly'),
                    'expire_datetime' => $this->input->post('expire_datetime') . " 23:59:59",
                    'status' => $this->input->post('status'),
                    'added_by_id' => $this->user->id,
                    'updated_by_id' => $this->user->id,
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                );

                //! Creating record
                $new_record = WorksheetApikey::create($data_array);

                redirect('admin/viewworksheetapikey/0/' . $error);
            }
        }

        function viewworksheetapikey($page = 0,$error = 0) {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                redirect();
                die();
            }

            $wak = WorksheetApikey::find('all',array(
                'conditions' => " 1 = 1",
                "order" => 'id DESC'
            ));

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['wak'] = $wak;
            $body['page'] = $page;
            $body['error'] = $error;
            $header['title'] = "View worksheet apikey";

            //! Display the list
            $this->loadtemplate("admin/viewworksheetapikey",$header,$body,$footer);
        }

        function editworksheetapikey($wak_id = 0) {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                redirect();
                die();
            }

            //! check if id is valid
            if($wak_id == 0 || $wak_id == '') {
                redirect("admin/viewworksheetapikey");
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $wak = WorksheetApikey::find($wak_id);
            $body['wak'] = $wak;
            $body['wak_id'] = $wak_id;

            //! Validation rules
            $this->form_validation->set_rules('limit_hourly','Hourly Limit', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Edit Worksheet apikey";

                $this->loadtemplate("admin/editworksheetapikey",$header,$body,$footer);
            } else {
                //! Else update the question data
                $error = 1;

                //! Edit data in table
                $wak->limit_hourly = $this->input->post('limit_hourly');
                $wak->limit_monthly = $this->input->post('limit_monthly');
                $wak->expire_datetime = $this->input->post('expire_datetime') . " 23:59:59";
                $wak->status = $this->input->post('status');
                $wak->updated_by_id = $this->user->id;
                $wak->updated = date("Y-m-d H:i:s");
                $wak->save();

                //! Redirect to view page
                redirect('admin/viewworksheetapikey/0/2');
            }
        }

        function viewpartner($error = 0) {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                redirect();
                die();
            }

            $cg_slate = Partner::find(1);
            $cg_slate_parent_count1 = User::find_by_sql("SELECT COUNT(DISTINCT(cg_parent_id)) AS total FROM mg_user WHERE user_type = '".@$cg_slate->user_type."';");
            $cg_slate_parent_count = @$cg_slate_parent_count1[0]->total;
            $cg_slate_child_count1 = User::find_by_sql("SELECT COUNT(id) AS total FROM mg_user WHERE user_type = '".@$cg_slate->user_type."';");
            $cg_slate_child_count = @$cg_slate_child_count1[0]->total;

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['cg_slate'] = $cg_slate;
            $body['cg_slate_parent_count'] = $cg_slate_parent_count;
            $body['cg_slate_child_count'] = $cg_slate_child_count;
            $body['error'] = $error;
            $header['title'] = "View Partner";

            //! Display the list
            $this->loadtemplate("admin/viewpartner",$header,$body,$footer);
        }

        function editpartner($partner_id = 0) {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                redirect();
                die();
            }

            //! check if id is valid
            if($partner_id == 0 || $partner_id == '') {
                redirect("admin/viewpartner");
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $partner = Partner::find($partner_id);
            $body['partner'] = $partner;
            $body['partner_id'] = $partner_id;

            //! Validation rules
            $this->form_validation->set_rules('limit','Limit', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Edit Partner";

                $this->loadtemplate("admin/editpartner",$header,$body,$footer);
            } else {
                //! Else update the question data
                $error = 1;

                //! Edit data in table
                $partner->limit = $this->input->post('limit');
                $partner->updated_at = date("Y-m-d H:i:s");
                $partner->save();

                //! Redirect to view page
                redirect('admin/viewpartner/1');
            }
        }

        function viewpromocodeused($promocode_id = 0) {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! check if user_id is valid
            if($promocode_id == 0 || $promocode_id == '') {
                redirect("admin/viewpromocode");
                die();
            }

            //! Setting page data
            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $promocode = Promocode::find($promocode_id);
            $body['promocode'] = $promocode;
            $body['promocode_id'] = $promocode_id;
            $footer['user'] = $this->user;

            $header['title'] = "View Promocode";
            $this->loadtemplate("admin/viewpromocodeused",$header,$body,$footer);
        }

        function viewstudentrecord($student_id = 0) {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1) {
                redirect();
                die();
            }

            //! check if user_id is valid
            if($student_id == 0 || $student_id == '') {
                redirect("admin/viewpromocode");
                die();
            }

            $userm_id = "";
            $userm = User::find("all",array(
                "conditions" => " id = '$student_id' "
            ));
            if(isset($userm[0])) {
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
                
                $this->loadtemplate("admin/viewstudentrecord",$header,$body,$footer);

            } else {
                redirect("admin/viewpromocode");
                die();
            }
        }
    }
?>