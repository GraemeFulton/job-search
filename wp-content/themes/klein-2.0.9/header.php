<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package klein
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<!-- favicon -->
<?php $favicon_default = get_template_directory_uri() . '/favicon.ico'; ?>
<?php $favicon = ot_get_option( 'favicon', $favicon_default ); ?>
<link rel="icon" href="<?php echo $favicon; ?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo $favicon; ?>" type="image/x-icon" />
<!-- favicon end -->
<!-- custom background css -->
<?php klein_custom_background(); ?>
<!-- custom background css end -->
<!-- custom typography settings -->
<?php klein_custom_typography(); ?>
<!-- custom typography settings end -->
<?php wp_head(); ?>
<link rel="stylesheet" type="text/css"href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css"/>
<script type="text/javascript"
src="http://gdc.indeed.com/ads/apiresults.js"></script>
                                    
</head>
<body <?php body_class(); ?>>
<?php
        $container_class = ot_get_option( 'container', 'fluid' );
?>
<div id="page" class="hfeed site <?php echo $container_class; ?>">
        <?php do_action( 'before' ); ?>
    
<?php //BOOTSTRAP NAV-WALKER
         do_action('bp_after_header');
 ?>
   
    
  <div class="clearfix"></div>

        <?php 
        // Revolution Slider Support
        // for front-page-rev-slider.php
        // page template
        if( klein_has_rev_slider() ){ ?>
                <div id="klein-rev-slider">
                        <?php $rev_slider_id = ot_get_option( 'front_page_slider_id', '' ); ?>
                        <?php putRevSlider( $rev_slider_id ); ?>
                </div>  
        <?php }?>
   
        <div id="main" class="container site-main">
