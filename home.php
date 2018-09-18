<?php
/**
 * Template Name: Homepage Template
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
					<em>Latest News at Greyhound Lifeline</em>
					<img id="newsposticon" src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/themes/greyhoundlifeline/images/icons/newspost.png" width="85" height="89" alt="News and Updates"/>
					<p>
						Greyhound Lifeline like to keep you informed of various events and happenings. Please check this page frequently as it is updated often.
					</p>
				</div>
				
				<?php //show the latest news post only here
					$my_query = new WP_Query('category_name=news&posts_per_page=1'); ?>
				<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
				<!-- Do special_cat stuff... -->
				<?php endwhile; ?>

				<?php //get_template_part( 'content', 'page' ); 
					get_template_part( 'content', 'single' );
					//comments_template();
					//wp_list_comments( $args );
				?>
				<div id="special-post-comments">
					<p>
						This post currently has
						<?php comments_number( 'no comments', 'one comment', '% comments' ); ?>.
						<a href="<?php comments_link(); ?>" title="Read Comments or Comment on <?php the_title_attribute(); ?>">
							View comments or comment on this post &rsaquo;
						</a>
					</p>

					<div id="shareaholic-footer-buttonset">
						<?php 
							if(!is_page(array('privacy-policy','contact', 'terms-and-conditions', 'sitemap', 'greyhound-resources-links')))
							{
								if(function_exists('selfserv_shareaholic')) { selfserv_shareaholic(); }
							}
						?>
					</div>
					<div class="lbvcb"></div>
				</div>

				<?php //show the latest general information post only here
					$my_query = new WP_Query('category_name=information&name=general-information&posts_per_page=1'); ?>
				<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
				<!-- Do special_cat stuff... -->
				<?php endwhile; ?>

				<?php get_template_part( 'content', 'page' ); ?>
				
				<?php get_endpageshare(); ?>
				<?php ghl_get_events(5); ?>
			</div><!-- #content -->
			<?php get_sidebar(); ?>
		</div><!-- #primary -->

<?php get_footer(); ?>