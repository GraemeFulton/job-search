<?php

class AJAX_Content_Navigator {

	public $shortcode_run = false;

	/* Class constructor */
	function __construct() {
		add_action('wp_enqueue_scripts', array(&$this, 'add_styles'), 9);
		$this->defaults = array(
			'show_count' => 1,
			'num_loaded_first_time' => 3,
			'num_loaded_every_time' => 3,
			'num_load_more' => 9,
			'distance_before_autoload' => 400,
			'style' => 'default',
			'enable_toggle' => 1,
			'show_wooprice' => 0,
			'show_author' => 1,
			'show_teaser' => 1,
			'show_title' => 1,
			'show_date' => 1,
			'show_comments' => 1,
			'show_likes' => 1,
			'show_perma_icon' => 1,
			'show_social' => 1,
			'show_sliders' => 1,
			'show_menu' => 1,
			'excluded_taxonomies' => array('nav_menu', 'link_category', 'post_format'),
			'excluded_types' => array('attachment', 'revision', 'nav_menu_item'),
			'excluded_sort' => array(''),
			'excluded_formats' => array(''),
			'enable_post_types' => 1,
			'enable_post_formats' => 1,
			'enable_sort' => 1,
			'grid' => 0,
			'grid_ecommerce' => 0
		);
	}
	
	/* Frontend styles */
	function add_styles(){

		/* google fonts */
		wp_register_style( 'acn_google_fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700&subset=latin,latin-ext');
		wp_enqueue_style('acn_google_fonts');
	
		/* plugin css */
		wp_register_style( 'acn_front',acn_url.'css/acn.css');
		wp_enqueue_style('acn_front');
		
		wp_register_style( 'acn_fontawesome',acn_url.'css/font-awesome.min.css');
		wp_enqueue_style('acn_fontawesome');
		
		/* jquery UI */
		wp_register_style( 'acn_ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/themes/flick/jquery-ui.css');
		wp_enqueue_style('acn_ui');
		
		/* Masonry */
		wp_register_script( 'acn_masonry', acn_url.'js/jquery.masonry.min.js', array('jquery',
				'jquery-ui-draggable',
				'jquery-ui-accordion',
				'jquery-ui-slider',
				'jquery-ui-sortable',
				'jquery-ui-droppable',
				'jquery-ui-mouse',
				'jquery-ui-widget'));
		wp_enqueue_script( 'acn_masonry' );
		
		/* Share */
		wp_register_script( 'acn_sharrre', acn_url.'js/jquery.sharrre-1.3.4.min.js');
		wp_enqueue_script( 'acn_sharrre' );
		
		/* Lightbox */
		wp_register_script( 'acn_lightbox', acn_url.'js/jquery.prettyPhoto.js' );
		wp_enqueue_script( 'acn_lightbox' );
		
		/* Lightbox CSS */
		wp_register_style( 'acn_lightbox',acn_url.'css/prettyPhoto.css');
		wp_enqueue_style('acn_lightbox');
		
	}
	
	/* Gets array of meta key values (published posts only) */
	function meta_values($metakey) {
		global $wpdb;
		$prefix = $wpdb->prefix.'postmeta';
		$posts = $wpdb->prefix.'posts';
		$values = $wpdb->get_col("SELECT meta_value AS $metakey FROM $posts 
								JOIN $prefix ON ($prefix.post_id =  $posts.ID) 
								WHERE post_status = 'publish' 
								AND meta_key = '$metakey'");
		return $values;
	}
	
	/* get options */
	function get_option($setting) {
		$options = get_option('acn_options');
		if (isset($options[$setting])) {
			return $options[$setting];
		} else {
			return $this->defaults[$setting];
		}
	}
	
	/* load skin */
	function load_skin() {
		$style = $this->get_option('style');
		$styles = apply_filters('acn_builtin_skins', array());
			
		if (isset($styles[$style]))
			return $styles[$style];
	}
	
	/* get group name */
	function get_group_name($filter) {
		switch($filter) {
			case 'sort_by':
				return __('Sort results','acn');
				break;
			case 'post_types':
				return __('Filter Content','acn');
				break;
			case 'post_formats':
				return __('Content Type','acn');
				break;
			default:
				$the_tax = get_taxonomy( $filter );
				return $the_tax->labels->name;
				break;
		}
	}
	
	/* get count of posts */
	function get_count($attribute, $filter) {
		if ($this->get_option('show_count')) {
			$display = null;
			$display = '<span>';
			switch($filter) {
				
				case 'post_types':
					$count_posts = wp_count_posts($attribute);
					$display .= $count_posts->publish;
					break;
				
				case 'post_formats':
					$args = array(
						'tax_query' => array(
							array(
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => 'post-format-'.$attribute,
							)
						)
					);
					$query = new WP_Query( $args );
					$display .= $query->found_posts;
					break;
				
			}
			$display .= '</span>';
			return $display;
		}
	}
	
	/* Returns array of post types allowed */
	function get_post_types_array( $array=null ) {
		if (!$array) {
			$post_types=get_post_types('','names'); 
			foreach ($post_types as $post_type ) {
				if (!in_array($post_type, (array)$this->get_option('excluded_types') )) {
					$array[] = $post_type;
				}
			}
		}
		return $array;
	}
	
	/* Prepares a query */
	function setup_query($args) {
		$query = new WP_Query($args);
		return $query;
	}
	
	/* Loop a group filter */
	function loop($filter, $type=null, $sortby='date', $exclude_categories=null) {
		$display = null;
		switch($filter) {
		
			case 'sort_by':
				$sort_array = apply_filters('acn_sort_array', array(
					'title' => __('Alphabetically','acn'),
					'comment_count' => __('Most Popular','acn'),
					'date' => __('Newest First','acn'),
					'date_asc' => __('Oldest First','acn'),
					'meta_value_num' => __('Top Liked','acn')
					) );
				foreach($sort_array as $k=>$v) {
					if (!in_array($k, (array)$this->get_option('excluded_sort'))) {
						if ($k == $sortby) {
							$mk_default = 'icon-check';
							$highlight = 'class="acn-highlighted"';
						} else {
							$mk_default = 'icon-check-empty';
							$highlight = null;
						}
						$display .= '<li><a href="" data-post-order="'.$k.'" '.$highlight .'><i class="'.$mk_default.'"></i>&nbsp;'.$v.'</a></li>';
					}
				}
				break;
		
			case 'post_types':
				$display .= '<li><a href="" data-reset="all" class="acn-highlighted"><i class="icon-check"></i>&nbsp;'.__('Clear / Show All','acn').'</a></li>';
				if ($this->get_post_types_array()) {
					if ($type != '') {
						$post_type = $type;
						$object = get_post_type_object( $post_type );
						$display .= '<li><a href="" data-post-type="'.$post_type.'"><i class="icon-check-empty"></i>&nbsp;'.$object->labels->name.$this->get_count($post_type, $filter).'</a></li>';
					} else {
					foreach ($this->get_post_types_array() as $post_type ) {
						$object = get_post_type_object( $post_type );
						$display .= '<li><a href="" data-post-type="'.$post_type.'"><i class="icon-check-empty"></i>&nbsp;'.$object->labels->name.$this->get_count($post_type, $filter).'</a></li>';
					}
					}
				}
				break;
				
			case 'post_formats':
				if ( current_theme_supports( 'post-formats' ) ) {
					$post_formats = get_theme_support( 'post-formats' );
					if ( is_array( $post_formats[0] ) ) {
						$formats = $post_formats[0];
						$display .= '<li><a href="" data-reset="all" class="acn-highlighted"><i class="icon-check"></i>&nbsp;'.__('Clear / Show All','acn').'</a></li>';
						foreach($formats as $format) {
							if (!in_array($format, (array)$this->get_option('excluded_formats'))) {
								$display .= '<li><a href="" data-post-format="'.$format.'"><i class="icon-check-empty"></i>&nbsp;'.ucfirst($format).$this->get_count($format, $filter).'</a></li>';
							}
						}
					}
				}
				break;
				
			default:
				$args = array(
				  'taxonomy'     => $filter,
				  'orderby'      => 'name',
				  'show_count'   => $this->get_option('show_count'),
				  'pad_counts'   => 0,
				  'hierarchical' => 1,
				  'title_li'     => '',
				  'hide_empty'   => 0,
				  'echo'		 => 0
				);
				
				/* new feature: exclude categories by slugs 'exclude_categories' */
				if ($exclude_categories) {
					$exclude = null;
					
					$cats = explode(',', $exclude_categories);
					foreach($cats as $cat_id) {
						$term_get = get_term_by('slug', $cat_id, $filter);
						if ($term_get) {
							$exclude[] = $term_get->term_id;
						}
					}
					
					$included_terms = get_terms( $filter, array('hide_empty' => 0, 'fields' => 'ids', 'exclude' => $exclude ) );
					
					if ($included_terms) {
					$args['include'] = $included_terms;
					} else {
					if (isset($exclude) && $exclude) {
					$exc_terms = get_terms( $filter, array('hide_empty' => 0, 'fields' => 'ids' ));
					$args['exclude'] = $exc_terms;
					}
					}
				}
				
				$content = wp_list_categories( $args );
				$content = str_ireplace('<li>' .__( "No categories" ). '</li>', "", $content);
				$content = preg_replace('` title="(.+)"`', '', $content);
				if ($this->get_option('show_count')) {
				$content = preg_replace('|<a href="(.+?)">(.+?)</a> \((\d+?)\)|i', '<a href="$1" data-post-taxonomy="'.$filter.'" class="data-post-taxonomy-'.$filter.'"><i class="icon-check-empty"></i>&nbsp;$2<span>$3</span></a>', $content);
				} else {
				$content = preg_replace('|<a href="(.+?)">(.+?)</a>|i', '<a href="$1" data-post-taxonomy="'.$filter.'" class="data-post-taxonomy-'.$filter.'"><i class="icon-check-empty"></i>&nbsp;$2</a>', $content);
				}
				$display .= '<li><a href="" data-reset="all" class="acn-highlighted"><i class="icon-check"></i>&nbsp;'.__('Clear / Show All','acn').'</a></li>';
				$display .= $content;
				break;
		
		}
		return $display;
	}
	
	/* Minimum woo price */
	function woo_min_price() {
		global $wpdb;
		$prefix = $wpdb->prefix.'postmeta';
		$min = "SELECT min(cast(meta_value as DECIMAL)) FROM $prefix WHERE meta_key='_regular_price'";
		return $wpdb->get_var($min);
	}
	
	/* Maximum woo price */
	function woo_max_price() {
		global $wpdb;
		$prefix = $wpdb->prefix.'postmeta';
		$max = "SELECT max(cast(meta_value as DECIMAL)) FROM $prefix WHERE meta_key='_regular_price'";
		return $wpdb->get_var($max);
	}

	/* Browser/links/navi */
	function browser( $type=null, $options=null, $forcetaxonomy=null, $forcetaxonomies=null, $forceterm=null, $pricefilter=null, $sort=null, $sortby=null, $exclude_categories=null ) {
	
		$display = null;
		$hide_sliders = null;
				
		/* get taxonomies */
		$taxonomies=get_taxonomies('','names'); 
		foreach ($taxonomies as $taxonomy ) {
			if (!in_array($taxonomy, (array)$this->get_option('excluded_taxonomies') ))
			$acn_taxonomies[] = $taxonomy;
		}
		
		/* Start to create filters left nav */
		
		$acn_filters = array();
			
		if ($this->get_option('enable_post_types'))
			$acn_filters[] = 'post_types';
		
		if ($this->get_option('enable_post_formats'))
			$acn_filters[] = 'post_formats';
		
		if (isset($acn_taxonomies)) {
			$acn_filters = array_merge($acn_filters, $acn_taxonomies);
		}
		
		/* Tweak $acn_filters based on
		shortcode arguments to customize
		acn instance */
			
		if ($type == 'product') {
			$acn_filters = array('product_cat','product_tag');
		}
		
		if ($forcetaxonomy != '' && taxonomy_exists($forcetaxonomy)) {
			if (!$forceterm) {
				$acn_filters = array($forcetaxonomy);
			} else {
				foreach($acn_filters as $k=>$f) {
					if ($f == $forcetaxonomy) {
						unset($acn_filters[$k]);
					}
				}
			}
		}
		
		if ($forcetaxonomies) {
			$split = explode(',', $forcetaxonomies);
			foreach($acn_filters as $k=>$f) {
				if (!in_array($f, $split)) {
					unset($acn_filters[$k]);
				}
			}
		}
		
		if ($this->get_option('enable_sort') && $sort !== 'no') {
			array_unshift($acn_filters, 'sort_by');
		}
		
		/* Done acn filters here, stop adding/editing filters */
		
		/* if filters exist */
		if ($acn_filters) {
			
			$display .= '<div class="acn-navi-wrap">';
			
			/* selected items */
			$display .= '<div class="acn-selected"></div><div class="acn-clear"></div>';
			
			/* show or hide controls */
			if (!$this->get_option('show_sliders') || $options === 'no')
				$hide_sliders = 'acn-hide';
				
			if ($options === 'yes')
				$hide_sliders = null;

			$display .= '<div class="acn-sec '.$hide_sliders.'">';
			$display .= '<div class="acn-header">'.__('Browse Options','acn').'</div>';
			$display .= '<div class="acn-body">';
			$display .= '<div class="acn-dposts-slider"></div>';
			$display .= '<div class="acn-slider-text">'.__('Showing <span class="acn-dposts-slider-amount"></span>&nbsp;items by default','acn').'</div>';
			$display .= '<div class="acn-posts-slider"></div>';
			$display .= '<div class="acn-slider-text">'.__('Showing <span class="acn-posts-slider-amount"></span>&nbsp;items per scroll','acn').'</div>';
			$display .= '</div>';
			$display .= '</div>';
			
			/* show woo slider */
			if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			if ( ( $this->get_option('show_wooprice') || $pricefilter === 'woocommerce' ) && $this->woo_min_price() < $this->woo_max_price() ) {

				$display .= '<div class="acn-sec">';
				$display .= '<div class="acn-header">'.__('Price Filter','acn').'</div>';
				$display .= '<div class="acn-body">';
				$display .= '<div class="acn-woo-pricefilter"></div>';
				$display .= '<div class="acn-woo-i">'.sprintf( __('Price: <span class="acn-woo-min-price"></span>&nbsp;- <span class="acn-woo-max-price"></span>','acn') ).'</div>';
				$display .= '</div>';
				$display .= '</div>';
				
			}
			}
			
			$display .= '<div class="acn-navi">';
				
			$acn_filters = apply_filters('acn_allowed_filters', $acn_filters );
			$this->acn_filters = $acn_filters;
			foreach($acn_filters as $filter) {
			
				$display .= '<h3>'.$this->get_group_name($filter).'</h3>
					<div><ul>'.$this->loop($filter, $type, $sortby, $exclude_categories).'</ul></div>';
			
			}
		
			$display .= '</div>';
			$display .= '</div>';
			return $display;
		
		}
		
	}
	
	/* return featured image link / resize icon */
	function get_lightbox_featured_image() {
		global $post;
		$img_id = get_post_thumbnail_id($post->ID);
		$url = wp_get_attachment_image_src($img_id, 'full');
		$alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
		if (!$alt_text) $alt_text = $post->post_title;
		if ($this->count_images_only() > 0) $gal = '[gal_'.$post->ID.']'; else $gal = null;
		if ($url[0]) {
			return '<a href="'.$url[0].'" class="acn-full-image" rel="prettyPhoto'.$gal.'" title="'.$alt_text.'"><i class="icon-resize-full"></i></a>';
		}
	}
	
	/* get post thumbnail masonry|grid */
	function get_thumbnail( $layout = null ) {
		global $post;
		$img_id = get_post_thumbnail_id($post->ID);
		$url = wp_get_attachment_image_src($img_id, 'full');
		
		$alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
		if (!$alt_text) $alt_text = $post->post_title;
		
		$image = $url[0];
		if ($this->get_option('grid') || $layout == 'grid' ) {
			$image = acn_url.'thumb.php?src='.$url[0].'&amp;w=500&h=500"';
		}
		if ($image)
		return '<img src="'.$image.'" alt="'.$alt_text.'" />';
	}
	
	/* get post thumbnail masonry|grid external */
	function get_thumbnail_external( $layout = null , $link, $title ) {
		global $post;
		$alt_text = $title;
		if (!$alt_text) $alt_text = $post->post_title;
		
		if ($this->get_option('grid') || $layout == 'grid' ) {
			$link = acn_url.'thumb.php?src='.$link.'&amp;w=500&h=500"';
		}
		if ($link)
		return '<img src="'.$link.'" alt="'.$alt_text.'" title="'.$alt_text.'" />';
	}
	
	/* show post thumbnail */
	function post_thumbnail( $layout=null , $social=null ) {
		global $post;
		if (has_post_thumbnail($post->ID)) {
			echo '<div class="acn-media '.$this->grid_class('acn-media', $layout).'">
					<a href="'.get_permalink($post->ID).'">'.$this->get_thumbnail( $layout ).'</a>
					'.$this->get_lightbox_featured_image();
					if ( ( $this->get_option('show_social') || $social === 'yes' ) && $social !== 'no') {
					echo '<div class="acn-socialbar">
							<div class="shareme" data-url="'.get_permalink($post->ID).'" data-text="'.$post->post_title.'"></div>
					</div><div class="acn-clear"></div>';
					}
			echo '</div>';
		} else {
			/* Try to find external image */
			$this->social = $social;
			do_action('acn_featured_image_external', $layout);
		}
	}
	
	/* Display author link / pic */
	function author() {
		if ($this->get_option('show_author')) {
		?><div class="acn-author">
				<a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><i class="icon-user"></i> <?php the_author_meta('display_name'); ?></a>
				<a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php echo get_avatar( get_the_author_meta('email'), 24 ); ?></a>
			</div><?php
		}
	}
	
	/* Post permalink */
	function permalink() {
		if ($this->get_option('show_title')) {
		?><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php
		}
	}
	
	/* Show comments count/link */
	function comments_link() {
		if ($this->get_option('show_comments')) {
		?><div class="acn-comments"><a href="<?php echo get_comments_link(); ?>"><i class="icon-comments"></i> <?php echo comments_number(0, 1, '%'); ?></a></div><?php
		}
	}
	
	/* Grid class */
	function grid_class($class, $layout=null) {
		if ($this->get_option('grid') || $layout == 'grid' ) {
			return $class.'-grid';
		}
	}
	
	/* function: validate a like post/IP basis */
	function already_liked($post_id=null, $ip) {
		$user_votes = get_option('acn_faves_by_ip');
		if (isset($user_votes["$ip"][$post_id])) // vote exists in that post
			return true;
		return false;
	}
	
	/* function: this function returns true if check by IP is enabled
	* and user already liked */
	function grey_out_button($post_id=null) {
		if ($this->already_liked($post_id, $_SERVER["REMOTE_ADDR"])) {
			return true;
		}
	}
	
	/* Get faves count */
	function get_faves($post_id=null) {
		if (!$post_id) {
			global $post;
			$post_id = $post->ID;
		}
		$count = (int)get_post_meta($post_id, 'acn_faves', true);
		return number_format_i18n($count);
	}
	
	/* function: get likes count of a post */
	function get_likes($post_id=null) {
		$count = (int)get_post_meta($post_id, 'acn_faves', true);
		return $count;
	}
	
	/* function: add a like to a post */
	function add_like($post_id=null) {
		$likes_of_post = $this->get_likes($post_id);
		$this->update_likes($post_id, $likes_of_post, $likes_of_post+1);
	}
	
	/* function: store like in DB option */
	function add_like_to_blog($post_id=null) {
	
		/* record the like in blog */
		$likes = get_option('acn_faves');
		$likes[] = array(
							'post_id' => $post_id,
							'time' => time(),
							'ip' => $_SERVER["REMOTE_ADDR"]
						);
		update_option('acn_faves', $likes);
		
		/* record the like by IP */
		$ipaddress = $_SERVER["REMOTE_ADDR"];
		$user_votes = get_option('acn_faves_by_ip');
		if (!isset($user_votes["$ipaddress"])) {
			$user_votes["$ipaddress"] = array( $post_id => array( 'liked' => 1, 'time' => time() ) );
		} else {
			if (!isset($user_votes["$ipaddress"][$post_id])) {
				$user_votes["$ipaddress"][$post_id] = array(
					'liked' => 1,
					'time' => time()
				);
			} else { // IP address votes for this post
				$user_votes["$ipaddress"][$post_id]['last_liked'] = time(); // update last liked time
			}
		}
		update_option('acn_faves_by_ip', $user_votes);
		
	}
	
	/* update who liked a post */
	function update_who_liked($post_id=null) {
		if (is_user_logged_in()) {
			$users = (array)get_post_meta($post_id, 'acn_faves_users', true);
			global $current_user;
			get_currentuserinfo();
			$id = $current_user->ID;
			if (!in_array($id, $users)) {
				$users[] = $id;
				update_post_meta($post_id, 'acn_faves_users', $users);
			}
		}
	}
	
	/* function: update post likes */
	function update_likes($post_id=null, $current, $new) {
		update_post_meta($post_id, 'acn_faves', $new);
		$this->update_who_liked($post_id);
	}
	
	/* function check already like */
	function already_liked_class($post_id=null) {
		if (!$post_id) {
			global $post;
			$post_id = $post->ID;
		}
		$already_liked = $this->already_liked($post_id, $_SERVER["REMOTE_ADDR"]);
		if ( $already_liked ) {
			return 'acn-fav-button-done';
		}
	}
	
	/* Like facility */
	function like() {
		if ($this->get_option('show_likes')) {
		?><div class="acn-like"><a href="" data-post-id="<?php the_ID(); ?>" class="acn-fav-button <?php echo $this->already_liked_class(); ?>"><i class="icon-heart"></i> <span class="acn-fav-count"><?php echo $this->get_faves(); ?></span></a></div><?php
		}
	}
	
	/* Publish time */
	function published() {
		if ($this->get_option('show_date')) {
		?><span class="acn-date"><?php the_time('j M y, g:ia'); ?></span><?php
		}
	}
	
	/* Count gallery items */
	function count_images_only() {
		global $post;
		$args = array(
				'post_type' => 'attachment',
				'numberposts' => -1,
				'post_parent' => $post->ID,
				'post_mime_type' => 'image',
				'orderby' => 'menu_order',
				'exclude' => get_post_thumbnail_id(), /* do not include featured image */
				'order' => 'ASC'
		);
		$attachments = get_posts($args);
		return count($attachments);
	}
	
	/* Show gallery icon */
	function gallery_icon() {
		
		global $post;
		$args = array(
				'post_type' => 'attachment',
				'numberposts' => -1,
				'post_parent' => $post->ID,
				'post_mime_type' => 'image',
				'orderby' => 'menu_order',
				'exclude' => get_post_thumbnail_id(), /* do not include featured image */
				'order' => 'ASC'
		);
		
		$attachments = get_posts($args);
		
		/* find count of gallery items */
		if (has_post_thumbnail()) {
			$gallery_item_count=  count($attachments)+1;
		} else {
			$gallery_item_count= count($attachments);
		}
		
		$gallery_item_count = apply_filters('acn_gallery_count', $gallery_item_count);
		
		/* show/hide count */
		if ($gallery_item_count > 1) {
			$imgcount = $gallery_item_count;
		} else {
			$imgcount = null;
		}
		
		if ($attachments) {
			echo '<div class="acn-gallery">';
			$i = 0;
			foreach($attachments as $attachment) {
				$i++;
				$url = wp_get_attachment_image_src($attachment->ID, 'full');
				$alt_text = get_post_meta($attachment->ID , '_wp_attachment_image_alt', true);
				if (!$alt_text) $alt_text = $post->post_title;
				if ($i == 1) {
					echo '<a href="'.$url[0].'" rel="prettyPhoto[gal_'.$post->ID.']" title="'.$alt_text.'"><i class="icon-camera"></i> '.$imgcount.'</a>';
				} else {
					echo '<a href="'.$url[0].'" rel="prettyPhoto[gal_'.$post->ID.']" title="'.$alt_text.'" class="acn-hide"><i class="icon-camera"></i></a>';
				}
			}
					/* parse image URLs for flickr, etc */
					do_action('acn_external_image_links');
					
			echo '</div>';
		} else { // no attachments, but maybe external images?
		
			/* there are external images */
			if ( ( $gallery_item_count > 0 ) && !has_post_thumbnail() || ( $gallery_item_count > 1 && has_post_thumbnail() ) ) {
				echo '<div class="acn-gallery">';
				$show_first = 1;
				do_action('acn_external_image_links', $show_first);
				echo '</div>';
			}
			
		}
		
	}
	
	/* get image info */
	function get_image_external_array( $url ) {
		$array = array('url' => 'http://'.$url );
		$result = $this->oembed( 'http://www.flickr.com/services/oembed/?' . http_build_query($array), $array );
		return $result;
	}
	
	/* get gallery link - oembed */
	function get_gallery_link( $url, $show_first=0, $count=null ) {
		global $post;
		$show_or_hide = 'class="acn-hide"';
		$array = array('url' => 'http://'.$url );
		if ($show_first==1) $show_or_hide = null;
		if ($count <= 1) {
			$gal_rel = null;
		} else {
			$gal_rel = '[gal_'.$post->ID.']';
		}
		$result = $this->oembed( 'http://www.flickr.com/services/oembed/?' . http_build_query($array), $array );
		echo '<a href="'.$result['html'].'" rel="prettyPhoto'.$gal_rel.'" title="'.$result['title'].'" '.$show_or_hide.'><i class="icon-camera"></i> '.$count.'</a>';
	}
	
	/* get embed code */
	function oembed($url, $array) {
		$result = array();
		$url = add_query_arg('format', 'json', $url);
		$response = wp_remote_get( $url );
		if ( 501 == wp_remote_retrieve_response_code( $response ) ) 
			return false;
		if ( ! $body = wp_remote_retrieve_body( $response ) )
			return false;
		( ( $data = json_decode( trim( $body ) ) ) && is_object( $data ) ) ? $data : false;
		
		/* embedded html */
		if (!isset($data->html) && !isset($data->url))
			return false;

		if (isset($data->html)) {
			extract ($array );
			if (isset($width)) $data->html = preg_replace(array('/ width="\d+"/'), array(' width="'.$width.'"'), $data->html );
			if (isset($height)) $data->html = preg_replace(array('/ height="\d+"/'), array(' height="'.$height.'"'), $data->html );
			$result['html'] = $data->html;
		}
		
		if (isset($data->url)) {
			$result['html'] = $data->url;
		}
		
		if (isset($data->title)) {
			$result['title'] = $data->title;
		}
		
		return $result;
	}
	
	/* Catch a video content in post */
	function video_icon() {
		global $post;
		
		/* Find video links */
		preg_match_all( "/(http(v|vh|vhd)?:\/\/)?([a-zA-Z0-9\-\_]+\.|)?vimeo\.com\/([a-zA-Z0-9\-\_]{8})([\/])?/", $post->post_content, $matches['vimeo.com'], PREG_SET_ORDER );
		preg_match_all( "/(http(v|vh|vhd)?:\/\/)?([a-zA-Z0-9\-\_]+\.|)?youtube\.com\/watch(\?v\=|\/v\/|#!v=)([a-zA-Z0-9\-\_]{11})([^<\s]*)/", $post->post_content, $matches['youtube.com'], PREG_SET_ORDER );
		preg_match_all( "/(http(v|vh|vhd)?:\/\/)?([a-zA-Z0-9\-\_]+\.|)?youtu\.be\/([a-zA-Z0-9\-\_]{11})/", $post->post_content, $matches['youtu.be'], PREG_SET_ORDER );
		foreach($matches as $match) {
			foreach($match as $vid) {
				$video_links[] = $vid[0];
			}
		}
		
		/* Parse video links */
		if (isset($video_links) && is_array($video_links)) {
			
			/* video links count */
			if (count($video_links) > 1) {
				$video_count = count($video_links);
			} else {
				$video_count = null;
			}
		
			$i = 0;
			echo '<div class="acn-video">';
			foreach($video_links as $link) {
				$alt_text = $post->post_title;
				$i++;
				if ($i == 1) {
					echo '<a href="'.$link.'&width=500&height=281" rel="prettyPhoto[vid_'.$post->ID.']" title="'.$alt_text.'"><i class="icon-facetime-video"></i> '.$video_count.'</a>';
				} else {
					echo '<a href="'.$link.'&width=500&height=281" rel="prettyPhoto[vid_'.$post->ID.']" title="'.$alt_text.'" class="acn-hide"><i class="icon-camera"></i></a>';
				}
			}
			echo '</div>';
		}
	}
	
	/* Show permalink link as icon */
	function permalink_icon() {
		if ($this->get_option('show_perma_icon')) {
		?><div class="acn-link"><a href="<?php the_permalink(); ?>"><i class="icon-link"></i></a></div><?php
		}
	}
	
	/* strips content and return x chars */
	function summary($layout=null, $excerpt_length=null, $ending = '...') {
		if ($this->get_option('show_teaser')) {
		
			global $post;
			$text = get_the_content('');
			$text = strip_shortcodes( $text );

			$text = apply_filters('the_content', $text);
			$text = str_replace(']]>', ']]&gt;', $text);
			$text = strip_tags($text);
			
			if (!$excerpt_length) $excerpt_length = 20;
			
			$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
			if ( count($words) > $excerpt_length ) {
				array_pop($words);
				$text = implode(' ', $words);
				$text = $text . $ending;
			} else {
				$text = implode(' ', $words);
			}
			
			if ($text) 
				echo '<div class="acn-excerpt '.$this->grid_class('acn-excerpt', $layout).'"><p>'.$text.'</p></div>';
		}
	}
	
	/* meta integration */
	function metatable($metakeys=null, $metanames=null) {
		global $post;
		if ($metanames && $metakeys) {
			$keys = explode(',',$metakeys);
			$names = explode(',', $metanames);
			$array = array_combine($keys, $names);
		}
			
		if (isset($array)) {
			echo '<div class="acn-fields">';
			
			foreach($array as $k=>$v) {
			
				$postmeta = get_post_meta($post->ID, $k, true);
				if ($postmeta != '' ) {
			
				echo '<div class="acn-field">
					<div class="acn-left">'.$v.'</div>
					<div class="acn-right">'.$postmeta.'</div>
					<div class="acn-clear"></div>
				</div>';
				
				}
				
			}
		
			echo '</div><div class="acn-clear"></div>';
		}
	}
	
	/**
	 * Gets the identified product. Compatible with WC 2.0 and backwards
	 * compatible with previous versions
	 *
	 * @param int $product_id the product identifier
	 * @param array $args optional array of arguments
	 *
	 * @return WC_Product the product
	 */
	function woo_get_product( $product_id, $args = array() ) {
	  $product = null;

	  if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
		// WC 2.0
		$product = get_product( $product_id, $args );
	  } else {
		
		// old style, get the product or product variation object
		if ( isset( $args['parent_id'] ) && $args['parent_id'] ) {
		  $product = new WC_Product_Variation( $product_id, $args['parent_id'] );
		} else {
		  // get the regular product, but if it has a parent, return the product variation object
		  $product = new WC_Product( $product_id );
		  if ( $product->get_parent() ) {
			$product = new WC_Product_Variation( $product->id, $product->get_parent() );
		  }
		}
	  }

	  return $product;
	}
	
	/* woo integration */
	function woo( $layout = null ) {
		global $post;
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$product = $this->woo_get_product( get_the_ID() );
			$price = $product->get_price_html();
			$label = apply_filters('add_to_cart_text', __('Buy', 'acn'));

			/* catch grid */
			if ($this->get_option('grid') || $layout == 'grid') {
				$grid = 1;
			} else {
				$grid = 0;
			}
			
			if ( ($price && $grid == 0) || ( $grid && $this->get_option('grid_ecommerce') )) {
						
		?>
			
			<div class="acn-ecom <?php echo $this->grid_class('acn-ecom', $layout); ?>">
				
				<div class="acn-left">
					<?php echo $price; ?>
				</div>
				
				<div class="acn-right woocommerce">
					<a href="<?php echo get_permalink($product->id); ?>" class="button alt"><?php echo $label; ?></a>
				</div><div class="acn-clear"></div>
				
			</div>

		<?php
			}
		}
	}
	
	/* jigoshop integration */
	function jigoshop( $layout = null ) {
		global $post;
		if ( in_array( 'jigoshop/jigoshop.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			if (get_post_type() == 'product') {
		
				$_product = new jigoshop_product( $post->ID );
				$price = $_product->get_price_html();
				$label = apply_filters('add_to_cart_text', __('Buy', 'acn'));

				/* catch grid */
				if ($this->get_option('grid') || $layout == 'grid') {
					$grid = 1;
				} else {
					$grid = 0;
				}
			
				if ( ($price && $grid == 0) || ( $grid && $this->get_option('grid_ecommerce') )) {
						
				?>
			
					<div class="acn-ecom acn-ecom-jigoshop <?php echo $this->grid_class('acn-ecom', $layout); ?>">
						
						<div class="acn-left">
							<?php echo $price; ?>
						</div>
						
						<div class="acn-right">
							<a href="<?php echo get_permalink($_product->id); ?>" class="button button-alt"><?php echo $label; ?></a>
						</div><div class="acn-clear"></div>
						
					</div>

				<?php
				}
			}
		}
	}
	
	/* Content */
	function content( $menu = null, $columns = null, $loadmorebutton=null ) {
			
		$display = null;
		if ($this->get_option('show_menu') == 0 || !isset($this->acn_filters) || $menu === 'no') {
			$class = 'full-width';
		} else {
			$class = null;
		}
		if ($menu === 'yes') {
			$class = null;
		}
		$display .= '<div class="acn-content '.$class.' acn-content-'.$columns.'">';
		$display .= '<ul></ul>';
		
		if ($loadmorebutton == 'yes') {
		$display .= '<div class="acn-load-more"><a href="#loadmore">'.__('Load more content','acn').'</a></div>';
		}
		
		$display .= '</div>';
		
		return $display;
		
	}

	/* Display the wrapper */
	function show( $args=array() ) {
	
		/* Arguments */
		$defaults = array(
			'layout' => null,
			'type' => null,
			'options' => null,
			'menu' => null,
			'columns' => null,
			'posts' => null,
			'load' => null,
			'taxonomy' => null,
			'taxonomies' => null,
			'term' => null,
			'exclude_categories' => null,
			'active' => null,
			'pricefilter' => null,
			'excerpt' => null,
			'sort' => null,
			'sortby' => 'date',
			'social' => null,
			'metakeys' => null,
			'metanames' => null,
			'loadmorebutton' => null,
			'author' => null,
			'sidebar' => null
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args, EXTR_SKIP );
		
		global $post;
		
		$this->shortcode_run = true;
		
		/* Tweak some params */
		if ($active && $active != 0) $active = $active - 1; else $active = 0;
		$forcetaxonomies = $taxonomies;
		$forcetaxonomy = $taxonomy;
		$forceterm = $term;
		
		/* If author is set */
		if ($author == 'query') { /* attempt to get author ID automatically */
			if (get_query_var('author')) {
				$author = get_query_var('author');
			}
		} elseif ($author == 'upme') {
			if (isset($_REQUEST['viewuser'])) {
				$author = $_REQUEST['viewuser'];
			} elseif (is_user_logged_in()) {
				$current_user = wp_get_current_user();
				if ( ($current_user instanceof WP_User) ) {
				$author = $current_user->ID;
				}
			}
		} elseif ($author == 'post') {
			if (isset($post->post_author)){
				$author = $post->post_author;
			}
		}
		/* Done author param setting */

		$display = null;
		$display .= '<div class="acn-clear"></div>';
				
		/* set posts num */
		$posts = (isset($posts) && $posts > 0) ? $posts : $this->get_option('num_loaded_first_time');
		$load = (isset($load) && $load > 0) ? $load : $this->get_option('num_loaded_every_time');
				
		$display .= '<div class="acn-wrap acn-wrap-'.$columns.' acn-wrap-sidebar-'.$sidebar.'" data-active="'.$active.'" data-forcetaxonomy="'.$forcetaxonomy.'" data-forcetaxonomies="'.$forcetaxonomies.'" data-forceterm="'.$forceterm.'" data-layout="'.$layout.'" data-forcetype="'.$type.'" data-num-posts="'.$posts.'" data-num-load="'.$load.'" data-excerpt="'.$excerpt.'" data-social="'.$social.'" data-metakeys="'.$metakeys.'" data-metanames="'.$metanames.'" data-loadmorebutton="'.$loadmorebutton.'" data-author="'.$author.'" data-sortby="'.$sortby.'" data-exclude_categories="'.$exclude_categories.'">';
		
		if ($this->get_option('show_menu') && $menu !== 'no' ) {
		$display .= $this->browser( $type, $options, $forcetaxonomy, $forcetaxonomies, $forceterm, $pricefilter, $sort, $sortby, $exclude_categories );
		} elseif ($menu === 'yes') {
		$display .= $this->browser( $type, $options, $forcetaxonomy, $forcetaxonomies, $forceterm, $pricefilter, $sort, $sortby, $exclude_categories );
		} else {
			/* To prevent php errors */
			$display .= '<div class="acn-sec acn-hide">';
			$display .= '<div class="acn-header">'.__('Browse Options','acn').'</div>';
			$display .= '<div class="acn-body">';
			$display .= '<div class="acn-dposts-slider"></div>';
			$display .= '<div class="acn-slider-text">'.__('Showing <span class="acn-dposts-slider-amount"></span>&nbsp;items by default','acn').'</div>';
			$display .= '<div class="acn-posts-slider"></div>';
			$display .= '<div class="acn-slider-text">'.__('Showing <span class="acn-posts-slider-amount"></span>&nbsp;items per scroll','acn').'</div>';
			$display .= '</div>';
			$display .= '</div>';
		}

			
		$display .= $this->content( $menu, $columns, $loadmorebutton );
		
		$display .= '<div class="acn-loading"><span></span></div>';
		
		if ($this->get_option('enable_toggle') && $this->get_option('show_menu') && isset($this->acn_filters) && $menu !== 'no') {
		$display .= '<div class="acn-toggle"></div>';
		}
		
		$display .= '<div class="acn-clear"></div></div><div class="acn-clear"></div>';
	
		return $display;
	
	}

}

$acn = new AJAX_Content_Navigator();