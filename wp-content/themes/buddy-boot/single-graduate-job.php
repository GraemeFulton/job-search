<?php
/**
 * The Template for displaying all single posts.
 *
 * @package klein
 *
 */

get_header(); ?>
<?php global $post; ?>
<div class="row">
  <?php                
        $content='[ajaxy-live-search post_types="graduate-job" label="Search for Graduate Jobs" width="500" delay="300" width="500" url="http://localhost/LGWP/?s=%s" border="1px solid #eee"]';
        echo do_shortcode($content);
        
        ?>

	<div class="col-md-12" id="content-header">
		<h1 class="entry-title" id="bp-klein-page-title">
			<?php the_title(); ?>
		</h1>
	</div>

<?php if(function_exists('bcn_display')){ ?>
	<div class="klein-breadcrumbs col-md-12">
		<?php bcn_display(); ?>
	</div>
<?php } ?>
	
</div>
<div class="row custom-tax-single">
	<div id="primary" class="col-md-8 col-sm-8">
<?php 

         $post_id= get_the_ID();
         $popup= new Popup_Filter($post_id, 'graduate-job', 'profession', 'company');

	echo '<h5 style="background:#333;color:rgba(255, 134, 39, 1);padding:5px;margin-bottom:0px;"><span style="margin-right:5px;"class="glyphicon fa fa-bullseye fa-2x"></span>Job Fact File</h3>';
	$popup->template_response('table');
?>
<?php the_content(); ?>

<?php                
	echo '<hr><h3 style="margin-bottom:-20px;">Similar Jobs</h3>'.do_shortcode('[widgets_on_pages id="Related Taxonomy Widget"]');
?>
		
                    <?php
                        // If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() )
			comments_template();
                    ?>
	</div>
	<div id="secondary" class="widget-area col-md-4 col-sm-4" role="complementary">
            
		<?php 
		echo do_shortcode('[widgets_on_pages id="Related Job Sidebar"]');
               get_sidebar(); ?>
	</div>
</div>
                                  
<?php get_footer(); ?>
