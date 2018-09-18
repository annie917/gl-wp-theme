<?php
/**
 * Template Name: Sidebar Template
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

				<?php the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php //comments_template( '', true ); ?>
				<div class="shareaholic-like-buttonset">
					<h4>Please share with your friends</h4>
					<ul>
						<li><a rel="nofollow" title="Like this page on Facebook" class="shareaholic-fblike" shr_layout="standard" shr_showfaces="false"  shr_send = "false" shr_action="like" shr_href="http://www.greyhoundlifeline.co.uk/"></a></li>
						<li><a rel="nofollow" title="Share this page on Facebook" class="shareaholic-fbsend" shr_href="http://www.greyhoundlifeline.co.uk/"></a></li>
						<li><a rel="nofollow" class="shareaholic-googleplusone" shr_size="standard" shr_count="true" shr_href="http://www.greyhoundlifeline.co.uk/"></a></li>
					</ul>
				</div>

			</div><!-- #content -->
			<?php get_sidebar(); ?>
		</div><!-- #primary -->

<?php get_footer(); ?>



