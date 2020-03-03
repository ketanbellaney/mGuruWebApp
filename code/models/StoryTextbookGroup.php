<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class StoryTextbookGroup extends ActiveRecord\Model {

        static $table_name = 'mg_story_textbook_group';


        // Associations(!!!!)
        static $has_many = array(
            array('story_textbook_group_word_linkage', 'foreign_key' => 'story_textbook_group_id', 'class_name' => 'StoryTextbookGroupWordLinkage'),
        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );

    }
?>