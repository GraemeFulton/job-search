<?php


// Global Definitions

define('SP_BPCPM_MIN_REQ_PHP_VERSION', '5.0');
define('SP_BPCPM_MIN_REQ_BP_VERSION', '1.5');

define('SP_BPCPM_BASENAME', plugin_basename(__FILE__));
define( 'SP_BP_FOLDER',	plugin_basename( dirname( __FILE__ ) ) );
define( 'SP_BP_ABSPATH', plugin_dir_path( __FILE__ ) );
define( 'SP_BP_URLPATH', trailingslashit( plugins_url( '/'. SP_BP_FOLDER ) ) );



/**
 * Check the PHP version and give a useful error message if the user's version is less than the required version
 * @return boolean true if version check passed. If false, triggers an error which WP will handle, by displaying
 * an error message on the Admin page
 */
function SP_BPCPM_noticePhpVersionWrong() {
    echo '<div class="updated fade">' .
      __('Error: plugin "BuddyPress Custom Profile Menu" requires a newer version of PHP to be running.',  'bp-custom-profile-menu').
            '<br/>' . __('Minimal version of PHP required: ', 'bp-custom-profile-menu') . '<strong>' . SP_BPCPM_MIN_REQ_PHP_VERSION . '</strong>' .
            '<br/>' . __('Your server\'s PHP version: ', 'bp-custom-profile-menu') . '<strong>' . phpversion() . '</strong>' .
         '</div>';
}

function SP_BPCPM_PhpVersionCheck() {
    if (version_compare(phpversion(), SP_BPCPM_MIN_REQ_PHP_VERSION) < 0) {
        add_action('admin_notices', 'SP_BPCPM_noticePhpVersionWrong');
        return false;
    }
    return true;
}


/**
 * Initialize internationalization (i18n) for this plugin.
 * @return void
 */
function SP_BPCPM_i18n_init() {
    $pluginDir = dirname(plugin_basename(__FILE__));
    load_plugin_textdomain('bp-custom-profile-menu', false, $pluginDir . '/languages/');
}




function SP_BPCPM_init($file) {

    if(!SP_BPCPM_PhpVersionCheck())
        return false;
    
    // First initialize i18n
    SP_BPCPM_i18n_init();
    
    if(SP_BPCPM_PRO)
    {
        require_once('pro/SP_BPCPM_Plugin_Pro.php');
        $aPlugin = new SP_BPCPM_Plugin_Pro();
    }
    else
    {
        require_once('SP_BPCPM_Plugin.php');
        $aPlugin = new SP_BPCPM_Plugin();
    }

    if (!$aPlugin->isInstalled()) {
        $aPlugin->install();
    }
    else {
        // Perform any version-upgrade activities prior to activation (e.g. database changes)
        $aPlugin->upgrade();
    }

    // Add callbacks to hooks
    $aPlugin->addActionsAndFilters();

    if (!$file) {
        $file = __FILE__;
    }
    // Register the Plugin Activation Hook
    register_activation_hook($file, array(&$aPlugin, 'activate'));


    // Register the Plugin Deactivation Hook
    register_deactivation_hook($file, array(&$aPlugin, 'deactivate'));
}
