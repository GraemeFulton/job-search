<?php
/**
 * The template for displaying search forms in klein
 *
 * @package klein
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	
	<input type="text" class="search-field" placeholder="<?php echo esc_attr_x( 'To search type and hit enter', 'klein' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="<?php _ex( 'Search for:', 'label', 'klein' ); ?>">
	
</form>
