<?php
/*
     * filter_by_subject_ajax
     * 
     * args: arguments from checkbox.js 
     * returns: returns html template to ajax call
     */
    function checkbox_filter()
    {
        
         $super_filter = new Super_Filter($_POST['selected_subjects'], 
                          $_POST['offset'],
                          $_POST['cat'], 
                          $_POST['type'], 
                          $_POST['selected_institutions'],
                          $_POST['body_type'],
                          $_POST['location'],
                          $_POST['provider'],
                          $_POST['selected_category_type'],
                          $_POST['search_filter'],
                          $_POST['order_by'],
                          $_POST['sort_a_z'],
                          $_POST['tax_or_cat']);
         
         switch($_REQUEST['fn'])
        {
             
             case 'select':
                 $output= $super_filter->create_filter('select');
             break;
         
             case 'scroll':               
                $output= $super_filter->create_filter('scroll');
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
    



Class Super_Filter{
    
        protected $selected_subjects; 
        protected $offset;
        protected $category_type;
        protected $tag_type; //e.g. profession/subject
        protected $selected_institutions;
        protected $body_type;
        protected $location;
        protected $selected_provider;
        protected $selected_post_type;
        protected $search_term;
        protected $order_by;
        protected $order_a_z;
        protected $tax_or_cat;

        
        protected $view; //string (path of view to be loaded)
        protected $printable_name; //name for message when no posts returned
  
  
  public function __construct($selected_subjects, 
                            $offset, 
                            $category_type, 
                            $tag_type, 
                            $selected_institutions, 
                            $body_type, 
                            $location,
                            $selected_provider,
                            $selected_category_type,
                            $search,
                            $order_by,
                            $order_a_z,
                            $tax_or_cat) 
  {      
      $this->selected_subjects= $selected_subjects;
      $this->offset= $offset;
      $this->category_type= $category_type;
      $this->tag_type= $tag_type;
      $this->selected_institutions= $selected_institutions;
      $this->body_type= $body_type;
      $this->location=$location;
      $this->selected_provider= $selected_provider;
      $this->selected_post_type=$selected_category_type;
      $this->search_term= $search;
      $this->order_by= $order_by;
      $this->order_a_z= $order_a_z;
      $this->tax_or_cat= $tax_or_cat;
  }
    
  public function create_filter($filter_type){
      
    //get the post args
    $args= $this->initiate_post_args($filter_type);
    
    if($this->tax_or_cat=='tax'){
    //query any checked subjects/professions/destinations
    $args= $this->taxonomy_shared_filter($this->tag_type, 0,$this->selected_subjects, $args);
                
    //initiate filters depending on page types
    $args=$this->create_regular_taxonomy_filters($args);
    }
    elseif($this->tax_or_cat=='cat'){
      $args= $this->category_handler($args);
    }   
    query_posts($args);
    
   return $this->load_post_loop_view($filter_type);
      
      
  }
  
  
  private function category_handler($args){
      
      $this->view="blog_post_loop.php";
      $args=$this->regular_taxonomy_filter('category', 0, $this->selected_subjects, $args);
      return $args;
  }
  
  private function create_regular_taxonomy_filters($args){
       
       if($this->category_type=='course'){
            $args= $this->regular_taxonomy_filter('course-provider', 3, $this->selected_provider, $args); 
            $args= $this->regular_taxonomy_filter('uni', 2,$this->selected_institutions, $args);
            $args= $this->regular_taxonomy_filter('course-type', 5,$this->selected_post_type, $args);

            $this->view = "course_post_loop.php";
            $this->printable_name= "courses";
      }
      elseif($this->category_type=='graduate-job' || $this->category_type=='work-experience-job'){
        
            $args= $this->regular_taxonomy_filter('job-provider', 3, $this->selected_provider, $args);  
            $args= $this->regular_taxonomy_filter('company', 2,$this->selected_institutions, $args);
            $args= $this->regular_taxonomy_filter('location', 4, $this->location, $args);  

            $this->view = "graduatejob_post_loop.php";
            $this->printable_name= "jobs";

       }
       if($this->category_type=='graduate-job'){
           
           $args= $this->regular_taxonomy_filter('job-type', 5,$this->selected_post_type, $args);          
       }
       if( $this->category_type=='work-experience-job'){
           
           $args= $this->regular_taxonomy_filter('work-experience-type', 5,$this->selected_post_type, $args);
       }
       elseif($this->category_type=='travel-opportunities'){
        
           $args= $this->regular_taxonomy_filter('travel-agent', 3, $this->selected_provider, $args);  
           $args= $this->regular_taxonomy_filter('travel-type', 5,$this->selected_post_type, $args);
 
           
           $this->view = "travel_post_loop.php";
           $this->printable_name= "travel opportunities";
       }
              
       return $args;
   }
   
   
    private function load_post_loop_view($filter_type) {
        if (!have_posts()){
         
            if ($filter_type=='select'){
              echo '<div class="sorry-message hentry" style="width:100%">
                  <h2 class="no-more" style="width:100%">
                   <br><br> Sorry, we don&apos;t have any '.$this->printable_name.' matching this criteria at the moment, please try a different filter.
                   </h2>
                   <button id="reset-filter" class="btn btn-success">Reset Filter</button></div>';exit;
            }
            elseif ($filter_type=='scroll'){
              echo '<div class="sorry-message hentry" style="width:100%">
                  <h2 class="no-more" >
                  <br><br> Sorry, that&apos;s all the '.$this->printable_name.' we&apos;ve got matching your criteria. We&apos;re working to add more! 
                  </h2>
                  <button id="reset-filter" class="btn btn-success">Reset Filter</button>
                   </div>';exit;
            }
        return;
        }
        else{
        include('templates/templates-post-loop/'.$this->view);      
        }
        wp_reset_query();
        exit;
    }
    
    /*
     * taxonomy_shared_filter
     * 
     * @param: tag_type_name
     * returns: args
     * 
     * takes a taxonomy tag-type name, e.g. 'subject', and applies that name as the
     * regular taxonomy we are filtering against.
     */
    private function taxonomy_shared_filter($tag_type_name, $array_index, $selected_terms, $args){
    
       if($selected_terms!="" && $this->tag_type==$tag_type_name){//if a box has been checked, we add a taxnomoy query
         
            $args['tax_query'][$array_index]['terms']=$selected_terms;
            $args['tax_query'][$array_index]['taxonomy']=$tag_type_name;
            $args['tax_query'][$array_index]['field']='slug';
            
      }
      return $args;
    
   }
   
    private function regular_taxonomy_filter($tag_type_name, $array_index, $selected_terms, $args){
    
       if($selected_terms!=""){//if a box has been checked, we add a taxnomoy query
         
            $args['tax_query'][$array_index]['terms']=$selected_terms;
            $args['tax_query'][$array_index]['taxonomy']=$tag_type_name;
            $args['tax_query'][$array_index]['field']='slug';
            
      }
      return $args;
    
   }
   
   private function initiate_post_args($filter_type){
   	
   	if($filter_type=='scroll')$offset=6;
   	elseif($filter_type=='select')$offset=9;
       
     $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

     $args= array
    (
        'offset'=>$this->offset,
        'post_type'=>$this->category_type,
        'paged'=>$paged,
        'posts_per_page'=>$offset,
        'orderby' => $this->order_by,
        'order' => $this->order_a_z,
        's'=>$this->search_term
    );
     if ($this->tax_or_cat=='cat'){
        
           $user = get_userdatabylogin($this->selected_provider);
           $search_tag=  str_replace(' ', '-', $this->selected_institutions);
         
         $args2=array(
             'tag'=>$search_tag,
             'author'=>$user->ID
         );
         
         $args= array_merge($args, $args2);
     }
  
       return $args;
   }
    
}
?>
