<?php

use Symfony\Component\Finder\Finder;

class StarterSite extends Timber\Site {
	/**
	 * @var Finder
	 */
	private $finder;

	public function __construct() {
		$this->finder = new Finder();

		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_action( 'init', array( $this, 'register_libraries' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'init', array( $this, 'register_visual_composer_modules' ) );
		add_action( 'init', array( $this, 'register_controller' ) );
		add_action( 'init', array( $this, 'register_menus' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts_and_styles' ), 999);
		parent::__construct();
	}

	/** This is where you can register custom libraries. */
	public function register_libraries() {
		$path = dirname(__DIR__) . '/lib/';

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
	
	/** This is where you can register custom post types. */
	public function register_post_types() {
		$path = dirname(__DIR__) . '/config/post_types/';

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

	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {
		$path = dirname(__DIR__) . '/config/taxonomies/';

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

	/** This is where you can register custom visual-composer modules. */
	public function register_visual_composer_modules() {
		$path = dirname(__DIR__) . '/src/vc_modules/';

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

	/** This is where you can register controller. */
	public function register_controller() {
		$path = dirname(__DIR__) . '/src/controller/';

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
		$vendor_js_path = $this->assets('vendor.js');
		$app_js_path = $this->assets('app.js');

		if ($app_css_path !== false) {
			wp_register_style('template-styles', $app_css_path, [], '', 'all');
		}

		// Register scripts
		if ($vendor_js_path !== false) {
			wp_register_script('template-vendor', $vendor_js_path, [], '', true);
		}

		if ($app_js_path !== false) {
			wp_register_script('template-scripts', $app_js_path, ['template-vendor'], '', true);
		}

		// Enqueue scripts and styles
		wp_enqueue_script('template-scripts');
		wp_enqueue_script('template-vendor');
		wp_enqueue_style('template-styles');
	}

	public function assets($key) {
		$path = get_template_directory() . '/public/manifest.json';

		if (file_exists($path)) {
		    $manifest_string = file_get_contents($path);
		    $manifest_array  = json_decode($manifest_string, true);
		    return get_stylesheet_directory_uri() . '/public/' . $manifest_array[$key];
		} else {
			return false;
		}
	}
}