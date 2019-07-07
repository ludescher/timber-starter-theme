<?php

namespace src\Controller;

use lib\Controller;
use lib\Annotation\Route;

class DefaultController extends Controller {
    /**
     * @Route("/default", name="default")
     */
    public function defaultAction() {
        echo json_encode([
            "response" => "defaultAction()"
        ]);
    }
}