<?php

namespace lib;

use src\Utils\PathHelper;
use lib\Manager\RouterManager;
use Timber\Timber;
use Timber\User;

class Controller {
    function __construct() {}

    public function render(string $twig_file_name, array $options = []) {
        return Timber::compile($twig_file_name, $options);
    }

    public function redirectToRoute($routename, $args = []) {
        $this->redirect(
            RouterManager::getRouteByNameAndOptions($routename, $args)
        );
    }

    public function redirect(string $url, bool $permanent = false) {
        header('Location: ' . $url, true, $permanent ? 301 : 302);
        exit();
    }

    public function getUser($id = false) {
        $user_id = apply_filters( 'determine_current_user', false );
        return new User($user_id);
    }

    public function generateUrl(string $routename, array $args = []):string {
        return RouterManager::getRouteByNameAndOptions($routename, $args);
    }
}