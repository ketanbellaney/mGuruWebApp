<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Limit edited successfully.</p>";
                }
            ?>
            <h2>Partners</h2>
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Partner</th>
                    <th>Limit</th>
                    <th>Count Parent</th>
                    <th>Count Child</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td><?php echo $cg_slate->id; ?></td>
                    <td><?php echo $cg_slate->name; ?></td>
                    <td><?php echo $cg_slate->limit; ?></td>
                    <td><?php echo $cg_slate_parent_count; ?></td>
                    <td><?php echo $cg_slate_child_count; ?></td>
                    <td><a href='<?php echo site_url("admin/editpartner/" . $cg_slate->id); ?>' >edit</a></td>
                </tr>
            </table>
        </div>
    </div>
</div>