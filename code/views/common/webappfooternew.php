<?php
    $webApp = new Webapp();
    $languages = $webApp->getLanguages();
    $defaultlanguages = $webApp->getdefaultLanguage();
 ?>
    <!-- <div class='footer footer_color_1 ' <?php if($static_footer == 1) echo " style='bottom: 0px;' "; ?> >
        <div class='row '>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <div class="social-account">
                    <a href='https://www.facebook.com/mguruapps/' target='_blank'>
                        <img src='<?php echo base_url("webapp_asset/images/fb_1.svg"); ?>' height='21' width='21' />
                    </a>
                     <a href='https://www.youtube.com/mguruapps/' target='_blank'>
                        <img src='<?php echo base_url("webapp_asset/images/yt_1.svg"); ?>' height='21' width='21' />
                    </a>
                    <a href='https://www.viemo.com/mguruapps/' target='_blank'>
                        <img src='<?php echo base_url("webapp_asset/images/vim_1.svg"); ?>' height='21' width='21' />
                    </a>
                </div>
          	</div>

      	    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
      		    <div class="copyright">&copy; <?php echo date("Y"); ?> mGuru PVT. LTD. ALL RIGHTS RESERVED.</div>
          	</div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
      		    <div class="footer-links">
                    <a href='<?php echo site_url("about-us"); ?>' >About Us</a>
                    <a href='<?php echo site_url("faq"); ?>' >FAQ</a>
                    <a href='<?php echo site_url("contact-us"); ?>' >Contact Us</a>
                </div>
          	</div>
      	</div>
    </div>
    -->
    <div class="mg-modal mg-modal-bold modal fade" role="dialog" id="mgEarnFreeMangoModal" tabindex="-1" aria-labelledby="mgEarnFreeMangoModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background:#ffffff;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="<?php echo base_url("webapp_asset/images/popup_close_1.svg"); ?>" alt="mGuru Pop-up close">
                    </button>
                </div>
                <div class="modal-body text-center">
                    <h1 class="mg-modal-title">
                        Earn free mangoes
                    </h1>
                    <p class="mg-modal-desc">
                        Share mGuru and get mangoes!
                    </p>
                    <p class="mg-modal-desc mg-modal-short-desc">
                        400 mangoes for each friend that sings up with<br>your link or your code.
                    </p>
                    <div class="row mg-refer-media">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="mg-refer-media-item mg-media-fb">
                                <a href="#">
                                    <img src="<?php echo base_url("webapp_asset/images/share_fb_1.svg"); ?>" alt="mGuru Refer via FaceBook">
                                </a>
                            </div>
                            <div class="mg-refer-media-item mg-media-whatsapp">
                                <a href="#">
                                    <img src="<?php echo base_url("webapp_asset/images/share_wa_1.svg"); ?>" alt="mGuru Refer via WhatsApp">
                                </a>
                            </div>
                            <div class="mg-refer-media-item mg-media-sms">
                                <a href="#">
                                    <img src="<?php echo base_url("webapp_asset/images/share_sms_1.svg"); ?>" alt="mGuru Refer via SMS">
                                </a>
                            </div>
                            <div class="mg-refer-media-item mg-media-mail">
                                <a href="#">
                                    <img src="<?php echo base_url("webapp_asset/images/share_mail_1.svg"); ?>" alt="mGuru Refer via Mail">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mg-motu-earn-mangoes">
                        <img src="<?php echo base_url("webapp_asset/images/motu_9_without_shadow_1.svg"); ?>" alt="mGuru Motu" class="mg-motu">
                        <img src="<?php echo base_url("webapp_asset/images/motu_shadhow_1.svg"); ?>" alt="mGuru Motu" class="mg-motu-shadow">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mg-modal modal fade" role="dialog" id="mgLearnEngModal" tabindex="-1" aria-labelledby="mgLearnEngModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content" style="background:#ffffff;height:auto;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="<?php echo base_url("webapp_asset/images/popup_close_1.svg"); ?>" alt="mGuru Pop-up close">
                    </button>
                </div>

                <div class="modal-body text-center">
                    <div class='language_selection_div' style='width: 600px !important;'>
                        <ul class="list-group">
                            <?php
                                $default = 'english';
                                if($defaultlanguages != '') {
                                    $default = $defaultlanguages;
                                }
                                foreach($languages as $lang => $text) {
                                    if($default == $lang) {
                                        echo '<button type="button" class="list-group-item list-group-item-action lang_'.$lang.' active" onclick="select_language1(\''.$lang.'\');">'.$text.'</button>';
                                    } else {
                                        echo '<button type="button" class="list-group-item list-group-item-action lang_'.$lang.' " onclick="select_language1(\''.$lang.'\');">'.$text.'</button>';
                                    }
                                }
                            ?>
                        </ul>

                    </div>
                    <br style='clear:both; '/>
                </div>
            </div>
        </div>
    </div>

    <div class="mg-modal mg-modal-bold modal fade" role="dialog" id="mgAreYouSureModal" tabindex="-1" aria-labelledby="mgAreYouSureModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="<?php echo base_url("webapp_asset/images/popup_close_1.svg"); ?>" alt="mGuru Pop-up close">
                    </button>
                </div>
                <div class="modal-body text-center">
                    <h1 class="mg-modal-title">
                        Are you sure
                    </h1>
                    <p class="mg-modal-desc">
                        you want to sign out?
                    </p>
                    <div class="mg-motu-lock-wrapper">
                        <img src="<?php echo base_url("webapp_asset/images/motu_6_without_shadow_1.svg"); ?>" alt="mGuru Motu" class="mg-motu">
                        <img src="<?php echo base_url("webapp_asset/images/motu_shadhow_1.svg"); ?>" alt="mGuru Motu" class="mg-motu-shadow">
                    </div>
                    <a href="<?php echo site_url("logout"); ?>" class="mg-unlock-btn">Yes.. Sign out</a>
                    <a href="javascript:void(0);" data-dismiss="modal" class="mg-btn-back">Cancel</a>
                </div>
            </div>
        </div>
    </div>
	<!-- END: box-wrap -->

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
    <!-- jQuery ui progress -->
    <script src="<?php echo base_url("webapp_asset/js/jquery-ui.min.js"); ?>"></script>
    
	<!-- Main JS (Do not remove) -->
	<script src="<?php echo base_url("webapp_asset/js/main.js"); ?>"></script>
	<script src="<?php echo base_url("webapp_asset/js/recorderWorker.js"); ?>"></script>
	<script src="<?php echo base_url("webapp_asset/js/recorder.js"); ?>"></script>
	<script src="<?php echo base_url("webapp_asset/js/recordLive.js"); ?>"></script>
    <script src='<?php echo base_url("pwacompat.min.js"); ?>' async></script>

    <script>
        function select_language1(langg) {
            _lang_selected = langg;
            $(".list-group-item").removeClass("active");
            $(".lang_" + langg).addClass("active");

            $.post("<?php echo site_url("changelanguage"); ?>/" + _lang_selected,{language: _lang_selected},function( data ) {
                window.location.reload();
            });
        }


    </script>

    <script>
//if('serviceWorker' in navigator) {
//  navigator.serviceWorker
//           .register('/sw.js')
//           .then(function() { console.log("Service Worker Registered"); });
//}
</script>

	</body>
</html>
