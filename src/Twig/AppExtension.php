<?php

namespace src\Twig;

use src\Utils\PathHelper;
use Timber\Twig_Function;
use lib\Manager\RouterManager;

class AppExtension {

    function __construct() {
        add_filter( 'timber/twig', [$this, 'getFunctions'] );
    }

    public function getFunctions($twig) {
        // Adding a function.
        $twig->addFunction( new Twig_Function( 'url', [ &$this, 'twig_url_generator'] ) );
        $twig->addFunction( new Twig_Function( 'path', [ &$this, 'twig_path_generator'] ) );
        return $twig;
    }

    public function twig_url_generator(string $routename, array $args = []):string {
        return RouterManager::getRouteByNameAndOptions($routename, $args);
    }

    public function twig_path_generator(string $routename, array $args = []):string {
        return RouterManager::getRouteByNameAndOptions($routename, $args, true);
    }
}