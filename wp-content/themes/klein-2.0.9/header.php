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
    <div id="bp-klein-top-bar">
                <nav id="bp-klein-user-bar" class="container" role="navigation">
                        <div class="row">
                                <div class="col-md-8 col-sm-8">
                                        <p class="remove-bottom site-description">
                                                <?php bloginfo('description'); ?>
                                        </p>
                                </div>
                                <div id="bp-klein-user-bar-action" class="col-md-4 col-sm-4">
                                        <div class="pull-right">
      <?php if( is_user_logged_in() ){ ?>
                                                        <?php
                                                                global $current_user;
                                                                get_currentuserinfo();
                                                                $user_login = $current_user->user_login;
                                                        ?>
                                                        <?php if( function_exists('bp_core_get_user_domain' ) ){ ?>
                        <a id="klein-top-bp-profile-link" class="btn btn-primary" href="<?php echo bp_core_get_user_domain( $current_user->ID );?>" title="<?php _e('My Profile','klein'); ?>">
                                                                        <?php echo $current_user->display_name; ?>
                                                                </a>
                                                                <?php klein_user_nav(); ?>
                                                        <?php } ?>
                                                <?php }else{ ?>
<a data-toggle="modal" id="klein-login-btn" class="btn btn-primary" href="#klein_login_modal" title="<?php _e( 'Login', 'klein' ); ?>"><i class="icon-lock"></i> <?php _e( 'Login', 'klein' ); ?></a>
                                        <?php echo str_replace( '<a', '<a id="klein-register-btn" title="'.__('Register','klein').'" class="btn btn-primary" ', wp_register('', '', false)); ?>
                                                        <div class="modal fade" id="klein_login_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                                        <h4 class="modal-title">
                                                                                                <?php _e( sprintf( 'Login to %s', get_bloginfo( 'name' ) ),'klein' ); ?>
                                                                                        </h4>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                        <?php do_action( 'klein_before_login_form_modal_body' ); ?>
<div class="modal-social">
                                                                                <div class="new-fb-btn new-fb-4 new-fb-default-anim">
<div class="new-fb-4-1">
<div class="new-fb-4-1-1">
<a href="http://lostgrad.com/login/?loginFacebook=1&amp;redirect=http://localhost/LGWP" onclick="window.location = 'http://lostgrad.com/login/?loginFacebook=1&amp;redirect='+window.location.href; return false;">Log In with facebook</a></div>
</div>
</div>
&nbsp;

<div class="new-twitter-btn new-twitter-4 new-twitter-default-anim">
<div class="new-twitter-4-1">
<div class="new-twitter-4-1-1"><a href="http://lostgrad.com/login/?loginTwitter=1&amp;redirect=http://localhost/LGWP" onclick="window.location = 'http://lostgrad.com/login/?loginTwitter=1&amp;redirect='+window.location.href; return false;">Log In with twitter</a></div>
</div>
    </div>
</div>
                                                                                                <?php wp_login_form(); ?>
                                                                                        <?php do_action( 'klein_after_login_form_modal_body' ); ?>
                                                                                </div>
                                                                        </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                        </div><!-- /.modal -->
                                                <?php } ?>
                                        </div>

 </div>
                        </div>
                </nav>
        </div>
    
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
