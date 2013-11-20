<?php
//this is required to utilize wp_set_object_terms
require( '../../../wp-load.php' );

class Job
{
    protected $initiative_job_id = 0;        //initiative category identifier
    protected $employer_name = "";                //e.g. 1= coursera
    protected $job_location= "";                 //name of the category
    protected $job_url = "";
    protected $job_provider="";
    protected $job_profession="";
    protected $job_desc=""; //used for existance check
    
    /**
     * Access modifier to set protected properties
     */
    public function __set($var, $val)
    {
            $this->$var = $val;  
    }


    /**
     * Access modifier to get protected properties
     */
    public function &__get($var)
    {
            return $this->$var;
    }

  /*
   * addJob
   * adds job meta data in the post_meta table
   */           

    
   public function addJob($wpdb, $last_insert_id)
  {
            //INSERT JOB-TYPE
            $job_type = array(
                'post_id' => $last_insert_id,
                'meta_value'=>'a:1:{s:64:"wpcf-fields-checkboxes-option-d847eb71bad56ab77945a6625aab63b2-1";s:1:"2";}',
                'meta_key'=>'wpcf-graduate-job-type'
            );//meta_value = 2:Entry Level

            $wpdb->insert(
                'wp_postmeta', 
                $job_type,
                array( '%d', '%s', '%s' )
            );
            
            
           //INSERT JOB-URL   
              $job_url = array(
                'post_id' => $last_insert_id,
                'meta_value'=>$this->job_url,
                'meta_key'=>'wpcf-job-url'
            );
            $wpdb->insert(
                'wp_postmeta', 
                $job_url,
                array( '%d', '%s', '%s' )
            );
            
           //INSERT JOB-COURSE-ID   
              $provider_job_id = array(
                'post_id' => $last_insert_id,
                'meta_value'=>$this->initiative_job_id,
                'meta_key'=>'wpcf-provider-job-id'
            );
            $wpdb->insert(
                'wp_postmeta', 
                $provider_job_id,
                array( '%d', '%s', '%s' )
            );
            
            
            //INSERT JOB-LOCATION 
            
            $location=$this->get_coordinates();
            
              $job_location = array(
                'post_id' => $last_insert_id,
                'meta_value'=>$location,
                'meta_key'=>'location'
            );
            $wpdb->insert(
                'wp_postmeta', 
                $job_location,
                array( '%d', '%s', '%s' )
            );
            
            
            $this->setObjectTerms($last_insert_id);
  }
  
  
    /*
   * setObjectTerms
   * @param: last_insert_id
   * inserts taxonomy terms related to the post using wp_set_object_terms
   */
  private function setObjectTerms($last_insert_id){
      
    //INSERT PROVIDER NAME/RELATIONSHIP
    wp_set_object_terms($last_insert_id,$this->job_provider,'provider');
    
    //INSERT UNIVERSITY NAME/RELATIONSHIP
    wp_set_object_terms($last_insert_id,$this->job_profession,'profession');
    
    //INSERT SUBJECT NAME/RELATIONSHIP
    wp_set_object_terms($last_insert_id,$this->employer_name,'company');      
  }
    
  public function isJobRecorded($wpdb)
  {
      
        $sql = "SELECT * FROM wp_postmeta where meta_key='wpcf-job-url' and meta_value='%s'";
       $query = $wpdb->prepare($sql, $this->job_url);
                
	$recorded = $wpdb->get_var($query); 
        
        if($recorded)
        {
            return $recorded;
        } 
        else{
            
            $sql = "SELECT ID FROM wp_posts WHERE post_content LIKE '%s'";
            $query = $wpdb->prepare($sql, $this->job_desc);

            return $recorded = $wpdb->get_var($query);
            
        }
      
      
  }
  
  /*
   * alternateJobRecordedCheck
   * this check is used by indeed job search
   * checks if a job is recorded which has the same snippet
   * if so, it returns to say the job is already recorded 
   */
    public function alternateJobRecordedCheck($wpdb, $url)
  {
       $sql = "SELECT ID FROM wp_posts WHERE post_content LIKE '%s'";
       $query = $wpdb->prepare($sql, $url);
                
	$recorded = $wpdb->get_var($query); 
        
        if($recorded)
        {
            return $recorded;
        }  
      
      
  }
  
  
 /*
  * get_coordinates
  * @params: none
  * @returns: a string value:
  * e.g. "london|51.5112139,-0.1198244"
  */
 private function get_coordinates(){
          
     $address = str_replace(" ", "+", $this->job_location); // replace all the white space with "+" sign to match with google search pattern
 
     $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=$address";
 
     $response = file_get_contents($url);
 
     $json = json_decode($response,TRUE); //generate array object from the response from the web
 
    return $address.'|'.($json['results'][0]['geometry']['location']['lat'].",".$json['results'][0]['geometry']['location']['lng']);
  
  }
  
    
}
?>
