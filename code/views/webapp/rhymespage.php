<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>
<section id="stories" class="mg-videos" style='background: url(<?php echo base_url("webapp_asset/images/stories-bg.png"); ?>);    background-position-y: -124px;height: 580px; overflow: hidden;'>

    <div class="container-fluid">
        <div class="row-fluid clearfix">
            <div class="col-md-8 col-md-offset-2 text-center">
                <h1 class="mg-h1-header" style='margin-top: 15px;margin-bottom: 0px;'>
                    Rhymes
                </h1>
            </div>
        </div>
        <!--<div class="row-fluid mg-stories-videos-wrapper clearfix">
            <div class="col-md-8 col-md-offset-2">
                <div class="row">
                     <div class="mg-level-search-wrapper">
                        <div class="col-md-6">
                            <div class="mg-sub-nav">
                                <ul class="list-unstyled list-inline text-center">
                                    <li <?php if($level == 1) { ?>class="active" <?php } ?>>
                                        <a href="<?php echo site_url("stories/books"); ?>?level=1">Level 1</a>
                                    </li>
                                    <li <?php if($level == 2) { ?>class="active" <?php } ?>>
                                        <a href="<?php echo site_url("stories/books"); ?>?level=2">Level 2</a>
                                    </li>
                                    <li <?php if($level == 3) { ?>class="active" <?php } ?>>
                                        <a href="<?php echo site_url("stories/books"); ?>?level=3">Level 3</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="javascript:void(0);" class="mg-search">
                                <img src="<?php echo base_url("webapp_asset/images/search_1.svg"); ?>" alt="mGuru Search">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12 mg-search-box-wrapper hide">
                        <form id='searchform'  method='post' action="<?php echo site_url("stories/books"); ?>" >
                        <input type="text" name="keyword" required>
                        <a href="javascript:void(0);" class="mg-search-hide">
                            <img src="<?php echo base_url("webapp_asset/images/back_1.svg"); ?>" alt="mGuru Search Hide">
                        </a>
                        <a type='submit' href="#" onclick="document.getElementById('searchform').submit();" class="mg-search-btn">Search</a>
                        </form>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="row-fluid clearfix mg-stories-videos">
            <div class="col-md-8 col-md-offset-2 mg-stories-videos-wrapper-inner">
                <div class="row">

                    <div class="col-md-6">
                        <a href='<?php echo site_url("activity/454/start"); ?>' ><div class="mg-video mg-video-lg" >
                            <img src='https://mguruenglish.com/contentfiles/phrase/_df18b09ee1da30ca3a7f3ca3f06481a6.png' style='height: 100%; width: 100%;' />
                            <div class="mg-video-bottom-overlay text-left">
                                Dogs
                            </div>
                        </div></a>
                    </div>
                    <div class="col-md-6">
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <a href='<?php echo site_url("activity/464/start"); ?>' ><div class="mg-video mg-video-sm">
                                    <img src='https://mguruenglish.com/contentfiles/phrase/_80b80f8bf744336d3c62ec364765340b.png' style='height: 100%; width: 100%;' />
                                    <div class="mg-video-bottom-overlay text-left">
                                        My puppy
                                    </div>
                                </div></a>
                            </div>
                            <div class="col-md-6">
                                <a href='<?php echo site_url("activity/465/start"); ?>' ><div class="mg-video mg-video-sm">
                                    <img src='https://mguruenglish.com/contentfiles/phrase/_6c51da2eaf34ec125a2e40550336e785.png' style='height: 100%; width: 100%;' />
                                    <div class="mg-video-bottom-overlay text-left">
                                        The Gray Squirrel
                                    </div>
                                </div></a>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <a href='<?php echo site_url("activity/474/start"); ?>' ><div class="mg-video mg-video-sm">
                                    <img src='https://mguruenglish.com/contentfiles/sentence/_0b6a68ceee93905bbabfba229bbc5bb4.png' style='height: 100%; width: 100%;' />
                                    <div class="mg-video-bottom-overlay text-left">
                                        Butterfly
                                    </div>
                                </div></a>
                            </div>
                            <div class="col-md-6">
                                <a href='<?php echo site_url("activity/494/start"); ?>' ><div class="mg-video mg-video-sm">
                                    <img src='https://mguruenglish.com/contentfiles/sentence/_7df285605ae1fbaec96b329043a77e51.png' style='height: 100%; width: 100%;' />
                                    <div class="mg-video-bottom-overlay text-left">
                                        Sundays for song
                                    </div>
                                </div></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">

                    <div class="col-md-3">
                        <a href='<?php echo site_url("activity/504/start"); ?>' >
                            <div class="mg-video mg-video-sm">
                                <img src='http://api001.mguru.co.in/contentfiles/sentence/_1bfc6931f5b07e13fddd65bc21c44d55.png' style='height: 100%; width: 100%;' />
                                <div class="mg-video-bottom-overlay text-left">
                                    There is a car song
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                        //if($ii % 4 == 0 ) {
                        //    echo "</div><div class='row clearfix'> ";
                        //}
                    ?>

                </div>

            </div>
        </div>
    </div>
</section>

<style>
.mg-video {
     overflow: hidden;
     box-shadow: 2px 2px #cccccc;
}

.mg-video-bottom-overlay {
    border-top: 2px solid #00DC1D;
}

.footer {
    bottom: 0px !important;
}

body {
    height: 100%;
    overflow: hidden !important;
}


</style>