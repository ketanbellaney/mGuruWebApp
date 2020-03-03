<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Activity level added successfully.</p>";
                } else if($error == 2) {
                    echo "<br /><p class='alert alert-success' >Activity level edited successfully.</p>";
                } else if($error == 3) {
                    echo "<br /><p class='alert alert-danger' >Access denied, this incident will be reported to administration.</p>";
                } else if($error == 4) {
                    echo "<br /><p class='alert alert-success' >Activity level deleted successfully.</p>";
                }
            ?>
            <h2>Activity level</h2>
            <br /><br />
            <a type="button" href='<?php echo site_url("englishcontent/addactivitylevel"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add Activity level</a>
            <br /><br /><br /><br />
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>Level</th>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
                <?php
                    foreach($activitylevels as $al) {
                        echo "
                        <tr>
                            <td>".$al->level."</td>
                            <td>".$al->title."</td>
                            <td><a href='".site_url("englishcontent/editactivitylevel/" . $al->id)."' >edit</a></td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </div>
</div>