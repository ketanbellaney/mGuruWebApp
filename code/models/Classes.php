<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Classes extends ActiveRecord\Model {

        static $table_name = 'mg_classes';

        // Associations(!!!!)
        static $has_many = array(
            array('class_subject_linkage', 'class_name' => 'ClassSubjectLinkage'),
        );

        static $has_one = array(

        );

        static $belongs_to = array(
            
        );
    }
?>