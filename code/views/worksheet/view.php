<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>View Worksheet - <?php echo @$ws->name; ?></h2>

            <div class="form-group class_display">
                <div class="col-sm-3"><b>Board:</b> <?php echo @$ws->board; ?></div>
				<div class="col-sm-2"><b>Class:</b> <?php echo @$ws->classes_id - 2; ?></div>
				<div class="col-sm-2"><b>Date:</b> <?php echo @$ws->created->format("d F, Y"); ?></div>
				<div class="col-sm-2"><a type="button" class="btn btn-default" href="<?php echo site_url("worksheet/downloadpdf/" . @$ws->id); ?>" >Download Worksheet</a></div>
				<div class="col-sm-3"><a type="button" class="btn btn-default" href="<?php echo site_url("worksheet/downloadanswerpdf/" . @$ws->id); ?>" >Download Answer</a></div>
			</div>
            <br /><br />
            <div class="form-group class_display" style="width: 630px;  ">
                <br /><br />
                <div class="col-sm-12" ><?php echo @$ws_sheet; ?></div>
                <br /><br />
			</div>
        </div>
    </div>
</div>