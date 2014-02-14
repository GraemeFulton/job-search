<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
		<?php if ( current_theme_supports( 'bp-default-responsive' ) ) : ?><meta name="viewport" content="width=device-width, initial-scale=1.0" /><?php endif; ?>
		<title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

		<?php bp_head(); ?>
		<?php wp_head(); ?>
                <?php header("HTTP/1.1 200 OK");?>
                
                <script>
var $=jQuery;
$(document).ready(function(){
    var $=jQuery;
    var $content= $('.mobile-menu');
       $('#sidebar-toggle').bind('click', function(){
           $content.toggleClass('mobile-menu-open');
           $('.navbar-brand').toggleClass('nav-hide');
           $('.navbar-toggle').toggleClass('nav-hide');
           $('.navbar-nav').toggleClass('nav-hide');
           $('#main_search').toggleClass('nav-hide');
       })   
})
</script>
	</head>

	<body <?php body_class(); ?> id="bp-default">
      <!-- Fixed navbar -->
    <div class="navbar navbar-inverse wide-nav navbar-fixed-top mobile-menu" role="navigation">
      <div class="container">
          
           <div class="navbar-header">
            
               <div id="sidebar-toggle">
                    <div id="toggle-icon">
                        <button type="button" class="btn navbar-inverse">
                             <i class="fa fa-caret-square-o-left fa-2x" style="color:#eaeaea;"></i> 

                        </button>
                    </div>
                </div>
          
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
<a class="navbar-brand" href="<?php bloginfo('url')?>"><?php bloginfo('name')?></a>        </div>
        <div class="navbar-collapse collapse">
         <?php /* Primary navigation */
   wp_nav_menu( array(
        'menu'              => 'top_menu',
        'theme_location'    => 'primary',
        'depth'             => 2,
        'container'         => false,
        'container_class'   => 'collapse navbar-collapse navbar-ex1-collapse',
        'menu_class'        => 'nav navbar-nav',
        'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
        'walker'            => new wp_bootstrap_navwalker())
    );

?>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    </div>
            <div class="home-line mobile-menu"></div>
    
		<?php do_action( 'bp_before_header' ); ?>

<!-- 		<div id="header">                   -->
<!--                     <div id="search-bar" role="search"> -->
<!--                             <div id="main_search"> -->
                            <?php //get_search_form(); ?>
<!--                             </div> -->
<!-- 			</div> -->
			<!-- #search-bar -->
                          
                    			<?php //do_action( 'bp_header' );?>

<!-- 		</div> -->
		<!-- #header -->

		<?php do_action( 'bp_after_header'     ); ?>
		<?php do_action( 'bp_before_container' ); ?>
                  <div class="slider-button fixed"></div>

		<div id="container">
