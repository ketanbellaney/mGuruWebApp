<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Help Video Question added successfully.</p>";
                } else if($error == 2) {
                    echo "<br /><p class='alert alert-success' >Help Video Question edited successfully.</p>";
                } else if ( $error == 3 ) {
                    echo "<br /><p class='alert alert-success' >Help Video Question deleted successfully. </p>";
                }
            ?>
            <h2>Help Video Question For <?php echo $helpvideo->title; ?></h2>
            <br /><br />
            <a type="button" href='<?php echo site_url("admin/addquestion/0/0/" . $helpvideo->id); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add Question</a>
            <br /><br /><br /><br />
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Question</th>
                    <th>Order Number</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Action</th>
                </tr>
                <?php
                    foreach($helpvideo->help_video_question_linkage as $question) {
                        if($question->question->status == 'active') {
                        echo "
                        <tr>
                            <td>".$question->question->id."</td>
                            <td>".$question->question->title."</td>
                            <td>".$question->order_number."</td>
                            <td>".$question->question->added_by->name()."<br />
                            ".$question->question->created->format("d/m/Y")."</td>
                            <td>".$question->question->updated_by->name()."<br />
                            ".$question->question->updated->format("d/m/Y")."</td>
                            <td><a href='".site_url("admin/editquestion/" . $question->question->id."/0/" . $helpvideo->id)."' >edit</a><br />
                            <a href='".site_url("admin/deletequestion/" . $question->question->id."/0/" . $helpvideo->id)."' onclick='return confirm(\"Are you sure?\");' >delete</a></td>
                        </tr>
                        ";
                        }
                    }
                ?>
            </table>
        </div>
    </div>
</div>