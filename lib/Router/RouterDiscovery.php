<?php

namespace lib\Router;

use src\Utils\PathHelper;
use lib\Annotation\Route;
use Symfony\Component\Finder\Finder;
use Doctrine\Common\Annotations\FileCacheReader;

class RouterDiscovery {

    private $annotationReader;
    private $path;
    private $namespace;
    private $routes = [];

    public function __construct(FileCacheReader $reader) {
        $this->annotationReader = $reader;
        $this->path = PathHelper::replaceSeparator(get_template_directory() . '/src/Controller');
        $this->namespace = "src\Controller";
    }
    
    public function getRoutes() {
        if (!$this->routes) {
            $this->discoverRoutes();
        }
        return $this->routes;
    }

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
                    }
                }
            }
        }
    }
}
