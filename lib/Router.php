<?php

namespace lib;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

try {
    // Load routes from the yaml file
	$fileLocator = new FileLocator([get_template_directory() . DIRECTORY_SEPARATOR . "config"]);

	$loader = new YamlFileLoader($fileLocator);
    
    $routes = $loader->load('routes.yaml');

	// Init RequestContext object
	$context = new RequestContext();
	$context->fromRequest(Request::createFromGlobals());

	// Init UrlMatcher object
	$matcher = new UrlMatcher($routes, $context);

	// Find the current route
	$parameters = $matcher->match($context->getPathInfo());

	// print_r(json_encode($parameters));
	// print_r(json_encode($context->getQueryString()));
	// print_r(json_encode($context->getParameters()));
	// print_r(json_encode($context->getParameter("email")));
	$parameters["_controller"]($parameters);

	exit;
} catch (ResourceNotFoundException $e) {
	echo $e->getMessage();
}