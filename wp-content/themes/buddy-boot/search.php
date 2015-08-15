<?php
/**
 * The template for displaying any single page.
 *
 */

get_header(); // This fxn gets the header.php file and renders it
global $paged;
global $wp_query;
?>
 <? include(get_stylesheet_directory().'/partials/side-nav.php');?>
 <?php require(JOB_RECOMMENDATIONS.'/public/views/partials/app-bar.php'); ?>


    <section class="col-md-9 col-xs-12">
      <?php  include(get_stylesheet_directory().'/partials/loader.php');?>


     	<div id="primary" class="container">
            <div class='container'>
            <?php get_search_form(); ?>
             </div>
<!--		<div id="content" role="main" class="span12">-->
		<section class="container list-container">

			<?php if ( have_posts() ) :

      global $wp_query;
        if ($paged==0){
        	$paged=1;
     	 }

         echo '<div class="pagi-top container no-pad-bottom no-pad"><p>Page <span class="page-num">'.$paged.' of '.$wp_query->max_num_pages.'</span> for your search</p>';?>
               <?php include('partials/selections-tags.php') ;
               echo '</div>';

			// Do we have any posts/pages in the databse that match our query?
			?>


				<?php while ( have_posts() ) : the_post();
				// If we have a page to show, start a loop that will display it
				?>
				<?php do_action('job_search_results_loop'); ?>
				<?php endwhile; // OK, let's stop the page loop once we've displayed it ?>

			<?php else : // Well, if there are no posts to display and loop through, let's apologize to the reader (also your 404 error) ?>

				<article class="post error container" style="padding:20px;">
					<h3 style="margin-top:0px;">Sorry, nothing found</h3>
                                        <p>Try searching for something else, or browse recommended jobs:</p>
                                        <a class="btn-success btn-outlined btn" href="<?php echo get_site_url; ?>/job-roll">Recommended Jobs</a>
				</article>

			<?php endif; // OK, I think that takes care of both scenarios (having a page or not having a page to show) ?>
                </section>
<!--		</div> #content .site-content -->
	</div><!-- #primary .content-area -->

	<?php if (!is_user_logged_in() && $paged==1){  ?>
   <div class="col-md-12 no-pad pad-top">
      <?php echo get_next_posts_link( '<p><button class="btn btn-primary btn-large btn-raised">View more jobs</button></p>', $qp->max_num_pages ); // display older posts link ?>
        </div>

 <?php }else{ ?>

        <div class="container col-md-12 paginating">
	        <div class="col-sm-2 pager pull-left">
                    <li class='pull-left'>
	        <?php previous_posts_link('Previous'); ?>
                    </li>
	        </div>
	        <div class="col-sm-8 page-navi mobile-hide desktop-show">
	         <?php wp_pagenavi(); ?>
	         </div>
	        <div class="col-sm-2 pager pull-right">
                    <li class='pull-right'>
	        <?php next_posts_link('Next'); ?>
                    </li>
	        </div>
			<div class="mobile-show">
			<?php wp_pagenavi_dropdown();?>
			</div>
        </div>


 <?php } ?>

    </section>
<?php get_footer(); // This fxn gets the footer.php file and renders it ?>
