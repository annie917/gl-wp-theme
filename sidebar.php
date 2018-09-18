<?php
/**
 * The Sidebar containing the main widget area.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

$options = twentyeleven_get_theme_options();
$current_layout = $options['theme_layout'];

if ( 'content' != $current_layout ) :
?>
   <!--New Donate Button.  Ideally would go in functions.php, but don't have access-->
	  <div id="donate-button">
		  <h3 class="widget-title">Donate to GL</h3>
		  <ul>
			  <li>
				  <a href="<?php echo esc_url( home_url( '/' ) ); ?>donate/" title="Donate to greyhound lifeline">DONATE <span>&raquo;</span></a>
			  </li>
		  </ul>
	  </div>
		<?php
			get_view_greyhound_gallery_button();
			//get_greyhound_donation();
			get_greyhound_showcase();
			get_view_greyhound_gallery_archive_button();
		?>
		<!--div id="view-greyhound-gallery-archive" class="ghlfr">
			<ul>
				<li>
					<a href="http://www.greyhoundlifeline.co.uk/greyhound-lifeline-archive-gallery/" title="View the Greyhound Lifeline Greyhound Archive Gallery">VIEW ARCHIVE GALLERY <span>&raquo;</span></a>
				</li>
			</ul>
		</div-->

		<div id="secondary" class="widget-area" role="complementary">
			<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

				<aside id="archives" class="widget">
					<h3 class="widget-title"><?php _e( 'Archives', 'twentyeleven' ); ?></h3>
					<ul>
						<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
					</ul>
				</aside>

				<aside id="meta" class="widget">
					<h3 class="widget-title"><?php _e( 'Meta', 'twentyeleven' ); ?></h3>
					<ul>
						<?php wp_register(); ?>
						<li><?php wp_loginout(); ?></li>
						<?php wp_meta(); ?>
					</ul>
				</aside>

			<?php endif; // end sidebar widget area ?>
			<?php 
				//ready for donation info to come through
				//get_greyhound_donation();
			?>
		</div><!-- #secondary .widget-area -->
<?php endif; ?>