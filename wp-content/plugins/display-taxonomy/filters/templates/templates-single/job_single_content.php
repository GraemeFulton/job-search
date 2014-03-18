 <div class='single_post_content'>
     
          
     <div class="single_cont">
     
     <h4>Description</h4>
     <h5>
         This job is provided by Indeed - Click 'Apply Now' for full job description.
     </h5>
     
     <div class='indeed-content'>
         <p>
         Excerpt provided by Indeed:
     </p>
    <?php echo $the_content?>
         </div>
<a class="btn btn-success btn-large" id='apply-now' style='float:left'>Apply Now</a>
           <img style='float:left; position:relative; margin-left:5px;max-width:80px;'src='http://www.indeed.co.uk/images/job_search_indeed_en_GB.png'>

            </div>
 </div>

   <script>
       var open__=false;
       $=jQuery;
        $('#review_button').click(function()
        {
            
            if (open__==false){   
            jQuery('#wpcr_button_1').trigger('click');
            open=true;
        }
                           
            $('body').scrollTo('#wpcr_commentform ');
        });
        
        $('#apply-now').click(function(){
           var link= jQuery(".apply").attr("href")
            window.open(link);
            
        })
   </script>
