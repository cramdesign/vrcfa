<form id="searchform" action="<?php echo home_url( '/' ); ?>" method="get" class="searchform simple target">
	
	<input type="submit" id="searchsubmit" class="search" value="Search">
	
	<label for="search"><span class="screen-reader-text">Search for:</span>
		<input type="text" name="s" id="search" placeholder="Search VRCFA..." value="<?php the_search_query(); ?>">
	</label>
	
</form>


