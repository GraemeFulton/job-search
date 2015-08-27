<?php
//get location
global $paged;
$location= $this->get_jobs_location($tree);
if(!isset($institution)){
  $institution='N/A';
}
if(!isset($location)){
  $location='N/A';
}
//get date
$post_date=get_the_time('Y-m-d', $this->post_id);
   $now = time(); // or your date as well
    $your_date = strtotime($post_date);
    $datediff = $now - $your_date;
    $total_days= floor($datediff/(60*60*24));
    $days_ago = '';
    if ($total_days>30){
        $days_ago = '<div class="time pull-right">30+ days ago</div>';
    }
    else{
      if($total_days==1){
        $lang = ' day ago';
      }
      else{
        $lang = ' days ago';
      }
       '<div class="time pull-right">'. $days_ago = ''.$total_days.$lang.'</div>';
    }


if(is_user_logged_in()==false) {
    if ($paged == 1) {
      $ahref = '<a class="job-link post-link" href="'. $link.'">';
    }
    else{
      $ahref = '<a data-toggle="modal" class="post-link" id="add-cover-photo" data-target="#myModal" data-href="'.get_permalink().'">';
    }
  }
  else {
    $ahref= '<a class="post-link" href="'.get_permalink().'">';
  }
?>

<div class="container list-main-content">
  <?php echo $ahref; ?>
    <div class="pull-left col-xs-8">
      <h4 class="title"><?php the_title(); ?></h4>
    </div>
    <div class="col-xs-4 pull-right">
        <span><?php echo $days_ago; ?></span>
    </div>
<div class="container no-pad">
   <?php echo $excerpt;?>
    <div class="meta-info">
      <i class="material-icons">business</i> <span><?php echo $institution;?></span>&nbsp;
  <i class="material-icons">place</i><span><?php echo $location;?></span>&nbsp;
    </div>
</div>
</a>
</div>
