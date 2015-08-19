<?php

$closing_selected='';
$recent_selected='';
if(isset($_GET['order_by'])){
  if($_GET['order_by']=='closing'){
      $closing_selected='selected';
  }
  else{
    $recent_selected='selected';
  }
}
?>

<div class="pull-right menu-sort-filter">
  <select class="form-control" id="filter-select">
      <option <?php echo $recent_selected; ?> data-sort="latest">Most recent</option>
      <option <?php echo $closing_selected; ?> data-sort="closing">Closing soon</option>
  </select>
  <a class='filter-button btn btn-raised'><i class="material-icons">filter_list</i></a>
</div>
