<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Anyone can create their own math worksheet for students to practice or test. Make personalized worksheets for students in 1-5. SSC Maharashtra, West Bengal, and many more">
        <meta name="author" content="mguru">
        <link rel="icon" href="<?php echo base_url("images/logo.png"); ?>">
        <meta content="math, maths, math worksheet, maths worksheet, maths homework, maths practice, mguru, mguru worksheet" name="keywords" />

        <meta property="og:type" content="article" />
        <meta property="og:title" content="mGuru Math Worksheet" />
        <meta property="og:description" content="Your friend wants you to try mGuru Math Worksheet for free. Anyone can create their own Math Worksheet for students to practice or test. Make personalized worksheets for students in 1-5. SSC Maharashtra, West Bengal, and many more" />
        <meta property="og:image" content="<?php echo base_url("images/shareimage.png"); ?>" />

        <title>mGuru Math Worksheet</title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url("css/bootstrap.min.css"); ?>" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?php echo base_url("css/mguru.css"); ?>" rel="stylesheet">

        <script src="<?php echo base_url("js/jquery-1.10.2.js"); ?>"></script>
        <script src="<?php echo base_url("js/jquery-ui.js"); ?>"></script>
        <script src="<?php echo base_url("js/jquery.easing.min.js"); ?>"></script>

        <!-- start Mixpanel -->
        <script type="text/javascript">
            (function(e,b){if(!b.__SV){var a,f,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable time_event track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.union people.track_charge people.clear_charges people.delete_user".split(" ");
            for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=e.createElement("script");a.type="text/javascript";a.async=!0;a.src="undefined"!==typeof MIXPANEL_CUSTOM_LIB_URL?MIXPANEL_CUSTOM_LIB_URL:"file:"===e.location.protocol&&"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js".match(/^\/\//)?"https://cdn.mxpnl.com/libs/mixpanel-2-latest.min.js":"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";f=e.getElementsByTagName("script")[0];f.parentNode.insertBefore(a,f)}})(document,window.mixpanel||[]);
            mixpanel.init("9b687ab2ae386dacd57190c25b272a37");
        </script>
        <!-- end Mixpanel -->

    </head>
    <body>
        <img src='<?php echo base_url("images/shareimage.png"); ?>' style='display:none;' />
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo site_url("worksheet"); ?>"><img src="<?php echo base_url("images/logo.png"); ?>" width='40' style='display: inline; margin-top: -9px;' /> mGuru</a>
                </div>

                <div id="navbar" class="navbar-collapse collapse">
                    <?php
                        if(isset($user->id)) {
                    ?>
                    <form class="navbar-form navbar-right" action='#' method='post'>
                        <div class="form-group">
                            <em style='color: #ffffff; font-size: 15px;'>Hi <?php echo $user->name(); ?>&nbsp;&nbsp;</em>
                        </div>

                        <button type="button" onclick='window.location.href="<?php echo site_url("worksheet/listview"); ?>";' class="btn btn-info">My worksheet(s)</button>
                        <button type="button" onclick='window.location.href="<?php echo site_url("worksheet/create"); ?>";' class="btn btn-info">Create worksheet</button>
                        <button type="button" onclick='window.location.href="<?php echo site_url("worksheet/refer"); ?>";' class="btn btn-info">Refer & earn</button>
                        <button type="button" onclick='window.location.href="<?php echo site_url("worksheet/logout"); ?>";' class="btn btn-danger">Sign out</button>
                    </form>
                    <?php
                        } else {
                    ?>
                    <form class="navbar-form navbar-right" action='<?php echo site_url("worksheet/loginprocess"); ?>' method='post'>
                        <div class="form-group">
                            <input type="text" name='log_email' id='log_email' required placeholder="Email" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="password" name='log_password' id='log_password' required  placeholder="Password" class="form-control" />
                        </div>
                        <button type="submit" class="btn btn-success">Sign in</button> &nbsp;&nbsp;
                        <a href="<?php echo site_url("worksheet/forgotpassword"); ?>" >Forgot password?</a>
                    </form>
                    <?php
                        }
                    ?>
                </div><!--/.navbar-collapse -->
            </div>
        </nav>
