<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

				<?php the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php comments_template( '', true ); ?>

				<?php if ($post->post_name=="contact") { ?>
				<div id="please-comment">
					<p>
					<em class="smallfont">We don't like spam either, please see our <a href="<?php echo esc_url( home_url( '/' ) ); ?>privacy-policy/" onclick="target='_blank'" title="See the Greyhound Lifeline Privacy Policy">privacy policy</a></em>
					</p>
				</div>
				<?php } ?>
			</div><!-- #content -->
			<?php get_sidebar(); ?>
		</div><!-- #primary -->

<?php get_footer(); ?>