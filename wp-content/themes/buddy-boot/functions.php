<?php
	/*-----------------------------------------------------------------------------------*/
	/* This file will be referenced every time a template/page loads on your Wordpress site
	/* This is the place to define custom fxns and specialty code
	/*-----------------------------------------------------------------------------------*/

// Define the version so we can easily replace it throughout the theme
define( 'CB', 1.0 );

/*-----------------------------------------------------------------------------------*/
/* Add Rss feed support to Head section
/*-----------------------------------------------------------------------------------*/
add_theme_support( 'automatic-feed-links' );

/**WOOCOMMERCE THEME SUPPORT**/
add_theme_support( 'woocommerce' );

/*-----------------------------------------------------------------------------------*/
/* Register main menu for Wordpress use
/*-----------------------------------------------------------------------------------*/
register_nav_menus(
	array(
		'primary'	=>	__( 'Primary Menu', 'naked' ), // Register the Primary menu
		// Copy and paste the line above right here if you want to make another menu,
		// just change the 'primary' to another name
	)
);

/*-----------------------------------------------------------------------------------*/
/* Activate sidebar for Wordpress use
/*-----------------------------------------------------------------------------------*/
function clean_bootstrap_register_sidebars() {
	register_sidebar(array(				// Start a series of sidebars to register
		'id' => 'sidebar', 					// Make an ID
		'name' => 'Sidebar',				// Name it
		'description' => 'Take it on the side...', // Dumb description for the admin side
		'before_widget' => '<div>',	// What to display before each widget
		'after_widget' => '</div>',	// What to display following each widget
		'before_title' => '<h3 class="side-title">',	// What to display before each widget's title
		'after_title' => '</h3>',		// What to display following each widget's title
		'empty_title'=> '',					// What to display in the case of no title defined for a widget
		// Copy and paste the lines above right here if you want to make another sidebar,
		// just change the values of id and name to another word/name
	));
}
// adding sidebars to Wordpress (these are created in functions.php)
add_action( 'widgets_init', 'clean_bootstrap_register_sidebars' );

/*-----------------------------------------------------------------------------------*/
/* Enqueue Styles and Scripts
/*-----------------------------------------------------------------------------------*/
add_action('init', 'no_more_jquery');
function no_more_jquery(){
    wp_deregister_script('jquery');
    wp_register_script('jquery', get_template_directory_uri()."/js/jquery.min.js", false, null);
}
function LG_bootstrap_scripts()  {


        //bootstrap css
        wp_enqueue_style( 'LG-bootstrap',  get_template_directory_uri() . '/css/bootstrap.min.css' );

        //fontawesome
        wp_enqueue_style( 'LG-fontawesome', get_template_directory_uri() . '/css/font-awesome/css/font-awesome.min.css' );
        wp_enqueue_script('jquery');

        //bootstrap js
        wp_enqueue_script( 'LG-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js' );

        //RAPHAEL
        wp_enqueue_script( 'raphael', get_template_directory_uri() . '/js/raphael.min.js' );

        //materialize
        wp_enqueue_style( 'materialize-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons' );
         wp_enqueue_style( 'materialize-roboto', get_template_directory_uri() . '/css/dist/css/roboto.min.css' );
         wp_enqueue_style( 'materialize-fullpalette', get_template_directory_uri() . '/css/dist/css/material-fullpalette.min.css' );
         wp_enqueue_style( 'materialize-ripples', get_template_directory_uri() . '/css/dist/css/ripples.min.css' );


        // wp_enqueue_style( 'materialize', get_template_directory_uri() . '/css/dist/css/material.min.css' );

         wp_enqueue_script( 'materialize-ripples', get_template_directory_uri() . '/css/dist/js/ripples.min.js' );
         wp_enqueue_script( 'materialize', get_template_directory_uri() . '/css/dist/js/material.min.js' );

    // get the theme directory style.css and link to it in the header
        wp_enqueue_style( 'LG-style', get_template_directory_uri() . '/style.css', '10000', 'all' );

				//main js
				wp_enqueue_script( 'main', get_template_directory_uri() . '/js/main.js' );


}
add_action( 'wp_enqueue_scripts', 'LG_bootstrap_scripts' ); // Register this fxn and allow Wordpress to call it automatcally in the header




/**
 * Store cookies for user registration
 */
add_action('init', function() {
	// yes, this is a PHP 5.3 closure, deal with it

    //couldn't set cookies because you need to serialize the array first!
		if(isset($_GET['Profession'])){
			setcookie("profession", serialize($_GET['Profession']), time()+3600 , '/' );
		}
		if(isset($_GET['Location'])){
			setcookie("location", serialize($_GET['Location']), time()+3600 , '/' );
		}
});

/**
 * after user registers, insert the extra profile fields from cookies
 */
add_action( 'wpuf_after_register', 'myplugin_registration_save', 10, 1 );

function myplugin_registration_save(  $user_id, $userdata, $form_id, $form_settings ) {

     //@TODO: filter cookies before inserting into db

		 $selected_professions= StripSlashes($_COOKIE["profession"]);
 		//unserialize them
 		$professions = unserialize($selected_professions);


 		foreach ($professions as $profession){

 				$parent_term = get_term_by('slug', $profession, 'profession');
 				$parent_field_id = xprofile_get_field_id_from_name($parent_term->name);
 				//computing = 561
 				$child_terms = get_term_children( $parent_term->term_id, 'profession' );
 				$options_selected = [$parent_term->name];
 				foreach($child_terms as $child_term){
 					$child_term= get_term_by('id', $child_term, 'profession');
 					array_push($options_selected, $child_term->name);
 				}
 				//xprofile_set_field_data must take an array
 				//we're only ever dealing with one category per checkbox group,e.g. ['Computing'])
 			xprofile_set_field_data($parent_field_id,$user_id,$options_selected);
 		}

     $selected_locations= StripSlashes($_COOKIE["location"]);
    //unserialize them
    $locations = unserialize($selected_locations);


    foreach ($locations as $location){

        $field_id = xprofile_get_field_id_from_name($location);

        //xprofile_set_field_data must take an array
        //we're only ever dealing with one category per checkbox group,e.g. ['Computing'])
        xprofile_set_field_data($field_id, $user_id,[$location]);
    }

}
    function check_active_link($link){

			if(strpos($_SERVER['REQUEST_URI'],'members')&& strpos($_SERVER['REQUEST_URI'],'?s')){
				return $active=2;
			}
        //if job page
         if(strpos($link,'job') !== false){
             if(strpos($_SERVER['REQUEST_URI'],'company')||strpos($_SERVER['REQUEST_URI'],'job-roll')||strpos($_SERVER['REQUEST_URI'],'graduate-job')||strpos($_SERVER['REQUEST_URI'],'?s=')||strpos($_SERVER['REQUEST_URI'],'profession') ){

                 return $active = 1;
             }
             elseif(strpos($_SERVER['REQUEST_URI'],'sign-up')){
                 return $active = 1;
             }
         }
         //if profile page
         if((strpos($link,'members') !== false)&& (strpos($link,'edit')== false) && (strpos($link,'setting')== false)){
             if(strpos($_SERVER['REQUEST_URI'],'profile')||strpos($_SERVER['REQUEST_URI'],'members') ){
                return $active = 1;
             }

         }

				 //profile edit link
				 if(strpos($link,'edit') !== false){
						 if(strpos($_SERVER['REQUEST_URI'],'edit') ){
								return $active = 1;
						 }

				 }
				 //settings profile link	 //profile edit link
	 				 if(strpos($link,'settings') !== false){
	 						 if(strpos($_SERVER['REQUEST_URI'],'settings') ){
	 								return $active = 1;
	 						 }

	 				 }
          //if profile page
         if(strpos($link,'register') !== false){
             if(strpos($_SERVER['REQUEST_URI'],'register') ){
                return $active = 1;
             }

         }
         else
         return $active = 2;
    }
		/**
		*Function for returning profession name
		*/
		function get_profession_name($name){
		  if($name=='Business &amp; Management'){
		    return $name = 'Business';
		  }
			return $name;
		}


		/**
		*custom filter
		**/
	//	add_filter('posts_orderby','my_sort_custom',10,2);
		function my_sort_custom( $orderby, $query ){
				if(isset($_GET['order_by'])){
					if($_GET['order_by']=='closing'){
						global $wpdb;

						if(is_search()){
								$orderby =  $wpdb->prefix."posts.post_type DESC, {$wpdb->prefix}posts.post_date DESC";
							}
					}

				}
		    return  $orderby;
		}

		function filter_where($where = '') {
				if(is_search() || is_archive()){
					//posts in the last 14 days
					if(isset($_GET['order_by'])){
						if($_GET['order_by']=='closing'){
							$where .= " AND post_date > '" . date('Y-m-d', strtotime('-31 days')) . "'";
						}
						return $where;
					}
			}
			return $where;
		}
		add_filter('posts_where', 'filter_where');


		/**WORDPRESS LOGIN PAGE**/
		//https://codex.wordpress.org/Customizing_the_Login_Form
		function restrict_admin()
	{
		if ( ! current_user_can( 'manage_options' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
	                wp_redirect( site_url() );
		}
	}
	add_action( 'admin_init', 'restrict_admin', 1 );
?>
