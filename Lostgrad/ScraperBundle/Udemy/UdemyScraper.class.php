 <?php

Class UdemyScraper extends CourseScraperAbstract{

    protected $course_type;
    
    public function scrape($wpdb) {
          $courseHTML = $this->getArray();
          
          $courseID= array();
          $courseVid=array();
          
         $courseIDs=$courseHTML->find(".course-card-wide");
          foreach($courseIDs as $ID){
              
              $id=$ID->getAttribute('data-courseid');
              $courseID[]=$id;
              $courseVid[]="https://www.udemy.com/course/promo-embed/?courseId=".$id;
          }
          
          
          $courseTitle=array();
          $courseNames = $courseHTML->find("#courses .title");
           foreach($courseNames as $courseName){
            $courseTitle[]=$courseName->innertext;
          }
          
         $coursePic= array();
          $courseImages= $courseHTML->find(".thumb img");
             foreach($courseImages as $courseImage){
            $coursePic[]= $courseImage->src;
            
          }
          
          
          $courseURL=array();
           $urls= $courseHTML->find("#courses a");
             foreach($urls as $url){
            $courseURL[]= $url->href;
            
          }
          
          $courseExc=array();
           $excs= $courseHTML->find("#courses .desc");
             foreach($excs as $exc){
            $courseExc[]= $exc->innertext;
            
          }
          
           $courseInstructor=array();
           $instructors= $courseHTML->find("#courses .ins-name");
             foreach($instructors as $instructor){
            $courseInstructor[]= $instructor->innertext;
            
          }
          
           $coursePrice=array();
           $prices= $courseHTML->find("#courses .price");
             foreach($prices as $price){
            $coursePrice[]= $price->innertext;
            
            if($price->innertext==' Free '){
                $this->course_type='Free';
            }
            else $this->course_type='Paid';
            $courseType[]=$this->course_type;
            
          }
          
          
          //now go to descendent pages and find the post description
          $courseDesc= array();
          
          foreach($urls as $url){
              
             $html=file_get_html($url->href);
              
            
              $courseDs= $html->find(".mc .cr");
             foreach($courseDs as $courseD){
                 //strip checkboxes
               $courseDesc[]=  preg_replace("/<\s* input [^>]+ >/xi", "", $courseD->innertext);

            }
       
   
          }

////////////////////////
                   
   $udemyCourses=array();

   //add individual course segments into one array for each course
   foreach($courseTitle as $key=>$value )
    {
        $udemyCourses[] = array
               ('image' => $coursePic[$key], 
                'title' => $courseTitle[$key], 
                'url'=>$courseURL[$key],
                'exc'=>$courseExc[$key],
                'desc'=>$courseDesc[$key],
                'vid'=>$courseVid[$key],
                'id'=>$courseID[$key],
                'instructor'=>$courseInstructor[$key],
                'price'=>$coursePrice[$key],
                'type'=>$courseType[$key]
                );
        
    }

        
  $this->insertCourses($udemyCourses, $wpdb);
        
    }
    
    
    private function insertCourses($udemyCourses, $wpdb){
         //update courses table
    foreach ($udemyCourses as $udemyCourse){
         $this->updateCourseDetails
                ($wpdb, 
                'udemy_'.$udemyCourse['id'], 
                'TBC', 
                'Self Paced', 
                'N/A',
                $udemyCourse['url'], 
                $udemyCourse['title'], 
                $udemyCourse['desc'], 
                $udemyCourse['exc'],
                $udemyCourse['image'],
                $this->category,
                $udemyCourse['vid'],
                'Udemy',//tags
                'Udemy',//provider
                $udemyCourse['instructor'],
                $udemyCourse['price'],//Price
                $udemyCourse['type']
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
