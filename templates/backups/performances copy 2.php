<?php /* Template Name: Season Performances */ ?>

<?php get_header(); ?>

<!-- performances.php -->

<main id="content" class="performances">
<section class="row">

	<?php
	// Value is set via WP_Customize_Control
	$current_season_cat_ID = get_theme_mod( 'current_season_category' );
	$current_season_cat = get_term_by( 'id', $current_season_cat_ID, 'sbe_category' );
	$current_season_cat_name = $current_season_cat->name;
	?>

	<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
		<h2>Current Season: <?php echo $current_season_cat_name; ?></h2>

		<div class="entry-content"><?php the_content(); ?></div><!-- entry-content -->
			
	<?php endwhile; endif; ?>
	
	
		<div class="slats">
							
			<?php 
			$args = array( 
				'post_type' 		=> 'events',
				'posts_per_page' 	=> -1,

				'tax_query' => array(
					array(
						'taxonomy' => 'sbe_events',
						'terms'    => $current_season_cat_ID,
					),
				),

			);
			
			$the_query = new WP_Query( $args );
			
			if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
				
				// function to output the data... works fine when it finds posts.
				sbe_list_output( true, 'medium' );
				
			endwhile; 
			wp_reset_postdata();			
			
			else :
			
				echo( '<h4>Sorry, no posts matched your criteria.</h4>' );
				echo( '<p>' . $current_season_cat_ID . '</p>' );
				
			endif; ?>

		</div><!-- slats -->
			

</section><!-- row -->
</main><!-- content -->

<?php get_footer(); ?>