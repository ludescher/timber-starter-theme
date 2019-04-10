<?php

namespace lib;

class Controller {
	public static function register($route) {

		add_action('rest_api_init', function () use ($route) {
			register_rest_route('api/', $route['route'], [
				'methods' => $route['methods'],
				'callback' => $route['callback'],
				'permission_callback' => isset($route['permission_callback']) ? $route['permission_callback'] : null,
				'args' => isset($route['params']) ? $route['params'] : [],
			]);
		});

		add_filter('timber_context', function ($data) use ($route) {
			$data[$route['name']] = site_url() . '/wp-json/api/' . $route['route'];

			return $data;
		});
	}

	public function render($twig, $params = NULL) {
		return Timber::compile($twig, $params);
	}
}
