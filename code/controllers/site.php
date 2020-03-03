<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Site extends MG_Controller {

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
            if(strpos(site_url(),'localhost') !== false || strpos(site_url(),'api001') !== false ) {
                $header['user'] = $this->user;
                $body['user'] = $this->user;
                $footer['user'] = $this->user;
                $this->loadtemplate("site/home",$header,$body,$footer);
            } else {
                header("location: http://www.mguru.co.in");
            }
        }

        function home() {
            if(!isset($this->user->id)) {
                redirect();
                die();
            }
            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $footer['user'] = $this->user;
            $this->loadtemplate("site/home",$header,$body,$footer);
        }

        function loginprocess() {

            if(isset($this->user->id)) {
                redirect();
                die();
            }

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
                        '_user_id'        =>  $euser[0]->id,
                        '_user_email'       =>  $euser[0]->email,
                        '_username'       =>  $euser[0]->username,
                    ));

                    $error = 3;
                } else {
                    $error = 2;
                }
            } else {
                $error = 1;
            }

            //! If not valid email / password
            if($error == 1 || $error == 2) {            //! Display login page
                redirect('site/login/' . $error);
            } else {                                    //! Else display dasboard
                redirect('site/home');
            }
        }

        function login($error = 1) {
            if(isset($this->user->id)) {
                redirect();
                die();
            }

            $header['user'] = $this->user;
            $body['user'] = $this->user;
            $body['error'] = $error;
            $footer['user'] = $this->user;
            $this->loadtemplate("site/login",$header,$body,$footer);
        }

        function logout() {
            if(!isset($this->user->id)) {
                redirect();
                die();
            }

            $this->session->set_userdata(array('_user_id' => '', '_user_email' => '', '_username' => ''));

            //! Destroy the sessions
            $this->session->sess_destroy();

            $header['user'] = '';
            $body['user'] = '';
            $footer['user'] = '';
            $this->loadtemplate("site/logout",$header,$body,$footer);
        }

        function r() {
            redirect("http://bit.ly/mg5hare");
        }

        function open($type = "home") {
        echo "<a href='intent://$type/#Intent;scheme=mguru;package=com.mguru.english;S.browser_fallback_url=market://;end' id='clickTarget'>Click here</a><script type='text/javascript'>
            window.onload = function() {
    var clickTarget = document.getElementById('clickTarget');
    var fakeMouseEvent = document.createEvent('MouseEvents');
    fakeMouseEvent.initMouseEvent('click', true, true, window, 0, 0, 0, 20, 10, false, false, false, false, 0, null);

    clickTarget.dispatchEvent(fakeMouseEvent);
  };
</script>";
    }
}
?>