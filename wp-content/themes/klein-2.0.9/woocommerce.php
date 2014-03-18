<?php
/**
 * WooCommerce File Support
 *
 * @package Klein
 *
 */
?>
<?php get_header(); ?>


<?php if( is_product() ){ ?>
	<?php get_template_part( 'content', 'header' ); ?>
	
	<div class="row">
		<?php
			global $post;
			$meta_layout = get_post_meta( $post->ID, 'klein_page_layout', true );
			$layout = empty( $meta_layout ) ? 'sidebar-content' : $meta_layout;
		?>
	
		<?php if( !empty( $layout ) ){ ?>
			<?php get_template_part( 'woocommerce', $layout ); ?>
		<?php } ?>
	</div>
<?php }else{ ?>

	<?php if(function_exists('bcn_display')){ ?>
		<?php if( is_shop() || is_product_category() || is_product_tag() ){ ?>
			<div class="row">
				<div id="content-header" class="col-md-12">
					<div class="klein-breadcrumbs">
						<?php bcn_display(); ?>
					</div>
				</div>
			</div>	
		<?php } else { ?>
			<div class="row">
				<div id="content-header" class="col-md-12">
					<div class="klein-breadcrumbs row">
						<?php bcn_display(); ?>
					</div>
				</div>
			</div>	
		<?php } ?>
		
	<?php } // end function_exists('bcn_display') ?>
	
	<div id="klein-woocommerce-wrapper" class="row">
		<?php 
			//if is not product page, then use layout set in theme options 
			$layout = ot_get_option( 'wc_layout', 'content-sidebar' );
		?>
		
		<?php if( !empty( $layout ) ){ ?>
			<?php get_template_part( 'woocommerce', $layout ); ?>
		<?php } ?>
	</div>
<?php } ?>

<?php get_footer(); ?>