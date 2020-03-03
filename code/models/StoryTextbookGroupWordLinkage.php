<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class StoryTextbookGroupWordLinkage extends ActiveRecord\Model {

        static $table_name = 'mg_story_textbook_group_word_linkage';


        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('story_textbook_group', 'foreign_key' => 'story_textbook_group_id', 'class_name' => 'StoryTextbookGroup'),
            array('word', 'foreign_key' => 'word_id', 'class_name' => 'Word'),
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );

    }
?>