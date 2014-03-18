<?php
/*
Plugin Name: LG Bootstrap-Walker
Plugin URI: http://graylien.tumblr.com
Description: Bootstrap navbar
Version: 1.0
Author: Graeme Fulton
Author URI: http://gfulton.me.uk
*/
    add_action( 'after_setup_theme', 'wpt_setup' );
    if ( ! function_exists( 'wpt_setup' ) ):
    function wpt_setup() {
    	register_nav_menu( 'primary', __( 'Primary navigation', 'wptuts' ) );
    } endif;
    
    /*include the nav bar class*/
    require_once('templates/wp_bootstrap_navwalker.php');
    
    add_action('bp_after_header', 'gray_bootstrap_navbar');
    function gray_bootstrap_navbar(){
    	global $wp;
    	//set up variables
    	$nav_settings=new NavBarSettings($wp);
    	$header_class=$nav_settings->header_css_class;
    	$placeholder=$nav_settings->placeholder_text;
    	$icon= $nav_settings->mobile_nav_toggle_icon;
    	$colour= $nav_settings->colour;
    	$search=$nav_settings->search;
    	//include template
    	require_once('templates/template_navbar.php');
    }
    
   /*
   * Action: enqueue css
   */
    function bootstrap_walker()
    {
        //css
        wp_register_style( 'bootstrap_walker', plugins_url('/css/bootstrap-walker.css', __FILE__) );
        wp_enqueue_style( 'bootstrap_walker' );
    }
    
    add_action( 'wp_enqueue_scripts', 'bootstrap_walker' );
    
    Class NavBarSettings{
    	
    	//set defaults as homepage
    	public $header_css_class='home';
    	public $placeholder_text='';
    	public $mobile_nav_toggle_icon='';
    	public $colour='';
    	public $search=false;
    	
    	
    	public function __construct($wp){
    		global $wp;
    	$id=get_the_ID();
    	$page=get_post($id);

    	//set up variables
    	$this->set_properties($page->post_title);
    		
    		
    	}
    	
    	private function set_properties($post_title){
    		
    		
    		if($post_title=='Work'){
    			$this->header_css_class='graduatejob';
    			$this->placeholder_text='Work';
    			$this->mobile_nav_toggle_icon='bullseye';
    			$this->colour='rgba(255, 134, 39, 1)';
    			$this->search=true;
    		}
    		elseif($post_title=='Learn'){	
    			$this->header_css_class='course';
    			$this->placeholder_text='Courses';
    			$this->mobile_nav_toggle_icon='book';
    			$this->colour='rgb(23, 171, 255)';
    			$this->search=true;
    			 
    		}
                elseif($post_title=='Travel'){
    			$this->header_css_class='travel';
    			$this->placeholder_text='Travel';
    			$this->mobile_nav_toggle_icon='plane';
    			$this->colour='rgb(87, 189, 87)';
    			$this->search=true;
    			 
    		}
    		elseif($post_title=='Experience'){
    			$this->header_css_class='work-experience';
    			$this->placeholder_text='Experience';
    			$this->mobile_nav_toggle_icon='cogs';
    			$this->colour='rgb(228, 104, 228)';
    			$this->search=true;
    			 
    		}
    		elseif($post_title=='Inspire'){
    			$this->header_css_class='inspire';
    			$this->placeholder_text='Inspire';
    			$this->mobile_nav_toggle_icon='lightbulb-o';
    			$this->colour='goldenrod';
    			$this->search=true;
    			 
    			
    		}
                else{
                    
                    $this->set_alternate_properties();
                
                }
    		
    	}
        
        function set_alternate_properties(){
            
        global $wp;
    	$id=get_the_ID();
        $post = get_post($id);
        $post_type= $post->post_type;
         
         
         
        if($post_type=='course'){
            $this->header_css_class='course';
    			$this->placeholder_text='Courses';
    			$this->mobile_nav_toggle_icon='book';
    			$this->colour='rgb(23, 171, 255)';
    			$this->search=true;
        }
        elseif($post_type=='graduate-job'){
        	$this->header_css_class='graduatejob';
    			$this->placeholder_text='Work';
    			$this->mobile_nav_toggle_icon='bullseye';
    			$this->colour='rgba(255, 134, 39, 1)';
    			$this->search=true;
        }
        elseif($post_type=='work-experience-job'){
            	$this->header_css_class='work-experience';
    			$this->placeholder_text='Experience';
    			$this->mobile_nav_toggle_icon='cogs';
    			$this->colour='rgb(228, 104, 228)';
    			$this->search=true;
        }
        elseif($post_type=='travel-opportunities'){
          		$this->header_css_class='travel';
    			$this->placeholder_text='Travel';
    			$this->mobile_nav_toggle_icon='plane';
    			$this->colour='rgb(87, 189, 87)';
    			$this->search=true;
        }
        
        }
    	
    	
    }
    
?>
