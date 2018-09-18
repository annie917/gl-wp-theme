<?php
/**
 * Template Name: Greyhound Gallery Template
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
					<em>Greyhound Lifeline Greyhound Gallery</em>
					<img id="newsposticon" src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/themes/greyhoundlifeline/images/icons/view-icon.png" width="89" height="89" alt="View Greyhound Gallery"/>
					<p>
						These Greyhounds need caring homes. Please see adoption details and contact us to make an appointment to view any greyhound.
						<br/>
						<span class="smallfont">NOTE: Images not for use without permission!</span>
					</p>
				</div>

				<div id="maingreyhoundgallery">
					<?php
						$category_name = get_the_category_by_ID(18);
						$category_link = get_category_link(18);
					?>
					<h1><a href="<?php echo $category_link; ?>" title="View this Category"><?php echo $category_name; ?></a></h1>
					<?php get_greyhound_featured(); ?>
					<?php pbd_image_gallery(18); ?>

				</div>

				<?php get_endpageshare(); ?>

			</div><!-- #content -->
			<?php get_sidebar(); ?>
		</div><!-- #primary -->



<?php get_footer(); ?>