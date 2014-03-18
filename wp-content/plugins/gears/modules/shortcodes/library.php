<?php
/**
 * Gears shortcode collection
 * 
 * @version 1.0
 * @since 2.0
 */
 
class Gears_Shortcodes{

	var $bp_not_installed = 'Sorry, buddypress must be enabled for this shortcode to work properly.';
	
	function __construct(){
	
		// if visual composer is present integrate our modules to it
		if( function_exists( 'vc_map' ) ){
			$this->vc_integration();
		}
		// groups carousel
		add_shortcode( 'gears_bp_groups_carousel', array( $this, 'bp_groups_carousel' ) );
		// groups grid
		add_shortcode( 'gears_bp_groups_grid', array( $this, 'bp_groups_grid' ) );
		// groups list
		add_shortcode( 'gears_bp_groups_list', array( $this, 'bp_groups_list' ) );
		// members carousel
		add_shortcode( 'gears_bp_members_carousel', array( $this, 'bp_members_carousel' ) );
		// members grid
		add_shortcode( 'gears_bp_members_grid', array( $this, 'bp_members_grid' ) );
		// members list
		add_shortcode( 'gears_bp_members_list', array( $this, 'bp_members_list' ) );
		// activity streams
		add_shortcode( 'gears_bp_activity_stream', array( $this, 'gears_activity_stream' ));
		// pricing table
		add_shortcode( 'gears_pricing_table', array( $this, 'gears_pricing_table' ));
	}
	
	/**
	 * shows members list 
	 */
	 
	function bp_members_carousel( $atts ) {
		
		$output = '';
		
		extract( 
			shortcode_atts( array(
				'type' => '',
				'max_item' => 10,
				'max_slides' => 7,
				'min_slides' => 1,
				'item_width' => 175
			), $atts ) 
		);
			
		$params = array(
			'type' => $type,
			'per_page' => $max_item
		);
		
		if( class_exists( 'buddypress' ) ){
			// begin bp members loop
			if ( bp_has_members( $params ) ){
			
				$output .= '<div class="clearfix">';
					$output .= '<ul data-max-slides="'.$max_slides.'" data-min-slides="'.$min_slides.'" data-item-width="'.$item_width.'" class="gears-carousel-standard bp-members-carousel">';
						while( bp_members() ){
							$output .= '<li class="carousel-item">';
								bp_the_member();
								$output .= '<a data-toggle="tooltip" href="'. bp_get_member_permalink() .'" title="'. bp_get_member_name() .'">';
										$output .= bp_get_member_avatar( array(	'type' => 'full' ));
								$output .= '</a>';	
							$output .= '</li>';
						}
					$output .= '</ul>';	
				$output .= '</div>';
				
				return $output;
			}
			
		}else{
			return $this->bp_not_installed;
		}
	}
	
	/**
	 * BP Members Grid
	 */
	function bp_members_grid( $atts ) {
		
		$output = '';
		
		extract( 
			shortcode_atts( array(
				'type' => '',
				'max_item' => 10,
				'size' => 2 // Maximum 12 
			), $atts )
		);
		
		// available columns are 1, 2, 3, and 4
			
		$params = array(
			'type' => $type,
			'per_page' => $max_item
		);
		
		if( class_exists( 'buddypress' ) ){
			// begin bp members loop
			if ( bp_has_members( $params ) ){
				$output .= '<div class="clearfix">';
					$output .= '<ul class="bp-members-grid">';
						while( bp_members() ){
							$output .= '<li class="bp-members-grid-item col-md-'.$size.' col-sm-'.$size.'">';
								bp_the_member();
								$output .= '<a href="'. bp_get_member_permalink() .'" title="'. bp_get_member_name() .'">';
										$output .= bp_get_member_avatar( array(	'type' => 'full', 'class' => 'trans avatar' ));
								$output .= '</a>';	
							$output .= '</li>';
						}
					$output .= '</ul>';	
				$output .= '</div>';
				return $output;
			}
			
		}else{
			return $this->bp_not_installed;
		}
	}
	
	/**
	 * BP Members List
	 */
	
	function bp_members_list( $atts ){
		$output = '';
		
		extract( 
			shortcode_atts( array(
				'type' => 'active',
				'max_item' => 10
			), $atts )
		);
		
		// available columns are 1, 2, 3, and 4
			
		$params = array(
			'type' => $type,
			'per_page' => $max_item
		);
		
		if( class_exists( 'buddypress' ) ){
			// begin bp members loop
			if ( bp_has_members( $params ) ){
				$output .= '<div class="clearfix">';
					$output .= '<ul class="bp-members-list clearfix">';
						while( bp_members() ){
							$output .= '<li class="clearfix bp-members-list-item ">';
								bp_the_member();
								
									$output .= bp_get_member_avatar( array(	'type' => 'full', 'class' => 'col-md-3 col-sm-3 trans avatar' ));
									
									$output .= '<div class="col-md-9 col-sm-9">';
										$output .= '<h5><a href="'.bp_get_member_permalink().'" title="'.bp_get_member_name().'">'. bp_get_member_name() .'</a></h5>';
										$output .= '<div class="item-meta"><span class="activity">' . bp_get_member_last_active() . '</span></div>';
												do_action( 'bp_directory_members_item' );
									$output .= '</div>';
							$output .= '</li>';
						}
					$output .= '</ul>';	
				$output .= '</div>';
					
					return $output;
				}
				
			}else{
				return $this->bp_not_installed;
			}
	}
	
	/**
	 * BP Groups Carousel
	 */
	
	function bp_groups_carousel( $atts ){
	
		extract( 
			shortcode_atts( array(
				'type' => 'active',
				'max_item' => 10,
				'max_slides' => 7,
				'min_slides' => 1,
				'item_width' => 100
			), $atts ) 
		);
			
		$params = array(
			'type' => $type,
			'per_page' => $max_item
		);
		
		$output = '';
		if( class_exists( 'buddypress' ) ){
			if( bp_has_groups( $params ) ){
				$output .= '<div class="clearfix">';
					$output .= '<ul data-max-slides="'.$max_slides.'" data-min-slides="'.$min_slides.'" data-item-width="'.$item_width.'" class="gears-carousel-standard bp-groups-carousel">';
						while ( bp_groups() ){
							bp_the_group(); 
							$output .= '<li class="carousel-item center">';
								$output .= '<a href="'. bp_get_group_permalink() .'" title="'. esc_attr( bp_get_group_name() ) .'">';
										$output .= bp_get_group_avatar( array(	'type' => 'full' ));
								$output .= '</a>';
							$output .= '</li>';
						}
					$output .= '</ul>';
				$output .= '</div>';	
			}else{
				$output .= '<div class="alert alert-info">' . __( 'There are no groups to display. Please try again soon.', 'gears' ) . '</div>';
			}
			return $output;
		}else{
			return $this->bp_not_installed;
		}
	}
	
	/**
	 * BP Groups Grid
	 */
	
	function bp_groups_grid( $atts ){
	
		extract( 
			shortcode_atts( array(
				'type' => 'active',
				'max_item' => 10,
				'size' => '2'
			), $atts ) 
		);
		
		//ensure that size doesnt go crazy
			if( $size >= 12 ){	$size = 2;	}
			
		$params = array(
			'type' => $type,
			'per_page' => $max_item
		);
		
		$output = '';
		if( class_exists( 'buddypress' ) ){
			if( bp_has_groups( $params ) ){
				$output .= '<div class="clearfix">';
					$output .= '<ul class="bp-groups-grid">';
						while ( bp_groups() ){
							bp_the_group(); 
							$output .= '<li class="bp-groups-grid-item col-md-'. trim( abs( $size ) ) .' col-sm-'. trim( abs( $size ) ) .'">';
								$output .= '<a href="'. bp_get_group_permalink() .'" title="'. esc_attr( bp_get_group_name() ) .'">';
										$output .= bp_get_group_avatar( array(	'type' => 'full' ));
								$output .= '</a>';
							$output .= '</li>';
						}
					$output .= '</ul>';
				$output .= '</div>';	
			}else{
				$output .= '<div class="alert alert-info">' . __( 'There are no groups to display. Please try again soon.', 'gears' ) . '</div>';
			}
			return $output;
		}else{
			return $this->bp_not_installed;
		}
	}
	
	/**
	 * BP Groups List
	 */
	
	function bp_groups_list( $atts ){
	
		extract( 
			shortcode_atts( array(
				'type' => 'active',
				'max_item' => 10,
			), $atts ) 
		);
			
		$params = array(
			'type' => $type,
			'per_page' => $max_item
		);
		
		$output = '';
		if( class_exists( 'buddypress' ) ){
			if( bp_has_groups( $params ) ){
				$output .= '<div class="clearfix">';
					$output .= '<ul class="bp-groups-list">';
						while ( bp_groups() ){
							bp_the_group(); 
							$output .= '<li class="clearfix bp-groups-list-item">';
								$output .= bp_get_group_avatar( array(	'type' => 'full', 'class' => 'avatar col-sm-3 col-lg-3 col-md-3' ));
								$output .= '<div class="col-md-9 col-sm-9 col-lg-9">';
									$output .= '<h5><a href="'.esc_attr( bp_get_group_permalink() ).'" title="'.esc_attr( bp_get_group_name() ).'">'.esc_attr( bp_get_group_name() ).'</a></h5>';
								
										$output .= '<div class="meta"><span class="activity">';
											$output .= bp_get_group_type() .'/'.  bp_get_group_member_count();
										$output .= '</span></div>';
								$output .= '</div>';
							$output .= '</li>';
						}
					$output .= '</ul>';
				$output .= '</div>';	
			}else{
				$output .= '<div class="alert alert-info">' . __( 'There are no groups to display. Please try again soon.', 'gears' ) . '</div>';
			}
			return $output;
		}else{
			return $this->bp_not_installed;
		}
	}
	
	/**
	 * Shows activity stream
	 */
	function gears_activity_stream( $atts ){
		
		extract(
			shortcode_atts(
				array(
					'activity_button_link' => '',
					'activity_button_label' => '',
					'max' => 5,
					'show' => false
				), $atts
			)
		);
		
		if( class_exists( 'buddypress' ) ){
			
			$output = '';
			$params = array(
				'max' => $max,
				'object' => $show
			);
			
			$output .= '<div class="clearfix">';
				$output .= '<div class="activity gears-module clearfix">';
					
					if ( bp_has_activities( $params ) ){
						$output .= '<ul id="activity-stream" class="activity-list item-list">';
							while ( bp_activities() ) : bp_the_activity();
								$output .= $this->gears_get_activity_stream();
							endwhile;
						$output .= '</ul>';
					}else{
						$output .= '<div class="alert alert-info">'. __( 'No activity to show at this time', 'gears' ) .'</div>';
					}
					
					if( !empty($activity_button_label) ){
						$output .= '<a href="'.$activity_button_link.'" title="" class="pull-right btn btn-large btn-primary">'.__( $activity_button_label ).'</a>';
					}
					
				$output .= '</div>';
			$output .= '</div>';
			return $output;
		}else{
			return $this->bp_not_installed;
		}
	}
		function gears_get_activity_stream(){
		
			$output = '';
				$output .= '<li class="'. bp_get_activity_css_class() .'" id="activity-'. bp_get_activity_id() .'">';
					$output .= '<div class="activity-avatar">';
						$output .= '<a class="gears-activity-avatar" title="'.__( 'View Profile','gears' ).'" href="'. bp_get_activity_user_link() .'">';
							$output .=  bp_get_activity_avatar();
						$output .= '</a>';
					$output .= '</div>';
					// activity content
					$output .= '<div class="activity-content">';
						$output .= '<div class="activity-header">';
							$output .= bp_get_activity_action();
						$output .= '</div>';
						
						$output .= '<div class="activity-inner">';
							if( bp_activity_has_content() ){
								$output .= bp_get_activity_content_body();
							} 
						$output .= '</div>';
						
						do_action( 'bp_activity_entry_content' );
						
						$output .= '<div class="activity-meta">';
							if ( bp_get_activity_type() == 'activity_comment' ){
								$output .= '<a href="'.bp_get_activity_thread_permalink(). '" class="view bp-secondary-action" title="'.__( 'View Conversation', 'gears' ). '">'.__( 'View Conversation', 'gears' ).'</a>';
							} 
				
							if ( is_user_logged_in() ){ 
				
								if ( bp_activity_can_favorite() ){
									if ( !bp_get_activity_is_favorite() ){
										$output .= '<a href="'.bp_get_activity_favorite_link().'" class="fav bp-secondary-action" title="'.esc_attr( __('Mark as Favorite', 'gears') ).'">'.__( 'Favorite', 'gears' ).'</a>';
									}else{
										$output .= '<a href="'.bp_get_activity_unfavorite_link().'" class="unfav bp-secondary-action" title="'.esc_attr( __('Remove Favorite', 'gears') ).'">'.__( 'Remove Favorite', 'gears' ).'</a>';
									}
								} 
				
								if ( bp_activity_user_can_delete() ){ 
									$output .= bp_get_activity_delete_link(); 
								} 
								do_action( 'bp_activity_entry_meta' ); 
				
							} 
						$output .= '</div>';
						
						if ( bp_get_activity_type() == 'activity_comment' ){
							$output .= '<a href="'. bp_get_activity_thread_permalink() . '" class="view bp-secondary-action" title="'. __( 'View Conversation', 'gears' ) .'">'. __( 'View Conversation', 'gears' );
						} // end bp_get_activity_type()
						
					$output .= '</div>';
					// end activity content
				$output .= '</li>';
			
			return $output;
			
		}
	
	/**
	 * gears pricing table
	 *
	 *	Title
	 *	Price Label
	 *	Features/Services Offered (separated by comma).
		Append '[x]' in the feature list to suggest a feature which is not available.
		Otherwise, append '[/]' in the feature list to suggest that the feature is
		available.
	 *	Button Label
	 *	Button Link
	 *	Color Scheme
	 *
	 */
	 
	function gears_pricing_table( $atts ){
		 
		extract( 
			shortcode_atts( array(
				'title' => '',
				'price_label' => '$0.00',
				'features' => '',
				'button_label' => 'Purchase',
				'button_link' => '#',
				'popular' => 'false',
				'color' => 'alizarin'
			), $atts ) 
		);
		
		if( !empty( $features ) ){
			$features = explode( ',', $features );
		}else{
			$features = array();
		}
		
		$output = '';
		
		if( 'true' == $popular ){
			$title .= ' <span class="glyphicon glyphicon-star"></span>';
		}
		$output .= '<div class="clearfix">';
			$output .= '<div class="gears-pricing-table">';
				$output .= '<div class="gears-pricing-table-title"><h2>'.$title.'</h2></div>';
				$output .= '<div class="gears-pricing-table-price-label"><h3>'.$price_label.'</h3></div>';
				$output .= '<div class="gears-pricing-table-features">';
					if( !empty( $features ) ){
						foreach( (array) $features as $feature){
							$feature = trim( $feature );
							
							if( '!' == substr( $feature, 0, 1 ) ){
								$output .= '<li class="gears-pricing-table-features-list"><span class="glyphicon glyphicon-remove"></span> '.substr( $feature, 1 ).'</li>';
							}else{
								$output .= '<li class="gears-pricing-table-features-list"><span class="glyphicon glyphicon-ok"></span> '.$feature.'</li>';
							}	
						}
					}
				$output .= '</div>';
				$output .= '<div class="gears-pricing-table-btn">';
					$output .= '<a href="'.$button_link.'" class="btn btn-primary">'.$button_label.'</a>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
	
	/**
	 * Integrates our shortcode into Visual Composer Screen
	 * 
	 * @since 1.0
	 */
	 function vc_integration(){
	 
		require_once GEARS_APP_PATH . '/modules/shortcodes/vc.php';
		
		$vc_modules = new Gears_Visual_Composer();
		// members carousel
		$vc_modules->load( 'gears_bp_members_carousel' );
		// members grid
		$vc_modules->load( 'gears_bp_members_grid' );
		// members list
		$vc_modules->load( 'gears_bp_members_list' );
		// groups carousel
		$vc_modules->load( 'gears_bp_groups_carousel' );
		// groups grid
		$vc_modules->load( 'gears_bp_groups_grid' );
		// groups list
		$vc_modules->load( 'gears_bp_groups_list' );
		// pricing table
		$vc_modules->load( 'gears_pricing_table' );
		// activity stream
		$vc_modules->load( 'gears_bp_activity_stream' );
	 }
} 

