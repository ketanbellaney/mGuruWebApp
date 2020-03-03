<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class MathSet extends ActiveRecord\Model {

        static $table_name = 'mg_math_set';

        // Associations(!!!!)
        static $has_many = array(
            array('math_answer', 'foreign_key' => 'math_answer_id', 'class_name' => 'MathAnswer'),
        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('user', 'foreign_key' => 'user_id', 'class_name' => 'User'),
            array('question', 'foreign_key' => 'question_id', 'class_name' => 'Question'),
            array('concept', 'foreign_key' => 'concepts_id', 'class_name' => 'Concept'),
            array('unit', 'foreign_key' => 'units_id', 'class_name' => 'Units'),
            array('subject', 'foreign_key' => 'subject_id', 'class_name' => 'Subject'),
            array('classes', 'foreign_key' => 'classes_id', 'class_name' => 'Classes'),
        );
    }
?>