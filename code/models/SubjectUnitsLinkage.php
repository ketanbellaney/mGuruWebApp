<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class SubjectUnitsLinkage extends ActiveRecord\Model {

        static $table_name = 'mg_subject_units_linkage';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('units'),
            array('subject'),   
        );
    }
?>