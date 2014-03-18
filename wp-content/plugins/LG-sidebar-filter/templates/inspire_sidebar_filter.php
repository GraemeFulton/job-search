<div id="lg-sidebar-filter" class="mobile-menu-side">
    

    
    <div class="sidebar-options">
    
    <div class="filter-tabs">
        <div class="filter-tab active-filter" id="filter-tab-1"><h4>Filters</h4></div>
        <div class="filter-tab" id="filter-tab-2"><h4>More Options</h4></div>
    </div>
            <?php require("search_filter.php");?>

    <?php 
     //Category Filter
          echo '<div class="filter-tab-1">';
          echo '<h3 class="filter-title"><i class="ico fa fa-lightbulb-o"></i> &nbsp;Topics</h3><br>';
          echo '<div class="page_widget">'.widgets_on_template("Topic Filter")."</div>";
          echo '</div>';

 echo '<div class="nav-filter filter-tab-2" ><h3><i class="ico fa fa-tags"></i> Tags</h3>'; 
          $lg_tree->display_select2_box('Select Tags');
          echo '</div>';  
          
                    
          echo '<div class="filter-tab-2">';
          echo '<div class="page_widget">More Options Coming Soon!</div></div>';
                  
          ?>
    
    
</div>

</div>