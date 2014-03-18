<div id="lg-sidebar-filter" class="mobile-menu-side">
    

      <div class="sidebar-options">
    
    <div class="filter-tabs">
        <div class="filter-tab active-filter" id="filter-tab-1"><h4>Filters</h4></div>
        <div class="filter-tab" id="filter-tab-2"><h4>More Options</h4></div>
    </div>
            <?php require("search_filter.php");?>

    <?php if ( function_exists( 'display_taxonomy_tree' ) ) 
        {
          $tree= display_taxonomy_tree('destination', 'destination');

          //travel type filter
           echo '<div id="Type_Filter" class="filter-tab-1"><h4 class="filter-title">Travel Type</h4><br>';
          echo '<div class="page_widget">'.widgets_on_template("Travel Type Filter")."</div></div>";
        
          //destination filter
          echo '<div class="filter-tab-1">';
          echo '<h3 class="filter-title"><i class="ico fa fa-plane"></i> Destination</h3>';
           echo '<div class="page_widget">'.widgets_on_template("Destination Filter")."</div>";
           echo '</div>';
          
           echo '<div id="Provider_Filter" class="filter-tab-2"><h3 class="filter-title">Travel Agent</h3>';
          echo '<div class="page_widget">'.widgets_on_template("Travel Provider Filter")."</div></div>";
       }
  
    ?>
    <?php do_action('the_action_hook'); ?>

</div>

</div>