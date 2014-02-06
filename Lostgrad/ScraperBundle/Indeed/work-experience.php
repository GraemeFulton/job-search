<?php
#include hotaru
require "../../SiteBundle/Job.php";;

# create and load the HTML
require "../ScraperAbstract.class.php"; 
require "../JobScraperAbstract.class.php";
require "./IndeedScraper.class.php";

define( 'SHORTINIT', true );
require_once('../../../wp-load.php' );
?>
<html>
<body>
<h2>Indeed Work Experience Generator</h2>
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
    
    
$DB_USER= 'root';
$DB_NAME='lgwp';
$DB_PASS='jinkster2312';
$DB_HOST='localhost';
$wpdb = new wpdb( $DB_USER, $DB_PASS, $DB_NAME, $DB_HOST);

  $sql="SELECT term_tax.description, term_tax.term_taxonomy_id, t.name
                from wp_term_taxonomy as term_tax
                INNER JOIN wp_terms as t
                ON term_tax.term_id=t.term_id
                WHERE term_tax.taxonomy= 'xili_tidy_tags_profession'
                ";
        
        $safe_sql= $wpdb->prepare($sql);
        $results=$wpdb->get_results($safe_sql);
                
     foreach($results as $group)
    {       
         $profession=$group->name;
         
         echo '<b>'.$profession.'</b><br>';
            
         $sql="SELECT r.object_id, t.name
               from wp_term_relationships as r
               INNER JOIN wp_terms as t
               ON r.object_id=t.term_id
               WHERE r.term_taxonomy_id= $group->term_taxonomy_id";
        
         $safe_sql= $wpdb->prepare($sql);
         $results=$wpdb->get_results($safe_sql);
                          
         perform_scrape($wpdb,$results);
              
    }
}


   function perform_scrape($wpdb,$categories){
             
         if (!$categories){echo '<p style="background:#eaeaea;">No tags to search for.</p><hr>'; return;}
         
         foreach($categories as $category)
         {  
            echo '<li>'.$category->name.'<br>';//indeed search terms
            echo '<br>Search String: '.$search_term=  (str_replace(' ', '%20', $category->name));          
            
            $withTitle="title%3A((".$search_term.")+(internship+or+placement))";
            $API= 'http://api.indeed.com/ads/apisearch?publisher=2878078796677777&q='."+".$withTitle.'&co=gb&userip=1.2.3.4&v=2&st=employer'; 
       
            echo '<p style="background:#FDFFC2;">API Search: '.$API.'</p><hr>';
         
            //do the api search!
            $initiativeURL='http://www.indeed.com';  

            $scraper = new IndeedScraper();
            $scraper->Setup($API, $initiativeURL, $category->name, 'work-experience-job');
            $scraper->scrape($wpdb);            

         }   
             
   }
    
?>
