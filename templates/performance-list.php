<?php 
	
	/* Template Name: Season Performances List */
	
	get_header();
	
	$layout = 'slats';
	$desc = true;
	
	include( locate_template( 'inc/performances.php' ) );
		
	get_footer(); 

?>

<!-- performance-list.php -->