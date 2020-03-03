<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Sentence extends ActiveRecord\Model {

        static $table_name = 'mg_sentence';

        // Associations(!!!!)
        static $has_many = array(
            array('phrase_sentence_linkage', 'foreign_key' => 'sentence_id', 'class_name' => 'PhraseSentenceLinkage'),
        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );

    }
?>