<?php

namespace Framework\Event;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\Event;

class ArgumentEvent extends Event
{

    protected  $request;
    protected $controller;
    protected  $argument;

    public function __construct(Request $request, callable $controller, array $argument)
    {
        $this->request = $request;
        $this->controller = $controller;
        $this->argument = $argument;
    }

    public function getController(): callable
    {
        return $this->controller;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getArguments(): array
    {
        return $this->argument;
    }
}
