=== Sideways8 Simple Taxonomy Images ===
Contributors: sideways8, technical_mastermind, areimann
Tags: s8, sideways8, sideways 8, taxonomy images, category images, taxonomy, category
Requires at least: 3.3
Tested up to: 3.5.1
Stable tag: 0.8.4
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

It is now easy to add images to your categories, tags, or any other custom taxonomy term!

== Description ==
This plugin was designed with themers and developers in mind. It allows for an easy way to quickly add category, tag, and custom taxonomy images to your taxonomy terms.

NOTE: This plugin is not yet intended for use by those that are not comfortable modifying their theme files and have some idea of how WordPress works. We are however working on an easy way for anyone to use this plugin so please check back later!

The admin side of things is very simple and straight forward. It adds a field to the add/edit term forms allowing you to easily add an image during the creation or editing of taxonomy terms. It also adds a column to all the taxonomy management screens so you can tell at a glance what image is attached to what taxonomy term.

To have the images show up on the site you will need to modify your theme files (for now). Just drop in one of the following functions and pass it the appropriate variables. In all examples '$tax_term' is a WordPress taxonomy term object (obtained by using a function like `get_term()`) and '$size' is an image size as defined by WordPress (e.g. 'thumbnail', 'medium', 'full', etc.). '$size' is optional and defaults to 'thumbnail'.

Returns an array with the following format:
`$image_src => array(
 'src' => URL source for the image
 'ID' => WordPress attachment ID (ALWAYS check to make sure this was returned before using ID, width, or height)
 'width' => Width of image (only returned if ID is returned)
 'height' => Height of image (only returned if ID is returned)
);`
Returns php `FALSE` on failure.
`<?php $image_src = s8_get_taxonomy_image_src($tax_term, $size); ?>`

Returns all the HTML needed to display the image, returns php `FALSE` on failure.
`<?php $image_html = s8_get_taxonomy_image($tax_term, $size); ?>`

Same as `s8_get_taxonomy_image()` except it goes ahead and echos it out
`<?php s8_taxonomy_image($tax_term, $size); ?>`

== Installation ==
1. Upload the entire `s8-simple-taxonomy-images` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==
= None yet! =

== Changelog ==
= 0.8.4 =
* Updated the media uploader to the WP 3.5 uploader, maintained backwards compatibility with older versions
* Fixed bug where two arguments were expected, only one was given for the $wpdb->prepare function
= 0.8.3 =
* More tweaks to `s8_get_taxonomy_image_src()`
* Fixed some JavaScript bugs
* Fixed an issue when adding images where it would fail to add them
* Added a thumbnail column to all taxonomies in the admin so you know what terms do and don't have images at a glance
* Added the option to remove an image from a taxonomy
* Made the add/remove image process more robust and end-user friendly
= 0.8.2 =
* Fixed an issue where `s8_get_taxonomy_image_src()` could return an empty image source instead of false.
= 0.8.1 =
* Fixed an issue where `s8_get_taxonomy_image_src()` could return an invalid array (causing issues with other functions).
= 0.8.0 =
* Initial release

== Upgrade Notice ==
= 0.8.4 =
Bug fix and update to the WP 3.5 media uploader (still compatible with older versions though)
= 0.8.3 =
Mostly bug fixes with a couple usability issues addressed.
= 0.8.2 =
Found and resolved returning empty source issue.
= 0.8.1 =
Fixed a potential issue when getting the source of the image.
= 0.8.0 =
Initial release
