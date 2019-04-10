<?php
/**
 * Timber starter-theme
 */

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
	});

	add_filter('template_include', function( $template ) {
		return get_stylesheet_directory() . '/templates/no-timber.html';
	});

	return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * By default, Timber does NOT autoescape values.
 */
Timber::$autoescape = false;

/**
 * Require Autoload
 */
$autoload_path = __DIR__ . '/vendor/autoload.php';

if (file_exists($autoload_path)) {
	require_once $autoload_path;

	include("config/site.php");

	new StarterSite();
} else {
	echo '<div class="error"><p>Autoload is missing. Make sure you\'ve installed all composer packages.</p></div>';
}