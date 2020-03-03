<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Wordsegment extends ActiveRecord\Model {

        static $table_name = 'mg_wordsegment';

        // Associations(!!!!)
        static $has_many = array(
            array('graphemes', 'foreign_key' => 'wordsegment_id', 'class_name' => 'GraphemeWordsegmentLinkage', 'order' => 'order_number ASC'),
            array('language_blend', 'foreign_key' => 'wordsegment_id', 'class_name' => 'LanguageBlend' ),
        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );

       /* public function get_image() {
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