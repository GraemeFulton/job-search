<?php
class Job
{
    protected $initiative_job_id = 0;        //initiative category identifier
    protected $initiative_id = 0;          //initiative's course ID (stored to check if unique)
    protected $employer_name = "";                //e.g. 1= coursera
    protected $post_id=0;
    protected $location= "";                 //name of the category
    protected $initiative_employer_id="";                  //course intro video
    
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
  
    public function alternateJobRecordedCheck($h, $url)
  {
       $sql = "SELECT post_id FROM hotaru_posts WHERE post_content LIKE '%s'";
        $query = $h->db->prepare($sql, $url);echo "<hr>";
              echo"<h4>Query:</h4> ".$query."<br>";
	return $recorded = $h->db->get_var($query);;     
      
      
  }
  

  public function getLatestPostID($h)
  {
      
       $sql = "SELECT post_id FROM " . TABLE_POSTS . " ORDER BY post_id DESC LIMIT 1";
      
       return $h->db->get_var($h->db->prepare($sql));     
      
  }
  
    
}
?>
