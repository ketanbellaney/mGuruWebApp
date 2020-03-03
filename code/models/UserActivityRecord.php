<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class UserActivityRecord extends ActiveRecord\Model {

        static $table_name = 'mg_user_activity_record';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('user'),
            array('activity'),
            array('activity_linkage'),
        );
    }
?>