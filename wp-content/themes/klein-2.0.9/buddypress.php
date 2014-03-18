<?php
/**
 * Buddypress Wrapper
 *
 * @package klein
 */
?>

<?php get_header(); ?>

<?php $layout = ot_get_option( 'bp_layout', 'right-sidebar' ); ?>

<?php 
	$bp_parsed_layout = array(
		'right-sidebar' => 'content-sidebar',
		'full-width' => 'full-content',
		'left-sidebar' => 'sidebar-content'
	);
?>

<?php
	$bp_layout = $bp_parsed_layout[$layout];
?>

<?php if( !empty( $bp_layout ) ){ ?>
<?php get_template_part( 'content','header'); ?>
	<div class="row">
		<?php get_template_part( 'buddypress', $bp_layout ); ?>
	</div><!--.row-->
<?php } // endif ?>
<?php get_footer(); ?>