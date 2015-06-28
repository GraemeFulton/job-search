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
       // wp_enqueue_style( 'LG-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
        wp_enqueue_style( 'LG-bootstrap',  get_template_directory_uri() . '/css/bootstrap.min.css' );
        
        //fontawesome
        wp_enqueue_style( 'LG-fontawesome', get_template_directory_uri() . '/css/font-awesome/css/font-awesome.min.css' );

        
	// get the theme directory style.css and link to it in the header
		wp_enqueue_style( 'LG-style', get_template_directory_uri() . '/style.css', '10000', 'all' );
        wp_enqueue_script('jquery');

        //bootstrap js
        wp_enqueue_script( 'LG-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js' );

        //RAPHAEL
        wp_enqueue_script( 'raphael', get_template_directory_uri() . '/js/raphael.min.js' );

        
        //bootstrap multi-select
        wp_enqueue_style( 'multi-select',  get_template_directory_uri() . '/libs/bootstrap-multiselect/css/bootstrap-multiselect.css' );
        wp_enqueue_script( 'mult-select-js', get_template_directory_uri() . '/libs/bootstrap-multiselect/js/bootstrap-multiselect.js' );
        //select2
        wp_enqueue_style( 'select2-css',  get_template_directory_uri() . '/libs/select2/select2.css' );
        wp_enqueue_style( 'select2-bootstrap-css',  get_template_directory_uri() . '/libs/select2/select2bootstrap.css' );
        wp_enqueue_script( 'select2-js', get_template_directory_uri() . '/libs/select2/select2.min.js' );

  
}
add_action( 'wp_enqueue_scripts', 'LG_bootstrap_scripts' ); // Register this fxn and allow Wordpress to call it automatcally in the header


//on registration we need to store the user's preferences as x-profile-fields
function LG_save_preferences($ID) {

    if($ID=NULL){
    global $current_user;
    get_currentuserinfo();
    $ID= $current_user->id;
    }
    
    $Location = $_SESSION['Location'];

    xprofile_set_field_data('Location', $current_user->id,  $Location);

}
add_action( 'user_register', 'LG_save_preferences' ); // Register this fxn and allow Wordpress to call it automatcally in the header


function LG_hi(){
    echo '<script>alert("hi"); console.log($.cookie("Location"));</script>';
}
add_shortcode('sessionvars', 'LG_hi');
