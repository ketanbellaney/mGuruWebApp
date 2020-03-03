<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class School extends ActiveRecord\Model {

        static $table_name = 'mg_school';

        // Associations(!!!!)
        static $has_many = array(
            array('profile'),
        );

        static $has_one = array(

        );

        static $belongs_to = array(

        );
    }
?>