<?php
/*
Plugin Name: Ajax Content Navigator
Plugin URI: http://codecanyon.net/item/ajax-content-browser-for-wordpress/3974652?ref=ThemeFluent
Description: An infinite, super-nice content browser with social features.
Version: 1.4.8
Author: ThemeFluent
Author URI: http://themeforest.net/user/ThemeFluent?ref=ThemeFluent
*/

define('acn_url',plugin_dir_url(__FILE__ ));
define('acn_path',plugin_dir_path(__FILE__ ));

	/* Includes */
	require_once(acn_path . 'includes/class-acn.php');
	require_once(acn_path . 'includes/shortcodes.php');
	require_once(acn_path . 'includes/widgets.php');
	require_once(acn_path . 'includes/hooks.php');
	require_once(acn_path . 'skins/builtin-skins.php');
	require_once(acn_path . 'taxonomies.php');
	
	/* Admin panel */	
	if (is_admin()) {

		require_once(acn_path . 'admin/class-admin-panel.php');
		require_once(acn_path . 'admin/admin-icons.php');
	
	}
	
	/* Add styling */
	add_action('wp_footer', 'acn_dynamic_css');
	function acn_dynamic_css() {

		global $acn;
		if ($acn->shortcode_run == true) {
				
		$theme = $acn->load_skin();
		
		$options = get_option('acn_options');
		foreach($theme as $k=>$v) {
			if (isset($options[$k])) {
				$theme[$k] = $options[$k];
			} else {
				$theme[$k] = $v;
			}
		}
		
		extract($theme);

		printf('<style type="text/css">
		
			div.acn-wrap {
				background-color: %1$s;
			}
			
			.acn-content ul li {
				box-shadow: 0 1px 2px -1px %3$s;
			    -webkit-box-shadow: 0 1px 2px -1px %3$s;
				-moz-box-shadow: 0 1px 2px -1px %3$s;
				-ms-box-shadow: 0 1px 2px -1px %3$s;
				-o-box-shadow: 0 1px 2px -1px %3$s;
				background: %2$s;
			}
			
			div.acn-navi,
			div.acn-sec {
				box-shadow: 0 1px 2px -1px %3$s;
			    -webkit-box-shadow: 0 1px 2px -1px %3$s;
				-moz-box-shadow: 0 1px 2px -1px %3$s;
				-ms-box-shadow: 0 1px 2px -1px %3$s;
				-o-box-shadow: 0 1px 2px -1px %3$s;
				background-color: %22$s;
			}
			
			.acn-wrap-sidebar-yes .acn-content a:hover,
			.acn-wrap-sidebar-yes a.acn-fav-button.acn-fav-button-done,
			.acn-content a:hover, a.acn-full-image:hover, a.acn-fav-button.acn-fav-button-done, .acn-content a.acn-full-image:hover,
			.acn-ecom ins,
			.acn-posts-slider-amount,
			.acn-dposts-slider-amount {
				color: %4$s;
			}
			
			div.acn-navi a {
				color: %5$s;
			}

			.acn-wrap-sidebar-yes .acn-navi a:hover,
			div.acn-navi a:hover, div.acn-navi a.acn-highlighted {
				color: %6$s;
			}
			
			div.acn-navi a i {
				color: %7$s;
			}

			div.acn-navi a i.icon-check {
				color: %8$s;
			}
			
			div.acn-navi li a span {
				background: %9$s;
				color: %10$s;
			}

			div.acn-navi a:hover span {
				background: %11$s;
				color: %12$s;
			}
			
			.acn-wrap-sidebar-yes .acn-content a,
			.acn-content a {
				color: %13$s;
			}
			
			.acn-date,
			.acn-ecom del {
				color: %14$s;
			}
			
			.acn-content a.acn-full-image {
				background: %15$s;
				color: %16$s;
			}

			.acn-content a.acn-full-image:hover {
				background: %17$s;
			}
			
			.acn-tags {
				background-color: %18$s;
			}
						
			.acn-content .acn-author img {
				background-color: %19$s;
			}
			
			.acn-meta, .acn-excerpt, .acn-shortcuts, .acn-ecom {
				border-top: 1px solid %20$s;
			}
			
			div.acn-navi h3, div.acn-navi div, .acn-header {
				border-bottom: 1px dotted %21$s;
			}
			
			div.acn-toggle {
				background-color: %1$s;
			}
			
			.acn-ecom {
				background-color: %23$s;
			}

		</style>',
		$wrapper_bg_color,
		$item_bg_color,
		$item_shadow_color,
		$primary_color,
		$nav_link_color,
		$nav_link_color_hover,
		$unchecked_color,
		$checked_color,
		$count_bg_color,
		$count_color,
		$count_bg_color_hover,
		$count_color_hover,
		$primary_link_color,
		$date_color,
		$zoom_bg_color,
		$zoom_color,
		$zoom_bg_color_hover,
		$tags_bg_color,
		$author_bg,
		$solid_border,
		$dotted_border,
		$nav_bg_color,
		$ecom_bg_color);
		
	print "<style type='text/css'>
			.sharrre .box{
			background:#444;
			background:-webkit-gradient(linear,left top,left bottom,color-stop(#444,0),color-stop(#222,1));
			background:-webkit-linear-gradient(top, #444 0%, #222 100%);
			background:-moz-linear-gradient(top, #444 0%, #222 100%);
			background:-o-linear-gradient(top, #444 0%, #222 100%);
			background:linear-gradient(top, #444 0%, #222 100%);
			filter:progid:DXImageTransform.Microsoft.gradient( startColorstr='#444', endColorstr='#222',GradientType=0 );
			height:22px;
			display:inline-block;
			position:relative;
			padding:0px 45px 0 8px;
			-webkit-border-radius:3px;
			-moz-border-radius:3px;
			border-radius:3px;
			font-size:12px;
			float:left;
			clear:both;
			overflow:hidden;
			-webkit-transition:all 0.3s linear;
			-moz-transition:all 0.3s linear;
			-o-transition:all 0.3s linear;
			transition:all 0.3s linear;
			-webkit-box-shadow:0 1px 1px #666;
			-moz-box-shadow:0 1px 1px #666;
			box-shadow:0 1px 1px #666;
			}
			.sharrre .left{
			line-height:22px;
			display:block;
			white-space:nowrap;
			text-shadow:0px 1px 1px rgba(255,255,255,0.3);
			color:#ffffff;
			-webkit-transition:all 0.2s linear;
			-moz-transition:all 0.2s linear;
			-o-transition:all 0.2s linear;
			transition:all 0.2s linear;
			}
			.sharrre .middle{
			position:absolute;
			height:22px;
			top:0px;
			right:30px;
			width:0px;
			background:#666;
			text-shadow:0px -1px 1px #363f49;
			color:#fff;
			white-space:nowrap;
			text-align:left;
			overflow:hidden;
			-webkit-box-shadow:-1px 0px 1px rgba(255,255,255,0.4), 1px 1px 2px rgba(0,0,0,0.2) inset;
			-moz-box-shadow:-1px 0px 1px rgba(255,255,255,0.4), 1px 1px 2px rgba(0,0,0,0.2) inset;
			box-shadow:-1px 0px 1px rgba(255,255,255,0.4), 1px 1px 2px rgba(0,0,0,0.2) inset;
			-webkit-transition:width 0.3s linear;
			-moz-transition:width 0.3s linear;
			-o-transition:width 0.3s linear;
			transition:width 0.3s linear;
			}
			.sharrre .middle a{
			color:#fff;
			font-weight:bold;
			padding:0 5px 0 5px;
			text-align:center;
			float:left;
			line-height:22px;
			-webkit-box-shadow:-1px 0px 1px rgba(255,255,255,0.4), 1px 1px 2px rgba(0,0,0,0.2) inset;
			-moz-box-shadow:-1px 0px 1px rgba(255,255,255,0.4), 1px 1px 2px rgba(0,0,0,0.2) inset;
			box-shadow:-1px 0px 1px rgba(255,255,255,0.4), 1px 1px 2px rgba(0,0,0,0.2) inset;
			}
			.sharrre .right{
			position:absolute;
			right:0px;
			top:0px;
			height:100%;
			width:35px;
			text-align:center;
			line-height:22px;
			color:#4b5d61;
			background:#fff;
			}
			.sharrre .box:hover{
			padding-right:120px;
			}
			.sharrre .middle a:hover{
			text-decoration:none;
			background: #ff0067;
			}
			.sharrre .box:hover .middle{
			width:80px;
			}
			
			</style>";
			
		if ($acn->get_option('custom_css') !== '') {
			print '<style type="text/css">'.$acn->get_option('custom_css').'</style>';
		}
		
		}
			
	}
	
	/* Footer */
	add_action('wp_footer', 'acn_content_viewer');
	function acn_content_viewer() {
		require_once(acn_path . 'includes/acn-content-viewer.php');
	}
	
	/* Load plugin text domain (localization) */
	add_action('init', 'acn_load_textdomain');
	function acn_load_textdomain() {
		load_plugin_textdomain( 'acn', false,'/ajax-content-navigator/l10n');
	}
	
	/* Fixes order by meta_value_num / meta_key count */
	function acn_fix_orderby_metavalue() {
		global $wpdb;
		return "$wpdb->postmeta.meta_value+0 DESC, wp_posts.ID DESC";
	}