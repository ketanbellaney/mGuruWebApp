<div class="container main-container">
    <div class="row">
        <div class="col-lg-12"> <!-- Registration Form -->
            <?php
                if($error == 1) {
                    echo "<br /><p class='alert alert-success' >Story added successfully.</p>";
                } else if($error == 2) {
                    echo "<br /><p class='alert alert-success' >Story edited successfully.</p>";
                } else if($error == 3) {
                    echo "<br /><p class='alert alert-success' >Story page added successfully.</p>";
                } else if($error == 4) {
                    echo "<br /><p class='alert alert-success' >Story page edited successfully.</p>";
                }
            ?>
            <h2>Story</h2>
            <br /><br />
            <a type="button" href='<?php echo site_url("content/addstory"); ?>' class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-5 col-xs-11 " style='margin:5px;'>Add Story</a>
            <br /><br /><br /><br />
            <?php
                $storys = Story::find('all',array(
                    'conditions' => " 1 = 1 ",
                    "order" => 'level,name ASC'
                ));
            ?>
            <table class='table table-hover table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Language</th>
                    <th>Page</th>
                    <th>Added By</th>
                    <th>Updated By</th>
                    <th>Status</th>
                    <th>Questions</th>
                    <th>Edit</th>
                </tr>
                <?php
                    foreach($storys as $story) {
                        $sq = $story->story_question_linkage;
                        echo "
                        <tr>
                            <td>".$story->id."</td>
                            <td>".$story->name."</td>
                            <td>".$story->language->name."</td>
                            <td>";
                            foreach($story->storypage as $page) {
                                $audio = "no";
                                $audio1 = "no";
                                if($page->audio != '') {
                                    $audio = 'yes';
                                    if($page->audio_map != '') {
                                        $audio1 = 'yes';
                                    }
                                }
                                echo "Page " . $page->pageno . "&nbsp; $audio $audio1 &nbsp;&nbsp;<a href='".site_url("content/editstorypage/" . $page->id)."' >edit</a><br />";
                            }
                            echo "<a href='".site_url("content/addstorypage/" . $story->id)."' >add more page</a></td>
                            <td>".$story->added_by->name()."<br />
                            ".$story->created->format("d/m/Y")."</td>
                            <td>".$story->updated_by->name()."<br />
                            ".$story->updated->format("d/m/Y")."</td>
                            <td>".$story->status."</td>
                            <td><a href='".site_url("content/storyquestions/" . $story->id)."' >questions</a><br /><br />Count: ".count($sq)."</td>
                            <td><a href='".site_url("content/editstory/" . $story->id)."' >edit</a></td>
                        </tr>
                        ";
                        unset($sq);
                    }
                ?>
            </table>
        </div>
    </div>
</div>