<?php

/*
 *	THIS SOURCE CODE AND ANY ACCOMPANYING DOCUMENTATION ARE PROTECTED BY UNITED STATES 
 *	INTELLECTUAL PROPERTY LAW AND INTERNATIONAL TREATIES. UNAUTHORIZED REPRODUCTION OR 
 *	DISTRIBUTION IS SUBJECT TO CIVIL AND CRIMINAL PENALTIES. YOU SHALL NOT DEVELOP NOR
 *	MAKE AVAILABLE ANY WORK THAT COMPETES WITH A "SENSIBLE PLUGINS" PRODUCT DERIVED FROM THIS 
 *	SOURCE CODE. THIS SOURCE CODE MAY NOT BE RESOLD OR REDISTRIBUTED ON A STAND ALONE BASIS.
 *
 *	USAGE OF THIS SOURCE CODE IS BOUND BY THE LICENSE AGREEMENT PROVIDED WITH THE 
 *	DOWNLOADED PRODUCT.
 *
 *      Copyright 2012 Sensible Plugins. All rights reserved.
 *
 *
 *	This notice may not be removed from this file.
 *
 */

require_once( SP_BP_ABSPATH . 'SP_BPCPM_MenuComponent.php' );

class SP_BPCPM_MenuItemComponent_Pro extends SP_BPCPM_MenuItemComponent
{
    function setup_nav()
    {
        // Add the submenu items
        $menu_slug = $this->get_menu_slug($this->menu_item);
        $submenu_array = $this->submenus;
        
        $has_access = bp_is_my_profile() || $this->is_slug_public($menu_slug);
        
        // BuddyBar compatibility
	$domain = bp_displayed_user_domain() ? bp_displayed_user_domain() : bp_loggedin_user_domain();
        
        $menu_url = trailingslashit( $domain . $menu_slug );
        $i=0;
        foreach ($submenu_array as $submenu) 
        {
            $submenu_slug = $this->get_menu_slug($submenu);
            $this->sub_nav[] = array(
                           'name'            => $this->get_menu_name($submenu),
                           'slug'            => $submenu_slug,
                           'parent_url'      => $menu_url,
                           'parent_slug'     => $menu_slug,
                           'screen_function' => array(&$this, 'menu_screen'),
                           'position'        => $i,
                           'item_css_id'     => $submenu_slug,
                           'user_has_access' => $has_access
                           );
            $i += 1;
        }
        
        parent::setup_nav();
    }
    
    function setup_admin_bar() 
    {
        // Setup the logged in user variables
        $user_domain  = bp_loggedin_user_domain();
        $menu_slug = $this->get_menu_slug($this->menu_item);
        $menu_url = trailingslashit( $user_domain . $menu_slug );

        // Add the submenu items
        $submenu_array = $this->submenus;
        foreach ($submenu_array as $submenu) 
        {
            $submenu_slug = $this->get_menu_slug($submenu);

            $this->wp_admin_nav[] = array(
                                'parent' => 'my-account-' . $menu_slug,
                                'id'     => 'my-account-' . $menu_slug . $submenu_slug,
                                'title'  => $this->get_menu_name($submenu),
                                'href'   => trailingslashit( $menu_url . $submenu_slug )
                                );
        }
        
        parent::setup_admin_bar();
    }
    
    // overrides super class
    function is_slug_public($slug) 
    {
        $slug_public = false;
        
        $option_key = $this->options_manager->ispublicOptionKey($slug);
        if($this->options_manager->getOption($option_key))
            $slug_public = true;
        
        return $slug_public;
    }
}

?>
