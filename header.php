<!DOCTYPE html>
<html>
<head>
<!-- 

Design by MattCram.com 

  _____ _____           __    __ _____  ______  ____  _____  _____ _   _ 
 / ____|  __ \    /\   |  \  /  |  __ \|  ____|/ ___||_   _|/ ____| \ | |
| |    | |__) |  /  \  | \ \/ / | |  | | |__  | (___   | | | |  __|  \| |
| |    |  _  /  / /\ \ | |\  /| | |  | |  __|  \___ \  | | | | |_ | . ` |
| |____| | \ \ / ____ \| | \/ | | |__| | |____  ___) |_| |_| |__| | |\  |
 \_____|_|  \_\_/    \_\_|    |_|_____/|______||____/|_____|\_____|_| \_|

hello

-->
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