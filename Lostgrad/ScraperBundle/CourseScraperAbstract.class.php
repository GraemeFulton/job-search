 <?php

abstract class CourseScraperAbstract extends ScraperAbstract{
    
public function updateCourseDetails
           (
            $wpdb, 
            $initiativeCourseID, 
            $startDate, 
            $courseLength, 
            $universityName, 
            $courseURL, 
            $courseTitle, 
            $courseContent, 
            $courseExcerpt,
            $coursePhoto,
            $courseSubject,
            $youtube,
            $tags,
            $provider
           )
  {
         $course = new Course();
        $course->initiativeCourseID=$initiativeCourseID;
        
        if($startDate!=='TBC'){
        $course->startDate=$startDate;
        }
        
        //if the course already exists, just break here
        $exists= $course->isCourseRecorded($wpdb);
        
        if (!($exists==$course->initiativeCourseID))
             {
       
        //otherwise carry on, and populate database:
                
        $course->courseLength=$courseLength;
        $course->courseUniversity=$universityName;
        $course->courseSubject = $courseSubject;
        $course->youtube= $youtube;
        $course->courseProvider=$provider;
        $course->courseURL= $courseURL;
       
        //post content requires as much detail as possible, for accurate searches
        $content=$courseContent.$this->build_additional_content($courseSubject, $universityName, $provider);
        
        //add to database:
        $this->submitPost($wpdb, $courseTitle, $content,$courseExcerpt, $coursePhoto, $tags, 'course',$course);
        
        $course->addCourse($wpdb, $this->last_insert_id); 
          
       
  }
        else
       echo "CourseID ".$course->initiativeCourseID." already exists, check if it has been updated.<hr>";
  }
   
    
    
  private function build_additional_content($courseSubject, $universityName, $provider){
      
      $additional_content = '<div class="additional_content"><p>';
      
      $additional_content.='University: '.$universityName;
      $additional_content.=' | Subject: '.$courseSubject;
      $additional_content.=' | Provider: '.$provider;
      
      $additional_content.='</p></div>';
      
      return $additional_content;
      
  }
  
  
  
} 


?>
