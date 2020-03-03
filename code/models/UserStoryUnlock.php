<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class UserStoryUnlock extends ActiveRecord\Model {

        static $table_name = 'mg_user_story_unlock';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('user'),
            array('story'),
        );

    }
?>