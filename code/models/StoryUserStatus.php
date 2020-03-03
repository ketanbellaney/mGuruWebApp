<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class StoryUserStatus extends ActiveRecord\Model {

        static $table_name = 'mg_story_user_status';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('story', 'foreign_key' => 'story_id', 'class_name' => 'Story'),
            array('user', 'foreign_key' => 'user_id', 'class_name' => 'User')
        );
    }
?>