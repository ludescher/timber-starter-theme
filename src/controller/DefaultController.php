<?php

namespace src\Controller;

use lib\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {
    /**
     * @Route("/default", name="default")
     */
    public static function index(array $request) {
        // $data = $request->request->get("email");

        // echo json_encode($data);
        echo json_encode($request);
    }
}
