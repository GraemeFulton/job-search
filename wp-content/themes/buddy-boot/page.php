<?php
/**
 * The template for displaying any single page.
 *
 */

get_header(); // This fxn gets the header.php file and renders it ?>
<div class="container-fluid theme-grey">
    <? include(get_stylesheet_directory().'/partials/side-nav.php');?>
    <?php require(JOB_RECOMMENDATIONS.'/public/views/partials/app-bar.php'); ?>
    
     	<div id="primary" class="col-md-9 col-xs-12">
<!--		<div id="content" role="main" class="span12">-->

			<?php if ( have_posts() ) :
			// Do we have any posts/pages in the databse that match our query?
			?>

				<?php while ( have_posts() ) : the_post();
				// If we have a page to show, start a loop that will display it
				?>

					<section>
					<?php if(!bp_is_my_profile()){?>
						<h1 class="title"><?php the_title(); // Display the title of the page ?></h1>
					<?php }?>
						<div class="the-content">
							<?php the_content();
							// This call the main content of the page, the stuff in the main text box while composing.
							// This will wrap everything in p tags
							?>

							<?php wp_link_pages(); // This will display pagination links, if applicable to the page ?>
						</div><!-- the-content -->

					</section>

				<?php endwhile; // OK, let's stop the page loop once we've displayed it ?>

			<?php else : // Well, if there are no posts to display and loop through, let's apologize to the reader (also your 404 error) ?>

				<article class="post error">
					<h1 class="404">Nothing posted yet</h1>
				</article>

			<?php endif; // OK, I think that takes care of both scenarios (having a page or not having a page to show) ?>

<!--		</div> #content .site-content -->
	</div><!-- #primary .content-area -->

</div>
<?php get_footer(); // This fxn gets the footer.php file and renders it ?>
