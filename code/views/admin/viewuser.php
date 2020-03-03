<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >User edited successfully. </p>";
                }
            ?>
            <h2>View user <a href='<?php echo site_url("admin/progressall"); ?>' class='btn btn-primary' >analysis</a></h2>
            <?php
                $total = User::count(array(
                    'conditions' => " 1 = 1 ",
                ));

                $totalpagecount = 50;
                $start = $page * $totalpagecount;

                $users = User::find('all',array(
                    'conditions' => " 1 = 1 ",
                    "order" => 'created DESC',
                    'limit' => $totalpagecount,
                    'offset' => $start,

                ));

                if( $total > 50 ) {
                    echo "Page";
                    $pages = round( $total / $totalpagecount );
                    for($ii = 0 ; $ii < $pages ; $ii++) {
                        echo "<a href='".site_url("admin/viewuser/" . $ii)."' >$ii</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
                    echo "<br /><br />";
                }

            ?>
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Username</th>
                    <th>Class / School</th>
                    <th>Status</th>
                    <th>Date of Registration</th>
                    <th>Action</th>
                    <th>Progress</th>
                </tr>
                <?php
                    foreach($users as $user1) {
                        echo "
                        <tr>
                            <td>".$user1->id."</td>
                            <td>".$user1->name()."</td>
                            <td>".$user1->mobile."</td>
                            <td>".$user1->username."</td>
                            <td>".$user1->profile->current_class." / ";
                            if($user1->profile->school) {
                                echo $user1->profile->school->name;
                            }
                            echo "</td>
                            <td>".$user1->status."</td>
                            <td>".$user1->created->format("d/m/Y")."</td>
                            <td><a href='".site_url("admin/edituser/" . $user1->id)."' >edit</a></td>
                            <td><a href='".site_url("admin/progressuser/" . $user1->id)."' >progress</a> - ".count(@$user1->grapheme_word_user_audio_recording_trace)."</td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </div>
</div>