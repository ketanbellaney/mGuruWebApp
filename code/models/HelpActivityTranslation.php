<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class HelpActivityTranslation extends ActiveRecord\Model {

        static $table_name = 'mg_help_activity_translation';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('help_activity'),
            array('language'),
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );
    }
?>