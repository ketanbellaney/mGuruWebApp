<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Privacypolicy extends MG_Controller {

        function __construct() {
            parent::__construct();

            $this->ci =& get_instance();
        }

        function index() {
            $this->loadtemplateblank("privacypolicy/index",array(),array(),array());
        }
    }
?>