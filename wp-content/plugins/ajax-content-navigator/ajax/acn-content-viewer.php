<?php

	define( 'WP_USE_THEMES', false );
	require('../../../../wp-load.php');

	if (!isset($_POST['offset']))
		die('Not allowed.');
		
	global $acn;
	extract($_POST);
	
	$args = array(
			'post_type' 		=> $acn->get_post_types_array(),
			'posts_per_page' 	=> $posts_per_page,
			'offset'			=> $offset
	);
		
	/* sortby global */
	if ($sortby != '') {
		$args['orderby'] = $sortby;
		if ($sortby == 'title') {
			$args['order'] = 'ASC';
		}
	}
		
	/** Find sort/order */
	if (isset($post_order) && $post_order != '' && !strstr($post_order, 'undefined')) {
		$post_order = trim($post_order, ',');
		
		$args['orderby'] = $post_order;
		
		if ($post_order == 'meta_value_num') {
			$args['orderby'] = 'meta_value_num ID';
			$args['meta_key'] = 'acn_faves';
			add_filter('posts_orderby', 'acn_fix_orderby_metavalue');
		}
		
		if ($post_order == 'date_asc') {
			$args['orderby'] = 'date';
		}
		
		if (in_array($post_order, array('title', 'date_asc') )) {
			$args['order'] = 'ASC';
		}
			
	}
	
	/** Find post types **/
	if (isset($post_types) && $post_types != '' && !strstr($post_types, 'undefined')) {
		$post_types = trim($post_types, ',');
		$post_types = explode(',', $post_types);
		$args['post_type'] = $acn->get_post_types_array( $post_types );
	}
	
	/* Try to force specific taxonomies */
	if ($forcetaxonomies) {
		$split = explode(',', $forcetaxonomies);
		foreach($split as $new_split) {
			$split_terms[$new_split] = get_terms( $new_split, array( 'hide_empty' => 0, 'fields' => 'ids' ) );
		}
		$args['tax_query'] = array('relation' => 'OR');
		foreach($split_terms as $tax => $terms_ids) {
			$args['tax_query'][] = array(
				'taxonomy' => $tax,
				'terms' => $terms_ids,
				'field' => 'id',
			);
		}
	}
	
	/** Find post taxonomies **/
	if (isset($post_taxonomies) && $post_taxonomies != '' && !strstr($post_taxonomies, 'undefined')) {
		$post_taxonomies = trim($post_taxonomies, ',');
		$post_taxonomies = explode(',', $post_taxonomies);
		foreach($post_taxonomies as $tax_relation) {
			$tax_relation_arr = explode(':', $tax_relation);
			$term = get_term_by('id', $tax_relation_arr[1], $tax_relation_arr[0]);
			$relations[$term->slug] = $tax_relation_arr[0];
		}
		$grouped = array();
		foreach ($relations as $choice => $group) {
			$grouped[$group][] = $choice;
		}
		foreach($grouped as $k => $v) {
			$implode = implode(',',$v);
			$terms = explode(',', $implode);
			$args['tax_query'] = array('relation' => 'AND');
			$args['tax_query'][] = array( 'taxonomy' => $k, 'field' => 'slug', 'terms' => $terms );
		}
	}
	
	/** Find post formats **/
	if (isset($post_formats) && $post_formats != '' && !strstr($post_formats, 'undefined')) {
		$post_formats = trim($post_formats, ',');
		$post_formats = explode(',', $post_formats);
		foreach($post_formats as $format) {
			$new_post_formats[] = 'post-format-'.$format;
		}
		$args['tax_query'][] = array( 'taxonomy' => 'post_format', 'field' => 'slug', 'terms' => $new_post_formats );
	}
	
	/**
	@Tweak query args by shortcode params 
	@shortcode [acn] 
	**/
	
	/* Trying to force a post type */
	if ($forcetype != '') {
		$args['post_type'] = $forcetype;
	}
	
	/* Trying to force a taxonomy! */
	if ($forcetaxonomy != '' && !$forceterm) {
	
		if (taxonomy_exists($forcetaxonomy)) {
			
			$taxonomy_terms = get_terms( $forcetaxonomy, array( 'hide_empty' => 0, 'fields' => 'ids' ) );
			
			if ($taxonomy_terms) {
				$args['tax_query'][] = array( 'taxonomy' => $forcetaxonomy, 'field' => 'id', 'terms' => $taxonomy_terms);
			}
			
		}
	}
	
	/* Trying to force a term */
	if ( $forceterm && $forcetaxonomy ) {
		$term = get_term_by('slug', $forceterm, $forcetaxonomy);
		$id = $term->term_id;
		$args['tax_query'][] = array( 'taxonomy' => $forcetaxonomy, 'field' => 'id', 'terms' => array($id) );
	}
	
	/* Apply price range */
	if ($args['post_type'] == 'product') {
		if (isset($woo_min_price) && isset($woo_max_price)) {
			$woo_min_price = filter_var($woo_min_price, FILTER_SANITIZE_NUMBER_INT);
			$woo_max_price = filter_var($woo_max_price, FILTER_SANITIZE_NUMBER_INT);
			$args['meta_query'][] = array(
				'key' => '_regular_price',
				'value' => array( $woo_min_price, $woo_max_price ),
				'type' => 'DECIMAL',
				'compare' => 'BETWEEN',
			);
		}
		$args['meta_query'][] = array( 'key'    => '_visibility',
                                       'value'  => array('catalog', 'visible'), 'compare' => 'IN' );
	}
	
	/* Apply Author ID */
	if ($author) {
		$args['author'] = $author;
	}
	
	/* Exclude categories by slugs */
	if ($exclude_categories) {
		$custom_tax=get_taxonomies('','names'); 
		foreach ($custom_tax as $custom_t ) {
			if (!in_array($taxonomy, (array)$acn->get_option('excluded_taxonomies') )) {
					
					
					$args['tax_query'][] = array(
							'taxonomy' => $custom_t,
							'terms' => explode(',', $exclude_categories),
							'field' => 'slug',
							'operator' => 'NOT IN');
							
			}
		}
	}
		
	/* done tweaking run query */
	/* stop editing here */
	
	$query = $acn->setup_query( $args );
	while ($query->have_posts()) : $query->the_post();

	?>
	
		<li style="display: none">
		
			<?php $acn->post_thumbnail( $layout, $social ); ?>
			
			<?php $acn->author(); ?>
			
			<?php if ($acn->get_option('show_title') || $acn->get_option('show_date')) { ?>
			<div class="acn-meta <?php echo $acn->grid_class('acn-meta', $layout); ?>">
				
				<?php $acn->permalink(); ?>
				
				<?php $acn->published(); ?>
				
			</div>
			<?php } ?>
			
			<?php $acn->summary($layout, $excerpt); ?>
			
			<?php $acn->metatable($metakeys, $metanames); ?>
			
			<?php $acn->woo( $layout ); ?>
			
			<?php $acn->jigoshop( $layout ); ?>
			
			<div class="acn-shortcuts">
				<div class="acn-left">
				
					<?php $acn->comments_link(); ?>
					
					<?php $acn->like(); ?>
					
				</div>
				<div class="acn-right">
				
					<?php $acn->video_icon(); ?>
				
					<?php $acn->gallery_icon(); ?>
				
					<?php $acn->permalink_icon(); ?>
					
				</div><div class="acn-clear"></div>
			</div>
			
			<?php
			$terms = wp_get_post_terms($post->ID, 'post_tag');
			if ($terms && !is_wp_error( $terms )) {
				echo '<div class="acn-tags '.$acn->grid_class('acn-tags', $layout).'">';
				foreach($terms as $term) {
					echo '<a href="'.get_term_link($term->slug, 'post_tag').'">#'.$term->name.'</a>';
				}
				echo '</div>';
			}
			?>

		</li>
	
	<?php
	endwhile;
	
if ($query->have_posts()) : ?>

<script type="text/javascript">
jQuery(document).ready(function($) {

	<?php if ($acn->get_option('show_social') || $social === 'yes') { ?>
	/* Social share */
	$('.shareme').sharrre({
	share: {
	twitter: true,
	facebook: true,
	googlePlus: true
	},
	template: '<div class="box"><div class="left"><i class="icon-link"></i></div><div class="middle"><a href="#" class="facebook"><i class="icon-facebook"></i></a><a href="#" class="twitter"><i class="icon-twitter"></i></a><a href="#" class="googleplus"><i class="icon-google-plus"></i></a></div><div class="right">{total}</div></div>',
	enableHover: false,
	enableTracking: true,
	render: function(api, options){
	$(api.element).on('click', '.twitter', function() {
	api.openPopup('twitter');
	});
	$(api.element).on('click', '.facebook', function() {
	api.openPopup('facebook');
	});
	$(api.element).on('click', '.googleplus', function() {
	api.openPopup('googlePlus');
	});
	}
	});
	<?php } ?>

	/* Lightbox */
	$("a[rel^='prettyPhoto']").prettyPhoto();
	
	/* Scroll function */
	canScroll = true;
	
	loadmorebutton = $('.acn-wrap').data('loadmorebutton');
	if (loadmorebutton == 'yes') {
		before_load_more = '<?php echo $acn->get_option('num_load_more'); ?>';
		if ($('.acn-content li').size() >= before_load_more) {
			$('.acn-load-more').show();
			$('.acn-load-more a').text('<?php _e('Load more content','acn'); ?>').removeClass('acn-cannot-load');
			canScroll = false;
		} else {
			$('.acn-load-more').hide();
			$('.acn-load-more a').text('<?php _e('Load more content','acn'); ?>').removeClass('acn-cannot-load');
		}
	}
			
	$(window).scroll(function () {
		if ($(window).scrollTop() + $(window).height() > $(document).height() - <?php echo $acn->get_option('distance_before_autoload'); ?>) {
			if (canScroll == true) {
			
				/* sets off scroll */
				canScroll = false;
				
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
						
						canScroll = true;
						
						loadmorebutton = $('.acn-wrap').data('loadmorebutton');
						if (loadmorebutton == 'yes') {
							before_load_more = '<?php echo $acn->get_option('num_load_more'); ?>';
							if ($('.acn-content li').size() >= before_load_more) {
								$('.acn-load-more').show();
								$('.acn-load-more a').text('<?php _e('Load more content','acn'); ?>').removeClass('acn-cannot-load');
								canScroll = false;
							} else {
								$('.acn-load-more').hide();
								$('.acn-load-more a').text('<?php _e('Load more content','acn'); ?>').removeClass('acn-cannot-load');
							}
						}
						
						if (!data) {
							
							/** all posts loaded - stop **/
							canScroll = false;
							/** all posts loaded - stop **/
							if (loadmorebutton == 'yes') {
								$('.acn-load-more').show();
								$('.acn-load-more a').text('<?php _e('Loaded All Content!','acn'); ?>').addClass('acn-cannot-load');
							}
							
						}
					}
				});
			}
		}
	});
	
	/* Add like / fav to post */
	$('.acn-fav-button').click(function(e){
		e.preventDefault();
		var button = $(this);
		if ($(this).hasClass('acn-fav-button-done') == false) {
			post_id = $(this).data('post-id');
			$('*[data-post-id="' + post_id + '"]').addClass('acn-fav-button-done');
			$.ajax({
				url: '<?php echo acn_url.'/ajax/acn-like.php'; ?>',
				type: 'post',
				data: {post_id: post_id},
				dataType: 'json',
				success: function(data){
					if (data.show_likes) {
						$('*[data-post-id="' + post_id + '"]').find('span.acn-fav-count').html(data.show_likes);
					}
				}
			});
		}
	});

});
</script>

<?php endif;