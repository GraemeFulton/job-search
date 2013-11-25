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
     

    function display_taxonomy_tree($tag_type, $grouped_taxonomy)
    {
        global $dp;
        $dp= new Display_Taxonomy($tag_type, $grouped_taxonomy);

        return $dp;
    }
   // add_action( 'plugins_loaded', array( 'Display_Taxonomy', 'init' ));



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
    add_action('wp_ajax_nopriv_check_box_filters', 'process_filter');
    add_action('wp_ajax_check_box_filters', 'process_filter');
    //add_action('wp_ajax_nopriv_check_box', array( 'Display_Taxonomy', 'dump_tags' ));

    /*
     * filter_by_subject_ajax
     * 
     * args: arguments from checkbox.js 
     * returns: returns html template to ajax call
     */
    function process_filter()
    {
         switch($_REQUEST['fn'])
        {
             case 'process_filter':
                  $output = create_post_filter(
                          $_POST['selected_subjects'], 
                          $_POST['offset'],
                          $_POST['cat'], 
                          $_POST['type'], 
                          $_POST['selected_institutions'],
                          $_POST['body_type']
                          );
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
function create_post_filter($selected_subjects, $offset, $category_type, $tag_type, $selected_institutions, $body_type)
{
    
   $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $args= array
    (
        'offset'=>$offset,
        'post_type'=>$category_type,
        'paged'=>$paged,
        'posts_per_page'=>9,
        'orderby' => 'title',
        'order' => 'ASC'

    );
    
    //QUERY CHECKED SUBJECTS
    if($selected_subjects!=""){//if a box has been checked, we add a taxnomoy query
         
        $tags_from_group=array();
        
        foreach($selected_subjects as $term)
        {       
            $tags_from_group= array_merge($tags_from_group,xtt_tags_from_group($term, '',"xili_tidy_tags_".$tag_type, $tag_type));
            $args['tax_query'][1]['terms']=$tags_from_group;
            $args['tax_query'][1]['taxonomy']=$tag_type;
            $args['tax_query'][1]['field']='slug';
        }      
    } //QUERY CHECKED SUBJECTS
    
    //QUERY CHECKED INSTITUTIONS
        if($selected_institutions!=""){//if a box has been checked, we add a taxnomoy query
         
        $tags_from_group=array();
        
        foreach($selected_institutions as $term)
        {       
           $tags_from_group= array_merge($tags_from_group,xtt_tags_from_group($term, '',"xili_tidy_tags_".$body_type, $body_type));

            $args['tax_query'][0]['terms']=$tags_from_group;
            $args['tax_query'][0]['taxonomy']=$body_type;
            $args['tax_query'][0]['field']='slug';
        }      
    } //QUERY CHECKED INSTITUTIONS
    
    query_posts($args);
    
   return load_post_loop_view($category_type);
}


function load_post_loop_view($category_type) {

    if ($category_type=='course'){
    // the Loop
      include("Views/course_post_loop.php");  
    }
    else if($category_type=='graduate-job'){
        
        include("Views/graduatejob_post_loop.php");  
        
    }
    
    wp_reset_query();
    exit;
}
?>

