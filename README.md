[![timber](https://ps.w.org/timber-library/assets/banner-1544x500.jpg)](https://www.upstatement.com/timber/)

# Wordpress
> The perfect WordPress-Timber starter theme.

### Requirements
* Wordpress
* Composer
* npm | yarn

### Installation

Go to your themes folder and
```
$ git clone https://github.com/ludescher/timber-starter-theme.git <theme-name>
$ cd <theme-name>
$ composer install
$ npm install
```
Now setup webpack and you're ready to go.

### Webpack-Encore
```php
# compile assets once
$ yarn encore dev

# or, recompile assets automatically when files change
$ yarn encore dev --watch

# on deploy, create a production build
$ yarn encore production
```
Change "WORDPRESS" to your sitename.
```js
// webpack.config.js
if (!Encore.isProduction()) {
    const BrowserSyncPlugin = require('browser-sync-webpack-plugin')
    config.plugins.push(
        new BrowserSyncPlugin({
            // browse to http://localhost:3000/ during development,
            // ./public directory is being served
            host: '127.0.0.1',
            proxy: 'http://localhost/WORDPRESS/',
            port: 3000,
            //server: { baseDir: ['public'] }
        })
    );
}
```
Finally, activate the Timber plugin!

### Timber-Cache
Caching is now enabled by default
```php
// functions.php

/**
 * Cache the Twig File (but not the data)
 */
Timber::$cache = true;
```

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

### Controller
> The Controller-Interface saves its Routes in a global variable. Therefore, you can access all routes the the new Twig-Functions url() and path().

the new controller was heavily inspired by [symfony](https://symfony.com/doc/current/controller.html#a-simple-controller "symfony")

```php
// src/Controller/DefaultController.php
<?php

namespace src\Controller;

use lib\Controller;
use lib\Annotation\Route;

class DefaultController extends Controller {
    /**
     * @Route("/test/{id}/list/{list}", name="test_list_item", methods={"GET"})
     */
    public function testListItemAction(\WP_REST_Request $request) {
        $id = $request->get_params("id");
        $list_id = $request->get_params("list");

        return [
            "method" => "logoutAction",
            "request" => $request->get_params(),    // POST parameters
            "url" => $this->generateUrl("test_post", ["id" => 120]),
            "user" => $this->getUser(),
        ];

        return $this->redirectToRoute("test_post");
        
        return $this->render("tease.twig");
        
        return $this->redirect("https://www.google.com");
    }

    /**
     * @Route("/test/post/{id}", name="test_post", methods={"GET"})
     */
    public function testPostAction(\WP_REST_Request $request) {[...]}
}
```
With the new Controller you have access to
```php
    // redirect the user to another page
    $this->redirectToRoute("routename");
```

```php
    // Passes data to a Twig file and returns the output.
    $this->render("filename");
```

```php
    // redirect the user to another page
    $this->redirect("url");
```

```php
    // get current user
    // get user by id
    $this->getUser();
```

```php
    // generate the url to another page
    $this->generateUrl("routename");
```
and much more ;-)