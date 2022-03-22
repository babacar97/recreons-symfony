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
        '_controller' => [new App\Controller\GreetingController, 'hello']
    ]
));
$routes->add('buy', new Route('/buy', [
    '_controller' => [new App\Controller\GreetingController, 'buy']
]));
$routes->add('about', new Route('/a-propos', [
    '_controller' => [new App\Controller\PageController, 'about']
]));


return $routes;
