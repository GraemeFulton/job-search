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

               
   public function addCourse($wpdb, $last_insert_id)
  {
   
            $course_type = array(
                'post_id' => $last_insert_id,
                'meta_value'=>'a:1:{s:64:"wpcf-fields-checkboxes-option-60039c1cd5b3cf7f3d424671ae5ccc3a-2";s:1:"1";}',
                'meta_key'=>'wpcf-course-type'
            );//meta_value = free course

            $wpdb->insert(
                'wp_postmeta', 
                $course_type,
                array( '%d', '%s', '%s' )
            );

  }
    
  public function isCourseRecorded($wpdb)
  {
       $sql = "SELECT initiative_course_id FROM lostgrad_course WHERE initiative_course_id =%d";
        $query = $h->db->prepare($sql, $this->initiativeCourseID);
                
	return $recorded = $h->db->get_var($query);;     
      
      
  }

    
}
?>
