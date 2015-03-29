<?php
/* Load support files 
-------------------------------------------------------------- */
require_once( 'metabox_framework.php' );



/* meta box settings
-------------------------------------------------------------- */
function add_custom_meta_boxes() {

	/* featured image metabox
	-------------------------------------------------------------- */
	$meta_box_featured_images = array(
		'id'		=> 'featured_image_meta_box', // Meta box ID
		'title'		=> 'Featured Image Options', // Meta box title
		'pages'		=> array( 'post', 'page' ), // Post types this meta box should be shown on
		'context'	=> 'side', // Meta box context
		'priority'	=> 'low', // Meta box priority
		'fields'	=> array(

			array(
				'type'	=> 'checkbox',
				'desc'	=> 'Hide featured image on full post.',
				'id'	=> 'hide_featured_image',
				'std'	=> 0
			),
			
			array(
				'type'	=> 'checkbox',
				'desc'	=> 'Display featured image as a banner.',
				'id'	=> 'banner_featured_image',
				'std'	=> 0
			),
			
		)
	);
	dev7_add_meta_box( $meta_box_featured_images );

	/* home template metabox
	-------------------------------------------------------------- */
	
	$cats = get_categories( 'post' );
	foreach( $cats as $cat ) {
		$cat_titles[$cat->cat_ID] = $cat->name;
	}
	
	$pages = get_pages( 'page' );
	foreach( $pages as $page ) {
		$page_titles[$page->ID] = $page->post_title;
	}
	
	$meta_box_home_template = array(
		'id'		=> 'home_template_meta_box', // Meta box ID
		'title'		=> 'Home Template Options', // Meta box title
		'pages'		=> 'page', // Post types this meta box should be shown on
		'template'	=> 'home.php', // Template filename
		'context'	=> 'normal', // Meta box context
		'priority'	=> 'low', // Meta box priority
		'fields'	=> array(

			/* -------------------------------------------------------------- */
			
			array(
                'label' => 'Feature Image',
				'desc'	=> 'Use the featured image meta box.',
				'type'	=> 'message',
                'hr'	=> true
			),
			
            array(
                'label' => 'Feature Title',
                'id'    => 'feature_title',
                'type'  => 'text',
                'std'   => 'This is std'
            ),
            
            array(
                'label' => 'Feature Description',
                'id'    => 'feature_description',
                'type'  => 'textarea',
                'std'   => 'This is std'
            ),
			
            array(
                'label' => 'Feature Page Link',
                'id'    => 'feature_page_link',
                'type'  => 'select',
                'args'  => $page_titles
            ),
            
			/* -------------------------------------------------------------- */

            array(
                'label' => 'Big Quote',
                'id'    => 'big_quote',
                'type'  => 'textarea',
                'std'   => 'This is std',
                'hr'	=> true
            ),
			
			/* -------------------------------------------------------------- */

			array(
                'label' => 'Category for Updates',
                'id'    => 'home_updates_category',
                'type'  => 'select',
                'args'  => $cat_titles,
                'hr'	=> true
			),
			
			/* -------------------------------------------------------------- */

			array(
                'label' => 'Locations sidebar',
				'desc'	=> 'Use the primary content area located under the page title for the locations sidebar.',
				'type'	=> 'message',
                'hr'	=> true
			),
			
			/* -------------------------------------------------------------- */

            array(
                'label' => 'Blogs Intro Title',
                'id'    => 'blog_intro_title',
                'type'  => 'text',
                'hr'	=> true
            ),
            
            array(
                'label' => 'Blogs Intro Description',
                'id'    => 'blog_intro_description',
                'type'  => 'textarea',
            ),
			
			/* -------------------------------------------------------------- */

            array(
                'label' => 'Blogs 1 Title',
                'id'    => 'blog_1_title',
                'type'  => 'text',
                'hr'	=> true
            ),
            
            array(
                'label' => 'Blogs 1 Description',
                'id'    => 'blog_1_description',
                'type'  => 'text',
            ),
			
            array(
                'label' => 'Blog 1 Category Link',
                'id'    => 'blog_1_category',
                'type'  => 'select',
                'args'  => $cat_titles
            ),
            
			/* -------------------------------------------------------------- */

           array(
                'label' => 'Blogs 1 Title',
                'id'    => 'blog_2_title',
                'type'  => 'text',
                'hr'	=> true
            ),
            
            array(
                'label' => 'Blogs 1 Description',
                'id'    => 'blog_2_description',
                'type'  => 'text',
            ),
			
            array(
                'label' => 'Blog 2 Category Link',
                'id'    => 'blog_2_category',
                'type'  => 'select',
                'args'  => $cat_titles
            )
			
		)
	);
	dev7_add_meta_box( $meta_box_home_template );

}
add_action( 'dev7_meta_boxes', 'add_custom_meta_boxes' );
