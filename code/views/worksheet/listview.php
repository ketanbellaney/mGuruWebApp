<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>My Worksheet</h2>
            <div class='alert alert-info' role='alert' > Worksheet credit: <?php echo @$ws_credit; ?></div>
            <br />
            <div class="table-responsive ">
                <table class="table table-striped table-hover table-condensed">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Board</th>
                            <th>Class</th>
                            <th>Date</th>
                            <th>Download</th>
                            <th>Answer</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $ii = 1;
                            foreach($ws as $sheet) {
                                echo "
                            <tr>
                                <td>$ii</td>
                                <td>".@$sheet->name."</td>
                                <td>".@$sheet->board."</td>
                                <td>".(@$sheet->classes_id - 2)."</td>
                                <td>".@$sheet->created->format("d F, Y")."</td>
                                <td><a type='button' class='btn btn-default' href='".site_url("worksheet/downloadpdf/" . @$sheet->id)."' >download</button></td>
                                <td><a type='button' class='btn btn-default' href='".site_url("worksheet/downloadanswerpdf/" . @$sheet->id)."' >answer</button></td>
                                <td><a type='button' class='btn btn-default' href='".site_url("worksheet/view/" . @$sheet->id)."' >view</button></td>
                            </tr>";
                                $ii++;
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
mixpanel.identify('<?php echo $user->id; ?>');
mixpanel.alias('<?php echo $user->id; ?>');
mixpanel.track("List Worksheet");
</script>