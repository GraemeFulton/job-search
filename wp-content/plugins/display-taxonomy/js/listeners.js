/*
 * listeners.js
 * checkbox/select box listeners
 * 
 */
/*
 * check_box_listener
 * @returns {undefined}
 * Listener for changes in checkboxes
 * Triggers checked() & unchecked() functions
 */
function activate_listeners($){
  
  //Clear all selections
   clear_previous_selections($);
    
  //activate listeners  
   subject_listener($);
   profession_listener($);
   institution_listener($);
   provider_listener($);
   
 //  location_search($);
   category_type_listener($);
   
    location_listener($);
    
}


/*
 *profession_listener 
 * @param {type} $
 * @returns {undefined}
 * listens for changes in the subject filter checkboxes
 */
function profession_listener($){
    $('#Profession_Filter .dtree_tax input').change(
        
        function()
    {
       if ($(this).is(':checked')) {
           
           selected_subjects.push($(this).siblings('.node').attr('slug'));
           apply_filter($,this, true, 'location');
      
        }
        else{
            var name= ($(this).siblings('.node').attr('slug'));        
            var index = selected_subjects.indexOf(name);
            selected_subjects.splice(index,1);
        
            apply_filter($,this, false, 'subject');
        }
    });
}

/*
 *profession_listener 
 * @param {type} $
 * @returns {undefined}
 * listens for changes in the subject filter checkboxes
 */
function subject_listener($){
    $('#Subject_Filter .dtree_tax input').change(
        
        function()
    {
       if ($(this).is(':checked')) {
           
           selected_subjects.push($(this).siblings('.node').attr('slug'));
           apply_filter($,this, true, 'location');
      
        }
        else{
            var name= ($(this).siblings('.node').attr('slug'));        
            var index = selected_subjects.indexOf(name);
            selected_subjects.splice(index,1);
        
            apply_filter($,this, false, 'subject');
        }
    });
}


/*
 *institution_listener 
 * @param {type} $
 * @returns {undefined}
 * listens for changes in the institution filter checkboxes
 */
function institution_listener($){
  $('#institution-filter input:checkbox').change(
    
    function()
    {
                var name = $(this).attr('name');

       if ($(this).is(':checked')) {
            
            selected_institutions.push(name);
            apply_filter($,this, true, 'institution');
      
        }
        else{
        var index = selected_institutions.indexOf(name);
           selected_institutions.splice(index,1);
            apply_filter($,this, false, 'institution');
        }
    }); 
}

/*
 *provider_listener 
 * @param {type} $
 * @returns {undefined}
 * listens for changes in the subject filter checkboxes
 */
function provider_listener($){
  $('#provider-filter input:checkbox').change(
    
    function()
    {
            var name = $(this).attr('name');

       if ($(this).is(':checked')) {

            selected_providers.push(name);
            apply_filter($,this, true, 'provider');
      
        }
        else{
        var index = selected_providers.indexOf(name);
           selected_providers.splice(index,1);
            apply_filter($,this, false, 'provider');
        }
    }); 
}

/*
 * category_type_listener
 * @param {type} $
 * @param {type} arg
 * @param {type} true_false
 * @param {type} filter_type
 * @returns {undefined}
 */
function category_type_listener($){
    
      $('#category-type-filter input').change(
    
    function()
    {
       if ($(this).is(':checked')) {
           var name= $('input[name=option]:checked', '#category-type-filter').attr('value');
               
            selected_category_type=[]
            selected_category_type.push(name);
            
            if(name=="clear"){selected_category_type=""}
            apply_filter($,this, true, 'category_type');
      
        }
        else{
            
            selected_category_type=[];

            apply_filter($,this, false, 'category_type');
        }
    }); 
    
}


/*
 * location_search
 * @param {type} $
 * @param {type} arg
 * @param {type} true_false
 * @param {type} filter_type
 * @returns {undefined}
 * currently not using this for locations
 */
function location_search($){
    
    //listen for if the box is empty
     $(".input-append").change(function(){
       if($(".select2-choices").children().length==1){
           meta_filter="";
           meta_filter_arr=[];
        apply_filter($,'#multi-append', true, '');
       }
       
   }) 
    
    //all on click!
    $('#location_search').click(function(){
    
       //assign value of meta box to meta_filter variable
        meta_filter= $("#multi-append").val();//$("#multi-append").select2("val");

        //if there IS something in the box, meta_filter=box value
        if(meta_filter!=null){
            meta_filter=meta_filter.toString();
            meta_filter_arr= meta_filter.split(',');console.log(meta_filter_arr);
        }
        else meta_filter="";//else meta_filter is blank

        apply_filter($,'#multi-append', true, '');

    })
    
}


function location_listener($){

    $('#input:checkbox').prop('checked', false);

     $('#Location_Filter .dtree_tax input').change(
    
    function()
    {
       if ($(this).is(':checked')) {
           
           selected_locations.push($(this).siblings('.node').attr('slug'));
           apply_filter($,this, true, 'location');
      
        }
        else{
            var name= ($(this).siblings('.node').attr('slug'));        
            var index = selected_locations.indexOf(name);
            selected_locations.splice(index,1);
        
            apply_filter($,this, false, 'location');
        }
    }); 
}



/*
 * clear_previous_selections
 * @param {type} $
 * @returns {undefined}
 * removes any previously selected options 
 * clears checkboxes and select box
 */
function clear_previous_selections($){
    
    $('#input:checkbox').prop('checked', false);
    $('#myselect').attr('value','');
    
    //clear duplicate select values
    remove_duplicate_select_options($);
    
}