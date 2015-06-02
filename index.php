<?php get_header(); ?>

<!-- index.php -->

<section id="content">
	
	<div class="row sections alt">
		
		<section class="posts">
			<?php
				
				// start the loop... make wp look for posts
				if ( have_posts() ) : while ( have_posts() ) : the_post();
			
			
				// print the content of the post to the screen
				// look at the file inc/content.php for how this is formatted
				get_template_part( 'inc/content', get_post_format() );
				
				
				// end the loop... When there are no more posts, stop looking
				endwhile; endif;
				
				
				if( is_single() ) :
				
					// if on a single post
					// show links to the next and previous post
					the_post_navigation();
					
				elseif( is_home() ) :
				
					// if on the blog page
					// display page numbers if there are more posts than fit on one page
					the_posts_pagination();			
				
				endif;
				
			?>
		</section>
		
		<aside class="sidebar">
			
			<?php get_sidebar(); ?>
			
		</aside><!-- sidebar -->
	
	</div><!-- row -->

</section><!-- #content -->

<?php if ( comments_open() or get_comments_number() ) comments_template(); ?>

<?php get_footer(); ?>


