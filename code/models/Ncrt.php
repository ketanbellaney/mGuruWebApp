<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Ncrt extends ActiveRecord\Model {

        static $table_name = 'mg_ncrt';

        // Associations(!!!!)
        static $has_many = array(
            array('activity', 'foreign_key' => 'ncrt_id', 'class_name' => 'NcrtActivity'),
        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );

    }
?>