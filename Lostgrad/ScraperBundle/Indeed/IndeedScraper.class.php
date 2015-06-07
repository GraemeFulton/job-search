<?php

Class IndeedScraper extends JobScraperAbstract{

    private $feed_type;
   public function scrape($wpdb, $feed_type){
     
       $this->feed_type = $feed_type;
       
    $resp= $this->getArray();
        
        if($feed_type=='API'){
            foreach($resp->results->result as $result)
            {
                $date = new DateTime( $result->date);
                $format_date= $date->format("Y-m-d H:i:s"); 

              $this->updateJobDetails(
                      $wpdb, 
                      $this->category,//profession
                      "id_indeed", 
                      $result->company, 
                      $result->formattedLocation,
                      $result->url, 
                      $result->jobtitle,  
                      $result->snippet,  //description
                      $result->snippet, //exerpt 
                      $result->company, //company name used for image search
                      "indeed",//tags
                      "indeed",//provider
                      $this->post_type, //post-type
                      $this->post_type_meta, //job type
                      $format_date //indeed's publish date
                       );

            }
        }
        elseif ($feed_type=='RSS'){

                foreach ($resp->channel->item as $result) 
                {
                   $date = new DateTime( $result->pubDate);
                   $format_date= $date->format("Y-m-d H:i:s");    
                   
                   $this->updateJobDetails(
                      $wpdb, 
                      $this->category,//profession
                      "id_indeed", 
                      $result->source, 
                      'UK',
                      $result->link, 
                      $result->title,  
                      $result->description,  //description
                      $result->description, //exerpt 
                      $result->source, //company name used for image search
                      "indeed",//tags
                      "indeed",//provider
                      $this->post_type, //post-type
                      $this->post_type_meta, //job type
                      $format_date //indeed's publish date
                       );
                }



        }
   }
   
    
    
    
     public function getArray()
    {        // Get cURL resource
        $url=$this->urlToScrape; 
        echo '<h1>'.$url.'</h1>';
        if($this->feed_type=='API'){
            //parse xml feed
            
          $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, $url); // get the url contents
      
        $data = curl_exec($curl); // execute curl request
        curl_close($curl);
        
        return new SimpleXMLElement($data);  
            
        }
        elseif($this->feed_type=='RSS'){
            //parse simple rss feed
          return $rss=  simplexml_load_file($this->urlToScrape);
            
        }
        
    }
    
}
?>
