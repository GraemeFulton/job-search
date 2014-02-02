<?php
/*
   Plugin Name: BuddyPress Custom Profile Menu Pro
   Plugin URI: http://sensibleplugins.com/
   Version: 1.3.3
   Author: Sensible Plugins
   Description: Finally a plugin to fully customize the BuddyPress profile menu. Just start by creating a normal menu under Appearance->Menus, then select this menu in the plugin's settings page. Once you do that, your front-end BuddyPress profile menu will automatically be customized to fully reflect your new configuration. Enjoy :)
   Text Domain: bp-custom-profile-menu
*/


if(function_exists('SP_BPCPM_PluginAlreadyActivatedAdminError'))
{
    add_action('admin_notices', 'SP_BPCPM_PluginAlreadyActivatedAdminError');
    return false;
}
else
{
    
define('SP_BPCPM_PRO', 1);

    
function SP_BPCPM_PluginAlreadyActivatedAdminError() 
{
    echo '<div class="updated fade" style="background-color:#FFE8E8; border-color:#FFBABA; padding:5px;"><strong>Error:</strong> Only one version of the <strong>BuddyPress Custom Profile Menu</strong> plugin should be activated. If you are trying to activate the Pro version, please make sure you deactivate the free version first.</div>';
}


include_once('bp-custom-profile-menu_init.php');
SP_BPCPM_init(__FILE__);
    
}


