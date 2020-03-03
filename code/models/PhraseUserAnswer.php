<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class PhraseUserAnswer extends ActiveRecord\Model {

        static $table_name = 'mg_phrase_user_answer';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('sentence', 'foreign_key' => 'sentence_id', 'class_name' => 'Sentence'),
            array('user', 'foreign_key' => 'user_id', 'class_name' => 'User')
        );
    }
?>