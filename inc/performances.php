<section id="content" class="performances">
	
	<div class="row">
	
		<?php
			
			// Value is set via WP_Customize_Control
			$current_season_cat_ID = get_theme_mod( 'current_season_category' );
			$current_season_cat = get_term_by( 'id', $current_season_cat_ID, 'sbe_category' );
			$current_season_cat_name = $current_season_cat->name;
			$current_season_cat_slug = $current_season_cat->slug;
			
			// start the Loop
			if ( have_posts() ) : while ( have_posts() ) : the_post(); 
			
		?>
		
			<header>
					
					<h2>Upcoming Events</h2>
					<!-- <h2>Current Season: <?php echo $current_season_cat_name; ?></h2> -->
					<div class="content"><?php the_content(); ?></div><!-- entry-content -->
				
			</header>
			
		<?php 
			
			// end the Loop
			endwhile; endif; 

			if( ! isset( $layout ) ) $layout = 'slats';
			if( ! isset( $desc ) ) $desc = false;

		?>
				
		<div class="posts <?php echo( $layout ); ?>">
											
			<?php
					
				//Preparing the query for events
				$meta_quer_args = array(
					
					'relation'		=>	'AND',
					array(
						
						'key'		=>	'event-end-date',
						'value'		=>	time(),
						'compare'	=>	'>='
						
					)
					
				);
	
				// WP_Query arguments
				$query_args = array (
					
					'post_type'       => 'events',
					'sbe_category'    => $current_season_cat_slug,
	
					'post_status'			=>	'publish',
					'ignore_sticky_posts'	=>	true,
					'meta_key'				=>	'event-start-date',
					'orderby'				=>	'meta_value_num',
					'order'					=>	'ASC',
					'posts_per_page'		=>	-1
					
				);
				
				// The Query
				$query = new WP_Query( $query_args );
	
				if ( $query->have_posts() ) : 
				
					while ( $query->have_posts() ) : $query->the_post();
		
						// function to output the data found in sbe-widget.php
						sbe_list_output( $desc, 'thumbnail' );
		
					endwhile;
								
				else :
	
					echo ( 'No posts meet this criteria.' );
	
				endif;
	
				// Reset
				wp_reset_postdata();
	
			?>
	
		</div><!-- posts -->
	
	
	</div><!-- row -->
	
</section><!-- content -->
