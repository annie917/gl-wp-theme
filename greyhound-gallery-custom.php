<?php
/**
 * Template Name: Greyhound Gallery Custom Template
 * Description: A Page Template that adds a custom photo gallery to pages
 *
 * @package WordPress
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">
				<div class="post-date">
					<div class="month"><?php echo date("M") ?></div>
					<div class="day"><?php echo date("d") ?></div>
				</div>

				<?php
						//get custom field customgallery with value category name (slug doesnt want to play ball nicely, you would have thought wp would make slug better used)

						//customgallery

						$custom_gallery_field = get_post_custom();
						//print_r($custom_gallery_field);
						//echo "gal=".$custom_gallery_field[customgallery][0];

						$gallname = str_replace(' ', '-', $custom_gallery_field[customgallery][0]);

						$idObj = get_category_by_slug($gallname);
						$galleryid = $idObj->term_id;

						$category_name = get_the_category_by_ID($galleryid);
						$category_link = get_category_link($galleryid);
						
						$hasdescription = "Please also see the main greyhound gallery for greyhounds looking for a forever home.";
						$lenhasdescription = $custom_gallery_field[customgallerydescription][0];
						if (strlen($lenhasdescription)>0)
						{
							$hasdescription = $lenhasdescription;
						}
					?>

				<div id="hdrstrap">
					<em>Gallery - <?php echo $category_name ?></em>
					<img id="newsposticon" src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/themes/greyhoundlifeline/images/icons/view-icon.png" width="89" height="89" alt="View Greyhound Gallery"/>
					<p>
						<?php echo $hasdescription; ?>
						<br/>
						<span class="smallfont">NOTE: Images not for use without permission!</span>
					</p>

				</div>

				<div id="maingreyhoundgallery">

					<h1><a href="<?php echo $category_link; ?>" title="View this Category"><?php echo $category_name; ?></a></h1>
					<?php pbd_image_gallery($galleryid); ?>

				</div>

				<?php get_endpageshare(); ?>

			</div><!-- #content -->
			<?php get_sidebar(); ?>
		</div><!-- #primary -->



<?php get_footer(); ?>