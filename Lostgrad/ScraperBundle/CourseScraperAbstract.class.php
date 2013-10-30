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
        
        
        $lastInsertID= $wpdb->insert_id;
        
   if ($lastInsertID)
    {  
   
            $course_type = array(
                'post_id' => $lastInsertID,
                'meta_value'=>'a:1:{s:64:"wpcf-fields-checkboxes-option-60039c1cd5b3cf7f3d424671ae5ccc3a-2";s:1:"1";}',
                'meta_key'=>'wpcf-course-type'
            );//meta_value = free course

            $wpdb->insert(
                'wp_postmeta', 
                $course_type,
                array( '%d', '%s', '%s' )
            );

         
     }
        
        
    
//  }
  }
   
    
    
} 


?>
