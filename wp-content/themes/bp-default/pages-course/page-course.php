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

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                    <div class="item">

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
    $uniID = wp_get_post_terms($post->ID, 'uni', array("fields" => "ids"));
    $uniName = wp_get_post_terms($post->ID, 'uni', array("fields" => "names"));
    $uniSlug = wp_get_post_terms($post->ID, 'uni', array("fields" => "slugs"));
    $url = get_bloginfo('url');

 if($uniID)
{
   $sql="SELECT $wpdb->term_taxonomy.term_id 
          FROM $wpdb->term_relationships INNER JOIN $wpdb->term_taxonomy
          ON $wpdb->term_taxonomy.term_taxonomy_id=$wpdb->term_relationships.term_taxonomy_id
          WHERE $wpdb->term_relationships.object_id ='$uniID[0]'";
        
    $safe_sql= $wpdb->prepare($sql);
    $results=$wpdb->get_results($safe_sql);
        
    if($results)
    {
      $tags_from_group= xtt_tags_from_group(intval($results[0]->term_id),'array',"xili_tidy_tags_uni", "uni");
      
      $slugs=array();
      $names=array();
      foreach($tags_from_group as $tags){
          array_push($slugs, $tags['tag_slug']);
          array_push($names, $tags['tag_name']);
       }
      
       $list = implode ( ',', $slugs );
       // echo add_query_arg($arr_params);
       if($names[0])
       echo '|Offered by: <a href="'.$url.'/?uni='.$list.'">'.$names[0].'</a>';
    }
     else if($uniName[0])echo '|Offered by: <a href="'.$url.'/?uni='.$uniSlug[0].'">'.$uniName[0].'</a>';

 }     
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
                                            <div class="clickme"></div><!--overlay -->
				</div><!--item-->

				</div>

			<?php comments_template(); ?>

			<?php endwhile; endif; ?>
                                                        

                                
<?php do_action( 'bp_after_blog_page' ); ?>
	
	</div><!-- #content -->
       
        </div><!-- .padder -->
  <div class="nav-more">
             <a href="#" id="blog-more" style="height:100px;"><h4>Load More</h4></a>
        </div>
   </div><!-- .page -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
