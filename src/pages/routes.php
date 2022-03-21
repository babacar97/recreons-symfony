<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;


class GreetingController
{

    public function hello(Request $request)
    {
        //connexion a la base de donnéé
        $name = $request->attributes->get('name');
        //Envoyer un email

        //integrer du html
        ob_start();
        include __DIR__ . '/hello.php';
        return new Response(ob_get_clean());
    }
}

$routes = new RouteCollection;
$routes->add('hello', new Route(
    '/hello/{name}',
    [
        'name' => 'word',
        '_controller' => [new GreetingController, 'hello']
    ]
));
$routes->add('buy', new Route('/buy'));
$routes->add('about', new Route('/a-propos'));


return $routes;
