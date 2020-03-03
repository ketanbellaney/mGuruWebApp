<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    /*
	Class name  : Englishcontent
	Description : English content for phrase sentence / grapheme words
	*/
    class Englishcontent extends MG_Controller {

        //! User details class property
        var $user = '';
        var $_wordcount = '';
        var $_sentencecount = '';
        var $_oldDate = '2016-03-10 00:00:00';
        var $stypes = array(
            "learn_letter" => "Learn Letter",
            "learn_grapheme" => "Learn Grapheme",
            "trace_grapheme" => "Trace Grapheme",
            "local_language_blend" => "Local Language blend",
            "vowel_blend" => "Vowel blend",
            "vowel_blend_trace" => "Vowel blend trace",
            "segmenting_blending" => "Segmenting Blending",
            "segmenting_blending_random" => "Segmenting Blending Random",
            "segmenting_blending_random_grapheme" => "Segmenting Blending Random: Grapheme",
            "word_game" => "Word Game",
            "word_game_random" => "Word Game Random",
            "word_game_random_grapheme" => "Word Game Random: Grapheme",
            "vocab" => "Vocab",
            "vocabrandom" => "Vocab Random",
            "vocabconceptrandom" => "Vocab Concept Random",
            "story" => "Story",
            "rhymes" => "Rhymes",
            "phrase" => "Phrase",
            "phrase_game" => "Phrase Game",
            "grammar" => "Grammar",
            "grammarrandom" => "Grammar Random",
            "grammarrandom_specific" => "Grammar Random: Title Specific",
            "spelling" => "Spelling",
            "reading_test" => "Reading Test",
            "first_last_sound" => "First and last sound in a word",
            "first_last_sound_random" => "First and last sound in 3 letter word",
            "missing_letter" => "MCQ for missing letter",
            "listen_to_a_sound" => "Listen to a sound",
            "listen_to_a_sound_random" => "Listen to a sound, pick from list ",
            "oddity_starts_with_grapheme" => "Oddity Starts With Grapheme",
            "oddity_ends_with_grapheme" => "Oddity Ends With Grapheme",
        );


        var $_worlds = array(
            "sound_of_letters" => "Sound of Letters",
            "vowel_friends" => "Vowel Friends",
            "wordy_birdy" => "Wordy Birdy",
            "phrases_in_the_sky" => "Phrases in the Sky",
            "grammar_space" => "Grammar Space"
        );

        var $_categories = array(
            "sounds" => "Sounds",
            "review" => "Review",
            "story" => "Story",
            "grammar_concepts" => "Grammar Concepts",
            "grammar_activity" => "Grammar Activity",
            "word" => "Word",
            "phrase" => "Phrase",
            "challenge" => "Challenge",
        );

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
            $this->_wordcount = 10;
            $this->_sentencecount = 10;

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
    	Function name   : addgrapheme()
    	Parameter       : $error - int - Stores error no. if any default is 0
    	Return          : none
    	Description     : Add new grapheme, primary word and words 5 words
    	*/
        function addgrapheme1($error = 0) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user has right privilege
            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $this->user;
            $body['wordcount'] =  $this->_wordcount;
            $body['user'] = $this->user;
            $body['error'] = $error;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('grapheme','Grapheme', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Add grapheme";
                $this->loadtemplate("englishcontent/addgrapheme",$header,$body,$footer);
            } else {

                $error = 1;

                //! Grapheme Image
                $image = "";
                if($_FILES["image"]["name"] != '') {
                    $type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $image = "_".md5(date("Y-m-d H:i:s") . $_FILES["image"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , "contentfiles/grapheme/" . $image);
                    } else {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/grapheme/" . $image);
                    }
                }

                //! Grapheme Audio
                $audio = "";
                if($_FILES["audio"]["name"] != '') {
                    $type = pathinfo($_FILES["audio"]["name"], PATHINFO_EXTENSION);
                    $audio = "_".md5(date("Y-m-d H:i:s") . $_FILES["audio"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , "contentfiles/grapheme/" . $audio);
                    } else {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/grapheme/" . $audio);
                    }
                }

                $grapheme_array = array(
                    'grapheme' => $this->input->post('grapheme'),
                    'type' => $this->input->post('type'),
                    'units_id' => $this->input->post('units_id'),
                    'level' => $this->input->post('level'),
                    'image' => $image,
                    'audio' => $audio,
                    'added_by_id' => $this->user->id,
                    'updated_by_id' => $this->user->id,
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                );

                if($this->input->post('type') != 'letter' ) {
                    $grapheme_array['phoneme'] = $this->input->post('phoneme');
                }

                //! Creating Grapheme record
                $new_grapheme = Grapheme::create($grapheme_array);

                //! Check if the Grapheme record is recorded or not
                if( isset($new_grapheme->id )) {

                    //! Primary word Image
                    $pimage = "";
                    if($_FILES["pimage"]["name"] != '') {
                        $type = pathinfo($_FILES["pimage"]["name"], PATHINFO_EXTENSION);
                        $pimage = "_".md5(date("Y-m-d H:i:s") . $_FILES["pimage"]["name"]) . "." . $type;
                        if(strpos(site_url(),'localhost') !== false ) {
                            move_uploaded_file ( $_FILES["pimage"]["tmp_name"] , "contentfiles/word/" . $pimage);
                        } else {
                            move_uploaded_file ( $_FILES["pimage"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/word/" . $pimage);
                        }
                    }

                    //! Primary word Audio
                    $paudio = "";
                    if($_FILES["paudio"]["name"] != '') {
                        $type = pathinfo($_FILES["paudio"]["name"], PATHINFO_EXTENSION);
                        $paudio = "_".md5(date("Y-m-d H:i:s") . $_FILES["paudio"]["name"]) . "." . $type;
                        if(strpos(site_url(),'localhost') !== false ) {
                            move_uploaded_file ( $_FILES["paudio"]["tmp_name"] , "contentfiles/word/" . $paudio);
                        } else {
                            move_uploaded_file ( $_FILES["paudio"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/word/" . $paudio);
                        }
                    }

                    //! Create primary word record
                    $new_primary_word = Word::create(array(
                        'word' => $this->input->post('pword'),
                        'level' => $this->input->post('plevel'),
                        'hindi_translation' => $this->input->post('phindi_translation'),
                        'marathi_translation' => $this->input->post('pmarathi_translation'),
                        'defination' => $this->input->post('pdefination'),
                        'example' => $this->input->post('pexample'),
                        'image' => $pimage,
                        'audio' => $paudio,
                        'added_by_id' => $this->user->id,
                        'updated_by_id' => $this->user->id,
                        'created' => date("Y-m-d H:i:s"),
                        'updated' => date("Y-m-d H:i:s"),
                    ));

                    //! Check if the primary word record is created or not
                    if(isset($new_primary_word->id)) {
                        //! Create the Grapheme Word Linkage
                        $new_grapheme_word_linkage = GraphemeWordLinkage::create(array(
                            'grapheme_id' => $new_grapheme->id,
                            'word_id' => $new_primary_word->id,
                            'primary' => 'yes',
                            'grapheme_index' => $this->input->post('grapheme_index'),
                            'added_by_id' => $this->user->id,
                            'updated_by_id' => $this->user->id,
                            'created' => date("Y-m-d H:i:s"),
                            'updated' => date("Y-m-d H:i:s"),
                        ));

                        //! Add word translation
                        for($mm = 0 ; $mm < count($_REQUEST['language_p_trans']) ; $mm++ ) {
                            if( @$_REQUEST['language_p_trans'][$mm] != '' ) {
                                //! Create record
                                $new_wt = WordTranslation::create(array(
                                    'word_id' => $new_primary_word->id,
                                    'language_id' => @$_REQUEST['language_p_id'][$mm],
                                    'translation' => @$_REQUEST['language_p_trans'][$mm],
                                    'added_by_id' => $this->user->id,
                                    'updated_by_id' => $this->user->id,
                                    'created' => date("Y-m-d H:i:s"),
                                    'updated' => date("Y-m-d H:i:s"),
                                ));
                            }
                        }
                    }

                    //! Add Aditional words
                    for($mm = 0 ; $mm < @$_REQUEST['count_word'] ; $mm++ ) {
                        if( @$_REQUEST['aword_' . $mm] != '' ) {
                            //! word Image
                            $aimage = "";
                            if($_FILES["aimage_" . $mm]["name"] != '') {
                                $type = pathinfo($_FILES["aimage_" . $mm]["name"], PATHINFO_EXTENSION);
                                $aimage = "_".md5(date("Y-m-d H:i:s") . $_FILES["aimage_" . $mm]["name"]) . "." . $type;
                                if(strpos(site_url(),'localhost') !== false ) {
                                    move_uploaded_file ( $_FILES["aimage_" . $mm]["tmp_name"] , "contentfiles/word/" . $aimage);
                                } else {
                                    move_uploaded_file ( $_FILES["aimage_" . $mm]["tmp_name"] , $this->config->item("root_url") . "contentfiles/word/" . $aimage);
                                }
                            }

                            //! word Audio
                            $aaudio = "";
                            if($_FILES["aaudio_" . $mm]["name"] != '') {
                                $type = pathinfo($_FILES["aaudio_" . $mm]["name"], PATHINFO_EXTENSION);
                                $aaudio = "_".md5(date("Y-m-d H:i:s") . $_FILES["aaudio_" . $mm]["name"]) . "." . $type;
                                if(strpos(site_url(),'localhost') !== false ) {
                                    move_uploaded_file ( $_FILES["aaudio_" . $mm]["tmp_name"] , "contentfiles/word/" . $aaudio);
                                } else {
                                    move_uploaded_file ( $_FILES["aaudio_" . $mm]["tmp_name"] , $this->config->item("root_url") . "contentfiles/word/" . $aaudio);
                                }
                            }

                            //! Create word record
                            $new_word = Word::create(array(
                                'word' => $this->input->post('aword_' . $mm),
                                'level' => $this->input->post('alevel_' . $mm),
                                'hindi_translation' => $this->input->post('ahindi_translation_' . $mm),
                                'marathi_translation' => $this->input->post('amarathi_translation_' . $mm),
                                'defination' => $this->input->post('adefination_' . $mm),
                                'example' => $this->input->post('aexample_' . $mm),
                                'image' => $aimage,
                                'audio' => $aaudio,
                                'added_by_id' => $this->user->id,
                                'updated_by_id' => $this->user->id,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));

                            //! Check if the primary word record is created or not
                            if(isset($new_word->id)) {
                                //! Create the Grapheme Word Linkage
                                $new_grapheme_word_linkage = GraphemeWordLinkage::create(array(
                                    'grapheme_id' => $new_grapheme->id,
                                    'word_id' => $new_word->id,
                                    'primary' => 'no',
                                    'grapheme_index' => $this->input->post('agrapheme_index_' . $mm),
                                    'added_by_id' => $this->user->id,
                                    'updated_by_id' => $this->user->id,
                                    'created' => date("Y-m-d H:i:s"),
                                    'updated' => date("Y-m-d H:i:s"),
                                ));

                                //! Add word translation
                                for($mmm = 0 ; $mmm < count($_REQUEST['language_a_trans_' . $mm]) ; $mmm++ ) {
                                    if( @$_REQUEST['language_a_trans_' . $mm][$mmm] != '' ) {
                                        //! Create record
                                        $new_wt = WordTranslation::create(array(
                                            'word_id' => $new_word->id,
                                            'language_id' => @$_REQUEST['language_a_id_' . $mm][$mmm],
                                            'translation' => @$_REQUEST['language_a_trans_' . $mm][$mmm],
                                            'added_by_id' => $this->user->id,
                                            'updated_by_id' => $this->user->id,
                                            'created' => date("Y-m-d H:i:s"),
                                            'updated' => date("Y-m-d H:i:s"),
                                        ));
                                    }
                                }
                            }
                        }
                    }

                    //! Add Grapheme script
                    for($mm = 0 ; $mm < count($_REQUEST['script']) ; $mm++ ) {
                        if( @$_REQUEST['script'][$mm] != '' ) {
                            //! Create record
                            $new_script = GraphemeScript::create(array(
                                'grapheme_id' => $new_grapheme->id,
                                'language_id' => @$_REQUEST['language_script'][$mm],
                                'script' => @$_REQUEST['script'][$mm],
                                'added_by_id' => $this->user->id,
                                'updated_by_id' => $this->user->id,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));
                        }
                    }

                }

                redirect('englishcontent/viewgrapheme/0/' . $error);
            }
        }

        /*
    	Function name   : addgrapheme1()
    	Parameter       : $error - int - Stores error no. if any default is 0
    	Return          : none
    	Description     : Add new grapheme, primary word and words 5 words
    	*/
        function addgrapheme($error = 0) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user has right privilege
            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['wordcount'] =  $this->_wordcount;
            $body['error'] = $error;

            //! Validation rules
            $this->form_validation->set_rules('grapheme','Grapheme', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Add grapheme";
                $body['words'] = Word::find("all",array(
                    "conditions" => "created >= '".$this->_oldDate."' ",
                    "order" => " word ASC "
                ));
                $this->loadtemplate("englishcontent/addgrapheme1",$header,$body,$footer);
            } else {

                $error = 1;

                //! Grapheme Image
                $image = "";
                if($_FILES["image"]["name"] != '') {
                    $type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $image = "_".md5(date("Y-m-d H:i:s") . $_FILES["image"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , "contentfiles/grapheme/" . $image);
                    } else {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/grapheme/" . $image);
                    }
                }

                //! Grapheme Audio
                $audio = "";
                if($_FILES["audio"]["name"] != '') {
                    $type = pathinfo($_FILES["audio"]["name"], PATHINFO_EXTENSION);
                    $audio = "_".md5(date("Y-m-d H:i:s") . $_FILES["audio"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , "contentfiles/grapheme/" . $audio);
                    } else {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/grapheme/" . $audio);
                    }
                }

                $grapheme_array = array(
                    'grapheme' => $this->input->post('grapheme'),
                    'type' => $this->input->post('type'),
                    'units_id' => $this->input->post('units_id'),
                    'level' => $this->input->post('level'),
                    'image' => $image,
                    'audio' => $audio,
                    'added_by_id' => $this->user->id,
                    'updated_by_id' => $this->user->id,
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                );

                if($this->input->post('type') != 'letter' ) {
                    $grapheme_array['phoneme'] = $this->input->post('phoneme');
                }

                //! Creating Grapheme record
                $new_grapheme = Grapheme::create($grapheme_array);

                //! Check if the Grapheme record is recorded or not
                if( isset($new_grapheme->id )) {

                    if(@$_REQUEST['word_id'] != '') {
                        //! Create the Grapheme Word Linkage
                        $new_grapheme_word_linkage = GraphemeWordLinkage::create(array(
                            'grapheme_id' => $new_grapheme->id,
                            'word_id' => @$_REQUEST['word_id'],
                            'primary' => 'yes',
                            'grapheme_index' => $this->input->post('grapheme_index'),
                            'added_by_id' => $this->user->id,
                            'updated_by_id' => $this->user->id,
                            'created' => date("Y-m-d H:i:s"),
                            'updated' => date("Y-m-d H:i:s"),
                        ));

                    }

                    //! Add Grapheme script
                    for($mm = 0 ; $mm < count($_REQUEST['script']) ; $mm++ ) {
                        if( @$_REQUEST['script'][$mm] != '' ) {
                            //! Create record
                            $new_script = GraphemeScript::create(array(
                                'grapheme_id' => $new_grapheme->id,
                                'language_id' => @$_REQUEST['language_script'][$mm],
                                'script' => @$_REQUEST['script'][$mm],
                                'added_by_id' => $this->user->id,
                                'updated_by_id' => $this->user->id,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));
                        }
                    }

                }

                redirect('englishcontent/viewgrapheme/0/' . $error);
            }
        }

        /*
    	Function name   : viewgrapheme()
    	Parameter       : $page - int - Stores the page no. if any, default is 0
                          $error - int - Stores error no. if any, default is 0
    	Return          : none
    	Description     : View grapheme list
    	*/
        function viewgrapheme($page = 0,$error = 0) {
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

            $graphemes = Grapheme::find('all',array(
                'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."' ",
                "order" => 'grapheme ASC'
            ));

            //! Setting page data
            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['graphemes'] = $graphemes;
            $body['page'] = $page;
            $body['error'] = $error;
            $footer['user'] = $this->user;
            $header['title'] = "View Grapheme ";

            //! Display the list
            $this->loadtemplate("englishcontent/viewgrapheme",$header,$body,$footer);
        }

         /*
    	Function name   : viewgrapheme()
    	Parameter       : $page - int - Stores the page no. if any, default is 0
                          $error - int - Stores error no. if any, default is 0
    	Return          : none
    	Description     : View grapheme list
    	*/
        function viewgrapheme1($page = 0,$error = 0) {
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

            $graphemes = Grapheme::find('all',array(
                'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created < '".$this->_oldDate."' ",
                "order" => 'grapheme ASC'
            ));

            //! Setting page data
            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['graphemes'] = $graphemes;
            $body['page'] = $page;
            $body['error'] = $error;
            $footer['user'] = $this->user;
            $header['title'] = "View Grapheme ";

            //! Display the list
            $this->loadtemplate("englishcontent/viewgrapheme",$header,$body,$footer);
        }

        /*
    	Function name   : editgrapheme()
    	Parameter       : $grapheme_id - int - grapheme id to be edited
    	Return          : none
    	Description     : edit grapheme data
    	*/
        function editgrapheme1($grapheme_id = 0) {
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

            //! check if grapheme_id is valid
            if($grapheme_id == 0 || $grapheme_id == '') {
                redirect("englishcontent/viewgrapheme");
                die();
            }

            //! Setting page data
            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $grapheme = Grapheme::find($grapheme_id);
            $body['grapheme'] = $grapheme;
            $body['grapheme_id'] = $grapheme_id;
            $body['wordcount'] =  $this->_wordcount;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('grapheme','Grapheme', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Edit grapheme";
                $this->loadtemplate("englishcontent/editgrapheme",$header,$body,$footer);
            } else {
                //! Else update the question data
                $error = 1;

                //! Grapheme Image
                $image = "";
                if($_FILES["image"]["name"] != '') {
                    $type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $image = "_".md5(date("Y-m-d H:i:s") . $_FILES["image"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , "contentfiles/grapheme/" . $image);
                    } else {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/grapheme/" . $image);
                    }
                    $grapheme->image = $image;
                }

                //! Grapheme Audio
                $audio = "";
                if($_FILES["audio"]["name"] != '') {
                    $type = pathinfo($_FILES["audio"]["name"], PATHINFO_EXTENSION);
                    $audio = "_".md5(date("Y-m-d H:i:s") . $_FILES["audio"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , "contentfiles/grapheme/" . $audio);
                    } else {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/grapheme/" . $audio);
                    }
                    $grapheme->audio = $audio;
                }

                //! Edit data in grapheme table
                $grapheme->type = $this->input->post('type');
                $grapheme->grapheme = $this->input->post('grapheme');
                if($this->input->post('type') == 'letter') {
                    $grapheme->phoneme = '';
                } else {
                    $grapheme->phoneme = $this->input->post('phoneme');
                }
                //$grapheme->script = $this->input->post('script');
                $grapheme->units_id = $this->input->post('units_id');
                $grapheme->level = $this->input->post('level');
                $grapheme->updated_by_id = $this->user->id;
                $grapheme->updated = date("Y-m-d H:i:s");
                $grapheme->save();

                //! Primary word Image
                $pimage = "";
                if($_FILES["pimage"]["name"] != '') {
                    $type = pathinfo($_FILES["pimage"]["name"], PATHINFO_EXTENSION);
                    $pimage = "_".md5(date("Y-m-d H:i:s") . $_FILES["pimage"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["pimage"]["tmp_name"] , "contentfiles/word/" . $pimage);
                    } else {
                        move_uploaded_file ( $_FILES["pimage"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/word/" . $pimage);
                    }
                }

                //! Primary word Audio
                $paudio = "";
                if($_FILES["paudio"]["name"] != '') {
                    $type = pathinfo($_FILES["paudio"]["name"], PATHINFO_EXTENSION);
                    $paudio = "_".md5(date("Y-m-d H:i:s") . $_FILES["paudio"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["paudio"]["tmp_name"] , "contentfiles/word/" . $paudio);
                    } else {
                        move_uploaded_file ( $_FILES["paudio"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/word/" . $paudio);
                    }
                }

                $pword_id = '';
                //! Check for the primary word
                if($this->input->post('pword_id') != '' ) {
                    //! Update primary word
                    $pword = Word::find($this->input->post('pword_id'));
                    $pword_id =  $pword->id;
                    if($pimage != '') {
                        $pword->image = $pimage;
                    }
                    if($paudio != '') {
                        $pword->audio = $paudio;
                    }
                    $pword->word = $this->input->post('pword');
                    $pword->level = $this->input->post('plevel');
                    $pword->hindi_translation = $this->input->post('phindi_translation');
                    $pword->marathi_translation = $this->input->post('pmarathi_translation');
                    $pword->defination = $this->input->post('pdefination');
                    $pword->example = $this->input->post('pexample');
                    $pword->updated_by_id = $this->user->id;
                    $pword->updated = date("Y-m-d H:i:s");
                    $pword->save();

                    $gw_linkage = GraphemeWordLinkage::find("all",array(
                        "conditions" => " word_id = '".$pword->id."' AND grapheme_id = '".$grapheme->id."' "
                    ));

                    if(isset($gw_linkage[0])) {
                        $gw_linkage[0]->primary = 'yes';
                        $gw_linkage[0]->grapheme_index = $this->input->post('grapheme_index');
                        $gw_linkage[0]->updated_by_id = $this->user->id;
                        $gw_linkage[0]->updated = date("Y-m-d H:i:s");
                        $gw_linkage[0]->save();
                    }

                } else {

                    //! Create primary word record
                    $new_primary_word = Word::create(array(
                        'word' => $this->input->post('pword'),
                        'level' => $this->input->post('plevel'),
                        'hindi_translation' => $this->input->post('phindi_translation'),
                        'marathi_translation' => $this->input->post('pmarathi_translation'),
                        'defination' => $this->input->post('pdefination'),
                        'example' => $this->input->post('pexample'),
                        'image' => $pimage,
                        'audio' => $paudio,
                        'added_by_id' => $this->user->id,
                        'updated_by_id' => $this->user->id,
                        'created' => date("Y-m-d H:i:s"),
                        'updated' => date("Y-m-d H:i:s"),
                    ));

                    //! Check if the primary word record is created or not
                    if(isset($new_primary_word->id)) {
                        //! Create the Grapheme Word Linkage
                        $new_grapheme_word_linkage = GraphemeWordLinkage::create(array(
                            'grapheme_id' => $grapheme->id,
                            'word_id' => $new_primary_word->id,
                            'primary' => 'yes',
                            'grapheme_index' => $this->input->post('grapheme_index'),
                            'added_by_id' => $this->user->id,
                            'updated_by_id' => $this->user->id,
                            'created' => date("Y-m-d H:i:s"),
                            'updated' => date("Y-m-d H:i:s"),
                        ));
                        $pword_id =  $new_primary_word->id;
                    }
                }

                if($pword_id != '') {
                    //! Add record
                    for($mm = 0 ; $mm < count($_REQUEST['language_p_trans']) ; $mm++ ) {
                        if( @$_REQUEST['language_p_trans'][$mm] != '' ) {
                            //! Check for the primary word
                            if( @$_REQUEST['word_translation_id'][$mm] != '') {

                                $wt = WordTranslation::find(@$_REQUEST['word_translation_id'][$mm]);

                                $wt->translation = @$_REQUEST['language_p_trans'][$mm];
                                $wt->updated_by_id = $this->user->id;
                                $wt->updated = date("Y-m-d H:i:s");
                                $wt->save();
                            } else {
                                //! Create record
                                $wt = WordTranslation::create(array(
                                    'word_id' => $pword_id,
                                    'language_id' => @$_REQUEST['language_p_id'][$mm],
                                    'translation' => @$_REQUEST['language_p_trans'][$mm],
                                    'added_by_id' => $this->user->id,
                                    'updated_by_id' => $this->user->id,
                                    'created' => date("Y-m-d H:i:s"),
                                    'updated' => date("Y-m-d H:i:s"),
                                ));
                            }
                        } else {
                            if(@$_REQUEST['word_translation_id'][$mm] != '') {
                                WordTranslation::delete_all(array(
            	    			    'conditions' => array(
            		    			    'id' => @$_REQUEST['word_translation_id'][$mm],
            			    		)
            				    ));
                            }
                        }
                    }
                }

                //! Add Aditional words
                for($mm = 0 ; $mm < @$_REQUEST['count_word'] ; $mm++ ) {
                    $aword_id = '';
                    if( @$_REQUEST['aword_' . $mm] != '' ) {
                        //! word Image
                        $aword_id =  @$_REQUEST['aword_' . $mm];
                        $aimage = "";
                        if($_FILES["aimage_" . $mm]["name"] != '') {
                            $type = pathinfo($_FILES["aimage_" . $mm]["name"], PATHINFO_EXTENSION);
                            $aimage = "_".md5(date("Y-m-d H:i:s") . $_FILES["aimage_" . $mm]["name"]) . "." . $type;
                            if(strpos(site_url(),'localhost') !== false ) {
                                move_uploaded_file ( $_FILES["aimage_" . $mm]["tmp_name"] , "contentfiles/word/" . $aimage);
                            } else {
                                move_uploaded_file ( $_FILES["aimage_" . $mm]["tmp_name"] , $this->config->item("root_url") . "contentfiles/word/" . $aimage);
                            }
                        }

                        //! word Audio
                        $aaudio = "";
                        if($_FILES["aaudio_" . $mm]["name"] != '') {
                            $type = pathinfo($_FILES["aaudio_" . $mm]["name"], PATHINFO_EXTENSION);
                            $aaudio = "_".md5(date("Y-m-d H:i:s") . $_FILES["aaudio_" . $mm]["name"]) . "." . $type;
                            if(strpos(site_url(),'localhost') !== false ) {
                                move_uploaded_file ( $_FILES["aaudio_" . $mm]["tmp_name"] , "contentfiles/word/" . $aaudio);
                            } else {
                                move_uploaded_file ( $_FILES["aaudio_" . $mm]["tmp_name"] , $this->config->item("root_url") . "contentfiles/word/" . $aaudio);
                            }
                        }

                        //! Check for the primary word
                        if( @$_REQUEST['aword_id_' . $mm] != '') {
                             $aword_id =  @$_REQUEST['aword_id_' . $mm];
                            //! Update word
                            $aword = Word::find(@$_REQUEST['aword_id_' . $mm]);

                            if($aimage != '') {
                                $aword->image = $aimage;
                            }
                            if($aaudio != '') {
                                $aword->audio = $aaudio;
                            }
                            $aword->word = $this->input->post('aword_' . $mm);
                            $aword->level = $this->input->post('alevel_' . $mm);
                            $aword->hindi_translation = $this->input->post('ahindi_translation_' . $mm);
                            $aword->marathi_translation = $this->input->post('amarathi_translation_' . $mm);
                            $aword->defination = $this->input->post('adefination_' . $mm);
                            $aword->example = $this->input->post('aexample_' . $mm);
                            $aword->updated_by_id = $this->user->id;
                            $aword->updated = date("Y-m-d H:i:s");
                            $aword->save();

                            $gw_linkage = GraphemeWordLinkage::find("all",array(
                                "conditions" => " word_id = '".$aword->id."' AND grapheme_id = '".$grapheme->id."' "
                            ));

                            if(isset($gw_linkage[0])) {
                                $gw_linkage[0]->primary = 'no';
                                $gw_linkage[0]->grapheme_index = $this->input->post('agrapheme_index_' . $mm);
                                $gw_linkage[0]->updated_by_id = $this->user->id;
                                $gw_linkage[0]->updated = date("Y-m-d H:i:s");
                                $gw_linkage[0]->save();
                            }
                        } else {
                            //! Create word record
                            $new_word = Word::create(array(
                                'word' => $this->input->post('aword_' . $mm),
                                'level' => $this->input->post('alevel_' . $mm),
                                'hindi_translation' => $this->input->post('ahindi_translation_' . $mm),
                                'marathi_translation' => $this->input->post('amarathi_translation_' . $mm),
                                'defination' => $this->input->post('adefination_' . $mm),
                                'example' => $this->input->post('aexample_' . $mm),
                                'image' => $aimage,
                                'audio' => $aaudio,
                                'added_by_id' => $this->user->id,
                                'updated_by_id' => $this->user->id,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));

                            //! Check if the primary word record is created or not
                            if(isset($new_word->id)) {
                                //! Create the Grapheme Word Linkage
                                $new_grapheme_word_linkage = GraphemeWordLinkage::create(array(
                                    'grapheme_id' => $grapheme->id,
                                    'word_id' => $new_word->id,
                                    'primary' => 'no',
                                    'grapheme_index' => $this->input->post('agrapheme_index_' . $mm),
                                    'added_by_id' => $this->user->id,
                                    'updated_by_id' => $this->user->id,
                                    'created' => date("Y-m-d H:i:s"),
                                    'updated' => date("Y-m-d H:i:s"),
                                ));

                                $aword_id =  $new_word->id;
                            }
                        }

                        //! Add record
                        for($mmm = 0 ; $mmm < count($_REQUEST['language_a_trans_' . $mm]) ; $mmm++ ) {
                            if( @$_REQUEST['language_a_trans_' . $mm][$mmm] != '' ) {
                                //! Check for the primary word
                                if( @$_REQUEST['word_translation_id_' . $mm][$mmm] != '') {

                                    $wt = WordTranslation::find(@$_REQUEST['word_translation_id_' . $mm][$mmm]);

                                    $wt->translation = @$_REQUEST['language_a_trans_' . $mm][$mmm];
                                    $wt->updated_by_id = $this->user->id;
                                    $wt->updated = date("Y-m-d H:i:s");
                                    $wt->save();
                                } else {
                                    //! Create record
                                    $wt = WordTranslation::create(array(
                                        'word_id' => $aword_id,
                                        'language_id' => @$_REQUEST['language_a_id_' . $mm][$mmm],
                                        'translation' => @$_REQUEST['language_a_trans_' . $mm][$mmm],
                                        'added_by_id' => $this->user->id,
                                        'updated_by_id' => $this->user->id,
                                        'created' => date("Y-m-d H:i:s"),
                                        'updated' => date("Y-m-d H:i:s"),
                                    ));
                                }
                            } else {
                                if(@$_REQUEST['word_translation_id_' . $mm][$mmm] != '') {
                                    WordTranslation::delete_all(array(
                	    			    'conditions' => array(
                		    			    'id' => @$_REQUEST['word_translation_id_' . $mm][$mmm],
                			    		)
                				    ));
                                }
                            }
                        }
                    } else {
                        if( @$_REQUEST['aword_id_' . $mm] != '') {
                            GraphemeWordLinkage::delete_all(array(
            				    'conditions' => array(
            					    'word_id' => @$_REQUEST['aword_id_' . $mm],
            					)
            				));

                            WordTranslation::delete_all(array(
          	    			    'conditions' => array(
          		    			    'word_id' => @$_REQUEST['aword_id_' . $mm],
          			    		)
          				    ));
                        }
                    }
                }

                //! Add Grapheme script
                for($mm = 0 ; $mm < count($_REQUEST['script']) ; $mm++ ) {
                    if( @$_REQUEST['script'][$mm] != '' ) {
                        //! Check for the primary word
                        if( @$_REQUEST['script_id'][$mm] != '') {

                            $script = GraphemeScript::find(@$_REQUEST['script_id'][$mm]);

                            $script->script = @$_REQUEST['script'][$mm];
                            $script->updated_by_id = $this->user->id;
                            $script->updated = date("Y-m-d H:i:s");
                            $script->save();
                        } else {
                             //! Create record
                            $new_script = GraphemeScript::create(array(
                                'grapheme_id' => $grapheme->id,
                                'language_id' => @$_REQUEST['language_script'][$mm],
                                'script' => @$_REQUEST['script'][$mm],
                                'added_by_id' => $this->user->id,
                                'updated_by_id' => $this->user->id,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));
                        }
                    } else {
                        if(@$_REQUEST['script_id'][$mm] != '') {
                            GraphemeScript::delete_all(array(
            				    'conditions' => array(
            					    'id' => @$_REQUEST['script_id'][$mm],
            					)
            				));
                        }
                    }
                }

                //! Redirect to view grapheme page
                redirect('englishcontent/viewgrapheme/0/2');
            }
        }

        /*
    	Function name   : editgrapheme1()
    	Parameter       : $grapheme_id - int - grapheme id to be edited
    	Return          : none
    	Description     : edit grapheme data
    	*/
        function editgrapheme($grapheme_id = 0) {
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

            //! check if grapheme_id is valid
            if($grapheme_id == 0 || $grapheme_id == '') {
                redirect("englishcontent/viewgrapheme");
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $grapheme = Grapheme::find($grapheme_id);
            $body['grapheme'] = $grapheme;
            $body['grapheme_id'] = $grapheme_id;
            $body['wordcount'] =  $this->_wordcount;

            //! Validation rules
            $this->form_validation->set_rules('grapheme','Grapheme', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Edit grapheme";
                $body['words'] = Word::find("all",array(
                    "conditions" => "created >= '".$this->_oldDate."' ",
                    "order" => " word ASC "
                ));
                $this->loadtemplate("englishcontent/editgrapheme1",$header,$body,$footer);
            } else {
                //! Else update the question data
                $error = 1;

                //! Grapheme Image
                $image = "";
                if($_FILES["image"]["name"] != '') {
                    $type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $image = "_".md5(date("Y-m-d H:i:s") . $_FILES["image"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , "contentfiles/grapheme/" . $image);
                    } else {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/grapheme/" . $image);
                    }
                    $grapheme->image = $image;
                }

                //! Grapheme Audio
                $audio = "";
                if($_FILES["audio"]["name"] != '') {
                    $type = pathinfo($_FILES["audio"]["name"], PATHINFO_EXTENSION);
                    $audio = "_".md5(date("Y-m-d H:i:s") . $_FILES["audio"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , "contentfiles/grapheme/" . $audio);
                    } else {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/grapheme/" . $audio);
                    }
                    $grapheme->audio = $audio;
                }

                //! Edit data in grapheme table
                $grapheme->type = $this->input->post('type');
                $grapheme->grapheme = $this->input->post('grapheme');
                if($this->input->post('type') == 'letter') {
                    $grapheme->phoneme = '';
                } else {
                    $grapheme->phoneme = $this->input->post('phoneme');
                }
                //$grapheme->script = $this->input->post('script');
                $grapheme->units_id = $this->input->post('units_id');
                $grapheme->level = $this->input->post('level');
                $grapheme->updated_by_id = $this->user->id;
                $grapheme->updated = date("Y-m-d H:i:s");
                $grapheme->save();


                $pword_id =  $this->input->post('word_id');
                $gw_linkage = GraphemeWordLinkage::find("all",array(
                    "conditions" => " `primary` = 'yes' AND grapheme_id = '".$grapheme->id."' "
                ));

                if(isset($gw_linkage[0])) {
                    $gw_linkage[0]->word_id = $pword_id;
                    $gw_linkage[0]->primary = 'yes';
                    $gw_linkage[0]->grapheme_index = $this->input->post('grapheme_index');
                    $gw_linkage[0]->updated_by_id = $this->user->id;
                    $gw_linkage[0]->updated = date("Y-m-d H:i:s");
                    $gw_linkage[0]->save();
                } else {
                    $new_grapheme_word_linkage = GraphemeWordLinkage::create(array(
                        'grapheme_id' => $grapheme->id,
                        'word_id' => $pword_id,
                        'primary' => 'yes',
                        'grapheme_index' => $this->input->post('grapheme_index'),
                        'added_by_id' => $this->user->id,
                        'updated_by_id' => $this->user->id,
                        'created' => date("Y-m-d H:i:s"),
                        'updated' => date("Y-m-d H:i:s"),
                    ));
                }

                //! Add Grapheme script
                for($mm = 0 ; $mm < count($_REQUEST['script']) ; $mm++ ) {
                    if( @$_REQUEST['script'][$mm] != '' ) {
                        //! Check for the primary word
                        if( @$_REQUEST['script_id'][$mm] != '') {

                            $script = GraphemeScript::find(@$_REQUEST['script_id'][$mm]);

                            $script->script = @$_REQUEST['script'][$mm];
                            $script->updated_by_id = $this->user->id;
                            $script->updated = date("Y-m-d H:i:s");
                            $script->save();
                        } else {
                             //! Create record
                            $new_script = GraphemeScript::create(array(
                                'grapheme_id' => $grapheme->id,
                                'language_id' => @$_REQUEST['language_script'][$mm],
                                'script' => @$_REQUEST['script'][$mm],
                                'added_by_id' => $this->user->id,
                                'updated_by_id' => $this->user->id,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));
                        }
                    } else {
                        if(@$_REQUEST['script_id'][$mm] != '') {
                            GraphemeScript::delete_all(array(
            				    'conditions' => array(
            					    'id' => @$_REQUEST['script_id'][$mm],
            					)
            				));
                        }
                    }
                }

                //! Redirect to view grapheme page
                redirect('englishcontent/viewgrapheme/0/2');
            }
        }

        /*
    	Function name   : addphrase()
    	Parameter       : $error - int - Stores error no. if any default is 0
    	Return          : none
    	Description     : Add new phrase, sentences words
    	*/
        function addphrase($error = 0) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user has right privilege
            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $this->user;
            $body['sentencecount'] =  $this->_sentencecount;
            $body['user'] = $this->user;
            $body['error'] = $error;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('phrase','Phrase', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $body['graphemes'] =  Grapheme::find("all",array(
                    "conditions" => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."' "
                ));
                $header['title'] = "Add phrase";
                $this->loadtemplate("englishcontent/addphrase",$header,$body,$footer);
            } else {

                $error = 1;

                //! Phrase Image
                $image = "";
                if($_FILES["image"]["name"] != '') {
                    $type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $image = "_".md5(date("Y-m-d H:i:s") . $_FILES["image"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , "contentfiles/phrase/" . $image);
                    } else {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/phrase/" . $image);
                    }
                }

                //! Phrase Audio
                $audio = "";
                if($_FILES["audio"]["name"] != '') {
                    $type = pathinfo($_FILES["audio"]["name"], PATHINFO_EXTENSION);
                    $audio = "_".md5(date("Y-m-d H:i:s") . $_FILES["audio"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , "contentfiles/phrase/" . $audio);
                    } else {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/phrase/" . $audio);
                    }
                }

                //! Creating Phrase record
                $new_phrase = Phrase::create(array(
                    'type' => $this->input->post('type'),
                    'phrase' => $this->input->post('phrase'),
                    'units_id' => $this->input->post('units_id'),
                    'level' => $this->input->post('level'),
                    'grapheme_id' => $this->input->post('grapheme_id'),
                    'image' => $image,
                    'audio' => $audio,
                    'added_by_id' => $this->user->id,
                    'updated_by_id' => $this->user->id,
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                ));

                //! Check if the Phrase record is recorded or not
                if( isset($new_phrase->id )) {

                    //! Add Sentences
                    for($mm = 0 ; $mm < $this->_sentencecount ; $mm++ ) {
                        if( @$_REQUEST['sentence_' . $mm] != '' ) {
                            //! Sentence Image
                            $aimage = "";
                            if($_FILES["aimage_" . $mm]["name"] != '') {
                                $type = pathinfo($_FILES["aimage_" . $mm]["name"], PATHINFO_EXTENSION);
                                $aimage = "_".md5(date("Y-m-d H:i:s") . $_FILES["aimage_" . $mm]["name"]) . "." . $type;
                                if(strpos(site_url(),'localhost') !== false ) {
                                    move_uploaded_file ( $_FILES["aimage_" . $mm]["tmp_name"] , "contentfiles/sentence/" . $aimage);
                                } else {
                                    move_uploaded_file ( $_FILES["aimage_" . $mm]["tmp_name"] , $this->config->item("root_url") . "contentfiles/sentence/" . $aimage);
                                }
                            }

                            //! sentence Audio
                            $aaudio = "";
                            if($_FILES["aaudio_" . $mm]["name"] != '') {
                                $type = pathinfo($_FILES["aaudio_" . $mm]["name"], PATHINFO_EXTENSION);
                                $aaudio = "_".md5(date("Y-m-d H:i:s") . $_FILES["aaudio_" . $mm]["name"]) . "." . $type;
                                if(strpos(site_url(),'localhost') !== false ) {
                                    move_uploaded_file ( $_FILES["aaudio_" . $mm]["tmp_name"] , "contentfiles/sentence/" . $aaudio);
                                } else {
                                    move_uploaded_file ( $_FILES["aaudio_" . $mm]["tmp_name"] , $this->config->item("root_url") . "contentfiles/sentence/" . $aaudio);
                                }
                            }

                            //! sentence Audio map
                            $aaudio_map = "";
                            if($_FILES["aaudio_map_" . $mm]["name"] != '') {
                                $type = pathinfo($_FILES["aaudio_map_" . $mm]["name"], PATHINFO_EXTENSION);
                                $aaudio_map = "_".md5(date("Y-m-d H:i:s") . $_FILES["aaudio_map_" . $mm]["name"]) . "." . $type;
                                if(strpos(site_url(),'localhost') !== false ) {
                                    move_uploaded_file ( $_FILES["aaudio_map_" . $mm]["tmp_name"] , "contentfiles/sentence/" . $aaudio_map);
                                } else {
                                    move_uploaded_file ( $_FILES["aaudio_map_" . $mm]["tmp_name"] , $this->config->item("root_url") . "contentfiles/sentence/" . $aaudio_map);
                                }
                            }

                            //! Create sentence record
                            $new_sentence = Sentence::create(array(
                                'sentence' => $this->input->post('sentence_' . $mm),
                                'units_id' => $this->input->post('units_id'),
                                'level' => $this->input->post('level'),
                                'image' => $aimage,
                                'audio' => $aaudio,
                                'audio_map' => $aaudio_map,
                                'added_by_id' => $this->user->id,
                                'updated_by_id' => $this->user->id,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));

                            //! Check if the new sentence record is created or not
                            if(isset($new_sentence->id)) {
                                //! Create the Phrase Sentence Linkage
                                $new_phrase_sentence_linkage = PhraseSentenceLinkage::create(array(
                                    'phrase_id' => $new_phrase->id,
                                    'sentence_id' => $new_sentence->id,
                                    'order_number' => $this->input->post('order_number_' . $mm),
                                    'added_by_id' => $this->user->id,
                                    'updated_by_id' => $this->user->id,
                                    'created' => date("Y-m-d H:i:s"),
                                    'updated' => date("Y-m-d H:i:s"),
                                ));
                            }
                        }
                    }
                }

                redirect('englishcontent/viewphrase/0/' . $error);
            }
        }

        /*
    	Function name   : viewphrase()
    	Parameter       : $page - int - Stores the page no. if any, default is 0
                          $error - int - Stores error no. if any, default is 0
    	Return          : none
    	Description     : View phrase list
    	*/
        function viewphrase($page = 0,$error = 0) {
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

            $phrases = Phrase::find('all',array(
                'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL )  AND created >= '".$this->_oldDate."' ",
                "order" => 'id ASC'
            ));

            //! Setting page data
            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['phrases'] = $phrases;
            $body['page'] = $page;
            $body['error'] = $error;
            $footer['user'] = $this->user;
            $header['title'] = "View Phrase ";

            //! Display the list
            $this->loadtemplate("englishcontent/viewphrase",$header,$body,$footer);
        }

        /*
    	Function name   : viewphrase()
    	Parameter       : $page - int - Stores the page no. if any, default is 0
                          $error - int - Stores error no. if any, default is 0
    	Return          : none
    	Description     : View phrase list
    	*/
        function viewphrase1($page = 0,$error = 0) {
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

            $phrases = Phrase::find('all',array(
                'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created < '".$this->_oldDate."' ",
                "order" => 'id ASC'
            ));

            //! Setting page data
            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['phrases'] = $phrases;
            $body['page'] = $page;
            $body['error'] = $error;
            $footer['user'] = $this->user;
            $header['title'] = "View Phrase ";

            //! Display the list
            $this->loadtemplate("englishcontent/viewphrase",$header,$body,$footer);
        }

        /*
    	Function name   : editphrase()
    	Parameter       : $phrase_id - int - phrase id to be edited
    	Return          : none
    	Description     : edit phrase data
    	*/
        function editphrase($phrase_id = 0) {
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

            //! check if phrase_id is valid
            if($phrase_id == 0 || $phrase_id == '') {
                redirect("englishcontent/viewphrase");
                die();
            }

            //! Setting page data
            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $phrase = Phrase::find($phrase_id);
            $body['phrase'] = $phrase;
            $body['phrase_id'] = $phrase_id;
            $body['sentencecount'] =  $this->_sentencecount;
            $footer['user'] = $this->user;

            //! Validation rules
            $this->form_validation->set_rules('phrase','Phrase', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $body['graphemes'] =  Grapheme::find("all",array(
                    "conditions" => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."' "
                ));
                $header['title'] = "Edit phrase";
                $this->loadtemplate("englishcontent/editphrase",$header,$body,$footer);
            } else {
                //! Else update the question data
                $error = 1;

                //! Phrase Image
                $image = "";
                if($_FILES["image"]["name"] != '') {
                    $type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $image = "_".md5(date("Y-m-d H:i:s") . $_FILES["image"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , "contentfiles/phrase/" . $image);
                    } else {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/phrase/" . $image);
                    }
                    $phrase->image = $image;
                }

                //! Phrase Audio
                $audio = "";
                if($_FILES["audio"]["name"] != '') {
                    $type = pathinfo($_FILES["audio"]["name"], PATHINFO_EXTENSION);
                    $audio = "_".md5(date("Y-m-d H:i:s") . $_FILES["audio"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , "contentfiles/phrase/" . $audio);
                    } else {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/phrase/" . $audio);
                    }
                    $phrase->audio = $audio;
                }

                //! Edit data in grapheme table
                $phrase->type = $this->input->post('type');
                $phrase->phrase = $this->input->post('phrase');
                $phrase->units_id = $this->input->post('units_id');
                $phrase->grapheme_id = $this->input->post('grapheme_id');
                $phrase->level = $this->input->post('level');
                $phrase->updated_by_id = $this->user->id;
                $phrase->updated = date("Y-m-d H:i:s");
                $phrase->save();

                //! Add Sentences
                for($mm = 0 ; $mm < $this->_sentencecount ; $mm++ ) {
                    if( @$_REQUEST['sentence_' . $mm] != '' ) {
                        //! Sentence Image
                        $aimage = "";
                        if($_FILES["aimage_" . $mm]["name"] != '') {
                            $type = pathinfo($_FILES["aimage_" . $mm]["name"], PATHINFO_EXTENSION);
                            $aimage = "_".md5(date("Y-m-d H:i:s") . $_FILES["aimage_" . $mm]["name"]) . "." . $type;
                            if(strpos(site_url(),'localhost') !== false ) {
                                move_uploaded_file ( $_FILES["aimage_" . $mm]["tmp_name"] , "contentfiles/sentence/" . $aimage);
                            } else {
                                move_uploaded_file ( $_FILES["aimage_" . $mm]["tmp_name"] , $this->config->item("root_url") . "contentfiles/sentence/" . $aimage);
                            }
                        }

                        //! word Audio
                        $aaudio = "";
                        if($_FILES["aaudio_" . $mm]["name"] != '') {
                            $type = pathinfo($_FILES["aaudio_" . $mm]["name"], PATHINFO_EXTENSION);
                            $aaudio = "_".md5(date("Y-m-d H:i:s") . $_FILES["aaudio_" . $mm]["name"]) . "." . $type;
                            if(strpos(site_url(),'localhost') !== false ) {
                                move_uploaded_file ( $_FILES["aaudio_" . $mm]["tmp_name"] , "contentfiles/sentence/" . $aaudio);
                            } else {
                                move_uploaded_file ( $_FILES["aaudio_" . $mm]["tmp_name"] , $this->config->item("root_url") . "contentfiles/sentence/" . $aaudio);
                            }
                        }

                        //! sentence Audio map
                        $aaudio_map = "";
                        if($_FILES["aaudio_map_" . $mm]["name"] != '') {
                            $type = pathinfo($_FILES["aaudio_map_" . $mm]["name"], PATHINFO_EXTENSION);
                            $aaudio_map = "_".md5(date("Y-m-d H:i:s") . $_FILES["aaudio_map_" . $mm]["name"]) . "." . $type;
                            if(strpos(site_url(),'localhost') !== false ) {
                                move_uploaded_file ( $_FILES["aaudio_map_" . $mm]["tmp_name"] , "contentfiles/sentence/" . $aaudio_map);
                            } else {
                                move_uploaded_file ( $_FILES["aaudio_map_" . $mm]["tmp_name"] , $this->config->item("root_url") . "contentfiles/sentence/" . $aaudio_map);
                            }
                        }

                        //! Check for the primary word
                        if( @$_REQUEST['asentence_id_' . $mm] != '') {
                            //! Update Sentence
                            $asentence = Sentence::find(@$_REQUEST['asentence_id_' . $mm]);

                            if($aimage != '') {
                                $asentence->image = $aimage;
                            }
                            if($aaudio != '') {
                                $asentence->audio = $aaudio;
                            }
                            if($aaudio_map != '') {
                                $asentence->audio_map = $aaudio_map;
                            }
                            $asentence->sentence = $this->input->post('sentence_' . $mm);
                            $asentence->units_id = $this->input->post('units_id');
                            $asentence->level = $this->input->post('level');
                            $asentence->updated_by_id = $this->user->id;
                            $asentence->updated = date("Y-m-d H:i:s");
                            $asentence->save();

                            $ps_linkage = PhraseSentenceLinkage::find("all",array(
                                "conditions" => " phrase_id = '".$phrase->id."' AND sentence_id = '".$asentence->id."' "
                            ));

                            if(isset($ps_linkage[0])) {
                                $ps_linkage[0]->order_number = $this->input->post('order_number_' . $mm);
                                $ps_linkage[0]->updated_by_id = $this->user->id;
                                $ps_linkage[0]->updated = date("Y-m-d H:i:s");
                                $ps_linkage[0]->save();
                            }
                        } else {
                            //! Create sentence record
                            $new_sentence = Sentence::create(array(
                                'sentence' => $this->input->post('sentence_' . $mm),
                                'units_id' => $this->input->post('units_id'),
                                'level' => $this->input->post('level'),
                                'image' => $aimage,
                                'audio' => $aaudio,
                                'audio_map' => $aaudio_map,
                                'added_by_id' => $this->user->id,
                                'updated_by_id' => $this->user->id,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));

                            //! Check if the new sentence record is created or not
                            if(isset($new_sentence->id)) {
                                //! Create the Phrase Sentence Linkage
                                $new_phrase_sentence_linkage = PhraseSentenceLinkage::create(array(
                                    'phrase_id' => $phrase->id,
                                    'sentence_id' => $new_sentence->id,
                                    'order_number' => $this->input->post('order_number_' . $mm),
                                    'added_by_id' => $this->user->id,
                                    'updated_by_id' => $this->user->id,
                                    'created' => date("Y-m-d H:i:s"),
                                    'updated' => date("Y-m-d H:i:s"),
                                ));
                            }
                        }
                    } else {
                        if( @$_REQUEST['asentence_id_' . $mm] != '') {
                            PhraseSentenceLinkage::delete_all(array(
            				    'conditions' => array(
            					    'sentence_id' => @$_REQUEST['asentence_id_' . $mm],
            					)
            				));
                        }
                    }
                }

                //! Redirect to view grapheme page
                redirect('englishcontent/viewphrase/0/2');
            }
        }

        /*
    	Function name   : addphonemestory()
    	Parameter       : $error - int - Stores error no. if any default is 0
    	Return          : none
    	Description     : Add new phoneme story
    	*/
        function addphonemestory($error = 0) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user has right privilege
            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['error'] = $error;

            //! Validation rules
            $this->form_validation->set_rules('title','Title', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Add phoneme story";
                $this->loadtemplate("englishcontent/addphonemestory",$header,$body,$footer);
            } else {

                $error = 1;

                //! phoneme story Image
                $image = "";
                if($_FILES["image"]["name"] != '') {
                    $type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $image = "_".md5(date("Y-m-d H:i:s") . $_FILES["image"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , "contentfiles/phoneme_story/" . $image);
                    } else {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/phoneme_story/" . $image);
                    }
                }

                //! phoneme story Audio
                $audio = "";
                if($_FILES["audio"]["name"] != '') {
                    $type = pathinfo($_FILES["audio"]["name"], PATHINFO_EXTENSION);
                    $audio = "_".md5(date("Y-m-d H:i:s") . $_FILES["audio"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , "contentfiles/phoneme_story/" . $audio);
                    } else {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/phoneme_story/" . $audio);
                    }
                }

                //! Creating phoneme story record
                $new_phoneme_story = PhonemeStory::create(array(
                    'title' => $this->input->post('title'),
                    'unit' => $this->input->post('unit'),
                    'story' => $this->input->post('story'),
                    'image' => $image,
                    'audio' => $audio,
                    'added_by_id' => $this->user->id,
                    'updated_by_id' => $this->user->id,
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                ));

                redirect('englishcontent/viewphonemestory/0/' . $error);
            }
        }

        /*
    	Function name   : viewphonemestory()
    	Parameter       : $page - int - Stores the page no. if any, default is 0
                          $error - int - Stores error no. if any, default is 0
    	Return          : none
    	Description     : View phoneme story list
    	*/
        function viewphonemestory($page = 0,$error = 0) {
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
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['page'] = $page;
            $body['error'] = $error;
            $header['title'] = "View Phoneme Story ";

            //! Display the list
            $this->loadtemplate("englishcontent/viewphonemestory",$header,$body,$footer);
        }

        /*
    	Function name   : editphonemestory()
    	Parameter       : $phonemestory_id - int - phoneme story id to be edited
    	Return          : none
    	Description     : edit phoneme story data
    	*/
        function editphonemestory($phonemestory_id = 0) {
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

            //! check if phonemestory_id is valid
            if($phonemestory_id == 0 || $phonemestory_id == '') {
                redirect("englishcontent/viewphonemestory");
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $phonemestory = PhonemeStory::find($phonemestory_id);
            $body['phonemestory'] = $phonemestory;
            $body['phonemestory_id'] = $phonemestory_id;

            //! Validation rules
            $this->form_validation->set_rules('title','Title', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Edit phoneme story";
                $this->loadtemplate("englishcontent/editphonemestory",$header,$body,$footer);
            } else {
                //! Else update the data
                $error = 1;

                //! Phoneme Story Image
                $image = "";
                if($_FILES["image"]["name"] != '') {
                    $type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $image = "_".md5(date("Y-m-d H:i:s") . $_FILES["image"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , "contentfiles/phoneme_story/" . $image);
                    } else {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/phoneme_story/" . $image);
                    }
                    $phonemestory->image = $image;
                }

                //! Phoneme Story Audio
                $audio = "";
                if($_FILES["audio"]["name"] != '') {
                    $type = pathinfo($_FILES["audio"]["name"], PATHINFO_EXTENSION);
                    $audio = "_".md5(date("Y-m-d H:i:s") . $_FILES["audio"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , "contentfiles/phoneme_story/" . $audio);
                    } else {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/phoneme_story/" . $audio);
                    }
                    $phonemestory->audio = $audio;
                }

                //! Edit data in grapheme table
                $phonemestory->title = $this->input->post('title');
                $phonemestory->unit = $this->input->post('unit');
                $phonemestory->story = $this->input->post('story');
                $phonemestory->story = $this->input->post('story');
                $phonemestory->updated_by_id = $this->user->id;
                $phonemestory->updated = date("Y-m-d H:i:s");
                $phonemestory->save();

                //! Redirect to view grapheme page
                redirect('englishcontent/viewphonemestory/0/2');
            }
        }

        /*
    	Function name   : deletephrase()
    	Parameter       : $phrase_id - int - phrase id to be edited
    	Return          : none
    	Description     : delete phrase data
    	*/
        function deletephrase($phrase_id = 0) {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                //! Redirect to view phrase page
                redirect('englishcontent/viewphrase/0/3');
                die();
            }

            //! check if phrase_id is valid
            if($phrase_id == 0 || $phrase_id == '') {
                redirect("englishcontent/viewphrase");
                die();
            }

            //! Setting delete flag
            $phrase = Phrase::find($phrase_id);
            $phrase->updated_by_id = $this->user->id;
            $phrase->updated = date("Y-m-d H:i:s");
            $phrase->delete_flag = 1;
            $phrase->save();

            //! Redirect to view grapheme page
            redirect('englishcontent/viewphrase/0/4');

        }

        /*
    	Function name   : deletephonemestory()
    	Parameter       : $phoneme_story_id - int - phoneme story id to be deleted
    	Return          : none
    	Description     : delete phoneme story data
    	*/
        function deletephonemestory($phoneme_story_id = 0) {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                //! Redirect to view phrase page
                redirect('englishcontent/viewphonemestory/0/3');
                die();
            }

            //! check if phoneme_story_id is valid
            if($phoneme_story_id == 0 || $phoneme_story_id == '') {
                redirect("englishcontent/viewphonemestory");
                die();
            }

            //! Setting delete flag
            $phoneme_story = PhonemeStory::find($phoneme_story_id);
            $phoneme_story->updated_by_id = $this->user->id;
            $phoneme_story->updated = date("Y-m-d H:i:s");
            $phoneme_story->delete_flag = 1;
            $phoneme_story->save();

            //! Redirect to view page
            redirect('englishcontent/viewphonemestory/0/4');

        }

        /*
    	Function name   : addwordsegment()
    	Parameter       : $error - int - Stores error no. if any default is 0
    	Return          : none
    	Description     : Add new word segment
    	*/
        function addwordsegment($error = 0) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user has right privilege
            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['error'] = $error;

            //! Validation rules
            $this->form_validation->set_rules('word','Word', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Add word segment";
                $body['graphemes'] =  Grapheme::find('all',array(
                    'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."'  ",
                    "order" => 'grapheme ASC'
                ));
                $this->loadtemplate("englishcontent/addwordsegment",$header,$body,$footer);
            } else {

                $error = 1;

                //! Grapheme Image
                $image = "";
                if($_FILES["image"]["name"] != '') {
                    $type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $image = "_".md5(date("Y-m-d H:i:s" . rand(1,99999)) . $_FILES["image"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , "contentfiles/word/" . $image);
                    } else {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/word/" . $image);
                    }
                }

                $double_flag = 0;
                if(isset($_REQUEST['double_flag'])) {
                    $double_flag = 1;
                }

                $ws = array(
                    'word' => $this->input->post('word'),
                    'unit' => $this->input->post('unit'),
                    'level' => $this->input->post('level'),
                    'status' => $this->input->post('status'),
                    'image' => $image,
                    'hindi_translation' => $this->input->post('hindi_translation'),
                    'marathi_translation' => $this->input->post('marathi_translation'),
                    'concept' => $this->input->post('concept'),
                    'added_by_id' => $this->user->id,
                    'updated_by_id' => $this->user->id,
                    'double_flag' => $double_flag,
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                );

                if(isset($_REQUEST['language_blend'])) {
                    $ws['primary_segment'] = $this->input->post('primary_segment');
                    $ws['secondary_segment'] = $this->input->post('secondary_segment');
                }
                //! Creating phoneme story record
                $new_wordsegment = Wordsegment::create($ws);

                if(isset($new_wordsegment->id)) {
                    //! Add wordsegment grapheme linkage
                    $mmm = 1;
                    for($mm = 0 ; $mm < @$_REQUEST['count_grapheme'] ; $mm++ ) {
                        if( @$_REQUEST['grapheme_id_' . $mm] != '' ) {

                            //! wordsegment grapheme linkage
                            $new_wordsegment_grapheme_linkage = GraphemeWordsegmentLinkage::create(array(
                                'wordsegment_id' => $new_wordsegment->id,
                                'grapheme_id' => $this->input->post('grapheme_id_' . $mm),
                                'segment' => $this->input->post('segment_' . $mm),
                                'order_number' => $mmm,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));

                            $mmm++;
                        }
                    }

                    $word_id = '';
                    $www = Word::find_by_word(trim($this->input->post('word')));

                    if(isset($www->id)) {
                        $word_id = $www->id;
                        $www->created = date("Y-m-d H:i:s");
                        $www->updated = date("Y-m-d H:i:s");
                        if( $www->concept == '') {
                            $www->concept = $this->input->post('concept');
                        }
                        $www->save();
                    } else {

                        $new_word = Word::create(array(
                            'word' => $this->input->post('word'),
                            'level' => $this->input->post('level'),
                            'concept' => $this->input->post('concept'),
                            'hindi_translation' => '',
                            'marathi_translation' => '',
                            'defination' => '',
                            'example' => '',
                            'image' => $image,
                            'audio' => '',
                            'added_by_id' => $this->user->id,
                            'updated_by_id' => $this->user->id,
                            'created' => date("Y-m-d H:i:s"),
                            'updated' => date("Y-m-d H:i:s"),
                        ));

                        $word_id = $new_word->id;
                    }

                    //! Add word translation
                    for($mm = 0 ; $mm < count($_REQUEST['language_trans']) ; $mm++ ) {
                        if( @$_REQUEST['language_trans'][$mm] != '' ) {
                            //! Check for the primary word
                            if( @$_REQUEST['word_translation_id'][$mm] != '') {

                                $wt = WordTranslation::find(@$_REQUEST['word_translation_id'][$mm]);

                                $wt->translation = @$_REQUEST['language_trans'][$mm];
                                $wt->updated_by_id = $this->user->id;
                                $wt->updated = date("Y-m-d H:i:s");
                                $wt->save();
                            } else {
                                //! Create record
                                $new_wt = WordTranslation::create(array(
                                    'word_id' => $word_id,
                                    'language_id' => @$_REQUEST['language_id'][$mm],
                                    'translation' => @$_REQUEST['language_trans'][$mm],
                                    'added_by_id' => $this->user->id,
                                    'updated_by_id' => $this->user->id,
                                    'created' => date("Y-m-d H:i:s"),
                                    'updated' => date("Y-m-d H:i:s"),
                                ));
                            }
                        } else {
                            if(@$_REQUEST['word_translation_id'][$mm] != '') {
                                WordTranslation::delete_all(array(
            	    			    'conditions' => array(
            		    			    'id' => @$_REQUEST['word_translation_id'][$mm],
            			    		)
            				    ));
                            }
                        }
                    }

                    //! Add word transliteration
                    for($mm = 0 ; $mm < count($_REQUEST['language1_trans']) ; $mm++ ) {
                        if( @$_REQUEST['language1_trans'][$mm] != '' ) {
                            //! Check for the primary word
                            if( @$_REQUEST['word1_translation_id'][$mm] != '') {

                                $wt = WordTransliteration::find(@$_REQUEST['word1_translation_id'][$mm]);

                                $wt->translation = @$_REQUEST['language1_trans'][$mm];
                                $wt->updated_by_id = $this->user->id;
                                $wt->updated = date("Y-m-d H:i:s");
                                $wt->save();
                            } else {
                                //! Create record
                                $new_wt = WordTransliteration::create(array(
                                    'word_id' => $word_id,
                                    'language_id' => @$_REQUEST['language1_id'][$mm],
                                    'translation' => @$_REQUEST['language1_trans'][$mm],
                                    'added_by_id' => $this->user->id,
                                    'updated_by_id' => $this->user->id,
                                    'created' => date("Y-m-d H:i:s"),
                                    'updated' => date("Y-m-d H:i:s"),
                                ));
                            }
                        } else {
                            if(@$_REQUEST['word1_translation_id'][$mm] != '') {
                                WordTransliteration::delete_all(array(
            	    			    'conditions' => array(
            		    			    'id' => @$_REQUEST['word1_translation_id'][$mm],
            			    		)
            				    ));
                            }
                        }
                    }

                    if(isset($_REQUEST['language_blend'])) {
                        //! Add secondary segment transliteration
                        for($mm = 0 ; $mm < count($_REQUEST['l_trans']) ; $mm++ ) {
                            if( @$_REQUEST['l_trans'][$mm] != '' ) {
                                //! Create record
                                $new_wt = LanguageBlend::create(array(
                                    'wordsegment_id' => $new_wordsegment->id,
                                    'language_id' => @$_REQUEST['l_id'][$mm],
                                    'word' => $this->input->post('secondary_segment'),
                                    'translation' => @$_REQUEST['l_trans'][$mm],
                                    'added_by_id' => $this->user->id,
                                    'updated_by_id' => $this->user->id,
                                    'created' => date("Y-m-d H:i:s"),
                                    'updated' => date("Y-m-d H:i:s"),
                                ));
                            }
                        }
                    }

                } else {
                    $error = 2;
                }

                redirect('englishcontent/addwordsegment/' . $error);
            }
        }

        /*
    	Function name   : viewwordsegment()
    	Parameter       : $page - int - Stores the page no. if any, default is 0
                          $error - int - Stores error no. if any, default is 0
    	Return          : none
    	Description     : View word segment list
    	*/
        function viewwordsegment($page = 0,$error = 0) {
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

            $wordsegments = Wordsegment::find('all',array(
                'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."'  ",
                "order" => 'unit,id ASC'
            ));

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['page'] = $page;
            $body['wordsegments'] = $wordsegments;
            $body['error'] = $error;
            $header['title'] = "View word segment";

            //! Display the list
            $this->loadtemplate("englishcontent/viewwordsegment",$header,$body,$footer);
        }

        /*
    	Function name   : viewwordsegment()
    	Parameter       : $page - int - Stores the page no. if any, default is 0
                          $error - int - Stores error no. if any, default is 0
    	Return          : none
    	Description     : View word segment list
    	*/
        function viewwordsegment2($page = 0,$error = 0) {
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

            $wordsegments = Wordsegment::find('all',array(
                'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."'  ",
                "order" => 'unit,id ASC',
                "offset" => @$_REQUEST['start'],
                "limit" => 50,
            ));

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['page'] = $page;
            $body['wordsegments'] = $wordsegments;
            $body['error'] = $error;
            $header['title'] = "View word segment";

            //! Display the list
            $this->loadtemplate("englishcontent/viewwordsegment2",$header,$body,$footer);
        }

        /*
    	Function name   : viewwordsegment()
    	Parameter       : $page - int - Stores the page no. if any, default is 0
                          $error - int - Stores error no. if any, default is 0
    	Return          : none
    	Description     : View word segment list
    	*/
        function viewwordsegment1($page = 0,$error = 0) {
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

            $wordsegments = Wordsegment::find('all',array(
                'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created < '".$this->_oldDate."'  ",
                "order" => 'unit,id ASC'
            ));

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['page'] = $page;
            $body['wordsegments'] = $wordsegments;
            $body['error'] = $error;
            $header['title'] = "View word segment";

            //! Display the list
            $this->loadtemplate("englishcontent/viewwordsegment",$header,$body,$footer);
        }

        /*
    	Function name   : editwordsegment()
    	Parameter       : $wordsegment_id - int - wordsegment id to be edited
    	Return          : none
    	Description     : edit wordsegment data
    	*/
        function editwordsegment($wordsegment_id = 0) {
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

            //! check if wordsegment_id is valid
            if($wordsegment_id == 0 || $wordsegment_id == '') {
                redirect("englishcontent/viewwordsegment");
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $wordsegment = Wordsegment::find($wordsegment_id);
            $body['wordsegment'] = $wordsegment;
            $body['wordsegment_id'] = $wordsegment_id;

            //! Validation rules
            $this->form_validation->set_rules('word','Word', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Edit word segment";
                $body['graphemes'] =  Grapheme::find('all',array(
                    'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."' ",
                    "order" => 'grapheme ASC'
                ));
                $this->loadtemplate("englishcontent/editwordsegment",$header,$body,$footer);
            } else {
                //! Else update the data
                $error = 1;

                //! Grapheme Image
                $image = "";
                if($_FILES["image"]["name"] != '') {
                    $type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $image = "_".md5(date("Y-m-d H:i:s" . rand(1,99999)) . $_FILES["image"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , "contentfiles/word/" . $image);
                    } else {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/word/" . $image);
                    }
                    $wordsegment->image = $image;
                }

                //! Edit data in grapheme table
                if(isset($_REQUEST['language_blend'])) {
                    $wordsegment->primary_segment = $this->input->post('primary_segment');
                    $wordsegment->secondary_segment = $this->input->post('secondary_segment');
                } else {
                    $wordsegment->primary_segment = '';
                    $wordsegment->secondary_segment = '';
                }

                $double_flag = 0;
                if(isset($_REQUEST['double_flag'])) {
                    $double_flag = 1;
                }

                $wordsegment->word = $this->input->post('word');
                $wordsegment->unit = $this->input->post('unit');
                $wordsegment->level = $this->input->post('level');
                $wordsegment->status = $this->input->post('status');
                $wordsegment->hindi_translation = $this->input->post('hindi_translation');
                $wordsegment->marathi_translation = $this->input->post('marathi_translation');
                $wordsegment->concept = $this->input->post('concept');
                $wordsegment->updated_by_id = $this->user->id;
                $wordsegment->updated = date("Y-m-d H:i:s");
                $wordsegment->double_flag = $double_flag;
                $wordsegment->save();

                $mmm = 1;
                //! Add / Update Grapheme word segment linkage
                for($mm = 0 ; $mm < @$_REQUEST['count_grapheme'] ; $mm++ ) {
                    if( @$_REQUEST['grapheme_id_' . $mm] != '' ) {
                        //! Check for the id
                        if( @$_REQUEST['gwsl_id_' . $mm] != '') {
                            //! Update Grapheme word segment linkage
                            $gwsl = GraphemeWordsegmentLinkage::find(@$_REQUEST['gwsl_id_' . $mm]);

                            $gwsl->grapheme_id = $this->input->post('grapheme_id_' . $mm);
                            $gwsl->segment = $this->input->post('segment_' . $mm);
                            $gwsl->order_number = $mmm;
                            $gwsl->updated = date("Y-m-d H:i:s");
                            $gwsl->save();
                        } else {
                            //! wordsegment grapheme linkage
                            $new_wordsegment_grapheme_linkage = GraphemeWordsegmentLinkage::create(array(
                                'wordsegment_id' => $wordsegment->id,
                                'grapheme_id' => $this->input->post('grapheme_id_' . $mm),
                                'segment' => $this->input->post('segment_' . $mm),
                                'order_number' => $mmm,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));
                        }
                        $mmm++;
                    } else {
                        if( @$_REQUEST['gwsl_id_' . $mm] != '') {
                            GraphemeWordsegmentLinkage::delete_all(array(
            				    'conditions' => array(
            					    'id' => @$_REQUEST['gwsl_id_' . $mm],
            					)
            				));
                        }
                    }
                }

                $word_id = '';
                $www = Word::find_by_word(trim($this->input->post('word')));

                if(isset($www->id)) {
                    $word_id = $www->id;
                    $www->created = date("Y-m-d H:i:s");
                    $www->updated = date("Y-m-d H:i:s");
                    if($www->concept == '') {
                        $www->concept = $this->input->post('concept');
                    }
                    $www->save();
                } else {

                    $new_word = Word::create(array(
                        'word' => $this->input->post('word'),
                        'level' => $this->input->post('level'),
                        'concept' => $this->input->post('concept'),
                        'hindi_translation' => '',
                        'marathi_translation' => '',
                        'defination' => '',
                        'example' => '',
                        'image' => $image,
                        'audio' => '',
                        'added_by_id' => $this->user->id,
                        'updated_by_id' => $this->user->id,
                        'created' => date("Y-m-d H:i:s"),
                        'updated' => date("Y-m-d H:i:s"),
                    ));

                    $word_id = $new_word->id;
                }

                //! Add word translation
                for($mm = 0 ; $mm < count($_REQUEST['language_trans']) ; $mm++ ) {
                    if( @$_REQUEST['language_trans'][$mm] != '' ) {
                        //! Check for the primary word
                        if( @$_REQUEST['word_translation_id'][$mm] != '') {

                            $wt = WordTranslation::find(@$_REQUEST['word_translation_id'][$mm]);

                            $wt->translation = @$_REQUEST['language_trans'][$mm];
                            $wt->updated_by_id = $this->user->id;
                            $wt->updated = date("Y-m-d H:i:s");
                            $wt->save();
                        } else {
                            //! Create record
                            $new_wt = WordTranslation::create(array(
                                'word_id' => $word_id,
                                'language_id' => @$_REQUEST['language_id'][$mm],
                                'translation' => @$_REQUEST['language_trans'][$mm],
                                'added_by_id' => $this->user->id,
                                'updated_by_id' => $this->user->id,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));
                        }
                    } else {
                        if(@$_REQUEST['word_translation_id'][$mm] != '') {
                            WordTranslation::delete_all(array(
        	    			    'conditions' => array(
        		    			    'id' => @$_REQUEST['word_translation_id'][$mm],
        			    		)
        				    ));
                        }
                    }
                }

                //! Add word transliteration
                for($mm = 0 ; $mm < count($_REQUEST['language1_trans']) ; $mm++ ) {
                    if( @$_REQUEST['language1_trans'][$mm] != '' ) {
                        //! Check for the primary word
                        if( @$_REQUEST['word1_translation_id'][$mm] != '') {

                            $wt = WordTransliteration::find(@$_REQUEST['word1_translation_id'][$mm]);

                            $wt->translation = @$_REQUEST['language1_trans'][$mm];
                            $wt->updated_by_id = $this->user->id;
                            $wt->updated = date("Y-m-d H:i:s");
                            $wt->save();
                        } else {
                            //! Create record
                            $new_wt = WordTransliteration::create(array(
                                'word_id' => $word_id,
                                'language_id' => @$_REQUEST['language1_id'][$mm],
                                'translation' => @$_REQUEST['language1_trans'][$mm],
                                'added_by_id' => $this->user->id,
                                'updated_by_id' => $this->user->id,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));
                        }
                    } else {
                        if(@$_REQUEST['word1_translation_id'][$mm] != '') {
                            WordTransliteration::delete_all(array(
        	    			    'conditions' => array(
        		    			    'id' => @$_REQUEST['word1_translation_id'][$mm],
        			    		)
        				    ));
                        }
                    }
                }

                if(isset($_REQUEST['language_blend'])) {
                    //! Add record
                    for($mm = 0 ; $mm < count($_REQUEST['l_trans']) ; $mm++ ) {
                        if( @$_REQUEST['l_trans'][$mm] != '' ) {
                            //! Check for the primary word
                            if( @$_REQUEST['lb_id'][$mm] != '') {

                                $wt = LanguageBlend::find(@$_REQUEST['lb_id'][$mm]);

                                $wt->word = $this->input->post('secondary_segment');
                                $wt->translation = @$_REQUEST['l_trans'][$mm];
                                $wt->updated_by_id = $this->user->id;
                                $wt->updated = date("Y-m-d H:i:s");
                                $wt->save();
                            } else {
                                //! Create record
                                $new_wt = LanguageBlend::create(array(
                                    'wordsegment_id' => $wordsegment->id,
                                    'language_id' => @$_REQUEST['l_id'][$mm],
                                    'word' => $this->input->post('secondary_segment'),
                                    'translation' => @$_REQUEST['l_trans'][$mm],
                                    'added_by_id' => $this->user->id,
                                    'updated_by_id' => $this->user->id,
                                    'created' => date("Y-m-d H:i:s"),
                                    'updated' => date("Y-m-d H:i:s"),
                                ));
                            }
                        } else {
                            if(@$_REQUEST['lb_id'][$mm] != '') {
                                LanguageBlend::delete_all(array(
            	    			    'conditions' => array(
            		    			    'id' => @$_REQUEST['lb_id'][$mm],
            			    		)
            				    ));
                            }
                        }
                    }
                } else {
                    LanguageBlend::delete_all(array(
  	    			    'conditions' => array(
  		    			    'wordsegment_id' => $wordsegment->id,
  			    		)
  				    ));
                }

                //! Redirect to view word segment page
                redirect('englishcontent/viewwordsegment/0/2');
            }
        }

        /*
    	Function name   : deletewordsegment()
    	Parameter       : $wordsegment_id - int - word segment id to be deleted
    	Return          : none
    	Description     : delete word segment data
    	*/
        function deletewordsegment($wordsegment_id = 0) {
            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                //! Redirect to view page
                redirect('englishcontent/viewwordsegment/0/3');
                die();
            }

            //! check if id is valid
            if($wordsegment_id == 0 || $wordsegment_id == '') {
                redirect("englishcontent/viewwordsegment");
                die();
            }

            //! Setting delete flag
            $wordsegment = Wordsegment::find($wordsegment_id);
            $wordsegment->updated_by_id = $this->user->id;
            $wordsegment->updated = date("Y-m-d H:i:s");
            $wordsegment->delete_flag = 1;
            $wordsegment->save();

            //! Redirect to view page
            redirect('englishcontent/viewwordsegment/0/4');

        }

        /*
    	Function name   : deletegrapheme()
    	Parameter       : $grapheme_id - int - grapheme id to be deleted
    	Return          : none
    	Description     : delete grapheme data
    	*/
        function deletegrapheme( $grapheme_id = 0 ) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                //! Redirect to view page
                redirect('englishcontent/viewgrapheme/0/3');
                die();
            }

            //! check if id is valid
            if($grapheme_id == 0 || $grapheme_id == '') {
                redirect("englishcontent/viewgrapheme");
                die();
            }

            //! Setting delete flag
            $grapheme = Grapheme::find($grapheme_id);
            $grapheme->updated_by_id = $this->user->id;
            $grapheme->updated = date("Y-m-d H:i:s");
            $grapheme->delete_flag = 1;
            $grapheme->save();

            foreach($grapheme->grapheme_wordsegment_linkage as $vall) {
                $vall->wordsegment->status = 'inactive';
                $vall->wordsegment->updated = date("Y-m-d H:i:s");
                $vall->wordsegment->updated_by_id = $this->user->id;
                $vall->wordsegment->save();
            }

            //! Redirect to view page
            redirect('englishcontent/viewgrapheme/0/4');

        }

        /*
    	Function name   : addstorytextbook()
    	Parameter       : $error - int - Stores error no. if any default is 0
    	Return          : none
    	Description     : Add new story text book
    	*/
        function addstorytextbook($error = 0) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user has right privilege
            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] =  $this->user;
            $body['error'] = $error;

            //! Validation rules
            $this->form_validation->set_rules('title','Title', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Add textbook story";
                $this->loadtemplate("englishcontent/addstorytextbook",$header,$body,$footer);
            } else {

                $error = 1;

                //! Image
                $image = "";
                if($_FILES["image"]["name"] != '') {
                    $type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $image = "_".md5(date("Y-m-d H:i:s") . $_FILES["image"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , "contentfiles/textbook/" . $image);
                    } else {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/textbook/" . $image);
                    }
                }

                //! Audio
                $audio = "";
                if($_FILES["audio"]["name"] != '') {
                    $type = pathinfo($_FILES["audio"]["name"], PATHINFO_EXTENSION);
                    $audio = "_".md5(date("Y-m-d H:i:s") . $_FILES["audio"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , "contentfiles/textbook/" . $audio);
                    } else {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/textbook/" . $audio);
                    }
                }

                //! Creating Text book story record
                $new_textbookstory = StoryTextbook::create(array(
                    'title' => $this->input->post('title'),
                    'title_hindi' => $this->input->post('title_hindi'),
                    'title_marathi' => $this->input->post('title_marathi'),
                    'content' => $this->input->post('content'),
                    'content_hindi' => $this->input->post('content_hindi'),
                    'content_marathi' => $this->input->post('content_marathi'),
                    'unit' => $this->input->post('unit'),
                    'class' => $this->input->post('class'),
                    'board' => $this->input->post('board'),
                    'order_number' => $this->input->post('order_number'),
                    'page_number' => $this->input->post('page_number'),
                    'source' => $this->input->post('source'),
                    'author' => $this->input->post('author'),
                    'status' => $this->input->post('status'),
                    'image' => $image,
                    'audio' => $audio,
                    'added_by_id' => $this->user->id,
                    'updated_by_id' => $this->user->id,
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s")
                ));

                redirect('englishcontent/viewstorytextbook/0/' . $error);
            }
        }

        /*
    	Function name   : viewstorytextbook()
    	Parameter       : $page - int - Stores the page no. if any, default is 0
                          $error - int - Stores error no. if any, default is 0
    	Return          : none
    	Description     : View story textbook list
    	*/
        function viewstorytextbook($page = 0,$error = 0) {
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
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['page'] = $page;
            $body['error'] = $error;
            $header['title'] = "View Story textbook ";

            //! Display the list
            $this->loadtemplate("englishcontent/viewstorytextbook",$header,$body,$footer);
        }

        /*
    	Function name   : editstorytextbook()
    	Parameter       : $story_textbook_id - int - story textbook id to be edited
    	Return          : none
    	Description     : edit story textbook data
    	*/
        function editstorytextbook($story_textbook_id = 0) {
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

            //! check if story_textbook_id is valid
            if($story_textbook_id == 0 || $story_textbook_id == '') {
                redirect("englishcontent/viewstorytextbook");
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $storytextbook = StoryTextbook::find($story_textbook_id);
            $body['storytextbook'] = $storytextbook;
            $body['story_textbook_id'] = $story_textbook_id;

            //! Validation rules
            $this->form_validation->set_rules('title','Title', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Edit Textbook story";
                $this->loadtemplate("englishcontent/editstorytextbook",$header,$body,$footer);
            } else {
                //! Else update data
                $error = 1;

                //! Image
                $image = "";
                if($_FILES["image"]["name"] != '') {
                    $type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $image = "_".md5(date("Y-m-d H:i:s") . $_FILES["image"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , "contentfiles/textbook/" . $image);
                    } else {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/textbook/" . $image);
                    }
                    $storytextbook->image = $image;
                }

                //! Audio
                $audio = "";
                if($_FILES["audio"]["name"] != '') {
                    $type = pathinfo($_FILES["audio"]["name"], PATHINFO_EXTENSION);
                    $audio = "_".md5(date("Y-m-d H:i:s") . $_FILES["audio"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , "contentfiles/textbook/" . $audio);
                    } else {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/textbook/" . $audio);
                    }
                    $storytextbook->audio = $audio;
                }

                //! Edit data in story text book table
                $storytextbook->title = $this->input->post('title');
                $storytextbook->title_hindi = $this->input->post('title_hindi');
                $storytextbook->title_marathi = $this->input->post('title_marathi');
                $storytextbook->content = $this->input->post('content');
                $storytextbook->content_hindi = $this->input->post('content_hindi');
                $storytextbook->content_marathi = $this->input->post('content_marathi');
                $storytextbook->unit = $this->input->post('unit');
                $storytextbook->class = $this->input->post('class');
                $storytextbook->board = $this->input->post('board');
                $storytextbook->order_number = $this->input->post('order_number');
                $storytextbook->page_number = $this->input->post('page_number');
                $storytextbook->source = $this->input->post('source');
                $storytextbook->author = $this->input->post('author');
                $storytextbook->status = $this->input->post('status');
                $storytextbook->updated_by_id = $this->user->id;
                $storytextbook->updated = date("Y-m-d H:i:s");
                $storytextbook->save();

                //! Redirect to view story textbook page
                redirect('englishcontent/viewstorytextbook/0/2');
            }
        }

        /*
    	Function name   : deletestorytextbook()
    	Parameter       : $story_textbook_id - int - story textbook id to be deleted
    	Return          : none
    	Description     : delete story textbook data
    	*/
        function deletestorytextbook( $story_textbook_id = 0 ) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                //! Redirect to view page
                redirect('englishcontent/viewstorytextbook/0/3');
                die();
            }

            //! check if id is valid
            if($story_textbook_id == 0 || $story_textbook_id == '') {
                redirect("englishcontent/viewstorytextbook");
                die();
            }

            //! Setting delete flag
            $storytextbook = StoryTextbook::find($story_textbook_id);
            $storytextbook->updated_by_id = $this->user->id;
            $storytextbook->updated = date("Y-m-d H:i:s");
            $storytextbook->delete_flag = 1;
            $storytextbook->save();

            //! Redirect to view page
            redirect('englishcontent/viewstorytextbook/0/4');

        }

        /*
    	Function name   : addwordgroup()
    	Parameter       : $error - int - Stores error no. if any default is 0
    	Return          : none
    	Description     : Add new word group and words
    	*/
        function addwordgroup($error = 0) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user has right privilege
            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['wordcount'] =  $this->_wordcount;
            $body['error'] = $error;

            //! Validation rules
            $this->form_validation->set_rules('name','Group Name', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Add Word group";
                $this->loadtemplate("englishcontent/addwordgroup",$header,$body,$footer);
            } else {

                $error = 1;

                //! Creating Group record
                $new_group = StoryTextbookGroup::create(array(
                    'name' => $this->input->post('name'),
                    'unit' => $this->input->post('unit'),
                    'class' => $this->input->post('class'),
                    'board' => $this->input->post('board'),
                    'source' => $this->input->post('source'),
                    'page_number' => $this->input->post('page_number'),
                    'status' => $this->input->post('status'),
                    'added_by_id' => $this->user->id,
                    'updated_by_id' => $this->user->id,
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                ));

                //! Check if the Group record is recorded or not
                if( isset($new_group->id )) {

                    //! Add words
                    $mmm = 1;
                    for($mm = 0 ; $mm < @$_REQUEST['count_word'] ; $mm++ ) {
                        if( @$_REQUEST['aword_' . $mm] != '' ) {
                            //! word Image
                            $aimage = "";
                            if($_FILES["aimage_" . $mm]["name"] != '') {
                                $type = pathinfo($_FILES["aimage_" . $mm]["name"], PATHINFO_EXTENSION);
                                $aimage = "_".md5(date("Y-m-d H:i:s") . $_FILES["aimage_" . $mm]["name"]) . "." . $type;
                                if(strpos(site_url(),'localhost') !== false ) {
                                    move_uploaded_file ( $_FILES["aimage_" . $mm]["tmp_name"] , "contentfiles/word/" . $aimage);
                                } else {
                                    move_uploaded_file ( $_FILES["aimage_" . $mm]["tmp_name"] , $this->config->item("root_url") . "contentfiles/word/" . $aimage);
                                }
                            }

                            //! word Audio
                            $aaudio = "";
                            if($_FILES["aaudio_" . $mm]["name"] != '') {
                                $type = pathinfo($_FILES["aaudio_" . $mm]["name"], PATHINFO_EXTENSION);
                                $aaudio = "_".md5(date("Y-m-d H:i:s") . $_FILES["aaudio_" . $mm]["name"]) . "." . $type;
                                if(strpos(site_url(),'localhost') !== false ) {
                                    move_uploaded_file ( $_FILES["aaudio_" . $mm]["tmp_name"] , "contentfiles/word/" . $aaudio);
                                } else {
                                    move_uploaded_file ( $_FILES["aaudio_" . $mm]["tmp_name"] , $this->config->item("root_url") . "contentfiles/word/" . $aaudio);
                                }
                            }

                            //! Create word record
                            $new_word = Word::create(array(
                                'word' => $this->input->post('aword_' . $mm),
                                'level' => $this->input->post('alevel_' . $mm),
                                'hindi_translation' => $this->input->post('ahindi_translation_' . $mm),
                                'marathi_translation' => $this->input->post('amarathi_translation_' . $mm),
                                'defination' => $this->input->post('adefination_' . $mm),
                                'example' => $this->input->post('aexample_' . $mm),
                                'image' => $aimage,
                                'audio' => $aaudio,
                                'added_by_id' => $this->user->id,
                                'updated_by_id' => $this->user->id,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));

                            //! Check if the word record is created or not
                            if(isset($new_word->id)) {
                                //! Create the Group Word Linkage
                                $new_group_word_linkage = StoryTextbookGroupWordLinkage::create(array(
                                    'story_textbook_group_id' => $new_group->id,
                                    'word_id' => $new_word->id,
                                    'order_number' => $mmm,
                                    'added_by_id' => $this->user->id,
                                    'updated_by_id' => $this->user->id,
                                    'created' => date("Y-m-d H:i:s"),
                                    'updated' => date("Y-m-d H:i:s"),
                                ));

                                $mmm++;
                            }
                        }
                    }
                }

                redirect('englishcontent/viewwordgroup/0/' . $error);
            }
        }

        /*
    	Function name   : viewwordgroup()
    	Parameter       : $page - int - Stores the page no. if any, default is 0
                          $error - int - Stores error no. if any, default is 0
    	Return          : none
    	Description     : View word group list
    	*/
        function viewwordgroup($page = 0,$error = 0) {
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
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['page'] = $page;
            $body['error'] = $error;
            $header['title'] = "View Word group ";

            //! Display the list
            $this->loadtemplate("englishcontent/viewwordgroup",$header,$body,$footer);
        }

        /*
    	Function name   : editwordgroup()
    	Parameter       : $group_word_id - int - group word id to be edited
    	Return          : none
    	Description     : edit group word data
    	*/
        function editwordgroup($group_word_id = 0) {
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

            //! check if group_word_id is valid
            if($group_word_id == 0 || $group_word_id == '') {
                redirect("englishcontent/viewwordgroup");
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $wordgroup = StoryTextbookGroup::find($group_word_id);
            $body['wordgroup'] = $wordgroup;
            $body['group_word_id'] = $group_word_id;
            $body['wordcount'] =  $this->_wordcount;

            //! Validation rules
            $this->form_validation->set_rules('name','Group Name', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Edit word group";
                $this->loadtemplate("englishcontent/editwordgroup",$header,$body,$footer);
            } else {
                //! Else update
                $error = 1;

                //! Edit data in grapheme table
                $wordgroup->name = $this->input->post('name');
                $wordgroup->unit = $this->input->post('unit');
                $wordgroup->class = $this->input->post('class');
                $wordgroup->board = $this->input->post('board');
                $wordgroup->source = $this->input->post('source');
                $wordgroup->page_number = $this->input->post('page_number');
                $wordgroup->status = $this->input->post('status');
                $wordgroup->updated_by_id = $this->user->id;
                $wordgroup->updated = date("Y-m-d H:i:s");
                $wordgroup->save();

                //! Add words
                $mmm = 1;
                for($mm = 0 ; $mm < @$_REQUEST['count_word'] ; $mm++ ) {
                    if( @$_REQUEST['aword_' . $mm] != '' ) {
                        //! word Image
                        $aimage = "";
                        if($_FILES["aimage_" . $mm]["name"] != '') {
                            $type = pathinfo($_FILES["aimage_" . $mm]["name"], PATHINFO_EXTENSION);
                            $aimage = "_".md5(date("Y-m-d H:i:s") . $_FILES["aimage_" . $mm]["name"]) . "." . $type;
                            if(strpos(site_url(),'localhost') !== false ) {
                                move_uploaded_file ( $_FILES["aimage_" . $mm]["tmp_name"] , "contentfiles/word/" . $aimage);
                            } else {
                                move_uploaded_file ( $_FILES["aimage_" . $mm]["tmp_name"] , $this->config->item("root_url") . "contentfiles/word/" . $aimage);
                            }
                        }

                        //! word Audio
                        $aaudio = "";
                        if($_FILES["aaudio_" . $mm]["name"] != '') {
                            $type = pathinfo($_FILES["aaudio_" . $mm]["name"], PATHINFO_EXTENSION);
                            $aaudio = "_".md5(date("Y-m-d H:i:s") . $_FILES["aaudio_" . $mm]["name"]) . "." . $type;
                            if(strpos(site_url(),'localhost') !== false ) {
                                move_uploaded_file ( $_FILES["aaudio_" . $mm]["tmp_name"] , "contentfiles/word/" . $aaudio);
                            } else {
                                move_uploaded_file ( $_FILES["aaudio_" . $mm]["tmp_name"] , $this->config->item("root_url") . "contentfiles/word/" . $aaudio);
                            }
                        }

                        //! Check for word id
                        if( @$_REQUEST['aword_id_' . $mm] != '') {
                            //! Update word
                            $aword = Word::find(@$_REQUEST['aword_id_' . $mm]);

                            if($aimage != '') {
                                $aword->image = $aimage;
                            }
                            if($aaudio != '') {
                                $aword->audio = $aaudio;
                            }
                            $aword->word = $this->input->post('aword_' . $mm);
                            $aword->level = $this->input->post('alevel_' . $mm);
                            $aword->hindi_translation = $this->input->post('ahindi_translation_' . $mm);
                            $aword->marathi_translation = $this->input->post('amarathi_translation_' . $mm);
                            $aword->defination = $this->input->post('adefination_' . $mm);
                            $aword->example = $this->input->post('aexample_' . $mm);
                            $aword->updated_by_id = $this->user->id;
                            $aword->updated = date("Y-m-d H:i:s");
                            $aword->save();

                            $gw_linkage = StoryTextbookGroupWordLinkage::find("all",array(
                                "conditions" => " word_id = '".$aword->id."' AND story_textbook_group_id = '".$wordgroup->id."' "
                            ));

                            if(isset($gw_linkage[0])) {
                                $gw_linkage[0]->order_number = $mmm;
                                $gw_linkage[0]->updated_by_id = $this->user->id;
                                $gw_linkage[0]->updated = date("Y-m-d H:i:s");
                                $gw_linkage[0]->save();
                                $mmm++;
                            }
                        } else {
                            //! Create word record
                            $new_word = Word::create(array(
                                'word' => $this->input->post('aword_' . $mm),
                                'level' => $this->input->post('alevel_' . $mm),
                                'hindi_translation' => $this->input->post('ahindi_translation_' . $mm),
                                'marathi_translation' => $this->input->post('amarathi_translation_' . $mm),
                                'defination' => $this->input->post('adefination_' . $mm),
                                'example' => $this->input->post('aexample_' . $mm),
                                'image' => $aimage,
                                'audio' => $aaudio,
                                'added_by_id' => $this->user->id,
                                'updated_by_id' => $this->user->id,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));

                            //! Create the Group Word Linkage
                            $new_group_word_linkage = StoryTextbookGroupWordLinkage::create(array(
                                'story_textbook_group_id' => $wordgroup->id,
                                'word_id' => $new_word->id,
                                'order_number' => $mmm,
                                'added_by_id' => $this->user->id,
                                'updated_by_id' => $this->user->id,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));

                            $mmm++;
                        }
                    } else {
                        if( @$_REQUEST['aword_id_' . $mm] != '') {
                            StoryTextbookGroupWordLinkage::delete_all(array(
            				    'conditions' => array(
            					    'word_id' => @$_REQUEST['aword_id_' . $mm],
            					)
            				));
                        }
                    }
                }

                //! Redirect to view grapheme page
                redirect('englishcontent/viewwordgroup/0/2');
            }
        }

        /*
    	Function name   : deletewordgroup()
    	Parameter       : $word_group_id - int - word group id to be deleted
    	Return          : none
    	Description     : delete word group data
    	*/
        function deletewordgroup( $word_group_id = 0 ) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                //! Redirect to view page
                redirect('englishcontent/viewwordgroup/0/3');
                die();
            }

            //! check if id is valid
            if($word_group_id == 0 || $word_group_id == '') {
                redirect("englishcontent/viewwordgroup");
                die();
            }

            //! Setting delete flag
            $wordgroup = StoryTextbookGroup::find($word_group_id);
            $wordgroup->updated_by_id = $this->user->id;
            $wordgroup->updated = date("Y-m-d H:i:s");
            $wordgroup->delete_flag = 1;
            $wordgroup->save();

            //! Redirect to view page
            redirect('englishcontent/viewwordgroup/0/4');

        }

        /*
    	Function name   : editword()
    	Parameter       : $word - string - word
    	Return          : none
    	Description     : edit wordsegment data
    	*/
        function editword($word = '') {
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

            //! check if wordsegment_id is valid
            if($word == '') {
                redirect("englishcontent/viewwordsegment");
                die();
            }

            $wordsegment = Wordsegment::find("all",array(
                "conditions" => " word = '$word' AND (delete_flag = 0 OR delete_flag IS NULL ) "
            ));

            if(isset($wordsegment[0])) {
                redirect('englishcontent/editwordsegment/' . $wordsegment[0]->id);
                die();
            } else {
                redirect("englishcontent/viewwordsegment");
                die();
            }
        }

        //! Get the translation for the word
        function getwordtranslated() {
            $word = @$_REQUEST['word'];

            if($word != '') {
                $www = Word::find_by_word($word);

                if(isset($www->id)) {
                    $trans = array();

                    foreach($www->word_translation as $val) {
                        $trans[] = $val->language_id . ";;;" . $val->translation . ";;;" . $val->id;
                    }

                    echo implode(":::",$trans);
                }
            }
        }

        function getwordtranslated1() {
            $word = @$_REQUEST['word'];

            if($word != '') {
                $www = Word::find_by_word($word);

                if(isset($www->id)) {
                    $trans = array();

                    foreach($www->word_transliteration as $val) {
                        $trans[] = $val->language_id . ";;;" . $val->translation . ";;;" . $val->id;
                    }

                    echo implode(":::",$trans);
                }
            }
        }

        /*
    	Function name   : addvowelblend()
    	Parameter       : $error - int - Stores error no. if any default is 0
    	Return          : none
    	Description     : Add new vowel blend
    	*/
        function addvowelblend($error = 0) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user has right privilege
            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['error'] = $error;

            //! Validation rules
            $this->form_validation->set_rules('vowel','Vowel', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Add Vowel Blend";
                $body['words'] = Wordsegment::find("all",array(
                    "select" => "id, word",
                    "conditions" => "created >= '".$this->_oldDate."' AND image != '' AND  ( delete_flag = 0 OR delete_flag IS NULL )  ",
                    "order" => " word ASC ",
                    "group" => "word",
                ));
                $this->loadtemplate("englishcontent/addvowelblend",$header,$body,$footer);
            } else {

                $error = 1;

                //! Image
                $image = "";
                if($_FILES["image"]["name"] != '') {
                    $type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $image = "_".md5(date("Y-m-d H:i:s") . $_FILES["image"]["name"] . rand(0,99999)) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , "contentfiles/vowelblend/" . $image);
                    } else {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/vowelblend/" . $image);
                    }
                }

                //! Audio
                $audio = "";
                if($_FILES["audio"]["name"] != '') {
                    $type = pathinfo($_FILES["audio"]["name"], PATHINFO_EXTENSION);
                    $audio = "_".md5(date("Y-m-d H:i:s") . $_FILES["audio"]["name"]) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , "contentfiles/vowelblend/" . $audio);
                    } else {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/vowelblend/" . $audio);
                    }
                }

                $vb_array = array(
                    'vowel' => $this->input->post('vowel'),
                    'secondary_letter' => $this->input->post('secondary_letter'),
                    'level' => $this->input->post('level'),
                    'unit' => $this->input->post('unit'),
                    'order_num' => $this->input->post('order_num'),
                    'image' => $image,
                    'audio' => $audio,
                    'wordsegment_id' => $this->input->post('wordsegment_id'),
                    'added_by_id' => $this->user->id,
                    'updated_by_id' => $this->user->id,
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                );

                //! Creating record
                $new_vb = VowelBlend::create($vb_array);

                redirect('englishcontent/viewvowelblend/0/' . $error);
            }
        }

        /*
    	Function name   : viewvowelblend()
    	Parameter       : $page - int - Stores the page no. if any, default is 0
                          $error - int - Stores error no. if any, default is 0
    	Return          : none
    	Description     : View vowel blend list
    	*/
        function viewvowelblend($page = 0,$error = 0) {
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

            $vbs = VowelBlend::find('all',array(
                'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL ) ",
                "order" => 'id ASC'
            ));

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['vbs'] = $vbs;
            $body['page'] = $page;
            $body['error'] = $error;
            $header['title'] = "View vowel blend";

            //! Display the list
            $this->loadtemplate("englishcontent/viewvowelblend",$header,$body,$footer);
        }

        /*
    	Function name   : editvowelblend()
    	Parameter       : $vowelblend_id - int - vowelblend id to be edited
    	Return          : none
    	Description     : edit vowelblend data
    	*/
        function editvowelblend($vowelblend_id = 0) {
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

            //! check if id is valid
            if($vowelblend_id == 0 || $vowelblend_id == '') {
                redirect("englishcontent/viewvowelblend");
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $vowelblend = VowelBlend::find($vowelblend_id);
            $body['vowelblend'] = $vowelblend;
            $body['vowelblend_id'] = $vowelblend_id;

            //! Validation rules
            $this->form_validation->set_rules('vowel','Vowel', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Edit vowel blend";
                $body['words'] = Wordsegment::find("all",array(
                    "select" => "id, word",
                    "conditions" => "created >= '".$this->_oldDate."' AND image != '' AND  ( delete_flag = 0 OR delete_flag IS NULL )  ",
                    "order" => " word ASC ",
                    "group" => "word",
                ));
                $this->loadtemplate("englishcontent/editvowelblend",$header,$body,$footer);
            } else {
                //! Else update the question data
                $error = 1;

                //! Image
                $image = "";
                if($_FILES["image"]["name"] != '') {
                    $type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $image = "_".md5(date("Y-m-d H:i:s") . $_FILES["image"]["name"] . rand(0,99999)) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , "contentfiles/vowelblend/" . $image);
                    } else {
                        move_uploaded_file ( $_FILES["image"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/vowelblend/" . $image);
                    }
                    $vowelblend->image = $image;
                }

                //! Audio
                $audio = "";
                if($_FILES["audio"]["name"] != '') {
                    $type = pathinfo($_FILES["audio"]["name"], PATHINFO_EXTENSION);
                    $audio = "_".md5(date("Y-m-d H:i:s") . $_FILES["audio"]["name"].rand(0,99999)) . "." . $type;
                    if(strpos(site_url(),'localhost') !== false ) {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , "contentfiles/vowelblend/" . $audio);
                    } else {
                        move_uploaded_file ( $_FILES["audio"]["tmp_name"] , $this->config->item("root_url") . "contentfiles/vowelblend/" . $audio);
                    }
                    $vowelblend->audio = $audio;
                }

                //! Edit data in table
                $vowelblend->vowel = $this->input->post('vowel');
                $vowelblend->secondary_letter = $this->input->post('secondary_letter');
                $vowelblend->level = $this->input->post('level');
                $vowelblend->unit = $this->input->post('unit');
                $vowelblend->order_num = $this->input->post('order_num');
                $vowelblend->wordsegment_id = $this->input->post('wordsegment_id');
                $vowelblend->updated_by_id = $this->user->id;
                $vowelblend->updated = date("Y-m-d H:i:s");
                $vowelblend->save();

                //! Redirect to view page
                redirect('englishcontent/viewvowelblend/0/2');
            }
        }

        /*
    	Function name   : deletevowelblend()
    	Parameter       : $vowelblend_id - int - vowelblend id to be deleted
    	Return          : none
    	Description     : delete vowelblend data
    	*/
        function deletevowelblend( $vowelblend_id = 0 ) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                //! Redirect to view page
                redirect('englishcontent/viewvowelblend/0/3');
                die();
            }

            //! check if id is valid
            if($vowelblend_id == 0 || $vowelblend_id == '') {
                redirect("englishcontent/viewvowelblend");
                die();
            }

            //! Setting delete flag
            $vb = VowelBlend::find($vowelblend_id);
            $vb->updated_by_id = $this->user->id;
            $vb->updated = date("Y-m-d H:i:s");
            $vb->delete_flag = 1;
            $vb->save();

            //! Redirect to view page
            redirect('englishcontent/viewvowelblend/0/4');

        }

        /*
    	Function name   : addactivity()
    	Parameter       : $error - int - Stores error no. if any default is 0
    	Return          : none
    	Description     : Add new activity
    	*/
        function addactivity($error = 0) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user has right privilege
            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['error'] = $error;

            //! Validation rules
            $this->form_validation->set_rules('name','Activity Name', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Add activity";
                $body['stypes'] = $this->stypes;
                $body['worlds'] = $this->_worlds;
                $body['categories'] = $this->_categories;

                $this->loadtemplate("englishcontent/addactivity",$header,$body,$footer);
            } else {
                $error = 1;

                $challenge = 0;
                if(isset($_REQUEST['challenge'])) {
                    $challenge = 1;
                }

                $activity_array = array(
                    'name' => $this->input->post('name'),
                    'level' => $this->input->post('level'),
                    'unit' => $this->input->post('unit'),
                    'activity_num' => $this->input->post('activity_num'),
                    'activity_type' => '',
                    'point' => $this->input->post('point'),
                    'score' => $this->input->post('score'),
                    'stars' => $this->input->post('stars'),
                    'added_by_id' => $this->user->id,
                    'updated_by_id' => $this->user->id,
                    'challenge' => $challenge,
                    'world' => $this->input->post('world'),
                    'category' => $this->input->post('category'),
                    'description' => $this->input->post('description'),
                    'tags' => $this->input->post('tags'),
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                );

                //! Creating record
                $new_activity = Activity::create($activity_array);

                //! Check if the record is created or not
                if( isset($new_activity->id )) {

                    for($mm = 0 ; $mm < count($_REQUEST['language_trans']) ; $mm++ ) {
                        if( @$_REQUEST['language_trans'][$mm] != '' ) {
                            $new_wt = ActivityTranslation::create(array(
                                'activity_id' => $new_activity->id,
                                'language_id' => @$_REQUEST['language_id'][$mm],
                                'translation' => @$_REQUEST['language_trans'][$mm],
                                'added_by_id' => $this->user->id,
                                'updated_by_id' => $this->user->id,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));
                        }
                    }

                    //! Add Activity linkage
                    for($mm = 0 ; $mm < count($_REQUEST['activity_type']) ; $mm++ ) {
                        if( @$_REQUEST['activity_type'][$mm] != '' ) {

                            $sudo = explode("***",@$_REQUEST['type_id'][$mm]);

                            $additional_info = array();
                            if(isset($sudo[1])) {
                                if( @$_REQUEST['activity_type'][$mm] == "first_last_sound" ) {
                                    $additional_info["letter_at"] = @$sudo[1];
                                }
                            }

                            if( @$_REQUEST['activity_type'][$mm] == "missing_letter" ) {
                                $additional_info["missing_letter"] = @$_REQUEST['ml_grapheme'][$mm];
                            }

                            if( @$_REQUEST['activity_type'][$mm] == "phrase_game" ) {
                                $additional_info["missing_word"] = @$_REQUEST['ml_grapheme'][$mm];
                            }

                            if( @$_REQUEST['act_count'][$mm] != "" ) {
                                $additional_info["count"] = @$_REQUEST['act_count'][$mm];
                            }

                            if( @$_REQUEST['activity_type'][$mm] == "listen_to_a_sound_random" ) {
                                $sudo[0] = '0';
                                $additional_info["graphemes"] = @$_REQUEST['type_id1'][$mm];
                            }

                            //! Create record
                            $new_al = ActivityLinkage::create(array(
                                'activity_id' => $new_activity->id,
                                'type_id' => @$sudo[0],
                                'type' =>  @$_REQUEST['activity_type'][$mm],
                                'order_num' => @$_REQUEST['order_num'][$mm],
                                'additional_info' => json_encode($additional_info),
                                'added_by_id' => $this->user->id,
                                'updated_by_id' => $this->user->id,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));
                        }
                    }

                }

                redirect('englishcontent/viewactivity/0/' . $error);
            }
        }

        /*
    	Function name   : viewactivity()
    	Parameter       : $page - int - Stores the page no. if any, default is 0
                          $error - int - Stores error no. if any, default is 0
    	Return          : none
    	Description     : View activity list
    	*/
        function viewactivity($page = 0,$error = 0) {
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

            $activities = Activity::find('all',array(
                'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL ) ",
                "order" => 'level,activity_num ASC'
            ));

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['activities'] = $activities;
            $body['page'] = $page;
            $body['error'] = $error;
            $header['title'] = "View activities";

            //! Display the list
            $this->loadtemplate("englishcontent/viewactivity",$header,$body,$footer);
        }

        /*
    	Function name   : editactivity()
    	Parameter       : $activity_id - int - activity id to be edited
    	Return          : none
    	Description     : edit activity data
    	*/
        function editactivity($activity_id = 0) {
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

            //! check if id is valid
            if($activity_id == 0 || $activity_id == '') {
                redirect("englishcontent/viewactivity");
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $activity = Activity::find($activity_id);
            $body['activity'] = $activity;
            $body['activity_id'] = $activity_id;

            //! Validation rules
            $this->form_validation->set_rules('name','Activity Name', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Edit activity";
                $body['stypes'] = $this->stypes;
                $body['worlds'] = $this->_worlds;
                $body['categories'] = $this->_categories;
                $this->loadtemplate("englishcontent/editactivity",$header,$body,$footer);
            } else {
                //! Else update the question data
                $error = 1;

                $challenge = 0;
                if(isset($_REQUEST['challenge'])) {
                    $challenge = 1;
                }

                //! Edit data in table
                $activity->name = $this->input->post('name');
                $activity->level = $this->input->post('level');
                $activity->unit = $this->input->post('unit');
                $activity->activity_num = $this->input->post('activity_num');
                $activity->activity_type = '';
                $activity->point = $this->input->post('point');
                $activity->score = $this->input->post('score');
                $activity->stars = $this->input->post('stars');
                $activity->updated_by_id = $this->user->id;
                $activity->challenge = $challenge;
                $activity->world = $this->input->post('world');
                $activity->category = $this->input->post('category');
                $activity->description = $this->input->post('description');
                $activity->tags = $this->input->post('tags');
                $activity->updated = date("Y-m-d H:i:s");
                $activity->save();

                for($mm = 0 ; $mm < count($_REQUEST['language_trans']) ; $mm++ ) {
                    if( @$_REQUEST['language_trans'][$mm] != '' ) {
                        //! Check for the primary word
                        if( @$_REQUEST['qt_id'][$mm] != '') {

                            $wt = ActivityTranslation::find(@$_REQUEST['qt_id'][$mm]);

                            $wt->translation = @$_REQUEST['language_trans'][$mm];
                            $wt->updated_by_id = $this->user->id;
                            $wt->updated = date("Y-m-d H:i:s");
                            $wt->save();
                        } else {
                            //! Create record
                            $new_wt = ActivityTranslation::create(array(
                                'activity_id' => $activity->id,
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
                            ActivityTranslation::delete_all(array(
        	    			    'conditions' => array(
        		    			    'id' => @$_REQUEST['qt_id'][$mm],
        			    		)
        				    ));
                        }
                    }
                }

                 ActivityLinkage::delete_all(array(
                    'conditions' => array(
                	    'activity_id' => $activity->id,
                	)
                 ));

                //! Add Activity linkage
                for($mm = 0 ; $mm < count($_REQUEST['type_id']) ; $mm++ ) {
                    if( @$_REQUEST['activity_type'][$mm] != '' ) {

                        $sudo = explode("***",@$_REQUEST['type_id'][$mm]);

                        $additional_info = array();
                        if(isset($sudo[1])) {
                            if( @$_REQUEST['activity_type'][$mm] == "first_last_sound" ) {
                                $additional_info["letter_at"] = @$sudo[1];
                            }
                        }

                        if( @$_REQUEST['activity_type'][$mm] == "missing_letter" ) {
                            $additional_info["missing_letter"] = @$_REQUEST['ml_grapheme'][$mm];
                        }

                        if( @$_REQUEST['activity_type'][$mm] == "phrase_game" ) {
                            $additional_info["missing_word"] = @$_REQUEST['ml_grapheme'][$mm];
                        }

                        if( @$_REQUEST['act_count'][$mm] != "" ) {
                            $additional_info["count"] = @$_REQUEST['act_count'][$mm];
                        }

                        if( @$_REQUEST['activity_type'][$mm] == "listen_to_a_sound_random" ) {
                            $sudo[0] = '';
                            $additional_info["graphemes"] = @$_REQUEST['type_id1'][$mm];
                        }

                        //! Create record
                        $new_al = ActivityLinkage::create(array(
                            'activity_id' => $activity->id,
                            'type_id' => @$sudo[0],
                            'type' => @$_REQUEST['activity_type'][$mm],
                            'order_num' => @$_REQUEST['order_num'][$mm],
                            'additional_info' => json_encode($additional_info),
                            'added_by_id' => $this->user->id,
                            'updated_by_id' => $this->user->id,
                            'created' => date("Y-m-d H:i:s"),
                            'updated' => date("Y-m-d H:i:s"),
                        ));
                    }
                }

                //! Redirect to view page
                redirect('englishcontent/viewactivity/0/2');
            }
        }

        /*
    	Function name   : deleteactivity()
    	Parameter       : $activity_id - int - activity id to be deleted
    	Return          : none
    	Description     : delete activity data
    	*/
        function deleteactivity( $activity_id = 0 ) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                //! Redirect to view page
                redirect('englishcontent/viewvowelblend/0/3');
                die();
            }

            //! check if id is valid
            if($activity_id == 0 || $activity_id == '') {
                redirect("englishcontent/viewactivity");
                die();
            }

            //! Setting delete flag
            $activity = Activity::find($activity_id);
            $activity->updated_by_id = $this->user->id;
            $activity->updated = date("Y-m-d H:i:s");
            $activity->delete_flag = 1;
            $activity->save();

            //! Redirect to view page
            redirect('englishcontent/viewactivity/0/4');

        }

        function getactivitydata() {
            $type = @$_REQUEST['type'];

            if($type != '') {

                $str = array();

                switch($type) {
                    case "learn_letter":
                        $letter = Grapheme::find('all',array(
                            'select' => " id, grapheme,phoneme  ",
                            "conditions" => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."' AND CHAR_LENGTH(grapheme) = 1 ",
                            "order" => 'grapheme ASC'
                        ));

                        foreach($letter as $val) {
                            $str[] = $val->id . ":::" . $val->grapheme . " (".$val->phoneme.")";
                        }
                        break;

                    case "listen_to_a_sound":
                    case "trace_grapheme":
                    case "learn_grapheme":
                        $graphemes = Grapheme::find('all',array(
                            'select' => " id, grapheme,phoneme  ",
                            "conditions" => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."' ",
                            "order" => 'grapheme ASC'
                        ));

                        foreach($graphemes as $val) {
                            $str[] = $val->id . ":::" . $val->grapheme . " (".$val->phoneme.")";
                        }
                        break;

                    case "local_language_blend":
                        $data = Wordsegment::find('all',array(
                            'select' => " id,word ",
                            'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."' AND primary_segment != '' ",
                            'group' => 'word',
                            "order" => 'word ASC'
                        ));

                        foreach($data as $val) {
                            $str[] = $val->id . ":::" . $val->word;
                        }
                        break;

                    case "vowel_blend_trace":
                    case "vowel_blend":
                        $data = VowelBlend::find('all',array(
                            'select' => " id, secondary_letter, vowel ",
                            'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL ) ",
                            "order" => 'vowel,secondary_letter ASC'
                        ));

                        foreach($data as $val) {
                            $str[] = $val->id . ":::" . $val->secondary_letter . $val->vowel;
                        }
                        break;

                    case "word_game":
                    case "spelling":
                        $data = Wordsegment::find('all',array(
                            'select' => " word, id ",
                            'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."' ",
                            "group" => 'word',
                            "order" => 'word ASC'
                        ));

                        foreach($data as $val) {
                            $str[] = $val->id . ":::" . $val->word;
                        }
                        break;

                    case "segmenting_blending":
                        $data = Wordsegment::find('all',array(
                            'select' => " word, id ",
                            'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."' AND LENGTH(word) <= 6 ",
                            "group" => 'word',
                            "order" => 'word ASC'
                        ));

                        foreach($data as $val) {
                            $str[] = $val->id . ":::" . $val->word;
                        }
                        break;

                    case "vocab":
                        $data = Wordsegment::find('all',array(
                            'select' => " word, id ",
                            'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."' AND image != '' ",
                            "group" => 'word',
                            "order" => 'word ASC'
                        ));

                        foreach($data as $val) {
                            $str[] = $val->id . ":::" . $val->word;
                        }
                        break;

                    case "missing_letter":
                        $data = Wordsegment::find('all',array(
                            'select' => " word, id ",
                            'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."' AND image != '' AND LENGTH(word) <= 5 ",
                            "group" => 'word',
                            "order" => 'word ASC'
                        ));

                        foreach($data as $val) {
                            $str[] = $val->id . ":::" . $val->word;
                        }
                        break;

                    case "word_game_random":
                        $data = Wordsegment::find('all',array(
                            'select' => " concept, id, COUNT(id) AS icount ",
                            'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."' ",
                            "group" => 'concept',
                            "order" => 'concept ASC'
                        ));

                        foreach($data as $val) {
                            $str[] = $val->id . ":::" . $val->concept . " (".$val->icount.")";
                        }
                        break;

                    case "segmenting_blending_random":
                        $data = Wordsegment::find('all',array(
                            'select' => " concept, id, COUNT(id) AS icount ",
                            'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."' AND LENGTH(word) <= 6  ",
                            "group" => 'concept',
                            "order" => 'concept ASC'
                        ));

                        foreach($data as $val) {
                            $str[] = $val->id . ":::" . $val->concept . " (".$val->icount.")";
                        }
                        break;

                    case "vocabconceptrandom":
                        $data = Wordsegment::find('all',array(
                            'select' => " concept, id, COUNT(id) AS icount ",
                            'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."' AND image != '' ",
                            "group" => 'concept',
                            "order" => 'concept ASC'
                        ));

                        foreach($data as $val) {
                            $str[] = $val->id . ":::" . $val->concept . " (".$val->icount.")";
                        }
                        break;

                    case "story":
                        $data = Story::find("all",array(
                            "select" => "id, name",
                            "conditions" => " status = 'active' ",
                            "order" => "name ASC"
                        ));

                        foreach($data as $val) {
                            $str[] = $val->id . ":::" . $val->name;
                        }
                        break;

                    case "phrase":
                        $data = Phrase::find('all',array(
                            'select' => " phrase, id",
                            'conditions' => " type = 'phrase' AND ( delete_flag = 0 OR delete_flag IS NULL )  AND created >= '".$this->_oldDate."' ",
                            "order" => 'phrase ASC'
                        ));


                        foreach($data as $val) {
                            $str[] = $val->id . ":::" . $val->phrase . " (".count($val->phrase_sentence_linkage).")";
                        }
                        break;

                    case "phrase_game":
                        $data = Phrase::find('all',array(
                            'select' => " phrase, id",
                            'conditions' => " type = 'phrase' AND ( delete_flag = 0 OR delete_flag IS NULL )  AND created >= '".$this->_oldDate."' ",
                            "order" => 'phrase ASC'
                        ));


                        foreach($data as $val) {
                            $data1 = PhraseSentenceLinkage::find("all",array(
                                "joins" => "JOIN mg_sentence ON mg_phrase_sentence_linkage.sentence_id = mg_sentence.id",
                                "select" => "mg_sentence.id,mg_sentence.sentence",
                                'conditions' => " mg_phrase_sentence_linkage.phrase_id = '".$val->id."' ",
                            ));
                            foreach($data1 as $val1) {
                                $str[] = $val1->id . ":::" . $val1->sentence . " [". $val->phrase . "]";
                            }
                        }
                        break;

                    case "rhymes":
                        $data = Phrase::find('all',array(
                            'select' => " phrase, id",
                            'conditions' => " type = 'rhymes' AND ( delete_flag = 0 OR delete_flag IS NULL )  AND created >= '".$this->_oldDate."' ",
                            "order" => 'phrase ASC'
                        ));

                        foreach($data as $val) {
                            $str[] = $val->id . ":::" . $val->phrase;
                        }
                        break;

                    case "grammarrandom":
                        $data = Question::find('all',array(
                            'joins' => "JOIN mg_concepts_question_linkage ON mg_concepts_question_linkage.question_id = mg_question.id
                                        JOIN mg_concepts ON mg_concepts_question_linkage.concepts_id = mg_concepts.id",
                            'select' => " mg_concepts.id, mg_concepts.name, COUNT(mg_question.id) AS icount  ",
                            'conditions' => " mg_question.meta_type = 'fixed' AND mg_question.status = 'active' AND mg_concepts.units_id = '21' ",
                            'group' => " mg_concepts.id ",
                            "order" => 'mg_concepts.name ASC'
                        ));
                        // 21
                        foreach($data as $val) {
                            $str[] = $val->id . ":::" . $val->name . " (".$val->icount.")" ;
                        }
                        break;

                    case "grammarrandom_specific":
                        $data = Question::find('all',array(
                            'joins' => "JOIN mg_concepts_question_linkage ON mg_concepts_question_linkage.question_id = mg_question.id
                                        JOIN mg_concepts ON mg_concepts_question_linkage.concepts_id = mg_concepts.id",
                            'select' => " mg_question.id, mg_concepts.name,mg_question.title, COUNT(mg_question.id) AS icount  ",
                            'conditions' => " mg_question.meta_type = 'fixed' AND mg_question.status = 'active' AND mg_concepts.units_id = '21' ",
                            'group' => " mg_concepts.id,mg_question.title  ",
                            "order" => 'mg_concepts.name,mg_question.id  ASC'
                        ));
                        // 21
                        foreach($data as $val) {
                            $str[] = $val->id . ":::" . $val->name ." (".$val->title.") [".$val->icount."]" ;
                        }
                        break;

                    case "grammar":
                        $data = Question::find('all',array(
                            'joins' => "JOIN mg_concepts_question_linkage ON mg_concepts_question_linkage.question_id = mg_question.id
                                        JOIN mg_concepts ON mg_concepts_question_linkage.concepts_id = mg_concepts.id
                                        ",
                            'select' => " mg_question.id, mg_question.question, mg_concepts.name  ",
                            'conditions' => " mg_question.meta_type = 'fixed' AND mg_question.status = 'active' AND mg_concepts.units_id = '21' ",
                            "order" => 'mg_question.id ASC'
                        ));
                        // 21
                        foreach($data as $val) {
                            $ques_obj = json_decode($val->question);
                            $str[] = $val->id . ":::" . $ques_obj->question->text . " (".$val->name.") [".$ques_obj->question->type."]";
                        }
                        break;

                    case "reading_test":
                        $data = Question::find('all',array(
                            'joins' => "JOIN mg_concepts_question_linkage ON mg_concepts_question_linkage.question_id = mg_question.id
                                        JOIN mg_concepts ON mg_concepts_question_linkage.concepts_id = mg_concepts.id",
                            'select' => " mg_concepts.id, mg_concepts.name, COUNT(mg_question.id) AS icount  ",
                            'conditions' => " mg_question.meta_type = 'fixed' AND mg_question.status = 'active' AND mg_concepts.units_id = '22' ",
                            'group' => " mg_concepts.id ",
                            "order" => 'mg_concepts.name ASC'
                        ));

                        // 21
                        foreach($data as $val) {
                            $str[] = $val->id . ":::" . $val->name . " (".$val->icount.")" ;
                        }
                        break;

                    case "first_last_sound":
                        $letter = Grapheme::find('all',array(
                            'select' => " id,grapheme ",
                            "conditions" => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."' AND CHAR_LENGTH(grapheme) = 1 ",
                            "order" => 'grapheme ASC'
                        ));

                        foreach($letter as $val) {
                            $count = Wordsegment::find("all",array(
                                "select" => "id",
                                'conditions' => "( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."' AND image != '' AND word LIKE '".$val->grapheme."%' ",
                                'group' => "word"
                            ));
                            $str[] = $val->id . "***first:::First letter " . $val->grapheme . " (".count($count).")";
                            if(in_array($val->grapheme,array("a","e","i","o","u"))) {
                                $count1 = Wordsegment::find("all",array(
                                    "select" => "id",   
                                    'conditions' => "( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."' AND image != '' AND word LIKE '%".$val->grapheme."%' AND word NOT LIKE '".$val->grapheme."%' AND word NOT LIKE '%".$val->grapheme."' ",
                                    'group' => "word"
                                ));
                                $str[] = $val->id . "***middle:::Middle letter " . $val->grapheme . " (".count($count1).")";
                            } else {
                                $count1 = Wordsegment::find("all",array(
                                    "select" => "id",
                                    'conditions' => "( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."' AND image != '' AND word LIKE '%".$val->grapheme."' ",
                                    'group' => "word"
                                ));
                                $str[] = $val->id . "***last:::Last letter " . $val->grapheme ." (".count($count1).")";
                            }
                        }
                        break;

                    case "vocabrandom":
                        $graphemes = Grapheme::find('all',array(
                            'select' => " id,grapheme ",
                            "conditions" => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."' ",
                            "order" => 'grapheme ASC'
                        ));

                        foreach($graphemes as $val) {
                            $count = Wordsegment::find("all",array(
                                'select' => "mg_grapheme_wordsegment_linkage.id",
                                'joins' => "JOIN mg_grapheme_wordsegment_linkage ON mg_grapheme_wordsegment_linkage.wordsegment_id = mg_wordsegment.id",
                                'conditions' => "( mg_wordsegment.delete_flag = 0 OR mg_wordsegment.delete_flag IS NULL ) AND mg_wordsegment.created >= '".$this->_oldDate."' AND mg_wordsegment.image != '' AND mg_grapheme_wordsegment_linkage.grapheme_id = '".$val->id."' ",
                                'group' => "mg_wordsegment.word"
                            ));
                            $str[] = $val->id . ":::has " . $val->grapheme ." (".count($count).")";
                        }
                        break;

                    case "word_game_random_grapheme":
                        $graphemes = Grapheme::find('all',array(
                            'select' => " id,grapheme ",
                            "conditions" => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."' ",
                            "order" => 'grapheme ASC'
                        ));

                        foreach($graphemes as $val) {
                            $count = GraphemeWordsegmentLinkage::find("all",array(
                                'select' => "id",
                                'conditions' => " grapheme_id = '".$val->id."' "
                            ));
                            $str[] = $val->id . ":::has " . $val->grapheme ." (".count($count).")";
                        }
                        break;

                    case "segmenting_blending_random_grapheme":
                        $graphemes = Grapheme::find('all',array(
                            'select' => " id,grapheme ",
                            "conditions" => " ( delete_flag = 0 OR delete_flag IS NULL ) AND created >= '".$this->_oldDate."' ",
                            "order" => 'grapheme ASC'
                        ));

                        foreach($graphemes as $val) {
                            $count = GraphemeWordsegmentLinkage::find("all",array(
                                'select' => "mg_grapheme_wordsegment_linkage.id",
                                'joins' => "JOIN mg_wordsegment ON mg_grapheme_wordsegment_linkage.wordsegment_id = mg_wordsegment.id",
                                'conditions' => " mg_grapheme_wordsegment_linkage.grapheme_id = '".$val->id."' AND LENGTH(mg_wordsegment.word) <= 6 "
                            ));
                            $str[] = $val->id . ":::has " . $val->grapheme ." (".count($count).")";
                        }
                        break;

                     case "oddity_starts_with_grapheme":
                        $data = Grapheme::find_by_sql("SELECT mg_grapheme.id, mg_grapheme.grapheme, mg_grapheme.phoneme, COUNT(mg_grapheme_wordsegment_linkage.id) AS icount  FROM mg_wordsegment, mg_grapheme_wordsegment_linkage, mg_grapheme WHERE mg_wordsegment.id = mg_grapheme_wordsegment_linkage.wordsegment_id AND mg_grapheme_wordsegment_linkage.grapheme_id = mg_grapheme.id AND mg_grapheme_wordsegment_linkage.order_number = 1 AND ( mg_grapheme.delete_flag = 0 OR mg_grapheme.delete_flag IS NULL ) AND mg_grapheme.created >= '".$this->_oldDate."' AND ( mg_wordsegment.delete_flag = 0 OR mg_wordsegment.delete_flag IS NULL ) AND mg_wordsegment.created >= '".$this->_oldDate."' AND mg_wordsegment.status='active' GROUP BY mg_grapheme.id ORDER BY `mg_grapheme`.`grapheme` ASC");
                        // 21
                        foreach($data as $val) {
                            if($val->icount >= 3) {
                                $str[] = $val->id . ":::" . $val->grapheme . " [".$val->phoneme."] (".$val->icount.")" ;
                            }
                        }
                        break;

                     case "oddity_ends_with_grapheme":
                        $data = Grapheme::find_by_sql("SELECT mg_grapheme_wordsegment_linkage.grapheme_id, mg_wordsegment.word FROM mg_wordsegment, mg_grapheme_wordsegment_linkage WHERE mg_grapheme_wordsegment_linkage.wordsegment_id = mg_wordsegment.id AND ( mg_wordsegment.delete_flag = 0 OR mg_wordsegment.delete_flag IS NULL ) AND mg_wordsegment.created >= '".$this->_oldDate."' AND mg_wordsegment.status='active' GROUP BY mg_wordsegment.id ORDER BY mg_grapheme_wordsegment_linkage.order_number DESC");
                        // 21
                        $data1 = array();
                        foreach($data as $val) {
                            if(isset($data1[$val->grapheme_id])) {
                                $data1[$val->grapheme_id]['count']++;
                            } else {
                                $gra = Grapheme::find($val->grapheme_id);
                                $data1[$val->grapheme_id]['grapheme'] = $gra->grapheme;
                                $data1[$val->grapheme_id]['count'] = 1;
                                $data1[$val->grapheme_id]['phoneme'] = $gra->phoneme;
                            }
                        }

                        asort( $data1);
                        foreach($data1 as $iid => $val) {
                            if($val['count'] >= 3) {
                                $str[] = $iid . ":::" . $val['grapheme'] . " [".$val['phoneme']."] (".$val['count'].")" ;
                            }
                        }
                        break;
                }

                echo implode(";;;",$str);
            } else {
                echo "";
            }

        }

        function setaudio() {
            $gra = Grapheme::find("all");

            foreach($gra as $val) {
                if($val->audio == '' || $val->audio == ".mp3") {
                    if(file_exists($this->config->item("root_url") . "contentfiles/grapheme/" . $val->phoneme . ".mp3")) {
                        //if(file_exists("contentfiles/grapheme/" . $this->phoneme . ".mp3")) {
                        $val->audio = $val->phoneme . ".mp3";
                        $val->save();
                    }
                }
            }
        }

        /*
    	Function name   : duplicateactivity()
    	Parameter       : $activity_id - int - activity id to be edited
    	Return          : none
    	Description     : edit activity data
    	*/
        function duplicateactivity($activity_id = 0) {
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

            //! check if id is valid
            if($activity_id == 0 || $activity_id == '') {
                redirect("englishcontent/viewactivity");
                die();
            }

            //! Setting page data
            $activity = Activity::find($activity_id);

            $activity_array = array(
                'name' => $activity->name,
                'level' => $activity->level,
                'unit' => $activity->unit,
                'activity_num' => $activity->activity_num,
                'activity_type' => $activity->activity_type,
                'point' => $activity->point,
                'score' => $activity->score,
                'stars' => $activity->stars,
                'world' => $activity->world,
                'category' => $activity->category,
                'challenge' => $activity->challenge,
                'description' => $activity->description,
                'tags' => $activity->tags,
                'added_by_id' => $this->user->id,
                'updated_by_id' => $this->user->id,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s"),
            );

            //! Creating record
            $new_activity = Activity::create($activity_array);

            //! Check if the record is created or not
            if( isset($new_activity->id )) {

                foreach($activity->activity_linkage as $val) {
                    //! Create record
                    $new_al = ActivityLinkage::create(array(
                        'activity_id' => $new_activity->id,
                        'type_id' => $val->type_id,
                        'type' =>  $val->type,
                        'order_num' => $val->order_num,
                        'additional_info' => $val->additional_info,
                        'added_by_id' => $this->user->id,
                        'updated_by_id' => $this->user->id,
                        'created' => date("Y-m-d H:i:s"),
                        'updated' => date("Y-m-d H:i:s"),
                    ));
                }
            }

            //! Redirect to view page
            redirect('englishcontent/viewactivity/0/1');

        }

        /*
    	Function name   : addactivitylevel()
    	Parameter       : $error - int - Stores error no. if any default is 0
    	Return          : none
    	Description     : Add new activity level
    	*/
        function addactivitylevel($error = 0) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user has right privilege
            if($this->user->admin != 1 && $this->user->admin != 2 ) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['error'] = $error;

            //! Validation rules
            $this->form_validation->set_rules('level','Level', 'trim|required');
            $this->form_validation->set_rules('title','title', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Add activity level";
                $this->loadtemplate("englishcontent/addactivitylevel",$header,$body,$footer);
            } else {

                $error = 1;

                $data_array = array(
                    'level' => $this->input->post('level'),
                    'title' => $this->input->post('title'),
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                );

                //! Creating Activity level
                $activity_level = ActivityLevel::create($data_array);

                redirect('englishcontent/viewactivitylevel/0/' . $error);
            }
        }

        /*
    	Function name   : viewactivitylevel()
    	Parameter       : $page - int - Stores the page no. if any, default is 0
                          $error - int - Stores error no. if any, default is 0
    	Return          : none
    	Description     : View activity level list
    	*/
        function viewactivitylevel($page = 0,$error = 0) {
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

            $activitylevels = ActivityLevel::find('all',array(
                "order" => 'level ASC'
            ));

            //! Setting page data
            $footer['user'] = $body['user'] = $header['user'] = $this->user;
            $body['activitylevels'] = $activitylevels;
            $body['page'] = $page;
            $body['error'] = $error;
            $header['title'] = "View Activity Level";

            //! Display the list
            $this->loadtemplate("englishcontent/viewactivitylevel",$header,$body,$footer);
        }

        /*
    	Function name   : editactivitylevel()
    	Parameter       : $activity_level_id - int - activity level id to be edited
    	Return          : none
    	Description     : edit activity level data
    	*/
        function editactivitylevel($activity_level_id = 0) {
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

            //! check if activity_level_id is valid
            if($activity_level_id == 0 || $activity_level_id == '') {
                redirect("englishcontent/viewactivitylevel");
                die();
            }

            //! Setting page data
            $footer['user'] = $body['user'] = $header['user'] = $this->user;
            $activity_level = ActivityLevel::find($activity_level_id);
            $body['activity_level'] = $activity_level;
            $body['activity_level_id'] = $activity_level_id;

            //! Validation rules
            $this->form_validation->set_rules('level','Level', 'trim|required');
            $this->form_validation->set_rules('title','Title', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Edit Activity level";
                $this->loadtemplate("englishcontent/editactivitylevel",$header,$body,$footer);
            } else {
                //! Else update the question data
                $error = 1;

                //! Edit data in table
                $activity_level->level = $this->input->post('level');
                $activity_level->title = $this->input->post('title');
                $activity_level->updated = date("Y-m-d H:i:s");
                $activity_level->save();

                //! Redirect to view page
                redirect('englishcontent/viewactivitylevel/0/2');
            }
        }

        /*
    	Function name   : addncrt()
    	Parameter       : $error - int - Stores error no. if any default is 0
    	Return          : none
    	Description     : Add new ncrt
    	*/
        function addncrt($error = 0) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user has right privilege
            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['error'] = $error;

            //! Validation rules
            $this->form_validation->set_rules('name','Name', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Add ncrt activity";
                $body['activities'] = Activity::find("all",array(
                    "conditions" => " ( delete_flag = 0 OR delete_flag IS NULL ) AND challenge != 1 ",
                    "order" => "level, activity_num ASC"
                ));

                $this->loadtemplate("englishcontent/addncrt",$header,$body,$footer);
            } else {
                $error = 1;

                $data_array = array(
                    'name' => $this->input->post('name'),
                    'level' => $this->input->post('level'),
                    'unit' => $this->input->post('unit'),
                    'description' => $this->input->post('description'),
                    'order_number' => $this->input->post('order_number'),
                    'added_by_id' => $this->user->id,
                    'updated_by_id' => $this->user->id,
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                );

                //! Creating record
                $new_record = Ncrt::create($data_array);

                //! Check if the record is created or not
                if( isset($new_record->id )) {

                    //! Add Activity linkage
                    for($mm = 0 ; $mm < count($_REQUEST['activity']) ; $mm++ ) {
                        if( @$_REQUEST['activity'][$mm] != '' ) {

                            //! Create record
                            $new_al = NcrtActivity::create(array(
                                'ncrt_id' => $new_record->id,
                                'activity_id' => @$_REQUEST['activity'][$mm],
                                'order_number' => @$_REQUEST['order_number'][$mm],
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));
                        }
                    }

                }

                redirect('englishcontent/viewncrt/0/' . $error);
            }
        }

        /*
    	Function name   : viewncrt()
    	Parameter       : $page - int - Stores the page no. if any, default is 0
                          $error - int - Stores error no. if any, default is 0
    	Return          : none
    	Description     : View ncrt list
    	*/
        function viewncrt($page = 0,$error = 0) {
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

            $ncrts = Ncrt::find('all',array(
                'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL ) ",
                "order" => 'unit,level ASC'
            ));

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['ncrts'] = $ncrts;
            $body['page'] = $page;
            $body['error'] = $error;
            $header['title'] = "View ncrt activities";

            //! Display the list
            $this->loadtemplate("englishcontent/viewncrt",$header,$body,$footer);
        }

        /*
    	Function name   : editncrt()
    	Parameter       : $ncrt_id - int - ncrt id to be edited
    	Return          : none
    	Description     : edit ncrt data
    	*/
        function editncrt($ncrt_id = 0) {
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

            //! check if id is valid
            if($ncrt_id == 0 || $ncrt_id == '') {
                redirect("englishcontent/viewncrt");
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $ncrt = Ncrt::find($ncrt_id);
            $body['ncrt'] = $ncrt;
            $body['ncrt_id'] = $ncrt_id;

            //! Validation rules
            $this->form_validation->set_rules('name','Name', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Edit ncrt activity";
                $body['activities'] = Activity::find("all",array(
                    "conditions" => " ( delete_flag = 0 OR delete_flag IS NULL )  AND challenge != 1 ",
                    "order" => "level, activity_num ASC"
                ));
                $this->loadtemplate("englishcontent/editncrt",$header,$body,$footer);
            } else {
                //! Else update the question data
                $error = 1;

                //! Edit data in table
                $ncrt->name = $this->input->post('name');
                $ncrt->level = $this->input->post('level');
                $ncrt->unit = $this->input->post('unit');
                $ncrt->description = $this->input->post('description');
                $ncrt->order_number = $this->input->post('order_number');
                $ncrt->updated_by_id = $this->user->id;
                $ncrt->updated = date("Y-m-d H:i:s");
                $ncrt->save();

                NcrtActivity::delete_all(array(
                    'conditions' => array(
                	    'ncrt_id' => $ncrt->id,
                	)
                 ));

                //! Add linkage
                for($mm = 0 ; $mm < count($_REQUEST['activity']) ; $mm++ ) {
                    if( @$_REQUEST['activity'][$mm] != '' ) {

                        //! Create record
                        $new_al = NcrtActivity::create(array(
                            'ncrt_id' => $ncrt->id,
                            'activity_id' => @$_REQUEST['activity'][$mm],
                            'order_number' => @$_REQUEST['order_number'][$mm],
                            'created' => date("Y-m-d H:i:s"),
                            'updated' => date("Y-m-d H:i:s"),
                        ));
                    }
                }

                //! Redirect to view page
                redirect('englishcontent/viewncrt/0/2');
            }
        }

        /*
    	Function name   : deletencrt()
    	Parameter       : $ncrt_id - int - ncrt id to be deleted
    	Return          : none
    	Description     : delete ncrt data
    	*/
        function deletencrt( $ncrt_id = 0 ) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                //! Redirect to view page
                redirect('englishcontent/viewncrt/0/3');
                die();
            }

            //! check if id is valid
            if($ncrt_id == 0 || $ncrt_id == '') {
                redirect("englishcontent/viewncrt");
                die();
            }

            //! Setting delete flag
            $ncrt = Ncrt::find($ncrt_id);
            $ncrt->updated_by_id = $this->user->id;
            $ncrt->updated = date("Y-m-d H:i:s");
            $ncrt->delete_flag = 1;
            $ncrt->save();

            //! Redirect to view page
            redirect('englishcontent/viewncrt/0/4');

        }


        /*
    	Function name   : addhelpvideo()
    	Parameter       : $error - int - Stores error no. if any default is 0
    	Return          : none
    	Description     : Add new help video
    	*/
        function addhelpvideo($error = 0) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user has right privilege
            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['error'] = $error;

            //! Validation rules
            $this->form_validation->set_rules('title','Title', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Add help video";

                $data1 = Question::find('all',array(
                            'joins' => "JOIN mg_concepts_question_linkage ON mg_concepts_question_linkage.question_id = mg_question.id
                                        JOIN mg_concepts ON mg_concepts_question_linkage.concepts_id = mg_concepts.id",
                            'select' => " mg_concepts.id, mg_concepts.name",
                            'conditions' => " mg_question.meta_type = 'fixed' AND mg_question.status = 'active' AND mg_concepts.units_id = '21' ",
                            'group' => " mg_concepts.id ",
                            "order" => 'mg_concepts.name ASC'
                        ));
                $concepts = array();
                foreach($data1 as $val) {
                    $concepts[$val->id] = $val->name;
                }


                $body['concepts'] = $concepts;

                $this->loadtemplate("englishcontent/addhelpvideo",$header,$body,$footer);
            } else {
                $error = 1;

                $data_array = array(
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'link' => $this->input->post('link'),
                    'category' => $this->input->post('category'),
                    'level' => $this->input->post('level'),
                    'series' => $this->input->post('series'),
                    'age_range' => $this->input->post('age_range'),
                    'is_premium' => $this->input->post('is_premium'),
                    'added_by_id' => $this->user->id,
                    'updated_by_id' => $this->user->id,
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                );

                if($this->input->post('concept_id') != "") {
                    $concept = Concept::find($this->input->post('concept_id'));
                    $data_array['concept'] = @$concept->name;
                    $data_array['concept_id'] = $this->input->post('concept_id');
                } else {
                    $data_array['concept'] = '';
                    $data_array['concept_id'] = '';
                }

                //! Creating record
                $new_record = HelpVideo::create($data_array);

                redirect('englishcontent/viewhelpvideo/0/' . $error);
            }
        }

        /*
    	Function name   : viewhelpvideo()
    	Parameter       : $page - int - Stores the page no. if any, default is 0
                          $error - int - Stores error no. if any, default is 0
    	Return          : none
    	Description     : View help video list
    	*/
        function viewhelpvideo($page = 0,$error = 0) {
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

            $helpvideos = HelpVideo::find('all',array(
                'conditions' => " ( delete_flag = 0 OR delete_flag IS NULL ) ",
                "order" => 'level ASC'
            ));

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['helpvideos'] = $helpvideos;
            $body['page'] = $page;
            $body['error'] = $error;
            $header['title'] = "View help videos";

            //! Display the list
            $this->loadtemplate("englishcontent/viewhelpvideo",$header,$body,$footer);
        }

        /*
    	Function name   : edithelpvideo()
    	Parameter       : $helpvideo_id - int - helpvideo id to be edited
    	Return          : none
    	Description     : edit help video data
    	*/
        function edithelpvideo($helpvideo_id = 0) {
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

            //! check if id is valid
            if($helpvideo_id == 0 || $helpvideo_id == '') {
                redirect("englishcontent/viewhelpvideo");
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $helpvideo = HelpVideo::find($helpvideo_id);
            $body['helpvideo'] = $helpvideo;
            $body['helpvideo_id'] = $helpvideo_id;

            //! Validation rules
            $this->form_validation->set_rules('title','Title', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Edit help video";

                $data1 = Question::find('all',array(
                            'joins' => "JOIN mg_concepts_question_linkage ON mg_concepts_question_linkage.question_id = mg_question.id
                                        JOIN mg_concepts ON mg_concepts_question_linkage.concepts_id = mg_concepts.id",
                            'select' => " mg_concepts.id, mg_concepts.name",
                            'conditions' => " mg_question.meta_type = 'fixed' AND mg_question.status = 'active' AND mg_concepts.units_id = '21' ",
                            'group' => " mg_concepts.id ",
                            "order" => 'mg_concepts.name ASC'
                        ));
                $concepts = array();
                foreach($data1 as $val) {
                    $concepts[$val->id] = $val->name;
                }


                $body['concepts'] = $concepts;
                $this->loadtemplate("englishcontent/edithelpvideo",$header,$body,$footer);
            } else {
                //! Else update the question data
                $error = 1;

                if($this->input->post('concept_id') != "") {
                    $concept = Concept::find($this->input->post('concept_id'));
                    $helpvideo->concept = @$concept->name;
                    $helpvideo->concept_id = $this->input->post('concept_id');
                } else {
                    $helpvideo->concept = '';
                    $helpvideo->concept_id = '';
                }

                //! Edit data in table
                $helpvideo->title = $this->input->post('title');
                $helpvideo->description = $this->input->post('description');
                $helpvideo->link = $this->input->post('link');
                $helpvideo->category = $this->input->post('category');
                $helpvideo->level = $this->input->post('level');
                $helpvideo->series = $this->input->post('series');
                $helpvideo->age_range = $this->input->post('age_range');
                $helpvideo->is_premium = $this->input->post('is_premium');
                $helpvideo->updated_by_id = $this->user->id;
                $helpvideo->updated = date("Y-m-d H:i:s");
                $helpvideo->save();

                //! Redirect to view page
                redirect('englishcontent/viewhelpvideo/0/2');
            }
        }

        /*
    	Function name   : deletehelpvideo()
    	Parameter       : $helpvideo_id - int - helpvideo id to be deleted
    	Return          : none
    	Description     : delete helpvideo data
    	*/
        function deletehelpvideo( $helpvideo_id = 0 ) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                //! Redirect to view page
                redirect('englishcontent/viewhelpvideo/0/3');
                die();
            }

            //! check if id is valid
            if($helpvideo_id == 0 || $helpvideo_id == '') {
                redirect("englishcontent/viewhelpvideo");
                die();
            }

            //! Setting delete flag
            $helpvideo = HelpVideo::find($helpvideo_id);
            $helpvideo->updated_by_id = $this->user->id;
            $helpvideo->updated = date("Y-m-d H:i:s");
            $helpvideo->delete_flag = 1;
            $helpvideo->save();

            //! Redirect to view page
            redirect('englishcontent/viewhelpvideo/0/4');

        }

        /*
    	Function name   : helpvideoquestions()
    	Parameter       : $help_video_id - int - Help Video id of the questions
                          $error - int - Error number if any
    	Return          : none
    	Description     : Show the question list
    	*/
        function helpvideoquestions($help_video_id = 0 , $error = 0) {
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

            //! check if help_video_id is valid
            if($help_video_id == 0 || $help_video_id == '') {
                redirect("englishcontent/viewhelpvideo");
                die();
            }

            $helpvideo = HelpVideo::find($help_video_id);

            if(!isset($helpvideo->id)) {
                redirect("englishcontent/viewhelpvideo");
                die();
            }

            //! Setting page data
            $footer['user'] = $body['user'] = $header['user'] = $this->user;
            $body['error'] = $error;
            $body['helpvideo'] = $helpvideo;
            $header['title'] = "Help Video Question";

            //! Display the list
            $this->loadtemplate("englishcontent/helpvideoquestions",$header,$body,$footer);
        }

        function helpvideoactivity($help_video_id = 0 , $error = 0) {
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

            //! check if help_video_id is valid
            if($help_video_id == 0 || $help_video_id == '') {
                redirect("englishcontent/viewhelpvideo");
                die();
            }

            $helpvideo = HelpVideo::find($help_video_id);

            if(!isset($helpvideo->id)) {
                redirect("englishcontent/viewhelpvideo");
                die();
            }

            //! Setting page data
            $footer['user'] = $body['user'] = $header['user'] = $this->user;
            $body['error'] = $error;
            $body['helpvideo'] = $helpvideo;
            $header['title'] = "Help Video Activity";

            //! Display the list
            $this->loadtemplate("englishcontent/helpvideoactivity",$header,$body,$footer);
        }

        function addhelpactivity($helpvideo_id = 0) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user has right privilege
            if($this->user->admin != 1 && $this->user->admin != 2) {
                redirect();
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $body['helpvideo_id'] = $helpvideo_id;

            //! Validation rules
            $this->form_validation->set_rules('name','Activity Name', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Add activity";
                $body['stypes'] = $this->stypes;
                $body['worlds'] = $this->_worlds;
                $body['categories'] = $this->_categories;

                $this->loadtemplate("englishcontent/addhelpactivity",$header,$body,$footer);
            } else {
                $error = 1;

                $challenge = 0;
                if(isset($_REQUEST['challenge'])) {
                    $challenge = 1;
                }

                $activity_array = array(
                    'name' => $this->input->post('name'),
                    'level' => $this->input->post('level'),
                    'unit' => $this->input->post('unit'),
                    'activity_num' => $this->input->post('activity_num'),
                    'activity_type' => '',
                    'point' => $this->input->post('point'),
                    'score' => $this->input->post('score'),
                    'stars' => $this->input->post('stars'),
                    'added_by_id' => $this->user->id,
                    'updated_by_id' => $this->user->id,
                    'challenge' => $challenge,
                    'world' => $this->input->post('world'),
                    'category' => $this->input->post('category'),
                    'description' => $this->input->post('description'),
                    'tags' => $this->input->post('tags'),
                    'created' => date("Y-m-d H:i:s"),
                    'updated' => date("Y-m-d H:i:s"),
                );

                //! Creating record
                $new_activity = HelpActivity::create($activity_array);

                //! Check if the record is created or not
                if( isset($new_activity->id )) {

                    for($mm = 0 ; $mm < count($_REQUEST['language_trans']) ; $mm++ ) {
                        if( @$_REQUEST['language_trans'][$mm] != '' ) {
                            $new_wt = HelpActivityTranslation::create(array(
                                'help_activity_id' => $new_activity->id,
                                'language_id' => @$_REQUEST['language_id'][$mm],
                                'translation' => @$_REQUEST['language_trans'][$mm],
                                'added_by_id' => $this->user->id,
                                'updated_by_id' => $this->user->id,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));
                        }
                    }

                    //! Add Activity linkage
                    for($mm = 0 ; $mm < count($_REQUEST['activity_type']) ; $mm++ ) {
                        if( @$_REQUEST['activity_type'][$mm] != '' ) {

                            $sudo = explode("***",@$_REQUEST['type_id'][$mm]);

                            $additional_info = array();
                            if(isset($sudo[1])) {
                                if( @$_REQUEST['activity_type'][$mm] == "first_last_sound" ) {
                                    $additional_info["letter_at"] = @$sudo[1];
                                }
                            }

                            if( @$_REQUEST['activity_type'][$mm] == "missing_letter" ) {
                                $additional_info["missing_letter"] = @$_REQUEST['ml_grapheme'][$mm];
                            }

                            if( @$_REQUEST['activity_type'][$mm] == "phrase_game" ) {
                                $additional_info["missing_word"] = @$_REQUEST['ml_grapheme'][$mm];
                            }

                            if( @$_REQUEST['act_count'][$mm] != "" ) {
                                $additional_info["count"] = @$_REQUEST['act_count'][$mm];
                            }

                            if( @$_REQUEST['activity_type'][$mm] == "listen_to_a_sound_random" ) {
                                $sudo[0] = '0';
                                $additional_info["graphemes"] = @$_REQUEST['type_id1'][$mm];
                            }

                            //! Create record
                            $new_al = HelpActivityLinkage::create(array(
                                'help_activity_id' => $new_activity->id,
                                'type_id' => @$sudo[0],
                                'type' =>  @$_REQUEST['activity_type'][$mm],
                                'order_num' => @$_REQUEST['order_num'][$mm],
                                'additional_info' => json_encode($additional_info),
                                'added_by_id' => $this->user->id,
                                'updated_by_id' => $this->user->id,
                                'created' => date("Y-m-d H:i:s"),
                                'updated' => date("Y-m-d H:i:s"),
                            ));
                        }
                    }

                    $help_video_activity_linkage = HelpVideoActivityLinkage::create(array(
                            'help_video_id' => $helpvideo_id,
                            'help_activity_id' => $new_activity->id,
                            'order_number' => $this->input->post('activity_num'),
                            'added_by_id' => $this->user->id,
                            'updated_by_id' => $this->user->id,
                            'created' => date("Y-m-d H:i:s"),
                            'updated' => date("Y-m-d H:i:s"),
                        ));

                }

                redirect('englishcontent/helpvideoactivity/'.$helpvideo_id.'/1');
            }
        }


        function edithelpactivity($help_activity_id = 0, $helpvideo_id = 0) {
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

            //! check if id is valid
            if($help_activity_id == 0 || $help_activity_id == '') {
                redirect("englishcontent/helpvideoactivity/" . $helpvideo_id);
                die();
            }

            //! Setting page data
            $header['user'] = $body['user'] = $footer['user'] = $this->user;
            $activity = HelpActivity::find($help_activity_id);
            $body['activity'] = $activity;
            $body['help_activity_id'] = $help_activity_id;
            $body['helpvideo_id'] = $helpvideo_id;

            //! Validation rules
            $this->form_validation->set_rules('name','Activity Name', 'trim|required');

            //! Check if form is submitted
            if ($this->form_validation->run() == FALSE) {
                //! If not submitted or validation fails display the form
                $header['title'] = "Edit activity";
                $body['stypes'] = $this->stypes;
                $body['worlds'] = $this->_worlds;
                $body['categories'] = $this->_categories;
                $this->loadtemplate("englishcontent/edithelpactivity",$header,$body,$footer);
            } else {
                //! Else update the question data
                $error = 1;

                $challenge = 0;
                if(isset($_REQUEST['challenge'])) {
                    $challenge = 1;
                }

                //! Edit data in table
                $activity->name = $this->input->post('name');
                $activity->level = $this->input->post('level');
                $activity->unit = $this->input->post('unit');
                $activity->activity_num = $this->input->post('activity_num');
                $activity->activity_type = '';
                $activity->point = $this->input->post('point');
                $activity->score = $this->input->post('score');
                $activity->stars = $this->input->post('stars');
                $activity->updated_by_id = $this->user->id;
                $activity->challenge = $challenge;
                $activity->world = $this->input->post('world');
                $activity->category = $this->input->post('category');
                $activity->description = $this->input->post('description');
                $activity->tags = $this->input->post('tags');
                $activity->updated = date("Y-m-d H:i:s");
                $activity->save();

                for($mm = 0 ; $mm < count($_REQUEST['language_trans']) ; $mm++ ) {
                    if( @$_REQUEST['language_trans'][$mm] != '' ) {
                        //! Check for the primary word
                        if( @$_REQUEST['qt_id'][$mm] != '') {

                            $wt = HelpActivityTranslation::find(@$_REQUEST['qt_id'][$mm]);

                            $wt->translation = @$_REQUEST['language_trans'][$mm];
                            $wt->updated_by_id = $this->user->id;
                            $wt->updated = date("Y-m-d H:i:s");
                            $wt->save();
                        } else {
                            //! Create record
                            $new_wt = HelpActivityTranslation::create(array(
                                'help_activity_id' => $activity->id,
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
                            HelpActivityTranslation::delete_all(array(
        	    			    'conditions' => array(
        		    			    'id' => @$_REQUEST['qt_id'][$mm],
        			    		)
        				    ));
                        }
                    }
                }

                 HelpActivityLinkage::delete_all(array(
                    'conditions' => array(
                	    'help_activity_id' => $activity->id,
                	)
                 ));

                //! Add Activity linkage
                for($mm = 0 ; $mm < count($_REQUEST['type_id']) ; $mm++ ) {
                    if( @$_REQUEST['activity_type'][$mm] != '' ) {

                        $sudo = explode("***",@$_REQUEST['type_id'][$mm]);

                        $additional_info = array();
                        if(isset($sudo[1])) {
                            if( @$_REQUEST['activity_type'][$mm] == "first_last_sound" ) {
                                $additional_info["letter_at"] = @$sudo[1];
                            }
                        }

                        if( @$_REQUEST['activity_type'][$mm] == "missing_letter" ) {
                            $additional_info["missing_letter"] = @$_REQUEST['ml_grapheme'][$mm];
                        }

                        if( @$_REQUEST['activity_type'][$mm] == "phrase_game" ) {
                            $additional_info["missing_word"] = @$_REQUEST['ml_grapheme'][$mm];
                        }

                        if( @$_REQUEST['act_count'][$mm] != "" ) {
                            $additional_info["count"] = @$_REQUEST['act_count'][$mm];
                        }

                        if( @$_REQUEST['activity_type'][$mm] == "listen_to_a_sound_random" ) {
                            $sudo[0] = '';
                            $additional_info["graphemes"] = @$_REQUEST['type_id1'][$mm];
                        }

                        //! Create record
                        $new_al = HelpActivityLinkage::create(array(
                            'help_activity_id' => $activity->id,
                            'type_id' => @$sudo[0],
                            'type' => @$_REQUEST['activity_type'][$mm],
                            'order_num' => @$_REQUEST['order_num'][$mm],
                            'additional_info' => json_encode($additional_info),
                            'added_by_id' => $this->user->id,
                            'updated_by_id' => $this->user->id,
                            'created' => date("Y-m-d H:i:s"),
                            'updated' => date("Y-m-d H:i:s"),
                        ));
                    }
                }


                $helpvideoactivitylinkage = HelpVideoActivityLinkage::find_by_help_video_id_and_help_activity_id($helpvideo_id,$activity->id);

                $helpvideoactivitylinkage->order_number = $this->input->post('activity_num');
                $helpvideoactivitylinkage->updated_by_id = $this->user->id;
                $helpvideoactivitylinkage->updated = date("Y-m-d H:i:s");
                $helpvideoactivitylinkage->save();


                //! Redirect to view page
                redirect('englishcontent/helpvideoactivity/'.$helpvideo_id.'/2');
            }
        }

        function deletehelpactivity( $activity_id = 0, $helpvideo_id = 0 ) {

            //! check if user is valid
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            //! check if user is admin
            if($this->user->admin != 1 ) {
                //! Redirect to view page
                redirect('englishcontent/helpvideoactivity/'.$helpvideo_id);
                die();
            }

            //! check if id is valid
            if($activity_id == 0 || $activity_id == '') {
                redirect('englishcontent/helpvideoactivity/'.$helpvideo_id);
                die();
            }

            //! Setting delete flag
            $activity = HelpActivity::find($activity_id);
            $activity->updated_by_id = $this->user->id;
            $activity->updated = date("Y-m-d H:i:s");
            $activity->delete_flag = 1;
            $activity->save();

            //! Redirect to view page
            redirect('englishcontent/helpvideoactivity/'.$helpvideo_id.'/3');

        }
    }
?>