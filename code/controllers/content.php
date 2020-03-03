<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Content extends MG_Controller {

        var $user = '';
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

        function index() {
            redirect();
        }

        function story($error = 0) {
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['error'] = $error;
            $footer['user'] = $this->user;
            $header['title'] = "Story";
            $this->loadtemplate("content/story",$header,$body,$footer);
        }

        function addstory($error = 0) {
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['error'] = $error;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('name','Story Name', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $header['title'] = "Add story";
                $body['language'] = Language::find("all");
                $this->loadtemplate("content/addstory",$header,$body,$footer);
            } else {
                $error = 1;

                $image = "";
                if($_FILES["image"]["name"] != '') {
                    $type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $image = md5(date("Y-m-d H:i:s") . $_FILES["image"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , "story/" . $image);
                    } else {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , $this->config->item("root_url") . "story/" . $image);
                    }
                }

                $new_story = Story::create(array(
                    'name' => $this->input->post('name'),
                    'writtenby' => $this->input->post('writtenby'),
                    'illustrationsby' => $this->input->post('illustrationsby'),
                    'translationby' => $this->input->post('translationby'),
                    'source' => $this->input->post('source'),
                    'language_id' => $this->input->post('language_id'),
                    'level' => $this->input->post('level'),
                    'image' => $image,
                    'status' => $this->input->post('status'),
                    'added_by_id' => $this->user->id,
                    'updated_by_id' => $this->user->id,
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                ));

                redirect('content/story/' . $error);
            }
        }

        function editstory($story_id = 0) {
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            if($story_id == 0 || $story_id == '') {
                redirect("content/story");
                die();
            }

            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $story = Story::find($story_id);
            $body['story'] = $story;
            $body['story_id'] = $story_id;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('name','Story Name', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $header['title'] = "Edit Story";
                $body['language'] = Language::find("all");
                $this->loadtemplate("content/editstory",$header,$body,$footer);
            } else {
                $error = 1;
                $image = "";
                if($_FILES["image"]["name"] != '') {
                    $type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $image = md5(date("Y-m-d H:i:s") . $_FILES["image"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , "story/" . $image);
                    } else {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , $this->config->item("root_url") . "story/" . $image);
                    }
                    $story->image = $image;
                }

                $story->name = $this->input->post('name');
                $story->writtenby = $this->input->post('writtenby');
                $story->illustrationsby = $this->input->post('illustrationsby');
                $story->translationby = $this->input->post('translationby');
                $story->source = $this->input->post('source');
                $story->language_id = $this->input->post('language_id');
                $story->level = $this->input->post('level');
                $story->status = $this->input->post('status');
                $story->updated_by_id = $this->user->id;
                $story->updated = date("Y-m-d H:i:s");
                $story->save();

                redirect('content/story/2');
            }
        }

        function addstorypage($story_id = 0) {
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $story = Story::find($story_id);
            $body['story'] = $story;
            $body['story_id'] = $story_id;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('content','Page content', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $header['title'] = "Add story page";
                $this->loadtemplate("content/addstorypage",$header,$body,$footer);
            } else {
                $error = 3;

                $image = "";
                if($_FILES["image"]["name"] != '') {
                    $type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $image = md5(date("Y-m-d H:i:s") . $_FILES["image"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , "story/" . $image);
                    } else {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , $this->config->item("root_url") . "story/" . $image);
                    }
                }

                $audio = "";
                if($_FILES["audio"]["name"] != '') {
                    $type = pathinfo($_FILES["audio"]["name"], PATHINFO_EXTENSION);
                    $audio = md5(date("Y-m-d H:i:s") . $_FILES["audio"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , "story/" . $audio);
                    } else {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , $this->config->item("root_url") . "story/" . $audio);
                    }
                }

                $audio_map = "";
                if($_FILES["audio_map"]["name"] != '') {
                    $type = pathinfo($_FILES["audio_map"]["name"], PATHINFO_EXTENSION);
                    $audio_map = md5(date("Y-m-d H:i:s") . $_FILES["audio_map"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["audio_map"]["tmp_name"] , "story/" . $audio_map);
                    } else {
                        move_uploaded_file ( $_FILES["audio_map"]["tmp_name"] , $this->config->item("root_url") . "story/" . $audio_map);
                    }
                }


                $new_story_page = Storypage::create(array(
                    'content' => $this->input->post('content'),
                    'story_id' => $story_id,
                    'image' => $image,
                    'audio' => $audio,
                    'audio_map' => $audio_map,
                    'pageno' => $this->input->post('pageno'),
                    'added_by_id' => $this->user->id,
                    'updated_by_id' => $this->user->id,
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                ));

                redirect('content/story/' . $error);
            }
        }

        function editstorypage($storypage_id = 0) {
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            if($storypage_id == 0 || $storypage_id == '') {
                redirect("content/story");
                die();
            }

            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $storypage = Storypage::find($storypage_id);
            $body['storypage'] = $storypage;
            $body['storypage_id'] = $storypage_id;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('pageno','Story Page No', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $header['title'] = "Edit Story Page";
                $this->loadtemplate("content/editstorypage",$header,$body,$footer);
            } else {
                $image = "";
                if($_FILES["image"]["name"] != '') {
                    $type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $image = md5(date("Y-m-d H:i:s") . $_FILES["image"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , "story/" . $image);
                    } else {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , $this->config->item("root_url") . "story/" . $image);
                    }
                    $storypage->image = $image;
                }

                $audio = "";
                if($_FILES["audio"]["name"] != '') {
                    $type = pathinfo($_FILES["audio"]["name"], PATHINFO_EXTENSION);
                    $audio = md5(date("Y-m-d H:i:s") . $_FILES["audio"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , "story/" . $audio);
                    } else {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , $this->config->item("root_url") . "story/" . $audio);
                    }
                    $storypage->audio = $audio;
                }

                $audio_map = "";
                if($_FILES["audio_map"]["name"] != '') {
                    $type = pathinfo($_FILES["audio_map"]["name"], PATHINFO_EXTENSION);
                    $audio_map = md5(date("Y-m-d H:i:s") . $_FILES["audio_map"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["audio_map"]["tmp_name"] , "story/" . $audio_map);
                    } else {
                        move_uploaded_file ( $_FILES["audio_map"]["tmp_name"] , $this->config->item("root_url") . "story/" . $audio_map);
                    }
                    $storypage->audio_map = $audio_map;
                }

                $storypage->content = $this->input->post('content');
                $storypage->pageno = $this->input->post('pageno');
                $storypage->updated_by_id = $this->user->id;
                $storypage->updated = date("Y-m-d H:i:s");
                $storypage->save();

                redirect('content/story/4');
            }
        }

        /*
    	Function name   : storyquestions()
    	Parameter       : $story_id - int - Story id of the questions
                          $error - int - Error number if any
    	Return          : none
    	Description     : Show the question list
    	*/
        function storyquestions($story_id = 0 , $error = 0) {
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

            //! check if story_id is valid
            if($story_id == 0 || $story_id == '') {
                redirect("content/story");
                die();
            }

            //! Get story record
            $story = Story::find($story_id);

            //! Check if the story is proper
            if(!isset($story->id)) {
                redirect("content/story");
                die();
            }

            //! Setting page data
            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['error'] = $error;
            $body['story'] = $story;
            $footer['user'] = $this->user;
            $header['title'] = "Story Question";

            //! Display the list
            $this->loadtemplate("content/storyquestions",$header,$body,$footer);
        }

        function editorschoicestory($error = 0) {
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['error'] = $error;
            $footer['user'] = $this->user;
            $header['title'] = "Editors Choice Story";
            $body['stories'] = Story::find("all",array(
                "conditions" => " status = 'active' ",
                "order" => "level,name ASC"
            ));;

            //! Validation rules
            $this->form_validation->set_rules('story_id','Story Name', 'trim|required');

            if ($this->form_validation->run() == FALSE) {

                $ecs = @file_get_contents($this->config->item("root_url") . "story/editorschoicestory.json");
                //$ecs = @file_get_contents("story/editorschoicestory.json");

                $body['ecs'] = @json_decode($ecs);

                $this->loadtemplate("content/editorschoicestory",$header,$body,$footer);
            } else {

                $mmm = array($this->input->post('story_id'));

                file_put_contents($this->config->item("root_url") . "story/editorschoicestory.json", json_encode($mmm));
                //file_put_contents("story/editorschoicestory.json", json_encode($mmm));

                $ecs = @file_get_contents($this->config->item("root_url") . "story/editorschoicestory.json");
                //$ecs = @file_get_contents("story/editorschoicestory.json");

                $body['ecs'] = @json_decode($ecs);

                $this->loadtemplate("content/editorschoicestory",$header,$body,$footer);

            }
        }

        function editorschoicehelp($error = 0) {
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['error'] = $error;
            $footer['user'] = $this->user;
            $header['title'] = "Editors Choice Help";
            $body['helpvideos'] = HelpVideo::find("all",array(
                "conditions" => " ( delete_flag = 0 OR delete_flag IS NULL ) ",
                "order" => "level,title ASC"
            ));;

            //! Validation rules
            $this->form_validation->set_rules('help_id','Help Video Name', 'trim|required');

            if ($this->form_validation->run() == FALSE) {

                $ecs = @file_get_contents($this->config->item("root_url") . "story/editorschoicehelp.json");
                //$ecs = @file_get_contents("story/editorschoicehelp.json");

                $body['ecs'] = @json_decode($ecs);

                $this->loadtemplate("content/editorschoicehelp",$header,$body,$footer);
            } else {

                $mmm = array($this->input->post('help_id'));

                file_put_contents($this->config->item("root_url") . "story/editorschoicehelp.json", json_encode($mmm));
                //file_put_contents("story/editorschoicehelp.json", json_encode($mmm));

                $ecs = @file_get_contents($this->config->item("root_url") . "story/editorschoicehelp.json");
                //$ecs = @file_get_contents("story/editorschoicehelp.json");

                $body['ecs'] = @json_decode($ecs);

                $this->loadtemplate("content/editorschoicehelp",$header,$body,$footer);

            }
        }
    }
?>