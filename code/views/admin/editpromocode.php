<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Edit Promocode</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('admin/editpromocode/' . $promocode_id);?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                        <div class="form-group">
							<label for="title" class="col-sm-4 control-label">Promocode</label>
							<div class="col-sm-3">
								<?php echo $promocode->promocode; ?>
							</div>
						</div>

                        <div class="form-group">
							<label for="date_of_birth" class="col-sm-4 control-label">Start Date</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="start_date1" name="start_date1" placeholder="" value="<?php echo $promocode->start_date->format("d/m/Y"); ?>" readonly='readonly' />
								<input type="hidden" class="form-control" id="start_date" name="start_date" placeholder="" value="<?php echo $promocode->start_date->format("Y-m-d"); ?>" readonly='readonly' />
							</div>
						</div>

                        <div class="form-group">
							<label for="date_of_birth" class="col-sm-4 control-label">End Date</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="end_date1" name="end_date1" placeholder="" value="<?php echo $promocode->end_date->format("d/m/Y"); ?>" readonly='readonly' />
								<input type="hidden" class="form-control" id="end_date" name="end_date" placeholder="" value="<?php echo $promocode->end_date->format("Y-m-d"); ?>" readonly='readonly' />
							</div>
						</div>

						<div class="form-group">
							<label for="first_name" class="col-sm-4 control-label"> </label>
							<span class="col-sm-6" style='color:red; font-size: 10px'>For special discount please provide amount comma saperated Yearly,Quaterly,Monthly will be 500,180,60</span>
						</div>
                        <div class="form-group">
							<label for="date_of_birth" class="col-sm-4 control-label">Amount *</label>
							<div class="col-sm-6">
                                <input type="text" class="form-control" id="amount" name="amount" value="<?php echo $promocode->amount; ?>" placeholder="" required />
							</div>
						</div>
						
						<div class="form-group">
							<label for="first_name" class="col-sm-4 control-label"> </label>
							<span class="col-sm-6" style='color:red; font-size: 10px'>For special discount please provide days comma saperated Yearly,Quaterly,Monthly will be 365,90,30</span>
						</div>
                        <div class="form-group">
							<label for="date_of_birth" class="col-sm-4 control-label">Days *</label>
							<div class="col-sm-6">
                                <input type="text" class="form-control" id="days" name="days" value="<?php echo $promocode->days; ?>" placeholder="" required />
							</div>
						</div>

                        <div class="form-group" style='display:none;'>
							<label for="status" class="col-sm-4 control-label">Package</label>
							<div class="col-sm-3">
								<select class="form-control" id="package" name="package" >
                                    <?php
                                        /*$_pack = array(
                                            "5,,1" => "1 day validity",
                                            "15,,7" => "1 week validity",
                                            "50,,30" => "1 month validity",
                                            "150,,90" => "3 month validity",
                                            "400,,365" => "1 year validity",
                                            );
                                        foreach($_pack as $iid => $val) {
                                            if($promocode->amount . ",,".$promocode->days == $iid) {
                                                echo "<option value='$iid' selected='selected' >$val</option>";
                                            } else {
                                                echo "<option value='$iid' >$val</option>";
                                            }
                                        }*/
                                    ?>
								</select>
							</div>
						</div>
                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Count</label>
							<div class="col-sm-3">
                                <input type="text" class="form-control" id="count" name="count" value="<?php echo $promocode->count; ?>" placeholder="" required />
							</div>
						</div>

                        <?php
                            if($promocode->promo_image != '') {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Promo Image<br />
                            <small><em>Upload a new image to replace the existing image only else leave it blank</em></small></label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="promo_image" name="promo_image" value=""/>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Existing Promo Image</label>
                            <div class="col-sm-6">
								<img src="<?php echo base_url("images/" . $promocode->promo_image); ?>" width='100' />
							</div>
						</div>
                        <?php
                            } else {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Promo Image</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="promo_image" name="promo_image" value=""/>
							</div>
						</div>
                        <?php
                            }
                        ?>

					    <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Save</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('admin/viewpromocode'); ?>">Cancel</a>

                     </form>
        </div>
    </div>
</div>
<script>
    $( "#start_date1" ).datepicker({
        dateFormat: 'dd/mm/yy',
        altField: "#start_date",
        altFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });

    $( "#end_date1" ).datepicker({
        dateFormat: 'dd/mm/yy',
        altField: "#end_date",
        altFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });
</script>
