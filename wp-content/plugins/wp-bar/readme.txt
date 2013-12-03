=== The Wordpress Bar ===
Contributors: italianst4
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5898022
Tags: wordpress bar,wp-bar, wpbar, link bar, diggbar, social bookmarks, digg, twitter, facebook, delicious, stumbleupon, friendfeed, linking, affiliate, short link, easy link creation
Requires at least: 2.7
Tested up to: 2.8.5
Stable tag: 0.6.2



== Description ==

WATCH THE VIDEO OVERVIEW!!  Seen the DiggBar on Digg.com?  Add a similar feature to your Wordpress blog.  Use your blog as a short link service with Easy Link Creation.  Feature any link on the internet with a custom URL such as http://www.internetriot.com/?bing. Also feature social network links such as Facebook, Twitter, and Digg.

<a href="http://www.youtube.com/watch?v=LBZxlRF_5xk">Watch this video overview of The Wordpress Plugin</a>
<br><br>
<b>Features:</b>
<ul>
<li>Feature a "DiggBar like" to all external links</li>
<li>Whitelist domains that you do not want to apply The Wordpress Bar</li>
<li>Give your users up to 16 social network sharing links</li>
<li>Title and Logo branding options for your The Wordpress Bar</li>
<li>Multiple The Wordpress Bar color options</li>
<li>Track stats for how often featured links are viewed by your users</li>
<li>"As Featured In..." - This will list all of the posts that each link is featured in.  Great way to introduce your readers to new articles!</li>
<li><strong>Easy Short Link Creation</strong> - Simply put any ? then URL after your blogs URL and The Wordpress Bar will create a new link for it, featuring The Wordpress Bar above that site.  Example:  www.internetriot.com?http://www.woot.com will create a Wordpress Bar link for woot.com.  Use your blog as a short link creation service</li>
<li><strong>Custom Link Identifiers</strong> - Customize the identifiers in your URL to make your links more memorable to your readers. Example: Make www.internetriot.com/?bing show The Wordpress Bar for Bing.com</li>
</ul>


== Installation ==

1. Install and activate the plugin through the 'Plugins' menu in WordPress
2. Update the settings and design of your The Wordpress Bar by going to Settings>The Wordpress Bar.

To make sure the The Wordpress Bar is working, create and publish a post with an external link.  View that post and click on the external link.  You should now be viewing the link with the The Wordpress Bar along the top.

If you have any issues or suggestions for the The Wordpress Bar, please post them here: <a href="http://www.anthonymontalbano.com/software/wordpress/wp-bar/">The Wordpress Bar Support</a>



== Screenshots ==

1. Administrative backend and external link stats
2. Example of the The Wordpress Bar in action

== Changelog ==

= 0.6.2 =
* Add the ability to exclude file extensions such as MP3 or JPG.  This will allow you to not apply the Wordpress Bar to particular media. (considerable thanks to Kevin Wilson)
* Added a comment link on the Featured Post drop down list.  This will allow your visitors to comment on the different posts the featured link is in. (considerable thanks to Tim)
* Fixed the overlay issue of the Featured Post to now overlay the Featured page.  This protects the size of the page from clipping at the bottom of the browser.

= 0.6.1 =
* Fixed cross-browser compatibility issues with not displaying the Wordpress Bar correctly. (considerable thanks to Syed Balkhi)
* Fixed a database table issue with defaulting null values.  (considerable thanks to Michael Writhe)

= 0.6.0 =
* Fixed critical redirect issue using wp_redirect which prevented the Wordpress Bar from potentially not showing

= 0.5.9 =
* Fixed potential vulnerabilites in SQL queries by using santized wp functions for inserts and updates (considerable thanks to Ozh)
* Fixed potential redirect vulnerability by using WP redirection
* Created a method to sanitize admin user input from injecting HTML into The Wordpress Bar customizations

= 0.5.8 =
* Fixed all PHP short tags to remove potential errors with different operating systems and server configurations (considerable thanks to Andrew)
* Shows the current logo image for The Wordpress Bar from the admin settings (considerable thanks to Steve Racine)
* Added the option to apply NoFollow attributes to each external link on your blog.  Some may find applying this to the links optimizes the potential of duplicate content. (considerable thanks to Abe)
* Each external link has the option to show the Wordpress Bar or just redirect to the source.  If you're looking to use your blog as a custom Short Link service, simply redirect to source, instead of showing The Wordpress Bar


= 0.5.7 =
* Easy Link Creation now optional (considerable thanks to Adi Wong)
* Fixed a couple validation issues
* Updated a minor variable passing issue


= 0.5.6 =
* Fixed related links issue with links that are not featured in any posts
* Take any link and create a short bar URL by adding a ?URLGOESHERE to the end of any URL on your site.  For example: myblog.com/?http://www.google.com will create a custom link and viewable by the Wordpress Bar.  Great way to share websites and keep track who visits your links.
* Optionally show link views on the Wordpress Bar
* Customize the link idenifier with something more memorable.  For example you can create a link such as myblog.com/?blogsoftware and it will show the Wordpress Bar for the link http://www.wordpress.com.  Great tool to promote other sites as affiliates!
* Fix attribute issue with URL's using + to separate keywords
* Show original link in title tag for links created by The Wordpress Bar (considerable thanks to Randy)

= 0.5.5 =
* Redesigned internal variable structure to 1/10th database queries of previous version, which means much faster loading
* FIX: Only applies default settings on new installation. If already installed, leaves the original settings
* Shows site Favicon on the bar to the left of the source title
* Created an external CSS file for bar for cleaner code and faster style changes
* Ellipses title headlines longer than 100 characters
* Paginates and adds sortability to the stats for easier visibility and stat reading
* New option to validate URLs to replace (good to protect integrity of anchor links and relative URLs)

= 0.5.4 =
* Made links in stats clickable
* Removed Pownce (discontinued service) and replaced with FriendFeed
* Option to apply The Wordpress Bar to Blogroll
* Editable "Featured In" Text

= 0.5.3 =
* Fixed URL replacement errors
* Added the "As Featured In" feature
* Shorter URL structure
* Does not apply bar to Sociable links (considerable thanks to Garrett)

= 0.5.2 =
* Completely optimized and redesigned code for even faster loading (less queries)
* Default settings optimized
* Ability to delete and clear external link stats
* Redesigned admin menu
* Change plugin name to The Wordpress Bar

= 0.5.0 =
* Updated the default settings to DB
* Add 12 more social network share link options
* Responded to user feedback updating numerous bugs

= 0.4.4 =
* Fixed internal linking issues to image
* Redefined dynamic plugin directories

= 0.4 =
* Initial public release of the WP-Bar


