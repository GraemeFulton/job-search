<?php
/*
Plugin Name: Display Taxonomies
Plugin URI: http://graylien.tumblr.com
Description: Displays taxonomies for sidebar
Version: 1.0
Author: Graeme Fulton
Author URI: http://gfulton.me.uk
*/

//include required class
include("display-tax-libs.php");

    
    /* display_taxonomy_tree
     * 
     * plugin hook called from sidebar
     * 
     */
     

    function display_taxonomy_tree($tag_type)
    {
        $dp= new Display_Taxonomy('xili_tidy_tags_'.$tag_type);
    }
    
    /*
     * Action: load checkbox.js script
     */
    function load_js()
    {
        wp_enqueue_script('the_js', plugins_url('/checkbox.js',__FILE__) );
    }
    add_action('wp_head','load_js');


    /*
     * ajax course subject filter hooks
     */
    add_action('wp_ajax_nopriv_check_box', 'filter_by_subject_ajax');
    add_action('wp_ajax_check_box', 'filter_by_subject_ajax');
    //add_action('wp_ajax_nopriv_check_box', array( 'Display_Taxonomy', 'dump_tags' ));

    /*
     * filter_by_subject_ajax
     * 
     * args: arguments from checkbox.js 
     * returns: returns html template to ajax call
     */
    function filter_by_subject_ajax()
    {
         switch($_REQUEST['fn'])
        {
             case 'get_latest_posts':
                  $output = ajax_get_latest_posts($_POST['tax'], $_POST['offset'], $_POST['cat'], $_POST['type']);
             break;
             default:
                 $output = 'No function specified, check your jQuery.ajax() call';
             break;
        }
 
        $output=json_encode($output);
        
        if(is_array($output))
        {
            print_r($output);   
        }
         else{echo $output;}
         die;
    }
    
/*
 * ajax_get_latest_posts
 * args: taxonomy (checkbox selections), offset(number of courses already loaded)
 * returns: html template 
 */
function ajax_get_latest_posts($tax, $offset, $category_type, $tag_type)
{
    
   $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $args= array
    (
        'offset'=>$offset,
        'post_type'=>$category_type,
        'paged'=>$paged,
        'posts_per_page'=>9
    );
    
    if($tax!=""){//if a box has been checked, we add a taxnomoy query
         
        $tags_from_group=array();
        
        foreach($tax as $term)
        {       
            $tags_from_group= array_merge($tags_from_group,xtt_tags_from_group($term, '',"xili_tidy_tags_".$tag_type, $tag_type));
            $args['tax_query'][0]['terms']=$tags_from_group;
            $args['tax_query'][0]['taxonomy']=$tag_type;
            $args['tax_query'][0]['field']='slug';
        }      
    } 
    query_posts($args);
    
   return loadMore();
}


function loadMore() {

    // the Loop
      include("Views/course_post_loop.php");  
      wp_reset_query();
      exit;
}
?>

