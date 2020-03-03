<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class HelpActivity extends ActiveRecord\Model {

        static $table_name = 'mg_help_activity';

        // Associations(!!!!)
        static $has_many = array(
            array('help_activity_linkage', 'foreign_key' => 'help_activity_id', 'class_name' => 'HelpActivityLinkage', "order" => "order_num"),
            array('description_translation', 'foreign_key' => 'help_activity_id', 'class_name' => 'HelpActivityTranslation' ),
        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );

    }
?>