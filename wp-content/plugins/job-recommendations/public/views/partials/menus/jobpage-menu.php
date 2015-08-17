<?
$jobmenu=false;
if(strpos($_SERVER['REQUEST_URI'],'company')||strpos($_SERVER['REQUEST_URI'],'job-roll')||strpos($_SERVER['REQUEST_URI'],'graduate-job')||strpos($_SERVER['REQUEST_URI'],'?s=') ){

    $jobmenu = true;
}
elseif(strpos($_SERVER['REQUEST_URI'],'sign-up')){
    $jobmenu = true;
}

if($jobmenu==true){

  $output= '<li class="dropdown">';
  $output.='<a class="dropdown-toggle" data-toggle="dropdown" href="bootstrap-elements.html" data-target="#">';
  $output.='Categories <span class="caret"></span><div class="ripple-wrapper"></div></a>';
  $output.='<ul class="dropdown-menu">';
  echo $output;
  $professions = get_terms('profession');
  foreach($professions as $profession)
  {
    ?>
      <li class="">
        <a href="#dropdown1" data-toggle="tab" aria-expanded="true"><?php echo $profession->name;?>
        <div class="ripple-wrapper">
          <div class="ripple ripple-on ripple-out"></div>
        </div>
      </a>
    </li>
    <li class="divider"></li>
    <?php

  }
  echo '</ul>';

}

?>
