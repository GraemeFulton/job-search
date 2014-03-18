<div id="lg-sidebar-filter" class="mobile-menu-side">
    

    
    <div class="sidebar-options">
    
    <div class="filter-tabs">
        <div class="filter-tab active-filter" id="filter-tab-1"><h4>Filters</h4></div>
        <div class="filter-tab" id="filter-tab-2"><h4>More Options</h4></div>
    </div>
                <?php require("search_filter.php");?>

    <?php 
          
        
          echo '<div id="Type_Filter" class="filter-tab-1"><h4 class="filter-title">Job Type</h4><br>';
          echo '<div class="page_widget">'.widgets_on_template("Job Type Filter")."</div></div>";
         
          //Profession Filter
           echo '<div class="filter-tab-1">';
           echo '<h3 class="filter-title"><i class="ico fa fa-crosshairs"></i> Profession</h3>';
           echo '<div class="page_widget">'.widgets_on_template("Profession Filter")."</div>";
           echo '</div>';
         //Location Filter 
           echo '<div class="filter-tab-2">';
           echo '<h3 class="filter-title"><i class="ico fa fa-map-marker"></i> Location</h3>';
           echo '<div class="page_widget">'.widgets_on_template("Location Filter")."</div>";
           echo '</div>';

           //company filter
           echo '<div class="nav-filter filter-tab-2"><h3><i class="ico fa fa-building"></i> Company</h3>'; 
               //     $tree->display_select2_box('Select Companies');
                    echo '</div>';

          echo '<div id="Provider_Filter" class="filter-tab-2"><h3 class="filter-title">Provider</h3>';
          echo '<div class="page_widget">'.widgets_on_template("Job Provider Filter")."</div></div>";
                //  echo '</div>';
       
        
    
    ?>
</div>

</div>