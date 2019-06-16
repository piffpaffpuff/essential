<?php
/**
 * @package Hello
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<!--[if IE]>
<meta http-equiv="imagetoolbar" content="no" />
<![endif]-->
<meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php
	// Print the <title> tag based on what is being viewed.
	global $page, $paged;

	wp_title( '-', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " - $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		echo ' - ' . sprintf( __( 'Page %s', 'hello' ), max( $paged, $page ) );
	}
?></title>

<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon/favicon-16x16.png">
<link rel="manifest" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon/site.webmanifest">
<link rel="mask-icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon/safari-pinned-tab.svg" color="#242424">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">

<script type="text/javascript">
	// Google Font Loader
	WebFontConfig = {
		custom: {
			families: ['Batiment Ext Bold']
		}
	};
	(function() {
        var wf = document.createElement('script');
        wf.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
      })();
</script>
<script type="text/javascript">
	// Google Analytics
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-7378650-1']);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>
<?php wp_enqueue_style('style', get_stylesheet_uri(), null, false, 'all'); ?>
<?php
	if(!is_admin()){
		// enqueue jquery again to send it to the footer
		wp_deregister_script('jquery');
		wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', false, '3.3.1', true);
		wp_enqueue_script('jquery');
	}
?>
<?php wp_enqueue_script('tweenmax', get_stylesheet_directory_uri() . '/js/gsap/TweenMax.min.js', null, '1.0', true); ?>
<?php wp_enqueue_script('splittext', get_stylesheet_directory_uri() . '/js/gsap/utils/SplitText.min.js', array('tweenmax'), '1.0', true); ?>
<?php wp_enqueue_script('scrollout', '//unpkg.com/scroll-out/dist/scroll-out.min.js', null, '1.0', true); ?>
<?php wp_enqueue_script('script', get_stylesheet_directory_uri() . '/js/script.min.js', array('jquery', 'tweenmax', 'splittext', 'scrollout'), '1.0', true); ?>
<?php wp_head(); ?>
</head>

<body <?php body_class('collapsed'); ?>>
<div id="page" class="hfeed">
	<?php do_action( 'before' ); ?>

	<header id="branding" role="banner">
		<h1 id="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<nav id="access" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'container' => false ) ); ?>
		</nav>
	</header><!-- #branding -->
