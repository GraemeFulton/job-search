<!--course post loop template-->
<div class="page" id="blog-page" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    
    <?php $id= get_the_ID(); $ID=  settype($id, "integer");; ?>
				<div id="post-<?php echo $ID; ?>" <?php post_class(); ?>>
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
    $uniID = wp_get_post_terms(get_the_ID(), 'uni', array("fields" => "ids"));
    $uniName = wp_get_post_terms(get_the_ID(), 'uni', array("fields" => "names"));
    $uniSlug = wp_get_post_terms(get_the_ID(), 'uni', array("fields" => "slugs"));
    $url = get_bloginfo('url');

 if($uniID)
{
     global $wpdb;
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
     else echo '|Offered by: <a href="'.$url.'/?uni='.$uniSlug[0].'">'.$uniName[0].'</a>';

 }     
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
