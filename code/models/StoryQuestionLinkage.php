<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class StoryQuestionLinkage extends ActiveRecord\Model {

        static $table_name = 'mg_story_question_linkage';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('story', 'foreign_key' => 'story_id', 'class_name' => 'Story'),
            array('storypage', 'foreign_key' => 'storypage_id', 'class_name' => 'StoryPage'),
            array('question', 'foreign_key' => 'question_id', 'class_name' => 'Question'),
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );
    }
?>