<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class HelpVideo extends ActiveRecord\Model {

        static $table_name = 'mg_help_video';

        // Associations(!!!!)
        static $has_many = array(
            array('concept', 'foreign_key' => 'concept_id', 'class_name' => 'Concept'),
            array('help_video_question_linkage', 'foreign_key' => 'help_video_id', 'class_name' => 'HelpVideoQuestionLinkage', 'order' => 'order_number ASC'),
            array('help_video_activity_linkage', 'foreign_key' => 'help_video_id', 'class_name' => 'HelpVideoActivityLinkage', 'order' => 'order_number ASC'),
        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );

    }
?>