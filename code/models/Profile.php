<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Profile extends ActiveRecord\Model {

        static $table_name = 'mg_profile';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('user'),
            array('school'), 
        );

        public function profile_photo() {
            if(trim($this->profile_picture) != '' ) {
                return base_url("user/photo/" . $this->profile_picture);
            } else {
                return base_url("user/photo/default.png");
            }
        }
    }
?>