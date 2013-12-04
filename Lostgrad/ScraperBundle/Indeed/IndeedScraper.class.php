<?php

Class IndeedScraper extends JobScraperAbstract{

   public function scrape($wpdb){
        
    $resp= $this->getArray();
        
    foreach($resp->results->result as $result)
    {
       
      $this->updateJobDetails(
              $wpdb, 
              $this->category,//profession
              "id_indeed", 
              $result->company, 
              $result->formattedLocation." ".$result->country,
              $result->url, 
              $result->jobtitle,  
              $result->snippet,  //description
              $result->snippet, //exerpt 
              $result->company, //company name used for image search
              "indeed",//tags
              "indeed",//provider
              $this->post_type //post-type
               );
  
    }
   }
    
    
    
     public function getArray()
    {
        // Get cURL resource
        $url=$this->urlToScrape; 
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, $url); // get the url contents
      
        $data = curl_exec($curl); // execute curl request
        curl_close($curl);
        
        return new SimpleXMLElement($data);
    }
    
    

    
    

}
?>
