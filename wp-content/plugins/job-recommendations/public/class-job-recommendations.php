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
		add_action('job_search_results_loop', array($this, 'search_results_loop'));
		add_action('archive_job_loop', array($this, 'archive_loop'));

		//user profile fields
		add_action('bp_init', array($this,'create_profile_field_group'));

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

	/**
	 * include template file for search results
	 */
	public function search_results_loop(){
		include('views/partials/primary-job-loop.php');
	}

	public function archive_loop(){
		include('views/partials/primary-job-loop.php');

	}

	private function set_user_order_by($args){

		if(isset($_GET['order_by'])){

				$order_by = $_GET['order_by'];

				if($order_by=='latest'){
					$args['orderby']='date';
				 	$args['order']='DESC';
				}
				elseif($order_by == 'closing'){
					$args['date_query']=	 array(
																    'after'     => '31 days ago',  // or '-2 days'
																    'inclusive' => true,
																  );
          $args['orderby']='date';
					$args['order'] = 'ASC';

				}
		}
		return $args;

	}


     public function recommend_jobs(){

     	global $paged, $wp_query;

        //WP_QUERY
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;


        $args= array
       (
           'post_type'=>'graduate-job',
           'paged'=>$paged,
       );


        //add '-jobs' suffix to professions so query by slug works
        if(isset($_COOKIE["profession"])){

					$selected_professions= StripSlashes($_COOKIE["profession"]);
					//unserialize them
					$professions = unserialize($selected_professions);

        //profession
         $args['tax_query'][0]['terms']=$professions;
         $args['tax_query'][0]['taxonomy']='profession';
         $args['tax_query'][0]['field']='slug';

        }

        if(isset($_COOKIE["location"])){
					$selected_locations= StripSlashes($_COOKIE["location"]);
					//unserialize them
					$locations = unserialize($selected_locations);
         //location
         $args['tax_query'][1]['terms']=$locations;
         $args['tax_query'][1]['taxonomy']='location';
         $args['tax_query'][1]['field']='slug';
        }
        //clear tax args if both none set
        $args = $this->clear_tax_args($args);
				$args = $this->set_user_order_by($args);
				if(isset($this->user_order_by)){
					array_merge($args, $this->user_order_by);
				}
        //show 4 results on first page
        if(!is_user_logged_in() && $paged==1){
        	$args['posts_per_page']=4;
        }
        //otherwise show 6
        else $args['posts_per_page']=6;

        $temp = $wp_query;
        $wp_query = null;
        $wp_query = new WP_Query();
        $wp_query->query($args);

        $found = $wp_query->found_posts;


        if( $wp_query->found_posts > 22){
            $message='for';
            require_once 'views/partials/app-bar.php';
            require_once 'views/template-job-recommendations.php';
        }
        else{
                $suggest_more = true;
                $message='for';
                include_once('partials/app-bar.php');
        	require_once 'views/template-job-suggest-more.php';
        }
         //reset query
         $wp_query = null;
  		 $wp_query = $temp;  // Reset

     }

     /**
      * set_profile_preferences
      */
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

     /**
      * Recommend jobs within user profile
      */
     public function profile_recommend_jobs(){
     	global $paged, $wp_query;

     	$this->set_profile_preferences();

        //WP_QUERY
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $args= array
       (
           'post_type'=>'graduate-job',
           'paged'=>$paged
       );


        //add '-jobs' suffix to professions so query by slug works
        if(isset($this->subjects)){

        	$professions_arr = array();
        	foreach ($this->subjects as $subject){
						if(is_array($subject)){

        		foreach($subject as $s){
        			array_push($professions_arr, $this->create_search_param($s, 'profession'));

        		}
						}

        }

        //profession
         $args['tax_query'][0]['terms']=$professions_arr;
         $args['tax_query'][0]['taxonomy']='profession';
         $args['tax_query'][0]['field']='slug';
				 $args['tax_query'][0]['include_children']=0;

        }

        $locations_arr = array();

        if(isset($this->locations)){

        	foreach ($this->locations as $location){
						if(is_array($location)){
        		foreach($location as $l){
        			array_push($locations_arr, $this->create_search_param($l, 'location'));

        		}
					}
        	}

        }
        if(count($locations_arr)>0){
        //location
        $args['tax_query'][1]['terms']=$locations_arr;
        $args['tax_query'][1]['taxonomy']='location';
        $args['tax_query'][1]['field']='slug';
        }

        //clear tax args if both none set
       $args = $this->clear_tax_args($args);

				//order the posts depending on orderby $_GET parameter
			 $args = $this->set_user_order_by($args);

          //show 4 results on first page
        if( $paged==1){
        	$args['posts_per_page']=4;
        }
        //otherwise show 6
        else $args['posts_per_page']=6;

        $temp = $wp_query;
        $wp_query = null;
        $wp_query = new WP_Query();
        $wp_query->query($args);

        $found = $wp_query->found_posts;


        if( $wp_query->found_posts > 30){

            $message='for';
            require_once 'views/partials/app-bar.php';
            require_once 'views/template-job-recommendations.php';
        }
        else{
                 $suggest_more = true;
                $message='for';
                include('views/partials/app-bar.php');
        	require_once 'views/template-job-suggest-more.php';
        }
         //reset query
         $wp_query = null;
  		 $wp_query = $temp;  // Reset


     }


    /**
     * Create slug
     * @param unknown $value
     */
    private function create_slug($value){

     $term = get_term_by( 'name',$value, 'profession' );

     $slug = $term->slug;

   	return $slug;
	}

	/**
	 * Create search param
	 * @param unknown $s
	 * @param unknown $type
	 * @return string
	 */
	private function create_search_param($s, $type){

			$term = get_term_by( 'name',$s, $type );

			$slug = $term->slug;

			return $slug;

	}

	/**
	 * clear tax args
	 */
	private function clear_tax_args($args){
		if(empty($args['tax_query'][0]['terms']) && empty($args['tax_query'][1]['terms'])){
			unset($args['tax_query']);
		}
		return $args;

	}




}
