<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Word extends ActiveRecord\Model {

        static $table_name = 'mg_word';

        // Associations(!!!!)
        static $has_many = array(
            array('grapheme_word_linkage', 'foreign_key' => 'word_id', 'class_name' => 'GraphemeWordLinkage'),
            array('story_textbook_group_word_linkage', 'foreign_key' => 'word_id', 'class_name' => 'StoryTextbookGroupWordLinkage'),
            array('word_translation', 'foreign_key' => 'word_id', 'class_name' => 'WordTranslation' ),
            array('word_transliteration', 'foreign_key' => 'word_id', 'class_name' => 'WordTransliteration' ),
        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );

        /*public function get_image() {
            if(@$this->image == '') {
                $CI = &get_instance();
                if(file_exists($CI->config->item("root_url") . "contentfiles/word/" . strtolower(trim($this->word)) . ".png")) {
                //if(file_exists("contentfiles/word/" . strtolower(trim($this->word)) . ".png")) {
                    $this->image = strtolower(trim($this->word)) . ".png";
                    $this->save();
                    return strtolower(trim($this->word)) . ".png";
                } else {
                    return '';
                }
            } else {
                return $this->image;
            }
        }*/

    }
?>