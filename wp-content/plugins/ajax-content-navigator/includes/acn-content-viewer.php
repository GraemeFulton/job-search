<?php

global $acn;

if ($acn->shortcode_run == true) {

?>

<script type="text/javascript">
jQuery(document).ready(function($) {

	loadmorebutton = $('.acn-wrap').data('loadmorebutton');
	if (loadmorebutton == 'yes') {
	$('.acn-load-more a').click(function(){
		if ($(this).hasClass('acn-cannot-load') == false){
				/* get data for filtering */
				var post_types = '';
				var post_formats = '';
				var post_taxonomies = '';
				var post_order = '';
				$('.acn-navi a').each( function() {
					if ($(this).find('i').hasClass('icon-check')) { // its been checked
						if ($(this).data('post-type')) {
							post_types = post_types + $(this).data('post-type') + ',';
						} else if ($(this).data('post-format')) {
							post_formats = post_formats + $(this).data('post-format') + ',';
						} else if ($(this).data('post-taxonomy')) {
							post_taxonomies = post_taxonomies + $(this).data('post-taxonomy') + ':' + $(this).parent().attr('class').replace(/[^0-9]/g, '') + ',';
						} else if ($(this).data('post-order')) {
							post_order = post_order + $(this).data('post-order') + ',';
						}
					}
				});
				
				$('.acn-loading').show();
				$.ajax({
					url: '<?php echo acn_url.'/ajax/acn-content-viewer.php'; ?>',
					type: 'post',
					data: {
						offset:			$('.acn-content li').size(),
						posts_per_page:	$('.acn-posts-slider-amount').html(),
						excerpt: $('.acn-wrap').data('excerpt'),
						social: $('.acn-wrap').data('social'),
						metakeys: $('.acn-wrap').data('metakeys'),
						metanames: $('.acn-wrap').data('metanames'),
						layout: $('.acn-wrap').data('layout'),
						forcetype: $('.acn-wrap').data('forcetype'),
						author: $('.acn-wrap').data('author'),
						sortby: $('.acn-wrap').data('sortby'),
						forcetaxonomy: $('.acn-wrap').data('forcetaxonomy'),
						forcetaxonomies: $('.acn-wrap').data('forcetaxonomies'),
						forceterm: $('.acn-wrap').data('forceterm'),
						exclude_categories: $('.acn-wrap').data('exclude_categories'),
						woo_min_price: $('.acn-woo-min-price').html(),
						woo_max_price: $('.acn-woo-max-price').html(),
						post_types: post_types,
						post_formats: post_formats,
						post_taxonomies: post_taxonomies,
						post_order: post_order
					},
					success: function(data){
						/* update append new items on scroll */
						$container = $('.acn-content ul');
						$container.find('li').fadeIn();
						$container.append( data ).imagesLoaded(function(){
							$container.masonry('reload');
							$container.find('li').fadeIn();
							$('.acn-loading').hide();
						});
						if (!data) {
							/** all posts loaded - stop **/
							if (loadmorebutton == 'yes') {
								$('.acn-load-more').show();
								$('.acn-load-more a').text('<?php _e('Loaded All Content!','acn'); ?>').addClass('acn-cannot-load');
							}
						}
					}
				});
		}
	});
	}

	<?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?>
	
	/* Price Range Slider */
	$( ".acn-woo-pricefilter" ).slider({
		range: true,
		min: <?php echo $acn->woo_min_price(); ?>,
		max: <?php echo $acn->woo_max_price(); ?>,
		step: 10,
		values: [ <?php echo $acn->woo_min_price(); ?>, <?php echo $acn->woo_max_price(); ?> ],
		slide: function( event, ui ) {

			$( ".acn-woo-min-price" ).html( '<?php echo get_woocommerce_currency_symbol(); ?>' + ui.values[ 0 ]);
			$( ".acn-woo-max-price" ).html( '<?php echo get_woocommerce_currency_symbol(); ?>' + ui.values[ 1 ]);
			/* get data for filtering */
			var post_types = '';
			var post_formats = '';
			var post_taxonomies = '';
			var post_order = '';
			$('.acn-navi a').each( function() {
				if ($(this).find('i').hasClass('icon-check')) { // its been checked
					if ($(this).data('post-type')) {
						post_types = post_types + $(this).data('post-type') + ',';
					} else if ($(this).data('post-format')) {
						post_formats = post_formats + $(this).data('post-format') + ',';
					} else if ($(this).data('post-taxonomy')) {
						post_taxonomies = post_taxonomies + $(this).data('post-taxonomy') + ':' + $(this).parent().attr('class').replace(/[^0-9]/g, '') + ',';
					} else if ($(this).data('post-order')) {
						post_order = post_order + $(this).data('post-order') + ',';
					}
				}
			});
			
			/* Load content */
			$('.acn-loading').show();
			$.ajax({
				url: '<?php echo acn_url.'ajax/acn-content-viewer.php'; ?>',
				type: 'post',
				data: {
					offset:			0,
					posts_per_page:	$('.acn-dposts-slider-amount').html(),
					layout: $('.acn-wrap').data('layout'),
					excerpt: $('.acn-wrap').data('excerpt'),
					social: $('.acn-wrap').data('social'),
					metakeys: $('.acn-wrap').data('metakeys'),
					metanames: $('.acn-wrap').data('metanames'),
					forcetype: $('.acn-wrap').data('forcetype'),
					author: $('.acn-wrap').data('author'),
					sortby: $('.acn-wrap').data('sortby'),
					forcetaxonomy: $('.acn-wrap').data('forcetaxonomy'),
					forcetaxonomies: $('.acn-wrap').data('forcetaxonomies'),
					forceterm: $('.acn-wrap').data('forceterm'),
					exclude_categories: $('.acn-wrap').data('exclude_categories'),
					woo_min_price: $('.acn-woo-min-price').html(),
					woo_max_price: $('.acn-woo-max-price').html(),
					post_types: post_types,
					post_formats: post_formats,
					post_taxonomies: post_taxonomies,
					post_order: post_order
				},
				success: function(data){
					/* This is for first load of filtered data */
					$container = $('.acn-content ul');
					$container.html( data ).imagesLoaded(function(){
						$container.masonry('reload');
						$container.find('li').fadeIn();
						$('.acn-loading').hide();
						
						if (loadmorebutton == 'yes') {
							before_load_more = '<?php echo $acn->get_option('num_load_more'); ?>';
							if ($('.acn-content li').size() >= before_load_more) {
								$('.acn-load-more').show();
								$('.acn-load-more a').text('<?php _e('Load more content','acn'); ?>').removeClass('acn-cannot-load');
							} else {
								$('.acn-load-more').hide();
								$('.acn-load-more a').text('<?php _e('Load more content','acn'); ?>').removeClass('acn-cannot-load');
							}
						}
						
					});
				}
			});
		}
	});
	$( ".acn-woo-min-price" ).html( '<?php echo get_woocommerce_currency_symbol(); ?>' + $( ".acn-woo-pricefilter" ).slider( "values", 0 ));
	$( ".acn-woo-max-price" ).html( '<?php echo get_woocommerce_currency_symbol(); ?>' + $( ".acn-woo-pricefilter" ).slider( "values", 1 ));
	
	<?php } ?>
	
	/* Posts no. slider */
	$( ".acn-posts-slider" ).slider({
		range: "max",
		min: 1,
		max: 10,
		value: $('.acn-wrap').data('num-load'),
		slide: function( event, ui ) {
		$( ".acn-posts-slider-amount" ).html( ui.value );
		}
	});
	$( ".acn-posts-slider-amount" ).html( $( ".acn-posts-slider" ).slider( "value" ) );
	
	/* Posts default slider */
	$( ".acn-dposts-slider" ).slider({
		range: "max",
		min: 1,
		max: 10,
		value: $('.acn-wrap').data('num-posts'),
		slide: function( event, ui ) {
		$( ".acn-dposts-slider-amount" ).html( ui.value );
		}
	});
	$( ".acn-dposts-slider-amount" ).html( $( ".acn-dposts-slider" ).slider( "value" ) );

	/* Toggle the left filters */
	$('.acn-toggle').click(function(e){
		e.preventDefault();
		$container = $('.acn-content ul');
		if ($(this).hasClass('acn-hide-menu') == false) {
			$('.acn-navi-wrap').stop().animate({opacity: 0}).fadeOut( function() {
				$('.acn-toggle').addClass('acn-hide-menu');
				$('.acn-content').addClass('full-width');
				$container.imagesLoaded(function(){
					$container.masonry('reload');
					$container.find('li').fadeIn();
				});
			});
		} else {
			$container.find('li').hide();
			$('.acn-navi-wrap').stop().animate({opacity: 1}).fadeIn( function() {
				$('.acn-toggle').removeClass('acn-hide-menu');
				$('.acn-content').removeClass('full-width');
				$container.imagesLoaded(function(){
					$container.masonry('reload');
					$container.find('li').fadeIn();
				});
			});
		}
	});
	
	/* Load content */
	$('.acn-loading').show();
	$.ajax({
		url: '<?php echo acn_url.'ajax/acn-content-viewer.php'; ?>',
		type: 'post',
		data: {
			offset:			$('.acn-content li').size(),
			posts_per_page:	$('.acn-dposts-slider-amount').html(),
			layout: $('.acn-wrap').data('layout'),
			excerpt: $('.acn-wrap').data('excerpt'),
			social: $('.acn-wrap').data('social'),
			metakeys: $('.acn-wrap').data('metakeys'),
			metanames: $('.acn-wrap').data('metanames'),
			forcetype: $('.acn-wrap').data('forcetype'),
			author: $('.acn-wrap').data('author'),
			sortby: $('.acn-wrap').data('sortby'),
			forcetaxonomy: $('.acn-wrap').data('forcetaxonomy'),
			forcetaxonomies: $('.acn-wrap').data('forcetaxonomies'),
			forceterm: $('.acn-wrap').data('forceterm'),
			exclude_categories: $('.acn-wrap').data('exclude_categories'),
			woo_min_price: $('.acn-woo-min-price').html(),
			woo_max_price: $('.acn-woo-max-price').html(),
			post_order: $('.acn-wrap').data('sortby')
		},
		success: function(data){
			/* First load: init masonry, load html data */
			var $container = $('.acn-content ul');
			$container.html(data).imagesLoaded(function(){
				$container.masonry({
					itemSelector : 'li'
				});
				$container.find('li').fadeIn();
				$('.acn-loading').hide();
			});
			
			/* First load should we show load more button?*/
			if (loadmorebutton == 'yes') {
				before_load_more = '<?php echo $acn->get_option('num_load_more'); ?>';
				if ($('.acn-content li').size() >= before_load_more) {
					$('.acn-load-more').show();
					$('.acn-load-more a').text('<?php _e('Load more content','acn'); ?>').removeClass('acn-cannot-load');
				} else {
					$('.acn-load-more').hide();
					$('.acn-load-more a').text('<?php _e('Load more content','acn'); ?>').removeClass('acn-cannot-load');
				}
			}
			
		},
		error: function(data){
			alert('Ajax could not be loaded!');
			$('.acn-loading').hide();
		}
	});
	
	/* acn-navi accordion */
	$('.acn-navi').accordion({ 
		collapsible: true,
		autoHeight: false,
		active: $('.acn-wrap').data('active')
	});
	
	/* add toggle sign */
	$('.acn-navi li').each(function(){
		if ($(this).children('ul').length) {
			$(this).children('a').append('<ins class="icon-angle-right"></ins>');
		}
	});
	
	/* toggling submenus */
	$('.acn-navi li a ins').click(function(e){
		e.stopPropagation();
		e.preventDefault();
		if ($(this).hasClass('icon-angle-right')) {
			$(this).addClass('icon-angle-down').removeClass('icon-angle-right');
		} else {
			$(this).addClass('icon-angle-right').removeClass('icon-angle-down');
		}
		$(this).parent().parent().find('ul.children').slideToggle();
	});
	
	/* hide multi levels */
	$('.acn-navi ul.children').hide();
	
	/* removing filters */
	$('.acn-selected a').live('click',function(e){
		e.preventDefault();
		tag_text = $(this).find('span').html();
		canScroll = false
		$('.acn-navi a:contains("' + tag_text + '")').trigger('click');
	});
	
	/* disable link behavior */
	$('.acn-navi a').click(function(e) {
		
		e.preventDefault();
		
		/* mark as selected */
		if ($(this).find('i').hasClass('icon-check-empty')) {
			$(this).find('i').removeClass('icon-check-empty').addClass('icon-check');
			$(this).addClass('acn-highlighted');
			if ($(this).data('post-order')) {
			$(this).parent().parent().find('a').not(this).removeClass('acn-highlighted');
			}
			/* Unmark parent only */
			if ($(this).parent().parent().attr('class') == 'children') {
				$(this).parent().parent().parent().find('a:first').find('i').removeClass('icon-check').addClass('icon-check-empty');
				$(this).parent().parent().parent().find('a:first').removeClass('acn-highlighted');
			}
			/* Mark all children */
			if ($(this).parent().find('ul.children')) {
				$(this).parent().find('ul.children').find('i').addClass('icon-check').removeClass('icon-check-empty');
				$(this).parent().find('ul.children').find('a').addClass('acn-highlighted');
			}
		} else {
			$(this).find('i').removeClass('icon-check').addClass('icon-check-empty');
			$(this).removeClass('acn-highlighted');
			/* Unmark parent only */
			if ($(this).parent().parent().attr('class') == 'children') {
				$(this).parent().parent().parent().find('a:first').find('i').removeClass('icon-check').addClass('icon-check-empty');
				$(this).parent().parent().parent().find('a:first').removeClass('acn-highlighted');
			}
			/* Unmark all children */
			if ($(this).parent().find('ul.children')) {
				$(this).parent().find('ul.children').find('i').removeClass('icon-check').addClass('icon-check-empty');
				$(this).parent().find('ul.children').find('a').removeClass('acn-highlighted');
			}
		}
		
		/* Catch all */
		if ($(this).data('reset')) {
			$(this).parent().parent().find('a').not(this).find('i').removeClass('icon-check').addClass('icon-check-empty');
			$(this).parent().parent().find('a').not(this).removeClass('acn-highlighted');
		} else {
			$(this).parent().parent().find('a[data-reset="all"]').find('i').removeClass('icon-check').addClass('icon-check-empty');
			$(this).parent().parent().find('a[data-reset="all"]').removeClass('acn-highlighted');
			/* if this is submenu catch reset link all from parent */
			if ($(this).parent().parent().attr('class') == 'children') {
				$(this).parent().parent().parent().parent().find('a[data-reset="all"]').find('i').removeClass('icon-check').addClass('icon-check-empty');
				$(this).parent().parent().parent().parent().find('a[data-reset="all"]').removeClass('acn-highlighted');
			}
		}
		
		/* Only one checked at a time */
		if ($(this).data('post-order')) {
			$(this).parent().parent().find('a').not(this).find('i').removeClass('icon-check').addClass('icon-check-empty');
		}
		
		/* get data for filtering */
		$('.acn-navi-wrap .acn-selected').empty().hide();
		var post_types = '';
		var post_formats = '';
		var post_taxonomies = '';
		var post_order = '';
		$('.acn-navi a').each( function() {
			if ($(this).find('i').hasClass('icon-check')) { // its been checked
			
				/* clone attributes only */
				if (!$(this).data('reset') && !$(this).data('post-order')) {
					var cloneit = $(this).clone().find('i,span,ins').remove().end().html().replace(/&nbsp;/g, '');
					var new_html = '<a href=""><span>' + cloneit + '</span><i class="icon-remove"></i></a>';
					$('.acn-navi-wrap .acn-selected').append(new_html).fadeIn();
				}
				
				if ($(this).data('post-type')) {
					post_types = post_types + $(this).data('post-type') + ',';
				} else if ($(this).data('post-format')) {
					post_formats = post_formats + $(this).data('post-format') + ',';
				} else if ($(this).data('post-taxonomy')) {
					post_taxonomies = post_taxonomies + $(this).data('post-taxonomy') + ':' + $(this).parent().attr('class').replace(/[^0-9]/g, '') + ',';
				} else if ($(this).data('post-order')) {
					post_order = post_order + $(this).data('post-order') + ',';
				}
			}
		});
		
		/* Load content */
		$('.acn-loading').show();
		$.ajax({
			url: '<?php echo acn_url.'ajax/acn-content-viewer.php'; ?>',
			type: 'post',
			data: {
				offset:			0,
				posts_per_page:	$('.acn-dposts-slider-amount').html(),
				layout: $('.acn-wrap').data('layout'),
				excerpt: $('.acn-wrap').data('excerpt'),
				social: $('.acn-wrap').data('social'),
				metakeys: $('.acn-wrap').data('metakeys'),
				metanames: $('.acn-wrap').data('metanames'),
				forcetype: $('.acn-wrap').data('forcetype'),
				author: $('.acn-wrap').data('author'),
				sortby: $('.acn-wrap').data('sortby'),
				forcetaxonomy: $('.acn-wrap').data('forcetaxonomy'),
				forcetaxonomies: $('.acn-wrap').data('forcetaxonomies'),
				forceterm: $('.acn-wrap').data('forceterm'),
				exclude_categories: $('.acn-wrap').data('exclude_categories'),
				woo_min_price: $('.acn-woo-min-price').html(),
				woo_max_price: $('.acn-woo-max-price').html(),
				post_types: post_types,
				post_formats: post_formats,
				post_taxonomies: post_taxonomies,
				post_order: post_order
			},
			success: function(data){
				/* This is for first load of filtered data */
				$container = $('.acn-content ul');
				$container.html( data ).imagesLoaded(function(){
					$container.masonry('reload');
					$container.find('li').fadeIn();
					$('.acn-loading').hide();
					
					if (loadmorebutton == 'yes') {
						before_load_more = '<?php echo $acn->get_option('num_load_more'); ?>';
						if ($('.acn-content li').size() >= before_load_more) {
							$('.acn-load-more').show();
							$('.acn-load-more a').text('<?php _e('Load more content','acn'); ?>').removeClass('acn-cannot-load');
						} else {
							$('.acn-load-more').hide();
							$('.acn-load-more a').text('<?php _e('Load more content','acn'); ?>').removeClass('acn-cannot-load');
						}
					}
					
				});
			}
		});
		
	});

});
</script>

<?php } ?>