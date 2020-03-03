<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class UserHelpVideoUnlock extends ActiveRecord\Model {

        static $table_name = 'mg_user_help_video_unlock';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('help_video', 'foreign_key' => 'help_video_id', 'class_name' => 'HelpVideo'),
            array('user', 'foreign_key' => 'user_id', 'class_name' => 'User')
        );
    }
?>