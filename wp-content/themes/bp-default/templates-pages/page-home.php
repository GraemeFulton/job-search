<?php 
/*
 * Template Name: Home Page
 * 
 * A Page for courses
*/

get_header();
?>

<div id="page-container">

	<div id="home-content" class='home-content'>

		<div class="padder">

		<?php do_action( 'bp_before_blog_page' ); ?>

		<div class="page" role="main">
                        
<?php 
echo do_shortcode('[widgets_on_pages id="Member Feed"]');

$post_types=['course', 'travel-opportunities','graduate-job', 'work-experience-job'];

echo '<div id="Featured_Content">';
echo "<h2>Featured Content</h2>";
foreach($post_types as $type){

do_shortcode('[profile_favourites slug="'.$type.'"]');
}
echo '</div>';
?>