<div <?php post_class( 'item' ) ?>>

	<?php
		
		if( has_post_thumbnail( $post->ID ) ) echo( '<figure>' . get_the_post_thumbnail( $post->ID, 'thumbnail' ) . '</figure>' );
			
	?>

	<article>

        <header>
			
			<h3 class="title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>

        </header>

		<div class="content">
		
			<?php is_category() || is_archive() || is_home() || is_front_page() ) ? the_excerpt() : the_content(); ?>
			
		</div>

		<?php if ( ! is_front_page() ) : ?>
		
			<footer>
				<p><small>Posted in <?php the_category( ', ' ) ?></small></p>
			</footer>
			
		<?php endif; ?>

	</article>

</div><!-- post -->
