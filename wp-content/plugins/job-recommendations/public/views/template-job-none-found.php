<section class='col-md-9 col-md-offset-2 col-xs-12 main-content-area'>
<?php

    include(get_stylesheet_directory().'/partials/loader.php');

     include('partials/secondary-job-loop.php');

     include(get_stylesheet_directory().'/partials/pagination.php');
</section>
<div class="container-margin-bottom">
  <h3><i class="fa fa-thumbs-o-up"></i> We've found <?php echo $wp_query->found_posts; ?> related jobs within the UK</h3>
   <p><i class="fa fa-info-circle"></i> There are no more jobs in the location you selected</p>
  </div>
