$(function() {
    'use strict';

    // iPad and iPod detection
    var isiPad = function() {
        return (navigator.platform.indexOf("iPad") != -1);
    };

    var isiPhone = function() {
        return (
            (navigator.platform.indexOf("iPhone") != -1) ||
            (navigator.platform.indexOf("iPod") != -1)
        );
    };

    // Parallax
    var parallax = function() {
        $(window).stellar();
    };

    // Burger Menu
    var burgerMenu = function() {

        $('body').on('click', '.js-fh5co-nav-toggle', function(event) {

            event.preventDefault();

            if ($('#navbar').is(':visible')) {
                $(this).removeClass('active');
            } else {
                $(this).addClass('active');
            }

        });

    };

    var goToTop = function() {

        $('.js-gotop').on('click', function(event) {

            event.preventDefault();

            $('html, body').animate({
                scrollTop: $('html').offset().top
            }, 500);

            return false;
        });

    };


    // Page Nav
    var clickMenu = function() {

        $('#navbar a:not([class="external"])').click(function(event) {
            var section = $(this).data('nav-section'),
                navbar = $('#navbar');

            if ($('[data-section="' + section + '"]').length) {
                $('html, body').animate({
                    scrollTop: $('[data-section="' + section + '"]').offset().top
                }, 500);
            }

            if (navbar.is(':visible')) {
                navbar.removeClass('in');
                navbar.attr('aria-expanded', 'false');
                $('.js-fh5co-nav-toggle').removeClass('active');
            }

            event.preventDefault();
            return false;
        });

    };

    // Reflect scrolling in navigation
    var navActive = function(section) {

        var $el = $('#navbar > ul');
        $el.find('li').removeClass('active');
        $el.each(function() {
            $(this).find('a[data-nav-section="' + section + '"]').closest('li').addClass('active');
        });

    };

    var navigationSection = function() {

        var $section = $('section[data-section]');

        $section.waypoint(function(direction) {

            if (direction === 'down') {
                navActive($(this.element).data('section'));
            }
        }, {
            offset: '150px'
        });

        $section.waypoint(function(direction) {
            if (direction === 'up') {
                navActive($(this.element).data('section'));
            }
        }, {
            offset: function() {
                return -$(this.element).height() + 155;
            }
        });

    };

    // Window Scroll
    var windowScroll = function() {
        var lastScrollTop = 0;

        $(window).scroll(function(event) {

            var header = $('#fh5co-header'),
                scrlTop = $(this).scrollTop();

            if (scrlTop > 500 && scrlTop <= 2000) {
                header.addClass('navbar-fixed-top fh5co-animated slideInDown');
            } else if (scrlTop <= 500) {
                if (header.hasClass('navbar-fixed-top')) {
                    header.addClass('navbar-fixed-top fh5co-animated slideOutUp');
                    setTimeout(function() {
                        header.removeClass('navbar-fixed-top fh5co-animated slideInDown slideOutUp');
                    }, 100);
                }
            }

        });
    };

    // Animations

    var contentWayPoint = function() {
        var i = 0;
        $('.animate-box').waypoint(function(direction) {

            if (direction === 'down' && !$(this.element).hasClass('animated')) {

                i++;

                $(this.element).addClass('item-animate');
                setTimeout(function() {

                    $('body .animate-box.item-animate').each(function(k) {
                        var el = $(this);
                        setTimeout(function() {
                            el.addClass('fadeInUp animated');
                            el.removeClass('item-animate');
                        }, k * 200, 'easeInOutExpo');
                    });

                }, 100);

            }

        }, {
            offset: '85%'
        });
    };

    // Document on load.
    $(function() {

        // parallax();

        // burgerMenu();

        // clickMenu();

        // windowScroll();

        // navigationSection();

        // goToTop();

        // Animations
        contentWayPoint();

    });

    // Add footer class for explore page
    if(window.location.pathname.indexOf("explore") != -1)
        $('body .footer').addClass('mg-explore-footer');
    if(window.location.pathname.indexOf("language") != -1)
        $('body').removeClass('logged-in');

	// Changing menu active class based on the current page
    var current = location.pathname.split('/')[1];
    $('ul.mg-navbar-nav li').removeClass('active');
    $('.mg-navbar-nav > li > a').each(function() {
        var $this = $(this);
        if($this.attr('href').indexOf(current) !== -1) {
            $this.parents('.mg-navbar-item').addClass('active');
        }
    });

    // Open dropdown menu on hover
    $(".mg-navbar-item").hover(function() {
        var dropdownMenu = $(this).children(".mg-dropdown-menu");
        if(dropdownMenu.is(":visible") && $(this).find('a.dropdown-toggle').attr('href').indexOf(current) == -1) {
            dropdownMenu.parent().toggleClass("open active");
        }
    });
    $(".mg-navbar-item > a").mouseenter(function() {
        var $self = $(this);
        if(!$self.parent().hasClass('active') && !$self.parent().hasClass('dropdown'))
            $self.parent().addClass('active hovered');
    });
    $(".mg-navbar-item > a").mouseleave(function() {
        var $self = $(this);
        if($self.parent().hasClass('hovered'))
            $self.parent().removeClass('hovered active');
    })
    $('[data-toggle="tooltip"]').tooltip();
    // stop carousel auto slide
    $('.carousel').carousel({
        interval: false
    });

    $(".mg-wordy-birdy-wrapper .mg-sub-nav > ul > li").on('click', function() {
        var $self = $(this);
        $(".mg-wordy-birdy-wrapper .mg-sub-nav > ul > li").removeClass("active");
        $self.addClass("active");
    });

    // Stories search button on click
    $('body').on('click', '.mg-search', function() {
        $('.mg-level-search-wrapper').slideUp();
        $('.mg-search-box-wrapper').removeClass('hide');
    });
    $('body').on('click', '.mg-search-hide', function() {
        $('.mg-search-box-wrapper').addClass('hide');
        $('.mg-level-search-wrapper').slideDown();
    });

    // esplore page
    if($('.mg-explore-worlds').length > 0) {
        if($('.mg-explore-worlds').find('.mg-locked').length == 5)
            $('.mg-explore-worlds').addClass('mg-all-locked');
        else
            $('.mg-explore-worlds').removeClass('mg-all-locked');
    }
    $('body').on('click', '.mg-daily-activity-wrapper .mg-submit', function() {
        if($(this).hasClass('mg-btn-disabled'))
            return false;
        window.callnextquestion();
        return false;
    })
    $('body').on('click', '.mg-daily-activity-wrapper .mg-next', function() {
        window.callnextquestiondirect();
        return false;
    })
    $('body').on('click', '.mg-missing-letter .mg-options-wrapper .mg-void', function() {
        var $self = $(this);
        var text = $self.find('span').text();
        if($('.mg-activity-word-wrapper .mg-void span').html() == "&nbsp;" && $self.find('span').html() != "&nbsp;") {
            $self.addClass('mg-empty');
            $self.find('span').html("&nbsp;");
            $('.mg-missing-letter .mg-activity-word-wrapper .mg-void').addClass('mg-filled');
            $('.mg-missing-letter .mg-activity-word-wrapper .mg-void span').html(text);
            $('.mg-submit').removeClass('mg-btn-disabled');
        } else {
            var $self1 = $(".mg-missing-letter .mg-activity-word-wrapper .mg-filled");
            var text1 = $self1.find('span').text();
            $self1.find('span').html("&nbsp;");
            $self1.removeClass('mg-filled');
            $('.mg-missing-letter .mg-options-wrapper .mg-empty span').html(text1);
            $('.mg-missing-letter .mg-options-wrapper .mg-empty').removeClass('mg-empty');

            $self.addClass('mg-empty');
            $self.find('span').html("&nbsp;");
            $('.mg-missing-letter .mg-activity-word-wrapper .mg-void').addClass('mg-filled');
            $('.mg-missing-letter .mg-activity-word-wrapper .mg-void span').html(text);
            $('.mg-submit').removeClass('mg-btn-disabled');
        }

        if($(this).data('value') != 'undefined'){
            $("#user_answer").val($(this).data('value'));
        }

        return false;
    });


    $('body').on('click', '.mg-missing-letter .mg-activity-word-wrapper .mg-filled', function() {
        var $self = $(this);
        var text = $self.find('span').text();
        $self.find('span').html("&nbsp;");
        $self.removeClass('mg-filled');
        $('.mg-missing-letter .mg-options-wrapper .mg-empty span').html(text);
        $('.mg-missing-letter .mg-options-wrapper .mg-empty').removeClass('mg-empty');
        $('.mg-submit').addClass('mg-btn-disabled');
        $("#user_answer").val('');
    });
    $('body').on('click', '.mg-missing-word:visible .mg-options-wrapper .mg-void', function() {
        if($(this).hasClass("mg-options-wrapper1")) {
            var $self = $(this);
            if($self.hasClass("mg-selected")) {
                $self.removeClass('mg-selected');
            } else {
                //$('.mg-missing-word:visible .mg-options-wrapper .mg-void').removeClass('mg-selected');

                var text = $self.find('span').text();
                $('.mg-missing-word:visible .mg-query-text .mg-void').text(text);
                $self.addClass('mg-selected');
            }

            var answers = new Array();
            $( ".mg-missing-word:visible .mg-options-wrapper .mg-void" ).each(function( index ) {
                if($(this).hasClass("mg-selected")) {
                    answers.push($(this).data('value'));
                }
            });

            if( answers.length > 0 ) {
                $('.mg-submit').removeClass('mg-btn-disabled');
                $("#user_answer").val(answers.join(","));
            } else {
                $('.mg-submit').addClass('mg-btn-disabled');
                $("#user_answer").val('');
            }

        } else {
            $('.mg-missing-word:visible .mg-options-wrapper .mg-void').removeClass('mg-selected');
            var $self = $(this);
            var text = $self.find('span').text();
            $('.mg-missing-word:visible .mg-query-text .mg-void').text(text);
            $self.addClass('mg-selected');
            $('.mg-submit').removeClass('mg-btn-disabled');
            if($(this).data('value') != 'undefined'){
                $("#user_answer").val($(this).data('value'));
            }
        }
    });
    $('.mg-missing-word:visible .mg-query-text .mg-void').on('DOMSubtreeModified',function(){
        var text = $.trim($(this).text());
        if(text.length > 0) {
            $('.mg-missing-word:visible .mg-options-wrapper .mg-void').each(function() {
                var $self = $(this);
                var selfText = $.trim($self.find('span').text());
                if(text.toLowerCase() == selfText.toLowerCase()) {
                    $self.addClass('mg-selected');
                } else {
                    $self.removeClass('mg-selected');
                }
            });
            $('.mg-submit').removeClass('mg-btn-disabled');
        } else {
            $('.mg-submit').addClass('mg-btn-disabled');
            $('.mg-missing-word:visible .mg-options-wrapper .mg-void').removeClass('mg-selected');
        }
    });
    $('body').on('click', '.mg-correct-image .mg-options-wrapper .mg-void', function() {
        $('.mg-correct-image .mg-options-wrapper .mg-void').removeClass('mg-selected');
        var $self = $(this);
        $self.addClass('mg-selected');
        $('.mg-submit').removeClass('mg-btn-disabled');
        if($(this).data('value') != 'undefined'){
            $("#user_answer").val($(this).data('value'));
        }
    });
    $('body').on('click', '.mg-word-starts-with .mg-options-wrapper .mg-void', function() {
        $('.mg-word-starts-with .mg-options-wrapper .mg-void').removeClass('mg-selected');
        var $self = $(this);
        $self.addClass('mg-selected');
        $('.mg-submit').removeClass('mg-btn-disabled');

        if($(this).data('value') != 'undefined'){
            $("#user_answer").val($(this).data('value'));
        }
        if($(this).data('word') != 'undefined'){
            _speaktext($(this).data('word'));
        }

    });
    $('body').on('click', '.mg-correct-word:visible .mg-options-wrapper .mg-void', function() {
        $('.mg-correct-word:visible .mg-options-wrapper .mg-void').removeClass('mg-selected');
        var $self = $(this);
        $self.addClass('mg-selected');
        $('.mg-submit').removeClass('mg-btn-disabled');
    });
    $('body').on('click', '.mg-letter-sound .mg-activity-sound-wrapper .mg-void', function() {
        var $self = $(this);
        if($self.hasClass('mg-listening'))
            return false;
        $self.toggleClass('mg-listening');
        $self.find('.mg-listen').toggleClass('hide');
        $self.find('.mg-pause').toggleClass('hide');


        var progressBarOptions = {
            size: 300,
            value: 1.00,
            startAngle: -1.55,
            animation : {
                duration: 1000,
                easing: "circleProgressEasing"
            },
            fill: {
                color: '#ffce00'
            }
        }
        $('.mg-activity-sound-wrapper .mg-void').circleProgress(progressBarOptions).on('circle-animation-progress', function(event, progress, stepValue) {});
        setTimeout(function() {
            $self.toggleClass('mg-listening');
            $self.find('.mg-listen').toggleClass('hide');
            $self.find('.mg-pause').toggleClass('hide');
        }, 1100);

        if(document.getElementById("grapheme_sound")) {
            var audioPlayer_1 = document.getElementById("grapheme_sound");
            audioPlayer_1.play();
        }

        if(document.getElementById("audio_tts_ans")) {
            _speaktext($("#audio_tts_ans").val());
        }


    });
    $('body').on('click', '.mg-letter-sound .mg-options-wrapper .mg-void', function() {
        $('.mg-letter-sound .mg-options-wrapper .mg-void').removeClass('mg-selected');
        var $self = $(this);
        $self.addClass('mg-selected');
        $('.mg-submit').removeClass('mg-btn-disabled');

        if($(this).data('value') != 'undefined'){
            $("#user_answer").val($(this).data('value'));
        }
    });

    // Reset steps for say event on click try again button
    //if($('.mg-say:visible').length > 0) {
        $('body').on('click', '.mg-reply', function() {
            reset_say_activity();
            if(document.getElementById('recordingslist')) {
                document.getElementById('recordingslist').innerHTML = '';
            }
            return false;
        });
    //}
    $('body').on('click', '.mg-say .mg-activity-sound-wrapper .mg-void', function() {
        var $self = $(this);
        var step = parseInt($self.find('.mg-say-img:visible').data('step'));
        process_say_activity($self, step);
    });

    var _current_step = 0;
    var process_say_activity = function($self, step) {

        var step = step;

        if($self.hasClass('mg-listening'))
            return false;
        _current_step = step;
        if(step == 1 || step == 3 || step == 5)
            $self.toggleClass('mg-listening');

		var timee = 1000;
		if(step == 1) {
			$self.find(".mg-say-img[data-step=1]").addClass('hide');
			$self.find(".mg-say-img[data-step=2]").removeClass('hide');
			$(".mg-listen-word").css("display","none");
			timee = 1000;
		} else if(step == 2) {
			$self.find(".mg-say-img[data-step=2]").addClass('hide');
			$self.find(".mg-say-img[data-step=3]").removeClass('hide');
			timee = 1000;
		} else if(step == 3) {
			$self.find(".mg-say-img[data-step=3]").addClass('hide');
			$self.find(".mg-say-img[data-step=5]").addClass('hide');
			$self.find(".mg-say-img[data-step=4]").removeClass('hide');
			timee = 5000;
		} else if(step == 4) {
			$self.find(".mg-say-img[data-step=3]").addClass('hide');
			$self.find(".mg-say-img[data-step=4]").addClass('hide');
			$self.find(".mg-say-img[data-step=5]").removeClass('hide');
			timee = 5000;
		} else if(step == 5) {
            $self.find(".mg-say-img[data-step=3]").addClass('hide');
			$self.find(".mg-say-img[data-step=4]").addClass('hide');
   			$self.find(".mg-say-img[data-step=5]").removeClass('hide');
			timee = 5000;
		}

        if(document.getElementById("phrase_sentence")) {
            timee = 5000;
        }

        var progressBarOptions = {
            size: 300,
            value: 1.00,
            startAngle: -1.55,
            animation : {
                duration: timee,
                easing: "circleProgressEasing"
            },
            fill: {
                color: '#ffce00'
            }
        };

        if(step == 1) {
            $('.mg-activity-sound-wrapper .mg-void').circleProgress(progressBarOptions).on('circle-animation-progress', function(event, progress, stepValue) {});

            if(document.getElementById("defaultaudio")) {
				var audioPlayer_2 = document.getElementById("defaultaudio");
                audioPlayer_2.play();
            }

			if(document.getElementById("phrase_sentence")) {
				_speaktext($("#phrase_sentence").val());
			}

            setTimeout(function() {
				if(_current_step == 1) {
					$self.toggleClass('mg-listening');
					$self.parent().next('.mg-options-wrapper').find('.mg-motu-listen').addClass('hide');
                    $self.parent().next('.mg-options-wrapper').find('.mg-motu-record').removeClass('hide');
                    if(document.getElementById("defaultaudio_word")) {
                        _speaktext($("#defaultaudio_word").val());
                    }
                    $self.find(".mg-say-img[data-step=2]").addClass('hide');
					$self.find(".mg-say-img[data-step=3]").removeClass('hide');
				}
            }, timee);
        } else if(step == 2) {
			$self.toggleClass('mg-listening');
			$self.parent().next('.mg-options-wrapper').find('.mg-motu-listen').addClass('hide');
            $self.parent().next('.mg-options-wrapper').find('.mg-motu-record').removeClass('hide');
            $self.find(".mg-say-img[data-step=2]").addClass('hide');
			$self.find(".mg-say-img[data-step=3]").removeClass('hide');
        } else if(step == 3 || step == 5) {
            $('.mg-activity-sound-wrapper .mg-void').circleProgress(progressBarOptions).on('circle-animation-progress', function(event, progress, stepValue) {});

            /*if(document.getElementById("phrase_sentence")) {
				_speaktext($("#phrase_sentence").val());
            }*/

            if(document.getElementById('recorded_audio_id')) {
				playrecodring();
                $self.parent().next('.mg-options-wrapper').find('.mg-motu-listen').removeClass('hide');
			} else {
				startRecording();
                $self.parent().next('.mg-options-wrapper').find('.mg-motu-record').removeClass('hide');
			}

            setTimeout(function() {
				if(_current_step == 3 || _current_step == 5) {
					$self.toggleClass('mg-listening');
					$self.find(".mg-say-img[data-step=3]").addClass('hide');
					$self.find(".mg-say-img[data-step=4]").addClass('hide');
					$self.find(".mg-say-img[data-step=5]").removeClass('hide');
					$self.addClass("mg-completed");
                    $self.parent().next('.mg-options-wrapper').find('.mg-motu-listen').addClass('hide');
                    $self.parent().next('.mg-options-wrapper').find('.mg-motu-record').addClass('hide');
                    $self.parent().next('.mg-options-wrapper').find('.mg-motu-listen').removeClass('hide');
					//$self.parent().next('.mg-options-wrapper').find('.mg-motu-listen, .mg-motu-record').removeClass('hide').addClass('invisible');
					$('.mg-submit').removeClass('mg-btn-disabled');
					//$('.mg-say .mg-image-text-hint').find('.mg-text-disabled').addClass('mg-text-warning').removeClass('mg-text-disabled');
					//$(".mg-listen-word").css("display","block");

					if(document.getElementById('recorded_audio_id')) {
						stopplayrecodring();
					} else {
						stopRecording();
					}
				}
            }, timee);
        } else if(step == 4) {
			$self.toggleClass('mg-listening');
			$self.find(".mg-say-img[data-step=3]").addClass('hide');
			$self.find(".mg-say-img[data-step=4]").addClass('hide');
			$self.find(".mg-say-img[data-step=5]").removeClass('hide');
			$self.addClass("mg-completed");
			//$self.parent().next('.mg-options-wrapper').find('.mg-motu-listen, .mg-motu-record').removeClass('hide').addClass('invisible');
            $self.parent().next('.mg-options-wrapper').find('.mg-motu-listen').addClass('hide');
            $self.parent().next('.mg-options-wrapper').find('.mg-motu-record').addClass('hide');
            $self.parent().next('.mg-options-wrapper').find('.mg-motu-listen').removeClass('hide');
			$('.mg-submit').removeClass('mg-btn-disabled');
			//$('.mg-say .mg-image-text-hint').find('.mg-text-disabled').addClass('mg-text-warning').removeClass('mg-text-disabled');
			//$(".mg-listen-word").css("display","block");
			if(document.getElementById('recorded_audio_id')) {
				stopplayrecodring();
			} else {
				stopRecording();
			}
        }








        /*if(step == 1 || step == 3) {
            $('.mg-activity-sound-wrapper .mg-void').circleProgress(progressBarOptions).on('circle-animation-progress', function(event, progress, stepValue) {});
            //if(step == 1) {
                var timee = 1000;
                if(document.getElementById("defaultaudio")) {
                    var audioPlayer_3 = document.getElementById("defaultaudio");
                    audioPlayer_3.play();
                    $(".mg-listen-word").css("display","none");
                    timee = 1000;
                }

                if(document.getElementById("phrase_sentence")) {
                    _speaktext($("#phrase_sentence").val());
                    timee = 5000;
                }
            //}
            setTimeout(function() {
                $self.toggleClass('mg-listening');
                $self.find(".mg-say-img[data-step="+(++step)+"]").addClass('hide');
                if(step == 4) {
                    step = 0;
                    $self.addClass("mg-completed");
                    $self.parent().next('.mg-options-wrapper').find('.mg-motu-listen, .mg-motu-record').removeClass('hide').addClass('invisible');
                    $('.mg-submit').removeClass('mg-btn-disabled');
                    $('.mg-say .mg-image-text-hint').find('.mg-text-disabled').addClass('mg-text-warning').removeClass('mg-text-disabled');
                    $(".mg-listen-word").css("display","block");
                } else {
                    $self.parent().next('.mg-options-wrapper').find('.mg-motu-listen').addClass('hide');
                    $self.parent().next('.mg-options-wrapper').find('.mg-motu-record').removeClass('hide');
                    if(document.getElementById("defaultaudio_word")) {
                        _speaktext($("#defaultaudio_word").val());
                    }
                }
                $self.find(".mg-say-img[data-step="+(step+1)+"]").removeClass('hide');
            }, timee);
        } */
        return false;
    };

    var reset_say_activity = function() {
        $('.mg-say .mg-activity-sound-wrapper .mg-void .mg-say-img').addClass('hide');
        $('.mg-say .mg-activity-sound-wrapper .mg-void').find(".mg-say-img[data-step=1]").removeClass('hide');
        $('.mg-say .mg-activity-sound-wrapper .mg-void').removeClass('mg-listening mg-completed');
        if($('.mg-say .mg-image-text-hint .mg-text-warning').length > 0) {
            $('.mg-say .mg-image-text-hint .mg-text-warning').addClass('mg-text-disabled').removeClass('mg-text-warning');
        }
        $('.mg-say .mg-options-wrapper').find('.mg-motu-listen, .mg-motu-record').addClass('hide').removeClass('invisible');
        $('.mg-say .mg-options-wrapper').find('.mg-motu-listen').removeClass('hide');
        $('.mg-submit').addClass('mg-btn-disabled');
        $(".mg-listen-word").css("display","block");
        if(document.getElementById('recorded_audio_id')) {
			$("#recordingslist").html("");
		}
        return false;
    };

    var counter = 0;
    $('body').on('click', '.mg-arrange-phrase .mg-options-wrapper .mg-void', function() {
        var $self = $(this);
        var text = $self.find('span').text();
        var queryTextEle = $('.mg-arrange-phrase .mg-query-text .mg-void');
        var activeEleLength = $('.mg-arrange-phrase .mg-options-wrapper .mg-void.mg-selected').length;
        if(activeEleLength == 0) {
            counter = 0;
        }
        if($self.hasClass('mg-selected') && counter > 0) {
            var unSelectedCounterVal = parseInt($self.find('.mg-counter').text());
            $('.mg-arrange-phrase .mg-options-wrapper .mg-void.mg-selected').each(function() {
                var curVal = parseInt($(this).find('.mg-counter').text());
                if(curVal > unSelectedCounterVal) {
                    --curVal;
                    var updatedVal = (counter < 10) ? 0+""+curVal : curVal;
                    $(this).find('.mg-counter').text(updatedVal);
                }
            });
            --counter;
            queryTextEle.text((queryTextEle.text()).replace(text + " " , ""));
            $self.removeClass('mg-selected');
            $self.find('.mg-counter').text("");
        } else {
            if(activeEleLength < counter) {
                return false;
            }
            ++counter;
            var sanitizedCounter = (counter < 10) ? 0+""+counter : counter;
            $self.find('.mg-counter').text(sanitizedCounter);
            queryTextEle.append(text + " " );
            $self.addClass('mg-selected');
        }

        var ans_txt = queryTextEle.text();
        ans_txt = ans_txt.replace(/ /gi,"");
        ans_txt = ans_txt.replace(/\u00a0/g, "");
        $("#user_answer").val(ans_txt);

        if(ans_txt == "") {
            $('.mg-submit').addClass('mg-btn-disabled');
        } else {
            $('.mg-submit').removeClass('mg-btn-disabled');
        }

    });
    // Draggable
    if($(".mg-drag-target").length > 0) {
        $(".mg-drag-target").draggable({
            revert: 'invalid'
        });
    }

    // Droppable
    if($(".mg-drop-target").length > 0) {
        $(".mg-drop-target").droppable({
            accept: '.mg-drag-target',
            drop: function(event, ui) {
                $(this).removeClass("mg-text-disabled").html("");
                $(ui.draggable).detach().removeClass("mg-image-text-hint").appendTo(this);
                $('.mg-submit').removeClass('mg-btn-disabled');
            }
        });
    }



    setTimeout(function() {
        if($('.mg-activity-main-bg:visible').length > 0) {
            $('body').css({
                "height" : $('.mg-activity-main-bg:visible').outerHeight(),
                "background" : "#ffffff"
            });
        }
    }, 1500);

    if($('.mg-h1-header:visible').find('.mg-icon-hint').length > 0) {
        $('.mg-h1-header:visible').css("padding-right", "25px");
    }

}());

var _msg = new SpeechSynthesisUtterance();
    var _voices = window.speechSynthesis.getVoices();
    for(var qw = 0 ; qw < _voices.length ; qw++ ) {
        if(_voices[qw].lang == "hi-IN") {
             _msg.voice = _voices[qw];
        }
    }

        _msg.voiceURI = "native";
        _msg.volume = 1;
        _msg.rate = 0.8;
        _msg.pitch = 1;
        _msg.lang = 'hi-IN';
function _speaktext(text) {
        //var msg = new SpeechSynthesisUtterance(text);
        //window.speechSynthesis.speak(msg);
        /*var msg = new SpeechSynthesisUtterance();
        var voices = window.speechSynthesis.getVoices();
        msg.voice = voices[10];
        msg.voiceURI = "native";
        msg.volume = 1;
        msg.rate = 0.8;
        msg.pitch = 1;
        msg.lang = 'hi-IN';  */
        _msg.text = text;
        speechSynthesis.speak(_msg);
        return false;
    }

function playfirstlastsound(textt) {
    _speaktext(textt);

    setTimeout(function() {
        playfirstlastsound1();
    }, 2500);
}

function playfirstlastsound1() {
    var audioPlayer_5 = document.getElementById("defaultaudio");
    audioPlayer_5.play();
}

var _audio_vb = new Array();
var _mg_drop_wrapper = '';
var _mg_drag_wrapper = '';

function reset_drag_drop() {
     $(".mg-drop-wrapper").html(_mg_drop_wrapper);
     $(".mg-drag-wrapper").html(_mg_drag_wrapper);
     $('.mg-submit').addClass('mg-btn-disabled');
     start_drag_drop();

     return false;
}

function start_drag_drop() {
    _mg_drop_wrapper = $(".mg-drop-wrapper").html();
    _mg_drag_wrapper = $(".mg-drag-wrapper").html();

    _audio_vb = new Array();

     // Draggable
    /*if($(".mg-drag-target").length > 0) {
        $(".mg-drag-target").draggable({
            revert: 'invalid'
        });
    }

     if($(".mg-drop-target").length > 0) {
        $(".mg-drop-target").droppable({
            accept: '.mg-drag-target',
            drop: function(event, ui) {
                $(this).removeClass("mg-text-disabled").html("");
                $(ui.draggable).detach().removeClass("mg-image-text-hint").appendTo(this);
                $('.mg-submit').removeClass('mg-btn-disabled');
            }
        });
    } */

    var count = 1;

    if(document.getElementById('drag_count')) {
        count = $("#drag_count").val();
    }

    for(var ii = 1 ; ii <= count ; ii++) {
        if($(".mg-drag-target" + ii).length > 0) {
            $(".mg-drag-target" + ii).draggable({
                revert: 'invalid',
                start: function() {
                    var nnmm = $(this).data("num");
                    _audio_vb[nnmm] = 1;
                    play_vb_audio(nnmm);
                },
                drag: dragFix,
                stop: function() {
                    var nnmm = $(this).data("num");
                    _audio_vb[nnmm] = 0;
                }
            });
        }

        if($(".mg-drop-target" + ii).length > 0) {
            $(".mg-drop-target" + ii).droppable({
                accept: '.mg-drag-target' + ii,
                drop: function(event, ui) {
                    var nnmm = $(this).data("num");
                    var nnmm1 = nnmm + 1;
                    $(this).removeClass("mg-text-disabled").html("");
                    $(ui.draggable).detach().removeClass("mg-image-text-hint").appendTo(this);
                    //$('.mg-submit').removeClass('mg-btn-disabled');
                    $('.mg-drag-target' + nnmm1).removeClass('hidden');

                    var count_num = 1;

                    if(document.getElementById('drag_count')) {
                        count_num = $("#drag_count").val();
                    }

                    if( nnmm >= count_num) {
                        $('.mg-submit').removeClass('mg-btn-disabled');
                        setTimeout(function() {
                            playvowel()
                        }, 500);
                    }

                }
            });
        }

    }

}

function play_vb_audio(nnuumm) {
    if(_audio_vb[nnuumm] == 1) {
        var audioPlayer_63 = document.getElementById("vovel_sound" + nnuumm);
        audioPlayer_63.play();
        setTimeout(function() {
            play_vb_audio(nnuumm)
        }, 500);
    }
}

function playvowel() {

    if(document.getElementById("vovel_sound")) {
        var audioPlayer_6 = document.getElementById("vovel_sound");
        audioPlayer_6.play();
    } else {
        _speaktext($("#vowel_word").val());
    }
}


function playwordgamesound(text1,text2) {
    _speaktext(text1);

    setTimeout(function() {
        var audioPlayer_7 = document.getElementById("grapheme_sound");
        audioPlayer_7.play();
        setTimeout(function() {
            _speaktext(text2);
        }, 1300);
    }, 1500);
}

function checkanswerr() {
    if ($("#phrase_answer").html() != '') {
        $(".mg-submit").removeClass("mg-btn-disabled");
    } else {
        $(".mg-submit").addClass("mg-btn-disabled");
    }
    $("#user_answer").val($("#phrase_answer").html());
}


var leftCounter = 0;
    var rightCounter = 0;
    var leftPanelSelectedItems = 0;
    var rightPanelSelectedItems = 0;
    var totalRightPanelItems = $('.mg-match-pairs .mg-right-panel .mg-void').length;

    function matchthecolumninit() {
        leftCounter = 0;
        rightCounter = 0;
        leftPanelSelectedItems = 0;
        rightPanelSelectedItems = 0;
        totalRightPanelItems = $('.mg-match-pairs .mg-right-panel .mg-void').length;
    }

    $('body').on('click', '.mg-match-pairs .mg-options-wrapper .mg-void', function() {
        var $self = $(this);
        if($self.parent('.mg-options-wrapper').hasClass('mg-left-panel')) {
            if(leftPanelSelectedItems > rightPanelSelectedItems) {
                return false;
            } else {
                leftCounter = $self.find('.mg-counter').text();
                $self.addClass('mg-selected');
                if(totalRightPanelItems > leftPanelSelectedItems)
                    ++leftPanelSelectedItems;
            }
        }
        if($self.parent('.mg-options-wrapper').hasClass('mg-right-panel')) {
            if(leftPanelSelectedItems == 0) {
                return false;
            } else {
                if(rightCounter == leftCounter) {
                    $('.mg-match-pairs .mg-right-panel .mg-void').each(function() {
                        var $obj = $(this);
                        var lastCounter = $obj.find('.mg-counter');
                        if(rightCounter == lastCounter.text()) {
                            $obj.removeClass('mg-selected');
                            lastCounter.addClass('hide');
                            if(leftPanelSelectedItems == rightPanelSelectedItems)
                                --rightPanelSelectedItems;
                        }
                    });
                }
                if($self.hasClass('mg-selected')) {
                    $('.mg-match-pairs .mg-left-panel .mg-void').each(function() {
                        var $leftObj = $(this);
                        var leftSameCounter = $leftObj.find('.mg-counter');
                        if(leftSameCounter.text() == $self.find('.mg-counter').text()) {
                            $leftObj.removeClass('mg-selected');
                            --leftPanelSelectedItems;
                            if(leftPanelSelectedItems == rightPanelSelectedItems)
                                --rightPanelSelectedItems;
                        }
                    });
                }
                $self.addClass('mg-selected');
                $self.find('.mg-counter').removeClass('hide').text(leftCounter);
                rightCounter = leftCounter;
                ++rightPanelSelectedItems;
            }
        }

        if($('.mg-match-pairs .mg-right-panel .mg-void.mg-selected').length == $('.mg-match-pairs .mg-right-panel .mg-void').length &&
        $('.mg-match-pairs .mg-left-panel .mg-void.mg-selected').length == $('.mg-match-pairs .mg-left-panel .mg-void').length) {
            var uans = '';
            var uans_counter = 1;

            for(var ii = 0 ; ii < totalRightPanelItems ; ii++) {
                var mmm = 0;
                $('.mg-match-pairs .mg-right-panel .mg-void').each(function() {
                    if(mmm == 0) {
                        if( parseInt($(this).find('.mg-counter').text()) == uans_counter) {
                            mmm = parseInt($(this).data('value'));
                        }
                    }
                });

                uans += "" + uans_counter +""+ mmm;
                uans_counter++;
            }
            $("#user_answer").val(uans);
            $('.mg-submit').removeClass('mg-btn-disabled');
        } else {
            $('.mg-submit').addClass('mg-btn-disabled');
        }
    });



    $('body').on('click', '.mg-match-pairs-chat .mg-activity-sound-wrapper .mg-void', function() {
        var $self = $(this);
        var step = parseInt($self.find('.mg-say-img:visible').data('step'));
        process_say_activity1($self, step);
    });
    var process_say_activity1 = function($self, step) {
        var step = step;
        $self.toggleClass('mg-listening');

        $self.find(".mg-say-img[data-step="+step+"]").addClass('hide');
        $self.find(".mg-say-img[data-step="+(step+1)+"]").removeClass('hide');
        var progressBarOptions = {
            size: 150,
            value: 1.00,
            startAngle: -1.55,
            animation : {
                duration: 6000,
                easing: "circleProgressEasing"
            },
            fill: {
                color: '#ffce00'
            }
        };

        if(document.getElementById('recorded_audio_id')) {
            if(step == 1) {
                playrecodring();
                $('.mg-activity-sound-wrapper .mg-void').circleProgress(progressBarOptions).on('circle-animation-progress', function(event, progress, stepValue) {});
                setTimeout(function() {
                    $self.toggleClass('mg-listening');
                    $self.find(".mg-say-img[data-step="+(++step)+"]").addClass('hide');
                    if(step == 2) {
                        step = 0;
                        $self.addClass("mg-completed");
                        $('.mg-submit').removeClass('mg-btn-disabled');
                    }
                    $self.find(".mg-say-img[data-step="+(step+1)+"]").removeClass('hide');
                }, 6100);
            }
        } else {
            if(step == 1) {
                startRecording();
                $('.mg-activity-sound-wrapper .mg-void').circleProgress(progressBarOptions).on('circle-animation-progress', function(event, progress, stepValue) {});
                setTimeout(function() {
                    $self.toggleClass('mg-listening');
                    $self.find(".mg-say-img[data-step="+(++step)+"]").addClass('hide');
                    if(step == 2) {
                        step = 0;
                        $self.addClass("mg-completed");
                        $('.mg-submit').removeClass('mg-btn-disabled');
                    }
                    $self.find(".mg-say-img[data-step="+(step+1)+"]").removeClass('hide');
                    stopRecording();
                }, 6100);
            }
        }
    };

    var zoomScale = 0.8;
    function dragFix(event, ui) {
        var changeLeft = ui.position.left - ui.originalPosition.left; // find change in left
        var newLeft = ui.originalPosition.left + changeLeft / zoomScale; // adjust new left by our zoomScale

        var changeTop = ui.position.top - ui.originalPosition.top; // find change in top
        var newTop = ui.originalPosition.top + changeTop / zoomScale; // adjust new top by our zoomScale

        ui.position.left = newLeft;
        ui.position.top = newTop;
    }