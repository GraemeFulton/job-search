<?php
/**
 * The Sidebar Left
 *
 * @package klein
 */
?>

<?php global $post; ?>

<?php // global default sidebars; ?>
<?php $sidebar_meta = get_post_meta( $post->ID, 'klein_sidebar_left', true ); ?>
<?php do_action( 'before_sidebar' ); ?>

<?php if( !empty( $sidebar_meta ) ){ ?>
	<?php dynamic_sidebar( $sidebar_meta ); ?>
<?php }else{ ?>
	<?php 
		// default sidebar
		$sidebar = 'sidebar-2'; 
	?>
	<?php if( function_exists( 'is_bbpress' ) ){ //check if bbpress is installed ?>
		<?php if( is_bbpress() ){ ?>
			<?php
			//bbpress forums/discussion sidebar
			$sidebar = 'bbp-klein-sidebar-left'; ?>
		<?php } ?>
	<?php } ?>
	<?php dynamic_sidebar( $sidebar ); ?>	
<?php } ?>