<?php
/*
	Plugin Name: supersimple shortcodes
	Author: cramdesign
	Author Email: matt@cramdesign.com

	Description: WordPress shortcodes that are super simple

	Version: 0.1.1

*/


function get_top_parent_page_id() {
 
    global $post;
 
    $ancestors = $post->ancestors;
 
    // Check if page is a child page (any level)
    if ($ancestors) {
 
        //  Grab the ID of top-level page from the tree
        return end($ancestors);
 
    } else {
 
        // Page is the top level, so use  it's own id
        return $post->ID;
 
    }
 
}



// List current page and any child pages in a menu
// [ss_list_pages]
function supersimple_list_subpagesOLD() { 

	global $post;
	$parent_page = get_top_parent_page_id($post->ID);
	
	if ( is_page() && $post->post_parent ) :
	
		// on a subpage
		$childpages  = wp_list_pages( 'sort_column=menu_order&title_li=&include=' . $post->post_parent . '&echo=0' );
		$childpages .= wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->post_parent . '&echo=0' );
		
	else :
	
		// on the parent page
		$childpages  = wp_list_pages( 'sort_column=menu_order&title_li=&include=' . $post->ID . '&echo=0' );
		$childpages .= wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0' );
		
	endif;
	
	if ( $childpages ) return '<ul class="page_menu">' . $childpages . '</ul>';
	
}



// List current page and any child pages in a menu
// [ss_list_pages]
function supersimple_list_subpages() { 

	global $post;
	$parent_page = get_top_parent_page_id($post->ID);
	
	if ( is_page() ) :
	
		$childpages  = wp_list_pages( 'sort_column=menu_order&title_li=&include=' . $parent_page . '&echo=0' );
		$childpages .= wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $parent_page . '&echo=0' );
		
	endif;
	
	if ( $childpages ) return '<ul class="page_menu">' . $childpages . '</ul>';
	
}

add_shortcode( 'ss_list_pages', 'supersimple_list_subpages' );



function supersimple_sectionmenu() {

	global $post; 
	
	if( $post->post_parent or count( get_pages( 'child_of=' . $post->ID ) ) ) :
	
		echo( '<aside class="sectionmenu"><h4>Section Menu</h4>' . supersimple_list_subpages() . '</aside>' );
	
	endif;

}