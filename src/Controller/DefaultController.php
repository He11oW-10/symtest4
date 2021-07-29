<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    public function indextest()
    {
        return new Response('index page test');
    }
}