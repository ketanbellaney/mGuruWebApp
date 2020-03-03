<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Edit worksheet api key</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('admin/editworksheetapikey/' . $wak_id);?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">User</label>
							<div class="col-sm-6">
								<?php echo $wak->user->name() . " (".$wak->user_id.")"; ?>
							</div>
						</div>
						
						<div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">API KEY</label>
							<div class="col-sm-6">
								<em style='color: #851B1B'><?php echo $wak->apikey;?></em>
							</div>
						</div>

                        <div class="form-group">
							<label for="date_of_birth" class="col-sm-4 control-label">Hourly Limit *</label>
							<div class="col-sm-3">
								<select class="form-control" id="limit_hourly" name="limit_hourly" >
                                    <?php
                                        $limit_array = array(10,50,100,250,500, 750, 1000, 2000, 5000, 10000, 15000, 20000,40000,50000);
                                        foreach($limit_array as $val) {
											if(@$wak->limit_hourly == $val) {
												echo "<option value='$val' selected='selected'>$val</option>";
											} else {
												echo "<option value='$val' >$val</option>";
											}
                                        }
                                    ?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label for="date_of_birth" class="col-sm-4 control-label">Monthly Limit *</label>
							<div class="col-sm-3">
								<select class="form-control" id="limit_monthly" name="limit_monthly" >
                                    <?php
                                        foreach($limit_array as $val) {
											if(@$wak->limit_monthly == $val) {
												echo "<option value='$val' selected='selected'>$val</option>";
											} else {
												echo "<option value='$val' >$val</option>";
											}
                                        }
                                    ?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label for="date_of_birth" class="col-sm-4 control-label">Expire Date *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="expire_datetime1" name="expire_datetime1" placeholder="" value="<?php echo @$wak->expire_datetime->format("d/m/Y"); ?>" readonly='readonly' />
								<input type="hidden" class="form-control" id="expire_datetime" name="expire_datetime" placeholder="" value="<?php echo @$wak->expire_datetime->format("Y-m-d"); ?>" readonly='readonly' />
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Status *</label>
							<div class="col-sm-3">
								<select class="form-control" id="status" name="status" >
                                    <?php
                                        $_status = array("active","inactive");
                                        foreach($_status as $val) {
                                            if(@$wak->status == $val) {
												echo "<option value='$val' selected='selected'>$val</option>";
											} else {
												echo "<option value='$val' >$val</option>";
											}
                                        }
                                    ?>
								</select>
							</div>
						</div>

					    <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Save</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('admin/viewworksheetapikey'); ?>">Cancel</a>

                     </form>
        </div>
    </div>
</div>
<script>
    $( "#expire_datetime1" ).datepicker({
        dateFormat: 'dd/mm/yy',
        altField: "#expire_datetime",
        altFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });
</script>
