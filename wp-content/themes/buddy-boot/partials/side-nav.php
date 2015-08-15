<?php
  $menu_name = 'primary';
  $locations = get_nav_menu_locations();
  $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
  $menuitems = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC' ) );
?>

<nav class="col-xs-0 col-md-2 menu no-pad">
<ul>
    <?php
    $count = 0;
    $group_count = 0;
    $group = array();
    $submenu = false;
    foreach( $menuitems as $item ):
        $link = $item->url;

        $activeClass='';
        $active=check_active_link($link);
        if($active==1){
          $activeClass='active';
        }


        $title = $item->title;
        // item does not have a parent so menu_item_parent equals 0 (false)
        if ( !$item->menu_item_parent ):
        // save this id for later comparison with sub-menu items
          $parent_id = $item->ID;
          $group_item['active']=$active;


          $output= '<div class="menu-group '.$activeClass.'">';
          $output.='<a href="'.$link.'" class="title">';
          $output.='<li class="withripple '.$activeClass.'">'.$title;
          $output.='<div class="ripple-wrapper"></div></li></a>';
          $group_count+=1;
        endif;

        if ( $parent_id == $item->menu_item_parent ):
           if ( !$submenu ):
             $submenu = true;
             $output.='<ul class="sub-menu">';
           endif;

           $output.=  '<a href="'.$link.'" class="title">';
           $output.='<li class="withripple '.$activeClass.'">'.$title;
           $output.='<div class="ripple-wrapper"></div></li></a>';

           if ( $menuitems[ $count + 1 ]->menu_item_parent != $parent_id && $submenu ):
             $output.='</ul>';
            $submenu = false;
          endif;
        endif;

        if ( $menuitems[ $count + 1 ]->menu_item_parent != $parent_id ):
          $output.='</div>';
          $submenu = false;
        endif;
        $group_item['output']=$output;
        $group_item['order']=$count;

        $group[$group_count]=$group_item;
        $count++;
      endforeach;

    //  echo $output;

    ?>

<?php
usort($group, function($a, $b) {
  if($a['active']==NULL)
  $a['active']=2;

  $c = $a['active'] - $b['active'];
  $c .= $a['order'] - $b['order'];
  return $c;
});
foreach ($group as $menu_group) {
  echo $menu_group['output'];
}
?>
</ul>
</nav>
