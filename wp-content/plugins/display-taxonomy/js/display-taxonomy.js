jQuery(document).ready(function ($) {
    
    activate_listeners($);

    graylien_infinite_scroll($);     
    
   // if(jQuery('.we-menu.active').length){jQuery('.job-menu.current-menu-parent').removeClass(".job-menu.current-menu-ancestor").addClass('we-menu we-menu.current-menu-ancestor')}
    
  //$("#tree").fancytree("option", "checkbox", true);
//load_more_button_listener($);
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

var order_by=[];
var sort_a_z=[];
/*
 * graylien_infinite_scroll
 * @param {type} $
 * @returns {undefined}
 * triggers the call to load more when user scrolls to bottom
 */
var isLoadingData;
function graylien_infinite_scroll($){
  //   load_more_button_listener($);
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

            //resetCurrentActiveBox($);
            setTimeout(function(){isotopes_modal($);}, 500);


   }
});

    
}


/*
 * load_more_button
 * @param {type} $
 * @returns {undefined}
 * listens for click of load more button, and loads more posts
 */
function load_more_button_listener($){
 $('#blog-more').click(function(event){
     $('#blog-more').hide();
       event.preventDefault();
        var postoffset = $('.hentry').length;
        var category_type= $('#content').attr('category_type');
        var tag_type= $('#content').attr('tag_type');
        var body_type= $('#content').attr('body_type');

 // console.log("offset: "+postoffset);

  process_filter_scroll($,postoffset, category_type, tag_type, body_type);
              isLoadingData=true;
            setTimeout(function(){isotopes_modal($);}, 500);
             setTimeout(function(){$('#blog-more').fadeIn(2000);}, 1200);
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
 * apply_cat_filter
 * same as above, but for category, not taxnomy
 * @param {type} $
 * @param {type} category_type
 * @param {type} tag_type
 * @param {type} body_type
 * @returns {undefined}
 */
function apply_cat_filter($){
    
  //  $("html, body").animate({ scrollTop: 0 }, 500);
    //filter for the url_string
        
        //add filter value to process filter, and collect it in the php file, then use it to filter the post
         process_cat_filter($);
            
            closeActiveBox($);
            disableClickMe($);
            setTimeout(function(){isotopes_modal($);}, 500);
   
}

/*
 *process_cat_filter 
 * @param {type} $
 * @param {type} tax
 * @returns {undefined}
 * ajax filter for subject box
 */
function process_cat_filter($){
    
    //	resetCurrentActiveBox($);
    update_selected_options($);
     $('.sorry-message').remove();

    //loading gif
    $('.hentry').empty();
    $('#content').prepend('<img id="ajax-loader-check-box" style="margin:10px 0 0 10px;"src="'+templateUrl+'/ajax-loader.gif"/>');

    $.ajax({
     url: '/LGWP/wp-admin/admin-ajax.php', 
     type: "POST",
     data: {
             'action': 'check_box_filter',
            'fn':'select',
            'selected_subjects':selected_subjects,
            'cat':'post',
            'type':'category',
            'selected_institutions':all_selections.Tags[0],//tag search for posts
            'body_type': '',
            'location': selected_locations,
            'provider':all_selections.Author[0],//author search for posts
            'selected_category_type':selected_category_type,
             'search_filter':all_selections.Search[0],
             'order_by':order_by,
             'sort_a_z':sort_a_z,
             'tax_or_cat':'cat'
           },
   dataType:'HTML', 
   success: function(data){
        //remove all boxes
        $(".hentry").remove(); 

        var parsedData = JSON.parse(data);
       //destroy isotopes
       var $container = $('#loaded_content');
        $container.isotope('destroy');

        // initialize isotope
        $container.isotope({
         masonry: {
                    columnWidth: 0
                  }
         });
               
         $('#loaded_content').isotope( 'insert', $(parsedData[0]) );
         
         setTimeout(function(){insert_images($, parsedData);}, 750);

         
         resetCurrentActiveBox($);
         //reinitiate ratings plugin
         reset_filter_listener($);

         $('#ajax-loader-check-box').remove();
        
          return false;
     },
             
     error: function(errorThrown){
               alert('error');
               console.log(errorThrown);
          }
});  
}

/*
 *process_subject 
 * @param {type} $
 * @param {type} tax
 * @returns {undefined}
 * ajax filter for subject box
 */
function process_filter($, category_type, tag_type, body_type){

//	resetCurrentActiveBox($);
    update_selected_options($);
     $('.sorry-message').remove();

    //loading gif
    $('.hentry').children().fadeOut(250, function() {
});
    $('#content').prepend('<img id="ajax-loader-check-box" style="margin:10px 0 0 10px;"src="'+templateUrl+'/ajax-loader.gif"/>');

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
             'search_filter':all_selections.Search[0],
             'order_by':order_by,
             'sort_a_z':sort_a_z,
             'tax_or_cat':'tax'
           },
   dataType:'HTML', 
   success: function(data){
        //remove all boxes
        $(".hentry").remove(); 
       var parsedData = JSON.parse(data);
       
       //destroy isotopes
            var $container = $('#loaded_content');
           $container.isotope('destroy');

        $container.isotope({
             // options...
             itemSelector: '.hentry',
            masonry: {
                columnWidth: 0
             }
         });
        $container.isotope( 'insert', ( $(parsedData[0])) )

              setTimeout(function(){insert_images($, parsedData);}, 750);

               setTimeout(function(){
                     $('#selected-options-container').removeClass('normalHighlight').addClass('animateHighlight');
            setTimeout(function(){
                  $('#selected-options-container').removeClass('animateHighlight').addClass('normalHighlight');
            }, 3200)  
                   
               }, 1200)


        resetCurrentActiveBox($);
        //reinitiate ratings plugin
        reset_filter_listener($);

        $('#ajax-loader-check-box').remove();
       
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
	//resetCurrentActiveBox($);

 if(isLoadingData===true) return;
     //loading gif
     $('.sorry-message').remove();
    $('#content').append('<img id="ajax-loader-scroll" src="'+templateUrl+'/ajax-loader.gif"/>');
    
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
            'search_filter':all_selections.Search[0],
            'order_by':order_by,
            'sort_a_z':sort_a_z,
            'tax_or_cat':'tax'

           },
   dataType:'HTML', 
   
    success: function(data){
       
       var parsedData = JSON.parse(data);
      // console.log(parsedData[0])
       
   var $container = $('#loaded_content');
    
    $container.isotope( 'insert', $(parsedData[0]) );
        // trigger isotope again after images have been loaded
      setTimeout(function(){insert_images($, parsedData);}, 1100);
            
     isLoadingData=false;
         
     $('#ajax-loader-scroll').remove();
    //rebind infinitescroll
     resetCurrentActiveBox($);

    graylien_infinite_scroll($);
    reset_filter_listener($);

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
        $('#content').prepend('<img id="ajax-loader-popup" style="margin:10px 0 0 10px;"src="'+templateUrl+'/ajax-loader.gif"/>');

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
        closeBoxHandler($, post_id);
        $('#ajax-loader-popup').fadeOut();
        return false;
     },
     error: function(errorThrown){
               alert('error');
               console.log(errorThrown);
          }
});  

    
}


function update_selected_options($){
 
 var selected_option_head= '<h4 class="options-title"><i style="margin-top:-15px;"class="fa fa-search"></i> &nbsp;Selected: </h4>';
     selected_option_head+='<div class="clear_both"></div><div id="nothing_selected">Nothing Selected. Please use the filters available on the left to find what you want.</div>';
    
    
    $('#selected-options-container').empty().append(selected_option_head);
    
 $.each(all_selections, function(index, item){
        
    if(item!=""){
        $("#nothing_selected").remove();
        var output= '<div class="filter-group">';

        //if it's a search item:
      if(index=='Search'){
        output+='<span class="selected-index selected-filter selected-search-index">'+index+': </span><div class="clear_both"></div>';

        $.each(item, function(index,tag){
            output+='<span class="selected-tag selected-search">'+tag+'<i class="fa fa-times close_tag"></i></span><div class="clear_both"></div>';

            
        });
        
        }
             //if it's a search item:
      else if(index=='Tags'){
        output+='<span class="selected-index selected-filter selected-tag-index">'+index+': </span><div class="clear_both"></div>';

        $.each(item, function(index,tag){
            output+='<span class="selected-tag selected_tags">'+tag+'<i class="fa fa-times close_tag"></i></span><div class="clear_both"></div>';

            
        });
        
        }
                //if it's an Author item:
      else if(index=='Author'){
        output+='<span class="selected-index selected-filter selected-author-index">'+index+': </span><div class="clear_both"></div>';

        $.each(item, function(index,tag){
            output+='<span class="selected-tag selected-author">'+tag+'<i class="fa fa-times close_tag"></i></span><div class="clear_both"></div>';

            
        });
        
        }
        else
        {
            //otherwise:
            
            output+='<span class="selected-index selected-filter">'+index+': </span><div class="clear_both"></div>';

            $.each(item, function(index, tag){
               output+='<span class="selected-tag selected-filter">'+tag+'<i class="fa fa-times close_tag"></i></span><div class="clear_both"></div>';

            })
        }
            output+='</div>';

            $('#selected-options-container').append(output).addClass("selected-options-active");

            $('.selected-index').hide().fadeIn(500);
            $('.selected-tag').hide().fadeIn(500);
            
          
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


function insert_images($, data){
    
    var $posts=data[1]['posts'];
    var $container = $('#loaded_content');

   
    $.each($posts, function() {
      
      var $matchingElem=$(".post_image_"+this.ID);
      //there will always be a match      
      if($matchingElem.length){
                
         $matchingElem.children('.advert_image').attr('src',this.image )
         
         .imagesLoaded( function() {  
     
             $container.isotope('reLayout');

          }).progress( function( instance, image ) {
              
                var $item = $( image.img ).parent();
                
                if ( !image.isLoaded ) {
                    $item.addClass('is-broken');
                }else{
                  $item.removeClass('is-loading');
                }
           });
                
       }
       
       else{console.log("no match")}

    });

    setTimeout(function(){
      $container.imagesLoaded(function(){
  $container.isotope('reLayout');

});
      
    },300)


}

/*
* animatie highlight
* 
* http://stackoverflow.com/questions/275931/how-do-you-make-an-element-flash-in-jquery
* Usage example:

$("div").animateHighlight("#dd0000", 1000);
* 
 */
 
function animateHighlight(div,highlightColor, duration) {
    var highlightBg = highlightColor || "#222";
    var animateMs = duration || 1500;
    var originalBg = div.css("backgroundColor");
    alert(originalBg)
    div.addClass('highlight');
   
};