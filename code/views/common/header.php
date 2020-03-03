<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="mguru">
    <meta name="author" content="mguru">
    <link rel="icon" href="">

    <title>mGuru</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url("css/bootstrap.min.css"); ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url("css/mguru.css"); ?>" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url(); ?>">mGuru</a>
            </div>

            <div id="navbar" class="navbar-collapse collapse">
                <?php
                    if(isset($user->id)) {
                ?>
                <form class="navbar-form navbar-right" action='#' method='post'>
                    <div class="form-group">
                        <em style='color: #ffffff; font-size: 15px;'>Hi <?php echo $user->profile->first_name; ?>&nbsp;&nbsp;</em>
                    </div>

                    <button type="button" onclick='window.location.href="<?php echo site_url("site/logout"); ?>";' class="btn btn-danger">Sign out</button>
                </form>
                <?php
                    } else {
                ?>
                <form class="navbar-form navbar-right" action='<?php echo site_url("site/loginprocess"); ?>' method='post'>
                    <div class="form-group">
                        <input type="text" name='log_email' id='log_email' required placeholder="Email" class="form-control" />
                    </div>
                    <div class="form-group">
                        <input type="password" name='log_password' id='log_password' required  placeholder="Password" class="form-control" />
                    </div>
                    <button type="submit" class="btn btn-success">Sign in</button>
                </form>
                <?php
                    }
                ?>
            </div><!--/.navbar-collapse -->
        </div>
    </nav>