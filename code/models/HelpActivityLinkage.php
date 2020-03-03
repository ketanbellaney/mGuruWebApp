<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class HelpActivityLinkage extends ActiveRecord\Model {

        static $table_name = 'mg_help_activity_linkage';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('help_activity', 'foreign_key' => 'help_activity_id', 'class_name' => 'HelpActivity'),
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );

    }
?>