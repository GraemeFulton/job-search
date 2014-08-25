<?php
/**
 * Template Name: Front Page LG
 */
?>
<?php get_header(); ?>

        <?php                
        
        $content='[ajaxy-live-search show_category="1" show_post_category="1" post_types="graduate-job,course,work-experience-job,travel-opportunities,inspire-posts" label="Search for courses, jobs and travel opportunities" iwidth="447" delay="300" width="500" url="http://localhost/LGWP/?s=%s" border="1px solid #eee"]';
        echo do_shortcode($content);
        
        ?>
<div class="discover"><center><h1 style="margin-top:12px">Discover the Opportunities.</h1></center></div>
	<?php
        
        $post_types=array(
            array("course", "Learn", '#17ABFF'),
            array("work-experience-job", "Experience", '#E468E4'),
            array("graduate-job", "Work", '#FF8627'),
            array("travel-opportunities", "Travel", '#57BD57'),
            array("inspire-posts", "Inspire", '#EEBA38')
            );
        
        foreach($post_types as $post_type){
        echo'<div class="home-box-container hide-on-phones hide-on-tablet" style="border-top:3px solid '.$post_type[2].'">';
            echo get_title($post_type[0]);
        $myposts = get_posts(array(
            'showposts' => 3,
            'post_type' => $post_type[0],
            'orderby'=>'rand'
        ));
            foreach ($myposts as $mypost) {
                $img=get_the_image($mypost->ID);
                $link=get_permalink($mypost->ID);

                  echo '<a href="'.$link.'"><div class="home-page-box" style="border-bottom:2px solid '.$post_type[2].'"><img class="home-page-images" src="'.$img.'">';
                  echo '<p>'.$mypost->post_title . '</p></div></a>';

            }
                    
         echo'</div>';

        }
        
        
        function get_title($post_type){
            echo'<center><h3>';
            if($post_type=="course")echo 'Learn';
            elseif($post_type=="graduate-job")echo 'Work';
            elseif($post_type=="work-experience-job")echo 'Experience';
            elseif($post_type=="travel-opportunities")echo 'Travel';
            elseif($post_type=="inspire-posts")echo 'Inspire';
            
            echo'</h3></center>';

        }
        
?>
<?php get_footer(); ?>