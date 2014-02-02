<?php
/*
Plugin Name: The Wordpress Bar
Plugin URI: http://www.anthonymontalbano.com/software/wordpress/wp-bar/
Description: Seen the DiggBar on Digg.com?  Add a similar feature to your Wordpress blog by creating a navigation bar for all external links outside of blog.  Also feature social network links such as Facebook, Twitter, Digg, and FriendFeed.
Version: 0.6.2
Author: Anthony Montalbano
Author URI: http://www.anthonymontalbano.com

Copyright 2009 Anthony Montalbano (me@anthonymontalbano.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
global $wpdb;

//define plugin urls
if ( !defined('WP_CONTENT_URL') )
    define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
if ( !defined('WP_BAR_DIR') )
    define( 'WP_BAR_DIR',WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)));
if ( !defined('WP_BAR_IMGS') )
    define( 'WP_BAR_IMGS', WP_BAR_DIR.'/imgs/');
if ( !defined('WP_BAR_JS') )
    define( 'WP_BAR_JS', WP_BAR_DIR.'/js/');

//define plugin table names
if ( !defined('WP_BARDB_LINKS') )
    define( 'WP_BARDB_LINKS', $wpdb->prefix . 'lb_links');
if ( !defined('WP_BARDB_RELATED') )
    define( 'WP_BARDB_RELATED', $wpdb->prefix . 'lb_related');

//array of available social networks
$socialNetworks =  array(
	"facebook" => array("Facebook","facebook.png","http://www.facebook.com/share.php?u=THELINK&amp;t=TITLE"),
	"digg" => array("Digg","digg.png","http://digg.com/submit?phase=2&amp;url=THELINK&amp;title=TITLE"),
	"delicious" => array("Delicious","delicious.png","http://del.icio.us/post?url=THELINK&amp;title=TITLE"),
	"stumbleupon" => array("StumbleUpon","stumbleupon.png","http://www.stumbleupon.com/submit?url=THELINK&amp;title=TITLE"),
	"twitter" => array("Twitter","twitter.png","http://twitter.com/home?status=THELINK"),
	"email" => array("Email","email.png","mailto:?subject=TITLE&amp;body=THELINK"),
	"fark" => array("Fark","fark.png","http://cgi.fark.com/cgi/fark/farkit.pl?h=TITLE&amp;u=THELINK"),
	"google" => array("Google","google.png","http://www.google.com/bookmarks/mark?op=edit&amp;bkmk=THELINK&amp;title=TITLE"),
	"linkedin" => array("LinkedIn","linkedin.png","http://www.linkedin.com/shareArticle?mini=true&amp;url=THELINK&amp;title=TITLE&amp;source=BLOGNAME&amp;summary=TITLE"),
	"live" => array("Live","live.png","https://favorites.live.com/quickadd.aspx?marklet=1&amp;url=THELINK&amp;title=TITLE"),
	"myspace" => array("Myspace","myspace.png","http://www.myspace.com/Modules/PostTo/Pages/?u=THELINK&amp;t=TITLE"),
	"newsvine" => array("Newsvine","newsvine.png","http://www.newsvine.com/_tools/seed&amp;save?u=THELINK&amp;h=TITLE"),
	"friendfeed" => array("FriendFeed","friendfeed.png","http://www.friendfeed.com/share?title=TITLE&amp;link=THELINK"),
	"reddit" => array("Reddit","reddit.png","http://reddit.com/submit?url=THELINK&amp;title=TITLE"),
	"slashdot" => array("Slashdot","slashdot.png","http://slashdot.org/bookmark.pl?title=TITLE&amp;url=THELINK"),
	"technorati" => array("Technorati","technorati.png","http://technorati.com/faves?add=THELINK")
);

//add wp actions
if(function_exists('add_action'))
	add_action('admin_menu', 'add_wp_bar');

if ( !defined('WP_BAR_CUR_LINK') )
	define( 'WP_BAR_CUR_LINK',clean_input($_SERVER['QUERY_STRING']));

$uid="";

//considerable thanks to Adi Wong @riceblogger.com
$wpbar_options = get_option("wpbar_options");
if(isValidURL(WP_BAR_CUR_LINK) && $wpbar_options['enabledEasyLink']) {
   print "<meta http-equiv=\"REFRESH\" content=\"0;url=".get_option('siteurl')."/?".isInDB(WP_BAR_CUR_LINK)."\">";
   exit();
} elseif(WP_BAR_CUR_LINK!="") {
	$uid = $wpdb->get_var($wpdb->prepare("SELECT id FROM ".WP_BARDB_LINKS." WHERE link_uid = %s",WP_BAR_CUR_LINK));
}

if(!is_page() && !is_feed() && $uid!="")
	add_action('wp_head', 'redirect_wpbar');
	
if(WP_BAR_CUR_LINK!="" && $uid!="") {
	$behavior = $wpdb->get_var($wpdb->prepare("SELECT link_behavior FROM ".WP_BARDB_LINKS." WHERE id = %d",$uid));
	if($behavior==0)
		view_wp_bar(WP_BAR_CUR_LINK);
	else {
		$clicks = $wpdb->get_var($wpdb->prepare("SELECT link_clicks FROM ".WP_BARDB_LINKS." WHERE id = %d",$uid)) + 1;
		$wpdb->update(WP_BARDB_LINKS,array('link_clicks'=>$clicks,'link_lastclick'=>date("Y-m-d H:i:s",time())),array('id'=>$uid),array('%d','%s'),array('%d'));
		print "<meta http-equiv=\"REFRESH\" content=\"0;url=".$wpdb->get_var("SELECT link_url FROM ".WP_BARDB_LINKS." WHERE id = '$uid';")."\">";
		exit();
	}
}
	
//add wp hooks
register_activation_hook(__FILE__, 'wpbar_install');

//add wp filters
add_filter('the_content', 'replace_links');

$wpbar_options = get_option("wpbar_options");
if($wpbar_options["blogroll"])
	add_filter('get_bookmarks', 'replace_blogroll');


//add the options to wp admin menu
function add_wp_bar() {
	add_options_page('The Wordpress Bar Management', 'The Wordpress Bar', 8, 'wpbar', 'wp_bar_options');
}

function view_wp_bar($uid) {
	global $wpdb,$socialNetworks;
	//get link variables
	$results = $wpdb->get_results($wpdb->prepare("SELECT link_url, link_clicks, id FROM ".WP_BARDB_LINKS." WHERE link_uid = %s",$uid));
	foreach($results as $uri) {
		$source = $uri->link_url;
		$clicks = $uri->link_clicks;
		$lid = $uri->id;
	}

	$wpdb->update(WP_BARDB_LINKS,array('link_clicks'=>($clicks+1),'link_lastclick'=>date("Y-m-d H:i:s",time())),array('link_uid'=>$uid),array('%d','%s'),array('%s'));
	
	$homeURL = get_bloginfo('home');
	$wpbar_options = get_option("wpbar_options");
	
	$web_page = @file_get_contents($source);
	$srcTitle = return_title($web_page);
	if(strlen($srcTitle)>100)
		$srcTitle = substr($srcTitle,0,100)."...";
	
	if(@file_get_contents("http://".get_domain($source)."/favicon.ico"))
		$siteIcon = "<img src=http://".get_domain($source)."/favicon.ico align=left>";
	
	$homeTitle = $wpbar_options["title"];
	if($homeTitle=="")
		$homeTitle2=get_option('blogname');
	else $homeTitle2 = $homeTitle;
	
	$numrelated = $wpdb->get_var($wpdb->prepare("SELECT id FROM ".WP_BARDB_RELATED." WHERE lid = %d",$lid));
	
	$bigTitle = $homeTitle2." | ".$srcTitle;
	$bigLink = $homeURL."/?".$uid;
	?>
<style type="text/css">
.wpbar {
 background:url(<?php echo WP_BAR_IMGS.$wpbar_options["bg"];
?>) repeat-x;
}
</style>
<link href="<?php echo WP_BAR_DIR; ?>/wpbar.css" rel="stylesheet" type="text/css" />
<?php if($wpbar_options["featured"]) { ?>
<script type="text/javascript" src="<?php echo WP_BAR_JS; ?>jquery-1.3.2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
	$("#show_related").click(function() {
	$("#related_posts").slideToggle(500);
	});
	});
	</script>
<?php } //end of if featured select
	
	//start to build bar
	print '<head>
            <title>'.$bigTitle.'</title>
                <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet">
                <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
                <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
                </head>
                <body>';
	print "<div class='wpbar'>";
	//generate blog recognition
	print "<div class='leftBrand'>";
	if($wpbar_options["imgurl"]!="")
		print "<a href='".$homeURL."'><img src=".$wpbar_options["imgurl"]." align='left' border='0'></a>";
	print "<a href='".$homeURL."' class='homeURL'>".$homeTitle."</a></div>";
	//generates blog title and original link
	print "<div class='sourcebox'>".$siteIcon."<b>".$srcTitle."</b>";
	$showViews = ($wpbar_options["showViews"]) ? ($clicks+1)." views " : "";
	print "<br><small>$showViews <font color='#666666'><a target='_top' href='".$source."'>Original Link</a></font></small>
               <br><a href='".$homeURL."/courses' style='background:blue; border:blue;' class='btn btn-success'><i class='fa fa-chevron-left'></i> Lostgrad Courses</a>
               <a href='".$homeURL."/graduate-jobs'  style='background:orange; border:orange;'class='btn btn-success'><i class='fa fa-chevron-left'></i> Lostgrad Graduate Jobs</a>
               </div>";
	//generates close button
	print "<div class='closeButton'><a target='_top' href='".$source."'><img src='".WP_BAR_IMGS."close.jpg' border='0'></a></div>";
	//generates social network links
	print "<div class='socialNetworks'>";	
	print "<small>".$wpbar_options["shareAction"]."</small><br>";
	foreach ($wpbar_options["share"] as $current) {
		$curSocialNetwork = $socialNetworks[strtolower($current)];
		$theLink = str_replace("THELINK",$bigLink,str_replace("TITLE",$wpbar_options["sharePrefix"]." ".$bigTitle,$curSocialNetwork[2]));
		print "<a href=\"".$theLink."\" target=\"_blank\"><img src=\"".WP_BAR_IMGS.$curSocialNetwork[1]."\" border=0 /></a> ";
	}
	print "</div>";
	if($wpbar_options["featured"] && $numrelated>0) {
		print "<div class='featured'>";	
		$featuredCSS = (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$_SERVER['HTTP_USER_AGENT'],$matched)) ? "ieFeatureButton" : "featureButton";		
		print "<a id='show_related' href='#' class='".$featuredCSS."'><strong>".$wpbar_options["featuredText"]."</strong></a>";
		print "</div>";
	}
	print "</div>";
	
        print "<iframe src='".$source."' frameborder='0' class='sourceView' noresize='noresize'></iframe>";
	print "</body>";

	exit();
}

//checks if the URL exists, return the uid for URL
function isInDB($uri,$related=true) {
	global $wpdb,$post;
	//get uid, create it if doesn't exist
	$uid = $wpdb->get_var($wpdb->prepare("SELECT link_uid FROM ".WP_BARDB_LINKS." WHERE link_url = %s",$uri));
	if($uid=="") {
		$uid=generate_uid();
		if(!isSociable($url))
			$wpdb->insert(WP_BARDB_LINKS, array('link_url'=>$uri,'link_uid'=>$uid,'link_added'=>date("Y-m-d H:i:s",time())), array('%s','%s','%s'));
	}
	//add to related
	if($related) {
		$pid = $post->ID;
		$lid = $wpdb->get_var($wpdb->prepare("SELECT id FROM ".WP_BARDB_LINKS." WHERE link_url = %s",$uri));
		$rid = $wpdb->get_var($wpdb->prepare("SELECT id FROM ".WP_BARDB_RELATED." WHERE lid = %d AND pid = %d",$lid,$pid));
		if($rid=='')
			$wpdb->insert(WP_BARDB_RELATED, array('lid'=>$lid,'pid'=>$pid),array('%d','%d'));
	}
	return $uid;
}

//checks if the domain is on the whitelist
//considerable thanks to Romeo @romeolab.com and Doug @binaryemulsion.com
function isWhiteListed($tld) {
	$wpbar_options = get_option("wpbar_options");
	$whitelist=explode("\n",$wpbar_options["whitelist"]);
	$white=false;
	for($i=0;$i<sizeof($whitelist);$i++){
		if(trim($tld)==trim(get_domain($whitelist[$i])))
			$white=true;
	}
	return $white;
}

//checks if the file extension is on the whitelist
//considerable thanks to Kevin @tranceshare.tk
function isExcludedExtension($link) {
	$wpbar_options = get_option("wpbar_options");
	$excExt=explode("\n",$wpbar_options["excExt"]);
	$white=false;
	for($i=0;$i<sizeof($excExt);$i++){
		if(array_pop(explode(".",trim($link)))==trim($excExt[$i]))
			$white=true;
	}
	return $white; 	
}

//redirects the page on loading of Wordpress Bar
function redirect_wpbar() {
	if(WP_BAR_CUR_LINK!="") {
		print "<meta http-equiv=\"REFRESH\" content=\"0;url=".WP_BAR_DIR.__FILE__."/?".WP_BAR_CUR_LINK."\">";
	}
}

//initial install routine when plugin is activated
function wpbar_install() {
	global $wpdb;
	
	//install default values
	$wpbar_options = array("title" => get_bloginfo('name'),
							"location" => 'top',
							"bg" => "bg1.jpg",
							"imgurl" => WP_BAR_IMGS.'logo.png',
							"share" => array("Facebook","Digg","Delicious","StumbleUpon","Twitter"),
							"sharePrefix" => "Look what I found at",
							"shareAction" => "Share this link:",
							"featured" => true,
							"blogroll" => true,
							"featuredText" => "As Featured In...",
							"whitelist" => get_domain(get_option('home')),
							"validateURL" => false,
							"showViews" => true,
							"enabledEasyLink" => true
						);
	$wpbar_link_table = ($wpdb->get_var("show tables like '".WP_BARDB_LINKS."'") != WP_BARDB_LINKS);						
	if($wpbar_link_table) {
		$sql = "CREATE TABLE ".WP_BARDB_LINKS." (
			id smallint(11) NOT NULL auto_increment,
			link_url text NULL,
			link_clicks int(12) NULL,
			link_uid text  NULL,
			link_lastclick datetime NULL,
			link_added datetime NULL,
			link_nofollow int(2) NULL,
			link_behavior int(2) NULL,
			PRIMARY KEY  (id)
		);";
		$wpdb->query($wpdb->prepare($sql));
	}
	if($wpbar_link_table || get_option("wpbar_bg")!="") {
		//remove old settings structure
		delete_option("wpbar_title");
		delete_option("wpbar_imgurl");
		delete_option("wpbar_bg");
		delete_option("wpbar_share");
		delete_option("wpbar_sharePrefix");
		delete_option("wpbar_shareAction");
		delete_option("wpbar_featured");
		delete_option("wpbar_featuredText");
		delete_option("wpbar_whitelist");
		delete_option("wpbar_blogroll");
		//save new settings structure
		update_option("wpbar_options", $wpbar_options);
	}
	//checks if nofollow field is in database, if not add it
	$tableFields = mysql_list_fields(DB_NAME, WP_BARDB_LINKS);
	for($i=0;$i<mysql_num_fields($tableFields);$i++){
		$field_array[] = mysql_field_name($fields, $i);
	}
	if (!in_array("link_nofollow", $field_array))
		mysql_query("ALTER TABLE ".WP_BARDB_LINKS." ADD link_nofollow INT(2) NULL;");
	if (!in_array("link_behavior", $field_array))
		mysql_query("ALTER TABLE ".WP_BARDB_LINKS." ADD link_behavior INT(2) NULL;");
	
	//considerable thanks to Michael Writhe
	mysql_query("ALTER TABLE ".WP_BARDB_LINKS." CHANGE 'id' 'id' SMALLINT( 11 ) NOT NULL AUTO_INCREMENT ,
				CHANGE 'link_url' 'link_url' TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL ,
				CHANGE 'link_clicks' 'link_clicks' INT( 12 ) NULL ,
				CHANGE 'link_uid' 'link_uid' TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL ,
				CHANGE 'link_lastclick' 'link_lastclick' DATETIME NULL ,
				CHANGE 'link_added' 'link_added' DATETIME NULL ,
				CHANGE 'link_nofollow' 'link_nofollow' INT( 2 ) NULL ,
				CHANGE 'link_behavior' 'link_behavior' INT( 2 ) NULL");
		
	if($wpdb->get_var("show tables like '".WP_BARDB_RELATED."'") != WP_BARDB_RELATED) {
		$sql = "CREATE TABLE ".WP_BARDB_RELATED." (
				id INT NOT NULL AUTO_INCREMENT ,
				lid INT NULL ,
				pid INT NULL ,
				PRIMARY KEY (id)
		);";
		$wpdb->query($wpdb->prepare($sql));
	}	
}


//displays necessary CSS for message
function wpbar_message($message) {
	echo "<div id=\"message\" class=\"updated fade\"><p>$message</p></div>\n";
}

//deletes link stats
function deleteLink($linkid) {
	global $wpdb;
	$wpdb->query($wpdb->prepare("DELETE FROM ".WP_BARDB_LINKS." WHERE id=%d",$linkid));
}

//clears link stats
function clearLink($linkid) {
	global $wpdb;
	$wpdb->update(WP_BARDB_LINKS,array('link_clicks'=>0,'link_lastclick'=>0),array('id'=>$linkid),array('%d','%d'),array('%d'));
}

//apply nofollow to link
function applyNofollow($linkid) {
	global $wpdb;
	$wpdb->update(WP_BARDB_LINKS,array('link_nofollow'=>1),array('id'=>$linkid),array('%d'),array('%d'));
}
//remove nofollow to link
function removeNofollow($linkid) {
	global $wpdb;
	$wpdb->update(WP_BARDB_LINKS,array('link_nofollow'=>0),array('id'=>$linkid),array('%d'),array('%d'));
}

//just redirect to source
function redirectToSource($linkid) {
	global $wpdb;
	$wpdb->update(WP_BARDB_LINKS,array('link_behavior'=>1),array('id'=>$linkid),array('%d'),array('%d'));
}
//show The Wordpress Bar
function applyShowWpBar($linkid) {
	global $wpdb;
	$wpdb->update(WP_BARDB_LINKS,array('link_behavior'=>0),array('id'=>$linkid),array('%d'),array('%d'));
}

//applys actions to selected links
function applyBulkLinkAction($action,$checked) {
	$linkNum=sizeof($checked);
	if($action=="clear-selected") {
		foreach ($checked as $linkid) {
			clearLink($linkid);
		}
		wpbar_message($linkNum.' external link stats cleared!');
	}
	if($action=="delete-selected") {
		foreach ($checked as $linkid) {
			deleteLink($linkid);
		}
		wpbar_message($linkNum.' external link stats deleted!');
	}
	if($action=="apply-nofollow") {
		foreach ($checked as $linkid) {
			applyNofollow($linkid);
		}
		wpbar_message('Nofollow applied to '.$linkNum.' external links!');
	}
	if($action=="remove-nofollow") {
		foreach ($checked as $linkid) {
			removeNofollow($linkid);
		}
		wpbar_message('Nofollow removed from '.$linkNum.' external links!');
	}
	if($action=="show-wpbar") {
		foreach ($checked as $linkid) {
			applyShowWpBar($linkid);
		}
		wpbar_message($linkNum.' external links with show The Wordpress Bar!');
	}
	if($action=="redirect-source") {
		foreach ($checked as $linkid) {
			redirectToSource($linkid);
		}
		wpbar_message($linkNum.' external links redirect to source!');
	}
}
  
//show admin menu
function wp_bar_options() {
	global $wpdb,$socialNetworks;
	
	if(isset($_REQUEST['saveWPBar']) && $_REQUEST['saveWPBar']) {
		$shareLinks = array();
		foreach ($socialNetworks as $curSocialNetwork) {
			if($_POST[$curSocialNetwork[0]]==$curSocialNetwork[0]) { $shareLinks[] = $curSocialNetwork[0]; }
		}
		$newSettings = array("title" => clean_input($_POST['barTitle']), 
							 "bg" => clean_input($_POST['bcolor']),
							 "imgurl" => clean_input($_POST['barImgUrl']),
							 "share" => $shareLinks, 
							 "sharePrefix" => clean_input($_POST['sharePrefix']), 
							 "shareAction" => clean_input($_POST['shareAction']),
							 "featured" => clean_input($_POST['barFeatured']), 
							 "blogroll" => clean_input($_POST['applyBlogroll']), 
							 "featuredText" => clean_input($_POST['featuredText']),
							 "whitelist" => clean_input($_POST['whitelisted']),
							 "excExt" => clean_input($_POST['excExtension']),
							 "validateURL" => clean_input($_POST['validateURL']),
							 "showViews" => clean_input($_POST['showViews']),
							 "enabledEasyLink" => clean_input($_POST['enabledEasyLink'])
							 );
		update_option("wpbar_options", $newSettings);
	
		wpbar_message('The Wordpress Bar Settings Saved!');
	}
	
	
	if(isset($_REQUEST['dobulk_links'])) {
		applyBulkLinkAction($_POST['action'],$_POST['checked']);
	}
	
	if(isset($_REQUEST['saveId'])) {
		$link_uids = $_POST['link_uid'];
		while($linkUid = current($link_uids)) {
			$uid = $wpdb->get_var($wpdb->prepare("SELECT link_uid FROM ".WP_BARDB_LINKS." WHERE link_uid = %s AND id <> %d",$linkUid,key($link_uids)));
			$cuid = $wpdb->get_var($wpdb->prepare("SELECT link_uid FROM ".WP_BARDB_LINKS." WHERE id = %d",key($link_uids)));
			if($uid=="") {
				$wpdb->update(WP_BARDB_LINKS,array('link_uid'=>htmlspecialchars($linkUid)),array('id'=>key($link_uids)),array('%s'),array('%d'));
			} else {
				wpbar_message('Identifier already exists: Could not rename '.$cuid.' to '.$linkUid);
			}
			next($link_uids);
		}
		wpbar_message(" Link Identifiers Updated!");
	}
	
	$wpbar_options = get_option("wpbar_options");
	?>
<script type="text/javascript">
	function showEdit(id) {
		document.getElementById('show'+id).style.display = "none";
		document.getElementById('edit'+id).style.display = "block";
	}
	</script>
<div class="wrap">
  <h2>The Wordpress Bar Settings</h2>
  <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <div id="poststuff" style="width:650px;">
    <div class="postbox">
      <h3>Blog Recognition</h3>
      <div class="inside">
        <table class="form-table" style="width:600px;">
          <tr>
            <td colspan="2">Customize the The Wordpress Bar Blog Recognition by adding a title or logo or both.</td>
          </tr>
          <tr>
            <td width="120" valign="top"><strong>The Wordpress Bar Title:</strong></td>
            <td><input type="text" value="<?php print $wpbar_options["title"]; ?>" class="regular-text" name="barTitle" size="40" />
              <br />
              <?php _e('Type a title for you blog.  This will appear on the left side of the The Wordpress Bar.'); ?></td>
          </tr>
          <tr>
            <td valign="top"><strong>The Wordpress Bar Logo URL:</strong></td>
            <td><input type="text" value="<?php print $wpbar_options["imgurl"]; ?>" class="regular-text" name="barImgUrl" size="40" />
              <br />
              <?php _e('Provide the URL of an image to show on the left side of the The Wordpress Bar with a max height of 34px. <br><b>Tip: </b>For best results, make the image a PNG or GIF with alpha transparency.'); ?>
              <br />
              <?php if($wpbar_options["imgurl"]!="") { ?>
              <div align="right"><i>Current Wordpress Bar Logo:</i><br />
                <img src="<?php print $wpbar_options["imgurl"]; ?>" /></div>
              <?php } ?></td>
          </tr>
          <tr>
            <td valign="top"><strong>The Wordpress Bar Featured:</strong></td>
            <td><input type="checkbox" value="true" name="barFeatured" <?php if($wpbar_options["featured"]) { print "checked='checked'"; } ?> />
              <br />
              <?php _e('This will include a button that will list all of the posts the current link is featured in.'); ?></td>
          </tr>
          <tr>
            <td valign="top"><strong>Featured Text:</strong></td>
            <td><input type="text" value="<?php print $wpbar_options["featuredText"]; ?>" class="regular-text" name="featuredText" size="40" />
              <br />
              <?php _e('This is the text that will display in the Featured button.'); ?></td>
          </tr>
          <tr>
            <td valign="top"><strong>Show views:</strong></td>
            <td><input type="checkbox" value="true" name="showViews" <?php if($wpbar_options["showViews"]) { print "checked='checked'"; } ?> />
              <br />
              <?php _e('This will show how many views this link has had through your blog.'); ?></td>
          </tr>
          <tr>
            <td valign="top"><strong>Enabled Easy Link Creation:</strong></td>
            <td><input type="checkbox" value="true" name="enabledEasyLink" <?php if($wpbar_options["enabledEasyLink"]) { print "checked='checked'"; } ?> />
              <br />
              <?php _e('This will allow you to easily create URL viewable by the Wordpress Bar by just adding a ?http://www.alinkhere.com at the end of your blog\'s URL. For example <b>'.get_bloginfo('home').'?http://www.google.com</b> will automatically create a short link for google displaying The Wordpress Bar'); ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="postbox">
      <h3>Bar Color</h3>
      <div class="inside">
        <table class="form-table" >
          <tr>
            <td colspan="2">Choose the color that you would like to make The Wordpress Bar.</td>
          </tr>
          <tr>
            <td colspan="2"><table border="0">
                <tr>
                  <?php 	for($i=1;$i<=5;$i++) { ?>
                  <td width="40" align="center"><img src="<?php print WP_BAR_IMGS; ?>bg<?php print $i; ?>.jpg" /></td>
                  <?php } ?>
                </tr>
                <tr>
                  <?php 	for($i=1;$i<=5;$i++) { ?>
                  <td align="center"><input type="radio" name="bcolor" value="bg<?php print $i; ?>.jpg" <?php if($wpbar_options["bg"]=='bg'.$i.'.jpg') { print "checked='checked'"; } ?> /></td>
                  <?php } ?>
                </tr>
              </table></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="postbox">
      <h3>Social Network Share Links</h3>
      <div class="inside">
        <table class="form-table" >
          <tr>
            <td colspan="2">Select which social networks you would like to let your users share with.<br />
              <br /></td>
          </tr>
          <tr>
            <td valign="top"><strong>Share Action:</strong></td>
            <td><input type="text" value="<?php print $wpbar_options["shareAction"]; ?>" class="regular-text" name="shareAction" />
              <br />
              <?php _e('Type a share action that tells your users what to do with the selected icons below.'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><br />
              <br />
              <table border="0">
                <?php
	$i=0;
	foreach ($socialNetworks as $curSocialNetwork) {
		$isActive="";
		if(($i%4)==0) { print "<tr>"; }
		print "<td align=\"left\">";
		if(is_array($wpbar_options["share"])) {
			if(in_array($curSocialNetwork[0],$wpbar_options["share"])) { $isActive = "checked='checked'"; }
		}
		print "<input type=\"checkbox\" name=\"".$curSocialNetwork[0]."\" value=\"".$curSocialNetwork[0]."\" $isActive />";
		print " <span style='padding:0 25px 15px 0'><img src=\"".WP_BAR_IMGS.$curSocialNetwork[1]."\" /> ".$curSocialNetwork[0];
		print "</span></td>";
		if(($i%4)==4) { print "</tr>"; }
		$i++;
	}	
	?>
              </table>
              <br />
              <br /></td>
          </tr>
          <tr>
            <td valign="top"><strong>Share Prefix:</strong></td>
            <td><input type="text" value="<?php print $wpbar_options["sharePrefix"]; ?>" class="regular-text" name="sharePrefix" />
              <br />
              <?php _e('Type a prefix for you share links.  This will be added to the beginning of the share link text.'); ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="postbox">
      <h3>The Wordpress Bar Exclusions</h3>
      <div class="inside">
        <table class="form-table" >
          <tr>
            <td colspan="2"><h4>Whitelisted Domains</h4>
              <?php _e('This is a list of domains that you do not want to be viewable by the The Wordpress Bar.'); ?>
              <textarea cols="50" rows="8" name="whitelisted"><?php print $wpbar_options["whitelist"]; ?></textarea>
              <br />
              <small>Enter the domains to whitelist, one per line.</small></td>
          </tr>
          <tr>
            <td colspan="2"><h4>Exclude files with the following extension</h4>
              <?php _e('This is a list of extensions that you do not want to be viewable by the The Wordpress Bar.'); ?>
              <textarea cols="50" rows="8" name="excExtension"><?php print $wpbar_options["excExt"]; ?></textarea>
              <br />
              <small>Enter the file extensions to whitelist, one per line.</small></td>
          </tr>
          <tr>
            <td valign="top"><strong>Apply to Links (Blogroll):</strong></td>
            <td><input type="checkbox" value="true" name="applyBlogroll" <?php if($wpbar_options["blogroll"]) { print "checked='checked'"; } ?> />
              <br />
              <?php _e('This will convert the links on your blogroll to be viewed with The Wordpress Bar.'); ?></td>
          </tr>
          <tr>
            <td valign="top"><strong>Validate URLs:</strong></td>
            <td><input type="checkbox" value="true" name="validateURL" <?php if($wpbar_options["validateURL"]) { print "checked='checked'"; } ?> />
              <br />
              <?php _e('This will validate the URL is an absolute URL.  For example, if you do not want to apply The Wordpress Bar to anchor and relative links it would be a good idea to check this box.'); ?></td>
          </tr>
        </table>
      </div>
    </div>
    <input type="submit" name="saveWPBar" id="submitter" value="<?php _e("Save Settings"); ?>" class="button-primary"/>
  </form>
  <?php
	if(!isset($_GET['paged']))
		$_GET['paged']=1;
	if(!isset($_GET['orderby']))
		$_GET['orderby']=id;
	$posts_per_page = 10;
	$offset = (( $_GET['paged'] - 1 ) * $posts_per_page);
	
	switch($_GET['orderby']) {
		case 'link_url': $orderby = 'link_url';
		break;
		case 'short_link': $orderby = 'link_uid';
		break;
		case 'visits': $orderby = 'link_clicks';
		break;
		case 'date_last': $orderby = 'link_lastclick';
		break;
		case 'date_added': $orderby = 'link_added';
		break;
		default: $orderby = 'id';
	}
	
	if(isset($_GET['asc'])) {
		$order_img = "&#9650;";
		$order_dir = "ASC";
		$order = "&desc";
	} else if(isset($_GET['desc'])) {
		$order_img = "&#9660;";
		$order_dir = "DESC";
		$order = "&asc";
	} else {
		$order_img = "";
		$order = "&asc";
	}
	
	$linkbars = $wpdb->get_results("SELECT * FROM ".WP_BARDB_LINKS." ORDER BY ".$orderby." ".$order_dir);
	$max_num_pages = ceil(sizeof($linkbars)/$posts_per_page);
	
	$currentLinks = array_slice($linkbars,$offset,$posts_per_page);
	
	$page_links = paginate_links( array(
		'base' => add_query_arg( 'paged', '%#%' ),
		'format' => '',
		'prev_text' => __('&laquo;'),
		'next_text' => __('&raquo;'),
		'total' => $max_num_pages,
		'current' => $_GET['paged']
	));
	?>
</div>
<h2>External Link Stats</h2>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
  <div class="tablenav">
    <div class="alignleft actions">
      <select name="action">
        <option value="" selected="selected">Bulk Actions</option>
        <option value="clear-selected">Clear Stats</option>
        <option value="apply-nofollow">Apply NoFollow</option>
        <option value="remove-nofollow">Remove NoFollow</option>
        <option value="show-wpbar">Show The Wordpress Bar</option>
        <option value="redirect-source">Redirect to Source</option>
        <option value="delete-selected">Delete</option>
      </select>
      <input type="submit" name="dobulk_links" value="Apply" class="button-secondary action" />
    </div>
    <?php if ( $page_links ) { ?>
    <div class="tablenav-pages">
      <?php $page_links_text = sprintf( '<span class="displaying-num">' . __( 'Displaying %s&#8211;%s of %s' ) . '</span>%s',
            number_format_i18n( ( $_GET['paged'] - 1 ) * $posts_per_page + 1 ),
            number_format_i18n( min( $_GET['paged'] * $posts_per_page, sizeof($linkbars) ) ),
            number_format_i18n( sizeof($linkbars) ),
            $page_links
        ); echo $page_links_text; ?>
    </div>
    <?php } ?>
  </div>
  <div class="clear"></div>
  <table class="widefat" cellspacing="0">
  <thead>
    <tr>
      <th scope="col" class="manage-column check-column"><input type="checkbox" /></th>
      <th scope="col" width="300"><a href="?page=wpbar&orderby=link_url<?php echo $order; ?>">
        <?php _e('Link URL'); if($orderby=="link_url") print $order_img; ?>
        </a></th>
      <th scope="col"><?php _e('Behavior'); ?></th>
      <th scope="col"><?php _e('NoFollow'); ?></th>
      <th scope="col"><?php _e('Posts In'); ?></th>
      <th scope="col"><a href="?page=wpbar&orderby=short_link<?php echo $order; ?>">
        <?php _e('Short Link ID'); if($orderby=="link_uid") print $order_img;  ?>
        </a></th>
      <th scope="col"><a href="?page=wpbar&orderby=visits<?php echo $order; ?>">
        <?php _e('Visits'); if($orderby=="link_clicks") print $order_img;  ?>
        </a></th>
      <th scope="col"><a href="?page=wpbar&orderby=date_last<?php echo $order; ?>">
        <?php _e('Date Last Visited'); if($orderby=="link_lastclick") print $order_img;  ?>
        </a></th>
      <th scope="col"><a href="?page=wpbar&orderby=date_added<?php echo $order; ?>">
        <?php _e('Date Added'); if($orderby=="link_added") print $order_img;  ?>
        </a></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th scope="col" class="manage-column check-column"><input type="checkbox" /></th>
      <th scope="col"><?php _e('Link URL'); ?></th>
      <th scope="col"><?php _e('Behavior'); ?></th>
      <th scope="col"><?php _e('NoFollow'); ?></th>
      <th scope="col"><?php _e('Posts In'); ?></th>
      <th scope="col"><?php _e('Short Link ID'); ?></th>
      <th scope="col"><?php _e('Visits'); ?></th>
      <th scope="col"><?php _e('Date Last Visited'); ?></th>
      <th scope="col"><?php _e('Date Added'); ?></th>
    </tr>
  </tfoot>
  <tbody>
    <?php
	foreach($currentLinks as $thelink) {
		$result = $wpdb->query($wpdb->prepare("SELECT * FROM ".WP_BARDB_RELATED." WHERE lid=%d",$thelink->id));
		if($thelink->link_lastclick=="0000-00-00 00:00:00")
			$lastClicked="<i>Never</i>";
		else
			$lastClicked=date("F j, Y g:ia",strtotime($thelink->link_lastclick));
		print "<tr><th scope='row' class='check-column'><input type='checkbox' name='checked[]' value='".$thelink->id."' /></th>";
		print "<td>".$thelink->link_url."</td><td>";
		print ($thelink->link_behavior==0) ? "Show Wordpress Bar" : "Redirect to Source";
		print "</td><td>";
		print ($thelink->link_nofollow==0) ? "No" : "Applied";
		print "</td><td>".$result."</td><td>";
		
		//editable feature of short link ID
		print "<div class='show".$thelink->id."' id='show".$thelink->id."' style='display:block'>";
		print "<a href=".get_option('home')."/?".$thelink->link_uid." target=_blank>".$thelink->link_uid."</a> <img src=".WP_BAR_IMGS."edit.png onclick='showEdit(".$thelink->id.");'>";
		print "</div>";
		
		print "<div class='edit".$thelink->id."' id='edit".$thelink->id."' style='display:none'>";
		print "<input type='text' size='10' value='".$thelink->link_uid."' name='link_uid[".$thelink->id."]'><input type='submit' value='Save' name='saveId'>";
		print "</div>";
	
		//end of editable feature short link ID
		print "</td><td>".$thelink->link_clicks."</td><td>".$lastClicked."</td><td>".date("F j, Y g:ia",strtotime($thelink->link_added))."</td></tr>";
	}
	print "</tbody></table>";
	?>
</form>
<?php
	print "<div align=right><br><br><small>The Wordpress Bar is created by <a href=http://www.anthonymontalbano.com target=_blank>Anthony Montalbano</a> &copy; 2009</small></div></div>";

}

//returns content of post with links replace for Wordpress Bar
//considerable thanks to Randy @onederlnd.com/
function replace_links($content) {
	preg_match_all("/<a\s*[^>]*>(.*)<\/a>/siU", $content, $matches);
	//preg_match_all("/<a\s[^>]*>(.*?)(</a>)/siU", $content, $matches);	
	$foundLinks = $matches[0];
	$wpbar_options = get_option("wpbar_options");
	
	foreach ($foundLinks as $theLink) {
		$uri = getAttribute('href',$theLink);
		if($wpbar_options["validateURL"]) {
			if(!isWhiteListed(get_domain($uri)) && !isSociable($theLink) && isValidURL($uri) && !isExcludedExtension($uri)) {
				$uid = isInDB($uri);
				$nofollow = is_nofollow($uid) ? "rel='nofollow'" : "";
				$content=str_replace("href=\"".$uri."\"","title='Original Link: ".$uri."' ".$nofollow." href=\"".get_option('home')."/?".$uid."\"",$content);
			}
		} else {
			if(!isWhiteListed(get_domain($uri)) && !isSociable($theLink)) {
				$uid = isInDB($uri);
				$nofollow = is_nofollow($uid) ? "rel='nofollow'" : "";
				$content=str_replace("href=\"".$uri."\"","title='Original Link: ".$uri."' ".$nofollow." href=\"".get_option('home')."/?".$uid."\"",$content);
			}
		}
	}	
	return $content;
}

function is_nofollow($uid) {
	global $wpdb;
	return $wpdb->get_var($wpdb->prepare("SELECT link_nofollow FROM ".WP_BARDB_LINKS." WHERE link_uid=%s",$uid))==1;
}

function replace_link($uri,$related=true) {
	if(!isWhiteListed(get_domain($uri)) && !isExcludedExtension($uri)) {
			$uid = isInDB($uri,$related);
			return get_option('home')."/?".$uid;
	} else {
		return $uri;
	}
}

function replace_blogroll($blogroll) {
	foreach($blogroll as $bookmark)
		$bookmark->link_url = replace_link($bookmark->link_url,false);
						
	return $blogroll;
}

//does not apply function to sociable links
//considerable thanks to Garrett @blog.campusversed.com
function isSociable($fullTag) {
	return ('sociable-hovers'==getAttribute('class',$fullTag));	
}
//considerable thanks to Hazrul Azhar Jamari
function getAttribute($attrib, $tag){
  //get attribute from html tag
  $re = '/' . preg_quote($attrib) . '=([\'"])?((?(1).+?|[^\s>]+))(?(1)\1)/is';
  if (preg_match($re, $tag, $match)) {
	 return $match[2];
  }
  return false;
}

//returns domain of a url
function get_domain($link) {
	preg_match('@^(?:http://)?([^/]+)@i',$link, $internal);
	return($internal[1]);
}

function isValidURL($url) {
 return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}  

//returns title of source page
function return_title($source) {
    preg_match('@((<title\s*)([a-zA-Z]+=("|\')?[a-zA-Z0-9_-]*("|\')?\s*)*\>)([a-zA-Z0-9()-_\s.:|&#;]*)(</title>)@',$source, $output);
	return html_entity_decode(strip_tags(trim($output[0])));
}

//Creates a Unique ID for links
function generate_uid($length=8) {
	$allChars = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9','_');
	for($i=0;$i<$length;$i++) 
		$uid.=$allChars[rand(0,62)];
	return $uid;
}

//Cleans user input variables
function clean_input($var) {
	return strip_tags($var);
}
?>
