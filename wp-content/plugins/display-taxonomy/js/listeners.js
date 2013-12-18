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
  //activate trees
   subject_tree_listener($);
   profession_tree_listener($);
   provider_tree_listener($);

   //activate instituion listeneres
   select2_search_listener($, 'company', all_selections.Company=[]);
   select2_search_listener($, 'uni',all_selections.University=[]);
   
 //  location_search($);
   category_type_tree_listener($);
   
    location_tree_listener($);
    
}


/*
 *profession_tree_listener 
 * @param {type} $
 * @returns {undefined}
 * listens for changes in the subject filter checkboxes
 */
function profession_tree_listener($){
     
    all_selections.Professions=[];
    
    $('#Profession_Filter .dtree_tax input').change(function()
    {
       if ($(this).is(':checked')) {
                
         var term= $(this).siblings('.node').text();

          selected_subjects.push($(this).siblings('.node').attr('slug'));         
          all_selections.Professions.push([term]);

          apply_filter($,this, true, 'location');
      
        }
        else{
            var selection_name= ($(this).siblings('.node').text());
   
             $.each(all_selections.Professions, function(index, item){
                if (item==selection_name){
                    (all_selections.Professions.splice(index,1))
                }
            }); 
            
            var name= ($(this).siblings('.node').attr('slug'));        
            var index = selected_subjects.indexOf(name);
            selected_subjects.splice(index,1);

            apply_filter($,this, false, 'subject');
        }
    });
}

/*
 *subject_tree_listener 
 * @param {type} $
 * @returns {undefined}
 * listens for changes in the subject filter checkboxes
 */
function subject_tree_listener($){
    
    all_selections.Subjects=[];

    $('#Subject_Filter .dtree_tax input').change(function()
    {
       if ($(this).is(':checked')) {
           
           var term= $(this).siblings('.node').text();
         all_selections.Subjects.push([term]);
            
           selected_subjects.push($(this).siblings('.node').attr('slug'));
           apply_filter($,this, true, 'location');
      
        }
        else{
           var selection_name= ($(this).siblings('.node').text());

             $.each(all_selections.Subjects, function(index, item){
                if (item==selection_name){
                    (all_selections.Subjects.splice(index,1))
                }
            }); 
            
            var name= ($(this).siblings('.node').attr('slug'));        
            var index = selected_subjects.indexOf(name);
            selected_subjects.splice(index,1);
        
            apply_filter($,this, false, 'subject');
        }
    });
}

function provider_tree_listener($){
        all_selections.Providers=[];

    $('#Provider_Filter .dtree_tax input').change(function()
    {
     if ($(this).is(':checked')) {
           
           var term= $(this).siblings('.node').text();
         all_selections.Providers.push([term]);
            
           selected_providers.push($(this).siblings('.node').attr('slug'));
           apply_filter($,this, true, 'location');
      
        }
        else{
           var selection_name= ($(this).siblings('.node').text());

             $.each(all_selections.Providers, function(index, item){
                if (item==selection_name){
                    (all_selections.Providers.splice(index,1))
                }
            }); 
            
            var name= ($(this).siblings('.node').attr('slug'));        
            var index = selected_providers.indexOf(name);
            selected_providers.splice(index,1);
        
            apply_filter($,this, false, 'provider');
        }
    });
}

function location_tree_listener($){
        all_selections.Locations=[];

    $('#input:checkbox').prop('checked', false);

     $('#Location_Filter .dtree_tax input').change(
    
    function()
    {
      if ($(this).is(':checked')) {
           
           var term= $(this).siblings('.node').text();
         all_selections.Locations.push([term]);
            
           selected_locations.push($(this).siblings('.node').attr('slug'));
           apply_filter($,this, true, 'location');
      
        }
        else{

           var selection_name= ($(this).siblings('.node').text());
        
           $.each(all_selections.Locations, function(index, item){
                if (item==selection_name){
                    (all_selections.Locations.splice(index,1))
                }
            });   
            
            var name= ($(this).siblings('.node').attr('slug'));        
            var index = selected_locations.indexOf(name);
            selected_locations.splice(index,1);
        
            apply_filter($,this, false, 'location');
        }
    });
}



/*
 * select2_search_listener
 * @param {type} $
 * @param {type} institution_type
 * @returns {undefined}
 * used for select2 search boxes, currently companies and universities
 */
function select2_search_listener($, institution_type, arr_object){
   //listen for if the box is empty
     $(".input-append").change(function(){
       if($(".select2-choices").children().length==1){
           arr_object.length=0;

        apply_filter($,'#multi-append', true, '');
       }
       
   }) 
    
    //all on click!
    $('#'+institution_type+'_search').click(function(){
        
        var data = $('#'+institution_type+'-multi-append').select2('data');
   
        if(data){
         
        arr_object.length=0;
         
        $.each(data, function(){
              arr_object.push(this['text']);
        });
      
        }
        else   arr_object.length=0;
        
        
        selected_institutions = arr_object;
        apply_filter($,'#multi-append', true, '');

    })
}


/*
 * category_type_listener
 * @param {type} $
 * @param {type} arg
 * @param {type} true_false
 * @param {type} filter_type
 * @returns {undefined}
 */
function category_type_tree_listener($){
        all_selections.Type=[];

    $('#input:checkbox').prop('checked', false);

     $('#Type_Filter .dtree_tax input').change(
    
    function()
    {
      if ($(this).is(':checked')) {
           
           var term= $(this).siblings('.node').text();
         all_selections.Type.push([term]);
            
           selected_category_type.push($(this).siblings('.node').attr('slug'));
           apply_filter($,this, true, 'category_type');
      
        }
        else{
           var selection_name= ($(this).siblings('.node').text());

             $.each(all_selections.Type, function(index, item){
                if (item==selection_name){
                    (all_selections.Type.splice(index,1))
                }
            }); 
            
            
            var name= ($(this).siblings('.node').attr('slug'));        
            var index = selected_category_type.indexOf(name);
            selected_category_type.splice(index,1);
        
            apply_filter($,this, false, 'category_type');
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


/*
 *institution_listener 
 * @param {type} $
 * @returns {undefined}
 * listens for changes in the institution filter checkboxes
 */
//function institution_listener($){
//  $('#institution-filter input:checkbox').change(
//    
//    function()
//    {
//                var name = $(this).attr('name');
//
//       if ($(this).is(':checked')) {
//            
//            selected_institutions.push(name);
//            apply_filter($,this, true, 'institution');
//      
//        }
//        else{
//        var index = selected_institutions.indexOf(name);
//           selected_institutions.splice(index,1);
//            apply_filter($,this, false, 'institution');
//        }
//    }); 
//}

/*
 *provider_listener 
 * @param {type} $
 * @returns {undefined}
 * listens for changes in the subject filter checkboxes
 */
//function provider_listener($){
//  $('#provider-filter input:checkbox').change(
//    
//    function()
//    {
//            var name = $(this).attr('name');
//
//       if ($(this).is(':checked')) {
//
//            selected_providers.push(name);
//            apply_filter($,this, true, 'provider');
//      
//        }
//        else{
//        var index = selected_providers.indexOf(name);
//           selected_providers.splice(index,1);
//            apply_filter($,this, false, 'provider');
//        }
//    }); 
//}