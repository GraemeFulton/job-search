<?php
class Job
{
    protected $initiative_job_id = 0;        //initiative category identifier
    protected $employer_name = "";                //e.g. 1= coursera
    protected $job_location= "";                 //name of the category
    protected $job_url = "";
    protected $job_provider="";
    protected $job_profession="";
    
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

               
   public function addJob($h)
  {
    $sql = "INSERT INTO lostgrad_job SET initiative_job_id= %d, initiative_id = %d, employer_name = %s,"
            ." post_id= %d, location = %s, initiative_employer_id=%d";
		
    $h->db->query($h->db->prepare
            ($sql, 
            $this->initiative_job_id, 
            $this->initiative_id, 
            $this->employer_name, 
            $this->post_id, 
            $this->location, 
            $this->initiative_employer_id
            ));
  }
    
  public function isJobRecorded($h)
  {
      
       $sql = "SELECT initiative_job_id FROM lostgrad_job WHERE initiative_job_id =%d";
        $query = $h->db->prepare($sql, $this->initiative_job_id);
                
	return $recorded = $h->db->get_var($query);;     
      
      
  }
  
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
  

  public function getLatestPostID($h)
  {
      
       $sql = "SELECT post_id FROM " . TABLE_POSTS . " ORDER BY post_id DESC LIMIT 1";
      
       return $h->db->get_var($h->db->prepare($sql));     
      
  }
  
    
}
?>
