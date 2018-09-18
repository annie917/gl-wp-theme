<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>

	<link rel="shortcut icon" href="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/themes/greyhoundlifeline/images/icons/greyhound-lifeline.jpg" type="image/x-icon"/>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/themes/greyhoundlifeline/js/greyhound-cycle.js"></script>

</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed">

	<header id="branding" role="banner">
		<ul id="ghl-networking">
			<li>
				<a href="http://www.facebook.com/pages/Greyhound-Lifeline/140115126025085" rel="nofollow" onclick="target='_blank'" title="Join Greyhound Lifeline on Facebook">
					<img id="site-icon-facebook" src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/themes/greyhoundlifeline/images/icons/greyhound-lifeline-facebook.png" width="32" height="32" alt="Greyhound Lifeline Facebook"/>
					<span>Join us on Facebook</span>
				</a>
			</li>
		</ul>
		<a href="http://www.greyhoundlifeline.co.uk/" title="Greyhound Lifeline - Supporting UK Greyhound Rescue and Rehoming">
			<img id="site-logo" src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/themes/greyhoundlifeline/images/headers/greyhound-lifeline-logo.png" width="120" height="122" alt="Greyhound Lifeline logo"/>
		</a>
		<hgroup>
			<h1 id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">Greyhound <span>Life</span>line</a></h1> <!-- <?php bloginfo( 'name' ); ?>-->
			<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
			<h3 id="independent-volunteer-greyhound-rehoming">An Independent Greyhound Welfare and Homing Group. Registered Charity number 1173175</h3>
		</hgroup>
		<a class="tel" href="<?php echo esc_url( home_url( '/' ) ); ?>category/main/contact/" title="Contact Greyhound Lifeline for an appointment">
			Telephone Adoption Line:-
			<br/>
			Lucy - <span class="tel">013843 96770</span>
		</a>
		<nav id="access" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Main menu', 'twentyeleven' ); ?></h3>
			<?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff. */ ?>
			<div class="skip-link"><a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to primary content', 'twentyeleven' ); ?>"><?php _e( 'Skip to primary content', 'twentyeleven' ); ?></a></div>
			<div class="skip-link"><a class="assistive-text" href="#secondary" title="<?php esc_attr_e( 'Skip to secondary content', 'twentyeleven' ); ?>"><?php _e( 'Skip to secondary content', 'twentyeleven' ); ?></a></div>
			<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu. The menu assiged to the primary position is the one used. If none is assigned, the menu with the lowest ID is used. */ ?>
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- #access -->
	</header><!-- #branding -->


	<div id="main">
	
		<?php get_latest_postbar(); ?>
		
		<div id="bcbreadcrumbs">
		</div>
		
<?php
