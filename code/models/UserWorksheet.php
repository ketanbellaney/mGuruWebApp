<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class UserWorksheet  extends ActiveRecord\Model {

        static $table_name = 'mg_user_worksheet';


        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('user', 'foreign_key' => 'user_id', 'class_name' => 'User'),
            array('classes', 'foreign_key' => 'classes_id', 'class_name' => 'Classes')
        );

    }
?>