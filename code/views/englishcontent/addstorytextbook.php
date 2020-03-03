<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Story added successfully.</p>";
                } else if($error == 2) {
                    echo "<br /><p class='alert alert-success' >Some error occured, Please add story again.</p>";
                }
            ?>
            <br /><br />
            <a type="button" href='<?php echo site_url("englishcontent/viewstorytextbook"); ?>' class="btn btn-primary btn-lg col-lg-4 col-md-4 col-sm-11 col-xs-11 " style='margin:5px;'>View all story textbox</a>
            <br /><br />

            <h2>Add textbook story</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('englishcontent/addstorytextbook');?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">

                       <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Title *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="title" name="title" value="" placeholder="Title" required />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Title (Hindi)</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="title_hindi" name="title_hindi" value="" placeholder="Title (Hindi)" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Title (Marathi)</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="title_marathi" name="title_marathi" value="" placeholder="Title (Marathi)" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Content</label>
							<div class="col-sm-6">
								<textarea class="form-control" id="content" name="content" placeholder="Content" required></textarea>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Content (Hindi)</label>
							<div class="col-sm-6">
								<textarea class="form-control" id="content_hindi" name="content_hindi" placeholder="Content (Hindi)" ></textarea>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Content (Marathi)</label>
							<div class="col-sm-6">
								<textarea class="form-control" id="content_marathi" name="content_marathi" placeholder="Content (Marathi)" ></textarea>
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Unit *</label>
							<div class="col-sm-3">
								<select class="form-control" id="unit" name="unit" required>
                                    <?php
                                        for($ii = 1 ; $ii <= 12 ; $ii++) {
                                            echo "<option value='".$ii."' >" . $ii . "</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Class *</label>
							<div class="col-sm-6">
                                <select class="form-control" id="class" name="class" required>
                                    <?php
                                        $_class = array("JKG","SKG",1,2,3,4,5);
                                        foreach($_class as $cla) {
                                            echo "<option value='".$cla."' >" . $cla . "</option>";
                                        }
                                    ?>
                                </select>
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Examination Board *</label>
							<div class="col-sm-3">
								<select class="form-control" id="board" name="board" onchange="changeeb(this);" required>
                                    <option value=''></option>
                                    <?php
                                        $_eb = array("ISCE","CBSE","IGCSE","SSC","other");
                                        foreach($_eb as $val) {
                                            echo "<option value='$val' >$val</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Order Number</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="order_number" name="order_number" value="" placeholder="Order Number" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Page Number</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="page_number" name="page_number" value="" placeholder="Page Number" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Source</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="source" name="source" value="" placeholder="Source" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Author</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="author" name="author" value="" placeholder="Author" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Image</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="image" name="image" value=""/>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Audio</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="audio" name="audio" value=""/>
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Status *</label>
							<div class="col-sm-3">
								<select class="form-control" id="status" name="status" required>
                                    <?php
                                        $_status = array("active","inactive");
                                        foreach($_status as $sta) {
                                            echo "<option value='".$sta."' >" . $sta . "</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <br /><br />
					    <button type="submit" class="btn btn-primary pull-right" id="addsubmit" name="addsubmit">Submit</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url(); ?>">Cancel</a>

                     </form>
        </div>
    </div>
</div>

<script>
    function changeeb(dis){
        if(dis.value == 'other') {
            dis.parentNode.innerHTML = "<input type='text' class='form-control' id='examination_board' name='examination_board' placeholder='Examination Board' value='' />";
        }
    }
</script>