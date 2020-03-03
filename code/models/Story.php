<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Story extends ActiveRecord\Model {

        static $table_name = 'mg_story';

        // Associations(!!!!)
        static $has_many = array(
            array('storypage', 'order' => 'pageno ASC'),
            array('story_question_linkage', 'foreign_key' => 'story_id', 'class_name' => 'StoryQuestionLinkage', 'order' => 'type ASC , order_number ASC'),
        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('language'),
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );
    }
?>