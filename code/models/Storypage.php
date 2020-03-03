<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Storypage extends ActiveRecord\Model {

        static $table_name = 'mg_storypage';

        // Associations(!!!!)
        static $has_many = array(
            array('story_question_linkage', 'foreign_key' => 'storypage_id', 'class_name' => 'StoryQuestionLinkage', 'order' => 'type ASC , order_number ASC'),
            array('storypage_language', 'foreign_key' => 'storypage_id', 'class_name' => 'StorypageLanguage'),
        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('story'),
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );
    }
?>