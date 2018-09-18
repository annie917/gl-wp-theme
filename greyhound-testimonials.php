<?php
/**
 * Template Name: Greyhound Testimonials Template
 * Description: A Page Template that adds a sidebar to pages
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">
				<div class="post-date">
					<div class="month"><?php echo date("M") ?></div>
					<div class="day"><?php echo date("d") ?></div>
				</div>
				<div id="hdrstrap">
					<em>Greyhound Lifeline Testimonials</em>
					<img id="newsposticon" src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/themes/greyhoundlifeline/images/icons/iinformationpost.png" width="89" height="89" alt="View Greyhound Gallery"/>
					<p>
						Greyhound Lifeline works hard to match greyhounds with owners, these lovely hounds really do appreciate a forever home and make great pets!
					</p>
				</div>

				<div id="maingreyhoundgallery">
					<?php
						$category_name = get_the_category_by_ID(149);
						$category_link = get_category_link(149);
					?>
					<h1><a href="<?php echo $category_link; ?>" title="View this Category"><?php echo $category_name; ?></a></h1>
					<?php ghl_testimonials(149); ?>

				</div>

				<?php get_endpageshare(); ?>

			</div><!-- #content -->
			<?php get_sidebar(); ?>
		</div><!-- #primary -->



<?php get_footer(); ?>