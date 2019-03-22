<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Headless_CMS
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'headless-cms' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding" style="margin:50px 0px">
			
        <h1 style="font-size:2rem;margin-left:50px">CDG Bureau Website</h1>
        <ul>
        <li><p>Homepage:<br /><a href="<?php echo get_rest_url() ?>"><?php echo get_rest_url() ?></a></p></li>
        <li><p>Posts:<br /><a href="http://localhost/headless-cms/wp-json/wp/v2/posts">http://localhost/headless-cms/wp-json/wp/v2/posts</a></p></li>
        <li><p>Printers:<br /><a href="http://localhost/headless-cms/wp-json/wp/v2/printers">http://localhost/headless-cms/wp-json/wp/v2/printers</a></p></li>
        <li><p>Materials:<br /><a href="http://localhost/headless-cms/wp-json/wp/v2/materials">http://localhost/headless-cms/wp-json/wp/v2/materials</a></p></li>
        <li><p>FAQ:<br /><a href="http://localhost/headless-cms/wp-json/wp/v2/faq">http://localhost/headless-cms/wp-json/wp/v2/faq</a></p></li>
        </ul>
		</div><!-- .site-branding -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">