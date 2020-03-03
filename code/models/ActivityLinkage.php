<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class ActivityLinkage extends ActiveRecord\Model {

        static $table_name = 'mg_activity_linkage';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('activity', 'foreign_key' => 'activity_id', 'class_name' => 'Activity'),
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );

    }
?>