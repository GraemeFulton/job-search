<?php
/**
 * Klein functions and definitions
 *
 * @package klein
 */
DEFINE( 'KLEIN_VERSION', '2.0.9' ); 
DEFINE( 'KLEIN_SIDEBAR_KEY', 'klein_option72613_sidebars' ); 
 
/**
 * Optional: set 'ot_show_pages' filter to false.
 * This will hide the settings & documentation pages.
 */
 
add_filter( 'ot_show_pages', '__return_false' );

/**
 * Optional: set 'ot_show_new_layout' filter to false.
 * This will hide the "New Layout" section on the Theme Options page.
 */
add_filter( 'ot_show_new_layout', '__return_false' );

/**
 * Required: set 'ot_theme_mode' filter to true.
 * Required: set 'ot_child_theme_mode' filter to true
 */
add_filter( 'ot_child_theme_mode', '__return_true' );
add_filter( 'ot_theme_mode', '__return_true' );

/**
 * Required: include OptionTree.
 */
load_template( trailingslashit( get_template_directory() ) . 'option-tree/ot-loader.php' );
 
/**
 * Options Settings
 */
load_template( trailingslashit( get_template_directory() ) . 'klein/theme-option.php' );
 
/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'klein_setup' ) ) :

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function klein_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on klein, use a find and replace
	 * to change 'klein' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'klein', get_template_directory() . '/languages' );
	
	// add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	
	// add featured-image theme support
	add_theme_support( 'post-thumbnails' );  
		add_image_size( 'klein-thumbnail-large', 650, 350, true ); 
		add_image_size( 'klein-thumbnail-slider', 580, 277, true ); 
		add_image_size( 'klein-thumbnail-highlights', 325, 325, true ); 
		add_image_size( 'klein-thumbnail', 225, 185, true );
	
	
	// add support for woocommerce
	add_theme_support( 'woocommerce' ); 
		define('WOOCOMMERCE_USE_CSS', false);
	
	// register the nav emnu
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'klein' ),
	));
	
	// add post formats
	add_theme_support( 'post-formats', array( 'video', 'status' ) );

	//bbPress support 
	add_theme_support( 'bbpress' );
}

endif; // klein_setup

add_action( 'after_setup_theme', 'klein_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function klein_widgets_init() {
	/*
	 * Default Sidebars
	 */
	register_sidebar( array(
		'name'          => __( 'Sidebar Left', 'klein' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3><div class="widget-clear"></div>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Sidebar Right', 'klein' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3><div class="widget-clear"></div>',
	) );
	
	/*
	 * Front Page Sidebars
	 */
	register_sidebar( array(
		'name'          => __( 'Front Page Sidebar A', 'klein' ),
		'id'            => 'front-page-sidebar-a',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3><div class="widget-clear"></div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Front Page Sidebar B', 'klein' ),
		'id'            => 'front-page-sidebar-b',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3><div class="widget-clear"></div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Front Page Sidebar C', 'klein' ),
		'id'            => 'front-page-sidebar-c',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3><div class="widget-clear"></div>',
	) );
	
	/**
	 * BuddyPress Sidebar
	 */
	
	register_sidebar( array(
		'name'          => __( '(BuddyPress) Sidebar Right', 'klein' ),
		'id'            => 'bp-klein-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3><div class="widget-clear"></div>',
	) );
	
	register_sidebar( array(
		'name'          => __( '(BuddyPress) Sidebar Left', 'klein' ),
		'id'            => 'bp-klein-sidebar-left',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3><div class="widget-clear"></div>',
	) );
	
	/**
	 * bbPress Sidebar
	 */
	 
	register_sidebar( array(
		'name'          => __( '(bbPress) Sidebar Left', 'klein' ),
		'id'            => 'bbp-klein-sidebar-left',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3><div class="widget-clear"></div>',
	) );
	
	
	register_sidebar( array(
		'name'          => __( '(bbPress) Sidebar Right', 'klein' ),
		'id'            => 'bbp-klein-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3><div class="widget-clear"></div>',
	) );

	
	/**
	 * WooCommerce Sidebar
	 */
	register_sidebar( array(
		'name'          => __( '(WooCommerce) Sidebar Left', 'klein' ),
		'id'            => 'wc-klein-sidebar-left',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3><div class="widget-clear"></div>',
	));
	
	register_sidebar( array(
		'name'          => __( '(WooCommerce) Sidebar Right', 'klein' ),
		'id'            => 'wc-klein-sidebar-right',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3><div class="widget-clear"></div>',
	));
	
	// Footer Widgets
	
	$footer_widgets_count = 4;
	$footer_widgets_index = 0;
	
	for( $i = 0; $i < $footer_widgets_count; $i++){
	
		$footer_widgets_index ++;
	
		register_sidebar( array(
			'name'          => __( 'Footer Widget Area ' . $footer_widgets_index, 'klein' ),
			'id'            => 'bp-klein-footer-' . $footer_widgets_index,
			'before_widget' => '<aside id="%1$s-footer-'.$footer_widgets_index.'" class="row widget  %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3><div class="widget-clear"></div>',
		));
		
	}
	
	// Register Additional Sidebars
	$sidebars = unserialize( get_option( KLEIN_SIDEBAR_KEY ) ); 
	
	if( !empty( $sidebars ) ){ 
		foreach( $sidebars as $sidebar ){ 
			if( !empty( $sidebar['klein-sidebar-name'] ) ){ 
				register_sidebar( array(
					'name'          => $sidebar['klein-sidebar-name'],
					'id' 			=> $sidebar['klein-sidebar-id'],
					'before_widget' => '<aside id="%1$s" class="row widget  %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3><div class="widget-clear"></div>',
				));
			}
		}
	}
}

add_action( 'widgets_init', 'klein_widgets_init' );

/**
 * Font Support for IE 8
**/
function klein_ie8_fix(){
	?>
		<!--[if lte IE 8]>
			<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/ie-fix.css'; ?>" type="text/css"/>
			<script src="<?php echo get_template_directory_uri() . '/js/ie-fix.js';?>"></script>
		<![endif]-->
	
		<!--[if gt IE 8]>
			<link href="http://fonts.googleapis.com/css?family=PT+Sans:400,700|Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
		<![endif]-->

		<!--[if !IE]> -->
			<link href="http://fonts.googleapis.com/css?family=PT+Sans:400,700|Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
		<!-- <![endif]-->
	<?php
}

add_action( 'wp_head', 'klein_ie8_fix' );

/**
 * Enqueue scripts and styles
 */
function klein_html5_shiv(){
	?>
	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri() . '/js/html5shiv.js'; ?>"></script>
	<![endif]-->
	<!--[if IE 7]>
		<link rel="stylesheet" media="all" href="<?php echo get_template_directory_uri() . '/css/font-awesome-ie7.css' ?>" />
	<![endif]-->
	<?php
} 

add_action( 'wp_head', 'klein_html5_shiv', 0 );

function klein_scripts(){

	global $wp_version;
		
		// Global stylesheets
		wp_enqueue_style( 'klein-bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), KLEIN_VERSION );
		wp_enqueue_style( 'klein-bootstrap-theme', get_template_directory_uri() . '/css/bootstrap-theme.css', array(), KLEIN_VERSION );
		wp_enqueue_style( 'klein-base', get_stylesheet_uri(), array(), KLEIN_VERSION );
		wp_enqueue_style( 'klein-layout', get_template_directory_uri() . '/css/layout.css', array(), KLEIN_VERSION );
		wp_enqueue_style( 'klein-mobile-stylesheet', get_template_directory_uri() . '/css/mobile.css', array( 'klein-layout' ), KLEIN_VERSION );
		
		// Magnific Popup
		wp_enqueue_style( 'klein-magnific-popup', get_template_directory_uri() . '/css/magnific.popup.css', array(), KLEIN_VERSION );
		
		// Bx Slider
		wp_enqueue_style( 'klein-bx-slider', get_template_directory_uri() . '/css/bx-slider.css', array(), KLEIN_VERSION );
		
		// WooCommerce Active?
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
		
			// Enqueque WooCommerce Style 
			wp_enqueue_style( 'klein-woocommerce', get_template_directory_uri() . '/css/woocommerce.css', array(), KLEIN_VERSION );
		}
		
		// Presets
		$preset = ot_get_option( 'base_preset', 'default' );
			if( 'default' != $preset )
			{
				wp_enqueue_style( 'klein-preset-layer', get_template_directory_uri() . '/css/presets/'.$preset.'.css', array(), KLEIN_VERSION );
			}
		
		// Visual Composer Support
		if( class_exists( 'WPBakeryVisualComposerSetup' ) )
		{
			wp_enqueue_style( 'klein-visual-composer-layer', get_template_directory_uri() . '/css/visual-composer.css', array( 'js_composer_front' ), KLEIN_VERSION  );
		}
		
		// Dark layout
		$is_dark_layout_enable = ot_get_option( 'dark_layout_enable', false );
			if( is_array( $is_dark_layout_enable ) )
			{
				wp_enqueue_style( 'klein-dark-layout', get_template_directory_uri() . '/css/dark.css', array(), KLEIN_VERSION  );
			}
		
		// Smooth Scroll Support
			// check if smooth scroll is enabled
			$smooth_scroll_enable = ot_get_option( 'smooth_scroll_enable' );
				if( $smooth_scroll_enable ){
					wp_enqueue_script( 'klein-jquery-smoothscroll', get_template_directory_uri() . '/js/jquery.smoothscroll.js', array( 'jquery' ), KLEIN_VERSION, true );
				}
				
		// Respond JS
		wp_enqueue_script( 'klein-html5-shiv', get_template_directory_uri() . '/js/respond.js', '', KLEIN_VERSION, true );
		
		// Modernizer
		wp_enqueue_script( 'klein-modernizr', get_template_directory_uri() . '/js/modernizr.js', array('jquery'), KLEIN_VERSION, true );
		
		// Polyfill on IE (Placeholder)
		wp_enqueue_script( 'klein-placeholder-polyfill', get_template_directory_uri() . '/js/placeholder-polyfill.js', array('jquery'), KLEIN_VERSION, true );

		// BX Slider
		wp_enqueue_script( 'klein-bx-slider', get_template_directory_uri() . '/js/bx-slider.js', array( 'jquery' ), KLEIN_VERSION, true );
		
		// Magnific Popup
		wp_enqueue_script( 'klein-magnific-popup', get_template_directory_uri() . '/js/jquery.magnific.popup.js', array( 'jquery' ), KLEIN_VERSION , true );
		
		// Tooltip
		wp_enqueue_script( 'klein-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.js', array( 'jquery' ), KLEIN_VERSION , true );
		
		// Template JS
		wp_enqueue_script( 'klein', get_template_directory_uri() . '/js/klein.js', array('jquery'), KLEIN_VERSION, true );
		
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) 
	{
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) 
	{
		wp_enqueue_script( 'klein-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), KLEIN_VERSION );
	}
}

add_action( 'wp_enqueue_scripts', 'klein_scripts' );

/**
 * Custom background
 */
if( !function_exists( 'klein_custom_background' ) ){
?>
<?php function klein_custom_background() { ?>
<?php $background = ot_get_option( 'background','' ); ?>
	<?php if( !empty( $background ) ){ ?>
	<?php $attrib = ''; ?>
	<?php foreach( (array)$background as $key => $prop ){ ?>
		<?php if( !empty( $prop ) ){ ?>
			<?php if( 'background-image' == $key ){ ?>
				<?php $attrib .= $key . ':url(' . $prop . ')!important; '; ?>
			<?php }else{ ?>
				<?php $attrib .= $key . ':' . $prop . '!important; '; ?>
			<?php } ?>
		<?php } ?>	
	<?php } ?>
	<style type="text/css">
		body{<?php echo $attrib; ?>}
	</style>
	<?php }// end empty $background ?>
<?php } // end klein_custom_background() ;?>
<?php
} // end custom background function

/**
 * Custom Typography Settings
 */

if( !function_exists( 'klein_custom_typography' ) ){
	function klein_custom_typography(){
		
		$export_ot_settings = array(
			'font-color' => 'color'
		);
		
		// Headings
		$header_typography = ot_get_option( 'header_fonts', '' );
		if( !empty( $header_typography ) ){
			$heading_attrib = '';
			
			foreach( (array) $header_typography as $key => $prop ){
				
				//change the ot key settings to readable
				//css property
				if( array_key_exists( $key, $export_ot_settings ) ){
					$key = $export_ot_settings[$key];
				}
				
				if( !empty( $prop ) ){
					$heading_attrib .= $key . ':' . $prop .'!important;';
				}
			}
		} // !empty $header_typography
		
		// Body
		$body_typography = ot_get_option( 'body_fonts', '' );
		if( !empty( $body_typography ) ){
			$body_attrib = '';
			$export_ot_settings = array(
				'font-color' => 'color'
			);
			foreach( (array) $body_typography as $key => $prop ){
				
				//change the ot key settings to readable
				//css property
				if( array_key_exists( $key, $export_ot_settings ) ){
					$key = $export_ot_settings[$key];
				}
				
				if( !empty( $prop ) ){
					$body_attrib .= $key . ':' . $prop .'!important;';
				}
			}
		} // !empty $body_typography
		?>
		<style type="text/css">
			<?php if( !empty( $heading_attrib ) ){ ?>
				h1,h2,h3,h4,h5,h6{<?php echo $heading_attrib; ?>}
			<?php } ?>
			<?php if( !empty( $body_attrib ) ){ ?>
				body.klein{<?php echo $body_attrib; ?>}
			<?php } ?>
		</style>
		<?php
	}
}

/**
 * Visual Composer CSS Overwrite
 */
 
function klein_css_classes_for_vc_row_and_vc_column($class_string, $tag) {

    if($tag=='vc_row' || $tag=='vc_row_inner') {
        $class_string = str_replace('vc_row-fluid', 'row', $class_string);
    }
    if($tag=='vc_column' || $tag=='vc_column_inner') {
        $class_string = str_replace('vc_span2', 'col-md-2 col-sm-2', $class_string);
        $class_string = str_replace('vc_span3', 'col-md-3 col-sm-3', $class_string);
        $class_string = str_replace('vc_span4', 'col-md-4 col-sm-4', $class_string);
        $class_string = str_replace('vc_span5', 'col-md-5 col-sm-5', $class_string);
        $class_string = str_replace('vc_span6', 'col-md-6 col-sm-6', $class_string);
        $class_string = str_replace('vc_span7', 'col-md-7 col-sm-7', $class_string);
        $class_string = str_replace('vc_span8', 'col-md-8 col-sm-8', $class_string);
        $class_string = str_replace('vc_span9', 'col-md-9 col-sm-9', $class_string);
        $class_string = str_replace('vc_span10', 'col-md-10 col-sm-10', $class_string);
        $class_string = str_replace('vc_span11', 'col-md-11 col-sm-11', $class_string);
        $class_string = str_replace('vc_span12', 'col-md-12 col-sm-12', $class_string);
    }
    return $class_string;
}
// Filter to Replace default css class for vc_row shortcode and vc_column
add_filter('vc_shortcodes_css_class', 'klein_css_classes_for_vc_row_and_vc_column', 10, 2);

/**
 * Theme Customizer File.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';


/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Unlimited Sidebar
 */

require_once get_template_directory() . '/klein/sidebars-action.php';

/**
 * Meta Boxes
 */

load_template( trailingslashit( get_template_directory() ) . 'klein/theme-meta-box.php' );
 
 /**
  * TGM Plugin Activation
  */

require_once get_template_directory(). '/klein/tgm-plugin-activation-index.php';

/**
 * Klein actions
 */

require_once get_template_directory() . '/klein/klein-login.php'; 

/*****************
SHOW RATINGS
******************/
function show_ratings($postID){
global $wpdb;
$pId = $postID; //if using in another page, use the ID of the post/page you want to show ratings for.
$row = $wpdb->get_results("SELECT COUNT(*) AS `total`,AVG(review_rating) AS `aggregate_rating`,MAX(review_rating) AS `max_rating` FROM wp_wpcreviews WHERE `page_id`= $pId AND `status`=1");
$max_rating = $row[0]->max_rating;
$aggregate_rating = $row[0]->aggregate_rating; 
$total_reviews = $row[0]->total;
$totl = $aggregate_rating * 20;
$wpdb->flush();

return '<div class="sp_rating" id="wpcr_respond_1"><div class="base"><div style="width:'.$totl.'%" class="average"></div></div>&nbsp('.$total_reviews.' Reviews)</div>';
}

/*
 * only show 30 days
 */
function wpa57065_filter_where( $where = '' ) {
    // posts in the last 30 days
    $where .= " AND post_date > '" . date('Y-m-d', strtotime('-30 days')) . "'";
    return $where;
}