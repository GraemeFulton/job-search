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

require_once( SP_BP_ABSPATH . 'SP_BPCPM_Plugin.php' );


define( 'SP_BPCPM_MENU_ORDER_OPTIONKEY', '_menu_order');


class SP_BPCPM_Plugin_Pro extends SP_BPCPM_Plugin 
{
    public function getPluginDisplayName() 
    {
        return 'BuddyPress Custom Profile Menu Pro';
    }
    
    public function addActionsAndFilters()
    {
        parent::addActionsAndFilters();
        
        add_action( 'bp_init', array(&$this, 'reorderBPMenus'), 10000);
        
        // define the default BP component
        add_action('init', array(&$this, 'define_default_component'), 1);
    }
    
    public function getOptionMetaData() 
    {
        $meta_array = parent::getOptionMetaData();
        
        global $bp;
        foreach ( (array) $bp->bp_nav as $user_nav_item ) 
        {
            $option_key = $this->ispublicOptionKey($user_nav_item['slug']);
            $ispublic_checkbox = new SP_BPCPM_Option($option_key, SP_BPCPM_Option::checkbox, 'Public', false);
            $meta_array[$option_key] = $ispublic_checkbox;
        }
        
        return $meta_array;
    }

    public function loadCustomMenu() 
    {
        if(!$this->SP_BPCPM_BuddyPressActivated())
        {
            add_action('admin_notices', array(&$this, 'SP_BPCPM_BuddyPressNotActivatedAdminError'));  
        
            return;
        }
        
                
        parent::loadCustomMenu();
    }

        protected function addSettingsSubMenuPageToSettingsMenu()
    {
        parent::addSettingsSubMenuPageToSettingsMenu();        
        
        // Load the scrips *only* on the plugin's settings page
        add_action('admin_print_scripts-' . $this->settings_page, array(&$this, 'load_settings_scripts'));
    }
    
    public function load_settings_scripts()
    {
        
        wp_enqueue_script('jQuery');
        wp_enqueue_script('jquery-ui-sortable');
        
    }
    
    public function reorderBPMenus()
    {
        $menu_order_array = $this->getOption(SP_BPCPM_MENU_ORDER_OPTIONKEY);
        if(!$menu_order_array)
            return;
        
        global $bp;
        foreach ( $bp->bp_nav as $user_nav_item )
        {
            $slug = $user_nav_item['slug'];
            if(array_key_exists($slug, $menu_order_array))
            {
                $order = $menu_order_array[$slug];
                
                $bp->bp_nav[$slug]['position'] = $order;
                if(has_action('bp_setup_admin_bar', array($bp->$slug, 'setup_admin_bar')))
                {
                    //remove_action('bp_setup_admin_bar', array($bp->$slug, 'setup_admin_bar'));
                    add_action( 'bp_setup_admin_bar', array($bp->$slug, 'setup_admin_bar'), $order );
                }
            }
        }
    }
    
    public function updateMenuOrderOption($data)
    {
        if(empty($data) || !is_string($data))
            return;
        
        if($data == 'reset')
        {
            $this->deleteOption(SP_BPCPM_MENU_ORDER_OPTIONKEY);
            return;
        }
        
        parse_str($data, $data);
        $order_position_array = $data['item'];
        if(empty($order_position_array))
            return;
        
        
        global $bp;
        
        $position_slug_array = array();
        foreach ( $bp->bp_nav as $user_nav_item )
        {
            $slug = $user_nav_item['slug'];
            $position = $user_nav_item['position'];

            $position_slug_array[$position] = $slug;
        }
        
        
        $menu_order_array = array();
        
        foreach ($order_position_array as $order => $position) 
        {
            if(array_key_exists($position, $position_slug_array))
            {
                $slug = $position_slug_array[$position];
                
                $menu_order_array[$slug] = $order;
                $bp->bp_nav[$slug]['position'] = $order;
            }
        }
        
        $this->updateOption(SP_BPCPM_MENU_ORDER_OPTIONKEY, $menu_order_array);
    }
    
    public function define_default_component()
    {   
        $menu_order_array = $this->getOption(SP_BPCPM_MENU_ORDER_OPTIONKEY);
        if(!$menu_order_array)
            return;
        
        // define the first tab as default
        $components = array_keys($menu_order_array);
        $first_component = $components[0];
        
        // Make sure the user can view $first_component first!
        $can_view = TRUE;
        if(!function_exists('bp_is_my_profile'))
            return;
        if(!bp_is_my_profile())
        {
            $ispublic_key = $this->ispublicOptionKey($first_component);
            if(!$this->getOption($ispublic_key))
                $can_view = FALSE;
        }
        
        if( $can_view && !defined('BP_DEFAULT_COMPONENT') )
        {
            define( 'BP_DEFAULT_COMPONENT', $first_component );
        }
        
    }
}

?>
