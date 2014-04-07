<?php
#include hotaru
//require "../../SiteBundle/Job.php";;
//
//# create and load the HTML
//require "../ScraperAbstract.class.php"; 
//require "../JobScraperAbstract.class.php";
////require "./IndeedScraper.class.php";
//require "./IndeedPostsGenerator.class.php";


define( 'SHORTINIT', true );
//require_once('../../../wp-load.php' );
?>
<html>
<body>
<h2>Indeed Graduate Job Generator</h2>
<form action="?action=generatePosts" method="post">
    <h2>Graduate Jobs</h2>
    <input type="radio" name="graduate_job" value='Entry Level' />Entry Level <br>
    <input type="radio" name="graduate_job" value='Graduate Scheme' />Graduate Scheme <br>
    <hr>
    <h2>Work Experience</h2>
     <input type="radio" name="work_experience" value='Internship' />Internship<br>
    <input type="radio" name="work_experience" value='Volunteer' />Volunteer<br>
    <input type="radio" name="work_experience" value='Student Jobs' />Student Jobs<br>

<input type="submit" value="Generate Posts">
</form>

</body>
</html>

<?php

if(isset($_GET['action'])=='generatePosts') {

  
    $handler= new Form_Handler();
    $handler->start_scraper();

    
}

/*
 * name= name of form
 * value = value of form
 */
function scrape($name, $value){
    
    $_POST[$name]=$value;
      $handler= new Form_Handler();
    $handler->start_scraper();
}

Class Form_Handler{

    protected $job_taxonomy_type;
    protected $page_type;
    
   public function start_scraper(){
        
          if(isset($_POST['graduate_job'])){
       
        $job_type= $_POST['graduate_job'];
        
        $this->job_taxonomy_type='job-type';
        $this->page_type = 'graduate-job';
        
        $this->scrape_graduate_jobs($job_type);
     
    }
    
    
        elseif(isset($_POST['work_experience'])){
       
        $job_type= $_POST['work_experience'];
       
        $this->page_type = 'work-experience-job';
        $this->job_taxonomy_type='work-experience-type';

        $this->scrape_work_experience($job_type);
        
    }
    
        
    }
    
    private function scrape_graduate_jobs($job_type){
        
        if($job_type=='Graduate Scheme'){
            
            $job_type_search_terms=['graduate+programme', 'graduate+scheme', 'Intake+-placement+-school+-internship+-intern'];
              
            foreach($job_type_search_terms as $term){
                $gen= new Indeed_Post_Gen($job_type, $term, $this->job_taxonomy_type, $this->page_type); //loop through each if graduate scheme
             }
        }
        elseif($job_type=='Entry Level'){
            
             $job_type_search_terms= 'junior+or+graduate+or+trainee+or+-programme+or+-scheme+-2014+-2013+-charge+-placement+-director+-senior';
            $gen= new Indeed_Post_Gen($job_type, $job_type_search_terms, $this->job_taxonomy_type, $this->page_type);//otherwise provide the full string
            
        }
        
    }
    
    private function scrape_work_experience($job_type){
    
        if($job_type=='Internship'){
        
            $job_type_search_terms=['Internship', 'Placement'];
            
            foreach($job_type_search_terms as $term){
                $gen= new Indeed_Post_Gen($job_type, $term, $this->job_taxonomy_type, $this->page_type); //loop through each if graduate scheme
            }
        
        }
        elseif($job_type=='Volunteer'){
            
            $job_type_search_terms=['Volunteer'];
            
            foreach($job_type_search_terms as $term){
                $gen= new Indeed_Post_Gen($job_type, $term, $this->job_taxonomy_type, $this->page_type); //loop through each if graduate scheme
            }
            
        }
           elseif($job_type=='Student Jobs'){
            
            $job_type_search_terms=['Part+Time+Student', 'Evening*+Student', 'Weekend+Student', 'Student+-Teacher+-Lecturer+-Dean+-Support+-Director+-Deputy'];
            
            foreach($job_type_search_terms as $term){
                $gen= new Indeed_Post_Gen($job_type, $term, $this->job_taxonomy_type, $this->page_type); //loop through each if graduate scheme
            }
            
        }
    }
    

}
?>
