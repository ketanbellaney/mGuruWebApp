<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <h2>Edit Textbook story</h2>

                    <form class='form-horizontal' role="form" action="<?php echo site_url('englishcontent/editstorytextbook/' . $story_textbook_id);?>" method="post" name="" enctype="multipart/form-data" onsubmit="return validateregistration();">


                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Title *</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="title" name="title" value="<?php echo @$storytextbook->title; ?>" placeholder="Title" required />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Title (Hindi)</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="title_hindi" name="title_hindi" value="<?php echo @$storytextbook->title_hindi; ?>" placeholder="Title (Hindi)" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Title (Marathi)</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="title_marathi" name="title_marathi" value="<?php echo @$storytextbook->title_marathi; ?>" placeholder="Title (Marathi)" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Content</label>
							<div class="col-sm-6">
								<textarea class="form-control" id="content" name="content" placeholder="Content" required><?php echo @$storytextbook->content; ?></textarea>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Content (Hindi)</label>
							<div class="col-sm-6">
								<textarea class="form-control" id="content_hindi" name="content_hindi" placeholder="Content (Hindi)" ><?php echo @$storytextbook->content_hindi; ?></textarea>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Content (Marathi)</label>
							<div class="col-sm-6">
								<textarea class="form-control" id="content_marathi" name="content_marathi" placeholder="Content (Marathi)" ><?php echo @$storytextbook->content_marathi; ?></textarea>
							</div>
						</div>

                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Unit *</label>
							<div class="col-sm-3">
								<select class="form-control" id="unit" name="unit" required>
                                    <?php
                                        for($ii = 1 ; $ii <= 12 ; $ii++) {
                                            if(@$storytextbook->unit == $ii) {
                                                echo "<option value='".$ii."' selected='selected' >" . $ii . "</option>";
                                            } else {
                                                echo "<option value='".$ii."' >" . $ii . "</option>";
                                            }
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
                                            if(@$storytextbook->class == $cla) {
                                                echo "<option value='".$cla."' selected='selected' >" . $cla . "</option>";
                                            } else {
                                                echo "<option value='".$cla."' >" . $cla . "</option>";
                                            }
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
                                        $flagg = 0;
                                        foreach($_eb as $val) {
                                            if(@$storytextbook->board == $val) {
                                                echo "<option value='".$val."' selected='selected' >" . $val . "</option>";
                                                $flagg = 1;
                                            } else {
                                                echo "<option value='".$val."' >" . $val . "</option>";
                                            }
                                        }
                                        if($flagg == 0) {
                                            echo "<option value='".@$storytextbook->board."' selected='selected' >" . @$storytextbook->board . "</option>";
                                        }
                                    ?>
								</select>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Order Number</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="order_number" name="order_number" value="<?php echo @$storytextbook->order_number; ?>" placeholder="Order Number" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Page Number</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="page_number" name="page_number" value="<?php echo @$storytextbook->page_number; ?>" placeholder="Page Number" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Source</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="source" name="source" value="<?php echo @$storytextbook->source; ?>" placeholder="Source" />
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Author</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="author" name="author" value="<?php echo @$storytextbook->author; ?>" placeholder="Author" />
							</div>
						</div>

                        <?php
                            if(@$storytextbook->image != '') {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Image<br />
                            <small><em>Upload a new image to replace the existing image only else leave it blank</em></small></label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="image" name="image" value=""/>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Existing Image</label>
                            <div class="col-sm-6">
								<img src="<?php echo base_url("contentfiles/textbook/" . $storytextbook->image); ?>" width='200' />
							</div>
						</div>
                        <?php
                            } else {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Image</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="image" name="image" value=""/>
							</div>
						</div>
                        <?php
                            }
                        ?>

                        <?php
                            if($storytextbook->audio != '') {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Audio<br />
                            <small><em>Upload a new audio to replace the existing audio only else leave it blank</em></small></label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="audio" name="audio" value=""/>
							</div>
						</div>

                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Existing Audio</label>
                            <div class="col-sm-6">
								<a href="<?php echo base_url("contentfiles/textbook/" . $storytextbook->audio); ?>" target='blank' >click here</a>
							</div>
						</div>
                        <?php
                            } else {
                        ?>
                        <div class="form-group">
							<label for="first_name" class="col-sm-4 control-label">Audio</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="audio" name="audio" value=""/>
							</div>
						</div>
                        <?php
                            }
                        ?>


                        <div class="form-group">
							<label for="status" class="col-sm-4 control-label">Status *</label>
							<div class="col-sm-3">
								<select class="form-control" id="status" name="status" required>
                                    <?php
                                        $_status = array("active","inactive");
                                        foreach($_status as $sta) {
                                            if(@$storytextbook->status == $sta) {
                                                echo "<option value='".$sta."' selected='selected' >" . $sta . "</option>";
                                            } else {
                                                echo "<option value='".$sta."' >" . $sta . "</option>";
                                            }
                                        }
                                    ?>
								</select>
							</div>
						</div>

                       <br /><br />
                        <button type="submit" class="btn btn-primary pull-right" id="addusersubmit" name="addusersubmit">Save</button>
					    <a role="button" class="btn  pull-right" href="<?php echo site_url('englishcontent/viewstorytextbook'); ?>">Cancel</a>

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