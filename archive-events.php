<?php get_header(); ?>


<main id="content" class="archive events">

	<?php if ( have_posts() ) : ?>
		
		<header>
			
			<div class="row">
			
				<?php if( is_category() ) : ?>
					
					<h1 class="category-title title"><?php single_cat_title( $prefix = '', $display = true ); ?></h1>
					<div class="entry-content"><?php echo category_description(); ?></div>
					
				<?php else : ?>
					
					<h2>Upcoming Events</h2>
					
				<?php endif; ?>
			
			</div><!-- row -->
			
		</header>
	
	
		<section class="row">
				
		<?php 
			
			while ( have_posts() ) : the_post();
		
				sbe_list_output( true, 'medium' );
			
			endwhile; 
		
		?>
		
		</section><!-- events -->
	
	
		<?php get_template_part( 'inc/pagination' ); ?>
	
	
	<?php endif; ?>
	
</main>


<?php get_footer(); ?>