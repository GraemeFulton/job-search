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
         $courseExcerpt=$courseraCourse['short_description'];
      //   $courseDescription=$courseraCourse['courses'][0]['certificate_description'].'<br>'.$courseraCourse['short_description'];
        $courseDescription=$courseraCourse['short_description'];

         $coursePhoto = $courseraCourse['photo'];
         $courseShortName = $courseraCourse['short_name'];
         $instructor=$courseraCourse['instructor'];
       
        //get details for courses table
        
        $initiativeCourseID = 'coursera-'.$courseraCourse['id']; 
       
        $day=$courseraCourse['courses'][0]['start_day']; if($day=="")$day='1'; 
        $month= $courseraCourse['courses'][0]['start_month'];if($month=="")$month='1'; 
        $year= $courseraCourse['courses'][0]['start_year'];if($year=="")$year='999'; 
        
        $startDate=$day."/".$month."/".$year;
        //if no start date, set it to TBC
        if ($startDate=="1/1/999")
            $startDate="TBC";
        echo $startDate;
        
        $courseLength=$courseraCourse['courses'][0]['duration_string'];
        //if no length, set to tbc
        if ($courseLength=="")
            $courseLength="TBC";
        
        $universityName= $courseraCourse['universities'][0]['name'];
        $courseSubject = $courseraCourse['categories'][0]['name'];
        $youtube = $courseraCourse['video'];

        echo "About to insert ";
        //then add details to course table
        $this->updateCourseDetails
                ($wpdb, 
                $initiativeCourseID, 
                $startDate, 
                $courseLength, 
                $universityName,
                $courseUrl, 
                $courseTitle, 
                $courseDescription, 
                $courseExcerpt,
                $coursePhoto,
                $courseSubject,
                $youtube,
                'Coursera',//tags
                'Coursera',//provider
                $instructor
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
