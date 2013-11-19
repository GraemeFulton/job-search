<?php

Class IndeedScraper extends JobScraperAbstract{

   public function scrape($wpdb){
        
    $resp= $this->getArray();
        
    foreach($resp->results->result as $result)
    {
        
    //check if job exists, if so break here
    $job = new Job();
    $unique_snippet=urlencode($result->snippet);
    $unique_snippetQ = rtrim($unique_snippet, "+");
        echo $unique_snippetQ."<br>";

    
    $exists= $job->alternateJobRecordedCheck($wpdb,$unique_snippetQ);
    //echo urlencode($result->snippet);
       
    
                if (!$exists) {
       
        //otherwise carry on, and populate database:
      $this->updateJobDetails(
              $wpdb, 
              $this->category,//profession
              "id_indeed", 
              $result->company, 
              $result->city,
              $result->url, 
              $result->jobtitle,  
              $result->snippet,  //description
              $result->snippet, //exerpt 
              $result->company, //company name used for image search
              "indeed",//tags
              "indeed"//provider
               );
         echo "<h4 style='color:green;'> Job Inserted</h4>";
        }
        else echo "<h4 style='color:red;'> Job already exists </h4>";
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
