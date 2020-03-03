<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class StudentTeacherLinkage extends ActiveRecord\Model {

        static $table_name = 'mg_student_teacher_linkage';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('student', 'foreign_key' => 'student_id', 'class_name' => 'User'),
            array('teacher', 'foreign_key' => 'teacher_id', 'class_name' => 'User'),
        );
    }
?>