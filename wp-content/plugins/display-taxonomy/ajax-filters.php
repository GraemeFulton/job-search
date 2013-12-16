<?php
/*
     * filter_by_subject_ajax
     * 
     * args: arguments from checkbox.js 
     * returns: returns html template to ajax call
     */
    function process_filter()
    {
         $super_filter = new Super_Filter($_POST['selected_subjects'], 
                          $_POST['offset'],
                          $_POST['cat'], 
                          $_POST['type'], 
                          $_POST['selected_institutions'],
                          $_POST['body_type'],
                          $_POST['location'],
                          $_POST['provider'],
                          $_POST['selected_category_type']);
         
         switch($_REQUEST['fn'])
        {
             
             case 'group_filter':
                 $output= $super_filter->create_filter();
             break;
         
             case 'regular_filter':               
                $output= $super_filter->create_filter();
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
        protected $selected_category_type;
  
  
  public function __construct($selected_subjects, 
                            $offset, 
                            $category_type, 
                            $tag_type, 
                            $selected_institutions, 
                            $body_type, 
                            $location,
                            $selected_provider,
                            $selected_category_type) 
  {      
      $this->selected_subjects= $selected_subjects;
      $this->offset= $offset;
      $this->category_type= $category_type;
      $this->tag_type= $tag_type;
      $this->selected_institutions= $selected_institutions;
      $this->body_type= $body_type;
      $this->location=$location;
      $this->selected_provider= $selected_provider;
      $this->selected_category_type=$selected_category_type;
  }
    
  public function create_filter(){
      
      
      $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    //get the post args
    $args= $this->initiate_post_args();
    
    //query any checked subjects/professions/destinations
    $args= $this->taxonomy_shared_filter($this->tag_type, 0,$this->selected_subjects, $args);
         
    //query any checked institutions
    $args= $this->xili_group_taxonomy_filter($args, 2, $this->selected_institutions);
       
      //query any checked provider (destination)
    $args=$this->filter_provider($args);
    
    //query any checked locations
    $args= $this->regular_taxonomy_filter('location', 4, $this->location, $args);  

    query_posts($args);
    
   return $this->load_post_loop_view($this->category_type);
      
      
      
  }  
    
    
    
//  public function create_filter_simple(){
//      
//    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
//
//    $args= $this->initiate_post_args();
//
//    
//    //query any checked subjects/professions/destinations
//    $args= $this->taxonomy_shared_filter($this->tag_type, 0,$this->selected_subjects, $args);
//    
//     //QUERY CHECKED PROVIDER (destination)
//    if($this->selected_provider!=""){//if a box has been checked, we add a taxnomoy query
//
//            $args['tax_query'][0]['terms']=$this->selected_provider;
//            $args['tax_query'][0]['taxonomy']='provider';
//            $args['tax_query'][0]['field']='slug';
//            
//    } //QUERY CHECKED PROVIDER
//    
//     //QUERY META VALUE (category_type)
//       if($this->selected_category_type!=""){
//           
//      $meta=array('relation'=>'OR');
//      foreach($this->selected_category_type as $key=>$value)
//        {     
//           $result = str_replace('-', '"', $value);
//
//           $meta[$key]=array(
//                    'key' => 'travel_type',
//                    'value' => $result,
//                    'compare' => 'LIKE',
//                    );              
//         
//        }                          
//
//          $args['meta_query']=$meta;
//            
//    }
//    
//    query_posts($args);
//
//    return $this->load_post_loop_view();
//    }
    
    
    
    private function load_post_loop_view() {

    if ($this->category_type=='course'){
    // the Loop
      include("Views/course_post_loop.php");  
    }
    else if($this->category_type=='graduate-job'){
        
        include("Views/graduatejob_post_loop.php");  
        
    }
      else if($this->category_type=='work-experience-job'){
        
        include("Views/graduatejob_post_loop.php");  
        
    }
       else if($this->category_type=='travel-opportunities'){
        
        include("Views/travel_post_loop.php");  
        
    }
    
    
    wp_reset_query();
    exit;
}

    /*
     * regular_taxonomy_filter
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
   
   private function xili_group_taxonomy_filter($args, $array_index, $selected_group_terms){
       
       if($selected_group_terms!=""){
            $tags_from_group=array();

             foreach($selected_group_terms as $term)
             {       
                $tags_from_group= array_merge($tags_from_group,xtt_tags_from_group($term, '',"xili_tidy_tags_".$this->body_type, $this->body_type));

                 $args['tax_query'][$array_index]['terms']=$tags_from_group;
                 $args['tax_query'][$array_index]['taxonomy']=$this->body_type;
                 $args['tax_query'][$array_index]['field']='slug';
             }
       }
       return $args;
       
   }
   
   private function filter_provider($args){
       
       if($this->category_type=='course'){
       $args= $this->regular_taxonomy_filter('course-provider', 3, $this->selected_provider, $args);  
       }
       elseif($this->category_type=='graduate-job' || $this->category_type=='work-experience-job'){
       $args= $this->regular_taxonomy_filter('job-provider', 3, $this->selected_provider, $args);  
       }
       elseif($this->category_type=='travel'){
       $args= $this->regular_taxonomy_filter('travel-agent', 3, $this->selected_provider, $args);  
       }
       
       return $args;
   }
   
   private function initiate_post_args(){
       
     $args= array
    (
        'offset'=>$this->offset,
        'post_type'=>$this->category_type,
        'paged'=>$paged,
        'posts_per_page'=>9,
        'orderby' => 'title',
        'order' => 'ASC'
    );
       
       return $args;
   }
    
}
?>
