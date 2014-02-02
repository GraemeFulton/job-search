<?php
                               
    $component_slug = bp_current_component();

    global $bp;
    $active_menu_component = $bp->$component_slug;

    $slug = bp_current_action();
    if(!$slug)
        $slug = bp_current_item();
    if(!$slug)
        $slug = bp_current_component();

    $menu = $active_menu_component->get_menu_for_slug($slug);
    if(!$active_menu_component->submenus)
    {
        ?>
        <script>
            var nav_element = document.getElementById("subnav");
            nav_element.parentNode.removeChild(nav_element);
        </script>
        <?php 
    }
    if(!$active_menu_component->is_custom_link_menu($menu))
    {
        $content = $active_menu_component->get_content_for_slug($slug);
        echo $content;
    }
    else
    {
        $link = $menu->url;
        echo "<iframe style='custom-link-iframe' src='$link' width=100% height=600px></iframe>";
    }
           
?>