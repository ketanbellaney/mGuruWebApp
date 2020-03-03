<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class VowelBlend extends ActiveRecord\Model {

        static $table_name = 'mg_vowel_blend';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('wordsegment', 'foreign_key' => 'wordsegment_id', 'class_name' => 'Wordsegment'),
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );

        public function get_audio() {
            if(@$this->audio == '') {
                $CI = &get_instance();
                if(file_exists($CI->config->item("root_url") . "contentfiles/vowelblend/" . $this->secondary_letter . $this->vowel . ".mp3")) {
                //if(file_exists("contentfiles/vowelblend/" . $this->secondary_letter . $this->vowel . ".mp3")) {
                    return $this->secondary_letter . $this->vowel . ".mp3";
                } else {
                    return '';
                }
            } else {
                return $this->audio;
            }
        }
    }
?>