 <?php

abstract class CourseScraperAbstract extends ScraperAbstract{
    
public function updateCourseDetails
           (
            $wpdb, 
            $initiativeCategoryID, 
            $initiativeCourseID, 
            $initiativeID, 
            $startDate, 
            $courseLength, 
            $institutionID, 
            $courseURL, 
            $courseTitle, 
            $courseContent, 
            $coursePhoto,
            $categoryName,
            $youtube,
            $tags
           )
  {
         $course = new Course();
        $course->initiativeCourseID=$initiativeCourseID;
        
        //if the course already exists, just break here
//        $exists= $course->isCourseRecorded($wpdb);					
//                if (!$exists) {
       
        //otherwise carry on, and populate database:
                
        $course->initiativeCategoryID=$initiativeCategoryID;
        $course->initiativeID=$initiativeID;
        $course->startDate=$startDate;
        $course->courseLength=$courseLength;
        $course->institutionID=$institutionID;
        $course->categoryName = $categoryName;
        $course->youtube= $youtube;
       
        //add to database:
        $this->submitPost($wpdb, $courseURL, $courseTitle, $courseContent, $coursePhoto, $tags,
                                         $this->urlToScrape, $this->currentCategory, $course);
        
        $course->addCourse($wpdb, $this->last_insert_id); 
          
       
//  }
//        else
//        echo "CourseID ".$course->initiativeCourseID." already exists, check if it has been updated.<hr>";
  }
   
    
    
} 


?>
