<?php
/* Load support files 
-------------------------------------------------------------- */
require_once( 'functions/pricing.php' );
require_once( 'functions/customizer.php' );
require_once( 'functions/editor-styles.php' );
require_once( 'functions/super-basic-events/sbe-events.php' );




/* Register widget areas
-------------------------------------------------------------- */
if ( !function_exists( 'custom_theme_widgets_init' ) ) : function custom_theme_widgets_init() {
	
	register_sidebar(array(
		'name'			=> 'Home Widgets 1',
		'id'			=> 'home_1',
		'description'	=> 'Home page. Left column.',
		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</div><!-- end widget -->',
		'before_title'	=> '<h3 class="title">',
		'after_title'	=> '</h3>'
	));
	
	register_sidebar(array(
		'name'			=> 'Home Widgets 2',
		'id'			=> 'home_2',
		'description'	=> 'Home page. Right column.',
		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</div><!-- end widget -->',
		'before_title'	=> '<h3 class="title">',
		'after_title'	=> '</h3>'
	));
	
	register_sidebar(array(
		'name'			=> 'Sidebar Widgets',
		'id'			=> 'sidebar',
		'description'	=> 'Pages that are posts overview.',
		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</div><!-- end widget -->',
		'before_title'	=> '<h3 class="title">',
		'after_title'	=> '</h3>'
	));

	register_sidebar(array(
		'name'			=> 'Footer Widgets 1',
		'id'			=> 'footer_1',
		'description'	=> 'All pages, footer. Left column.',
		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</div><!-- end widget -->',
		'before_title'	=> '<h3 class="title">',
		'after_title'	=> '</h3>'
	));
	
	register_sidebar(array(
		'name'			=> 'Footer Widgets 2',
		'id'			=> 'footer_2',
		'description'	=> 'All pages, footer. Right column.',
		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</div><!-- end widget -->',
		'before_title'	=> '<h3 class="title">',
		'after_title'	=> '</h3>'
	));
	
} endif;
add_action( 'widgets_init', 'custom_theme_widgets_init' );




/* Register javascript and stylesheets
-------------------------------------------------------------- */
if ( !function_exists( 'custom_theme_scripts' ) ) : function custom_theme_scripts() {


	// load comments stylesheet and javascript only if it is needed
	if ( is_singular() and ( comments_open() or 0 != get_comments_number() ) ) : 
		
		wp_enqueue_style ( 'comments', get_template_directory_uri() . '/css/comments.css' );
		if ( get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
			
	endif;


	// Styles
	wp_enqueue_style( 'norm', get_template_directory_uri() . '/css/norm.css' );
	wp_enqueue_style( 'base', get_template_directory_uri() . '/css/base.css' );
	wp_enqueue_style( 'menu', get_template_directory_uri() . '/css/menu.css' );
	wp_enqueue_style( 'html', get_template_directory_uri() . '/css/html.css' );
	wp_enqueue_style( 'main', get_template_directory_uri() . '/css/main.css' );


} endif;
add_action( 'wp_enqueue_scripts', 'custom_theme_scripts', 5 );




/*	Register login stylesheet
-------------------------------------------------------------- */
if ( !function_exists( 'login_scripts' ) ) : function login_scripts() {

	wp_enqueue_style( 'login-style', get_template_directory_uri() . '/css/login.css' );

} endif;
add_action( 'login_enqueue_scripts', 'login_scripts', 1 );




/* Register Theme Features 
-------------------------------------------------------------- */
if ( !function_exists( 'custom_theme_features' ) ) : function custom_theme_features()  {


	// sets max image width inserted into a post
	if ( ! isset( $content_width ) ) $content_width = 800;


	// Remove ugly inline css in gallery shortcode
	add_filter( 'use_default_gallery_style', '__return_false' );
	

	// Menus
	register_nav_menu( 'primary', 'Primary menu' );
	register_nav_menu( 'social', 'Social menu' );
	register_nav_menu( 'top', 'Top menu' );


	// Editor stylesheet
	add_editor_style ( 'css/html.css' );


	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'comment-form',
		'search-form',
		'comment-form',
		'gallery',
		'caption'
	) );
	
	
	// allow WordPress to control the title tag
	add_theme_support( 'title-tag' );


	// add support for featured images
	add_theme_support( 'post-thumbnails' ); 
	add_image_size( 'icon', 80, 80, true );


} endif;
add_action( 'after_setup_theme', 'custom_theme_features' );




?>