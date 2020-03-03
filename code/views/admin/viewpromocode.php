<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Promocode edited successfully. </p>";
                }
            ?>
            <h2>View Promocode</h2>
            <?php
                $total = Promocode::count(array(
                    'conditions' => " 1 = 1 ",
                ));

                $totalpagecount = 50;
                $start = $page * $totalpagecount;

                $promos = Promocode::find('all',array(
                    'conditions' => " 1 = 1 ",
                    "order" => 'created DESC',

                ));

            ?>
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
                    foreach($promos as $promo) {
                        echo "
                        <tr>
                            <td>".$promo->id."</td>
                            <td>".$promo->promocode."</td>
                            <td>".$promo->amount." / ".$promo->days."</td>
                            <td>".$promo->count."</td>
                            <td><a href='".site_url("admin/viewpromocodeused/" . $promo->id)."' >".count($promo->promocode_used)."</a></td>
                            <td>".$promo->start_date->format("d/m/Y")." - ".$promo->end_date->format("d/m/Y")."</td>
                            <td>".$promo->created->format("d/m/Y")."</td>
                            <td><a href='".site_url("admin/editpromocode/" . $promo->id)."' >edit</a></td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </div>
</div>