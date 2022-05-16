<?php
/**
 * Twenty Eleven functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, twentyeleven_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentyeleven_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 584;

/**
 * Tell WordPress to run twentyeleven_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'twentyeleven_setup' );

if ( ! function_exists( 'twentyeleven_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override twentyeleven_setup() in a child theme, add your own twentyeleven_setup to your child theme's
 * functions.php file.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To style the visual editor.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links, and Post Formats.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_setup() {

	/* Make Twenty Eleven available for translation.
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Eleven, use a find and replace
	 * to change 'twentyeleven' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentyeleven', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Load up our theme options page and related code.
	require( dirname( __FILE__ ) . '/inc/theme-options.php' );

	// Grab Twenty Eleven's Ephemera widget.
	require( dirname( __FILE__ ) . '/inc/widgets.php' );

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'twentyeleven' ) );

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );

	// Add support for custom backgrounds
	add_custom_background();

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );

	// The next four constants set how Twenty Eleven supports custom headers.

	// The default header text color
	define( 'HEADER_TEXTCOLOR', '000' );

	// By leaving empty, we allow for random image rotation.
	define( 'HEADER_IMAGE', '' );

	// The height and width of your custom header.
	// Add a filter to twentyeleven_header_image_width and twentyeleven_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'twentyeleven_header_image_width', 1000 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'twentyeleven_header_image_height', 375 ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be the size of the header image that we just defined
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Add Twenty Eleven's custom image sizes
	add_image_size( 'large-feature', HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true ); // Used for large feature (header) images
	add_image_size( 'small-feature', 500, 300 ); // Used for featured posts if a large-feature doesn't exist
	
	// Turn on random header image rotation by default.
	//add_theme_support( 'custom-header', array( 'random-default' => true ) );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See twentyeleven_admin_header_style(), below.
	//add_custom_image_header( 'twentyeleven_header_style', 'twentyeleven_admin_header_style', 'twentyeleven_admin_header_image' );

	// ... and thus ends the changeable header business.
	add_image_size('gallery-thumbnail', 150, 150, true);
	add_image_size( 'greyhound-feature', 500, 375 ); // Used for featured greyhounds

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	
	/*register_default_headers( array(
		'wheel' => array(
			'url' => '%s/images/headers/wheel.jpg',
			'thumbnail_url' => '%s/images/headers/wheel-thumbnail.jpg',
			// translators: header image description
			'description' => __( 'Wheel', 'twentyeleven' )
		),
		'shore' => array(
			'url' => '%s/images/headers/shore.jpg',
			'thumbnail_url' => '%s/images/headers/shore-thumbnail.jpg',
			// translators: header image description
			'description' => __( 'Shore', 'twentyeleven' )
		),
		'trolley' => array(
			'url' => '%s/images/headers/trolley.jpg',
			'thumbnail_url' => '%s/images/headers/trolley-thumbnail.jpg',
			// translators: header image description
			'description' => __( 'Trolley', 'twentyeleven' )
		),
		'pine-cone' => array(
			'url' => '%s/images/headers/pine-cone.jpg',
			'thumbnail_url' => '%s/images/headers/pine-cone-thumbnail.jpg',
			// translators: header image description
			'description' => __( 'Pine Cone', 'twentyeleven' )
		),
		'chessboard' => array(
			'url' => '%s/images/headers/chessboard.jpg',
			'thumbnail_url' => '%s/images/headers/chessboard-thumbnail.jpg',
			// translators: header image description
			'description' => __( 'Chessboard', 'twentyeleven' )
		),
		'lanterns' => array(
			'url' => '%s/images/headers/lanterns.jpg',
			'thumbnail_url' => '%s/images/headers/lanterns-thumbnail.jpg',
			// translators: header image description
			'description' => __( 'Lanterns', 'twentyeleven' )
		),
		'willow' => array(
			'url' => '%s/images/headers/willow.jpg',
			'thumbnail_url' => '%s/images/headers/willow-thumbnail.jpg',
			// translators: header image description
			'description' => __( 'Willow', 'twentyeleven' )
		),
		'hanoi' => array(
			'url' => '%s/images/headers/hanoi.jpg',
			'thumbnail_url' => '%s/images/headers/hanoi-thumbnail.jpg',
			//translators: header image description
			'description' => __( 'Hanoi Plant', 'twentyeleven' )
		)
	) );*/
}
endif; // twentyeleven_setup

//if ( ! function_exists( 'twentyeleven_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @since Twenty Eleven 1.0
 */
 
function orgtwentyeleven_header_style() {

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == get_header_textcolor() )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		#site-title,
		#site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo get_header_textcolor(); ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
//endif; // twentyeleven_header_style

if ( ! function_exists( 'twentyeleven_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in twentyeleven_setup().
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg h1,
	#desc {
		font-family: "Helvetica Neue", Arial, Helvetica, "Nimbus Sans L", sans-serif;
	}
	#headimg h1 {
		margin: 0;
	}
	#headimg h1 a {
		font-size: 32px;
		line-height: 36px;
		text-decoration: none;
	}
	#desc {
		font-size: 14px;
		line-height: 23px;
		padding: 0 0 3em;
	}
	<?php
		// If the user has set a custom color for the text use that
		if ( get_header_textcolor() != HEADER_TEXTCOLOR ) :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo get_header_textcolor(); ?>;
		}
	<?php endif; ?>
	#headimg img {
		max-width: 1000px;
		height: auto;
		width: 100%;
	}
	</style>
<?php
}
endif; // twentyeleven_admin_header_style

if ( ! function_exists( 'twentyeleven_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in twentyeleven_setup().
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_admin_header_image() { ?>
	<div id="headimg">
		<?php
		if ( 'blank' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) || '' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) )
			$style = ' style="display:none;"';
		else
			$style = ' style="color:#' . get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) . ';"';
		?>
		<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php }
endif; // twentyeleven_admin_header_image

/**
 * Sets the post excerpt length to 40 words.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */
function twentyeleven_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'twentyeleven_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function twentyeleven_continue_reading_link() {
	return ' <br/><strong><a href="'. esc_url( get_permalink() ) . '" class="ghlfr">' . __( 'Continue reading this post <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) . '</a></strong><br/>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyeleven_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function twentyeleven_auto_excerpt_more( $more ) {
	return ' &hellip;' . twentyeleven_continue_reading_link();
}
add_filter( 'excerpt_more', 'twentyeleven_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function twentyeleven_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= twentyeleven_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'twentyeleven_custom_excerpt_more' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function twentyeleven_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentyeleven_page_menu_args' );

/**
 * Register our sidebars and widgetized areas. Also register the default Epherma widget.
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_widgets_init() {

	register_widget( 'Twenty_Eleven_Ephemera_Widget' );

	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'twentyeleven' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Showcase Sidebar', 'twentyeleven' ),
		'id' => 'sidebar-2',
		'description' => __( 'The sidebar for the optional Showcase Template', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area One', 'twentyeleven' ),
		'id' => 'sidebar-3',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Two', 'twentyeleven' ),
		'id' => 'sidebar-4',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Three', 'twentyeleven' ),
		'id' => 'sidebar-5',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'twentyeleven_widgets_init' );

/**
 * Display navigation to next/previous pages when applicable
 */
function twentyeleven_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentyeleven' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentyeleven' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}

/**
 * Return the URL for the first link found in the post content.
 *
 * @since Twenty Eleven 1.0
 * @return string|bool URL or false when no link is present.
 */
function twentyeleven_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function twentyeleven_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-5' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
}

if ( ! function_exists( 'twentyeleven_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyeleven_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyeleven' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s on %2$s <span class="says">said:</span>', 'twentyeleven' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'twentyeleven' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentyeleven' ); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'twentyeleven' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for twentyeleven_comment()

if ( ! function_exists( 'twentyeleven_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own twentyeleven_posted_on to override in a child theme
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'twentyeleven' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		sprintf( esc_attr__( 'View all posts by %s', 'twentyeleven' ), get_the_author() ),
		esc_html( get_the_author() )
	);
}
endif;

/**
 * Adds two classes to the array of body classes.
 * The first is if the site has only had one author with published posts.
 * The second is if a singular post being displayed
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_body_classes( $classes ) {

	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	if ( is_singular() && ! is_home() && ! is_page_template( 'showcase.php' ) && ! is_page_template( 'sidebar-page.php' ) )
		$classes[] = 'singular';

	return $classes;
}
add_filter( 'body_class', 'twentyeleven_body_classes' );

remove_action('wp_head', 'wp_generator');
/*
function remove_comment_author_class( $classes ) {
	foreach( $classes as $key => $class ) {
		if(strstr($class, "comment-author-")) {
			unset( $classes[$key] );
		}
	}
	return $classes;
}
add_filter( 'comment_class' , 'remove_comment_author_class' );
*/

/* kj remove theme options to reduce confusion and any settings issues, main theme stuff already handled */
add_action('admin_init', 'remove_theme_menus');
function remove_theme_menus() {
	global $submenu;	
//print_r($submenu); //debug
	unset($submenu['themes.php'][5]);
	unset($submenu['themes.php'][15]);
	unset($submenu['themes.php'][2]);
	unset($submenu['themes.php'][13]);
	unset($submenu['themes.php'][2]);
	unset($submenu['themes.php'][12]);
	unset($submenu['themes.php'][2]);
	unset($submenu['themes.php'][11]);
	unset($submenu['themes.php'][2]);
	unset($submenu['themes.php'][14]);
}

function login_logo() {
    echo '<style type="text/css">
        #login h1 a { background: url('.get_bloginfo('template_directory').'/images/headers/greyhound-lifeline-logo-admin.png) !important; width: 603px; height: 126px; margin-left: -150px;}
    </style>';
}
add_action('login_head', 'login_logo');

function admin_logo() {
    echo '<img id="header-logo" src="'.get_bloginfo('template_directory').'/images/headers/greyhound-lifeline-logo-admin.png" alt="" width="600" height="56" />';
}
add_action('header-logo', 'admin_logo');




add_filter('show_admin_bar', '__return_false');

add_filter('login_errors',create_function('$a', "return null;"));

// Custom Default Avatar
 if ( !function_exists('addgravatar') ) {
    function addgravatar( $avatar_defaults ) {
    $myavatar = get_bloginfo('template_directory').'/images/custom-gravatar.jpg'; //=&gt; Change path to your custom avatar
    $avatar_defaults[$myavatar] = 'Greyhound Lifeline Avatar'; //=&gt; Change to your avatar name
    return $avatar_defaults;
    }
 add_filter( 'avatar_defaults', 'addgravatar' );
}

//need to grab 7 random greyhounds from homes needed area
function get_greyhound_showcase(){

	global $post;
	$shfeaturedID = get_post_thumbnail_id($post->ID);
 
	$args = array(
		'numberposts' => 7,
		'category_name' => 'greyhounds needing homes',
        'orderby' => 'rand'
    );
    $shimages = get_posts($args);

	
?>
<div id="slideshowholder">
	<h3 class="widget-title">Recent Greyhounds</h3>
	<div class="slideshow">
		<ul>
		<?php
		
			foreach($shimages as $shimage) { 
			?>
				<li>				
					<a href="<?php echo get_permalink($shimage->ID); ?>" title="<?php echo $shimage->post_title; ?> is looking for a forever home">
						<?php 
							echo get_the_post_thumbnail( $shimage->ID, array(150,150), 'gallery-thumbnail');
						?>
						<span>View <?php echo $shimage->post_title; ?> &rsaquo;</span>
					</a>
				</li>
	 
				 <?php
				}
			?>		
		</ul>
	</div>
</div>
<?php
//wp_reset_query();
/*
not finished yet, need to add some greyhounds and taxonomies
	<?php 
		$args = array(
			'tax_query' => array(
				array(
					'taxonomy' => 'greyhoundsneedinghomes',
					'field' => 'slug'
				),
				array (
					'orderby' => 'rand',
					'posts_per_page' => '7'
				)
			)
		);

		$recent = new WP_Query( $args ); while($recent->have_posts()) : $recent->the_post();?>
		<li>
			<a href="<?php the_permalink() ?>" rel="bookmark" title="View Greyound <?php the_title(); ?>">
				<img src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/themes/greyhoundlifeline/images/greyhounds/greyhounds-needing-homes/thb_greyhound-black-pippa.jpg" alt="<?php the_title(); ?>" width="160" height="107"/>
				<span>View <?php the_title(); ?> &raquo;</span>
			</a>
		</li>
		<?php endwhile; ?>
		
		<?php wp_reset_postdata(); ?>
*/


}

//same slideshow as above but for the gallery page to show featured greyhounds
function get_greyhound_featured()
{
	global $post;
	$shfeaturedID = get_post_thumbnail_id($post->ID);

	$args = array(
		'numberposts' => 5,
		'category_name' => 'greyhounds needing homes',
		'tag' => 'featured',
		'post_status' => 'publish',
		'orderby' => 'rand'
    );

    $featuredshimages = get_posts($args);
	//print_r($featuredshimages);
	
	$attachments = get_children( $args );
	
?>

<div id="featuredslideshowholder">
	<h3 class="widget-title">Featured Greyhounds</h3>	
	<div class="featuredslideshow">
		<ul>
		<?php
			
			foreach($featuredshimages as $featuredshimage) { 
			$thisfeaturedgreyhoundstatus ='';
			$greytags = array();
			?>
				<li>				
					<a href="<?php echo get_permalink($featuredshimage->ID); ?>" title="<?php echo $featuredshimage->post_title; ?> is looking for a forever home">
						<?php 
							$thumbnail_id = get_post_thumbnail_id($featuredshimage->ID);
							
							//echo get_the_post_thumbnail( $featuredshimage->ID, array(500,375), 'medium-feature');
							
							$thumbnail_object = get_post($thumbnail_id);

							$posttags = get_the_tags($featuredshimage->ID);
							foreach($posttags as $tagslug)
							{
								$greytags[] = $tagslug->slug;
							}

							if(in_array( 'reserved', $greytags ))
							{
								$thisfeaturedgreyhoundstatus = '<span class="reserved-full-size-feature">&nbsp;</span>';
							}
							else if(in_array( 'available', $greytags ))
							{
								$thisfeaturedgreyhoundstatus = '<span class="available-full-size-feature">&nbsp;</span>';
							}
							
							/*else if(in_array( 'homed', $greytags ))
							{
								$thisfeaturedgreyhoundstatus = '<span class="homed-full-size-feature">&nbsp;</span>';
							}
							
							
							<img src="<?php echo $thumbnail_object->guid; ?>" width="500" height="375" alt="<?php echo $thumbnail_object->post_title; ?>"/>
							*/
						?>
						<?php echo $thisfeaturedgreyhoundstatus; ?>

						<?php //$resizedImage = vt_resize('', $featuredshimage->ID, 500, 375, true);
								echo get_the_post_thumbnail( $featuredshimage->ID, array(500,375), 'greyhound-feature');
								//echo get_the_post_thumbnail( $resizedImage, array(500,375), 'greyhound-feature');
						?>
						<!--img src="<?php //echo get_the_post_thumbnail( $featuredshimage->ID, array(500,375), 'medium-feature'); ?>" width="500" height="375" alt="<?php //echo $thumbnail_object->post_title; ?>"/-->
						
						<span>View <?php echo $featuredshimage->post_title; ?> &rsaquo;</span>
					</a>
				</li>
	 
				 <?php
				}
			?>		
		</ul>
	</div>
</div>

<?php
//wp_reset_query();
}

//need to grab 5 latest posts from everywhere
function get_latest_postbar(){
?>

<div id="topnotifierbarholder">
	<label>Latest:</label>
	<ul>
		<?php $recentposts = new WP_Query("showposts=5&orderby=modified"); while($recentposts->have_posts()) : $recentposts->the_post();?>
			<li><a href="<?php the_permalink() ?>" rel="bookmark" title="View latest post - <?php the_title(); ?>"><?php the_title(); ?></a></li>
		<?php endwhile; ?>		
	</ul>
	<?php wp_reset_postdata(); // cannot be removed ?>
</div>

<?php
}
//wp_reset_query();

//rather than splodging this code everywhere, bosh it function style
function get_endpageshare(){
?>
	<div class="shareaholic-like-buttonset">
		<h4>Please share with your friends</h4>
		<?php echo do_shortcode('[shareaholic app="share_buttons" id="22189790"]'); ?>
		<!--ul>
			<li><a rel="nofollow" title="Like this page on Facebook" class="shareaholic-fblike" shr_layout="standard" shr_showfaces="false"  shr_send = "false" shr_action="like" shr_href="http://www.greyhoundlifeline.co.uk/"></a></li>
			<li><a rel="nofollow" title="Share this page on Facebook" class="shareaholic-fbsend" shr_href="http://www.greyhoundlifeline.co.uk/"></a></li>
			<li><a rel="nofollow" class="shareaholic-googleplusone" shr_size="standard" shr_count="true" shr_href="http://www.greyhoundlifeline.co.uk/"></a></li>
		</ul-->
	</div>

<?php
}
	
/*
add to blog page to show all the authors

Just as we mentioned above that for multi-authored blogs, Its often useful to put authors description in the end of the respective post. 
And its even more useful for readers to put the list of all the blog authors on your WordPress blog if anyone wants to follow any 
specific author. You just need to place following code anywhere you want to display the list.

    <ul>
		<?php wp_list_authors('exclude_admin=0&optioncount=1&show_fullname=1&hide_empty=1'); ?>
    </ul>
this is to add to each post
	<div class="author-box">
   <div class="author-pic"><?php echo get_avatar( get_the_author_email(), '80' ); ?></div>
   <div class="author-name"><?php the_author_meta( "display_name" ); ?></div>
   <div class="author-bio"><?php the_author_meta( "user_description" ); ?></div>
</div>

You also can tweak the parameters to adjust the display.

    exclude_admin: 0 (include the admins name in the authors list) / 1 (exclude the admins name from the list)
    optioncount : 0 (No post count against the authors name) / 1 (display post count against the authors name)
    show_fullname : 0 (display first name only) / 1 (display full name of the author)
    hide_empty : 0 (display authors with no posts) / 1 (display authors who have one or more posts)


*/

/*replace default email address to a constant one*/
function mail_from() {
	$emailaddress = 'enquiries@greyhoundlifeline.co.uk';
	return $emailaddress;
}

function mail_from_name() {
	$sendername = "GreyhoundLifeline.co.uk - Team";
	return $sendername;
}

add_filter('wp_mail_from','mail_from');
add_filter('wp_mail_from_name','mail_from_name');

/*hide update warning except for admins*/
/*
function wp_hide_update() {
	global $current_user;
	get_currentuserinfo();

	if ($current_user->ID != 1) { // only admin will see it
		remove_action( 'admin_notices', 'update_nag', 3 );
	}
}
add_action('admin_menu','wp_hide_update');*/

/* BUTTONS */

function get_donate_button()
{
    ?>
    <div id="donate-button" class="gl-button clearfix">
      <h3 class="widget-title">Donate to Us</h3>
        <ul>
            <li>
              <a href="<?php echo esc_url( home_url( '/' ) ); ?>donate/" title="Donate to greyhound lifeline">DONATE <span>&raquo;</span></a>
            </li>
        </ul>
    </div>
<?php
}

function get_shop_button()
{
    ?>
    <div id="shop-button" class="gl-button clearfix">
      <h3 class="widget-title">Online Shop</h3>
        <ul>
            <li>
              <a href="<?php echo esc_url( home_url( '/' ) ); ?>greyhound-merchandise/" title="Visit our shop">SHOP <span>&raquo;</span></a>
            </li>
        </ul>
    </div>
<?php
}

function get_view_greyhound_gallery_button()
{
?>
	<div id="view-greyhound-gallery", class="gl-button">
		<h3 class="widget-title">In Need of a Home</h3>
		<ul>
			<li>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>greyhound-gallery/" title="View the Greyhound Lifeline Greyhound Gallery">GREYHOUND GALLERY <span>&raquo;</span></a>
			</li>
		</ul>
	</div>
<?php
}

function get_help_button()
{
?>
	  <div id="help-button", class="gl-button">
		  <h3 class="widget-title">Help our Hounds</h3>
		  <ul>
			  <li>
				  <a href="<?php echo esc_url( home_url( '/' ) ); ?>support/" title="Help greyhound lifeline">How to Help <span>&raquo;</span></a>
			  </li>
		  </ul>
	  </div>

<?php
}

function get_view_greyhound_gallery_archive_button()
{
?>
	<div id="view-greyhound-gallery-homed", class="gl-button">
	<h3 class="widget-title">On the Sofa</h3>
		<ul>
			<li>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>greyhound-gallery/greyhound-gallery-homed-greyhounds/" title="View the Greyhound Lifeline Greyhound Homed Gallery">HOMED HOUNDS <span>&raquo;</span></a>
			</li>
		</ul>
	</div>
<?php
}

function get_testimonial_button()
{
?>
    <div id="testimonial-button", class="gl-button">
		<ul>
			<li>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>contact/" title="Add Your Testimonial to Greyhound Lifeline">ADD YOUR TESTIMONIAL <span>&raquo;</span></a>
			</li>
		</ul>
	</div>
 
<?php    
}

function get_general_information()
{
?>
 
  <div id="general-information" class="clearfix">
    <h1 class="entry-title"><a href="https://www.greyhoundlifeline.co.uk/information/general-information/" title="Permalink to General Information" rel="bookmark">General Information</a></h1>
    <h4>Join Greyhound Lifeline on Facebook</h4>
    <a href="https://www.facebook.com/pages/Greyhound-Lifeline/140115126025085" rel="nofollow" onclick="target='_blank'" title="Join Greyhound Lifeline on Facebook">Greyhound Lifeline are on Facebook</a>, please come and visit us there.
    <h4>Choosing a Boy or Girl Greyhound</h4>
    <a href="https://www.greyhoundlifeline.co.uk/adopt/choosing-boy-girl-greyhound/" title="Choosing a Boy or Girl Greyhound">Boy or Girl</a> highlights the common problem in greyhound rescue and re homing of finding homes for the greyhound males. Perhaps after reading through the page you might give equal consideration to adopting a boy. 	
  </div>

<?php
}

add_theme_support( 'post-thumbnails' );

/*automatically uses images from posts to create a gallery*/

function isint( $mixed )
{
    return ( preg_match( '/^\d*$/'  , $mixed) == 1 );
}

function pbd_image_gallery($catid) {
	global $post, $wpdb;
//echo "catid=".$catid;
	//print_r($post);
 //echo "got here at img gall";
	$limitImages = 9; // How many images in total to show after the post?
	$perRow = 3; // How many images should be in each row?
 
	//$featuredID = get_post_thumbnail_id($post->ID);
 
	// Build our query to return the images attached to this post.
	// We query one image more than we intend to show to see if there extra images that won't fit into the gallery here.
    /*$args = array(
		'category_name' => 'greyhounds needing homes',
        'orderby' => 'DESC',
		'post_status' => 'publish',
        'numberposts' => $limitImages + 1
    );
	*/
// 'post_parent' => $post->ID,
//'order' => 'DESC',
//'post_type' => 'attachment',
//'post_mime_type' => 'image',
//'numberposts' => $limitImages + 1,
//'orderby' => 'menu_order',
    //$images = get_posts($args);

//basic list
/*
	foreach( $images as $post ) :	setup_postdata($post); ?>
	<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
	<?php endforeach;
*/

	//echo "countimg=".count($images);
//print_r($images);
	// Assuming we found some images, display them.
	//if(count($images)==0){ 
	if(1==0){ 
	//echo "yep got em=".$limitImages;
	?>
	 
	<div id="gimages1">
		<h1><a href="<?php echo home_url( '/' ); ?>adopt/greyhounds-needing-homes/" title="Adopt a greyhound today">Greyhounds Needing Homes</a></h1>
		<ul>
			<?php
			// We'll use the $count here to keep track of what image we're on.
			$count = 1;
	 
			// Print each individual image.
			foreach($images as $image) { 
			//print_r($image);
			//the_category( ' ', 0, $image->ID );
			//echo "\nblashstart";
			//echo "and=".get_the_post_thumbnail( $image->ID, 'thumbnail');
			//echo "\nblashend";
				// Only show the image if it is within our limit.
				if($count <= $limitImages){?>
				<li<?php 
				
				
					// Each end image in a row gets the "lastimage" class added. 
					if($count % $perRow == 0) { echo ' class="lastimage"'; } ?>>
					<a href="<?php echo get_permalink($image->ID); ?>" title="<?php echo $image->post_title; ?> is looking for a forever home">
						<?php 
							//echo wp_get_attachment_image($image->ID, 'gallery-thumbnail'); 
							//get_the_post_thumbnail( $image->ID, 'thumbnail');
							echo get_the_post_thumbnail( $image->ID, array(150,150), 'gallery-thumbnail');
							//print_r($image);
						?>
						<span>View <?php echo $image->post_title; ?> &rsaquo;</span>
					</a>
				</li>
	 
				 <?php
				}
			 $count++;
			 } ?>
		</ul>
<?php //insert more code here, needs pagination ?>
	</div>
 

<?php 
	}
	
	$imagesPerPage = 9;
	$getnewimagesPerPage = 0;
	
	// Standard post output
	
	// Work out how many pages we need and what page we are currently on
	//$catid = 18;
	$imageCount = $wpdb->get_var("SELECT COUNT FROM {$wpdb->prefix}term_taxonomy WHERE taxonomy = 'category' AND TERM_ID = $catid");

//echo "imageCount=".$imageCount;

	$pageCount = ceil($imageCount / $imagesPerPage);
	
	$currentPage = intval($_GET['gallerypage']);
	if(!($currentPage>=1 && $currentPage <=200))
	{
		$currentPage = 1;
	}
	if ( empty($currentPage) || $currentPage<=0 ) $currentPage=1;

	$maxImage = $currentPage * $imagesPerPage;
	$minImage = ($currentPage-1) * $imagesPerPage;
	if($currentPage==1)
	{
		$getnewimagesPerPage = 0;
	}
	else
	{
		//org $getnewimagesPerPage = $getnewimagesPerPage + $imagesPerPage;
		$getnewimagesPerPage = $imagesPerPage * ($currentPage-1);
	}
//echo "currentPage=".$currentPage;
//echo "getnewimagesPerPage=".$getnewimagesPerPage."<br/>";
		// Define some default options
	$options = array(
		//'category_name' => 'greyhounds needing homes',
		//'category-slug' => 'greyhounds-needing-homes',
		'cat' => $catid,
		'orderby' => 'modified',
		'order' => 'DESC',
		'offset' => $getnewimagesPerPage,
		'post_status' => 'publish',
        'numberposts' => $imagesPerPage
				
	);
	
	$images2 = get_posts($options);
//print_r($images2);
	if ($pageCount >= 1)
	{
		$page_link= get_permalink();
		$page_link_perma= true;
		if ( strpos($page_link, '?')!==false )
			$page_link_perma= false;

		$gplist= '<div class="gallery_pages_list">'.__('<strong>Gallery Pages '.$currentPage.' of '.$pageCount.'</strong>').'<ul>';
		for ( $j=1; $j<= $pageCount; $j++)
		{
			if ( $j==$currentPage )
				$gplist .= '<li><strong class="current_gallery_page_num"> '.$j.' </strong></li>';
			else
				$gplist .= '<li><a href="'.$page_link. ( ($page_link_perma?'?':'&amp;') ). 'gallerypage='.$j.'" title="View more pages in this gallery">'.$j.'</a></li>';
		}
		$gplist .= '</ul></div>';
	}
	
	$output .= "\n<br style='clear: both;' />$gplist\n";
	//echo $output;	
	// If we've got this far then we must have some attachments to play with!
	//echo 'Gallery Here - Page '. $currentPage. ' of '. $pageCount.'</div>';
	
	$k = $minImage;
	//echo "minImage=".$minImage."<br/>";
	//echo "maxImage=".$maxImage."<br/>";
	
	//make it dynamic as we want to view multiple galleries
	//$category_name = get_the_category_by_ID($catid);
	//$category_link = get_category_link($catid);
	//<h1><a href="<?php echo $category_link; " title="View this Category"><?php echo $category_name; </a></h1>
	
	?>
	<div id="gimages">

		<ul>
	<?php
	foreach($images2 as $imagegal) {
		if ($k >= $minImage && $k < $maxImage) {
		//echo "k=".$k;
		?>
				<li<?php 
					// Each end image in a row gets the "lastimage" class added. 
					if($k % $perRow == 0) { echo ' class="lastimage"'; } 
					?>>
					<a href="<?php echo get_permalink($imagegal->ID); ?>" title="<?php echo $imagegal->post_title; ?> is looking for a forever home">
						<?php 
							//echo wp_get_attachment_image($image->ID, 'gallery-thumbnail'); 
							//get_the_post_thumbnail( $image->ID, 'thumbnail');
							echo get_the_post_thumbnail( $imagegal->ID, array(150,150), 'gallery-thumbnail');
							//print_r($imagegal);
						?>
						<span>View <?php echo $imagegal->post_title; ?> &rsaquo;</span>
					</a>
				</li>
	 <?php
		}
		$k=$k+1;
	}

	?>
		</ul>
	</div>

<?php
	echo $output;
}
//wp_reset_query();

/*remove website url from comment form as we're looking for genuine people commenting and asking questions
we dont want to cater for spammers!!
*/
add_filter('comment_form_default_fields', 'url_filtered');
function url_filtered($fields)
{
  if(isset($fields['url']))
   unset($fields['url']);
  return $fields;
}


/*automatically add in specific text into every post direct into the editor*/
/*
add_filter( 'default_content', 'my_editor_content' );
function my_editor_content( $content ) {
	$content = "If you enjoyed this post, make sure to subscribe to my rss feed.";
	return $content;
}
*/
/*automatically add in specific text into every post direct into the post footer*/
function insertFootNote($content) {
	//global $post;
        if((!is_feed() && !is_home()) && (is_single() || is_page()) ) {
				//kj april 2012 - add heart murmur page link via custom field hasheartmurmur value = dogsname
				$custom_fields = get_post_custom();
				//print_r($custom_fields);
				//echo "hasheartmurmur=".$custom_fields[hasheartmurmur][0];
				$hasheartmurmur = "";
				$hasheartmurmur = ucwords(trim($custom_fields[hasheartmurmur][0]));
				if(strlen($hasheartmurmur)>2)
				{
					$contactcontent.= '<div class="heartmurmur">';
					$contactcontent.= '		<p>
											'.$hasheartmurmur.' has a heart murmur, however, please don\'t overlook '.$hasheartmurmur.' for adoption.
											<br/>
											Please look at our information about 
											<a href="https://www.greyhoundlifeline.co.uk/information/big-hearted-greyhounds/" title="These greyhounds still need your love, so don\'t be put off by this condition">Greyhound Heart Murmurs</a>
											</p>';
					$contactcontent.= '</div>';
				}


				$contactcontent.= '<div class="contentfooternote">';
				$contactcontent.= '<a id="adopt-a-greyhound-smile" href="'.esc_url( home_url( '/' ) ).'adopt-a-greyhound/" title="Adopt a greyhound, they make excellent pets"><img src="'.esc_url( home_url( '/' ) ).'wp-content/themes/greyhoundlifeline/images/smile-logo-slim.jpg" width="466" height="41" alt="Adopt a greyhound and make him smile"/></a>';
                $contactcontent.= '<h4>Interested in Adopting a Greyhound?</h4>';
				$contactcontent.= '<p>Enquiries should be directed by telephone or text message to Greyhound Lifeline</p>
							<ul>
								<li><strong>For adoption enquiries:</strong>
									<ul>
										<li>Lucy on 07769 348310</li>
									</ul>
								</li>
							</ul>
							<ul>
								<li><strong>For any other enquiries:</strong>
									<ul>
										<li>Marie on 07828 138378</li>
									</ul>
								</li>
							</ul>
							<p>Or by email to '.antispambot('enquiries@greyhoundlifeline.co.uk').'<br/>';
				$contactcontent.= 'Or <a id="contact-greyhound-lifeline-to-adopt-a-greyhound" href="'.esc_url( home_url( '/' ) ).'contact/" title="Adopt a greyhound, they make excellent pets">Contact us using our Contact page</a></p>';
                $contactcontent.= '</div>';


			$content = $content.$contactcontent;
        }
        return $content;
}

add_filter ('the_content', 'insertFootNote');


/*automatically add in specific text/image for greyhound status - reserved, homed etc...*/
function insertGreyhoundStatus($content) {
	global $post;
	if((!is_feed() && !is_home()) && (is_single() || is_page()) ) {
			//check if tag to see if is
		$thisgreyhoundstatus ='';
		//get tag for post/page

		if(has_tag( 'reserved', $post ))
		{
			$thisgreyhoundstatus = '<span class="reserved-full-size">&nbsp;</span>';
		}
		else if(has_tag( 'homed', $post ))
		{
			$thisgreyhoundstatus = '<span class="homed-full-size">&nbsp;</span>';
		}
		else if(has_tag( 'available', $post ))
		{
			$thisgreyhoundstatus = '<span class="available-full-size">&nbsp;</span>';
		}
		$content = $thisgreyhoundstatus.$content;
	}
	return $content;
}  

add_filter ('the_content', 'insertGreyhoundStatus');



function get_greyhound_donation()
{
?>
	<div id="greyhound-lifeline-donations">
		<h3 class="widget-title">Make a Donation</h3>
		<p>
			Greyhound Lifeline is run by volunteers.
			<br/>
			Please help support retired greyhounds in our care by making a donation today.
			<br/>
			Many thanks.
		</p>

		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<fieldset>
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="9KE2JFPR2BRBQ">
				<input onclick="target='_blank'" type="image" src="https://www.greyhoundlifeline.co.uk/images/btn_donateCC_LG.gif" width="160" height="47" id="ppl" name="submit" alt="Please Donate to Greyhound Lifeline">
				<img alt="Please Donate to Greyhound Lifeline" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
			</fieldset>
		</form>

	</div>
<?php
}

function disable_self_trackback( &$links ) {
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, get_option( 'home' ) ) )
            unset($links[$l]);
}
add_action( 'pre_ping', 'disable_self_trackback' );


//$greyhoundreserved = '<img id="reserved-full-size" src="'.esc_url( home_url( '/' ) ).'wp-content/themes/greyhoundlifeline/images/greyhound-reserved.png" width="171" height="171" alt="This Greyhound is reserved"/>';
//$content.= $greyhoundreserved;

/*
add to htaccess
RewriteRule ^login$ http://www.greyhoundlifeline.co.uk/wp-login.php [NC,L]
*/
/*
add to ping list
http://rpc.pingomatic.com/
http://api.moreover.com/RPC2
http://bblog.com/ping.php
http://blogsearch.google.com/ping/RPC2
http://ping.weblogalot.com/rpc.php
http://ping.feedburner.com
http://ping.syndic8.com/xmlrpc.php
http://ping.bloggers.jp/rpc/
http://rpc.weblogs.com/RPC2
http://rpc.technorati.com/rpc/ping
http://topicexchange.com/RPC2
http://www.blogpeople.net/servlet/weblogUpdates
http://xping.pubsub.com/ping
*/




function ghl_testimonials($catid) {
	global $post, $wpdb;
	$perRow = 1;
 	$imagesPerPage = 6;
	$getnewimagesPerPage = 0;

	$imageCount = $wpdb->get_var("SELECT COUNT FROM {$wpdb->prefix}term_taxonomy WHERE taxonomy = 'category' AND TERM_ID = $catid");

	$pageCount = ceil($imageCount / $imagesPerPage);
	
	$currentPage = intval($_GET['testimonialpage']);
	if(!($currentPage>=1 && $currentPage <=200))
	{
		$currentPage = 1;
	}
	if ( empty($currentPage) || $currentPage<=0 ) $currentPage=1;

	$maxImage = $currentPage * $imagesPerPage;
	$minImage = ($currentPage-1) * $imagesPerPage;
	if($currentPage==1)
	{
		$getnewimagesPerPage = 0;
	}
	else
	{
		$getnewimagesPerPage = $imagesPerPage * ($currentPage-1);
	}
	// Define some default options
	$options = array(
		'cat' => $catid,
		'orderby' => 'modified',
		'order' => 'DESC',
		'offset' => $getnewimagesPerPage,
		'post_status' => 'publish',
        'numberposts' => $imagesPerPage
	);

	$images2 = get_posts($options);
//print_r($images2);
	if ($pageCount >= 1)
	{
		$page_link= get_permalink();
		$page_link_perma= true;
		if ( strpos($page_link, '?')!==false )
			$page_link_perma= false;

		$gplist= '<div class="gallery_pages_list">'.__('<strong>Testimonial Pages '.$currentPage.' of '.$pageCount.'</strong>').'<ul>';
		for ( $j=1; $j<= $pageCount; $j++)
		{
			if ( $j==$currentPage )
				$gplist .= '<li><strong class="current_gallery_page_num"> '.$j.' </strong></li>';
			else
				$gplist .= '<li><a href="'.$page_link. ( ($page_link_perma?'?':'&amp;') ). 'testimonialpage='.$j.'" title="View more Testimonials">'.$j.'</a></li>';
		}
		$gplist .= '</ul></div>';
	}

	$output .= "\n<br style='clear: both;' />$gplist\n";
	
	$k = $minImage;
	
	?>
	<div id="testimonials">

		<ul>
	<?php
	foreach($images2 as $imagegal) {
		if ($k >= $minImage && $k < $maxImage) {
		//echo "k=".$k;

		//print_r($imagegal);
		$thistestimonial = "";
		
		$thistestimonial .= "<blockquote>";
		$thistestimonial .= $imagegal->post_excerpt; //post_content
		$testimonialciting = "<br/><cite>".get_post_meta($imagegal->ID, 'testimonial-cite', true)."</cite>";
		$thistestimonial .= $testimonialciting;
		$thistestimonial .= '<a href="'.get_permalink($imagegal->ID).'" title="'.$imagegal->post_title.'">';
		$thistestimonial .= '<span class="ghlfr">Read More &rsaquo;</span></a>';
		$thistestimonial .= "</blockquote>";

		?>
				<li<?php 
					// Each end image in a row gets the "lastimage" class added. 
					if($k % $perRow == 0) { echo ' class="lastimage"'; } 
					?>>
					<?php
						echo $thistestimonial;
					?>
				</li>
	 <?php
		}
		$k=$k+1;
	}

	?>
		</ul>
	</div>

<?php
	echo $output;
}
//wp_reset_query();



function shop_gallery($catid) {
	global $post, $wpdb;
	$perRow = 1;
 	$imagesPerPage = 9;
	$getnewimagesPerPage = 0;

	$imageCount = $wpdb->get_var("SELECT COUNT FROM {$wpdb->prefix}term_taxonomy WHERE taxonomy = 'category' AND TERM_ID = $catid");

	$pageCount = ceil($imageCount / $imagesPerPage);
	
	$currentPage = intval($_GET['merchandisepage']);
	if(!($currentPage>=1 && $currentPage <=200))
	{
		$currentPage = 1;
	}
	if ( empty($currentPage) || $currentPage<=0 ) $currentPage=1;

	$maxImage = $currentPage * $imagesPerPage;
	$minImage = ($currentPage-1) * $imagesPerPage;
	if($currentPage==1)
	{
		$getnewimagesPerPage = 0;
	}
	else
	{
		$getnewimagesPerPage = $imagesPerPage * ($currentPage-1);
	}
	// Define some default options
	$options = array(
		'cat' => $catid,
		'orderby' => 'modified',
		'order' => 'DESC',
		'offset' => $getnewimagesPerPage,
		'post_status' => 'publish',
        'numberposts' => $imagesPerPage
	);
	
	$shopgals = get_posts($options);
//print_r($shopgals);
	if ($pageCount >= 1)
	{
		$page_link= get_permalink();
		$page_link_perma= true;
		if ( strpos($page_link, '?')!==false )
			$page_link_perma= false;

		$gplist= '<div class="gallery_pages_list">'.__('<strong>Greyhound Merchandise Pages '.$currentPage.' of '.$pageCount.'</strong>').'<ul>';
		for ( $j=1; $j<= $pageCount; $j++)
		{
			if ( $j==$currentPage )
				$gplist .= '<li><strong class="current_gallery_page_num"> '.$j.' </strong></li>';
			else
				$gplist .= '<li><a href="'.$page_link. ( ($page_link_perma?'?':'&amp;') ). 'merchandisepage='.$j.'" title="View more Greyhound Merchandise">'.$j.'</a></li>';
		}
		$gplist .= '</ul></div>';
	}
	
	$output .= "\n<br style='clear: both;' />$gplist\n";
	
	$k = $minImage;
	
	?>
	<div id="merchandise">

		<ul>
	<?php
	foreach($shopgals as $shopgal) {
		if ($k >= $minImage && $k < $maxImage) {
		//echo "k=".$k;

		//print_r($shopgal);

		$thisproductprice = '<span class="product-price">Price: &pound;'.get_post_meta($shopgal->ID, 'product-price', true).'</span>';
		$thisproduct = '<div class="product-description">'.$shopgal->post_excerpt.'</div>';

		?>
				<li<?php 
					// Each end image in a row gets the "lastimage" class added. 
					if($k % $perRow == 0) { echo ' class="lastimage"'; } 
					?>>
					<strong class="product-title">
						<a href="<?php echo get_permalink($shopgal->ID); ?>" title="View Product: <?php echo $shopgal->post_title; ?>"><?php echo $shopgal->post_title; ?></a>
						<?php echo $thisproductprice; ?>
					</strong>

					<a href="<?php echo get_permalink($shopgal->ID); ?>" title="View Product: <?php echo $shopgal->post_title; ?>">
						<?php
							echo get_the_post_thumbnail( $shopgal->ID, array(150,150), 'gallery-thumbnail');
						?>
						<?php echo $thisproduct; ?>
						<span class="ghlfr">View <?php echo $shopgal->post_title; ?> &rsaquo;</span>
					</a>
				</li>
	 <?php
		}
		$k=$k+1;
	}

	?>
		</ul>
	</div>

<?php
	echo $output;
}
//wp_reset_query();

function ghl_footer_testimonials()
{

	$options = array(
		'cat' => 149,
		'orderby' => 'rand',
		'numberposts' => 1
	);
	
	$testimonials = get_posts($options);
	//print_r($testimonials);
	
	//$testimonial_excerpt = '<blockquote>'.$testimonials->post_excerpt.'</blockquote>';
	//$testimonial_citing = "<br/><cite>".get_post_meta($testimonials->ID, 'testimonial-cite', true)."</cite>";
	//$randtestimonials = $testimonial_excerpt.$testimonial_citing;
	
?>
	<ul>
	<?php
	foreach($testimonials as $testimonial) {
		
		$rettestimonial = '<div id="testimonialfooterbox"><blockquote>';
		$rettestimonial .= $testimonial->post_excerpt;
		$testimonialciting = '<br/><cite>'.get_post_meta($testimonial->ID, 'testimonial-cite', true).'</cite>';
		$rettestimonial .= $testimonialciting;
		$rettestimonial .= '<a href="'.get_permalink($testimonial->ID).'" title="'.$testimonial->post_title.'">';
		$rettestimonial .= '<span class="ghlfr">Read More &rsaquo;</span></a>';
		$rettestimonial .= "</blockquote></div>";

		?>
				<li>
					<?php
						echo $rettestimonial;
					?>
				</li>
	 <?php
	}
	?>
	</ul>
	<div id="addatestimonial">
		<!--<h4>Add Your Testimonial</h4> -->
		<ul>
		    <li>
		    <br/>
		    <br/>
			If Greyhound Lifeline has helped you in any way, please leave a testimonial.
			<br/>
			Thanks, Greyhound Lifeline
		    </li>
           <!--<li>-->
		<!--<div id="testimonial-button">
			<ul>-->
				<li>
					<?php get_testimonial_button();?>
				</li>
			</ul>
		<!--</div>
            </li>-->
	</div>
	
<?php
}

add_filter('wp_feed_cache_transient_lifetime', create_function('$fixrss', 'return 1800;') );

function my_doctitle() {
	global $post;
	$nt = $post->post_title;
	$thisnt = $nt;
	$thiscat = get_the_category( $post->ID );
	$thisactualcat = $thiscat[0]->slug;

	if ($thisactualcat =='greyhounds-needing-homes')
	{
		$thisnt = 'Adopt '.$nt.' the Greyhound as Your Pet';
	}
	if ($thisactualcat =='greyhounds-homed')
	{
		$thisnt = $nt.' Has Been Homed';
	}
	if ($thisactualcat =='greyhounds-in-memory')
	{
		$thisnt = $nt.' Has Passed to Rainbow Bridge';
	}
	
	return $thisnt;
}
add_filter('wp_title', 'my_doctitle');

/*
function ghlcustomgallery($atts)
{
*/
/*new shortcode image gallery for custom galleries

http://codex.wordpress.org/Shortcode_API

usage: by cat slug
[custom-gallery gall="greyhound-gallery-homed-greyhounds"]

*/
/*
	print_r($atts);
	echo "<br/>";
	$catslug = $atts[gall];
	echo "catslug=".$catslug;
	echo "<br/>";

	$category = get_category_by_slug($catslug);
	//$category = get_category($catslug);

	print_r($category);

	//$category_name = $category->term_id;
	echo "category_name=".$id.$category_name;
	echo "<br/>";

	return "hello";
*/

/*
				<div id="hdrstrap">
					<em>Greyhound Lifeline insert custom title</em>
					<img id="newsposticon" src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/themes/greyhoundlifeline/images/icons/view-icon.png" width="89" height="89" alt="View Greyhound Gallery"/>
					<p>
						Custom photo galleries. Please also see the main greyhound gallery for greyhounds looking for a forever home.
						<br/>
						<span class="smallfont">NOTE: Images not for use without permission!</span>
					</p>

				</div>

				<div id="maingreyhoundgallery">
					<?php
						$obcategory = get_category_by_slug( $slug )
						$category_name = get_the_category_by_ID(20);
						$category_link = get_category_link(20);
						
						
						
					?>
					<h1><a href="<?php echo $category_link; ?>" title="View this Category"><?php echo $category_name; ?></a></h1>
					<?php pbd_image_gallery(20); ?>

				</div>
				
*/

//}
add_shortcode( 'custom-gallery', 'ghlcustomgallery' );

//look at ie8 for archive gallery

function ghl_get_events($howmanyevents)
{
	global $wpdb;
	if($howmanyevents=='')
	{
		$howmanyevents = 999;
	}

	$myevents = $wpdb->get_results( "
			SELECT DISTINCT 
				substr(wposts.post_title, 1, 10) as eventdate, 
				wposts.ID, 
				left(wposts.post_title, 68) as eventtitle
			FROM wp_posts wposts
			LEFT JOIN wp_postmeta wpostmeta ON wposts.ID = wpostmeta.post_id
			LEFT JOIN wp_term_relationships ON (wposts.ID = wp_term_relationships.object_id)
			LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
			WHERE wp_term_taxonomy.taxonomy = 'category'
			AND wp_term_taxonomy.term_id = 145
			LIMIT ".$howmanyevents);
	//wp_term_taxonomy.taxonomy = 'category'
	//AND year(replace(substr(wposts.post_title, 1, 10), '/','-')) >=year(curdate())
	//ORDER BY year(replace(substr(wposts.post_title, 1, 10), '/','-')),week(replace(substr(wposts.post_title, 1, 10), '/','-'))
?>
        
<!--
Commented out 12/09/18 as not working
	<div id="greyhound-events">
		<h2>Upcoming Events</h2>
		<ul>
	<?php
    /*
		$retevents = "";
		foreach($myevents as $event) {
			$retevents .= "<li>";
			$retevents .= '<a href="'.get_permalink($event->ID).'" title="'.$event->eventtitle.'">';
			$retevents .= $event->eventtitle;
			$retevents .= '<span class="fr">Read More &raquo;</span></a>';
			$retevents .= "</li>\n";
		}
		echo $retevents;*/
?>
		</ul>
	</div>
-->
<?php
}
add_shortcode( 'get_events_list', 'ghl_get_events' );
add_filter( ‘wpcf7_load_js’, ‘__return_false’ );