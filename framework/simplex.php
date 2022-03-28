<?php

namespace Framework;

use ArgumentCountError;
use Exception;
use Framework\Event\ArgumentEvent;
use Framework\Event\ControllerEvent;
use Framework\Event\RequestEvent;
use Framework\Event\ResponseEvent;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;

class Simplex
{


    protected  $urlMatcher;
    protected  $controllerResolver;
    protected $argumentResolver;
    protected $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher, UrlMatcherInterface $urlMatcher, ControllerResolverInterface $controllerResolver, ArgumentResolverInterface $argumentResolver)
    {
        $this->urlMatcher = $urlMatcher;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
        $this->dispatcher = $dispatcher;
    }

    public function handle(Request $request)
    {
        $this->urlMatcher->getContext()->fromRequest($request);

        try {

            $request->attributes->add($this->urlMatcher->match($request->getPathInfo()));

            $this->dispatcher->dispatch(new RequestEvent($request), 'kernel.request');

            $controller = $this->controllerResolver->getController($request);

            $this->dispatcher->dispatch(new ControllerEvent($request, $controller), 'kernel.controller');

            $argument = $this->argumentResolver->getArguments($request, $controller);

            $this->dispatcher->dispatch(new ArgumentEvent($request, $controller, $argument), 'Kernel.argument');

            $response = call_user_func_array($controller, $argument);

            $this->dispatcher->dispatch(new ResponseEvent($response), 'Kernel.response');
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
