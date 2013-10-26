<table class="form-table">

<?php

$this->add_plugin_setting( 
	'select',
	'show_count',
	__('Show Item Count in Nav','acn'),
	array(
		1 => __('Yes, show count','acn'), 
		0 => __('No, hide count','acn')),
	null);

$this->add_plugin_setting(
	'input',
	'num_loaded_first_time',
	__('Number of Items Loaded first time','acn'),
	null,
	__('The number of items that get loaded on first time load.','acn'));
	
$this->add_plugin_setting(
	'input',
	'num_loaded_every_time',
	__('Number of Items Loaded on each new scroll','acn'),
	null,
	__('The number of items that get loaded on every scroll the user makes.','acn'));
	
$this->add_plugin_setting(
	'input',
	'num_load_more',
	__('Number of Items Loaded before "Load More Button" is activated','acn'),
	null,
	__('Activates Load More button. Used only when <code>loadmorebutton=yes</code> in your wall shortcode.','acn'));
	
$this->add_plugin_setting(
	'input',
	'distance_before_autoload',
	__('Scroll Threshold','acn'),
	null,
	__('The distance specified in pixels will be required as a distance between scroll position and page bottom in order to attempt to load more content automatically.','acn'));

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
$this->add_plugin_setting( 
	'select',
	'show_wooprice',
	__('Show/Hide WooCommerce Price Filter','acn'),
	array(
		1 => __('Show','acn'), 
		0 => __('Hide','acn')),
	null);
}

$this->add_plugin_setting( 
	'select',
	'show_sliders',
	__('Show/Hide Visual Sliders','acn'),
	array(
		1 => __('Show','acn'), 
		0 => __('Hide','acn')),
	null);
	
$this->add_plugin_setting( 
	'select',
	'show_menu',
	__('Show/Hide Menu/Filters','acn'),
	array(
		1 => __('Show','acn'), 
		0 => __('Hide','acn')),
	null);
	
$this->add_plugin_setting( 
	'select',
	'enable_toggle',
	__('Enable Menu/Filters Toggle','acn'),
	array(
		1 => __('Show','acn'), 
		0 => __('Hide','acn')),
	null);
	
$this->add_plugin_setting( 
	'select',
	'show_author',
	__('Show/Hide Author Box','acn'),
	array(
		1 => __('Show','acn'), 
		0 => __('Hide','acn')),
	null);
	
$this->add_plugin_setting( 
	'select',
	'show_teaser',
	__('Show/Hide Post Teaser','acn'),
	array(
		1 => __('Show','acn'), 
		0 => __('Hide','acn')),
	null);
	
$this->add_plugin_setting( 
	'select',
	'show_title',
	__('Show/Hide Post Title','acn'),
	array(
		1 => __('Show','acn'), 
		0 => __('Hide','acn')),
	null);
	
$this->add_plugin_setting( 
	'select',
	'show_date',
	__('Show/Hide Post Date','acn'),
	array(
		1 => __('Show','acn'), 
		0 => __('Hide','acn')),
	null);
	
$this->add_plugin_setting( 
	'select',
	'show_comments',
	__('Show/Hide Comments Count','acn'),
	array(
		1 => __('Show','acn'), 
		0 => __('Hide','acn')),
	null);
	
$this->add_plugin_setting( 
	'select',
	'show_likes',
	__('Show/Hide Likes','acn'),
	array(
		1 => __('Show','acn'), 
		0 => __('Hide','acn')),
	null);
	
$this->add_plugin_setting( 
	'select',
	'show_perma_icon',
	__('Show/Hide Permalink Icon','acn'),
	array(
		1 => __('Show','acn'), 
		0 => __('Hide','acn')),
	null);
	
$this->add_plugin_setting( 
	'select',
	'show_social',
	__('Show/Hide Social Bar','acn'),
	array(
		1 => __('Show','acn'), 
		0 => __('Hide','acn')),
	null);
	
?>

</table>