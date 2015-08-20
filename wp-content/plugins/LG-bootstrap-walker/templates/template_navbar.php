      <!-- Fixed navbar -->
    <div class="navbar wide-nav navbar-inverse navbar-fixed-top mobile-menu" role="navigation">

        <div class="navbar-header">

          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

        <a class="navbar-brand" style="" href="<?php bloginfo('url')?>">Grad Jobs</a>

        </div>
        <form class="navbar-form navbar-left" action="<?php echo home_url( '/' ); ?>">

            <div class="input-field form-group  has-feedback">
              <input style="padding-right:32px; width:350px;"type="text" class="form-control col-lg-8" placeholder="Search" value="<?php echo get_search_query(); ?>" name="s" id="s" >
              <input type="hidden" name="post_type" value="graduate-job">
              <span class="fa fa-search form-control-feedback"></span>
            </div>
        </form>

    </div>
