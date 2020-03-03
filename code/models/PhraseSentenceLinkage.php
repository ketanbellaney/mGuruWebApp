<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class PhraseSentenceLinkage extends ActiveRecord\Model {

        static $table_name = 'mg_phrase_sentence_linkage';

        // Associations(!!!!)
        static $has_many = array(

        );         

        static $has_one = array(

        );

        static $belongs_to = array(
            array('phrase', 'foreign_key' => 'phrase_id', 'class_name' => 'Phrase'),
            array('sentence', 'foreign_key' => 'sentence_id', 'class_name' => 'Sentence'),
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );

    }
?>