<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Concept edited successfully.</p>";
                }
            ?>
            <h2>View Concept</h2>
            <?php
                $total = Concept::count(array(
                    'conditions' => " 1 = 1 ",
                ));

                $totalpagecount = 50;
                $start = $page * $totalpagecount;

                $concepts = Concept::find('all',array(
                    'conditions' => " 1 = 1 ",
                    "order" => 'units_id ASC'
                ));

                if( $total > 50 ) {
                    echo "Page";
                    $pages = round( $total / $totalpagecount );
                    for($ii = 0 ; $ii < $pages ; $ii++) {
                        echo "<a href='".site_url("admin/viewconcept/" . $ii)."' >$ii</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
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
                    <th>Concept</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
                <?php
                    if(@$_REQUEST['for'] == "grammar") {
                        foreach($concepts as $concept) {
                            if($concept->units->subject_id == 2) {
                            echo "
                            <tr>
                                <td>".$concept->id."</td>
                                <td>".$concept->units->classes->name."</td>
                                <td>".$concept->units->subject->name."</td>
                                <td>".$concept->units->name."</td>
                                <td>".$concept->name."</td>
                                <td>".$concept->status."</td>
                                <td>".$concept->created->format("d/m/Y")."</td>
                                <td><a href='".site_url("admin/editconcept/" . $concept->id."?for=grammar")."' >edit</a></td>
                            </tr>
                            ";
                            }
                        }
                    } else {
                        foreach($concepts as $concept) {
                            echo "
                            <tr>
                                <td>".$concept->id."</td>
                                <td>".$concept->units->classes->name."</td>
                                <td>".$concept->units->subject->name."</td>
                                <td>".$concept->units->name."</td>
                                <td>".$concept->name."</td>
                                <td>".$concept->status."</td>
                                <td>".$concept->created->format("d/m/Y")."</td>
                                <td><a href='".site_url("admin/editconcept/" . $concept->id)."' >edit</a></td>
                            </tr>
                            ";
                        }
                    }
                ?>
            </table>
        </div>
    </div>
</div>