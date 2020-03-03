<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class WorksheetApikey extends ActiveRecord\Model {

        static $table_name = 'mg_worksheet_apikey';

        // Associations(!!!!)
        static $has_many = array(

        );

        static $has_one = array(

        );

        static $belongs_to = array(
            array('user'),
            array('added_by', 'foreign_key' => 'added_by_id', 'class_name' => 'User'),
            array('updated_by', 'foreign_key' => 'updated_by_id', 'class_name' => 'User'),
        );


        public function generateapikey() {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randstring = '';
            for ($i = 0; $i < 10; $i++) {
                $randstring += $characters[rand(0, strlen($characters))];
            }
            $randstring1 = '';
            for ($i = 0; $i < 10; $i++) {
                $randstring1 += $characters[rand(0, strlen($characters))];
            }

            return md5($randstring) . md5($randstring1);
        }
    }
?>