<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Progress of user <?php echo $user1->name() . " (" .$user1->id.")"; ?></h2>
            <br /><br />
            <h3>Phonics</h3>
            <?php
                $points = array();
                $level = array();
                $status = array();
                $stars = array();
                $learn_audio = array();
                $trace_image = array();
                $phrase_audio = array();
                $word_audio = array();
                $phrase_game_ans_normal = array();
                $phrase_game_ans_normal_per = array();
                $phrase_game_ans_test_count = array();
                $phrase_game_ans_test_correct = array();
                $word_game_ans_normal = array();
                $word_game_ans_normal_per = array();
                $word_game_ans_test_count = array();
                $word_game_ans_test_correct = array();
                $word_game_ans_test_count1 = array();
                $word_game_ans_test_correct1 = array();
                $challenge = array();
                $challenge_per = array();
                for($ii = 1 ; $ii <= 9 ; $ii++) {
                    $level[$ii] = "<td>$ii</td>";
                    $points[$ii] = "<td>-</td>";
                    $status[$ii] = "<td>Not Started</td>";
                    $stars[$ii] = "<td>-</td>";
                    $learn_audio[$ii] = "<td>-</td>";
                    $trace_image[$ii] = "<td>-</td>";
                    $phrase_audio[$ii] = "<td>-</td>";
                    $word_audio[$ii] = "<td>-</td>";
                    $phrase_game_ans_normal[$ii] = "<td>-</td>";
                    $phrase_game_ans_test_count[$ii] = 0;
                    $phrase_game_ans_test_correct[$ii] = 0;
                    $word_game_ans_normal[$ii] = "<td>-</td>";
                    $word_game_ans_test_count[$ii] = 0;
                    $word_game_ans_test_correct[$ii] = 0;
                    $word_game_ans_test_count1[$ii] = 0;
                    $word_game_ans_test_correct1[$ii] = 0;
                    $challenge[$ii] = "<td>-</td>";
                    $challenge_per[$ii] = "<td>-</td>";
                    $word_game_ans_normal_per[$ii] = "<td>-</td>";
                    $phrase_game_ans_normal_per[$ii] = "<td>-</td>";
                }

                foreach($graphemeUserStatus as $val) {
                    $points[$val->unit] = "<td>".$val->total_point."</td>";
                    if($val->status == '') {
                        $status[$val->unit] = "<td>pending</td>";
                    } else {
                        $status[$val->unit] = "<td>".$val->status."</td>";
                    }
                    $stars[$val->unit] = "<td>".$val->total_star."</td>";
                }

                foreach($learn_data as $val) {
                    if(isset($learn_audio[$val->unit])) {
                        if($val->learn_count != 0)
                            $learn_audio[$val->unit] = "<td>".$val->learn_count."</td>";
                        if($val->trace_count != 0)
                            $trace_image[$val->unit] = "<td>".$val->trace_count."</td>";
                    }
                }

                foreach($phrase_data as $val) {
                    if(isset($phrase_audio[$val->unit])) {
                        if($val->phrase_count != 0)
                            $phrase_audio[$val->unit] = "<td>".$val->phrase_count."</td>";
                    }
                }

                foreach($word_data as $val) {
                    if(isset($word_audio[$val->unit])) {
                        if($val->word_count != 0)
                            $word_audio[$val->unit] = "<td>".$val->word_count."</td>";
                    }
                }

                foreach($phrase_ans_data as $val) {
                    if(isset($phrase_game_ans_normal[$val->unit])) {
                        if($val->total_count_normal != 0) {
                            $phrase_game_ans_normal[$val->unit] = "<td>".$val->correct_count_normal."/".$val->total_count_normal."</td>";
                            $Temp = ( $val->correct_count_normal / $val->total_count_normal ) * 100;
                            $phrase_game_ans_normal_per[$val->unit] = "<td>".round($Temp, 2)."</td>";
                        }
                        $phrase_game_ans_test_count[$val->unit] = $val->total_count_test;
                        $phrase_game_ans_test_correct[$val->unit] = $val->correct_count_test;
                    }
                }

                foreach($word_ans_data as $val) {
                    if(isset($word_game_ans_normal[$val->unit])) {
                        if($val->total_count_normal != 0) {
                            $word_game_ans_normal[$val->unit] = "<td>".$val->correct_count_normal."/".$val->total_count_normal."</td>";
                            $Temp = ( $val->correct_count_normal / $val->total_count_normal ) * 100;
                            $word_game_ans_normal_per[$val->unit] = "<td>".round($Temp, 2)."</td>";
                        }
                        $word_game_ans_test_count1[$val->unit] = $val->total_count_test;
                        $word_game_ans_test_correct1[$val->unit] = $val->correct_count_test;
                    }
                }

                foreach($word_ans_data1 as $val) {
                    if(isset($word_game_ans_test_correct[$val->unit])) {
                        $word_game_ans_test_count[$val->unit] = $val->total_count_test;
                        $word_game_ans_test_correct[$val->unit] = $val->correct_count_test;
                    }
                }

                for($ii = 1 ; $ii <= 9 ; $ii++) {
                    $total_countt = $phrase_game_ans_test_count[$ii] + $word_game_ans_test_count1[$ii] + $word_game_ans_test_count[$ii];
                    if($total_countt != 0 ) {
                        $challenge[$ii] = "<td>".($phrase_game_ans_test_correct[$ii] + $word_game_ans_test_correct1[$ii] + $word_game_ans_test_correct[$ii])."/".($phrase_game_ans_test_count[$ii] + $word_game_ans_test_count1[$ii] + $word_game_ans_test_count[$ii])."</td>";
                        $Temp = ( ($phrase_game_ans_test_correct[$ii] + $word_game_ans_test_correct1[$ii] + $word_game_ans_test_correct[$ii]) / ($phrase_game_ans_test_count[$ii] + $word_game_ans_test_count1[$ii] + $word_game_ans_test_count[$ii]) ) * 100;
                        $challenge_per[$ii] = "<td>".round($Temp, 2)."</td>";
                    }
                }
            ?>
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <td><b>Level</b></td>
                    <?php echo implode("",$level); ?>
                </tr>
                <tr>
                    <td><b>Status</b></td>
                    <?php echo implode("",$status); ?>
                </tr>
                <tr>
                    <td><b>Points</b></td>
                    <?php echo implode("",$points); ?>
                </tr>
                <tr>
                    <td><b>Stars</b></td>
                    <?php echo implode("",$stars); ?>
                </tr>
                <tr>
                    <td><b>Learn Audio</b></td>
                    <?php echo implode("",$learn_audio); ?>
                </tr>
                <tr>
                    <td><b>Trace Count</b></td>
                    <?php echo implode("",$trace_image); ?>
                </tr>
                <tr>
                    <td><b>Word Audio</b></td>
                    <?php echo implode("",$word_audio); ?>
                </tr>
                <tr>
                    <td><b>Phrase Audio</b></td>
                    <?php echo implode("",$phrase_audio); ?>
                </tr>
                <tr>
                    <td><b>Phrase Game</b></td>
                    <?php echo implode("",$phrase_game_ans_normal); ?>
                </tr>
                <tr>
                    <td><b>Phrase Game %</b></td>
                    <?php echo implode("",$phrase_game_ans_normal_per); ?>
                </tr>
                <tr>
                    <td><b>Word Game</b></td>
                    <?php echo implode("",$word_game_ans_normal); ?>
                </tr>
                <tr>
                    <td><b>Word Game %</b></td>
                    <?php echo implode("",$word_game_ans_normal_per); ?>
                </tr>
                <tr>
                    <td><b>Challenge</b></td>
                    <?php echo implode("",$challenge); ?>
                </tr>
                <tr>
                    <td><b>Challenge %</b></td>
                    <?php echo implode("",$challenge_per); ?>
                </tr>
            </table>

             <br /><br />
             <h3>Story</h3>
             <br /><br />
             <?php

                $level = array();
                $total_download = array();
                $total_reading = array();
                $total_completed = array();
                $total_score = array();
                $total_count_read_aloud = array();
                $total_count_conversation = array();
                $total_count_describe_image = array();

                $total_questions_pre = array();
                $total_questions_pre_per = array();
                $total_questions_during = array();
                $total_questions_during_per = array();
                $total_questions_post = array();
                $total_questions_post_per = array();
                $total_questions_overall = array();
                $total_questions_overall_per = array();

                for($ii = 1 ; $ii <= 5 ; $ii++) {
                    $level[$ii] = "<td>$ii</td>";
                    $total_download[$ii] = "<td>-</td>";
                    $total_reading[$ii] = "<td>-</td>";
                    $total_completed[$ii] = "<td>-</td>";
                    $total_score[$ii] = "<td>-</td>";
                    $total_count_read_aloud[$ii] = "<td>-</td>";
                    $total_count_conversation[$ii] = "<td>-</td>";
                    $total_count_describe_image[$ii] = "<td>-</td>";

                    $total_questions_pre[$ii] = "<td>-</td>";
                    $total_questions_pre_per[$ii] = "<td>-</td>";
                    $total_questions_during[$ii] = "<td>-</td>";
                    $total_questions_during_per[$ii] = "<td>-</td>";
                    $total_questions_post[$ii] = "<td>-</td>";
                    $total_questions_post_per[$ii] = "<td>-</td>";
                    $total_questions_overall[$ii] = "<td>-</td>";
                    $total_questions_overall_per[$ii] = "<td>-</td>";
                }

                foreach($story_user_status as $val) {
                    if($val->total_download != 0)
                        $total_download[$val->level] = "<td>".$val->total_download."</td>";
                    if($val->total_reading != 0)
                        $total_reading[$val->level] = "<td>".$val->total_reading."</td>";
                    if($val->total_completed != 0)
                        $total_completed[$val->level] = "<td>".$val->total_completed."</td>";
                    if($val->total_score != 0)
                        $total_score[$val->level] = "<td>".$val->total_score."</td>";
                }

                foreach($story_audio_data as $val) {
                    if($val->total_count_read_aloud != 0)
                        $total_count_read_aloud[$val->level] = "<td>".$val->total_count_read_aloud."</td>";
                    if($val->total_count_conversation != 0)
                        $total_count_conversation[$val->level] = "<td>".$val->total_count_conversation."</td>";
                    if($val->total_count_describe_image != 0)
                        $total_count_describe_image[$val->level] = "<td>".$val->total_count_describe_image."</td>";
                }

                foreach($story_question_data as $val) {
                    $overall_count = 0;
                    $overall_correct = 0;
                    if($val->total_questions_pre_count != 0) {
                        $total_questions_pre[$val->level] = "<td>".$val->total_questions_pre_correct."/".$val->total_questions_pre_count."</td>";
                        $Temp = ( $val->total_questions_pre_correct / $val->total_questions_pre_count ) * 100;
                        $total_questions_pre_per[$val->level]  = "<td>".round($Temp, 2)."</td>";
                        $overall_count += $val->total_questions_pre_count;
                        $overall_correct += $val->total_questions_pre_correct;
                    }
                    if($val->total_questions_during_count != 0) {
                        $total_questions_during[$val->level] = "<td>".$val->total_questions_during_correct."/".$val->total_questions_during_count."</td>";
                        $Temp = ( $val->total_questions_during_correct / $val->total_questions_during_count ) * 100;
                        $total_questions_during_per[$val->level]  = "<td>".round($Temp, 2)."</td>";
                        $overall_count += $val->total_questions_during_count;
                        $overall_correct += $val->total_questions_during_correct;
                    }
                    if($val->total_questions_post_count != 0) {
                        $total_questions_post[$val->level] = "<td>".$val->total_questions_post_correct."/".$val->total_questions_post_count."</td>";
                        $Temp = ( $val->total_questions_post_correct / $val->total_questions_post_count ) * 100;
                        $total_questions_post_per[$val->level]  = "<td>".round($Temp, 2)."</td>";
                        $overall_count += $val->total_questions_post_count;
                        $overall_correct += $val->total_questions_post_correct;
                    }
                    if($overall_count != 0 ) {
                        $total_questions_overall[$val->level] = "<td>".$overall_correct."/".$overall_count."</td>";
                        $Temp = ( $overall_correct / $overall_count ) * 100;
                        $total_questions_overall_per[$val->level]  = "<td>".round($Temp, 2)."</td>";
                    }
                }
             ?>

             <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <td><b>Level</b></td>
                    <?php echo implode("",$level); ?>
                </tr>
                <tr>
                    <td><b>Downloaded</b></td>
                    <?php echo implode("",$total_download); ?>
                </tr>
                <tr>
                    <td><b>Reading</b></td>
                    <?php echo implode("",$total_reading); ?>
                </tr>
                <tr>
                    <td><b>Completed</b></td>
                    <?php echo implode("",$total_completed); ?>
                </tr>
                <tr>
                    <td><b>Score</b></td>
                    <?php echo implode("",$total_score); ?>
                </tr>
                <tr>
                    <td><b>Read Aloud Audio</b></td>
                    <?php echo implode("",$total_count_read_aloud); ?>
                </tr>
                <tr>
                    <td><b>Conversation Audio</b></td>
                    <?php echo implode("",$total_count_conversation); ?>
                </tr>
                <tr>
                    <td><b>Describe Image Audio</b></td>
                    <?php echo implode("",$total_count_describe_image); ?>
                </tr>
                <tr>
                    <td><b>Pre Question</b></td>
                    <?php echo implode("",$total_questions_pre); ?>
                </tr>
                <tr>
                    <td><b>Pre Question %</b></td>
                    <?php echo implode("",$total_questions_pre_per); ?>
                </tr>
                <tr>
                    <td><b>During Question</b></td>
                    <?php echo implode("",$total_questions_during); ?>
                </tr>
                <tr>
                    <td><b>During Question %</b></td>
                    <?php echo implode("",$total_questions_during_per); ?>
                </tr>
                <tr>
                    <td><b>Post Question</b></td>
                    <?php echo implode("",$total_questions_post); ?>
                </tr>
                <tr>
                    <td><b>Post Question %</b></td>
                    <?php echo implode("",$total_questions_post_per); ?>
                </tr>
                <tr>
                    <td><b>Overall Question</b></td>
                    <?php echo implode("",$total_questions_overall); ?>
                </tr>
                <tr>
                    <td><b>Overall Question %</b></td>
                    <?php echo implode("",$total_questions_overall_per); ?>
                </tr>

            </table>
        </div>
    </div>
</div>