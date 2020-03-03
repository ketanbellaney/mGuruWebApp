<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class NcrtActivity extends ActiveRecord\Model {

        static $table_name = 'mg_ncrt_activity';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('ncrt', 'foreign_key' => 'ncrt_id', 'class_name' => 'Ncrt'),
            array('activity', 'foreign_key' => 'activity_id', 'class_name' => 'Activity'),
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );

    }
?>