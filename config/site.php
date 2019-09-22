<?php

use Symfony\Component\Finder\Finder;
use lib\Manager\AnnotationManager;
use lib\Manager\RouterManager;
use src\Twig\AppExtension;
use Timber\Site;

class StarterSite extends Site {
	/**
	 * @var Finder
	 */
	private $finder;

	public function __construct() {
		$this->finder = new Finder();

		//Register Actions / Filters
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts_and_styles' ), 999);
		
		// Register Custom PHP-Files
		$this->register_router();
		$this->register_timber_extensions();
		$this->register_menus();
		$this->register_post_types();
		$this->register_taxonomies();
		$this->register_hooks();
		$this->register_metaboxes();
		
		parent::__construct();
	}

	/**
	 * This is where you can register all PostTypes
	 */
	public function register_post_types() {
		$path = dirname(__DIR__) . '/src/PostType/';
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

	/**
	 * This is where you can register all Taxonomies
	 */
	public function register_taxonomies() {
		$path = dirname(__DIR__) . '/src/Taxonomy/';
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

	/**
	 * This is where you can register all Hooks
	 */
	public function register_hooks() {
		$path = dirname(__DIR__) . '/src/Hooks/';
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

	/**
	 * This is where you can register Metaboxes
	 */
	public function register_metaboxes() {
		$path = dirname(__DIR__) . '/src/Metaboxes/';
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

	/**
	 * Init Annotaion
	 * cache Routes or read from Cache
	 * add all Routes to $GLOBALS['routes']
	 */
	public function register_router() {
		$annotationManager = new AnnotationManager(
			templatePath('/var/cache/routes/'),
			templatePath("/lib/Annotation/Route.php"),
			"lib\Annotation",
			templatePath('/lib')
		);
		$routerManager = new RouterManager(
			$annotationManager->initAnnotationReader(),
			templatePath('/src/Controller'),
			"src\Controller",
			"timber"
		);
		$routerManager->discover();
	}

	/**
	 * add new functionality to twig
	 * e.g. url() path() 
	 */
	public function register_timber_extensions() {
		new AppExtension();
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

	/**
	 * Register styles
	 * used to register all Webpack resources
	 */
	public function enqueue_scripts_and_styles() {

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

	/**
	 * get Assets by Key
	 * 
	 * @param String $key
	 * @return String
	 */
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
