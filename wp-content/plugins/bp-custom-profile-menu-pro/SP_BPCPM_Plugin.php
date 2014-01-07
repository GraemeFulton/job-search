<?php


if(!class_exists('SP_BPCPM_Plugin'))
{
    
define( 'SP_BPCPM_MENU_OPTIONKEY', '_custom_menu');
define( 'SP_BPCPM_MENU_ITEMS_OPTIONKEY', '_custom_menu_items');
define( 'SP_BPCPM_ISPUBLIC_OPTIONKEY', '_ispublic');


include_once('SP_BPCPM_LifeCycle.php');

class SP_BPCPM_Plugin extends SP_BPCPM_LifeCycle {

    function SP_BPCPM_BuddyPressActivated() {
        if(class_exists('BP_Component'))
            return TRUE;
        //else
        return FALSE;
    }
    
    function SP_BPCPM_BuddyPressNotActivatedAdminError() {
        echo '<div class="updated fade" style="background-color:#FFE8E8; border-color:#FFBABA; padding:5px;"><strong>Error:</strong> plugin <strong>BuddyPress Custom Profile Menu</strong> requires that the BuddyPress plugin be correctly installed, activated and configured. If you have not yet downloaded BuddyPress, you can freely download it from <a href="http://wordpress.org/extend/plugins/buddypress/">here.</a></div>';
    }
    
    function SP_BPCPM_BuddyPressCorrectVersion()
    {
        return version_compare( BP_VERSION, SP_BPCPM_MIN_REQ_BP_VERSION, '>' );
    }
    
    function SP_BPCPM_BuddyPressWrongVersionError() {
        echo '<div class="updated fade" style="background-color:#FFE8E8; border-color:#FFBABA; padding:5px;"><strong>Error:</strong> plugin <strong>BuddyPress Custom Profile Menu</strong> requires that your BuddyPress plugin version be above ' . SP_BPCPM_MIN_REQ_BP_VERSION . '.</a></div>';
    }
    
    
    /**
     * @return array of option meta data.
     */
    public function getOptionMetaData() {
        // Get the list of available menus
        $menu_list = wp_get_nav_menus();
        $menu_names = array();
        foreach ($menu_list as $menu) 
        {
            $menu_names[] = $menu->name;
        }
        array_unshift($menu_names, ''); // add an empty option
        array_unshift($menu_names, 'Select custom menu');
        $menu_option = new SP_BPCPM_Option(SP_BPCPM_MENU_OPTIONKEY, SP_BPCPM_Option::dropList, $menu_names, true);
        
        return array(
            SP_BPCPM_MENU_OPTIONKEY => $menu_option
        );
    }

    public function getPluginDisplayName() {
        return 'BuddyPress Custom Profile Menu';
    }

    /**
     * @return void
     */
    protected function installDatabaseTables() {
        //        global $wpdb;
        //        $tableName = $this->prefixTableName('mytable');
        //        $wpdb->query("CREATE TABLE IF NOT EXISTS `$tableName` (
        //            `id` INTEGER NOT NULL");
    }

    /**
     * Drop plugin-created tables on uninstall.
     * @return void
     */
    protected function unInstallDatabaseTables() {
        //        global $wpdb;
        //        $tableName = $this->prefixTableName('mytable');
        //        $wpdb->query("DROP TABLE IF EXISTS `$tableName`");
    }


    /**
     * Perform actions when upgrading from version X to version Y
     * @return void
     */
    public function upgrade() {
    }


    public function addActionsAndFilters() {
        
        // Add a 'Settings' link in the plugins page
        add_filter('plugin_action_links_' . SP_BPCPM_BASENAME, array(&$this, 'addSettingsLink'), 10, 2);

        // Add options administration page
        add_action('admin_menu', array(&$this, 'addSettingsSubMenuPage'));

        
        // Load the custom menu after BP has been loaded
        //add_action( 'bp_loaded', array(&$this, 'loadCustomMenu'));
        add_action( 'init', array(&$this, 'loadCustomMenu'));
        
        // On WordPress init, set SP_BPCPM_MENU_ITEMS_OPTIONKEY
        //add_action( 'init', array(&$this, 'setCustomMenuItemsOption'));
        
        // Insert custom css into admin head
        add_action('admin_head', array(&$this, 'admin_custom_css') );
    }

    public function addSettingsLink($links, $file) {
        
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=' . $this->getSettingsSlug() . '">Settings</a>';
        array_unshift($links, $settings_link);

        return $links;
    }

    
    public function setCustomMenuItemsOption()
    {
        $nav_menu_name = $this->getOption(SP_BPCPM_MENU_OPTIONKEY);
        $nav_menu = wp_get_nav_menu_object($nav_menu_name);
        if( !is_nav_menu( $nav_menu ) )
        {
            $this->deleteOption(SP_BPCPM_MENU_ITEMS_OPTIONKEY);
            return;
        }
        
        $menu_items = wp_get_nav_menu_items( $nav_menu->term_id );
        
        $this->updateOption(SP_BPCPM_MENU_ITEMS_OPTIONKEY, $menu_items);
    }


    public function loadCustomMenu()
    {
        if(!$this->SP_BPCPM_BuddyPressCorrectVersion())
        {
            add_action('admin_notices', array(&$this, 'SP_BPCPM_BuddyPressWrongVersionError'));  
        
            return;
        }
        
        
        global $bp;
        
        $nav_menu_name = $this->getOption(SP_BPCPM_MENU_OPTIONKEY);
        $nav_menu = wp_get_nav_menu_object($nav_menu_name);
        if( !is_nav_menu( $nav_menu ) )
        {
            $this->deleteOption(SP_BPCPM_MENU_ITEMS_OPTIONKEY);
            return;
        }
        
        // Build the menu items arrays
        $menu_items = wp_get_nav_menu_items( $nav_menu->term_id );
        if(!$menu_items)
            return;
        $top_level_menu_items = array();
        $submenu_items = array();
        $id_field = 'db_id';
        $parent_field = 'menu_item_parent';
        foreach ( $menu_items as $menu_item ) 
        {
            if ( $menu_item->$parent_field == 0 )
            {
                $top_level_menu_items[] = $menu_item;
                $submenu_items[$menu_item->$id_field] = array();
            }
            else
            {
                $submenu_items[$menu_item->$parent_field][] = $menu_item;
            }
	}
        
        
        $menu_item_pos = 1000;
        foreach ($top_level_menu_items as $menu_item)
        {
            $submenus = $submenu_items[$menu_item->$id_field];
            
            $menu_component = NULL;
            if(SP_BPCPM_PRO)
            {
                include_once('pro/SP_BPCPM_MenuComponent_Pro.php');
                $menu_component = new SP_BPCPM_MenuItemComponent_Pro($menu_item, $menu_item_pos, $submenus, $this);
            }
            else
            {
                include_once('SP_BPCPM_MenuComponent.php');
                $menu_component = new SP_BPCPM_MenuItemComponent($menu_item, $menu_item_pos, NULL, $this);
            }
            
            $slug = $menu_component->get_menu_slug($menu_item);
            $bp->$slug = $menu_component;
            
            $menu_item_pos += 10;
        }
    }
    
    function admin_custom_css()
    {
        ?>
        <style type="text/css">
            #SP_BPCPM_sortable { list-style-type: none; margin: 10px 0 0; padding: 0; width: 100%; }
            #SP_BPCPM_sortable ul { margin-left:20px; list-style: none; }
            #SP_BPCPM_sortable li { padding: 2px 0px; margin: 4px 0px;  border: 1px solid #DDDDDD; -moz-border-radius:6px}
            <?php if(SP_BPCPM_PRO) echo '#SP_BPCPM_sortable li {cursor: move;}'; ?>
            #SP_BPCPM_sortable li span { display: block; background: #f7f7f7;  padding: 5px; color:#808080; font-size:14px; font-weight:bold;}
            #SP_BPCPM_sortable li.placeholder{border: dashed 2px #ccc;background-color:#FFF;height:20px;}
            .SP_custom-item, .SP_custom-item span { background-color: #F8EDAE !important; }
        </style>
        <?php
    }
}
    
    
} // endif class_exists



