<?php if( $post->post_parent or count( get_pages('child_of=' . $post->ID) ) ) : ?>

<aside class="sectionmenu">
	<h5>Section Menu</h5>
	<ul class="menu">

	<?php
		// if the post has a parent, list parent and siblings otherwise list the post and its children
		// from: http://www.mbwebdesign.co.uk/show-siblings-or-children-of-a-wordpress-page/
		if( $post->post_parent ) :
		
			// on a subpage
		    wp_list_pages( 'title_li=&include='.$post->post_parent );
		    wp_list_pages( 'title_li=&child_of='.$post->post_parent );
			
		elseif( count( get_pages( 'child_of=' . $post->ID ) ) ) :
		
			// on the parent page
		    wp_list_pages( 'title_li=&include='.$post->ID );
		    wp_list_pages( 'title_li=&child_of='.$post->ID );
			
		endif; 
	?>

	</ul>
</aside><!-- subpages -->

<?php endif; ?>