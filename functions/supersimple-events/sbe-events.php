<?php
/*

Plugin Name: Supersimple Events
Description: A plugin to show a list of upcoming events on the front-end.
Version: 1.2.3
Author: Matt Cram
Author URI: http://mattcram.com
Text Domain: super-basic-events
License: GPL2
 
forked: https://wordpress.org/plugins/upcoming-events-lists/
http://code.tutsplus.com/tutorials/creating-upcoming-events-plugin-in-wordpress-custom-post-type-and-the-dashboard--wp-35404
 
*/

function sbe_custom_post_type_init() {

	// Register Custom Post Type

	$labels = array(
		'name'					=> 'Events',
		'singular_name'			=> 'Event',
		'menu_name'				=> 'Events',
		'parent_item_colon'		=> 'Parent Event:',
		'all_items'				=> 'All Events',
		'view_item'				=> 'View Event',
		'add_new_item'			=> 'Add New Event',
		'add_new'				=> 'Add New',
		'edit_item'				=> 'Edit Event',
		'update_item'			=> 'Update Event',
		'search_items'			=> 'Search Events',
		'not_found'				=> 'No events found',
		'not_found_in_trash'	=> 'No events found in Trash',
	);
	
	$args = array(
		'label'					=> 'events',
		'description'			=> 'A list of upcoming events',
		'capability_type'		=> 'page',
		'labels'				=> $labels,
		'supports'				=> array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'hierarchical'			=> true,
		'public'				=> true,
		'show_ui'				=> true,
		'show_in_menu'			=> true,
		'show_in_nav_menus'		=> true,
		'show_in_admin_bar'		=> true,
		'menu_position'			=> 5,
		'menu_icon'				=> 'dashicons-calendar-alt',
		'can_export'			=> true,
		'has_archive'			=> true,
		'exclude_from_search'	=> false,
		'publicly_queryable'	=> true,
		'taxonomies'			=> array( 'sbe_category', 'sbe_venue'),
		'rewrite'				=> array( "slug" => "events" ),
	);
	
	register_post_type( 'events', $args );


	// Register taxonomies for the event post type

	// event categories
	
    $labels = array(
        'name' 					=> 'Event Categories',
        'singular_name' 		=> 'Event Category',
        'search_items' 			=> 'Search Event Categories',
        'popular_items' 		=> 'Popular Event Categories',
        'all_items' 			=> 'All Event Categories',
        'parent_item' 			=> null,
        'parent_item_colon' 	=> null,
        'edit_item' 			=> 'Edit Event Category',
        'update_item' 			=> 'Update Event Category',
        'add_new_item' 			=> 'Add New Event Category',
        'new_item_name' 		=> 'New Event Category Name',
    );

	$args = array(
        'label' 				=> 'Event Category',
        'labels' 				=> $labels,
        'hierarchical' 			=> true,
        'show_ui' 				=> true,
        'query_var' 			=> true,
        'rewrite' 				=> array( 'slug' => 'event-category' ),
    );
    
	register_taxonomy( 'sbe_category','events', $args );


	// venues
	
    $labels = array(
        'name' 					=> 'Venues',
        'singular_name' 		=> 'Venue',
        'search_items' 			=> 'Search Venues',
        'popular_items' 		=> 'Popular Venues',
        'all_items' 			=> 'All Venues',
        'parent_item' 			=> null,
        'parent_item_colon' 	=> null,
        'edit_item' 			=> 'Edit Venue',
        'update_item' 			=> 'Update Venue',
        'add_new_item' 			=> 'Add New Venue',
        'new_item_name' 		=> 'New Venue Name',
    );

	$args = array(
        'label' 				=> 'Event Venue',
        'labels' 				=> $labels,
        'hierarchical' 			=> true,
        'show_ui' 				=> true,
        'query_var' 			=> true,
        'rewrite' 				=> array( 'slug' => 'event-venue' ),
    );
    
    register_taxonomy( 'sbe_venue','events', $args );

}

add_action( 'init', 'sbe_custom_post_type_init', 0 );



function sbe_activation_deactivation() {
	
	// register taxonomies and post type
	sbe_custom_post_type_init();
	
	// flush rewrite rules for better permalink structure
	flush_rewrite_rules();
	
}
register_activation_hook( __FILE__, 'sbe_activation_deactivation' );



//Adding metabox for event information
function sbe_add_event_info_metabox() {
	
	add_meta_box( 'sbe-event-info-metabox', 'Event Info', 'sbe_render_event_info_metabox', 'events', 'normal', 'high' );
	
}
add_action( 'add_meta_boxes', 'sbe_add_event_info_metabox' );



/**
 * Rendering the metabox for event information
 * @param  object $post The post object
 */
function sbe_render_event_info_metabox( $post ) {
	
	//generate a nonce field
	wp_nonce_field( basename( __FILE__ ), 'sbe-event-info-nonce' );

	//get previously saved meta values (if any)
	$start_date			= get_metabox( 'event-start-date' );
	$start_time			= get_metabox( 'event-start-time' );
	$end_date 			= get_metabox( 'event-end-date' );
	$end_time			= get_metabox( 'event-end-time' );

	$custom_link 		= get_metabox( 'event-custom-link' );
	$ticket_link 		= get_metabox( 'event-ticket-link' );
	
	$standard_lower		= get_metabox( 'event-ticket-standard-lower' );
	$standard_upper		= get_metabox( 'event-ticket-standard-upper' );
	
	$senior_lower		= get_metabox( 'event-ticket-senior-lower' );
	$senior_upper		= get_metabox( 'event-ticket-senior-upper' );
	
	$student_lower		= get_metabox( 'event-ticket-student-lower' );
	$student_upper		= get_metabox( 'event-ticket-student-upper' );
	
	$child_lower		= get_metabox( 'event-ticket-child-lower' );
	$child_upper		= get_metabox( 'event-ticket-child-upper' );
	
	$caption			= get_metabox( 'event-ticket-caption' );
	$sponsor			= get_metabox( 'event-sponsor' );
	

	//if there is previously saved value then retrieve it, else set it to the current time
	$start_date = empty( $start_date ) ? time() : $start_date;

	//we assume that if the end date is not present, event ends on the same day
	$end_date = empty( $end_date ) ? $start_date : $end_date;
	
	if( $end_date < $start_date ) $end_date = $start_date;

	?>
	
	<table class="meta">

		<tr>
			<th> 
				<label for="sbe-start-date">Event Start Date:</label>
			</th>
			<td>
				<input type="date" id="sbe-start-date" name="sbe-start-date" class="sbe-date-input half" value="<?php echo date( 'F d, Y', $start_date ); ?>" placeholder="Format: February 7, 2014">
				<input type="text" id="sbe-start-time" name="sbe-start-time" class="half" value="<?php echo $start_time; ?>" placeholder="Starting Time. Example: 7:30 pm">
			</td>
		</tr>

		<tr>
			<th>
				<label for="sbe-end-date">Event End Date:</label>
			</th>
			<td>
				<input type="date" id="sbe-end-date" name="sbe-end-date" class="sbe-date-input half" value="<?php echo date( 'F d, Y', $end_date ); ?>" placeholder="Format: February 7, 2014">
				<input type="text" id="sbe-end-time" name="sbe-end-time" class="half" value="<?php echo $end_time; ?>" placeholder="Ending Time">
			</td>
		</tr>

		<tr>
			<th>
				<label for="sbe-ticket-link">Custom Link:</label>
			</th>
			<td>
				<input type="text" id="sbe-custom-link" name="sbe-custom-link" value="<?php echo $custom_link; ?>" placeholder="Link to an external page">
			</td>
		</tr>

		<tr>
			<th>
				<label for="sbe-ticket-link">Purchase Tickets Link:</label>
			</th>
			<td>
				<input type="text" id="sbe-ticket-link" name="sbe-ticket-link" value="<?php echo $ticket_link; ?>" placeholder="The full Ticketmaster link">
			</td>
		</tr>

		<tr>
			<th>
				<label>Standard Ticket Price:</label>
			</th>
			<td>
				<input type="text" id="sbe-ticket-standard-lower" name="sbe-ticket-standard-lower" class="half" value="<?php echo $standard_lower; ?>" placeholder="Lower Tier">
				<input type="text" id="sbe-ticket-standard-upper" name="sbe-ticket-standard-upper" class="half" value="<?php echo $standard_upper; ?>" placeholder="Upper Tier">
			</td>
		</tr>

		<tr>
			<th>
				<label>Senior Ticket Price:</label>
			</th>
			<td>
				<input type="text" id="sbe-ticket-senior-lower" name="sbe-ticket-senior-lower" class="half" value="<?php echo $senior_lower; ?>" placeholder="Lower Tier">
				<input type="text" id="sbe-ticket-senior-upper" name="sbe-ticket-senior-upper" class="half" value="<?php echo $senior_upper; ?>" placeholder="Upper Tier">
			</td>
		</tr>

		<tr>
			<th>
				<label>Student Ticket Price:</label>
			</th>
			<td>
				<input type="text" id="sbe-ticket-student-lower" name="sbe-ticket-student-lower" class="half" value="<?php echo $student_lower; ?>" placeholder="Lower Tier">
				<input type="text" id="sbe-ticket-student-upper" name="sbe-ticket-student-upper" class="half" value="<?php echo $student_upper; ?>" placeholder="Upper Tier">
			</td>
		</tr>

		<tr>
			<th>
				<label>Under 12 Ticket Price:</label>
			</th>
			<td>
				<input type="text" id="sbe-ticket-child-lower" name="sbe-ticket-child-lower" class="half" value="<?php echo $child_lower; ?>" placeholder="Lower Tier">
				<input type="text" id="sbe-ticket-child-upper" name="sbe-ticket-child-upper" class="half" value="<?php echo $child_upper; ?>" placeholder="Upper Tier">
			</td>
		</tr>

		<tr>
			<th>
				<label for="sbe-ticket-link">Ticket Pricing Caption:</label>
			</th>
			<td>
				<input type="text" id="sbe-ticket-caption" name="sbe-ticket-caption" value="<?php echo $caption; ?>" placeholder="(optional caption)">
			</td>
		</tr>

		<tr>
			<th>
				<label for="sbe-sponsor">Event Sponsor:</label>
			</th>
			<td>
				<input type="text" id="sbe-sponsor" name="sbe-sponsor" value="<?php echo $sponsor; ?>" placeholder="Sponsor text">
			</td>
		</tr>

	</table>

	<?php
}



// simple way to return the value

if ( !function_exists( 'get_metabox' ) ) : function get_metabox( $key = "" ) {

	return get_post_meta( get_the_ID(), $key, true );

} endif;

if ( !function_exists( 'the_metabox' ) ) : function the_metabox( $key = "" ) {

	echo get_metabox( $key );

} endif;



/**
 * Enqueueing scripts and styles in the admin
 * @param  int $hook Current page hook
 */
function sbe_admin_scripts( $hook ) {
	
	global $post_type;

	if ( ( 'post.php' == $hook || 'post-new.php' == $hook ) && ( 'events' == $post_type ) ) {

		$path = str_replace( WP_CONTENT_DIR, WP_CONTENT_URL, dirname( __FILE__ ) );

		// scripts
		wp_register_script( 'pikaday', $path . '/js/pikaday.js', array(), '', true );
		wp_enqueue_script( 'sbe-events', $path . '/js/sbe-events.js', array( 'pikaday' ), '', true );
		
		// styles
		wp_enqueue_style( 'pikaday', $path . '/css/pikaday.css' );
		wp_enqueue_style( 'sbe-admin', $path . '/css/sbe-admin.css' );
		
	}
	
}
add_action( 'admin_enqueue_scripts', 'sbe_admin_scripts' );



/**
 * Enqueueing styles for the front-end widget
 */
function sbe_widget_style() {
	
	if ( is_active_widget( '', '', 'sbe_upcoming_events', true ) ) {
		
		$path = str_replace( WP_CONTENT_DIR, WP_CONTENT_URL, dirname( __FILE__ ) );
		//wp_enqueue_style( 'upcoming-events', $path . '/css/upcoming-events.css' );
		
	}
	
}
add_action( 'wp_enqueue_scripts', 'sbe_widget_style' );



/**
 * Saving the event along with its meta values
 * @param  int $post_id The id of the current post
 */
function sbe_save_event_info( $post_id ) {

	//checking if the post being saved is an 'event'; if not, then return
	if( isset( $_POST['post_type'] ) && 'events' != $_POST['post_type'] ) return;

	//checking for the 'save' status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST['sbe-event-info-nonce'] ) && ( wp_verify_nonce( $_POST['sbe-event-info-nonce'], basename( __FILE__ ) ) ) ) ? true : false;

	//exit depending on the save status or if the nonce is not valid
	
	if ( $is_autosave || $is_revision || ! $is_valid_nonce ) return;

	//checking for the values and performing necessary actions
	
	if( isset( $_POST['sbe-start-date'] ) ) {
		update_post_meta( $post_id, 'event-start-date', strtotime( $_POST['sbe-start-date'] ) );
	}

	if( isset( $_POST['sbe-start-time'] ) ) {
		update_post_meta( $post_id, 'event-start-time', sanitize_text_field( $_POST['sbe-start-time'] ) );
	}

	if( isset( $_POST['sbe-end-date'] ) ) {
		update_post_meta( $post_id, 'event-end-date', strtotime( $_POST['sbe-end-date'] ) );
	}

	if( isset( $_POST['sbe-end-time'] ) ) {
		update_post_meta( $post_id, 'event-end-time', sanitize_text_field( $_POST['sbe-end-time'] ) );
	}

	if( isset( $_POST['sbe-custom-link'] ) ) {
		update_post_meta( $post_id, 'event-custom-link', sanitize_text_field( $_POST['sbe-custom-link'] ) );
	}
	
	if( isset( $_POST['sbe-ticket-link'] ) ) {
		update_post_meta( $post_id, 'event-ticket-link', sanitize_text_field( $_POST['sbe-ticket-link'] ) );
	}
	
	
	// Standard
	if( isset( $_POST['sbe-ticket-standard-lower'] ) ) {
		update_post_meta( $post_id, 'event-ticket-standard-lower', sanitize_text_field( $_POST['sbe-ticket-standard-lower'] ) );
	}
	
	if( isset( $_POST['sbe-ticket-standard-upper'] ) ) {
		update_post_meta( $post_id, 'event-ticket-standard-upper', sanitize_text_field( $_POST['sbe-ticket-standard-upper'] ) );
	}
	
	// Senior
	if( isset( $_POST['sbe-ticket-senior-lower'] ) ) {
		update_post_meta( $post_id, 'event-ticket-senior-lower', sanitize_text_field( $_POST['sbe-ticket-senior-lower'] ) );
	}
	
	if( isset( $_POST['sbe-ticket-senior-upper'] ) ) {
		update_post_meta( $post_id, 'event-ticket-senior-upper', sanitize_text_field( $_POST['sbe-ticket-senior-upper'] ) );
	}
	
	// Student
	if( isset( $_POST['sbe-ticket-student-lower'] ) ) {
		update_post_meta( $post_id, 'event-ticket-student-lower', sanitize_text_field( $_POST['sbe-ticket-student-lower'] ) );
	}
	
	if( isset( $_POST['sbe-ticket-student-upper'] ) ) {
		update_post_meta( $post_id, 'event-ticket-student-upper', sanitize_text_field( $_POST['sbe-ticket-student-upper'] ) );
	}
	
	// Child
	if( isset( $_POST['sbe-ticket-child-lower'] ) ) {
		update_post_meta( $post_id, 'event-ticket-child-lower', sanitize_text_field( $_POST['sbe-ticket-child-lower'] ) );
	}
	
	if( isset( $_POST['sbe-ticket-child-upper'] ) ) {
		update_post_meta( $post_id, 'event-ticket-child-upper', sanitize_text_field( $_POST['sbe-ticket-child-upper'] ) );
	}
	
	
	if( isset( $_POST['sbe-ticket-caption'] ) ) {
		update_post_meta( $post_id, 'event-ticket-caption', sanitize_text_field( $_POST['sbe-ticket-caption'] ) );
	}
	
	if( isset( $_POST['sbe-sponsor'] ) ) {
		update_post_meta( $post_id, 'event-sponsor', sanitize_text_field( $_POST['sbe-sponsor'] ) );
	}
	
}
add_action( 'save_post', 'sbe_save_event_info' );






/**
 * Custom columns head
 * @param  array $defaults The default columns in the post admin
 */
function sbe_custom_columns_head( $columns ) {
	
	unset( $columns['date'] );

	$new_columns['event_start_date'] = 'Start Date';
	$new_columns['event_end_date'] = 'End Date';
	$new_columns['event_category'] = 'Category';
	$new_columns['event_venue'] = 'Venue';
	
	return array_merge( $columns, $new_columns );
	
}
add_filter( 'manage_edit-events_columns', 'sbe_custom_columns_head', 10 );



/**
 * Custom columns content
 * @param  string 	$column_name The name of the current column
 * @param  int 		$post_id	 The id of the current post
 */
function sbe_custom_columns_content( $column_name, $post_id ) {
	
	global $post;

	if ( 'event_start_date' == $column_name ) {
		$start_date = get_metabox( 'event-start-date' );
		echo date( 'F d, Y', $start_date );
	}

	if ( 'event_end_date' == $column_name ) {
		$end_date = get_metabox( 'event-end-date' );
		echo date( 'F d, Y', $end_date );
	}

	if ( 'event_category' == $column_name ) {
		
		$terms = get_the_terms( $post_id, 'sbe_category' );

		if ( !empty( $terms ) ) :

			$out = array();

			foreach ( $terms as $term ) :
			
				$out[] = sprintf( '<a href="%s">%s</a>',
					esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'sbe_category' => $term->slug ), 'edit.php' ) ),
					esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'sbe_category', 'display' ) )
				);
				
			endforeach;

			echo join( ', ', $out );
		
		else :
		
			_e( 'No Category' );
			
		endif;

	}

	if ( 'event_venue' == $column_name ) {
		
		$terms = get_the_terms( $post_id, 'sbe_venue' );

		if ( !empty( $terms ) ) :

			$out = array();

			foreach ( $terms as $term ) :
			
				$out[] = sprintf( '<a href="%s">%s</a>',
					esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'sbe_venue' => $term->slug ), 'edit.php' ) ),
					esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'sbe_venue', 'display' ) )
				);
				
			endforeach;

			echo join( ', ', $out );
		
		else :
		
			_e( 'No Venue' );
			
		endif;

	}

}
add_action( 'manage_events_posts_custom_column', 'sbe_custom_columns_content', 10, 2 );


// Including the widget
include( 'sbe-widget.php' );