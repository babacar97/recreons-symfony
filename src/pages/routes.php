<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;


$routes = new RouteCollection;
$routes->add('hello', new Route(
    '/hello/{name}',
    [
        'name' => 'word',
        '_controller' => 'App\Controller\GreetingController::hello'
    ]
));
$routes->add('buy', new Route('/buy', [
    '_controller' => 'App\Controller\GreetingController::buy'
]));
$routes->add('about', new Route('/a-propos', [
    '_controller' => 'App\Controller\PageController::about'
]));


return $routes;
