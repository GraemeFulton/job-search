jQuery(document).ready(function ($) {
  
    load_more_button_listener($);
   
    check_box_listener($);

    graylien_infinite_scroll($);
});

/*
 * var url_string
 * 
 * Newly checked categories are appended to the url
 * Unchecked categories are removed from the url_string
 */
var url_string=document.URL;
var selected_array =[];
var category_names_selected= "Selected: ";
var pageURL=getPageName(document.URL);

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

  ajaxLoadMore($,selected_array,postoffset, category_type, tag_type);
 });  
}


/*
 * graylien_infinite_scroll
 * @param {type} $
 * @returns {undefined}
 * triggers the call to load more when user scrolls to bottom
 */
function graylien_infinite_scroll($){
    
    $(window).scroll(function () {
   if ($(window).scrollTop() >= $(document).height() - $(window).height()) {
              
            var postoffset = $('.hentry').length;
            var category_type= $('#content').attr('category_type');
            var tag_type= $('#content').attr('tag_type');

      
            ajaxLoadMore($,selected_array,postoffset, category_type, tag_type);
        
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
function check_box_listener($){
  
  //uncheck all boxes on page load
    $('input:checkbox').prop('checked', false);

     $('input:checkbox').change(
    
    function()
    {
       if ($(this).is(':checked')) {
            checked($,this, true);
      
        }
        else{

            checked($,this, false);
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
function checked($,arg, true_false){
    $("html, body").animate({ scrollTop: 0 }, 500);
    //filter for the url_string
    var cat_id=$(arg).val();
    var filter= "&category="+cat_id;
    var category_type= $('#content').attr('category_type');
    var tag_type= $('#content').attr('tag_type');

    
    //name for breadcrumbs
    var name = $(arg).attr('name');
    if (category_names_selected.indexOf(name) >= 0){
       category_names_selected = category_names_selected.replace(name, "");
    }else{category_names_selected+=" <a href='"+pageURL+".php?category="+cat_id+"'><span class='crumb-checked'>"+name+"</span></a>";}

    
       
    if (true_false===true)
    {
            selected_array.push(name);
                ajaxLoad($,selected_array, category_type, tag_type);
                console.log(selected_array);
                
    }      
    else { 
        var index = selected_array.indexOf(name);
        selected_array.splice(index,1);
           ajaxLoad($,selected_array, category_type, tag_type);                
    }
        
}


/*
 *ajaxLoad 
 * @param {type} $
 * @param {type} tax
 * @returns {undefined}
 */
function ajaxLoad($, tax, category_type, tag_type){
    
    $.ajax({
     url: '/LGWP/wp-admin/admin-ajax.php', 
     type: "POST",
     data: {
            'action': 'check_box',
            'fn':'get_latest_posts',
            'tax':tax,
            'cat':category_type,
            'type':tag_type
           },
   dataType:'HTML', 
   success: function(data){
 
        //remove all boxes
        $(".hentry").remove(); 
       
       //destroy isotopes
       var $container = $('#blog-page');
        $container.isotope('destroy');

        // initialize isotope
        $container.isotope({
         masonry: {
                    columnWidth: 0
                  }
         });
               
         $('#blog-page').isotope( 'insert', $(data) );
         resetCurrentActiveBox($);
         
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
function ajaxLoadMore($, tax, postoffset, category_type, tag_type){
    $.ajax({
     url: '/LGWP/wp-admin/admin-ajax.php', 
     type: "POST",
     data: {
            'action': 'check_box',
            'fn':'get_latest_posts',
            'tax':tax,
            'offset':postoffset,
            'cat':category_type,
            'type':tag_type
           },
   dataType:'HTML', 
   
    success: function(data){
         
          var $container = $('#blog-page');
  
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
         $('#blog-page').isotope( 'insert', $(data) );
         setTimeout(function(){ $('#blog-page').isotope( 'reLayout');}, 200); //prevent overlap
        
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