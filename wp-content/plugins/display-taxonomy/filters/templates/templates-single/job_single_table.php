<?php
$location= $this->get_jobs_location($tree);

if(!isset($institution_with_link)){
  $institution_with_link='N/A';
}
if(!isset($location)){
  $location='N/A';
}
if(!isset($post_type)){
  $post_type='N/A';
}
?>
                <div class="single_datagrid">
                  <h1>
                    <?php the_title(); ?>
                  </h1>
                  <?php
                  $image='';
                  if(strpos($provider['src'],'indeed')!==false){
                    $image = 'http://www.indeed.co.uk/images/job_search_indeed_en_GB.png';
                    if($post_type=='Entry Level'){
                      $sentance = 'an entry level position';
                      $desc = $subject.' entry level roles often equip you with valuable hands on experience that may not be possible on larger graduate schemes in the '.strtolower($subject).' industry';
                    }
                    elseif($post_type=='Graduate Scheme'){
                      $sentance = 'a graduate training scheme position';
                      $desc = 'Joining a training scheme such as this would provide you with a guided route into the '.strtolower($subject).' industry, enabling you to develop both your skills and understanding.';
                    }
                    if(isset($institution_with_link)){
                      $advertised_by = ' advertised by '.$institution_with_link;
                    }
                    else{
                      $advertised_by = '';
                    }
                    ?>

                    <p>This is <?php echo $sentance.$advertised_by; ?>.</p>
                    <p>The role is in the <?php echo strtolower($subject) ?> industry, and is <?php echo $location?> based.</p>
                    <p> <?php echo $desc;?> </p>
                    <p> A summary of the job is provided below. Click the 'Apply Now' button to find out more.</p>

                    <?php
                  }
                  ?>
                  <hr>
                    <table class="pop-out-tbl">
                        <tr><th><h5 class="small-title">Job details</h5></th></tr>
                        <tr><th>Company: </th><td><?php echo $institution_with_link;?></td></tr>
                        <tr class="alt"><th>Profession: </th><td><?php echo $subject;?></td></tr>
                        <tr><th>Location: </th><td><?php echo $location;?></td></tr>
                        <tr class="alt"><th>Job Type: </th><td><?php echo $post_type;?></td></tr>
                        <tr><th>Provider:</th><td><img style="width:100px;" src="<?php echo $image; ?>"/></td></tr>
                        <tr class="alt"><th>Excerpt: </td><td><?php echo $the_content;?></td></tr>
                         <tr><th>Date Posted: </th><td><?php echo $post_date=get_the_time('d-m-Y', $this->post_id);?></td></tr>
            <?php
        //get post date and add 30 days
        $e_date= strtotime("+30 days", strtotime($post_date));
        $expiry=date("Y-m-d", $e_date);

        $today=mktime(0,0,0,date("m"),date("d"),date("Y"));

        if($e_date>$today)
        {
        }else{ ?><tr class="alt"><th>Notice: </th><td><span class="job-expiry">Older than 30 days</span></td></tr><?php } ?>
                    </table>
<?php echo ' <a class="btn-success btn-outlined btn apply" target="_blank" href="'.$link.'">Apply Now</a>';?>



                </div>
