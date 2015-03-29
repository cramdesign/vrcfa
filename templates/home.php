<?php /* Template Name: Home Page */ ?>


<?php get_header(); ?>


	
<?php

	// WP_Query arguments
	$query_args = array (
		'post_type'       => 'events',
		'sbe_category'    => 'featured',

		'post_status'			=>	'publish',
		'posts_per_page'		=>	1,
		'ignore_sticky_posts'	=>	true,
		'meta_key'				=>	'event-start-date',
		'orderby'				=>	'meta_value_num',
		'order'					=>	'ASC',
	);
	
	// The Query
	$query = new WP_Query( $query_args );

	if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); 
	
	?>
	
	<div id="hero" class="hero event clear">
		
		<?php

		// function to output the data found in sbe-widget.php
		$start_date		= get_metabox( 'event-start-date' );
		$end_date 		= get_metabox( 'event-end-date' );
		$ticket_link 	= get_metabox( 'event-ticket-link' );
		

		if ( has_post_thumbnail() ) : 
		
			$hero_size = 'large';
			$hero = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '$hero_size' );
			$hero_url = $hero[ 0 ];

		?>
		
			<figure style="background-image: url(<?php echo $hero_url; ?>);">
				<a href="<?php the_permalink() ?>"><img src="<?php echo $hero_url; ?>"></a>
			</figure>
			
		<?php endif; ?>
		
		<article>
						
			<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

			<h4 class="meta date">
				<strong><?php echo date_i18n( get_option( 'date_format' ), $start_date ); ?></strong> 
				<?php if ($end_date != $start_date ) echo " &ndash; " . date_i18n( get_option( 'date_format' ), $end_date ); ?>
			</h4>
			
			<?php if ( has_excerpt() ) echo( '<div class="content">' . get_the_excerpt() . '</div>' ); ?>
			
			<nav>
				<a href="<?php the_permalink(); ?>" class="button">More Info</a>
				<?php if( $ticket_link ) : ?>
				<a href="<?php echo $ticket_link; ?>" class="button">Order Tickets</a>
				<?php endif; ?>
				<?php edit_post_link('edit', '<span>', '</span>'); ?>
			</nav>
			
		</article>
			
	</div><!-- hero -->

	<?php
		
	endwhile; else :

		echo ( 'No posts meet this criteria.' );

	endif;

	// Reset
	wp_reset_postdata();

?>


<!--

<div id="hero" class="event clear">

	<figure style="background-image: url(http://localhost/vrcfa/wp-content/uploads/sites/4/2014/10/keyboard-conversations.jpg);">
		<img src="http://localhost/vrcfa/wp-content/uploads/sites/4/2014/10/keyboard-conversations.jpg">
	</figure>
	
	<article>
		<h3 class="title"><a href="single-event-1.html">Keyboard Conversations Concerts with Lively Commentary Jeffrey Siegel, Pianist</a></h3>
		<p class="meta date"><strong>November 04, 2014</strong> at 7:30 pm</p>
		<p>This is a brief description of the upcoming event. Just a bit of teaser text if you will. No more than a few lines of text really. Full info on the full post.</p>
		<nav><a href="single-event-1.html" class="button info big">More Info</a> <a href="#" class="button purchase big">Order Tickets</a></nav>
	</article>

</div>

-->



<main id="content">
<div class="row sections">

	<section class="events">
	
		<?php if( is_active_sidebar('home_1') ) : ?>
			
		<div class="widget-area">
			<?php dynamic_sidebar('home_1'); ?>
		</div><!-- widget-area -->
		
		<?php else : ?>
		
		<header>
			<h3>Upcoming Events</h3>
			<nav><a href="events.html" class="button">All events</a><a href="#" class="button">ticket information</a></nav>
		</header>
		
		<div class="post event slat">
			<figure>
				<img src="images/landau-murphy-thumb.jpg">
			</figure>
			<article>
				<h4 class="title"><a href="single-event-1.html">Landau Eugene Murphy Jr and Friends</a></h4>
				<p class="meta date"><strong>November 04, 2014</strong></p>
				<nav><a href="single-event-1.html" class="button">Info</a><a href="#" class="button">Tickets</a></nav>
			</article>
		</div><!-- event teaser -->
	
		<div class="post event slat">
			<figure>
				<img src="images/keyboard-conversations-thumb.jpg">
			</figure>
			<article>
				<h4 class="title"><a href="single-event-1.html">Keyboard Conversations Concerts with Lively Commentary from Jeffrey Siegel, Pianist</a></h4>
				<p class="meta date"><strong>November 04, 2014</strong></p>
				<nav><a href="single-event-1.html" class="button">Info</a><a href="#" class="button">Tickets</a></nav>
			</article>
		</div><!-- event teaser -->
	
		<div class="post event slat">
			<figure>
				<img src="images/cuttime-simfonica-thumb.jpg">
			</figure>
			<article>
				<h4 class="title"><a href="single-event-1.html">CutTime Simfonica</a></h4>
				<p class="meta date"><strong>November 04, 2014</strong></p>
				<nav><a href="single-event-1.html" class="button">Info</a><a href="#" class="button">Tickets</a></nav>
			</article>
		</div><!-- event teaser -->
	
		<?php endif; ?>
		
	</section><!-- events -->
	
	<section class="excerpts">
		
		<?php if( is_active_sidebar('home_2') ) : ?>
			
		<div class="widget-area">
			<?php dynamic_sidebar('home_2'); ?>
		</div><!-- widget-area -->
		
		<?php else : ?>
		
		<header>
			<h3>News and announcements</h3>
			<nav><a href="#" class="button">All announcements</a></nav>
		</header>
		
		<div class="post">
			<h4 class="title">This is an announcement title. These can vary in length up to two lines but no more.</h4>
			<article>
				<p>Deconstructivism is a development of postmodern architecture that began in the late 1980s. It is influenced by the theory of "Deconstruction", which is a form of semiotic analysis. It is characterized by fragmentation, an interest in manipulating a structure's surface, skin, non-rectilinear shapes which appear to distort and dislocate elements of architecture, such as structure... <a href="#" class="more">Read full article</a></p>
			</article>
		</div><!-- post -->
		
		<div class="post">
			<h4 class="title">Announcements can have a featured image. If they do, they look like this.</h4>
			<figure>
				<img src="images/landau-murphy-icon.jpg">
			</figure>
			<article>
				<p>Deconstructivism is a development of postmodern architecture that began in the late 1980s. It is influenced by the theory of "Deconstruction", which is a form of semiotic analysis. It is characterized by fragmentation, an interest in manipulating a structure's surface, skin, non-rectilinear shapes which appear to distort and dislocate elements of architecture, such as structure... <a href="#" class="more">Read full article</a></p>
			</article>
		</div><!-- post -->
		
		<div class="widget newsletter post">
			<h3 class="title">Email updates</h3>
			<p class="subtitle">Sign up to receive the latest information.</p>
			<form class="newsletter-form simple" action="#">
				<input type="submit" value="Ok">
				<label for="email-text"><span class="screen-reader-text">Email address:</span>
					<input type="text" id="email-text" value="">
				</label>
			</form>
		</div><!-- widget -->
		
		<?php endif; ?>

	</section><!-- announcements -->

</div><!-- row -->
</main>



<?php get_footer(); ?>