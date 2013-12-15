<?php
#include hotaru
require "../../SiteBundle/Job.php";;

# create and load the HTML
require "../ScraperAbstract.class.php"; 
require "../JobScraperAbstract.class.php";
//require "./IndeedScraper.class.php";
require "./IndeedPostsGenerator.class.php";


define( 'SHORTINIT', true );
require_once('../../../wp-load.php' );
?>
<html>
<body>
<h2>Indeed Graduate Job Generator</h2>
<form action="?action=generatePosts" method="post">
    <input type="radio" name="job_type" value='a:1:{i:0;s:11:"entry_level";}' />Entry Level <br>
    <input type="radio" name="job_type" value='a:1:{i:0;s:15:"graduate_scheme";}' />Graduate Scheme <br>

<input type="submit" value="Generate Posts">
</form>

</body>
</html>

<?php

if(isset($_GET['action'])=='generatePosts') {

  
    $handler= new Form_Handler();
    $handler->start_scraper();

    
}


Class Form_Handler{

    protected $job_option_selected;
    
   public function start_scraper(){
        
          if(isset($_POST['job_type'])){
       
        $job_type = stripslashes($_POST["job_type"]);
        
        $job_type_search_terms= $this->get_search_terms($job_type);
        
        if($this->job_option_selected==1){
        foreach($job_type_search_terms as $term){
        $gen= new Indeed_Post_Gen($job_type, $term); //loop through each if graduate scheme

        }
        }
        elseif($this->job_option_selected==2){
            
            $gen= new Indeed_Post_Gen($job_type, $job_type_search_terms);//otherwise provide the full string
            
        }
    }
        
    }
    
    
   private function get_search_terms($job_type){
        
    
        //if graduate jobs
        if($job_type=='a:1:{i:0;s:15:"graduate_scheme";}'){
            
            echo 'Job Type Meta: '.$job_type;
            $this->job_option_selected=1;
           return $job_search_array=['graduate+programme', 'graduate+scheme', 'Intake+-placement+-school'];
         

        }
        //if entry level
        elseif($job_type=='a:1:{i:0;s:11:"entry_level";}'){
            $this->job_option_selected=2;
            echo 'Job Type Meta: '.$job_type;
         return   $job_type_search_terms= 'junior+or+graduate+or+trainee+or+-programme+or+-scheme+-2014+-2013+-charge';
        }
    
    
    }

}
?>
