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
  
  //activate select2
  activate_select_2($);
  
  
  //Clear all selections
   clear_previous_selections($);
    
  //activate listeners  
  //activate trees
   tree_listener($,"#Subject_Filter", all_selections.Subjects=[], selected_subjects,'.dtree_tax');
   tree_listener($,"#Profession_Filter", all_selections.Professions=[], selected_subjects,'.dtree_tax');
   tree_listener($,"#Topic_Filter", all_selections.Topics=[], selected_subjects,'.dtree_tax');
   tree_listener($,"#Destination_Filter", all_selections.Destinations=[], selected_subjects,'.dtree_tax');
   tree_listener($,"#Provider_Filter", all_selections.Providers=[], selected_providers,'.dtree_tax');
   tree_listener($,"#Location_Filter", all_selections.Locations=[], selected_locations,'.dtree_tax');
   tree_listener($,"#Type_Filter", all_selections.Types=[], selected_category_type,'.dtree_tax');

   tree_listener($,"#Category_Filter", all_selections.Category=[], selected_subjects, '.dtree_cat');

   //activate instituion listeners
   select2_search_listener($, 'company', all_selections.Company=[]);
   select2_search_listener($, 'uni',all_selections.University=[]);
   select2_search_listener($, 'inspire-tag',all_selections.Tag=[]);

   //activate post page listeners
   select2_single_filter_listener($, 'tag',all_selections.Tags=[]);
   select2_single_filter_listener($, 'author',all_selections.Author=[]);

   //popup listener
   //popup_listener($);
   
   //reset when scrollup 
   scroll_up_click_reset($);
   
   //search filter
    Search_Filter($, all_selections.Search=[]);
    //Tag_Search_Filter($, all_selections.Tags=[]);

    //scroller
    scrollHandler($);
   
   //sidebar popout
   popout_sidebar($);
   filter_tab_listener($);
   
   //order by listner
   order_by_listener($);
   sort_button_listener($);
   reset_filter_listener($);
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
function tree_listener($, filter_selector, arr_object, global_var, dtree_type){
     
    uncheck_parent($,filter_selector);
    
    $(filter_selector+' '+dtree_type+' input').change(function()
    {
        console.log("change");
        if ($(this).is(':checked')) {
                
         var term= $(this).siblings('.node').text();

         

            if(dtree_type=='.dtree_cat'){
                global_var.push($(this).siblings('.node').attr('title'));         
                arr_object.push([term]);
                get_delay_apply_filter($)
            }
            else{
                global_var.push($(this).siblings('.node').attr('slug'));         
                arr_object.push([term]);
                get_delay_apply_filter($)
            }
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

          
            get_delay_apply_filter($)
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
//     $(".input-append").change(function(){
//         
//         
//       if($(".select2-choices").children().length==1){
//           arr_object.length=0;
//
//            get_delay_apply_filter($)
//       }
//       
//   });
    
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
            get_delay_apply_filter($)

    });
}


function select2_single_filter_listener($,filter_type, arr_object){

 $('#'+filter_type+'-multi-append').select().on("change", function(e) {

     var tag= $(this).val();
       if(tag!==''){
           
         arr_object.length=0;
         
       arr_object.push(tag);
       
      
        }
        else   arr_object.length=0;
        
        
//        selected_institutions = arr_object;
            get_delay_apply_filter($)
   });

}

/*
* activate_select_2

 * @param {type} $
 * @returns {undefined} */
function activate_select_2($){
 
    $('.select2').select2({ placeholder : 'Select an option',
          allowClear: true
        });
      
      $('button[data-select2-open]').click(function(){
        $('#' + $(this).data('select2-open')).select2('open');
      });
}


/*
* Order By Listener

 * @param {type} $
 * @returns {undefined} */

function order_by_listener($){
    
    $("#sort-box").change(function(){
           
        order_by=this.value;
        if(this.value=='title'){
          $(".numeric-sort").fadeOut(function(){
                        $(".alpha-sort").fadeIn();

          });

        }
        else if(this.value=='date'){
            $(".alpha-sort").fadeOut(function(){
                           $(".numeric-sort").fadeIn();

            });
        }
        sort_a_z='ASC';
        get_delay_apply_filter($);

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
    
    $('input:checkbox').prop('checked', false);
    $('#myselect').attr('value','');
    
    //clear duplicate select values
    remove_duplicate_select_options($);
    
}

/*
 * uncheck_parent
 * e.g. if CS is checked, and we then check AI, it's still include all CS
 * results when the search is performed. 
 * Therefore we need to uncheck the parent, and vica versa
 */
function uncheck_parent($, filter_selector){
            var child_is_checked=false;
            var parent_is_checked=false;
      $(filter_selector+' .dtree_tax input').change(function()
    {
        
             //get the parent checkbox, and uncheck it
           if($(this).prev().get(0).tagName=='IMG'){
               if (child_is_checked==true)return;
               
              var parent=$(this).parent().parent().prevAll('.dtNode:first').children('input');
        if(parent.is(':checked')){
            parent_is_checked=true;

            parent.click();
        }
                    parent_is_checked=false;
                    
         }
            
        //get the children checkbox, and uncheck it
        var children=$(this).parent().next('.clip:first').children('.dtNode').children('input');
        
        if(children.length>0){

           if (parent_is_checked==true)return;
            
           $(children).each(function(){
               if($(this).is(':checked'))child_is_checked=true;
               if($(this).is(':checked')){
                    $(this).click();
                }
           
           });
            child_is_checked=false;
        }
   
    });
}

/*
* remove_tag_from_search
* 
* listens for when selected tags are closed
* and clears them from the filter
* 
 * @param {type} $
 * @returns {undefined} */
function remove_tag_from_search($){
    
   
    //clear the filters
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
                    setTimeout(function(){$(".input-append .btn").trigger('click');}, 500)
                    
                    return;
                    }
            });
        
        
    });
    
    //clear the main search bar
    $('.selected-search').click(function(){

        $('.selected-search-index').remove();
        $(this).remove();
        $('#Search_Term').val('');
        $('#Search_Filter').click();
        
    });
    
    //clear the tag box
    $('.selected_tags').click(function(){

        $('.selected-tags-index').remove();
        $(this).remove();
        
        $('#s2id_tag-multi-append').select2('data', null, function(){
            var tag= $(this).val();
            get_delay_apply_filter($)
               
        });
        
        
        
    });
    
      //clear the author box
    $('.selected-author').click(function(){

        $('.selected-author-index').remove();
        $(this).remove();
        
        $('#s2id_author-multi-append').select2('data', null, function(){
            var tag= $(this).val();
            get_delay_apply_filter($)
        });
        
        
        
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
//  $('html,body').animate({ scrollTop: 200 }, 'fast');

     e.preventDefault();
     
     var terms= $('#Search_Term').val();
     
      if(terms){
         
        search_terms.length=0;
        search_terms.push(terms);
             
        }
        else   search_terms.length=0;
        
       
    get_delay_apply_filter($);
     
     
 });
 
}

//function Tag_Search_Filter($,search_terms){
// 
// $("#Tag_Search_Filter").click(function(e){
////  $('html,body').animate({ scrollTop: 200 }, 'fast');
//
//     e.preventDefault();
//     
//     var terms= $('#Tag_Search_Term').val();
//     
//      if(terms){
//         
//        search_terms.length=0;
//        search_terms.push(terms);
//             
//        }
//        else   search_terms.length=0;
//        
//       
//    get_delay_apply_filter($);
//     
//     
// });
// 
//}



/*
* sort button listener

 * @param {type} $
 * @returns {undefined} */
function sort_button_listener($){
   $('.sort-button').click(function(){
       if ( $(this).hasClass("sort-asc") ){
           $(this).addClass('sort-active');
           $(".sort-desc").removeClass('sort-active');
           sort_a_z='DESC';
               get_delay_apply_filter($);


       }
        if ( $(this).hasClass("sort-desc") ){
           $(this).addClass('sort-active');
           $(".sort-asc").removeClass('sort-active');
             sort_a_z='ASC';
                 get_delay_apply_filter($);


       }
       
   
   });
 
}

function reset_filter_listener($){
     $('#reset-filter').click(function(){
           //                get_delay_apply_filter($);
 window.setTimeout('location.reload()', 1);        //  clear_previous_selections($);

   });
}

/*
 * scroll
 * 
 * after the page scrolls down a bit, the left bar, and breadcrumbs
 * click to the top.
 */
var lastFixPos = 0;
var threshold = 800;

function scrollHandler($){

        $(document).scroll(function () {
             //dont run if small window size
    if ($(window).width() < 1025) {return;}
    
            
    var y = $(this).scrollTop();
    if (y > 115) {
        $("#sidebar-left").css({"top":"70px","height":"95%","width":"15%", "position":"fixed", "overflow-y":"scroll"});
        $("#content").css({"margin-left":"15%", "border-left":"1px solid rgba(0,0,0,0.3)"});
       // $("#sidebar-right").css("top", "0px");
        $("#selected-options").css({"position":"fixed", "top":"70px","right":"196px", "margin":"0px"});
        $("#selected-options-container").css({"position":"fixed", "top":"70px","right":"0px","margin":"0px"});

        $(".sidebar-main").css({"margin-top":"240px", "border-top":"1px solid #ccc"});

   } 
    else{ 
        $("#sidebar-left").css({"top":"","height":"80%", "position":"relative","width":"", "overflow-y":""});
                $("#content").css({"margin-left":"", "border-left": ""});
        $("#selected-options").css({"position":"", "top":"", "right":"", "margin":""});
        $("#selected-options-container").css({"position":"", "top":"",  "width":"", "margin":""});

        $(".sidebar-main").css({"margin-top":"", "border-top":""});

    //    $("#sidebar-right").css("top", "");
     //   $("#breadcrumbs").css({"position":"relative", "top":""});

}
 if (y > 800) {
     
     $("#to_top").fadeIn();
     
 }
 else{$("#to_top").fadeOut();}
 
 var diff = Math.abs($(window).scrollTop() - lastFixPos);
  if(diff > threshold){

           // resetCurrentActiveBox($);            

    lastFixPos = $(window).scrollTop();
  }
 

});
    
    
}

/*
 * Popout Sidebar
 * 
 * -for mobiles-
 *when the toggle button is clicked, this expands the left sidebar, and forces
 *the main content to go underneath. When clicked again, the opposite happens
 *
 *when sidebar is open, the right arrow icon is swapped with a left arrow icon 
 *
 */

function popout_sidebar($){
   
       var $content= $('.mobile-menu');
       $('#sidebar-toggle').bind('click', function(){
           $content.toggleClass('mobile-menu-open');
           $('.navbar-brand').toggleClass('nav-hide');
           $('.navbar-toggle').toggleClass('nav-hide');
           $('.navbar-nav').toggleClass('nav-hide');
           $('#main_search').toggleClass('nav-hide');
          
       })

    
}


function filter_tab_listener($){
   
      $('#filter-tab-2').on('click', function(){
           $('#filter-tab-2').addClass('active-filter')
           $('#filter-tab-1').removeClass('active-filter')

            $('.filter-tab-1').fadeOut('medium', function(){
                    $('.filter-tab-2').fadeIn();
            });
      });
      
        $('#filter-tab-1').on('click', function(){
                   $('#filter-tab-1').addClass('active-filter')
                    $('#filter-tab-2').removeClass('active-filter')
         
            $('.filter-tab-2').fadeOut('medium', function(){
               $('.filter-tab-1').fadeIn();
            });
      });
}

/*
 * utility function
 */

function get_delay_apply_filter($){
    
    
var y = $(document).scrollTop();
    if (y < 400) { 
        if( $('#content').attr('category_type')) apply_filter($);
        else apply_cat_filter($);
    }else{
        
        
        $('html,body').animate({ scrollTop: 0 }, 'medium');
            setTimeout(function(){
                if( $('#content').attr('category_type')) apply_filter($);
                 else apply_cat_filter($);     
            }, 600)

        
    } 
            

}

