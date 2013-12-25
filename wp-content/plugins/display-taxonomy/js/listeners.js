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
   tree_listener($,"#Subject_Filter", all_selections.Subjects=[], selected_subjects);
   tree_listener($,"#Profession_Filter", all_selections.Professions=[], selected_subjects);
   tree_listener($,"#Destination_Filter", all_selections.Destinations=[], selected_subjects);
   tree_listener($,"#Provider_Filter", all_selections.Providers=[], selected_providers);
   tree_listener($,"#Location_Filter", all_selections.Locations=[], selected_locations);
   tree_listener($,"#Type_Filter", all_selections.Types=[], selected_category_type);


   //activate instituion listeneres
   select2_search_listener($, 'company', all_selections.Company=[]);
   select2_search_listener($, 'uni',all_selections.University=[]);
   
   //popup listener
   popup_listener($);
   
   //reset when scrollup 
   scroll_up_click_reset($);
   
   //search filter
    Search_Filter($, all_selections.Search=[]);
   
}


/*
 *tree_listener 
 * @param {type} $
 * @param {type} filter_selector
 * @param {type} arr_object
 * @param {type} global_var
 * @returns {undefined}
 * listens for changes in the subject filter checkboxes
 */
function tree_listener($, filter_selector, arr_object, global_var){
     
    
    $(filter_selector+' .dtree_tax input').change(function()
    {
       if ($(this).is(':checked')) {
                
         var term= $(this).siblings('.node').text();

          global_var.push($(this).siblings('.node').attr('slug'));         
          arr_object.push([term]);

          apply_filter($);
      
        }
        else{
            var selection_name= ($(this).siblings('.node').text());
   
             $.each(arr_object, function(index, item){
                if (item==selection_name){
                    (arr_object.splice(index,1))
                }
            }); 
            
            var name= ($(this).siblings('.node').attr('slug'));        
            var index = global_var.indexOf(name);
            global_var.splice(index,1);

            apply_filter($);
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

        apply_filter($);
       }
       
   });
    
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
        apply_filter($);

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


function remove_tag_from_search($){
    
   
    
    $('.selected-filter').click(function(){
        
        var selected_option= $(this).text();
      
        $('.node').each(function(i, obj) {
            //test
            var checkbox= $(obj).text()
            if(selected_option==checkbox){
            
                var cb=$(obj).siblings('input[type=checkbox]');
                
                cb.trigger('click');
                return;
            }
        });


        $(".select2-search-choice").each(function(i, obj){
            
            
            var select2_option= $(obj).text();
            //strip spaces, or they dont match
                select2_option = select2_option.replace(/\s/g, '');
                selected_option = selected_option.replace(/\s/g, '');

               if(selected_option==select2_option){
                var select_close=$(obj).children('a');
                select_close.trigger('click');
                    $(document).css({'cursor':'wait'})

                setTimeout(function(){$(".input-append .btn").trigger('click');}, 300);
                    $(document).css({'cursor':'default'})

                return;
            }
            
        });
        
        
    });
    
    
    $('.selected-search').click(function(){
        $('.selected-search-index').remove();
        $(this).remove();
        $('#Search_Term').val('');
        $('#Search_Filter').click();
        
    });
    
}

/*
 * popup listener
 * 
 */
function popup_listener($){
    
    $('.clickme').unbind('click.popup');
   

 $('.clickme').bind('click.popup', function() {

            var post_id= $(this).parent().parent('.hentry').attr('id');

     $(window).unbind('scroll.load_more'); //deactivate infinitescroll
        //if data already loaded, don't need to do it again
         if ($(this).siblings(".pop-out").html().length > 0) {
             closeBoxHandler($, post_id)
            return;
         }                                     
        
        
        var category= $('#content').attr('category_type');
        var tag_type= $('#content').attr('tag_type');
        var body_type= $('#content').attr('body_type');
        var popup= $(this).siblings('.pop-out');
    
        process_popup_data($, popup,category,tag_type,body_type, post_id);
   });
}


function scroll_up_click_reset($){
 
 $('#scrollUp').click(function(){
     
        resetCurrentActiveBox($); 
 });
 
}


function Search_Filter($,search_terms){
 
 $("#Search_Filter").click(function(e){
     
     e.preventDefault();
     
     var terms= $('#Search_Term').val();
     
     //alert(terms)
      if(terms){
         
        search_terms.length=0;
        search_terms.push(terms);
             
        }
        else   search_terms.length=0;
        
       
    console.log(search_terms)
    apply_filter($);
     
     
 });
 

}