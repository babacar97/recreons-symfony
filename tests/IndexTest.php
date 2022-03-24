<?php

use Framework\Simplex;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

class IndexTest extends TestCase
{

    protected  $framework;

    protected function Setup(): void
    {
        $routes = require __DIR__ . '/../src/pages/routes.php';

        // $context->fromRequest($request);

        $urlMatcher = new UrlMatcher($routes, new RequestContext());

        $controllerResolver = new ControllerResolver();
        $argumentResolver = new ArgumentResolver();
        $this->framework = new Simplex($urlMatcher, $argumentResolver, $controllerResolver);
    }


    public function testHello()
    {
        // $framework = new Simplex;
        $request = Request::create('/hello/lior');
        $response = $this->framework->handle($request);
        $this->assertEquals('Helo aba', $response->getcontent());
    }

    public function testbuy()
    {
        $request = Request::create('/buy');
        // $framework = new Simplex;
        $response = $this->framework->handle($request);
        $this->assertEquals(' revoir', $response->getcontent());
    }
}
