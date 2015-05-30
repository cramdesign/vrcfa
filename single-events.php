<?php get_header(); ?>


<!-- single-events.php -->


<?php 
	
	// Start the LOOP
	if ( have_posts() ) : while ( have_posts() ) : the_post();
	
	
	// Event Variables
	$start = date_i18n( get_option( 'date_format' ), get_metabox( 'event-start-date' ) );
	$end = date_i18n( get_option( 'date_format' ), get_metabox( 'event-end-date' ) );
	
	$start_time = get_metabox( 'event-start-time' );
	$end_time = get_metabox( 'event-end-time' );
	
	$event_date = '<span class="event-start">' . $start . '</span>';
	if( $start != $end ) $event_date .= ' &ndash; <span class="event-end">' . $end . '</span>';
	
	if( $start_time and $end_time ) :
		$event_date .= ' from <span class="event-start-time">' . $start_time . '</span> to <span class="event-end-time">' . $end_time . '</span>';
	elseif ( $start_time ) :
		$event_date .= ' starting at <span class="event-start-time">' . $start_time . '</span>';
	endif;

?>

<section id="content">
<div class="posts row">

<article class="post single event">

	<header>
		
		<?php 
			
			the_title( '<h1 class="title">', '</h1>' );

			echo( '<h4 class="date">' . $event_date . '</h4>' ); 
			
		?>

	</header>
	
	<div class="row">
		
		<div class="content primary">
			
			<?php 
			
				// featured image
				if ( has_post_thumbnail( $post->ID ) ) echo( '<figure>' . get_the_post_thumbnail( $post->ID, 'large' ) . '</figure>' );
					
				// main content
				the_content();
				
				// ticket order button
				if( get_metabox( 'event-sponsor' ) ) echo( '<h6 class="sponsor">Sponsored by: ' . get_metabox( 'event-sponsor' ) . '</h6>' );
					
			?>
			
		</div><!-- primary -->
		
		<aside class="secondary">
			
			<?php 
				
				// extra content
				//if( has_excerpt() ) echo( '<div class="meta notes">' . get_the_excerpt() . '</div>' );


				// Venue
				if( has_term( '', 'sbe_venue' ) ) echo( '<div class="meta location"><b>Venue:</b> ' .  get_the_term_list( $post->ID, 'sbe_venue', '', ', ' ) . '</div>' );


				// performance categories
				if( has_term( '', 'sbe_category' ) ) echo( '<div class="meta categories">' . get_the_term_list( $post->ID, 'sbe_category', '', ', ' ) . '</div>' );
	
				
				// ticket prices. located in functions/utility.php
				sbe_render_ticket_pricing();  
				
				 
				// ticket order button
				if( get_metabox( 'event-ticket-link' ) ) :
									
					echo( '<nav><a href="' . get_metabox( 'event-ticket-link' ) . '" class="button purchase big">Order Tickets</a></nav>' );
			
				else : 
				
					echo( '<p class="meta">Contact the McKinley Box Office for seating and ticket information at <strong>740-351-3600</strong> or <strong><a href="mailto:info@vrcfa.com">info@vrcfa.com</a></strong>.</p>' );
					
				endif;
				
			?>
			
		</aside><!-- secondary -->
	
	</div><!-- row -->
	
</article>

</div><!-- row -->
</section>

<?php endwhile; endif; ?>

<?php get_footer(); ?>