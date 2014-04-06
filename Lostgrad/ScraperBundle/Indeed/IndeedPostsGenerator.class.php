<?php
require_once('../../../wp-load.php' );
require "./IndeedScraper.class.php";

Class Indeed_Post_Gen{
   
//      private $cities=array( "",
//          "Aberdeen","Bath","Belfast","Birmingham","Bournemouth","Bradford","Brighton","Bristol","Cambridge","Cardiff"
//       ,"Chester","Coventry","Derby","Derry","Dundee","Edinburgh","Essex","Exeter","Falkirk"
//       ,"Gateshead","Glasgow","Gloucestershire","Hull","Ipswich","Jersey","Leeds","Leicester","Lincolnshire"
//       ,"Liverpool","London","Kent","Manchester","Milton Keynes"
//       ,"Newcastle","Northampton","Norwich","Nottingham","Oxford","Peterborough","Plymouth","Portsmouth","Preston","Lancashire"
//        ,"Reading","Sheffield","Southampton","Stoke","Surrey","Swansea","Swindon","Teesside","Watford","Wolverhampton"
//       ,"Worcestershire","York"
//       );
    
    protected $job_type;
    protected $job_type_search_terms;
    protected $job_type_taxonomy;
    protected $page_type;
    protected $wpdb;
    private $feed_type='RSS';
    
    
  public function __construct($job_type, $job_type_search_terms, $job_type_taxonomy, $page_type)
    {
        $this->connect_database();
        $this->job_type= $job_type;
        $this->job_type_search_terms= $job_type_search_terms;
        $this->job_type_taxonomy = $job_type_taxonomy;
        $this->page_type = $page_type;
        
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
 * perform_scrape - Scrapes by category
 * loops through each category provided, and performs a scrape
 */
  private function perform_scrape($categories){
      
         if (!$categories){return;}
         
         foreach($categories as $category)
         {   
             $city='';
//            foreach($this->cities as $city){
             
                $API= $this->build_search_string($category, $city, $this->feed_type);
               if ($API){
                //do the api search!
                $initiativeURL='http://www.indeed.com';  

                $scraper = new IndeedScraper();
                $scraper->Setup($API, $initiativeURL, $category->name, $this->page_type, $this->job_type, $this->job_type_taxonomy);
                $scraper->scrape($this->wpdb, $this->feed_type);  
                
                }//do scrape (if api exists)
         
//            }//foreach city
            
         }//foreach category    
   }
   
   
   
   /*
    *build_search_string
    *@param: search_term - takes a search term from the perform_scrape loop
    *@return: API - returns an api search string formatted depending on search term 
    */
   private function build_search_string($category, $city){
       
       $feed_url='';
       if($this->feed_type=='API'){
          $feed_url = 'http://api.indeed.com/ads/apisearch?publisher=2878078796677777&co=gb&userip=1.2.3.4&v=2&l='.$city.'&';           
       }
       elseif($this->feed_type=='RSS'){
          $feed_url = 'http://indeed.co.uk/rss?l='.$city.'&';           
       }
            //string manipulation to create title and search
            $category_no_space= str_replace(' ', '+', $category->description);
            $category_indeed_format= str_replace(',', '+or', $category_no_space);
            $chunks = explode("/", $category_indeed_format);
                
            //title and search
            $title= substr($chunks[0], 0, -1);//remove trailing +
            $search= substr($chunks[1], 1);//remove +from beginning
            echo 'SEARCH: '.$search;
            //get rid of all parents (they dont have search chunk)
                  
                    //if graduate jobs
                  if($this->job_type=='Graduate Scheme'){

                      $withTitle="title%3A((".$title.")+(".$this->job_type_search_terms."))";
                      
                      return $API=$feed_url.'&q='.$withTitle;//st=employer'; 
                      
                  }
                  
                  //if entry level
                  elseif($this->job_type=='Entry Level'){
                     
                       //in entry level, skip over engineering cos it doesnt work well
                      if (strpos($category->name,'Civil') !== false ||
                             strpos($category->name,'Electrical') !== false  ||
                             strpos($category->name,'Industrial') !== false  ||
                              strpos($category->name,'Mechanical') !== false ||
                             strpos($category->name,'Energy') !== false

                              ) {
                                                    
                        return;
                        }
                        ///////////////////////////////////////////////////////////////
                     // elseif ($search!==''){
                       //     $withTitle="title%3A((".$search.")+(".$this->job_type_search_terms."))";//put search term in title
                        $withTitle="title%3A((".$search.")+(".$this->job_type_search_terms."))";//put search term in title
                           return $API= $feed_url.'q='."+".$withTitle;//.'&st=employer'; 
                      //  }
                  }
                  
                  elseif($this->job_type=='Internship'){

                      $withTitle="title%3A((".$title.")+(".$this->job_type_search_terms."))";
                     return $API= $feed_url.'q='.$withTitle;//st=employer'; 

                  }
                  
                  elseif($this->job_type=='Volunteer'){

                      $withTitle="title%3A((".$title.")+(".$this->job_type_search_terms."))";
                     return $API= $feed_url.'q='.$withTitle;//st=employer'; 

                  }
                  
                     elseif($this->job_type=='Student Jobs'){

                      $withTitle="title%3A((".$title.")+(".$this->job_type_search_terms."))";
                     return $API= $feed_url.'q='.$withTitle;//st=employer'; 

                  }
                  
                  
                  
                  
            
   }
}


?>
