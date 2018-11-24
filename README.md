[![timber](https://ps.w.org/timber-library/assets/banner-1544x500.jpg)](https://www.upstatement.com/timber/)

# Wordpress
> The perfect WordPress-Timber starter theme.

### Requirements
* Wordpress
* Composer
* npm
* Nodejs

### Installation

Go to your themes folder and
```
$ git clone https://github.com/ludescher/wordpress-timber-theme.git
$ cd wordpress-timber-theme
$ composer install
$ npm install
$ npm run watch
```
Finally, activate the Timber plugin!

### Menus
Register all needed menus in

```
config/menus/menus.php
```

### AJAX Controller Interface
> The Controller-Interface saves its Routes in the global Twig Context. Therefore, you can access the route in all twig files.

Register a Route

```
// src/Controller/DefaultController.php

Controller::register([
	'methods' => ['POST'],
	'route' => 'posts/aller',
	'name' => 'just_posts',
	'callback' => function (WP_REST_Request $request) {
		$data = $request->get_params();

		return Controller::render('components/ajax.html.twig', $data);
	},
]);
```
Just assign a Name, a Route Name and an callback (which handles the request) and if you have to render additional data, you can simply call render ;-)