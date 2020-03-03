<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Activity extends ActiveRecord\Model {

        static $table_name = 'mg_activity';

        // Associations(!!!!)
        static $has_many = array(
            array('activity_linkage', 'foreign_key' => 'activity_id', 'class_name' => 'ActivityLinkage', "order" => "order_num"),
            array('description_translation', 'foreign_key' => 'activity_id', 'class_name' => 'ActivityTranslation' ),
        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );

    }
?>