<?php

	/* admin icons for the plugin */
	add_action('admin_head',  'acn_admin_icon');
	function acn_admin_icon(){
		$screen = get_current_screen();
		if( !strstr($screen->id, 'wp-acn') )
			return;

		$image_url = acn_url.'admin/images/icon-32.png';
		echo "<style>
		#icon-wp-acn {
			background: transparent url( '{$image_url }' ) no-repeat;
		}
		</style>";
	}