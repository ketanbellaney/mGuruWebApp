<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class AnswerQuestion extends ActiveRecord\Model {

        static $table_name = 'mg_answer_question';

        // Associations(!!!!)
        static $has_many = array(
          
        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('user', 'foreign_key' => 'user_id', 'class_name' => 'User'),
            array('question', 'foreign_key' => 'question_id', 'class_name' => 'Question'),
            array('answer', 'foreign_key' => 'answer_id', 'class_name' => 'Answer'),
        );
    }
?>