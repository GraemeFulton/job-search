		<?php do_shortcode('[indeed_popups id=1]'); ?>

<?php 
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args= array(
        'post_type'=>$post_category,
    	'paged' => $paged,
        'orderby' => 'rand'    
);

query_posts( $args);

?>
<div id="lg-gridview-container"  class='main-content mobile-menu' category_type='<?php echo $post_category;?>' tag_type='<?php echo $tag_type;?>' body_type="<?php echo $body_type;?>">
   
		<div class="padder">
                            <?php include('filter_bar.php');?>

		<?php do_action( 'bp_before_blog_page' ); ?>

		<div id="lg-grid-view" role="main">
                    
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                    
                            <?php  include($include);?>

			<?php endwhile; endif; ?>
                                                                            
	</div><!-- #content -->
        
        <div id="loaded_content"></div>

        </div><!-- .padder -->
   </div><!-- .page -->
   
