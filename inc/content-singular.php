
<main id="content" class="singular">

	<section <?php post_class( 'row' ) ?>>
	
		<header>
		
			<h1 class="title"><?php the_title(); ?></h1>
		
			<?php if ( is_single() or is_home() ) : ?>
			
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
	
			
		<div>
			
			<?php if( is_page() ) get_template_part( 'inc/nav', 'page' ); ?>
			
			<article class="entry-content"><?php the_content(); ?></article><!-- entry-content -->
		
			<?php wp_link_pages('before=<div id="page-links">&after=</div>'); ?>
			
		</div>
		
	
	</section><!-- post row -->
			
</main><!-- content -->
		
