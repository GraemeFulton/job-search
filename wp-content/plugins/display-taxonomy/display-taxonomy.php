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

    //plugin hook called from sidebar
    function display_taxonomy_tree()
    {
        $dp= new Display_Taxonomy();
    }
    
     add_action('wp_head','load_js');
    function load_js()
    {
        wp_enqueue_script('the_js', plugins_url('/checkbox.js',__FILE__) );
    }


    add_action('wp_ajax_nopriv_check_box', 'our_ajax_function');
    add_action('wp_ajax_check_box', 'our_ajax_function');
    //add_action('wp_ajax_nopriv_check_box', array( 'Display_Taxonomy', 'dump_tags' ));
    // add_action('wp_ajax_check_box', array( 'Display_Taxonomy', 'dump_tags' ));

    function our_ajax_function()
    {
       // the first part is a SWTICHBOARD that fires specific functions
       // according to the value of Query Var 'fn'
 
        switch($_REQUEST['fn'])
        {
             case 'get_latest_posts':
                  $output = ajax_get_latest_posts($_POST['tax'], $_POST['offset']);
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
    

function ajax_get_latest_posts($tax, $offset)
{
         
   $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $args= array
    (
        'offset'=>$offset,
     'post_type'=>'course',
        'paged'=>$paged,
        'posts_per_page'=>3
    );
    
    if($tax!=""){//if a box has been checked, we add a taxnomoy query
         
        $tags_from_group=array();
        
        foreach($tax as $term)
        {       
            $tags_from_group= array_merge($tags_from_group,xtt_tags_from_group($term, '',"xili_tidy_tags_subject", "subject"));
            $args['tax_query'][0]['terms']=$tags_from_group;
            $args['tax_query'][0]['taxonomy']='subject';
            $args['tax_query'][0]['field']='slug';
        }      
    } 
        query_posts( $args);

   return loadMore();
}



 function printposts($args){   
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
    
    $pagedposts=array();
    $pagedposts['posts']=$posts;

    return $pagedposts;
}




function loadMore() {

    // setup your query to get what you want

    // initialsise your output

    // the Loop
?>


		<?php do_action( 'bp_before_blog_page' ); ?>

		<div class="page" id="blog-page" role="main">

                                <div id="json_response_box"></div>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

					<div class="entry">

						<?php the_excerpt( __( '<p class="serif">Read the rest of this page &rarr;</p>', 'buddypress' ) ); ?>

						<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>
						
<?php //addition: company name

$linked_company= get_field('Company') ;
//var_dump($linked_company);
$linked_co = $linked_company[0];
if ($linked_co)
echo 'Institution: <a href="'. $linked_co->guid.'">'. $linked_co->post_title.'</a> ';
?>
                                         
<?php //addition: course type field
 
$course_type = types_render_field("course-type", array("output"=>"normal"));

//Output the trainer email
 if($course_type)
printf("| Course Type: %s",$course_type);
  
 ////////////////NEW ADDITION 
 $uni = wp_get_post_terms($post->ID, 'uni', array("fields" => "ids"));
 if($uni){
echo "| Offered by: ";

    $sql="SELECT $wpdb->term_taxonomy.term_id 
            FROM $wpdb->term_relationships INNER JOIN $wpdb->term_taxonomy
                ON $wpdb->term_taxonomy.term_taxonomy_id=$wpdb->term_relationships.term_taxonomy_id
                WHERE $wpdb->term_relationships.object_id ='$uni[0]'";
        
   
   
        $safe_sql= $wpdb->prepare($sql);
        $results=$wpdb->get_results($sql);

        $tags_from_group=array();

       $tags_from_group= array_merge($tags_from_group,xtt_tags_from_group(intval($results[0]->term_id),'',"xili_tidy_tags_uni", "uni"));

    			$list = implode ( ',', $tags_from_group );

   $url = get_bloginfo('url');

 echo '<a href="'.$url.'/?uni='.$list.'">'.$tags_from_group[0].'</a>';
    

 }     

else echo " none";
 //////////////////////////
 $pic = types_render_field("post-image", array("output"=>"raw"));
 
//Output the trainer email
 if($pic){
   printf('<br><img style="float:left position:relative; max-height:150px" src="%s"/>', $pic);
 }
 ?>
                                            <hr>                                       

					</div>

				</div>


			<?php endwhile; endif; ?>
                                
 <div class="navigation">
     <div style="width:100px; height:100px; background:blue;"id="blog-more"></div>
</div>
                                
<?php do_action( 'bp_after_blog_page' ); ?>

    
		
		
	</div>

<?php
       
    wp_reset_query();

exit;
}

?>

