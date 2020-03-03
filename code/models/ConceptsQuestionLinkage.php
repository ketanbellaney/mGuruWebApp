<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class ConceptsQuestionLinkage extends ActiveRecord\Model {

        static $table_name = 'mg_concepts_question_linkage';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('concept', 'foreign_key' => 'concepts_id', 'class_name' => 'Concept'),
            array('question', 'foreign_key' => 'question_id', 'class_name' => 'Question'),
        );
    }
?>