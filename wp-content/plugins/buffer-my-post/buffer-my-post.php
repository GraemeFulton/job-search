<?php   
#     /* 
#     Plugin Name: Buffer My Post
#     Plugin URI: http://www.ajaymatharu.com/buffer-my-posts/
#     Description: This plugin helps you to keeps your old posts alive by posting it to buffer and driving more traffic to them from various social sites suppoerted by buffer. It also helps you to promote your content. You can set time and no of posts to post to drive more traffic. For questions, comments, or feature requests, contact me! <a href="http://www.ajaymatharu.com/">Ajay Matharu</a> you can follow me twitter at <a href="http://twitter.com/matharuajay/">@matharuajay</a>.
#     Author: Ajay Matharu 
#     Version: 14.1.14.2
#     Author URI: http://www.ajaymatharu.com/
#     */  
 

require_once('bmp-admin.php');
require_once('bmp-core.php');
require_once('bmp-excludepost.php');

define ('bmp_opt_1_HOUR', 60*60);
define ('bmp_opt_2_HOURS', 2*bmp_opt_1_HOUR);
define ('bmp_opt_4_HOURS', 4*bmp_opt_1_HOUR);
define ('bmp_opt_8_HOURS', 8*bmp_opt_1_HOUR);
define ('bmp_opt_6_HOURS', 6*bmp_opt_1_HOUR); 
define ('bmp_opt_12_HOURS', 12*bmp_opt_1_HOUR); 
define ('bmp_opt_24_HOURS', 24*bmp_opt_1_HOUR); 
define ('bmp_opt_48_HOURS', 48*bmp_opt_1_HOUR); 
define ('bmp_opt_72_HOURS', 72*bmp_opt_1_HOUR); 
define ('bmp_opt_168_HOURS', 168*bmp_opt_1_HOUR); 
define ('bmp_opt_INTERVAL', 4);
define ('bmp_opt_AGE_LIMIT', 30); // 120 days
define ('bmp_opt_MAX_AGE_LIMIT', 60); // 120 days
define ('bmp_opt_OMIT_CATS', "");
define('bmp_opt_HASHTAGS',"");
define('bmp_opt_no_of_post',"1");
define('bmp_opt_post_type',"post");


   function bmp_admin_actions() {  
        add_menu_page("Buffer My Post", "Buffer My Post", 1, "BufferMyPost", "bmp_admin");
        add_submenu_page("BufferMyPost", __('Exclude Posts','BufferMyPost'), __('Exclude Posts','BufferMyPost'), 1, __('BMPExcludePosts','BufferMyPost'), 'bmp_exclude');
		
    }  
    
  	add_action('admin_menu', 'bmp_admin_actions');  
	add_action('admin_head', 'bmp_opt_head_admin');
 	add_action('init','bmp_buffer_my_post');
       
        
       
        
add_filter('plugin_action_links', 'bmp_plugin_action_links', 10, 2);

function bmp_plugin_action_links($links, $file) {
    static $this_plugin;

    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }

    if ($file == $this_plugin) {
        // The "page" query string value must be equal to the slug
        // of the Settings admin page we defined earlier, which in
        // this case equals "myplugin-settings".
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=BufferMyPost">Settings</a>';
        array_unshift($links, $settings_link);
    }

    return $links;
}

?>