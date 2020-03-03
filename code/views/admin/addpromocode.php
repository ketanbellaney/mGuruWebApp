<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Add new promocode</h2>
            <?php
		        if(@$error == 2) {
			        echo "<p class='alert alert-success'>New Promocode added.</p>";
			    } else if(@$error == 1) {
			        echo "<p class='alert alert-success'>Promocode already exisits.</p>";
			    }
            ?>
                    <form class='form-horizontal' role="form" action="<?php echo site_url('admin/addpromocode');?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">


						<div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Promocode *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="promocode" name="promocode" value="" placeholder="" required />
							</div>
						</div>

                        <div class="form-group">
							<label for="date_of_birth" class="col-sm-4 control-label">Start Date</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="start_date1" name="start_date1" placeholder="" value="<?php echo date("d/m/Y"); ?>" readonly='readonly' />
								<input type="hidden" class="form-control" id="start_date" name="start_date" placeholder="" value="<?php echo date("Y-m-d"); ?>" readonly='readonly' />
							</div>
						</div>

                        <div class="form-group">
							<label for="date_of_birth" class="col-sm-4 control-label">End Date</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="end_date1" name="end_date1" placeholder="" value="<?php echo date("d/m/Y",mktime(date("H") + 240)); ?>" readonly='readonly' />
								<input type="hidden" class="form-control" id="end_date" name="end_date" placeholder="" value="<?php echo date("Y-m-d",mktime(date("H") + 240)); ?>" readonly='readonly' />
							</div>
						</div>

						<div class="form-group">
							<label for="first_name" class="col-sm-4 control-label"> </label>
							<span class="col-sm-6" style='color:red; font-size: 10px'>For special discount please provide amount comma saperated Yearly,Quaterly,Monthly will be 500,180,60</span>
						</div>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Amount *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="amount" name="amount" value="" placeholder="" required />
							</div>
						</div>

						<div class="form-group">
							<label for="first_name" class="col-sm-4 control-label"> </label>
							<span class="col-sm-6" style='color:red; font-size: 10px'>For special discount please provide days comma saperated Yearly,Quaterly,Monthly will be 365,90,30</span>
						</div>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Days *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="days" name="days" value="" placeholder="" required />
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
                                            echo "<option value='$iid' >$val</option>";
                                        }*/
                                    ?>
								</select>
							</div>
						</div>
                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Count</label>
							<div class="col-sm-3">
                                <input type="text" class="form-control" id="count" name="count" value="" placeholder="" required />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Promo Image</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="promo_image" name="promo_image" value=""/>
							</div>
						</div>


					    <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Submit</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('site/home'); ?>">Cancel</a>

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
