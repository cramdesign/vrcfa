<?php
/*
	Plugin Name: supersimple shortcodes
	Author: cramdesign
	Author Email: matt@cramdesign.com

	Description: WordPress shortcodes that are super simple

	Version: 0.1

*/


// List current page and any child pages in a menu
// [ss_list_pages]
function supersimple_list_subpages() { 

	global $post; 
	
	if ( is_page() && $post->post_parent ) :
	
		// on a subpage
		$childpages  = wp_list_pages( 'sort_column=menu_order&title_li=&include=' . $post->post_parent . '&echo=0' );
		$childpages .= wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->post_parent . '&echo=0' );
		
	else :
	
		// on the parent page
		$childpages  = wp_list_pages( 'sort_column=menu_order&title_li=&include=' . $post->ID . '&echo=0' );
		$childpages .= wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0' );
		
	endif;
	
	if ( $childpages ) return '<ul class="menu">' . $childpages . '</ul>';
	
}

add_shortcode( 'ss_list_pages', 'supersimple_list_subpages' );



function supersimple_sectionmenu() {

	if( $post->post_parent or count( get_pages( 'child_of=' . $post->ID ) ) ) :
	
		echo( '<aside class="sectionmenu"><h4>Section Menu</h4>' . supersimple_list_subpages() . '</aside>' );
	
	endif;

}