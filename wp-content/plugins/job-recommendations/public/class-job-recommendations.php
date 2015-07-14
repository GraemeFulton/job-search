<?php
/**
 * .
 *
 * @package   Job Recommendations
 * @author    Graeme Fulton <graeme@lostgrad.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-plugin-name-admin.php`
 *
 * @TODO: Rename this class to a proper name for your plugin.
 *
 * @package Job_Recommendations
 * @author  Your Name <email@example.com>
 */
class Job_Recommendations{

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.0.0';

	protected $plugin_slug = 'job-recommendations';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	protected $subjects;
	protected $locations;
	
	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
                
                //custom action
                add_action('job_recommendation_loop', array($this,'recommend_jobs'));
                add_action('profile_job_recommendation_loop', array($this,'profile_recommend_jobs'));
                
                //user profile fields
//                add_action( 'show_user_profile', array($this,'user_interests_fields') );
//                add_action( 'edit_user_profile', array($this,'user_interests_fields') );
                add_action('bp_init', array($this,'create_profile_field_group'));
                
            //    add_action('bp_after_profile_field_content', array($this, 'profession_list'));

	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/public.css', __FILE__ ), array(), self::VERSION );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
            
                wp_enqueue_script('job_recommendations', plugins_url('/assets/js/public.js', __FILE__), array('jquery'), '1.0', true );
                
                //localize the script
                wp_localize_script('job_recommendations', 'ajax_var', array(
                    'url' => admin_url('admin-ajax.php'),
                    'nonce' => wp_create_nonce('ajax-nonce')
                ));
                 
	}
        
        
     public function recommend_jobs(){
            

        //WP_QUERY
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        if(!is_user_logged_in() && $paged==1){
            $posts_per_page='4';
        }
        else ($posts_per_page='6');
        
        $args= array
       (
           'post_type'=>'graduate-job',
           'paged'=>$paged,
           'posts_per_page'=>$posts_per_page,
       );


        //add '-jobs' suffix to professions so query by slug works
        if(isset($_GET['Profession'])){
            
            $_COOKIE['Profession']= $_GET['Profession'];
        
         array_walk($_GET['Profession'], function(&$value, $key) {  $value =$this->create_slug($value); });
        //profession
         $args['tax_query'][0]['terms']=$_GET['Profession'];
         $args['tax_query'][0]['taxonomy']='profession';
         $args['tax_query'][0]['field']='slug';
        }

        if(isset($_GET['Location'])){

            $_COOKIE['Location']= $_GET['Location'];

         //location
         $args['tax_query'][1]['terms']=$_GET['Location'];
         $args['tax_query'][1]['taxonomy']='location';
         $args['tax_query'][1]['field']='slug';  
        }
         $qp= query_posts($args);

         require_once 'views/template-job-recommendations.php';
         //set cookies using js

         wp_reset_query();
                  
     }
     
     
     private function set_profile_preferences(){
     	
     	$user_ID = get_current_user_id();
     	
     	$parent_id= xprofile_get_field_id_from_name('Profession');
     	global $bp;
     	global $wpdb;
     	
     	
     	$args = array(
     			'taxonomy'      => 'profession',
     			'parent'        => 0, // get top level categories
     			'orderby'       => 'name',
     			'order'         => 'ASC',
     			'hierarchical'  => 1,
     			'pad_counts'    => 0
     	);
     	
     	$categories = get_categories( $args );
     	
     	$subjects=array();
     	foreach ( $categories as $category ){
     		array_push($subjects, xprofile_get_field_data($category->name, $user_ID));
     	}
     	
     	$this->subjects = $subjects;
     	
     	$args = array(
     			'taxonomy'      => 'location',
     			'child_of'        => 292, // make sure they're a child of united kingdon
     			'orderby'       => 'name',
     			'order'         => 'ASC',
     			'hierarchical'  => 1,
     			'pad_counts'    => 0
     	);
     		
     		
     	
     	$categories = get_categories( $args );
     	$locations = array();
     	foreach ( $categories as $category ){
     		 
     		$sub_args = array(
     				'taxonomy'      => 'location',
     				'parent'        => $category->term_id, // get child categories
     				'orderby'       => 'name',
     				'order'         => 'ASC',
     				'hierarchical'  => 1
     		);
     		$sub_categories = get_categories( $sub_args );
     		array_push($locations, xprofile_get_field_data($category->name, $user_ID));
     	
     	}
     	$this->locations = $locations;
     	
     }
     
     public function profile_recommend_jobs(){
         
     	$this->set_profile_preferences();
         
        //WP_QUERY
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        if(is_user_logged_in() && $paged==1){
            $posts_per_page='4';
        }
        else ($posts_per_page='6');
        
        $args= array
       (
           'post_type'=>'graduate-job',
           'paged'=>$paged,
           'posts_per_page'=>$posts_per_page,
       );


        //add '-jobs' suffix to professions so query by slug works
        if(isset($this->subjects)){
        	
        	$professions_arr = array();
        	foreach ($this->subjects as $subject){
        		foreach($subject as $s){
        			array_push($professions_arr, strtolower($s.'-jobs'));
        			
        		}
        		
        			
        }
		
        //profession
         $args['tax_query'][0]['terms']=$professions_arr;
         $args['tax_query'][0]['taxonomy']='profession';
         $args['tax_query'][0]['field']='slug';
        }

        if(isset($this->locations)){
        	
        	$locations_arr = array();
        	foreach ($this->locations as $location){
        		foreach($location as $l){
        			array_push($locations_arr, strtolower($l));
        			 
        		}
        	}
        

         //location
         $args['tax_query'][1]['terms']=$locations_arr;
         $args['tax_query'][1]['taxonomy']='location';
         $args['tax_query'][1]['field']='slug';  
        }
         $qp= query_posts($args);

         require_once 'views/template-job-recommendations.php';
         //set cookies using js

         wp_reset_query();
         
         
     }
    
     
        
    private function create_slug($value){
    
    if($value=='Finance'){
       $value='accounting';
    }
     
    return $value .= '-jobs';
}
        
  
 

}
