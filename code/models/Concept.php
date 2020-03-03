<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Concept extends ActiveRecord\Model {

        static $table_name = 'mg_concepts';

        // Associations(!!!!)
        static $has_many = array(
            array('next_concepts', 'foreign_key' => 'next_concept_id', 'class_name' => 'Concept'),
            array('previous_concepts', 'foreign_key' => 'previous_concept_id', 'class_name' => 'Concept'),
            array('lower_concepts', 'foreign_key' => 'lower_concept_id', 'class_name' => 'Concept'),
            array('higher_concepts', 'foreign_key' => 'higher_concept_id', 'class_name' => 'Concept'),
        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('units'),
            array('next_concept', 'foreign_key' => 'next_concept_id', 'class_name' => 'Concept'),
            array('previous_concept', 'foreign_key' => 'previous_concept_id', 'class_name' => 'Concept'),
            array('lower_concept', 'foreign_key' => 'lower_concept_id', 'class_name' => 'Concept'),
            array('higher_concept', 'foreign_key' => 'higher_concept_id', 'class_name' => 'Concept'),
        );
    }
?>