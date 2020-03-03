<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Question extends ActiveRecord\Model {

        static $table_name = 'mg_question';

        // Associations(!!!!)
        static $has_many = array(
            array('concepts_question_linkage', 'foreign_key' => 'question_id', 'class_name' => 'ConceptsQuestionLinkage'),
            array('story_question_linkage', 'foreign_key' => 'question_id', 'class_name' => 'StoryQuestionLinkage', 'order' => 'type ASC , order_number ASC'),
            array('title_translation', 'foreign_key' => 'question_id', 'class_name' => 'QuestionTranslation' ),
        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
            array('question_template', 'foreign_key' => 'question_template_id', 'class_name' => 'QuestionTemplate'),
        );
    }
?>