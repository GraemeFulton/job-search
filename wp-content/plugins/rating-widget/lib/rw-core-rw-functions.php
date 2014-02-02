<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

/* String Helpers.
--------------------------------------------------------------------------------------------*/
function rw_starts_with($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);    
}

function rw_ends_with($haystack, $needle)
{
    $length = strlen($needle);
    $start  = $length * -1; //negative
    return (substr($haystack, $start) === $needle);    
}

function rw_last_index_of($haystack, $needle)
{
    $index = strpos(strrev($haystack), strrev($needle));  

    if ($index)
    {
        $index = strlen($haystack) - strlen($needle) - $index;  
        return $index;  
    }
    
    return -1;  
}

/* Url.
--------------------------------------------------------------------------------------------*/
function rw_admin_url($path = '', $scheme = 'admin')
{
    echo rw_get_admin_url( $path, $scheme );
}

function rw_get_admin_url($path = 'admin.php', $scheme = 'admin')
{
    return add_query_arg(array('page' => WP_RW__ADMIN_MENU_SLUG), admin_url($path, $scheme));
}

function rw_get_site_url($path = '')
{
    return empty($path) ? 
        WP_RW__ADDRESS : 
        WP_RW__ADDRESS . '/' . trim($path, '/') . (false === strpos($path, '.') ? '/' : '');
}

function rw_the_site_url($path = '')
{
    echo rw_get_site_url($path);
}

function rw_get_blog_url($path = '')
{
    return rw_get_site_url('/blog/' . ltrim($path, '/'));
}

function rw_get_url_daily_cache_killer()
{
    return date('\YY\Mm\Dd');
}

function rw_get_js_url($js)
{
    if (rw_starts_with($js, 'http'))
        return $js;

    if (((!WP_RW__LOCALHOST && !WP_RW__LOCALHOST_SCRIPTS) || !WP_RW__DEBUG) && rw_ends_with($js, '.php'))
        $js = substr($js, 0, strlen($js) - 3) . 'js';
    
    return WP_RW__ADDRESS_JS . $js . '?ck=' . rw_get_url_daily_cache_killer();
}

function rw_get_css_url($css)
{
    if (rw_starts_with($css, 'http'))
        return $css;
        
    if (((!WP_RW__LOCALHOST && !WP_RW__LOCALHOST_SCRIPTS) || !WP_RW__DEBUG) && rw_ends_with($css, '.php'))
        $css = substr($css, 0, strlen($css) - 3) . 'css';
    
    return WP_RW__ADDRESS_CSS . $css . '?ck=' . rw_get_url_daily_cache_killer();
}

function rw_get_post_thumb_url($post, $width = 160, $height = 100)
{
    $img = ratingwidget()->GetPostImage($post, WP_RW__CACHE_TIMEOUT_POST_THUMB_EXTRACT);    
    return rw_get_img_thumb_url(
        (false !== $img ? $img : get_permalink($post->ID)),
        $width,
        $height
    );
}

function rw_get_img_thumb_url($src, $width = 160, $height = 100)
{
    return WP_RW__ADDRESS_TMB . '?src=' . urlencode($src) . '&w=' . $width . '&h=' . $height . '&zc=1';
}

function rw_get_plugin_img_path($path)
{
    return WP_RW__PLUGIN_URL . 'resources/img/' . trim($path, '/');
}

function rw_get_plugin_css_path($path)
{
    return WP_RW__PLUGIN_URL . 'resources/css/' . trim($path, '/');
}

/* Views.
--------------------------------------------------------------------------------------------*/
function rw_get_view_path($path)
{
    return WP_RW__PLUGIN_VIEW_DIR . trim($path, '/');
}

function rw_include_view($path, &$params = null)
{
    $VARS = &$params;
    include(rw_get_view_path($path));
}

function rw_include_once_view($path, &$params = null)
{
    $VARS = &$params;
    include_once(rw_get_view_path($path));
}

function rw_require_view($path, &$params = null)
{
    $VARS = &$params;
    require(rw_get_view_path($path));
}

function rw_require_once_view($path, &$params = null)
{
    $VARS = &$params;
    require_once(rw_get_view_path($path));
}

/* Scripts and styles including.
--------------------------------------------------------------------------------------------*/
function rw_register_style($handle, $src = false, $ver = WP_RW__VERSION)
{
    wp_register_style($handle, rw_get_css_url($src), array(), $ver);
}

function rw_enqueue_style($handle, $src = false, $ver = WP_RW__VERSION)
{
    wp_enqueue_style($handle, rw_get_css_url($src), array(), $ver);
}

function rw_register_script($handle, $src = false, $ver = WP_RW__VERSION)
{
    wp_register_script($handle, rw_get_js_url($src), array(), $ver);
}

function rw_enqueue_script($handle, $src = false, $ver = WP_RW__VERSION)
{
    wp_enqueue_script($handle, rw_get_js_url($src), array(), $ver);
}

/* Redirect.
--------------------------------------------------------------------------------------------*/
function rw_admin_redirect($location = 'admin.php')
{
    rw_redirect(rw_get_admin_url($location));
    exit();
}

function rw_site_redirect($location = '')
{
    rw_redirect(rw_get_site_url($location));
    exit();
}

/* Core Redirect (coppied from BuddyPress).
--------------------------------------------------------------------------------------------*/
/**
 * Redirects to another page, with a workaround for the IIS Set-Cookie bug.
 *
 * @link http://support.microsoft.com/kb/q176113/
 * @since 1.5.1
 * @uses apply_filters() Calls 'wp_redirect' hook on $location and $status.
 *
 * @param string $location The path to redirect to
 * @param int $status Status code to use
 * @return bool False if $location is not set
 */
function rw_redirect($location, $status = 302) {
    global $is_IIS;

    if (headers_sent())
        return false;
    
    if ( !$location ) // allows the wp_redirect filter to cancel a redirect
        return false;

    $location = rw_sanitize_redirect($location);

    if ( $is_IIS ) {
        header("Refresh: 0;url=$location");
    } else {
        if ( php_sapi_name() != 'cgi-fcgi' )
            status_header($status); // This causes problems on IIS and some FastCGI setups
        header("Location: $location");
    }
}

/**
 * Sanitizes a URL for use in a redirect.
 *
 * @since 2.3
 *
 * @return string redirect-sanitized URL
 **/
 function rw_sanitize_redirect($location) {
    $location = preg_replace('|[^a-z0-9-~+_.?#=&;,/:%!]|i', '', $location);
    $location = rw_kses_no_null($location);

    // remove %0d and %0a from location
    $strip = array('%0d', '%0a');
    $found = true;
    while($found) {
        $found = false;
        foreach( (array) $strip as $val ) {
            while(strpos($location, $val) !== false) {
                $found = true;
                $location = str_replace($val, '', $location);
            }
        }
    }
    return $location;
}

/**
 * Removes any NULL characters in $string.
 *
 * @since 1.0.0
 *
 * @param string $string
 * @return string
 */
function rw_kses_no_null($string) {
    $string = preg_replace('/\0+/', '', $string);
    $string = preg_replace('/(\\\\0)+/', '', $string);

    return $string;
}

?>