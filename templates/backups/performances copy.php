<?php /* Template Name: Season Performances */ ?>


<?php get_header(); ?>

	
<!-- performances.php -->

<main id="content" class="singular">
<section class="row">

	<?php while ( have_posts() ) : the_post(); ?>
	
		<?php 
		$current_season_cat_ID = get_theme_mod( 'current_season_category' );
		$current_season_cat = get_term_by( 'id', $current_season_cat_ID, 'sbe_category' );
		$current_season_cat_name = $current_season_cat->name;
		?>
	
		<h2>Current Season: <?php echo $current_season_cat_name; ?></h2>

		<div class="entry-content"><?php the_content(); ?></div><!-- entry-content -->
			
		<div class="slats">
		
			<?php
			$args = array( 
				'post_type' 		=> 'events',
				'posts_per_page' 	=> -1,
				'tax_query' => array(
					array(
						'taxonomy' => 'sbe_events',
						'field'    => 'name',
						'terms'    => $current_season_cat_name,
					),
				),
			);
			
			$myposts = get_posts( $args );
			
			print_r( $args );
			
// 			print_r( $myposts );
			
			foreach ( $myposts as $post ) : 
			
				setup_postdata( $post );
				
				sbe_widget_output( true, 'medium' );
			
			endforeach; 
			wp_reset_postdata();
			?>
					
		</div><!-- slats -->
			
			
	<?php endwhile; ?>


</section><!-- row -->
</main><!-- content -->

<?php get_footer(); ?>