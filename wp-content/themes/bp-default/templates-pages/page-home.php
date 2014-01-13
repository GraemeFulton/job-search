<?php 
/*
 * Template Name: Home Page
 * 
 * A Page for courses
*/

get_header();
?>

<div id="page-container">

	<div id="content"   class='main-content'>

		<div class="padder">

		<?php do_action( 'bp_before_blog_page' ); ?>

		<div class="page" role="main">
                        
<h1>Welcome</h1>

			<?php comments_template(); ?>

		                 

                                
<?php do_action( 'bp_after_blog_page' ); ?>
	
	</div><!-- #content -->
        
       
        </div><!-- .padder -->
   </div><!-- #content -->

	 <div class='sidebar-main'>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>

</div>