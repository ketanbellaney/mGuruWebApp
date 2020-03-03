<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class GraphemeWordLinkage extends ActiveRecord\Model {

        static $table_name = 'mg_grapheme_word_linkage';

        // Associations(!!!!)
        static $has_many = array(

        );         

        static $has_one = array(

        );

        static $belongs_to = array(    
            array('grapheme', 'foreign_key' => 'grapheme_id', 'class_name' => 'Grapheme'),
            array('word', 'foreign_key' => 'word_id', 'class_name' => 'Word'),
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );

    }
?>