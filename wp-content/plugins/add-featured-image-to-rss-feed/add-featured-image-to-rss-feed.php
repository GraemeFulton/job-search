<?php
/* 
Plugin Name: Add featured image to RSS feed
Plugin URI: http://www.tacticaltechnique.com/wordpress/
Description: Adds the featured image attached to your posts to the RSS feed.
Author: Corey Salzano
Version: 1.0
Author URI: http://twitter.com/salzano
*/

//	function add_featured_image_to_feed($content) {
//		global $post;
//		if ( has_post_thumbnail( $post->ID ) ){
//			$content = '' . get_the_post_thumbnail( $post->ID, 'large' ) . '' . $content;
//		}
//		return $content;
//	}
//
//	add_filter('the_excerpt_rss', 'add_featured_image_to_feed', 1000, 1);
//	add_filter('the_content_feed', 'add_featured_image_to_feed', 1000, 1);
        
            add_action('rss2_item','add_job_details_to_RSS');
            
            function add_job_details_to_RSS(){
                
                global $post;
                $post_type=get_post_type( $post->ID );
                
                if($post_type=='graduate-job'){
                   
                    $job_tree=display_taxonomy_tree('profession', 'company');

                    //show image in feed
                    $image = get_the_image($post->ID);
                    echo '<image>'.$image.'</image>';
                    
                    //show job source
                    $source = $job_tree->get_linked_taggroup_or_tag($post->ID, '', ''); 
                    if($source){
                      echo '<source>'.$source.'</source>';
                    }
                    
                    //show location
                    $location = $job_tree->get_taxonomy_field($post->ID, 'location');
                    if($location){
                        echo '<location>'.$location.'</location>';
                    }
                    
                    //show profession
                  $profession = $job_tree->grouped_taxonomy_name($post->ID);
                    if ($profession){
                        echo '<profession>'.$profession.'</profession>';
                    }
                    
                }
                
            }



//                add_action( 'rss2_item', 'add_featured_image_to_feed_as_node' );
//
//        function add_featured_image_to_feed_as_node() {
//            
//            global $post;
//            $image = get_the_image($post->ID);
//            echo '<image>'.$image.'</image>';
//            
//        }
//        
//                 add_action( 'rss2_item', 'add_source_to_rss' );
//
//        function add_source_to_rss(){
//            
//            global $post;
//            $image = get_the_image($post->ID);
//            echo '<source>'.$image.'</source>';
//            
//        }
//        
        
?>
