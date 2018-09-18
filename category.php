<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); 

?>

		<section id="primary">
			<div id="content" role="main">
				<div class="post-date">
					<div class="month"><?php echo date("M") ?></div>
					<div class="day"><?php echo date("d") ?></div>
				</div>
			<?php if ( have_posts() ) : ?>

					<?php
						//kj need to split this out slightly different if its the ghl blog posts (not main site content)
						//treat the blog more like a category with sub cats, posts ala pretty much as normal
						$blogcat = strtolower(single_cat_title( '', false ));
						if ($blogcat=="blog" || $blogcat=="greyhound lifeline blog")
						{
						?>
							<header class="entry-header">
								<h1 class="entry-title"><?php echo single_cat_title( '', false ); ?></h1>
							</header>
							<div id="hdrcustom">
								<h3>
									<img src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/themes/greyhoundlifeline/images/icons/newspost.png" alt="Greyhound Information" title="Greyhound Information" width="85" height="89" class="alignleft size-full ghlimg" />
									Welcome to the Greyhound Lifeline Blog
								</h3>
								<p>
									Here you will find latest blog entries from a number of our contributors - just select the blog post or author you want to read and enjoy!
								</p>
							</div>
						<?php
						}
						else
						{
						?>
						<header class="page-header">
							<h1 class="page-title"><?php
								printf( __( 'Category Archives: %s', 'twentyeleven' ), '<span>' . single_cat_title( '', false ) . '</span>' );
							?></h1>
						</header>
						<?php
						}
						$category_description = category_description();
						if ( ! empty( $category_description ) )
							echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
					?>

				<div id="ghlseparatorline"></div>

				<?php twentyeleven_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php twentyeleven_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</div><!-- #content -->
			<?php get_sidebar(); ?>
		</section><!-- #primary -->

<?php get_footer(); ?>
