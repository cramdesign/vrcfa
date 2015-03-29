<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	
<div id="page" class="wrap">

<?php get_template_part( 'inc/top' ); ?>

<header id="header" class="row">
	
	<h1 id="logo" class="site-title"><a href="<?php echo home_url( "/" ); ?>"><?php bloginfo( "name" ); ?></a></h1>
		
	<nav id="menu">
		<input type="checkbox" id="menu-toggle" class="toggle"><label for="menu-toggle" class="toggle">Menu</label>
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'drop menu target' )); ?>
	</nav>
		
</header>


<main>