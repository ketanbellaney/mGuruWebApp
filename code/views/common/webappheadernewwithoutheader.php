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
<html class="no-js"> <!--<![endif]-->
	<head>
	    <meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name=apple-mobile-web-app-capable content=yes>
        <link rel="manifest" href="https://mguruenglish.com/manifest.json"/>
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

        <!-- jQuery ui  -->
   	    <link rel="stylesheet" href="<?php echo base_url("webapp_asset/css/jquery-ui.min.css"); ?>" />


    	<!-- Modernizr JS -->
    	<script src="<?php echo base_url("webapp_asset/js/modernizr-2.6.2.min.js"); ?>"></script>
    	<!-- FOR IE9 below -->
    	<!--[if lt IE 9]>
    	<script src="<?php echo base_url("webapp_asset/js/respond.min.js"); ?>"></script>
    	<![endif]-->
	</head>
    <body >