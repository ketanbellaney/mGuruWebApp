<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class MG_Auth {

        function __construct() {
            $this->ci =& get_instance();
        }


        function get_current_person() {
            if ( ! $this->is_logged_in()) {
                return FALSE;
            }

            $user_id = $this->session->userdata('_user_id');

            $user = User::find($user_id);

            if ($user) {
                return $user;
            }
            return FALSE;
        }

        function is_logged_in() {
            if ( $this->session->userdata('_user_id') != '' ) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }
?>