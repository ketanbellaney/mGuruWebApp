<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class UserReferralCode extends ActiveRecord\Model {

        static $table_name = 'mg_user_referral_code';


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