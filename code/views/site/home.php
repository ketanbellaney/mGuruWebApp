<div class="container main-container">
    <div class="row">
        <div class="col-md-12">
            <h2>Welcome to mGuru</h2>
            <?php
                if(@$user->admin == 1 || @$user->admin == 2) {
            ?>
                <h3>Please select what you want to do</h3>

                <?php
                    if(@$user->admin == 1) {
                ?>
                <div class='row'>
                    <h5>User Actions</h5>
                    <a type="button" href='<?php echo site_url("admin/adduser"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add user</a>
                    <a type="button" href='<?php echo site_url("admin/viewuser"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>View user</a>
                    <a type="button" href='<?php echo site_url("admin/addpromocode"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add promocode</a>
                    <a type="button" href='<?php echo site_url("admin/viewpromocode"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>View promocode</a>
                    <a type="button" href='<?php echo site_url("admin/viewpartner"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>View Partner</a>
                </div>

                <div class='row'>
                    <h5>Concept Actions</h5>
                    <a type="button" href='<?php echo site_url("admin/addclass"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add class</a>
                    <a type="button" href='<?php echo site_url("admin/viewclass"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>View class</a>
                    <a type="button" href='<?php echo site_url("admin/addsubject"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add subject</a>
                    <a type="button" href='<?php echo site_url("admin/viewsubject"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>View subject</a>
                    <a type="button" href='<?php echo site_url("admin/addunits"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add units</a>
                    <a type="button" href='<?php echo site_url("admin/viewunits"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>View units</a>
                    <a type="button" href='<?php echo site_url("admin/addconcept"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add Concept</a>
                    <a type="button" href='<?php echo site_url("admin/viewconcept"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>View Concept</a>
                    <br style='clear:both;'/>
                    <a type="button" href='<?php echo site_url("admin/addconcept?for=grammar"); ?>' class="btn btn-primary btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>Add Grammar Concept</a>
                    <a type="button" href='<?php echo site_url("admin/viewconcept?for=grammar"); ?>' class="btn btn-primary btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>View Grammar Concept</a>
                </div>
                <div class='row'>
                    <h5>Question Actions</h5>
                    <a type="button" href='<?php echo site_url("admin/addquestiontemplate"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add Question Template</a>
                    <a type="button" href='<?php echo site_url("admin/viewquestiontemplate"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>View Question Template</a>
                    <a type="button" href='<?php echo site_url("admin/addquestion"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add Question</a>
                    <a type="button" href='<?php echo site_url("admin/viewquestion"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>View Question</a>
                </div>
            <?php
                }
            ?>
                <div class='row'>
                    <h5>Story</h5>
                    <a type="button" href='<?php echo site_url("content/addstory"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add new Story</a>
                    <a type="button" href='<?php echo site_url("content/story"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Story</a>
                    <a type="button" href='<?php echo site_url("content/editorschoicestory"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Editors Choice Story</a>
                </div>

                <div class='row'>
                    <h5>English Content</h5>
                    <a type="button" href='<?php echo site_url("admin/addquestion?for=grammar"); ?>' class="btn btn-primary btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>Add Grammar Question</a>
                    <a type="button" href='<?php echo site_url("admin/viewquestion?for=grammar"); ?>' class="btn btn-primary btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>View Grammar Question</a>
                    <br style='clear:both;'/>
                    <a type="button" href='<?php echo site_url("englishcontent/addgrapheme"); ?>' class="btn btn-primary btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>Add grapheme</a>
                    <a type="button" href='<?php echo site_url("englishcontent/viewgrapheme1"); ?>' class="btn btn-danger btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>( Old ) View grapheme</a>
                    <a type="button" href='<?php echo site_url("englishcontent/viewgrapheme"); ?>' class="btn btn-success btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>( New ) View grapheme</a>
                    <br style='clear:both;'/>
                    <a type="button" href='<?php echo site_url("englishcontent/addphrase"); ?>' class="btn btn-primary btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>Add phrase</a>
                    <a type="button" href='<?php echo site_url("englishcontent/viewphrase1"); ?>' class="btn btn-danger btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>( Old ) View phrase</a>
                    <a type="button" href='<?php echo site_url("englishcontent/viewphrase"); ?>' class="btn btn-success btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>( New ) View phrase</a>
                    <br style='clear:both;'/>
                    <a type="button" href='<?php echo site_url("englishcontent/addphonemestory"); ?>' class="btn btn-primary btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>Add phoneme story</a>
                    <a type="button" href='<?php echo site_url("englishcontent/viewphonemestory"); ?>' class="btn btn-primary btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>View phoneme story</a>
                    <br style='clear:both;'/>
                    <a type="button" href='<?php echo site_url("englishcontent/addwordsegment"); ?>' class="btn btn-primary btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>Add word segment</a>
                    <a type="button" href='<?php echo site_url("englishcontent/viewwordsegment1"); ?>' class="btn btn-danger btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>( Old ) View word segment</a>
                    <a type="button" href='<?php echo site_url("englishcontent/viewwordsegment"); ?>' class="btn btn-success btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>( New ) View word segment</a>
                    <br style='clear:both;'/>
                    <a type="button" href='<?php echo site_url("englishcontent/addvowelblend"); ?>' class="btn btn-primary btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>Add Vowel blend</a>
                    <a type="button" href='<?php echo site_url("englishcontent/viewvowelblend"); ?>' class="btn btn-primary btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>View Vowel blend</a>
                    <br style='clear:both;'/>
                    <a type="button" href='<?php echo site_url("englishcontent/addactivitylevel"); ?>' class="btn btn-primary btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>Add Activity Level</a>
                    <a type="button" href='<?php echo site_url("englishcontent/viewactivitylevel"); ?>' class="btn btn-primary btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>View Activity Level</a>
                    <br style='clear:both;'/>
                    <a type="button" href='<?php echo site_url("englishcontent/addactivity"); ?>' class="btn btn-primary btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>Add Activity</a>
                    <a type="button" href='<?php echo site_url("englishcontent/viewactivity"); ?>' class="btn btn-primary btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>View Activity</a>
                    <br style='clear:both;'/>
                    <a type="button" href='<?php echo site_url("englishcontent/addncrt"); ?>' class="btn btn-primary btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>Add NCRT Activity</a>
                    <a type="button" href='<?php echo site_url("englishcontent/viewncrt"); ?>' class="btn btn-primary btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>View NCRT Activity</a>
                    <br style='clear:both;'/>
                    <a type="button" href='<?php echo site_url("englishcontent/addhelpvideo"); ?>' class="btn btn-primary btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>Add Help video</a>
                    <a type="button" href='<?php echo site_url("englishcontent/viewhelpvideo"); ?>' class="btn btn-primary btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>View Help video</a>
                    <a type="button" href='<?php echo site_url("content/editorschoicehelp"); ?>' class="btn btn-primary btn-lg col-lg-3 col-md-3 col-sm-5 col-xs-11 " style='margin:5px;'>Editors Choice Help Video</a>
                    <br style='clear:both;'/>
                </div>

                <div class='row'>
                    <h5>Textbook Story</h5>
                    <a type="button" href='<?php echo site_url("englishcontent/addstorytextbook"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add textbook story</a>
                    <a type="button" href='<?php echo site_url("englishcontent/viewstorytextbook"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>View textbook story</a>
                    <a type="button" href='<?php echo site_url("englishcontent/addwordgroup"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add word group</a>
                    <a type="button" href='<?php echo site_url("englishcontent/viewwordgroup"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>View word group</a>
                </div>
            <?php
                } else {
            ?>
                <h3>Coming soon</h3>
            <?php
                }
            ?>

        </div>
    </div>
</div>