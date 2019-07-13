<?php

namespace src\Controller;

use lib\Controller;
use lib\Annotation\Route;

class DefaultController extends Controller {
    /**
     * @Route("/default", name="default")
     */
    public function defaultAction(\WP_REST_Request $request) {
        return [
            "method" => "logoutAction",
            "data" => $request->get_params()
        ];
    }

    /**
     * @Route("/test/{id}", name="test")
     */
    public function testAction(\WP_REST_Request $request) {
        return [
            "method" => "logoutAction",
            "data" => $request->get_params()
        ];
    }

    /**
     * @Route("/test/{id}/list", name="test_list")
     */
    public function testListAction(\WP_REST_Request $request) {
        return [
            "method" => "logoutAction",
            "data" => $request->get_params()
        ];
    }

    /**
     * @Route("/test/{id}/list/{list}", name="test_list_item")
     */
    public function testListItemAction(\WP_REST_Request $request) {
        return [
            "method" => "logoutAction",
            "data" => $request->get_params()
        ];
    }
}