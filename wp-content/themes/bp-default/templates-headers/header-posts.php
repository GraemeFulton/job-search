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
	</head>

	<body <?php body_class(); ?> id="bp-default">
                        <div id="main-overlay"></div>

      <!-- Fixed navbar -->
    <div class="navbar navbar-inverse wide-nav navbar-fixed-top mobile-menu" role="navigation">
      <div class="container">
        <div class="navbar-header">
            
            <div id="sidebar-toggle">
                    <div id="toggle-icon">
                        <button type="button" class="btn navbar-inverse ">
                            <i class="fa fa-caret-square-o-left fa-2x"></i> 
                        </button>
                    </div>
                </div>            
            
            
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
                       <a class="navbar-brand" href="<?php bloginfo('url')?>"><img class="navbar-logo"src="<?php echo get_bloginfo('template_directory');?>/_inc/images/LG.png"/></a>        
        </div>
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
                    <div id="search-bar" class="desktop-search" role="search">
                            <div id="main_search">
                                <form class="navbar-form" role="search">
                                    <div class="input-group">
                                     <input type="text" class="form-control Search_Term" id='Search_Term' placeholder="Search for Posts" name="srch-term">
                                        <div class="input-group-btn">
                                        <button class="btn btn-default Search_Filter" id='Search_Filter'type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                    </div>
                                </div>
                               
                                </form>
                                                                
                            </div>
			</div><!-- #search-bar -->
            
            
<!--    <input id="toggle-button" type="button" value="Toggle Style"> -->
        </div><!--/.nav-collapse -->
      </div>
    </div>
    
		<?php do_action( 'bp_before_header' ); ?>

		<div id="header" class="header-home mobile-menu">                  
            
          		<a href="<?php echo site_url();?>/new-post"<button class="add-post-btn btn btn-primary">Add New Post</button></a>
                           
<!--                           <div id="header-quote"> -->
                        <?php //quotescollection_quote('show_author=1&show_source=1&tags=education&ajax_refresh=0&char_limit=200&random=1')?>
<!--                     </div> -->
                   <?php do_action( 'bp_header' );?>

		</div><!-- #header -->

		<?php do_action( 'bp_after_header'     ); ?>
		<?php do_action( 'bp_before_container' ); ?>
                  <div class="slider-button fixed"></div>

  <div id="search-bar" class="mobile-search mobile-menu" role="search">
                            <div id="main_search">
                                <form class="navbar-form" role="search">
                                    <div class="input-group">
                                     <input type="text" class="form-control Search_Term" id='Search_Term_Mobile' placeholder="Search for Posts" name="srch-term">
                                        <div class="input-group-btn">
                                        <button class="btn btn-default Search_Filter" id='Search_Filter_Mobile'type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                    </div>
                                </div>
                               
                                </form>
                                                                
                            </div>
			</div><!-- #search-bar -->