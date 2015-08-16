<?php
/**
* Template: Sidebar.php
*
* @package EvoLve
* @subpackage Template
*/
$evolve_layout = evolve_get_option('evl_layout','2cl');
?>
<!--BEGIN #secondary .aside-->
<div id="secondary" class="aside <?php if (($evolve_layout == "1c")) {} if (($evolve_layout == "3cm" || $evolve_layout == "3cl" || $evolve_layout == "3cr")) {echo 'col-xs-12 col-sm-6 col-md-3';} else {echo 'col-sm-6 col-md-4';} ?>">
	<?php /* Widgetized Area */
		if ( !dynamic_sidebar( 'sidebar-1' )) : ?>
	<?php endif; /* (!function_exists('dynamic_sidebar') */ ?>
</div><!--END #secondary .aside-->