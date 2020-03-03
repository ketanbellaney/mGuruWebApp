<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class GraphemeWordUserAudioRecordingTrace extends ActiveRecord\Model {

        static $table_name = 'mg_grapheme_word_user_audio_recording_trace';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('grapheme', 'foreign_key' => 'grapheme_id', 'class_name' => 'Grapheme'),
            array('word', 'foreign_key' => 'word_id', 'class_name' => 'Word'),
            array('user', 'foreign_key' => 'user_id', 'class_name' => 'User')
        );
    }
?>