<?php

namespace src\Controller;

use lib\Controller;
use lib\Annotation\Route;

class DefaultController extends Controller {
    /**
     * @Route("/post/{id}", name="render_post")
     */
    public function renderPostAction(\WP_REST_Request $request) {
        return $this->render("tease.twig");
    }
    
    /**
     * @Route("/default", name="default")
     */
    public function defaultAction(\WP_REST_Request $request) {
        return [
            "method" => "logoutAction",
            "user" => $this->getUser(),
        ];
    }

    /**
     * @Route("/test/{id}", name="test")
     */
    public function testAction(\WP_REST_Request $request) {
        return $this->redirectToRoute("default");
    }

    /**
     * @Route("/test/{id}/list", name="test_list")
     */
    public function testListAction(\WP_REST_Request $request) {
        return $this->redirect("https://www.google.at/?gws_rd=ssl");
    }

    /**
     * @Route("/test/{id}/list/{list}", name="test_list_item")
     */
    public function testListItemAction(\WP_REST_Request $request) {
        return [
            "method" => "logoutAction",
            "request" => $request->get_params(),
            "url" => $this->generateUrl("test", ["id" => 120]),
            "user" => $this->getUser(),
        ];
    }
}