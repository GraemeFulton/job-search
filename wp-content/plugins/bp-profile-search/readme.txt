=== BP Profile Search ===
Contributors: dontdream
Tags: buddypress, member, members, user, users, friend, friends, profile, profiles, search, filter
Requires at least: BP 1.8
Tested up to: BP 1.9.2
Stable tag: 3.6

Lets visitors search your BuddyPress Members Directory and their Friends list.

== Description ==

BP Profile Search adds a configurable search form to your BuddyPress site, to let visitors search your Members Directory and their Friends list.

You can insert the search form in your Members Directory page, in a sidebar or widget area, or in any post or page.

When visitors click the *Search* button, they are redirected to your Members Directory page showing their search results. The *All Members* tab shows all the results, while the *My Friends* tab shows the results found among your visitor's friends.

= Translations =

* Italian (it_IT)
* Russian (ru_RU), by [Ivan Dyakov](http://olymproject.org/)
* Serbo-Croatian (sr_RS), by [Borisa Djuraskovic, WebHostingHub](http://www.webhostinghub.com/)
* Spanish (es_ES), by [Andrew Kurtis, WebHostingHub](http://www.webhostinghub.com/)

== Installation ==

After the standard plugin installation procedure, you'll be able to access the plugin settings page *Users -> Profile Search*, where you can build and customize your search form.

= Form Fields =

In this section you can:

* Add and remove form fields
* Enter the field label and description, or leave them empty to use the default
* Enable the *Value Range Search* for numeric fields, or the *Age Range Search* for date fields
* Change the order of the fields

= Add to Directory =

With this option you can insert your search form in your Members Directory page. If you enable *Add to Directory*, you can also:

* Enter the HTML text for the optional form header
* Enable the *Toggle Form* option
* Enter the text for the *Toggle Form* button

= Text Search Mode =

With this option you can select your text search mode, between:

* *Partial Match*: a search for *John* finds *John*, *Johnson*, *Long John Silver*, and so on
* *Exact Match*: a search for *John* finds *John* only

In both modes, two wildcard characters are available:

* *% (percent sign)*: matches any text, or no text at all
* *_ (underscore)*: matches any single character

= Display your search form =

After you build your search form, you can display it:

* In your Members Directory page, selecting the option *Add to Directory*
* In a sidebar or widget area, using the widget *Profile Search*
* In a post or page, using the shortcode **[bp_profile_search_form]**
* Anywhere in your theme, using the PHP code<br>
**&lt;?php do_action ('bp_profile_search_form'); ?&gt;**

== Changelog ==

= 3.6 =
* Redesigned settings page, added Help section
* Added customization of field label and description
* Added *Value Range Search* for multiple numeric fields
* Added *Age Range Search* for multiple date fields
* Added reordering of form fields
* Updated Italian translation
* Updated Russian translation
= 3.5.6 =
* Replaced deprecated $wpdb->escape() with esc_sql()
* Added *Clear* link to reset the search filters
= 3.5.5 =
* Fixed the CSS for widget forms and shortcode generated forms
= 3.5.4 =
* Added the Serbo-Croatian translation
= 3.5.3 =
* Added Spanish, Russian and Italian translations
= 3.5.2 =
* Fixed a pagination bug introduced in 3.5.1
= 3.5.1 =
* Fixed a few conflicts with other plugins and themes
= 3.5 =
* Added the *Add to Directory* option
* Fixed a couple of bugs with multisite installations
* Ready for localization
* Requires BuddyPress 1.8 or higher
= 3.4.1 =
* Added *selectbox* profile fields as candidates for the *Value Range Search*
= 3.4 =
* Added the *Value Range Search* option (Contributor: Florian Shießl)
= 3.3 =
* Added pagination for search results
* Added searching in the *My Friends* tab of the Members Directory
* Removed the *Filtered Members List* option in the *Advanced Options* tab
* Requires BuddyPress 1.7 or higher
= 3.2 =
* Updated for BuddyPress 1.6
* Requires BuddyPress 1.6 or higher
= 3.1 =
* Fixed the search when field options contain trailing spaces
* Fixed the search when field type is changed after creation
= 3.0 =
* Added the *Profile Search* widget
* Added the [bp_profile_search_form] shortcode
= 2.8 =
* Fixed the *Age Range Search*
* Fixed the search form for required fields
* Removed field descriptions from the search form
* Requires BuddyPress 1.5 or higher
= 2.7 =
* Updated for BuddyPress 1.5 multisite
* Requires BuddyPress 1.2.8 or higher
= 2.6 =
* Updated for BuddyPress 1.5
= 2.5 =
* Updated for BuddyPress 1.2.8 multisite installations
= 2.4 =
* Added the *Filtered Members List* option in the *Advanced Options* tab
= 2.3 =
* Added the choice between *Partial match* and *Exact match* for text searches
= 2.2 =
* Added the *Age Range Search* option
= 2.1 =
* Added the *Toggle Form* option to show/hide the search form
* Fixed a bug where no results were found in some installations
= 2.0 =
* Added support for *multiselectbox* and *checkbox* profile fields
* Added support for % and _ wildcard characters in text searches
= 1.0 =
* First version released to the WordPress Plugin Directory
