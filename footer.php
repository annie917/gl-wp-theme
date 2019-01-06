<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 */
 
 ?>

	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">
		<div id="ghl-main-social">
			<div id="shareaholic-footer-buttonset">
				<?php 
					if(!is_page(array('privacy-policy','contact', 'terms-and-conditions', 'sitemap', 'greyhound-resources-links')))
					{
						//if(function_exists('selfserv_shareaholic')) { selfserv_shareaholic(); }
					}
				?>
			</div>
			<div class="ghlcb"></div>
		</div>
		
		<div id="footer-top-site-links">
			<ul>
				<li><a href="https://www.greyhoundlifeline.co.uk/" title="">Greyhound Lifeline</a></li>
				<li><a href="https://www.greyhoundlifeline.co.uk/privacy-policy/" title="Greyhound Lifeline Privacy Policy">Privacy Policy</a></li>
                <li><a href="https://www.greyhoundlifeline.co.uk/information/greyhound-resources-links/" title="Greyhound Lifeline Resources and Links">Resources and Links</a></li>

				<li><a href="https://www.greyhoundlifeline.co.uk/terms-and-conditions/" title="Greyhound Lifeline Site Terms and Conditions">Terms and Conditions</a></li>
<!--				<li><a href="http://www.greyhoundlifeline.co.uk/sitemap/" title="Greyhound Lifeline Sitemap">Sitemap</a></li>-->
<!--
***Newsletter option removed 30/04/18 AA ***
				<li><a href="http://www.greyhoundlifeline.co.uk/greyhound-lifeline-newsletter/" title="Join Our Newsletter for up-to-date news and events">Newsletter</a></li>
-->
<!--
				<li><a href="http://www.greyhoundlifeline.co.uk/feed/" onclick="target='_blank'" title="Subscribe to the greyhound Lifeline RSS Feed">RSS Feed</a></li>
-->
				<li><a href="https://www.greyhoundlifeline.co.uk/contact/" title="Contact Greyhound Lifeline">Contact</a></li>
			</ul>
		</div>

			<?php
				/* A sidebar in the footer? Yep. You can can customize
				 * your footer with three columns of widgets.
				 */
				get_sidebar( 'footer' );
			?>

		<div id="footer-bottominfo">
			<ul>
				<li>&copy; <?php echo date("Y"); ?> <a href="https://www.greyhoundlifeline.co.uk/" title="Adopt a Greyhound from Greyhound Lifeline">Greyhound Lifeline</a> - Finds loving homes for greyhounds and is run entirely by volunteers (Registered Charity number 1173175)</li>
				<!--<li class="ghlright"><a href="https://uk.linkedin.com/in/kevinjaques" onclick="target='_blank'" title="Contact Kev Jaques Today">Kev Jaques</a></li>-->
			</ul>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

<script type="text/javascript">
$(document).ready(function() {

	$('.slideshow ul') 
	.after('<div id="greyhound-nav">') 
	.cycle({ 
		fx:     'scrollLeft',
		speed:  'slow',
		timeout: 6000,
		pager:  '#greyhound-nav'
	});

	$('#topnotifierbarholder ul') 
	.after('<div id="ghllatest-nav">') 
	.cycle({ 
		fx:     'fade',
		speed:  'slow',
		timeout: 5000,
		pager:  '#ghllatest-nav'
	});
	
	$('.featuredslideshow ul')
			.after('<div id="featured-greyhound-nav">') 
			.cycle({ 
			fx:     'scrollLeft',
			speed:  'slow',
			timeout: 7000,
			pager:  '#featured-greyhound-nav'
	});
	
});
</script>

<?php
	if ( function_exists( 'yoast_analytics' ) ) {
		yoast_analytics();
	}
?>

<?php //echo "\n".'<!-- '.get_num_queries().' queries in '; ?> <?php //timer_stop(1); echo ' seconds -->'; ?>
</body>
</html>