<?php
/**
 * Template Name: Greyhound Shop Template
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
					<em>Greyhound Merchandise</em>
					<img id="newsposticon" src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/themes/greyhoundlifeline/images/icons/view-icon.png" width="89" height="89" alt="View Greyhound Merchandise"/>
					<p>
						All profits go to support the greyhounds.
					</p>
					<p>
						We are now able to offer mail order on certain products.  Kibble is ONLY available to buy in person.
					</p>
					<p>
						If you would like to purchase selected items through online shopping, please send an email to enquiries@greyhoundlifeline.co.uk, we will respond with your total, including P&P.  You will also be sent an online invoice to pay for your goods in full before we send you your goods.
					</p>
				</div>

				<div id="maingreyhoundgallery">
					<?php
						$category_name = get_the_category_by_ID(9);
						$category_link = get_category_link(9);
					?>
					<h1><a href="<?php echo $category_link; ?>" title="View this Category"><?php echo $category_name; ?></a></h1>
					
					<?php shop_gallery(9); ?>

				</div>

				<?php get_endpageshare(); ?>

			</div><!-- #content -->
			<?php get_sidebar(); ?>
		</div><!-- #primary -->



<?php get_footer(); ?>