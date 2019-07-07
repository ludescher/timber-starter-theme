<?php

namespace src\Controller;

use lib\Controller;
use lib\Annotation\Route;

/**
 * @Route(methods="SecurityController", name="SecurityController")
 */
class SecurityController extends Controller {
    /**
     * @Route("/auth/login", name="auth_login")
     */
    public function authAction() {
        echo json_encode([
            "response" => "authAction()"
        ]);
    }
}
