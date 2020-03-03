<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Subject edited successfully.</p>";
                }
            ?>
            <h2>View Subject</h2>
            <?php
                $total = Subject::count(array(
                    'conditions' => " 1 = 1 ",
                ));

                $totalpagecount = 50;
                $start = $page * $totalpagecount;

                $subjects = Subject::find('all',array(
                    'conditions' => " 1 = 1 ",
                    "order" => 'created DESC',
                    'limit' => $totalpagecount,
                    'offset' => $start,
                ));

                if( $total > 50 ) {
                    echo "Page";
                    $pages = round( $total / $totalpagecount );
                    for($ii = 0 ; $ii < $pages ; $ii++) {
                        echo "<a href='".site_url("admin/viewsubject/" . $ii)."' >$ii</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
                    echo "<br /><br />";
                }

            ?>
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Subject</th>
                    <th>Class</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
                <?php
                    foreach($subjects as $subject) {
                        echo "
                        <tr>
                            <td>".$subject->id."</td>
                            <td>".$subject->name."</td>
                            <td>";
                            foreach($subject->class_subject_linkage as $val) {
                                echo $val->classes->name . " - " . $val->status ."<br />";
                            }
                        echo "</td>
                            <td>".$subject->created->format("d/m/Y")."</td>
                            <td><a href='".site_url("admin/editsubject/" . $subject->id)."' >edit</a></td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </div>
</div>