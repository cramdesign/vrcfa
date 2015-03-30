<?php
/*
Plugin Name: Custom Styles
Plugin URI: http://www.speckygeek.com
Description: Add custom styles in your posts and pages content using TinyMCE WYSIWYG editor. The plugin adds a Styles dropdown menu in the visual post editor.
Based on TinyMCE Kit plug-in for WordPress

http://plugins.svn.wordpress.org/tinymce-advanced/branches/tinymce-kit/tinymce-kit.php

http://wp.tutsplus.com/tutorials/theme-development/adding-custom-styles-in-wordpress-tinymce-editor/

Learn TinyMCE style format options at http://www.tinymce.com/wiki.php/Configuration:formats

*/



// Add "Styles" drop-down
add_filter( 'mce_buttons_2', 'tuts_mce_editor_buttons' );

function tuts_mce_editor_buttons( $buttons ) {
	
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
    
}



// Add styles/classes to the "Styles" drop-down
add_filter( 'tiny_mce_before_init', 'tuts_mce_before_init' );

function tuts_mce_before_init( $settings ) {

    $style_formats = array(
	    
        array(
            'title' => 'Button',
            'selector' => 'a',
            'classes' => 'button'
        ),
            
        array(
            'title' => 'Intro',
            'selector' => 'p',
            'classes' => 'intro',
        ),
        
        array(
            'title' => 'Clear Floats',
            'selector' => 'h1,h2,h3,h4,h5,h6,p,blockquote,ul,ol',
            'classes' => 'clear',
        ),
        
/*
	    ,array(
            'title' => 'Entry Title',
            'selector' => 'h1,h2,h3,h4',
            'classes' => 'entry-title',
        )
        
        ,array(
            'title' => 'Red Uppercase Text',
            'inline' => 'span',
            'styles' => array(
                'color' => '#ff0000',
                'fontWeight' => 'bold',
                'textTransform' => 'uppercase'
            )
        )
*/
    );

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;

}