<?php
$post_types= [];
if ($favorite_post_ids):
	$c = 0;
	$favorite_post_ids = array_reverse($favorite_post_ids);
     foreach ($favorite_post_ids as $post_id) {
    	//if ($c++ == $limit) break; //uncomment to impose the limit from the front-end
        
    	$p = get_post($post_id);
        $post_type=get_post_type( $post_id );
        
        if(!in_array_r($post_type, $post_types)){
        	        	
        	$spt=[$post_type];
        	array_push($post_types, $spt);        	 
        }
        	
        	$matchedArray = array_filter($post_types, function($x) use ($post_type) {
        		return $x[0] == $post_type;
        	});
        	foreach ($matchedArray as $key=>$value) {$index= $key;};
        	array_push($post_types[$index], $p);
        
    }
    else:
    echo "<li>";
    echo "Your favorites will be here.";
    echo "</li>";
    endif;
    echo '<div id="all-post-favourites">';
	//uasort($post_types, "compareElems");
        
    foreach ($post_types as $key => $value) {
    	if($value[0]){
    	//div container for each group
    	echo '<div class="post-favourite-group favourite-'.$value[0].'">';
    	//add pre-designated order (defined within the wpfp_get_order method)
    	echo '<p style="display:none;" class="order">'.wpfp_get_order($value[0]).'</p>';
    	//loop through each group's posts and print what desired attributes
    	foreach($value as $id=>$p){    
    		if(!$p->ID){
    			echo "<div class='post-favourite-group-title'><h4>".wpfp_get_post_title($value[0])."</h4></div><div class='hr-".$value[0]."'><hr></div>";
    		}		
			if($p->ID){
    		echo '<div class="profile-bookmark-item">';	
	    	//image
	    	$image=get_the_image($p->ID);
	    	echo '<div class="profile-bookmark-image-box">';
	    	echo "<a href='".get_permalink($p->ID)."' title='". $p->post_title ."'>";
	    	echo '<img class="profile-bookmark-image" src="'.$image.'"/></a><br>';
	    	echo "</div>";
	    	//link
	    	$title=wpfp_limit_post_title($p->post_title);
	    	echo "<a class='profile-bookmark-link' href='".get_permalink($p->ID)."' title='". $p->post_title ."'>" . $title . "</a> ";
	    	
	    	echo "</div>";
			}
			
    	}
    	echo "</div>";//post-favourite-group
    	 
    	}	
    }
    echo "</div>";//all-post-favourites

    ?>
    <div id="loaded_content"></div>  
   
    <script>
    
    $=jQuery;
    var $favepage= jQuery('#all-post-favourites');
    var $container = $('#loaded_content');

    $('#all-post-favourites').hide()
        // initialize isotope
        $container.isotope({
        	getSortData : {
        	    order : function ( $elem ) {
        	      return $elem.find('.order').text();
        	    }
        	  },
         // options...
          itemSelector: '.post-favourite-group',
          sortBy : 'order' 
        })
        .isotope('insert',$favepage.find('.post-favourite-group'));
 </script>

