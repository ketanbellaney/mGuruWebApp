<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class ClassSubjectLinkage extends ActiveRecord\Model {

        static $table_name = 'mg_class_subject_linkage';

        // Associations(!!!!)
        static $has_many = array(
        
        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('classes'),
            array('subject'),
        );
    }
?>