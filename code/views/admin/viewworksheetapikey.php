<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Worksheet API KEY edited successfully. </p>";
                }
            ?>
            <h2>View Worksheet Api Key</h2>
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Limit (hourly / monthly)</th>
                    <th>Expire</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
                <?php
                    foreach($wak as $promo) {
                        echo "
                        <tr>
                            <td>".$promo->id."</td>
                            <td>".$promo->user->name()." (".$promo->user_id.")</td>
                            <td>".$promo->limit_hourly." / ".$promo->limit_monthly."</td>
                            <td>".$promo->expire_datetime->format("d/m/Y")."</td>
                            <td>".$promo->created->format("d/m/Y")."</td>
                            <td><a href='".site_url("admin/editworksheetapikey/" . $promo->id)."' >edit</a></td>
                        </tr>
                        <tr>
							<td colspan='6'>".$promo->apikey."</td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </div>
</div>
