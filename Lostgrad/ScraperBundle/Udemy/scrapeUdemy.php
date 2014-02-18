<?php
require "../../SiteBundle/Course.php";

require_once "../ScraperAbstract.class.php"; 
require "../CourseScraperAbstract.class.php";
require "./UdemyScraper.class.php";

# create and load the HTML
include('../simplehtmldom/simple_html_dom.php');
////////////////////////////////////////////////////////////
//Just set the following variables, then run the script:////
///////////////////////////////////////////////////////////
?>
<html>
<body>
<h2>Udemy Course Generator</h2>
<form action="?action=generatePosts" method="post">
    URL: <input type="text"  size="150" name="url"><br><small>e.g.'https://www.udemy.com/courses/Business/?view=list&sort=popularity'</small><br>

    Subject: <input type="text"  size="150" name="cat"><br><small>e.g. business</small><br>

<input type="submit" value="Generate Posts">
</form>

</body>
</html>
<?php
if(isset($_GET['action'])=='generatePosts') {
$URL= $_POST['url']; 
$category=$_POST['cat'];
if(!$category){echo 'Please insert category'; }

//can leave the next one for udemy
$initiativeURL='http://www.udemy.com';        
/////////////////////////////////////////////////////////////////
//
//
define( 'SHORTINIT', true );
require_once('../../../wp-load.php' );

$DB_USER= 'root';
$DB_NAME='lgwp';
$DB_PASS='Jinkstron3042';
$DB_HOST='localhost';


$wpdb = new wpdb( $DB_USER, $DB_PASS, $DB_NAME, $DB_HOST);
$wpdb->set_prefix('wp_');
echo "connected";

////////////////////////////////////////////////////////////////
 $scraper = new UdemyScraper();
 $scraper->Setup($URL, $initiativeURL, $category);
 $scraper->scrape($wpdb);
 
}
?>
