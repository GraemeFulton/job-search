<?php
/**<br />
 * Template Name: Archives Template<br />
 * Description: A Page Template that lets us created a dedicated Archives page<br />
 *<br />
 * @package WordPress<br />
 * @subpackage Twenty_Eleven<br />
 * @since Twenty Eleven 1.0<br />
 */
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
global $paged;

get_header(); // This fxn gets the header.php file and renders it ?>


<div class="container-fluid theme-grey">
    <div class='container box-head'>
        <?php if ($paged==0){ 
        	$paged=1;
     	 }
        
         echo '<div style="float:left;"><p>Page <span class="page-num">'.$paged.'</span> for jobs @ '.$term->name.' </p></div>';?>
        
    </div>


	<div class="container archive-title">
		<h2>Jobs @ <?php  echo $term->name; ?></h2>
	</div>
     	<div id="primary" class="container">
<!--		<div id="content" role="main" class="span12">-->

			<?php if ( have_posts() ) : 
			// Do we have any posts/pages in the databse that match our query?
			?>

				<?php while ( have_posts() ) : the_post(); 
				// If we have a page to show, start a loop that will display it
				
				do_action('archive_job_loop');
				?>

					

				<?php endwhile; // OK, let's stop the page loop once we've displayed it ?>

			<?php else : // Well, if there are no posts to display and loop through, let's apologize to the reader (also your 404 error) ?>
				
				<article class="post error">
					<h1 class="404">Nothing posted yet</h1>
				</article>

			<?php endif; // OK, I think that takes care of both scenarios (having a page or not having a page to show) ?>

<!--		</div> #content .site-content -->
	</div><!-- #primary .content-area -->
	
		<?php if (!is_user_logged_in() && $paged==1){  ?>

      <?php echo get_next_posts_link( '<p class="sign-up-next-link"><div class="container text-center sign-up-next"><h4>Show me more!</h4></div></p>', $qp->max_num_pages ); // display older posts link ?>


 <?php }else{ ?>
 
        <div class="container paginating">
	        <div class="col-sm-2">
	        <?php previous_posts_link('<div class="pull-left pagi-button"> Previous</div>'); ?>
	        </div>
	        <div class="col-sm-8 page-navi mobile-hide desktop-show">
	         <?php wp_pagenavi(); ?>
	         </div>
	         <div class="col-sm-2">
			<?php next_posts_link( '<div class="pull-right pagi-button">Next</div>'); ?>
			</div>
			<div class="mobile-show">
			<?php wp_pagenavi_dropdown();?>
			</div>
        </div>

        
       
 <?php } ?>
<?php get_footer(); // This fxn gets the footer.php file and renders it ?>
</div>