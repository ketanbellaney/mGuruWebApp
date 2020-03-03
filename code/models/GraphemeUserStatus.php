<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class GraphemeUserStatus extends ActiveRecord\Model {

        static $table_name = 'mg_grapheme_user_status';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('user', 'foreign_key' => 'user_id', 'class_name' => 'User')
        );
    }
?>