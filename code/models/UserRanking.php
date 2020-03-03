<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class UserRanking extends ActiveRecord\Model {

        static $table_name = 'mg_user_ranking';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('user')
        );

    }
?>