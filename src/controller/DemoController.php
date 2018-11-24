<?php

Controller::register([
	'methods' => ['POST'],
	'route' => 'posts/aller',
	'name' => 'just_posts',
	'callback' => function (WP_REST_Request $request) {
		$data = $request->get_params();

		return Controller::render('components/ajax.html.twig', $data);
	},
]);