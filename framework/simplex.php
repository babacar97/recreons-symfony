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
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class Simplex
{


    protected  $urlMatcher;
    protected  $controllerResolver;
    protected $argumentResolver;

    public function __construct(UrlMatcherInterface $urlMatcher, ControllerResolverInterface $controllerResolver, ArgumentResolverInterface $argumentResolver)
    {
        $this->urlMatcher = $urlMatcher;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
    }

    public function handle(Request $request)
    {
        $this->urlMatcher->getContext()->fromRequest($request);
        try {

            $request->attributes->add($this->urlMatcher->match($request->getPathInfo()));

            $controller = $this->controllerResolver->getController($request);
            $argument = $this->argumentResolver->getArguments($request, $controller);


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
