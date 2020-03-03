<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class QuestionTemplate extends ActiveRecord\Model {

        static $table_name = 'mg_question_template';

        // Associations(!!!!)
        static $has_many = array(
            array('question', 'foreign_key' => 'question_template_id', 'class_name' => 'Question'),
        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),   
        );
    }
?>