<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package klein
 */
?>

	</div><!-- #main -->
	
	<?php if ( is_active_sidebar( 'bp-klein-footer-1' ) || is_active_sidebar( 'bp-klein-footer-2' ) || is_active_sidebar( 'bp-klein-footer-3' ) || is_active_sidebar( 'bp-klein-footer-4' ) ){ ?>
		<div id="footer-widgets">
			<div class="container">
				<div class="col-md-3 col-sm-3"><?php dynamic_sidebar('bp-klein-footer-1'); ?></div>
				<div class="col-md-3 col-sm-3"><?php dynamic_sidebar('bp-klein-footer-2'); ?></div>
				<div class="col-md-3 col-sm-3"><?php dynamic_sidebar('bp-klein-footer-3'); ?></div>
				<div class="col-md-3 col-sm-3"><?php dynamic_sidebar('bp-klein-footer-4'); ?></div>
			</div>		
		</div>
	<?php } ?>
	<footer id="footer" class="site-footer" role="contentinfo">
		<div class="container">
			<div class="site-info center">
				<?php
					$copyright = ot_get_option( 'copyright_text', 'Copyright &copy 2013 Klein WordPress Theme (Co. Reg. No. 123456789). All Rights Reserved. Your Company Inc.' );
				?>
				<div id="copyright-text">
					<?php echo $copyright; ?>
				</div>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #footer -->
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>