<?php
#include hotaru
require "../../SiteBundle/Course.php";


# create and load the HTML
include('simple_html_dom.php');

require_once "../ScraperAbstract.class.php"; 
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
$catID=1;
$category_type=8;
$provider_id=1;//coursera
//can leave the next one for udemy
$initURL='http://www.coursera.org';        
/////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////


define( 'SHORTINIT', true );
require_once('../../../wp-load.php' );

$DB_USER= 'root';
$DB_NAME='lgwp';
$DB_PASS='jinkster2312';
$DB_HOST='localhost';
$wpdb = new wpdb( $DB_USER, $DB_PASS, $DB_NAME, $DB_HOST);

echo "connected";
 $scraper = new CourseraScraper();
 $scraper->Setup($URL, $catID, $initURL, $category_type, $provider_id);
 $scraper->scrape($wpdb);
}
////
////$post = array(
////    'post_author' => 1,
////    'post_date' => date('Y-m-d H:i:s'),
////    'post_date_gmt' => date('Y-m-d H:i:s'),
////    'post_content' => '',
////    'post_title' => 'Course 25',
////    'post_name' => 'course-25',
////    'post_excerpt' => '',
////    'post_status' => 'publish',
////    'comment_status' => 'open',
////    'ping_status' => 'open',
////    'post_modified' => date('Y-m-d H:i:s'),
////    'post_modified_gmt' => date('Y-m-d H:i:s'),
////    'post_parent' => 0,
////    'post_type' => 'course',
////    'comment_count' => 0
////);
////
////$wpdb->insert(
////    'wp_posts', 
////    $post,
////    array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' )
////);
//
//echo "<br><b>Post Inserted :)</b>";
//
/////////
// $lastInsertID= $wpdb->insert_id;
//        
//         
//$course_type = array(
//    'post_id' => $lastInsertID,
//    'meta_value'=>'a:1:{s:64:"wpcf-fields-checkboxes-option-60039c1cd5b3cf7f3d424671ae5ccc3a-2";s:1:"1";}',
//    'meta_key'=>'wpcf-course-type'
//);//meta_value = free course
//
//$wpdb->insert(
//    'wp_postmeta', 
//    $course_type,
//    array( '%d', '%s', '%s' )
//);
//
//$post_image = array(
//    'post_id' => $lastInsertID,
//    'meta_value'=>'https://coursera-course-photos.s3.amazonaws.com/6e/6a5fc6ea45cf14031527787c0e660f/CourseLogo.jpg',
//    'meta_key'=>'wpcf-post-image'
//);//meta_value = free course
//
//
//$wpdb->insert(
//    'wp_postmeta', 
//    $post_image,
//    array( '%d', '%s', '%s' )
//);
//
//echo "<br><b>Meta Inserted :)</b>";
//
//



///////////////////////
//require '../../../wp-includes/class-IXR.php';
//
//$client = new IXR_Client('http://localhost/LGWP/xmlrpc.php');
//
//$USER = 'admin';
//$PASS = 'jinkster2312';
// 
//        $content = array( 
//                 'title'=>'Free Course Test', 
//                 'description'=>'body body body {cf wpcf-course-type="1"}', 
//                 'post_type'=>'course',
//                // 'mt_keywords'=>$keywords, 
//               //  'categories'=>array($category), 
//              
//              ); 
//
//        
//        if (!$client->query('wp.newPost','', $USER,$PASS, $content, true)) 
//        {
//            die( 'Error while creating a new post' . $client->getErrorCode() ." : ". $client->getErrorMessage());  
//        }
//        $ID =  $client->getResponse();
//        
//        if($ID)
//        {
//            echo 'Post published with ID:#'.$ID;
//        }
//        
?>