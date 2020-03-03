<?php
    class MG_Controller extends CI_Controller {

        var $_language_map = array(
            "english" => 1,
            "hindi" => 3,
            "marathi" => 4,
            "gujrati" => 2,
            "bengali" => 0,
            "kannada" => 5,
            "tamil" => 6,
            "manayalam" => 7
        );
        var $_language_db_map = array(
            "english" => 4,
            "hindi" => 6,
            "marathi" => 8,
            "gujrati" => 5,
            "bengali" => 2,
            "kannada" => 7,
            "tamil" => 11,
            "manayalam" => 15
        );
        var $_language_is = 'english';
          
        function __construct() {
            parent::__construct();
        }

        function loadtemplate($file, $header = array(), $data = array(), $footer = array(), $override = FALSE) {
            if (!$override) {
	            $this->load->view('common/header', $header);
            }

            $this->load->view($file, $data);

            if (!$override) {
	            $this->load->view('common/footer', $footer);
            }
        }

        function loadwstemplate($file, $header = array(), $data = array(), $footer = array(), $override = FALSE) {
            if (!$override) {
	            $this->load->view('common/wsheader', $header);
            }

            $this->load->view($file, $data);

            if (!$override) {
	            $this->load->view('common/wsfooter', $footer);
            }
        }

        function loadtatemplate($file, $header = array(), $data = array(), $footer = array(), $override = FALSE) {
            if (!$override) {
	            $this->load->view('common/taheader', $header);
            }

            $this->load->view($file, $data);

            if (!$override) {
	            $this->load->view('common/tafooter', $footer);
            }
        }

        function loadtemplateblank($file, $header = array(), $data = array(), $footer = array(), $override = FALSE) {
            if (!$override) {
	            $this->load->view('common/headerblank', $header);
            }

            $this->load->view($file, $data);

            if (!$override) {
	            $this->load->view('common/footerblank', $footer);
            }
        }

        function loadwebapptemplate($file, $data = array(), $override = FALSE) {
            if (!$override) {
	            $this->load->view('common/webappheader', $data);
            }

            $this->load->view($file, $data);

            if (!$override) {
	            $this->load->view('common/webappfooter', $data);
            }
        }

        function loadwebapptemplatenew($file, $data = array(), $override = FALSE) {

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

            if (!$override) {
	            $this->load->view('common/webappheadernew', $data);
            }

            $this->load->view($file, $data);

            $data['static_footer'] = 0;

            if (!$override) {
	            $this->load->view('common/webappfooternew', $data);
            }
        }

        function loadwebapptemplatenewwithoutheader($file, $data = array(), $override = FALSE) {
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
            if (!$override) {
	            $this->load->view('common/webappheadernewwithoutheader', $data);
            }

            $data['_translation'] = $this->_translator;

            $this->load->view($file, $data);

            $data['static_footer'] = 1;

            if (!$override) {
	            $this->load->view('common/webappfooternew', $data);
            }
        }

        function email_template($email, $subject, $message) {
            $this->load->library('email');

            $top_email = "";
            $bottom_email = "";
              
            $this->email->from('info@mguru.co.in', 'mGuru Team');
            $this->email->to($email);
            $this->email->subject($subject);
            $this->email->message($top_email . $message . $bottom_email);

            if($this->email->send()) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }
?>