<?php

use Symfony\Component\Finder\Finder;
use src\Utils\PathHelper;
use lib\Router\RouterDiscovery;
use lib\Router\RouterManager;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\FileCacheReader;

class StarterSite extends Timber\Site {
	/**
	 * @var Finder
	 */
	private $finder;

	/**
	 * @var RouterManager
	 */
	private $routerManager;

	public function __construct() {
		$this->finder = new Finder();

		AnnotationRegistry::registerFile(PathHelper::replaceSeparator(get_template_directory() . "/lib/Annotation/Route.php"));
		AnnotationRegistry::registerAutoloadNamespace("lib\Annotation", PathHelper::replaceSeparator(get_template_directory() . '/lib'));

		$reader = new FileCacheReader(
			new AnnotationReader(),
			PathHelper::replaceSeparator(get_template_directory() . '/var/cache/'),
			$debug = true
		);

		$discovery = new RouterDiscovery($reader);

		$this->routerManager = new RouterManager($discovery);
		dump($this->routerManager->getRoutes());

		//Register Actions / Filters
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts_and_styles' ), 999);

		// Register Custom PHP-Files
		$this->register_menus();
		$this->register_src();
		parent::__construct();
	}

	/** This is where you can register ... */
	public function register_src() {
		$path = PathHelper::replaceSeparator(dirname(__DIR__) . '/src/');

		if (file_exists($path)) {
			$this->finder->files()
				->in($path)
				->name('*.php')
				->notName(basename(__FILE__));

			foreach ($this->finder as $file) {
				require_once $file->getRealPath();
			}
		}
	}

	/** This is where you can register menus. */
	public function register_menus() {
		register_nav_menu('header_menu', __('Header menu', 'timber'));

		register_nav_menu('footer_menu', __('Footer menu', 'timber'));
	}

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$context['menu'] = new Timber\Menu();
		$context['site'] = $this;
		return $context;
	}

	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats', array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support( 'menus' );
	}

	public function enqueue_scripts_and_styles() {
		// Register styles

		$app_css_path = $this->assets('app.css');
		$runtime_js_path = $this->assets('runtime.js');
		$app_js_path = $this->assets('app.js');

		if ($app_css_path !== false) {
			wp_register_style('template-styles', $app_css_path, [], '', 'all');
		}

		if ($runtime_js_path !== false) {
			wp_register_script('template-runtime', $runtime_js_path, [], '', true);
		}

		if ($app_js_path !== false) {
			wp_register_script('template-scripts', $app_js_path, [], '', true);
		}

		// Enqueue scripts and styles
		wp_enqueue_style('template-styles');
		wp_enqueue_script('template-runtime');
		wp_enqueue_script('template-scripts');
	}

	public function assets($key) {
		$path = get_template_directory() . '/public/manifest.json';

		
		if (file_exists($path)) {
			$manifest_string = file_get_contents($path);
			$manifest_array  = json_decode($manifest_string, true);

		    return get_stylesheet_directory_uri() . '/public' . $manifest_array[$key];
		} else {
			return false;
		}
	}
}
