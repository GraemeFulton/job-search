<h3><?php _e('Enable/Disable Global Filters','acn'); ?></h3>

<table class="form-table">

<?php

	$this->add_plugin_setting( 
	'select',
	'enable_sort',
	__('Enable/Disable Sort Results','acn'),
	array(
		1 => __('Enabled','acn'), 
		0 => __('Disabled','acn')),
	null);

	$this->add_plugin_setting( 
	'select',
	'enable_post_types',
	__('Enable/Disable Post Types','acn'),
	array(
		1 => __('Enabled','acn'), 
		0 => __('Disabled','acn')),
	null);
	
	$this->add_plugin_setting( 
	'select',
	'enable_post_formats',
	__('Enable/Disable Post Formats','acn'),
	array(
		1 => __('Enabled','acn'), 
		0 => __('Disabled','acn')),
	null);
	
?>

</table>

<h3><?php _e('Exclude certain taxonomies','acn'); ?></h3>
<p><?php _e('This allow you to exclude any taxonomy or custom taxonomy from being available in the filters list.','acn'); ?></p>

<table class="form-table">

<?php
	
$this->add_plugin_setting( 
	'multiselect',
	'excluded_taxonomies',
	__('Exclude Taxonomies','acn'),
	'taxonomy_list',
	null);
	
$this->add_plugin_setting( 
	'multiselect',
	'excluded_types',
	__('Exclude Post Types','acn'),
	'posttype_list',
	null);
	
$this->add_plugin_setting( 
	'multiselect',
	'excluded_sort',
	__('Exclude Sort Options','acn'),
	'sort_list',
	null);
	
$this->add_plugin_setting( 
	'multiselect',
	'excluded_formats',
	__('Exclude Post Formats','acn'),
	'format_list',
	null);
	
?>

</table>