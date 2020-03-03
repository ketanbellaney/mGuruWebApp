<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Transaction extends ActiveRecord\Model {

        static $table_name = 'mg_transaction';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('user'),
        );

    }
?>