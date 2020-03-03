<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->

            <h2>View Promocode <?php echo $promocode->promocode; ?></h2>
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Promocode</th>
                    <th>Amount / Days</th>
                    <th>Current Count</th>
                    <th>Used Count</th>
                    <th>Validity</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
                <?php
                        echo "
                        <tr>
                            <td>".$promocode->id."</td>
                            <td>".$promocode->promocode."</td>
                            <td>".$promocode->amount." / ".$promocode->days."</td>
                            <td>".$promocode->count."</td>
                            <td>".count($promocode->promocode_used)."</td>
                            <td>".$promocode->start_date->format("d/m/Y")." - ".$promocode->end_date->format("d/m/Y")."</td>
                            <td>".$promocode->created->format("d/m/Y")."</td>
                            <td><a href='".site_url("admin/editpromocode/" . $promocode->id)."' >edit</a></td>
                        </tr>
                        ";
                ?>
            </table>
            <br />
            <br />
            <br />
            <h2>Promocode Used By Users</h2>
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Class</th>
                    <th>School</th>
                    <th>Date</th>
                </tr>
                <?php
                    foreach($promocode->promocode_used as $val) {
                        $school = '';
                        if(@$val->user->profile->school_id != '') {
                            $school = $val->user->profile->school->name;
                        }
                        echo "
                        <tr>
                            <td>".$val->user_id."</td>
                            <td><a href='".site_url("admin/viewstudentrecord/" . $val->user_id)."' >".$val->user->username." (".$val->user->profile->first_name . " " . $val->user->profile->last_name.")</a></td>
                            <td>".$val->user->mobile."</td>
                            <td>".$val->user->profile->current_class."</td>
                            <td>".$school."</td>
                            <td>".$val->promocode_used_date->format("d/m/Y")."</td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </div>
</div>