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

    //grab the professions the user has selected from the cookies
    $selected_professions= StripSlashes($_COOKIE["profession"]);
    //unserialize them
    $professions = unserialize($selected_professions);


    foreach ($professions as $profession){

        $field_id = xprofile_get_field_id_from_name($profession);

        //xprofile_set_field_data must take an array
        //we're only ever dealing with one category per checkbox group,e.g. ['Computing'])
        xprofile_set_field_data($field_id, $user_id,[$profession]);
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
        //if job page
         if(strpos($link,'job') !== false){
             if(strpos($_SERVER['REQUEST_URI'],'company')||strpos($_SERVER['REQUEST_URI'],'job-roll') ){

                 return $active = 'active';
             }
             elseif(strpos($_SERVER['REQUEST_URI'],'sign-up')){
                 return $active = 'active';
             }
         }
         //if profile page
         if((strpos($link,'members') !== false)&& (strpos($link,'edit')== false) && (strpos($link,'setting')== false)){
             if(strpos($_SERVER['REQUEST_URI'],'profile')||strpos($_SERVER['REQUEST_URI'],'members') ){
                return $active = 'active';
             }

         }

				 //profile edit link
				 if(strpos($link,'edit') !== false){
						 if(strpos($_SERVER['REQUEST_URI'],'edit') ){
								return $active = 'active';
						 }

				 }
				 //settings profile link	 //profile edit link
	 				 if(strpos($link,'settings') !== false){
	 						 if(strpos($_SERVER['REQUEST_URI'],'settings') ){
	 								return $active = 'active';
	 						 }

	 				 }
          //if profile page
         if(strpos($link,'register') !== false){
             if(strpos($_SERVER['REQUEST_URI'],'register') ){
                return $active = 'active';
             }

         }
         else
         return $active = '';
    }

?>
