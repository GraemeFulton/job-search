<?php

if (!defined('WP_UNINSTALL_PLUGIN'))
	exit();

delete_option('scrollup_text');
delete_option('scrollup_type');
delete_option('scrollup_show');
delete_option('scrollup_position');
delete_option('scrollup_distance');
delete_option('scrollup_animation');
delete_option('scrollup_attr');

?>