<?php get_header(); ?>

<!-- taxonomy-sbe_category.php -->

<main id="content" class="performances">
	<header>
	<div class="row">
	
	<?php if( is_tax() ) : ?>
		
		<h1 class="category-title title">Event Category: <?php single_cat_title( $prefix = '', $display = true ); ?></h1>
		<div class="entry-content">
			<?php echo category_description(); ?>
		</div>
		
	<?php else : ?>
		
		<h2>Upcoming Events</h2>
		
	<?php endif; ?>
	
	</div><!-- row -->
	</header>
	<section class="row">
	
	    <?php
	    $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	    $args = array( 'post_type'=>'events', 'sbe_category'=>$term->slug );
	    $loop = new WP_Query( $args );
	    ?>
	
	    <!-- Start of blog wrapper -->
	    <div class="cr3ativcareer_blog_wrapper">
	
	    <?php while ($loop->have_posts()) : $loop->the_post(); ?>
	
		    <?php
			// function to output the data... works fine when it finds posts.
			sbe_list_output( true, 'medium' );
			?>
	
		<?php endwhile; ?> 
	        
	    </div>
	    <!-- End of blog wrapper -->
	
	
	</section><!-- row -->
</main><!-- content -->

<?php get_footer(); ?>