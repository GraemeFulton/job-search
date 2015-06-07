<?php
/**
 * Job Recommendations.
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
                
                add_action('bp_after_profile_field_content', array($this, 'profession_list'));

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

        if($paged==1){
            $posts_per_page='4';
        }
        else ($posts_per_page='8');
        
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
     
     
     public function profile_jobs(){
         
         
        //WP_QUERY
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        if($paged==1){
            $posts_per_page='4';
        }
        else ($posts_per_page='8');
        
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
     
     public function create_profile_field_group(){
       
         $this->create_group('Search Preferences');
         
             
     }
     
     
     private function create_group($group_name){
               global $wpdb;
            $group_args = array(
                'name' => $group_name
                );
            $sqlStr = "SELECT `id` FROM `wp_bp_xprofile_groups` WHERE `name` = '$group_name'";
            $groups = $wpdb->get_results($sqlStr);
            if(count($groups) > 0)
            {
                // The group exist so we exit the function
                return;
            }
            // The group does not exist so we create is
            $group_id = xprofile_insert_field_group( $group_args );
                                
            $this->add_options($group_id, 'Professions', 'profession');
            $this->add_options_only_parents($group_id, 'Location', 'location');
         
     }
     
     private function add_options($group_id, $field_group_name, $taxonomy){
        $parent_id= xprofile_get_field_id_from_name($field_group_name);      
          global $bp;
              global $wpdb;
        
        
                    $args = array(
               'taxonomy'      => $taxonomy,
               'parent'        => 0, // get top level categories
               'orderby'       => 'name',
               'order'         => 'ASC',
               'hierarchical'  => 1,
               'pad_counts'    => 0
           );

           $categories = get_categories( $args );
              
           $counter = 1;

           foreach ( $categories as $category ){
               
                  if(!in_array(xprofile_get_field_id_from_name($category->name), $group_id)){
                global $bp;
                $xfield_args =  array (
                    field_group_id  => $group_id,
                    name            => $category->name,
                    can_delete      => false,
                    field_order     => 1,
                    is_required     => false,
                    type            => 'checkbox'
                    );

                  $parent_id=  xprofile_insert_field( $xfield_args );
                    // add options
                   if ( !$wpdb->query( $wpdb->prepare( "INSERT INTO {$bp->profile->table_name_fields} (group_id, parent_id, type, name, description, is_required, option_order, is_default_option) VALUES (%d, %d, 'option', %s, '', 0, %d, %d)", $group_id, $parent_id, $category->name, $counter, $is_default ) ) ) {
                
                    return false;
                    }
                    
                    
                            $counter+=1;
                     $sub_args = array(
                         'taxonomy'      => 'profession',
                         'parent'        => $category->term_id, // get child categories
                         'orderby'       => 'name',
                         'order'         => 'ASC',
                         'hierarchical'  => 1,
                         'pad_counts'    => 0
                     );
                             $sub_categories = get_categories( $sub_args );

                            foreach ( $sub_categories as $sub_category ){

                                 if ( !$wpdb->query( $wpdb->prepare( "INSERT INTO {$bp->profile->table_name_fields} (group_id, parent_id, type, name, description, is_required, option_order, is_default_option) VALUES (%d, %d, 'option', %s, '', 0, %d, %d)", $group_id, $parent_id, $sub_category->name, $counter, $is_default ) ) ) {

                                     return false;
                                 }

                                 $counter+=1;
                            }
                }  
               
               
                
              

       

           }
        
     }
     
          private function add_options_only_parents($group_id, $field_group_name, $taxonomy){
        $parent_id= xprofile_get_field_id_from_name($field_group_name);      
          global $bp;
              global $wpdb;
        
        
                    $args = array(
               'taxonomy'      => $taxonomy,
               'parent'        => 0, // get top level categories
               'orderby'       => 'name',
               'order'         => 'ASC',
               'hierarchical'  => 1,
               'pad_counts'    => 0
           );

           $categories = get_categories( $args );
              
           $counter = 1;

           foreach ( $categories as $category ){
               
                  if(!in_array(xprofile_get_field_id_from_name($category->name), $group_id)){
                global $bp;
                $xfield_args =  array (
                    field_group_id  => $group_id,
                    name            => $category->name,
                    can_delete      => false,
                    field_order     => 1,
                    is_required     => false,
                    type            => 'checkbox'
                    );
$childs=  get_term_children($category->term_id, $taxonomy);
            if(sizeof($childs)>0){
                
                        $parent_id=  xprofile_insert_field( $xfield_args );
                    // add options
                   if ( !$wpdb->query( $wpdb->prepare( "INSERT INTO {$bp->profile->table_name_fields} (group_id, parent_id, type, name, description, is_required, option_order, is_default_option) VALUES (%d, %d, 'option', %s, '', 0, %d, %d)", $group_id, $parent_id, $category->name, $counter, $is_default ) ) ) {
                
                    return false;
                    }
                    
                    
                            $counter+=1;
                     $sub_args = array(
                         'taxonomy'      => 'profession',
                         'parent'        => $category->term_id, // get child categories
                         'orderby'       => 'name',
                         'order'         => 'ASC',
                         'hierarchical'  => 1,
                         'pad_counts'    => 0
                     );
                             $sub_categories = get_categories( $sub_args );

                            foreach ( $sub_categories as $sub_category ){

                                 if ( !$wpdb->query( $wpdb->prepare( "INSERT INTO {$bp->profile->table_name_fields} (group_id, parent_id, type, name, description, is_required, option_order, is_default_option) VALUES (%d, %d, 'option', %s, '', 0, %d, %d)", $group_id, $parent_id, $sub_category->name, $counter, $is_default ) ) ) {

                                     return false;
                                 }

                                 $counter+=1;
                            }
                }  
            }

          
               
               
                
              

       

           }
        
     }

     public function profession_list(){

                    $args = array(
               'taxonomy'      => 'profession',
               'parent'        => 0, // get top level categories
               'orderby'       => 'name',
               'order'         => 'ASC',
               'hierarchical'  => 1,
               'pad_counts'    => 0
           );

           $categories = get_categories( $args );

           foreach ( $categories as $category ){

               echo '<h3>'. $category->name . '</h3>';

               $sub_args = array(
                   'taxonomy'      => 'profession',
                   'parent'        => $category->term_id, // get child categories
                   'orderby'       => 'name',
                   'order'         => 'ASC',
                   'hierarchical'  => 1,
                   'pad_counts'    => 0
               );

               $sub_categories = get_categories( $sub_args );

               foreach ( $sub_categories as $sub_category ){

                   echo '<label><input type="checkbox" id="type-'. $sub_category->name . '" rel="'. $sub_category->name . '">'. $sub_category->name . '</label>';

               }

           }
     }
     
        
    private function create_slug($value){
    
    if($value=='Finance'){
       $value='accounting';
    }
     
    return $value .= '-jobs';
}
        
  
 

}