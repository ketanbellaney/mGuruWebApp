<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class UserActivity extends ActiveRecord\Model {

        static $table_name = 'mg_user_activity';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('user'),
            array('activity')
        );
    }
?>