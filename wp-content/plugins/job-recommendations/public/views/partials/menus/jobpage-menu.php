<?
$jobmenu=false;
if(strpos($_SERVER['REQUEST_URI'],'company')||strpos($_SERVER['REQUEST_URI'],'job-roll')||strpos($_SERVER['REQUEST_URI'],'graduate-job')||strpos($_SERVER['REQUEST_URI'],'?s=')||strpos($_SERVER['REQUEST_URI'],'profession') ){

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
    if($profession->parent==0)//if there is no parent, it is a top-level category
    {
      ?>
        <li style="float:left">
          <a href="<?php echo get_term_link( $profession ); ?>" aria-expanded="true"><?php echo $profession->name;?>
          <div class="ripple-wrapper">
            <div class="ripple ripple-on ripple-out"></div>
          </div>
        </a>
      </li>
      <li class="divider"></li>
      <?php
        //get term children
         $termchildren= get_term_children( $profession->term_id, 'profession' );
         foreach($termchildren as $child)
         {
            $term = get_term_by( 'id', $child, 'profession');
            ?>
              <li style="float:left">
                <a href="<?php echo get_term_link( $term ); ?>" aria-expanded="true"><?php echo $term->name;?>
                <div class="ripple-wrapper">
                  <div class="ripple ripple-on ripple-out"></div>
                </div>
              </a>
            </li>
            <li class="divider"></li>
            <?php
         }

    }

  }
  echo '</ul>';

}

?>
