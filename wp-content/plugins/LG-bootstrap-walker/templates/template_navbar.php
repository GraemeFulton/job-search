      <!-- Fixed navbar -->
          <div id="main-overlay"></div>

    <div class="navbar wide-nav navbar-inverse navbar-fixed-top mobile-menu" role="navigation">
        
      <div class="container">
        <div class="navbar-header">
            
            <?php if ($search==true){?>
                 <div id="sidebar-toggle">
                    <div id="toggle-icon">
                        <button type="button" class="btn navbar-inverse ">
                            <span class="glyphicon fa fa-<?php echo $icon;?> fa-2x" style="color:<?php echo $colour;?>"></span>
                        </button>
                    </div>
                </div>
                <?php }?>
            
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

        <a class="navbar-brand" href="<?php bloginfo('url')?>"><img class="navbar-logo"src="<?php echo plugins_url('images/LG.png', __FILE__);?>"/></a>        
    
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
    );?>
<?php if ($search==true){?>
                  <div id="search-bar" class="desktop-search" role="search">
                            <div id="main_search">
                                <form class="navbar-form" role="search">
                                    <div class="input-group">
                                     <input type="text" class="form-control Search_Term" id='Search_Term' placeholder="Search for <?php echo $placeholder;?>" name="srch-term">
                                        <div class="input-group-btn">
                                        <button class="btn btn-default Search_Filter" id='Search_Filter'type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                    </div>
                                </div>
                               
                                </form> 
                            </div>
			</div><!-- #search-bar -->
<?php }?>   
        </div><!--/.nav-collapse -->
      </div>
    </div>
                  <div class="slider-button fixed"></div>

		<div id="container">

<?php if ($search==true){?>
                       <div id="search-bar" class="mobile-search mobile-menu" role="search">
                            <div id="main_search">
                                <form class="navbar-form" role="search">
                                    <div class="input-group">
                                     <input type="text" class="form-control Search_Term" id='Search_Term_Mobile' placeholder="Search for <?php echo $placeholder;?>" name="srch-term">
                                        <div class="input-group-btn">
                                        <button class="btn btn-default Search_Filter" id='Search_Filter_Mobile'type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                    </div>
                                </div>
                               
                                </form> 
                            </div>
			</div><!-- #search-bar -->
<?php }?>
                        
<!--trim-->
<div class="<?php echo $header_class;?>-line mobile-menu"></div>
<div class="nav-bar-end"></div>