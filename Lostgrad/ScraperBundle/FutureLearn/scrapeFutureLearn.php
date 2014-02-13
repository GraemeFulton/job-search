<?php
require "../../SiteBundle/Course.php";

require_once "../ScraperAbstract.class.php"; 
require "../CourseScraperAbstract.class.php";
require "./FutureLearnScraper.class.php";

# create and load the HTML
include('../simplehtmldom/simple_html_dom.php');
////////////////////////////////////////////////////////////
//Just set the following variables, then run the script:////
///////////////////////////////////////////////////////////
?>
<html>
<body>
<h2>Future Learn Course Generator</h2>
<form action="?action=generatePosts" method="post">
    URL: <input type="text"  size="150" name="url"><br><small>e.g.'https://www.futurelearn.com/courses'</small><br>

    Subject: <input type="text"  size="150" name="cat"><br><small>e.g. N/A for FutureLearn</small><br>

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
$initiativeURL='http://www.futurelearn.com';        
/////////////////////////////////////////////////////////////////
//
//
define( 'SHORTINIT', true );
require_once('../../../wp-load.php' );

$DB_USER= 'root';
$DB_NAME='lgwp';
$DB_PASS='jinkster2312';
$DB_HOST='localhost';


$wpdb = new wpdb( $DB_USER, $DB_PASS, $DB_NAME, $DB_HOST);
$wpdb->set_prefix('wp_');
echo "connected";

////////////////////////////////////////////////////////////////
 $scraper = new FutureLearnScraper();
 $scraper->Setup($URL, $initiativeURL, $category);
 $scraper->scrape($wpdb);
 
}
?>
