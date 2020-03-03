<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class PromocodeUsed extends ActiveRecord\Model {

        static $table_name = 'mg_promocode_used';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('promocode', 'foreign_key' => 'promocode_id', 'class_name' => 'Promocode'),
            array('user', 'foreign_key' => 'user_id', 'class_name' => 'User')
        );
    }
?>