<?php
/*
Plugin Name: Display Taxonomies
Plugin URI: http://graylien.tumblr.com
Description: Displays taxonomies for sidebar
Version: 1.0
Author: Graeme Fulton
Author URI: http://gfulton.me.uk
*/


    add_action('wp_head','load_js');
    add_action('wp_ajax_nopriv_check_box', 'our_ajax_function');
    add_action('wp_ajax_check_box', 'our_ajax_function');
    //add_action('wp_ajax_nopriv_check_box', array( 'Display_Taxonomy', 'dump_tags' ));
    // add_action('wp_ajax_check_box', array( 'Display_Taxonomy', 'dump_tags' ));

    //include required class
    include("display-tax-libs.php");

    //plugin hook called from sidebar
    function display_taxonomy_tree()
    {
        $dp= new Display_Taxonomy();
    }
    
    function load_js()
    {
        wp_enqueue_script('the_js', plugins_url('/checkbox.js',__FILE__) );
    }



    function our_ajax_function()
    {
       // the first part is a SWTICHBOARD that fires specific functions
       // according to the value of Query Var 'fn'
 
        switch($_REQUEST['fn'])
        {
             case 'get_latest_posts':
                  $output = ajax_get_latest_posts($_POST['tax']);
             break;
             default:
                 $output = 'No function specified, check your jQuery.ajax() call';
             break;
        }
 
   // at this point, $output contains some sort of valuable data!
   // Now, convert $output to JSON and echo it to the browser 
   // That way, we can recapture it with jQuery and run our success function
 
        $output=json_encode($output);
        
        if(is_array($output))
        {
            print_r($output);   
        }
         else{echo $output;}
         die;
    }
    

function ajax_get_latest_posts($tax)
{
    
    $tags_from_group=array();
    
    foreach($tax as $term)
    {       
        $tags_from_group= array_merge($tags_from_group,xtt_tags_from_group($term, '',"xili_tidy_tags_subject", "subject"));
    }
    
    $args= array
    (
     'post_type'=>'course',
        'paged'=>$paged,
      'tax_query' => array(
         array(
        'taxonomy' => 'subject',
        'field' => 'slug',
        'terms' => $tags_from_group
        )
        )
    
    );

    $posts=query_posts( $args);
    
    foreach ( $posts as $key => $post ) 
    {
        $posts[ $key ]->key1 = get_post_meta( $post->ID, 'wpcf-course-type', true );
        $company_id=get_post_meta( $post->ID, 'Company', true );
        $posts[ $key ]->key2 = get_post_meta($company_id, "wpcf-company-name", true);

        $linked_company= get_field('Company', $post->ID) ;

        $linked_co = $linked_company[0];

        if ($linked_co)
        $posts[ $key ]->key2=$linked_co;
    }

    return $posts;
}

?>

