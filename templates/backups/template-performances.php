<?php /* Template Name: Cr3ativ-Performances */ ?>

<?php get_header(); ?>

<!-- template-performances.php -->

<main id="content" class="performances">
<section class="row">
	
	<h1>Cr3ative Template Example</h1>

    <!-- Start of left content -->
    <div class="left_content">

        <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
        
            <h1 class="title"><?php the_title (); ?></h1>

            <?php if ( has_post_thumbnail() ) the_post_thumbnail(); ?>

            <?php the_content(); ?> 

        <?php endwhile; else: ?>
        
            <p><?php _e( 'There are no posts to display. Try using the search.', 'squarecode' ); ?></p> 

        <?php endif; ?>



		<?php
		// Value is set via WP_Customize_Control
		$current_season_cat_ID = get_theme_mod( 'current_season_category' );
		$current_season_cat = get_term_by( 'id', $current_season_cat_ID, 'sbe_category' );
		$current_season_cat_name = $current_season_cat->name;
		?>

        <?php 
		$temp = $wp_query; 
		$wp_query = null; 
		$wp_query = new WP_Query(); 
		$wp_query->query( 'post_type=events'.'&sbe_category='.$current_season_cat_name ); 
        ?>

        <?php while ($wp_query->have_posts()) : $wp_query->the_post();  ?>
        
		    <?php
			// function to output the data... works fine when it finds posts.
			sbe_list_output( true, 'medium' );
			?>
				
        <?php endwhile; ?> 
        
	    <?php $wp_query = null; $wp_query = $temp;  // Reset ?>
        
    </div>
    <!-- End of left content -->


</section><!-- row -->
</main><!-- content -->

<?php get_footer(); ?>