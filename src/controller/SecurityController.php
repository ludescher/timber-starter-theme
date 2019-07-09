<?php

namespace src\Controller;

use lib\Controller;
use lib\Annotation\Route;

class SecurityController extends Controller {
    /**
     * @Route("/auth/login", name="auth_login")
     */
    public static function authAction($var1, $var2) {
        \file_put_contents(get_template_directory() . '/shit.log', var_export([
            "var1" => $var1,
            "var2" => $var2
        ], true));

        echo json_encode([
            "response" => "authAction()"
        ]);
    }
}