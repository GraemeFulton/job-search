<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package klein
 */

get_header(); ?>

	<div id="primary error-404" class="content-area breath">
		<div id="content" class="row site-content" role="main">
			<div class="container-compress row">
				
				<h1 class="super-large"><?php _e('Four \'Oh! Four!','klein'); ?></h1>
				<p>
					<?php _e('The page you\'ve requested could not be found or it was already removed in the database. Another thing, probably caused by an outdated link in search engines. If you believe that this is an error, please kindly contact us. Thank you!','klein'); ?>
				</p>
				<a class="btn btn-success" href="<?php echo esc_url( home_url() ); ?>" title="<?php _e( 'Back to Home', 'klein' ); ?>">
					<span class="glyphicon glyphicon-home"></span> <?php _e( 'Back to Home','klein' ); ?>
				</a>
			</div>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>