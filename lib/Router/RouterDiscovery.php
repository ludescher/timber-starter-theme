<?php

namespace lib\Router;

use lib\Annotation\Route;
use src\Utils\PathHelper;
use Symfony\Component\Finder\Finder;
use src\Controller\SecurityController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Doctrine\Common\Annotations\FileCacheReader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Route as SymfonyRoute;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class RouterDiscovery {
    /**
     * @var FileCacheReader
     */
    private $annotationReader;
    
    /**
     * @var String
     */
    private $path;

    /**
     * @var String
     */
    private $namespace;
    
    /**
     * @var Finder
     */
    private $finder;
    
    /**
     * @var Array
     */
    private $routes = [];
    
    /**
     * @var String
     */
    private $prefix;

    /**
     * @param FileCacheReader $reader
     * @param string $path
     * @param string $namespace
     */
    public function __construct(FileCacheReader $reader, string $path, string $namespace) {
        $this->annotationReader = $reader;
        $this->path = $path;
        $this->namespace = $namespace;
        $this->finder = new Finder();
        $this->prefix = "timber";
    }

    /**
     * Discover all Routes
     */
    public function discover():void {
        $this->finder->files()->in($this->path);
        foreach ($this->finder as $file) {
            $classname = $file->getBasename('.php');
            $namespace = $this->namespace . '\\' . $classname;
            $reflClass = new \ReflectionClass($namespace);
            $reflMethods = $reflClass->getMethods();
            foreach ($reflMethods as $method) {
                if ($method->class == $namespace) {
                    $reflMethod = new \ReflectionMethod($method->class, $method->name);
                    $routes = $this->annotationReader->getMethodAnnotations($reflMethod);
                    if (!$routes) {continue;}
                    $route = $routes[0];
                    $prefix = $this->prefix;
                    $this->routes[$route->getName()] = $route->getPath();
                    add_action( 'rest_api_init', function() use ($method, $prefix, $route, $namespace) {$this->addToRouting($method, $prefix, $route, $namespace);});
                }
            }
        }
    }

    /**
     * The Following registers an api route with multiple parameters.
     * 
     * @param \ReflectionMethod $method
     * @param String $prefix
     * @param Route $route
     * @param String $namespace
     */
    public function addToRouting(\ReflectionMethod $method, string $prefix, Route $route, string $namespace) {
        $args = PathHelper::getPathparameters($route->getPath(), 1, ["validate_callback" => function($param, $request, $key) {return is_numeric($param);}]);
        $path = PathHelper::replaceParameters($route->getPath());
        register_rest_route($prefix, $path, [
            'methods' => ($route->getMethods() != []) ? $route->getMethods() : ["GET", "POST"],
            'callback' => [new $namespace(), $method->name],
            'args' => $args,
        ], true);
    }

    /**
     * Get all Routes
     * 
     * @return Array
     */
    public function getRoutes():array {
        return $this->routes;
    }
}