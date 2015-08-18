<?
$jobmenu=false;
if(strpos($_SERVER['REQUEST_URI'],'company')||strpos($_SERVER['REQUEST_URI'],'job-roll')||strpos($_SERVER['REQUEST_URI'],'graduate-job')||strpos($_SERVER['REQUEST_URI'],'?s=')||strpos($_SERVER['REQUEST_URI'],'profession') ){

    $jobmenu = true;
}
elseif(strpos($_SERVER['REQUEST_URI'],'sign-up')){
    $jobmenu = true;
}

if($jobmenu==true){

  $professions = get_terms('profession');
  $current_page='Categories';
  $output='';
  foreach($professions as $profession)
  {
    if($profession->parent==0)//if there is no parent, it is a top-level category
    {
      $name = get_profession_name($profession->name);

    $output.='<div class="submenu-group">';
    $output.= '<li class="submenu-header">';
    $output.=      '<a aria-expanded="true">'.$name;
    $output.=      '<div class="ripple-wrapper">';
    $output.=        '<div class="ripple ripple-on ripple-out"></div>';
    $output.=      '</div>';
    $output.=    '</a>';
    $output.=  '</li>';

    //get term children
    $termchildren= get_term_children( $profession->term_id, 'profession' );
         foreach($termchildren as $child)
         {
            $childprofession = get_term_by( 'id', $child, 'profession');
            $active='';
            if(strpos($_SERVER['REQUEST_URI'],$childprofession->slug)){
              $active='active';
              $current_page='<span class="archive-menu-active">'.$childprofession->name.'</span>';
            }

            $output.=  '<li class="submenu-item '.$active.'">';
            $output.=    '<a href="'. get_term_link( $childprofession ).'" aria-expanded="true">'. $childprofession->name;
            $output.=    '<div class="ripple-wrapper">';
            $output.=      '<div class="ripple ripple-on ripple-out"></div>';
            $output.=    '</div>';
            $output.=  '</a>';
            $output.='</li>';
         }
         //if no children, put submenu link to entire category
         if(!$termchildren)
              {
                $active='';
                if(strpos($_SERVER['REQUEST_URI'],$profession->slug)){
                  $active='active';
                  $current_page='<span class="archive-menu-active">'.$name.'</span>';
                }
                $output.='<li class="submenu-item '.$active.'">';
                $output.='<a href="'.get_term_link( $profession ).'" aria-expanded="true">'.$name;
                $output.='<div class="ripple-wrapper">';
                $output.='<div class="ripple ripple-on ripple-out"></div>';
                $output.=    '</div>';
                $output.=  '</a>';
                $output.='</li>';
              }

         $output.='</div>';

    }

  }
  $output.='</ul>';

  $active= '';
  if($current_page!=='Categories'){
    $active = 'current';
  }
  $outer= '<li class="dropdown '.$active.'">';
  $outer.='<a class="dropdown-toggle" data-toggle="dropdown" href="bootstrap-elements.html" data-target="#">';
  $outer.=$current_page.'<i class="material-icons" style="vertical-align:middle; font-weight:100; font-size:22px;margin-right:-5px; margin-left:2px;">keyboard_arrow_down</i><div class="ripple-wrapper"></div></a>';
  $outer.='<ul class="dropdown-menu">';

  echo $outer.$output;

  //recommended link
  if(strpos($_SERVER['REQUEST_URI'],'job-roll')||strpos($_SERVER['REQUEST_URI'],'sign-up')){
    $active = 'current';
  }
  else $active='';
  ?>
  <li class='submenu-main <?php echo $active;?>'><a href="<?php echo get_site_url();?>/job-roll">Recommended</a></li>

<?php
}
