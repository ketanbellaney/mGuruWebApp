<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class MathAnswer extends ActiveRecord\Model {

        static $table_name = 'mg_math_answer';

        // Associations(!!!!)
        static $has_many = array(
            array('math_answer_items', 'foreign_key' => 'math_answer_question_id', 'class_name' => 'MathAnswerQuestion'),
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
            array('math_set', 'foreign_key' => 'math_set_id', 'class_name' => 'MathSet'),
        );
    }
?>