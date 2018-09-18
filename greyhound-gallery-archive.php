<?php
/**
 * Template Name: Greyhound Gallery Archive Template
 * Description: A Page Template that adds a sidebar to pages
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<div id="view-greyhound-gallery-archivepg">
			<h3 class="widget-title">Greyhound Gallery</h3>
			<ul>
				<li>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>greyhound-gallery/" title="View the Greyhound Lifeline Greyhound Gallery">VIEW GREYHOUND GALLERY <span>&raquo;</span></a>
				</li>
			</ul>
		</div>
	
		<div id="primary">
			<div id="archive-gallery-content" role="main">
				<div class="post-date">
					<div class="month"><?php echo date("M") ?></div>
					<div class="day"><?php echo date("d") ?></div>
				</div>
				<div id="hdrstrapwide">
					<em>Greyhound Lifeline Archive Gallery</em>
					<img id="newsposticon" src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/themes/greyhoundlifeline/images/icons/view-icon.png" width="89" height="89" alt="View Greyhound Gallery"/>
					<p>
						We couldn't let our old gallery go to waste, so here it is for your viewing pleasure.
						<br/>
						<span class="smallfont">NOTE: Images not for use without permission!</span>
					</p>
				</div>

				<div id="archivemaingreyhoundgallery">

				<iframe id="gallery-archive" src="http://www.greyhoundlifeline.co.uk/greyhound-galleries/" seamless="seamless" name="gallery-archive" height="100%" width="100%"></iframe>

				</div>

				<?php get_endpageshare(); ?>

			</div><!-- #content -->
			<?php //get_sidebar(); ?>
		</div><!-- #primary -->

<?php get_footer(); ?>