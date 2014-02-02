<?php
//this is required to utilize wp_set_object_terms
require( '../../../wp-load.php' );

class Course
{
    protected $initiativeCourseID = "";          //initiative's course ID (stored to check if unique)
    protected $startDate = "";                  //start date string
    protected $courseLength = "";               //course length string
    protected $youtube="";                  //course intro video
    
    protected $courseProvider="";
    protected $courseUniversity="";
    protected $courseSubject="";
    protected $courseURL="";
    
    protected $course_type="Free";
    protected $courseInstructor="";

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
   * addCourse
   * adds course meta data in the post_meta table
   */
   public function addCourse($wpdb, $last_insert_id)
  {
//       //INSERT COURSE-TYPE
//            $course_type = array(
//                'post_id' => $last_insert_id,
//                'meta_value'=>'a:1:{s:64:"wpcf-fields-checkboxes-option-60039c1cd5b3cf7f3d424671ae5ccc3a-2";s:1:"1";}',
//                'meta_key'=>'wpcf-course-type'
//            );//meta_value = free course
//
//            $wpdb->insert(
//                'wp_postmeta', 
//                $course_type,
//                array( '%d', '%s', '%s' )
//            );
            
      // INSERT START DATE
       if($this->startDate!=="")
       {
             $timestamp = DateTime::createFromFormat('m/d/Y', $this->startDate)->getTimestamp();     
            
              $start_date = array(
                'post_id' => $last_insert_id,
                'meta_value'=>$timestamp,
                'meta_key'=>'wpcf-start-date'
            );
            $wpdb->insert(
                'wp_postmeta', 
                $start_date,
                array( '%d', '%s', '%s' )
            );
         }
            
           //INSERT COURSE-LENGTH     
              $course_length = array(
                'post_id' => $last_insert_id,
                'meta_value'=>$this->courseLength,
                'meta_key'=>'wpcf-course-length'
            );
            $wpdb->insert(
                'wp_postmeta', 
                $course_length,
                array( '%d', '%s', '%s' )
            );
            
           //INSERT COURSE-URL   
              $course_url = array(
                'post_id' => $last_insert_id,
                'meta_value'=>$this->courseURL,
                'meta_key'=>'wpcf-opportunity-url'
            );
            $wpdb->insert(
                'wp_postmeta', 
                $course_url,
                array( '%d', '%s', '%s' )
            );
            
            //INSERT COURSE-INSTRUCTOR
             //INSERT COURSE-URL   
              $course_instructor = array(
                'post_id' => $last_insert_id,
                'meta_value'=>$this->courseInstructor,
                'meta_key'=>'wpcf-course-instructor'
            );
            $wpdb->insert(
                'wp_postmeta', 
                $course_instructor,
                array( '%d', '%s', '%s' )
            );
            
            
           //INSERT PROVIDER-COURSE-ID   
              $provider_course_id = array(
                'post_id' => $last_insert_id,
                'meta_value'=>$this->initiativeCourseID,
                'meta_key'=>'wpcf-provider-course-id'
            );
            $wpdb->insert(
                'wp_postmeta', 
                $provider_course_id,
                array( '%d', '%s', '%s' )
            );
            
              //INSERT YOUTUBE VID
            if($this->youtube!=""){
              $provider_course_id = array(
                'post_id' => $last_insert_id,
                'meta_value'=>'http://www.youtube.com/watch?v='.$this->youtube,
                'meta_key'=>'wpcf-embedded-media'
            );
            $wpdb->insert(
                'wp_postmeta', 
                $provider_course_id,
                array( '%d', '%s', '%s' )
            );
            }
            
            $this->setObjectTerms($last_insert_id);
  }
  
  
  /*
   * setObjectTerms
   * @param: last_insert_id
   * inserts taxonomy terms related to the post using wp_set_object_terms
   */
  private function setObjectTerms($last_insert_id){
      
      //INSERT PROVIDER NAME/RELATIONSHIP
    wp_set_object_terms($last_insert_id,$this->course_type,'course-type'); 
      
    //INSERT PROVIDER NAME/RELATIONSHIP
    wp_set_object_terms($last_insert_id,$this->courseProvider,'course-provider');
    
    //INSERT UNIVERSITY NAME/RELATIONSHIP
    wp_set_object_terms($last_insert_id,$this->courseUniversity,'uni');
    
    //INSERT SUBJECT NAME/RELATIONSHIP
    wp_set_object_terms($last_insert_id,$this->courseSubject,'subject');      
  }
  
  
  /*
   * isCourseRecorded
   * checks if the course is already in our database using the providers identifier
   */  
  public function isCourseRecorded($wpdb)
  {
        $sql = "SELECT meta_value FROM wp_postmeta WHERE meta_key='wpcf-provider-course-id' AND meta_value =%s";
        $query = $wpdb->prepare($sql, $this->initiativeCourseID);
                
	$recorded = $wpdb->get_var($query); 
        
        if($recorded)
        {
            return $recorded;
        }
//        else
//            {
//                $sql = "SELECT post_title FROM wp_posts WHERE post_tite=%s";
//                $query = $wpdb->prepare($sql, $this->initiativeCourseID);
//                
//                $recorded = $wpdb->get_var($query); 
//        
//                return $recorded;
//            }
  }

    
}
?>
