=== Text to Custom Field ===
Contributors: WordpressReady
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=AGGAL5MFNEBBE&lc=UY&item_name=WordpressReady&item_number=0043&no_note=1&no_shipping=1&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted
Author URI: http://www.wordpressready.com
Plugin URI http://wordpressready.com/downloads/
Tags: xmlrpc,custom field, field, post
Requires at least: 2.9
Tested up to: 3.3.1 
Stable Tag: 1.11

Allows adding custom fields from ANY desktop blog editor even if the editor can't support custom fields!

== Description ==

The plugin works similar as shortcodes with important differences:

* It looks for any tag in the post with the following format: **{cf your_custom_field_name=your_custom_field_value}**
* For any tag found, it create a custom field for that post.
* The tag is erased from the post.

= How to use =

Type in anywhere in a post:
{cf your_custom_field_name=your_custom_field_value}

Examples:

* **{cf thumbnail=http://wordpressready.com/wp-content/uploads/oneringtorulethemall.jpg}**
* **{cf posticon=/wp-content/uploads/posticon.ico}**
* **{cf my_custom_color=#22fb30}**

This three examples written inside the post will create three custom fields with respectives values
when you publish the post.
After publishing, the tag inside the post are deleted. No other information is erased.

= Notes =

* Because the way the plugin works, it will run fine with ANY desktop blogger(Windows Live Writer, Scribefire, Qumana, w.Bloggar, Zoundry
, Thingamablog, Blod Desk, Flock, Post2Blog, Bleezer, you name it)
* The plugin can be used even inside the wordpress editor (though what would it be the point?)
* You can use any number of custom field for post. 
* Reserved characters: '{cf' and '}',because it conflicts with the delimiters.
* After the post, the tags are automatically erased.
* If the custom field is already present, its value will be replaced.

== Installation == 

1. Unzip the ZIP file and drop the folder straight into your `wp-content/plugins/` directory.
2. Activate the plugin 'Text to Custom Field' through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

* What if I use the tag twice? for example {cf my_custom_value=Anna} , {cf my_custom_value=Jessy} in the same post?
Answer: The plugin scans the post from top to bottom and update the custom fields in that order.
In the strange case you do that, the last tag will take precedence over the first one, where
the final value would be **my_custom_value=Jessy**

* Do I need to use quotes (') or double quotes (") to assign values to the custom fields?
Answer: No quotes or double quotes are needed. But if you use it, they would be assigned to the custom field, so be careful!

* What if there is already a custom field with that name?
Answer: Any custom field with same name is updated

* What if I want to delete a custom field?
Answer: This version does not delete a custom field. The best it can do is assign an empty value to a custom field as {cf my_custom_field= }

* Any character or exception to consider?
the '}' can't be inside an evaluation. For example: {cf my_custom_field=hello {there} } won't work as expected since the plugin can't 
decide what is the last character. The final evaluation would be **my_custom_field=hello {there**. 
In the same fashion the character combination '{cf' can't be inside an assignation.

* What if I have another question related to this plugin?
Answer: Contact with admin@wordpressready.com for any questions.

== Screenshots ==

screenshot-1.png

== Changelog ==

=1.1=

* using {cf custom_field_name } to avoid conflict with shortcodes. cf is an abreviation of 'custom fields'
* Improved documentation

=1.0=

* Initial release (not for public)
