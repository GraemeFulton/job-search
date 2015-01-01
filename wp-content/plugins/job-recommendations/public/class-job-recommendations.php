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

        $args= array
       (
           'post_type'=>'graduate-job',
           'paged'=>$paged,
           'posts_per_page'=>$offset,
       );


        //add '-jobs' suffix to professions so query by slug works
        if(isset($_POST['Profession'])){
        array_walk($_POST['Profession'], function(&$value, $key) {  $value =$this->create_slug($value); });
        //profession
         $args['tax_query'][0]['terms']=$_POST['Profession'];
         $args['tax_query'][0]['taxonomy']='profession';
         $args['tax_query'][0]['field']='slug';
        }

        if(isset($_POST['Location'])){
         //location
         $args['tax_query'][1]['terms']=$_POST['Location'];
         $args['tax_query'][1]['taxonomy']='location';
         $args['tax_query'][1]['field']='slug';  
        }
         $qp= query_posts($args);

         require_once 'views/template-job-recommendations.php';
         wp_reset_query();
                  
     }
     
     
     public function profile_recommend_jobs(){
                
    global $bp;
    $id=$bp->loggedin_user->id ;
    
    //set up a custom query for paginating
    $custom_query_args = array(
    // Custom query parameters go here
         'post_type'=>'graduate-job',
        'posts_per_page'=>"3"
    );
    
    //WP_QUERY
    // $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

   $custom_query_args['paged'] = get_query_var( 'page' ) 
    ? get_query_var( 'page' ) 
    : 1;


     
//     $selections = xprofile_get_field_data('Subjects', $id);
//     //add '-jobs' suffix to professions so query by slug works
//     if(isset($selections)){
//     array_walk($selections, function(&$value, $key) {  $value =$this->create_slug($value); });
//     //profession
//      $custom_query_args['tax_query'][0]['terms']=$selections;
//      $custom_query_args['tax_query'][0]['taxonomy']='profession';
//      $custom_query_args['tax_query'][0]['field']='slug';
//     }
//     
//     if(isset($_POST['Location'])){
//      //location
//      $custom_query_args['tax_query'][1]['terms']=$_POST['Location'];
//      $custom_query_args['tax_query'][1]['taxonomy']='location';
//      $custom_query_args['tax_query'][1]['field']='slug';  
//     }
    // Instantiate custom query
    $custom_query = new WP_Query( $custom_query_args );
    //cache the old query
    $temp_query = $wp_query;
    $wp_query = NULL;
    $wp_query = $custom_query;
    
?>
<h1>Latest Job Recommendations</h1>
  <?php 	 if ( $custom_query->have_posts() ) : 
			// Do we have any posts/pages in the databse that match our query?
			?>

				<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
				// If we have a page to show, start a loop that will display it
				?>

					<div class="post container" >
					
                                            <a href="<?php the_permalink(); ?>">	<h4 class="title"><?php the_title(); // Display the title of the page ?></h4></a>
						
						<div class="the-content">
							<?php the_content(); 
							// This call the main content of the page, the stuff in the main text box while composing.
							// This will wrap everything in p tags
							?>
							
							<?php wp_link_pages(); // This will display pagination links, if applicable to the page ?>
						</div><!-- the-content -->
						
					</div>

				<?php endwhile; // OK, let's stop the page loop once we've displayed it ?>

			<?php else : // Well, if there are no posts to display and loop through, let's apologize to the reader (also your 404 error) ?>
				
				<article class="post error">
					<h1 class="404">Nothing posted yet</h1>
				</article>

			<?php endif; // OK, I think that takes care of both scenarios (having a page or not having a page to show)
                      
                        ?>


<?php
 // Reset postdata
wp_reset_postdata();

// Custom query loop pagination
previous_posts_link( 'Older Posts' );
next_posts_link( 'Newer Posts', $custom_query->max_num_pages );

// Reset main query object
$wp_query = NULL;
$wp_query = $temp_query;


     }
        
        
    private function create_slug($value){
    
    if($value=='Finance'){
       $value='accounting';
    }
     
    return $value .= '-jobs';
}
        
  
 

}
