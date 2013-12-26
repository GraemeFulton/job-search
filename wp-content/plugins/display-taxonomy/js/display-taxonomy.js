jQuery(document).ready(function ($) {
    
    activate_listeners($);

    graylien_infinite_scroll($);     
    
  //$("#tree").fancytree("option", "checkbox", true);

});

/*
 * var url_string
 * 
 * Newly checked categories are appended to the url
 * Unchecked categories are removed from the url_string
 */
var selected_subjects =[]; //array to hold checked subjects
var selected_providers=[];//array to hold checked providers
var selected_category_type=[];
var selected_locations=[];
var selected_institutions=[];

var meta_filter= "";
var meta_filter_arr=[];

var all_selections={};
/*
 * graylien_infinite_scroll
 * @param {type} $
 * @returns {undefined}
 * triggers the call to load more when user scrolls to bottom
 */
var isLoadingData;
function graylien_infinite_scroll($){
     
     //make sure it's not bound from the start
     $(window).unbind('scroll.load_more');
     
    $(window).bind('scroll.load_more',function () {
                
   if (($(window).scrollTop() >= $(document).height() - $(window).height())) {
  
    //if there's already no more, exit here
        if ($('.no-more').length > 0){
        return;
        }
            var postoffset = $('.hentry').length;
            var category_type= $('#content').attr('category_type');
            var tag_type= $('#content').attr('tag_type');
            var body_type= $('#content').attr('body_type');

      
            process_filter_scroll($,postoffset, category_type, tag_type, body_type);
            isLoadingData=true;

            resetCurrentActiveBox($);
            setTimeout(function(){isotopes_modal($);}, 500);


   }
});

    
}

/*
 * checked
 * @param {type} arg
 * @returns {undefined}
 * 
 * Called when you check/uncheck any checkbox
 * Adds the newly checked box to the url_string
 * or removes unchecked value from url_string
 * 
 */
function apply_filter($){
    
  //  $("html, body").animate({ scrollTop: 0 }, 500);
    //filter for the url_string
    var category_type= $('#content').attr('category_type');
    var tag_type= $('#content').attr('tag_type');
    var body_type= $('#content').attr('body_type');

       
        //add filter value to process filter, and collect it in the php file, then use it to filter the post
         process_filter($, category_type, tag_type, body_type);
            
            closeActiveBox($);
            disableClickMe($);
            setTimeout(function(){isotopes_modal($);}, 500);
   
}


/*
 *process_subject 
 * @param {type} $
 * @param {type} tax
 * @returns {undefined}
 * ajax filter for subject box
 */
function process_filter($, category_type, tag_type, body_type){

    update_selected_options($);
     $('.sorry-message').remove();

    //loading gif
    $('.hentry').empty();
    $('#content').prepend('<img id="ajax-loader" style="margin:10px 0 0 10px;"src="'+templateUrl+'/ajax-loader.gif"/>');

    $.ajax({
     url: '/LGWP/wp-admin/admin-ajax.php', 
     type: "POST",
     data: {
            'action': 'check_box_filter',
            'fn':'select',
            'selected_subjects':selected_subjects,
            'cat':category_type,
            'type':tag_type,
            'selected_institutions':selected_institutions,
            'body_type': body_type,
            'location': selected_locations,
            'provider':selected_providers,
            'selected_category_type':selected_category_type,
             'search_filter':all_selections.Search[0]
           },
   dataType:'HTML', 
   success: function(data){
 console.log(selected_institutions)
        //remove all boxes
        $(".hentry").remove(); 
       
       //destroy isotopes
       var $container = $('#loaded_content');
        $container.isotope('destroy');

        // initialize isotope
        $container.isotope({
         masonry: {
                    columnWidth: 0
                  }
         });
               
         $('#loaded_content').isotope( 'insert', $(data) );
         resetCurrentActiveBox($);
            //reinitiate ratings plugin
     //    $('.kk-star-ratings').kkstarratings();
                  $('#ajax-loader').remove();
       
       setTimeout(function(){ $('#loaded_content').isotope( 'reLayout');}, 500); //prevent overlap

         return false;
     },
             
     error: function(errorThrown){
               alert('error');
               console.log(errorThrown);
          }
});  

}

/*
* process_filter_scroll

 * @param {type} $
 * @param {type} tax
 * @param {type} postoffset
 * @returns {undefined} */
function process_filter_scroll($, postoffset, category_type, tag_type, body_type){
  
 if(isLoadingData===true) return;
     //loading gif
     $('.sorry-message').remove();
    $('#content').append('<img id="ajax-loader" src="'+templateUrl+'/ajax-loader.gif"/>');
    
    $.ajax({
     url: '/LGWP/wp-admin/admin-ajax.php', 
     type: "POST",
     data: {
            'action': 'check_box_filter',
            'fn':'scroll',
            'selected_subjects':selected_subjects,
            'offset':postoffset,
            'cat':category_type,
            'type':tag_type,
            'selected_institutions': selected_institutions,
            'body_type': body_type,
            'location': selected_locations,
            'provider': selected_providers,
            'selected_category_type':selected_category_type,
            'search_filter':all_selections.Search[0]
           },
   dataType:'HTML', 
   
    success: function(data){
         
          var $container = $('#loaded_content');
  
          // initialize isotope
          $container.isotope({
            // options...
            masonry: 
                    {
                     columnWidth: 0,
                     rowHeight:0
                    }
             });
             
         //append new isotopes    
         $('#loaded_content').isotope( 'insert', $(data) );
         setTimeout(function(){ $('#loaded_content').isotope( 'reLayout');}, 320); //prevent overlap
        
         isLoadingData=false;
         //reinitiate ratings plugin
    //     $('.kk-star-ratings').kkstarratings();
             $('#ajax-loader').remove();
             $('#ajax-loader').remove();

//rebind infinitescroll
            graylien_infinite_scroll($);
            popup_listener($);
//////////////////////////

         return false;
     },
     error: function(errorThrown){
               alert('error');
               console.log(errorThrown);
          }
});  

    
}

/*
* process_popup_data

 * @param {type} $
 * @param {type} tax
 * @param {type} postoffset
 * @returns {undefined} */
function process_popup_data($, popup, category, tag_type,body_type, post_id){
    
    $.ajax({
     url: '/LGWP/wp-admin/admin-ajax.php', 
     type: "POST",
     data: {
            'action': 'popup_filter',
            'category':category,
            'post_id': post_id,
            'tag_type':tag_type,
            'body_type': body_type
           },
   dataType:'HTML',   
    success: function(data){
        $(popup).css("display", "none"); 
        $(popup).append(data);
        $(popup).slideDown('slow');
        closeBoxHandler($, post_id)

        return false;
     },
     error: function(errorThrown){
               alert('error');
               console.log(errorThrown);
          }
});  

    
}


function update_selected_options($){
 
 var selected_option_head= '<h4 class="options-title"><i style="margin-top:-15px;"class="fa fa-search"></i> &nbsp;Your Selected Options: </h4>';
     selected_option_head+='<div class="clear_both"></div><div id="nothing_selected">Nothing Selected. Please use the filters available on the left to find what you want.</div>'
    
    
    $('#selected-options').empty().append(selected_option_head);
    
 $.each(all_selections, function(index, item){
        
    if(item!=""){
        $("#nothing_selected").remove();
        var output= '<div class="filter-group">';

        //if it's a search item:
      if(index=='Search'){
        output+='<span class="selected-index selected-filter selected-search-index">'+index+': </span>';

        $.each(item, function(index,tag){
            output+='<span class="selected-tag selected-search">'+tag+'</span>';

            
        });
        
        }
        else
        {
            //otherwise:
            
            output+='<span class="selected-index selected-filter">'+index+': </span>';

            $.each(item, function(index, tag){
               output+='<span class="selected-tag selected-filter">'+tag+'</span>';

            })
        }
            output+='</div>';

            $('#selected-options').append(output);

        
    }
     
 });
     
     
   remove_tag_from_search($);
 
 
}


/*
 * remove_duplicate_select_options
 * @param {type} $
 * @returns {undefined}
 * removes any duplicate names from the meta select box
 */
function remove_duplicate_select_options($){
    
    var usedNames = {};
     $("select[name='meta'] > option").each(function () 
     {
         if(usedNames[this.text]) 
         {
            $(this).remove();
         } 
         else 
         {
            usedNames[this.text] = this.value;
         }
    });
}


/*
 * load_more_button
 * @param {type} $
 * @returns {undefined}
 * listens for click of load more button, and loads more posts
 */
//function load_more_button_listener($){
// $('#blog-more').click(function(event){
//       event.preventDefault();
//        var postoffset = $('.hentry').length;
//        var category_type= $('#content').attr('category_type');
//        var tag_type= $('#content').attr('tag_type');
//
// // console.log("offset: "+postoffset);
//
//  process_filter_scroll($,postoffset, category_type, tag_type, body_type);
// });  
//}