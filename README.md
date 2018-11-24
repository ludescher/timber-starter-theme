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
$ git clone https://github.com/ludescher/timber-starter-theme.git
$ cd timber-starter-theme
$ composer install
$ npm install
$ npm run watch
```
Finally, activate the Timber plugin!

### Webpack
Take a quick look into
```
// config/webpack/config.js

[...]

  assetsPath: '/YOUR-PROJECT-NAME/wp-content/themes/YOUR-THEME-NAME/',

[...]

  devUrl: 'http://localhost/YOUR-PROJECT-NAME/',

[...]
```
Replace YOUR-PROJECT-NAME and YOUR-THEME-NAME with your configuration.

### Theme
You can manage all needed Theme settings in
```
config/site.php
```
Registering a menu etc.

### Post Types
If you need any custom post types, you can easily create a file in the post_types directory.
```
config/post_types/car.php
```

### Taxonomies
Same goes for taxonomies.
```
config/taxonomies/car_brand.php
```

### AJAX Controller Interface
> The Controller-Interface saves its Routes in the global Twig Context. Therefore, you can access the route in all twig files.

Register a Route

```
// src/controller/DefaultController.php

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
Just assign a Name, a Route Name and an callback (which handles the request) and if you have to render additional data, you can simply call render() ;-)