<?php

namespace Framework;

use Exception;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;



class Simplex
{
    // protected UrlMatcher $urlMatcher;
    // protected ArgumentResolver $argumentResolver;
    // protected ControllerResolver $controllerResolver;

    // public function __construct(UrlMatcher $urlMatcher, ArgumentResolver $argumentResolver, ControllerResolver $controllerResolver)
    // {
    //     $this->argumentResolver = $argumentResolver;
    //     $this->controllerResolver = $controllerResolver;
    //     $this->urlMatcher = $urlMatcher;
    // }

    public function handle(Request $request)
    {
        $routes = require __DIR__ . '/../src/pages/routes.php';

        $context = new RequestContext();
        $context->fromRequest($request);

        $urlMatcher = new UrlMatcher($routes, $context);

        $controllerResolver = new ControllerResolver();
        $argumentResolver = new ArgumentResolver();

        $pathInfo = $request->getPathInfo();

        try {

            $request->attributes->add($urlMatcher->match($request->getPathInfo()));

            $controller = $controllerResolver->getController($request);
            $argument = $argumentResolver->getArguments($request, $controller);


            $response = call_user_func_array($controller, $argument);
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
        return $response;
    }
}
