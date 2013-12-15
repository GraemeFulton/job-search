<?php
/*
     * filter_by_subject_ajax
     * 
     * args: arguments from checkbox.js 
     * returns: returns html template to ajax call
     */
    function process_filter()
    {
         switch($_REQUEST['fn'])
        {
             case 'group_filter':
                  $output = create_post_filter(
                          $_POST['selected_subjects'], 
                          $_POST['offset'],
                          $_POST['cat'], 
                          $_POST['type'], 
                          $_POST['selected_institutions'],
                          $_POST['body_type'],
                          $_POST['location'],
                          $_POST['provider'],
                          $_POST['selected_category_type']
                          );
             break;
         
             case 'regular_filter':
                  $output = create_simple_post_filter(
                          $_POST['selected_subjects'], 
                          $_POST['offset'],
                          $_POST['cat'], 
                          $_POST['type'],
                          $_POST['provider'],
                          $_POST['selected_category_type']
                          );
                 break;
             default:
                 $output = 'No function specified, check your jQuery.ajax() call';
             break;
        }
 
        $output=json_encode($output);
        
        if(is_array($output))
        {
            print_r($output);   
        }
         else{echo $output;}
         die;
    }
    
/*
 * ajax_get_latest_posts
 * args: taxonomy (checkbox selections), offset(number of courses already loaded)
 * returns: html template 
 * note:change location to meta value
 */
function create_post_filter($selected_subjects, 
                            $offset, 
                            $category_type, 
                            $tag_type, 
                            $selected_institutions, 
                            $body_type, 
                            $location,
                            $selected_provider,
                            $selected_category_type
                            )
{
    
   $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $args= array
    (
        'offset'=>$offset,
        'post_type'=>$category_type,
        'paged'=>$paged,
        'posts_per_page'=>9,
        'orderby' => 'title',
        'order' => 'ASC'
    );
    
    //QUERY CHECKED SUBJECTS
    if($selected_subjects!="" && $tag_type=='subject'){//if a box has been checked, we add a taxnomoy query
         
         $args['tax_query'][3]['terms']=$selected_subjects;
            $args['tax_query'][3]['taxonomy']='subject';
            $args['tax_query'][3]['field']='slug';    
    } //QUERY CHECKED SUBJECTS
    
    //QUERY CHECKED PROFESSION
      if($selected_subjects!="" && $tag_type=='profession'){//if a box has been checked, we add a taxnomoy query
                
            $args['tax_query'][4]['terms']=$selected_subjects;
            $args['tax_query'][4]['taxonomy']='profession';
            $args['tax_query'][4]['field']='slug';   
            
    }
    //QUERY CHECKED PROFESSION
    
    //QUERY CHECKED INSTITUTIONS
        if($selected_institutions!=""){//if a box has been checked, we add a taxnomoy query
         
        $tags_from_group=array();
        
        foreach($selected_institutions as $term)
        {       
           $tags_from_group= array_merge($tags_from_group,xtt_tags_from_group($term, '',"xili_tidy_tags_".$body_type, $body_type));

            $args['tax_query'][0]['terms']=$tags_from_group;
            $args['tax_query'][0]['taxonomy']=$body_type;
            $args['tax_query'][0]['field']='slug';
        }      
    } //QUERY CHECKED INSTITUTIONS
    
      //QUERY CHECKED PROVIDER (destination)
    if($selected_provider!=""){//if a box has been checked, we add a taxnomoy query

            $args['tax_query'][1]['terms']=$selected_provider;
            $args['tax_query'][1]['taxonomy']='provider';
            $args['tax_query'][1]['field']='slug';
            
    } //QUERY CHECKED PROVIDER
    
    
    //QUERY CHECKED LOCATION
       if($location!=""){
           
            $args['tax_query'][2]['terms']=$location;
            $args['tax_query'][2]['taxonomy']='location';
            $args['tax_query'][2]['field']='slug';   
       }
    //QUERY META VALUE (LOCATION)
   
//QUERY META VALUE (category_type)
       if($selected_category_type!=""){
           
      $meta=array('relation'=>'OR');
      foreach($selected_category_type as $key=>$value)
        {     
            $result = str_replace('-', '"', $value);
          
           $meta[$key]=array(
                    'key' => 'job_type',
                    'value' => $result,
                    'compare' => 'LIKE',
                    );              
         
        }                          

          $args['meta_query']=$meta;
            
    }
    //QUERY META VALUE (category_type)

    
    query_posts($args);
    
   return load_post_loop_view($category_type);
}


function create_simple_post_filter($selected_subjects, 
                                    $offset, 
                                    $category_type, 
                                    $tag_type,
                                    $selected_provider,
                                    $selected_category_type
                                    )
 {
    
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $args= array
    (
        'offset'=>$offset,
        'post_type'=>$category_type,
        'paged'=>$paged,
        'posts_per_page'=>9,
        'orderby' => 'title',
        'order' => 'ASC'
    );
    
     //QUERY CHECKED SUBJECTS (destination)
    if($selected_subjects!=""){//if a box has been checked, we add a taxnomoy query

            $args['tax_query'][1]['terms']=$selected_subjects;
            $args['tax_query'][1]['taxonomy']=$tag_type;
            $args['tax_query'][1]['field']='slug';
            
    } //QUERY CHECKED SUBJECTS
    
     //QUERY CHECKED PROVIDER (destination)
    if($selected_provider!=""){//if a box has been checked, we add a taxnomoy query

            $args['tax_query'][0]['terms']=$selected_provider;
            $args['tax_query'][0]['taxonomy']='provider';
            $args['tax_query'][0]['field']='slug';
            
    } //QUERY CHECKED PROVIDER
    
     //QUERY META VALUE (category_type)
       if($selected_category_type!=""){
           
      $meta=array('relation'=>'OR');
      foreach($selected_category_type as $key=>$value)
        {     
           $result = str_replace('-', '"', $value);

           $meta[$key]=array(
                    'key' => 'travel_type',
                    'value' => $result,
                    'compare' => 'LIKE',
                    );              
         
        }                          

          $args['meta_query']=$meta;
            
    }
    
    
    
    //QUERY META VALUE (LOCATION)
    
    
        query_posts($args);

       return load_post_loop_view($category_type);

}

function load_post_loop_view($category_type) {

    if ($category_type=='course'){
    // the Loop
      include("Views/course_post_loop.php");  
    }
    else if($category_type=='graduate-job'){
        
        include("Views/graduatejob_post_loop.php");  
        
    }
      else if($category_type=='work-experience-job'){
        
        include("Views/graduatejob_post_loop.php");  
        
    }
       else if($category_type=='travel-opportunities'){
        
        include("Views/travel_post_loop.php");  
        
    }
    
    
    wp_reset_query();
    exit;
}
?>
