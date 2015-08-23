<?php
/**
 * Template Name: Front Page LG
 */
?>
<?php get_header(); ?>

	

        <?php                
        $content='[ajaxy-live-search show_category="1" show_post_category="1" post_types="graduate-job,course,work-experience-job,travel-opportunities,inspire-posts" label="Search for courses, jobs and travel opportunities" iwidth="447" delay="300" width="500" url="http://localhost/LGWP/?s=%s" border="1px solid #eee"]';
        echo do_shortcode($content);
        
        ?>
	
<?php get_footer(); ?>