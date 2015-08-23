/**
 * klein.js
 *
 * Handles effects, tooltips, toggles, tabs, and other things the theme uses
 * if you have small custom requirements that you need javascript to achieve
 * it might be the best thing to put it here.
 (
 */
( function($) {
	
	"use strict";
	
	/**
	 * Navigation
	 */
	 
	$(".nav-btn").click( function(){
		var dropdown = $(this).attr( 'data-dropdown' );
			$(dropdown).slideToggle();
	});
	
	$(".menu.mobile ul.children").prev('a').append("&nbsp; <i class='icon-angle-down'></i>");
	
	/**
	 * Sliding Banner 
	 */
	 
	$('.labeled-box').click( function(e){
	
		var $selector = $( '.line-heading-content', $(this).parent() );
		var $entrance = $selector.attr( 'data-entrance' );
		
		$( $selector ).toggle( 'bounce' );
	});
	
	/**
	 * Tooltips
	 */
	$('.tip').tooltip();
} )(jQuery);
