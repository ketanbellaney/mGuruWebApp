<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class StorypageLanguage extends ActiveRecord\Model {

        static $table_name = 'mg_storypage_language';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('story'),
            array('storypage'),
            array('language'),
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );
    }
?>