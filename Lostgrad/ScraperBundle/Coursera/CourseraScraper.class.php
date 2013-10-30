 <?php

class CourseraScraper extends CourseScraperAbstract  {
    
public function scrape($wpdb)
{    
    
    //get all the course data in an array
     $courseraCourses = $this->getArray();
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

        echo "going to insert";
        //then add details to course table
        $this->updateCourseDetails
                ($wpdb, 
                $initiativeCategoryID, 
                $initiativeCourseID, 
                $initiativeID, 
                $startDate, 
                $courseLength, 
                $institutionID,
                $courseUrl, 
                $courseTitle, 
                $courseDescription, 
             //   $courseShortName, 
                $coursePhoto,
                $categoryName,
                $youtube,
                'coursera'
                );
         
            $totalSubmitted+=1;
     }
    
     echo"<br>Total Courses Found: ".$totalSubmitted;
 }
 
 
  public function getArray()
    {
        echo "Fetched Coursera JSON...<br>";
        return json_decode(file_get_contents($this->urlToScrape), true);
    }
    
} 


?>
