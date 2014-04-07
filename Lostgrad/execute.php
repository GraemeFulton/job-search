<?php

require 'ScraperBundle/Indeed/graduate-jobs.php'; 

require "SiteBundle/Job.php";;

# create and load the HTML
require "ScraperBundle/ScraperAbstract.class.php"; 
require "ScraperBundle/JobScraperAbstract.class.php";
//require "./IndeedScraper.class.php";
require "ScraperBundle/Indeed/IndeedPostsGenerator.class.php";


scrape('graduate_job', 'Graduate Scheme');
scrape('graduate_job', 'Entry Level');

scrape('work_experience', 'Volunteer');
scrape('work_experience', 'Internship');
scrape('work_experience', 'Student Jobs');

?>
