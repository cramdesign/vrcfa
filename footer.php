</main>

<footer id="footer">
	
	<div class="row sections">
	
		<section>
			
			<?php if( is_active_sidebar('footer_1') ) : ?>
				
				<div class="widget-area">
					<?php dynamic_sidebar('footer_1'); ?>
				</div><!-- widget-area -->
			
			<?php else : ?>
			
				<div class="widget text">
					<h3>Support the arts</h3>
					<p>Dummy text here. It is characterized by fragmentation, an interest in manipulating a structure's surface, skin, non-rectilinear shapes which appear to distort and dislocate elements of architecture.</p>
				</div><!-- widget -->
				
				<div class="widget">
					<nav>
						<h5>Quick links</h5>
						<ul id="quick-menu" class="menu">
							<li><a href="#">Events list</a></li>
							<li><a href="#">Ticket information</a></li>
							<li><a href="#">Rental information</a></li>
							<li><a href="#">Planning your visit</a></li>
						</ul>
					</nav>
				</div><!-- widget -->
				
				<div class="widget">
					<nav>
						<ul id="social-menu" class="menu">
							<li><a href="http://facebook.com">Facebook</a></li>
							<li><a href="http://twitter.com">Twitter</a></li>
						</ul>
					</nav>
				</div><!-- widget -->
			
			<?php endif; ?>
			
		</section>
		
		<section>
			
			<?php if( is_active_sidebar('footer_2') ) : ?>
				
				<div class="widget-area">
					<?php dynamic_sidebar('footer_2'); ?>
				</div><!-- widget-area -->
			
			<?php else : ?>
			
				<div class="widget text">
					<p>The Vern Riffe Center for the Arts is located on the beautiful campus of Shawnee State University in historic Portsmouth, Ohio.</p>
				</div><!-- widget -->
				
				<div class="widget text">
					<p><strong>The Vern Riffe Center for the Arts</strong>
					<br>940 Second Street
					<br>Portsmouth, Ohio 45653</p>
				</div><!-- widget -->
				
				<div class="widget text">
					<p><strong>The McKinley Box Office</strong>
					<br>Monday - Friday; 10am - 5pm
					<br>740 351-3600 &bull; info@vrcfa.com</p>
				</div><!-- widget -->
					
			<?php endif; ?>
			
		</section>
	
	</div><!-- row -->
	
</footer>

</div><!-- page.wrap -->
	
<?php wp_footer(); ?>

</body>
</html>