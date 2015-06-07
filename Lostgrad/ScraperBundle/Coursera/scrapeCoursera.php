<?php
require "../../SiteBundle/Course.php";
require "../ScraperAbstract.class.php"; 
require "../CourseScraperAbstract.class.php";
require "./CourseraScraper.class.php";
////////////////////////////////////////////////////////////
//Just set the following variables, then run the script:////
///////////////////////////////////////////////////////////

?>

<html>
<body>
<h2>Coursera Course Generator</h2>
<form action="?action=generatePosts" method="post">
    
<input type="submit" value="Generate Posts">
</form>

</body>
</html>



<?php

if(isset($_GET['action'])=='generatePosts') {
    generatePosts();
}


function generatePosts(){
//url you will target
$URL= 'https://www.coursera.org/maestro/api/topic/list?full=1'; 

//default category id
//can leave the next one for udemy
$initURL='http://www.coursera.org';        
/////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////

echo "connecting1";
define( 'SHORTINIT', true );
require_once('../../../wp-load.php' );

echo "connecting...";
$DB_USER= 'graylien89';
$DB_NAME='lgwp';
$DB_PASS='jinkstron3042';
$DB_HOST='localhost';
$wpdb = new wpdb( $DB_USER, $DB_PASS, $DB_NAME, $DB_HOST);

echo "connected";
 $scraper = new CourseraScraper();
 $scraper->Setup($URL, $initURL, $category);
 $scraper->scrape($wpdb);
}
?>
