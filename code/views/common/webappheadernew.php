<?php
    if($_lang_map === '') {
        $_lang_map = 1;
        $_lang_db = 4;
    }
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" > <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta name=apple-mobile-web-app-capable content=yes>
        <link rel="manifest" href="https://mguruenglish.com/manifest.json"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>mGuru English</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="mGuru English" />
        <meta name="keywords" content="mGuru English" />
        <meta name="author" content="mGuru English" />

        <meta name='mobile-web-app-capable' content='yes'>
        <meta name='apple-mobile-web-app-capable' content='yes'>
        <meta name='application-name' content='mGuru'>
        <meta name='theme-color' content='#2196F3'>


        <!-- Facebook and Twitter integration -->
        <meta property="og:title" content="mGuru English"/>
        <meta property="og:image" content=""/>
        <meta property="og:url" content=""/>
        <meta property="og:site_name" content="mGuru English"/>
        <meta property="og:description" content="mGuru English"/>
        <meta name="twitter:title" content="mGuru English" />
        <meta name="twitter:image" content="" />
        <meta name="twitter:url" content="" />
        <meta name="twitter:card" content="mGuru English" />

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="shortcut icon" href="<?php echo base_url("webapp_asset/images/logo.png"); ?>" />

        <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,300,700|Roboto:300,400' rel='stylesheet' type='text/css' />
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700" rel="stylesheet">

        <!-- Animate.css -->
        <link rel="stylesheet" href="<?php echo base_url("webapp_asset/css/animate.css"); ?>" />
        <!-- Icomoon Icon Fonts-->
        <link rel="stylesheet" href="<?php echo base_url("webapp_asset/css/icomoon.css"); ?>" />
        <!-- Bootstrap  -->
        <link rel="stylesheet" href="<?php echo base_url("webapp_asset/css/bootstrap.css"); ?>" />

        <link rel="stylesheet" href="<?php echo base_url("webapp_asset/css/style_web.css"); ?>" />

        <!-- Modernizr JS -->
        <script src="<?php echo base_url("webapp_asset/js/modernizr-2.6.2.min.js"); ?>"></script>
        <!-- FOR IE9 below -->
        <!--[if lt IE 9]>
        <script src="<?php echo base_url("webapp_asset/js/respond.min.js"); ?>"></script>
        <![endif]-->


    	<!-- jQuery -->
		<script src="<?php echo base_url("webapp_asset/js/jquery.min.js"); ?>"></script>
		<!-- jQuery Easing -->
		<script src="<?php echo base_url("webapp_asset/js/jquery.easing.1.3.js"); ?>"></script>
		<!-- Bootstrap -->
		<script src="<?php echo base_url("webapp_asset/js/bootstrap.min.js"); ?>"></script>
		<!-- Waypoints -->
		<script src="<?php echo base_url("webapp_asset/js/jquery.waypoints.min.js"); ?>"></script>
	    <!-- circle progress -->
		<script src="<?php echo base_url("webapp_asset/js/circle-progress.min.js"); ?>"></script>

		<!-- Main JS (Do not remove) -->
		<script src="<?php echo base_url("webapp_asset/js/main.js"); ?>"></script>

    </head>
    <?php $body_cls = (isset($user->id)) ? "logged-in" : ""; ?>
    <body class="<?php echo $body_cls; ?>">
        <header role="banner" id="fh5co-header">
            <div class="container container-no-margin-padding">
                <?php if(isset($user->id)) { ?>
                    <nav class="navbar navbar-white navbar-fixed-top">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand navbar-brand-no-margin-padding" href="<?php echo site_url("daily-quest"); ?>">
                                <img class="mg-logo" src="<?php echo base_url("webapp_asset/images/logo.png"); ?>"/>
                            </a>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse pull-right">
                            <ul class="nav navbar-nav mg-navbar-nav">
                                <li class="mg-navbar-item dropdown mg-item-3">
                                    <a href="<?php echo site_url("/stories"); ?>" class="dropdown-toggle text-center" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="mg-icon icon-stories"></span>
                                        <span class="mg-item-title"><?php echo @$_translation->array[$_lang_map]->item[90]; ?></span>
                                    </a>
                                    <ul class="dropdown-menu mg-dropdown-menu">
                                        <li>
                                            <a href="<?php echo site_url("/stories/books"); ?>"><?php echo @$_translation->array[$_lang_map]->item[210]; ?></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url("/stories/video"); ?>"><?php echo @$_translation->array[$_lang_map]->item[211]; ?></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url("/stories/rhymes"); ?>">Rhymes</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="mg-navbar-item mg-item-2">
                                    <a href="<?php echo site_url("/explore"); ?>" class="text-center">
                                        <span class="mg-icon icon-explore"></span>
                                        <span class="mg-item-title"><?php echo @$_translation->array[$_lang_map]->item[89]; ?></span>
                                    </a>
                                </li>
                                <li class="mg-navbar-item mg-item-1 active">
                                    <a href="<?php echo site_url("/daily-quest"); ?>" class="text-center">
                                        <span class="mg-icon icon-daily-quest"></span>
                                        <span class="mg-item-title"><?php echo @$_translation->array[$_lang_map]->item[88]; ?></span>
                                    </a>
                                </li>
                                <li class="mg-navbar-item dropdown mg-item-4">
                                    <a href="<?php echo site_url("/profile"); ?>" class="dropdown-toggle text-center" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="mg-icon icon-profile"></span>
                                        <span class="mg-item-title"><?php echo @$_translation->array[$_lang_map]->item[91]; ?></span>
                                    </a>
                                    <ul class="dropdown-menu mg-dropdown-menu " style='padding-bottom: 0px;background-color: #009CF8;'>
                                        <li>
                                            <a href="<?php echo site_url("/profile"); ?>"><?php echo @$_translation->array[$_lang_map]->item[91]; ?></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url("/profile/edit-info"); ?>"><?php echo @$_translation->array[$_lang_map]->item[117]; ?></a>
                                        </li>
                                        <!-- <li>
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#mgEarnFreeMangoModal">Free Mangoes</a>
                                        </li> -->
                                        <li>
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#mgLearnEngModal"><?php echo @$_translation->array[$_lang_map]->item[137]; ?></a>
                                        </li>
                                        <!--<li>
                                            <a href="<?php echo site_url("/profile/promo-code"); ?>">Promo Code</a>
                                        </li> -->
                                        <li>
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#mgAreYouSureModal"><?php echo @$_translation->array[$_lang_map]->item[118]; ?></a>
                                        </li>
                                        <li>
                                            <br />
                                        </li>
                                        <li style='background-color: #4FB9F9;'>
                                            <a href='https://www.facebook.com/mguruapps/' target='_blank' style='float:right;'><img src='<?php echo base_url("webapp_asset/images/fb_1.svg"); ?>' height='21' width='21' /></a><br style='clear:both;' />
                                            <div class="copyright" style='color: #ffffff;padding-top: 0px;'>&copy; <?php echo date("Y"); ?> mGuru PVT. LTD. ALL RIGHTS RESERVED.</div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div><!--/.navbar-collapse -->
                    </nav>
                <?php } ?>
            </div>
        </header>
