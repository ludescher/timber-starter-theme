<?php

namespace lib\Router;

use src\Utils\PathHelper;
use Symfony\Component\Finder\Finder;
use Doctrine\Common\Annotations\FileCacheReader;

class RouterDiscovery {
    /**
     * @var FileCacheReader
     */
    private $annotationReader;
    
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $namespace;
    
    /**
     * @var array
     */
    private $routes = [];

    public function __construct(FileCacheReader $reader) {
        $this->annotationReader = $reader;
        $this->path = PathHelper::replaceSeparator(get_template_directory() . '/src/Controller');
        $this->namespace = "src\Controller";
    }

    /**
     * Discover and return a list of available Routes.
     * 
     * @return array
     */
    public function getRoutes() {
        if (!$this->routes) {
            $this->discoverRoutes();
        }
        return $this->routes;
    }

    /**
     * Discover all Routes
     */
    private function discoverRoutes() {
        $finder = new Finder();
        $finder->files()->in($this->path);
        foreach ($finder as $file) {
            $class = $this->namespace . '\\' . $file->getBasename('.php');
            $reflClass = new \ReflectionClass($class);
            $reflMethods = $reflClass->getMethods();
            foreach ($reflMethods as $method) {
                if ($method->class == $class) {
                    $reflMethod = new \ReflectionMethod($method->class, $method->name);
                    $routes = $this->annotationReader->getMethodAnnotations($reflMethod);
                    if (!$routes) {
                        continue;
                    }
                    foreach ($routes as $route) {
                        $this->routes[$route->getName()] = [
                            "class" => $class,
                            "method" => $method->getName(),
                            "route" => $route
                        ];
                        // add Routes to global Timber Context
                        add_filter('timber_context', function ($data) use ($route) {
                            $data[$route->getName()] = site_url() . $route->getPath();
                            return $data;
                        });
                    }
                }
            }
        }
    }
}
