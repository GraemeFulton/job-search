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
<h2>Indeed Graduate Job Generator</h2>
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
         echo '<b>'.$group->name.'</b><br>';
            
         $sql="SELECT r.object_id, t.name
               from wp_term_relationships as r
               INNER JOIN wp_terms as t
               ON r.object_id=t.term_id
               WHERE r.term_taxonomy_id= $group->term_taxonomy_id";
        
         $safe_sql= $wpdb->prepare($sql);
         $results=$wpdb->get_results($safe_sql);
        
         $with_all_terms_or='';
         
         foreach($results as $group)
         {  
            echo '<li>'.$group->name.'<br>';//indeed search terms
            $with_all_terms_or.=$group->name."+or+";            
         }
            
         if ($with_all_terms_or!=''){
         echo '<br>Search String: '.$with_all_terms=  substr((str_replace(' ', '%20', $with_all_terms_or)),0,-4);
         $noneOfTerms= "-intake";
          
         $withTitle="title%3A((".$with_all_terms.")+(junior+or+graduate+or+trainee+or+-programme+or+-scheme+-2014+-2013+-charge))";
         $API= 'http://api.indeed.com/ads/apisearch?publisher=2878078796677777&q='."+".$withTitle.'&co=gb&userip=1.2.3.4&v=2';//&st=employer'; 
       
         echo '<p style="background:#FDFFC2;">API Search: '.$API.'</p><hr>';
         
        //if we have a valid API string, we can perform the search: 
        $initiativeURL='http://www.indeed.com';  
          
        $scraper = new IndeedScraper();
        $scraper->Setup($API, $initiativeURL, $profession);
        $scraper->scrape($wpdb);
         
         }
         //otherwise we can't:
         else  echo '<p style="background:#eaeaea;">No tags to search for.</p><hr>'; 

            
    }
}
    
?>
