<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Grapheme extends ActiveRecord\Model {

        static $table_name = 'mg_grapheme';

        // Associations(!!!!)
        static $has_many = array(
            array('grapheme_word_linkage_primary', 'foreign_key' => 'grapheme_id', 'class_name' => 'GraphemeWordLinkage', 'conditions' => " `primary` = 'yes' "),
            array('grapheme_word_linkage', 'foreign_key' => 'grapheme_id', 'class_name' => 'GraphemeWordLinkage', 'conditions' => " `primary` != 'yes' "),
            array('grapheme_script', 'foreign_key' => 'grapheme_id', 'class_name' => 'GraphemeScript' ),
        );

        static $has_one = array(
            array('phrase', 'foreign_key' => 'grapheme_id', 'class_name' => 'Phrase' ),
        );

        static $belongs_to = array(
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );

        /*public function get_audio() {
            if(@$this->audio == '') {
                $CI = &get_instance();
                if(file_exists($CI->config->item("root_url") . "contentfiles/grapheme/" . $this->phoneme . ".mp3")) {
                //if(file_exists("contentfiles/grapheme/" . $this->phoneme . ".mp3")) {
                    return $this->phoneme . ".mp3";
                } else {
                    return '';
                }
            } else {
                return $this->audio;
            }
        }*/
    }
?>