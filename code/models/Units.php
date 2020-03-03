<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Units extends ActiveRecord\Model {

        static $table_name = 'mg_units';

        // Associations(!!!!)
        static $has_many = array(
            array('concept'),
        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('classes'),
            array('subject'),
        );
    }
?>