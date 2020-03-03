<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class UserReferred extends ActiveRecord\Model {

        static $table_name = 'mg_user_referred';


        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('user', 'foreign_key' => 'user_id', 'class_name' => 'User'),
            array('referred_by', 'foreign_key' => 'referred_by_id', 'class_name' => 'User'),
        );

    }
?>