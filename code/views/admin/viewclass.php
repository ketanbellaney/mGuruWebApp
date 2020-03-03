<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Class edited successfully.</p>";
                }
            ?>
            <h2>View Class</h2>
            <?php
                $total = Classes::count(array(
                    'conditions' => " 1 = 1 ",
                ));

                $totalpagecount = 50;
                $start = $page * $totalpagecount;

                $classes = Classes::find('all',array(
                    'conditions' => " 1 = 1 ",
                    "order" => 'created DESC',
                    'limit' => $totalpagecount,
                    'offset' => $start,
                ));

                if( $total > 50 ) {
                    echo "Page";
                    $pages = round( $total / $totalpagecount );
                    for($ii = 0 ; $ii < $pages ; $ii++) {
                        echo "<a href='".site_url("admin/viewclass/" . $ii)."' >$ii</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
                    echo "<br /><br />";
                }

            ?>
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Class</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
                <?php
                    foreach($classes as $class) {
                        echo "
                        <tr>
                            <td>".$class->id."</td>
                            <td>".$class->name."</td>
                            <td>".$class->status."</td>
                            <td>".$class->created->format("d/m/Y")."</td>
                            <td><a href='".site_url("admin/editclass/" . $class->id)."' >edit</a></td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </div>
</div>