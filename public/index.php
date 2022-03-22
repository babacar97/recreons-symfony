<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

require __DIR__ . '/../vendor/autoload.php';
$request = Request::createFromGlobals();


$routes = require __DIR__ . '/../src/pages/routes.php';

$context = new RequestContext();
$context->fromRequest($request);

$urlMatcher = new UrlMatcher($routes, $context);

$pathInfo = $request->getPathInfo();

try {
    $resultat = ($urlMatcher->match($request->getPathInfo()));
    $request->attributes->add($resultat);


    $className = substr($resultat['_controller'], 0, strpos($resultat['_controller'], '@'));


    $methodeName = substr(
        $resultat['_controller'],
        strpos($resultat['_controller'], '@') + 1
    );
    //Voila un exemple de collable
    $controller = [new $className, $methodeName];


    $response = call_user_func($controller, $request);
    // die();
    // extract($resultat);
    // extract($request->query->all());
    // ob_start();

    // include __DIR__ . '/../src/pages/' . $resultat['_route'] . '.php';
    // $response = new Response(ob_get_clean());
} catch (ResourceNotFoundException $th) {

    $response = new Response("la page demande n'existe pas", 404);
} catch (Exception $e) {

    $response = new Response("Une erreur est arrivé sur le serveur", 500);
}

$response->send();
