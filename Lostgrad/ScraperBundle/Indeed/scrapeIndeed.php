<?php
#include hotaru
require "../../SiteBundle/Job.php";
require_once('../../../config/settings.php');
require_once('../../../Hotaru.php');
$h = new Hotaru();
$h->vars['submitted_data']['submit_media'] ='text';  //prevents undefined index in media_select line 93

# create and load the HTML
require "../ScraperAbstract.class.php"; 
require "../JobScraperAbstract.class.php";
require "./IndeedScraper.class.php";

////////////////////////////////////////////////////////////
//Just set the following variables, then run the script:////
///////////////////////////////////////////////////////////
//http://www.indeed.co.uk/jobs?q=Auditor+Audit+or+Auditor+or+Auditing+-intake+title%3A(junior+or+graduate+or+trainee+or+-programme+or+-scheme)+(auditor+or+auditing+or+audit+or+tax)
//http://api.indeed.com/ads/apisearch?publisher=2878078796677777&q=medicine+-intake+title%3A((medicine)(junior+or+graduate+or+trainee+or+-programme+or+-scheme+-2014+-2013+-charge))&v=2
    $categories = $h->getCatChildren(205);
    $category_type=11;//set this 
    
    foreach($categories as $category)
    {
        //print out the category name we are in
        $id=$category->category_id;
        $name=$h->getCatName($category->category_id);
        echo "<h1>".$name."</h1>";

        //INDEED SEARCH TERMS
        $searchTerms = $h->getCatMeta($category->category_id);

        //With all of these words:
    //    $withAllTerms = str_replace("%2C", "", $searchTerms->category_query);
        //with at least one of these words:
        $atLeastOneTerms = str_replace("%2C", "+or", $searchTerms->category_keywords);
        //with these words in the title:
        $withAllTermsOr = str_replace("%2C","+or", $searchTerms->category_query);
         
        $noneOfTerms= "-intake";

                
        $withTitle="title%3A((".$withAllTermsOr.")(junior+or+graduate+or+trainee+or+-programme+or+-scheme+-2014+-2013+-charge))";
        $API= 'http://api.indeed.com/ads/apisearch?publisher=2878078796677777&q='.$atLeastOneTerms."+".$noneOfTerms."+".$withTitle.'&co=gb&userip=1.2.3.4&v=2';//&st=employer'; 

        /////////////////////////////////////////////
        //category specific changes may be necessary:
//        $category=204;
//        if($category==204){
//                    $withTitle="title%3A((".$withAllTermsOr.")(engineer+or+engineering)(junior+or+graduate+or+trainee+or+-programme+or+-scheme+-2014+-2013))";
//
//        }
//        if($category==205||$category==209) //allow posts from recruiters
//        {
//            
//        $API= 'http://api.indeed.com/ads/apisearch?publisher=2878078796677777&q='.$atLeastOneTerms."+".$noneOfTerms."+".$withTitle.'&co=gb&userip=1.2.3.4&v=2'; 
//
//        }
        ///////////////////////////////
        
        //with none of these words:


        //default category for this scrape
        $catID=$id;//equals $name

        echo "<strong>QUERY: </strong>".$API."<br>";

       $initiativeURL='http://www.indeed.com';  
        //  
        $scraper = new IndeedScraper();
        $scraper->Setup($API, $catID, $initiativeURL, $category_type);
        $scraper->scrape($h);
    }






////url you will target
//$API= 'http://api.indeed.com/ads/apisearch?publisher=2878078796677777&q=xbox+sales&st=employer&l=&start=0&end=0sort=&radius=&st=&jt=&start=&limit=25&fromage=&filter=&latlong=1&co=gb&chnl=&userip=1.2.3.4&useragent=Mozilla/%2F4.0%28Firefox%29&v=2'; 
//
////default category for this scrape
//$catID=202;//equals $name
//
//$subtag="Entry Level".$catID;
//
////can leave the next one for udemy
//$initiativeURL='http://www.indeed.com';        
///////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
// $scraper = new IndeedScraper();
// $scraper->Setup($API, $catID, $initiativeURL, $subtag);
// $scraper->scrape($h);





    //$category_tags = $h->getCatMeta($category->category_id);
    // $categorytags = str_replace("%2C", "", $category_tags->category_keywords);
    // print_r($categorytags);
?>
