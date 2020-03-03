<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Promocode extends ActiveRecord\Model {

        static $table_name = 'mg_promocode';

        // Associations(!!!!)
        static $has_many = array(
            array('promocode_used', 'foreign_key' => 'promocode_id', 'class_name' => 'PromocodeUsed'),
        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('added_by', 'foreign_key' => 'created_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );
    }
?>