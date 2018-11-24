<?php
/**
 * Timber starter-theme
 */

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
	});

	add_filter('template_include', function( $template ) {
		return get_stylesheet_directory() . '/src/views/no-timber.html';
	});

	return;
}

/**
 * Require Autoload
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'src/views', 'views' );

/**
 * By default, Timber does NOT autoescape values.
 */
Timber::$autoescape = false;

include("config/site.php");

new StarterSite();
