<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class WordUserAnswers extends ActiveRecord\Model {

        static $table_name = 'mg_word_user_answers';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('word', 'foreign_key' => 'word_id', 'class_name' => 'Word'),
            array('user', 'foreign_key' => 'user_id', 'class_name' => 'User')
        );
    }
?>