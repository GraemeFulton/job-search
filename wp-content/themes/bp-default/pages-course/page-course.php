<?php 
/*
 * Template Name: Courses (All)
 * 
 * A Page for courses
*/

get_header(); 

	 get_sidebar('left');

?>


<?php 
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args= array(
        'post_type'=>'course',
    	'paged' => $paged
);




query_posts( $args); ?>
	<div id="content">

		<div class="padder">

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


//   $sql="SELECT $wpdb->term_relationships.term_taxonomy_id
//                from $wpdb->term_relationships 
//                WHERE $wpdb->term_relationships.object_id ='$uni[0]'";
        
    $sql="SELECT $wpdb->term_taxonomy.term_id 
            FROM $wpdb->term_relationships INNER JOIN $wpdb->term_taxonomy
                ON $wpdb->term_taxonomy.term_taxonomy_id=$wpdb->term_relationships.term_taxonomy_id
                WHERE $wpdb->term_relationships.object_id ='$uni[0]'";
        
   
   
        $safe_sql= $wpdb->prepare($sql);
        $results=$wpdb->get_results($sql);
           // $results = $wpdb->get_results ( "SELECT * FROM $wpdb->terms" );
              $tags_from_group=array();


////    foreach($results as $group)
//    {       

       $tags_from_group= array_merge($tags_from_group,xtt_tags_from_group(intval($results[0]->term_id),'',"xili_tidy_tags_uni", "uni"));

    //   echo $group->term_taxonomy_id; 
       
     //  echo "<br> tfg ".$tags_from_group[0];
       
       
//    }
    			$list = implode ( ',', $tags_from_group );

    
   // echo add_query_arg($arr_params);
    $url = get_bloginfo('url');

 echo '<a href="'.$url.'/?uni='.$list.'">'.$tags_from_group[0].'</a>';
    
 //echo '<a href="'.link_for_posts_of_xili_tags_group ('trademark').'">'.$tags_from_group[1].'</a>';



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
                                                    <?php // edit_post_link( __( 'Edit this page.', 'buddypress' ), '<p class="edit-link">', '</p>'); ?>

					</div>

				</div>

			<?php comments_template(); ?>

			<?php endwhile; endif; ?>
                                
 <div class="navigation">
     <div style="width:100px; height:100px; background:blue;"id="blog-more"></div>
  <div class="alignleft"><?php previous_posts_link('&laquo; Previous') ?></div>
  <div class="alignright"><?php next_posts_link('More &raquo;') ?></div>
</div>
                                
<?php do_action( 'bp_after_blog_page' ); ?>

    
		
		
	</div><!-- #content -->
        </div><!-- .padder -->

   </div><!-- .page -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
