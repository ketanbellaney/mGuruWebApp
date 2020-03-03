<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Language extends ActiveRecord\Model {

        static $table_name = 'mg_language';

        // Associations(!!!!)
        static $has_many = array(
            array('story'),
        );

        static $has_one = array(

        );

        static $belongs_to = array(
            
        );
    }
?>