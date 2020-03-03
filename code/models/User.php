<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class User extends ActiveRecord\Model {

        static $table_name = 'mg_user';

        // Associations(!!!!)
        static $has_many = array(
            array('promocode_used'),
            array('transaction'),
            array('grapheme_word_user_audio_recording_trace'),
        );

        static $has_one = array(
            array('profile'),
            array('user_referral_code'),
            array('user_device'),
            array('user_worksheet_status'),
        );

        static $belongs_to = array(
            
        );

        public function name() {
            if(trim($this->profile->display_name) != '' ) {
                return ucwords($this->profile->display_name);
            } else if(trim($this->profile->first_name) != '') {
                return ucwords($this->profile->first_name . ' ' . $this->profile->last_name);
            } else {
				return $this->username;
			}
        }

        function after_create() {
            $refcode = substr(MD5($this->id . $this->username),0,8);

            $mmm = 0;
            $iii = 0;
            do {

                $ccc = UserReferralCode::find_by_referral_code($refcode);
                $mmm = 1;
                if(isset($ccc->id)) {
                    $refcode = substr(MD5($this->id . $this->username . $iii),0,8);
                    $iii++;
                    $mmm = 0;
                }

            } while($mmm == 0);

            $ref_code = UserReferralCode::create(array(
                'user_id' => $this->id,
                'referral_code' => $refcode,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ));

            $ws = UserWorksheetStatus::create(array(
                "user_id" => $this->id,
                "count" => 5,
                "expire_date_time" => date("Y-m-t 23:59:59"),
                "created" => date("Y-m-d H:i:s"),
                "updated" => date("Y-m-d H:i:s"),
            ));

        }
    }
?>
