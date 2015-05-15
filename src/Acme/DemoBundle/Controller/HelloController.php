<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HelloController extends Controller
{
    public function contactAction()
    {
        return new Response('<h1>Contact us!</h1>');
    }


}
