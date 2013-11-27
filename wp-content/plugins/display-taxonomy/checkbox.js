jQuery(document).ready(function ($) {
  
    load_more_button_listener($);
   
    activate_listeners($);

    graylien_infinite_scroll($);         
});

/*
 * var url_string
 * 
 * Newly checked categories are appended to the url
 * Unchecked categories are removed from the url_string
 */
var selected_subjects =[]; //array to hold checked subjects
var selected_institutions=[]; //array to hold checked institutions
var meta_filter= "";

/*
 * load_more_button
 * @param {type} $
 * @returns {undefined}
 * listens for click of load more button, and loads more posts
 */
function load_more_button_listener($){
 $('#blog-more').click(function(event){
       event.preventDefault();
        var postoffset = $('.hentry').length;
        var category_type= $('#content').attr('category_type');
        var tag_type= $('#content').attr('tag_type');

 // console.log("offset: "+postoffset);

  ajaxLoadMore($,selected_subjects,postoffset, category_type, tag_type);
 });  
}


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
                     
            var postoffset = $('.hentry').length;
            var category_type= $('#content').attr('category_type');
            var tag_type= $('#content').attr('tag_type');
            var body_type= $('#content').attr('body_type');

      
            process_filter_scroll($,selected_subjects,postoffset, category_type, tag_type, selected_institutions,body_type);
            isLoadingData=true;

            closeActiveBox($);
            disableClickMe($);
            setTimeout(function(){isotopes_modal($);}, 500);


   }
});
    
}


/*
 * check_box_listener
 * @returns {undefined}
 * Listener for changes in checkboxes
 * Triggers checked() & unchecked() functions
 */
function activate_listeners($){
  
  //uncheck all boxes on page load
    $('#input:checkbox').prop('checked', false);

   subject_listener($);
   institution_listener($);
    
   location_search($);

    
}

/*
 *subject_listener 
 * @param {type} $
 * @returns {undefined}
 * listens for changes in the subject filter checkboxes
 */
function subject_listener($){
  $('#subject-filter input:checkbox').change(
    
    function()
    {
       if ($(this).is(':checked')) {
            apply_filter($,this, true, 'subject');
      
        }
        else{

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
       if ($(this).is(':checked')) {
            apply_filter($,this, true, 'institution');
      
        }
        else{

            apply_filter($,this, false, 'institution');
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
 */
function location_search($){
    
    //listen for if the box is empty
     $("#multi-append").on("change", function(){
       
       if($("#multi-append").val()==null){
           meta_filter="";
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
            meta_filter= meta_filter.split('|', 1)[0];    
        }
        else meta_filter="";//else meta_filter is blank

        apply_filter($,'#multi-append', true, '');

    })
    
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
    
    $("html, body").animate({ scrollTop: 0 }, 500);
    //filter for the url_string
    var category_type= $('#content').attr('category_type');
    var tag_type= $('#content').attr('tag_type');
    var body_type= $('#content').attr('body_type');
    //name for filtering
    var name = $(arg).attr('name');

    if (true_false===true)
    {
        if(filter_type==='subject'){
            selected_subjects.push(name);
        }
        if (filter_type==='institution'){
               selected_institutions.push(name);
        }
        
        //add filter value to process filter, and collect it in the php file, then use it to filter the post
         process_filter($,selected_subjects, category_type, tag_type, selected_institutions, body_type);
            
            closeActiveBox($);
            disableClickMe($);
            setTimeout(function(){isotopes_modal($);}, 500);
                
    }      
    else { 
        
        if(filter_type==='subject'){
        var index = selected_subjects.indexOf(name);
        selected_subjects.splice(index,1);
        }
         if(filter_type==='institution'){
        var index = selected_institutions.indexOf(name);
        selected_institutions.splice(index,1);
        }
           
           
           process_filter($,selected_subjects, category_type, tag_type, selected_institutions, body_type);           
           
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
function process_filter($, selected_subjects, category_type, tag_type, selected_institutions, body_type, filter_value){
    $.ajax({
     url: '/LGWP/wp-admin/admin-ajax.php', 
     type: "POST",
     data: {
            'action': 'check_box_filters',
            'fn':'process_filter',
            'selected_subjects':selected_subjects,
            'cat':category_type,
            'type':tag_type,
            'selected_institutions': selected_institutions,
            'body_type': body_type,
            'location': meta_filter
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
function process_filter_scroll($, selected_subjects, postoffset, category_type, tag_type, selected_institutions, body_type){
 
 if(isLoadingData==true) return;
 
    $.ajax({
     url: '/LGWP/wp-admin/admin-ajax.php', 
     type: "POST",
     data: {
            'action': 'check_box_filters',
            'fn':'process_filter',
            'selected_subjects':selected_subjects,
            'offset':postoffset,
            'cat':category_type,
            'type':tag_type,
            'selected_institutions': selected_institutions,
            'body_type': body_type,
            'location': meta_filter
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

         return false;
     },
     error: function(errorThrown){
               alert('error');
               console.log(errorThrown);
          }
});  

    
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