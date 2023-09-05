<?php
require 'vendor/autoload.php';
$app = new \Slim\App();
require 'helper.php';

$app->add(function ($request, $response, $next) {
    $response = $next($request, $response);

    // Set header untuk mengizinkan permintaan dari semua origin
    $response = $response->withHeader('Access-Control-Allow-Origin', '*');

    // Atur header lainnya sesuai kebutuhan
    // $response = $response->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');

    return $response;
});

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . "/templates", [
        'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};

require "routes.php";

$app->run();
