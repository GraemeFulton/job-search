<?php
class Course
{
    protected $initiativeCategoryID = 0;        //initiative category identifier
    protected $initiativeCourseID = 0;          //initiative's course ID (stored to check if unique)
    protected $initiativeID = 0;                //e.g. 1= coursera
    protected $startDate = "";                  //start date string
    protected $courseLength = "";               //course length string
    protected $institutionID= 0;                //who's teaching it
    protected $postID=0;
    protected $categoryName= "";                 //name of the category
    protected $youtube="";                  //course intro video
    
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

               
   public function addCourse($h)
  {
    $sql = "INSERT INTO lostgrad_course SET initiative_category_id= %d, initiative_course_id = %d,initiative_id = %d,"
            ." course_start_date= %s, course_length = %s, institution_id=%d, post_id=%d, initiative_category_name= %s,"
            ." youtube_video=%s";
		
    $h->db->query($h->db->prepare
            ($sql, 
            $this->initiativeCategoryID, 
            $this->initiativeCourseID, 
            $this->initiativeID, 
            $this->startDate, 
            $this->courseLength, 
            $this->institutionID, 
            $this->postID, 
            $this->categoryName,
            $this->youtube
            ));
  }
    
  public function isCourseRecorded($h)
  {
       $sql = "SELECT initiative_course_id FROM lostgrad_course WHERE initiative_course_id =%d";
        $query = $h->db->prepare($sql, $this->initiativeCourseID);
                
	return $recorded = $h->db->get_var($query);;     
      
      
  }
  

  public function getLatestPostID($h)
  {
      
       $sql = "SELECT post_id FROM " . TABLE_POSTS . " ORDER BY post_id DESC LIMIT 1";
      
       return $h->db->get_var($h->db->prepare($sql));     
      
  }
  
  
  public function categorizeCourses($h)
  {
      
      
      
  }
    
}
?>
