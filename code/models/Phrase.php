<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Phrase extends ActiveRecord\Model {

        static $table_name = 'mg_phrase';

        // Associations(!!!!)
        static $has_many = array(
            array('phrase_sentence_linkage', 'foreign_key' => 'phrase_id', 'class_name' => 'PhraseSentenceLinkage', 'order' => ' order_number ASC ' ),
        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
            array('grapheme', 'foreign_key' => 'grapheme_id', 'class_name' => 'Grapheme'),
        );

    }
?>