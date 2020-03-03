<section id="intro">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 text-center">
                <div class="intro animate-box">
                    <h2>Daily Quest</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 text-center">
                <?php
                    foreach($dail_quest as $val) {
                ?>
                        <div class='btn btn-lg btn-success col-lg-12 col-md-12 col-xs-12 col-sm-12 text-center' >

                        <?php echo $val['activityLevelName']; ?></div>
                        <br style='clear:both; '/>
                        <br style='clear:both; '/>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</section>
