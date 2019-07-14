<?php

namespace lib;

use src\Utils\PathHelper;
use lib\Manager\RouterManager;
use Timber\Timber;
use Timber\User;

class Controller {

    /**
     * Compile a Twig file.
	 *
	 * Passes data to a Twig file and returns the output.
     * 
     * @param String $twig_file_name
     * @param Array $options
     * @return String
     */
    public function render(string $twig_file_name, array $options = []) {
        return Timber::compile($twig_file_name, $options);
    }

    /**
     * redirect the user to another page
     * 
     * @param String $routename
     * @param Array $args
     */
    public function redirectToRoute(string $routename, $args = []) {
        $this->redirect(
            RouterManager::getRouteByNameAndOptions($routename, $args)
        );
    }

    /**
     * redirect the user to another page
     * 
     * @param String $url
     * @param Bool $permanent
     */
    public function redirect(string $url, bool $permanent = false) {
        header('Location: ' . $url, true, $permanent ? 301 : 302);
        exit();
    }

    /**
     * get current user
     * get user by id
     * 
     * @param Int $id
     * @return User
     */
    public function getUser($id = false) {
        $user_id = apply_filters( 'determine_current_user', false );
        return new User($user_id);
    }

    /**
     * generate the url to another page
     * 
     * @param String $routename
     * @param Array $args
     * @return String
     */
    public function generateUrl(string $routename, array $args = []):string {
        return RouterManager::getRouteByNameAndOptions($routename, $args);
    }
}