<h3><?php _e('Activate Grid System','acn'); ?></h3>
<p><?php _e('This plugin uses Masonry layout by default, so It deals with variable height content, images and boxes out of the box. These settings however let you switch off Masonry layout and use Grid layout instead which will make all your content boxes equal in height.','acn'); ?></p>

<table class="form-table">

<?php
	
$this->add_plugin_setting( 
	'select',
	'grid',
	__('Enable Grid','acn'),
	array(
		1 => __('Yes','acn'), 
		0 => __('No','acn')),
	null);
	
$this->add_plugin_setting( 
	'select',
	'grid_ecommerce',
	__('Show/Hide eCommerce Bar','acn'),
	array(
		1 => __('Yes','acn'), 
		0 => __('No','acn')),
	__('This bar displays the product price and buy button If you are showcasing products using WooCommerce integration for example.','acn'));
	
?>

</table>