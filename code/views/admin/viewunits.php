<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Unit edited successfully.</p>";
                }
            ?>
            <h2>View Units</h2>
            <?php
                $total = Units::count(array(
                    'conditions' => " 1 = 1 ",
                ));

                $totalpagecount = 50;
                $start = $page * $totalpagecount;

                $units = Units::find('all',array(
                    'conditions' => " 1 = 1 ",
                    "order" => 'classes_id,subject_id ASC',
                    'limit' => $totalpagecount,
                    'offset' => $start,
                ));

                if( $total > 50 ) {
                    echo "Page";
                    $pages = round( $total / $totalpagecount );
                    for($ii = 0 ; $ii < $pages ; $ii++) {
                        echo "<a href='".site_url("admin/viewunits/" . $ii)."' >$ii</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
                    echo "<br /><br />";
                }

            ?>
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Class</th>
                    <th>Subject</th>
                    <th>Unit</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
                <?php
                    foreach($units as $unit) {
                        echo "
                        <tr>
                            <td>".$unit->id."</td>
                            <td>".$unit->classes->name." (".$unit->examination_board.") </td>
                            <td>".$unit->subject->name."</td>
                            <td>".$unit->name."</td>
                            <td>".$unit->status."</td>
                            <td>".$unit->created->format("d/m/Y")."</td>
                            <td><a href='".site_url("admin/editunits/" . $unit->id)."' >edit</a></td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </div>
</div>