<?php

use lib\Controller;

Controller::register([
	'methods' => ['POST'],
	'route' => 'post/all',
	'name' => 'get_em_all',
	'callback' => function (WP_REST_Request $request) {
		$data = $request->get_params();

		return $data;
	},
]);