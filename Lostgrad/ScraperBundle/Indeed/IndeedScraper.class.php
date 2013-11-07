<?php

Class IndeedScraper extends JobScraperAbstract{

   public function scrape($h){
        
    $resp= $this->getArray();
        
    foreach($resp->results->result as $result)
    {
        
    //check if job exists, if so break here
    $job = new Job();
    $url=urlencode($result->snippet);
    $urlQ = rtrim($url, "+");
    
    $exists= $job->alternateJobRecordedCheck($h,$urlQ);
    //echo urlencode($result->snippet);
       
    
                if (!$exists) {
       
        //otherwise carry on, and populate database:
      $this->updateJobDetails(
              $h, 
              "", 
              "",  
              $result->company, 
              $result->city,
              "", 
              $result->url, 
              $result->jobtitle,  
              $result->snippet,  
              $result->company, 
              "indeed");
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
