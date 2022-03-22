<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class GreetingController
{

    public function hello(Request $request)
    {
        //connexion a la base de donnéé
        $name = $request->attributes->get('name');
        //Envoyer un email

        //integrer du html
        ob_start();
        include __DIR__ . '/../pages/hello.php';
        return new Response(ob_get_clean());
    }

    public function buy()
    {
        ob_start();
        include __DIR__ . '/../pages/buy.php';
        return new Response(ob_get_clean());
    }
}
