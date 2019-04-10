[![timber](https://ps.w.org/timber-library/assets/banner-1544x500.jpg)](https://www.upstatement.com/timber/)

# Wordpress
> The perfect WordPress-Timber starter theme.

### Requirements
* Wordpress
* Composer
* npm
* Nodejs
* Yarn

### Installation

Go to your themes folder and
```
$ git clone https://github.com/ludescher/timber-starter-theme.git <theme-name>
$ cd <theme-name>
$ composer install
$ npm install
$ npm run watch
```
Finally, activate the Timber plugin!

### Webpack-Encore
```
# compile assets once
$ yarn encore dev

# or, recompile assets automatically when files change
$ yarn encore dev --watch

# on deploy, create a production build
$ yarn encore production
```
Finally, activate the Timber plugin!

### Theme
You can manage all needed Theme settings in
```
config/site.php
```
Registering a menu etc.

### Post Types
If you need any custom post types, you can easily create a file in the post_types directory.
```
src/PostType/car.php
```

### Taxonomies
Same goes for taxonomies.
```
src/Taxonomy/car_brand.php
```

### AJAX Controller Interface
> The Controller-Interface saves its Routes in the global Twig Context. Therefore, you can access the route in all twig files.

Register a Route

```
// src/Controller/DefaultController.php

Controller::register([
	'methods' => ['POST'],
	'route' => 'posts/all',
	'name' => 'get_all_posts',
	'callback' => function (WP_REST_Request $request) {
		$data = $request->get_params();

		return Controller::render('components/ajax.html.twig', $data);
	},
]);
```
Just assign a Name, a Route Name and an callback (which handles the request) and if you have to render additional data, you can simply call render() ;-)