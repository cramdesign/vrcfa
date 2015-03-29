<?php

/**
 * Class Upcoming_Events
 */

class Upcoming_Events extends WP_Widget {

	/**
	 * Initializing the widget
	 */
	public function __construct() {
		$widget_ops = array(
			'class'			=>	'sbe_upcoming_events',
			'description'	=>	'A widget to display a list of upcoming events'
		);

		parent::__construct(
			'sbe_upcoming_events',	// base id
			'SBE Upcoming Events',	// title
			$widget_ops
		);
	}


	/**
	 * Displaying the widget on the back-end
	 * @param  array $instance An instance of the widget
	 */
	public function form( $instance ) {
	
		$widget_defaults = array(
			'title'				=>	'Upcoming Events',
			'number_events'		=>	5,
			'offset'			=>	0,
			'show_excerpt'		=>	false
		);

		$instance  = wp_parse_args( (array) $instance, $widget_defaults );
		
		?>
		
		<!-- Rendering the widget form in the admin -->
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'upcoming-events' ); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" class="widefat" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'number_events' ); ?>"><?php _e( 'Number of events to show', 'upcoming-events' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'number_events' ); ?>" name="<?php echo $this->get_field_name( 'number_events' ); ?>" class="widefat">
				<?php for ( $i = 1; $i <= 10; $i++ ): ?>
					<option value="<?php echo $i; ?>" <?php selected( $i, $instance['number_events'], true ); ?>><?php echo $i; ?></option>
				<?php endfor; ?>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('offset'); ?>"><?php _e( 'Offset (the number of posts to skip)', 'upcoming-events' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('offset'); ?>" name="<?php echo $this->get_field_name('offset'); ?>" type="text" value="<?php echo esc_attr( $instance['offset'] ); ?>" />
		</p>

		<p>
			<input id="<?php echo $this->get_field_id( 'show_excerpt' ); ?>" name="<?php echo $this->get_field_name( 'show_excerpt' ); ?>" type="checkbox" value="1" <?php checked( '1', $instance['show_excerpt'] ); ?>/>
			<label for="<?php echo $this->get_field_id( 'show_excerpt' ); ?>"><?php _e( 'Show excerpt, if available?' ); ?></label> 
        </p>
        
		<p>
			<input id="<?php echo $this->get_field_id( 'show_feature' ); ?>" name="<?php echo $this->get_field_name( 'show_feature' ); ?>" type="checkbox" value="1" <?php checked( '1', $instance['show_feature'] ); ?>/>
			<label for="<?php echo $this->get_field_id( 'show_feature' ); ?>"><?php _e( 'Show featured image, if available?' ); ?></label> 
        </p>
        
		<p>
			<input id="<?php echo $this->get_field_id( 'show_buttons' ); ?>" name="<?php echo $this->get_field_name( 'show_buttons' ); ?>" type="checkbox" value="1" <?php checked( '1', $instance['show_buttons'] ); ?>/>
			<label for="<?php echo $this->get_field_id( 'show_buttons' ); ?>"><?php _e( 'Show the buttons?' ); ?></label> 
        </p>
        
		<?php
	}


	/**
	 * Making the widget updateable
	 * @param  array $new_instance New instance of the widget
	 * @param  array $old_instance Old instance of the widget
	 * @return array An updated instance of the widget
	 */
	public function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['title'] 			= strip_tags( $new_instance['title'] );
		$instance['offset'] 		= strip_tags( $new_instance['offset'] );
		$instance['number_events'] 	= $new_instance['number_events'];
		$instance['show_excerpt'] 	= $new_instance['show_excerpt'];
		$instance['show_feature'] 	= $new_instance['show_feature'];
		$instance['show_buttons'] 	= $new_instance['show_buttons'];

		return $instance;
		
	}


	/**
	 * Displaying the widget on the front-end
	 * @param  array $args     Widget options
	 * @param  array $instance An instance of the widget
	 */
	public function widget( $args, $instance ) {

		extract( $args );
		$title  		= apply_filters( 'widget_title', $instance['title'] );
		$offset 		= apply_filters( 'widget_title', $instance['offset'] );
		$number 		= $instance['number_events'];
		$show_excerpt 	= $instance['show_excerpt'];
		$show_feature 	= $instance['show_feature'];
		$show_buttons 	= $instance['show_buttons'];

		//Preparing the query for events
		$meta_quer_args = array(
			'relation'		=>	'AND',
			array(
				'key'		=>	'event-end-date',
				'value'		=>	time(),
				'compare'	=>	'>='
			)
		);

		$query_args = array(
			'post_type'				=>	'events',
			'posts_per_page'		=>	$number,
			'offset'				=>	$offset,
			'post_status'			=>	'publish',
			'ignore_sticky_posts'	=>	true,
			'meta_key'				=>	'event-start-date',
			'orderby'				=>	'meta_value_num',
			'order'					=>	'ASC',
			'meta_query'			=>	$meta_quer_args
		);

		$upcoming_events = new WP_Query( $query_args );

		//Preparing to show the events
		echo $before_widget;
		
		if ( $title ) : 
		
		?>
		
		<header>
			<?php echo $before_title . $title . $after_title; ?>
		</header>
		
		<?php 
			
		endif;
				
		if( $upcoming_events->have_posts() ) :
		
			echo( '<div class="events">' );
			while( $upcoming_events->have_posts() ): $upcoming_events->the_post();
			
				sbe_list_output( $show_excerpt, $show_feature, $show_buttons );
						
			endwhile;
			echo( '</div><!-- events -->' );
			
		else : 
		
			echo( 'No events though $number were called.' );
	
		endif; 
		
		wp_reset_query();
		
		echo $after_widget;

	}
}

function sbe_list_output( $desc = false, $feature = true, $buttons = true, $size = 'thumbnail', $class = 'event slat' ) {

	$start_date		= get_metabox( 'event-start-date' );
	$end_date 		= get_metabox( 'event-end-date' );
	$ticket_link 	= get_metabox( 'event-ticket-link' );
	
	?>
	
	<div class="<?php echo $class; ?>">
		
		<?php
			
			if ( has_post_thumbnail( $post->ID ) and $feature ) :
						
				echo( '<figure><a href="' . get_the_permalink() . '">' . get_the_post_thumbnail( $post->ID, $size ) . '</a></figure>' );
			
			endif; 
		
		?>
		
		<article>
						
			<?php the_title( '<h4 class="title"><a href="' . get_the_permalink() . '">', '</a></h4>' ); ?>

			<p class="meta date">
				<strong><?php echo date_i18n( get_option( 'date_format' ), $start_date ); ?></strong> 
				<?php if ($end_date != $start_date ) echo " &ndash; " . date_i18n( get_option( 'date_format' ), $end_date ); ?>
			</p>
			
			<?php if ( $desc and has_excerpt() ) echo( '<div class="content">' . get_the_excerpt() . '</div>' ); ?>
			
			<?php if( $buttons ) : ?>
			
				<nav>
					
					<?php 
						
						echo( '<a href="' . get_the_permalink() . '" class="button">Info</a>' );
					
						if( $ticket_link ) echo( '<a href="' . $ticket_link . '" class="button">Tickets</a>' );
					
						edit_post_link('edit', '<span class="">', '</span>'); 
						
					?>
					
				</nav>
			
			<?php endif; ?>
			
		</article>
		
	</div><!-- post event -->
	
	<?php
}



function sbe_register_widget() {
	register_widget( 'Upcoming_Events' );
}
add_action( 'widgets_init', 'sbe_register_widget' );


