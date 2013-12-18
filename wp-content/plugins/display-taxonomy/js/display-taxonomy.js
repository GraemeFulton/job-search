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
     
    $(window).scroll(function () {
                
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

            resetCurrentActiveBox($)
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
function apply_filter($,arg, true_false, filter_type){
    
  //  $("html, body").animate({ scrollTop: 0 }, 500);
    //filter for the url_string
    var category_type= $('#content').attr('category_type');
    var tag_type= $('#content').attr('tag_type');
    var body_type= $('#content').attr('body_type');

    if (true_false===true)
    {
           
        //add filter value to process filter, and collect it in the php file, then use it to filter the post
         process_filter($, category_type, tag_type, body_type);
            
            closeActiveBox($);
            disableClickMe($);
            setTimeout(function(){isotopes_modal($);}, 500);
                
    }      
    else { 
           
           process_filter($, category_type, tag_type, body_type);           
           
           closeActiveBox($);
            disableClickMe($);
            setTimeout(function(){isotopes_modal($);}, 500);
    }
        
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
            'action': 'check_box_filters',
            'fn':'select',
            'selected_subjects':selected_subjects,
            'cat':category_type,
            'type':tag_type,
            'selected_institutions':selected_institutions,
            'body_type': body_type,
            'location': selected_locations,
            'provider':selected_providers,
            'selected_category_type':selected_category_type
           },
   dataType:'HTML', 
   success: function(data){
 
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

         return false;
     },
             
     error: function(errorThrown){
               alert('error');
               console.log(errorThrown);
          }
});  

}

/*
* ajaxLoadMore

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
            'action': 'check_box_filters',
            'fn':'scroll',
            'selected_subjects':selected_subjects,
            'offset':postoffset,
            'cat':category_type,
            'type':tag_type,
            'selected_institutions': selected_institutions,
            'body_type': body_type,
            'location': selected_locations,
            'provider': selected_providers,
            'selected_category_type':selected_category_type
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
         setTimeout(function(){ $('#loaded_content').isotope( 'reLayout');}, 200); //prevent overlap
        
         isLoadingData=false;
         //reinitiate ratings plugin
    //     $('.kk-star-ratings').kkstarratings();
             $('#ajax-loader').remove();
             $('#ajax-loader').remove();

         return false;
     },
     error: function(errorThrown){
               alert('error');
               console.log(errorThrown);
          }
});  

    
}


function update_selected_options($){
 console.log(all_selections)
 
 $('#selected-options').empty().append(
         '<h4 style="padding:5px 0 0 5px; float:left;"><i style="margin-top:-15px;"class="fa fa-search"></i> &nbsp;Your Selected Options: </h4><div class="clear_both"></div>');
 
 $.each(all_selections, function(index, item){
    
    
    
    if(item!=""){

        var output= '<div class="filter-group">';

        output+='<span class="selected-index selected-filter">'+index+': </span>';

        $.each(item, function(index, tag){
            
           output+='<span class="selected-tag selected-filter">'+tag+'</span>';

        })
        output+='</div>';
        
        $('#selected-options').append(output);

    }
     //+": "+item+" | "
     
 })
     
     
   
 
 
}
/* 
 * @param {type} url
 * @returns {unresolved} 
 */
 
//function printResults($,data){
// console.log(data);
// 
// $("#blog-page").empty();
// $('#blog-page').append(data);
////  $.each(data['pagination'],function(){
////     
////  //    consoloe.log(this);
////      
////  });
//////////////////////OLD:
////$.each(data['posts'], function() {
//// //   console.log(this.ID);
////  
//// var course_type= getCourseType(this);
//// var body_name= getBodyName(this);
//// 
////    var content= this.post_content;        
////    content= jQuery.trim(content).substring(0, 310).split(" ").slice(0, -1).join(" ") + " [...]";
////    content= content.replace(/\n/g, "<br />");
////            content=  content.replace(/<img[^>]*>/g,"");
////
////    
////    var post= 
////        '<div id="'+this.post_id+'" class="'+this.post_id+' '+this.post_type+' type-'+this.post_type+' status-publish hentry">'
////        +'<h2 class="posttitle"><a href="'+this.guid+'" rel="bookmark" title="Permanent Link to '+this.post_title+'">'+this.post_title+'</a></h2>'
////        +'<div class="entry">'
////        +content+"</div></div>"
////        +"</a><br><p>"+course_type+" "+body_name+"</p><hr>";
////   
////  $("#blog-page").append(post);
////  $('.entry a').contents().unwrap(); //remove hyperlinks in descriptions
////
////});
// 
//}



/*
 * getPageName
 * @param: url
 * @returns: returns the filename
 */

function getPageName(url) {
    var index = url.lastIndexOf("/") + 1;
    var filenameWithExtension = url.substr(index);
    var filename = filenameWithExtension.split(".")[0]; // <-- added this line
    return filename;                                    // <-- added this line
}

/*
 * getCourseType
 * @param: data
 * @returns: course type
 */

function getCourseType(data){
    
     var course_type= "";
    if(data.key1['wpcf-fields-checkboxes-option-b7c3ac2ba41562b7ea3cfbcdd3587bf0-1'])
         course_type= 'Course Type: Paid';
    
        if(data.key1['wpcf-fields-checkboxes-option-60039c1cd5b3cf7f3d424671ae5ccc3a-2'])
         course_type= 'Course Type: Free';
     
     return course_type;
    
}

/*
 * getBodyType
 * @param: data
 * @returns: body/institution offering job/course
 */

function getBodyName(data){
    
     var body= "";
    if(data.key2.post_title)
         body= "| Institution: "+data.key2.post_title;
    
     return body;
    
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