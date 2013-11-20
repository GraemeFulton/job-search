 <?php
 
abstract class JobScraperAbstract extends ScraperAbstract{
    
public function updateJobDetails
           (
            $wpdb, 
            $profession,
            $initiative_job_id, 
            $employer_name, 
            $location, 
            $job_url, 
            $job_title, 
            $job_desc, 
            $job_exerpt,
            $jobimage, 
            $tags,
            $provider
           )
  {
    
        $job = new Job();
        $job->job_url= $job_url;
        $job->job_desc=$job_desc;
        $job->initiative_job_id=$initiative_job_id;         
        $job->employer_name=$employer_name;
        $job->job_location=$location;
        $job->job_provider=$provider;
        $job->job_profession=$profession;
        
        //if the course already exists, just break here
       $exists= $job->isJobRecorded($wpdb);					
        
       if (!$exists) 
       {
        //otherwise carry on, and populate database:
            $imageURL= $this->getImageURL($jobimage);

            //add to database:
            $this->submitPost($wpdb, $job_title, $job_desc,$job_exerpt, $imageURL, $tags,'graduate-job', $job);

            $job->addJob($wpdb,$this->last_insert_id); 
             echo "<h4 style='color:green;'> Job Inserted</h4>";       
       }
       else
       echo "<p style='color:red;'>Job: '".$job_title." | ".$employer_name."' already exists!</p><hr>";
    
    
  }
    
    public function getImageURL($nameForSearch){
        
        
        $search_term = preg_replace('/[^a-z0-9]+/i', '%20', $nameForSearch);
        //$search= preg_replace("_", "%20", $search_term);
        
        $url = "https://ajax.googleapis.com/ajax/services/search/images?" .
       "v=1.0&q=".$search_term."%20site:http://www.brandprofiles.com/&userip=INSERT-USER-IP";
        
        echo "<br>Image search: ".$url."<br>";
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
     //   echo '<br>Image Url: '.$json["responseData"]["results"][0]["url"].'<br>';
      return $json["responseData"]["results"][0]["url"];
      }
      
      else if($json["responseData"]["results"][1]["url"]){
        //    echo '<br>Image Url: '.$json["responseData"]["results"][1]["url"].'<br>';
              return $json["responseData"]["results"][1]["url"];

      }
        else if($json["responseData"]["results"][2]["url"]){
         //   echo '<br>Image Url: '.$json["responseData"]["results"][2]["url"].'<br>';
           return $json["responseData"]["results"][2]["url"];

      }
        else if($json["responseData"]["results"][3]["url"]){
         //   echo '<br>Image Url: '.$json["responseData"]["results"][3]["url"].'<br>';
            return $json["responseData"]["results"][3]["url"];

      }
      
       else{
           echo "<br>Image: dummy image used<br>";
           return 'dummy';
       }
           
       }
  
   
    
    
} 


?>
