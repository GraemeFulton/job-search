 <?php

Class FutureLearnScraper extends CourseScraperAbstract{

    protected $course_type;
    
    public function scrape($wpdb) {
          $courseHTML = $this->getArray();
            
           $courseURLs=array();
           $courseUniversities= array();
           $courseImages= array();
           $courseLengths= array();

          //COURSE URL
           $urls= $courseHTML->find(".course-index .button-more");
             foreach($urls as $url){
            $courseURLs[]= "http://www.futurelearn.com".$url->href;          
          }
           
          //COURSE UNIVERSITY
          $university_names= $courseHTML->find(".organisation");
             foreach($university_names as $university_name){
               $courseUniversities[]=  strip_tags($university_name->innertext);
            }
            
          //COURSE IMAGE
          $course_images= $courseHTML->find(".media_image img");
             foreach($course_images as $course_image){
               $courseImages[]=  $course_image->src;
            }
            
               
            //COURSE LENGTH
              $course_lengths= $courseHTML->find(".media_attributes");
            foreach($course_lengths as $course_length){
               $courseLengths[]=  $course_length->innertext;
            }
    
            
          $courseIDs=array();
          $courseDescriptions= array();
          $courseExcerpts= array();
          $courseStartDates= array();
          $courseTitles= array();
          $courseInstructors= array();
          $courseVideos= array();

          //now go to descendent pages to find further details
          foreach($urls as $url){
              
             $html=file_get_html("http://www.futurelearn.com".$url->href);
                         
              //COURSE ID
            $course_ids= $html->find(".course");
             foreach($course_ids as $course_id){
                 $id=$course_id->getAttribute('id');
                 
               $courseIDs[]=  $id;
            }
             
             //COURSE DESCRIPTION
            $course_descriptions= $html->find(".course-description .small");
             foreach($course_descriptions as $course_description){
               $courseDescriptions[]= $course_description->innertext;
            }
            
            //COURSE EXCERPT
              $course_excerpts= $html->find(".text-introduction");
             foreach($course_excerpts as $course_excerpt){
               $courseExcerpts[]=  $course_excerpt->innertext;
            }
            
            //START DATE
              $start_dates= $html->find("time");
              if($start_dates){
                   foreach($start_dates as $start_date){
                           $date=$start_date->getAttribute('datetime');
                        if($date){$date_ins= DateTime::createFromFormat('Y-m-d', $date)->getTimestamp();
                                if($date_ins){$courseStartDates[]=$date_ins;}
                                else $courseStartDates='TBC';
                        }
                        else $courseStartDates[]='TBC';
                   }
            }
            else $courseStartDates[]= 'TBC';
                      
             //COURSE TITLE
             $course_titles= $html->find(".headline-black");
             foreach($course_titles as $course_title){
               $courseTitles[]=  $course_title->innertext;
            }
            
            //COURSE INSTRUCTOR
             $course_instructors= $html->find(".educator .small");
             foreach($course_instructors as $course_instructor){
               $courseInstructors[]=  strip_tags($course_instructor->innertext);
            }
            
            //COURSE VIDEO URL
             $course_videos= $html->find(".video-step-container iframe");
             if($course_videos){
                    foreach($course_videos as $course_video){

                        if($course_video->src){
                        $courseVideos[]=  $course_video->src;
                        }
                        else $courseVideos[]="N/A";
                   }
             }
                else $courseVideos[]="N/A";

          }

   //populate array to be inserted into db
   $futureLearnCourses=array();

   //add individual course segments into one array for each course
   foreach($courseURLs as $key=>$value )
    {
        $futureLearnCourses[] = array
               ('image' => $courseImages[$key], 
                'title' => $courseTitles[$key], 
                'url'=>$courseURLs[$key],
                'exc'=>$courseExcerpts[$key],
                'desc'=>$courseDescriptions[$key],
                'vid'=>$courseVideos[$key],
                'id'=>$courseIDs[$key],
                'instructor'=>$courseInstructors[$key],
                'uni'=>$courseUniversities[$key],
                'length'=>$courseLengths[$key],
                'date'=>$courseStartDates[$key]
                );
        
    }
   // var_dump($futureLearnCourses);
 $this->insertCourses($futureLearnCourses, $wpdb);
        
    }
    
    
    private function insertCourses($futureLearnCourses, $wpdb){
         //update courses table
    foreach ($futureLearnCourses as $futureLearnCourse){
         $this->updateCourseDetails
                ($wpdb, 
                'futurelearn_'.$futureLearnCourse['id'], 
                 $futureLearnCourse['date'], 
                 $futureLearnCourse['length'], 
                 $futureLearnCourse['uni'],
                 $futureLearnCourse['url'], 
                 $futureLearnCourse['title'], 
                 $futureLearnCourse['desc'], 
                 $futureLearnCourse['exc'],
                 $futureLearnCourse['image'],
                 $this->category,
                 $futureLearnCourse['vid'],
                'Future Learn',//tags
                'Future Learn',//provider
                 $futureLearnCourse['instructor'],
                 'Free',//Price
                 'MOOC'
                );
        }
        
        
    }
    
    
    public function getArray() {
      //  $html = new simple_html_dom();
        $html=file_get_html($this->urlToScrape); 
        return $html;
    }
    
    
    
    
}


?>
