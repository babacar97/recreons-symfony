<?php

use Framework\Event\RequestEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;


require __DIR__ . '/../vendor/autoload.php';


$request = Request::createFromGlobals();

$routes = require __DIR__ . '/../src/pages/routes.php';

$context = new RequestContext();
// $context->fromRequest($request);

$urlMatcher = new UrlMatcher($routes, $context);

$controllerResolver = new ControllerResolver();



$argumentResolver = new ArgumentResolver();

$dispatcher = new EventDispatcher;

$dispatcher->addListener('kernel.request', function (RequestEvent $e) {
    dump($e);
});

$dispatcher->addListener('kernel.controller', function () {
    dump('salut frrdreeerewrwzw');
});
$framework = new Framework\Simplex($dispatcher, $urlMatcher, $controllerResolver, $argumentResolver);


$response = $framework->handle($request);

$response->send();
