<?php
require_once('../../../wp-load.php' );
require "./IndeedScraper.class.php";

Class Indeed_Post_Gen{
   
    protected $job_type;
    protected $job_type_search_terms;
    protected $wpdb;
    
  public function __construct($job_type, $job_type_search_terms)
    {
        $this->connect_database();
        $this->job_type= $job_type;
        $this->job_type_search_terms= $job_type_search_terms;
        $this->gather_category_terms();
    }  
    
  
private function connect_database(){
    
  $DB_USER= 'root';
  $DB_NAME='lgwp';
  $DB_PASS='jinkster2312';
  $DB_HOST='localhost';
  //set class database connection
  $this->wpdb= new wpdb( $DB_USER, $DB_PASS, $DB_NAME, $DB_HOST);
    
}


/*
 * gather_category_terms 
 * queries the database to build an array of post terms which will be used 
 * in searching for jobs
 */
private function gather_category_terms(){
    
  $sql="SELECT term_tax.description, term_tax.term_taxonomy_id, t.name
                from wp_term_taxonomy as term_tax
                INNER JOIN wp_terms as t
                ON term_tax.term_id=t.term_id
                WHERE term_tax.taxonomy= 'profession'
                ";
        
        $safe_sql= $this->wpdb->prepare($sql);
        $results=$this->wpdb->get_results($safe_sql);
        
        $this->perform_scrape($results);
        
}


/*
 * perform_scrape 
 * loops through each category provided, and performs a scrape
 */
  private function perform_scrape($categories){
             
         if (!$categories){echo '<p style="background:#eaeaea;">No tags to search for.</p><hr>'; return;}
         
         foreach($categories as $category)
         {  
            echo '<li>'.$category->name.'<br>';//indeed search terms
            echo '<br>Search String: '.$search_term=  (str_replace(' ', '%20', $category->name));
            
            $API= $this->build_search_string($category);
            if ($API){
                echo '<p style="background:#FDFFC2;">API Search: '.$API.'</p><hr>';

                //do the api search!
                $initiativeURL='http://www.indeed.com';  

                $scraper = new IndeedScraper();
                $scraper->Setup($API, $initiativeURL, $category->name, 'graduate-job', $this->job_type);
                $scraper->scrape($this->wpdb);            
            }
         }   
             
   }
   
   
   
   /*
    *build_search_string
    *@param: search_term - takes a search term from the perform_scrape loop
    *@return: API - returns an api search string formatted depending on search term 
    */
   private function build_search_string($category){
       
            //string manipulation to create title and search
            $category_no_space= str_replace(' ', '+', $category->description);
            $category_indeed_format= str_replace(',', '+or', $category_no_space);
            $chunks = explode("/", $category_indeed_format);
                
            //title and search
            $title= substr($chunks[0], 0, -1);//remove trailing +
            $search= substr($chunks[1], 1);//remove +from beginning
            
            //get rid of all parents (they dont have search chunk)
           
            echo '<br><b>Title</b>: '.$title.' <b>Search</b>: '.$search.'<br>';
       
                    //if graduate jobs
                  if($this->job_type=='a:1:{i:0;s:15:"graduate_scheme";}'){

                      $withTitle="title%3A((".$title.")+(".$this->job_type_search_terms."))";
                     return $API= 'http://api.indeed.com/ads/apisearch?publisher=2878078796677777&q='.$withTitle.'&co=gb&userip=1.2.3.4&v=2';//st=employer'; 


                  }
                  
                  //if entry level
                  elseif($this->job_type=='a:1:{i:0;s:11:"entry_level";}'){
                
                      if($search!=''){
                            $withTitle="title%3A((".$search.")+(".$this->job_type_search_terms."))";//put search term in title
                           return $API= 'http://api.indeed.com/ads/apisearch?publisher=2878078796677777&q='."+".$withTitle.'&co=gb&userip=1.2.3.4&v=2&st=employer'; 
                        }
                  }
            
   }
}


?>
