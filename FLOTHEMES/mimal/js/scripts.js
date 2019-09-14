function setCookie(c_name,value,exdays){
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays===null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

function floGetCookie(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i=0; i<ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1);
		if (c.indexOf(name) === 0) return c.substring(name.length,c.length);
	}
	return "";
}

//  we consider screens larger than 760 not beeing mobile
var isNotMobile = window.matchMedia("only screen and (min-width: 760px)", window.devicePixelRatio );
//console.log(isMobile.matches);

(function(){

// Set the cookie for the retina devices
// the cookie is used later to serve appropriate image size
	if( document.cookie.indexOf('flo_device_pixel_ratio') == -1 && 'devicePixelRatio' in window && window.devicePixelRatio == 2 && isNotMobile ){

		var date = new Date();

		date.setTime( date.getTime() + 3600000 );

		document.cookie = 'flo_device_pixel_ratio=' + window.devicePixelRatio + ';' + ' expires=' + date.toUTCString() +'; path=/';

		//if cookies are not blocked, reload the page

		if(document.cookie.indexOf('flo_device_pixel_ratio') != -1) {

			window.location.reload();

		}

	} else if(document.cookie.indexOf('flo_device_pixel_ratio') != -1 && floGetCookie('flo_device_pixel_ratio') != window.devicePixelRatio){
		// delete the coockie if the saved cookie does not match the current device pixel reatio

		var dateO = new Date();
		dateO.setTime( dateO.getTime() - 3600000 ); // set a past date that will be used to make the cookie expired

		document.cookie = 'flo_device_pixel_ratio=' + window.devicePixelRatio + ';' + ' expires=' + dateO.toUTCString() +'; path=/';

		window.location.reload(); // reload the page after deletting the cookie
	}

	// skip-link-focus-fix.js

	var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
		is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
		is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

	if ( ( is_webkit || is_opera || is_ie ) && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var element = document.getElementById( location.hash.substring( 1 ) );

			if ( element ) {
				if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}

	/**
	 * navigation.js
	 *
	 * Handles toggling the navigation menu for small screens.
	 */

	var container, button, menu;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );

	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};
})();

jQuery(document).ready(function(){

	// Init FitVids to make the videos responsive
    jQuery(".video-element, .entry-content,.page-content").fitVids();

	jQuery('.flo-social-hover').hover(
		function() {
			jQuery( this ).attr('src', jQuery( this ).data('imghover') );
		}, function() {
			jQuery( this ).attr('src', jQuery( this ).data('imgoriginal') );
		}
	);
	
	// Cosmo send mail
	function cosmoSendMail( form, container){
		jQuery('#cosmo-name').removeClass('invalid');
		jQuery('#cosmo-email').removeClass('invalid');

		jQuery(container).html('');

		//jQuery('#flo-loading').css('background','rgba(255,255,255,0.2)');
		//jQuery('#flo-loading').fadeIn('slow'); // loading effect
		jQuery.ajax({
			url: ajaxurl,
			data: '&action=cosmoSendContact&'+jQuery( form ).serialize(),
			type: 'POST',
			dataType: "json",
	//      cache: false,
			success: function (json) {

				//jQuery('#flo-loading').fadeOut('slow'); // loading effect

				if(json.contact_name ){
					jQuery('#cosmo-name').addClass('invalid');
					jQuery(container).append(json.contact_name);
				}

				if(json.contact_email ){
					jQuery('#cosmo-email').addClass('invalid');
					jQuery(container).append(json.contact_email);
				}

				if(json.message ){
					jQuery('.flo-modal').fadeIn('slow');

					jQuery( form).find('input[type="text"], textarea').val('');

					setTimeout(function(){
						jQuery('.flo-modal').fadeOut('slow');
					},3000);
				}

			}

		});
	}


});

(function($) {

  function detectmob() {
   if( navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/Windows Phone/i) ){
      return true;
    }
   else {
      return false;
    }
  }

  var config = {};

  var Sage = {
    // All pages
    'common': {
      init: function() {

        var $mainHeader = $('header.main-header'),
            $navigation = $('nav.main-navigation'),
            navHeight = $navigation.outerHeight();

        var getEffectOptions = function(effect) {
          var options = {},
              effectClassName = false;

          switch(effect) {
            case 'zoomOut':

              options = {
                fade: true,
                speed: 800
              };

              effectClassName = 'eff-zoom-out';

              break;

            case 'fade':
              options = {
                fade: true,
                speed: 800
              };

              break;

            case 'fadeUp':
              options = {
                fade: true,
                speed: 1000
              };

              effectClassName = 'eff-fade-up';

              break;

            case 'fadeDown':
              options = {
                fade: true,
                speed: 1000
              };

              effectClassName = 'eff-fade-down';

              break;
            case 'fadeSide':
              options = {
                fade: true,
                speed: 800
              };

              effectClassName = 'eff-fade-side';

              break;
            case 'slide':
              options ={
                speed: 800
              };

              break;
          }

          return {
            options: options,
            effectClassName: effectClassName
          };
        };

        if ($('.flo-gallery-shortcode').length) {
          $('a.flo-gallery-shortcode-image').fancybox({
            openEffect : 'elastic',
            openSpeed  : 150,
            closeEffect : 'elastic',
            closeSpeed  : 150,
            closeClick : true,
            padding: 0,
            autoCenter: false,
            openMethod : 'changeIn',
            wrapCSS: 'flo-fancybox',
            scrollOutside: false
          });
        }

        // Init Search Modal
        if ($('.search-block').length) {
          var $searchBlock = $('.search-block');

          $searchBlock.find('a.close-btn').click(function(event) {
            event.preventDefault();

            $searchBlock.toggleClass('active');

          });

          $('.show-search').click(function(event) {
            event.preventDefault();

            $searchBlock.toggleClass('active');

            setTimeout(function() {
              $searchBlock.find('input[type="text"]').focus();
            }, 100);

            $('body').on('keyup', function(event) {
              if (event.keyCode == 27) {
                $searchBlock.toggleClass('active');

                $('body').off('keyup');
              }
            });

            $('.search-block input.input').focus();
          });
        }

        // Init Sticky Header
        if (floConfig.stickyHeader == '1' && !detectmob() && $(window).width() > 768) {

          var navigationIsOverlay = $('header.main-header').hasClass('navigation-overlay');

          $mainHeader.find('.navigation-wrap').css('height', navHeight);

          var waypoints = $('header.main-header').waypoint(function(direction) {

            if (direction == 'down') {

              if (navigationIsOverlay) {
                // $navigation.removeClass('overlay');
              }

              $mainHeader.addClass('header-sticky');
              $navigation.addClass('animated slideInDown');

              $navigation.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $navigation.removeClass('animated slideInDown');
              });

            } else if (direction === 'up') {

              $navigation
                .fadeOut('fast', function() {
                  $mainHeader.removeClass('header-sticky');
                  $navigation.fadeIn('fast');
                });
            }

          }, {
            offset: '-500px'
          });
        }

        // Category Select Button
        if ($('.category-select').length) {

          $('.category-select a.toggle').click(function(e) {
            e.preventDefault();

            $(this).toggleClass('active');

            $(".category-list").toggleClass('active');
          });
        }


        // Init Hero Slider
        if ($('.hero-slider .slide').length) {

          var effectClassName = false;

          var heroSliderAutoplay = floConfig.autoplay == '1' ? true : false,
              heroSliderSpeed = floConfig.autoplay_speed ? floConfig.autoplay_speed : false,
              isBackgroundCheck = floConfig.automatically_text_color === '1' ? true : false,
              slideshowEffect = floConfig.slideshowEffect,
              slideshowEffectSpeed = floConfig.slideshowEffectSpeed ? floConfig.slideshowEffectSpeed : false;
              sliderLayout = floConfig.sliderLayoutType || 'fullscreen';
              backgroundCheckImagesTriger = sliderLayout == 'full-width' ? '.slick-slide figure img' : '.hero-slider .slick-slide';

          var  getTargets = function(targets) {
              var targetList = [];

              targets.forEach( function(target) {
                if ($(target).length) {
                  targetList.push(target);
                }
              });

              return targetList.join(', ');
          };

          var sliderConfig = getEffectOptions(slideshowEffect);

          var basicOptions = {
              autoplay: heroSliderAutoplay,
              autoplaySpeed: heroSliderSpeed,

              responsive: [
                {
                  breakpoint: 768,
                  settings: {
                    arrows: false,
                    fade: false,
                    speed: 600
                  }
                }
              ]
          };

          if (slideshowEffectSpeed) {
            basicOptions.speed = slideshowEffectSpeed;
          }

          options = $.extend(sliderConfig.options, basicOptions);

          effectClassName = sliderConfig.effectClassName;

          $('.hero-slider').each(function(index, el) {
            var $heroSlider = $(this),
                $slider = $heroSlider.find('.slider'),
                scrollOffset = 0;




            $slider.on('init', function() {
              setTimeout(function() {
                BackgroundCheck.refresh();
              }, 10);
            });

            options.dots = typeof homeSliderDots != 'undefined' ? homeSliderDots : false;

            $slider.slick(options);


            if (effectClassName) {
              $slider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
                var $currentSlide = slick.$slides.eq(currentSlide);
                var $nextSlide = slick.$slides.eq(nextSlide);

                $currentSlide.addClass(effectClassName);
              });

              $slider.on('afterChange', function(event, slick, currentSlide) {
                 $slider.find('.' + effectClassName).removeClass(effectClassName);
              });
            }

            // Init Video Slides and Background Check on hero-slider with menu-outside
            if ($heroSlider.hasClass('menu-outside')) {

              // Init video Slide
              $slider.find('.slide.video-slide').each(function(index, el) {
                var $video = $(this),
                    $playButton = $video.find('.play-button'),
                    $closeButton = $video.find('.close-video');

                $playButton.click(function(event) {
                  event.preventDefault();

                  videoControl.Init($slider, $video);

                  $('body').on('keyup', function(event) {
                    if (event.keyCode == 27) {
                      videoControl.Close($slider, $video);
                      $('body').off('keyup');
                    }
                  });
                });

                $closeButton.click(function(event) {
                  event.preventDefault();
                  videoControl.Close($slider, $video);
                });
              });

              // Close video when change slide
              $slider.on('beforeChange', function() {
                if ($slider.find('.video-block.video-active').length) {
                  videoControl.Close($slider, $slider.find('.slide.video-slide'));
                }
              });

              var backgroundCheckTarget = getTargets(['.slide-hover', '.hero-slider button.slick-next', '.hero-slider button.slick-prev', '.hero-slider .slide-btn']);

              if (isBackgroundCheck && backgroundCheckTarget !== '') {

                BackgroundCheck.init({
                  targets: backgroundCheckTarget,
                  images: backgroundCheckImagesTriger
                });

                $slider.on('setPosition', function() {
                  BackgroundCheck.refresh();
                });
              }
            }

            // Init Background Check on hero-slider wit menu-over
            if ($heroSlider.hasClass('menu-over')) {

              if(jQuery(window).width() > 768){
                scrollOffset = navHeight;
              }else{
                scrollOffset = $('.hero-slider').outerHeight()+$('.navigation-wrap').outerHeight();
              }
              

              var backgroundCheckTarget2 = getTargets(['.hero_nav .nav-wrapper', '.hero-slider button.slick-next', '.hero-slider button.slick-prev', '.hero-slider .slide-btn']);


              if (isBackgroundCheck && backgroundCheckTarget2 !== '') {
                
                BackgroundCheck.init({
                    targets: backgroundCheckTarget2,
                    images: backgroundCheckImagesTriger
                });

                $slider.on('setPosition', function() {
                  BackgroundCheck.refresh();
                });
              }
            }

            if ($heroSlider.hasClass('menu-outside') && sliderLayout == 'fullscreen') {

              $heroSlider.find('.slide').css({
                "height": "calc(100vh - " + navHeight + "px - 42px)"
              });
            }

            $('.slide-btn').click(function(e) {
              e.preventDefault();

              if(jQuery(window).width() > 768){
                $('html, body').animate({ scrollTop: $(window).height() - scrollOffset }, 1000);
              }else{
                $('html, body').animate({ scrollTop: scrollOffset }, 1000);
              }
            });
          });

          // Controls for video
          var videoControl = {
            Init: function($slider, $video) {
              $slider.addClass('active');
              $video.find('.video-block').floVideo('create');
              $('.hero-slider').addClass('video-playing');

              // Disable Autoplay when video is on
              if (heroSliderAutoplay) {
                $slider.slick('slickSetOption', "autoplay", false, false);
              }
            },

            Close: function($slider, $video) {
              $video.find('.video-block').floVideo('destroy');
              $('.hero-slider').removeClass('video-playing');

              // Enable Autoplay after then video is hide
              if (heroSliderAutoplay) {
                $slider.slick('slickSetOption', 'autoplay', true, false);
              }

              $slider.removeClass('active');
            }
          };
        }

        // Parallax Effects
        if (floConfig.parallaxHero == '1' && !detectmob()) {

          var controller = new ScrollMagic.Controller(),
              heroImageScene;

          if ($('.hero-image').length > 0) {

            var $heroImage = $('.hero-image'),
                $inner = $('.hero-image .inner'),
                isTitle = $heroImage.find('h1.title').length;

            if ($heroImage.hasClass('small-photo')) {

              var heroImageOpacity, titleOpacity, imageX;

              heroImageOpacity = TweenMax.to($heroImage.get(0), 1, {
                backgroundColor: '#fff',
                ease: Power0.easeNone
              });

              innerOpacity = TweenMax.to($inner.get(0), 3, {
                opacity: 0
              });

              if (isTitle) {
                titleOpacity = TweenMax.to($heroImage.find('h1.title').get(0), 4, {
                    y: -250,
                    ease: Power0.easeNone
                });
              }


              heroImageScene = new ScrollMagic.Scene({
                triggerElement: $heroImage.get(0),
                duration: 950,
                triggerHook: 0,
                offset: 0
              }).setPin('.hero-image', {
                pushFollowers: false
              });

              if (isTitle) {
                heroImageScene.setTween([titleOpacity, heroImageOpacity, innerOpacity]);
              } else {
                heroImageScene.setTween([ heroImageOpacity, innerOpacity]);
              }

              controller.addScene([heroImageScene]);
            } else if ($heroImage.hasClass('full-width')) {

              var scene = new ScrollMagic.Scene({
                triggerElement: $heroImage.get(0),
                duration: "45%",
                triggerHook: 0,
                offset: 10
              });

              tweenImage = TweenMax.to($heroImage.find('img').get(0), 0.8, {
                //opacity: 0,
                //y: '-20%'
              });

              tweenText = TweenMax.to($heroImage.find('.content').get(0), 1, {
                //y: '100%',
                //color: '#373737'
              });

              scene.setTween([tweenImage, tweenText]);

              var scene2 = new ScrollMagic.Scene({
                triggerElement: $heroImage.get(0),
                duration: 0,
                triggerHook: 0,
                offset: "68%"
              });

              scene2.setClassToggle(".hero-image", "fixed");

              controller.addScene([scene, scene2]);



            } else if ($heroImage.hasClass('photo-small-text')) {

              var imageSlide = TweenMax.to($heroImage.find('.over').get(0), 4, {
                opacity: 0,
                ease: Power0.easeNone
              });

              heroImageScene = new ScrollMagic.Scene({
                triggerElement: $heroImage.get(0),
                duration: 450,
                triggerHook: 0
              }).setPin('.hero-image .over', {
                pushFollowers: false
              }).setTween([imageSlide]);

              controller.addScene([heroImageScene]);
            }
          }
        }

        // Add Selecter styling for select in widgets
        if ($('aside.widget select').length > 0) {
          $('aside.widget select').selecter({
            cover: false
          });
        }

        // Open mobile menu button
        $('.menu-button').click(function(event) {
          event.preventDefault();

          $(this).toggleClass('active');
          $('.navigation-wrap').toggleClass('showed');
          $('#wrapper > .page').toggleClass('menu-showed');
        });

        // Listen for orientation changes
        jQuery(window).on('resize  orientationChanged', function() {
            // Announce the new orientation number
            //alert($(window).width());
            if ($(window).width() > 768) {
              $('body').css('padding-top', 0);
            }
        });

        if ($(window).width() <= 768) {
          $navWrapHeight = $('.navigation-wrap').outerHeight() + 40;
          $('.navigation-wrap').addClass('fix');
          
          $('body').css('padding-top', $navWrapHeight);

          $('.header_main-nav_link.menu-item-has-children').click(function(event) {
            $link = $(this);

            if (! $link.hasClass('active')) {
              event.preventDefault();
              $('.header_main-nav_link.active').removeClass('active');
              $link.addClass('active');
            }
          });

          $('body').on('tap', '#wrapper > .page', function(event) {
            if ($('.navigation-wrap').hasClass('showed')) {
              event.preventDefault();

              $('.menu-button').removeClass('active');
              $('.navigation-wrap').toggleClass('showed');
              $('#wrapper > .page').toggleClass('menu-showed');
            }
          });
        }

        // All Posts, Full Width hover effect
        if ($('.all-posts.full-width').length) {
          $('.all-posts.full-width .post.with-image').each(function(index, el) {
            var $post = $(this),
                $openPost = $post.find('a.open-post');

            $openPost.hover(
              function() {
                $post.addClass('active');
              },
              function() {
                $post.removeClass('active');
              }
            );

          });
        }
      }
    },

    'single_gallery': {
      init: function() {
        $('.flobox').flobox();

        $('.lazy-image').lazyload({
            effect : "fadeIn"
        });

        if ($('.portfolio-single .main-slider').length) {
          $('.main-slider').slick({
            asNavFor: '.thumbnails',
            speed: 600,
            responsive: [
              {
                breakpoint: 768,
                settings: {
                  adaptiveHeight: true,
                  fade: true
                }
              }
            ]
          });
          var slidesToShow = jQuery('.thumbnail').length < 10? jQuery('.thumbnail').length - 1: 10
          $('.thumbnails').slick({
            asNavFor: '.main-slider',
            centerMode: true,
            slidesToShow: slidesToShow,
            slidesToScroll: 4,
            variableWidth: true,
            arrows: false,
            swipe: false
          });

          $('.thumbnails .thumbnail').click(function(event) {
            event.preventDefault();

            $('.main-slider').slick('slickGoTo', $(this).data('slickIndex'));
          });
        }

      }
    },

    'single_post': {
      init: function() {
        $('article .also-like').waypoint(function(direction) {
          $('.post-nav').toggleClass('disable');
        });

        $('.flobox').flobox();
        $('.lazy-image').lazyload({
          effect : "fadeIn"
        });
      }
    }

  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(window).load(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.

function floSendMail( form, container){
  jQuery('input[name="cosmo-name"]').removeClass('invalid');
  jQuery('input[name="cosmo-email"]').removeClass('invalid');

  jQuery(container).html('');

  //jQuery('#flo-loading').css('background','rgba(255,255,255,0.2)');
  //jQuery('#flo-loading').fadeIn('slow'); // loading effect
  jQuery.ajax({
    url: ajaxurl,
    data: '&action=floSendContact&'+jQuery( form ).serialize(),
    type: 'POST',
    dataType: "json",
//      cache: false,
    success: function (json) {

      //jQuery('#flo-loading').fadeOut('slow'); // loading effect

      if(json.contact_name ){
        jQuery('input[name="cosmo-name"]').addClass('invalid');
        jQuery(container).append(json.contact_name);
      }

      if(json.contact_email ){
        jQuery('input[name="cosmo-email"]').addClass('invalid');
        jQuery(container).append(json.contact_email);
      }

      if(json.message ){
        jQuery('.flo-modal').fadeIn('slow');

        jQuery(form)[0].reset();

        setTimeout(function(){
          jQuery('.flo-modal').fadeOut('slow');
        },3000);
      }

    }

  });
}
