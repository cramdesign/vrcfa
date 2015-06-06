<?php if( function_exists( 'supersimple_list_subpages' ) and ( $post->post_parent or count( get_pages( 'child_of=' . $post->ID ) ) ) ) : ?>

	<aside class="sectionmenu">
		<h4>Section Menu</h4>
	
		<?php echo do_shortcode( '[ss_list_pages]' ); ?>
	
	</aside><!-- subpages -->

<?php endif; ?>