      <!-- Fixed navbar -->
    <div class="navbar wide-nav navbar-inverse navbar-fixed-top mobile-menu" role="navigation">
        
      <div class="container">
        <div class="navbar-header">
            
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

        <a class="navbar-brand" style="color:#fff; background:#51968B" href="<?php bloginfo('url')?>">GJ</a>        
    
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

<!--                  <div id="search-bar" class="desktop-search" role="search">
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
			</div> #search-bar -->
 
        </div><!--/.nav-collapse -->
      </div>
    </div>
