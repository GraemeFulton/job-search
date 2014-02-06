<?php
/*
Plugin Name: Extended API
Plugin URI: http://www.michaelgrosser.com
Description: This makes all of the common WordPress functions available via XML RPC rather than having to use pre-defined WP XML-RPC methods.
Author: Michael Grosser
Version: 0.8
Author URI: http://www.michaelgrosser.com
*/

//Check the WP version - Requires 3.0+
global $wp_version;
$exit_msg = 'Extended API Requires WordPress 3.0 or newer. You are currently running WordPress ' . $wp_version . '. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>';
if (version_compare($wp_version, "3.0", "<"))
{
    exit($exit_msg);
}

//Add a filter for XML RPC Methods
add_filter( 'xmlrpc_methods', 'createXmlRpcMethods' );

/**
 * Generate the Response
 *
 * @param methods Array - list of existing XMLRPC methods
 * @return methods Array - list of updated XMLRPC methods
 */
function createXmlRpcMethods($methods)
{
    $functions = get_defined_functions();

    $wp_functions = $functions['user'];
    $methods[get_option('namespace') . '.callWpMethod'] = 'wpext_response';
    return $methods;
}

/**
 * Generate the Response
 *
 * @param Array (username, password, wp method name, arguments for method)
 * @return Mixed (response from WP method)
 */
function wpext_response($params)
{
    //Separate Params from Request
    $username = $params[0];
    $password = $params[1];
    $method   = $params[2];
    $args     = $params[3];

    // List of Allowed WP Functions
    $allowed_functions = get_option('allowed_functions');
	
    global $wp_xmlrpc_server;
    // Let's run a check to see if credentials are okay
    if ( !$user = $wp_xmlrpc_server->login($username, $password) ) {
            return $wp_xmlrpc_server->error;
    }    

    if (function_exists($method) && in_array($method, $allowed_functions))
    {
        try
        {
            if (!empty($args))
                return call_user_func_array($method,&$args);
        } catch (Exception $e) {
            return new IXR_Error( 401, __( 'This is not working.' ) );
        }
        
    } else {
	return new IXR_Error( 401, __( 'Sorry, the method ' . $method . ' does not exist or is not allowed.' ) );
    }
}

/*
 * Add a Settings page for this Plugin.
 */
add_action('admin_menu', 'extapi_create_menu');
function extapi_create_menu()
{
    add_options_page( 'Extended API Settings', 'Extended API', 'administrator', 'extapisettings', 'extapi_settings_page');
}

/*
 * Register the custom options for this plugin.
 */
add_action( 'admin_init', 'extapi_register_settings' );
function extapi_register_settings()
{
    //register settings
	register_setting( 'extapi_settings', 'extapi_installed');
    register_setting( 'extapi_settings', 'allowed_functions' );
    register_setting( 'extapi_settings', 'namespace', 'validate_namespace' );
}

/*
 * If the user deletes the namespace, set it back to the default.
 */
function validate_namespace($input)
{
    $input = trim($input);
	if (empty($input))
            $input = 'extapi';
        
	return $input;
}


/*
 * Function to display the settings page.
 */
function extapi_settings_page()
{
	global $extapi_available_functions;
    include('settings_page.php');
}

/**
 * Run this when the plugin is activated. This will make sure options
 * are setup.
 */
register_activation_hook(__FILE__,'extapi_install');
function extapi_install()
{
    //Make sure settings are registered
    extapi_register_settings();	
}

/** Check and see if we need to run setup. We're doing this
 *  here instead of the register_activation_hook to ensure two things:
 *  1. WordPress is fully loaded.
 *  2. If the plugin was activated in schema.php, it doesn't call the hook
 */
add_action('wp_loaded', 'verify_install');
function verify_install()
{
	if (!get_option('extapi_installed'))
	{
		setup_options();
	}
}

function setup_options()
{
    //Setup Default Namespace
    $namespace = get_option('namespace');
    if (empty($namespace))
        update_option('namespace','extapi');

    //Setup Default Allowed Functions
    $allowed_functions = get_option('allowed_functions');
    if (empty($allowed_functions))
    {
        $allowed_functions = array();
        $functions = get_defined_functions();
        foreach ($functions['user'] as $function)
        {
            $allowed_functions[] = $function;
        }
        update_option('allowed_functions',$allowed_functions);
    }
	
	update_option('extapi_installed',true);
}

function logError($data)
{
	if (is_object($data) || is_array($data))
		$data = print_r($data, true);

	$data .= "\r\n";
	$log_file = 'log/system.log';

	$fh = fopen($log_file, "a+");
	fwrite($fh,$data);
	fclose($fh);
}

// we need to set the defined functions here
// since others will be available in the template that we don't want.
$defined_functions = get_defined_functions();
$extapi_available_functions = $defined_functions['user'];