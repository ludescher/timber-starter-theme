<?php

namespace lib\Router;

use lib\Router\RouterDiscovery;
use lib\Controller;

class RouterManager {
    /**
     * @var RouterDiscovery
     */
    private $discovery;

    public function __construct(RouterDiscovery $discovery) {
        $this->discovery = $discovery;
    }

    /**
     * Returns a list of available Routes.
     *
     * @return array
     */
    public function getRoutes() {
        return $this->discovery->getRoutes();
    }

    /**
     * Returns one Route by name
     *
     * @param $name
     * @return array
     *
     * @throws \Exception
     */
    public function getRoute($name) {
        $route = $this->discovery->getRoutes();
        if (isset($route[$name])) {
            return $route[$name];
        }

        throw new \Exception("$name not found.");
    }

    /**
     * Creates a Route
     *
     * @param $name
     * @return Controller
     *
     * @throws \Exception
     */
    public function create($name) {
        $routes = $this->discovery->getRoutes();
        if (array_key_exists($name, $routes)) {
            $class = $routes[$name]['class'];
            if (!class_exists($class)) {
                throw new \Exception("$name class does not exist.");
            }
            return new $class();
        }

        throw new \Exception("$name does not exist.");
    }
}