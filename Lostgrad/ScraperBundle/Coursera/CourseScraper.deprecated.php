 <?php
 #include hotaru
 require_once('../../../config/settings.php');
 require_once('../../../Hotaru.php');
 include_once "".BASEURL."content/plugins/post_images/post_images.php";
 #include Course object
 require "../../SiteBundle/Course.php";
 require "../ICourseScraper.php";
 
 $h = new Hotaru();
  //set any hotaru variables:
 $h->vars['submitted_data']['submit_media'] ='text';  //prevents undefined index in media_select line 93
 $scraper = new CourseScraper();
 $scraper->scrape($h);
 


class CourseScraper {

    
    const COURSES_JSON = 'https://www.coursera.org/maestro/api/topic/list?full=1'; 
    const COURSERA_URL = 'https://www.coursera.org/course/';
    const CURRENT_CATEGORY_ID=1;//default category
    
public function scrape($h)
{    
    
    //get all the course data in an array
     $courseraCourses = $this->getCoursesArray();
     $totalSubmitted= 0;
     foreach($courseraCourses as $courseraCourse)
     {
         //get details for posts table
         $courseUrl =$courseraCourse['courses'][0]['home_link'];
         $courseTitle= $courseraCourse['name'];
         $courseDescription=$courseraCourse['short_description'];
         $coursePhoto = $courseraCourse['small_icon_hover'];
         $courseShortName = $courseraCourse['short_name'];
       
        //get details for courses table
         if (isset($courseraCourse['categories'][0]['id']))
         {
            $initiativeCategoryID= $courseraCourse['categories'][0]['id'];
         }
         else $initiativeCategoryID=0;
        
        $initiativeCourseID = $courseraCourse['id']; 
        $initiativeID = 1;//1 for coursera
        $startDate=$courseraCourse['courses'][0]['start_day']
                ."/".$courseraCourse['courses'][0]['start_month']
                ."/".$courseraCourse['courses'][0]['start_year'];
        //if no start date, set it to TBC
        if ($startDate=="//")
            $startDate="TBC";
        
        $courseLength=$courseraCourse['courses'][0]['duration_string'];
        //if no length, set to tbc
        if ($courseLength=="")
            $courseLength="TBC";
        
        $institutionID= $courseraCourse['universities'][0]['id'];
        $categoryName = $courseraCourse['categories'][0]['name'];
        $youtube = $courseraCourse['video'];

        
        //then add details to course table
        $this->updateCourseDetails
                ($h, 
                $initiativeCategoryID, 
                $initiativeCourseID, 
                $initiativeID, 
                $startDate, 
                $courseLength, 
                $institutionID,
                $courseUrl, 
                $courseTitle, 
                $courseDescription, 
                $courseShortName, 
                $coursePhoto,
                $categoryName,
                $youtube
                );
         
            $totalSubmitted+=1;
     }
    
     echo"<br>Total Courses Found: ".$totalSubmitted;
 }
 
 
  private function getCoursesArray()
    {
        echo "Fetched Coursera JSON...<br>";
        return json_decode(file_get_contents(self::COURSES_JSON), true);
    }
    
    
    private function processPost($h, $courseURL, $courseTitle, $courseContent, $courseShortName, $coursePhoto){
        
      $h->post->origUrl = $courseURL;
      $h->post->domain = 'http://www.coursera.org/';
      $h->post->status= 'new';
      $h->post->author="1";
      $h->post->title = $courseTitle;
      $title = html_entity_decode($h->post->title, ENT_QUOTES, 'UTF-8');
      $h->post->url = make_url_friendly($title);
      $h->post->content = $courseContent;
      $h->post->type = 'news';
      $h->post->tags= 'coursera';
      $h->post->category= self::CURRENT_CATEGORY_ID;

      $this->insertPostImage($h, $courseShortName, $coursePhoto);
      return $h->addPost();   
        
    }
    
    
    private function updateCourseDetails
           (
            $h, 
            $initiativeCategoryID, 
            $initiativeCourseID, 
            $initiativeID, 
            $startDate, 
            $courseLength, 
            $institutionID, 
            $courseURL, 
            $courseTitle, 
            $courseContent, 
            $courseShortName, 
            $coursePhoto,
            $categoryName,
            $youtube
           )
      {
        
        $course = new Course();
        $course->initiativeCourseID=$initiativeCourseID;
        
        //if the course already exists, just break here
        $exists= $course->isCourseRecorded($h);					
                if (!$exists) {
       
        //otherwise carry on, and populate database:
                
        $course->initiativeCategoryID=$initiativeCategoryID;
        $course->initiativeID=$initiativeID;
        $course->startDate=$startDate;
        $course->courseLength=$courseLength;
        $course->institutionID=$institutionID;
        $course->categoryName = $categoryName;
        $course->youtube= $youtube;
       
        //add to database:
        $lastInsertID=$this->processPost($h, $courseURL, $courseTitle, $courseContent, $courseShortName, $coursePhoto);
        
        if ($lastInsertID){
           $course->postID= $lastInsertID;
        }
        else{           		
           $course->postID= $course->getLatestPostID($h);         
        }
         $course->addCourse($h); 
                
        }
        echo "CourseID ".$course->initiativeCourseID." already exists, check if it has been updated.<hr>";
    }
    
    
    
    private function insertPostImage($h, $courseShortName, $coursePhoto)
   {
        
     $url = $coursePhoto;
     $image_name ="image_".$courseShortName."_".time() . ".png";
     $image_path= LOCALPATH."content/images/post_images/".$image_name;
     
     // Assumes a correctly encoded URL
    $image = file_get_contents($url);
     
    if (!$image)
     return false;

    file_put_contents($image_path, $image); 
  
    if (!file_exists($image_path))
        return false;

    $h->post->image= $image_name;
  
    echo "<br><h4>".$h->post->image."</h4>";
        
  }
    
    
    
} 


?>
