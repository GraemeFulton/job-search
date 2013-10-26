<table class="form-table">

<?php

$this->add_plugin_setting( 
'textarea', 
'custom_css', 
__('Custom CSS', 'acn'), 
null,
__('Apply custom styles and CSS here to make it compatible with updated versions of the plugin.','acn'));

$this->add_plugin_setting( 'color', 'wrapper_bg_color', __('Container Background Color','acn'), null, null);
$this->add_plugin_setting( 'color', 'item_bg_color', __('Item Background Color','acn'), null, null);
$this->add_plugin_setting( 'color', 'item_shadow_color', __('Item Shadow Color','acn'), null, null);
$this->add_plugin_setting( 'color', 'primary_color', __('Primary Color','acn'), null, null);
$this->add_plugin_setting( 'color', 'nav_link_color', __('Nav Link Color','acn'), null, null);
$this->add_plugin_setting( 'color', 'nav_link_color_hover', __('Nav Link Hover Color','acn'), null, null);
$this->add_plugin_setting( 'color', 'unchecked_color', __('Unchecked Box Color','acn'), null, null);
$this->add_plugin_setting( 'color', 'checked_color', __('Checked Box Color','acn'), null, null);
$this->add_plugin_setting( 'color', 'count_bg_color', __('Count Background Color','acn'), null, null);
$this->add_plugin_setting( 'color', 'count_bg_color_hover', __('Count Background Hover Color','acn'), null, null);
$this->add_plugin_setting( 'color', 'count_color', __('Count Text Color','acn'), null, null);
$this->add_plugin_setting( 'color', 'count_color_hover', __('Count Text Hover Color','acn'), null, null);
$this->add_plugin_setting( 'color', 'primary_link_color', __('Primary Link Color','acn'), null, null);
$this->add_plugin_setting( 'color', 'date_color', __('Date Text Color','acn'), null, null);
$this->add_plugin_setting( 'color', 'tags_bg_color', __('Tags Background Color','acn'), null, null);
$this->add_plugin_setting( 'color', 'author_bg', __('Author Box Background Color','acn'), null, null);
$this->add_plugin_setting( 'color', 'solid_border', __('Solid Border Color','acn'), null, null);
$this->add_plugin_setting( 'color', 'dotted_border', __('Dotted Border Color','acn'), null, null);
$this->add_plugin_setting( 'color', 'nav_bg_color', __('Nav Background Color','acn'), null, null);
$this->add_plugin_setting( 'color', 'zoom_bg_color', __('Zoom Icon Background','acn'), null, null);
$this->add_plugin_setting( 'color', 'zoom_bg_color_hover', __('Zoom Icon Background Hover','acn'), null, null);
$this->add_plugin_setting( 'color', 'zoom_color', __('Zoom Icon Color','acn'), null, null);
$this->add_plugin_setting( 'color', 'ecom_bg_color', __('Woo Background Color','acn'), null, null);

?>

</table>