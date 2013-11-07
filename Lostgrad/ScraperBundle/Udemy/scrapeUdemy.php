<?php
#include hotaru
require "../../SiteBundle/Course.php";
require_once('../../../config/settings.php');
require_once('../../../Hotaru.php');
$h = new Hotaru();
$h->vars['submitted_data']['submit_media'] ='text';  //prevents undefined index in media_select line 93

# create and load the HTML
include('simple_html_dom.php');

require_once "../ScraperAbstract.class.php"; 
require "../CourseScraperAbstract.class.php";
require "./UdemyScraper.class.php";
////////////////////////////////////////////////////////////
//Just set the following variables, then run the script:////
///////////////////////////////////////////////////////////

//url you will target
$URL= 'https://www.udemy.com/courses/Business/?p=4&price=free&view=list'; 

//default category id, and name of scraping session
$catID=103;

//can leave the next one for udemy
$initiativeURL='http://www.udemy.com';        
/////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
 $scraper = new UdemyScraper();
 $scraper->Setup($URL, $catID, $initiativeURL);
 $scraper->scrape($h);
?>
