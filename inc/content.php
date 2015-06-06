<article class="post">
	
	<?php
		
		if( has_post_thumbnail( $post->ID ) ) :
		
			$img = get_the_post_thumbnail( $post->ID, 'large' );
		
			if( is_singular() ) :
			
				echo( '<figure>' . $img . '</figure>' );
			
			else :
					
				echo( '<figure><a href="' . get_the_permalink() . '">' . $img . '</a></figure>' );
			
			endif;
		
		endif; 
	
	?>

	<header>
		
		<?php 
			
			if( is_singular() ) : 
			
				// if this post is a single post, page, or attachment; just print the title
				// but not if it's the front page as set in Settings > Reading
				if ( !is_front_page() ) : 
				
					the_title( '<h1 class="title">', '</h1>' ); 
					
				endif;
				
			else : 
			
				// otherwise print the title with a link to the single
				the_title( '<h2 class="title"><a href="' . get_the_permalink() . '">', '</a></h2>' );

			endif;
			
		?>
		
		<?php if( is_single() or is_home() ) : ?>
			
			<div class="meta">
				
				<p class="date"><?php the_time( get_option('date_format') ); ?></p>
				
				<?php if( has_category() ) : ?>
					<p class="categories"><?php the_category(', ') ?></p>
				<?php endif; ?>
				
				<?php if( get_comments_number() != 0 ) : ?>
					<p class="comments"><?php comments_popup_link( 'No Comments', '1 Comment', '% Comments' ); ?></p>
				<?php endif; ?>
				
			</div><!-- meta -->
			
		<?php endif; ?>
		
	</header>
	
	<?php if( is_page() ) supersimple_sectionmenu(); ?>
	
	<div class="content">
		
		<?php 
			
			// get the main content from the post
			the_content();
			wp_link_pages('before=<div id="page-links">&after=</div>');
			
		?>
		
	</div><!-- content -->
	
</article><!-- post -->