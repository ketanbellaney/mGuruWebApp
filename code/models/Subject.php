<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Subject extends ActiveRecord\Model {

        static $table_name = 'mg_subject';

        // Associations(!!!!)
        static $has_many = array(
            array('class_subject_linkage', 'foreign_key' => 'subject_id', 'class_name' => 'ClassSubjectLinkage'),
        );

        static $has_one = array(

        );

        static $belongs_to = array(

        );
    }
?>