 <?php

Class UdemyScraper extends CourseScraperAbstract{

    protected $categoryName;

    
    public function scrape($h) {
          $courseHTML = $this->getCoursesArray();
          
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
          
          $courseDesc=array();
           $descs= $courseHTML->find("#courses .desc");
             foreach($descs as $desc){
            $courseDesc[]= $desc->innertext;
            
          }
                   
   $udemyCourses=array();

   //add individual course segments into one array for each course
   foreach($courseTitle as $key=>$value )
    {
        $udemyCourses[] = array
               ('image' => $coursePic[$key], 
                'title' => $courseTitle[$key], 
                'url'=>$courseURL[$key],
                'desc'=>$courseDesc[$key]
                );
        
    }
        
   //update courses table
   foreach($udemyCourses as $udemyCourse)
     {
        $this->updateCourseDetails($h,0,0,2,"NA","NA","NA",$udemyCourse['url'],$udemyCourse['title'],$udemyCourse['desc'], 
                                   $udemyCourse['image'],"udemy", "","udemy");
     }
        
    }
    
    
    public function getArray() {
        $html = new simple_html_dom();
        $html->load_file($this->urlToScrape); 
        return $html;
    }
    
    
    
    
}


?>
