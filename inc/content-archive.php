<main id="content" class="archive events">
	
	<header>
		
		<div class="row">
	
			<?php if( is_tax() or is_category() ) : ?>
				
				<h1 class="category-title title">Event Category: <?php single_cat_title( $prefix = '', $display = true ); ?></h1>
				<div class="entry-content"><?php echo category_description(); ?></div>
				
			<?php else : ?>
				
				<h2>Upcoming Events</h2>
				
			<?php endif; ?>
		
		</div><!-- row -->
	
	</header>
	
	
	<section class="row">
	
	    <div class="slats">
	
		<?php 
			
			if( ! $layout ) $layout = 'slats';
			if( ! $desc ) $desc = true;
						
			while ( have_posts() ) : the_post();
		
				sbe_list_output( true, 'medium' );
			
			endwhile; 
		
		?>
	        
	    </div>
	
		<?php the_posts_pagination(); ?>

	</section><!-- row -->
	
</main><!-- content -->
