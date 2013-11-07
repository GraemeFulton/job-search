=== Plugin Name ===
Contributors: michaelgrosser
Tags: API, XML-RPC, XMLRPC, Webservices
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=michaelgrosser%40gmail%2ecom
Requires at least: 3.0
Tested up to: 3.4.2
Stable tag: trunk

Extends the WordPress XML-RPC API to allow for nearly every WordPress function to be used.

== Description ==

Updated!
Fixed an issue that caused issues on certain configurations of newer versions of PHP. Please continue to contact me with any suggestions for improvements!

This plugin was made to make WordPress easier to integrate with external platforms and external code. While the existing 
WordPress XML-RPC API provides a lot of functionality, it does not provide everything. This plugin allows nearly every 
standard WordPress function to be called via API. 

Here's some examples of things you can do with this plugin that you cannot do with WordPress' "out-of-the-box" XML-RPC API:

*   Add Users
*   Update Users
*   Update Post Meta
*   Update User Meta
*   And much more!

While some of these things are possible with the other APIs WordPress supports, it's a hassle to learn multiple API specs 
just to get something done. Now, if you know the WordPress function, you can call it with this extended API.

This plugin also lets you choose a Namespace for the extended API and enable/disable all of the functions it provides access
to for security purposes. The plugin also ensures the user is valid before executing a WordPress command.

So how does it work? Easy, you simply execute an XML RPC request to WordPress as you always would, except the method you will 
always call is "callWpMethod". callWpMethod takes 4 arguments:

1. Username
1. Password
1. WordPress Method Name (e.g. get_posts)
1. WordPress Method Arguments (e.g. post_id). Note, this MUST be an array. The number of array items should be the list of parameters
you would normally pass to the method.

Warning: This is an advanced module. While it makes all functions accessible via the API, that doesn't mean it's necessarily
recommended to leave all of this open. You will need to be a programmer to make effective use of this extension. Use at your own risk. 

That said, have fun! Feel free to contact me if you have any questions or need support. Also, since this is a new project, I'm very
open to suggestions for improvements or new features, so please let me know if you'd like to see anything added to this project.

== Installation ==

To install the plugin:

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Under Settings -> Extended API confirm both the Namespace and also the functions you want enabled/disabled.
1. Start making your webservice requests!

== Frequently Asked Questions ==

= How can I use this? =
This is limited only by your resourcefulness! I use it to provide deep WordPress integrations with other platforms like Magento and non-PHP
projects.

== Screenshots ==

1. Admin panel

== Changelog ==

= 0.8 =

Fixed an issue that caused problems on newer versions of PHP.

= 0.7 =
I fixed an issue that prevented the initial setup from working if activated through schema.php. I also fixed an issue that caused some methods to appear that couldn't actually be exposed via API.

= 0.6 = 
Fixes a few problems with the namespaces and also with calling functions with multiple parameters.

= 0.5 =
Initial Release

== Upgrade Notice ==

= 0.8 =

Fixed an issue that caused problems on newer versions of PHP.

= 0.7 =
I fixed an issue that prevented the initial setup from working if activated through schema.php. I also fixed an issue that caused some methods to appear that couldn't actually be exposed via API.

= 0.6 = 
Fixes a few problems with the namespaces and also with calling functions with multiple parameters.