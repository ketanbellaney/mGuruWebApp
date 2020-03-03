<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
	<head>
	    <meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<title>mGuru English</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1">
    	<meta name="description" content="mGuru English" />
	    <meta name="keywords" content="mGuru English" />
	    <meta name="author" content="mGuru English" />

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

	    <!-- Animate.css -->
    	<link rel="stylesheet" href="<?php echo base_url("webapp_asset/css/animate.css"); ?>" />
    	<!-- Icomoon Icon Fonts-->
    	<link rel="stylesheet" href="<?php echo base_url("webapp_asset/css/icomoon.css"); ?>" />
    	<!-- Bootstrap  -->
    	<link rel="stylesheet" href="<?php echo base_url("webapp_asset/css/bootstrap.css"); ?>" />

    	<link rel="stylesheet" href="<?php echo base_url("webapp_asset/css/style.css"); ?>" />

        <!-- jQuery ui  -->
   	    <link rel="stylesheet" href="<?php echo base_url("webapp_asset/css/jquery-ui.min.css"); ?>" />


    	<!-- Modernizr JS -->
    	<script src="<?php echo base_url("webapp_asset/js/modernizr-2.6.2.min.js"); ?>"></script>
    	<!-- FOR IE9 below -->
    	<!--[if lt IE 9]>
    	<script src="<?php echo base_url("webapp_asset/js/respond.min.js"); ?>"></script>
    	<![endif]-->


        <!-- END: box-wrap -->
	</head>
	<body>
	<div class="box-wrap">
		<header role="banner" id="fh5co-header">
			<div class="container">
				<nav class="navbar navbar-default">
					<div class="row">
						<div class="col-md-12">
							<div class="fh5co-navbar-brand text-center">
								<a class="fh5co-logo" href="<?php echo site_url(); ?>"><img src="<?php echo base_url("webapp_asset/images/img_logo_extended.png"); ?>" alt="mGuru English" width='200' /></a>
							</div>
                            <br />
						</div>
						<div class="col-md-12">
							<ul class="nav text-center">
                                <?php
                                    if(isset($user->id)) {
                                ?>
                                        <li><a href="<?php echo site_url("dashboard"); ?>">Hi <?php echo $user->profile->display_name; ?></a></li>
                                        <li class="active"><a href="<?php echo site_url("dashboard"); ?>">Daily Quest</a></li>
                                        <li><a href="<?php echo site_url("logout"); ?>">Logout</a></li>
                                <?php
                                    } else {
                                ?>
                                    <li><a href="<?php echo site_url("login"); ?>">Login</a></li>
                                    <li><a href="<?php echo site_url("sign-up"); ?>">Sign-Up</a></li>
                                <?php
                                    }
                                ?>
							</ul>
						</div>
						<!-- <div class="col-md-3">
							<ul class="social">
								<li><a href="#"><i class="icon-twitter"></i></a></li>
								<li><a href="#"><i class="icon-dribbble"></i></a></li>
								<li><a href="#"><i class="icon-instagram"></i></a></li>
							</ul>
						</div> -->
					</div>
				</nav>
		  </div>
		</header>
		<!-- END: header -->