 <?php
 
abstract class JobScraperAbstract extends ScraperAbstract{

public function updateJobDetails
           (
            $h, 
            $initiative_job_id, 
            $initiative_id, 
            $employer_name, 
            $location, 
            $initiative_employer_id,
            $job_url, 
            $job_title, 
            $job_desc, 
            $jobimage, 
            $tags            
           )
  {
    
        $job = new Job();
        $job->initiative_job_id=$initiative_job_id;
        
        //if the course already exists, just break here
       $exists= $job->isJobRecorded($h);					
               if (!$exists) {
       
        //otherwise carry on, and populate database:
                
        $job->initiative_id=$initiative_id;
        $job->employer_name=$employer_name;
        $job->location=$location;
        $job->initiative_employer_id=$initiative_employer_id;
        
        $imageURL= $this->getImageURL($jobimage);
        
        //add to database:
        $lastInsertID=$this->submitPost($h, $job_url, $job_title, $job_desc, $imageURL, $tags,
                                          $this->urlToScrape, $this->currentCategory, $job);
        
        if ($lastInsertID){
           $job->post_id= $lastInsertID;
        }
        else{           		
           $job->post_id= $job->getLatestPostID($h);         
        }
         $job->addJob($h); 
                
        }
        else
        echo "JobID ".$job->initiative_job_id." already exists, check if it has been updated.<hr>";
    
    
  }
    
    public function getImageURL($nameForSearch){
        
        
        $search_term = preg_replace('/[^a-z0-9]+/i', '_', $nameForSearch);
        //$search= preg_replace("_", "%20", $search_term);
        
        $url = "https://ajax.googleapis.com/ajax/services/search/images?" .
       "v=1.0&q=".$search_term."%20logo&userip=INSERT-USER-IP&as_filetype=jpg";
        
        
        // sendRequest
        // note how referer is set manually
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER,'84.200.17.46');
        $body = curl_exec($ch);
        curl_close($ch);
        
        // now, process the JSON string
        $json = json_decode($body, true);
        // now have some fun with the results...
             
      if($json["responseData"]["results"][0]["url"]){
      return $json["responseData"]["results"][0]["url"];
      }
      
      else if($json["responseData"]["results"][1]["url"]){
              return $json["responseData"]["results"][1]["url"];

      }
        else if($json["responseData"]["results"][2]["url"]){
           return $json["responseData"]["results"][2]["url"];

      }
        else if($json["responseData"]["results"][3]["url"]){
              return $json["responseData"]["results"][3]["url"];

      }
      
       else   return LOCALPATH."content/images/post_images/dummy_orange.jpg";
    }
  
   
    
    
} 


?>
