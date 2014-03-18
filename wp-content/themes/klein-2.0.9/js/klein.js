/**
 * Klein Javascript
 *
 * This file contains Klein javascript functions
 * and definitions, method, or any javacript function
 * that corresponds to the theme
 *
 * @package Klein
 */
(function($) {
    "use strict";
	$(document).ready( function($){
		/**
		* Featured Thumbnail Hover
		*/
		$(".entry-content-thumbnail").hover(
			function() {
				var $img_source = $('img', $(this)).attr('src');
				$(this).append('<div class="entry-content-thumbnail-zoom"><a class="klein-featured-thumb-popup" href="' + $img_source + '"><i class="glyphicon glyphicon-plus"></i></a></div>');
				var $thumb_icon = $('.entry-content-thumbnail-zoom', $(this));
				var $center_y = (($(this).height() / 2) - $thumb_icon.height()) + 'px';
				var $center_x = (($(this).width() / 2) - $thumb_icon.width()) + 'px';
				$thumb_icon.css('left', $center_x);
				$thumb_icon.animate({
					top: $center_y,
					opacity: 1
				}, 450, function() {
					$('.klein-featured-thumb-popup').magnificPopup({
						type: 'image'
					});
				});
			}, function() {
				$('.entry-content-thumbnail-zoom', $(this)).fadeOut('fast', function() {
					$(this).remove();
				});
			$('body').css('cursor', 'auto'); //fix
		});
		
		/**
		* Updates/Notifcation Menu
		**/
		$("#klein-top-updates-btn").click(function(e) {
			e.preventDefault();
			$("#klein-top-updates-nav").toggle();
		});
		
		/**
		* Main Menu Navigation
		*/
		$('.menu.mobile ul.sub-menu').prev('a').addClass('desktop-menu-data-dropdown').append("&nbsp; <span class='sub-menu-toggle'><i class='nav-icon glyphicon glyphicon-chevron-down'></i></span>");
		$('.menu.mobile ul.children').prev('a').addClass('desktop-menu-data-dropdown').append("&nbsp; <span class='sub-menu-toggle'><i class='nav-icon glyphicon glyphicon-chevron-down'></i></span>");
		$('.desktop-menu ul.sub-menu').prev('a').addClass('desktop-menu-data-dropdown').append("&nbsp; <i class='nav-icon glyphicon glyphicon-chevron-down'></i>");
		$('.desktop-menu ul.children').prev('a').addClass('desktop-menu-data-dropdown').append("&nbsp; <i class='nav-icon glyphicon glyphicon-chevron-down'></i>");
		$('.nav-icon', $('.desktop-menu ul.sub-menu ul.sub-menu').prev('a')).addClass('desktop-menu-data-dropdown').remove();
		$('.nav-icon', $('.desktop-menu ul.children ul.children').prev('a')).addClass('desktop-menu-data-dropdown').remove();
		$('.desktop-menu ul.sub-menu ul.sub-menu').prev('a').addClass('desktop-menu-data-dropdown').append("&nbsp; <i class='glyphicon glyphicon-chevron-right'></i>");
		$('.desktop-menu ul.children ul.children').prev('a').addClass('desktop-menu-data-dropdown').append("&nbsp; <i class='glyphicon glyphicon-chevron-right'></i>");
		$('.nav-btn').click(function() {
			var dropdown = $(this).attr('data-dropdown');
			$(dropdown).fadeToggle();
		});
		
		$('.menu.desktop ul.sub-menu').parent('li').mouseenter(function() {
			$(this).children('ul.sub-menu').fadeIn('fast');
		}).mouseleave(function() {
			$(this).children('ul.sub-menu').fadeOut('fast');
		});
		$('.menu.desktop ul.children').parent('li').mouseenter(function() {
			$(this).children('ul.children').fadeIn('fast');
		}).mouseleave(function() {
			$(this).children('ul.children').fadeOut('fast');
		});
		
		// nav menu widgets
		if ($('.widget.widget_nav_menu').length == 1) {
			$(".widget.widget_nav_menu ul.sub-menu").prev('a').addClass('desktop-menu-data-dropdown').append("&nbsp; <i class='nav-menu-icon nav-icon glyphicon glyphicon-chevron-down'></i>");
			$('.widget.widget_nav_menu li a i').click(function(e) {
				e.preventDefault();
				if ($(this).hasClass('glyphicon glyphicon-chevron-down')) {
					$(this).removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
				} else {
					$(this).removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
				}
				$(this).parent().next('ul.sub-menu').slideToggle();
			});
		}
		
		/**
		* Responsive Menu Toggle
		*/
		$('.sub-menu-toggle').on('click', function(e) {
			e.preventDefault();
			if ($(this).hasClass('open')) {
				$(this).removeClass('open');
				$('i', $(this)).removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-chevron-down');
			} else {
				$(this).addClass('open');
				$('i', $(this)).removeClass('glyphicon glyphicon-chevron-down').addClass('glyphicon glyphicon-remove');
			}
			$('menu.mobile ul.sub-menu').css('display', 'none');
			$(this).parent().next('ul').toggle();
		});
		
		/**
		* Tooltips
		*/
		$('.tip').tooltip({
			delay: {
				show: 0,
				hide: 0
			},
			animation: true
		});
		
		/**
		* Popover
		*/
		$('.pophover').popover({
			trigger: 'hover'
		});
		
		/**
		* Carousel (Standard)
		*/
		if ($('.gears-carousel-standard').length >= 1) {
			var $klein_carousel_standard = $('.gears-carousel-standard');
			$.each($klein_carousel_standard, function() {
				var __this = $(this);
				var max_slides = (__this.attr('data-max-slides') !== undefined && __this.attr('data-max-slides').length >= 1) ? __this.attr('data-max-slides') : 7;
				var min_slides = (__this.attr('data-min-slides') !== undefined && __this.attr('data-min-slides').length >= 1) ? __this.attr('data-min-slides') : 1;
				var slide_width = (__this.attr('data-item-width') !== undefined && __this.attr('data-item-width').length >= 1) ? __this.attr('data-item-width') : 85;
				var prop = {
					minSlides: parseInt(min_slides),
					maxSlides: parseInt(max_slides),
					slideWidth: parseInt(slide_width),
					nextText: '<span class="glyphicon glyphicon-chevron-right"></span>',
					prevText: '<span class="glyphicon glyphicon-chevron-left"></span>',
					pager: false,
					moveSlides: 3
				};
				$(this).fadeIn();
				$(this).bxSlider(prop);
			});
		}
	
		$("#front-page-carousels-preloader").fadeOut('medium', function() {
			$('#front-page-slider').bxSlider({
				mode: 'fade',
				controls: false,
				adaptiveHeight: true,
				responsive: true,
				auto: true,
				pause: 3500
			});
			$('#highlights').bxSlider({
				minSlides: 2,
				maxSlides: 4,
				auto: true,
				pause: 3000,
				slideWidth: 225,
				slideHeight: 'auto',
				slideMargin: 20,
				pager: false,
				nextSelector: '#front-page-highlights-prev',
				prevSelector: '#front-page-highlights-next',
				nextText: '<a class="front-page-highlights-nav-right" href="#"><i class="glyphicon glyphicon-chevron-left"></i></a>',
				prevText: '<a class="front-page-highlights-nav-left" href="#"><i class="glyphicon glyphicon-chevron-right"></i></a>',
				onSliderLoad: function() {
					$("#highlights .slide.klein-carousel").on({
						mouseenter: function() {
							$(this).find("div.font-page-highlights-content").slideDown();
							$(this).find("img.thumbnail").animate({
								opacity: 0.5
							}, 100);
						},
						mouseleave: function() {
							$(this).find("div.font-page-highlights-content").slideUp();
							$(this).find("img.thumbnail").animate({
								opacity: 1
							}, 100);
						}
					});
				}
			});
			$("#front-page-carousels").fadeIn();
		});
		/**
		* Magnific Popup
		*/
		var $magnific_popup_config = {
			type: 'image',
			gallery: {
				enable: true
			}
		};
		// initialize
		$('.klein-zoom').magnificPopup($magnific_popup_config);
		// additional class to support popup
		$('.klein-popup').magnificPopup({
			type: 'image'
		});
		/**
		* Miscellaneous
		*/
		$('#front-page-slider').animate({
			opacity: 1
		}, 800);
		// hide BuddyPress pagination if empty
		if ($('.pagination-links').length >= 1) {
			$.each($('.pagination-links'), function() {
				var html = $(this).html();
				var __blank = "";
				if (__blank === $.trim(html)) {
					$(this).remove();
				}
			});
		}
		// hide BuddyPress subnav if empty
		if ($('.item-list-tabs#subnav ul').length >= 1) {
			if ("" === $.trim($('.item-list-tabs#subnav ul').html())) {
				$('.item-list-tabs#subnav').remove();
			}
		}
		
		// hover effect on profile bubble
		var $user_nav = $( '.item-list-tabs li' );
			if( $user_nav.length >=1 ){
				$( $user_nav ).mouseenter( function(e){
					var $bubble = $( 'a span', $(this) );
						if( $bubble.length >=1 ){
							$bubble.animate({
								top: '-19px'
							});
						}
				}).mouseout( function(e){
					var $bubble = $( 'a span', $(this) );
						if( $bubble.length >=1 ){
							$bubble.animate({
								top: '-12px'
							});
						}
				});
			}
	});// end document ready	
})(jQuery);