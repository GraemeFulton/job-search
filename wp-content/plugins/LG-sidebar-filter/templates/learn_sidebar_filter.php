<div id="lg-sidebar-filter" class="mobile-menu-side">
     
    <div class="sidebar-options">
    
    <div class="filter-tabs">
        <div class="filter-tab active-filter" id="filter-tab-1"><h4>Filters</h4></div>
        <div class="filter-tab" id="filter-tab-2"><h4>More Options</h4></div>
    </div>
            <?php require("search_filter.php");?>

 <?php    echo '<div id="Type_Filter" class="filter-tab-1"><h4 class="filter-title">Course Type</h4><br>';
          echo '<div class="page_widget">'.widgets_on_template("Course Type Filter")."</div></div>";
    
          //Subject Filter
          echo '<div class="filter-tab-1">';
          echo '<h3 class="filter-title"><i class="ico fa fa-book"></i> Subject</h3>';
          echo '<div class="page_widget">'.widgets_on_template("Subject Filter")."</div>";
          echo '</div>';
           
       	  echo '<div id="Provider_Filter" class="filter-tab-2"><h3 class="filter-title">Provider</h3>';
          echo '<div class="page_widget">'.widgets_on_template("Course Provider Filter")."</div></div>";
                 
          echo '<div class="nav-filter filter-tab-2" ><h3><i class="ico fa fa-building"></i> University</h3>'; 
          $lg_tree->display_select2_box('Select Universities');
          echo '</div>';
?>

    <?php do_action('the_action_hook'); ?>

</div>

</div>